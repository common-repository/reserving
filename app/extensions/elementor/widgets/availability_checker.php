<?php

class Reserving_Availability_Checker extends \Elementor\Widget_Base {

	public function get_name() {
		return 'reserving_availability_checker';
	}

	public function get_title() {
		return esc_html__( 'Availability Checker', 'reserving' );
	}

	public function get_icon() {
		return 'eicon-search';
	}

	public function get_categories() {
		return [ 'reserving' ];
	}

	public function get_keywords() {
		return [ 'reserving', 'checker' ];
	}

	public function get_script_depends() {

		return [
			'reserving_frontend_tab_js',
			'reserving_frontend_main_js',
		];

	}
	public function get_style_depends() {

		return [
			'reserving_frontend_popup_style',
			'reserving_frontend_tabs_style',
		];

	}

	protected function register_controls() {

		$this->start_controls_section(
			'content_box_section',
			[
				'label' => esc_html__( 'Box', 'reserving' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background::get_type(),
			[
				'name' => 'section_containertryu_background',
				'label' => esc_html__( 'Background', 'reserving' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .form-popup',
			]
		);

			$this->add_group_control(
				\Elementor\Group_Control_Border::get_type(),
				[
					'name' => 'section_container_border',
					'label' => esc_html__( 'Border', 'reserving' ),
					'selector' => '{{WRAPPER}} .form-popup',
				]
			);

			$this->add_responsive_control(
				'section_container_padding',
				[
					'label' => esc_html__( 'Padding', 'reserving' ),
					'type' => \Elementor\Controls_Manager::DIMENSIONS,
					'size_units' => [ 'px', '%', 'em' ],
					'selectors' => [
						'{{WRAPPER}} .form-popup' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'section_containerwidth',
				[
					'label' => esc_html__( 'Width', 'reserving' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 5,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
				
					'selectors' => [
						'{{WRAPPER}} .form-popup' => 'width: {{SIZE}}{{UNIT}};',
					],
				]
			);

			$this->add_responsive_control(
				'section_container_max_width',
				[
					'label' => esc_html__( 'Max Width', 'reserving' ),
					'type' => \Elementor\Controls_Manager::SLIDER,
					'size_units' => [ 'px', '%' ],
					'range' => [
						'px' => [
							'min' => 0,
							'max' => 1000,
							'step' => 5,
						],
						'%' => [
							'min' => 0,
							'max' => 100,
						],
					],
				
					'selectors' => [
						'{{WRAPPER}} .form-popup' => 'max-width: {{SIZE}}{{UNIT}};',
					],
				]
			);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_heading_section',
			[
				'label' => esc_html__( 'Heading', 'reserving' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'section_title_color',
			[
				'label' => esc_html__( 'Color', 'reserving' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .form-popup .reserving-chk-heading' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'content_heading_typography',
				'selector' => '{{WRAPPER}} .form-popup .reserving-chk-heading',
			]
		);

		$this->add_responsive_control(
			'section_heading_margin',
			[
				'label' => esc_html__( 'Margin', 'reserving' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .form-popup .reserving-chk-heading' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			[
				'name' => 'section_heaidng_border',
				'label' => esc_html__( 'Border', 'reserving' ),
				'selector' => '{{WRAPPER}} .form-popup .reserving-chk-heading',
			]
		);

		$this->add_control(
			'section_heaidng_display_style',
			[
				'label' => esc_html__( 'Display', 'reserving' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'inline-block'  => esc_html__( 'Inline', 'reserving' ),
					'block' => esc_html__( 'Block', 'reserving' ),
					'none' => esc_html__( 'None', 'reserving' ),
				],
				'selectors' => [
					'{{WRAPPER}} .form-popup .reserving-chk-heading' => 'display: {{VALUE}};',
				],
			]
		);


		$this->end_controls_section();

		$this->start_controls_section(
			'content_tab_section',
			[
				'label' => esc_html__( 'Tab', 'reserving' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs(
				'tab_style_tabs_wrapper'
			);
			
			$this->start_controls_tab(
				'reserving_normal_tab_wrapper',
				[
					'label' => esc_html__( 'Wrapper', 'reserving' ),
				]
			);

				$this->add_group_control(
					\Elementor\Group_Control_Background::get_type(),
					[
						'name' => 'section_tab_background',
						'label' => esc_html__( 'Background', 'reserving' ),
						'types' => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .reserving__tabs',
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Border::get_type(),
					[
						'name' => 'section_taba_border',
						'label' => esc_html__( 'Border', 'reserving' ),
						'selector' => '{{WRAPPER}} .form-popup .reserving__tabs',
					]
				);

				$this->add_responsive_control(
					'section_tabs_margin',
					[
						'label' => esc_html__( 'Margin', 'reserving' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .form-popup .reserving__tabs' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_responsive_control(
					'section_tabs_padding',
					[
						'label' => esc_html__( 'Padding', 'reserving' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .form-popup .reserving__tabs' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
			
			$this->end_controls_tab();

			$this->start_controls_tab(
				'reserving_normal_tab_item',
				[
					'label' => esc_html__( 'Item', 'reserving' ),
				]
			);

				$this->add_responsive_control(
					'section_tabs_item_padding',
					[
						'label' => esc_html__( 'Padding', 'reserving' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .form-popup .reserving__tabs button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_responsive_control(
					'section_tabs_item_margin',
					[
						'label' => esc_html__( 'margin', 'reserving' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .form-popup .reserving__tabs button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_control(
					'section_tabs_item_bg__color',
					[
						'label' => esc_html__( 'BgColor', 'reserving' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .form-popup .reserving__tabs button' => 'background-color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'section_tabs_item__color',
					[
						'label' => esc_html__( 'Color', 'reserving' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .reserving__tabs button' => 'color: {{VALUE}}',
						],
					]
				);


				$this->add_control(
					'section_tabs_item_bg_ac_color',
					[
						'label' => esc_html__( 'Active BgColor', 'reserving' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .reserving__tabs button.active' => 'background-color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'section_tabs_item_ac_color',
					[
						'label' => esc_html__( 'Active Color', 'reserving' ),
						'type' => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .reserving__tabs button.active' => 'color: {{VALUE}}',
						],
					]
				);

				$this->add_control(
					'section_tabs_float_style',
					[
						'label' => esc_html__( 'Float', 'reserving' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'default' => '',
						'options' => [
							'left'  => esc_html__( 'Left', 'reserving' ),
							'right' => esc_html__( 'Right', 'reserving' ),
							'none' => esc_html__( 'None', 'reserving' ),
						],
						'selectors' => [
							'{{WRAPPER}} .reserving__tabs button' => 'float: {{VALUE}};',
						],
					]
				);

			$this->end_controls_tab();
			
			$this->end_controls_tabs();

		$this->end_controls_section();
		$this->start_controls_section(
			'content_tab_content_delivery_section',
			[
				'label' => esc_html__( 'Home Delivery', 'reserving' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

			$this->start_controls_tabs(
				'content_tab_content_branch_select'
			);

			$this->start_controls_tab(
				'style_branch_label_tab',
				[
					'label' => esc_html__( 'Branch label', 'reserving' ),
				]
			);

				$this->add_control(
					'label_br_submithover_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'reserving' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} label[for=reserving_branch]' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'label_branch_typography',
						'selector' => '{{WRAPPER}} label[for=reserving_branch]',
					]
				);

			$this->end_controls_tab();

			$this->start_controls_tab(
				'style_branch_input_tab',
				[
					'label' => esc_html__( 'Branch Input', 'reserving' ),
				]
			);

			
				$this->add_control(
					'input_br_submithover_p_color',
					[
						'label'     => esc_html__( 'Label Color', 'reserving' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .reserving_delivery_areas p' => 'color: {{VALUE}};',

						],
					]
				);

				$this->add_control(
					'input_br_submithover_text_color',
					[
						'label'     => esc_html__( 'Input Color', 'reserving' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .reserving_delivery_areas input[name=search_delivery_area]' => 'color: {{VALUE}};',
							'{{WRAPPER}} .reserving_delivery_areas input[name=search_delivery_area]::-webkit-input-placeholder' => 'color: {{VALUE}};',
							'{{WRAPPER}} .reserving_delivery_areas input[name=search_delivery_area]::-moz-placeholder' => 'color: {{VALUE}};',
							'{{WRAPPER}} .reserving_delivery_areas input[name=search_delivery_area]:-ms-input-placeholder' => 'color: {{VALUE}};',
							'{{WRAPPER}} .reserving_delivery_areas input[name=search_delivery_area]::placeholder' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Typography::get_type(),
					[
						'name' => 'input_branch_typography',
						'selector' => '{{WRAPPER}} .reserving_delivery_areas input[name=search_delivery_area]',
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background:: get_type(),
					[
						'name'     => 'input_br_submithover_background_color',
						'label'    => esc_html__( 'Background', 'reserving' ),
						'types'    => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .reserving_delivery_areas input[name=search_delivery_area]',
					]
				);
				$this->add_group_control(
					\Elementor\Group_Control_Border:: get_type(),
					[
						'name'     => 'input_br_submithover_border',
						'label'    => esc_html__( 'Border', 'reserving' ),
						'selector' => '{{WRAPPER}} .reserving_delivery_areas input[name=search_delivery_area]',
					]
				);

				$this->add_responsive_control(
					'input_br_item_padding',
					[
						'label' => esc_html__( 'Padding', 'reserving' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .reserving_delivery_areas input[name=search_delivery_area]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_responsive_control(
					'input_br_item_margin',
					[
						'label' => esc_html__( 'Margin', 'reserving' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .reserving_delivery_areas input[name=search_delivery_area]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'style_branch_select_tab',
				[
					'label' => esc_html__( 'Branch Select', 'reserving' ),
				]
			);

				$this->add_control(
					'select_br_submithover_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'reserving' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} select[name=reserving_branch]' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background:: get_type(),
					[
						'name'     => 'selkect_br_submithover_background_color',
						'label'    => esc_html__( 'Background', 'reserving' ),
						'types'    => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} select[name=reserving_branch]',
					]
				);
				$this->add_group_control(
					\Elementor\Group_Control_Border:: get_type(),
					[
						'name'     => 'select_br_submithover_border',
						'label'    => esc_html__( 'Border', 'reserving' ),
						'selector' => '{{WRAPPER}} select[name=reserving_branch]',
					]
				);

				$this->add_responsive_control(
					'select_br_item_padding',
					[
						'label' => esc_html__( 'Padding', 'reserving' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} select[name=reserving_branch]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_responsive_control(
					'select_br_item_margin',
					[
						'label' => esc_html__( 'Margin', 'reserving' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} select[name=reserving_branch]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);
			
			$this->end_controls_tab();
			
			$this->start_controls_tab(
				'style_branc_button_tab',
				[
					'label' => esc_html__( 'Button', 'reserving' ),
				]
			);

				$this->add_control(
					'button_br_submith_text_color',
					[
						'label'     => esc_html__( 'Text Color', 'reserving' ),
						'type'      => \Elementor\Controls_Manager::COLOR,
						'selectors' => [
							'{{WRAPPER}} .availibity_checker_btn' => 'color: {{VALUE}};',
						],
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Background:: get_type(),
					[
						'name'     => 'button__br_submithover_background_color',
						'label'    => esc_html__( 'Background', 'reserving' ),
						'types'    => [ 'classic', 'gradient' ],
						'selector' => '{{WRAPPER}} .availibity_checker_btn',
					]
				);

				$this->add_group_control(
					\Elementor\Group_Control_Border:: get_type(),
					[
						'name'     => 'button_br_submithover_border',
						'label'    => esc_html__( 'Border', 'reserving' ),
						'selector' => '{{WRAPPER}} .availibity_checker_btn',
					]
				);

				$this->add_responsive_control(
					'button_br_item_padding',
					[
						'label' => esc_html__( 'Padding', 'reserving' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .availibity_checker_btn' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_responsive_control(
					'button_br_item_margin',
					[
						'label' => esc_html__( 'Margin', 'reserving' ),
						'type' => \Elementor\Controls_Manager::DIMENSIONS,
						'size_units' => [ 'px', '%', 'em' ],
						'selectors' => [
							'{{WRAPPER}} .availibity_checker_btn' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
						],
					]
				);

				$this->add_control(
					'buton__ng_display_style',
					[
						'label' => esc_html__( 'Display', 'reserving' ),
						'type' => \Elementor\Controls_Manager::SELECT,
						'default' => '',
						'options' => [
							'inline-block'  => esc_html__( 'Inline', 'reserving' ),
							'block' => esc_html__( 'Block', 'reserving' ),
							'none' => esc_html__( 'None', 'reserving' ),
						],
						'selectors' => [
							'{{WRAPPER}} .availibity_checker_btn' => 'display: {{VALUE}};',
						],
					]
				);

			$this->end_controls_tab();
			
			$this->end_controls_tabs();

		$this->end_controls_section();
		$this->start_controls_section(
			'content_tab_content_delivery_date',
			[
				'label' => esc_html__( 'Delivery date', 'reserving' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'delivary_date_item_margin',
			[
				'label' => esc_html__( 'Margin', 'reserving' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} div.delivery_date' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'delivery_date_br_item_padding',
			[
				'label' => esc_html__( 'Padding', 'reserving' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} input.delivery_date' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'delivery_dater_th_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'reserving' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} input.delivery_date' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background:: get_type(),
			[
				'name'     => 'delivery_datebr__background_color',
				'label'    => esc_html__( 'Background', 'reserving' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} input.delivery_date',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_tab_content_pickup_time',
			[
				'label' => esc_html__( 'PickUp Time', 'reserving' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'pickup_time_item_margin',
			[
				'label' => esc_html__( 'Margin', 'reserving' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} select[name=delivery_time]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'pickup_timee_br_item_padding',
			[
				'label' => esc_html__( 'Padding', 'reserving' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} select[name=delivery_time]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'pickup_time_th_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'reserving' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} select[name=delivery_time]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pickup_time_branch_typography',
				'selector' => '{{WRAPPER}} select[name=delivery_time]',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background:: get_type(),
			[
				'name'     => 'dpickup_timer__background_color',
				'label'    => esc_html__( 'Background', 'reserving' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} select[name=delivery_time]',
			]
		);

		$this->end_controls_section();

		
		$this->start_controls_section(
			'content_tab_content_dine_start_time',
			[
				'label' => esc_html__( 'Dine Start Time', 'reserving' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'dine_start_time_item_margin',
			[
				'label' => esc_html__( 'Margin', 'reserving' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} select[name=reserving_start_time]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dine_start_time__br_item_padding',
			[
				'label' => esc_html__( 'Padding', 'reserving' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} select[name=reserving_start_time]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dine_start_time__th_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'reserving' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} select[name=reserving_start_time]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pdine_start_time__branch_typography',
				'selector' => '{{WRAPPER}} select[name=reserving_start_time]',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background:: get_type(),
			[
				'name'     => 'dine_start_time___background_color',
				'label'    => esc_html__( 'Background', 'reserving' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} select[name=reserving_start_time]',
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'content_tab_content_dine_end_time',
			[
				'label' => esc_html__( 'Dine End Time', 'reserving' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'dine_end_time_item_margin',
			[
				'label' => esc_html__( 'Margin', 'reserving' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} select[name=reserving_end_time]' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'dine_end_time__br_item_padding',
			[
				'label' => esc_html__( 'Padding', 'reserving' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} select[name=reserving_end_time]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'dine_end_time__th_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'reserving' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} select[name=reserving_end_time]' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'pdine_end_time__branch_typography',
				'selector' => '{{WRAPPER}} select[name=reserving_end_time]',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background:: get_type(),
			[
				'name'     => 'dine_end_time___background_color',
				'label'    => esc_html__( 'Background', 'reserving' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} select[name=reserving_end_time]',
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'content_tab_content_order_btn',
			[
				'label' => esc_html__( 'Order Button', 'reserving' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);


		$this->add_control(
			'order__br_submith_text_color',
			[
				'label'     => esc_html__( 'Text Color', 'reserving' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .start_order' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'order__branch_typography',
				'selector' => '{{WRAPPER}} .start_order',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Background:: get_type(),
			[
				'name'     => 'order___br_submithover_background_color',
				'label'    => esc_html__( 'Background', 'reserving' ),
				'types'    => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .start_order',
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border:: get_type(),
			[
				'name'     => 'order__br_submithover_border',
				'label'    => esc_html__( 'Border', 'reserving' ),
				'selector' => '{{WRAPPER}} .start_order',
			]
		);

		$this->add_responsive_control(
			'order_br_item_padding',
			[
				'label' => esc_html__( 'Padding', 'reserving' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .start_order' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'order_r_item_margin',
			[
				'label' => esc_html__( 'Margin', 'reserving' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .start_order' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'order__heaidng_display_style',
			[
				'label' => esc_html__( 'Display', 'reserving' ),
				'type' => \Elementor\Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'inline-block'  => esc_html__( 'Inline', 'reserving' ),
					'block' => esc_html__( 'Block', 'reserving' ),
					'none' => esc_html__( 'None', 'reserving' ),
				],
				'selectors' => [
					'{{WRAPPER}} .start_order' => 'display: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
        echo do_shortcode( '[reserving_availability_checker]' );
	}
}