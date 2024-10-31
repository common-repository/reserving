<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<?php wp_head(); ?>
	</head>
	<body <?php body_class(['reserving-header-canvas-enable']); ?>>
		<?php wp_body_open(); ?>
			<div class="reserving-header-content-wrapper">
			  <?php	do_action( 'reserving_header_canvas' ); ?>
			</div>
		?>
		
			
			
