<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

if (!priotech_is_woocommerce_activated()) {
    return;
}

use Elementor\Icons_Manager;
use Priotech\Elementor\Priotech_Base_Widgets;
use Elementor\Controls_Manager;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

/**
 * Elementor tabs widget.
 *
 * Elementor widget that displays vertical or horizontal tabs with different
 * pieces of content.
 *
 * @since 1.0.0
 */
class Priotech_Elementor_Widget_Products extends Priotech_Base_Widgets {


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
        return 'priotech-products';
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
        return esc_html__('Products', 'priotech');
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
        return [
            'priotech-elementor-products',
            'tooltipster'
        ];
    }

    public function on_export($element) {
        unset($element['settings']['categories']);
        unset($element['settings']['tag']);

        return $element;
    }

    /**
     * Register tabs widget controls.
     *
     * Adds different input fields to allow the user to change and customize the widget settings.
     *
     * @since  1.0.0
     * @access protected
     */
    protected function register_controls() {

        //Section Query
        $this->start_controls_section(
            'section_setting',
            [
                'label' => esc_html__('Settings', 'priotech'),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );


        $this->add_control(
            'limit',
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
                'default' => 'date',
                'options' => [
                    'date'       => esc_html__('Date', 'priotech'),
                    'id'         => esc_html__('Post ID', 'priotech'),
                    'menu_order' => esc_html__('Menu Order', 'priotech'),
                    'popularity' => esc_html__('Number of purchases', 'priotech'),
                    'rating'     => esc_html__('Average Product Rating', 'priotech'),
                    'title'      => esc_html__('Product Title', 'priotech'),
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
                'options'     => $this->get_product_categories(),
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
            'tag',
            [
                'label'       => esc_html__('Tags', 'priotech'),
                'type'        => Controls_Manager::SELECT2,
                'label_block' => true,
                'options'     => $this->get_product_tags(),
                'multiple'    => true,
            ]
        );

        $this->add_control(
            'tag_operator',
            [
                'label'     => esc_html__('Tag Operator', 'priotech'),
                'type'      => Controls_Manager::SELECT,
                'default'   => 'IN',
                'options'   => [
                    'AND'    => esc_html__('AND', 'priotech'),
                    'IN'     => esc_html__('IN', 'priotech'),
                    'NOT IN' => esc_html__('NOT IN', 'priotech'),
                ],
                'condition' => [
                    'tag!' => ''
                ],
            ]
        );

        $this->add_control(
            'product_type',
            [
                'label'   => esc_html__('Product Type', 'priotech'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'newest',
                'options' => [
                    'newest'       => esc_html__('Newest Products', 'priotech'),
                    'on_sale'      => esc_html__('On Sale Products', 'priotech'),
                    'best_selling' => esc_html__('Best Selling', 'priotech'),
                    'top_rated'    => esc_html__('Top Rated', 'priotech'),
                    'featured'     => esc_html__('Featured Product', 'priotech'),
                    'ids'          => esc_html__('Product Name', 'priotech'),
                ],
            ]
        );

        $this->add_control(
            'product_ids',
            [
                'label'       => esc_html__('Products name', 'priotech'),
                'type'        => 'products',
                'label_block' => true,
                'multiple'    => true,
                'condition'   => [
                    'product_type' => 'ids'
                ]
            ]
        );

        $this->add_control(
            'paginate',
            [
                'label'   => esc_html__('Paginate', 'priotech'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'none',
                'options' => [
                    'none'       => esc_html__('None', 'priotech'),
                    'pagination' => esc_html__('Pagination', 'priotech'),
                ],
            ]
        );

        $this->add_control(
            'product_layout',
            [
                'label'   => esc_html__('Product Layout', 'priotech'),
                'type'    => Controls_Manager::SELECT,
                'default' => 'grid',
                'options' => [
                    'grid' => esc_html__('Grid', 'priotech'),
                    'list' => esc_html__('List', 'priotech'),
                ],
            ]
        );

        $this->add_control(
            'style',
            [
                'label'     => esc_html__('Block Style', 'priotech'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => '',
                'options'   => [
                    ''  => esc_html__('Style Default', 'priotech'),
                    '2'  => esc_html__('Style 2', 'priotech'),
                    '3'  => esc_html__('Style 3', 'priotech'),
                    '4'  => esc_html__('Style 4', 'priotech'),
                ],
                'condition' => [
                    'product_layout' => 'grid'
                ]
            ]
        );

        $this->add_control(
            'style_image_hover',
            [
                'label'     => esc_html__('Image Hover', 'priotech'),
                'type'      => \Elementor\Controls_Manager::SELECT,
                'default'   => 'none',
                'options'   => [
                    'none'          => esc_html__('None', 'priotech'),
                    'bottom-to-top' => esc_html__('Bottom to Top', 'priotech'),
                    'top-to-bottom' => esc_html__('Top to Bottom', 'priotech'),
                    'right-to-left' => esc_html__('Right to Left', 'priotech'),
                    'left-to-right' => esc_html__('Left to Right', 'priotech'),
                    'swap'          => esc_html__('Swap', 'priotech'),
                    'fade'          => esc_html__('Fade', 'priotech'),
                    'zoom-in'       => esc_html__('Zoom In', 'priotech'),
                    'zoom-out'      => esc_html__('Zoom Out', 'priotech'),
                ],
                'condition' => [
                    'product_layout' => 'grid'
                ]
            ]
        );

        $this->add_control(
            'list_layout',
            [
                'label'     => esc_html__('List Layout', 'priotech'),
                'type'      => Controls_Manager::SELECT,
                'default'   => '1',
                'options'   => [
                    '1' => esc_html__('Style 1', 'priotech'),
                    '2' => esc_html__('Style 2', 'priotech'),
                ],
                'condition' => [
                    'product_layout' => 'list'
                ]
            ]
        );
        $this->add_control(
            'show_badge_sale',
            [
                'label'     => esc_html__('Show Discount Badge', 'priotech'),
                'type'      => Controls_Manager::SWITCHER,
                'condition' => [
                    'product_type'   => 'on_sale',
                    'product_layout' => 'grid'
                ],
                'default'   => 'no',
                'selectors_dictionary' => [
                    'yes' => 'block',
                    'no' => 'none',
                ],
                'selectors' => [
                    '{{WRAPPER}} .label-wrapper' => 'display: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'show_time_sale',
            [
                'label'     => esc_html__('Show Time Sale', 'priotech'),
                // 'type'      => Controls_Manager::SWITCHER,
                'type'    => Controls_Manager::HIDDEN,
                'condition' => [
                    'product_type'   => 'on_sale',
                    'product_layout' => 'grid'
                ]
            ]
        );

        $this->add_control(
            'show_deal_sold',
            [
                'label'     => esc_html__('Show Deal Sold', 'priotech'),
                // 'type'      => Controls_Manager::SWITCHER,
                'type'    => Controls_Manager::HIDDEN,
                'condition' => [
                    'product_type'   => 'on_sale',
                    'product_layout' => 'grid'
                ]
            ]
        );

        $this->add_control(
            'enable_effects',
            [
                'label'     => esc_html__('Effects', 'priotech'),
                'type'      => Controls_Manager::SWITCHER,
                'prefix_class' => 'enable-effects-',
            ]
        );

        $this->end_controls_section();


        //Section Query
        $this->start_controls_section(
            'section_product_style',
            [
                'label' => esc_html__('Products', 'priotech'),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'product_padding',
            [
                'label'      => esc_html__('Padding', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .product-block-list' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .product-block'      => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'product_margin',
            [
                'label'      => esc_html__('Margin', 'priotech'),
                'type'       => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors'  => [
                    '{{WRAPPER}} .product-block-list' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                    '{{WRAPPER}} .product-block'      => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name'     => 'product_background',
                'selector' => '{{WRAPPER}} .product-block-list, {{WRAPPER}} .product-block',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name'     => 'product_box_shadow',
                'selector' => '{{WRAPPER}} .product-block-list, {{WRAPPER}} .product-block',
            ]
        );
        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name'      => 'product_border',
                'selector'  => '{{WRAPPER}} .product-block-list, {{WRAPPER}} .product-block, {{WRAPPER}} li.product:not(:first-child) .product-block-list',
                'separator' => 'before',
            ]
        );

        $this->end_controls_section();

        $conditon_column = ['product_layout' => 'grid'];
        $this->get_controls_column($conditon_column);

        // Carousel Option
        $conditon_carousel = [
            'paginate' => 'none',
            'product_layout' => 'grid'
        ];
        $this->get_control_carousel($conditon_carousel);
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

    protected function get_product_tags() {
        $tags    = get_terms(array(
                'taxonomy'   => 'product_tag',
                'hide_empty' => false,
            )
        );
        $results = array();
        if (!is_wp_error($tags)) {
            foreach ($tags as $tag) {
                $results[$tag->slug] = $tag->name;
            }
        }

        return $results;
    }

    protected function get_product_type($atts, $product_type) {
        switch ($product_type) {
            case 'featured':
                $atts['visibility'] = "featured";
                break;
            case 'on_sale':
                $atts['on_sale'] = true;
                break;
            case 'best_selling':
                $atts['best_selling'] = true;
                break;
            case 'top_rated':
                $atts['top_rated'] = true;
                break;
            default:
                break;
        }

        return $atts;
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
        $this->woocommerce_default($settings);
    }

    private function woocommerce_default($settings) {
        if (isset($_GET['layout'])) {
            if ($_GET['layout'] == 'list') {
                $this->add_render_attribute('_wrapper', 'class', 'elementor-product-list-by-url');
                $settings['product_layout'] = 'list';
            } else {
                $settings['product_layout'] = 'grid';
                $settings['style'] = '1';
            }
            
        }

        $layout_setting = $settings['product_layout'];
        add_filter('priotech_get_current_layout', function($layout) use ($layout_setting) {
            return $layout_setting;
        });

        $type  = 'products';
        $class = '';
        $atts  = [
            'limit'          => $settings['limit'],
            'columns'        => $settings['enable_carousel'] === 'yes' ? 1 : $settings['column'],
            'orderby'        => $settings['orderby'],
            'order'          => $settings['order'],
            'product_layout' => $settings['product_layout'],
        ];

        $atts['show_time_sale'] = false;
        $atts['show_deal_sold'] = false;

        if ($settings['product_layout'] == 'list') {
            $atts['style'] = 'list-' . $settings['list_layout'];
            $class         .= ' woocommerce-product-list';
            $class         .= ' woocommerce-product-list-' . $settings['list_layout'];
        } else {
            if (isset($settings['style']) && $settings['style'] !== '') {
                $atts['style'] = $settings['style'];
            }

            if (isset($settings['style_image_hover']) && $settings['style_image_hover'] !== '') {
                $atts['style_image_hover'] = $settings['style_image_hover'];
            }
        }

        $atts = $this->get_product_type($atts, $settings['product_type']);

        if (isset($atts['on_sale']) && wc_string_to_bool($atts['on_sale'])) {
            $type = 'sale_products';
            if ($settings['show_time_sale']) {
                $atts['show_time_sale'] = true;
            }
            if ($settings['show_deal_sold']) {
                $atts['show_deal_sold'] = true;
            }
        } elseif (isset($atts['best_selling']) && wc_string_to_bool($atts['best_selling'])) {
            $type = 'best_selling_products';
        } elseif (isset($atts['top_rated']) && wc_string_to_bool($atts['top_rated'])) {
            $type = 'top_rated_products';
        }
        if (isset($settings['product_ids']) && !empty($settings['product_ids']) && $settings['product_type'] == 'ids') {
            $atts['ids'] = implode(',', $settings['product_ids']);
        }

        if (!empty($settings['categories'])) {
            $atts['category']     = implode(',', $settings['categories']);
            $atts['cat_operator'] = $settings['cat_operator'];
        }

        if (!empty($settings['tag'])) {
            $atts['tag']          = implode(',', $settings['tag']);
            $atts['tag_operator'] = $settings['tag_operator'];
        }

        // Carousel
        if ($settings['enable_carousel'] === 'yes') {
            $atts['enable_carousel']   = 'yes';
            $atts['carousel_settings'] = $this->get_swiper_navigation_for_product();
            $class                     = ' priotech-swiper-wrapper swiper';
        }
        if ($settings['paginate'] === 'pagination') {
            $atts['paginate'] = 'true';
        }
        $atts['class'] = $class;

        echo (new WC_Shortcode_Products($atts, $type))->get_content(); // WPCS: XSS ok
    }
}

$widgets_manager->register(new Priotech_Elementor_Widget_Products());
