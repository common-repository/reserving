<?php

namespace Reserving\extensions\frontend\product;
/**
 * Product Single class
 * Cart
 * @author Abdur Rohman <abdur.rohman2003@gmail.com>
 */

class Product_Grid
{
    public function register()
    {
        if (!reserving_setting_option('reserving_activate_product_quick_view', 1)) {
            return;
        }

        // header footer canvas for quickview
        add_action( 'get_header',[ $this, 'render_header' ] );
        add_action( 'get_footer',[ $this, 'render_footer' ] );
        add_filter( 'show_admin_bar',[ $this,'_admin_bar' ] );

        $this->remove_hooks();

        add_filter( 'woocommerce_loop_add_to_cart_link' , [ $this, 'show_quick_view_button' ],13,3 );
        add_action( 'woocommerce_before_shop_loop' , [ $this, 'add_product_quick_view_form' ] );
        add_action( 'woocommerce_after_single_product' , [ $this, 'add_product_quick_view_form' ] );
        add_action( 'woocommerce_after_cart' , [ $this, 'add_product_quick_view_form' ] );
        add_action( 'wp_footer' , [ $this, 'add_product_quick_view_form' ] );
        add_action( 'wp_ajax_quick_view_product_details' , [ $this, 'quick_view_product_details' ] );
        add_action( 'wp_ajax_nopriv_quick_view_product_details' , [ $this, 'quick_view_product_details' ] );
    
    }

    public function remove_hooks(){

        if ($this->is_quick_view()) {

            if(reserving_setting_option( 'reserving_dactivate_related_product', 1)){
                remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );
            }

            if(reserving_setting_option( 'reserving_dactivate_upsell_product', 1)){
                remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
            }

            if(reserving_setting_option( 'reserving_dactivate_product_breadcrumb', 1)){
                remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
            }
            
        }	

    }
     
    /**
     * Remove Header from product popup
     * @since 1.0
     */
    public function render_header() {
		
        if ( $this->active_header()) {
    
          require_once __DIR__ . '/views/default/header.php';
          $templates   = array();
          $templates[] = 'header.php';
          
          remove_all_actions( 'wp_head' );
          ob_start();
              locate_template( $templates, true );
          ob_get_clean();

       }
    }
    /**
     * Remove footer from product popup
     * @since 1.0
     */
    public function render_footer() {
   
		if ( $this->active_footer()) {
            require_once __DIR__ . '/views/default/footer.php';
        	$templates   = array();
			$templates[] = 'footer.php';
			
			remove_all_actions( 'wp_footer' );
			ob_start();
				locate_template( $templates, true );
			ob_get_clean();

		}
    }

    public function active_header(){
       
        if($this->is_quick_view()){
            if (reserving_setting_option('reserving_dactivate_header', 1)) {
                return true;
            }
        }
        return false;
    }

    public function active_footer(){
        
        if($this->is_quick_view()){

            if (reserving_setting_option('reserving_dactivate_footer', 1)) {
                return true;
            }
          
        }

        return false;
    }

    public function _admin_bar($query) {
   
        if($this->is_quick_view()){
          return false;
        }

        return $query;
    }

    public function is_quick_view(){
    
        $is_quick_view = isset($_GET['reserving-popup-type'])?sanitize_text_field($_GET['reserving-popup-type']) : false;
        
        if($is_quick_view === 'quickview'){
            return true;
        }
    
        return false;
    }
    public function add_product_quick_view_form()
    {
        wp_enqueue_style( 'reserving_frontend_popup_style' );
        wp_enqueue_style( 'reserving_product_grid_style' );
        wp_enqueue_script( 'reserving_frontend_main_js' );
        wp_enqueue_script( 'reserving_product_grid_js' );

        require_once __DIR__ . '/views/popup.php';
    }

    public function show_quick_view_button($cart_button,$product, $args)
    {
        $quick_view = reserving_text_setting_option('reserving_activate_product_quick_view', 0);
        
        if(!$quick_view){
          return $cart_button;
        }
        
        $icon_markup = '';
        $quick_view_cart = reserving_text_setting_option('reserving_quick_view_icon_cls', 'fas fa-eye');
        
        if($quick_view_cart !=''){
            $icon_markup = sprintf('<i class="%s"></i>',$quick_view_cart); 
        }
        
        $quick_view_text = reserving_text_setting_option('reserving_quick_view_text', '');
        $disable_default = reserving_setting_option('reserving_disable_default_add_to_cart', 0);
        $quick_view_content = sprintf('<button data-product_id="%s" class="reserving_quick_view_btn">%s %s</button>',
                                $product->get_id(),
                                reserving_kses($quick_view_text),
                                $icon_markup   
                            );

        if($this->has_extra_items($product)){

            if($disable_default){
                return $quick_view_content;
            }
            
            return $cart_button . $quick_view_content;
        }
 
        return $cart_button;
    }

    public function quick_view_product_details()
    {
        $product_id  = intval(sanitize_text_field($_REQUEST['product_id']));
        $product_url = get_permalink($product_id);
        setup_postdata($product_id);

        $product = wc_get_product($product_id);
        $view    = reserving_setting_option('reserving_quick_view_extra_item',0);
      
        $view_type = $view?'extra_item' :'';
        $content = '';
        if($view_type == 'extra_item'){
           $content = $this->get_product_content($product); 
        }

        $return_content = [
            'url'               => esc_url($product_url),
            'view'              => esc_html($view_type),
            'content'           => reserving_kses($content),
            'price'             => $product->get_price(),
            'get_price'         => $product->get_price(),
            'get_regular_price' => $product->get_regular_price()
        ];
        
        wp_send_json($return_content);
    }

    public function has_extra_items($product){
        $extra_items = get_post_meta($product->get_id(), 'reserving_extra_items', true);
        if (empty($extra_items)) {
            return false;
        }
        return $extra_items;
    }

    public function get_product_content($product){

    if(!$this->has_extra_items($product)){
        return;
    }
        $reserving_add_to_cart_ajax = reserving_setting_option('reserving_add_to_cart_ajax',1);
    ?>
<div class="reserving-single-item-wrapper">
    <?php
    echo wc_get_stock_html( $product ); // WPCS: XSS ok.
    if( $product->is_in_stock()): ?>
    <?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>
    <form class="cart"
        action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>"
        method="post" enctype='multipart/form-data'>
        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
        <?php do_action( 'woocommerce_before_add_to_cart_quantity' ); ?>
        <div class="reserving-cart-wrapper">
            <?php
                        $_quantity = isset($_POST['quantity']) ? sanitize_text_field($_POST['quantity']) : '';  
                        woocommerce_quantity_input(
                            array(
                                'min_value'   => apply_filters( 'woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product ),
                                'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product ),
                                'input_value' => wp_kses_post( isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_quantity ) ) : $product->get_min_purchase_quantity() ), // WPCS: CSRF ok, input var ok.
                            )
                        );
                        do_action( 'woocommerce_after_add_to_cart_quantity' );
                    ?>
            <?php wp_nonce_field(); ?>
            <button type="submit" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>"
                class="reserving--single_add--to--cart--button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>
        </div>
        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

    </form>
    <?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>
    <?php endif;
        $output = ob_get_clean();
        return $output;
    }
}