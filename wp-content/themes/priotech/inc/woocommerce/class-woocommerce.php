<?php
if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Priotech_WooCommerce')) :

    /**
     * The Priotech WooCommerce Integration class
     */
    class Priotech_WooCommerce {

        public $list_shortcodes;

        private $prefix = 'remove';

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {
            $this->list_shortcodes = array(
                'recent_products',
                'sale_products',
                'best_selling_products',
                'top_rated_products',
                'featured_products',
                'related_products',
                'product_category',
                'products',
            );
            $this->init_shortcodes();
            $this->remove_wvs_support();
            add_action('after_setup_theme', array($this, 'setup'));
            add_filter('body_class', array($this, 'woocommerce_body_class'));
            add_action('widgets_init', array($this, 'widgets_init'));
            add_filter('priotech_theme_sidebar', array($this, 'set_sidebar'), 20);
            add_action('wp_enqueue_scripts', array($this, 'woocommerce_scripts'), 20);
            add_filter('woocommerce_enqueue_styles', '__return_empty_array');
            add_filter('woocommerce_output_related_products_args', array($this, 'related_products_args'));
            add_filter('woocommerce_upsell_display_args', array($this, 'upsell_products_args'));
            add_filter('woocommerce_product_thumbnails_columns', array($this, 'thumbnail_columns'));

            add_filter('wp_list_categories', array($this, 'remove_wrap_symbol_show_count_category_list'), 10, 2);
            //add_filter('woocommerce_layered_nav_count', array($this, 'remove_wrap_symbol_show_count_attribute_list'), 10, 3);

            add_filter('widget_title', array($this, 'add_wrapper_filter_widget_woo'), 10, 3);
            

            if (defined('WC_VERSION') && version_compare(WC_VERSION, '3.3', '<')) {
                add_filter('loop_shop_per_page', array($this, 'products_per_page'));
            }

            // Remove Shop Title
            add_filter('woocommerce_show_page_title', '__return_false');

            add_filter('priotech_register_nav_menus', [$this, 'add_location_menu']);
            add_filter('wp_nav_menu_items', [$this, 'add_extra_item_to_nav_menu'], 10, 2);

            add_filter('woocommerce_single_product_image_gallery_classes', function ($wrapper_classes) {
                $wrapper_classes[] = 'woocommerce-product-gallery-' . priotech_get_theme_option('single_product_gallery_layout', 'horizontal');

                if (priotech_get_theme_option('single_product_gallery_layout', 'horizontal') == 'gallery') {
                    $wrapper_classes[] = 'woocommerce-product-gallery-vertical';
                }

                return $wrapper_classes;
            });


            // Elementor Admin
            add_action('admin_action_elementor', array($this, 'register_elementor_wc_hook'), 1);
            add_filter('woocommerce_cross_sells_columns', array($this, 'woocommerce_cross_sells_columns'));

            add_action('admin_init', [$this, 'wvs_support']);
        }


        public function woocommerce_cross_sells_columns() {
            return wc_get_default_products_per_row();
        }

        public function register_elementor_wc_hook() {
            wc()->frontend_includes();
            require_once get_theme_file_path('inc/woocommerce/woocommerce-template-hooks.php');
            require_once get_theme_file_path('inc/woocommerce/template-hooks.php');
            priotech_include_hooks_product_blocks();
        }

        public function add_extra_item_to_nav_menu($items, $args) {
            if ($args->theme_location == 'my-account') {
                $items .= '<li><a href="' . esc_url(wp_logout_url(home_url())) . '">' . esc_html__('Logout', 'priotech') . '</a></li>';
            }

            return $items;
        }

        public function add_location_menu($locations) {
            $locations['my-account'] = esc_html__('My Account', 'priotech');

            return $locations;
        }

        /**
         * Sets up theme defaults and registers support for various WooCommerce features.
         *
         * Note that this function is hooked into the after_setup_theme hook, which
         * runs before the init hook. The init hook is too late for some features, such
         * as indicating support for post thumbnails.
         *
         * @return void
         * @since 2.4.0
         */
        public function setup() {
            add_theme_support(
                'woocommerce', apply_filters(
                    'priotech_woocommerce_args', array(
                        'product_grid' => array(
                            'default_columns' => 4,
                            'default_rows'    => 4,
                            'min_columns'     => 1,
                            'max_columns'     => 6,
                            'min_rows'        => 1,
                        ),
                    )
                )
            );
            add_image_size('woocommerce-thumbnails', 80, 88, true);


            /**
             * Add 'priotech_woocommerce_setup' action.
             *
             * @since  2.4.0
             */
            do_action('priotech_woocommerce_setup');
        }


        public function action_woocommerce_before_template_part($template_name, $template_path, $located, $args) {
            $product_style = priotech_get_theme_option('wocommerce_block_style', 0);
            if ($product_style != 0 && ($template_name == 'single-product/up-sells.php' || $template_name == 'single-product/related.php' || $template_name == 'cart/cross-sells.php')) {
                $template_custom = 'content-product-' . $product_style . '.php';
                add_filter('wc_get_template_part', function ($template, $slug, $name) use ($template_custom) {
                    if ($slug == 'content' && $name == 'product') {
                        return get_theme_file_path('woocommerce/' . $template_custom);
                    } else {
                        return $template;
                    }
                }, 10, 3);
            }
        }

        public function action_woocommerce_after_template_part($template_name, $template_path, $located, $args) {
            $product_style = priotech_get_theme_option('wocommerce_block_style', 0);
            if ($product_style != 0 && ($template_name == 'single-product/up-sells.php' || $template_name == 'single-product/related.php' || $template_name == 'cart/cross-sells.php')) {
                add_filter('wc_get_template_part', function ($template, $slug, $name) {
                    if ($slug == 'content' && $name == 'product') {
                        return get_theme_file_path('woocommerce/content-product.php');
                    } else {
                        return $template;
                    }
                }, 10, 3);
            }
        }

        private function init_shortcodes() {
            foreach ($this->list_shortcodes as $shortcode) {
                add_filter('shortcode_atts_' . $shortcode, array($this, 'set_shortcode_attributes'), 10, 3);
                add_action('woocommerce_shortcode_before_' . $shortcode . '_loop', array($this, 'shortcode_loop_start'));
                add_action('woocommerce_shortcode_after_' . $shortcode . '_loop', array($this, 'shortcode_loop_end'));
            }
        }

        public function shortcode_loop_end($atts = array()) {
            $function_to_call = $this->prefix . '_filter';
            if (isset($atts['style']) && $atts['style'] !== '') {

                add_filter('wc_get_template_part', function ($template, $slug, $name) {
                    if ($slug == 'content' && $name == 'product') {
                        return get_theme_file_path('woocommerce/content-product.php');
                    } else {
                        return $template;
                    }
                }, 10, 3);

            } else {
                if (isset($atts['show_time_sale']) && $atts['show_time_sale'] == true) {
                    $function_to_call('woocommerce_before_shop_loop_item_title', 'priotech_woocommerce_time_sale', 15);
                }
                if (isset($atts['show_deal_sold']) && $atts['show_deal_sold'] == true) {
                    $function_to_call('woocommerce_after_shop_loop_item_title', 'priotech_woocommerce_deal_progress', 70);
                }
            }

            if (isset($atts['enable_carousel']) && $atts['enable_carousel'] === 'yes') {
                wc_set_loop_prop('enable_carousel', false);
                if (isset($atts['carousel_settings']) && $atts['carousel_settings'] != '') {
                    echo wp_kses_post($atts['carousel_settings']);
                }
            }
        }

        public function shortcode_loop_start($atts = array()) {
            $function_to_call = $this->prefix . '_filter';
            if (isset($_GET['layout'])) {
                if ($_GET['layout'] == 'list') {
                    $atts['product_layout'] = 'list';
                    $atts['style'] = 'list-1';
                } else {
                    $atts['product_layout'] = 'grid';
                    $atts['style'] = '3';
                }
            }

            if (isset($atts['product_layout']) && $atts['product_layout'] == 'list') {
                $function_to_call('priotech_shop_layout', 'priotech_wcc_grid_layout_loop', 10);
                add_filter('priotech_shop_layout', 'priotech_wcc_list_layout_loop', 10, 1);

                if (isset($atts['style']) && $atts['style'] == 'list-2') {
                    add_filter( 'woocommerce_post_class', 'priotech_wcc_add_class_list_style_2', 10, 2);
                }
                else {
                    add_filter( 'woocommerce_post_class', function($classes, $product) {return $classes;} , 10, 2);
                }
            } 
            else {
                add_filter('priotech_shop_layout', 'priotech_wcc_grid_layout_loop', 10, 1);
                
                add_filter( 'woocommerce_post_class', function($classes, $product) {return $classes;} , 10, 2);
            }

            if (isset($atts['style_image_hover'])) {
                $style_image_hover = $atts['style_image_hover'];

                add_filter('hover_skin_shortcode_product', function ($hover_skin) use ($style_image_hover) {
                    $hover_skin = $style_image_hover;
                    return $hover_skin;
                }, 10, 1);    
            }

            if (isset($atts['style']) && $atts['style'] !== '') {

                if (in_array($atts['style'], ['list-1', 'list-2'])) {
                    
                    $template_custom = 'content-product-list.php';
                } 
                else {
                    $template_custom = 'content-product-' . $atts['style'] . '.php';

                }
                // echo $template_custom;
                add_filter('wc_get_template_part', function ($template, $slug, $name) use ($template_custom) {
                    if ($slug == 'content' && $name == 'product') {
                        return get_theme_file_path('woocommerce/' . $template_custom);
                    } else {
                        return $template;
                    }
                }, 10, 3);

            } else {
                if (isset($atts['show_time_sale']) && $atts['show_time_sale'] == true) {
                    add_action('woocommerce_before_shop_loop_item_title', 'priotech_woocommerce_time_sale', 15);
                }
                if (isset($atts['show_deal_sold']) && $atts['show_deal_sold'] == true) {
                    add_action('woocommerce_after_shop_loop_item_title', 'priotech_woocommerce_deal_progress', 70);
                }
            }

            if (isset($atts['enable_carousel']) && $atts['enable_carousel'] === 'yes') {
                wc_set_loop_prop('enable_carousel', true);
            }

        }

        public function set_shortcode_attributes($out, $pairs, $atts) {
            $out = wp_parse_args($atts, $out);

            return $out;
        }


        /**
         * Assign styles to individual theme mod.
         *
         * @return void
         * @since 2.1.0
         * @deprecated 2.3.1
         */
        public function set_priotech_style_theme_mods() {
            if (function_exists('wc_deprecated_function')) {
                wc_deprecated_function(__FUNCTION__, '2.3.1');
            } else {
                _deprecated_function(__FUNCTION__, '2.3.1');
            }
        }

        /**
         * Add WooCommerce specific classes to the body tag
         *
         * @param array $classes css classes applied to the body tag.
         *
         * @return array $classes modified to include 'woocommerce-active' class
         */
        public function woocommerce_body_class($classes) {
            $classes[] = 'woocommerce-active';

            // Remove `no-wc-breadcrumb` body class.
            $key = array_search('no-wc-breadcrumb', $classes, true);

            if (false !== $key) {
                unset($classes[$key]);
            }

            $style        = priotech_get_theme_option('wocommerce_block_style', 1);
            $layout       = priotech_get_theme_option('woocommerce_archive_layout', 'default');
            $sidebar      = priotech_get_theme_option('woocommerce_archive_sidebar', 'left');
            $single_style = priotech_get_theme_option('wocommerce_single_style', 1);
            $classes[]    = 'product-block-style-' . $style;
            $classes[]    = 'product-single-style-' . $single_style;


            if (priotech_is_product_archive()) {
                $classes   = array_diff($classes, array(
                    'priotech-sidebar-left', 'priotech-sidebar-right', 'priotech-full-width-content'
                ));
                $classes[] = 'priotech-archive-product';

                if (is_active_sidebar('sidebar-woocommerce-shop')) {
                    if ($layout == 'default') {

                        if ($sidebar == 'left') {
                            $classes[] = 'priotech-sidebar-left';
                        } else {
                            $classes[] = 'priotech-sidebar-right';
                        }
                    }

                    if ($layout == 'drawing') {

                        if ($sidebar == 'left') {
                            // $classes[] = 'priotech-sidebar-left';
                            $classes[] = 'priotech-drawing-side';
                            add_filter('priotech_sidebar_class', function($sidebarClass) {
                                if(!is_array($sidebarClass)) return;

                                $sidebarClass[] = 'collapsed';

                                return $sidebarClass;
                            }, 10);
                        }

                    }

                    if ($layout == 'canvas') {
                        $classes[] = 'priotech-full-width-content shop_filter_canvas';
                    }

                    if ($layout == 'dropdown') {
                        $classes[] = 'priotech-full-width-content shop_filter_dropdown';
                    }
                } else {
                    $classes[] = 'priotech-full-width-content';
                }
            }

            if (is_product()) {
                $classes[] = 'priotech-full-width-content';
                $classes[] = 'single-product-' . priotech_get_theme_option('single_product_gallery_layout', 'horizontal');
                $classes[] = 'single-product-tab-' . priotech_get_theme_option('single_product_tab_layout', 'default');
            }

            return $classes;
        }

        public function wvs_support() {
            $function_to_call = $this->prefix . '_filter';
            $function_to_call('pre_update_option_woocommerce_thumbnail_image_width', 'wvs_clear_transient');
            $function_to_call('pre_update_option_woocommerce_thumbnail_cropping', 'wvs_clear_transient');
        }

        /**
         * WooCommerce specific scripts & stylesheets
         *
         * @since 1.0.0
         */
        public function woocommerce_scripts() {
            global $priotech_version;
            $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
            //register_style
            wp_register_style('priotech-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce/woocommerce.css', array(), $priotech_version);
            wp_register_style('priotech-woocommerce-legacy', get_template_directory_uri() . '/assets/css/woocommerce/woocommerce-legacy.css', array(), $priotech_version);
            //register_script
            wp_register_script('priotech-header-cart', get_template_directory_uri() . '/assets/js/woocommerce/header-cart' . $suffix . '.js', array(), $priotech_version, true);
            wp_register_script('priotech-products-ajax-search', get_template_directory_uri() . '/assets/js/woocommerce/product-ajax-search' . $suffix . '.js', array('jquery', 'tooltipster'), $priotech_version, true);
            wp_register_script('priotech-products', get_template_directory_uri() . '/assets/js/woocommerce/main' . $suffix . '.js', array('jquery'), $priotech_version, true);
            wp_register_script('priotech-input-quantity', get_template_directory_uri() . '/assets/js/woocommerce/quantity' . $suffix . '.js', array('jquery'), $priotech_version, true);
            wp_register_script('priotech-cart-canvas', get_template_directory_uri() . '/assets/js/woocommerce/cart-canvas' . $suffix . '.js', array(), $priotech_version, true);
            wp_register_script('priotech-off-canvas', get_template_directory_uri() . '/assets/js/woocommerce/off-canvas' . $suffix . '.js', array(), $priotech_version, true);
            wp_register_script('priotech-sticky-add-to-cart', get_template_directory_uri() . '/assets/js/sticky-add-to-cart' . $suffix . '.js', array(), $priotech_version, true);
            wp_enqueue_script('priotech-single-product', get_template_directory_uri() . '/assets/js/woocommerce/single' . $suffix . '.js', array(
                'jquery',
                'swiper',
                'sticky-kit',
                'magnific-popup'
            ), $priotech_version, true);

            //enqueue_style
            wp_enqueue_style('priotech-woocommerce-style');
            wp_style_add_data('priotech-woocommerce-style', 'rtl', 'replace');
            // QuickView
            wp_dequeue_style('yith-quick-view');
            wp_enqueue_script('priotech-header-cart');

            //enqueue_script
            wp_enqueue_script('priotech-products-ajax-search');
            wp_enqueue_script('priotech-products');
            wp_enqueue_script('priotech-input-quantity');
            wp_enqueue_script('priotech-cart-canvas');

            if (defined('WC_VERSION') && version_compare(WC_VERSION, '3.3', '<')) {
                wp_enqueue_style('priotech-woocommerce-legacy');
                wp_style_add_data('priotech-woocommerce-legacy', 'rtl', 'replace');
            }

            if (is_shop() || is_product() || is_product_taxonomy()) {
                wp_enqueue_script('priotech-shop-select', get_template_directory_uri() . '/assets/js/woocommerce/shop-select' . $suffix . '.js', array('jquery'), $priotech_version, true);
                wp_enqueue_script('priotech-shop', get_template_directory_uri() . '/assets/js/woocommerce/shop' . $suffix . '.js', array(
                    'jquery', 'priotech-waypoints'
                ), $priotech_version, true);
            }
            if (is_shop() || is_product() || is_product_taxonomy() || priotech_elementor_check_type('priotech-products')) {
                wp_enqueue_script('tooltipster');
                wp_enqueue_style('tooltipster');
                wp_enqueue_script('magnific-popup');
                wp_enqueue_style('magnific-popup');

            }

            if (is_active_sidebar('sidebar-woocommerce-shop')) {
                wp_enqueue_script('priotech-off-canvas');
            }

            if (is_product() || is_cart()) {
                wp_enqueue_script('priotech-countdown');
                wp_enqueue_style('priotech-sticky-add-to-cart');
                wp_enqueue_style('magnific-popup');
                wp_enqueue_script('magnific-popup');
                wp_enqueue_script('spritespin');
                wp_enqueue_script('swiper');
                wp_enqueue_script('priotech-swiper');
                wp_enqueue_script('sticky-kit');
                wp_enqueue_script('priotech-single-product');
            }
        }

        /**
         * Related Products Args
         *
         * @param array $args related products args.
         *
         * @return  array $args related products args
         * @since 1.0.0
         */
        public function related_products_args($args) {
            $product_items = 4;

            $args = apply_filters(
                'priotech_related_products_args', array(
                    'posts_per_page' => $product_items,
                    'columns'        => $product_items,
                )
            );
            return $args;
        }

        /**
         * Upsells
         * Replace the default upsell function with our own which displays the correct number product columns
         *
         * @return  void
         * @since   1.0.0
         * @uses    woocommerce_upsell_display()
         */
        public function upsell_products_args() {
            $args = apply_filters(
                'priotech_upsell_products_args', array(
                    'columns' => 4,
                )
            );
            return $args;
        }

        /**
         * Product gallery thumbnail columns
         *
         * @return integer number of columns
         * @since  1.0.0
         */
        public function thumbnail_columns() {
            $columns = priotech_get_theme_option('single_product_gallery_column', 3);

            if (priotech_get_theme_option('single_product_gallery_layout', 'horizontal') == 'vertical') {
                $columns = 1;
            }
            if (priotech_get_theme_option('single_product_gallery_layout', 'horizontal') == 'right_vertical') {
                $columns = 1;
            }
            if (priotech_get_theme_option('single_product_gallery_layout', 'horizontal') == 'gallery') {
                $columns = 1;
            }

            return intval(apply_filters('priotech_product_thumbnail_columns', $columns));
        }

        /**
         * Products per page
         *
         * @return integer number of products
         * @since  1.0.0
         */
        public function products_per_page() {
            return intval(apply_filters('priotech_products_per_page', 12));
        }

        /**
         * Query WooCommerce Extension Activation.
         *
         * @param string $extension Extension class name.
         *
         * @return boolean
         */
        public function is_woocommerce_extension_activated($extension = 'WC_Bookings') {
            return class_exists($extension) ? true : false;
        }

        public function widgets_init() {
            register_sidebar(array(
                'name'          => esc_html__('WooCommerce Shop', 'priotech'),
                'id'            => 'sidebar-woocommerce-shop',
                'description'   => esc_html__('Add widgets here to appear in your sidebar on blog posts and archive pages.', 'priotech'),
                'before_widget' => '<div id="%1$s" class="widget %2$s priotech-widget-woocommerce">',
                'after_widget'  => '</div>',
                'before_title'  => '<div class="gamma widget-title">',
                'after_title'   => '</div>',
            ));
        }

        public function set_sidebar($name) {
            $layout = priotech_get_theme_option('woocommerce_archive_layout', 'default');
            if (priotech_is_product_archive()) {
                if (is_active_sidebar('sidebar-woocommerce-shop') && in_array($layout,  ['default', 'drawing'])) {
                    $name = 'sidebar-woocommerce-shop';
                } else {
                    $name = '';
                }
            }
            if (is_product()) {
                $name = '';
            }
            return $name;
        }

        public function grouped_product_column_image($grouped_product_child) {
            echo '<td class="woocommerce-grouped-product-image">' . $grouped_product_child->get_image('thumbnail') . '</td>';
        }

        public function remove_wvs_support() {
            $function_to_call = $this->prefix . '_filter';
            $function_to_call('pre_update_option_woocommerce_thumbnail_image_width', 'wvs_clear_transient');
            $function_to_call('pre_update_option_woocommerce_thumbnail_cropping', 'wvs_clear_transient');
        }

        public function remove_wrap_symbol_show_count_category_list($output, $args ) {
            if (!isset($args['show_count']) || !$args['show_count']) return $output;
            // if (!is_shop()) return $output;

            $search  = [
                '<span class="count">(',
                '<span class="cat-count">(',
                ')</span>'
            ];
            $replace  = [
                '<span class="count">',
                '<span class="cat-count">',
                '</span>'
            ];
        
            $output = str_replace($search, $replace, $output);
        
            return $output;
        }
        

        public function remove_wrap_symbol_show_count_attribute_list($output, $count, $term ) {

            $output = '<span class="count">' . absint( $count ) . '</span>';

            return $output;
        }

        public function add_wrapper_filter_widget_woo($widget_title, $instance, $id_base) {
            $base_filter_ids = [
                'woocommerce_price_filter',
                'woocommerce_layered_nav',
                'woocommerce_layered_nav',
                'woocommerce_rating_filter'
            ];
        
            if (in_array($id_base, $base_filter_ids)) {
                $widget_title = '<span class="priotech_title_filter">'.$widget_title.'</span>';
            }
        
            return $widget_title;
        }
    }

endif;

return new Priotech_WooCommerce();

