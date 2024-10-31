<?php

namespace Reserving_Packages\Options\Fields;

class Time extends Base_Field
{

	/**
	 * __construct
	 *
	 * This function will setup the field type data
	 * 
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct($field, $value, $parent)
	{
		//vars
		$this->parent = $parent;
		$this->option_name = $field['option_name'];
		$this->option_id   = parent::beautifyid($field['option_name']);

		$this->value = $value;
		$this->field = wp_parse_args($field, array(
			'id'			=> '',
			'title'			=> '',
			'desc'			=> '',
			'default' 		=> '',
			'sizes'			=> 'regular',
			'readonly'		=> false,
		));

		// If value does not set, use the default
		if (is_null($this->value)) {
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
	public function render_field($label = false)
	{

		$class = 'reserving-datepicker reserving-time-local-fld';

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
		if ($label): ?>

			<div class="ray-form-field option-date-wrapper reserving-time-local">
				<label class="ray-option-label"><?php echo esc_html($this->field['title']); ?></label>
			<?php
		endif;
			?>
			<div class="reserving-time-picker-option">
				<input type="time" class="<?php echo esc_attr($class); ?>" name="<?php echo esc_attr($this->option_name); ?>"
					id="<?php echo esc_attr($this->option_id); ?>" value="<?php echo esc_attr($this->value); ?>">
				<?php if ($this->field['desc'] != ''): ?>
					<span class="description"><?php echo esc_html($this->field['desc']); ?></span>
				<?php endif; ?>
			</div>
			<?php if ($label): ?>
			</div>
		<?php endif; ?>
<?php
	}

	public function sanitize($value)
	{

		$sanitize_value =  wp_strip_all_tags($value);

		return $sanitize_value;
	}
}


?>