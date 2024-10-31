<?php

namespace Reserving\extensions\frontend\assets;

class Frontend
{
    public function register()
    {
        add_action('wp_enqueue_scripts', [$this, 'register_scripts']);
    }

    /**
     *  Register scripts and styles
     */
    public function register_scripts()
    {

        $assets  = reserving_app()->get('configs-assets');
        $styles  = $assets['css'];
        $scripts = $assets['js'];

        foreach ($styles as  $style) {

            if (isset($style['public']) && $style['public']) {

                $src = $style['src'];

                // if (isset($style['path']) && reserving_app_is_not_running_on_server()) {
                //     if (file_exists(reserving_option_fix_path($style['path']))) {
                //         $src =  $style['min-src'];
                //     }
                // }

                wp_register_style(
                    $style['handle_name'],
                    esc_url($src),
                    $style['deps'],
                    time(),
                    $style['media']
                );
            }
        }

        foreach ($scripts as $script) {

            if (isset($script['public']) && $script['public']) {
                $src = $script['src'];

                if (isset($script['path']) && reserving_app_is_not_running_on_server()) {
                    if (file_exists(reserving_option_fix_path($script['path']))) {
                        $src = $script['min-src'];
                    }
                }
                wp_register_script(
                    $script['handle_name'],
                    esc_url($src),
                    $script['deps'],
                    time(),
                    $script['in_footer']
                );
            }
        }

        wp_localize_script('reserving_frontend_main_js', 'ReservingData', array(
            'ajax_url'        => esc_url(admin_url('admin-ajax.php')),
            'site_url'        => site_url(),
            'nonce'           => wp_create_nonce('security_check'),
            'currency_symbol' => wp_kses_post(get_woocommerce_currency_symbol())
        ));

        wp_localize_script('reserving_frontend_tab_js', 'reserving_data', array(
            'ajax_url'           => esc_url(admin_url('admin-ajax.php')),
            'site_url'           => site_url(),
            'option_tab_default' => esc_html(reserving_setting_option('default_form_tab_active'))
        ));
    }
}
