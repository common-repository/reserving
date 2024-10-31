<?php  

namespace Reserving_Packages\Options\Fields;

class Audio extends Base_Field {

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
			'sizes'			=> 'regular',
			'preview'		=> false
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
	 * Enqueue scripts and styles that field needed
	 *
	 * @since 1.0
	 * @return void
	 */
	public static function admin_enqueue_scripts() {
		
		wp_enqueue_media();
	
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
		wp_enqueue_media();
		$preview = $this->field['preview'];

		$class = '';
		switch ($this->field['sizes']) {
			case "small":
				$class .= ' small-text';
				break;
			case "large":
				$class .= ' small-text';
				break;
			default:
				$class .= ' regular-text';
				break;
		}
		if($label):
			
			echo wp_kses_post(sprintf('<div class="ray-form-field option-media-wrapper"><label class="ray-option-label"> %s </label><div>', esc_html($this->field['title'])));
		   
		endif; 
	?>
<div class="bookta-media-inner-option">
    <input type="text" class="<?php echo esc_attr($class); ?>" id="<?php echo esc_attr($this->option_id); ?>"
        name="<?php echo esc_attr($this->option_name); ?>" value="<?php echo esc_attr($this->value); ?>" />
    <input class="button reserving-media-button reserving-media-audio" type="button"
        data-input-id="<?php echo esc_attr($this->option_id); ?>"
        value="<?php echo esc_html__('Upload', 'reserving'); ?>" />
    <?php  if(isset($this->value) && !empty($this->value)) : ?>
    <input class="button reserving-media-delete-button" type="button"
        data-input-id="<?php echo esc_attr($this->option_id); ?>"
        value="<?php echo esc_html__('Delete', 'reserving'); ?>" />
    <br>
</div>
<?php endif; ?>
<span class="description"><?php echo esc_html($this->field['desc']); ?></span>
<?php if($label): ?>

</div>
</div>

<?php endif; ?>
<?php
	}

	public function sanitize( $value ) {

		$sanitize_value =  wp_strip_all_tags($value);

		return $sanitize_value;
	}

}



?>