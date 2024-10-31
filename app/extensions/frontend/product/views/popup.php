<div id="product_quick_view_form" class="modal reserving--product--quick--view--sec">
    <!-- Modal content -->
    <?php $view = reserving_setting_option('reserving_quick_view_extra_item',0); ?>
    <div class="modal-content <?php echo esc_attr($view?'reserving-extra--item':'') ?>">
        <span class="close">&times;</span>
        <div class="reserving-product">
        </div>
    </div>
</div>