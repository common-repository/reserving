<?php

namespace Reserving\extensions\elementor;
/**
 * Elementor Setup
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */
class Elementor
{
    public function register(){
        add_action( 'elementor/widgets/register', [$this,'register_widget'] );
 
        add_action( 'elementor/elements/categories_registered', [$this,'add_elementor_widget_categories'] );
    }
    function add_elementor_widget_categories( $elements_manager ) {

        $elements_manager->add_category(
            'reserving',
            [
                'title' => esc_html__( 'Reserving', 'reserving' ),
                'icon' => 'eicon-basket-solid',
            ]
        );
    
    }
    function register_widget( $widgets_manager ) {

        require_once( __DIR__ . '/widgets/availability_checker.php' );
        require_once( __DIR__ . '/widgets/frontend_dashboard.php' );
        require_once( __DIR__ . '/widgets/product_extra_item.php' );
        require_once( __DIR__ . '/widgets/product_extra_price.php' );
          
        $widgets_manager->register( new \Reserving_Availability_Checker() );
        $widgets_manager->register( new \Reserving_Frontend_Dashboard() );
        $widgets_manager->register( new \Reserving_Product_Extra_Meta() );
        $widgets_manager->register( new \Reserving_Product_Extra_Price() );
    
    }
}