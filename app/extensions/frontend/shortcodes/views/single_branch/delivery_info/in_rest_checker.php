<div class="form-container bookta-form-container-rest tabcontent deliveryCheckerForm" id="inRestChecker">
    <div class="delivery_date">
        <p><?php echo esc_html( reserving_text_setting_option('reserving_booking_date_label', esc_html__('Choose Date:', 'reserving')) ); ?>
        </p>
        <input type="date" name="delivery_date" min="<?php echo esc_attr( gmdate('Y-m-d') ); ?>" class="delivery_date"
            value="<?php echo esc_attr($this->delivery_info['delivery_date']); ?>">
        <br><br>
    </div>
    <div class="delivery_time">
        <?php $this->render_time_slots("inRestChecker"); ?>
    </div>
    <div id="reserving_tables" class="suggestions">
        <!-- Tables will be generated here on date/time selection -->
        <div class="tables">
            <?php echo reserving_kses($this->render_table_list()); ?>
        </div>
    </div>
    <a href="#" class="btn start_order"><?php echo esc_html($update_info_btn_text); ?></a>
    <div class="message mt-20"></div>
</div>