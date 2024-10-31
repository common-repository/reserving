<?php

$order_info       = $this->get_orders_list();
$heading_show     = reserving_setting_option('reserving_front_dash_table_heading', 1);
$date_filter_show = reserving_setting_option('reserving_front_dash_table_date_filter', 0);
$dfilter_label    = reserving_text_setting_option('reserving_front_dash_dfilter_label', '');
$dash_icon        = reserving_text_setting_option('ba_front_dash_icon_enable', 1);
$cooking_proc_img = reserving_text_setting_option('ba_cooking_process_icon');
$cooking_comp_img = reserving_text_setting_option('ba_cooking_complete_icon');
$all_order_img    = reserving_text_setting_option('ba_all_order_icon');

?>
<div class="wrap reserving-front-dashboard-manager">
    <?php if ($heading_show): ?>
        <h3><?php _e('Orders', 'reserving'); ?></h3>
    <?php endif; ?>
    <div class="reserving-ordertable-filter-wrapper <?php echo esc_attr($dash_icon ? 'reserving-icon-menu' : ''); ?>">
        <div class="reserving_order_filter_btns">
            <?php if ($date_filter_show): ?>
                <div class="filter_by_date">
                    <label>
                        <?php if ($dfilter_label != ''): ?>
                            <?php echo wp_kses_post($dfilter_label); ?>
                        <?php endif ?>
                        <input type="date">
                    </label>
                </div>
            <?php endif; ?>
            <button data-status="" class="all_orders">
                <div class="reserving-dash-icon-wrapper">
                    <?php if ($dash_icon): ?>
                        <img src="<?php echo esc_url($all_order_img); ?>" />
                    <?php endif; ?>
                </div>
                <span class="status-text">
                    <?php esc_html_e('All Orders', 'reserving') ?>
                </span>
            </button>
            <button data-status="Cooking Processing">
                <div class="reserving-dash-icon-wrapper">
                    <?php if ($dash_icon): ?>
                        <div class="reserving-icon-inner-wrapper">
                            <img src="<?php echo esc_url($cooking_proc_img); ?>" />
                            <span class="count"><?php echo esc_html($this->cooking_process); ?></span>
                        </div>
                    <?php else: ?>
                        <span class="count"><?php echo esc_html($this->cooking_process); ?></span>
                    <?php endif; ?>
                </div>
                <span class="status-text"><?php esc_html_e('Cooking Processing', 'reserving') ?></span>
            </button>
            <button data-status="Cooking Completed">
                <div class="reserving-dash-icon-wrapper">
                    <?php if ($dash_icon): ?>
                        <div class="reserving-icon-inner-wrapper">
                            <img src="<?php echo esc_url($cooking_comp_img); ?>" />
                            <span class="count"><?php echo esc_html($this->cooking_completed); ?></span>
                        </div>
                    <?php else: ?>
                        <span class="count"><?php echo esc_html($this->cooking_completed); ?></span>
                    <?php endif; ?>
                </div>
                <span class="status-text"><?php esc_html_e('Cooking Completed', 'reserving') ?></span>
            </button>
        </div>
        <table id="orders_table" class="display">
            <thead>
                <tr>
                    <th><?php _e('Order ID ', 'reserving'); ?></th>
                    <th><?php _e('Date Created', 'reserving'); ?></th>
                    <th><?php _e('Delivery/Pickup/Booking Date', 'reserving'); ?></th>
                    <th><?php _e('Order Status ', 'reserving'); ?></th>
                    <th><?php _e('View Order ', 'reserving'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php echo reserving_kses($order_info); ?>
            </tbody>
        </table>
    </div>
</div>