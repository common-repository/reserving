<form class="form-container reserving-form-container tabcontent deliveryCheckerForm" id="pickupChecker">
    <label for="reserving_branch"><b><?php echo esc_html(reserving_text_setting_option('reserving_select_branch_label', esc_html__('Select Branch', 'reserving'))); ?></b></label>
    <select name="reserving_branch" required>
        <option value=""><?php echo esc_html(reserving_text_setting_option('reserving_select_branch_label', esc_html__('Select Branch', 'reserving'))); ?></option>
        <?php echo reserving_kses($this->render_branch_list()); ?>
    </select>
    <div class="delivery_date">
        <p><?php echo esc_html(reserving_text_setting_option('reserving_pickup_date_label', esc_html__('Pickup Date', 'reserving'))); ?></p>
        <input type="date" name="delivery_date" min="<?php echo esc_attr(gmdate('Y-m-d')); ?>" value="<?php echo esc_attr(gmdate('Y-m-d')); ?>" class="delivery_date">
        <br>
    </div>
    <p><?php echo esc_html(reserving_text_setting_option('reserving_pickup_time_label', esc_html__('Pickup Time', 'reserving'))); ?></p>
    <div class="delivery_time">
        <!--Time slots will be generated here on branch & date Selection-->
    </div>
    <div class="message mt-20"></div>
    <a href="<?php echo esc_url($start_order_button_link); ?>" class="btn start_order"><?php echo esc_html($start_order_button_text); ?></a>
</form>