<?php
/**
 * Class for generating breadcrumb in pages
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;

if ( ! class_exists( 'Auxin_Breadcrumb' ) ) :



class Auxin_Breadcrumb {

    public $wrapper_start_tag = '<p class="aux-breadcrumbs">';
    public $wrapper_end_tag   = '</p>';

    public $sep               = '';
    public $home_icon         = '';

    public $item_start_tag    = '<span>';
    public $item_end_tag      = '</span>';


    public function render() {

        // Use "Breadcrumb NavXT" plugin instead, if it's installed
        if( function_exists('bcn_display') ){
            echo $this->wrapper_start_tag;
            bcn_display();
            echo $this->wrapper_end_tag;
            return;
        }

        // Use yoast breadcrumb if it's installed
        if ( function_exists( 'yoast_breadcrumb' ) ) {
            $breadcrumbs_enabled = current_theme_supports( 'yoast-seo-breadcrumbs' );
            if ( ! $breadcrumbs_enabled ) {
                $options             = get_option( 'wpseo_titles' );
                $breadcrumbs_enabled = ( $options['breadcrumbs-enable'] === true );
            }

            if ( $breadcrumbs_enabled ) {
                yoast_breadcrumb( $this->wrapper_start_tag, $this->wrapper_end_tag );
                return;
            }

        }

        global $post;

        if( is_home() ||  is_front_page() || is_404() || is_search() || ! isset( $post ) ) { return; }



        $this_temp_name = get_post_meta( $post->ID, '_wp_page_template', TRUE );
        $this_page_type = $post->post_type;

        $crumbs  =  $this->wrapper_start_tag;
        if ( empty( $this->home_icon ) ) {
            $crumbs .=  $this->create_crumb( esc_html_x( 'Home', 'Home in breadcrumb' , 'phlox-pro'), home_url(), null );
        } else {
            $crumbs .=  "<a href='" . home_url() . "'><span class='aux-breadcrumb-home " . $this->home_icon . "'></span></a>";
        }
        

        //if it is page
        if( is_page() ) {

            $branch   = array();
            $branch[] = $this->create_crumb( get_the_title( $post->ID ) );

            // loops thtough branch if has parent
            $p_post = $post;

            while ( is_object( $p_post ) && $p_post->post_parent ) {
                $branch[] = $this->create_crumb( get_the_title( $p_post->post_parent ), get_permalink( $p_post->post_parent ) );
                $p_post   = get_post( $p_post->post_parent );
            }

            $branch  = array_reverse( $branch );
            $crumbs .= implode( "", $branch   );
            $crumbs .= $this->wrapper_end_tag . "\n";
        }

        //if it's a single news/blog post --------------------------

        if( is_single() ) {

            $count_limit = 1;

            if( $this_page_type == "news" ) {
                $tax      = 'news-category';
                $crumbs  .= $this->get_single_breadcrumb_branch( $tax );

            } elseif( $this_page_type == "post" ) {
                $tax      = 'category';

                $show_on_front  = get_option( 'show_on_front' );
                $page_for_posts = get_option( 'page_for_posts' );

                if ( 'page' == $show_on_front && $page_for_posts ) {
                    $blog_title  = get_the_title( $page_for_posts );
                } else {
                    $blog_title  = esc_html_x( 'Blog', 'The blog title in breadcrumb', 'phlox-pro' );
                }

                $blog_link = get_post_type_archive_link( 'post' );

                $crumbs  .= $this->create_crumb( $blog_title, $blog_link );
                $crumbs  .= $this->get_single_breadcrumb_branch( $tax );

            } elseif ( $this_page_type == "portfolio" ) {

                $nav_type = auxin_get_option( 'portfolio_single_nav_type', 'breadcrumb' );

                if( $nav_type == 'breadcrumb' ){
                    $tax      = 'portfolio-cat';
                    $crumbs  .= $this->get_single_breadcrumb_branch( $tax );

                } elseif( $nav_type == "next_prev" ) {

                    $list_page = sprintf( '<a href="%s">%s</a>', get_post_type_archive_link( get_post_type() ), esc_html__( 'show all', 'phlox-pro' ) );
                    echo $this->get_next_prev_post_link( $this->wrapper_start_tag .$this->item_start_tag, $this->item_end_tag, $this->item_end_tag. $this->sep .$this->item_start_tag, $list_page );
                    $crumbs  =    '';

                } else {
                    $crumbs = "";
                }

            } elseif ( $this_page_type == "staff" ) {
                $tax      = 'department';
                $crumbs  .= $this->get_single_breadcrumb_branch( $tax );

            } elseif ( $this_page_type == "testimonial" ) {
                $tax      = 'testimonial-category';
                $crumbs  .= $this->get_single_breadcrumb_branch( $tax );

            } else if ( $this_page_type == "product" ) {
                $tax      = 'product_cat';
                $crumbs  .= $this->get_single_breadcrumb_branch( $tax );
            } else {
                $crumbs .= $this->sep .'<span> '.get_the_title( $post->ID ). $this->item_end_tag;
                $crumbs .= $this->wrapper_end_tag . "\n";
            }

        }

        elseif( is_tax() ) {

            $tax    = get_query_var('taxonomy');
            $term   = get_term_by('slug', get_query_var( 'term' ), $tax );
            $branch = array( $this->sep .'<span> '.$term->name. $this->item_end_tag );

            // loops thtough branch if term has parent
            $parent_id = $term->parent;

            while ($parent_id) {
                $parent    = get_term_by( 'id', $parent_id, $tax );

                $branch[]  = $this->create_crumb( $parent->name, get_term_link( $parent->slug, $tax ) );
                $parent_id = $parent->parent;
            }


            $branch[]= $this->create_crumb( $this->get_post_type_user_defined_name(), get_post_type_archive_link( $this_page_type ) );

            $branch  = array_reverse( $branch );
            $crumbs .= implode( "", $branch );
            $crumbs .= $this->wrapper_end_tag."\n";
        }

        // If it's custom post type archive (index) page
        elseif( is_post_type_archive() ) {
            $crumbs       .= $this->create_crumb( $this->get_post_type_user_defined_name() );
            $crumbs       .= $this->wrapper_end_tag."\n";
        }

        // if it's blog category page
        elseif( is_category() || is_tag() ) {
            $crumbs .= $this->create_crumb( single_term_title( '', false ) );
            $crumbs .= $this->wrapper_end_tag."\n";
        }

        //if it's the news/blog home page or any type of archive
        elseif( is_archive() ) {

            $crumbs .= $this->create_crumb( post_type_archive_title( '', false ) );
            $crumbs .= $this->wrapper_end_tag."\n";
        }

        echo $crumbs;
    }



    public function create_crumb( $title = '', $link = '', $sep = '' ){
        if( $title ) {

            $sep = ! $sep ? $this->sep : $sep;
            $crumb_max_length = auxin_get_option( 'breadcrumbs_text_max_length', 30 );
            $crumb_max_length =  empty( $crumb_max_length ) ? '' : $crumb_max_length ;
            $trimmed_title = esc_html( auxin_get_trimmed_string( $title, $crumb_max_length, "..." ) );

            if( $link ){
                return sprintf( '%s<span><a href="%s" title="%s">%s</a></span>', $sep , esc_url( $link ), esc_attr( $title ), $trimmed_title );
            } else {
                return sprintf( '%s<span>%s</span>', $sep , $trimmed_title );
            }
        }
        return '';
    }


    public function get_next_prev_post_link( $start_tag = '', $end_tag = '', $sep = '', $middle_tag = '' ){
        if( ! $sep ){
            $sep = $this->item_end_tag.$this->sep .$this->item_start_tag;
        }
        if( ! $start_tag ){
            $start_tag = $this->$wrapper_start_tag.$this->item_start_tag;
        }
        if( ! $end_tag ){
            $end_tag = $this->item_end_tag. $this->$wrapper_end_tag;
        }
        $output  = $start_tag;
        $output .= get_previous_post_link( '%link', esc_html_x( 'previous', 'navigate to previous page', 'phlox-pro') );
        $output .= $sep;
        $output .= ! empty( $middle_tag ) ? $middle_tag . $sep : '';
        $output .= get_next_post_link( '%link', esc_html_x( 'next', 'navigate to next page', 'phlox-pro') );
        $output .= $end_tag;

        echo $output;
    }



    // returns all breadcrumb branches for single page
    public function get_single_breadcrumb_branch( $tax ){
        global $post;

        if( ! isset( $post ) ) return '';

        $cat_terms = wp_get_post_terms( $post->ID, $tax );

        if( is_array( $cat_terms ) && isset( $cat_terms[0] ) ){

            $term     = $cat_terms[0];
            $branch   = array();
            $branch[] = $this->create_crumb( $term->name, get_term_link( $term->slug, $tax ) );

            // loops thtough branch if term has parent
            $parent_id = $term->parent;

            while ( $parent_id ) {
                $parent    = get_term_by( 'id', $parent_id, $tax );
                $branch[]  = $this->create_crumb( $parent->name, get_term_link( $parent->slug, $tax ) );
                $parent_id = $parent->parent;
            }

            if( $post->post_type != "post" ){
                $branch[] = $this->create_crumb( $this->get_post_type_user_defined_name(), get_post_type_archive_link( $post->post_type ) );
            }

            $branch  = array_reverse( $branch );
            $crumbs  = implode( "", $branch );
            $crumbs .= $this->create_crumb( get_the_title( $post->ID ) );
            $crumbs .= $this->wrapper_end_tag."\n";

            return $crumbs;
        }

        return '';
    }

    public function set_separator_icon( $icon_class = '' ){
        // 'gt' is previous default value which will be converted to default icon
        $icon_class = ! empty( $icon_class ) && ( 'gt' !== $icon_class ) ? $icon_class : 'auxicon-chevron-right-1';

        $this->sep = '<span class="aux-breadcrumb-sep breadcrumb-icon '. esc_attr( $icon_class ) .'"></span>';
    }



    public function get_post_type_user_defined_name( $post_type = '' ){
        $post_type      = empty( $post_type ) ? get_post_type() : $post_type;
        $post_type_obj  = get_post_type_object( $post_type );

        return auxin_get_option( $post_type.'_archive_breadcrumb_label', $post_type_obj->labels->menu_name );
    }

}


endif;
