<?php  

namespace Reserving_Packages\Options\Fields;

class Heading extends Base_Field {

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
			'default'		=> ''
		) );

		// If value does not set, use the default
		if( is_null($this->value) ) {
			$this->value = $this->field['default'];
		}

		//parent::__construct($field);
	}

	/**
	 * Render field
	 * Create the HTML interface for your field
	 * @param $field - an array holding all the field's data
	 * @since 1.0
	 * @return void
	 */
	public function render_field($label = false) {
	?>
		<hr>
	<?php
		if( !empty($this->field['desc']) ) {
		  echo wp_kses_post( sprintf('<p class="description">%s</p>',$this->field['desc']) );
		}
	}

}


?>