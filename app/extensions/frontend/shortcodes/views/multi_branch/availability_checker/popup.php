<?php

$checker_form_title = (!empty(reserving_setting_option('checker_form_title'))) ? _x(reserving_setting_option('checker_form_title'), 'reserving') : _x('Check Delivery Availability', 'reserving');
$open_button_text   = (!empty(reserving_setting_option('open_button_text'))) ? _x(reserving_setting_option('open_button_text'), 'reserving') : _x('Check Availability', 'reserving');
$close_button_text  = (!empty(reserving_setting_option('close_button_text'))) ? _x(reserving_setting_option('close_button_text'), 'reserving') : _x('Close', 'reserving');

$deliery_activated       = reserving_setting_option('home_delivery_activate', 1);
$pickup_activated        = reserving_setting_option('pickup_activate', 1);
$inrest_activated        = reserving_setting_option('inrestaurant_activate', 1);
$checker_form_title_show = reserving_setting_option('checker_form_title_show', 1);
$delivery_label          = (!empty(reserving_setting_option('home_delivery_label'))) ? reserving_setting_option('home_delivery_label') : 'Home Delivery';
$pickup_label            = (!empty(reserving_setting_option('pickup_label'))) ? reserving_setting_option('pickup_label') : 'Pick Up';
$in_rest_label           = (!empty(reserving_setting_option('in_restaurant_label'))) ? reserving_setting_option('in_restaurant_label') : 'In Restaurant';
$start_order_button_text = (!empty(reserving_setting_option('start_order_button_text'))) ? _x(reserving_setting_option('start_order_button_text'), 'reserving') : _x('Start Order', 'reserving');
$start_order_button_link = (!empty(reserving_setting_option('start_order_button_link'))) ? esc_url(reserving_setting_option('start_order_button_link')) : esc_url(wc_get_page_permalink('shop'));
// Button Icon
$delivery_icon = reserving_setting_option('reserving_tab_nav_home_delivery_icon');
$pickup_icon   = reserving_setting_option('reserving_tab_nav_pickup_delivery_icon');
$in_dine_icon  = reserving_setting_option('reserving_tab_nav_in_dine_icon');

?>
<div class="reserving-form-checker-wrapper">
</div>
<button class="reserving-open-button"
    onclick="openForm('availabilityChecker')"><?php echo esc_html($open_button_text); ?></button>
<div class="form-popup reserving-form-popup multi_branch" id="availabilityChecker">
    <?php if ($checker_form_title_show): ?>
        <h3 class="reserving-chk-heading">
            <?php echo esc_html($checker_form_title); ?>
        </h3>
    <?php endif; ?>
    <div class="shop_page reserving__tabs">
        <?php if ($deliery_activated) { ?>
            <button class="tablinks" onclick="openTabContent(event, 'deliveryChecker')">
                <?php if (filter_var($delivery_icon, FILTER_VALIDATE_URL) == TRUE): ?>
                    <img src="<?php echo esc_url($delivery_icon); ?>" />
                <?php endif; ?>
                <?php echo esc_html($delivery_label); ?>
            </button>
        <?php } ?>

        <?php if ($pickup_activated) { ?>
            <button class="tablinks" onclick="openTabContent(event, 'pickupChecker')">
                <?php if (filter_var($pickup_icon, FILTER_VALIDATE_URL) == TRUE): ?>
                    <img src="<?php echo esc_url($pickup_icon); ?>" />
                <?php endif; ?>
                <?php echo esc_html($pickup_label); ?>
            </button>
        <?php } ?>

        <?php if ($inrest_activated) { ?>
            <button class="tablinks" onclick="openTabContent(event, 'inRestChecker')">
                <?php if (filter_var($in_dine_icon, FILTER_VALIDATE_URL) == TRUE): ?>
                    <img src="<?php echo esc_url($in_dine_icon); ?>" />
                <?php endif; ?>
                <?php echo esc_html($in_rest_label); ?>
            </button>
        <?php } ?>

    </div>

    <!-- Delivery Checker Form-->
    <?php
    if ($deliery_activated) {
        require_once __DIR__ . '/delivery_checker.php';
    }

    if ($pickup_activated) {
        require_once __DIR__ . '/pickup_checker.php';
    }

    if ($inrest_activated) {
        require_once __DIR__ . '/in_rest_checker.php';
    }

    ?>

    <div class="loader"></div>
    <button class="btn reserving-close mt-20"
        onclick="closeForm('availabilityChecker')"><?php echo esc_html($close_button_text); ?></button>
</div>