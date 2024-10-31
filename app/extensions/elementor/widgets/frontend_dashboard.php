<?php

use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

class Reserving_Frontend_Dashboard extends \Elementor\Widget_Base {

	public function get_name() {
		return 'reserving_frontend_dashboard';
	}

	public function get_title() {
		return esc_html__( 'Reserving Frontend Dashboard', 'reserving' );
	}

	public function get_icon() {
		return 'eicon-dashboard';
	}

	public function get_categories() {
		return [ 'reserving' ];
	}

	public function get_keywords() {
		return [ 'reserving', 'dashboard','frontend' ];
	}

	protected function register_controls() {

		  /*---------------------------
            BUTTON STYLE
        ----------------------------*/
        $this->start_controls_section(
			'button_section_style',
			[
				'label' => esc_html__( 'Button', 'reserving' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
    		$this->start_controls_tabs( 'tabs_button_style' );
        		$this->start_controls_tab(
        			'tab_button_normal',
        			[
        				'label' => esc_html__( 'Normal', 'reserving' ),
        			]
        		);
                    $this->add_group_control(
                        Group_Control_Typography:: get_type(),
                        [
                            'name'     => 'button_typography',
                            'selector' => '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a, {{WRAPPER}} .button-primary',
                        ]
                    );
                    $this->add_control(
                        'button_text_color',
                        [
                            'label'     => esc_html__( 'Text Color', 'reserving' ),
                            'type'      => Controls_Manager::COLOR,
                            'selectors' => [
                                '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a, {{WRAPPER}} .button-primary' => 'color: {{VALUE}};',
                            ],
                        ]
                    );        
                    $this->add_group_control(
                        Group_Control_Background:: get_type(),
                        [
                            'name'     => 'button_background_color',
                            'label'    => esc_html__( 'Background', 'reserving' ),
                            'types'    => [ 'classic', 'gradient' ],
                            'selector' => '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a, {{WRAPPER}} .button-primary',
                        ]
                    );            
                    $this->add_responsive_control(
                        'button_height',
                        [
                            'label'      => esc_html__( 'Height', 'reserving' ),
                            'type'       => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range'      => [
                                'px' => [
                                    'min'  => 0,
                                    'max'  => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a, {{WRAPPER}} .button-primary' => 'height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );
                    $this->add_responsive_control(
                        'button_width',
                        [
                            'label'      => esc_html__( 'Width', 'reserving' ),
                            'type'       => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range'      => [
                                'px' => [
                                    'min'  => 0,
                                    'max'  => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a, {{WRAPPER}} .button-primary' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );        
                    $this->add_group_control(
            			Group_Control_Border:: get_type(),
            			[
            				'name'     => 'button_border',
            				'selector' => '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a, {{WRAPPER}} .button-primary',
            			]
            		);
                    $this->add_responsive_control(
            			'button_radius',
            			[
            				'label'      => esc_html__( 'Border Radius', 'reserving' ),
            				'type'       => Controls_Manager::DIMENSIONS,
            				'size_units' => [ 'px', '%' ],
            				'default'    => [
                                'top'      => '5',
                                'right'    => '5',
                                'bottom'   => '5',
                                'left'     => '5',
                                'isLinked' => false
                            ],
            				'selectors' => [
            					'{{WRAPPER}} .reserving-frontend-dashboard-wrapper a, {{WRAPPER}} .button-primary' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
            				],
            			]
            		);        
                    $this->add_group_control(
            			Group_Control_Box_Shadow:: get_type(),
            			[
            				'name'     => 'button_box_shadow',
            				'selector' => '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a, {{WRAPPER}} .button-primary',
            			]
            		);
                    $this->add_responsive_control(
                        'button_margin',
                        [
                            'label'      => esc_html__( 'Margin', 'reserving' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'default'    => [
                                'top'      => '0',
                                'right'    => '0',
                                'bottom'   => '0',
                                'left'     => '0',
                                'isLinked' => false
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a, {{WRAPPER}} .button-primary' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );        
                    $this->add_responsive_control(
                        'button_padding',
                        [
                            'label'   => esc_html__( 'Padding', 'reserving' ),
                            'type'    => Controls_Manager::DIMENSIONS,
                            'default' => [
                                'top'      => '12',
                                'right'    => '40',
                                'bottom'   => '12',
                                'left'     => '40',
                                'isLinked' => false
                            ],
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors'  => [
                                '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a, {{WRAPPER}} .button-primary' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );        
                    $this->add_control(
                        'button_transition',
                        [
                            'label'      => esc_html__( 'Transition', 'reserving' ),
                            'type'       => Controls_Manager::SLIDER,
                            'size_units' => [ 'px' ],
                            'range'      => [
                                'px' => [
                                    'min'  => 0.1,
                                    'max'  => 3,
                                    'step' => 0.1,
                                ],
                            ],
                            'default' => [
                                'unit' => 'px',
                                'size' => 0.3,
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a, {{WRAPPER}} .button-primary' => 'transition: {{SIZE}}s;',
                            ],
                        ]
                    );
                    $this->add_responsive_control(
                        'button_floting',
                        [
                            'label'   => esc_html__( 'Button Floating', 'reserving' ),
                            'type'    => Controls_Manager::CHOOSE,
                            'options' => [
                                'left' => [
                                    'title' => esc_html__( 'Left', 'reserving' ),
                                    'icon'  => 'fa fa-align-left',
                                ],
                                'none' => [
                                    'title' => esc_html__( 'None', 'reserving' ),
                                    'icon'  => 'fa fa-align-center',
                                ],
                                'right' => [
                                    'title' => esc_html__( 'Right', 'reserving' ),
                                    'icon'  => 'fa fa-align-right',
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a, {{WRAPPER}} .button-primary' => 'float: {{VALUE}};',
                            ],
                            'default'   => 'none',
                            'separator' => 'before',
                        ]
                    );
        		$this->end_controls_tab();

        		$this->start_controls_tab(
        			'tab_button_hover',
        			[
        				'label' => esc_html__( 'Hover', 'reserving' ),
        			]
        		);
            		$this->add_control(
            			'button_hover_color',
            			[
            				'label'     => esc_html__( 'Text Color', 'reserving' ),
            				'type'      => Controls_Manager::COLOR,
                            'separator' => 'before',
            				'selectors' => [
            					'{{WRAPPER}} .reserving-frontend-dashboard-wrapper a:hover, {{WRAPPER}} .button-primary:hover' => 'color: {{VALUE}};',
            				],
            			]
            		);
                    $this->add_group_control(
            			Group_Control_Background:: get_type(),
            			[
            				'name'     => 'button_hover_background',
            				'label'    => esc_html__( 'Hover Background', 'reserving' ),
            				'types'    => [ 'classic', 'gradient' ],
                            'separator' => 'before',
            				'selector' => '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a:hover, {{WRAPPER}} .button-primary:before,{{WRAPPER}} .button-primary:hover',
            			]
            		);
                    $this->add_control(
                        'button_before_hidding',
                        [
                            'label' => esc_html__( 'Hover Before Background', 'reserving' ),
                            'type' => Controls_Manager::HEADING,
                            'separator' => 'before',
                        ]
                    );
                    $this->add_group_control(
                        Group_Control_Background:: get_type(),
                        [
                            'name'     => 'button_hover_before_background',
                            'label'    => esc_html__( 'Hover Before Background', 'reserving' ),
                            'types'    => [ 'classic', 'gradient' ],
                            'separator' => 'before',
                            'selector' => '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a:hover:before, {{WRAPPER}} .button-primary:hover:before',
                        ]
                    );
            		$this->add_control(
            			'button_hover_border_color',
            			[
            				'label'     => esc_html__( 'Border Color', 'reserving' ),
            				'type'      => Controls_Manager::COLOR,
                            'separator' => 'before',
            				'selectors' => [
            					'{{WRAPPER}} .reserving-frontend-dashboard-wrapper a:hover, {{WRAPPER}} .button-primary:hover' => 'border-color: {{VALUE}};',
            				],
            			]
            		);
            		$this->add_group_control(
            			Group_Control_Box_Shadow:: get_type(),
            			[
            				'name'     => 'button_hover_box_shadow',
            				'selector' => '{{WRAPPER}} .reserving-frontend-dashboard-wrapper a:hover, {{WRAPPER}} .button-primary:hover',
            			]
            		);

        		$this->end_controls_tab();
    		$this->end_controls_tabs();
		$this->end_controls_section();
        /*----------------------------
            BUTTON STYLE END
        ------------------------------*/

		$this->start_controls_section(
			'content_box_section',
			[
				'label' => esc_html__( 'Box Heading', 'reserving' ),
				'tab' => \Elementor\Controls_Manager::TAB_STYLE,
			]
		);
      
		$this->add_control(
			'section__item__color',
			[
				'label' => esc_html__( 'Text Color', 'reserving' ),
				'type' => \Elementor\Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .reserving-frontend-dashboard-wrapper p' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			[
				'name' => 'label_p_typography',
				'selector' => '{{WRAPPER}} .reserving-frontend-dashboard-wrapper p',
			]
		);

		$this->add_responsive_control(
			'section_p_item_margin',
			[
				'label' => esc_html__( 'margin', 'reserving' ),
				'type' => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .reserving-frontend-dashboard-wrapper p' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


        $this->add_control(
            'heading_display',
            [
                'label'     => esc_html__( 'Heading Display', 'reserving' ),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'block',
                'options'   => [
                    '' => esc_html__('No Action','reserving'),
                    'none' => esc_html__('None','reserving'),
                    'block' => esc_html__('Block','reserving'),
                ],
				'selectors' => [
					'{{WRAPPER}} .reserving-frontend-dashboard-wrapper p' => 'display: {{VALUE}};',
				],
                
            ]
        );

		$this->end_controls_section();

		   /*---------------------------
            INPUT STYLE
        ----------------------------*/
        $this->start_controls_section(
			'input_style_section',
			[
				'label' => esc_html__( 'Inputs', 'reserving' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);
    		$this->start_controls_tabs( 'tabs_input_style' );
        		$this->start_controls_tab(
        			'tab_input_normal',
        			[
        				'label' => esc_html__( 'Normal', 'reserving' ),
        			]
        		);

                    $this->add_group_control(
                        Group_Control_Typography:: get_type(),
                        [
                            'name'     => 'input_typography',
                            'selector' => '{{WRAPPER}} input[type="password"],{{WRAPPER}} input[type="text"],{{WRAPPER}} input[type="tel"],{{WRAPPER}} input[type="date"],{{WRAPPER}} input[type="url"],{{WRAPPER}} input[type="email"],{{WRAPPER}} textarea',
                        ]
                    );
                    
                    $this->add_responsive_control(
                        'input_box_height',
                        [
                            'label'      => esc_html__( 'Height', 'reserving' ),
                            'type'       => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range'      => [
                                'px' => [
                                    'min'  => 0,
                                    'max'  => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} input[type="password"],{{WRAPPER}} input[type="text"],{{WRAPPER}} input[type="tel"],{{WRAPPER}} input[type="date"],{{WRAPPER}} input[type="url"],{{WRAPPER}} input[type="email"],{{WRAPPER}} textarea' => 'min-height: {{SIZE}}{{UNIT}}; line-height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'input_box_max_height',
                        [
                            'label'      => esc_html__( 'Max Height', 'reserving' ),
                            'type'       => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range'      => [
                                'px' => [
                                    'min'  => 0,
                                    'max'  => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} input[type="password"],{{WRAPPER}} input[type="text"],{{WRAPPER}} input[type="tel"],{{WRAPPER}} input[type="date"],{{WRAPPER}} input[type="url"],{{WRAPPER}} input[type="email"],{{WRAPPER}} textarea' => 'max-height: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

                    $this->add_responsive_control(
                        'input_box_width',
                        [
                            'label'      => esc_html__( 'Width', 'reserving' ),
                            'type'       => Controls_Manager::SLIDER,
                            'size_units' => [ 'px', '%' ],
                            'range'      => [
                                'px' => [
                                    'min'  => 0,
                                    'max'  => 1000,
                                    'step' => 1,
                                ],
                                '%' => [
                                    'min' => 0,
                                    'max' => 100,
                                ],
                            ],
                            'selectors' => [
                                '{{WRAPPER}} input[type="password"],{{WRAPPER}} input[type="text"],{{WRAPPER}} input[type="tel"],{{WRAPPER}} input[type="date"],{{WRAPPER}} input[type="url"],{{WRAPPER}} input[type="email"],{{WRAPPER}} textarea' => 'width: {{SIZE}}{{UNIT}};',
                            ],
                        ]
                    );

            		$this->add_control(
            			'input_text_color',
            			[
            				'label'     => esc_html__( 'Text Color', 'reserving' ),
            				'type'      => Controls_Manager::COLOR,
            				'default'   => '#79879d',
            				'selectors' => [
            					'{{WRAPPER}} input[type="password"],{{WRAPPER}} input[type="text"],{{WRAPPER}} input[type="tel"],{{WRAPPER}} input[type="date"],{{WRAPPER}} input[type="url"],{{WRAPPER}} input[type="email"],{{WRAPPER}} textarea, {{WRAPPER}} ::placeholder' => 'color: {{VALUE}};',
            				],
            			]
            		);
                    
                    $this->add_group_control(
            			Group_Control_Background:: get_type(),
            			[
            				'name'     => 'input_background_color',
            				'label'    => esc_html__( 'Background', 'reserving' ),
            				'types'    => [ 'classic', 'gradient' ],
            				'selector' => '{{WRAPPER}} input[type="password"],{{WRAPPER}} input[type="text"],{{WRAPPER}} input[type="tel"],{{WRAPPER}} input[type="date"],{{WRAPPER}} input[type="url"],{{WRAPPER}} input[type="email"],{{WRAPPER}} textarea'
            			]
            		);

                    $this->add_group_control(
                        Group_Control_Border:: get_type(),
                        [
                            'name'     => 'input_border',
                            'selector' => '{{WRAPPER}} input[type="password"],{{WRAPPER}} input[type="text"],{{WRAPPER}} input[type="tel"],{{WRAPPER}} input[type="date"],{{WRAPPER}} input[type="email"],{{WRAPPER}} input[type="url"],{{WRAPPER}} textarea',
                        ]
                    );

                    $this->add_responsive_control(
                        'input_radius',
                        [
                            'label'      => esc_html__( 'Border Radius', 'reserving' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%' ],
                            'default'    => [
                                'top'      => '5',
                                'right'    => '5',
                                'bottom'   => '5',
                                'left'     => '5',
                                'isLinked' => false
                            ],
                            'selectors' => [
                                '{{WRAPPER}} input[type="password"],{{WRAPPER}} input[type="text"],{{WRAPPER}} input[type="tel"],{{WRAPPER}} input[type="date"],{{WRAPPER}} input[type="url"],{{WRAPPER}} input[type="email"],{{WRAPPER}} textarea' => 'border-radius : {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                        ]
                    );
                    
                    $this->add_group_control(
                        Group_Control_Box_Shadow:: get_type(),
                        [
                            'name'     => 'input_box_shadow',
                            'selector' => '{{WRAPPER}} input[type="password"],{{WRAPPER}} input[type="text"],{{WRAPPER}} input[type="tel"],{{WRAPPER}} input[type="date"],{{WRAPPER}} input[type="url"],{{WRAPPER}} input[type="email"],{{WRAPPER}} textarea',
                        ]
                    );
                    
                    $this->add_responsive_control(
                        'input_margin',
                        [
                            'label'      => esc_html__( 'Margin', 'reserving' ),
                            'type'       => Controls_Manager::DIMENSIONS,
                            'size_units' => [ 'px', '%', 'em' ],
                            'default'    => [
                                'top'      => '0',
                                'right'    => '0',
                                'bottom'   => '0',
                                'left'     => '0',
                                'isLinked' => false
                            ],
                            'selectors' => [
                                '{{WRAPPER}} input[type="password"],{{WRAPPER}} input[type="text"],{{WRAPPER}} input[type="tel"],{{WRAPPER}} input[type="date"],{{WRAPPER}} input[type="url"],{{WRAPPER}} input[type="email"],{{WRAPPER}} textarea' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );
                    
                    $this->add_responsive_control(
                        'input_padding',
                        [
                            'label'   => esc_html__( 'Padding', 'reserving' ),
                            'type'    => Controls_Manager::DIMENSIONS,
                            'default' => [
                                'top'      => '12',
                                'right'    => '30',
                                'bottom'   => '12',
                                'left'     => '30',
                                'isLinked' => false
                            ],
                            'size_units' => [ 'px', '%', 'em' ],
                            'selectors'  => [
                                '{{WRAPPER}} input[type="password"],{{WRAPPER}} input[type="text"],{{WRAPPER}} input[type="tel"],{{WRAPPER}} input[type="date"],{{WRAPPER}} input[type="url"],{{WRAPPER}} input[type="email"],{{WRAPPER}} textarea' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

                    $this->add_responsive_control(
                        'custom_input_css',
                        [
                            'label'     => esc_html__( 'Input Field CSS', 'reserving' ),
                            'type'      => Controls_Manager::CODE,
                            'rows'      => 20,
                            'language'  => 'css',
                            'selectors' => [
                                '{{WRAPPER}} input[type="password"],{{WRAPPER}} input[type="text"],{{WRAPPER}} input[type="tel"],{{WRAPPER}} input[type="date"],{{WRAPPER}} input[type="url"],{{WRAPPER}} input[type="email"],{{WRAPPER}} textarea' => '{{VALUE}};',
                            ],
                            'separator' => 'before',
                        ]
                    );

        		$this->end_controls_tab();

        	
				$this->start_controls_tab(
        			'tab_input_focus',
        			[
        				'label' => esc_html__( 'Hover', 'reserving' ),
        			]
        		);

            		$this->add_control(
            			'input_focus_color',
            			[
            				'label'     => esc_html__( 'Text Color', 'reserving' ),
            				'type'      => Controls_Manager::COLOR,
            				'default'   => '#79879d',
            				'selectors' => [
            					'{{WRAPPER}} input[type="password"]:focus,{{WRAPPER}} input[type="text"]:focus,{{WRAPPER}} input[type="tel"]:focus,{{WRAPPER}} input[type="date"]:focus,{{WRAPPER}} input[type="url"]:focus,{{WRAPPER}} input[type="email"]:focus,{{WRAPPER}} textarea:focus' => 'color: {{VALUE}};',
            				],
            			]
            		);

                    $this->add_group_control(
            			Group_Control_Background:: get_type(),
            			[
            				'name'     => 'input_focus_background',
            				'label'    => esc_html__( 'focus Background', 'reserving' ),
            				'types'    => [ 'classic', 'gradient' ],
            				'selector' => '{{WRAPPER}} input[type="password"]:focus,{{WRAPPER}} input[type="text"]:focus,{{WRAPPER}} input[type="tel"]:focus,{{WRAPPER}} input[type="date"]:focus,{{WRAPPER}} input[type="url"]:focus,{{WRAPPER}} input[type="email"]:focus,{{WRAPPER}} textarea:focus'
            			]
            		);
                    
            		$this->add_control(
            			'input_focus_border_color',
            			[
            				'label'     => esc_html__( 'Border Color', 'reserving' ),
            				'type'      => Controls_Manager::COLOR,
            				'selectors' => [
            					'{{WRAPPER}} input[type="password"]:focus,{{WRAPPER}} input[type="text"]:focus,{{WRAPPER}} input[type="tel"]:focus,{{WRAPPER}} input[type="date"]:focus,{{WRAPPER}} input[type="url"]:focus,{{WRAPPER}} input[type="email"]:focus,{{WRAPPER}} textarea:focus' => 'border-color: {{VALUE}};',
            				],
            			]
            		);
            		$this->add_group_control(
            			Group_Control_Box_Shadow:: get_type(),
            			[
            				'name'     => 'input_focus_box_shadow',
            				'selector' => '{{WRAPPER}} input[type="password"]:focus,{{WRAPPER}} input[type="text"]:focus,{{WRAPPER}} input[type="tel"]:focus,{{WRAPPER}} input[type="date"]:focus,{{WRAPPER}} input[type="url"]:focus,{{WRAPPER}} input[type="email"]:focus,{{WRAPPER}} textarea:focus',
            			]
            		);

        		$this->end_controls_tab();
    		$this->end_controls_tabs();
		$this->end_controls_section();

		$this->start_controls_section(
            'top_title_section',
            [
                'label' => esc_html__( 'Label', 'reserving' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );
            $this->add_group_control(
                Group_Control_Typography:: get_type(),
                [
                    'name'     => 'top_title_typography',
                    'selector' => '{{WRAPPER}} form label',
                ]
            );

            $this->add_control(
                'top_title_color',
                [
                    'label'  => esc_html__( 'Color', 'reserving' ),
                    'type'   => Controls_Manager::COLOR,
                    'selectors' => [
                        '{{WRAPPER}} form label' => 'color: {{VALUE}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'label_width',
                [
                    'label'      => esc_html__( 'Width', 'reserving' ),
                    'type'       => Controls_Manager::SLIDER,
                    'size_units' => [ 'px', '%' ],
                    'range'      => [
                        'px' => [
                            'min'  => 0,
                            'max'  => 1000,
                            'step' => 1,
                        ],
                        '%' => [
                            'min' => 0,
                            'max' => 100,
                        ],
                    ],
                    'selectors' => [
                        '{{WRAPPER}} form label' => 'width: {{SIZE}}{{UNIT}};',
                    ],
                ]
            );

            $this->add_responsive_control(
                'top_title_margin',
                [
                    'label'      => esc_html__( 'Margin', 'reserving' ),
                    'type'       => Controls_Manager::DIMENSIONS,
                    'size_units' => [ 'px', '%', 'em' ],
                    'default'    => [
                        'top'      => '0',
                        'right'    => '0',
                        'bottom'   => '15',
                        'left'     => '0',
                        'isLinked' => true
                    ],
                    'selectors' => [
                        '{{WRAPPER}} form label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );
            
            $this->add_responsive_control(
                'top_title_padding',
                [
                    'label'   => esc_html__( 'Padding', 'reserving' ),
                    'type'    => Controls_Manager::DIMENSIONS,
                    'default' => [
                        'top'      => '0',
                        'right'    => '0',
                        'bottom'   => '0',
                        'left'     => '0',
                        'isLinked' => true
                    ],
                    'size_units' => [ 'px', '%', 'em' ],
                    'selectors'  => [
                        '{{WRAPPER}} form label' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    ],
                    'separator' => 'before',
                ]
            );   
            $this->add_group_control(
    			Group_Control_Border:: get_type(),
    			[
    				'name'     => 'top_title_border',
    				'label'    => esc_html__( 'Border', 'reserving' ),
    				'selector' => '{{WRAPPER}} form label',
    			]
    		);
            $this->add_responsive_control(
                'custom_top_title_css',
                [
                    'label'     => esc_html__( 'Lavel Custom CSS', 'reserving' ),
                    'type'      => Controls_Manager::CODE,
                    'rows'      => 20,
                    'language'  => 'css',
                    'selectors' => [
                        '{{WRAPPER}} form label' => '{{VALUE}};',
                    ],
                    'separator' => 'before',
                ]
            );
        $this->end_controls_section();

		$this->start_controls_section(
			'content__section',
			[
				'label' => esc_html__( 'Content', 'reserving' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

			$this->add_control(
				'heading',
				[
					'label' => esc_html__( 'Heading', 'reserving' ),
					'type' => \Elementor\Controls_Manager::WYSIWYG,
					'default' => esc_html__( 'Login as branch manager or delivery man', 'reserving' ),
					'placeholder' => esc_html__( 'Login as branch manager or delivery man', 'reserving' ),
				]
			);


			$this->add_control(
				'website_link',
				[
					'label' => esc_html__( 'Login Link', 'reserving' ),
					'type' => \Elementor\Controls_Manager::URL,
					'placeholder' => esc_html__( 'https://your-link.com', 'reserving' ),
					'label_block' => true,
				]
			);

			$this->add_control(
				'show_login_form',
				[
					'label'        => esc_html__( 'Show Login Form', 'reserving' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'label_on'     => esc_html__( 'Show', 'reserving' ),
					'label_off'    => esc_html__( 'Hide', 'reserving' ),
					'return_value' => 'yes',
					'default'      => 'yes',
				]
			);
			
			$this->add_control(
				'button_text',
				[
					'label' => esc_html__( 'Button Text', 'reserving' ),
					'type' => \Elementor\Controls_Manager::TEXT,
					'default' => esc_html__( 'Login', 'reserving' ),
					'placeholder' => esc_html__( 'Login Button', 'reserving' ),
				]
			);

			$this->add_responsive_control(
				'box_text_align',
				[
					'label' => esc_html__( 'Alignment', 'reserving' ),
					'type' => \Elementor\Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => esc_html__( 'Left', 'reserving' ),
							'icon' => 'eicon-text-align-left',
						],
						'center' => [
							'title' => esc_html__( 'Center', 'reserving' ),
							'icon' => 'eicon-text-align-center',
						],
						'right' => [
							'title' => esc_html__( 'Right', 'reserving' ),
							'icon' => 'eicon-text-align-right',
						],
					],
					'default' => 'center',
					'toggle' => true,
					'selectors' => [
						'{{WRAPPER}} .reserving-frontend-dashboard-wrapper' => 'text-align: {{VALUE}};',
					],
				]
			);

		$this->end_controls_section();
		
	}

	protected function render() {
	 
	  $settings = $this->get_settings_for_display();
      
      $arr = [
		'default_login'    => $settings['website_link']['url'],
		'login_button_msg' => $settings['heading'],
		'button_text'      => $settings['button_text'],
		'show_login_form'  => $settings['show_login_form'] == 'yes' ? true : false
	  ];

      $shortcode_with_var = sprintf( '[reserving_frontend_dashboard default_login="%s" login_button_msg="%s" button_text="%s" show_login_form="%s" ]',
	   esc_attr($arr['default_login']),
	   esc_html($arr['login_button_msg']), 
	   esc_html($arr['button_text']), 
	   esc_attr($arr['show_login_form'])
	  );

      echo do_shortcode( $shortcode_with_var );
	
	}
}