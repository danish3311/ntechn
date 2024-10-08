<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}
if (!priotech_is_woocommerce_activated()) {
    return;
}

use Elementor\Controls_Manager;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Priotech\Elementor\Priotech_Base_Widgets;

/**
 * Elementor Priotech_Elementor_Products_Categories
 * @since 1.0.0
 */
class Priotech_Elementor_Products_Categories extends Priotech_Base_Widgets {

    public function get_categories() {
        return array('priotech-addons');
    }

    /**
     * Get widget name.
     *
     * Retrieve tabs widget name.
     *
     * @return string Widget name.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_name() {
        return 'priotech-product-categories';
    }

    /**
     * Get widget title.
     *
     * Retrieve tabs widget title.
     *
     * @return string Widget title.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_title() {
        return esc_html__('Priotech Product Categories', 'priotech');
    }

    /**
     * Get widget icon.
     *
     * Retrieve tabs widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_script_depends() {
        return ['priotech-elementor-product-categories'];
    }

    public function on_export($element) {
        unset($element['settings']['category_image']['id']);

        return $element;
    }

    protected function register_controls() {

        //Section Query
        $this->start_controls_section(
            'section_setting',
            [
                'label' => esc_html__('Categories', 'priotech'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );
        $repeater = new Repeater();

        $repeater->add_control(
            'categories_name',
            [
                'label' => esc_html__('Alternate Name', 'priotech'),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'categories_sub_name',
            [
                'label' => esc_html__('Sub', 'priotech'),
                'type'  => Controls_Manager::TEXT,
            ]
        );

        $repeater->add_control(
            'categories',
            [
                'label'       => esc_html__('Categories', 'priotech'),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'options'     => $this->get_product_categories(),
                'multiple'    => false,
            ]
        );
        
        $repeater->add_control(
            'min-width',
            [
                'label'      => esc_html__('Width', 'priotech'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'vh'],
                'selectors'  => [
                    '{{WRAPPER}} .product-cat' => 'min-width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );


        $repeater->add_control(
            'selected_icon',
            [
                'label' => esc_html__('Icon', 'priotech'),
                'type'  => Controls_Manager::ICONS,
            ]
        );

        $repeater->add_control(
            'category_image',
            [
                'label'      => esc_html__('Choose Image', 'priotech'),
                'default'    => [
                    'url' => Elementor\Utils::get_placeholder_image_src(),
                ],
                'type'       => Controls_Manager::MEDIA,
                'show_label' => false,
            ]

        );


        $this->add_control(
            'categories_list',
            [
                'label'       => esc_html__('Items', 'priotech'),
                'type'        => Controls_Manager::REPEATER,
                'fields'      => $repeater->get_controls(),
                'title_field' => '{{{ categories }}}',
            ]
        );

        $this->add_group_control(
            Elementor\Group_Control_Image_Size::get_type(),
            [
                'name'      => 'image', // Usage: `{name}_size` and `{name}_custom_dimension`, in this case `brand_image_size` and `brand_image_custom_dimension`.
                'default'   => 'full',
                'separator' => 'none',
            ]
        );


        $this->add_control(
            'style',
            [
                'label'        => esc_html__('Style', 'priotech'),
                'type'         => Controls_Manager::SELECT,
                'default'      => '1',
                'options'      => [
                    '1' => esc_html__('Style 1', 'priotech'),
                    '2' => esc_html__('Style 2', 'priotech'),
                    '3' => esc_html__('Style 3', 'priotech'),
                    '4' => esc_html__('Style 4', 'priotech'),
                ],
                'prefix_class' => 'category-product-style-'
            ]
        );

        $this->add_responsive_control(
           'last_child_height',
           [
               'label'          => esc_html__('Height', 'priotech'),
               'type'           => Controls_Manager::SLIDER,
               'description' => esc_html__('Image Activate Last Child Height', 'priotech'),
               'default'        => [
                   'unit' => 'px',
               ],
               'tablet_default' => [
                   'unit' => 'px',
               ],
               'mobile_default' => [
                   'unit' => 'px',
               ],
               'size_units'     => ['%', 'px', 'vh'],
               'range'          => [
                     '%'  => [
                        'min' => 1,
                        'max' => 100,
                     ],
                   'px' => [
                       'min' => 1,
                       'max' => 500,
                   ],
                   'vh' => [
                       'min' => 1,
                       'max' => 100,
                   ],
               ],
               'selectors' => [
                   '{{WRAPPER}} .category-product-img' => 'height: {{SIZE}}{{UNIT}};',
               ],
           ]
       );

        $this->add_control('show_count',
            [
                'label' => esc_html__('Show Count', 'priotech'),
                'type'  => Controls_Manager::SWITCHER,
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'box_section_style',
            [
                'label' => esc_html__('Box', 'priotech'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'box_padding',
            [
                'label'      => esc_html__('Padding', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} div .product-cat' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'box_margin',
            [
                'label'      => esc_html__('Margin', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .product-cat' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'min-height',
            [
                'label'      => esc_html__('Height', 'priotech'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 100,
                        'max' => 1000,
                    ],
                    'vh' => [
                        'min' => 10,
                        'max' => 100,
                    ],
                ],
                'size_units' => ['px', 'vh'], 
                'selectors'  => [
                    '{{WRAPPER}} .product-cat' => 'height: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'box_border_radius',
            [
                'label'      => esc_html__('Border Radius', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .product-cat' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tabs_box_style');
        $this->start_controls_tab(
            'box_img_normal',
            [
                'label' => esc_html__('Normal', 'priotech'),
            ]
        );


        $this->add_control(
            'box_background',
            [
                'label'     => esc_html__('Background Color', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-cat' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->add_control(
            'box_opacity',
            [
                'label'     => esc_html__('Opacity', 'priotech'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-cat' => 'opacity: {{SIZE}};',
                ],
            ]
        );
        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_box_hover',
            [
                'label' => esc_html__('Hover', 'priotech'),
            ]
        );


        $this->add_control(
            'box_background_hover',
            [
                'label'     => esc_html__('Background Color', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .product-cat:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'box_opacity_hover',
            [
                'label'     => esc_html__('Opacity', 'priotech'),
                'type'      => Controls_Manager::SLIDER,
                'range'     => [
                    'px' => [
                        'max'  => 1,
                        'min'  => 0.10,
                        'step' => 0.01,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .product-cat:hover' => 'opacity: {{SIZE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

         $this->add_responsive_control(
            'effects_width',
            [
                'label'          => esc_html__('Width Effects', 'priotech'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units'     => ['%', 'px', 'vw'],
                'range'          => [
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .category-product-caption'     => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'image_style',
            [
                'label' => esc_html__('Image', 'priotech'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );


        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'image_border',
                'selector'  => '{{WRAPPER}} {{WRAPPER}} .category-product-img',
                'separator' => 'before',
            ]
        );
        $this->add_responsive_control(
            'image_border_radius',
            [
                'label'      => esc_html__('Border radius', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .category-product-img, {{WRAPPER}} .category-product-img img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                    '{{WRAPPER}} .category-product-img a:before' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}}',
                ],
            ]
        );

        $this->add_control(
            'box_img_background',
            [
                'label'     => esc_html__('Background Color', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .category-product-img' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'image_box_shadow',
                'selector' => '{{WRAPPER}} .category-product-img',
            ]
        );

        $this->add_responsive_control(
            'image_max_width',
            [
                'label'          => esc_html__('Max Width', 'priotech'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units'     => ['%', 'px', 'vw'],
                'range'          => [
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .category-product-img' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label'          => esc_html__('Width', 'priotech'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => '%',
                ],
                'tablet_default' => [
                    'unit' => '%',
                ],
                'mobile_default' => [
                    'unit' => '%',
                ],
                'size_units'     => ['%', 'px', 'vw'],
                'range'          => [
                    '%'  => [
                        'min' => 1,
                        'max' => 100,
                    ],
                    'px' => [
                        'min' => 1,
                        'max' => 1000,
                    ],
                    'vw' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .category-product-img'     => 'width: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .category-product-img img' => 'width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_height',
            [
                'label'          => esc_html__('Height', 'priotech'),
                'type'           => Controls_Manager::SLIDER,
                'default'        => [
                    'unit' => 'px',
                ],
                'tablet_default' => [
                    'unit' => 'px',
                ],
                'mobile_default' => [
                    'unit' => 'px',
                ],
                'size_units'     => ['px', 'vh'],
                'range'          => [
                    'px' => [
                        'min' => 1,
                        'max' => 500,
                    ],
                    'vh' => [
                        'min' => 1,
                        'max' => 100,
                    ],
                ],
                'selectors'      => [
                    '{{WRAPPER}} .category-product-img'     => 'height: {{SIZE}}{{UNIT}};',
                    '{{WRAPPER}} .category-product-img img' => 'height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_object_fit',
            [
                'label'     => esc_html__('Object Fit', 'priotech'),
                'type'      => Controls_Manager::SELECT,
                'condition' => [
                    'image_height[size]!' => '',
                ],
                'options'   => [
                    ''        => esc_html__('Default', 'priotech'),
                    'fill'    => esc_html__('Fill', 'priotech'),
                    'cover'   => esc_html__('Cover', 'priotech'),
                    'contain' => esc_html__('Contain', 'priotech'),
                ],
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} img' => 'object-fit: {{VALUE}};',
                ],
            ]
        );
        $this->add_responsive_control(
            'image_padding',
            [
                'label'      => esc_html__('Padding', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .category-product-img' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'image_margin',
            [
                'label'      => esc_html__('Margin', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .category-product-img' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'vertical_position_img',
            [
                'label'        => esc_html__('Vertical Position', 'priotech'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'priotech'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center'     => [
                        'title' => esc_html__('Middle', 'priotech'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__('Bottom', 'priotech'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'separator'    => 'none',
                'selectors'    => [
                    '{{WRAPPER}} .product-cat' => 'align-items: {{VALUE}} ;',
                ],
            ]
        );

        $this->add_responsive_control(
            'horizontal_position_img',
            [
                'label'        => esc_html__('Horizontal Position', 'priotech'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'priotech'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__('Center', 'priotech'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__('Right', 'priotech'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'separator'    => 'none',
                'selectors'    => [
                    '{{WRAPPER}} .product-cat' => 'justify-content: {{VALUE}} ;',
                ],
            ]
        );

        $this->end_controls_section();

         $this->start_controls_section(
             'icon_style',
              [
                'label' => esc_html__('Icon', 'priotech'),
                'tab'   => Controls_Manager::TAB_STYLE,
              ]
         );

         $this->add_responsive_control(
          'icon_size',
              [
                  'label'          => esc_html__('Icon size', 'priotech'),
                  'type'           => Controls_Manager::SLIDER,
                  'range'      => [
                      'px' => [
                          'min' => 30,
                          'max' => 500,
                      ],
                  ],
                  'size_units' => ['px', 'em', '%'],
                  'selectors'      => [
                      '{{WRAPPER}} .category-product-img a i' => 'font-size: {{SIZE}}{{UNIT}};',
                  ],
              ]
          );

           $this->start_controls_tabs('tab_icon');
           $this->start_controls_tab(
              'tab_icon_normal',
              [
                  'label' => esc_html__('Normal', 'priotech'),
              ]
          );
          $this->add_control(
              'icon_color',
              [
                  'label'     => esc_html__('Color', 'priotech'),
                  'type'      => Controls_Manager::COLOR,
                  'default'   => '',
                  'selectors' => [
                      '{{WRAPPER}} .category-product-img a i' => 'color: {{VALUE}};',
                  ],
              ]
          );

          $this->end_controls_tab();
          $this->start_controls_tab(
              'tab_icon_hover',
              [
                  'label' => esc_html__('Hover', 'priotech'),
              ]
          );
          $this->add_control(
              'icon_color_hover',
              [
                  'label'     => esc_html__('Hover Color', 'priotech'),
                  'type'      => Controls_Manager::COLOR,
                  'default'   => '',
                  'selectors' => [
                      '{{WRAPPER}} .product-cat:hover .category-product-img a i' => 'color: {{VALUE}};',
                  ],
              ]
          );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'box_text_style',
            [
                'label' => esc_html__('Box text', 'priotech'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'alignment',
            [
                'label'     => esc_html__('Text Align', 'priotech'),
                'type'      => Controls_Manager::CHOOSE,
                'options'   => [
                    'left'   => [
                        'title' => esc_html__('Left', 'priotech'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'center' => [
                        'title' => esc_html__('Center', 'priotech'),
                        'icon'  => 'eicon-text-align-center',
                    ],
                    'right'  => [
                        'title' => esc_html__('Right', 'priotech'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default'   => 'center',
                'selectors' => [
                    '{{WRAPPER}} .elementor-widget-container' => 'text-align: {{VALUE}}',
                    '{{WRAPPER}} .category-product-caption'   => 'text-align: {{VALUE}}',
                ],
            ]
        );

        $this->add_responsive_control(
            'vertical_position',
            [
                'label'        => esc_html__('Vertical Position', 'priotech'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'flex-start' => [
                        'title' => esc_html__('Top', 'priotech'),
                        'icon'  => 'eicon-v-align-top',
                    ],
                    'center'     => [
                        'title' => esc_html__('Middle', 'priotech'),
                        'icon'  => 'eicon-v-align-middle',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__('Bottom', 'priotech'),
                        'icon'  => 'eicon-v-align-bottom',
                    ],
                ],
                'prefix_class' => 'box-valign-',
                'separator'    => 'none',
                'selectors'    => [
                    '{{WRAPPER}} .category-product-caption' => 'align-items: {{VALUE}} ;',
                ],
            ]
        );

        $this->add_responsive_control(
            'horizontal_position',
            [
                'label'        => esc_html__('Horizontal Position', 'priotech'),
                'type'         => Controls_Manager::CHOOSE,
                'options'      => [
                    'flex-start' => [
                        'title' => esc_html__('Left', 'priotech'),
                        'icon'  => 'eicon-h-align-left',
                    ],
                    'center'     => [
                        'title' => esc_html__('Center', 'priotech'),
                        'icon'  => 'eicon-h-align-center',
                    ],
                    'flex-end'   => [
                        'title' => esc_html__('Right', 'priotech'),
                        'icon'  => 'eicon-h-align-right',
                    ],
                ],
                'prefix_class' => 'box-halign-',
                'separator'    => 'none',
                'selectors'    => [
                    '{{WRAPPER}} .category-product-caption' => 'justify-content: {{VALUE}} ;',
                ],
            ]
        );

        

        $this->end_controls_section();

        $this->start_controls_section(
            'title_style',
            [
                'label' => esc_html__('Title', 'priotech'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'tilte_typography',
                'selector' => '{{WRAPPER}} .category-title',
            ]
        );


        $this->add_responsive_control(
            'title_margin',
            [
                'label'      => esc_html__('Margin', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .category-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'title_padding',
            [
                'label'      => esc_html__('Padding', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .category-title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('tab_title');
        $this->start_controls_tab(
            'tab_title_normal',
            [
                'label' => esc_html__('Normal', 'priotech'),
            ]
        );
        $this->add_control(
            'title_color',
            [
                'label'     => esc_html__('Color', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .category-title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->start_controls_tab(
            'tab_title_hover',
            [
                'label' => esc_html__('Hover', 'priotech'),
            ]
        );
        $this->add_control(
            'title_color_hover',
            [
                'label'     => esc_html__('Hover Color', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}}.elementor-widget-priotech-product-categories .category-title a:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();
        $this->end_controls_tabs();

        $this->end_controls_section();

        $this->start_controls_section(
            'total_style',
            [
                'label' => esc_html__('Total', 'priotech'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name'     => 'total_typography',
                'selector' => '{{WRAPPER}} .category-count-wrapper',
            ]
        );

         $this->add_responsive_control(
            'total_margin',
            [
                'label'      => esc_html__('Margin', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .category-count-wrapper' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'total_padding',
            [
                'label'      => esc_html__('Padding', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors'  => [
                    '{{WRAPPER}} .category-count-wrapper' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'total_color_text',
            [
                'label'     => esc_html__('Color Count Text', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .category-count-text' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_control(
            'total_color',
            [
                'label'     => esc_html__('Color Count', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .category-count' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
        $this->get_controls_column();
        // Carousel options
        $this->get_control_carousel();
    }

    protected function get_product_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'product_cat',
                'hide_empty' => false,
            )
        );
        $results    = array();
        if (!is_wp_error($categories)) {
            foreach ($categories as $category) {
                $results[$category->slug] = $category->name;
            }
        }
        return $results;
    }

    /**
     * Render tabs widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        if (!empty($settings['categories_list']) && is_array($settings['categories_list'])) {
            $this->get_data_elementor_columns();

            $this->add_render_attribute('wrapper', 'class', 'elementor-categories-item-wrapper');
            // Item
            $this->add_render_attribute('item', 'class', 'elementor-categories-item');
            $migration_allowed = Icons_Manager::is_migration_allowed();
            ?>
            <div <?php $this->print_render_attribute_string('wrapper'); ?>>
                <div <?php $this->print_render_attribute_string('container'); ?>>
                    <div <?php $this->print_render_attribute_string('inner'); ?>>
                        <?php foreach ($settings['categories_list'] as $index => $item): ?>
                            <?php
                            //category_icon
                            $migrated              = isset($item['__fa4_migrated']['selected_icon']);
                            $is_new                = !isset($item['icon']) && $migration_allowed;
                            $class_item            = 'elementor-repeater-item-' . $item['_id'];
                            $tab_title_setting_key = $this->get_repeater_setting_key('tab_title', 'tabs', $index);
                            $this->add_render_attribute($tab_title_setting_key, ['class' => ['product-cat', $class_item],]);

                            ?>
                            <div <?php $this->print_render_attribute_string('item'); ?>>
                                <?php if (empty($item['categories'])) {
                                    echo esc_html__('Choose Category', 'priotech');
                                    return;
                                }
                                $category = get_term_by('slug', $item['categories'], 'product_cat');
                                if (!is_wp_error($category) && !empty($category)) {
                                    if (!empty($item['category_image']['id'])) {
                                        $image = Group_Control_Image_Size::get_attachment_image_src($item['category_image']['id'], 'image', $settings);
                                    } else {
                                        $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                                        if (!empty($thumbnail_id)) {
                                            $image = wp_get_attachment_url($thumbnail_id);
                                        } else {
                                            $image = wc_placeholder_img_src();
                                        }
                                    }
                                    $categories_sub_name = empty($item['categories_sub_name']) ? esc_html($category->sud) : sprintf('%s', $item['categories_sub_name']);
                                    $categories_name = empty($item['categories_name']) ? esc_html($category->name) : sprintf('%s', $item['categories_name']);
                                    ?>

                                    <div <?php $this->print_render_attribute_string($tab_title_setting_key); ?> onclick="window.location='<?php echo esc_url(get_term_link($category)); ?>'">

                                        <div class="category-product-img">
                                            <a class="category-product-link" href="<?php echo esc_url(get_term_link($category)); ?>"
                                               title="<?php echo esc_attr($category->name); ?>">
                                                <?php
                                                if ($is_new || $migrated) {
                                                    Icons_Manager::render_icon($item['selected_icon'], ['aria-hidden' => 'true']);
                                                }
                                                ?>
                                                <img src="<?php echo esc_url_raw($image); ?>"
                                                     alt="<?php echo esc_attr($category->name); ?>">
                                            </a>
                                        </div>

                                        <div class="category-product-caption">
                                            <div class="category-product-caption-inner">
                                                <div class="category-product-content">
                                                    <span class="category-sub">
                                                        <?php echo esc_html($categories_sub_name) ?>
                                                    </span>
                                                    <h4 class="category-title">
                                                        <a class="category-product-link" href="<?php echo esc_url(get_term_link($category)); ?>"
                                                        title="<?php echo esc_attr($category->name); ?>">
                                                            <?php echo esc_html($categories_name) ?>
                                                        </a>
                                                    </h4>

                                                    <?php if ($settings['show_count']): ?>
                                                        <div class="category-count-wrapper">
                                                            <span class="category-count"><?php echo esc_html($category->count); ?></span>
                                                            <span class="category-count-text"><?php echo esc_html__('products', 'priotech') ?></span>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>

                                            </div>
                                        </div>
                                        <?php if ($settings['style'] && $settings['style'] == 1): ?>
                                            <div class="category-product-button-wrapper">
                                                <a class="category-product-button more-link" href="<?php echo esc_url(get_term_link($category)); ?>"
                                                title="<?php echo esc_attr($category->name); ?>">
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php $this->get_swiper_navigation(count($settings['categories_list'])); ?>
            </div>

            <?php
        }
    }
}

$widgets_manager->register(new Priotech_Elementor_Products_Categories());

