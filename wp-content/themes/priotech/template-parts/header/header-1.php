<header id="masthead" class="site-header header-1" role="banner">
    <div class="header-container">
        <div class="container header-main">
            <div class="header-left">
                <?php
                priotech_site_branding();
                if (priotech_is_woocommerce_activated()) {
                    ?>
                    <div class="site-header-cart header-cart-mobile">
                        <?php priotech_cart_link(); ?>
                    </div>
                    <?php
                }
                ?>
                <?php priotech_mobile_nav_button(); ?>
            </div>
            <div class="header-center">
                <?php priotech_primary_navigation(); ?>
            </div>
            <div class="header-right desktop-hide-down">
                <div class="header-group-action">
                    <?php
                    priotech_header_account();
                    if (priotech_is_woocommerce_activated()) {
                        priotech_header_wishlist();
                        priotech_header_cart();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</header><!-- #masthead -->
