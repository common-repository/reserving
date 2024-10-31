<?php

function reserving_frontend_dashboard_optins_dynamic_render_callback( $block_attributes, $content ) {

    $label_style = '';
    if(isset($block_attributes['buttonlabelColorField'])){
        $label_style = "color:".$block_attributes['buttonlabelColorField'];
    }
   
    $button_style = isset($block_attributes['button_style']) ? $block_attributes['button_style'] : '';
    $stylesheet = array(
        ".login-submit .button" => $button_style
    );

    $arr = [
		'default_login'    => isset($block_attributes['loginurlField']) ? $block_attributes['loginurlField'] : '#',
		'login_button_msg' => isset($block_attributes['headingField']) ? $block_attributes['headingField'] : '',
		'button_text'      => isset($block_attributes['buttonlField']) ? $block_attributes['buttonlField'] : 'Button',
		'show_login_form'  => isset($block_attributes['radiologinformField']) && $block_attributes['radiologinformField'] == 'yes'? true : false 
	];

    ob_start();

    ?>
  
    <?php

    $shortcode_with_var = sprintf( '[reserving_frontend_dashboard default_login="%s" login_button_msg="%s" button_text="%s" show_login_form="%s" ]',
    esc_url($arr['default_login']),
    esc_html($arr['login_button_msg']), 
    esc_html($arr['button_text']), 
    esc_attr($arr['show_login_form'])
    
   );

    echo do_shortcode( $shortcode_with_var );
    $content = ob_get_clean();
    return $content;
}

function reserving_availabil_checker_render_callback( $block_attributes, $content ) {
   ob_start();
    ?>
    <div class="reserving--availability--checker">  
        <?php
            echo do_shortcode( '[reserving_availability_checker]' );
        ?>
    </div>
    <?php
    $content = ob_get_clean();
    return $content;
}