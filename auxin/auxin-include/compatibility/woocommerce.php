<?php
/**
 * WooCommerce compatibility
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;

/**
 * Set the archive page content inside auxin content wrapper
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper'      , 10);
remove_action( 'woocommerce_after_main_content' , 'woocommerce_output_content_wrapper_end'  , 10);
add_action   ( 'woocommerce_before_main_content', 'auxin_wc_wrapper_start'                  , 10);
add_action   ( 'woocommerce_after_main_content' , 'auxin_wc_wrapper_end'                    , 10);

remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar'                             , 10);
remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb'                   , 20, 0);



/**
 * Start wrapper for woocommerce
 */
function auxin_wc_wrapper_start() {
    ?>
    <main id="main" <?php auxin_content_main_class(); ?> >
        <div class="aux-wrapper">
            <div class="aux-container aux-fold">
                <div id="primary" class="aux-primary" >
                    <div class="content" role="main"  >
    <?php
}

/**
 * End wrapper for woocommerce
 */
function auxin_wc_wrapper_end() {
  ?>
                    </div>
                </div>
                <?php get_sidebar(); ?>
            </div>
        </div>
    </main>
    <?php
}


/**
 * Add theme support for WooCommerce 3 zoom and slider
 */
function auxin_woocommerce_setup() {
    
    add_theme_support( 'woocommerce' );
    // Inline Zoom functionality
    add_theme_support( 'wc-product-gallery-zoom' );
    // Default WooCommerce slider (flexslider)
    add_theme_support( 'wc-product-gallery-slider' );
    //No need to lightbox, use Phlox lightbox

}

add_action( 'after_setup_theme', 'auxin_woocommerce_setup' );


/**
 * Make sure cart contents update when products are added to the cart via AJAX
 */
function auxin_wc_add_to_cart_fragment( $fragments ) {

    $count = WC()->cart->cart_contents_count;

    if ( $count > 0 ){
        $fragments['a.aux-cart-contents span'] = '<span>' . esc_html( $count ) . '</span>';
    }

    return $fragments;
}
add_filter( 'woocommerce_add_to_cart_fragments', 'auxin_wc_add_to_cart_fragment' );

/*-----------------------------------------------------------------------------------*/
