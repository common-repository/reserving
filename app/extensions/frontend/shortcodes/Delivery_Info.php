<?php

namespace Reserving\extensions\frontend\shortcodes;

/**
 * Availability Checker class
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */
class Delivery_Info extends \Reserving\base\Common
{
    public $delivery_info;
    public  $branch_option;
    public $timeFormat;
    public $delivery_date;

    public function register()
    {

        if (!class_exists('WooCommerce')) {
            return;
        }

        $this->branch_option = reserving_setting_option('reserving_branch_option', 'multi_branch');

        if (isset($_COOKIE['reserving_delivery_info'])) {
            $sanitize_data = sanitize_text_field($_COOKIE['reserving_delivery_info']);
            $this->delivery_info = (array) json_decode(stripslashes($sanitize_data));
        } else {
            $this->delivery_info = [];
        }

        if (isset($_COOKIE['reserving_user_time'])) {
            $this->delivery_info['user_time'] = sanitize_text_field($_COOKIE['reserving_user_time']);
        }

        $this->timeFormat = reserving_setting_option('reserving_time_format', '12hours');

        add_shortcode('reserving_delivery_info', array($this, 'show_delivery_info_form'));
    }

    public function show_delivery_info_form($atts)
    {
        $atts = shortcode_atts(array(
            'branch_id' => '',
            'table_id'  => '',
            'date'      => '',
            'time'      => '',
        ), $atts);

        global $wp;
        $isCheckoutPage = false;
        if (is_checkout() && empty($wp->query_vars['order-pay']) && !isset($wp->query_vars['order-received'])) {
            $isCheckoutPage = true;
        }

        wp_enqueue_style('reserving_frontend_popup_style');
        wp_enqueue_style('reserving_frontend_tabs_style');
        wp_enqueue_script('reserving_frontend_tab_js');
        wp_enqueue_script('reserving_frontend_main_js');

        $output = '';

        ob_start();

        if ('multi_branch' == $this->get_branch_option()) {
            require_once __DIR__ . '/views/multi_branch/delivery_info/box.php';
        } else {
            require_once __DIR__ . '/views/single_branch/delivery_info/box.php';
        }

        $output .= ob_get_clean();

        return $output;
    }

    public function render_branch_list()
    {
        $list = '';
        $branches = get_posts(array(
            'post_type'      => 'reserving-branches',
            'posts_per_page' => -1,
        ));

        $branch_id = isset($this->delivery_info['reserving_branch']) ? $this->delivery_info['reserving_branch'] : 0;

        $selected = '';

        if (!empty($branches)) {
            foreach ($branches as $branch) {
                if ($branch->ID == $branch_id) {
                    $selected = 'selected';
                } else {
                    $selected = '';
                }
                $list .= sprintf("<option value='%s' %s>%s</option>", esc_attr($branch->ID), esc_attr($selected), esc_html($branch->post_title));
            }
        }

        return $list;
    }

    public function render_table_list()
    {
        $branch_id      = isset($this->delivery_info['reserving_branch']) ? $this->delivery_info['reserving_branch'] : 0;
        $booking_date   = isset($this->delivery_info['delivery_date']) ? $this->delivery_info['delivery_date'] : '';
        $start_time     = isset($this->delivery_info['start_time']) ? $this->delivery_info['start_time'] : '';
        $end_time       = isset($this->delivery_info['end_time']) ? $this->delivery_info['end_time'] : '';
        $table_ids      = reserving_check_available_tables($booking_date, $start_time, $end_time, $branch_id);
        $table_list = '';
        foreach ($table_ids as $key => $table_id) {
            $table = get_term_by('id', $table_id, 'reserving-tables');

            $checked = '';

            if (isset($this->delivery_info['reserving_tables'])) {
                if (in_array($table_id, $this->delivery_info['reserving_tables'])) {
                    $checked = 'checked';
                }
            }

            $table_list .= sprintf(
                '<div class="single_table"><input type="checkbox" class="btn" value="%s" id="table_%s" %s /> <label for="table_%s">%s</label></div>',
                esc_attr($table->term_id),
                esc_attr($table->term_id),
                esc_attr($checked),
                esc_attr($table->term_id),
                esc_html($table->name)
            );
        }

        return $table_list;
    }

    public function render_delivery_area_list()
    {
        $list = '';

        $delivery_areas = [];

        if ('multi_branch' == $this->branch_option) {
            if (isset($this->delivery_info['reserving_branch'])) {
                $delivery_areas = get_the_terms($this->delivery_info['reserving_branch'], 'reserving-delivery-area');
            }
        } else {
            $delivery_areas = get_terms('reserving-delivery-area');
        }

        $area_id = 0;
        $delivery_area = '';
        if (isset($this->delivery_info['delivery_area']) && !empty($this->delivery_info['delivery_area'])) {
            $area_id = $this->delivery_info['delivery_area'];
            $delivery_area_obj = get_term_by('id', $this->delivery_info['delivery_area'], 'reserving-delivery-area');

            if (isset($delivery_area_obj->name)) {
                $delivery_area = $delivery_area_obj->name;
            }
        }
        if (!empty($delivery_areas)) {

            $selected = '';
            foreach ($delivery_areas as $key => $area) {
                $selected = ($area->term_id == $area_id) ? 'selected' : '';
                $list .= sprintf("<li onclick='reservingGetItemValue(this)' data-value='%s' class='%s'>%s</li>", esc_attr($area->term_id), esc_attr($selected), esc_html($area->name));
            }
        }
        return $list;
    }

    public function render_time_slots($form_id = "deliveryChecker")
    {
        $delivery_date = isset($this->delivery_info['delivery_date']) ? $this->delivery_info['delivery_date'] : gmdate("Y-m-d");
        $user_time = isset($_COOKIE['reserving_user_time']) ? sanitize_text_field($_COOKIE['reserving_user_time']) . ':00' : gmdate('H:i');
        $branch_option = reserving_setting_option('reserving_branch_option', 'multi_branch');

        if ('multi_branch' == $branch_option) { // For multi branches
            $branch_id = isset($this->delivery_info['reserving_branch']) ? $this->delivery_info['reserving_branch'] : 0;

            $branch_opening_time = (isset(get_post_meta($branch_id)['reserving_branch_opening_time'][0]) && !empty(get_post_meta($branch_id)['reserving_branch_opening_time'][0])) ? get_post_meta($branch_id)['reserving_branch_opening_time'][0] : '09:00';

            $opening_time = ($delivery_date == gmdate("Y-m-d")) ? max($branch_opening_time, $user_time) : $branch_opening_time;

            $closing_time = (isset(get_post_meta($branch_id)['reserving_branch_closing_time'][0]) && !empty(get_post_meta($branch_id)['reserving_branch_closing_time'][0])) ? get_post_meta($branch_id)['reserving_branch_closing_time'][0] : '22:00';
        } else {
            $opening_time = reserving_setting_option('reserving_opening_time', '09:00');
            $closing_time = reserving_setting_option('reserving_closing_time', '11:00');

            $opening_time = ($delivery_date == gmdate("Y-m-d")) ? max($opening_time, $user_time) : $opening_time;
        }

        $delivery_time = isset($this->delivery_info['delivery_time']) ? $this->delivery_info['delivery_time'] : '';

        $slot_in_minutes = !empty(reserving_setting_option('reserving_time_slot', '60')) ? reserving_setting_option('reserving_time_slot', '60') : '60';

        $timeSlots = reservingCreateTimeSlots($opening_time, $closing_time, $slot_in_minutes);

        $options = '';

        if ("inRestChecker" == $form_id) {
            $start_time = isset($this->delivery_info['start_time']) ? $this->delivery_info['start_time'] : '';
            $end_time = isset($this->delivery_info['end_time']) ? $this->delivery_info['end_time'] : '';

            $start_time_label = reserving_setting_option('reserving_booking_start_time_label', _x('Select Start Time:', 'reserving'));

            $options .=  sprintf('<p class="mt-20">%s</p>', esc_html($start_time_label));
            $options .= '<select class="reserving-start--time" name="reserving_start_time">';
            $options .=  sprintf("<option value='0' disabled selected>%s</option>", esc_html($start_time_label));

            foreach ($timeSlots as $key => $slot) {
                $selected = ($start_time == $slot) ? 'selected' : '';

                $time = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($slot)) : $slot;
                $options .= sprintf("<option value='%s' %s>%s</option>", esc_attr($slot), esc_attr($selected), esc_attr($time));
            }
            $options .= '</select>';
            $end_time_label = reserving_setting_option('reserving_booking_end_time_label', _x('Select End Time:', 'reserving'));
            $options .= sprintf('<p class="mt-20">%s</p>', esc_html($end_time_label));
            $options .= '<select name="reserving_end_time">';
            $options .= sprintf("<option value='0' disabled selected>%s</option>", esc_html($end_time_label));
            foreach ($timeSlots as $key => $slot) {
                $selected = ($end_time == $slot) ? 'selected' : '';
                $time = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($slot)) : $slot;
                $options .= sprintf("<option value='%s' %s>%s</option>", esc_attr($slot), esc_attr($selected), esc_html($time));
            }
            $options .= '</select>';
        } else {

            $select_time_label = reserving_setting_option('reserving_delivery_time_label', _x('Delivery Time:', 'reserving'));
            if ($form_id == 'pickupChecker') {
                $select_time_label = reserving_setting_option('reserving_pickup_time_label', _x('Pickup Time:', 'reserving'));
            }
            $options .= "<select name='delivery_time'>";
            $options .= sprintf("<option value='0' disabled>%s</option>", esc_html($select_time_label));

            foreach ($timeSlots as $key => $slot) {
                $selected = ($delivery_time == $slot) ? 'selected' : '';
                $time = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($slot)) : $slot;
                $options .= sprintf("<option value='%s' %s>%s</option>", esc_attr($slot), esc_attr($selected), esc_html($time));
            }
            $options .= "</select>";
        }

        echo reserving_kses($options);
    }
}
