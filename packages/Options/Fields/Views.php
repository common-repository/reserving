<?php

namespace Reserving_Packages\Options\Fields;

class Views
{

	// Hold it's parent object which
	var $parent = null;

	/**
	 * Fire!
	 *
	 * @since 1.0.0
	 */
	public function __construct($parent)
	{
		$this->parent = $parent;
	}

	/**
	 * Create the HTML interface for admin options page
	 *
	 * @since  1.0.0
	 * @return void
	 */
	public function admin_options_page()
	{

		$section_ids = array_keys($this->parent->sections);
		$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : $section_ids[0];
		$base_url = menu_page_url($this->parent->configs['page_slug'], false);
		$page_title = $this->parent->configs['page_title'];
		$page_slug = $this->parent->configs['page_slug'];

		ob_start();
?>
<div class="wrap core-dash-qsrt-wrapper <?php echo esc_attr($page_slug); ?>">
    <h1 class="qersd-option-heading"> <?php echo esc_html($page_title); ?> </h1>
    <div class="qers-settings-wrapper">
        <div class="nav-tab-wrapper qrst-nav-tab-wrapper">
            <?php
					$banner_image = '';
					foreach ($this->parent->sections as $section) {

						$icon       = isset($section['icon']) ? sprintf("<img src='%s' />", $section['icon']) : "<span class='dashicons dashicons-admin-generic'></span>";
						$actived    = ($active_tab == $section['id']) ? 'nav-tab-active' : '';
						if (isset($section['type']) && $section['type'] == 'url') {
							echo wp_kses_post(sprintf(
								'<a href="%1$s" title="%2$s" class="nav-tab qrst-nav-tab %3$s"> %5$s <span> %4$s </span> </a>',
								esc_url($section['url']),
								esc_attr($section['title']),
								esc_attr($actived),
								esc_html($section['title']),
								$icon
							));
						} else {
							echo wp_kses_post(sprintf(
								'<a href="%1$s" title="%2$s" class="nav-tab qrst-nav-tab %3$s">%5$s <span> %4$s </span> </a>',
								add_query_arg('tab', esc_attr($section['id']), esc_url($base_url)),
								esc_html($section['title']),
								esc_attr($actived),
								esc_html($section['title']),
								$icon
							));
						}
					}
					?>
        </div>
        <!-- END .nav-tab-wrapper -->
        <?php

				$banner_image = isset($this->parent->sections[$active_tab]['content_bg']) ? $this->parent->sections[$active_tab]['content_bg'] : '';
				$option_heading = isset($this->parent->sections[$active_tab]['option_heading']) && $this->parent->sections[$active_tab]['option_heading'] == 'column' ? 'reserving-option-heading-column' : 'reserving-option-heading-row'; ?>

        <div class="qrs-tab-container <?php echo esc_attr($active_tab . ' ' . $option_heading); ?>" id="tab_container">
            <?php
					if (isset($this->parent->sections[$active_tab]['type']) && 'blank' == $this->parent->sections[$active_tab]['type']) {
						do_action('reserving_options_page_' . $this->parent->configs['opt_name'] . '_' . $this->parent->sections[$active_tab]['id']);
					} else {
					?>
            <form action="options.php" method="post">
                <p class="submit qrs-btn-wrapper">
                    <?php submit_button(__('Save Changes', 'reserving'), 'primary', 'save', false); ?>
                </p>
                <div class="qrs-tab-content-inner">
                    <div class="qrs--form-area">
                        <table class="form-table reserving-form-table">
                            <?php
										settings_fields($this->parent->configs['opt_name']);
										do_settings_fields($this->parent->configs['opt_name'] . '_' . $active_tab, $this->parent->configs['opt_name'] . '_' . $active_tab);
										?>
                        </table>
                        <!-- END .form-table -->
                    </div>
                    <?php if ($banner_image != ''): ?>
                    <div class="qrs-right-bg">
                        <img src="<?php echo esc_url($banner_image); ?>" />
                    </div>
                    <?php endif; ?>
                </div>
                <p class="submit qrs-btn-wrapper">
                    <?php $link = add_query_arg(array('tab' => $active_tab, 'action' => 'reset', 'reset_nonce' => wp_create_nonce('reserving_reset')), esc_url($base_url)); ?>
                    <a href="<?php echo esc_url($link); ?>"
                        class="button button-secondary"><?php _e('Reset', 'reserving'); ?></a>
                    <?php
								submit_button(__('Save Changes', 'reserving'), 'primary', 'save_bottom', false);
								?>
                </p>
            </form>
            <?php } ?>
        </div><!-- END #tab_container -->
    </div> <!-- END .qers-settings-wrapper -->
</div>
<!-- END .wrap -->
<?php
		$outup = ob_get_contents();
		ob_end_clean();
		echo wp_kses($outup, $this->allowed_html());
	}

	public function allowed_html()
	{
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
				'selected' => [],
				'disabled' => []
			),
			'textarea' => array(
				'name'	 => array(),
				'id' => [],
				'class' => [],
				'cols' => [],
				'rows' => []
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
				'scope' => array(),
			),
			'th'							 => array(
				'title' => array(),
				'class' => array(),
				'id' => array(),
				'scope' => array(),
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
				'for'	 => array(),
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
				'name'	 => array(),
				'height' => array(),
				'src'	 => array(),
				'method' => array(),
				'style'	 => array(),
			),
			'img'							 => array(
				'alt'	 => array(),
				'class'	 => array(),
				'id'	 => array(),
				'height' => array(),
				'src'	 => array(),
				'width'	 => array(),
				'style'	 => array(),
			),
			'li'							 => array(
				'class' => array(),
				'id' => array(),
				'style' => array(),
			),
			'ol'							 => array(
				'class' => array(),
			),
			'p'								 => array(
				'class' => array(),
				'id' => array(),
			),
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
				'name'	 => array(),
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