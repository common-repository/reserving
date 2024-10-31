<?php

    $deliery_activated = reserving_setting_option('home_delivery_activate', 1);
    $pickup_activated = reserving_setting_option('pickup_activate', 1);
    $inrest_activated = reserving_setting_option('inrestaurant_activate', 1);

    $deliveryActiveClass = (!isset($this->delivery_info['delivery_type']) || $this->delivery_info['delivery_type'] == 'delivery') ? 'active' : '';
    $home_delivery_info_label = reserving_text_setting_option('home_delivery_info_label', _x('Delivery Information', 'reserving'));
    $pickupActiveClass = (isset($this->delivery_info['delivery_type']) && $this->delivery_info['delivery_type'] == 'pickup') ? 'active' : '';

    $inrestActiveClass = (isset($this->delivery_info['delivery_type']) && $this->delivery_info['delivery_type'] == 'in_restaurant') ? 'active' : '';

    $delivery_label = (!empty(reserving_setting_option('home_delivery_label'))) ? reserving_setting_option('home_delivery_label') : _x('Home Delivery', 'reserving');
    $pickup_label = (!empty(reserving_setting_option('pickup_label'))) ? reserving_setting_option('pickup_label') : _x('Pick Up', 'reserving');
    $in_rest_label = (!empty(reserving_setting_option('in_restaurant_label'))) ? reserving_setting_option('in_restaurant_label') : _x('In Restaurant', 'reserving');

    $update_info_btn_text = reserving_text_setting_option('update_info_button_text', _x('Update Info', 'reserving'));
    $checker_form_title_show = reserving_setting_option('checker_form_title_show', 1);

?>
<div class="form-popup reserving-delivery-info-wrapper" id="checkoutDeliveryInfo">
    <?php if($checker_form_title_show): ?>
        <h3 class="reserving-chk-heading"><?php echo esc_html($home_delivery_info_label); ?></h3>
    <?php endif; ?>
    <div class="reserving__tabs">
        <?php if ($deliery_activated) { ?>
            <button class="tablinks <?php echo esc_attr($deliveryActiveClass); ?>" onclick="openTabContent(event, 'deliveryChecker')"><?php echo esc_html($delivery_label); ?></button>
        <?php } ?>

        <?php if ($pickup_activated) { ?>
            <button class="tablinks <?php echo esc_attr($pickupActiveClass); ?>" onclick="openTabContent(event, 'pickupChecker')"><?php echo esc_html($pickup_label); ?></button>
        <?php } ?>

        <?php if ($inrest_activated) { ?>
            <button class="tablinks <?php echo esc_attr($inrestActiveClass); ?>" onclick="openTabContent(event, 'inRestChecker')"><?php echo esc_html($in_rest_label); ?></button>
        <?php } ?>
    </div>

    <?php
    // Delivery Checker Form
    if ($deliery_activated) {
        require_once __DIR__ . '/delivery_checker.php';
    }

    // Pickup Checker Form
    if ($pickup_activated) {
        require_once __DIR__ . '/pickup_checker.php';
    }

    // In Restaurant Checker Form
    if ($inrest_activated) {
        require_once __DIR__ . '/in_rest_checker.php';
    }
    ?>
    <div class="loader"></div>
</div>