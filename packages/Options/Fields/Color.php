<?php  

namespace Reserving_Packages\Options\Fields;

class Color extends Base_Field {

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
			'default' 		=> '#ffffff',
			'readonly'		=> false,
		) );

		// If value does not set, use the default
		if( is_null($this->value) ) {
			$this->value = $this->field['default'];
		}

		parent::__construct($this->field);
	}

	/**
	 * Enqueue scripts
	 *
	 * Enqueue scripts and styles that field needed.
	 * This function will be called by it parent class 
	 * by default, so you don't need to add action again.
	 *
	 * @since 1.0
	 * @return void
	 */
	public static function admin_enqueue_scripts() {
		
		if( is_admin() ) {
			wp_enqueue_style( 'wp-color-picker' );
		}
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

		if($label):
			echo wp_kses_post( sprintf('<div class="ray-form-field option-color-wrapper"><label class="ray-option-label"> %s </label>', esc_html($this->field['title'])));
		endif; 
	?>
<input type="text" class="reserving-color-picker" name="<?php echo esc_attr($this->option_name); ?>"
    id="<?php echo esc_attr($this->option_id); ?>" value="<?php echo esc_attr( $this->value ); ?>">
<span class="description"><?php echo esc_html( $this->field['desc'] ); ?></span>
<?php if($label): ?>
</div>
<?php endif; ?>
<?php
	}

	public function sanitize( $input ) {

		$sanitize_input =  wp_strip_all_tags($input);
		if( !preg_match( '/^#[a-f0-9]{6}$/i', $sanitize_input ) ) {
			//add_settings_error( $setting, $code, $message, $type );
		}
		return $sanitize_input;
	}

}


?>