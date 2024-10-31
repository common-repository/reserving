<?php

namespace Reserving_Packages\Options\Fields;

class Select extends Base_Field
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
			'holder'		=> __('Select', 'reserving'),
			'sizes'			=> 'regular',
			'readonly'		=> false,
			'options'		=> null
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

		$options = (array) $this->field['options'];
		$pro = isset($this->field['pro']) && $this->field['pro'] ? true : false;
		$pro_markup = '';

		if ($pro) {
			$pro_markup = '<sup class="pro-option">PRO</sup>';
		}

		$class = '';
		switch ($this->field['sizes']) {
			case "small":
				$class .= ' reserving-small-select';
				break;
			case "large":
				$class .= ' reserving-large-select';
				break;
			default:
				$class .= ' reserving-regular-select';
				break;
		}


?>
		<?php if ($label): ?>
			<?php
			echo wp_kses_post(sprintf('<div class="ray-form-field form-field option-select-wrapper"><label class="ray-option-label"> %s </label>', esc_html($this->field['title'])));
			?>
		<?php endif; ?>
		<div>
			<select <?php echo esc_attr($pro ? 'disabled' : ''); ?>
				class="<?php echo esc_attr($class); ?> <?php echo $pro ? 'disable-click' : ''; ?> "
				name="<?php echo esc_attr($this->option_name); ?>" id="<?php echo esc_attr($this->option_id); ?>">
				<?php
				// Placeholder
				if (empty($this->value) && !empty($options)) {
					echo '<option value="" disabled selected>' . esc_html($this->field['holder']) . '</option>';
				} elseif (empty($options)) {
					echo '<option value="" disabled selected>' . __('Nothing found.', 'reserving') . '</option>';
				}

				foreach ($options as $val => $label) {
					echo wp_kses(sprintf(
						'<option value="%1$s" %2$s >%3$s</option>',
						esc_attr($val),
						selected($val, $this->value, false),
						esc_html($label)
					), $this->allowed_html());
				}

				?>
			</select>
			<?php if ($label): ?>
				<?php echo wp_kses($pro_markup, $this->allowed_html()); ?>
			<?php endif ?>
		</div>
		<?php if ($this->field['desc'] != ''): ?>
			<span class="description"><?php echo esc_html($this->field['desc']); ?></span>
		<?php endif ?>
		<?php if ($label): ?>
			</div>
		<?php endif; ?>
<?php
	}

	public function sanitize($input)
	{

		$sanitize_input = $input;

		return $sanitize_input;
	}
}
