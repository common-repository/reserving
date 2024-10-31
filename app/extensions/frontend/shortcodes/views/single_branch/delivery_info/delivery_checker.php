<?php

$delivery_area = "";
$area_id = 0;

if (isset($this->delivery_info['delivery_area']) && !empty($this->delivery_info['delivery_area'])) {
    $area_id = $this->delivery_info['delivery_area'];
    $delivery_area = get_term_by('id', $this->delivery_info['delivery_area'], 'reserving-delivery-area')->name;
}

?>
<div class="form-container reserving-form-container-checker tabcontent" id="deliveryChecker">
    <div class="suggestions">
        <div id="reserving_delivery_areas" class="reserving_delivery_areas">
            <p class="mt-20"><b><?php echo esc_html(reserving_text_setting_option('reserving_select_location_label', esc_html__('Select your location', 'reserving'))); ?></b></p>
            <input type="text" class="search_item" name="search_delivery_area" placeholder="<?php echo esc_html__('Search Location', 'reserving'); ?>" value="<?php echo esc_attr($delivery_area); ?>" onkeyup="reservingSearchDeliveryAreas(this.value)">
            <input type="hidden" class="item_value" name="item_value" value="<?php echo esc_attr($area_id); ?>">
            <ul class="delivery_areas">
                <?php echo reserving_kses($this->render_delivery_area_list()); ?>
            </ul>
        </div>
    </div>
    <br>
    <p><?php echo esc_html(reserving_text_setting_option('reserving_delivery_date_label', esc_html__('Delivery Date:', 'reserving'))); ?></p>
    <input type="date" name="delivery_date" min="<?php echo esc_attr(gmdate('Y-m-d')); ?>" class="delivery_date" value="<?php echo esc_attr($this->delivery_info['delivery_date']); ?>">
    <br>
    <p><?php echo esc_html(reserving_text_setting_option('reserving_delivery_time_label', esc_html__('Delivery Time:', 'reserving'))); ?></p>
    <div class="delivery_time">
        <?php echo reserving_kses($this->render_time_slots()); ?>
    </div>
    <br>
    <a href="#" class="btn start_order"><?php echo esc_html($update_info_btn_text); ?></a>
    <div class="message mt-20"></div>
</div>