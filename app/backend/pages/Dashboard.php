<?php

namespace Reserving\backend\pages;

class Dashboard extends \Reserving\base\Common
{
    public function __construct()
    {
        if (!class_exists('WooCommerce')) {
            return;
        }

        add_action('admin_enqueue_scripts', [$this, 'dashboard_inline_style'], 12);
        add_action('wp_ajax_reserving_dashboard_report_card_sorting', [$this, 'dashboard_report_card_sorting']);
    }
    public function dashboard_report_card_sorting()
    {

        if (!isset($_POST['reserving-dashboard-card-sorted-element']) || !isset($_POST['option'])) {
            $error = new \WP_Error('data_missing', __('Required Data Not Found', 'reserving'));
            wp_send_json_error($error);
        }
        //https://wp-kama.com/plugin/woocommerce/function/wc_clean
        update_option('reserving_sorted_cards', wc_clean($_POST['reserving-dashboard-card-sorted-element']));
        wp_send_json_success(['option_name' => get_option('reserving_sorted_cards')], 200);
        wp_die();
    }
    public function render_page()
    {
        if (!class_exists('WooCommerce')) {
            return;
        }

        wp_enqueue_script('reserving-dashboard-order-table');
        wp_localize_script('reserving-dashboard-order-table', 'reserving_obj', array(
            'ajaxurl' => esc_url_raw(admin_url('admin-ajax.php'))
        ));

        // Inline css 
        $dash_path = apply_filters('reserving_dashboard_path', __DIR__ . '/views/dashboard/dashboard.php');
        require_once $dash_path;
    }
    public function dashboard_inline_style()
    {

        $sorted_element = get_option('reserving_sorted_cards');

        if (!is_array($sorted_element)) {
            return;
        }

        $custom_css = '';

        foreach ($sorted_element as $order => $cls) {

            if (isset($cls[0])) {
                $custom_css .= "
                .{$cls[0]}{
                    order: -{$order};
                }";
            }
        }

        wp_add_inline_style('reserving-dashboard-settings', $custom_css);
    }
    public function get_user_edit_url($args)
    {
        return add_query_arg($args, admin_url('user-edit.php'));
    }
    public function get_wc_page_url($args)
    {
        return add_query_arg($args, menu_page_url('wc-admin', false));
    }
    public function get_order_page_url($args)
    {
        return add_query_arg($args, menu_page_url('reserving-at-orders', false));
    }

    public function get_customer_total_order($status, $user_id = 0)
    {

        $deliveryman_orders = get_posts(array(
            'numberposts' => -1,
            'meta_key'    => 'reserving_delivery_man',
            'meta_value'  => $user_id,
            'post_type'   => array('shop_order'),
            'post_status' => $status
        ));

        return count($deliveryman_orders);
    }

    public function get_orders_count($order_status = 'all')
    {
        $args = array(
            'numberposts' => -1
        );

        if ($order_status != 'all') {
            $args['status'] = [$order_status];
        }

        $orders = wc_get_orders($args);

        return count($orders);
    }

    public function get_last_24_h_orders_count($order_status = 'all')
    {
        $args = array(
            'numberposts' => -1,
            'date_created' => '>' . (time() - DAY_IN_SECONDS)
        );

        if ($order_status != 'all') {
            $args['status'] = [$order_status];
        }

        $orders = wc_get_orders($args);
        return count($orders);
    }

    public function get_todays_pending_orders()
    {
        $args = array(
            'numberposts' => -1,
            'date_created' => '>' . (time() - (1 * DAY_IN_SECONDS)),
        );

        $args['status'] = [
            'rsv-new-order',
            'reserving-cooking',
            'cooking-completed',
            'on-the-way',
            'processing',
            'pending',
            'processing',
        ];

        $orders = wc_get_orders($args);
        return [$orders, count($orders)];
    }

    public function get_last_48_h_orders_count($order_status = 'all')
    {
        $args = array(
            'numberposts' => -1,
            'date_created' => '>' . (time() - (2 * DAY_IN_SECONDS)),
        );

        if ($order_status != 'all') {
            $args['status'] = [$order_status];
        }

        $orders = wc_get_orders($args);
        return count($orders);
    }

    public function get_percentage_by_status($status)
    {
        $last_24 = $this->get_last_24_h_orders_count($status);
        $last_48 = $this->get_last_48_h_orders_count($status);
        return reserving_percentage_change($last_48, $last_24);
    }

    public function get_customer_percentage()
    {

        $last_24 = $this->get_total_customers_by_date();
        $old = $this->get_total_customers();

        return reserving_percentage_change($old, $last_24);
    }

    public function get_total_branches()
    {
        $branches = get_posts(array(
            'post_type' => 'reserving-branches',
            'numberposts' => -1
        ));

        return count($branches);
    }

    public function get_branche_name_user_id($user_id)
    {

        $branch = get_posts(array(
            'post_type' => 'reserving-branches',
            'meta_key'    => 'reserving_branch_manager',
            'meta_value'  => 'user_id_' . $user_id,
        ));

        if (!is_array($branch)) {
            return '';
        }

        return isset($branch[0]->post_title) ? $branch[0]->post_title : '';
    }

    public function get_total_delivery_area()
    {
        $areas = get_terms('reserving-delivery-area', array("hide_empty" => false));
        return count($areas);
    }

    public function get_total_customers()
    {
        $args = array(
            'role'       => 'customer',
            'number'     => -1,
        );

        $user_query = new \WP_User_Query($args);
        $total = $user_query->get_total();

        return is_numeric($total) ? $total : 0;
    }

    public function get_delivery_men()
    {
        $args = array(
            'role'    => 'delivery_man',
            'number'  => -1
        );

        $user_query = new \WP_User_Query($args);
        $total      = $user_query->get_total();
        $total      = is_numeric($total) ? $total : 0;

        return [$user_query, $total];
    }

    public function get_branch_managers()
    {
        $args = array(
            'role'   => 'branch_manager',
            'number' => -1
        );

        //reserving_branch_manager
        $user_query = new \WP_User_Query($args);
        $total      = $user_query->get_total();
        $total      = is_numeric($total) ? $total : 0;

        return [$user_query, $total];
    }

    public function get_kitchen_managers()
    {
        $args = array(
            'role'   => 'kitchen_manager',
            'number' => -1
        );

        $user_query = new \WP_User_Query($args);
        $total      = $user_query->get_total();
        $total      = is_numeric($total) ? $total : 0;

        return [$user_query, $total];
    }

    public function get_total_customers_by_date()
    {

        $args = array(
            'role'       => 'customer',
            'number'     => -1,
            'date_query' => array(
                ['after'  => 'today', 'inclusive' => true],
            )
        );

        $user_query = new \WP_User_Query($args);
        $total      = $user_query->get_total();
        return is_numeric($total) ? $total : 0;
    }
}
