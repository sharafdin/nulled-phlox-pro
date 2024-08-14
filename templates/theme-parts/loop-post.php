<?php
/**
 * Loops through all posts, taxes, .. and display posts
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */

// print the post slider
echo auxin_get_the_archive_slider( 'post', 'content' );

// get template type id
$template_type_id   = auxin_get_option( 'post_index_template_type', 'default' );
$post_loadmore_type = auxin_get_option( 'post_index_loadmore_type', '' );

// Use taxonomy template option if is category or tag archive page
if( is_category() || is_tag() || is_author() ){
	$template_type_id   = auxin_get_option( 'post_taxonomy_archive_template_type', 'default' );
	$post_loadmore_type = auxin_get_option( 'post_taxonomy_loadmore_type', '' );
}

// Does this query have result?
$result = have_posts();

// Let the auxin plugins add more custom layouts to current blog templates
$result = apply_filters( 'auxin_blog_archive_custom_template_layouts', $result, $template_type_id );


// if it is not a shortcode base blog layout
if( true === $result ){
    while ( have_posts() ) : the_post();
        include locate_template( 'templates/theme-parts/entry/post.php' );
    endwhile; // end of the loop.

// if it is a shortcode base blog layout
} elseif( false !== $result && '' !== $result ){
    echo $result;

// if result not found
} else {
    include locate_template( 'templates/theme-parts/content-none.php' );
}

if ( empty( $post_loadmore_type ) || in_array( $template_type_id, array( 'default', '1', '2', '3', '4' ) ) ){
	auxin_the_paginate_nav(
	    array( 'css_class' => esc_attr( auxin_get_option('archive_pagination_skin') ) )
	);
}
