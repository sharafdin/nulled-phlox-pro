<?php
$available_post_types = array_keys( auxin_get_available_post_types_for_search() );

$excluded_post_types = (array) auxin_get_option( 'auxin_search_exclude_post_types', array() );

$available_post_types = array_diff( $available_post_types , $excluded_post_types );

if ( isset( $_GET['post_type'] ) && in_array( sanitize_text_field( $_GET['post_type'] ), $available_post_types ) ) {
    $first_post_type = sanitize_text_field( $_GET['post_type'] );
} else {
    // TODO: get first post type from options -
    //  do it when ajax search merged with develop and get option from options available in that task
    $first_post_type = count( $available_post_types ) > 1 || empty( $available_post_types ) ? 'post' : reset( $available_post_types );
}

// Set Query Arguments
$args = array(
        's'                 => sanitize_text_field( $_GET['s'] ),
        'post_type'         => $first_post_type,
        'posts_per_page'    => '12',
    );
$category_slug = auxin_get_categories_slug_by_post_type( $first_post_type );
if ( isset( $_GET['cat'] ) && !empty($_GET['cat']) && !empty( $category_slug) ) {
    $args['tax_query'] = array(
        array(
            'taxonomy'  => $category_slug,
            'field'     => 'slug',
            'terms'     => sanitize_text_field( $_GET['cat'] )
        )
    );
}

global $paged;
$args['paged'] = $paged;


if ( auxin_get_option( 'auxin_search_exclude_no_media' ) ) {
    $args['meta_query'] = [
        [
            'key' => '_thumbnail_id'
        ]
     ];
}

// Start Searching
$wp_query = new WP_Query( $args );
if ( $wp_query->have_posts() ) {
    $post_type_obj = get_post_type_object( $first_post_type );
    echo "<div class='aux-search-from'>
            <span>".$post_type_obj->labels->name."</span>
        </div>";
    auxin_search_page_results( 
        $first_post_type, 
        array( 
            'custom_wp_query' => $wp_query, 
            'show_filters' => false ,
            'num'           => '12',
        )
    );

    // Show Pagination
    auxin_the_search_paginate_nav(
        array( 'css_class' => esc_attr( auxin_get_option('archive_pagination_skin') ) ),
        $wp_query
    );
}
wp_reset_postdata();

// show result from other post types
unset( $args['paged'] );
$args['posts_per_page'] = '4';
foreach( $available_post_types as $key => $post_type ) {
    if ( $post_type == $first_post_type ) continue;

    // Modify args to match current post type
    $args['post_type'] = $post_type;
    if ( isset( $_GET['cat'] ) && !empty($_GET['cat']) && isset( $category_slug[ $post_type ] ) ) {
        $args['tax_query']['0']['taxonomy'] = $category_slug[$post_type];
        $args['wp_query_args']['tax_query']['0']['taxonomy'] = $category_slug[$post_type];
    }
    // Start Searching
    $wp_query = new WP_Query($args);
    if ($wp_query->have_posts()) {
        echo "<hr>";
        $post_type_obj = get_post_type_object( $post_type );
        echo "<div class='aux-search-from'>
                <span>".$post_type_obj->labels->name."</span>
                <span class='aux-show-all-results'>
                    <a href='".add_query_arg( 'post_type',$post_type )."'>".
                    sprintf( __( 'Show All %s Results', 'phlox-pro' ), $post_type_obj->labels->name ).
                    "</a>
                </span>
            </div>";
        auxin_search_page_results( $post_type, array( 'custom_wp_query' => $wp_query, 'show_filters' => false ) );
    }
    wp_reset_postdata();
}

?>