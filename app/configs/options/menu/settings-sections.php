<?php

$branch_option = reserving_setting_option('reserving_branch_option', 'multi_branch');
$tabs = [];

/**
 * =====================================
 * General Section
 * =====================================
 */
$tabs['general'] = array(
    'title'     => 'General',
    'id'        => 'general',
    'icon'      => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/gen.svg',
    'content_bg' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/gen-bg.svg',
    'priority'    => 1,
    'option_heading' => 'column',
    'fields'    => array(
        
        'reserving_branch_option' => array(
            'title'  => 'Branch Option',
            'type'   => 'select',
            'holder' => 'Select',
            'pro'    => true,
            'label'  => true,
            'options' => array(
                'multi_branch'  => esc_html__('Multi Branch', 'reserving'),
                'single_branch' => esc_html__('Single Branch', 'reserving'),
            )
        ),
   
        'reserving_checker_logo' => array(
            'type'    => 'media',
            'label'   => true,
            'title'   => esc_html__('Logo in Order Details', 'reserving'),
            'desc'    => '',
            'default' => '',
            'preview' => true
        ),

        'reserving_add_to_cart_ajax' => array(
            'title'   => esc_html__('Grid Ajax Add to Cart', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0,
            'pro'    => true,
            'label'  => true,
        ),
  
       
    )
);

$tabs['frontend_dashboard_general'] = array(
    'title'          => 'Account',
    'id'             => 'frontend_dashboard_general',
    'icon'           => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/capability.svg',
    'content_bg'     => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/roles-bg-2.svg',
    'priority'       => 6,
    'option_heading' => 'row',
    'fields'    => array(
     
        'reserving_frontend_dashboard_url' => array(
            'title' => 'Frontend Dashboard Page',
            'type' => 'select',
            'holder' => 'Select',
            'pro'    => true,
            // 'label'  => true,
            'options' => reserving_default_pages_options()
        ),

        'reserving_front_dash_login_form_show' => array(
            'title'   => esc_html__('Show Login Form', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1,
            'pro'    => true,
            // 'label'  => true,
        ),
        'reserving_front_redirect_login_when_login' => array(
            'title'   => esc_html__('Redirect Dashboard When Login?', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0,
            'pro'     => true,
            // 'label'  => true,
        ),
        'reserving_frontend_dashboard_login_url' => array(
            'title'   => 'Frontend Dashboard Login Page',
            'type'    => 'select',
            'holder'  => 'Select',
            'pro'     => true,
            // 'label'   => true,
            'options' => reserving_default_pages_options()
        ),

        'reserving_frontend_login_button_text' => array(
            'title'   => esc_html__('Login Button Text', 'reserving'),
            'type'    => 'text',
            'holder'  => 'Login',
            // 'label'   => true,
            'default' => 'Login',
            'sizes'   => 'regular'
        ),

        'reserving_frontend_login_button_msg' => array(
            'title' => esc_html__('Login Message', 'reserving'),
            'type'    => 'textarea',
            // 'label'   => true,
            'holder'  => 'Login Message',
            'desc'    => esc_html__('Provide Login Button Heading Text ', 'reserving'),
            'default' => 'You should log in as a Branch Manage',
            'sizes'   => 'regular'
        ),

        'account_manager_heading' => array(
            'id'    => 'account_manager__heading',
            'type'  => 'service_heading',
            // 'heading' => true,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg',
            'title' => esc_html__('Advanced Settings', 'reserving'),
            'desc'  => esc_html__('After Login you can manage Front Dashboard Option', 'reserving')
        ),

        'reserving_front_dash_logout_link' => array(
            'title'   => esc_html__('Logout Link ?', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0,
            'pro'    => true,
            // 'label'  => true,
        ),

        'reserving_front_dash_username' => array(
            'title'   => esc_html__('Heading Username?', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1,
            'pro'    => true,
            // 'label'  => true,
        ),

        'reserving_frontend_dash_sub_heading' => array(
            'title' => esc_html__('Sub Heading', 'reserving'),
            'type'    => 'textarea',
            // 'label'   => true,
            'holder'  => 'Provide Sub Heading',
            'desc'    => esc_html__('Provide Sub Heading ', 'reserving'),
            'default' => 'Sub Heading',
            'sizes'   => 'regular'
        ),

        'reserving_front_dash_table_heading' => array(
            'title'   => esc_html__('Table Heading?', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1,
            'pro'    => true,
            // 'label'  => true,
        ),
        'reserving_front_dash_table_date_filter' => array(
            'title'   => esc_html__('Date Filter?', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0,
            'pro'     => true,
            // 'label'   => true,
        ),
      
        'reserving_front_dash_dfilter_label' => array(
            'title'   => esc_html__('Date Filter Label', 'reserving'),
            'type'    => 'text',
            'holder'  => 'Date Filter ',
            // 'label'   => true,
            'default' => 'Date Filter :',
            'sizes'   => 'regular'
        ),

        'ba_navi_heading' => array(
            'id'    => 'ba_navi_heading',
            'type'  => 'service_heading',
            // 'heading' => true,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg',
            'title' => esc_html__('Front Navigation', 'reserving'),
            'desc'  => esc_html__('Here you can manage Front Dashboard Icons', 'reserving')
        ),

        'ba_front_dash_icon_enable' => array(
            'title'   => esc_html__('Navigation Icon?', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0,
            'pro'     => true,
            // 'label'   => true,
        ),

        'ba_all_order_icon' => array(
            'type'    => 'media',
            // 'label'   => true,
            'title'   => esc_html__('All Order', 'reserving'),
            'desc'    => '',
            'default' => '',
            'preview' => true,
            'pro'     => true,
        ),

        'ba_new_order_icon' => array(
            'type'    => 'media',
            // 'label'   => true,
            'title'   => esc_html__('New Order', 'reserving'),
            'desc'    => '',
            'default' => '',
            'preview' => true,
            'pro'     => true,
        ),

        'ba_cooking_process_icon' => array(
            'type'    => 'media',
            // 'label'   => true,
            'title'   => esc_html__('Cooking Process Icon', 'reserving'),
            'desc'    => '',
            'default' => '',
            'preview' => true,
            'pro'     => true,
        ),

        'ba_cooking_complete_icon' => array(
            'type'    => 'media',
            // 'label'   => true,
            'title'   => esc_html__('Cooking Complete Icon', 'reserving'),
            'desc'    => '',
            'default' => '',
            'preview' => true,
            'pro'     => true,
        ),

        'ba_all_on_the_way_icon' => array(
            'type'    => 'media',
            // 'label'   => true,
            'title'   => esc_html__('On the Way', 'reserving'),
            'desc'    => '',
            'default' => '',
            'preview' => true,
            'pro'     => true,
        ),

        'ba_delivery_compl_icon' => array(
            'type'    => 'media',
            // 'label'   => true,
            'title'   => esc_html__('Delivery Complete', 'reserving'),
            'desc'    => '',
            'default' => '',
            'preview' => true,
            'pro'     => true,
        ),


  
       
    )
);


/**
 * =====================================
 * User Capabilities
 * =====================================
 */
$tabs['reserving_user_capabilities'] =  array(
    'title'      => 'Capabilities',
    'id'         => 'reserving_user_capabilities',
    'icon'       => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/capability.svg',
    'content_bg' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/roles-bg.svg',
  
    'priority'   => 2,
    'fields'    => array(
        'branch_manager_capability_heading' => array(
            'id'    => 'branch_manager_capability_heading',
            'type'  => 'service_heading',
            'heading' => false,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg',
            'title' => esc_html__('Branch Manager Order Management Capabilities', 'reserving'),
            'desc'  => esc_html__('Here you can manage Branch Manager capabilities to manage your orders.', 'reserving')
        ),
        'branch_manager_print_order' => array(
            'title'   => esc_html__('Print Order', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'branch_manager_cancel_order' => array(
            'title'   => esc_html__('Cancel Order', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'branch_manager_send_to_cook' => array(
            'title'   => esc_html__('Send to Cook', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'branch_manager_cooking_complete' => array(
            'title'   => esc_html__('Cooking Complete', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'branch_manager_assign_delivery' => array(
            'title'   => esc_html__('Assign Delivery Man', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'branch_manager_on_the_way' => array(
            'title'   => esc_html__('On The Way', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'branch_manager_delivery_complete' => array(
            'title'   => esc_html__('Delivery Complete', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'kitchen_manager_capability_heading' => array(
            'id'    => 'kitchen_manager_capability_heading',
            'type'  => 'service_heading',
            'heading' => false,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg',
            'title' => esc_html__('Kitchen Manager Order Management Capabilities', 'reserving'),
            'desc'  => esc_html__('Here you can manage Kitchen Manager capabilities to manage your orders.', 'reserving')
        ),
        'kitchen_manager_print_order' => array(
            'title'   => esc_html__('Print Order', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0
        ),
        'kitchen_manager_cancel_order' => array(
            'title'   => esc_html__('Cancel Order', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0
        ),
        'kitchen_manager_assign_delivery' => array(
            'title'   => esc_html__('Assign Delivery Man', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0
        ),
        'kitchen_manager_on_the_way' => array(
            'title'   => esc_html__('On The Way', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0
        ),
        'kitchen_manager_delivery_complete' => array(
            'title'   => esc_html__('Delivery Complete', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0
        ),

        'delivery_man_capability_heading' => array(
            'id'    => 'delivery_man_capability_heading',
            'type'  => 'service_heading',
            'heading' => false,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg',
            'title' => esc_html__('Delivery Man Order Management Capabilities', 'reserving'),
            'desc'  => esc_html__('Here you can manage Delivery Man capabilities to manage your orders.', 'reserving')
        ),
        'delivery_man_print_order' => array(
            'title'   => esc_html__('Print Order', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0
        ),
        'delivery_man_on_the_way' => array(
            'title'   => esc_html__('On The Way', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'delivery_man_delivery_complete' => array(
            'title'   => esc_html__('Delivery Complete', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
    )
);

/**
 * =====================================
 * Date/Time Section
 * =====================================
 */
$tabs['reserving_date_time_settings'] = array(
    'title'     => esc_html__('Time', 'reserving'),
    'id'        => 'reserving_date_time_settings',
    'icon'        => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/date.svg',
    'content_bg' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/calendar-bg.svg',
    'priority'    => 4,
    'fields'    => array(
        'reserving_time_format' => array(
            'title' => esc_html__('Time Format', 'reserving'),
            'type' => 'select',
            'holder' => esc_html__('Select Time Format', 'reserving'),
            'options' => array(
                '12hours' => '12 hours',
                '24hours' => '24 hours',
            )
        ),
        'reserving_time_slot' => array(
            'title' => esc_html__('Time Slot', 'reserving'),
            'type' => 'text',
            'holder' => 'Time Slot',
            'desc'    => esc_html__('in minutes (default: 60 min)', 'reserving'),
            'default'     => '60',
            'sizes'    => 'regular'
        ),
    )
);

if ('single_branch' == $branch_option) {
    $tabs['general']['fields']['reserving_single_branch_location'] = array(
        'title' => esc_html__('Restaurant Location', 'reserving'),
        'type' => 'textarea',
        'holder' => 'Restaurant Location',
        'sizes'    => 'small',
        'label'  => true,
    );

    $tabs['reserving_date_time_settings']['fields']['reserving_opening_time'] = array(
        'title'   => esc_html__('Opening Time', 'reserving'),
        'type'    => 'time',
        'default' => '09:00',
        'holder'  => 'Opening Time'
    );

    $tabs['reserving_date_time_settings']['fields']['reserving_closing_time'] = array(
        'title' => esc_html__('Closing Time', 'reserving'),
        'type' => 'time',
        'default'     => '22:00',
        'holder' => 'Closing Time'
    );
}

/**
 * ==================================
 * Availability Checker
 * ==================================
 */
$tabs['reserving_availability_checker'] =  array(
    'title'     => esc_html__('Availability Checker', 'reserving'),
    'id'        => 'reserving_availability_checker',
    'icon'        => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/avail.svg',
    'content_bg' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/cart-bg.svg',
    'priority'    => 3,
    'fields'    => array(
        'checker_form_show_style' => array(
            'title'   => 'Form Show Style',
            'type'    => 'select',
            'holder'  => 'Select',
            'label'   => true,
            'pro'     => true,
            'heading' => false,
            'options' => [
                'popup'       => esc_html__('Pop up', 'reserving'),
                'direct_show' => esc_html__('Direct Show', 'reserving')
            ]
        ),
        'default_form_tab_active' => array(
            'title'   => esc_html__('Default Active', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0
        ),
        'home_delivery_icon_setting_heading' => array(
            'id' => 'home_delivery_icons_setting_heading',
            'type'  => 'service_heading',
            'heading' => false,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg',
            'title' => esc_html__('Nav Icons', 'reserving'),
            'desc' => esc_html__('Manage Home delivery Nav settings here.', 'reserving')
        ),

        'reserving_tab_nav_home_delivery_icon' => array(
            'type'    => 'media',
            'label'   => true,
            'title'   => esc_html__('Home Delivery Icon', 'reserving'),
            'desc'    => '',
            'default' => '',
            'preview' => true
        ),
        'reserving_tab_nav_pickup_delivery_icon' => array(
            'type'    => 'media',
            'label'   => true,
            'title'   => esc_html__('PickUp Icon', 'reserving'),
            'desc'    => '',
            'default' => '',
            'preview' => true
        ),

        'reserving_tab_nav_in_dine_icon' => array(
            'type'    => 'media',
            'label'   => true,
            'title'   => esc_html__('InRestaurent Icon', 'reserving'),
            'desc'    => '',
            'default' => '',
            'preview' => true
        ),

        'home_delivery_setting_heading' => array(
            'id' => 'home_delivery_setting_heading',
            'type'  => 'service_heading',
            'heading' => false,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg',
            'title' => esc_html__('Home Delivery', 'reserving'),
            'desc' => esc_html__('Manage Home delivery settings here.', 'reserving')
        ),
        'checker_form_title_show' => array(
            'title' => esc_html__('Checker Form Title?', 'reserving'),
            'desc'    => '',
            'type' => 'switcher',
            'default' => 1
        ),
        'home_delivery_activate' => array(
            'title' => esc_html__('Activate Home Delivery', 'reserving'),
            'desc'    => '',
            'type' => 'switcher',
            'default' => 1
        ),
        'home_delivery_info_heading' => array(
            'title' => esc_html__('Delivery Info Heading?', 'reserving'),
            'desc'    => '',
            'type' => 'switcher',
            'default' => 1
        ),
        'home_delivery_info_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Delivery Info', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Delivery Info', 'reserving'),
            'sizes'   => 'regular'
        ),
        'home_delivery_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Tab Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Home Delivery', 'reserving'),
            'sizes'   => 'regular'
        ),
        'pickup_setting_heading' => array(
            'id' => 'pickup_setting_heading',
            'type'  => 'service_heading',
            'heading' => false,
            'label' => false,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg',
            'title' => esc_html__('Pickup', 'reserving'),
            'desc' => esc_html__('Manage Pickup settings here', 'reserving')
        ),
        'pickup_activate' => array(
            'title' => esc_html__('Activate Pickup', 'reserving'),
            'desc'    => '',
            'type' => 'switcher',
            'default' => 1
        ),
        'pickup_label' => array(
            'type'    => 'text',
            'title'    => esc_html__('Tab Label', 'reserving'),
            'desc'    => '',
            'default'     => 'Pickup',
            'sizes'    => 'regular'
        ),
        'inrestaurant_setting_heading' => array(
            'id' => 'inrestaurant_setting_heading',
            'type'  => 'service_heading',
            'heading' => false,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg',
            'title' => esc_html__('In Restaurant', 'reserving'),
            'desc' => esc_html__('Manage In Restaurant settings here', 'reserving')
        ),
        'inrestaurant_activate' => array(
            'title' => esc_html__('Activate In Restaurant', 'reserving'),
            'desc'    => '',
            'type' => 'switcher',
            'default' => 1
        ),
        'in_restaurant_label' => array(
            'type'    => 'text',
            'title'    => esc_html__('Tab Label', 'reserving'),
            'desc'    => '',
            'default'     => esc_html__('In Restaurant', 'reserving'),
            'sizes'    => 'regular'
        ),
        'checker_buttons_heading' => array(
            'id' => 'checker_buttons_heading',
            'type'  => 'service_heading',
            'heading' => false,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg',
            'title' => esc_html__('Other Labels', 'reserving'),
            'desc' => 'You can add other labels for availability checker form bellow'
        ),
      
        'checker_form_title' => array(
            'type'    => 'text',
            'title'    => esc_html__('Checker Heading', 'reserving'),
            'desc'    => '',
            'default'     => esc_html__('Check Availability', 'reserving'),
            'sizes'    => 'regular'
        ),
        'open_button_text' => array(
            'type'    => 'text',
            'title'    => esc_html__('Open Button Text', 'reserving'),
            'desc'    => '',
            'default'     => esc_html__('Check Availability', 'reserving'),
            'sizes'    => 'regular'
        ),
        'close_button_text' => array(
            'type'    => 'text',
            'title'    => esc_html__('Close Button Text', 'reserving'),
            'desc'    => '',
            'default'     => esc_html__('Close', 'reserving'),
            'sizes'    => 'regular'
        ),
        'check_availability_button_text' => array(
            'type'    => 'text',
            'title'    => esc_html__('Check Availability Button Text', 'reserving'),
            'desc'    => '',
            'default'     => esc_html__('Check Availability', 'reserving'),
            'sizes'    => 'regular'
        ),
        'start_order_button_text' => array(
            'type'    => 'text',
            'title'    => esc_html__('Start Order Button Text', 'reserving'),
            'desc'    => '',
            'default'     => esc_html__('Start Order', 'reserving'),
            'sizes'    => 'regular'
        ),
        'start_order_button_link' => array(
            'type'    => 'text',
            'title'    => esc_html__('Start Order Button Link', 'reserving'),
            'desc'    => '',
            'default'     =>  '#',
            'sizes'    => 'regular'
        ),
        'update_info_button_text' => array(
            'type'    => 'text',
            'title'    => esc_html__('Update Info Button Text', 'reserving'),
            'desc'    => '',
            'default'     => esc_html__('Update Info', 'reserving'),
            'sizes'    => 'regular'
        ),
        'reserving_select_branch_label' => array(
            'type'    => 'text',
            'title'    => esc_html__('Select Branch Label', 'reserving'),
            'desc'    => '',
            'default'     => esc_html__('Select Branch', 'reserving'),
            'sizes'    => 'regular'
        ),
        'reserving_select_location_label' => array(
            'type'    => 'text',
            'title'    => esc_html__('Select Location Label', 'reserving'),
            'desc'    => '',
            'default'     => esc_html__('Select Location', 'reserving'),
            'sizes'    => 'regular'
        ),
        'reserving_delivery_date_label' => array(
            'type'    => 'text',
            'title'    => esc_html__('Select Delivery Date Label', 'reserving'),
            'desc'    => '',
            'default'     => esc_html__('Select Delivery Date', 'reserving'),
            'sizes'    => 'regular'
        ),
        'reserving_delivery_time_label' => array(
            'type'    => 'text',
            'title'    => esc_html__('Select Delivery Time Label', 'reserving'),
            'desc'    => '',
            'default'     => esc_html__('Select Delivery Time', 'reserving'),
            'sizes'    => 'regular'
        ),
        'reserving_pickup_date_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Select Pickup Date Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Select Pickup Date', 'reserving'),
            'sizes'   => 'regular'
        ),
        'reserving_pickup_time_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Select Pickup Time Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Select Pickup Time', 'reserving'),
            'sizes'   => 'regular'
        ),
        'reserving_booking_date_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Select Booking Date Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Select Booking Date', 'reserving'),
            'sizes'   => 'regular'
        ),
        'reserving_booking_start_time_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Select Start Time Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Select Start Time', 'reserving'),
            'sizes'   => 'regular'
        ),
        'reserving_booking_end_time_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Select End Time Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Select End Time', 'reserving'),
            'sizes'   => 'regular'
        ),
        'reserving_select_tables_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Select Tables Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Select Tables', 'reserving'),
            'sizes'   => 'regular'
        ),
    ),
);

$tabs['quickview'] = array(
    'title'     => 'QuickView',
    'id'        => 'quickview',
    'icon'        => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/checkout.svg',
    'content_bg' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/cart-bg.svg',
    'priority'    => 1,
    'fields'    => array(
      
        'reserving_activate_product_quick_view' => array(
            'title'   => esc_html__('Activate Quick View', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1,
            'pro'     => 1
        ),

        'reserving_quick_view_extra_item' => array(
            'title'   => esc_html__('Extra Item Only', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0,
            'pro' => 1 
        ),

        'reserving_disable_default_add_to_cart' => array(
            'title'   => esc_html__('Disable Default Add to Cart ?', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0,
            'pro' => 1 
        ),
        
        'reserving_quick_view_text' => array(
            'title'   => esc_html__('Quick View Text', 'reserving'),
            'type'    => 'text',
            'holder'  => 'Quick View',
            'desc'    => '',
            'default' => 'Quick View',
            'sizes'   => 'regular'
        ),

        'reserving_quick_view_icon_cls' => array(
            'title'   => esc_html__('Quick View Icon', 'reserving'),
            'type'    => 'text',
            'holder'  => 'Quick View Icon',
            'desc'    => '',
            'default' => 'fas fa-eye',
            'sizes'   => 'regular'
        ),


        'reserving_dactivate_product_breadcrumb' => array(
            'title'   => esc_html__('Hide breadcrumb', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 0
        ),
      

        'reserving_dactivate_header' => array(
            'title'   => esc_html__('Hide Header', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'reserving_dactivate_footer' => array(
            'title'   => esc_html__('Hide Footer', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),

        'reserving_dactivate_related_product' => array(
            'title'   => esc_html__('Disable Related product', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),

        'reserving_dactivate_upsell_product' => array(
            'title'   => esc_html__('Disable UpSell product', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
    )
);

$tabs['reserving_cart_tip_options'] =  array(
    'title'     => esc_html__('Cart Tips', 'reserving'),
    'id'        => 'reserving_cart_tip_options',
    'content_bg' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/cart-bg.svg',
    'icon'        => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/checkout.svg',
    'priority'    => 3,
    'fields'    => array(
 
        'cart_tip_enable' => array(
            'title'   => esc_html__('Cart Tip', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'pro'     => true,
            'default' => 0
        ),

        'cart_tip_checkout_position' => array(
            'title'  => esc_html__('Checkout Page position', 'reserving'),
            'type'   => 'select',
            'pro'    => true,
            'holder' => 'Select',
            'options' => array(
                'woocommerce_after_checkout_form'              => esc_html__('After Checkout Form', 'reserving'),
                'woocommerce_review_order_before_submit'       => esc_html__('Before Order Submit', 'reserving'),
                'woocommerce_review_order_before_payment'      => esc_html__('Before Payment Option', 'reserving'),
                'woocommerce_checkout_before_order_review'     => esc_html__('Before Order Review', 'reserving'),
                'woocommerce_checkout_after_customer_details'  => esc_html__('Before Customer Details', 'reserving'),
                'woocommerce_after_order_notes'                => esc_html__('After Order Note', 'reserving'),
                'woocommerce_before_order_notes'               => esc_html__('Before Order Note', 'reserving'),
                'woocommerce_checkout_before_customer_details' => esc_html__('Before Customer Details', 'reserving'),
                'woocommerce_before_checkout_form'             => esc_html__('Before Checkout Form', 'reserving'),
                ''                                             => esc_html__('None', 'reserving'),
            )
        ),

        'cart_tip_cart_position' => array(
            'title' => esc_html__('Cart Page position', 'reserving'),
            'type' => 'select',
            'pro' => true,
            'holder' => 'Select',
            'options' => array(
                'woocommerce_before_cart_totals'              => esc_html__('Before Total', 'reserving'),
                'woocommerce_before_cart'       => esc_html__('Before Cart', 'reserving'),
                'woocommerce_before_cart_table'      => esc_html__('Before Cart Table', 'reserving'),
                'woocommerce_cart_coupon'     => esc_html__('After Coupon', 'reserving'),
                'woocommerce_after_cart_table'  => esc_html__('After Cart Table', 'reserving'),
                'woocommerce_cart_collaterals'  => esc_html__('Cart collaterals', 'reserving'),
                'woocommerce_proceed_to_checkout'  => esc_html__('Checkout Button', 'reserving'),
                ''                                             => esc_html__('None', 'reserving'),
            )
        ),


        'cart_tip_heading_enable' => array(
            'title' => esc_html__('Enable Heading?', 'reserving'),
            'desc'    => '',
            'type' => 'switcher',
            'default' => 1
        ),

        'cart_tip_heading' => array(
            'type'    => 'text',
            'title'   => esc_html__('Title', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Would you like to give a tip?', 'reserving'),
            'sizes'   => 'regular'
        ),

        'cart_tip_percentage_enable' => array(
            'title' => esc_html__('Enable Percantage Type', 'reserving'),
            'desc'    => '',
            'type' => 'switcher',
            'default' => 1
        ),

        'cart_tip_type_percentage_option_name' => array(
            'type'    => 'text',
            'title'   => esc_html__('Percantage(%) option', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Percantage(%)', 'reserving'),
            'sizes'   => 'regular'
        ),

        
        'cart_tip_type_fixed_option_name' => array(
            'type'    => 'text',
            'title'   => esc_html__('Fixed Option', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Fixed', 'reserving'),
            'sizes'   => 'regular'
        ),

        'cart_tip_button_add' => array(
            'type'    => 'text',
            'title'   => esc_html__('Button Add', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Add tip', 'reserving'),
            'sizes'   => 'regular'
        ),

        'cart_tip_button_remove' => array(
            'type'    => 'text',
            'title'   => esc_html__('Button Remove', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Clear', 'reserving'),
            'sizes'   => 'regular'
        ),

        'cart_tip_fld_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Tip Heading Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Tip', 'reserving'),
            'sizes'   => 'regular'
        ),

       
    )
);

/**
 * ==================================
 * Checkout element position
 * ==================================
 */
$tabs['reserving_checkout_options'] =  array(
    'title'     => esc_html__('Checkout', 'reserving'),
    'id'        => 'reserving_checkout_options',
    'content_bg' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/cart-bg.svg',
    'icon'        => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/checkout.svg',
    'priority'    => 3,
    'fields'    => array(

        'delivery_info_location_hook' => array(
            'title'  => esc_html__('Delivery Info Location', 'reserving'),
            'type'   => 'select',
            'pro'    => true,
            'holder' => 'Select',
            'options' => array(
                'woocommerce_after_checkout_form'              => esc_html__('After Checkout Form', 'reserving'),
                'woocommerce_review_order_before_submit'       => esc_html__('Before Order Submit', 'reserving'),
                'woocommerce_review_order_before_payment'      => esc_html__('Before Payment Option', 'reserving'),
                'woocommerce_checkout_before_order_review'     => esc_html__('Before Order Review', 'reserving'),
                'woocommerce_checkout_after_customer_details'  => esc_html__('Before Customer Details', 'reserving'),
                'woocommerce_after_order_notes'                => esc_html__('After Order Note', 'reserving'),
                'woocommerce_before_order_notes'               => esc_html__('Before Order Note', 'reserving'),
                'woocommerce_checkout_before_customer_details' => esc_html__('Before Customer Details', 'reserving'),
                'woocommerce_before_checkout_form'             => esc_html__('Before Checkout Form', 'reserving'),
                ''                                             => esc_html__('None', 'reserving'),
            )
        ),

        'thankyou_page_audio' => array(
            'title'   => esc_html__('ThankYou Page Audio', 'reserving'),
            'desc'    => '',
            'pro'     => true,
            'type'    => 'switcher',
            'default' => 0
        ),

        'thankyou_audio_src' => array(
            'type'    => 'audio',
            'title'   => esc_html__('ThankYou Audio', 'reserving'),
            'desc'    => '',
            'default' => '',
        ),
    )
);

// Print Options
$tabs['reserving_print_options'] = array(
    'title'     => esc_html__('Print', 'reserving'),
    'id'        => 'reserving_print_options',
    'content_bg' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/print-bg.svg',
    'icon'        => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/printer.svg',
    'priority'    => 4,
    'fields' =>  array(

        'print_logo_activate' => array(
            'title'   => esc_html__('Show Company Logo', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'print_company_title_activate' => array(
            'title'   => esc_html__('Show Company Title', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'print_billing_info_activate' => array(
            'title'   => esc_html__('Show Billing Info', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'print_billing_info_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Billing Info Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Billing Info', 'reserving'),
            'sizes'   => 'regular'
        ),
        'print_shipping_info_activate' => array(
            'title'   => esc_html__('Show Shipping Info', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'print_shipping_info_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Shipping Info Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Shipping Info', 'reserving'),
            'sizes'   => 'regular'
        ),
        'print_delivery_info_activate' => array(
            'title'   => esc_html__('Show Delivery Info', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'print_delivery_info_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Delivery Info Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Delivery Info', 'reserving'),
            'sizes'   => 'regular'
        ),
        'print_order_items_activate' => array(
            'title'   => esc_html__('Show Order Items', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'print_shipping_cost_activate' => array(
            'title'   => esc_html__('Show Shipping Cost', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'print_shipping_cost_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Shipping cost Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Shipping cost', 'reserving'),
            'sizes'   => 'regular'
        ),
        'print_total_cost_activate' => array(
            'title'   => esc_html__('Show Total Cost', 'reserving'),
            'desc'    => '',
            'type'    => 'switcher',
            'default' => 1
        ),
        'print_total_cost_label' => array(
            'type'    => 'text',
            'title'   => esc_html__('Total cost Label', 'reserving'),
            'desc'    => '',
            'default' => esc_html__('Total cost', 'reserving'),
            'sizes'   => 'regular'
        ),
    )
);

//Styles
$tabs['reserving_styles'] = array(
    'title'          => esc_html__('Styles', 'reserving'),
    'id'             => 'reserving_styles',
    'content_bg'     => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/style-bg.svg',
    'icon'           => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/style.svg',
    'priority'       => 5,
    'option_heading' => 'column',
    'fields'   => array(
        'reserving_checker_style_heading' => array(
            'id'    => 'reserving_checker_style_heading',
            'type'  => 'service_heading',
            'heading' => false,
            'pro' => 1,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg',
            'title' => esc_html__('Availability Checker Styles', 'reserving'),
            'desc'  => esc_html__('Here you can give some styles to the Availability Checker Form.', 'reserving')
        ),
        'checker_form_bg_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Checker Form Background Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_form_title_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Checker Form Title Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_open_button_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Open Button Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_open_button_bg_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Open Button BG Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_open_button_hover_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Open Button Hover Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_open_button_hover_bg_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Open Button Hover BG Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_close_button_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Close Button Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_close_button_bg_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Close Button BG Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_close_button_hover_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Close Button Hover Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_close_button_hover_bg_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Close Button Hover BG Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_tabs_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Tabs Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_tabs_bg_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Tabs Background Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_tabs_hover_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Tabs Hover Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_tabs_hover_bg_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Tabs Hover BG Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_tabs_active_bg_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Tabs Active BG Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_button_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Checker Button Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'checker_button_bg_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Checker Button BG Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'start_order_button_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Start Order Button Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
        'start_order_button_bg_color' => array(
            'type'    => 'color',
            'title'   => esc_html__('Start Order Button BG Color', 'reserving'),
            'desc'    => '',
            'label'  => true,
            'default' => '#dd3333'
        ),
    )
);

/**
 * ================================= = 
 * ShortCodes
 * ================================= = 
 */

$tabs['reserving_shortcodes'] =  array(
    'title'    => esc_html__('Shortcodes', 'reserving'),
    'id'       => 'reserving_shortcodes',
    'icon'        => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/shortcode.svg',
    'content_bg' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/shortcode-body.svg',
    'option_heading' => 'column',
    'priority' => 6,
    'fields'   => array(

        'availability_checker_shortcode' => array(
            'id'    => 'availability_checker_shortcode',
            'type'  => 'shortcode',
            'title' => esc_html__('Availability', 'reserving'),
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg',
            'desc'  => '[reserving_availability_checker]'
        ),

        'reserving_delivery_info' => array(
            'id'    => 'reserving_delivery_info',
            'type'  => 'shortcode',
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/edit.svg',
            'title' => esc_html__('Delivey Info (In Checkout page)', 'reserving'),
            'desc'  => '[reserving_delivery_info]'
        ),

        'reserving_frontend_dashboard' => array(
            'id'    => 'reserving_frontend_dashboard',
            'type'  => 'shortcode',
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/edit-color.svg',
            'title' => esc_html__('Frontend Dashboard', 'reserving'),
            'desc'  => '[reserving_frontend_dashboard]'
        ),
        'reserving_restaurant_slider' => array(
            'id'    => 'reserving_restaurant_slider',
            'type'  => 'shortcode',
            'pro'   => true,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/slider.svg',
            'title' => esc_html__('Restaurent Slider', 'reserving'),
            'desc'  => "[reserving_restaurant_slider number='10']"
        ),
        'reserving_category_slider' => array(
            'id'    => 'reserving_category_slider',
            'type'  => 'shortcode',
            'pro'   => true,
            'img_src' => RESERVING_ASSETS_BACKEND_URL.'imgs/icons/slider-cat.svg',
            'title' => esc_html__('Product Category Slider', 'reserving'),
            'desc'  => "[reserving_category_slider number='10']"
        )

    )
);

return apply_filters('reserving_gl_settings_tabs',$tabs);
