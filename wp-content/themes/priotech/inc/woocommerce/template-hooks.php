<?php
/**
 * =================================================
 * Hook priotech_page
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_single_post_top
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_single_post
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_single_post_bottom
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_loop_post
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_footer
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_after_footer
 * =================================================
 */
add_action('priotech_after_footer', 'priotech_sticky_single_add_to_cart', 999);

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'priotech_render_woocommerce_shop_canvas', 1);

/**
 * =================================================
 * Hook wp_head
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_before_header
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_before_content
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_content_top
 * =================================================
 */
add_action('priotech_content_top', 'priotech_shop_messages', 10);

/**
 * =================================================
 * Hook priotech_post_content_before
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_post_content_after
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_sidebar
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_loop_after
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_page_after
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_woocommerce_list_item_title
 * =================================================
 */
add_action('priotech_woocommerce_list_item_title', 'priotech_product_label', 5);
add_action('priotech_woocommerce_list_item_title', 'priotech_woocommerce_product_list_image', 10);

/**
 * =================================================
 * Hook priotech_woocommerce_list_item_content
 * =================================================
 */
add_action('priotech_woocommerce_list_item_content', 'woocommerce_template_loop_product_title', 10);
add_action('priotech_woocommerce_list_item_content', 'priotech_woocommerce_get_product_description', 15);
add_action('priotech_woocommerce_list_item_content', 'woocommerce_template_loop_rating', 15);
add_action('priotech_woocommerce_list_item_content', 'woocommerce_template_loop_price', 20);
add_action('priotech_woocommerce_list_item_content', 'priotech_stock_label', 25);

/**
 * =================================================
 * Hook priotech_woocommerce_before_shop_loop_item
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_woocommerce_before_shop_loop_item_image
 * =================================================
 */
add_action('priotech_woocommerce_before_shop_loop_item_image', 'priotech_product_label', 10);
add_action('priotech_woocommerce_before_shop_loop_item_image', 'woocommerce_template_loop_product_thumbnail', 15);
add_action('priotech_woocommerce_before_shop_loop_item_image', 'priotech_woocommerce_product_loop_action_start', 20);
add_action('priotech_woocommerce_before_shop_loop_item_image', 'priotech_quickview_button', 30);
add_action('priotech_woocommerce_before_shop_loop_item_image', 'priotech_woocommerce_product_loop_action_close', 40);
add_action('priotech_woocommerce_before_shop_loop_item_image', 'priotech_single__quantity_cart', 50);

/**
 * =================================================
 * Hook priotech_woocommerce_shop_loop_item_caption
 * =================================================
 */
add_action('priotech_woocommerce_shop_loop_item_caption', 'priotech_woocommerce_get_product_category', 5);
add_action('priotech_woocommerce_shop_loop_item_caption', 'priotech_single__rating_brands', 10);
add_action('priotech_woocommerce_shop_loop_item_caption', 'woocommerce_template_loop_product_title', 15);
add_action('priotech_woocommerce_shop_loop_item_caption', 'priotech_woocommerce_get_product_description', 20);
add_action('priotech_woocommerce_shop_loop_item_caption', 'woocommerce_template_loop_price', 30);
add_action('priotech_woocommerce_shop_loop_item_caption', 'priotech_single_product_extra_label', 25);
add_action('priotech_woocommerce_shop_loop_item_caption', 'priotech_woocommerce_product_loop_action_start', 30);
add_action('priotech_woocommerce_shop_loop_item_caption', 'priotech_wishlist_button', 30);
add_action('priotech_woocommerce_shop_loop_item_caption', 'priotech_quickview_button', 30);
add_action('priotech_woocommerce_shop_loop_item_caption', 'priotech_compare_button', 30);
add_action('priotech_woocommerce_shop_loop_item_caption', 'priotech_woocommerce_product_loop_action_close', 30);
add_action('priotech_woocommerce_shop_loop_item_caption', 'priotech_single__quantity_cart', 35);

/**
 * =================================================
 * Hook priotech_woocommerce_after_shop_loop_item
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_product_list_start
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_product_list_image
 * =================================================
 */
add_action('priotech_product_list_image', 'priotech_woocommerce_product_list_image', 10);

/**
 * =================================================
 * Hook priotech_product_list_content
 * =================================================
 */
add_action('priotech_product_list_content', 'woocommerce_template_loop_product_title', 10);
add_action('priotech_product_list_content', 'woocommerce_template_loop_rating', 10);
add_action('priotech_product_list_content', 'priotech_single_product_extra_label', 15);
add_action('priotech_product_list_content', 'woocommerce_template_loop_price', 20);

/**
 * =================================================
 * Hook priotech_product_list_end
 * =================================================
 */
