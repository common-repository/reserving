<?php

function reserving_get_block_attr($block,$return_attr = [ 'render_callback' ]){
    
	if($block == ''){
	  return false;
	}

    if(!is_array($return_attr)){
        return false;
    }

    if(!file_exists(reserving_option_fix_path(RESERVING_DIR_PATH . 'app/extensions/frontend/build/blocks/'.$block.'/block.json'))){
      return false;  
	}

	$return_data = []; 
	$data = wp_json_file_decode(reserving_option_fix_path(RESERVING_DIR_PATH . 'app/extensions/frontend/build/blocks/'.$block.'/block.json'), ['associative' => true]); 	
   
    foreach( $return_attr as $key ){
      if(isset($data[$key]) && $data[$key] !=''){
        $return_data[$key] = $data[$key];
      }
    }

    if(empty($return_data)){
        return false;
    }
    
    return $return_data;
}

function reserving_ready_get_dir_list($path = 'blocks'){

	$widgets_modules = [];
	$dir_path        = RESERVING_DIR_PATH."app/extensions/frontend/build/".$path;
	$dir             = new \DirectoryIterator($dir_path);
	 
	 foreach ($dir as $fileinfo) {
		 if ($fileinfo->isDir() && !$fileinfo->isDot()) {
			 $widgets_modules[$fileinfo->getFilename()] = $fileinfo->getFilename();
			
		 }
	 }

	 return $widgets_modules;
}


function reserving_css_array_to_css($rules, $indent = 0) {

    $css = '';
    $prefix = str_repeat('  ', $indent);

    foreach ($rules as $key => $value) {
        if (is_array($value)) {
            $selector = $key;
            $properties = $value;

            $css .= $prefix . "$selector {\n";
            $css .= $prefix . reserving_css_array_to_css($properties, $indent + 1);
            $css .= $prefix . "}\n";
        } else {
            $property = $key;
            $css .= $prefix . "$property: $value;\n";
        }
    }

    return $css;
}