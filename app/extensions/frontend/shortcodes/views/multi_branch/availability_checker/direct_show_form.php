<?php

$checker_form_title = (!empty(reserving_setting_option('checker_form_title'))) ? _x(reserving_setting_option('checker_form_title'), 'reserving') : _x('Check Delivery Availability', 'reserving');
$open_button_text = (!empty(reserving_setting_option('open_button_text'))) ? _x(reserving_setting_option('open_button_text'), 'reserving') : _x('Check Availability', 'reserving');

$close_button_text = (!empty(reserving_setting_option('close_button_text'))) ? _x(reserving_setting_option('close_button_text'), 'reserving') : _x('Close', 'reserving');

$deliery_activated = reserving_setting_option('home_delivery_activate', 1);
$pickup_activated = reserving_setting_option('pickup_activate', 1);
$inrest_activated = reserving_setting_option('inrestaurant_activate', 1);

$delivery_label = (!empty(reserving_setting_option('home_delivery_label'))) ? reserving_setting_option('home_delivery_label') : 'Home Delivery';
$pickup_label = (!empty(reserving_setting_option('pickup_label'))) ? reserving_setting_option('pickup_label') : 'Pick Up';
$in_rest_label = (!empty(reserving_setting_option('in_restaurant_label'))) ? reserving_setting_option('in_restaurant_label') : 'In Restaurant';

$start_order_button_text = (!empty(reserving_setting_option('start_order_button_text'))) ? _x(reserving_setting_option('start_order_button_text'), 'reserving') : _x('Start Order', 'reserving');
$checker_form_title_show = reserving_setting_option('checker_form_title_show', 1);
$start_order_button_link = (!empty(reserving_setting_option('start_order_button_link'))) ? esc_url(reserving_setting_option('start_order_button_link')) : esc_url(wc_get_page_permalink('shop'));

?>

<div class="reserving-form-checker-wrapper">
</div>
<div class="form-popup reserving-form-popup multi_branch direct_show" id="availabilityChecker">
    <?php if ($checker_form_title_show): ?>
        <h3 class="reserving-chk-heading"><?php echo esc_html($checker_form_title); ?></h3>
    <?php endif; ?>
    <div class="shop_page reserving__tabs">
        <?php if ($deliery_activated) { ?>
            <button class="tablinks"
                onclick="openTabContent(event, 'deliveryChecker')"><?php echo esc_html($delivery_label); ?></button>
        <?php } ?>

        <?php if ($pickup_activated) { ?>
            <button class="tablinks"
                onclick="openTabContent(event, 'pickupChecker')"><?php echo esc_html($pickup_label); ?></button>
        <?php } ?>

        <?php if ($inrest_activated) { ?>
            <button class="tablinks"
                onclick="openTabContent(event, 'inRestChecker')"><?php echo esc_html($in_rest_label); ?> </button>
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
</div>