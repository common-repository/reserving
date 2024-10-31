<?php  

namespace Reserving_Packages\Options\Fields;

class Date_Time extends Base_Field {

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

		$class = 'reserving-datepicker reservingdatetime-local-fld';

		switch ($this->field['sizes']) {
			case "small":
				$class .= ' small-text';
				break;
			case "large":
				$class .= ' large-text';
				break;
			default:
				$class .= ' regular-text';
				break;
		}
		if($label):
	
			echo wp_kses_post(sprintf('<div class="ray-form-field option-date-wrapper reserving-datetime-local"><label class="ray-option-label"> %s </label>', esc_html($this->field['title'])));
		   
		endif; 
	?>
<div class="reserving-datetime-picker-option">
    <input type="datetime-local" class="<?php echo esc_attr($class); ?>"
        name="<?php echo esc_attr($this->option_name); ?>" id="<?php echo esc_attr($this->option_id); ?>"
        value="<?php echo esc_attr($this->value); ?>">
    <?php if($this->field['desc'] !=''): ?>
    <span class="description"><?php echo wp_kses_post($this->field['desc']); ?></span>
    <?php endif; ?>
</div>
</div>
<?php if($label): ?>
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