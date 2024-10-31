<?php  

namespace Reserving_Packages\Options\Fields;

class Base_Field {

	/**
	 * __construct
	 *
	 * This function will setup the field type data
	 *
	 * @since  1.0.0
	 * @param array $field
	 * @return void
	 */
	public function __construct( $field = array() ) {
	
		add_filter('reserving_settings_sanitize_' . $field['option_name'], array($this, 'sanitize') );
	}

	/**
	 * Default field value sanitize
	 *
	 * @since  1.0.0
	 * @param  string $value - value to filter
	 * @return string        - filtered value
	 */
	public function sanitize( $value ) {
		
		return $value;
	}

	/**
	 * Beautify ID, replace '[',']' with '_'
	 *
	 * @since  1.0.0
	 * @param  string $id - value to filter
	 * @return string     - filtered id
	 */
	public function beautifyid( $id ) {

		$new_id = str_replace('[]', '_', $id);
		$new_id = str_replace('][', '_', $new_id);
		$new_id = str_replace('[', '_', $new_id);
		$new_id = str_replace(']', '_', $new_id);
		
		if(substr($new_id, -1) == '_') {
			$new_id = substr($new_id, 0, -1);
		}
		return $new_id;
	}
	public function allowed_html(){
		$allowed_tags = array(
			'a'								 => array(
				'class'	 => array(),
				'href'	 => array(),
				'rel'	 => array(),
				'title'	 => array(),
				'target'	 => array(),
		  ),
		  'option' => array(
			 'value'	 => array(),
			 'selected' => []
		   ),
			'abbr'							 => array(
				'title' => array(),
			),
			'b'								 => array(),
			'blockquote'					 => array(
				'cite' => array(),
			),
			'cite'							 => array(
				'title' => array(),
			),
			'code'							 => array(),
			'del'							 => array(
				'datetime'	 => array(),
				'title'		 => array(),
			),
			'dd'							 => array(),
			'div'							 => array(
				'class'	 => array(),
				'title'	 => array(),
				'style'	 => array(),
			),
			'dl'							 => array(),
			'dt'							 => array(),
			'em'							 => array(),
			'h1'							 => array(),
			'h2'							 => array(),
			'h3'							 => array(),
			'h4'							 => array(),
			'h5'							 => array(),
			'h6'							 => array(),
			'i'								 => array(
				'class' => array(),
			),
			'img'							 => array(
				'alt'	 => array(),
				'class'	 => array(),
				'height' => array(),
				'src'	 => array(),
				'width'	 => array(),
			),
			'li'							 => array(
				'class' => array(),
			),
			'ol'							 => array(
				'class' => array(),
			),
			'p'								 => array(
				'class' => array(),
			),
			'textarea'	 => array(
				'class' => array(),
				'id' => array(),
				'style' => [],
				'cols' => [],
				'rows' => [],
				'name' => []
			),
			'input'								 => array(
				'class' => array(),
				'autocomplete' => array(),
				'type' => []
			),
			'sup'								 => array(
				'class'	 => array(),
				'id'	 => array(),
			),
			'q'								 => array(
				'cite'	 => array(),
				'title'	 => array(),
			),
			'span'							 => array(
				'class'	 => array(),
				'title'	 => array(),
				'style'	 => array(),
			),
			'iframe'						 => array(
				'width'			 => array(),
				'height'		 => array(),
				'scrolling'		 => array(),
				'frameborder'	 => array(),
				'allow'			 => array(),
				'src'			 => array(),
			),
			'strike'						 => array(),
			'br'							 => array(),
			'strong'						 => array(),
			'data-wow-duration'				 => array(),
			'data-wow-delay'				 => array(),
			'data-wallpaper-options'		 => array(),
			'data-stellar-background-ratio'	 => array(),
			'ul'							 => array(
				'class' => array(),
			),
		);

		return $allowed_tags;
	
	}

}

?>