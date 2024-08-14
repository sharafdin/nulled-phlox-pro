<?php
/**
 * Template parts for hidden panels
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


if( ! function_exists('auxin_add_hidden_blocks') ){

    function auxin_add_hidden_blocks(){

    ?>
    <div class="aux-hidden-blocks">

        <section id="offmenu" class="aux-offcanvas-menu aux-pin-<?php echo esc_attr( auxin_get_option( 'site_header_mobile_menu_offcanvas_alignment', 'left' ) ); ?>" >
            <div class="aux-panel-close">
                <div class="aux-close aux-cross-symbol aux-thick-medium"></div>
            </div>
            <div class="offcanvas-header">
            </div>
            <div class="offcanvas-content">
            </div>
            <div class="offcanvas-footer">
            </div>
        </section>
        <!-- offcanvas section -->

        <section id="offcart" class="aux-offcanvas-menu aux-offcanvas-cart aux-pin-<?php echo esc_attr( auxin_get_option( 'site_header_mobile_menu_offcanvas_alignment', 'left' ) ); ?>" >
            <div class="aux-panel-close">
                <div class="aux-close aux-cross-symbol aux-thick-medium"></div>
            </div>
            <div class="offcanvas-header">
                <?php esc_attr_e( 'Shopping Basket', 'phlox-pro' ); ?>
            </div>
            <div class="aux-cart-wrapper aux-elegant-cart aux-offcart-content">
            </div>
        </section>
        <!-- cartcanvas section -->

        <?php
            // Full Screen Menu Classess
            $fs_menu_skin      = auxin_get_option( 'site_menu_full_screen_skin' ) ;
            $fs_menu_layout    = ' aux-fs-menu-layout-' . auxin_get_option( 'site_header_fullscreen_template' , 'center' ) ;
            $fs_menu_indicator = auxin_get_option( 'site_header_fullscreen_indicator', '1' ) ;
            $fs_menu_indicator = auxin_is_true( $fs_menu_indicator ) ? ' aux-indicator' : ' aux-no-indicator' ;
            $fs_menu_classes   = $fs_menu_skin . $fs_menu_layout . $fs_menu_indicator;

        ;?>
        <section id="fs-menu-search" class="aux-fs-popup <?php echo esc_attr( $fs_menu_classes ); ?>">
            <div class="aux-panel-close">
                <div class="aux-close aux-cross-symbol aux-thick-medium"></div>
            </div>
            <div class="aux-fs-menu">
            <?php
            /* The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.*/
            //wp_nav_menu( array( 'container_id' => 'master-menu-main-header', 'theme_location' => 'header-primary' ) );
            ?>
            </div>
            <div class="aux-fs-search">
            <?php echo auxin_get_search_box( array( 'has_toggle_icon' => false ) ); ?>
            </div>
        </section>
        <!-- fullscreen search and menu -->
        <?php
            $fs_css_classes  = auxin_get_option( 'header_fullscreen_search_skin' );
            $fs_css_classes .= ' has-ajax-form';
        ?>
        <section id="fs-search" class="aux-fs-popup aux-search-overlay <?php echo esc_attr( $fs_css_classes ); ?>">
            <div class="aux-panel-close">
                <div class="aux-close aux-cross-symbol aux-thick-medium"></div>
            </div>
            <div class="aux-search-field">

        <?php

            echo auxin_get_search_box([
                'has_form'        => true,
                'css_class'       => 'aux-404-search',
                'has_submit_icon' => true,
                'has_toggle_icon' => false,
                'has_submit'      => false,
                'is_ajax'         => false,
                'has_category'    => false
            ]);
        ?>
            </div>
        </section>
        <!-- fullscreen search-->

        <div class="aux-scroll-top"></div>
    </div>

    <?php
    }

}


/**
 * Site footer block
 *
 * @return
 */
function auxin_the_site_footer(){
    global $post;

    if( 'default' === $display_footer = auxin_get_post_meta( $post, 'page_show_footer', 'default') ){
        $display_footer = auxin_get_option( 'show_site_footer', '1' );
    }

    if( auxin_is_true( $display_footer ) || is_customize_preview() ){
?>
    <footer id="sitefooter" class="aux-site-footer" >
        <?php do_action( 'auxin_in_the_footer' ); ?>
        <div class="aux-wrapper aux-float-layout">
                <?php echo auxin_get_footer_components_markup(); ?>
                <!-- end navigation -->
        </div><!-- end wrapper -->
    </footer><!-- end sitefooter -->
<?php }

}


/**
 * Retrieves the copyright markup for the footer
 *
 * @param  boolean $echo Whether to return or print the generated markup
 * @return void|string
 */
function auxin_footer_copyright_markup( $echo = false, $args = [] ){
    global $post;

    $defaults = array(
        'copyright_text'        => sprintf( __( '&copy; %s. All rights reserved.', 'phlox-pro' ), '{{Y}} {{sitename}}' ),
        'attribution'           => false,
        'show_privacy_policy'   => false
    );

    if ( ! empty($args) ) {

        extract( wp_parse_args( $args, $defaults ) );

    } else {

        $copyright_text = ! empty( $post->ID ) ? auxin_get_post_meta( $post, 'page_footer_copyright', '') : '';
        $copyright_text = empty( $copyright_text ) ? auxin_get_option( 'copyright' ): $copyright_text ;

        $attribution = auxin_get_post_meta( $post, 'page_footer_attribution', 'default') ;
        $attribution = 'default' === $attribution ? auxin_get_option( 'attribution', false ) : $attribution;

        $show_privacy_policy =  auxin_get_option( 'footer_privacy_policy_link_display', 0 );

    }
    $output         = '';

    if( $copyright_text ) {
        $date_format = 'Y'; // to pass theme check plugin
        $copyright_text = str_replace( array( '{{Y}}', '{{sitename}}' ), array( date_i18n( $date_format ), get_bloginfo( 'name' ) ), $copyright_text );
        $output .= '<small>' . do_shortcode( stripslashes( $copyright_text ) ) . '</small>';
    }


    if ( auxin_is_true( $attribution ) ) {
        $output .= sprintf( '<small class="aux-attribution"> %1$s <a href="https://wordpress.org/themes/phlox/" title="%2$s"> %3$s </a></small>',
            __( 'Powered by', 'phlox-pro' ),
            __( 'Phlox Free WordPress Theme', 'phlox-pro' ),
            __( 'Phlox Theme', 'phlox-pro' )
        );
    }

    // Prints the policy markup in site footer
    if( auxin_is_true( $show_privacy_policy ) ){
        if ( function_exists( 'the_privacy_policy_link' ) ) {
            $output .= get_the_privacy_policy_link( '<small class="aux-privacy-policy">', '</small>' );
        } else {
            $output .= sprintf( '<small class="aux-privacy-policy">%s</small>', __( 'WordPress version 4.9.6 or higher is required for this feature.', 'phlox-pro') );
        }
    }

    if( $echo ){
        echo $output;
    } else {
        return $output;
    }
}
