<?php

namespace Reserving\extensions\frontend\shortcodes\frontend_dashboard;

use Reserving\extensions\frontend\shortcodes\Frontend_Dashboard;

/**
 * DeliveryMan class
 *
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */
class DeliveryMan extends Frontend_Dashboard
{
    public $completed_order = 0;
    public $on_the_way_order = 0;

    public function render_page()
    {
        $this->enqueue_scripts();

        $site_url         = site_url();
        $login_page_id    = reserving_setting_option('reserving_frontend_dashboard_login_url');
        $logout_link_show = reserving_setting_option('reserving_front_dash_logout_link', 0);
        $username_show    = reserving_setting_option('reserving_front_dash_username', 1);

        if (intval($login_page_id)) {
            $default_login = get_the_permalink(intval($login_page_id));
        } else {
            $default_login = $site_url . '/wp-login.php';
        }

?>
        <div class="reserving-main-content-wrapper-wrapper">
            <div class="reserving-fdash-heading-wrapper">
                <?php if ($username_show): ?>
                    <div class="reserving-user-wrapper">
                        <h3 class="reserving-manager-name">
                            <label>
                                <?php
                                _e('Welcome Back ', 'reserving');
                                if ($username_show): ?>
                                    <span>
                                        <?php
                                        $current_user = wp_get_current_user();
                                        echo esc_html($current_user->display_name);
                                        ?>
                                    </span>
                                <?php
                                endif;
                                ?>
                            </label>
                        </h3>
                        <?php
                        $sub_heading = reserving_text_setting_option('reserving_frontend_dash_sub_haeding', '');
                        echo wp_kses_post(wpautop($sub_heading));
                        ?>
                    </div>
                <?php endif; ?>
                <?php
                if ($logout_link_show):
                    echo wp_kses_post(sprintf(
                        "<div class='reserving-logout'><a href='%s'>%s</a> </div>",
                        esc_url(wp_logout_url($default_login)),
                        esc_html__('Logout', 'reserving')
                    ));
                endif;
                ?>
            </div>
            <?php
            require_once __DIR__ . '/views/delivery_man/order_table.php';
            require_once __DIR__ . '/views/delivery_man/order_details.php';
            ?>
        </div>
<?php
    }

    public function get_orders_list()
    {

        $args = array(
            'status'        => ['completed', 'rsv-new-order', 'reserving-cooking', 'cooking-completed', 'on-the-way',  'pending', 'processing',],
            'meta_key'      => 'reserving_delivery_man_id',
            'meta_value'    => get_current_user_id(),
            'meta_compare'  => '=',
            'return'        => 'objects'
        );

        $orders = wc_get_orders($args);

        $list   = "";


        if (!empty($orders)) {
            foreach ($orders as $key => $order) {
                switch ($order->get_status()) {
                    case 'completed':
                        $order_status = 'Delivery Completed';
                        $this->completed_order++;
                        break;
                    case 'on-the-way':
                        $order_status = 'On The Way';
                        $this->on_the_way_order++;
                        break;
                    default:
                        $order_status = reserving_get_order_status($order->get_status());
                        break;
                }
                $order_status_key = $order->get_status();
                $order_id = $order->get_id();
                $order_info = $order->get_meta('reserving_delivery_info');
                $list .= "<tr>";
                $list .= sprintf("<td>#%s</td>", esc_attr($order_id));
                $list .= "<td>" . date_format($order->get_date_created(), 'F j, Y g:i A') . "</td>";
                if ('multi_branch' == $this->get_branch_option()) {
                    if (isset($order_info['reserving_branch'])) {
                        $list .= sprintf("<td>%s</td>", esc_html(get_the_title($order_info['reserving_branch'])));
                    } else {
                        $list .= "<td> N/A </td>";
                    }
                }
                $list .= '<td>';
                if (isset($order_info['delivery_date'])) {
                    $list .= date_format(date_create($order_info['delivery_date']), 'F j, Y');
                    if (isset($order_info['delivery_time'])) {
                        $time = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($order_info['delivery_time'])) : $order_info['delivery_time'];
                        $list .= ' -- ' . $time;
                    }
                } else {
                    $list .= 'N/A';
                }
                $list .= '</td>';
                $list .= sprintf("<td class='order-status-%s' data-status_key='%s'>%s</td>", esc_attr($order_id), esc_attr($order_status_key), esc_html($order_status));
                $list .= sprintf("<td><button id='%s' class='view_details'>%s</button></td>", esc_attr($order->get_id()), esc_html__('View Details', 'reserving'));
                $list .= '</tr>';
            }
        }
        return $list;
    }
}
