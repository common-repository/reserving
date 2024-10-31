<?php

namespace Reserving\backend;

class Assets
{
    public function __construct()
    {
        add_action('admin_enqueue_scripts', [$this, 'register_scripts']);
    }

    /**
     *  Register scripts and styles
     */
    public function register_scripts()
    {
        $assets = reserving_app()->get('configs-assets');
        $styles = $assets['css'];
        $scripts = $assets['js'];

        foreach ($styles as  $style) {
            if (isset($style['admin']) && $style['admin']) {

                $src = $style['src'];
                if (isset($style['path']) && reserving_app_is_not_running_on_server()) {
                    if (file_exists(reserving_option_fix_path($style['path']))) {
                        $src =  $style['min-src'];
                    }
                }

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
            if (isset($script['admin']) && $script['admin']) {

                $src = $script['src'];
                if (isset($script['path']) && reserving_app_is_not_running_on_server()) {
                    if (file_exists(reserving_option_fix_path($script['path']))) {
                        $src =  $script['min-src'];
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
    }
}
