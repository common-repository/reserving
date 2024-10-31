<?php

return [

    'js' => [

        [
            'handle_name' => 'reserving-dashboard-settings-script',
            'src'         => apply_filters( 'reserving_settings_main_js' ,RESERVING_ASSETS_BACKEND_URL . 'js/admin-settings.js' ),
            'file'        => RESERVING_DIR_PATH . 'assets/backend/js/admin-settings.js',
            'minimize'    => false,
            'public'      => false, // will load in frontend
            'admin'       => true, // will load in admin panel
            'in_footer'   => true,
            'media'       => 'all',
            'deps'        => [
                'jquery', 'jquery-ui-core', 'wp-color-picker','wp-util'
            ]
        ]

    ],

    'css' => [

        [
            'handle_name' => 'reserving-dashboard-settings',
            'src'         => apply_filters( 'reserving_settings_main_css',RESERVING_ASSETS_BACKEND_URL . 'css/admin-settings.css'),
            'file'        => RESERVING_DIR_PATH . 'assets/backend/css/admin-settings.css',
            'minimize'    => false,
            'public'      => false,
            'admin'      => true,
            'media' => 'all',
            'deps' => []
        ]
        
    ]
];
