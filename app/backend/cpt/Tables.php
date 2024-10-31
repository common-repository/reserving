<?php

namespace Reserving\backend\cpt;
use Reserving\base\cpt\Custom_Taxonomy;
/**
 * @package Reserving
 * @quomodosoft
 */
class Tables extends Custom_Taxonomy
{
    public $name         = '';
    public $menu         = 'reserving_tables';
    public $textdomain   = '';
    public $posts        = array();
    public $public_quary = true;
    public $slug         = 'reserving-tables';
    public $search       = true;

    public function __construct()
    {
        $this->name = esc_html__('Tables', 'reserving');
        add_action('init', array($this, 'create_taxonomy'));
    }

    public function create_taxonomy()
    {
        $this->init('reserving-tables', esc_html__('Table', 'reserving'), esc_html__('Tables', 'reserving'), 'reserving-branches');
        $this->register_taxonomy();
    }
}
