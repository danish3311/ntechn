<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Priotech_Elementor_Search extends Elementor\Widget_Base {
    public function get_name() {
        return 'priotech-search';
    }

    public function get_title() {
        return esc_html__('Priotech Search Form', 'priotech');
    }

    public function get_icon() {
        return 'eicon-site-search';
    }

    public function get_categories() {
        return array('priotech-addons');
    }

    protected function register_controls() {
        $this->start_controls_section(
            'search-form-style',
            [
                'label' => esc_html__('Style', 'priotech'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'layout_style',
            [
                'label'   => esc_html__('Layout Style', 'priotech'),
                'type'    => Controls_Manager::SELECT,
                'options' => [
                    'layout-1' => esc_html__('Layout 1', 'priotech'),
                    'layout-2' => esc_html__('Layout 2', 'priotech'),
                    'layout-3' => esc_html__('Layout 3', 'priotech'),
                ],
                'default' => 'layout-1',
            ]
        );


        $this->add_responsive_control(
            'border_width',
            [
                'label'      => esc_html__('Border width', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}} form input[type=search]' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'border_color',
            [
                'label'     => esc_html__('Border Color', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'border_color_focus',
            [
                'label'     => esc_html__('Border Color Focus', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]:focus' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'text_color',
            [
                'label'     => esc_html__('Text Color', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .button-search-popup .content' => 'color: {{VALUE}};',
                ],
            ]
        );

         $this->add_control(
                    'text_color_hover',
                    [
                        'label'     => esc_html__('Text Hover', 'priotech'),
                        'type'      => Controls_Manager::COLOR,
                        'default'   => '',
                        'selectors' => [
                            '{{WRAPPER}} .button-search-popup:hover .content' => 'color: {{VALUE}};',
                        ],
                    ]
                );

        $this->add_control(
            'text_color_placeholder',
            [
                'label'     => esc_html__('Text Color Placeholder', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]::placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'background_form',
            [
                'label'     => esc_html__('Background Form', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} form input[type=search]' => 'background: {{VALUE}};',
                ],
            ]
        );

         $this->add_control(
              'icon_color_form',
              [
                    'label'     => esc_html__('Color Icon', 'priotech'),
                    'type'      => Controls_Manager::COLOR,
                    'default'   => '',
                    'selectors' => [
                        '{{WRAPPER}}.elementor-widget-priotech-search .widget form button[type=submit]:before' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .button-search-popup .priotech-icon-search1' => 'color: {{VALUE}};',
                    ],
              ]
         );

          $this->add_control(
                 'icon_color_form_hover',
                 [
                     'label'     => esc_html__('Icon Hover', 'priotech'),
                     'type'      => Controls_Manager::COLOR,
                     'default'   => '',
                     'selectors' => [
                     '{{WRAPPER}}.elementor-widget-priotech-search .widget form button[type=submit]:hover:before' => 'color: {{VALUE}};',
                        '{{WRAPPER}} .button-search-popup:hover .priotech-icon-search1' => 'color: {{VALUE}};',
                     ],
                 ]
          );

        $this->add_control(
            'border_radius_input',
            [
                'label'      => esc_html__('Border Radius Input', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .widget_product_search form input[type=search]' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding_input',
            [
                'label'      => esc_html__('Padding Input', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .widget_product_search form input[type=search]' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'width_button',
            [
                'label'      => esc_html__('Width Button', 'priotech'),
                'type'       => Controls_Manager::SLIDER,
                'range'      => [
                    'px' => [
                        'min' => 40,
                        'max' => 200,
                    ],
                ],
                'size_units' => ['px'],
                'selectors'  => [
                    '{{WRAPPER}}.elementor-widget-priotech-search .widget form button[type=submit]' => 'width: {{SIZE}}{{UNIT}}',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        if ($settings['layout_style'] === 'layout-1'):{
            if(priotech_is_woocommerce_activated()){
                priotech_product_search();
            }else{
                ?>
                <div class="site-search widget_search">
                    <?php get_search_form(); ?>
                </div>
                <?php
            }

        }
        endif;

        if ($settings['layout_style'] === 'layout-2'):{
            wp_enqueue_script('priotech-search-popup');
            add_action('wp_footer', 'priotech_header_search_popup', 1);
            ?>
            <div class="site-header-search">
                <a href="#" class="button-search-popup">
                    <i class="priotech-icon-search"></i>
                    <span class="content"><?php echo esc_html__('Search', 'priotech'); ?></span>
                </a>
            </div>
            <?php
        }
        endif;

         if ($settings['layout_style'] === 'layout-3'):{
            wp_enqueue_script('priotech-search-popup');
            add_action('wp_footer', 'priotech_header_search_popup', 1);
            ?>
            <div class="site-header-search">
                <a href="#" class="button-search-popup layout-3">
                    <i class="priotech-icon-search1"></i>
                     <span class="content"><?php echo esc_html__('Search', 'priotech'); ?></span>
                </a>
            </div>
            <?php
        }
        endif;

    }
}

$widgets_manager->register(new Priotech_Elementor_Search());
