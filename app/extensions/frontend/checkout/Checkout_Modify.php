<?php

namespace Reserving\extensions\frontend\checkout;

/**
 * Checkout Values Modifying class
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */

class Checkout_Modify
{
    public $delivery_info;

    public function register()
    {

        if (!class_exists('WooCommerce')) {
            return;
        }

        if (isset($_COOKIE['reserving_delivery_info'])) {
            $sanitize_data = sanitize_text_field($_COOKIE['reserving_delivery_info']);
            $this->delivery_info = (array) json_decode(stripslashes($sanitize_data));
        } else {
            $this->delivery_info = [];
        }

        if (isset($_COOKIE['reserving_user_time'])) {
            // data sanitize
            $this->delivery_info['user_time'] = sanitize_text_field($_COOKIE['reserving_user_time']);
        }

        $location_hook = trim(reserving_text_setting_option('delivery_info_location_hook'));

        if ($location_hook != '') {
            add_action($location_hook, [$this, 'display_delivery_info'], 10);
        }

        add_filter('woocommerce_checkout_cart_item_quantity', [$this, 'append_extra_items'], 100, 3);
        add_filter('woocommerce_cart_item_name', [$this, 'append_price_items'], 100, 3);
    }

    public function display_delivery_info()
    {
        echo do_shortcode('[reserving_delivery_info]');
    }

    /**
     * Append the extra items in the checkout
     */
    function append_price_items($item_name, $cart_item, $cart_item_key)
    {

        if (is_checkout()) {
            $product = wc_get_product($cart_item['product_id']);
            $price = $product->get_price();
            $item_name .= ' ( ' . get_woocommerce_currency_symbol() . esc_html($price) . ' ) ';
            return $item_name;
        }
        return $item_name;
    }
    function append_extra_items($item_name, $cart_item, $cart_item_key)
    {
        if (is_cart()) {
            return $item_name;
        }

        if (!isset($cart_item['reserving_extra_items']) || empty($cart_item['reserving_extra_items'])) {
            return $item_name;
        }

        wp_enqueue_style('reserving_product_extra_items_style');

        $b_item_name = '';
        $b_item_name .= '<div class="reserving-item-wrapper">';
        $b_item_name .= sprintf("<strong class='reserving-item-heading'>%s</strong>", esc_html__('Extra Items', 'reserving'));
        $b_item_name .= "<ul class='reserving_extra_items'>";
        foreach ($cart_item['reserving_extra_items'] as $key => $item) {
            if (floatval($item['enable_quantity']) == "0" || floatval($item['enable_quantity']) == 0) {
                $quantity = '';
                $quantity_unit = '';
                continue;
            } else {
                $quantity = sprintf("<span class='reserving_quantity'>%s</span>", esc_html($item['quantity']));
                $quantity_unit = sprintf('<span class="reserving_quantity_unit">%s</span>', esc_html($item['quantity_unit']));
            }
            $b_item_name .= "<li>";

            $b_item_name .= wp_kses_post(sprintf(
                "<span class='reserving_extra_item_label'>%s</span>",
                esc_html($item['name'])
            ));
            $b_item_name .= wp_kses_post(sprintf(" - %s %s", $quantity, $quantity_unit));
            $b_item_name .= wp_kses_post(sprintf("<span class='reserving_extra_item_price'>( %s%s )</span>", wp_kses_post(get_woocommerce_currency_symbol()), floatval(esc_html($item['price'])) * floatval(esc_html($item['quantity']))));
            $b_item_name .= "</li>";
        }
        $b_item_name .= "</ul>";
        $b_item_name .= "</div>";

        return reserving_kses($item_name . $b_item_name);
    }
}
