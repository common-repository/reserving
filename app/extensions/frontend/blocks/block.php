<?php

//Blocks
function reserving_register_block_register()
{

    if (! function_exists('register_block_type')) {
        return;
    }

    if (!file_exists(RESERVING_DIR_PATH . 'app/extensions/frontend/build/blocks')) {
        return;
    }

    $blocks = reserving_ready_get_dir_list('blocks');

    if (is_array($blocks)) {
        foreach ($blocks as $item) {

            $get_render_attr = reserving_get_block_attr($item, ['render_callback']);
            if (is_array($get_render_attr)) {
                register_block_type(RESERVING_DIR_PATH . 'app/extensions/frontend/build/blocks/' . $item, $get_render_attr);
            } else {
                register_block_type(RESERVING_DIR_PATH . 'app/extensions/frontend/build/blocks/' . $item);
            }
        }
    }
}

// Hook: Editor assets.
add_action('init', 'reserving_register_block_register');

function reserving_editor_block_enqueue()
{

    wp_enqueue_style('reserving_frontend_popup_style', esc_url(RESERVING_URL . 'assets/public/css/popup.css'));

    wp_enqueue_script('reserving_frontend_tab_js', esc_url(RESERVING_URL . 'assets/public/js/tab-content.js'), ['jquery']);
    wp_enqueue_script('reserving_frontend_main_js', apply_filters('reserving_frontend_main_src', esc_url(RESERVING_URL . 'assets/public/js/main.js')), ['jquery']);

    wp_localize_script('reserving_frontend_tab_js', 'reserving_data', array(
        'ajax_url'           => esc_url(admin_url('admin-ajax.php')),
        'site_url'           => site_url(),
        'option_tab_default' => esc_html(reserving_setting_option('default_form_tab_active'))
    ));

    wp_localize_script('reserving_frontend_main_js', 'ReservingData', array(
        'ajax_url'        => esc_url(admin_url('admin-ajax.php')),
        'site_url'        => site_url(),
        'currency_symbol' => wp_kses_post(get_woocommerce_currency_symbol())
    ));
}
add_action('enqueue_block_editor_assets', 'reserving_editor_block_enqueue', 500);
