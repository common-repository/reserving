<?php  

namespace Reserving_Packages\Options;

class Texonomy_Settings extends Base_Settings {

	// Hold all field classes
	var $fieldTypes = array();

	// Hold all setting fields object
	var $setting_fields = array();

	public function __construct( $parent ) {
		// Set parent to object
		$this->parent = $parent;
		$this->register_field();
		
		$this->add_hook();
	}

	/**
	 * Register actions
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function add_hook() {

		$taxonomy = isset( $this->parent->configs['taxonomy'] )? $this->parent->configs['taxonomy'] : 'category';
	  
		add_action( sprintf( '%s_edit_form_fields', $taxonomy ) , array( $this, 'render_meta_box_content' ),20 );
		add_action( sprintf( '%s_add_form_fields', $taxonomy ), [$this,'render_meta_box_content'],100 );

        add_action( sprintf( 'saved_%s', $taxonomy ), array( $this, 'save') );
        add_action( sprintf( 'edited_%s', $taxonomy ) , array( $this, 'save') );
	
	
	}

	public function save( $term_id  ) {
    
		$fields = $this->parent->configs['fields'];
	    $sanitize_data = wc_clean( $_POST );
		foreach($fields as $key => $field){
		
			if(isset($sanitize_data[$key])){
				
				if( isset($field['sub_fields'])){
				     $repeater_data = reserving_sanitize_cleaner($sanitize_data[ $key ] );
				     $data          = $this->get_transform_table_repeater_settings( $repeater_data );
				}else{
					$data = $sanitize_data[$key];
				}
				update_term_meta( $term_id , $key , $data );
			}
			
		}
	
       
    }

 	/**
     * Render Meta Box content.
     *
     * @param WP_Post $post The post object.
     */
    public function render_meta_box_content( $term ) {
  
		$fields = $this->parent->configs['fields'];
	
		if( !is_array( $fields ) ){
			return;
		}

		$term_id = null;

		if(isset($term->term_id)){
		  $term_id = $term->term_id;
		}

	
		foreach($fields as $key => $field){
			
			$field['option_name'] 	= $key;
			$field['option_id']   	= '';
			$field['id']			= $key;

			if( isset( $field[ 'type' ] ) ) {
				$field_class = $this->fieldTypes[strtolower($field['type'])];

				if( class_exists($field_class) ) {

					$value = is_null($term_id) ? '' : get_term_meta( $term_id, $key, true );

					if($field[ 'type' ] === 'repeat' && isset($value['field_count'])){
						unset($value['field_count']);	
					} 
					$render = new $field_class($field, $value, $this->parent);
					?>
					<tr class="form-field">
						<th>
							<label for="cb_taxonomy_meta_data"><?php echo esc_html($field['title']); ?></label>
				  		</th>
						<td>
							<?php echo wp_kses( $render->render_field(true) ,$this->allowed_html() ); ?>
				     	</td>
					</tr>
				<?php	
				}
			}

		}
	
        // Display the form, using the current value.
        ?>
    
        <?php
    }
	
	/**
	 * Require field class files
	 * Can be use full namespace path
	 * @since  1.0.0
	 * @return void
	 */
	public function register_field() {
		$this->fieldTypes = reserving_app()->get('register-options');
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
				
			),
			'abbr'							 => array(
				'title' => array(),
			),
			'b'								 => array(),
			'blockquote'					 => array(
				'cite' => array(),
			),
			'tbody'							 => array(
				'title' => array(),
				'class' => array(),
				'id' => array(),
			),
			'tr'							 => array(
				'title' => array(),
				'class' => array(),
				'id' => array(),
			),
			'td'							 => array(
				'title' => array(),
				'class' => array(),
				'id' => array(),
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
				'id'	 => array(),
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
			'form'							 => array(
				'action'	 => array(),
				'class'	 => array(),
				'height' => array(),
				'src'	 => array(),
				'method'	 => array(),
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
			'input'								 => array(
				'id' => array(),
				'for' => array(),
				'class' => array(),
				'autocomplete' => array(),
				'type' => [],
				'value' => [],
				'data-input-id' => []
			),
			'table'								 => array(
				'tr'	 => array(
					'td' => []
				),
				'td'	 => array(),
				'tbody'	 => array(),
				'for'	 => array(),
			),
			
			'label'								 => array(
				'class'	 => array(),
				'id'	 => array(),
				'for'	 => array(),
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
			'select'						 => array(
				'option' => [],
				'id'	 => array(),
				'class'	 => array(),
				'title'	 => array(),
				'style'	 => array(),
				'for'	 => array(),
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