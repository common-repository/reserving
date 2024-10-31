<?php

class Reserving_Product_Extra_Meta extends \Elementor\Widget_Base {

	public function get_name() {
		return 'reserving_frontend_product_extra_item';
	}

	public function get_title() {
		return esc_html__( 'Reserving Product Extra Items', 'reserving' );
	}

	public function get_icon() {
		return 'eicon-product-info';
	}

	public function get_categories() {
		return [ 'reserving' ];
	}

	public function get_keywords() {
		return [ 'reserving', 'dashboard','frontend','product', 'extra' ];
	}

	public function get_script_depends() {

		return [
			'reserving_frontend_single_product',
			
		];

	}
	public function get_style_depends() {

		return [
			'reserving_product_extra_items_style',
			
		];

	}
	protected function register_controls() {}
	protected function render() {

       echo do_shortcode( '[reserving_single_product_extra_items]' );
	
	}
}