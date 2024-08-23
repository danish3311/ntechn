<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <div class="single-content">
        <?php
        /**
         * Functions hooked in to priotech_single_post_top action
         *
         */
        do_action('priotech_single_post_top');

        /**
         * Functions hooked in to priotech_single_post action
         * @see priotech_post_thumbnail     - 20
         * @see priotech_post_header        - 10
         * @see priotech_post_content       - 30
         */
        do_action('priotech_single_post');

        /**
         * Functions hooked in to priotech_single_post_bottom action
         *
         * @see priotech_post_taxonomy        - 5
         * @see priotech_post_nav             - 10
         * @see priotech_single_author        - 15
         * @see priotech_display_comments     - 20
         */
        do_action('priotech_single_post_bottom');
        ?>

    </div>

</article><!-- #post-## -->
