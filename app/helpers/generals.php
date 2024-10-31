<?php


if (!function_exists('reserving_kses')) {

	// WP kses allowed tags
	// ----------------------------------------------------------------------------------------
	function reserving_kses($raw)
	{

		$allowed_tags = array(
			'button'								 => array(
				'class'	 => array(),
				'id'	 => array(),
				'title'	 => array(),
				'style'	 => array(),
				'type'	 => array(),
				'value' => array()
			),
			'a'								 => array(
				'class'	 => array(),
				'href'	 => array(),
				'rel'	 => array(),
				'title'	 => array(),
				'target' => array()
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
				'class'      => array(),
				'data-value' => [],
				'onclick'    => []
			),
			'ol'							 => array(
				'class' => array(),
				'id' => array(),
			),
			'ul'							 => array(
				'class' => array(),
				'id' => array(),
			),
			'p'								 => array(
				'class' => array(),
				'id' => array(),
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
			'input'								 => array(
				'id' => array(),
				'for' => array(),
				'class' => array(),
				'name' => array(),
				'style' => array(),
				'autocomplete' => array(),
				'type' => [],
				'checked' => [],
				'selected' => [],
				'value' => [],
				'data-input-id' => []
			),
			'table'								 => array(
				'td'	 => array(),
				'tbody'	 => array(),
				'for'	 => array(),
				'style'	 => array(),
				'class'	 => array(),
				'id'	 => array(),
			),
			'sup'								 => array(
				'class'	 => array(),
				'id'	 => array(),
			),
			'tr'								 => array(
				'class'	 => array(),
				'id'	 => array(),
				'style'	 => array(),
			),
			'td'								 => array(
				'class'	 => array(),
				'id'	 => array(),
				'scope'	 => array(),
				'style'	 => array(),
			),
			'label'								 => array(
				'class'	 => array(),
				'id'	 => array(),
				'for'	 => array(),
				'style'	 => array(),
			),
			'th'								 => array(
				'class'	 => array(),
				'id'	 => array(),
				'scope'	 => array(),
			),
			'select'							 => array(
				'class'  => array(),
				'id'     => array(),
				'name'   => array(),
				'value'  => array(),
				'type'   => array(),
				'onchange' => []
			),
			'option' => [
				'value'    => [],
				'class'    => [],
				'id'       => [],
				'selected' => [],
				'disabled' => []
			],
			'input' => [
				'name' => [],
				'id' => [],
				'type' => [],
				'class' => [],
				'style' => [],
				'value' => [],
			],
			'form' => [
				'method' => [],
				'action' => [],
				'enctype' => [],
				'class' => [],
				'id' => []
			]
		);

		if (function_exists('wp_kses')) { // WP is here
			$allowed = wp_kses($raw, $allowed_tags);
		} else {
			$allowed = $raw;
		}
		return $allowed;
	}
}

if (! function_exists('reserving_percentage_change')) {
	/**
	 * Generate percentage change between two numbers.
	 *
	 * @param int|float $old
	 * @param int|float $new
	 * @param int $precision
	 * @return float
	 */
	function reserving_percentage_change($old, $new, int $precision = 2)
	{
		if ($old == 0) {
			$old++;
			$new++;
		}

		$change = (($new - $old) / $old) * 100;

		return number_format($change, $precision);
	}
}

/**
 * Get Page Ids
 * @version 1.0 very beginning
 * @return array
 */
function reserving_default_pages_options()
{
	$pages = get_pages();
	$return_pages = [
		'' => 'none'
	];
	foreach ($pages as $page) {
		$return_pages[$page->ID] = $page->post_title;
	}

	return $return_pages;
}
/**
 * Resize any image from
 *
 * @param url  $url image 
 * @param mix $width image width size false for auto
 * @param mix $height image height size false for auto
 * @param boolen  $crop 
 * @return url string path
 * @version 1.0 very beginning
 * 
 */
if (!function_exists('reserving_resize')) {
	function reserving_resize($url, $width = false, $height = false, $crop = false)
	{

		$reserving_resize = \Reserving\helpers\resize::getInstance();
		$response  = $reserving_resize->process($url, $width, $height, $crop);

		return (!is_wp_error($response) && !empty($response['src'])) ? $response['src'] : $url;
	}
}

/**
 * @return bool
 * @param domain
 */
if (!function_exists('reserving_is_valid_domain_name')) {

	function reserving_is_valid_domain_name($domain_name)
	{
		return (preg_match("/^([a-z\d](-*[a-z\d])*)(\.([a-z\d](-*[a-z\d])*))*$/i", $domain_name) // valid chars check
			&& preg_match("/^.{1,253}$/", $domain_name) // overall length check
			&& preg_match("/^[^\.]{1,63}(\.[^\.]{1,63})*$/", $domain_name)); // length of each label
	}
}


/**
 * Safe load variables from an file
 * Use this function to not include files directly and to not give access to current context variables (like $this)
 *
 * @param string $file_path
 * @param array $_extract_variables Extract these from file array('variable_name' => 'default_value')
 * @param array $_set_variables Set these to be available in file (like variables in view)
 *
 * @return array
 */
function reserving_get_variables_from_file($file_path, array $_extract_variables, array $_set_variables = array())
{
	extract($_set_variables, EXTR_REFS);
	unset($_set_variables);

	require $file_path;

	foreach ($_extract_variables as $variable_name => $default_value) {
		if (isset($$variable_name)) {
			$_extract_variables[$variable_name] = $$variable_name;
		}
	}

	return $_extract_variables;
}

/**
 * Safe render a view and return html
 * In view will be accessible only passed variables
 * Use this function to not include files directly and to not give access to current context variables (like $this)
 *
 * @param string $file_path
 * @param array $view_variables
 * @param bool $return In some cases, for memory saving reasons, you can disable the use of output buffering
 *
 * @return string HTML
 */
function reserving_render_view($file_path, $view_variables = array(), $return = true)
{

	if (!is_file($file_path)) {
		return '';
	}

	extract($view_variables, EXTR_REFS);
	unset($view_variables);

	if ($return) {
		ob_start();
		require $file_path;

		return ob_get_clean();
	} else {
		require $file_path;
	}

	return '';
}

/**
 * Generate html tag
 *
 * @param string $tag Tag name
 * @param array $attr Tag attributes
 * @param bool|string $end Append closing tag. Also accepts body content
 *
 * @return string The tag's html
 */
function reserving_html_tag($tag, $attr = array(), $end = false)
{
	$html = '<' . $tag . ' ' . reserving_attr_to_html($attr);

	if ($end === true) {
		# <script></script>
		$html .= '></' . $tag . '>';
	} else if ($end === false) {
		# <br/>
		$html .= '/>';
	} else {
		# <div>content</div>
		$html .= '>' . $end . '</' . $tag . '>';
	}

	return $html;
}

/**
 * Convert to Unix style directory separators
 *  @param string $path url
 */
function reserving_fix_path($path)
{

	$windows_network_path = isset($_SERVER['windir']) && in_array(
		substr($path, 0, 2),
		array('//', '\\\\'),
		true
	);
	$fixed_path           = untrailingslashit(str_replace(array('//', '\\'), array('/', '/'), $path));

	if (empty($fixed_path) && !empty($path)) {
		$fixed_path = '/';
	}

	if ($windows_network_path) {
		$fixed_path = '//' . ltrim($fixed_path, '/');
	}

	return $fixed_path;
}


/**
 * Strip slashes from values, and from keys if magic_quotes_gpc = On
 */
function reserving_stripslashes_deep_keys($value)
{
	static $magic_quotes = null;
	if ($magic_quotes === null) {
		$magic_quotes = false; //https://www.php.net/manual/en/function.get-magic-quotes-gpc.php - always returns FALSE as of PHP 5.4.0. false fixes https://github.com/ThemeFuse/Unyson/issues/3915
	}

	if (is_array($value)) {
		if ($magic_quotes) {
			$new_value = array();
			foreach ($value as $key => $val) {
				$new_value[is_string($key) ? stripslashes($key) : $key] = reserving_stripslashes_deep_keys($val);
			}
			$value = $new_value;
			unset($new_value);
		} else {
			$value = array_map('reserving_stripslashes_deep_keys', $value);
		}
	} elseif (is_object($value)) {
		$vars = get_object_vars($value);
		foreach ($vars as $key => $data) {
			$value->{$key} = reserving_stripslashes_deep_keys($data);
		}
	} elseif (is_string($value)) {
		$value = stripslashes($value);
	}

	return $value;
}


/**
 * Use this id do not want to enter every time same last two parameters
 * Info: Cannot use default parameters because in php 5.2 encoding is not UTF-8 by default
 * @param string $string
 * @return string
 */
function reserving_htmlspecialchars($string)
{
	return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

/**
 * Generate attributes string for html tag
 *
 * @param array $attr_array array('href' => '/', 'title' => 'Test')
 *
 * @return string 'href="/" title="Test"'
 */
function reserving_attr_to_html(array $attr_array)
{
	$html_attr = '';

	foreach ($attr_array as $attr_name => $attr_val) {

		if ($attr_val === false) {
			continue;
		}

		$html_attr .= $attr_name . '="' . reserving_htmlspecialchars($attr_val) . '" ';
	}

	return $html_attr;
}
/**
 * Fetches post types. Based on helper functions developed inhouse.
 * @since 1.0
 * @param boolean $public - Queries the get_post_types to fetch publicly-available post types.
 * @param string $value - Fetches post types that are builtin, custom, or both. Values can be 'builtin', 'custom', or the default value, 'all'.
 */
function reserving_get_post_types($public = true, $value = 'all')
{
	// Fetch builtin post types.
	$args_builtin = array(
		'public' => $public,
		'_builtin' => true,
	);
	$post_types_builtin = get_post_types($args_builtin, 'objects');
	// Fetch custom post types.
	$args_custom = array(
		'public' => $public,
		'_builtin' => false,
	);
	$post_types_custom = get_post_types($args_custom, 'objects');
	// Converge or pick post types based on selection.
	switch ($value) {
		case 'builtin':
			$post_types = $post_types_builtin;
			break;

		case 'custom':
			$post_types = $post_types_custom;
			break;

		default:
			$post_types = array_merge($post_types_builtin, $post_types_custom);
			break;
	}
	return $post_types;
}

/**
 * Service Container
 * @since 1.0
 * @return container object
 */
if (!function_exists('reserving_app')) {

	function reserving_app()
	{

		static $container = null;
		if (!$container instanceof \Reserving_Packages\DI\Container) {
			$container = new Reserving_Packages\DI\Container();
		}
		return $container;
	}
}

/**
 * @return filelist
 * @since 1.0
 * @param path
 * @param extention
 */
if (!function_exists('reserving_get_dir_file_list')) {

	function reserving_get_dir_file_list($dir = 'dir', $ext = 'php')
	{
		if (!is_dir($dir)) {
			return [];
		}

		$files = [];

		foreach (glob("$dir/*.$ext") as $filename) {
			$files[basename(dirname($filename)) . '-' . basename($filename, '.' . $ext)] = $filename;
		}

		return $files;
	}
}

if (!function_exists('reserving_plugin_activation_link_url')) {

	/*****
	 * @return url
	 * @since 1.0
	 * @param plugin file name
	 * 
	 */
	function reserving_plugin_activation_link_url($plugin = 'woocommerce/woocommerce.php')
	{
		$activateUrl = sprintf(admin_url('plugins.php?action=activate&plugin=%s&plugin_status=all&paged=1&s'), $plugin);
		// change the plugin request to the plugin to pass the nonce check
		$_REQUEST['plugin'] = $plugin;
		$activateUrl = wp_nonce_url($activateUrl, 'activate-plugin_' . $plugin);

		return esc_url($activateUrl);
	}
}

if (!function_exists('reserving_sanitize_cleaner')) {

	function reserving_sanitize_cleaner($var)
	{
		if (is_array($var)) {
			return array_map('reserving_sanitize_cleaner', $var);
		} else {
			return is_scalar($var) ? sanitize_text_field($var) : $var;
		}
	}
}

if (!function_exists('reserving_get_current_user_role')) {

	function reserving_get_current_user_role()
	{
		if (is_user_logged_in()) { // check if there is a logged in user 

			$user = wp_get_current_user(); // getting & setting the current user 
			$roles = (array) $user->roles; // obtaining the role 
			return $roles; // return the role for the current user 
		} else {
			return array(); // if there is no logged in user return empty array  
		}
	}
}

if (!function_exists('reserving_get_order_status')) {

	function reserving_get_order_status($status_key)
	{
		$order_statuses = wc_get_order_statuses();

		$order_status = $status_key;

		foreach ($order_statuses as $key => $value) {
			if ($key == 'wc-' . $status_key) {
				$order_status =  $value;
			}
		}
		return $order_status;
	}
}

if (!function_exists('reserving_setting_option')) {

	function reserving_setting_option($key, $default = '')
	{
		static $options = null;

		if ($options == null) {
			$options =	get_option('reserving_options');
		}

		if (isset($options[$key])) {
			return $options[$key];
		}

		return $default;
	}
}

if (!function_exists('reserving_text_setting_option')) {

	function reserving_text_setting_option($key, $default = '')
	{
		static $options = null;

		if ($options == null) {
			$options =	get_option('reserving_options');
		}

		if (isset($options[$key]) && $options[$key] != '') {
			return $options[$key];
		}

		return $default;
	}
}

if (!function_exists('reservingCreateTimeSlots')) {

	function reservingCreateTimeSlots($StartTime, $EndTime, $Duration = "60")
	{
		$timeSlots = array(); // Define output
		$StartTime    = strtotime($StartTime); //Get Timestamp
		$EndTime      = strtotime($EndTime); //Get Timestamp

		$AddMins  = $Duration * 60;

		while ($StartTime <= $EndTime) //Run loop
		{
			$start_time_arr = explode(':', gmdate("G:i", $StartTime));

			$start_time_hour = str_pad($start_time_arr[0], 2, '0', STR_PAD_LEFT);

			$time = $start_time_hour . ':' . $start_time_arr[1];

			$timeSlots[] = $time;

			$StartTime += $AddMins; //Endtime check
		}
		return $timeSlots;
	}
}


if (!function_exists('reserving_check_available_tables')) {
	/**
	 * check table exist or not
	 * param date 2022-04-03 , start time 8:00 , enbd time 10:00, $table_ids as array
	 * @return array
	 */
	function reserving_check_available_tables($order_date = '2022-04-03', $start_time = '8:00', $end_time = '12:00', $branch_id = 0)
	{
		global $wpdb;

		// sanitize content
		$order_date = esc_sql(sanitize_text_field($order_date));
		$start_time = esc_sql(sanitize_text_field($start_time));
		$end_time   = esc_sql(sanitize_text_field($end_time));

		$sql_check_available = "SELECT DISTINCT {$wpdb->prefix}posts.ID FROM {$wpdb->prefix}posts INNER JOIN {$wpdb->prefix}postmeta ON ( {$wpdb->prefix}posts.ID = {$wpdb->prefix}postmeta.post_id ) INNER JOIN {$wpdb->prefix}postmeta AS mt1 ON ( {$wpdb->prefix}posts.ID = mt1.post_id ) WHERE 1=1 AND {$wpdb->prefix}posts.ID IN (SELECT `{$wpdb->prefix}posts`.`ID` FROM `{$wpdb->prefix}posts` INNER JOIN `{$wpdb->prefix}postmeta` on `{$wpdb->prefix}postmeta`.`post_id` = `{$wpdb->prefix}posts`.`ID` WHERE {$wpdb->prefix}posts.`post_status` IN ('wc-rsv-new-order','wc-reserving-cooking','wc-processing','wc-cooking-completed','wc-on-the-way','wc-pending') AND `{$wpdb->prefix}postmeta`.`meta_key` = 'reserving_booking_date' AND `{$wpdb->prefix}postmeta`.`meta_value` = '{$order_date}')  AND ( ({$wpdb->prefix}postmeta.meta_key = 'reserving_booking_start_time' AND {$wpdb->prefix}postmeta.meta_value BETWEEN '{$start_time}' AND '{$end_time}') OR ( mt1.meta_key = 'reserving_booking_end_time' AND mt1.meta_value BETWEEN '{$start_time}' AND '{$end_time}' ) )";

		$order_ids = $wpdb->get_results($sql_check_available);

		$tables = get_terms('reserving-tables', array('hide_empty' => false));

		if ($branch_id) {
			$tables = get_the_terms($branch_id, 'reserving-tables');
		}

		$table_ids = [];

		if (!empty($tables)) {
			foreach ($tables as $key => $table) {
				array_push($table_ids, $table->term_id);
			}
		}

		if (empty($order_ids)) {
			return $table_ids;
		}

		$booked_tables = [];

		foreach ($order_ids as $order_id) {
			if (isset($order_id->ID)) {
				$order_start_time = get_post_meta($order_id->ID, 'reserving_booking_start_time', true);
				$order_end_time = get_post_meta($order_id->ID, 'reserving_booking_end_time', true);

				if ($order_start_time == $end_time) {
					continue;
				}

				if ($order_end_time == $start_time) {
					continue;
				}

				$booked_tables[] = get_post_meta($order_id->ID, 'reserving_booking_tables', true);
			}
		}


		$booked_tables = array_merge([], ...$booked_tables);

		$available_tables = array_diff($table_ids, $booked_tables);

		return $available_tables;
	}
}

if (!function_exists('reserving_is_wplogin')) {
	function reserving_is_wplogin()
	{
		$ABSPATH_MY = str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, ABSPATH);
		return ((in_array($ABSPATH_MY . 'wp-login.php', get_included_files()) || in_array($ABSPATH_MY . 'wp-register.php', get_included_files())) || (isset($_GLOBALS['pagenow']) && $GLOBALS['pagenow'] === 'wp-login.php') || $_SERVER['PHP_SELF'] == '/wp-login.php');
	}
}

function reserving_generate_randoms_string($length = 7)
{
	$characters = 'abcdefghijklmnopqrstuvwxyz';
	$charactersLength = strlen($characters);
	$randomString = '';
	for ($i = 0; $i < $length; $i++) {
		$randomString .= $characters[rand(0, $charactersLength - 1)];
	}
	return 'reserving' . $randomString;
}

if (!function_exists('reserving_attr_to_shortcode')):

	function reserving_attr_to_shortcode(array $attr_array)
	{
		$html_attr = '';

		foreach ($attr_array as $attr_name => $attr_val) {
			if (($attr_val === false) || empty($attr_val)) {
				continue;
			}

			if (is_array($attr_val)) {
				$html_attr .= $attr_name . '="' . implode(",", $attr_val) . '" ';
			} else {
				$html_attr .= $attr_name . '="' . $attr_val . '" ';
			}
		}

		return $html_attr;
	}

endif;


if (!function_exists('reserving_get_elementor_saved_templates')) {
	/**
	 * optional parameter
	 * Category name
	 * return array element templates
	 * @since 1.0
	 */
	function reserving_get_elementor_saved_templates($category = false)
	{

		static $_template_kits = null;

		if (is_null($_template_kits)) {

			$args = array(
				'numberposts' => -1,
				'post_type'   => 'elementor_library',
				'post_status' => 'publish',
				'orderby'     => 'title',
				'order'       => 'ASC',
			);

			if ($category) {

				$args['tax_query'][] =  array(
					'taxonomy' => 'elementor_library_category',
					'field'    => 'slug',
					'terms'    => $category
				);
			}

			$_template_kits = get_posts($args);
		}

		return $_template_kits;
	}
}



if (!function_exists('reserving_get_elementor_templates_arr')) {

	/**
	 * use in elementor widget
	 * return array
	 * @author quomodsoft.com
	 */
	function reserving_get_elementor_templates_arr()
	{

		static $_template_kits = null;

		if (is_null($_template_kits)) {
			$_template_kits[''] = esc_html__('Select Template', 'reserving');
			$temp = reserving_get_elementor_saved_templates();

			if (is_array($temp)) {
				foreach ($temp as $item) {
					$_template_kits[$item->ID] = $item->post_name . ' - ' . $item->ID;
				}
			}
		}

		return $_template_kits;
	}
}

if (!function_exists('reserving_localize_script')) {

	function reserving_localize_script()
	{
		static $method_called = false;
		if (!$method_called) {
			$method_called = true;
			wp_localize_script('reserving_admin_order_table_js', 'reserving_params', array(
				'ajax_url'        => admin_url('admin-ajax.php'),
				'currency_symbol' => get_woocommerce_currency_symbol(),
				'loader'          => esc_url(RESERVING_ASSETS_BACKEND_URL . 'imgs/loader-cart.svg'),
				'q'               => isset($_GET['bat-search-q']) ? sanitize_text_field($_GET['bat-search-q']) : ''
			));
		}
	}
}

if (!function_exists('reserving_app_is_not_running_on_server')) {

	function reserving_app_is_not_running_on_server()
	{

		if (in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'))) {
			return false; // must be false  
		}
		return true;
	}
}

function reserving_option_fix_path($path)
{

	$windows_network_path = isset($_SERVER['windir']) && in_array(
		substr($path, 0, 2),
		array('//', '\\\\'),
		true
	);
	$fixed_path = untrailingslashit(str_replace(array('//', '\\'), array('/', '/'), $path));

	if (empty($fixed_path) && ! empty($path)) {
		$fixed_path = '/';
	}

	if ($windows_network_path) {
		$fixed_path = '//' . ltrim($fixed_path, '/');
	}

	return $fixed_path;
}
