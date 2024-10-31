<?php

namespace Reserving\backend\pages;

class Orders extends \Reserving\base\Common
{

    public $order_count;
    public function __construct()
    {
        if (!class_exists('WooCommerce')) {
            return;
        }

        $this->order_count = array(
            'rsv-new-order' => 0,
            'reserving-cooking'   => 0,
            'cooking-completed'   => 0,
            'on-the-way'          => 0,
            'completed'           => 0,
            'processing'          => 0,
            'pending'             => 0,
            'on-hold'             => 0,
            'cancelled'           => 0,
            'all'                 => 0,
            'checkout-draft'      => 0,
        );

        add_action('wp_ajax_view_order_details', [$this, 'view_order_details']);

        add_action('wp_ajax_print_order_pdf', [$this, 'print_order_pdf']);
        add_action('wp_ajax_nopriv_print_order_pdf', [$this, 'print_order_pdf']);

        add_action('wp_ajax_assign_delivery_man', [$this, 'assign_delivery_man']);

        add_action('wp_ajax_update_order_status', [$this, 'update_order_status']);

        add_action('init', [$this, 'register_order_statuses']);
        add_action('init', [$this, 'set_order_counts']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_localize'], 500);
    }

    public function enqueue_localize()
    {
        reserving_localize_script();
    }

    public function render_page()
    {
        $this->enqueue_scripts();

        require_once __DIR__ . '/views/order/order_details.php';
        require_once __DIR__ . '/views/order/order_table.php';
    }

    public function enqueue_scripts()
    {

        wp_enqueue_style('reserving_jquery_datatable_style');
        wp_enqueue_style('reserving_datatable_style');
        wp_enqueue_style('reserving_printjs_style');
        wp_enqueue_script('reserving_js_pdf');
        wp_enqueue_script('reserving_juqery_datatable_js');
        wp_enqueue_script('reserving_admin_order_table_js');
        wp_enqueue_script('reserving_admin_order_details_js');

        wp_localize_script('reserving_admin_order_table_js', 'reserving_params', array(
            'ajax_url'        => esc_url(admin_url('admin-ajax.php')),
            'currency_symbol' => get_woocommerce_currency_symbol(),
            'loader'          => esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/loader-cart.svg'),
            'q'               => sanitize_text_field(isset($_GET['bat-search-q']) ? $_GET['bat-search-q'] : '')
        ));
    }

    public function print_order_pdf($order_id)
    {

        $order_id = sanitize_text_field(isset($_REQUEST['order_id']) ? intval($_REQUEST['order_id']) : 0);
        $order    = $this->load_order_details($order_id);
        $html     = '';
        ob_start();
        require_once __DIR__ . '/views/order/print_pdf.php';
        $html .= ob_get_clean();
        wp_send_json($html);
    }

    public function set_order_counts()
    {
        $orders = wc_get_orders(array(
            'numberposts' => -1,
            'orderby'     => 'date',
            'order'       => 'DESC'
        ));

        if (!empty($orders)) {

            $this->order_count['all'] = count($orders);

            foreach ($orders as $order) {
                if ($order->get_status() == 'pending') {
                    $order->update_status('rsv-new-order');
                }
                $this->order_count[$order->get_status()]++;
            }
        }
    }

    public function get_orders_list()
    {
        $orders = wc_get_orders(array(
            'limit' => -1,
            'orderby'     => 'id',
            'order'       => 'DESC'
        ));

        $list = '';

        if (!empty($orders)) {
            foreach ($orders as $key => $order) {
                switch ($order->get_status()) {
                    case 'completed':
                        $order_status = esc_html__('Delivery Completed', 'reserving');
                        break;
                    default:
                        $order_status = reserving_get_order_status($order->get_status());
                        break;
                }

                $order_id = $order->get_id();
                //$order_info = get_post_meta($order_id, 'reserving_delivery_info', true);
                $order_info = $order->get_meta('reserving_delivery_info');
                $list .= "<tr>";
                $list .= sprintf("<td>#%s</td>", esc_attr($order_id));
                $list .= sprintf("<td>%s</td>", esc_html(date_format($order->get_date_created(), 'F j, Y g:i A')));

                if ('multi_branch' ==  $this->get_branch_option()) {
                    if (isset($order_info['reserving_branch'])) {
                        $list .= sprintf("<td>%s</td>", esc_html(get_the_title($order_info['reserving_branch'])));
                    } else {
                        $list .= "<td>N/A</td>";
                    }
                }




                if (isset($order_info['delivery_date'])) {
                    $list .= sprintf(
                        "<td>%s</td>",
                        esc_html(date_format(date_create($order_info['delivery_date']), 'F j, Y g:i A'))
                    );
                } else if (isset($order_info['booking_date'])) {
                    $list .= sprintf(
                        "<td>%s</td>",
                        esc_html(date_format(date_create($order_info['booking_date']), 'F j, Y g:i A'))
                    );
                } else {
                    $list .= "<td>N/A</td>";
                }



                $man_id = $order->get_meta('reserving_delivery_man');

                $delivery_man_id = $man_id['id'] ?? 0;

                $delivery_man = get_user_by('id', $delivery_man_id);



                if (!empty($delivery_man)) {
                    $list .= sprintf("<td>%s <br> (%s)</td>", esc_html($delivery_man->display_name), esc_html($delivery_man->user_email));
                } else {
                    $list .= "<td>N/A</td>";
                }

                $list .= sprintf("<td data-type='%s' class='order-status-%s'>%s</td>", esc_attr($order->get_status()), esc_attr($order_id), esc_attr($order_status));
                $list .= sprintf("<td><button id='%s' class='view_details'>%s</button></td>", esc_attr($order->get_id()), esc_html__('View Details', 'reserving'));
                $list .= "</tr>";
            }
        }
        return $list;
    }

    public function view_order_details()
    {
        $data = $this->load_order_details(intval(sanitize_text_field($_REQUEST['id'])));
        wp_send_json($data);
    }

    public function load_order_details($order_id)
    {
        $order = wc_get_order($order_id);
        $data = $order->get_data();

        foreach ($order->get_items() as $item_id => $item) {
            $data['order_items'][$item_id]['product_id'] = $item->get_product_id();
            $data['order_items'][$item_id]['variation_id'] = $item->get_variation_id();
            $data['order_items'][$item_id]['product'] = $item->get_product();
            $data['order_items'][$item_id]['product_name'] = $item->get_name();
            $data['order_items'][$item_id]['product_price'] = $item->get_product()->get_price();
            $data['order_items'][$item_id]['quantity'] = $item->get_quantity();
            $data['order_items'][$item_id]['subtotal'] = $item->get_subtotal();
            $data['order_items'][$item_id]['total'] = $item->get_total();
            $data['order_items'][$item_id]['tax'] = $item->get_subtotal_tax();
            $data['order_items'][$item_id]['allmeta'] = $item->get_meta_data();
            $data['order_items'][$item_id]['product_type'] = $item->get_type();
        }

        $reserving_delivery_info = $order->get_meta('reserving_delivery_info');

        $delivery_men_ids = [];

        if (isset($reserving_delivery_info['delivery_type'])) {
            $data['reserving_delivery_info']['delivery_type'] = ucfirst($reserving_delivery_info['delivery_type']);
        }

        if (isset($reserving_delivery_info['reserving_branch'])) {
            $data['reserving_delivery_info']['reserving_branch'] = get_post(intval($reserving_delivery_info['reserving_branch']))->post_title;
            $delivery_men_ids = get_post_meta(intval($reserving_delivery_info['reserving_branch']), 'reserving_branch_delivery_men')[0];
        } else {
            $men_ids = get_users(array('role__in' => array('delivery_man'), 'fields' => array('id')));
            if (!empty($men_ids)) {
                foreach ($men_ids as $key => $man) {
                    $delivery_men_ids[] = $man->id;
                }
            }
        }

        if (isset($reserving_delivery_info['delivery_area'])) {
            $d_area = get_term_by('id', intval($reserving_delivery_info['delivery_area']), 'reserving-delivery-area');
            $data['reserving_delivery_info']['delivery_area'] = isset($d_area->name) ? $d_area->name : '';
        }

        if (isset($reserving_delivery_info['delivery_date'])) {
            $data['reserving_delivery_info']['delivery_date'] = date_format(date_create($reserving_delivery_info['delivery_date']), "F j, Y");
        }

        if (isset($reserving_delivery_info['delivery_time'])) {
            $data['reserving_delivery_info']['delivery_time'] = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($reserving_delivery_info['delivery_time'])) : $reserving_delivery_info['delivery_time'];
        }

        if (isset($reserving_delivery_info['reserving_tables'])) {
            foreach ($reserving_delivery_info['reserving_tables'] as $key => $table) {
                if (!$table) {
                    continue;
                }
                $data['reserving_delivery_info']['reserving_tables'][] = ['table_info' => get_term_by('id', intval($table), 'reserving-tables'), 'max_person' => get_term_meta(intval($table), 'reserving_tables_max_person', true)];
            }
        }

        if (isset($reserving_delivery_info['delivery_type']) && strtolower($reserving_delivery_info['delivery_type']) == 'in_restaurant') {
            if (isset($reserving_delivery_info['delivery_date'])) {
                $data['reserving_delivery_info']['booking_date'] = date_format(date_create($reserving_delivery_info['delivery_date']), "F j, Y");
            }

            if (isset($reserving_delivery_info['start_time'])) {
                $data['reserving_delivery_info']['start_time'] = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($reserving_delivery_info['start_time'])) : $reserving_delivery_info['start_time'];
            }

            if (isset($reserving_delivery_info['end_time'])) {
                $data['reserving_delivery_info']['end_time'] = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($reserving_delivery_info['end_time'])) : $reserving_delivery_info['end_time'];
            }
        }

        $delivery_men = [];
        if (!empty($delivery_men_ids)) {
            if (isset($reserving_delivery_info['reserving_branch'])) {
                foreach ($delivery_men_ids as $key => $value) {
                    $id = intval(str_replace('user_id_', '', $value['country']));
                    $delivery_men[] = get_user_by('id', $id);
                }
            } else {
                foreach ($delivery_men_ids as $key => $id) {
                    $delivery_men[] = get_user_by('id', $id);
                }
            }
        }

        $data['reserving_delivery_men'] = $delivery_men;

        return $data;
    }

    public function update_order_status()
    {
        $sanitize_id = intval(sanitize_text_field($_REQUEST['id']));
        $sanitize_status = sanitize_text_field($_REQUEST['status']);
        $order = wc_get_order($sanitize_id);
        $order->update_status($sanitize_status);
        $data = $order->get_data();
        $data['status_text'] = reserving_get_order_status($sanitize_status);

        // wp_send_json_success(wc_get_order_statuses());
        wp_send_json($data);
    }

    /**
     * Assign Delivery man
     */
    public function assign_delivery_man()
    {
        $order_id = intval(sanitize_text_field($_REQUEST['order_id']));
        $man_id = intval(sanitize_text_field($_REQUEST['man_id']));
        $order = wc_get_order($order_id);

        $order->update_meta_data('reserving_delivery_man', [
            'id' => $man_id,
            'name' => get_user_by('id', $man_id)
        ]);

        $order->update_meta_data('reserving_delivery_man_id', $man_id);

        $order->save();

        update_post_meta($order_id, 'reserving_delivery_man', $man_id);

        $delivery_man = [];
        foreach ($order->get_data()['meta_data'] as $key => $meta) {
            if ('reserving_delivery_man' == $meta->key) {
                $delivery_man = $meta->value['name'];
            }
        }
        wp_send_json($delivery_man);
    }

    /**
     * ==========================================
     * Add custom order statuses
     * ==========================================
     */
    // Register custom statuses to order status list
    public function register_order_statuses()
    {
        register_post_status('wc-rsv-new-order', array(
            'label'                     => esc_html__('New Order', 'reserving'),
            'public'                    => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list'    => true,
            'exclude_from_search'       => false,
            'label_count'               => _n_noop('New Order (%s)', 'New Order (%s)')
        ));

        register_post_status('wc-reserving-cooking', array(
            'label'                     => esc_html__('Cooking Processing', 'reserving'),
            'public'                    => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list'    => true,
            'exclude_from_search'       => false,
            'label_count'               => _n_noop('Cooking Processing (%s)', 'Cooking Processing (%s)')
        ));

        register_post_status('wc-cooking-completed', array(
            'label'                     => esc_html__('Cooking Completed', 'reserving'),
            'public'                    => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list'    => true,
            'exclude_from_search'       => false,
            'label_count'               => _n_noop('Cooking Completed (%s)', 'Cooking Completed (%s)')
        ));

        register_post_status('wc-on-the-way', array(
            'label'                     => esc_html__('On The Way', 'reserving'),
            'public'                    => true,
            'show_in_admin_status_list' => true,
            'show_in_admin_all_list'    => true,
            'exclude_from_search'       => false,
            'label_count'               => _n_noop('On The Way (%s)', 'On The Way (%s)')
        ));

        add_filter('wc_order_statuses', [$this, 'add_order_statuses']);
    }

    // Add custom statuses to order status list
    public function add_order_statuses($order_statuses)
    {
        $new_order_statuses = array();

        foreach ($order_statuses as $key => $status) {

            $new_order_statuses[$key] = $status;
            $new_order_statuses['wc-rsv-new-order'] = esc_html__('New Order', 'reserving');
            $new_order_statuses['wc-reserving-cooking'] = esc_html__('Cooking Processing', 'reserving');
            $new_order_statuses['wc-cooking-completed'] = esc_html__('Cooking Completed', 'reserving');
            $new_order_statuses['wc-on-the-way'] = esc_html__('On The Way', 'reserving');
        }
        return $new_order_statuses;
    }
}
