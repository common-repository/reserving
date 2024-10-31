<?php

namespace Reserving_Packages\Options\Fields;

class Media extends Base_Field
{

	/**
	 * __construct
	 * This function will setup the field type data
	 * @since 1.0.0
	 * @return void
	 */
	public function __construct($field, $value, $parent)
	{
		//vars
		$this->parent      = $parent;
		$this->option_name = $field['option_name'];
		$this->option_id   = parent::beautifyid($field['option_name']);
		$this->value       = $value;
		$this->field       = wp_parse_args($field, array(
			'id'      => '',
			'title'   => '',
			'desc'    => '',
			'default' => '',
			'sizes'   => 'regular',
			'preview' => false
		));

		// If value does not set, use the default
		if (is_null($this->value)) {
			$this->value = $this->field['default'];
		}

		parent::__construct($this->field);
	}

	/**
	 * Enqueue scripts
	 * Enqueue scripts and styles that field needed
	 * @since 1.0
	 * @return void
	 */
	public static function admin_enqueue_scripts()
	{
		wp_enqueue_media();
	}

	/**
	 * Render field
	 * Create the HTML interface for your field
	 * @param $field - an array holding all the field's data
	 * @since 1.0
	 * @return void
	 */
	public function render_field($label = false)
	{

		wp_enqueue_media();

		$preview    = $this->field['preview'];
		$pro        = isset($this->field['pro']) && $this->field['pro'] ? true : false;
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
				$class .= ' small-text';
				break;
			default:
				$class .= ' regular-text';
				break;
		}
		if ($label):
			echo wp_kses_post(sprintf(
				'<div class="ray-form-field option-media-wrapper"><label class="ray-option-label"> %s %s</label><div>',
				esc_html($this->field['title']),
				$pro_markup
			));
		endif;
?>
<div class="bookta-media-inner-option" class="<?php echo $pro ? 'disable-click' : ''; ?>">
    <input <?php echo esc_attr($pro ? 'disabled' : ''); ?> type="text" class="<?php echo esc_attr($class); ?>"
        id="<?php echo esc_attr($this->option_id); ?>" name="<?php echo esc_attr($this->option_name); ?>"
        value="<?php echo esc_attr($this->value); ?>" />
    <input <?php echo esc_attr($pro ? 'disabled' : ''); ?> class="button reserving-media-button" type="button"
        data-input-id="<?php echo esc_attr($this->option_id); ?>" value="<?php _e('Upload', 'reserving'); ?>" />
    <?php if (isset($this->value) && !empty($this->value) && !$pro) : ?>
    <input class="button reserving-media-delete-button" type="button"
        data-input-id="<?php echo esc_attr($this->option_id); ?>" value="<?php _e('Delete', 'reserving'); ?>" />
    <br>
</div>
<?php if ($preview) : ?>
<p class="reserving-image-preview"><img src="<?php echo esc_attr($this->value); ?>"
        alt="<?php echo esc_html__('image', 'reserving'); ?>"></p>
<?php endif; ?>
<?php endif; ?>

<span class="description"><?php echo esc_html($this->field['desc']); ?></span>

<?php if ($label): ?>
</div>
</div>
<?php endif; ?>
<?php
	}

	public function sanitize($value)
	{
		return wp_kses_post($value);
	}
}



?>