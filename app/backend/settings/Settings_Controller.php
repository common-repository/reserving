<?php 

namespace Reserving\backend\settings;

use Reserving_Packages\Options\Settings_Api;
use Reserving_Packages\Options\MetaBox_Api;
use Reserving_Packages\Options\Texonomy_Api;

Class Settings_Controller {

    public function loader(){

        add_action( 'admin_enqueue_scripts', array($this, 'enqueue_scripts') );
        add_action( 'init', [$this,'setings_setup'] );
    }

    function setings_setup() {
    
       $this->dashboard_settings_with_menu();
       $this->load_post_type_options();
       $this->load_taxonomy_options();
    }

    public function dashboard_settings_with_menu(){
        
        $sections = array();
        $configs  = array();
     
        $sections   = reserving_app()->get('menu-settings-sections');
        $configs    = reserving_app()->get('menu-settings');
    
        // Dashboard Settings
        new Settings_Api(
            $configs, 
            apply_filters( 'reserving_option_sections', $sections, 'pages-settings-sections' )
        );

    }

    public function load_taxonomy_options(){

        $tax_options = reserving_app()->get('builder-options-taxonomy');
     
        if( is_array( $tax_options ) ){

            foreach($tax_options as $type){
                if(reserving_app()->has('taxonomy-'.$type)){
                    new Texonomy_Api(reserving_app()->get('taxonomy-'.$type));
                }
            }
        }
    }

    public function load_post_type_options(){

        $post_type_options = reserving_app()->get('builder-options-posts');
    
        if( is_array( $post_type_options ) ){

            foreach($post_type_options as $type){
            
                if(reserving_app()->has('posts-'.$type)){
                   new MetaBox_Api(reserving_app()->get('posts-'.$type));
                }

            }
        } 
  
    }

    public function _blank_callback(){}
  
    public function enqueue_scripts(){

        $asset_array = reserving_app()->get('configs-settings-assets');

        $js_arr = $asset_array[ 'js' ];
        $css_arr = $asset_array[ 'css' ];

        foreach( $css_arr as $css ){
            
            if( file_exists( $css[ 'file' ] ) && $css[ 'admin' ] == true ) {
                
                $media = isset( $css[ 'media' ] ) ? $css[ 'media' ] : 'all';
                wp_register_style( $css[ 'handle_name' ] , esc_url($css[ 'src' ]) , $css[ 'deps' ] , filemtime( $css[ 'file' ] ), $media );
                wp_enqueue_style( $css[ 'handle_name' ] );
        
            }
        }

        foreach( $js_arr as $js ){

            if( file_exists( $js[ 'file' ] ) && $js['admin'] == true ) {
                wp_register_script( $js[ 'handle_name' ] , esc_url($js[ 'src' ]) , $js[ 'deps' ] , filemtime( $js[ 'file' ] ) );
                wp_enqueue_script( $js[ 'handle_name' ] );
            }   
        } 
     

    }
}