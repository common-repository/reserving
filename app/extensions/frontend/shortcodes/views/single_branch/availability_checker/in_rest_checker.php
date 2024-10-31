<form class="form-container reserving-form-container tabcontent deliveryCheckerForm" id="inRestChecker">
    <div class="delivery_date">
        <p><?php echo esc_html(reserving_text_setting_option('reserving_booking_date_label', esc_html__('Choose Date:', 'reserving'))); ?></p>
        <input type="date" name="delivery_date" value="<?php echo esc_attr(gmdate('Y-m-d')); ?>" min="<?php echo esc_attr(gmdate('Y-m-d')); ?>" class="delivery_date">
        <br>
    </div>
    <div class="delivery_time mt-20">
        <?php $this->render_single_branch_time_slots("inRestChecker"); ?>
    </div>
    <br>
    <div id="reserving_tables" class="suggestions">
        <div class="tables">
            <!-- Tables will be generated here on date and time selection -->
        </div>
    </div>
    <div class="message mt-20"></div>
    <p><a href="<?php echo esc_url($start_order_button_link); ?>" class="btn start_order"><?php echo esc_html($start_order_button_text); ?></a></p>
</form>