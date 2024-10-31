<?php

namespace Reserving\extensions\frontend\cart;

/**
 * Cart Update class
 *
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */

class Cart_Update
{

    public function register()
    {

        add_action( 'wp_ajax_reserving_cart_cookie_update', [$this,'after_cart_updated'] );
        add_action( 'wp_ajax_nopriv_reserving_cart_cookie_update', [$this,'after_cart_updated'] );
        
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_filter( 'woocommerce_update_cart_action_cart_updated', [ $this, 'after_cart_updated' ], 9999 );
       
        $checkout_location = trim(reserving_setting_option( 'cart_tip_checkout_position', 'woocommerce_review_order_before_submit'));
        $cart_location = trim(reserving_setting_option( 'cart_tip_cart_position', 'woocommerce_before_cart_totals'));
        
        if(reserving_setting_option( 'cart_tip_enable', 0)){

            add_action( 'woocommerce_cart_calculate_fees', [$this,'add_tip_fees'],150 );
            // Cart Page
            if($cart_location !=''){
                add_action( $cart_location, [ $this, '_cart_tips_html' ] );
            }
            
            // checkout page  
            if($checkout_location !=''){
                add_action( $checkout_location, [ $this, '_cart_tips_html' ] );
            }
          
        }
      
    }
 
    public function add_tip_fees($cart){

        $tip_fld           = reserving_setting_option('cart_tip_fld_label','tip');
        $percentage_enable = reserving_setting_option('cart_tip_percentage_enable',1);
        $type              = WC()->session->get( 'reserving_cart_tip_type' );
        $flat_amount       = WC()->session->get( 'reserving_cart_tip_amount' );
 
        if($percentage_enable && $type == 'percentage'){

            $percent = $flat_amount / 100;
            $charge  = ( WC()->cart->cart_contents_total + WC()->cart->shipping_total ) * $percent;	
            $cart->add_fee( esc_html($tip_fld) , wc_clean($charge) );
        }else{
           
            $cart->add_fee( esc_html($tip_fld) , wc_clean($flat_amount) );
        } 
         
    }
    public function _cart_tips_html(){
       echo do_shortcode( '[reserving_cart_tip]' );
    }

    /**
     * Recalculate after updating cart
     */
    public function after_cart_updated($cart_updated)
    {
     
        if(isset($_COOKIE['reserving_extra_quantities'])){
            // data sanitize
            $sanitize_data = sanitize_text_field($_COOKIE[ 'reserving_extra_quantities' ]);
            $quantities = (array)json_decode(stripslashes( $sanitize_data ), true);
            $this->update_cart($quantities);
        }
        return WC()->cart->get_cart();
    }


    public function update_cart($quantities)
    {
        $cart = WC()->cart->cart_contents;

        foreach ($cart as $itemKey => $cart_item) {
            $price = $cart_item['data']->get_price();
            $product_id = $cart_item['product_id'];
            $extra_price = 0;
            $extra_quantities = $quantities[$itemKey];
            $extra_unit_prices = get_post_meta($product_id, 'reserving_extra_items', false)[0];
           
            if( isset( $cart_item[ 'reserving_extra_items' ] ) ){
                
                foreach ($cart_item['reserving_extra_items'] as $key => $item) {
                    $unit_price = floatval($extra_unit_prices[$key]['price']);
                    if (isset($cart_item['reserving_extra_items'][$key]['quantity'])) {
                        $cart[$itemKey]['reserving_extra_items'][$key]['quantity'] = floatval($extra_quantities[$key]);
                        $extra_price += (floatval($extra_quantities[$key]) * $unit_price);
                    }
                }
            }
   
            $cart[$itemKey]['line_subtotal'] = ($price + $extra_price);
            $cart[$itemKey]['line_total'] = ($price + $extra_price);
        }

        WC()->cart->cart_contents = $cart;

        WC()->cart->calculate_totals();
        WC()->cart->set_session();
    }

    /**
     * Enqueue JS file
     */
    function enqueue_scripts()
    {
        wp_enqueue_script('reserving_update_cart_item');
        wp_localize_script(
            'reserving_update_cart_item',
            'reserving_update_cart_vars',
            array(
                'ajaxurl' => esc_url( admin_url('admin-ajax.php') )
            )
        );
    }
}
