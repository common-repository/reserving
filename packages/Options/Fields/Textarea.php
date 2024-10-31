<?php

namespace Reserving_Packages\Options\Fields;

class Textarea extends Base_Field
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
			'rows'			=> 20,
			'cols'			=> 80,
			'sizes'			=> 'large',
			'readonly'		=> false,
		));

		// If value does not set, use the default
		if ($this->value == '') {
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
		$pro = isset($this->field['pro']) && $this->field['pro'] ? true : false;
		$pro_markup = '';

		if ($pro) {
			$pro_markup = '<sup class="pro-option">PRO</sup>';
		}

		$class = '';

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

?>
<?php if ($label): ?>
<div class="ray-form-field option-textarea-wrapper"><label
        class="ray-option-label"><?php echo esc_html($this->field['title']); ?><?php echo wp_kses_post($pro_markup); ?></label>
    <?php endif; ?>
    <div class="reserving-textarea-option-wrapper" class="<?php echo $pro ? 'disable-click' : ''; ?>">
        <textarea <?php echo esc_attr($pro ? 'disabled' : ''); ?> class="<?php echo esc_attr($class); ?>"
            name="<?php echo esc_attr($this->option_name); ?>" id="<?php echo esc_attr($this->option_id); ?>"
            cols="<?php echo (is_int($this->field['cols'])) ? $this->field['cols'] : 80; ?>"
            rows="<?php echo (is_int($this->field['rows'])) ? $this->field['rows'] : 20; ?>"><?php echo esc_textarea($this->value); ?></textarea>
        <span class="description"><?php echo esc_html($this->field['desc']); ?></span>
    </div>
    <?php if ($label): ?>
</div>
<?php endif; ?>
<?php
	}

	public function sanitize($input)
	{

		$sanitize_input =  wp_kses($input, $this->allowed_html());

		return $sanitize_input;
	}
}



?>