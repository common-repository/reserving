<?php
/**
 * @package Reserving
 */
namespace Reserving\backend\cpt;
use Reserving\base\cpt\Custom_Taxonomy;

class Delivery_Area extends Custom_Taxonomy
{
    public $name         = '';
    public $menu         = 'reserving_delivery_area';
    public $textdomain   = '';
    public $posts        = array();
    public $public_quary = true;
    public $slug         = 'reserving-delivery-area';
    public $search       = true;

    public function __construct()
    {
        $this->name = esc_html__('Delivery Areas', 'reserving');
        add_action('init', array($this, 'create_taxonomy'));
    }

    public function create_taxonomy()
    {
        $this->init('reserving-delivery-area', esc_html__('Delivery Area', 'reserving'), esc_html__('Delivery Areas', 'reserving'), 'reserving-branches');
        $this->register_taxonomy();
    }
}
