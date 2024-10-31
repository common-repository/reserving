<?php

namespace Reserving\extensions\frontend\shortcodes;

/**
 * Product_Single shortcodes
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */
class Product_Single
{
    public function register()
    {
        add_shortcode('reserving_single_product_extra_items', array($this, 'show_extra_items'));
        add_shortcode('reserving_single_product_price', array($this, 'show_total_price'));
    }

    public function show_extra_items($atts)
    {

        global $product;

        if (!method_exists($product, 'get_id')) {
            return;
        }

        wp_enqueue_style('reserving_product_extra_items_style');
        wp_enqueue_script('reserving_frontend_single_product');

        $extra_items = get_post_meta($product->get_id(), 'reserving_extra_items', true);

        if (empty($extra_items)) {
            return;
        }

?>
<div class="reserving-single-item-wrapper reserving-single-page">
    <p class='reserving_extra_item_title'><strong><?php echo esc_html__('Extra Items', 'reserving'); ?></strong></p>
    <ul class='reserving_extra_items'>
        <?php
                foreach ($extra_items as $key => $item) {
                    $quantity_unit = ($item['enable_quantity']) ? sprintf('<span class="reserving_quantity_unit">%s</span>', esc_html($item['quantity_unit'])) : '';
                ?>
        <li>

            <label class='reserving-extra-item'>


                <input type='checkbox' class="qreserving--extra--item--price"
                    name='reserving_extra_items[<?php echo esc_attr($key); ?>]'
                    value='<?php echo esc_attr($item['price']); ?>' />
                <span class='reserving_extra_item_label'><?php echo wp_kses_post($item['name']); ?></span>
                <span class='reserving_extra_item_price'>( <?php echo wc_price($item['price']); ?> )</span>
            </label>
            <label class='reserving-extra-qty'>
                <input type='number' name='reserving_extra_qty[<?php echo esc_attr($key); ?>]' value='1' min='1'
                    class='extra_quantity' />
                <?php echo wp_kses_post($quantity_unit); ?>
            </label>
        </li>
        <?php
                }
                ?>
    </ul>
    <?php
            $price = $product->get_price();
            $price = wc_price($price);
            ?>
    <p class="reserving_product_price"><strong
            class="reserving_product_price_label"><?php echo esc_html__('Total Price:', 'reserving'); ?></strong><?php echo wp_kses_post($price); ?>
    </p>
</div>
<?php
    }

    public function show_total_price()
    {
        global $product;
        if (!method_exists($product, 'get_id')) {
            return;
        }

        $price      = $product->get_price();
        $price      = wc_price($price);
        $price_html = sprintf('<p class="reserving_product_price"><strong class="reserving_product_price_label">%s</strong> %s</p>', esc_html__('Total Price:', 'reserving'), wp_kses_post($price));
        return $price_html;
    }
}