<form class="form-container reserving-form-container tabcontent" id="deliveryChecker">
    <?php if (!empty($this->delivery_areas)) { ?>
        <div class="suggestions">
            <div id="reserving_single_branch_delivery_areas" class="reserving_delivery_areas">
                <p class="mt-20"><b><?php echo esc_html(reserving_text_setting_option('reserving_select_location_label', esc_html__('Select your location', 'reserving'))); ?></b></p>
                <input type="text" class="search_item" name="search_delivery_area" placeholder="<?php echo esc_html__('Search Location', 'reserving') ?>" onkeyup="reservingSearchDeliveryAreas(this.value)">
                <input type="hidden" class="item_value" name="item_value" value="">
                <ul class="delivery_areas">
                    <?php echo reserving_kses($this->render_delivery_area_list()); ?>
                </ul>
            </div>
        </div>
        <br>
    <?php } ?>
    <!-- Delivery Date -->
    <div class="delivery_date">
        <p><?php echo esc_html(reserving_text_setting_option('reserving_delivery_date_label', esc_html__('Delivery Date:', 'reserving'))); ?></p>
        <input type="date" name="delivery_date" value="<?php echo esc_attr(gmdate('Y-m-d')); ?>" min="<?php echo esc_attr(gmdate('Y-m-d')); ?>" class="delivery_date">
        <br>
    </div>
    <p><?php echo esc_html(reserving_text_setting_option('reserving_delivery_time_label', esc_html__('Delivery Time:', 'reserving'))); ?></p>
    <div class="delivery_time">
        <?php $this->render_single_branch_time_slots(); ?>
    </div>
    <br>
    <div class="message mt-20"></div>
    <a href="<?php echo esc_url($start_order_button_link); ?>" class="btn start_order"><?php echo esc_html($start_order_button_text); ?></a>
</form>