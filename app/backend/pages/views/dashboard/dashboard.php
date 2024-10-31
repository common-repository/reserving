<div class="wrap reserving-dashboard-report-wrap">
    <div class="header">
        <h2><?php esc_html_e('Reserving | Food Delivery WooCommerce Addon', 'reserving'); ?></h2>
    </div>
    <div class="reserving-row reserving-row-cards">
        <div class="reserving-dashboard-card reserving-report-cart-total-orders">
            <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/total-order.svg'); ?>" />
            <?php
            $icon = 'up';
            $total_order_link = $this->get_order_page_url(
                [
                    'bat-search-q' => ''
                ]
            );
            ?>
            <h2><a href="<?php echo esc_url($total_order_link); ?>"><?php esc_html_e('Total Orders', 'reserving'); ?> </a></h2>
            <div class="reserving-report-count">
                <div class="count"><?php echo esc_html($this->get_orders_count()); ?></div>
                <div class="reserving-report-up-down">
                    <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/up.svg'); ?>" />
                </div>
            </div>
        </div>
        <div class="reserving-dashboard-card reserving-report-new-orders">
            <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/new-orders.svg'); ?>" />
            <?php
            $new_order_link = $this->get_order_page_url([
                'bat-search-q' => esc_html__('New Order', 'reserving')
            ]);
            $new_order = $this->get_percentage_by_status('rsv-new-order');
            if ($new_order == 0 || strpos($new_order, '-') !== false) {
                $icon = 'down';
            }
            ?>
            <h2>
                <a href="<?php echo esc_url($new_order_link); ?>">
                    <?php esc_html_e('New Orders', 'reserving'); ?>
                </a>
            </h2>
            <div class="reserving-report-count">
                <div class="count"><?php echo esc_html($this->get_orders_count('rsv-new-order')); ?></div>
                <div class="reserving-report-up-down">
                    <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . "imgs/dash-icons/{$icon}.svg"); ?>" />
                    <span><?php echo esc_html($new_order); ?></span>
                </div>
            </div>
        </div>
        <div class="reserving-dashboard-card reserving-report-cooking-process">
            <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/cooking-process.svg'); ?>" />
            <?php
            $process_order_link = $this->get_order_page_url([
                'bat-search-q' => esc_html__('Processing', 'reserving')
            ]);
            $cooking = $this->get_percentage_by_status('reserving-cooking');
            if ($cooking == 0 || strpos($cooking, '-') !== false) {
                $icon = 'down';
            }
            ?>
            <h2>
                <a href="<?php echo esc_url($process_order_link); ?>">
                    <?php esc_html_e('Cooking Processing', 'reserving'); ?>
                </a>
            </h2>
            <div class="reserving-report-count">
                <div class="count"><?php echo esc_html($this->get_orders_count('reserving-cooking')); ?> </div>
                <div class="reserving-report-up-down">
                    <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . "imgs/dash-icons/{$icon}.svg"); ?>" />
                    <span><?php echo esc_html($cooking); ?></span>
                </div>
            </div>
        </div>
        <div class="reserving-dashboard-card reserving-report-cooking-complete">
            <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/cooking-complete.svg'); ?>" />
            <?php
            $process_cmp_order_link = $this->get_order_page_url([
                'bat-search-q' => esc_html__('cooking complete', 'reserving')
            ]);
            $cooking_completed = $this->get_percentage_by_status('cooking-completed');
            if ($cooking_completed == 0 || strpos($cooking_completed, '-') !== false) {
                $icon = 'down';
            }
            ?>
            <h2>
                <a href="<?php echo esc_url($process_cmp_order_link); ?>">
                    <?php esc_html_e('Cooking Completed', 'reserving'); ?>
                </a>
            </h2>
            <div class="reserving-report-count">
                <div class="count"><?php echo esc_html($this->get_orders_count('cooking-completed')); ?> </div>
                <div class="reserving-report-up-down">
                    <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . "imgs/dash-icons/{$icon}.svg"); ?>" />
                    <span><?php echo esc_html($cooking_completed); ?></span>
                </div>
            </div>
        </div>
        <div class="reserving-dashboard-card reserving-report-on-the-way">
            <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/on-the-way.svg'); ?>" />
            <?php
            $on_way_order_link = $this->get_order_page_url([
                'bat-search-q' => esc_html__('on the way', 'reserving')
            ]);

            $on_the_way = $this->get_percentage_by_status('on-the-way');
            if ($on_the_way == 0 || strpos($on_the_way, '-') !== false) {
                $icon = 'down';
            }
            ?>
            <h2>
                <a href="<?php echo esc_url($on_way_order_link); ?>">
                    <?php esc_html_e('On the way', 'reserving'); ?>
                </a>
            </h2>
            <div class="reserving-report-count">
                <div class="count"><?php echo esc_html($this->get_orders_count('on-the-way')); ?></div>
                <div class="reserving-report-up-down">
                    <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . "imgs/dash-icons/{$icon}.svg"); ?>" />
                    <span><?php echo esc_html($on_the_way); ?></span>
                </div>
            </div>
        </div>
        <div class="reserving-dashboard-card reserving-report-del-com">
            <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/delivery-complete.svg'); ?>" />
            <?php
            $del_comp_order_link = $this->get_order_page_url([
                'bat-search-q' => esc_html__('Delivery Completed', 'reserving')
            ]);
            $completed = $this->get_percentage_by_status('completed');
            if ($completed == 0 || strpos($completed, '-') !== false) {
                $icon = 'down';
            }
            ?>
            <h2>
                <a href="<?php echo esc_url($del_comp_order_link); ?>">
                    <?php esc_html_e('Delivery Completed', 'reserving'); ?>
                </a>
            </h2>
            <div class="reserving-report-count">
                <div class="count"><?php echo esc_html($this->get_orders_count('completed')); ?> </div>
                <div class="reserving-report-up-down">
                    <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . "imgs/dash-icons/{$icon}.svg"); ?>" />
                    <span><?php echo esc_html($completed); ?></span>
                </div>
            </div>
        </div>
        <div class="reserving-dashboard-card reserving-report-order-cancel">
            <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/order-concel.svg'); ?>" />
            <?php
            $cancel_order_link = $this->get_order_page_url([
                'bat-search-q' => esc_html('Cancelled', 'reserving')
            ]);
            $cancelled = $this->get_percentage_by_status('cancelled');
            if ($cancelled == 0 || strpos($cancelled, '-') !== false) {
                $icon = 'down';
            }
            ?>
            <h2>
                <a href="<?php echo esc_url($cancel_order_link); ?>">
                    <?php esc_html_e('Order Cancelled', 'reserving'); ?>
                </a>
            </h2>
            <div class="reserving-report-count">
                <div class="count"><?php echo esc_html($this->get_orders_count('cancelled')); ?></div>
                <div class="reserving-report-up-down">
                    <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . "imgs/dash-icons/{$icon}.svg"); ?>" />
                    <span><?php echo esc_html($cancelled); ?></span>
                </div>
            </div>
        </div>
        <?php if ('multi_branch' == $this->get_branch_option()) { ?>
            <div class="reserving-dashboard-card reserving-report-total-branch">
                <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/total-branch.svg'); ?>" />
                <h2><?php esc_html_e('Total Branches', 'reserving'); ?></h2>
                <div class="reserving-report-count">
                    <div class="count"> <?php echo esc_html($this->get_total_branches()); ?> </div>
                    <div class="reserving-report-up-down">
                        <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/up.svg'); ?>" />
                    </div>
                </div>
            </div>
        <?php } ?>
        <div class="reserving-dashboard-card reserving-report-del-area">
            <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/delivery-area.svg'); ?>" />
            <h2>
                <?php
                $delivery_url = admin_url('edit-tags.php?taxonomy=reserving-delivery-area&post_type=reserving-branches');
                echo wp_kses_post(sprintf(
                    '<a href="%s" >%s</a>',
                    esc_url($delivery_url),
                    esc_html__('Total Delivery Area', 'reserving')
                ));
                ?>
            </h2>
            <div class="reserving-report-count">
                <div class="count">
                    <?php echo wp_kses_post($this->get_total_delivery_area()); ?>
                </div>
                <div class="reserving-report-up-down">
                    <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/up.svg'); ?>" />
                </div>
            </div>
        </div>
        <div class="reserving-dashboard-card reserving-report-total-customer">
            <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/user-group.svg'); ?>" />
            <h2>
                <?php
                $wc_url = $this->get_wc_page_url([
                    'path' => '/customers'
                ]);
                echo wp_kses_post(
                    sprintf(
                        "<a href='%s'>%s</a>",
                        esc_url($wc_url),
                        esc_html__('Total Customers', 'reserving')
                    )
                );
                ?>
            </h2>
            <div class="reserving-report-count">
                <div class="count"><?php echo esc_html($this->get_total_customers()); ?> </div>
                <div class="reserving-report-up-down">
                    <img src="<?php echo esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/dash-icons/down.svg'); ?>" />
                    <span><?php echo wp_kses_post($this->get_customer_percentage()); ?></span>
                </div>
            </div>
        </div>
    </div>
</div>