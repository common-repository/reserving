<?php

namespace Reserving_Packages\Options\Fields;

class ShortCode extends Base_Field
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
			'pro'			=> false,
			'desc'			=> '',
			'default'		=> ''
		));

		// If value does not set, use the default
		if (is_null($this->value)) {
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
	public function render_field($label = false)
	{
		$pro = isset($this->field['pro']) && $this->field['pro'] == 1 ? true : false;
		$pro_markup = '';
		if ($pro) {
			$pro_markup = '<sup class="pro-option">PRO</sup>';
		}
?>
		<div class="reserving-shortcode-option-wrapper">
			<?php if (isset($this->field['img_src'])): ?>
				<img src="<?php echo esc_url($this->field['img_src']); ?>" />
			<?php endif; ?>
			<div class="reserving-shortcode-content-wrapper <?php echo $pro ? 'disable-click' : ''; ?>">
				<h4> <?php echo esc_html($this->field['title']); ?>
					<?php echo wp_kses_post($pro_markup); ?>
				</h4>
				<?php

				if (!empty($this->field['desc'])) {
					echo '<div class="reserving-shortcode-option">';
					echo '<div contentEditable="true" class="description reserving-shortcode-editor-option">' . wp_kses_post($this->field['desc']) . '</div>';
					echo wp_kses_post(sprintf("<span class='reserving-copy-shortcode-text'>%s</span>", esc_html__('Copy', 'reserving')));
					echo '</div>';
				}
				?>
			</div>
		</div>
<?php
	}
}
