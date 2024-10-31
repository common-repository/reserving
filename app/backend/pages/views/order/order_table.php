<div class="wrap reserving-order-table-top-wrapper">
    <div class="reserving-order-table-header">
        <h2><?php _e('Orders Table', 'reserving'); ?></h2>
    </div>
    <div class="reserving-order-table-dash-container">
        <div class="reserving_order_filter_btns reserving-order-filter-btns">
            <div class="reserving-table-all-order">
                <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/icons/order-all.svg'); ?>" />
                <button data-status=" " class="all_orders"><span
                        class="status-text"><?php esc_html_e('All Order', 'reserving') ?></span> <span
                        class="count"><?php echo esc_html($this->order_count['all']); ?></span></button>
            </div>
            <div class="reserving-table-new-order">
                <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/icons/order-cart.svg'); ?>" />
                <button data-status="New Order"><span
                        class="status-text"><?php esc_html_e('New Order', 'reserving') ?></span> <span
                        class="count"><?php echo esc_html($this->order_count['rsv-new-order']); ?></span></button>
            </div>
            <div class="reserving-table-process-order">
                <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/icons/order-cookie.svg'); ?>" />
                <button data-status="Cooking Processing"><span
                        class="status-text"><?php esc_html_e('Cooking Processing', 'reserving') ?></span><span
                        class="count"><?php echo esc_html($this->order_count['reserving-cooking']); ?></span></button>
            </div>
            <div class="reserving-table-cook-cml-order">
                <img
                    src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/icons/order-cookie-complete.svg'); ?>" />
                <button data-status="Cooking Completed "><span
                        class="status-text"><?php esc_html_e('Cooking Completed', 'reserving') ?></span> <span
                        class="count"><?php echo esc_html($this->order_count['cooking-completed']); ?></span></button>
            </div>
            <div class="reserving-table-on-the-way-order">
                <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/icons/on-the-way.svg'); ?>" />
                <button data-status="On The Way"><span
                        class="status-text"><?php esc_html_e('On The Way', 'reserving') ?></span><span
                        class="count"><?php echo esc_html($this->order_count['on-the-way']); ?></span></button>
            </div>
            <div class="reserving-table-complete-order">
                <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/icons/car.svg'); ?>" />
                <button data-status="Delivery Completed"><span
                        class="status-text"><?php esc_html_e('Delivery Completed', 'reserving') ?></span><span
                        class="count"><?php echo esc_html($this->order_count['completed']); ?></span></button>
            </div>
            <div class="filter_by_date">
                <input type="date">
            </div>
        </div>
    </div>
    <table id="orders_table" class="display">
        <thead>
            <tr>
                <th><?php _e('Order ID ', 'reserving'); ?></th>
                <th><?php _e('Date Created', 'reserving'); ?></th>
                <?php if ('multi_branch' == $this->get_branch_option()) { ?>
                <th><?php _e('Branch', 'reserving'); ?></th>
                <?php } ?>
                <th><?php _e('Delivery/Pickup/Booking Date', 'reserving'); ?></th>
                <th><?php _e('Delivery Man', 'reserving'); ?></th>
                <th><?php _e('Order Status ', 'reserving'); ?></th>
                <th><?php _e('View Order ', 'reserving'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php echo wp_kses_post($this->get_orders_list()); ?>
        </tbody>
    </table>
</div>