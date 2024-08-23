<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Elementor\Controls_Manager;

class Priotech_Elementor_Info_Canvas extends Elementor\Widget_Base {

    public function get_name() {
        return 'priotech-info-canvas';
    }

    public function get_title() {
        return esc_html__('Priotech Info Canvas', 'priotech');
    }

    public function get_icon() {
        return 'eicon-nav-menu';
    }

    public function get_categories() {
        return ['priotech-addons'];
    }

    public function get_info() {
        global $post;

        $options[''] = esc_html__('Select Info', 'priotech');
        if (!priotech_is_elementor_activated()) {
            return;
        }
        $args = array(
            'post_type'      => 'elementor_library',
            'posts_per_page' => -1,
            'orderby'        => 'title',
            's'              => 'Info',
            'order'          => 'ASC',
        );

        $query1 = new WP_Query($args);
        while ($query1->have_posts()) {
            $query1->the_post();
            $options[$post->post_name] = $post->post_title;
        }

        wp_reset_postdata();
        return $options;
    }

    protected function register_controls() {
        $this->start_controls_section(
            'info_sesion_content',
            [
                'label' => esc_html__('Content', 'priotech'),
            ]
        );

        $this->add_control(
            'info',
            [
                'label'   => esc_html__('Info Page', 'priotech'),
                'type'    => Controls_Manager::SELECT,
                'options' => $this->get_info(),
            ]
        );

        $this->add_responsive_control(
            'align',
            [
                'label'   => esc_html__('Alignment', 'priotech'),
                'type'    => Controls_Manager::CHOOSE,
                'options' => [
                    'left'  => [
                        'title' => esc_html__('Left', 'priotech'),
                        'icon'  => 'eicon-text-align-left',
                    ],
                    'right' => [
                        'title' => esc_html__('Right', 'priotech'),
                        'icon'  => 'eicon-text-align-right',
                    ],
                ],
                'default' => 'right',
            ]
        );

        $this->add_responsive_control(
            'image_width',
            [
                'label'      => esc_html__('Width', 'priotech'),
                'type'       => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range'      => [
                    'px' => [
                        'min' => 300,
                        'max' => 600,
                    ],
                ],
                'selectors'  => [
                    'body .priotech-canvas-info' => '--e-global-info-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        $this->start_controls_section(
            'icon_info_style',
            [
                'label' => esc_html__('Icon', 'priotech'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->start_controls_tabs('color_tabs');

        $this->start_controls_tab('colors_normal',
            [
                'label' => esc_html__('Normal', 'priotech'),
            ]
        );

        $this->add_control(
            'info_color',
            [
                'label'     => esc_html__('Color', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .kitcho-info-button .priotech-icon > span' => 'background-color: {{VALUE}};',
                ],
            ]
        );


        $this->end_controls_tab();

        $this->start_controls_tab(
            'colors_hover',
            [
                'label' => esc_html__('Hover', 'priotech'),
            ]
        );

        $this->add_control(
            '_menu_color_hover',
            [
                'label'     => esc_html__('Color', 'priotech'),
                'type'      => Controls_Manager::COLOR,
                'default'   => '',
                'selectors' => [
                    '{{WRAPPER}} .kitcho-info-button:hover .priotech-icon > span' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();

    }

    public function render_info() {
        $settings     = $this->get_settings_for_display();
        $slug         = $settings['info'];
        $queried_post = get_page_by_path($slug, OBJECT, 'elementor_library');
        ?>
        <div class="priotech-canvas-info priotech-canvas-info-<?php echo esc_attr($settings['align']) ?>">
            <a href="#" class="priotech-canvas-info-close"><i class="priotech-icon-times"></i></a>
            <?php if (isset($queried_post->ID)) {
                echo Elementor\Plugin::instance()->frontend->get_builder_content($queried_post->ID);
            } else {
                echo '<p>' . esc_html__('No Content', 'priotech') . '</p>';
            }
            ?>
        </div>

        <div class="priotech-info-overlay"></div>
        <?php
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $slug     = $settings['info'];
        add_action('wp_footer', array($this, 'render_info'));

        $this->add_render_attribute('wrapper', 'class', 'elementor-canvas-info-wrapper');

        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <a href="#" class="priotech-info-button">
                <div class="priotech-icon">
                    <span class="icon-1"></span>
                    <span class="icon-2"></span>
                    <span class="icon-3"></span>
                </div>
            </a>
        </div>
        <?php
    }
}

$widgets_manager->register(new Priotech_Elementor_Info_Canvas());
