<div class="form-container reserving-form-container-pick tabcontent deliveryCheckerForm" id="pickupChecker">
    <p><?php echo esc_html(reserving_text_setting_option('reserving_pickup_date_label', esc_html__('Pickup Date', 'reserving'))); ?></p>
    <input type="date" name="delivery_date" min="<?php echo esc_attr(gmdate('Y-m-d')); ?>" class="delivery_date" value="<?php echo esc_attr($this->delivery_info['delivery_date']); ?>">
    <br><br>
    <p><?php echo esc_html(reserving_text_setting_option('reserving_pickup_time_label', esc_html__('Pickup Time', 'reserving'))); ?></p>
    <div class="delivery_time">
        <?php echo reserving_kses($this->render_time_slots()); ?>
    </div>
    <a href="#" class="btn start_order"><?php echo esc_html($update_info_btn_text); ?></a>
    <div class="message mt-20"></div>
</div>