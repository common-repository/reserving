<?php

namespace Reserving\extensions\frontend\cart;

/**
 * Cart Values Modifying class
 *
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */
class Cart_Modify
{
    public function register()
    {
        if (is_admin()) {
            return;
        }

        add_action('woocommerce_after_cart_item_name', [$this, 'display_extra_items'], 10, 3);
        add_filter('woocommerce_add_cart_item_data', [$this, 'save_extra_item_fields'], 10, 2);
        add_action('woocommerce_before_calculate_totals', [$this, 'add_extra_items_price'], 10);
    }

    /**
     * Display the extra items in the cart
     */

    function display_extra_items($cart_item, $cart_item_key)
    {

        if (!isset($cart_item['reserving_extra_items']) || empty($cart_item['reserving_extra_items'])) {
            return;
        }

        wp_enqueue_style('reserving_product_extra_items_style');

        $product = wc_get_product($cart_item['product_id']);
        $price = $product->get_price();
?>
        <span> <?php echo wp_kses_post('( ' . get_woocommerce_currency_symbol() . $price . ' )'); ?> </span>
        <div class="bookta-extra-cart-wrapper">
            <strong><?php echo esc_html__('Extra Items', 'reserving'); ?></strong>
            <ul class='reserving_extra_items' data-cart-id='<?php echo esc_attr($cart_item_key); ?>'>
                <?php

                foreach ($cart_item['reserving_extra_items'] as $key => $item) {

                    if (floatval($item['enable_quantity']) == "0" || floatval($item['enable_quantity']) == 0) {
                        $quantity = '';
                        $quantity_unit = '';
                    } else {
                        $quantity = sprintf("<label class='reserving-extra-qty'><input type='number' name='reserving_extra_qty_%s' value='%s' min='1' class='extra_quantity'/></label>", esc_attr($key), esc_attr($item['quantity']));
                        $quantity_unit = sprintf('<span class="reserving_quantity_unit">%s</span>', esc_html($item['quantity_unit']));
                    }

                    echo reserving_kses(sprintf(
                        "<li> <label><input type='hidden' name='reserving_extra_items[%s]' value='%.2f' /><span class='reserving_extra_item_label'>%s</span> <span class='reserving_extra_item_price'>( %s%s )</span></label> %s %s </li>",
                        esc_attr($key),
                        esc_attr($item['price']),
                        __($item['name'], 'reserving'),
                        get_woocommerce_currency_symbol(),
                        reserving_kses($item['price']),
                        reserving_kses($quantity),
                        reserving_kses($quantity_unit)
                    ));
                }
                ?>
            </ul>
        </div>
<?php  }

    /**
     * Add extra items fields
     */
    function save_extra_item_fields($cart_item_data, $product_id)
    {

        if (!isset($_REQUEST['reserving_extra_items'])) {
            return;
        }

        $all_extra_prices = get_post_meta($product_id, 'reserving_extra_items', true);

        $extra_items      = wc_clean($_REQUEST['reserving_extra_items']);

        $extra_items     = array_intersect_key($all_extra_prices, $extra_items);

        $extra_quantity   = wc_clean($_REQUEST['reserving_extra_qty']);

        foreach ($extra_quantity as $index => $quantity) {
            if (isset($extra_items[$index])) {
                $extra_items[$index]['quantity'] = $quantity;
                unset($extra_items[$index]['enable_quantity']);
            }
        }

        $cart_item_data['reserving_extra_items'] = $extra_items;
        return $cart_item_data;
    }


    function add_extra_items_price($cart_object)
    {
        foreach ($cart_object->get_cart() as $cart_item_key => $item_values) {
            if (isset($item_values['reserving_extra_items']) && !empty($item_values['reserving_extra_items'])) {
                $base_price = $item_values['data']->get_sale_price();
                if (!$base_price) {
                    $base_price = $item_values['data']->get_regular_price();
                }
                $new_price = $base_price;
                foreach ($item_values['reserving_extra_items'] as $extra_item) {
                    $extra_price = floatval($extra_item['price']) * intval($extra_item['quantity']);
                    $new_price += $extra_price;
                }
                $item_values['data']->set_price($new_price);
            }
        }
    }
}
