<?php

namespace Reserving\extensions\frontend\shortcodes\frontend_dashboard;

use Reserving\extensions\frontend\shortcodes\Frontend_Dashboard;

/**
 * Branch Manager class
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */
class BranchManager extends Frontend_Dashboard
{
    public $branch_order_count = [];

    public function render_page()
    {
        $this->branch_order_count = array(
            'rsv-new-order'  => 0,
            'reserving-cooking'    => 0,
            'cooking-completed' => 0,
            'on-the-way'        => 0,
            'completed'         => 0,
            'processing'        => 0,
            'pending'           => 0,
            'on-hold'           => 0,
            'cancelled'         => 0,
            'checkout-draft'    => 0,
        );

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
                <div class="reserving-user-wrapper">
                    <h3 class="reserving-manager-name">
                        <label>
                            <?php
                            echo esc_html__('Welcome Back ', 'reserving');
                            if ($username_show):
                            ?>
                                <span>
                                    <?php
                                    $current_user = wp_get_current_user();
                                    echo wp_kses_post($current_user->display_name);
                                    ?>
                                </span>
                            <?php
                            endif; ?>
                        </label>
                    </h3>
                    <?php
                    $sub_heading = reserving_text_setting_option('reserving_frontend_dash_sub_haeding', '');
                    echo wp_kses_post(wpautop($sub_heading));
                    ?>
                </div>

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
            require_once __DIR__ . '/views/branch_manager/order_table.php';
            require_once __DIR__ . '/views/branch_manager/order_details.php';
            ?>
        </div>
<?php
    }
    public function get_orders_list()
    {

        $args = array(
            'status'        => ['rsv-new-order', 'reserving-cooking', 'cooking-completed', 'on-the-way', 'completed', 'cancelled', 'on-hold', 'pending'], // Branch manager order permissions action
            'return'        => 'objects'
        );





        if ('multi_branch' ==  $this->get_branch_option()) {

            $branch_args = array(
                'post_type'    => 'reserving-branches',
                'meta_key'     => 'reserving_branch_manager',
                'meta_value'   => 'user_id_' . get_current_user_id(),
                'meta_compare' => '='
            );

            $branch    = get_posts($branch_args);
            $branch_id = 0;

            $args['limit'] = -1;

            if (isset($branch[0])) {
                $branch_id            = $branch[0]->ID;
                $args['meta_key']     = "reserving_branch";
                $args['meta_value']   = $branch_id;
                $args['meta_compare'] = '=';
            }
        }

        $orders = wc_get_orders($args);
        $list   = "";


        if (!empty($orders)) {
            foreach ($orders as $key => $order) {
                switch ($order->get_status()) {
                    case 'reserving-cooking':
                        $order_status = 'Cooking Processing';
                        $this->branch_order_count[$order->get_status()]++;
                        break;

                    case 'cooking-completed':
                        $order_status = 'Cooking Completed';
                        $this->branch_order_count[$order->get_status()]++;
                        break;

                    default:
                        $order_status = reserving_get_order_status($order->get_status());
                        $this->branch_order_count[$order->get_status()]++;
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
                        $list .= "<td>N/A</td>";
                    }
                }
                $list .= "<td>";

                if (isset($order_info['delivery_date'])) {
                    $list .= date_format(date_create($order_info['delivery_date']), 'F j, Y');
                    if (isset($order_info['delivery_time'])) {
                        $time = ('12hours' == $this->get_time_format()) ? gmdate('h:i A', strtotime($order_info['delivery_time'])) : $order_info['delivery_time'];
                        $list .= ' -- ' . $time;
                    }
                } else {
                    $list .= "N/A";
                }
                $list .= "</td>";

                if (reserving_setting_option('branch_manager_assign_delivery', 1)) {
                    $man_id = $order->get_meta('reserving_delivery_man');
                    $delivery_man_id = $man_id['id'] ?? 0;
                    $delivery_man = get_user_by('id', $delivery_man_id);
                    if (!empty($delivery_man)) {
                        $list .= sprintf("<td>%s <br> (%s)</td>", esc_html($delivery_man->display_name), esc_html($delivery_man->user_email));
                    } else {
                        $list .= "<td> N/A </td>";
                    }
                }

                $list .= sprintf("<td class='order-status-%s' data-status_key='%s'>%s</td>", esc_attr($order_id), esc_attr($order_status_key), esc_html($order_status));
                $list .= sprintf("<td><button id='%s' class='view_details'>%s</button></td>", esc_attr($order->get_id()), esc_html__('View Details', 'reserving'));
                $list .= "</tr>";
            }
        }

        return $list;
    }
}
