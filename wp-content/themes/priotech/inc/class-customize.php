<?php
if (!defined('ABSPATH')) {
    exit;
}
if (!class_exists('Priotech_Customize')) {

    class Priotech_Customize {


        public function __construct() {
            add_action('customize_register', array($this, 'customize_register'));
        }

        public function get_banner() {
            global $post;

            $options[''] = esc_html__('Select Banner', 'priotech');
            if (!priotech_is_elementor_activated()) {
                return;
            }
            $args = array(
                'post_type'      => 'elementor_library',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                's'              => 'Banner ',
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

        /**
         * @param $wp_customize WP_Customize_Manager
         */
        public function tesst($wp_customize) {
            $wp_customize->add_control(
                new WP_Customize_Image_Control(
                    $wp_customize,
                    'dav_bgImage',
                    array(
                        'label'    => esc_attr__('Background image', 'priotech'),
                        'section'  => 'dav_display_options',
                        'settings' => 'dav_bgImage',
                        'priority' => 8
                    )
                )
            );
        }

        public function customize_register($wp_customize) {

            /**
             * Theme options.
             */
            require_once get_theme_file_path('inc/customize-control/editor.php');
            $this->init_priotech_blog($wp_customize);
            $this->priotech_register_theme_customizer($wp_customize);


            if (priotech_is_woocommerce_activated()) {
                $this->init_woocommerce($wp_customize);
            }

            do_action('priotech_customize_register', $wp_customize);
        }

        function priotech_register_theme_customizer($wp_customize) {

        } // end priotech_register_theme_customizer

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */
        public function init_priotech_blog($wp_customize) {

            $wp_customize->add_panel('priotech_blog', array(
                'title' => esc_html__('Blog', 'priotech'),
            ));

            // =========================================
            // Blog Archive
            // =========================================
            $wp_customize->add_section('priotech_blog_archive', array(
                'title'      => esc_html__('Archive', 'priotech'),
                'panel'      => 'priotech_blog',
                'capability' => 'edit_theme_options',
            ));

            $wp_customize->add_setting('priotech_options_blog_sidebar', array(
                'type'              => 'option',
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_blog_sidebar', array(
                'section' => 'priotech_blog_archive',
                'label'   => esc_html__('Sidebar Position', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    'none'  => esc_html__('None', 'priotech'),
                    'left'  => esc_html__('Left', 'priotech'),
                    'right' => esc_html__('Right', 'priotech'),
                ),
            ));

            $wp_customize->add_setting('priotech_options_blog_style', array(
                'type'              => 'option',
                'default'           => 'standard',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_blog_style', array(
                'section' => 'priotech_blog_archive',
                'label'   => esc_html__('Blog style', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    'standard' => esc_html__('Blog Standard', 'priotech'),
                    'list'     => esc_html__('Blog List', 'priotech'),
                    'style-1'  => esc_html__('Blog Grid', 'priotech'),
                ),
            ));

            $wp_customize->add_setting('priotech_options_blog_columns', array(
                'type'              => 'option',
                'default'           => 3,
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_blog_columns', array(
                'section' => 'priotech_blog_archive',
                'label'   => esc_html__('Colunms', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    1 => esc_html__('1', 'priotech'),
                    2 => esc_html__('2', 'priotech'),
                    3 => esc_html__('3', 'priotech'),
                    4 => esc_html__('4', 'priotech'),
                ),
            ));

            $wp_customize->add_setting('priotech_options_blog_columns_laptop', array(
                'type'              => 'option',
                'default'           => 3,
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_blog_columns_laptop', array(
                'section' => 'priotech_blog_archive',
                'label'   => esc_html__('Colunms Laptop', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    1 => esc_html__('1', 'priotech'),
                    2 => esc_html__('2', 'priotech'),
                    3 => esc_html__('3', 'priotech'),
                    4 => esc_html__('4', 'priotech'),
                ),
            ));

            $wp_customize->add_setting('priotech_options_blog_columns_tablet', array(
                'type'              => 'option',
                'default'           => 2,
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_blog_columns_tablet', array(
                'section' => 'priotech_blog_archive',
                'label'   => esc_html__('Colunms Tablet', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    1 => esc_html__('1', 'priotech'),
                    2 => esc_html__('2', 'priotech'),
                    3 => esc_html__('3', 'priotech'),
                    4 => esc_html__('4', 'priotech'),
                ),
            ));

            $wp_customize->add_setting('priotech_options_blog_columns_mobile', array(
                'type'              => 'option',
                'default'           => 1,
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_blog_columns_mobile', array(
                'section' => 'priotech_blog_archive',
                'label'   => esc_html__('Colunms Mobile', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    1 => esc_html__('1', 'priotech'),
                    2 => esc_html__('2', 'priotech'),
                    3 => esc_html__('3', 'priotech'),
                    4 => esc_html__('4', 'priotech'),
                ),
            ));

            // =========================================
            // Blog Single
            // =========================================
            $wp_customize->add_section('priotech_blog_single', array(
                'title'      => esc_html__('Singular', 'priotech'),
                'panel'      => 'priotech_blog',
                'capability' => 'edit_theme_options',
            ));
            $wp_customize->add_setting('priotech_options_blog_single_sidebar', array(
                'type'              => 'option',
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_blog_single_sidebar', array(
                'section' => 'priotech_blog_single',
                'label'   => esc_html__('Sidebar Position', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    'none'  => esc_html__('None', 'priotech'),
                    'left'  => esc_html__('Left', 'priotech'),
                    'right' => esc_html__('Right', 'priotech'),
                ),
            ));
        }

        /**
         * @param $wp_customize WP_Customize_Manager
         *
         * @return void
         */


        public function init_woocommerce($wp_customize) {

            $wp_customize->add_panel('woocommerce', array(
                'title' => esc_html__('Woocommerce', 'priotech'),
            ));

            $wp_customize->add_section('priotech_woocommerce_archive', array(
                'title'      => esc_html__('Archive', 'priotech'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
                'priority'   => 1,
            ));

            if (priotech_is_elementor_activated()) {
                $wp_customize->add_setting('priotech_options_shop_banner', array(
                    'type'              => 'option',
                    'default'           => '',
                    'sanitize_callback' => 'sanitize_text_field',
                ));

                $wp_customize->add_control('priotech_options_shop_banner', array(
                    'section'     => 'priotech_woocommerce_archive',
                    'label'       => esc_html__('Banner', 'priotech'),
                    'type'        => 'select',
                    'description' => __('Banner will take templates name prefix is "Banner"', 'priotech'),
                    'choices'     => $this->get_banner()
                ));

                $wp_customize->add_setting('priotech_options_shop_banner_position', array(
                    'type'              => 'option',
                    'default'           => 'top',
                    'sanitize_callback' => 'sanitize_text_field',
                ));

                $wp_customize->add_control('priotech_options_shop_banner_position', array(
                    'section' => 'priotech_woocommerce_archive',
                    'label'   => esc_html__('Banner Position', 'priotech'),
                    'type'    => 'select',
                    'choices' => array(
                        'top'     => __('Top Page', 'priotech'),
                        'content' => __('Before Products', 'priotech'),
                    ),
                ));

            }

            $wp_customize->add_setting('priotech_options_woocommerce_archive_layout', array(
                'type'              => 'option',
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_woocommerce_archive_layout', array(
                'section' => 'priotech_woocommerce_archive',
                'label'   => esc_html__('Layout Style', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    'default'  => esc_html__('Sidebar', 'priotech'),
                    'canvas'   => esc_html__('Canvas Filter', 'priotech'),
                    'dropdown' => esc_html__('Dropdown Filter', 'priotech'),
                    'drawing'  => esc_html__('Drawing Filter', 'priotech'),
                ),
            ));

            $wp_customize->add_setting('priotech_options_woocommerce_archive_sidebar', array(
                'type'              => 'option',
                'default'           => 'left',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_woocommerce_archive_sidebar', array(
                'section' => 'priotech_woocommerce_archive',
                'label'   => esc_html__('Sidebar Position', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    'left'  => esc_html__('Left', 'priotech'),
                    'right' => esc_html__('Right', 'priotech'),

                ),
            ));

            $wp_customize->add_setting('priotech_options_woocommerce_shop_pagination', array(
                'type'              => 'option',
                'default'           => 'default',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_woocommerce_shop_pagination', array(
                'section' => 'priotech_woocommerce_archive',
                'label'   => esc_html__('Products pagination', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    'default'  => esc_html__('Pagination', 'priotech'),
                    'more-btn' => esc_html__('Load More', 'priotech'),
                    'infinit'  => esc_html__('Infinit Scroll', 'priotech'),
                ),
            ));

            // =========================================
            // Single Product
            // =========================================

            $wp_customize->add_section('priotech_woocommerce_single', array(
                'title'      => esc_html__('Singular', 'priotech'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
                'priority'   => 1,
            ));

            $wp_customize->add_setting('priotech_options_wocommerce_single_style', array(
                'type'              => 'option',
                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_wocommerce_single_style', array(
                'section' => 'priotech_woocommerce_single',
                'label'   => esc_html__('Single Style', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    '1' => esc_html__('Default', 'priotech'),
                    '2' => esc_html__('With Background', 'priotech'),
                ),
            ));

            $wp_customize->add_setting('priotech_options_single_product_gallery_layout', array(
                'type'              => 'option',
                'default'           => 'horizontal',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('priotech_options_single_product_gallery_layout', array(
                'section' => 'priotech_woocommerce_single',
                'label'   => esc_html__('Gallery Style', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    'horizontal'     => esc_html__('Bottom Thumbnail', 'priotech'),
                    'vertical'       => esc_html__('Left Thumbnail', 'priotech'),
                    'right_vertical' => esc_html__('Right Thumbnail', 'priotech'),
                    'without-thumb'  => esc_html__('Without Thumbnail', 'priotech'),
                    'gallery'        => esc_html__('Gallery Thumbnail', 'priotech'),
                    'sticky'         => esc_html__('Sticky Content', 'priotech'),
                ),
            ));

            $wp_customize->add_setting('priotech_options_single_product_tab_layout', array(
                'type'              => 'option',
                'default'           => 'horizontal',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('priotech_options_single_product_tab_layout', array(
                'section'     => 'priotech_woocommerce_single',
                'label'       => esc_html__('Content In Tabs?', 'priotech'),
                'description' => esc_html__('Show content in tabs or accordion .....?', 'priotech'),
                'type'        => 'select',
                'choices'     => array(
                    'default'       => esc_html__('Default Tabs', 'priotech'),
                    'vertical'      => esc_html__('Vertical Tabs', 'priotech'),
                    'accordion'     => esc_html__('Accordion', 'priotech'),
                    'expand'        => esc_html__('Expand all', 'priotech'),
                ),
            ));

            $wp_customize->add_setting(
                'priotech_options_single_product_content_meta',
                array(
                    /* translators: %s privacy policy page name and link */
                    'type'              => 'option',
                    'sanitize_callback' => 'wp_kses_post',
                    'capability'        => 'edit_theme_options',
                    'transport'         => 'postMessage',
                )
            );

            $wp_customize->add_control(
                'priotech_options_single_product_content_meta',
                array(

                    'label'    => esc_html__('Single extra description', 'priotech'),
                    'section'  => 'priotech_woocommerce_single',
                    'settings' => 'priotech_options_single_product_content_meta',
                    'type'     => 'textarea',
                )
            );

            // =========================================
            // Product Item Reponsive
            // =========================================
            $wp_customize->add_setting('priotech_options_wocommerce_row_laptop', array(
                'type'              => 'option',
                'default'           => 3,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_wocommerce_row_laptop', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row Laptop', 'priotech'),
                'type'    => 'number',
            ));

            $wp_customize->add_setting('priotech_options_wocommerce_row_tablet', array(
                'type'              => 'option',
                'default'           => 2,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_wocommerce_row_tablet', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row tablet', 'priotech'),
                'type'    => 'number',
            ));

            $wp_customize->add_setting('priotech_options_wocommerce_row_mobile', array(
                'type'              => 'option',
                'default'           => 1,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_wocommerce_row_mobile', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row mobile', 'priotech'),
                'type'    => 'number',
            ));

            // =========================================
            // Product Item Reponsive List View
            // =========================================
            $wp_customize->add_setting('priotech_options_wocommerce_column_list_view', array(
                'type'              => 'option',
                'default'           => 2,
                'transport'         => 'postMessage',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_wocommerce_column_list_view', array(
                'section' => 'woocommerce_product_catalog',
                'label'   => esc_html__('Products per row list view Laptop', 'priotech'),
                'description' => esc_html__('The number of products in each row of the list view)', 'priotech'),
                'type'    => 'number',
            ));

            // =========================================
            // Product
            // =========================================


            $wp_customize->add_section('priotech_woocommerce_product', array(
                'title'      => esc_html__('Product Block', 'priotech'),
                'capability' => 'edit_theme_options',
                'panel'      => 'woocommerce',
            ));
            $attribute_array      = [
                '' => esc_html__('None', 'priotech')
            ];
            $attribute_taxonomies = wc_get_attribute_taxonomies();

            if (!empty($attribute_taxonomies)) {
                foreach ($attribute_taxonomies as $tax) {
                    if (taxonomy_exists(wc_attribute_taxonomy_name($tax->attribute_name))) {
                        $attribute_array[$tax->attribute_name] = $tax->attribute_label;
                    }
                }
            }

            $wp_customize->add_setting('priotech_options_wocommerce_attribute', array(
                'type'              => 'option',
                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('priotech_options_wocommerce_attribute', array(
                'section' => 'priotech_woocommerce_product',
                'label'   => esc_html__('Attributes Show', 'priotech'),
                'type'    => 'select',
                'choices' => $attribute_array,
            ));

            $wp_customize->add_setting('priotech_options_wocommerce_grid_list_layout', array(
                'type'              => 'option',
                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));

            $wp_customize->add_control('priotech_options_wocommerce_grid_list_layout', array(
                'section' => 'priotech_woocommerce_product',
                'label'   => esc_html__('Grid - List Layout', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    ''     => esc_html__('Grid', 'priotech'),
                    'list' => esc_html__('List', 'priotech'),
                ),
            ));

            $wp_customize->add_setting('priotech_options_wocommerce_block_style', array(
                'type'              => 'option',
                'default'           => '',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('priotech_options_wocommerce_block_style', array(
                'section'     => 'priotech_woocommerce_product',
                'label'       => esc_html__('Style', 'priotech'),
                'description' => __('When you choose to display product items in Grid format, you will have additional options for hover effect styles below', 'priotech'),
                'type'        => 'select',
                'choices'     => array(
                    ''  => esc_html__('Layout 1', 'priotech'),
                    '2' => esc_html__('Layout 2', 'priotech'),
                    '3' => esc_html__('Layout 3', 'priotech'),
                    '4' => esc_html__('Layout 4', 'priotech'),
                ),
            ));

            $wp_customize->add_setting('priotech_options_woocommerce_product_hover', array(
                'type'              => 'option',
                'default'           => 'none',
                'transport'         => 'refresh',
                'sanitize_callback' => 'sanitize_text_field',
            ));
            $wp_customize->add_control('priotech_options_woocommerce_product_hover', array(
                'section' => 'priotech_woocommerce_product',
                'label'   => esc_html__('Animation Image Hover', 'priotech'),
                'type'    => 'select',
                'choices' => array(
                    'none'          => esc_html__('None', 'priotech'),
                    'bottom-to-top' => esc_html__('Bottom to Top', 'priotech'),
                    'top-to-bottom' => esc_html__('Top to Bottom', 'priotech'),
                    'right-to-left' => esc_html__('Right to Left', 'priotech'),
                    'left-to-right' => esc_html__('Left to Right', 'priotech'),
                    'swap'          => esc_html__('Swap', 'priotech'),
                    'fade'          => esc_html__('Fade', 'priotech'),
                    'zoom-in'       => esc_html__('Zoom In', 'priotech'),
                    'zoom-out'      => esc_html__('Zoom Out', 'priotech'),
                ),
            ));
        }
    }
}
return new Priotech_Customize();
