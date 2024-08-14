<?php
/**
 * The main template for blog 'page templates'
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */

get_header();
global $post;

// The list of content locations in blog page templates
$location_list = array(
    'above-full',       // Page builder content on above of template with full width
    'above-boxed',      // Page builder content on above of template with boxed width
    'above-in-frame',   // Page builder content right before template content
    'below-in-frame',   // Page builder content right after template content
    'below-boxed',      // Page builder content below template content with boxed width
    'below-full',       // Page builder content below template content with full width
    'none'              // Skip Page builder content
);

$page_content_location = auxin_get_post_meta( $post, 'aux_page_template_content_location', 'above-in-frame' );
if( ! in_array( $page_content_location, $location_list ) ){
    $page_content_location = 'above-in-frame';
}

// Get the page content
if( 'none' !== $page_content_location ){
    ob_start();
    the_content();
    $content = ob_get_clean();
} else {
    $content = '';
}

// Retrieve the content with corresponding wrappers
$the_content_markup = apply_filters( 'auxin_blog_page_template_content_markup', '', $content, $page_content_location );
?>
    <main id="main" <?php auxin_content_main_class(); ?> >
        <div class="aux-wrapper">
            <?php if( in_array( $page_content_location, array( 'above-full', 'above-boxed' ) ) == $page_content_location ){ echo $the_content_markup; } ?>

            <div class="aux-container aux-fold clearfix">
                <div id="primary" class="aux-primary" >
                    <div class="content" role="main" data-target="archive">

                    <?php
                    echo auxin_get_the_archive_slider( 'post', 'content' );
                    if( 'above-in-frame' == $page_content_location ){ echo $the_content_markup; }

                    // get template slug
                    $page_template = get_page_template_slug( get_queried_object_id() );

                    // Let the auxin plugins add more custom layouts to current blog templates
                    $result = apply_filters( 'auxin_blog_page_template_archive_content', '', $page_template );

                    if( empty( $result ) ) {

                        $q_args = array(
                            'post_type'     => 'post',
                            'order_by'      => 'date',
                            'order'         => 'DESC',
                            'post_status'   => 'publish',
                            'posts_per_page'=> get_option('posts_per_page'),
                            'paged'         => max( 1, get_query_var('paged'), get_query_var('page') ) // 'paged' for archive pages and 'page' for single pages
                        );

                        $the_wp_query = new WP_Query( $q_args );

                        $result = $the_wp_query->have_posts();
                    }

                    // if it is not a shortcode base blog page
                    if( true === $result ){

                        while ( $the_wp_query->have_posts() ) : $the_wp_query->the_post();
                            include locate_template( 'templates/theme-parts/entry/post.php' );
                        endwhile; // end of the loop.

                    // if it is a shortcode base blog page
                    } elseif( false !== $result && '' !== $result ){
                        echo $result;

                    // if result not found
                    } else {
                        include locate_template( 'templates/theme-parts/content-none.php' );
                    }

                    // generate the archive pagination
                    auxin_the_paginate_nav(
                        array(
                            'css_class' => esc_attr( auxin_get_option('archive_pagination_skin') ),
                            'wp_query'  => isset( $the_wp_query ) ? $the_wp_query : null
                        )
                    );

                    // reset the post data
                    wp_reset_postdata();

                    if( 'below-in-frame' == $page_content_location ){ echo $the_content_markup; }
                    ?>
                    </div><!-- end content -->

                </div><!-- end primary -->

                <?php get_sidebar(); ?>

            </div><!-- end container -->
            <?php if( in_array( $page_content_location, array( 'below-full', 'below-boxed' ) ) == $page_content_location ){ echo $the_content_markup; } ?>


        </div><!-- end wrapper -->
    </main><!-- end main -->

<?php get_sidebar('footer'); ?>
<?php get_footer(); ?>
