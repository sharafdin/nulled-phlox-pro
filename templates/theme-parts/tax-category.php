<?php /* Loops through all posts, taxes, .. and display posts */
    global $query_string;

    if ( get_query_var('paged') ){
         $paged = get_query_var('paged');
    } elseif ( get_query_var('page') ){
         $paged = get_query_var('page');
    } else {
        $paged = 1;
    }

    $q_args  = '&paged='. $paged. '&posts_per_page='. get_option( 'posts_per_page' );

    query_posts( $query_string.$q_args );


    while ( have_posts() ) : the_post();

        locate_template('templates/theme-parts/entry/post.php', true );

    endwhile; // end of the loop.

    auxin_the_paginate_nav(
        array( 'css_class' => esc_attr( auxin_get_option('archive_pagination_skin') ) )
    );
