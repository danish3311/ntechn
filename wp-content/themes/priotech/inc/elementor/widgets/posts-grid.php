<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

use Priotech\Elementor\Priotech_Base_Widgets;
use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Colors;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Typography;


/**
 * Class Priotech_Elementor_Blog
 */
class Priotech_Elementor_Post_Grid extends Priotech_Base_Widgets {

    public function get_name() {
        return 'priotech-post-grid';
    }

    public function get_title() {
        return esc_html__('Posts Grid', 'priotech');
    }

    /**
     * Get widget icon.
     *
     * Retrieve testimonial widget icon.
     *
     * @return string Widget icon.
     * @since  1.0.0
     * @access public
     *
     */
    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return array('priotech-addons');
    }

    public function get_script_depends() {
        return ['priotech-elementor-posts-grid'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'section_query',
            [
                'label' => esc_html__('Query', 'priotech'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'posts_per_page',
            [
                'label'   => esc_html__('Posts Per Page', 'priotech'),
                'type'    => Controls_Manager::NUMBER,
                'default' => 6,
            ]
        );


        $this->add_control(
            'advanced',
            [
                'label' => esc_html__('Advanced', 'priotech'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'orderby',
            [
                'label'   => esc_html__('Order By', 'priotech'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'post_date',
                'options' => [
                    'post_date'  => esc_html__('Date', 'priotech'),
                    'post_title' => esc_html__('Title', 'priotech'),
                    'menu_order' => esc_html__('Menu Order', 'priotech'),
                    'rand'       => esc_html__('Random', 'priotech'),
                ],
            ]
        );

        $this->add_control(
            'order',
            [
                'label'   => esc_html__('Order', 'priotech'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'desc',
                'options' => [
                    'asc'  => esc_html__('ASC', 'priotech'),
                    'desc' => esc_html__('DESC', 'priotech'),
                ],
            ]
        );

        $this->add_control(
            'categories',
            [
                'label'       => esc_html__('Categories', 'priotech'),
                'type'        => Controls_Manager::SELECT2,
                'options'     => $this->get_post_categories(),
                'label_block' => true,
                'multiple'    => true,
            ]
        );

        $this->add_control(
            'cat_operator',
            [
                'label'     => esc_html__('Category Operator', 'priotech'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => esc_html__('AND', 'priotech'),
                    'IN'     => esc_html__('IN', 'priotech'),
                    'NOT IN' => esc_html__('NOT IN', 'priotech'),
                ],
                'condition' => [
                    'categories!' => ''
                ],
            ]
        );

        $this->add_control(
            'layout',
            [
                'label' => esc_html__('Layout', 'priotech'),
                'type'  => Controls_Manager::HEADING,
            ]
        );

        $this->add_control(
            'post_style',
            [
                'label'   => esc_html__('Style', 'priotech'),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => [
                    'post-style-1' => esc_html__('Style 1', 'priotech'),
                ],
                'default' => 'post-style-1'
            ]
        );
        $this->end_controls_section();

        $this->get_control_pagination();
        $this->get_controls_column();
        $this->get_control_carousel();
    }

    protected function get_post_categories() {
        $categories = get_terms(array(
                'taxonomy'   => 'category',
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

    public static function get_query_args($settings) {
        $query_args = [
            'post_type'           => 'post',
            'orderby'             => $settings['orderby'],
            'order'               => $settings['order'],
            'ignore_sticky_posts' => 1,
            'post_status'         => 'publish', // Hide drafts/private posts for admins
        ];

        if (!empty($settings['categories'])) {
            $categories = array();
            foreach ($settings['categories'] as $category) {
                $cat = get_term_by('slug', $category, 'category');
                if (!is_wp_error($cat) && is_object($cat)) {
                    $categories[] = $cat->term_id;
                }
            }

            if ($settings['cat_operator'] == 'AND') {
                $query_args['category__and'] = $categories;
            } elseif ($settings['cat_operator'] == 'IN') {
                $query_args['category__in'] = $categories;
            } else {
                $query_args['category__not_in'] = $categories;
            }
        }

        $query_args['posts_per_page'] = $settings['posts_per_page'];
        if ($settings['post_style'] == 'post-special') {
            $query_args['posts_per_page'] = 4;
        }

        if (is_front_page()) {
            $query_args['paged'] = (get_query_var('page')) ? get_query_var('page') : 1;
        } else {
            $query_args['paged'] = (get_query_var('paged')) ? get_query_var('paged') : 1;
        }

        return $query_args;
    }

    public function query_posts() {
        $query_args = $this->get_query_args($this->get_settings());
        return new WP_Query($query_args);
    }


    protected function render() {
        $settings = $this->get_settings_for_display();

        $query = $this->query_posts();

        if (!$query->found_posts) {
            return;
        }
        $this->add_render_attribute('wrapper', 'class', ['elementor-post-wrapper', 'layout-' . $settings['post_style']]);
        // Item
        $this->add_render_attribute('item', 'class', 'elementor-posts-item');
        $this->get_data_elementor_columns();

        ?>
        <div <?php $this->print_render_attribute_string('wrapper'); ?>>
            <div <?php $this->print_render_attribute_string('container'); ?>>
                <div <?php $this->print_render_attribute_string('inner'); ?>>
                    <?php
                    $style = $settings['post_style'];
                    while ($query->have_posts()) {
                        $query->the_post(); ?>
                        <div <?php $this->print_render_attribute_string('item'); ?>>
                            <?php get_template_part('template-parts/posts-grid/item-' . $style); ?>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php $this->render_loop_footer(); ?>
            <?php $this->get_swiper_navigation($query->post_count); ?>
        </div>
        <?php
        wp_reset_postdata();
    }
}

$widgets_manager->register(new Priotech_Elementor_Post_Grid());