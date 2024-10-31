<?php

namespace Reserving\backend;

class Menu
{
    public $dashboard;
    public $orders;

    public function __construct()
    {
        $this->dashboard = new pages\Dashboard();
        $this->orders    = new pages\Orders();

        add_action('admin_menu', [$this, 'add_menu_pages']);
        add_action('init', [$this, 'create_pages']);
    }

    function create_pages()
    {
        $frontend_dashboard_page = array(
            'post_title'   => 'Reserving Frontend Dashboard',
            'post_content' => '[reserving_frontend_dashboard]',
            'post_status'  => 'publish',
            'post_author'  => 1,
            'post_type'    => 'page'
        );
        if (!$this->is_page_exists('reserving-frontend-dashboard')) {
            wp_insert_post($frontend_dashboard_page);
        }
    }

    function is_page_exists($slug)
    {
        global $wpdb;
        if ($wpdb->get_row("SELECT * FROM {$wpdb->prefix}posts WHERE post_name = '" . esc_sql($slug) . "'", 'ARRAY_A')) {
            return true;
        } else {
            return false;
        }
    }

    public function add_menu_pages()
    {
        $parent_slug = RESERVING_ROOT_PAGE;
        $capability = 'manage_options';

        add_menu_page(
            _x('Reserving', 'reserving'),
            _x('Reserving', 'reserving'),
            'manage_options',
            RESERVING_ROOT_PAGE,
            [$this->dashboard, 'render_page'],
            'dashicons-food',
            100
        );

        // Regular submenus
        $submenus = reserving_app()->get('configs-menus');




        foreach ($submenus as $menu) {
            add_submenu_page(
                $parent_slug,
                $menu['page_title'],
                $menu['menu_title'],
                $capability,
                $menu['menu_slug'],
                [$this->{$menu['instance']}, 'render_page']
            );
        }

        // Custom Post Type submenus  

        $branch_option       = reserving_setting_option('reserving_branch_option', 'multi_branch');
        $active_inrestaurant = reserving_setting_option('inrestaurant_activate', 1);

        if ('multi_branch' == $branch_option) {
            add_submenu_page(
                $parent_slug,
                _x('Branches', 'reserving'),
                _x('Branches', 'reserving'),
                $capability,
                esc_url(admin_url('edit.php?post_type=reserving-branches'))
            );
        }

        add_submenu_page(
            $parent_slug,
            _x('Delivery Areas', 'reserving'),
            _x('Delivery Areas', 'reserving'),
            $capability,
            esc_url(admin_url('edit-tags.php?taxonomy=reserving-delivery-area&post_type=reserving-branches'))
        );

        if ($active_inrestaurant) {
            add_submenu_page(
                $parent_slug,
                _x('Tables', 'reserving'),
                _x('Tables', 'reserving'),
                $capability,
                esc_url(admin_url('edit-tags.php?taxonomy=reserving-tables&post_type=reserving-branches'))
            );
        }
    }
}
