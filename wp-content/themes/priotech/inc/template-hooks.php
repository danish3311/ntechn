<?php
/**
 * =================================================
 * Hook priotech_page
 * =================================================
 */
add_action('priotech_page', 'priotech_page_header', 10);
add_action('priotech_page', 'priotech_page_content', 20);

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
add_action('priotech_single_post', 'priotech_post_thumbnail', 20);
add_action('priotech_single_post', 'priotech_post_header', 10);
add_action('priotech_single_post', 'priotech_post_content', 30);

/**
 * =================================================
 * Hook priotech_single_post_bottom
 * =================================================
 */
add_action('priotech_single_post_bottom', 'priotech_post_taxonomy', 5);
add_action('priotech_single_post_bottom', 'priotech_post_nav', 10);
add_action('priotech_single_post_bottom', 'priotech_single_author', 15);
add_action('priotech_single_post_bottom', 'priotech_display_comments', 20);

/**
 * =================================================
 * Hook priotech_loop_post
 * =================================================
 */
add_action('priotech_loop_post', 'priotech_post_header', 15);
add_action('priotech_loop_post', 'priotech_post_content', 30);

/**
 * =================================================
 * Hook priotech_footer
 * =================================================
 */
add_action('priotech_footer', 'priotech_footer_default', 20);

/**
 * =================================================
 * Hook priotech_after_footer
 * =================================================
 */

/**
 * =================================================
 * Hook wp_footer
 * =================================================
 */
add_action('wp_footer', 'priotech_template_account_dropdown', 1);
add_action('wp_footer', 'priotech_mobile_nav', 1);

/**
 * =================================================
 * Hook wp_head
 * =================================================
 */
add_action('wp_head', 'priotech_pingback_header', 1);

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
add_action('priotech_sidebar', 'priotech_get_sidebar', 10);

/**
 * =================================================
 * Hook priotech_loop_after
 * =================================================
 */
add_action('priotech_loop_after', 'priotech_paging_nav', 10);

/**
 * =================================================
 * Hook priotech_page_after
 * =================================================
 */
add_action('priotech_page_after', 'priotech_display_comments', 10);

/**
 * =================================================
 * Hook priotech_woocommerce_list_item_title
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_woocommerce_list_item_content
 * =================================================
 */

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

/**
 * =================================================
 * Hook priotech_woocommerce_shop_loop_item_caption
 * =================================================
 */

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

/**
 * =================================================
 * Hook priotech_product_list_content
 * =================================================
 */

/**
 * =================================================
 * Hook priotech_product_list_end
 * =================================================
 */
