<?php

namespace Reserving\system\service;

/**
 * All Extensions are init here.
 * @version 1.0.0
 * @since 2022-02-26
 * @since 1.0
 */

final class Ext_Loader {

    public static $terget_dir_path = RESERVING_DIR_PATH.'app/extensions';
    public static $terget_namespace = '\Reserving\extensions';

    public static $instance = null;

    /**
    * store all service providers
    */
    public function __construct(){

        self::set_services();  
    }

    public static function getInstance(){

        if( self::$instance == null ){
            self::$instance = new Ext_Loader();
        }

        return self::$instance;
    }

    /**
     * Get service directory
     * @param string $dir
     * @since 2022
     * @version 1.0
     */
    protected static function set_services(){
        
        $directories = glob(self::$terget_dir_path . '/*' , GLOB_ONLYDIR);
        $ext_runner = [];
        
        foreach( $directories as $dir ){

            $ext = basename($dir);

            $service_list = self::get_Init_File(self::$terget_dir_path.'/'.$ext);
            $boot_cls     = self::$terget_namespace.'\\'.$ext.'\\'.'Init';
           
            if(class_exists($boot_cls)){
                $ext_runner[] = $boot_cls;
            }
     
        }
        $var = 'reserveing_';
        // run
        foreach($ext_runner as $key => $book){

            $var.$key = $book;
            $var.$key::register_services();
        }
        
   
    }

    /**
     * Get all classes list`s from directory
     * @return array
     * @param dir path
     * @since 2022
     * @version 1.0
     */
    protected static function get_Init_File($dir){

        $classes = [];
       
        foreach (glob("$dir/Init.php") as $filename) {
            
             if( !is_null( basename( $filename ) ) ){
                 $classes = $filename;
                 break;
             }
            
        }
        
        return $classes;
    }
  
}



