<?php

return [

    'css' => [
        [
            'handle_name' => 'slick',
            'src'         => esc_url(RESERVING_URL . 'assets/public/css/slick.min.css'),
            'deps'        => [],
            'media'       => 'all',
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        [
            'handle_name' => 'reserving_frontend_popup_style',
            'src'         => esc_url(RESERVING_URL . 'assets/public/css/popup.css'),
            'min-src'     => esc_url(RESERVING_URL . 'assets/public/css/popup.min.css'),
            'path'        => RESERVING_DIR_PATH . 'assets/public/css/popup.min.css',
            'deps'        => [],
            'media'       => 'all',
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        [
            'handle_name' => 'reserving_frontend_cart_style',
            'src'         => esc_url(RESERVING_URL . 'assets/public/css/cart.css'),
            'min-src'     => esc_url(RESERVING_URL . 'assets/public/css/cart.min.css'),
            'path'        => RESERVING_DIR_PATH . 'assets/public/css/cart.min.css',
            'deps'        => [],
            'media'       => 'all',
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        [
            'handle_name' => 'reserving_frontend_tabs_style',
            'src'         => RESERVING_URL . 'assets/public/css/tab.css',
            'min-src'     => RESERVING_URL . 'assets/public/css/tab.min.css',
            'path'        => RESERVING_DIR_PATH . 'assets/public/css/tab.min.css',
            'deps'        => [],
            'media'       => 'all',
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        [
            'handle_name' => 'reserving_product_grid_style',
            'src'         => RESERVING_URL . 'assets/public/css/product-grid.css',
            'min-src'     => RESERVING_URL . 'assets/public/css/product-grid.min.css',
            'path'        => RESERVING_DIR_PATH . 'assets/public/css/product-grid.min.css',
            'deps'        => [],
            'media'       => 'all',
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        [
            'handle_name' => 'reserving_product_extra_items_style',
            'src'         => RESERVING_URL . 'assets/public/css/product-extra-items.css',
            'min-src'     => RESERVING_URL . 'assets/public/css/product-extra-items.min.css',
            'path'        => RESERVING_DIR_PATH . 'assets/public/css/product-extra-items.min.css',
            'deps'        => [],
            'media'       => 'all',
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        [
            'handle_name' => 'reserving_jquery_datatable_style',
            'src'         => RESERVING_URL.'assets/backend/css/jquery.dataTables.min.css',
            'deps'        => [],
            'media'       => 'all',
            'minimize'    => false,
            'public'      => true,
            'admin'       => true
        ],
        [
            'handle_name' => 'reserving_datatable_style',
            'src'         => RESERVING_URL . 'assets/public/css/data-table.css',
            'min-src'     => RESERVING_URL . 'assets/public/css/data-table.min.css',
            'deps'        => [],
            'media'       => 'all',
            'minimize'    => false,
            'public'      => true,
            'admin'       => true
        ],
        [
            'handle_name' => 'reserving_printjs_style',
            'src'         => RESERVING_URL . 'assets/public/css/printjs.min.css',
            'deps'        => [],
            'media'       => 'all',
            'minimize'    => false,
            'public'      => true,
            'admin'       => true
        ]
       
    ],

    'js' => [
        [
            'handle_name' => 'slick',
            'src'         => RESERVING_URL . 'assets/public/js/slick.min.js',
            'deps'        => [],
            'in_footer'   => true,
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        [
            'handle_name' => 'ele-slick',
            'src'         => RESERVING_URL . 'assets/public/js/ele-slick.js',
            'min-src'     => RESERVING_URL . 'assets/public/js/ele-slick.min.js',
            'path'        => RESERVING_DIR_PATH . 'assets/public/js/ele-slick.min.js',
            'deps'        => ['slick'],
            'in_footer'   => true,
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        [
            'handle_name' => 'reserving_js_pdf',
            'src'         => RESERVING_URL . 'assets/public/js/printjs.min.js',
            'deps'        => [],
            'in_footer'   => true,
            'minimize'    => false,
            'public'      => true,
            'admin'       => true
        ],
        [
            'handle_name' => 'reserving_frontend_main_js',
            'src'         =>  apply_filters('reserving_frontend_main_src', RESERVING_URL . 'assets/public/js/main.js'),
            'min-src'     =>  apply_filters('reserving_frontend_main_src', RESERVING_URL . 'assets/public/js/main.min.js'),
            'path'        =>  apply_filters('reserving_frontend_main_src', RESERVING_DIR_PATH . 'assets/public/js/main.min.js'),
            'deps'        =>  apply_filters('reserving_frontend_main_deps',[ 'jquery', 'reserving_js_pdf' ]),
            'in_footer'   => true,
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        [
            'handle_name' => 'reserving_frontend_tab_js',
            'src'         => RESERVING_URL . 'assets/public/js/tab-content.js',
            'min-src'     => RESERVING_URL . 'assets/public/js/tab-content.min.js',
            'path'        => RESERVING_DIR_PATH . 'assets/public/js/tab-content.min.js',
            'deps'        => [ 'jquery' ],
            'in_footer'   => true,
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        [
            'handle_name' => 'reserving_frontend_single_product',
            'src'         => RESERVING_URL . 'assets/public/js/single-product.js',
            'min-src'     => RESERVING_URL . 'assets/public/js/single-product.min.js',
            'path'        => RESERVING_DIR_PATH . 'assets/public/js/single-product.min.js',
            'deps'        => [ 'jquery' ],
            'in_footer'   => true,
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        
        [
            'handle_name' => 'reserving_product_grid_js',
            'src'         => RESERVING_URL . 'assets/public/js/product-grid.js',
            'min-src'     => RESERVING_URL . 'assets/public/js/product-grid.min.js',
            'path'        => RESERVING_DIR_PATH . 'assets/public/js/product-grid.min.js',
            'deps'        => [ 'jquery' ],
            'in_footer'   => true,
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        [
            'handle_name' => 'reserving_update_cart_item',
            'src'         => RESERVING_URL . 'assets/public/js/update-cart-item-ajax.js',
            'min-src'     => RESERVING_URL . 'assets/public/js/update-cart-item-ajax.min.js',
            'path'        => RESERVING_DIR_PATH . 'assets/public/js/update-cart-item-ajax.min.js',
            'deps'        => [ 'jquery-blockui' ],
            'in_footer'   => true,
            'minimize'    => false,
            'public'      => true,
            'admin'       => false
        ],
        [
            'handle_name' => 'reserving_juqery_datatable_js',
            'src'         => RESERVING_URL.'assets/backend/js/jquery.dataTables.min.js',
            'deps'        => [ 'jquery' ],
            'in_footer'   => true,
            'minimize'    => false,
            'public'      => true,
            'admin'       => true
        ],
        [
            'handle_name' => 'reserving_admin_order_table_js',
            'src'         => RESERVING_URL . 'assets/backend/js/order-table.js',
            'min-src'     => RESERVING_URL . 'assets/backend/js/order-table.min.js',
            'path'        => RESERVING_DIR_PATH . 'assets/backend/js/order-table.min.js',
            'deps'        => [ 'jquery', 'reserving_juqery_datatable_js' ],
            'in_footer'   => true,
            'minimize'    => false,
            'public'      => true,
            'admin'       => true
        ],
        [
            'handle_name' => 'reserving-dashboard-order-table',
            'src'         => RESERVING_URL . 'assets/backend/js/dashboard-table.js',
            'min-src'     => RESERVING_URL . 'assets/backend/js/dashboard-table.min.js',
            'path'        => RESERVING_DIR_PATH . 'assets/backend/js/dashboard-table.min.js',
            'deps'        => [ 'jquery', 'wp-lists', 'jquery-ui-sortable' ,'reserving_juqery_datatable_js' ],
            'in_footer'   => true,
            'minimize'    => false,
            'public'      => true,
            'admin'       => true
        ],
        [
            'handle_name' => 'reserving_admin_order_details_js',
            'src'         => RESERVING_URL . 'assets/backend/js/order-details.js',
            'min-src'     => RESERVING_URL . 'assets/backend/js/order-details.min.js',
            'path'        => RESERVING_DIR_PATH . 'assets/backend/js/order-details.min.js',
            'deps'        => [ 'jquery', 'reserving_juqery_datatable_js' ],
            'in_footer'   => true,
            'minimize'    => false,
            'public'      => true,
            'admin'       => true
        ],
    ]
    
];
