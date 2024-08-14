<?php
/**
 * Secondary sidebar
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/


    global $post;

    // if no result
    if( is_404() || empty( $post ) || is_search() ) {
        return;
    }


    // always generate secondary sidebar on customizer (useful for previewing live changes in sidebar positions)
    if( 2 === auxin_has_sidebar( $post ) || is_customize_preview() ) { ?>

            <aside class="aux-sidebar aux-sidebar-secondary">
                <div class="sidebar-inner">
                    <div class="sidebar-content">

<?php
        if( is_active_sidebar( 'auxin-global-secondary-sidebar-widget-area' ) ){
            echo '<div class="aux-widget-area">';
            dynamic_sidebar( 'auxin-global-secondary-sidebar-widget-area' );
            echo '</div>';
        }

        // get page template name
        $page_tempalte_name = get_post_meta( $post->ID, '_wp_page_template', TRUE );

        // if the current page is a blog page
        if ( ( $post->post_type == 'post' || strpos( $page_tempalte_name, 'blog' ) !== false ) && is_active_sidebar( 'auxin-blog-secondary-sidebar-widget-area' ) ) {
            echo '<div class="aux-widget-area">';
            dynamic_sidebar( 'auxin-blog-secondary-sidebar-widget-area' );
            echo '</div>';

        } elseif( is_active_sidebar( 'auxin-pages-secondary-sidebar-widget-area' ) ){
            echo '<div class="aux-widget-area">';
            dynamic_sidebar( 'auxin-pages-secondary-sidebar-widget-area' );
        }

?>
                    </div><!-- end sidebar-content -->
                </div><!-- end sidebar-inner -->
            </aside><!-- end secondary siderbar -->

<?php
    }

