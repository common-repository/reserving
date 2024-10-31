<?php

namespace Reserving\extensions\frontend\shortcodes;

/**
 * Availability Checker class
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */
class Availability_Checker extends \Reserving\base\Common
{
    public $delivery_areas;

    public function register()
    {
        add_shortcode('reserving_availability_checker', array($this, 'availability_checker'));
    }

    public function availability_checker($atts)
    {
        $this->delivery_areas = get_terms('reserving-delivery-area', array("hide_empty" => false));

        $atts = shortcode_atts(array(
            'branch_id' => '',
            'table_id'  => '',
            'date'      => '',
            'time'      => '',
        ), $atts);

        wp_enqueue_style('reserving_frontend_popup_style');
        wp_enqueue_style('reserving_frontend_tabs_style');
        wp_enqueue_script('reserving_frontend_tab_js');
        wp_enqueue_script('reserving_frontend_main_js');

        $output = '';
        $form_show_style = reserving_text_setting_option('checker_form_show_style', 'popup');
        ob_start();
        if ('multi_branch' == $this->get_branch_option()) {
            if ('popup' == $form_show_style) {
                require_once __DIR__ . '/views/multi_branch/availability_checker/popup.php';
            } else {
                require_once __DIR__ . '/views/multi_branch/availability_checker/direct_show_form.php';
            }
        } else {
            if ('popup' == $form_show_style) {
                require_once __DIR__ . '/views/single_branch/availability_checker/popup.php';
            } else {
                require_once __DIR__ . '/views/single_branch/availability_checker/direct_show_form.php';
            }
        }
        $output .= ob_get_clean();
        return $output;
    }

    public function render_branch_list()
    {
        $list = '';
        $branches = get_posts(array(
            'post_type'      => 'reserving-branches',
            'posts_per_page' => -1
        ));

        if (empty($branches)) {

            $list .= _x('No Branch Founds.', 'reserving');
        } else {
            foreach ($branches as $branch) {
                $list .= sprintf('<option value="%s">%s</option>', esc_attr(intval($branch->ID)), esc_html($branch->post_title));
            }
        }

        return $list;
    }

    public function render_delivery_area_list()
    {
        $list = '';

        if (empty($this->delivery_areas)) {
            $list .= _x('No Delivery Area Founds.', 'reserving');
        } else {
            foreach ($this->delivery_areas as $key => $area) {
                $list .= sprintf('<li onclick="reservingGetItemValue(this)" data-value="%s">%s</li>', esc_attr($area->term_id), esc_html($area->name));
            }
        }

        return $list;
    }

    public function render_table_list()
    {
        $list = '';
        $tables = get_terms('reserving-tables');
        foreach ($tables as $key => $table) {
            $list .= sprintf('<div class="single_table"><input type="checkbox" class="btn" value="%s" id="table_%s" /><label for="table_%s">%s</label></div>', esc_attr($table->term_id), esc_attr($table->term_id), esc_attr($table->term_id), esc_html($table->name));
        }
        return $list;
    }

    public function render_single_branch_time_slots($form_id = "deliveryChecker")
    {

        $delivery_date   = isset($this->delivery_info['delivery_date']) ? $this->delivery_info['delivery_date'] : gmdate("Y-m-d");
        $opening_time    = reserving_text_setting_option('reserving_opening_time', '09:00');
        $closing_time    = reserving_text_setting_option('reserving_closing_time', '11:00');
        $user_time       = isset($_COOKIE['reserving_user_time']) ? sanitize_text_field($_COOKIE['reserving_user_time']) . ':00' : gmdate('H:i');
        $opening_time    = ($delivery_date == gmdate("Y-m-d")) ? max($opening_time, $user_time) : $opening_time;
        $delivery_time   = isset($this->delivery_info['delivery_time']) ? $this->delivery_info['delivery_time'] : '';
        $slot_in_minutes = !empty(reserving_setting_option('reserving_time_slot', 60)) ? reserving_setting_option('reserving_time_slot', 60) : 60;
        $timeSlots       = reservingCreateTimeSlots($opening_time, $closing_time, $slot_in_minutes);
        $options         = '';

        if ("inRestChecker" == $form_id) {
            $start_time_label = reserving_text_setting_option('reserving_booking_start_time_label', _x('Select Start Time:', 'reserving'));

            $options .= sprintf('<p class="mt-20">%s</p>', esc_html($start_time_label));
            $options .= '<select class="reserving--start--time" name="reserving_start_time">';
            $options .= sprintf("<option value='0' disabled selected>%s</option>", esc_html($start_time_label));

            foreach ($timeSlots as $key => $slot) {
                $time = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($slot)) : $slot;
                $options .= sprintf("<option value='%s'>%s</option>", esc_attr($slot), esc_html($time));
            }

            $options .= '</select>';

            $end_time_label = reserving_text_setting_option('reserving_booking_end_time_label', _x('Select End Time:', 'reserving'));

            $options .= sprintf('<p class="mt-20">%s</p>', esc_html($end_time_label));
            $options .= '<select name="reserving_end_time">';
            $options .= sprintf("<option value='0' disabled selected>%s</option>", esc_html($end_time_label));
            foreach ($timeSlots as $key => $slot) {
                $time = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($slot)) : $slot;
                $options .= sprintf("<option value='%s'>%s</option>", esc_attr($slot), esc_html($time));
            }
            $options .= '</select>';
        } else {
            $select_time_label = reserving_text_setting_option('reserving_delivery_time_label', _x('Delivery Time:', 'reserving'));
            if ($form_id == 'pickupChecker') {
                $select_time_label = reserving_text_setting_option('reserving_pickup_time_label', _x('Pickup Time:', 'reserving'));
            }

            $options .= '<select name="delivery_time">';
            $options .= sprintf("<option value='0' disabled selected>%s</option>", esc_html($select_time_label));

            foreach ($timeSlots as $key => $slot) {
                $selected = ($delivery_time == $slot) ? 'selected' : '';
                $time = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($slot)) : $slot;
                $options .= sprintf("<option value='%s' %s>%s</option>", esc_attr($slot), esc_attr($selected), esc_html($time));
            }
            $options .= '</select>';
        }

        echo reserving_kses($options);
    }
}
