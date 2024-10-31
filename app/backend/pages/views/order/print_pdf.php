<div class="reserving_order_pdf" id="printJS-form">
    <div class="header">
        <?php
            if (reserving_setting_option('print_logo_activate', 1)) {
                if (reserving_setting_option('reserving_checker_logo')) {
                    $logo = reserving_setting_option('reserving_checker_logo', '');
                    echo wp_kses_post( sprintf("<img width='100' height='100' src='%s' alt='' class='custom-logo-link'>", esc_url($logo)));
                } else if (has_custom_logo()) {
                    the_custom_logo();
                }
            }
            if (reserving_setting_option('print_company_title_activate', 1)) {
                ?>
                <h3>
                   <?php bloginfo('title'); ?>
                </h3>
                <?php
            }
            $branch_option = reserving_text_setting_option('reserving_branch_option', 'multi_branch');
            if ('single_branch' == $branch_option) {
                echo wp_kses_post( sprintf('<p>%s</p>', esc_html(reserving_text_setting_option('reserving_single_branch_location', '') )));
            }
            $billing_label = reserving_text_setting_option('print_billing_info_label', _x('Billing Info:', 'reserving'));

            $shipping_label = reserving_text_setting_option('print_shipping_info_label', _x('Shipping Info:', 'reserving'));

            $delivery_info_label = reserving_text_setting_option('print_delivery_info_label', _x('Delivery Info:', 'reserving'));

            $shipping_cost_label = reserving_text_setting_option('print_shipping_cost_label', _x('Shipping Cost:', 'reserving'));

            $total_cost_label = reserving_text_setting_option('print_total_cost_label', _x('Total Cost:', 'reserving'));
            
        ?>
        <p class="order_id"><?php echo esc_html__('Order ID: #', 'reserving') . $order_id; ?> </p>
    </div>
    <div class="customer_info">
        <?php if (reserving_setting_option('print_billing_info_activate', 1)) { ?>
            <div class="billing_info">
                <p><strong><?php echo esc_html($billing_label); ?></strong></p>
                <p> <?php echo wp_kses_post( _x('Name: ', 'reserving') . esc_html($order['billing']['first_name']) . ' ' . esc_html($order['billing']['last_name']) ); ?></p>
                <p><?php echo wp_kses_post( _x('Phone: ', 'reserving') .  esc_html($order['billing']['phone']) ); ?></p>
                <p> <?php echo wp_kses_post( _x('Address: ', 'reserving') . wp_kses_post($order['billing']['address_1']) ); ?></p>
            </div>
        <?php } ?>

        <?php if (reserving_setting_option('print_shipping_info_activate', 1)) { ?>
            <div class="shipping_info">
                <p><strong><?php echo esc_html($shipping_label); ?></strong></p>
                <p> <?php echo wp_kses_post( _x('Name: ', 'reserving') .  esc_html($order['shipping']['first_name']) . ' ' . esc_html($order['shipping']['last_name'])); ?></p>
                <p> <?php echo wp_kses_post( _x('Phone: ', 'reserving') .  esc_html($order['shipping']['phone']) ); ?></p>
                <p><?php echo wp_kses_post( _x('Address: ', 'reserving') .  wp_kses_post($order['shipping']['address_1']) ); ?></p>
            </div>
        <?php } ?>
    </div>
    <?php if(reserving_setting_option('print_delivery_info_activate', 1)) { ?>
        <div class="delivery_info">
            <p><strong><?php echo esc_html($delivery_info_label); ?></strong></p>
            <?php if (isset($order['reserving_delivery_info']['delivery_type'])) { ?>
                <p><?php echo wp_kses_post( _x('Delivery Type: ', 'reserving') . esc_html($order['reserving_delivery_info']['delivery_type']) ); ?></p>
            <?php } ?>
            <?php if (isset($order['reserving_delivery_info']['reserving_branch'])) { ?>
                <p> <?php echo wp_kses_post( _x('Branch Name: ', 'reserving') . esc_html($order['reserving_delivery_info']['reserving_branch'])); ?></p>
            <?php } ?>
            <?php if (isset($order['reserving_delivery_info']['booking_date'])) { ?>
                <p><?php echo wp_kses_post( _x('Booking Date:  ', 'reserving') . esc_html($order['reserving_delivery_info']['booking_date']) ); ?></p>
                <p><?php echo wp_kses_post( _x('Start Time: ', 'reserving') . esc_html($order['reserving_delivery_info']['start_time']) ); ?></p>
                <p><?php echo wp_kses_post( _x('End Time: ', 'reserving') . esc_html($order['reserving_delivery_info']['end_time']) ); ?></p>
            <?php } else if (isset($order['reserving_delivery_info']['delivery_date'])) {
                $delivery_label = 'Delivery';
                if (strtolower($order['reserving_delivery_info']['delivery_type']) == 'pickup') {
                    $delivery_label = 'Pickup';
                }
            ?>
                <p><?php echo wp_kses_post( sprintf( "%s Date: %s" , $delivery_label , $order['reserving_delivery_info']['delivery_date'] ) ); ?></p>
                <p><?php echo wp_kses_post( sprintf("%s Time: %s" , $delivery_label , $order['reserving_delivery_info']['delivery_time'])); ?></p>
           <?php } ?>
            <?php if (isset($order['reserving_delivery_info']['reserving_tables'])) {
                $booked_tables = $order['reserving_delivery_info']['reserving_tables'];
                ?>
                <p> <?php echo esc_html__('Tables:', 'reserving'); ?>
                    <?php
                        foreach ($booked_tables as $key => $table) {
                            $comma = (count($booked_tables) - 1 == $key) ? '' : ' , ';
                            $table_name = $table['table_info']->name;
                            $max_person = $table['max_person'];
                            echo wp_kses_post( sprintf( "<span>%s ( Max: %s )</span>%s" , esc_html($table_name) , esc_html($max_person) ,esc_html( $comma ) ) );
                        }
                    ?>
                </p>
            <?php } ?>
        </div>
    <?php } ?>
    <hr>
    <?php if (reserving_setting_option('print_order_items_activate', 1)) { ?>
        <table style="width:100%; text-align:left;" class='display dataTable reserving-order-table-print'>
            <tr>
                <th><?php echo esc_html__('Item Name', 'reserving') ?></th>
                <th><?php echo esc_html__('Extra Items', 'reserving') ?></th>
                <th><?php echo esc_html__('Item Quantity', 'reserving') ?></th>
                <th><?php echo esc_html__('Item Total Price', 'reserving') ?></th>
            </tr>
            <?php
                foreach ($order['order_items'] as $key => $item) {
                    ?>
                    <tr>
                        <td>
                            <?php echo esc_html($item['product']->get_name()); ?>
                            <?php echo wp_kses_post(" (" . get_woocommerce_currency_symbol() . esc_html( $item['product']->get_price() ) . " )"); ?>
                        </td>
                        <td>
                            <?php
                                if (!empty($item['allmeta'])) {
                                    foreach ($item['allmeta'] as $key => $meta) {
                                        if ($meta->key == "_reduced_stock" || $meta->key == "reserving_delivery_info") {
                                            continue;
                                        }
                                        echo wp_kses_post( esc_attr( $meta->key ) . " " . esc_html( $meta->value ) . "<br>");
                                    }
                                }
                            ?>
                        </td>
                        <td><?php echo esc_html( $item['quantity'] ); ?></td>
                        <td><?php echo wp_kses_post( get_woocommerce_currency_symbol() . esc_html($item['total']) ); ?></td>
                    </tr>
                    <?php
                }
            ?>
        </table>
    <?php } ?>
    <hr>
    <div class="order_total">
        <?php if ( reserving_setting_option('print_shipping_cost_activate', 1)) { ?>
            <p class="shipping_total">
                <?php echo wp_kses_post( $shipping_cost_label . ' ' . get_woocommerce_currency_symbol() . esc_html( $order['shipping_total'] ) ); ?>
            </p>
        <?php } ?>
        <?php if ( reserving_setting_option('print_total_cost_activate', 1) ) { ?>
            <p class="total">
                <strong><?php echo wp_kses_post( $total_cost_label . ' ' .  get_woocommerce_currency_symbol() . esc_html( $order['total'] ) ); ?></strong>
            </p>
        <?php } ?>
    </div>
</div>