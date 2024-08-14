<?php
/**
 * Primary sidebar
 * The sidebar widget area is triggered if any of the areas have widgets.
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

    if( is_404() ){
        return;
    }

    global $post;

    // if no result
    if( ( empty( $post ) || is_search() ) && ! auxin_is_wc_product_archive() ) {
?>
            <aside class="aux-sidebar aux-sidebar-primary">
                <div class="sidebar-inner">
                    <div class="sidebar-content">
<?php if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'auxin_sidebar_primary' ) || is_active_sidebar( 'auxin-search-sidebar-widget-area' ) ) { ?>
                        <div class="aux-widget-area">
                        <?php
                            if( is_active_sidebar( 'auxin-search-sidebar-widget-area' ) ){
                                dynamic_sidebar( 'auxin-search-sidebar-widget-area' );
                            } elseif( current_user_can( 'edit_theme_options' ) ) {
                                echo '<div>' . esc_html__('Search widget area is empty.', 'phlox-pro' ) . '</div>';
                            }
                        ?>
                        </div>
<?php } ?>
                    </div>
                </div><!-- end sidebar wrapper -->
            </aside><!-- end siderbar -->
<?php return;
    }

// -----------------------------------------------------------------------------

    if( auxin_has_sidebar( $post ) || is_customize_preview() ) { ?>

            <aside class="aux-sidebar aux-sidebar-primary">
                <div class="sidebar-inner">
                    <div class="sidebar-content">
<?php
    if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'auxin_sidebar_primary' ) ) {

        if( is_active_sidebar( 'auxin-global-primary-sidebar-widget-area' ) ){
            echo '<div class="aux-widget-area">';
            dynamic_sidebar( 'auxin-global-primary-sidebar-widget-area' );
            echo '</div>';
        }

        // get page template name
        $page_template_name = get_post_meta( $post->ID, '_wp_page_template', TRUE );

        // if the current page is a blog page
        if ( ( $post->post_type == 'post' || strpos( $page_template_name, 'blog' ) !== false ) && is_active_sidebar( 'auxin-blog-primary-sidebar-widget-area' ) ) {
            echo '<div class="aux-widget-area">';
            dynamic_sidebar( 'auxin-blog-primary-sidebar-widget-area' );
            echo '</div>';
        } elseif ( function_exists('is_shop') && is_shop() ) {
            
            echo '<div class="aux-widget-area">';
            if( is_active_sidebar( 'auxin-shop-sidebar-widget-area' ) ){
                dynamic_sidebar( 'auxin-shop-sidebar-widget-area' );
            }
            echo '</div>';

        } elseif( is_active_sidebar( 'auxin-pages-primary-sidebar-widget-area' ) ){
            echo '<div class="aux-widget-area">';
            dynamic_sidebar( 'auxin-pages-primary-sidebar-widget-area' );
            echo '</div>';
        }


    }
?>
                    </div><!-- end sidebar-content -->
                </div><!-- end sidebar-inner -->
            </aside><!-- end primary siderbar -->
<?php
    }
