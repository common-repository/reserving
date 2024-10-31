<div class="form-container tabcontent deliveryCheckerForm" id="inRestChecker">
    <label for="reserving_branch"><b><?php echo esc_html(reserving_text_setting_option('reserving_select_branch_label', esc_html__('Select Branch', 'reserving'))); ?></b></label>
    <select name="reserving_branch" required>
        <option value=""><?php echo esc_html(reserving_text_setting_option('reserving_select_branch_label', esc_html__('Select Branch', 'reserving'))); ?></option>
        <?php echo reserving_kses($this->render_branch_list()); ?>
    </select>
    <div class="delivery_date">
        <p><?php echo esc_html(reserving_text_setting_option('reserving_booking_date_label', esc_html__('Choose Date:', 'reserving'))); ?></p>
        <input type="date" name="delivery_date" min="<?php echo esc_attr(gmdate('Y-m-d')); ?>" value="<?php echo esc_attr($this->delivery_info['delivery_date'] ?? ''); ?>" class="delivery_date">
        <br>
    </div>
    <div class="delivery_time">
        <!--Time slots will be generated here on branch Selection-->
        <?php echo reserving_kses($this->render_time_slots("inRestChecker")); ?>
    </div>
    <div id="reserving_tables" class="suggestions test">
        <div class="tables reserving--tables">
            <?php echo reserving_kses($this->render_table_list()); ?>
        </div>
    </div>
    <a href="#" class="btn start_order"><?php echo esc_html($update_info_btn_text); ?></a>
    <div class="message mt-20"></div>
</div>