<form class="form-container bookta-form-container tabcontent deliveryCheckerForm" id="inRestChecker">
    <label for="reserving_branch"><b><?php echo esc_html(reserving_text_setting_option('reserving_select_branch_label', esc_html__('Select Branch', 'reserving'))); ?></b></label>
    <select name="reserving_branch" required>
        <option value=""><?php echo esc_html(reserving_text_setting_option('reserving_select_branch_label', esc_html__('Select Branch', 'reserving'))); ?></option>
        <?php echo reserving_kses($this->render_branch_list()); ?>
    </select>

    <div class="delivery_date">
        <p><?php echo esc_html(reserving_text_setting_option('reserving_booking_date_label', esc_html__('Choose Date:', 'reserving'))); ?></p>
        <input type="date" name="delivery_date" min="<?php echo esc_attr(gmdate('Y-m-d')); ?>" value="<?php echo esc_attr(gmdate('Y-m-d')); ?>" class="delivery_date">
        <br>
    </div>
    <div class="delivery_time">
        <!--Times slots will be generated here on branch Selection-->
    </div>
    <div id="reserving_tables" class="suggestions">
        <!-- <input type="hidden" class="item_value" name="item_value" value=""> -->
        <div class="tables">
            <!-- Tables will be generated here on branch Selection-->
        </div>
    </div>
    <div class="message mt-20"></div>
    <a href="<?php echo esc_url($start_order_button_link); ?>" class="btn start_order"><?php echo esc_html($start_order_button_text); ?></a>
</form>