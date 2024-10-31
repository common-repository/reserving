<?php  

namespace Reserving_Packages\Options\Fields;

class Email extends Base_Field {

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
			'default' 		=> '',
			'holder'		=> '',
			'sizes'			=> 'regular',
			'readonly'		=> false,
		) );

		// If value does not set, use the default
		if( is_null($this->value) ) {
			$this->value = $this->field['default'];
		}

		parent::__construct($this->field);
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
		$class = 'regular-text';
		if($label):
			echo wp_kses_post(sprintf('<div class="ray-form-field option-email-wrapper"><label class="ray-option-label"> %s </label>',esc_html($this->field['title'])));
		endif; 
	?>
		<input type="email" class="<?php echo esc_attr($class); ?>" name="<?php echo esc_attr($this->option_name); ?>" id="<?php echo esc_attr($this->option_id); ?>" placeholder="<?php echo esc_attr($this->field['holder']); ?>" value="<?php echo esc_attr( sanitize_email($this->value) ); ?>">
		<span class="description"><?php echo esc_html($this->field['desc']); ?></span>
		<?php if($label): ?>
		    </div>
		<?php endif; ?>	 
	<?php
	}

	public function sanitize( $input ) {

		$sanitize_input = sanitize_email( $input );

		return $sanitize_input;
	}

}


?>