<?php


if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Priotech_Elementor')) :

    /**
     * The Priotech Elementor Integration class
     */
    class Priotech_Elementor {
        private $suffix = '';

        public function __construct() {
            $this->suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';

            add_action('wp', [$this, 'register_auto_scripts_frontend']);
            add_action('elementor/init', array($this, 'add_category'));
            add_action('wp_enqueue_scripts', [$this, 'add_scripts'], 15);
            add_action('elementor/widgets/register', array($this, 'include_widgets'));
            add_action('elementor/frontend/after_enqueue_scripts', [$this, 'add_js']);

            // Custom Animation Scroll
            add_filter('elementor/controls/animations/additional_animations', [$this, 'add_animations_scroll']);

            // Elementor Fix Noitice WooCommerce
            add_action('elementor/editor/before_enqueue_scripts', array($this, 'woocommerce_fix_notice'));

            // Backend
            add_action('elementor/editor/after_enqueue_styles', [$this, 'add_style_editor'], 99);

            // Add Icon Custom
            add_action('elementor/icons_manager/native', [$this, 'add_icons_native']);
            add_action('elementor/controls/register', [$this, 'add_icons']);


            // Add Breakpoints
            add_action('wp_enqueue_scripts', 'priotech_elementor_breakpoints', 9999);

            if (!priotech_is_elementor_pro_activated()) {
                require trailingslashit(get_template_directory()) . 'inc/elementor/class-custom-css.php';
                require trailingslashit(get_template_directory()) . 'inc/elementor/class-section-sticky.php';
                if (is_admin()) {
                    add_action('manage_elementor_library_posts_columns', [$this, 'admin_columns_headers']);
                    add_action('manage_elementor_library_posts_custom_column', [$this, 'admin_columns_content'], 10, 2);
                }
            }

            add_filter('elementor/fonts/additional_fonts', [$this, 'additional_fonts']);

        }

        public function additional_fonts($fonts) {
            $fonts["Outfit"] = 'googlefonts';
            return $fonts;
        }

        public function admin_columns_headers($defaults) {
            $defaults['shortcode'] = esc_html__('Shortcode', 'priotech');

            return $defaults;
        }

        public function admin_columns_content($column_name, $post_id) {
            if ('shortcode' === $column_name) {
                ob_start();
                ?>
                <input class="elementor-shortcode-input" type="text" readonly onfocus="this.select()" value="[hfe_template id='<?php echo esc_attr($post_id); ?>']"/>
                <?php
                ob_get_contents();
            }
        }

        public function add_js() {
            global $priotech_version;
            wp_enqueue_script('priotech-elementor-frontend', get_theme_file_uri('/assets/js/elementor-frontend.js'), [], $priotech_version);
        }

        public function add_style_editor() {
            global $priotech_version;
            wp_enqueue_style('priotech-elementor-editor-icon', get_theme_file_uri('/assets/css/admin/elementor/icons.css'), [], $priotech_version);
        }

        public function add_scripts() {
            global $priotech_version;
            $suffix = (defined('SCRIPT_DEBUG') && SCRIPT_DEBUG) ? '' : '.min';
            wp_enqueue_style('priotech-elementor', get_template_directory_uri() . '/assets/css/base/elementor.css', '', $priotech_version);
            wp_style_add_data('priotech-elementor', 'rtl', 'replace');

            // Add Scripts
            wp_register_script('tweenmax', get_theme_file_uri('/assets/js/libs/TweenMax.min.js'), array('jquery'), '1.11.1');
            wp_enqueue_script('tweenmax');

            if (priotech_elementor_check_type('animated-bg-parallax')) {
                wp_enqueue_script('jquery-panr', get_theme_file_uri('/assets/js/libs/jquery-panr' . $suffix . '.js'), array('jquery'), '0.0.1');
            }
        }

        public function register_auto_scripts_frontend() {
            global $priotech_version;
            wp_register_script('priotech-elementor-banner-carousel', get_theme_file_uri('/assets/js/elementor/banner-carousel.js'), array('jquery','elementor-frontend'), $priotech_version, true);
            wp_register_script('priotech-elementor-brand', get_theme_file_uri('/assets/js/elementor/brand.js'), array('jquery','elementor-frontend'), $priotech_version, true);
            wp_register_script('priotech-elementor-countdown', get_theme_file_uri('/assets/js/elementor/countdown.js'), array('jquery','elementor-frontend'), $priotech_version, true);
            wp_register_script('priotech-elementor-image-carousel', get_theme_file_uri('/assets/js/elementor/image-carousel.js'), array('jquery','elementor-frontend'), $priotech_version, true);
            wp_register_script('priotech-elementor-image-gallery', get_theme_file_uri('/assets/js/elementor/image-gallery.js'), array('jquery','elementor-frontend'), $priotech_version, true);
            wp_register_script('priotech-elementor-posts-grid', get_theme_file_uri('/assets/js/elementor/posts-grid.js'), array('jquery','elementor-frontend'), $priotech_version, true);
            wp_register_script('priotech-elementor-product-categories', get_theme_file_uri('/assets/js/elementor/product-categories.js'), array('jquery','elementor-frontend'), $priotech_version, true);
            wp_register_script('priotech-elementor-products', get_theme_file_uri('/assets/js/elementor/products.js'), array('jquery','elementor-frontend'), $priotech_version, true);
            wp_register_script('priotech-elementor-slide-scrolling', get_theme_file_uri('/assets/js/elementor/slide-scrolling.js'), array('jquery','elementor-frontend'), $priotech_version, true);
            wp_register_script('priotech-elementor-testimonial', get_theme_file_uri('/assets/js/elementor/testimonial.js'), array('jquery','elementor-frontend'), $priotech_version, true);
            wp_register_script('priotech-elementor-text-carousel', get_theme_file_uri('/assets/js/elementor/text-carousel.js'), array('jquery','elementor-frontend'), $priotech_version, true);
            wp_register_script('priotech-elementor-video', get_theme_file_uri('/assets/js/elementor/video.js'), array('jquery','elementor-frontend'), $priotech_version, true);
           
        }

        public function add_category() {
            Elementor\Plugin::instance()->elements_manager->add_category(
                'priotech-addons',
                array(
                    'title' => esc_html__('Priotech Addons', 'priotech'),
                    'icon'  => 'fa fa-plug',
                ), 1);
        }

        public function add_animations_scroll($animations) {
            $animations['Priotech Animation'] = [
                'opal-move-up'    => 'Move Up',
                'opal-move-down'  => 'Move Down',
                'opal-move-left'  => 'Move Left',
                'opal-move-right' => 'Move Right',
                'opal-flip'       => 'Flip',
                'opal-helix'      => 'Helix',
                'opal-scale-up'   => 'Scale',
                'opal-am-popup'   => 'Popup',
            ];

            return $animations;
        }

        /**
         * @param $widgets_manager Elementor\Widgets_Manager
         */
        public function include_widgets($widgets_manager) {
            require 'base_widgets.php';

            $files_custom = glob(get_theme_file_path('/inc/elementor/custom-widgets/*.php'));
            foreach ($files_custom as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }

            $files = glob(get_theme_file_path('/inc/elementor/widgets/*.php'));
            foreach ($files as $file) {
                if (file_exists($file)) {
                    require_once $file;
                }
            }
        }

        public function woocommerce_fix_notice() {
            if (priotech_is_woocommerce_activated()) {
                remove_action('woocommerce_cart_is_empty', 'woocommerce_output_all_notices', 5);
                remove_action('woocommerce_shortcode_before_product_cat_loop', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_shop_loop', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_single_product', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_cart', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_checkout_form', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_account_content', 'woocommerce_output_all_notices', 10);
                remove_action('woocommerce_before_customer_login_form', 'woocommerce_output_all_notices', 10);
            }
        }

        public function add_icons( $manager ) {
            $new_icons = json_decode( '{"priotech-icon-account":"account","priotech-icon-angle-down":"angle-down","priotech-icon-angle-down1":"angle-down1","priotech-icon-angle-down2":"angle-down2","priotech-icon-angle-left":"angle-left","priotech-icon-angle-right":"angle-right","priotech-icon-angle-right1":"angle-right1","priotech-icon-angle-up":"angle-up","priotech-icon-avatar":"avatar","priotech-icon-breadcrumb":"breadcrumb","priotech-icon-bullet-list-line":"bullet-list-line","priotech-icon-card":"card","priotech-icon-chat1":"chat1","priotech-icon-clock":"clock","priotech-icon-clock1":"clock1","priotech-icon-clock2":"clock2","priotech-icon-coupon":"coupon","priotech-icon-credit-card1":"credit-card1","priotech-icon-customer-care":"customer-care","priotech-icon-delivery":"delivery","priotech-icon-delivery2":"delivery2","priotech-icon-ecological":"ecological","priotech-icon-eye-o":"eye-o","priotech-icon-facebook-o":"facebook-o","priotech-icon-fast-delivery1":"fast-delivery1","priotech-icon-featured":"featured","priotech-icon-filters":"filters","priotech-icon-free-delivery":"free-delivery","priotech-icon-heart-o":"heart-o","priotech-icon-heart-p":"heart-p","priotech-icon-help-center":"help-center","priotech-icon-home-1":"home-1","priotech-icon-instagram-o":"instagram-o","priotech-icon-left-l":"left-l","priotech-icon-linkedin-in":"linkedin-in","priotech-icon-list-ul":"list-ul","priotech-icon-loop":"loop","priotech-icon-mail-o":"mail-o","priotech-icon-map-marker1":"map-marker1","priotech-icon-money-convert":"money-convert","priotech-icon-movies":"movies","priotech-icon-online-support":"online-support","priotech-icon-pay":"pay","priotech-icon-phone2":"phone2","priotech-icon-play-circle":"play-circle","priotech-icon-play-fill":"play-fill","priotech-icon-play":"play","priotech-icon-plus-circle-o":"plus-circle-o","priotech-icon-plus-m":"plus-m","priotech-icon-post-on":"post-on","priotech-icon-quickview1":"quickview1","priotech-icon-quote-left":"quote-left","priotech-icon-quote1":"quote1","priotech-icon-rating-group":"rating-group","priotech-icon-repeat-wl":"repeat-wl","priotech-icon-reply-line":"reply-line","priotech-icon-right-l":"right-l","priotech-icon-search-o":"search-o","priotech-icon-search1":"search1","priotech-icon-setting":"setting","priotech-icon-shake-hands":"shake-hands","priotech-icon-share-all":"share-all","priotech-icon-shopping-bag":"shopping-bag","priotech-icon-shoppingcart-o":"shoppingcart-o","priotech-icon-sliders-v":"sliders-v","priotech-icon-telephone":"telephone","priotech-icon-th-large-o":"th-large-o","priotech-icon-tools":"tools","priotech-icon-truck":"truck","priotech-icon-twitter-o":"twitter-o","priotech-icon-two-line":"two-line","priotech-icon-upload1":"upload1","priotech-icon-verification":"verification","priotech-icon-view":"view","priotech-icon-360":"360","priotech-icon-arrow-down":"arrow-down","priotech-icon-arrow-left":"arrow-left","priotech-icon-arrow-right":"arrow-right","priotech-icon-arrow-up":"arrow-up","priotech-icon-bars":"bars","priotech-icon-bullet-list-line2":"bullet-list-line2","priotech-icon-Call":"Call","priotech-icon-caret-down":"caret-down","priotech-icon-caret-left":"caret-left","priotech-icon-caret-right":"caret-right","priotech-icon-caret-up":"caret-up","priotech-icon-cart-1":"cart-1","priotech-icon-cart-empty":"cart-empty","priotech-icon-cart":"cart","priotech-icon-Check-mark":"Check-mark","priotech-icon-check-square":"check-square","priotech-icon-chevron-down":"chevron-down","priotech-icon-chevron-left":"chevron-left","priotech-icon-chevron-right":"chevron-right","priotech-icon-chevron-up":"chevron-up","priotech-icon-circle":"circle","priotech-icon-Clip-path-group":"Clip-path-group","priotech-icon-cloud-download-alt":"cloud-download-alt","priotech-icon-comment":"comment","priotech-icon-comments":"comments","priotech-icon-compare":"compare","priotech-icon-contact":"contact","priotech-icon-credit-card":"credit-card","priotech-icon-delivery-truck":"delivery-truck","priotech-icon-dot-circle":"dot-circle","priotech-icon-edit":"edit","priotech-icon-envelope":"envelope","priotech-icon-expand-alt":"expand-alt","priotech-icon-external-link-alt":"external-link-alt","priotech-icon-eye_1":"eye_1","priotech-icon-file-alt":"file-alt","priotech-icon-file-archive":"file-archive","priotech-icon-filter":"filter","priotech-icon-fire1":"fire1","priotech-icon-folder-open":"folder-open","priotech-icon-folder":"folder","priotech-icon-frown":"frown","priotech-icon-gift":"gift","priotech-icon-grid-view-line":"grid-view-line","priotech-icon-grip-horizontal":"grip-horizontal","priotech-icon-heart-fill":"heart-fill","priotech-icon-heart":"heart","priotech-icon-history":"history","priotech-icon-home":"home","priotech-icon-info-circle":"info-circle","priotech-icon-instagram":"instagram","priotech-icon-level-up-alt":"level-up-alt","priotech-icon-list":"list","priotech-icon-Mail":"Mail","priotech-icon-map-marker-check":"map-marker-check","priotech-icon-meh":"meh","priotech-icon-minus-circle":"minus-circle","priotech-icon-minus":"minus","priotech-icon-mobile-android-alt":"mobile-android-alt","priotech-icon-money-bill":"money-bill","priotech-icon-money":"money","priotech-icon-Online_Support":"Online_Support","priotech-icon-paper-plane":"paper-plane","priotech-icon-pencil-alt":"pencil-alt","priotech-icon-plus-circle":"plus-circle","priotech-icon-plus":"plus","priotech-icon-quickview":"quickview","priotech-icon-random":"random","priotech-icon-rating-stroke":"rating-stroke","priotech-icon-rating":"rating","priotech-icon-repeat":"repeat","priotech-icon-reply-all":"reply-all","priotech-icon-reply":"reply","priotech-icon-search-plus":"search-plus","priotech-icon-search":"search","priotech-icon-shield-check":"shield-check","priotech-icon-shopping-basket":"shopping-basket","priotech-icon-shopping-cart":"shopping-cart","priotech-icon-sign-out-alt":"sign-out-alt","priotech-icon-smile":"smile","priotech-icon-spinner":"spinner","priotech-icon-square":"square","priotech-icon-star":"star","priotech-icon-store":"store","priotech-icon-sync_alt":"sync_alt","priotech-icon-sync":"sync","priotech-icon-tachometer-alt":"tachometer-alt","priotech-icon-th-large":"th-large","priotech-icon-th-list":"th-list","priotech-icon-thumbtack":"thumbtack","priotech-icon-ticket":"ticket","priotech-icon-times-circle":"times-circle","priotech-icon-times":"times","priotech-icon-trophy-alt":"trophy-alt","priotech-icon-user-headset":"user-headset","priotech-icon-user-shield":"user-shield","priotech-icon-user":"user","priotech-icon-video":"video","priotech-icon-wishlist-empty":"wishlist-empty","priotech-icon-wishlist":"wishlist","priotech-icon-adobe":"adobe","priotech-icon-amazon":"amazon","priotech-icon-android":"android","priotech-icon-angular":"angular","priotech-icon-apper":"apper","priotech-icon-apple":"apple","priotech-icon-atlassian":"atlassian","priotech-icon-behance":"behance","priotech-icon-bitbucket":"bitbucket","priotech-icon-bitcoin":"bitcoin","priotech-icon-bity":"bity","priotech-icon-bluetooth":"bluetooth","priotech-icon-btc":"btc","priotech-icon-centos":"centos","priotech-icon-chrome":"chrome","priotech-icon-codepen":"codepen","priotech-icon-cpanel":"cpanel","priotech-icon-discord":"discord","priotech-icon-dochub":"dochub","priotech-icon-docker":"docker","priotech-icon-dribbble":"dribbble","priotech-icon-dropbox":"dropbox","priotech-icon-drupal":"drupal","priotech-icon-ebay":"ebay","priotech-icon-facebook-f":"facebook-f","priotech-icon-facebook":"facebook","priotech-icon-figma":"figma","priotech-icon-firefox":"firefox","priotech-icon-google-plus":"google-plus","priotech-icon-google":"google","priotech-icon-grunt":"grunt","priotech-icon-gulp":"gulp","priotech-icon-html5":"html5","priotech-icon-joomla":"joomla","priotech-icon-link-brand":"link-brand","priotech-icon-linkedin":"linkedin","priotech-icon-mailchimp":"mailchimp","priotech-icon-opencart":"opencart","priotech-icon-paypal":"paypal","priotech-icon-pinterest-p":"pinterest-p","priotech-icon-reddit":"reddit","priotech-icon-skype":"skype","priotech-icon-slack":"slack","priotech-icon-snapchat":"snapchat","priotech-icon-spotify":"spotify","priotech-icon-trello":"trello","priotech-icon-twitter":"twitter","priotech-icon-vimeo":"vimeo","priotech-icon-whatsapp":"whatsapp","priotech-icon-wordpress":"wordpress","priotech-icon-yoast":"yoast","priotech-icon-youtube":"youtube"}', true );
			$icons     = $manager->get_control( 'icon' )->get_settings( 'options' );
			$new_icons = array_merge(
				$new_icons,
				$icons
			);
			// Then we set a new list of icons as the options of the icon control
			$manager->get_control( 'icon' )->set_settings( 'options', $new_icons ); 
        }

        public function add_icons_native($tabs) {
            global $priotech_version;
            $tabs['opal-custom'] = [
                'name'          => 'priotech-icon',
                'label'         => esc_html__('Priotech Icon', 'priotech'),
                'prefix'        => 'priotech-icon-',
                'displayPrefix' => 'priotech-icon-',
                'labelIcon'     => 'fab fa-font-awesome-alt',
                'ver'           => $priotech_version,
                'fetchJson'     => get_theme_file_uri('/inc/elementor/icons.json'),
                'native'        => true,
            ];

            return $tabs;
        }
    }

endif;

return new Priotech_Elementor();
