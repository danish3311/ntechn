<article id="post-<?php the_ID(); ?>" <?php post_class('article-default'); ?>>
    <?php priotech_post_thumbnail('post-thumbnail', false); ?>
    <div class="post-content">
        <?php
        /**
         * Functions hooked in to priotech_loop_post action.
         *
         * @see priotech_post_header          - 15
         * @see priotech_post_content         - 30
         */
        do_action('priotech_loop_post');
        ?>
    </div>
</article><!-- #post-## -->