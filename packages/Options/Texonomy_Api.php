<?php

namespace Reserving_Packages\Options;

use Reserving_Packages\Options\Fields\Admin;
use Reserving_Packages\Options\Fields\Views;
use Reserving_Packages\Options\Fields\Settings;
use Reserving_Packages\Options\Texonomy_Settings;

class Texonomy_Api {

	// Hold setting configures
	var $configs = array();

	// Hold options
	var $options = array();

	// Hold default options
	var $default_options = array();

	// Hold null value options
	var $null_options = array();

	// Hold admin object
	var $mangocube_admin;

	// Hold settings object
	var $mangocube_settings;

	// Hold admin setting views object
	var $mangocube_views;

	public function __construct( $settings = array() ) {
        
		$this->configs            = wp_parse_args( $settings, $this->get_default_configs() );
		$this->mangocube_settings = new Texonomy_Settings($this);
	
	}

	/**
	 * Get default option configs
	 *
	 * @since  1.0.0
	 * @return array
	 */
	function get_default_configs() {

		$default = array(
			'title'       => esc_html__('Reserving Settings','reserving'),
			'taxonomy_id' => 'general_category',   //unique
			'taxonomy'    => 'category',
			'fields'      => []
		);

		return $default;
	}


}

