<?php

    $branch_managers_obj  = get_users(array('role__in' => array('branch_manager'), 'fields' => array('ID', 'display_name')));
    $kitchen_managers_obj = get_users(array('role__in' => array('kitchen_manager'), 'fields' => array('ID', 'display_name')));
    $delivery_men_obj     = get_users(array('role__in' => array('delivery_man'), 'fields' => array('ID', 'display_name')));

    $branch_managers  = [];
    $kitchen_managers = [];
    $delivery_men     = [];

    if (!empty($branch_managers_obj)) {
        foreach ($branch_managers_obj as $manager) {
            $branch_managers['user_id_' . $manager->ID] = $manager->display_name;
        }
    }

    if (!empty($kitchen_managers_obj)) {
        foreach ($kitchen_managers_obj as $manager) {
            $kitchen_managers['user_id_' . $manager->ID] = $manager->display_name;
        }
    }

    if (!empty($delivery_men_obj)) {
        foreach ($delivery_men_obj as $delivery_man) {
            $delivery_men['user_id_' . $delivery_man->ID] = $delivery_man->display_name;
        }
    }

    return array(

        'title'      => esc_html__('Branch Information','reserving'),
        'metabox_id' => 'reserving_branches_info',
        'post_type'  => 'reserving-branches',
        'priority'   => 'high',
        'position'   => 'normal',
        'fields'     => array(

            'branch_heading_info' => array(
               
                'type'  => 'service_heading',
                'heading' => false,
                'img_src' =>esc_url( RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg' ),
                'title' => esc_html__('Branch Information', 'reserving'),
                'desc'  => esc_html__('Here you can manage Branch Manager capabilities to manage your orders.', 'reserving')
            ),

            'reserving_branch_discount' => array(
                'title'   => esc_html__('Discount Offer(%)','reserving'),
                'type'    => 'text',
                'holder'  => 'Discount',
                'default' => '15%'
            ),
            'reserving_total_food_items' => array(
                'title'   => esc_html__('Total Food Items','reserving'),
                'type'    => 'text',
                'holder'  => 'Food Items',
                'default' => '101 items'
            ),

            'reserving_branch_manager' => array(
                'title'   => esc_html__('Branch Manager','reserving'),
                'type'    => 'select',
                'holder'  => 'Select Branch Manager',
                'options' => $branch_managers
            ),

            'reserving_kitchen_manager' => array(
                'title'   => esc_html__('Kitchen Manager','reserving'),
                'type'    => 'select',
                'holder'  => esc_html__('Select kitchen Manager','reserving'),
                'options' => $kitchen_managers
            ),

            'branch_delivery_heading_info' => array(
               
                'type'  => 'service_heading',
                'heading' => false,
                'img_src' => esc_url( RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg' ),
                'title' => esc_html__('Delivery Information', 'reserving'),
                'desc'  => esc_html__('Here you can manage Delivery Manager capabilities.', 'reserving')
            ),

            'reserving_branch_delivery_men' => array(
                'title'      => '',
                'type'       => 'repeat',
                'style'      => 'large',
                'sub_fields' => array(
                    'country' => array(
                        'title'   => esc_html__('Delivery Men','reserving'),
                        'type'    => 'select',
                        'label' => true,
                        'options' => $delivery_men
                    )
                )
            ),

            'branch_date_time_heading_info' => array(
               
                'type'  => 'service_heading',
                'heading' => false,
                'img_src' => esc_url( RESERVING_ASSETS_BACKEND_URL.'imgs/icons/light.svg' ),
                'title' => esc_html__('Time & Location', 'reserving'),
                'desc'  => esc_html__('Here you can manage Date And Time.', 'reserving')
            ),

            'reserving_branch_opening_time' => array(
                'title'  => esc_html__('Opening Time','reserving'),
                'type'   => 'time',
                'holder' => esc_html__('Opening Time','reserving'),
                'desc'  => esc_html__('Here you can manage restuarent Time.', 'reserving')
            ),

            'reserving_branch_closing_time' => array(
                'title'  => esc_html__('Closing Time','reserving'),
                'type'   => 'time',
                'holder' => esc_html__('Closing Time','reserving')
            ),

            'reserving_branch_location' => array(
                'type'    => 'textarea',
                'title'   => esc_html__('Branch Location','reserving'),
                'desc'    => '',
                'default' => '',
                'sizes'   => 'small',
                'desc'  => esc_html__('Here you can manage address.', 'reserving')
            ),
           

        )
    );
