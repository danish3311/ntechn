<?php

if (!defined('ABSPATH')) {
    exit;
}

if (!class_exists('Priotech_WooSW')) :

    /**
     * The CF7 Priotech class
     */
    class Priotech_WooSW {

        /**
         * Setup class.
         *
         * @since 1.0
         */
        public function __construct() {

            add_action('woosw_wishlist_item_actions_before', [$this, 'priotech_woosw_wishlist_item_actions_before'], 10, 2);
            add_action('woosw_wishlist_item_actions_after', [$this, 'priotech_woosw_wishlist_item_actions_after'], 10, 2);
        }


        public function priotech_woosw_wishlist_item_actions_before($product, $key) {
    
            echo <<<HTML
            <div class="priotech_woosw_item_wrapper">
            HTML;
            
        }
    
    
        public function priotech_woosw_wishlist_item_actions_after($product, $key) {
    
            echo <<<HTML
            </div>
            HTML;
            
        }
        
        

    }        

endif;

return new Priotech_WooSW();