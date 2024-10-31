<?php

class Reserving_Product_Extra_Price extends \Elementor\Widget_Base {

	public function get_name() {
		return 'reserving_frontend_product_price';
	}

	public function get_title() {
		return esc_html__( 'Reserving Product Extra Price', 'reserving' );
	}

	public function get_icon() {
		return 'eicon-price-list';
	}

	public function get_categories() {
		return [ 'reserving' ];
	}

	public function get_keywords() {
		return [ 'reserving', 'dashboard','frontend','product', 'extra','price' ];
	}
	protected function register_controls() {}
	protected function render() {
       echo do_shortcode( '[reserving_single_product_price]' );
	}
}