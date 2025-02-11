<?php 

namespace Reserving\serviceProviders\App;

/**
 * Show Notice Admin
 * 
 */
Class Notice {
  
    public function run()
	{
		
		/*----------------------------------
			Check for required Dependency Plugin
		-----------------------------------*/
		if ( !class_exists( 'WooCommerce' ) ) {
			add_action( 'admin_notices', [ $this, 'admin_notice_woocommerce_install' ] );
			return false;
		}

	}

    public function admin_notice_woocommerce_install() {
	
		$con = esc_html__( 'Click to Install', 'reserving');
	
		if( file_exists(WP_PLUGIN_DIR .'/woocommerce/woocommerce.php' ) ) {
	
			$er_url = reserving_plugin_activation_link_url('woocommerce/woocommerce.php');
			$con    = esc_html__( 'Click to Activate', 'reserving');
			
		}else{

			$con    = esc_html__( ' Click to Install ', 'reserving');
			$action = 'install-plugin';
			$slug   = 'woocommerce';

			$er_url = wp_nonce_url(
				add_query_arg(
					array(
						'action' => $action,
						'plugin' => $slug
					),
					admin_url( 'update.php' )
				),
				$action.'_'.$slug
			);
		}
	
		if ( isset( $_GET['activate'] ) ) unset( $_GET['activate'] );

		if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			$message =  sprintf(
				esc_html__( '"%1$s" requires "%2$s"', 'reserving' ),
				'<strong>' .RESERVING_ITEM_NAME . '</strong>',
				'<strong>' . esc_html__( 'WooCommerce', 'reserving' ) . '</strong>'
			);
		}else{

			$message = sprintf(
				esc_html__( '"%1$s" requires "%2$s" %3$s', 'reserving' ),
				'<strong>' . RESERVING_ITEM_NAME. '</strong>',
				'<strong>' . esc_html__( 'WooCommerce', 'reserving' ) . '</strong>',
				'<strong> <a href="'.esc_url($er_url).'">' . $con  . '</a></strong>'
			);
		}
	    ?>
		<div class="notice reserving-notice notice-warning is-dismissible"><p> <?php echo wp_kses_post($message); ?> </p></div>
		<?php
		unset( $er_url );
		unset( $con );
		unset( $message );

	}

}

