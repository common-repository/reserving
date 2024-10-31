<?php

namespace Reserving\extensions\frontend\order;

/**
 * Order Values Modifying class
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */

class Order_Modify
{
    public $delivery_info;
    public $timeFormat;

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
            $this->delivery_info['user_time'] = sanitize_text_field($_COOKIE['reserving_user_time']);
        }

        $this->timeFormat = reserving_setting_option('reserving_time_format', '12hours');

        add_action('woocommerce_thankyou', [$this, 'show_delivery_info']);
        add_action('woocommerce_view_order', [$this, 'show_delivery_info']);
        add_action('woocommerce_thankyou', [$this, 'change_order_status'], 100);
        add_action('woocommerce_checkout_create_order_line_item', [$this, 'add_extra_items_to_order'], 10, 4);
        add_action('woocommerce_checkout_update_order_meta', [$this, 'add_delivery_info_to_order']);
    }

    public function change_order_status($order_id)
    {
        if (!$order_id) {
            return;
        }


        $order = wc_get_order($order_id);
        if ('processing' == $order->get_status() || 'pending' == $order->get_status() || 'checkout-draft' == $order->get_status()) {
            $order->update_status('wc-rsv-new-order');
        }
        if ($order) {
            // Sanitize the delivery info
            $sanitize_data = wc_clean($this->delivery_info);

            // Update reserving delivery info
            $order->update_meta_data('reserving_delivery_info', $sanitize_data);

            // Update reserving branch if set
            if (isset($this->delivery_info['reserving_branch'])) {
                $order->update_meta_data('reserving_branch', sanitize_text_field($this->delivery_info['reserving_branch']));
            }

            // Check if delivery type is 'in_restaurant'
            if (isset($this->delivery_info['delivery_type']) && $this->delivery_info['delivery_type'] === 'in_restaurant') {

                // Update reserving booking date if set
                if (isset($this->delivery_info['delivery_date'])) {
                    $order->update_meta_data('reserving_booking_date', sanitize_text_field($this->delivery_info['delivery_date']));
                }

                // Update reserving booking tables if set
                if (isset($this->delivery_info['reserving_tables'])) {
                    $order->update_meta_data('reserving_booking_tables', wc_clean($this->delivery_info['reserving_tables']));
                }

                // Update reserving booking start time if set
                if (isset($this->delivery_info['start_time'])) {
                    $order->update_meta_data('reserving_booking_start_time', sanitize_text_field($this->delivery_info['start_time']));
                }

                // Update reserving booking end time if set
                if (isset($this->delivery_info['end_time'])) {
                    $order->update_meta_data('reserving_booking_end_time', sanitize_text_field($this->delivery_info['end_time']));
                }
            }

            // Save the order after updating meta
            $order->save();
        }
    }

    /**
     * Add extra items to order
     */
    function add_extra_items_to_order($item, $cart_item_key, $values, $order)
    {
        // Check if extra items are present
        if (empty($values['reserving_extra_items'])) {
            return;
        }

        // // Loop through each extra item and add it to the order metadata
        // foreach ($values['reserving_extra_items'] as $value) {
        //     // Sanitize and prepare the extra item data
        //     $item_name = sanitize_text_field($value['name']);
        //     $quantity = intval($value['quantity']);
        //     $quantity_unit = sanitize_text_field($value['quantity_unit']);
        //     $price = floatval($value['price']);
        //     $total_price = $price * $quantity;

        //     // Format the extra item information
        //     $item_meta_value = $quantity . ' ' . $quantity_unit . ' (' . get_woocommerce_currency_symbol() . number_format($total_price, 2) . ')';

        //     // Add the extra item data as meta to the order item
        //     $item->add_meta_data($item_name, $item_meta_value, true);
        // }
        if (isset($values['reserving_extra_items']) && !empty($values['reserving_extra_items'])) {

            // Loop through each extra item and add it to the order metadata
            foreach ($values['reserving_extra_items'] as $extra_item) {
                $name = sanitize_text_field($extra_item['name']);
                $quantity = intval($extra_item['quantity']);
                $unit = sanitize_text_field($extra_item['quantity_unit']);
                $price = floatval($extra_item['price']);
                $total = $price * $quantity;

                // Format the meta value
                $meta_value = $quantity . ' ' . $unit . ' (' . get_woocommerce_currency_symbol() . number_format($total, 2) . ')';


                // Add meta data to the order item
                $item->add_meta_data($name, $meta_value, true);
            }
        }
    }

    public function add_delivery_info_to_order($order_id)
    {
        // https://wp-kama.com/plugin/woocommerce/function/wc_clean
        $sanitize_data = wc_clean($this->delivery_info);
        update_post_meta($order_id, 'reserving_delivery_info', $sanitize_data);

        if (isset($this->delivery_info['reserving_branch'])) {
            update_post_meta($order_id, 'reserving_branch', sanitize_text_field($this->delivery_info['reserving_branch']));
        }
        if (isset($this->delivery_info['delivery_type']) && $this->delivery_info['delivery_type'] == 'in_restaurant') {

            if (isset($this->delivery_info['delivery_date'])) {
                update_post_meta($order_id, 'reserving_booking_date', sanitize_text_field($this->delivery_info['delivery_date']));
            }

            if (isset($this->delivery_info['reserving_tables'])) {
                update_post_meta($order_id, 'reserving_booking_tables', wc_clean($this->delivery_info['reserving_tables']));
            }

            if (isset($this->delivery_info['start_time'])) {
                update_post_meta($order_id, 'reserving_booking_start_time', sanitize_text_field($this->delivery_info['start_time']));
            }

            if (isset($this->delivery_info['end_time'])) {
                update_post_meta($order_id, 'reserving_booking_end_time', sanitize_text_field($this->delivery_info['end_time']));
            }
        }
    }


    public function show_delivery_info($order_id)
    {
        if (!empty($this->delivery_info)) {
?>
            <div class='delivery_info'>
                <p><strong><?php echo esc_html__('Delivery Information', 'reserving') ?></strong></p>
                <?php
                $delivery_type = 'delivery';
                foreach ($this->delivery_info as $key => $value) {
                    if ($key == 'delivery_type' && $value == 'pickup') {
                        $delivery_type = 'pickup';
                    }
                    if ($key == 'delivery_type') {
                        if ($value == 'in_restaurant') {
                            $delivery_type = 'in_restaurant';
                ?>
                            <p><strong><?php echo esc_html__('Delivery Type:', 'reserving'); ?></strong><?php echo esc_html__('In Restaurant', 'reserving'); ?>
                            </p>
                        <?php
                        } else {
                        ?>
                            <p><?php esc_html__('Delivery Type: ', 'reserving'); ?><?php echo ucfirst(esc_html($value)); ?> </p>
                        <?php
                        }
                    }
                    if ($key == 'reserving_branch' && !empty($this->delivery_info['reserving_branch'])) {
                        ?>
                        <p><strong><?php echo esc_html__('Branch Name:', 'reserving'); ?></strong>
                            <?php echo esc_html(get_post($value)->post_title); ?></p>
                    <?php
                    }
                    if ($key == 'delivery_area' && !empty($this->delivery_info['delivery_area'])) {
                        $delivery_area = get_term_by('id', $value, 'reserving-delivery-area')->name;
                    ?>
                        <p><strong><?php echo esc_html__('Delivery Area:', 'reserving'); ?></strong><?php echo esc_html($delivery_area); ?>
                        </p>
                    <?php
                    }
                    if ($key == 'reserving_tables' && !empty($this->delivery_info['reserving_tables'])) {
                    ?>
                        <p><strong><?php echo esc_html__('Tables:', 'reserving') ?></strong></p>
                        <?php
                        foreach ($value as $key => $table_id) {
                            if (empty($table_id)) {
                                continue;
                            }
                            $table = get_term_by('id', $table_id, 'reserving-tables');
                            $max_person = get_term_meta(intval($table_id), 'reserving_tables_max_person', true);
                        ?>
                            <p><?php echo wp_kses_post(sprintf('%s (%s %s %s)', $table->name, esc_html__('Max: ', 'reserving'), esc_html($max_person), esc_html__('person', 'reserving'))); ?>
                            </p>
                        <?php
                        }
                    }
                    $delivery_label = 'Delivery ';
                    if ($key == 'delivery_date') {
                        $delivery_date =  date_format(date_create($value), "F j, Y");
                        if ($delivery_type == 'pickup') {
                            $delivery_label = 'Pickup ';
                        }
                        if ($delivery_type == 'in_restaurant') {
                            $delivery_label = 'Booking ';
                        }
                        ?>
                        <p><strong><?php echo esc_html($delivery_label); ?>
                                <?php echo esc_html__('Date', 'reserving'); ?></strong><?php echo esc_html($delivery_date); ?></p>
                    <?php
                    }
                    if ($key == 'delivery_time') {
                        if ($delivery_type == 'pickup') {
                            $delivery_label = 'Pickup ';
                        }
                        if ($delivery_type == 'in_restaurant') {
                            $delivery_label = 'Booking ';
                        }
                        $delivery_time = ('12hours' == $this->timeFormat) ? gmdate('h:i A', strtotime($value ?? '')) : $value;
                    ?>
                        <p><strong><?php echo esc_html($delivery_label) . ' ' . esc_html(reserving_text_setting_option('reserving_delivery_time_label', "Time: ")); ?></strong><?php echo esc_html($delivery_time); ?>
                        </p>
                <?php
                    }
                    if ($key == 'start_time') {
                        $start_time = ('12hours' == $this->timeFormat) ? gmdate('h:i A', strtotime($value)) : $value;
                        echo wp_kses_post(sprintf('<p><strong>%s</strong>%s</p>', esc_html__('Start Time:', 'reserving'), esc_html($start_time)));
                    }
                    if ($key == 'end_time') {
                        $end_time = ('12hours' == $this->timeFormat) ? gmdate('h:i A', strtotime($value)) : $value;
                        echo wp_kses_post(sprintf('<p><strong>%s</strong>%s</p>', esc_html__('End Time:', 'reserving'), esc_html($end_time)));
                    }
                }
                ?>
            </div>
<?php
        }
    }
}
