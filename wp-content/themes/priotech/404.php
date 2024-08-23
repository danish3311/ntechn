<?php
get_header(); ?>
    <div id="primary" class="content">
        <main id="main" class="site-main">
            <div class="error-404 not-found">
                <div class="page-content">
                    <div class="page-header">
                        <div class="img-404">
                            <img src="<?php echo get_theme_file_uri('assets/images/404/404.png') ?>" alt="<?php echo esc_attr__('404 Page not found', 'priotech') ?>">
                        </div>
                        <h2 class="error-subtitle"><?php _e('<span>Oops!</span> page not found', 'priotech'); ?></h2>
                        <div class="error-text">
                            <span><?php esc_html_e('Page does not exist or some other error occured. Go to our Home Page', 'priotech') ?></span>
                        </div>
                        <div class="error-button">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="go-back"><?php esc_html_e('Back to Homepage', 'priotech'); ?>
                                <i class="priotech-icon-angle-right"></i>
                            </a>
                        </div>
                    </div><!-- .page-content -->
                </div><!-- .error-404 -->
            </div>
        </main><!-- #main -->
    </div><!-- #primary -->
<?php
get_footer();



