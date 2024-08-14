<?php
/**
 * WordPress popular posts compatibility
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


add_filter( 'wpp_custom_html', 'auxin_custom_popular_posts_markup', 10, 2 );

/**
 * Display All infromation user wants
 *
*/
function auxin_custom_popular_posts_markup( $mostpopular, $instance ){

	$output = '<div class="wpp-list">';

	// loop the array of popular posts objects
	foreach( $mostpopular as $popular ) {


		// Checking if thumbnail is actived  show the thumbs
		if ( $instance['thumbnail']['active'] ) {

			$tbwidth  = $instance['thumbnail']['width'];
			$tbheight = $instance['thumbnail']['height'];
			$tbcrop   = $instance['thumbnail']['crop'];
			$size     = array($tbwidth , $tbheight , $tbcrop);

		}

		// placeholder for the stats tag
		$stats = array();

		// Comment count option active, display comments
		if ( $instance['stats_tag']['comment_count'] ) {

			// display text in singular or plural, according to comments count
			$stats[] = '<span class="wpp-comments">' . sprintf(
				_n( '1 comment', '%s comments', $popular->comment_count, 'phlox-pro' ),
				number_format_i18n( $popular->comment_count )
			) . '</span>';

		}

		// Pageviews option checked, display views
		if ( $instance['stats_tag']['views'] ) {

			// If sorting posts by average views
			if ($instance['order_by'] == 'avg') {

				// display text in singular or plural, according to views count
				$stats[] = '<span class="wpp-views">' . sprintf(
					_n( '1 view per day', '%s views per day', intval($popular->pageviews), 'phlox-pro' ),
					number_format_i18n( $popular->pageviews, 2 )
				) . '</span>';

			}

			// Sorting posts by views
			else {

				// display text in singular or plural, according to views count
				$stats[] = '<span class="wpp-views">' . sprintf(
					_n( '1 view', '%s views', intval($popular->pageviews), 'phlox-pro' ),
					number_format_i18n( $popular->pageviews )
				) . '</span>';

			}

		}

		// Author option checked
		if ( $instance['stats_tag']['author'] ) {

			$author       = get_the_author_meta( 'display_name', $popular->uid );
			$display_name = '<a href="' . get_author_posts_url( $popular->uid ) . '">' . $author . '</a>';
			$stats[]      = '<span class="wpp-author">' . sprintf( __( 'by %s', 'phlox-pro' ), $display_name ). '</span>';

		}

		// Date option checked
		if ( $instance['stats_tag']['date']['active'] ) {

			$date    = date_i18n( $instance['stats_tag']['date']['format'], strtotime( $popular->date ) );
			$stats[] = '<span class="wpp-date">' . sprintf( __( 'posted on %s', 'phlox-pro' ), $date ) . '</span>';

		}

		// Category option checked
		if ( $instance['stats_tag']['category'] ) {

			$post_cat  = get_the_category( $popular->id );
			$post_cat  = ( isset( $post_cat[0] ) )
			? '<a href ="' . get_category_link( $post_cat[0]->term_id ) . '">' . $post_cat[0]->cat_name . '</a>'
                       : '';

			if ( $post_cat != '' ) {
				$stats[] = '<span class="wpp-category">' . sprintf( __( 'under %s', 'phlox-pro' ), $post_cat ) . '</span>';
			}

		}

		// Build stats tag
		if ( !empty( $stats ) ) {

			$stats = '<div class="wpp-stats">' . join( ' ', $stats ) . '</div>';

		}

		$excerpt = ''; // Excerpt placeholder

		// Excerpt option checked, build excerpt tag
		if ( $instance['post-excerpt']['active'] ) {

			$excerpt = get_excerpt_by_id( $popular->id );
			if ( !empty( $excerpt ) ) {
				$excerpt = '<div class="wpp-excerpt">' . $excerpt . '</div>';
			}

		}

        $output .= "<div class='wpp-list-items'>";
        $output .= '<div class="wpp-item-img">'.get_the_post_thumbnail( $popular->id , $size ).'</div>';
		$output .= "<div class='wpp-post-meta'><h2 class=\"entry-title\"><a href=\"" . get_the_permalink( $popular->id ) . "\" title=\"" . esc_attr( $popular->title ) . "\">" . $popular->title . "</a></h2>";
		$output .= $stats;
		$output .= $excerpt;
		$output .= '</div>';
		$output .= "</div>" . "\n";

	}

	$output .= '</div>';
	return $output;
}
