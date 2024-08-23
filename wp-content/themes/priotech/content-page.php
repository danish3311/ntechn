<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
	/**
	 * Functions hooked in to priotech_page action
	 *
	 * @see priotech_page_header          - 10
	 * @see priotech_page_content         - 20
	 *
	 */
	do_action( 'priotech_page' );
	?>
</article><!-- #post-## -->
