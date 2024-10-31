<?php

namespace Reserving_Packages\Options\Fields;

class Post_Select extends Base_Field {
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
			'holder'		=> __('Select', 'reserving'),
			'sizes'			=> 'regular',
			'readonly'		=> false,
			'data'			=> array('post_type' => 'page')
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

		$options = array();

		// Checks if post type exists
		if( !post_type_exists( $this->field['data']['post_type'] ) ) {
			echo '<p class="description>' . __("Post type does not exist!", 'reserving') . '</p>';
			return ;
		} 

		$page_args = wp_parse_args( $this->field['data'], array(
			'post_type' => 'page',
			'posts_per_page' => -1
		) );

		$page_query = new \WP_Query($page_args);
		if($page_query->have_posts()) :
			while($page_query->have_posts()) :
				$page_query->the_post();
				$options[get_the_ID()] = get_the_title();
			endwhile;
		endif;
		wp_reset_postdata();

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
		if($label):
			echo wp_kses_post( sprintf('<div class="ray-form-field option-post-select-wrapper"><label class="ray-option-label"> %s </label>',esc_html($this->field['title'])));
		 endif; 
	?>
	     
		<select class="<?php echo esc_attr($class); ?>" name="<?php echo esc_attr($this->option_name); ?>" id="<?php echo esc_attr($this->option_id); ?>">
		<?php  
			// Placeholder
			if( empty($this->value) && !empty($options) ) {
				echo '<option value="" disabled selected>'. esc_html($this->field['holder']) .'</option>';
			} elseif ( empty($options) ) {
				echo '<option value="" disabled selected>'. __('Nothing found.', 'reserving') .'</option>';
			}

			foreach ($options as $val => $label) {
			 	echo wp_kses_post( sprintf('<option value="%1$s" %2$s>%3$s</option>',
					esc_attr($val),
					selected( $val, $this->value, false ),
					esc_html($label)
				));
			}
		?>
		</select>
		<span class="description"><?php echo esc_html($this->field['desc']); ?></span>
		<?php if($label): ?>
		    </div>
		<?php endif; ?>	 
	<?php

	}

	public function sanitize( $input ) {

		$sanitize_input = intval($input);

		return $sanitize_input;
	}
}

