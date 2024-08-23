<?php
// Button
use Elementor\Controls_Manager;

add_action('elementor/element/button/section_button/after_section_end', function ($element, $args) {
    $element->update_control(
        'button_type',
        [
            'label'        => esc_html__('Type', 'priotech'),
            'type'         => Controls_Manager::SELECT,
            'default'      => 'default',
            'options'      => [
                'default'  => esc_html__('Default', 'priotech'),
                'secondary'=> esc_html__('Secondary', 'priotech'),
                'outline'  => esc_html__('OutLine', 'priotech'),
                'info'     => esc_html__('Info', 'priotech'),
                'success'  => esc_html__('Success', 'priotech'),
                'warning'  => esc_html__('Warning', 'priotech'),
                'danger'   => esc_html__('Danger', 'priotech'),
                'link'     => esc_html__('Link', 'priotech'),
            ],
            'prefix_class' => 'elementor-button-',
        ]
    );

}, 10, 2);

add_action( 'elementor/element/button/section_style/after_section_end', function ($element, $args ) {

    $element->update_control(
        'background_color',
        [
            'global' => [
                'default' => '',
            ],
			'selectors' => [
				'{{WRAPPER}} .elementor-button' => ' background-color: {{VALUE}};',
			],
        ]
    );
}, 10, 2 );

add_action('elementor/element/button/section_style/before_section_end', function ($element, $args) {

    $element->add_control(
        'button_style_categories',
        [
            'label'        => esc_html__('Button Categories', 'priotech'),
            'type'         => Controls_Manager::SWITCHER,
            'prefix_class' => 'button-style-category-',
            'separator'    => 'before',
            'condition' => [
                'button_type[value]' => 'link',
            ],
        ]
    );

    $element->add_control(
        'icon_button_size',
        [
            'label' => esc_html__('Icon Size', 'priotech'),
            'type' => Controls_Manager::SLIDER,
            'range' => [
                'px' => [
                    'min' => 6,
                    'max' => 300,
                ],
            ],
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon i' => 'font-size: {{SIZE}}{{UNIT}};',
                '{{WRAPPER}} .elementor-button .elementor-button-icon'   => 'display: flex; align-items: center;',
            ],
            'condition' => [
                'selected_icon[value]!' => '',
            ],
        ]
    );
    $element->add_control(
        'button_icon_color',
        [
            'label'     => esc_html__('Icon Color', 'priotech'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-button .elementor-button-icon i' => 'fill: {{VALUE}}; color: {{VALUE}};',
                '{{WRAPPER}}.button-link-yes .elementor-button .elementor-button-content-wrapper:after' => 'background-color: {{VALUE}};',
                '{{WRAPPER}}.button-link-yes .elementor-button .elementor-button-content-wrapper:before' => 'border-top-color: {{VALUE}}; border-right-color: {{VALUE}};',
            ],

        ]
    );

    $element->add_control(
        'button_icon_color_hover',
        [
            'label'     => esc_html__('Icon Color Hover', 'priotech'),
            'type'      => Controls_Manager::COLOR,
            'default'   => '',
            'selectors' => [
                '{{WRAPPER}} .elementor-button:hover .elementor-button-icon i' => 'fill: {{VALUE}}; color: {{VALUE}};',
                '{{WRAPPER}}.button-link-yes .elementor-button:hover .elementor-button-content-wrapper:after' => 'background-color: {{VALUE}};',
                '{{WRAPPER}}.button-link-yes .elementor-button:hover .elementor-button-content-wrapper:before' => 'border-top-color: {{VALUE}}; border-right-color: {{VALUE}};',
            ],

        ]
    );


}, 10, 2);




