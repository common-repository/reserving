<?php

namespace Reserving\extensions\frontend\shortcodes;

use Reserving\backend\pages\Orders;
use Reserving\extensions\frontend\shortcodes\frontend_dashboard\BranchManager;
use Reserving\extensions\frontend\shortcodes\frontend_dashboard\DeliveryMan;
use Reserving\extensions\frontend\shortcodes\frontend_dashboard\KitchenManager;

/**
 * Frontend_Dashboard class
 *
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */
class Frontend_Dashboard extends Orders
{
    public $kitchen_manager;
    public $branch_manager;
    public $delivey_man;

    public function register()
    {

        $this->branch_manager   = new BranchManager();
        $this->kitchen_manager  = new KitchenManager();
        $this->delivey_man      = new DeliveryMan();

        add_filter('show_admin_bar', [$this, '_admin_bar'], 100);
        add_filter('login_redirect', [$this, 'login_redirect'], 10, 3);
        add_action('template_redirect', [$this, 'template_redirect'], 10, 3);

        add_filter('login_form_bottom', [$this, 'login_form_bottom'], 10, 2);
        add_action('wp_login_failed', [$this, 'wp_login_failed'], 10, 2);
        add_action('init', [$this, 'session_start']);
        add_shortcode('reserving_frontend_dashboard', [$this, 'generate_frontend_dashboard']);
    }

    public function login_form_bottom($html, $args)
    {

        if (isset($args['form_id']) && $args['form_id'] == 'reserving_at_custom_form') {
            return $html . '<div class="reserving-custom-input-field"><input type="hidden" name="reserving_custom_form" value="1" /></div>';
        }
        return $html;
    }
    public function session_start()
    {

        if (!session_id()) {
            session_start(['read_and_close' => true]);
        }
    }
    public function wp_login_failed($username, $error)
    {

        $_SESSION['book_at_login_error'] = $error->get_error_message();

        if (isset($_REQUEST['reserving_custom_form'])) {
            wp_redirect(wp_get_referer());
            exit;
        }
    }
    public function _admin_bar($default)
    {

        $user = wp_get_current_user();
        $allowed_roles = array('editor', 'administrator');
        if (array_intersect($allowed_roles, $user->roles)) {
        }

        return $default;
    }
    public function template_redirect($location)
    {

        $when_login = reserving_setting_option('reserving_front_redirect_login_when_login', 0);

        if (!$when_login) {
            return;
        }

        if (
            is_user_logged_in() && (
                current_user_can('branch_manager') ||
                current_user_can('kitchen_manager') ||
                current_user_can('delivery_man')
            )
        ) {
            $page_id = reserving_setting_option('reserving_frontend_dashboard_url');
            $login_page_id   = reserving_setting_option('reserving_frontend_dashboard_login_url');

            if (is_numeric($page_id) && is_numeric($login_page_id)) {

                if (get_the_id() == $login_page_id) {
                    wp_redirect(esc_url(get_the_permalink($page_id)));
                    exit();
                }
            }
        }
    }
    public function generate_frontend_dashboard($atts)
    {
        ob_start();
        wp_enqueue_script('reserving_frontend_main_js');

        $page_id                  = reserving_setting_option('reserving_frontend_dashboard_url');
        $button_text              = reserving_text_setting_option('reserving_frontend_login_button_text', 'Login');
        $login_button_msg         = reserving_text_setting_option('reserving_frontend_login_button_msg', 'Login as branch manager');

        $show_login_form          = reserving_setting_option('reserving_front_dash_login_form_show');
        $frontend_dashboard_page  = get_the_permalink(intval($page_id));
        $site_url = site_url();
        $login_page_id            = reserving_setting_option('reserving_frontend_dashboard_login_url');

        if (intval($login_page_id)) {
            $default_login = get_the_permalink(intval($login_page_id));
        } else {
            $default_login = $site_url . '/wp-login.php';
        }

        if ($button_text == '') {
            $button_text = esc_html__('Login', 'reserving');
        }

        $atts = shortcode_atts([
            'default_login'    => esc_url($default_login),
            'login_button_msg' => esc_html($login_button_msg),
            'button_text'      => esc_html($button_text),
            'show_login_form'  => esc_html($show_login_form),
            'page_builder'     => false
        ], $atts);

        extract($atts);

        if ($default_login == '') {
            $default_login = $site_url . '/wp-login.php';
        }

        $default_login  = add_query_arg(array(
            'redirect_to' => $frontend_dashboard_page
        ), $default_login);

        $pass = true;
        if ($login_page_id == get_the_id()) {
            $pass = false;
        }

        // render
        if (current_user_can('branch_manager') && $pass) {
            $this->branch_manager->render_page();
        } else if (current_user_can('kitchen_manager') && $pass) {
            $this->kitchen_manager->render_page();
        } else if (current_user_can('delivery_man') && $pass) {
            $this->delivey_man->render_page();
        } else {

            echo '<div class="reserving-frontend-dashboard-wrapper text-center">';

            if ($login_button_msg != '') {
                echo wp_kses_post(sprintf("<p>%s</p>", esc_html($login_button_msg)));
            }

            if ($show_login_form) {
                $args = array(
                    'echo'            => true,
                    'redirect'        => esc_url($frontend_dashboard_page),
                    'remember'        => false,
                    'value_remember'  => false,
                    'label_log_in'    => esc_html($button_text),
                    'form_id'        => 'reserving_at_custom_form',
                );

                wp_login_form($args);
            } else {
                echo wp_kses_post(sprintf("<a href='%s'>%s</a>", esc_url($default_login), esc_html($button_text)));
            }

            echo '</div>';
        }

        $schema_content = ob_get_clean();
        return $schema_content;
    }

    function login_redirect($redirect_to, $request, $user)
    {
        if (!isset($user->roles)) {
            return $redirect_to;
        }

        $page_id                 = reserving_setting_option('reserving_frontend_dashboard_url');
        $frontend_dashboard_page = get_the_permalink(intval($page_id));

        if (in_array('branch_manager', $user->roles) || in_array('kitchen_manager', $user->roles) || in_array('delivery_man', $user->roles)) {
            $redirect_to = $frontend_dashboard_page;
        }

        return $redirect_to;
    }
}
