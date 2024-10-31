<?php

namespace Reserving\extensions\frontend\ajax;

use WP_Query;

/**
 * Frontend Ajax request handler class
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */

class Ajax extends \Reserving\base\Common
{
    public function register()
    {
        add_action('wp_ajax_load_single_branch_time_slots', [$this, 'load_single_branch_time_slots']);
        add_action('wp_ajax_nopriv_load_single_branch_time_slots', [$this, 'load_single_branch_time_slots']);

        add_action('wp_ajax_load_multi_branch_time_slots', [$this, 'load_multi_branch_time_slots']);
        add_action('wp_ajax_nopriv_load_multi_branch_time_slots', [$this, 'load_multi_branch_time_slots']);

        add_action('wp_ajax_load_available_tables', [$this, 'load_available_tables']);
        add_action('wp_ajax_nopriv_load_available_tables', [$this, 'load_available_tables']);

        add_action('wp_ajax_print_order_pdf', [$this, 'print_order_pdf']);
        add_action('wp_ajax_nopriv_print_order_pdf', [$this, 'print_order_pdf']);

        // Add tip
        add_action('wp_ajax_reserving_cart_tip_update', [$this, 'cart_tip_update']);
        add_action('wp_ajax_nopriv_reserving_cart_tip_update', [$this, 'cart_tip_update']);
        // remove tip
        add_action('wp_ajax_reserving_cart_tip_remove', [$this, 'reserving_cart_tip_remove']);
        add_action('wp_ajax_nopriv_reserving_cart_tip_remove', [$this, 'reserving_cart_tip_remove']);
        // latest cart content  
        add_action('wp_ajax_reserving_cart_latest_content', [$this, 'reserving_cart_latest_content']);
        add_action('wp_ajax_nopriv_reserving_cart_latest_content', [$this, 'reserving_cart_latest_content']);

        // popup single shop grid
        add_action('wp_ajax_reserving_quick_view_product_add_to_cart', [$this, 'reserving_quick_view_product_add_to_cart']);
        add_action('wp_ajax_nopriv_reserving_quick_view_product_add_to_cart', [$this, 'reserving_quick_view_product_add_to_cart']);
    }
    public function reserving_quick_view_product_add_to_cart()
    {

        $return_data = [
            '_wpnonce' => $_REQUEST['_wpnonce']
        ];

        $nonce = sanitize_text_field($_REQUEST['nonce']);
        if (! wp_verify_nonce($nonce, 'security_check')) {
            wp_send_json_error($return_data);
            wp_die();
        }

        $product_id = sanitize_text_field($_REQUEST['product_id']);
        $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($product_id));
        $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);

        WC()->cart->add_to_cart($product_id, $quantity, null, null, $this->set_cart_custom_data($product_id));
        do_action('woocommerce_ajax_added_to_cart', $product_id);

        wp_send_json_success(['view_button' => sprintf('<a href="%s" class="added_to_cart wc-forward" >%s</a>', esc_url(wc_get_cart_url()), esc_html__('View Cart', 'reserving'))]);
        wp_die();
    }

    public function set_cart_custom_data($product_id, $cart_item_data = [])
    {

        if (!isset($_REQUEST['reserving_extra_items'])) {
            return;
        }

        $all_extra_prices = get_post_meta($product_id, 'reserving_extra_items', true);
        $extra_items      = wc_clean($_REQUEST['reserving_extra_items']);

        $extra_prices     = array_intersect_key($all_extra_prices, $extra_items);

        //https://wp-kama.com/plugin/woocommerce/function/wc_clean
        $extra_quantity   = wc_clean($_REQUEST['reserving_extra_qty']);

        // sanitize 
        foreach ($extra_prices as $key => $item) {
            $cart_item_data['reserving_extra_items'][$key] = $item;
            $cart_item_data['reserving_extra_items'][$key]['quantity'] = $extra_quantity[$key];
        }

        // bellow statement make sure every add to cart action as unique line item
        $cart_item_data['custom_data']['unique_key'] = md5(microtime() . rand());

        return $cart_item_data;
    }
    public function reserving_cart_latest_content()
    {

        global $woocommerce;
        $items = $woocommerce->cart->get_cart();
        $line_items = [];
        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item):

            $product = $cart_item['data'];

            $product_id     = $cart_item['product_id'];
            $quantity       = $cart_item['quantity'];
            $price          = WC()->cart->get_product_price($product);
            $subtotal       = WC()->cart->get_product_subtotal($product, $cart_item['quantity']);
            $link           = $product->get_permalink($cart_item);
            $name           = $product->get_name($cart_item);
            $image_url      = wp_get_attachment_url($product->get_image_id());

            $line_items[$cart_item_key]['id']        = esc_attr($product_id);
            $line_items[$cart_item_key]['quantity']  = wp_kses_post($quantity);
            $line_items[$cart_item_key]['price']     = wp_kses_post($price);
            $line_items[$cart_item_key]['subtotal']  = wp_kses_post($subtotal);
            $line_items[$cart_item_key]['link']      = esc_url($link);
            $line_items[$cart_item_key]['name']      = esc_html($name);
            $line_items[$cart_item_key]['image_url'] = esc_url($image_url);

        endforeach;
        $return_data = [
            'line_items' => $line_items,
            'subtotal' => wp_kses_post($woocommerce->cart->total)
        ];

        wp_send_json_success($return_data);
        wp_die();
    }
    public function reserving_cart_tip_remove()
    {

        WC()->session->set('reserving_cart_tip_type', '');
        WC()->session->set('reserving_cart_tip_amount', 0);
        wp_send_json_success(['msg' => esc_html__('Tip Remove', 'reserving')]);
        wp_die(); // this is required to terminate immediately and return a proper response
    }

    public function cart_tip_update()
    {

        $type        = sanitize_text_field(isset($_GET['reserving_cart_tip_type']) ? $_GET['reserving_cart_tip_type'] : 0);
        $flat_amount = sanitize_text_field(isset($_GET['reserving_cart_tip_amount']) ? $_GET['reserving_cart_tip_amount'] : 0);
        //https://wp-kama.com/plugin/woocommerce/function/wc_clean
        //sanize with woocommerce function
        WC()->session->set('reserving_cart_tip_type', $type);
        WC()->session->set('reserving_cart_tip_amount', $flat_amount);
        wp_send_json_success(['msg' => esc_html__('Tip Added', 'reserving')]);
        wp_die();
    }

    public function load_available_tables()
    {
        $kses_args = [
            'div' => [
                'class' => [],
                'id'    => [],
                'style' => [],
                'data'  => []
            ],
            'input' => [
                'class' => [],
                'id'    => [],
                'style' => [],
                'type'  => [],
                'name'  => [],
                'value'  => []
            ]
        ];
        // sanitize
        $branch_id    = isset($_REQUEST['branch_id']) ? intval(sanitize_text_field($_REQUEST['branch_id'])) : 0;
        $booking_date = sanitize_text_field($_REQUEST['booking_date']);
        $start_time   = sanitize_text_field($_REQUEST['start_time']);
        $end_time     = sanitize_text_field($_REQUEST['end_time']);
        $table_ids    = reserving_check_available_tables($booking_date, $start_time, $end_time, $branch_id);
        if (empty($table_ids)) {
            $no_table_text = wp_kses_post(sprintf("<p>%s</p>", _x('No Table founds', 'reserving')));
            wp_send_json($no_table_text);
        }
        $table_list = '';
        $table_list .= sprintf('<p>%s</p>', esc_html(reserving_text_setting_option('reserving_select_tables_label', esc_html__('Select Tables:', 'reserving'))));
        foreach ($table_ids as $key => $table_id) {
            $table = get_term_by('id', $table_id, 'reserving-tables');
            $max_person = get_term_meta($table_id, 'reserving_tables_max_person', true);
            $table_list .= sprintf('<div class="single_table"><input type="checkbox" class="btn" value="%s" id="table_%s" /> <label for="table_%s">%s (Max: %s)</label></div>', esc_attr($table->term_id), esc_attr($table->term_id), esc_attr($table->term_id), esc_html($table->name), esc_html($max_person));
        }

        wp_send_json(wp_kses($table_list, $kses_args));
    }

    public function load_single_branch_time_slots()
    {
        $delivery_date = sanitize_text_field($_REQUEST['delivery_date']);
        $form_id       = sanitize_text_field($_REQUEST['form_id']);
        $opening_time  = reserving_text_setting_option('reserving_opening_time', '09:00');
        $closing_time  = reserving_text_setting_option('reserving_closing_time', '11:00');
        $user_time     = sanitize_text_field($_REQUEST['user_time']) . ':00';
        $opening_time  = ($delivery_date == gmdate("Y-m-d")) ? max($opening_time, $user_time) : $opening_time;
        $delivery_time = isset($this->delivery_info['delivery_time']) ? $this->delivery_info['delivery_time'] : '';
        $slot_in_minutes = !empty(reserving_setting_option('reserving_time_slot', 60)) ? reserving_setting_option('reserving_time_slot', 60) : 60;
        $timeSlots = reservingCreateTimeSlots($opening_time, $closing_time, $slot_in_minutes);

        $options = '';

        if ("inRestChecker" == $form_id) {
            $start_time_label = reserving_text_setting_option('reserving_booking_start_time_label', _x('Select Start Time:', 'reserving'));

            $options .= sprintf("<p>%s</p>", esc_html($start_time_label));
            $options .= '<select class="reserving--start--time" name="reserving_start_time" onchange="reservingLoadRestaurantTables()">';
            $options .= sprintf("<option value='0' disabled selected>%s</option>", esc_html($start_time_label));

            foreach ($timeSlots as $key => $slot) {
                $time = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($slot)) : $slot;
                $options .= sprintf("<option value='%s'>%s</option>", esc_attr($slot), esc_html($time));
            }
            $options .= '</select>';
            $end_time_label = reserving_text_setting_option('reserving_booking_end_time_label', _x('Select End Time:', 'reserving'));
            $options .=  sprintf("<p>%s</p>", esc_html($end_time_label));
            $options .= '<select class="reserving--end--time" name="reserving_end_time" onchange="reservingLoadRestaurantTables()">';
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
                $time = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($slot)) : $slot;
                $options .= sprintf("<option value='%s'>%s</option>", esc_attr($slot), esc_html($time));
            }
            $options .= '</select>';
        }
        wp_send_json($options);
    }

    public function load_multi_branch_time_slots()
    {

        $form_id       = sanitize_text_field($_REQUEST['form_id']);
        $branch_id     = intval(sanitize_text_field($_REQUEST['branch_id']));
        $delivery_date = sanitize_text_field($_REQUEST['delivery_date']);
        $user_time     = sanitize_text_field($_REQUEST['user_time']) . ':00';
        $branch_opening_time = (isset(get_post_meta($branch_id)['reserving_branch_opening_time'][0]) && !empty(get_post_meta($branch_id)['reserving_branch_opening_time'][0])) ? get_post_meta($branch_id)['reserving_branch_opening_time'][0] : '09:00';
        $opening_time = ($delivery_date == gmdate("Y-m-d")) ? max($branch_opening_time, $user_time) : $branch_opening_time;
        $closing_time = (isset(get_post_meta($branch_id)['reserving_branch_closing_time'][0]) && !empty(get_post_meta($branch_id)['reserving_branch_closing_time'][0])) ? get_post_meta($branch_id)['reserving_branch_closing_time'][0] : '22:00';
        $slot_in_minutes = !empty(reserving_setting_option('reserving_time_slot', 60)) ? reserving_setting_option('reserving_time_slot', 60) : 60;
        $delivery_time = isset($this->delivery_info['delivery_time']) ? $this->delivery_info['delivery_time'] : '';
        $timeSlots = reservingCreateTimeSlots($opening_time, $closing_time, $slot_in_minutes);
        $options = '';
        if ("inRestChecker" == $form_id) {
            $start_time_label = reserving_text_setting_option('reserving_booking_start_time_label', _x('Select Start Time:', 'reserving'));

            $options .=  sprintf("<p>%s</p>", esc_html($start_time_label));
            $options .= '<select class="reserving--start--time" name="reserving_start_time" onchange="reservingLoadRestaurantTables()">';
            $options .= sprintf("<option value='0' disabled selected>%s</option>", esc_html($start_time_label));
            foreach ($timeSlots as $key => $slot) {
                $time = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($slot)) : $slot;
                $options .= sprintf("<option value='%s'>%s</option>", esc_attr($slot), esc_html($time));
            }
            $options .= '</select>';

            $end_time_label = reserving_text_setting_option('reserving_booking_end_time_label', esc_html__('Select End Time:', 'reserving'));

            $options .=  sprintf("<p>%s</p>", esc_html($end_time_label));
            $options .= '<select class="reserving--end--time" name="reserving_end_time" onchange="reservingLoadRestaurantTables()">';
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
                if (0 == $key) {
                    continue;
                }
                $time = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($slot)) : $slot;
                $options .= sprintf("<option value='%s'>%s</option>", esc_attr($slot), esc_html($time));
            }
            $options .= '</select>';
        }
        wp_send_json($options);
    }
}
