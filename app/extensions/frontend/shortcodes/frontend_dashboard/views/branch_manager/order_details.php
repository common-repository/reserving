<div class="wrap reserving-order-details-modal-wrap">
    <!-- The Modal -->
    <div id="reserving_order_details_modal" class="modal reserving--order--details--modal">
        <!-- Modal content -->
        <div class="modal-content reserving-modal-content">
            <span class="close reserving-modal-close">&times;</span>
            <div class="loader reserving-order-loader"></div>
            <div class="header reserving-order-header">
                <?php if (reserving_setting_option('branch_manager_print_order', 1)) { ?>
                    <button class="reserving_print_pdf" data-order_id="0" onclick="reservingPrintOrderPDF(this)"><?php _e('Print PDF', 'reserving'); ?></button>
                <?php } ?>
                <?php if (reserving_setting_option('reserving_checker_logo')) {
                    $logo = reserving_setting_option('reserving_checker_logo', '');
                    ?>
                        <img src='<?php echo esc_url($logo); ?>'>
                    <?php
                } else if (has_custom_logo()) {
                    the_custom_logo();
                } ?>
                <h3><?php bloginfo('title'); ?></h3>
            </div>
            <div class="order_details reserving--order--details">
                <p class="order_id reserving--order--id"></p>
                <div class="customer_info reserving--customer--info">
                    <div class="billing_info reserving--billings--info">
                        <!-- Billing Info will be generated here -->
                    </div>
                    <div class="shipping_info reserving-shipping--info">
                        <!-- Shipping Info will be generated here -->
                    </div>
                </div>

                <div class="delivery_info reserving--delivery--info">
                    <!-- Delivery Info will be generated here -->
                </div>
                <div class="reserving_order_action_btns">
                    <input type="hidden" id="order_id_input">
                    <?php if (reserving_setting_option('branch_manager_cancel_order', 1)) { ?>
                        <button data-order-status='cancelled'><?php _e('Cancel Order', 'reserving') ?> <span></span></button>
                    <?php } ?>

                    <?php if (reserving_setting_option('branch_manager_send_to_cook', 1)) { ?>
                        <button data-order-status='reserving-cooking'><?php _e('Send to Cook', 'reserving') ?><span></span></button>
                    <?php } ?>

                    <?php if (reserving_setting_option('branch_manager_cooking_complete', 1)) { ?>
                        <button data-order-status='cooking-completed'><?php _e('Cooking Completed', 'reserving') ?><span></span></button>
                    <?php } ?>

                    <?php if (reserving_setting_option('branch_manager_on_the_way', 1)) { ?>
                        <button data-order-status='on-the-way'><?php _e('On The Way', 'reserving') ?><span></span></button>
                    <?php } ?>

                    <?php if (reserving_setting_option('branch_manager_delivery_complete', 1)) { ?>
                        <button data-order-status='completed'><?php _e('Delivery Completed', 'reserving') ?><span></span></button>
                    <?php } ?>
                </div>

                <?php if (reserving_setting_option('branch_manager_assign_delivery', 1)) { ?>
                    <div class="assign_delivery">
                        <!-- Delivery men list will be generated here -->
                    </div>
                <?php } ?>
                <table class='display dataTable'>
                    <!-- Order items will be generated here -->
                </table>
                <hr>
                <div class="order_total">
                    <p class="shipping_total">
                        <!-- Shipping cost will be generated here -->
                    </p>
                    <p class="total">
                        <!-- Total cost will be generated here -->
                    </p>
                </div>
            </div>
        </div>
        <div class="pdf_section reserving-frontdash--pdf--section"></div>
    </div>
</div>