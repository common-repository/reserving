<?php

namespace Reserving_Packages\Options\Fields;

class Text extends Base_Field
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
			'pro' 		    => false,
			'default' 		=> '',
			'sizes'			=> 'regular',
			'readonly'		=> false
		));


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
			<div class="ray-form-field option-text-wrapper"><label
					class="ray-option-label"><?php echo esc_html($this->field['title']); ?><?php echo wp_kses_post($pro_markup); ?></label>
			<?php endif; ?>
			<div class="reserving-text-field-wrapper <?php echo $pro ? 'disable-click' : ''; ?>">
				<input <?php echo esc_attr($pro ? 'disabled' : ''); ?>
					placeholder="<?php echo esc_attr($this->field['default']); ?>" type="text"
					class="<?php echo esc_attr($class); ?>" name="<?php echo esc_attr($this->option_name); ?>"
					id="<?php echo esc_attr($this->option_id); ?>" value="<?php echo esc_attr($this->value); ?>">
				<span class="description"><?php echo esc_html($this->field['desc']); ?></span>
			</div>
			<?php if ($label): ?>
			</div>
		<?php endif; ?>

<?php
	}
	/**
	 * Default field sanitize 
	 * @param  $value 			value to filter 			
	 * @return $sanitize_value  filtered value
	 */
	public function sanitize($value)
	{

		$sanitize_value = trim($value);
		return $sanitize_value;
	}
}


?>