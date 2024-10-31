<form class="form-container reserving-form-container tabcontent deliveryCheckerForm" id="pickupChecker">
    <div class="delivery_date">
        <p><?php echo esc_html(reserving_text_setting_option('reserving_pickup_date_label', esc_html__('Pickup Date', 'reserving'))); ?></p>
        <input type="date" name="delivery_date" value="<?php echo esc_attr(gmdate('Y-m-d')); ?>" min="<?php echo esc_attr(gmdate('Y-m-d')); ?>" class="delivery_date">
        <br>
    </div>
    <p><?php echo esc_html(reserving_text_setting_option('reserving_pickup_time_label', esc_html__('Pickup Time', 'reserving'))); ?></p>
    <div class="delivery_time">
        <?php $this->render_single_branch_time_slots(); ?>
    </div>
    <div class="message mt-20"></div>
    <a href="<?php echo esc_url($start_order_button_link); ?>" class="btn start_order"><?php echo esc_html($start_order_button_text); ?></a>
</form>