<?php

namespace Reserving\backend;

use Reserving\backend\settings\Settings_Controller as Settings_Controller;

/**
 * BackEnd Initializer
 */
final class Backend
{

  public function __construct()
  {
    $this->register();
  }

  public function register()
  {

    new \Reserving\base\Common();
    new \Reserving\backend\cpt\Branches();
    new \Reserving\backend\cpt\Delivery_Area();
    new \Reserving\backend\cpt\Tables();
    new Assets();
    new Menu();
    /*
     * Admin Notice
    **/
    $notice = reserving_app()->get(\Reserving\serviceProviders\App\Notice::class);
    $notice->run();
    
    /**
     * Settings Dashboard
     */
    $settings_loader = reserving_app()->get(Settings_Controller::class);
    $settings_loader->loader();
  }
}
new Backend();
