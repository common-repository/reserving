<?php

    return array(
        'title'      => 'General',
        'taxonomy'  => 'reserving-tables',
        'taxonomy_id'  => 'reserving-tables',
        'fields'     => array(
            'reserving_tables_max_person' => array(
                'type'    => 'number',
                'title'   => 'Maximum Person',
                'desc'    => '',
                'default' => '4',
                'sizes'   => 'regular'
            ),
        )
    );
