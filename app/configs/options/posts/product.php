<?php

    return array(

        'title'      => esc_html__('Reserving Extra Items','reserving'),
        'metabox_id' => 'reserving_extra_items',   //unique
        'post_type'  => 'product',
        'priority'   => 'high', // low, high
        'position'   => 'normal',         // 
        'fields'     => array(

            'reserving_extra_items' => array(
                'title' => esc_html__('Add Extra Items','reserving'),
                'type'  => 'repeat',
                'style' => 'small',
                'sub_fields' => array(

                    'name' => array(
                        'title'   => esc_html__('Name','reserving'),
                        'type'    => 'text',
                        'holder'  => 'Item Name',
                        'default' => 'Item Name'
                    ),

                    'price' => array(
                        'title'   => esc_html__('Price','reserving'),
                        'type'    => 'number',
                        'default' => 5
                    ),

                    'enable_quantity' => array(
                        'title'   => esc_html__('Enable Quantity','reserving'),
                        'type'    => 'switcher',
                        'default' => 1
                    ),

                    'quantity_unit' => array(
                        'title'   => esc_html__('Quantity Unit','reserving'),
                        'type'    => 'text',
                        'holder'  => 'e.g grams',
                        'default' => 'grams'
                    )
                )
            ),
        ),
    );
