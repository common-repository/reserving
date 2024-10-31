<?php

/**
 * @package Reserving
 */
namespace Reserving\backend\cpt;

use Reserving\base\cpt\Custom_Post;

class Branches extends Custom_Post
{
    public $name         = '';
    public $menu         = 'Branches';
    public $textdomain   = '';
    public $posts        = array();
    public $public_quary = true;
    public $slug         = 'reserving-branches';
    public $search       = false;

    public function __construct()
    {
        $this->posts      = array();
        $this->name       = esc_html__('Branches', 'reserving');
        add_action('init', array($this, 'create_post_type'));
    }

    public function create_post_type()
    {
        $this->init('reserving-branches', esc_html__('Branch', 'reserving'), esc_html__('Branches', 'reserving'), array(
            'menu_icon' => 'dashicons-location-alt',
            'supports'  => array(
                'title',
                'thumbnail',
                'editor'
            ),
            'rewrite' => array(
                'slug' => sanitize_title_with_dashes($this->menu)
            ),
            'show_in_menu' => false,
            'show_in_rest' => true,
        ));
        
        $this->register_custom_post();
    }
}
