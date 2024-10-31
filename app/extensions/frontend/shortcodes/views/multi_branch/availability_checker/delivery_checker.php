<form class="form-container reserving-form-conatiner tabcontent" id="deliveryChecker">
    <!-- Branches and Delivery areas -->
    <label for="reserving_branch"><b><?php echo esc_html(reserving_text_setting_option('reserving_select_branch_label', esc_html__('Select Branch', 'reserving'))); ?></b></label>
    <select name="reserving_branch" required>
        <option value=""><?php echo esc_html(reserving_text_setting_option('reserving_select_branch_label', esc_html__('Select Branch', 'reserving'))); ?></option>
        <?php echo reserving_kses($this->render_branch_list()); ?>
    </select>
    <div class="suggestions">
        <div id="reserving_delivery_areas" class="reserving_delivery_areas">
            <p class="mt-20"><b><?php echo esc_html(reserving_text_setting_option('reserving_select_location_label', esc_html__('Select your location', 'reserving'))); ?></b></p>
            <input type="text" class="search_item" name="search_delivery_area" placeholder="<?php echo esc_html__('Search Location', 'reserving'); ?>" onkeyup="reservingSearchDeliveryAreas(this.value)">
            <input type="hidden" class="item_value" name="item_value" value="">
            <ul class="delivery_areas"></ul>
            <a href="#" class="btn availibity_checker_btn"><?php echo esc_html(reserving_text_setting_option('check_availability_button_text', esc_html__('Check Availability', 'reserving'))); ?></a>
        </div>
    </div>
    <!-- Delivery Date -->
    <div class="delivery_date">
        <p><?php echo esc_html(reserving_text_setting_option('reserving_delivery_date_label', esc_html__('Delivery Date:', 'reserving'))); ?></p>
        <input type="date" name="delivery_date" min="<?php echo esc_attr(gmdate('Y-m-d')); ?>" value="<?php echo esc_attr(gmdate('Y-m-d')); ?>" class="delivery_date">
        <br>
    </div>
    <!-- Delivery Time -->
    <p><?php echo esc_html(reserving_text_setting_option('reserving_delivery_time_label', esc_html__('Delivery Time:', 'reserving'))); ?></p>
    <div class="delivery_time">
        <!-- Delivery Times will be generated here on branch Selection-->
    </div>
    <div class="message mt-20"></div>
    <a href="<?php echo esc_url($start_order_button_link); ?>" class="btn start_order"><?php echo esc_html($start_order_button_text); ?></a>
</form>