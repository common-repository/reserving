<?php

namespace Reserving\system\service;

/**
 * All Service Providers are registered here.
 * @version 1.0.0
 * @from 2022-02-26
 * @since 1.0
 */
final class Loader {

    public static $terget_dir_path = 'app/serviceProviders';
    public static $terget_namespace = '\Reserving\serviceProviders';
    public static $instance = null;
    /**
    * store all service providers
    */
    public function __construct(){

        do_action('reserving_service_container_load_before');
        self::set_services();  
        /* Load from extensions */
        do_action('reserving_service_container_load_after');

    }

    public static function getInstance(){

        if( self::$instance == null ){
            self::$instance = new Loader();
        }

        return self::$instance;
    }

    /**
     * Get service directory
     * @return void
     * @since 2022
     * @version 1.0
     */
    protected static function set_services(){
       
        $service_list = self::get_classes_list(RESERVING_DIR_PATH.self::$terget_dir_path);
        foreach($service_list as $classname => $file_path){
            $provider_cls = self::$terget_namespace.'\\'.$classname;
		     if( class_exists( $provider_cls ) ):
                reserving_app()->addServiceProvider( new $provider_cls );
            endif;
        }

    }
    protected static function get_classes_list( $dir ){

        $classes = [];
        foreach ( glob("$dir/*.php") as $filename ) {
            if( !is_null( basename( $filename ) ) ){
                $classes[ strtok( basename( $filename),'.' ) ] = $filename;
            }
        }

        return $classes;
    }
 
}



