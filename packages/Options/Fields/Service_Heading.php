<?php  

namespace Reserving_Packages\Options\Fields;

class Service_Heading extends Base_Field {

	/**
	 * __construct
	 *
	 * This function will setup the field type data
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct( $field, $value, $parent ) {
		//vars
		$this->parent = $parent;
		$this->option_name = $field['option_name'];
		$this->option_id   = parent::beautifyid($field['option_name']);

		$this->value = $value;
		$this->field = wp_parse_args( $field, array(
			'id'			=> '',
			'title'			=> '',
			'desc'			=> '',
			'default'		=> ''
		) );

		// If value does not set, use the default
		if( is_null($this->value) ) {
			$this->value = $this->field['default'];
		}

		//parent::__construct($field);
	}

	/**
	 * Render field
	 *
	 * Create the HTML interface for your field
	 *
	 * @param $field - an array holding all the field's data
	 *
	 * @since 1.0
	 * @return void
	 */
	public function render_field($label = false) {

	$pro = isset($this->field['pro']) && $this->field['pro'] ? true : false;
	$pro_markup = '';
	if($pro){
		$pro_markup = '<sup class="pro-option">PRO</sup>';	
	}

	?>
	  <div class="reserving-service-heading-option-wrapper">	
			<?php if(isset($this->field['img_src'])): ?>
					<img src="<?php echo esc_url($this->field['img_src']); ?>" />
			<?php endif; ?>
	    	<div class="reserving-service-heading-content-wrapper">
				<h4> <?php echo esc_html($this->field['title']); ?><?php echo wp_kses($pro_markup,$this->allowed_html()); ?></h4>
				<?php
            		if( !empty($this->field['desc']) ) {
					  echo wp_kses_post( sprintf('<p class="description reserving-service-desc">%s</p>', esc_html($this->field['desc'])));
				    }
				?>		
	       </div>
	    </div>
    <?php

	}

}
