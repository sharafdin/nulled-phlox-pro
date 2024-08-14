<?php
/**
 * General Functions
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


//// verfiy current page id ////////////////////////////////////////////////////////////

if( ! function_exists( "auxin_is_currentpage_id" ) ){

    function auxin_is_currentpage_id( $id ){
        if( ! function_exists( "get_current_screen" ) )    return true;

        $screen = get_current_screen();
        return is_object( $screen ) && $screen->id == $id;
    }

}


//// finds out if the url contains upload directory path (true, if it's absolute url to internal file)

/**
 * Whether the URL contains upload directory path or not
 *
 * @param  string $url  The URL
 * @return bool   TRUE if the URL is absolute
 */
if( ! function_exists( "auxin_contains_upload_dir" ) ){

    function auxin_contains_upload_dir( $url ){
        $uploads_dir = wp_get_upload_dir();
        return strpos( $url, $uploads_dir['baseurl'] ) !== false;
    }

}

/**
 * Whether it is auxin blog page or not
 *
 * @return boolean
 */
function auxin_is_blog(){
    // get the slug of page template
    $page_template_slug  = is_page_template() ? get_page_template_slug( get_queried_object_id() ) : '';
    // whether the current page is a blog page template or not
    $is_blog_template    = ! empty( $page_template_slug ) && false !== strpos( $page_template_slug, 'blog-type' );

    if( ( $is_blog_template || ( is_home() && !is_paged() ) || ( is_home() && !is_front_page() ) || ( !is_category() && !is_paged() && !is_tag() && !is_author() && is_archive() && !is_date() ) ) ) {
        return true;
    }
    return false;
}

//// create relative url if it's url for internal uploaded file ////////////////////////

/**
 * Print relative URL for media file event if the URL is absolute
 *
 * @param  string $url  The link to media file
 * @return void
 */
function auxin_the_relative_file_url( $url ){
    echo auxin_get_the_relative_file_url( $url );
}

    /**
     * Get relative URL for media file event if the URL is absolute
     *
     * @param  string $url  The link to media file
     * @return string   The absolute URL to media file
     */
    if( ! function_exists( 'auxin_get_the_relative_file_url' ) ){

        function auxin_get_the_relative_file_url( $url ){
            if( ! isset( $url ) || empty( $url ) )     return '';

            // if it's not internal absolute url
            if( ! auxin_contains_upload_dir( $url ) ) return $url;

            $uploads_dir = wp_get_upload_dir();
            return str_replace( trailingslashit( $uploads_dir['baseurl'] ), '', $url );
        }

    }


/*-----------------------------------------------------------------------------------*/
/*  Get data about current main/parent theme
/*-----------------------------------------------------------------------------------*/

function auxin_get_main_theme(){
    $theme = wp_get_theme();
    // always use parent theme data - averta
    if( is_child_theme() )
        $theme = wp_get_theme( $theme->template );
    return $theme;
}

/*-----------------------------------------------------------------------------------*/

/**
 * Retrieve post meta field for a post with fallback to default value.
 *
 * @param  int    $post_id       Post ID or post object
 * @param  string $meta_key      The meta key to retrieve. By default, returns data for all keys.
 * @param  string $default_value Default value if value for meta key was not found.
 *
 * @return mixed                 Value of meta data field
 */
function auxin_get_post_meta( $post_id, $meta_key = '', $default_value = '' ){
    $post = get_post( $post_id );

    if( empty( $post ) || empty( $post->ID ) )
        return $default_value;

    $meta_value = get_metadata( 'post', $post->ID, $meta_key, true );
    return '' === $meta_value ? $default_value : $meta_value;
}

/*-----------------------------------------------------------------------------------*/
/*  Get trimmed string
/*-----------------------------------------------------------------------------------*/

function auxin_the_trimmed_string( $string, $max_length = 1000, $more = " ..." ){
    echo auxin_get_trimmed_string( $string, $max_length, $more );
}

    if( ! function_exists( 'auxin_get_trimmed_string' ) ){
        function auxin_get_trimmed_string( $string, $max_length = 1000, $more = " ..." ){
            $string_length = function_exists('mb_strwidth') ? mb_strwidth( $string ) : strlen( $string );
            if( $string_length > $max_length && ! empty( $max_length ) ){
                return function_exists( 'mb_strimwidth' ) ? mb_strimwidth( $string, 0, $max_length, '' ) . $more : substr( $string, 0, $max_length ) . $more;
            }
            return $string;
        }
    }

/*-----------------------------------------------------------------------------------*/
/*  Shortcode enabled excerpts trimmed by character length
/*-----------------------------------------------------------------------------------*/

function auxin_the_trim_excerpt( $post_id = null, $char_length = null, $exclude_strip_shortcode_tags = null, $skip_more_tag = false, $wrap_excerpt_with = '' ){
    echo auxin_get_the_trim_excerpt( $post_id, $char_length, $exclude_strip_shortcode_tags, $skip_more_tag, $wrap_excerpt_with );
}
    if( ! function_exists( 'auxin_get_the_trim_excerpt' ) ){

        // make shortcodes executable in excerpt
        function auxin_get_the_trim_excerpt( $post_id = null, $char_length = null, $exclude_strip_shortcode_tags = null, $skip_more_tag = false, $wrap_excerpt_with = '' ) {
            $post = get_post( $post_id );
            if( ! isset( $post ) ) return '';

            // If post password required and it doesn't match the cookie.
            if ( post_password_required( $post ) )
                return get_the_password_form( $post );

            $post_content      = $post->post_content;
            $content           = $post_content;

            $excerpt_more = apply_filters( 'excerpt_more', " ..." );
            $excerpt_more = apply_filters( 'auxin_trim_excerpt_more', $excerpt_more );

            // check for <!--more--> tag
            if ( ! $skip_more_tag && preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
                $content = explode( $matches[0], $content, 2 );

                if ( ! empty( $matches[1] ) ){
                    $more_link_text = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );
                    $excerpt_more   = ! empty( $more_link_text ) ? $more_link_text : $excerpt_more;
                }

                return $content[0] . $excerpt_more;
            }
            // If char length is defined use it, otherwise use default char length
            $char_length  = empty( $char_length ) ? apply_filters( 'auxin_excerpt_char_length', 250 ) : $char_length;

            // Clean post content
            $excerpt = strip_tags( auxin_strip_shortcodes( $content, $exclude_strip_shortcode_tags ) );
            $excerpt = auxin_get_trimmed_string( $excerpt, $char_length, $excerpt_more );

            $excerpt = apply_filters( 'auxin_get_the_trim_excerpt', $excerpt, $post, $content, $post_content, $char_length, $excerpt_more );

            return  $excerpt && $wrap_excerpt_with ? "<{$wrap_excerpt_with}>" . $excerpt . "</{$wrap_excerpt_with}>" : $excerpt;
        }

    }

/*-----------------------------------------------------------------------------------*/
/*  Get template part for auxin themes and plugins
/*-----------------------------------------------------------------------------------*/

/**
 * Get template file path for auxin themes and plugins
 *
 * @param mixed    $slug
 * @param string   $name                  (default: '')
 * @param string   $extra_template_path   Extra template path for searching the template files in
 *
 * @return string  Template file path
 */
function auxin_get_template_file( $slug, $name = '', $extra_template_path = '' ) {
    $template = '';

    // Look in yourtheme/templates/slug-name.php
    if ( $name ) {
        $template = locate_template( array( "templates/{$slug}-{$name}.php" ) );
    }

    // Add slash at the end of path
    if( $extra_template_path ){
        $extra_template_path = trailingslashit( (string)$extra_template_path );
    }

    // Search and get slug-name.php from extra template path
    if ( ! $template && $extra_template_path && $name && file_exists( $extra_template_path . "{$slug}-{$name}.php" ) ) {
        $template = $extra_template_path . "{$slug}-{$name}.php";
    }

    // If template file doesn't exist, look in yourtheme/templates/slug.php
    if ( ! $template ) {
        $template = locate_template( array( "templates/{$slug}.php" ) );
    }

    // Search and get slug.php from extra template path
    if ( ! $template && $extra_template_path && $slug && file_exists( $extra_template_path . "{$slug}.php" ) ) {
        $template = $extra_template_path . "{$slug}.php";
    }

    // Allow developers to filter template file via this hook
    return apply_filters( 'auxin_get_template_file', $template, $slug, $name, $extra_template_path );
}


/**
 * Get template part.
 *
 * @param mixed    $slug
 * @param string   $name                  (default: '')
 * @param string   $extra_template_path   Extra template path for searching the template files in
 */
function auxin_get_template_part( $slug, $name = '', $extra_template_path = '' ) {
    if ( $template = auxin_get_template_file( $slug, $name, $extra_template_path ) ) {
        load_template( $template, false );
    }
}

/*-----------------------------------------------------------------------------------*/
/*  Excerpt outside of loop - trimmed by word length - The shortcodes content remains after striping
/*-----------------------------------------------------------------------------------*/

function auxin_the_excerpt( $post_id = null, $excerpt_length = null, $exclude_strip_shortcode_tags = null, $skip_more_tag = false ){
    echo auxin_get_the_excerpt( $post_id, $excerpt_length, $exclude_strip_shortcode_tags );
}

    // Generates an excerpt from the content outside of loop, if needed.
    function auxin_get_the_excerpt( $post_id = null, $excerpt_length = null, $exclude_strip_shortcode_tags = null, $skip_more_tag = false ) {
        $post = get_post( $post_id );
        if( ! isset( $post ) ) return '';

        // If post password required and it doesn't match the cookie.
        if ( post_password_required( $post ) )
            return get_the_password_form( $post );

        if ( $post->post_excerpt ) {
            $result = apply_filters( 'get_the_excerpt', $post->post_excerpt );

        } else {
            $content = $post->post_content;
            $content = apply_filters( 'the_content', $content );

            // If excerpt length is defined use it, otherwise use default excerpt length
            $excerpt_length = empty( $excerpt_length ) ? apply_filters( 'excerpt_length', 55 ) : $excerpt_length;
            $excerpt_more   = apply_filters( 'excerpt_more', " ..." );

            // check for <!--more--> tag
            if ( ! $skip_more_tag && preg_match( '/<!--more(.*?)?-->/', $content, $matches ) ) {
                $content = explode( $matches[0], $content, 2 );

                if ( ! empty( $matches[1] ) ){
                    $more_link_text = strip_tags( wp_kses_no_null( trim( $matches[1] ) ) );
                    $excerpt_more   = ! empty( $more_link_text ) ? $more_link_text : $excerpt_more;
                }

                return $content[0] . $excerpt_more;
            }

            // Clean post content
            $excerpt = strip_tags( auxin_strip_shortcodes( $content, $exclude_strip_shortcode_tags ) );
            $result = wp_trim_words( $excerpt, $excerpt_length, $excerpt_more );
        }

        return apply_filters( 'auxin_get_the_excerpt', $result );
    }

/*-----------------------------------------------------------------------------------*/
/*  Remove just shortcode tags from the given content but remain content of shortcodes
/*-----------------------------------------------------------------------------------*/

function auxin_strip_shortcodes( $content, $exclude_strip_shortcode_tags = null ) {
    if( ! $content ) return $content;

    if( ! $exclude_strip_shortcode_tags )
        $exclude_strip_shortcode_tags = auxin_exclude_strip_shortcode_tags();

    if( empty( $exclude_strip_shortcode_tags ) || ! is_array( $exclude_strip_shortcode_tags ) )
        return preg_replace('/\[[^\]]*\]/', '', $content);

    $exclude_codes = join('|', $exclude_strip_shortcode_tags);
    return preg_replace( "~(?:\[/?)(?!(?:$exclude_codes))[^/\]]+/?\]~s", '', $content );
}

/*-----------------------------------------------------------------------------------*/
/*  The list of shortcode tags that should not be removed in auxin_strip_shortcodes
/*-----------------------------------------------------------------------------------*/

function auxin_exclude_strip_shortcode_tags(){
    return apply_filters( "auxin_exclude_strip_shortcode_tags", array() );
}

/*-----------------------------------------------------------------------------------*/
/*  Specifies whether the current page is theme admin page or not
/*-----------------------------------------------------------------------------------*/

/**
 * Whether is the current admin page in list or not
 *
 * @param  array   $admin_pages list of admin page ids
 * @return boolean              True if the the current admin page is theme admin page
 */
function auxin_is_theme_admin_page( $admin_pages = array() ){
    global $pagenow;

    $admin_pages = empty( $admin_pages ) ? auxin_theme_admin_pages() : $admin_pages;

    foreach ( $admin_pages as $page ){
        if( auxin_is_currentpage_id( $page ) )  return true;
    }

    if( isset( $_GET['page'] ) && 'admin.php' == $pagenow && 'auxin-options' == $_GET['page'] ){
        return true;
    }

    if( auxin_is_currentpage_id( 'nav-menus' ) ){
        return true;
    }

    return false;
}

/*-----------------------------------------------------------------------------------*/
/*  List of theme admin pages
/*-----------------------------------------------------------------------------------*/

function auxin_theme_admin_pages(){
    return apply_filters( 'auxin_theme_admin_pages',
        array_merge(
            array('toplevel_page_auxin', 'appearance_page_auxin', 'toplevel_page_auxin-welcome', 'appearance_page_auxin-welcome', 'page', 'post', 'widgets'),
            auxin_registered_post_types(true)
        )
    );
}

/*-----------------------------------------------------------------------------------*/
/*  Excerpt configuration
/*-----------------------------------------------------------------------------------*/

//// Returns range list of numbers ///////////////////////////////////////////////////

if( ! function_exists( 'auxin_get_range' ) ){

    function auxin_get_range( $start_num, $end_num, $default_values = array() ){
        return array_merge( $default_values, range( $start_num, $end_num ) );
    }

}


function auxin_change_trim_excerpt_more_link( $more_link, $more_text, $from = '' ){

    // dont render readmore link if the blog template has auto readmore link
    if( in_array( auxin_get_option('post_index_template_type'), array('default', '1', '2', '3', '4') ) ){
        return '';
    }

    // if filter called from auxin_trim_excerpt function
    if( 'auxin_trim_excerpt' == $from ){
        return ' <a href="' . get_permalink() . '" class="more-link aux-read-more aux-outline aux-large">'. __( ' Continue Reading', 'phlox-pro' ) .'</a>';
    }
    return $more_link;
}

function auxin_change_content_more_link( $more_link, $more_text, $from = '' ){
    if( empty( $from ) ){
        return ' <a href="' . get_permalink() . '" class="more-link aux-read-more aux-outline aux-large"> '. $more_text .'</a>';
    }
    return $more_link;
}


/*-----------------------------------------------------------------------------------*/
/*  Sidebar and Layouts
/*-----------------------------------------------------------------------------------*/

//// specifies whether the page is full or has sidebar  /////////////////////////////////////////////

/**
 * Specifies whether th page has sidebar or not
 */
if( ! function_exists( 'auxin_has_sidebar' ) ){

    function auxin_has_sidebar( $page_id ) {
        $post = get_post( $page_id );
        $sidebar_pos = auxin_get_page_sidebar_pos( $post );

        if( 'no-sidebar' == $sidebar_pos ){
            return 0;
        } elseif( in_array( $sidebar_pos, array( 'right2-sidebar', 'left2-sidebar', 'left-right-sidebar','right-left-sidebar' ) ) ) {
            return 2;
        } elseif( in_array( $sidebar_pos, array( 'right-sidebar', 'left-sidebar' ) ) ) {
            return 1;
        }
        return false;
    }

}


/**
 * Retrieve the status of page sidebar [right-sidebar, left-sidebar, no-sidebar]
 *
 * @param  int|Object $page_id The page id or $post object
 * @return string              The the status of page sidebar [right-sidebar, left-sidebar, no-sidebar]
 */
function auxin_get_page_sidebar_pos( $page_id ){

    $layout = 'right-sidebar';
    $post   = get_post( $page_id );

    // check if woocommerce is activaited
    if ( class_exists('WooCommerce') ) {
        if( is_product() ) {
            $layout = auxin_get_option( 'product_single_sidebar_position', 'right-sidebar');
        }
    }

    if( is_404() || ( ! $post && ! auxin_is_wc_product_archive() ) ){
        $layout = 'no-sidebar';

    } elseif( is_home() || is_post_type_archive('post') ){
        $layout = auxin_get_option( 'post_index_sidebar_position', 'right-sidebar');

    } elseif( is_tax() ){

        // If the post type in list of "post_types_with_no_sidebar" set sidebar_pos to no-sidebar
        if( in_array( $post->post_type, apply_filters( 'auxin_post_types_with_no_sidebar_on_taxonomy', array( 'service', 'faq', 'staff', 'testimonial' ) ) ) ){
            $layout = 'no-sidebar';
        } else {
            $layout = auxin_get_option( $post->post_type.'_taxonomy_archive_sidebar_position', 'right-sidebar');
            // check if woocommerce is activaited
            if ( class_exists('WooCommerce') ) {
                 if( is_product_category() || is_product_tag() ){
                    $layout = auxin_get_option( 'product_category_sidebar_position', 'right-sidebar');
                }
            }

            // set the sidebars on portfolio category and tag archive
            if( is_tax('portfolio-tag') || is_tax('portfolio-cat')  ) {
                $layout = auxin_get_option( 'portfolio_taxonomy_sidebar_position', 'right-sidebar');
            }
        }

    } elseif( is_category() || is_tag() || is_author() ) {

        $layout = auxin_get_option( 'post_taxonomy_archive_sidebar_position', 'right-sidebar');
    } elseif( is_search() ){
        $layout = is_active_sidebar( 'auxin-search-sidebar-widget-area' ) ? 'right-sidebar' : 'no-sidebar';

    } elseif( is_archive() ){

        if ( empty( $post_type) ) {
            $layout = 'right-sidebar';
        } else {
            // If the post type in list of "post_types_with_no_sidebar" set sidebar_pos to no-sidebar
            $default_layout = in_array( $post_type, array('portfolio', 'product') ) ? 'no-sidebar' : 'right-sidebar';
            $layout = auxin_get_option( $post->post_type.'_index_sidebar_position', $default_layout );
        }


        if( auxin_is_wc_product_archive() ){
            $layout = auxin_get_option( 'product_index_sidebar_position', 'right-sidebar');
        }

        if ( class_exists('bbPress') ) {
            if ( is_bbpress() ){
                $layout = auxin_get_option( 'page_single_sidebar_position', 'right-sidebar');
            }
        }

    } elseif( is_single() ){

        if( 'default' == $layout = auxin_get_post_meta( $post, 'page_layout', 'default' ) ){
            $default_layout = in_array( $post->post_type, array('elementor_library') ) ? 'no-sidebar' : 'right-sidebar';
            $layout = auxin_get_option( $post->post_type.'_single_sidebar_position', $default_layout );
        }

        if ( class_exists('bbPress') ) {
            if ( is_bbpress() ){
                $layout = auxin_get_option( 'page_single_sidebar_position', 'right-sidebar');
            }
        }

    } elseif( is_page() ){

        if( 'default' == $layout = auxin_get_post_meta( $post, 'page_layout', 'default' ) ){
            $layout = auxin_get_option( $post->post_type.'_single_sidebar_position', 'no-sidebar');
        }
    } elseif( $post && ! $layout = get_post_meta( $post->ID, 'page_layout', true ) ){
        $layout = 'no-sidebar';
    }
    if( is_post_type_archive('portfolio') && ! is_tax() ) {
        $layout = auxin_get_option( 'portfolio_index_sidebar_position', 'no-sidebar');
    } elseif( is_post_type_archive('news') && ! is_tax() ) {
        $layout = auxin_get_option( 'news_index_sidebar_position', 'no-sidebar');
    }

    switch ($layout) {
        case 'right-sidebar':
        case 'left-sidebar':
            $layout = auxin_primary_sidebar_has_content() ? $layout : 'no-sidebar';
            break;
        
        case 'right2-sidebar':
        case 'left2-sidebar':
                $layout = auxin_primary_sidebar_has_content() || auxin_secondary_sidebar_has_content() ? $layout : 'no-sidebar';
                break;

        default:
            break;
    }

    return apply_filters( 'auxin_get_page_sidebar_pos', esc_attr( $layout ), $post );
}

/**
 * Check if primary sidebar has content
 * 
 * @return bool
 */
function auxin_primary_sidebar_has_content() {

    global $post;
    if( ( empty( $post ) || is_search() ) && ! auxin_is_wc_product_archive() ) {
        if( is_active_sidebar( 'auxin-search-sidebar-widget-area' ) ) {
            return true;
        }

        return false;
    }

    if ( is_active_sidebar( 'auxin-global-primary-sidebar-widget-area' ) ) {
        return true;
    }

    $page_template_name = get_post_meta( $post->ID, '_wp_page_template', TRUE );
    if ( ( $post->post_type == 'post' || strpos( $page_template_name, 'blog' ) !== false ) && is_active_sidebar( 'auxin-blog-primary-sidebar-widget-area' ) ) {
        if( is_active_sidebar( 'auxin-blog-primary-sidebar-widget-area' ) ){
            return true;
        }
    }

    if ( function_exists('is_shop') && is_shop() && is_active_sidebar( 'auxin-shop-sidebar-widget-area' )) {
        return true;
    }

    if( is_active_sidebar( 'auxin-pages-primary-sidebar-widget-area' ) ){
        return true;
    }

    return false;
}

/**
 * Check if secondary sidebar has content
 * 
 * @return bool
 */
function auxin_secondary_sidebar_has_content() {

    global $post;

    // if no result
    if( is_404() || empty( $post ) || is_search() ) {
        return false;
    }

    if( is_active_sidebar( 'auxin-global-secondary-sidebar-widget-area' ) ){
        return true;
    }

    $page_template_name = get_post_meta( $post->ID, '_wp_page_template', TRUE );
    if ( ( $post->post_type == 'post' || strpos( $page_template_name, 'blog' ) !== false ) && is_active_sidebar( 'auxin-blog-secondary-sidebar-widget-area' ) ) {
        if( is_active_sidebar( 'auxin-blog-secondary-sidebar-widget-area' ) ){
            return true;
        }
    }

    if( is_active_sidebar( 'auxin-pages-secondary-sidebar-widget-area' ) ){
        return true;
    }

    return false;
}



/**
 * Retrieve the ID of page sidebar
 *
 * @param  int|Object $page_id The page id or $post object
 * @return string              The the ID of page sidebar, empty string on failure
 */
function auxin_get_page_sidebar_id( $page_id ){
    $post = get_post( $page_id );

    $sidebar_id = isset( $post->ID ) ? get_post_meta( $post->ID, 'auxin_page_sidebar_id', true ) : '';

    return apply_filters( 'auxin_get_page_sidebar_id', $sidebar_id, $post );
}

/**
 * Check if page is woocommerce products archive page or not
 *
 * @return bool
 */
function auxin_is_wc_product_archive() {
    if ( class_exists('WooCommerce') ) {
        return is_shop() || is_tax( [ 'product_cat', 'product_tag' ] );
    }
    return false;
}

/**
 * Merge new css classes in current list
 *
 * @param  array        $classes   List of current classes
 * @param  string|array $class     One or more classes to add to the class list.
 *
 * @return                         Array of classes
 */
function auxin_merge_css_classes( $classes = array(), $class = '' ){

    if( empty( $classes ) && empty( $class ) )
        return array();

    if ( ! empty( $class ) ) {
        if ( !is_array( $class ) )
            $class = preg_split( '#\s+#', $class );

        $classes = array_merge( $class, $classes );
    }

    return $classes;
}

/**
 * Creates and returns an HTML class attribute
 *
 * @param  array        $classes   List of current classes
 * @param  string|array $class     One or more classes to add to the class list.
 *
 * @return string                  HTML class attribute
 */
function auxin_make_html_class_attribute( $classes = '', $class = '' ){

    if( ! $merged_classes = auxin_merge_css_classes( $classes, $class ) ){
        return '';
    }

    return 'class="' . esc_attr( trim( join( ' ', array_unique( $merged_classes ) ) ) ) . '"';
}

/**
 * Creates and returns attributes for a dom
 *
 * @param  array        $attrs   List of attributes and their values
 *
 * @return string                HTML attribute string
 */
function auxin_make_html_attributes( $attrs = array() ){

    if( ! is_array( $attrs ) ){
        auxin_error( sprintf( __( 'Input value for "%s" function should be array.', 'phlox-pro' ), __FUNCTION__ ) );
        return '';
    }

    $attributes_string = '';

    foreach ( $attrs as $attr => $value ) {
        $value = is_array( $value ) ? join( ' ', array_unique( $value ) ) : $value;
        $attributes_string .= sprintf( '%s="%s" ', $attr, esc_attr( trim( $value ) ) );
    }

    return $attributes_string;
}

/*-----------------------------------------------------------------------------------*/
/*  get featured image url (original images)
/*-----------------------------------------------------------------------------------*/

// get featured image url by attachment id
function auxin_get_attachment_url( $attach_id, $featured_img_size = "medium" ) {
    if( is_numeric( $attach_id ) ){
        if( $image_url = wp_get_attachment_image_src( $attach_id, $featured_img_size ) ){
            return $image_url[0];
        }
    }
    return '';
}

// get featured image url by post id
function auxin_get_the_attachment_url( $post_id, $img_size = "medium" ) {
    $post = get_post( $post_id );
    if( $post ){
        if( $image_url = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $img_size ) ){
            return $image_url[0];
        }
    }
    return null;
}

// get image caption by attachment id ////////////////////////////////////////////////

/**
 * Outputs the attachment caption content
 *
 * @param  string   $attach_id   The attachment id
 * @param  bool     $strip       Whether strip html tags or not
 */
function auxin_the_attachment_caption( $attach_id = null, $stripe = true ) {
    echo auxin_attachment_caption( $attach_id, $stripe );
}

/**
 * Returns the attachment caption content
 *
 * @param  string   $attach_id   The attachment id
 * @param  bool     $strip       Whether strip html tags or not
 * @return string   the attachment caption text
 */
function auxin_attachment_caption( $attach_id = null, $stripe = true ) {

    $attachment_post = get_post( $attach_id );

    if( empty( $attachment_post ) ){
        return '';
    }

    $caption = $attachment_post->post_excerpt;
    if ( empty( $caption ) )
        $caption = $attachment_post->post_title;
    if ( empty( $caption ) )
        $caption = get_post_meta( $attach_id, '_wp_attachment_image_alt', true );
    if ( $stripe ) {
        $caption = strip_tags( $caption );
    }

    return trim( $caption );
}

/**
 * The default WP image sizes
 *
 * @return array   the list of default image sizes
 */
function auxin_base_image_sizes(){
    return apply_filters( 'auxin_base_image_sizes', array('thumbnail', 'medium', 'medium_large', 'large') );
}

/*-----------------------------------------------------------------------------------*/
/*  Custom functions for resizing images
/*-----------------------------------------------------------------------------------*/

/**
 * Outputs resized image by image URL
 *
 * @param  string   $img_url  The original image URL
 * @param  integer  $width    New image Width
 * @param  integer  $height   New image height
 * @param  bool     $crop     Whether to crop image to specified height and width or resize. Default false (soft crop).
 * @param  integer  $quality  New image quality - a number between 0 and 100
 * @return string   new image src
 */
function auxin_the_resized_image( $img_url = "", $width = null , $height = null, $crop = null , $quality = 100, $attr = '', $upscale = false ) {
    echo auxin_get_the_resized_image( $img_url , $width , $height , $crop , $quality, $attr, $upscale );
}

        function auxin_get_the_resized_image( $img_url = "", $width = null , $height = null, $crop = null , $quality = 100, $attr = '', $upscale = false ) {

            $src = auxin_aq_resize( $img_url, $width, $height, $crop, $quality, true, $upscale );
            if( empty( $src ) ) return '';

            $html = '';

            $string_size = $width . 'x' . $height;
            $hwstring = image_hwstring( $width, $height );

            // default image attributes
            $default_attr = array(
                'src'   => $src,
                'class' => "auxin-resized-image auxin-image-$string_size"
            );

            $attr = wp_parse_args( $attr, $default_attr );

            /**
             * Filter the list of attachment image attributes.
             *
             * @param mixed $attr          Attributes for the image markup.
             * @param int   $attachment_id Image attachment ID.
             */
            $attr = apply_filters( 'auxin_get_resized_image_attributes', $attr, $img_url, $width, $height );
            $attr = array_map( 'esc_attr', $attr );
            $html = rtrim("<img $hwstring");
            foreach ( $attr as $name => $value ) {
                $html .= " $name=" . '"' . esc_attr( $value ) . '"';
            }
            $html .= ' />';

            return $html;
        }

        /**
         * Get resized image by image URL
         *
         * @param  string   $img_url  The original image URL
         * @param  integer  $width    New image Width
         * @param  integer  $height   New image height
         * @param  bool     $crop     Whether to crop image to specified height and width or resize. Default false (soft crop).
         * @param  integer  $quality  New image quality - a number between 0 and 100
         * @return string   new image src
         */
        if( ! function_exists( 'auxin_get_the_resized_image_src') ){

            function auxin_get_the_resized_image_src( $img_url = '', $width = null , $height = null, $crop = null , $quality = 100, $upscale = false ) {
                $resized_img_url = auxin_aq_resize( $img_url, $width, $height, $crop, $quality, true, $upscale );
                if( empty( $resized_img_url ) )
                    $resized_img_url = $img_url;
                return apply_filters('auxin_get_the_resized_image_src', $resized_img_url, $img_url);
            }

        }


// get resized image by attachment id ////////////////////////////////////////////////

/**
 * Outputs resized image by attachment id
 *
 * @param  string   $attach_id  The attachment id
 * @param  integer  $width    New image Width
 * @param  integer  $height   New image height
 * @param  bool     $crop     Whether to crop image to specified height and width or resize. Default false (soft crop).
 * @param  integer  $quality  New image quality - a number between 0 and 100
 * @return string   new image src
 */
function auxin_the_resized_attachment( $attach_id = null, $width = null , $height = null, $crop = null , $quality = 100, $attr = '', $upscale = false ) {
    echo auxin_get_the_resized_attachment( $attach_id, $width , $height, $crop, $quality, $attr, $upscale );
}

    // return resized image tag
    function auxin_get_the_resized_attachment( $attach_id = null, $width = null , $height = null, $crop = null , $quality = 100, $attr = '', $upscale = false ) {

        $html       = '';
        $size       = $width;
        $attachment = get_post( $attach_id );

        $image_meta = get_post_meta( $attach_id, '_wp_attachment_metadata', true );

        // if size is valid and defined
        if( ! is_numeric( $size ) ){
            $size_array = _wp_get_image_size_from_meta( $size, $image_meta );
            if( $size_array ){
                $width  = $size_array[0];
                $height = $size_array[1];
            }
        } else {
            $size = '';
            $size_array = array(
                absint( $width  ),
                absint( $height )
            );
        }

        $src = auxin_get_the_resized_attachment_src( $attach_id, $width , $height, $crop, $quality, $upscale );
        if( empty( $src ) ) return '';

        $srcset = wp_calculate_image_srcset( $size_array, $src, $image_meta, $attach_id );

        $string_size = $width . 'x' . $height;
        $hwstring    = image_hwstring( $width, $height );

        // default image attributes
        $default_attr = array(
            'src'              => $src,
            'class'            => "auxin-attachment attachment-$string_size",
            'alt'              => trim(strip_tags( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ) )), // Use Alt field first
            'width_attr_name'  => '',
            'height_attr_name' => '',
            'srcset'           => $srcset,
            'sizes'            => '33vw'
        );

        if ( empty( $default_attr['alt'] ) )
            $default_attr['alt'] = trim( strip_tags( $attachment->post_excerpt ) ); // If not, Use the Caption
        if ( empty( $default_attr['alt'] ) )
            $default_attr['alt'] = trim( strip_tags( $attachment->post_title   ) ); // Finally, use the title

        $attr = wp_parse_args( $attr, $default_attr );


        if( ! empty( $attr['width_attr_name'] ) || ! empty( $attr['height_attr_name'] ) )
            $metadata = wp_get_attachment_metadata( $attach_id );

        if( ! empty( $attr['width_attr_name'] ) )
            $attr[ $attr['width_attr_name'] ] = $metadata['width'];

        if( ! empty( $attr['height_attr_name'] ) )
            $attr[ $attr['height_attr_name'] ] = $metadata['height'];


        unset( $attr['width_attr_name' ] );
        unset( $attr['height_attr_name'] );

        if ( empty( $attr['srcset'] ) ) {
            unset( $attr['srcset'] );
            unset( $attr['sizes'] );
        }

        /**
         * Filter the list of attachment image attributes.
         *
         * @param mixed $attr          Attributes for the image markup.
         * @param int   $attach_id     Image attachment ID.
         */
        $attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment, $size_array );
        $attr = array_map( 'esc_attr', $attr );
        $html = rtrim("<img $hwstring");
        foreach ( $attr as $name => $value ) {
            $html .= " $name=" . '"' . esc_attr( $value ) . '"';
        }
        $html .= ' />';

        return $html;
    }

        /**
         * Get resized image src by attachment id
         *
         * @param  string   $attach_id  The attachment id
         * @param  integer  $width    New image Width
         * @param  integer  $height   New image height
         * @param  bool     $crop     Whether to crop image to specified height and width or resize. Default false (soft crop).
         * @param  integer  $quality  New image quality - a number between 0 and 100
         * @return string|array       A single or list of cropped image srcs
         */
        if( ! function_exists( 'auxin_get_the_resized_attachment_src' ) ){

            function auxin_get_the_resized_attachment_src( $attach_id = null, $width = null , $height = null, $crop = null , $quality = 100, $upscale = false ) {
                if( is_null( $attach_id ) ) return '';


                if( is_array( $attach_id ) ){
                    $srcs = array();

                    foreach ( $attach_id as $id ) {

                        if( wp_attachment_is( 'image', $id ) ){
                            $image_url   = wp_get_attachment_url( $id ); //get img URL
                            $srcs[ $id ] = $image_url ? auxin_aq_resize( $image_url, $width, $height, $crop, $quality, true, $upscale ) : '';
                        } elseif ( wp_attachment_is( 'audio', $id ) ){
                            $srcs[ $id ] = includes_url() . 'images/media/audio.png';
                        } elseif ( wp_attachment_is( 'video', $id ) ){
                            $srcs[ $id ] = includes_url() . 'images/media/video.png';
                        } elseif ( 0 === strpos( get_post_mime_type( $id ), 'text/' ) ){
                            $srcs[ $id ] = includes_url() . 'images/media/file.png';
                        }
                    }

                    return $srcs;
                }


                if( wp_attachment_is( 'image', $attach_id ) ){
                    $image_url = wp_get_attachment_url( $attach_id ); //get img URL
                    return $image_url ? auxin_aq_resize( $image_url, $width, $height, $crop, $quality, true, $upscale ) : false;
                } elseif ( wp_attachment_is( 'audio', $attach_id ) ){
                    return includes_url() . 'images/media/audio.png';
                } elseif ( wp_attachment_is( 'video', $attach_id ) ){
                    return includes_url() . 'images/media/video.png';
                } elseif ( 0 === strpos( get_post_mime_type( $attach_id ), 'text/' ) ){
                    return includes_url() . 'images/media/file.png';
                }

                return false;
            }


        }


// get resized image featured by post id //////////////////////////////////////////////


function auxin_generate_image_sizes( $image_sizes ){
    if( 'auto' === $image_sizes ){
        return $image_sizes;
    }

    $attr_sizes = '';
    foreach ( $image_sizes as $element_size ) {
        $attr_sizes .= ! empty( $element_size['min']  ) ? '(min-width:'. $element_size['min'] .') ' : '';
        $attr_sizes .= ! empty( $element_size['min']  ) && ! empty( $element_size['max']  ) ? 'and ' : '';
        $attr_sizes .= ! empty( $element_size['max']  ) ? '(max-width:'. $element_size['max'] .') ' : '';
        $attr_sizes .= ! empty( $element_size['width'] ) ? $element_size['width'] . ',' : ',';
    }
    return rtrim( $attr_sizes, ',' );
}


// echo resized image tag
function auxin_the_post_thumbnail( $post_id = null, $width = null , $height = null, $crop = null , $quality = 100, $upscale = false ) {
    echo auxin_get_the_post_thumbnail( $post_id, $width , $height, $crop, $quality, $upscale );
}

    /**
     * Retrieves the resized responsive image tag with custom srcset and sizes
     */
    function auxin_get_the_post_responsive_thumbnail( $post_id = null, $args = array() ) {

        if( ! $post = get_post( $post_id ) ){
            return;
        }
        if( ! $attachment_id = get_post_thumbnail_id( $post->ID ) ){
            return;
        }

        return auxin_get_the_responsive_attachment( $attachment_id, $args );
    }


    /**
     * Retrieves the resized attachment image custom srcset and sizes
     */
    function auxin_get_the_responsive_attachment( $attachment_id = null, $args = array() ) {

        $defaults = array(
            'quality'         => 100,
            'attr'            => '',
            'preloadable'     => true, // Set it to "true" or "null" in order make the image ready for preloading, "true" will load the best match as well.
            'preload_preview' => true, // (true, false, 'progress-box', 'simple-spinner', 'simple-spinner-light', 'simple-spinner-dark') if true, insert a low quality placeholder until lazyloading the main image. If set to progress, display a progress animation as a placeholder.
            'preload_bgcolor' => '',   // background color while loading the image
            'upscale'         => false,
            'size'            => 'large',
            'crop'            => null,
            'add_hw'          => true,
            'add_ratio'       => true,
            'sizes'           => 'auto', // (sizes)
            'srcset'          => 'auto', // (srcset) automatically calculate the image sizes based on the 'size' param, OR 'wp' generates image srcs based on WP default image sizes

            'original_src'    => true,
            'extra_class'     => ''
        );



        $args = wp_parse_args( $args, $defaults );

        // fallback for deprecated attributes
        if( isset( $args['image_sizes'] ) ){
            $args['sizes'] = $args['image_sizes'];
            unset( $args['image_sizes'] );
        }
        if( isset( $args['srcset_sizes'] ) ){
            $args['srcset'] = $args['srcset_sizes'];
            unset( $args['srcset_sizes'] );
        }

        extract( $args );

        // Throw error if $size is not defined
        if( empty( $size ) ){
            auxin_error( sprintf( '"size" option for "%s" function is not defined.', __FUNCTION__ ) );
        }

        $attachment  = get_post( $attachment_id );

        // get original image info
        $original_image       = wp_get_attachment_image_src( $attachment_id, 'full' );
        if( ! $original_image ){
            return '';
        }
        $original_image_width = $original_image['1'];

        // Check crop value
        $crop = empty( $crop ) ? $crop : auxin_is_true( $crop );

        // Make sure there is a valid $size value passed
        if( is_array( $size ) ){
            if( empty( $size['width'] ) && empty( $size['height'] ) ){
                $size = 'medium_large';
            }
            // since the size is a custom width and height, the hard crop is required
            if( is_null( $crop ) ){
                $crop = true;
            }
        }

        // Get the $size dimensions
        $dimensions = $size;
        if( in_array( $dimensions, array( 'full', 'original' ) ) ){
            $dimensions = array( 'width' => $original_image['1'], 'height' => $original_image['2'] );
            // prevent generating srcset if the original image size is requested
            $srcset = null;
            $sizes  = null;
        } elseif ( is_string( $dimensions ) ){
            $dimensions = auxin_wp_get_image_size( $dimensions );
            $dimensions = array( 'width' => $dimensions['width'], 'height' => $dimensions['height'] );
        }

        // calculate the image aspect ratio
        $image_aspect_ratio = empty( $dimensions['width'] ) || empty( $dimensions['height'] ) ? null : $dimensions['width']/$dimensions['height'];

        // if aspect ratio is available, turn on the upscale for improving accuracy in cropping images
        if( $image_aspect_ratio ){
            $upscale = true;
        }

        /*   Generate main image
        /*-------------------------------------*/
        // crop the main image
        if ( auxin_is_local_url( $original_image[0] ) && strpos( $original_image[0], '.gif' ) === false ) {
            if( is_string( $size ) ){
                $main_image = wp_get_attachment_image_src( $attachment_id, $size );
                if ( $size !== 'full' && empty( $main_image['3'] ) && in_array( $size, get_intermediate_image_sizes() ) ) {
                    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                    wp_update_image_subsizes( $attachment_id );
                    $main_image = wp_get_attachment_image_src( $attachment_id, $size );
                }
                $src = $main_image['0'];
            } else {
                $src = auxin_get_the_resized_attachment_src( $attachment_id, $dimensions['width'] , $dimensions['height'], $crop, $quality, $upscale );
            }
        } else {
            $src = $original_image[0];
        }


        if( empty( $src ) ) return '';

        // image width of default image src
        $default_image_width = $original_image_width > $dimensions['width'] ? $dimensions['width'] : $original_image_width;
        if ( empty( $default_image_width ) ) {
            return wp_get_attachment_image( $attachment_id, 'full' );
        }

        $default_image_width = round( $default_image_width );


        /*   Calculate SRCSET
        /*-------------------------------------*/
        $attr_srcset = '';

        if( ! empty( $srcset ) ){

            // generate src sizes based on the list of sizes
            if( is_array( $srcset ) ){

                foreach ( $srcset as $srcset_size ) {
                    // width is required for each src item
                    if( ! $srcset_size['width'] = empty( $srcset_size['width' ] ) ? null : $srcset_size['width' ] ){
                        continue;
                    }
                    // dont generate image src bigger than original image
                    if( $srcset_size['width'] >= $original_image_width ){
                        break;
                    }
                    $srcset_size['height'] = empty( $srcset_size['height'] ) ? null : $srcset_size['height'];

                    if ( empty( $srcset_image_url = auxin_get_the_resized_attachment_src( $attachment_id, $srcset_size['width'] , $srcset_size['height'], $crop, $quality, $upscale ) ) ) {
                        continue;
                    }
                    $attr_srcset .= $srcset_image_url;
                    $attr_srcset .= ' '. round( $srcset_size['width'] ).'w,';
                }

            // generate image sizes based on the default WordPress image sizes
            } elseif( 'wp' == $srcset || ( ( is_string( $size ) || empty( $image_aspect_ratio ) ) && 'auto' === $srcset ) ){
                $default_image_sizes = auxin_base_image_sizes();

                foreach ( $default_image_sizes as $image_size ) {
                    // Check if the image size is defined before
                    if( ! $current_image_dimensions = wp_get_attachment_image_src( $attachment_id, $image_size ) ){
                        auxin_error( sprintf( 'Intermediate image size name not found in "%s" function.', __FUNCTION__ ) );
                        continue;
                    }
                    // dont generate image src bigger than original image
                    if( $current_image_dimensions['1'] >= $original_image_width ){
                        break;
                    }

                    if( is_array( $size ) ){
                        if ( empty( $srcset_image_url = auxin_get_the_resized_attachment_src( $attachment_id, $current_image_dimensions['1'] , $current_image_dimensions['2'], $crop, $quality, $upscale ) ) ) {
                            continue;
                        }
                        $attr_srcset .= $srcset_image_url;
                        $attr_srcset .= ' '. round( $current_image_dimensions['1'] ).'w,';
                    } else {
                        $attr_srcset .=  $current_image_dimensions['0'];
                        $attr_srcset .= ' '. round( $current_image_dimensions['1'] ).'w,';
                    }

                }

            // automatically generate general image sizes based on the aspect ratio of the main image according the dimensions in $size
            } elseif( is_array( $size ) && 'auto' === $srcset && $image_aspect_ratio ){
                $default_image_sizes = auxin_base_image_sizes();

                foreach ( $default_image_sizes as $image_size ) {
                    $current_image_width = get_option( $image_size. '_size_w' );

                    // dont generate image src bigger than original image
                    if( $current_image_width >= $original_image_width ){
                        break;
                    }
                    if ( empty( $srcset_image_url = auxin_get_the_resized_attachment_src( $attachment_id, $current_image_width, $current_image_width/$image_aspect_ratio, $crop, $quality, $upscale ) ) ) {
                        continue;
                    }
                    $attr_srcset .= $srcset_image_url;
                    $attr_srcset .= ' '. round( $current_image_width ).'w,';
                }
            }


            // Add the original image src if the original size greater that large size exists
            if( $attr_srcset ){

                // Add main image to srcset too
                $attr_srcset .= $src . ' ' . $default_image_width . 'w,';

                if( $original_src ){
                    if( $image_aspect_ratio ){
                        $full_width  = (int) ( $original_image[1] -10 );
                        $full_height = (int) ($full_width/$image_aspect_ratio);
                        $attr_srcset .= auxin_get_the_resized_attachment_src( $attachment_id, $full_width, $full_height, true, $quality, true );
                        $attr_srcset .= ' ' . round( $full_width ) . 'w';
                    } else {
                        $attr_srcset .= $original_image[0] . ' ' . $original_image[1] . 'w';
                    }
                }

                $attr_srcset =  rtrim( $attr_srcset, ',' );
            }

        }

        /*   Add essential attribute
        /*-------------------------------------*/

        // Check preloadable value
        $preloadable = empty( $preloadable ) ? $preloadable : auxin_is_true( $preloadable );

        // Force to add width and height attributes if lazyloading is enabled
        if( $preloadable && $preload_preview ){
            $add_hw = true;
        }

        $html = '';
        $width_attribute  = $original_image['1'] < $dimensions['width' ] ? $original_image['1'] : $dimensions['width'];
        $height_attribute = $original_image['2'] < $dimensions['height'] ? $original_image['2'] : $dimensions['height'];
        $string_size      = $width_attribute . 'x' . $height_attribute;
        $hwstring         = $add_hw ? image_hwstring( $width_attribute, $height_attribute ) : '';

        // default image attributes
        $default_attr  = array(
            'src'              => $src,
            'class'            => "aux-attachment aux-featured-image attachment-$string_size aux-attachment-id-$attachment_id $extra_class",
            'alt'              => trim(strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) )), // Use Alt field first
            'width_attr_name'  => '',
            'height_attr_name' => ''
        );

        if ( empty( $default_attr['alt'] ) )
            $default_attr['alt'] = trim( strip_tags( $attachment->post_excerpt ) ); // If not, Use the Caption
        if ( empty( $default_attr['alt'] ) )
            $default_attr['alt'] = trim( strip_tags( $attachment->post_title ) ); // Finally, use the title

        // parse the attr
        $attr = wp_parse_args( $attr, $default_attr );

        // Generate 'srcset' and 'sizes' if not already present.
        if ( empty( $attr['srcset'] ) ) {
            if ( $attr_srcset ) {
                $attr['srcset'] = $attr_srcset;
            }
        }

        if( $image_aspect_ratio ){
            $attr['data-ratio'] = round( $image_aspect_ratio, 2 );
        }

        $attr['data-original-w'] = $original_image_width;

        if( ! empty( $attr['width_attr_name'] ) || ! empty( $attr['height_attr_name'] ) )
            $metadata = wp_get_attachment_metadata( $attachment_id );

        if( ! empty( $attr['width_attr_name'] ) )
            $attr[ $attr['width_attr_name'] ] = $metadata['width'];

        if( ! empty( $attr['height_attr_name'] ) )
            $attr[ $attr['height_attr_name'] ] = $metadata['height'];


        /*   Calculate sizes
        /*-------------------------------------*/
        if( ! empty( $sizes ) ){
            $attr_sizes  = auxin_generate_image_sizes( $sizes );

            if ( empty( $attr['sizes'] ) && $attr_sizes ) {
                $attr['sizes'] = $attr_sizes;
            }
        }

        // Keep the auto sizes if null passed to $preloadable
        if( is_null( $preloadable ) && 'auto' === $sizes ){

            // move srcset to data-srcset
            if ( ! empty( $attr['srcset'] ) ) {
                $attr['data-srcset'] = $attr['srcset'];
                unset( $attr['srcset'] );
            }

            if ( ! empty( $attr['src'] ) ) {
                $attr['data-src'] = $attr['src'];
                unset( $attr['src'] );
            }

            $attr['sizes']  = 'auto';

        } elseif( $preloadable && 'auto' === $sizes ){

            // move srcset to data-srcset
            if ( ! empty( $attr['srcset'] ) ) {
                $attr['data-srcset'] = $attr['srcset'];
                unset( $attr['srcset'] );
            }

            $attr['sizes']  = 'auto';

        } elseif( ! $preloadable && 'auto' === $sizes ) {
            $auto_sizes = array(
                array( 'min' => '', 'max' => '479px' , 'width' => '480px'  ),
                array( 'min' => '', 'max' => '767px' , 'width' => '768px'  ),
                array( 'min' => '', 'max' => '1023px', 'width' => '1024px' )
            );
            if( $dimensions['width'] ){
                $auto_sizes[] = array( 'min' => '', 'max' => '', 'width' => $default_image_width . 'px' );
            }
            $attr['sizes']  = auxin_generate_image_sizes( $auto_sizes );
        }

        // Display a blurred preview of the main image
        if ( $preloadable ) {
            // add the required class name to make it visible to image size-calculation script
            $attr['class'] .= ' aux-preload';

            if ( ! empty( $attr['src'] ) && empty( $attr['srcset'] ) ) {
                $attr['data-src'] = $attr['src'];
            }

            $attr['src'] = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';

            if( in_array( $preload_preview, array( 'progress-box', 'simple-spinner', 'simple-spinner-light', 'simple-spinner-dark' ) ) ){
                $attr['class'] .= ' aux-' . esc_attr( $preload_preview ); // the class name to add style and transition to the progress animation
            } elseif( auxin_is_true( $preload_preview ) ){
                $preload_ratio = null === $image_aspect_ratio ? null : 40 / $image_aspect_ratio;
                $attr['src'] = auxin_get_the_resized_attachment_src( $attachment_id, 40 , $preload_ratio, $crop, 100, false );
                $attr['class'] .= ' aux-has-preview'; // the class name to add style and transition to the preview image
            } else {
                $attr['class'] .= ' aux-blank';
            }

            if( ! empty( $preload_bgcolor ) ){
                $attr['data-bg-color'] = $preload_bgcolor;
            }

        }

        unset( $attr['width_attr_name' ] );
        unset( $attr['height_attr_name'] );


        /**
         * Filter the list of attachment image attributes.
         *
         * @param mixed $attr          Attributes for the image markup.
         * @param int   $attachment_id Image attachment ID.
         */
        $attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment, $size );
        $attr = array_map( 'esc_attr', $attr );
        $html = rtrim("<img $hwstring");
        foreach ( $attr as $name => $value ) {
            if( $value ){
                $html .= " $name=" . '"' . $value . '"';
            }
        }
        $html .= ' />';

        return $html;
    }






    // return resized image tag
    function auxin_get_the_post_thumbnail( $post_id = null, $width = null , $height = null, $crop = null , $quality = 100, $attr = '', $upscale = false ) {
        $src = auxin_get_the_post_thumbnail_src( $post_id, $width , $height, $crop, $quality, $upscale );
        if( empty( $src ) ) return '';

        $html = '';
        $attachment_id = get_post_thumbnail_id( $post_id );
        $attachment    = get_post( $attachment_id );

        $string_size   = $width . 'x' . $height;
        $hwstring      = image_hwstring( $width, $height );

        // default image attributes
        $default_attr = array(
            'src'              => $src,
            'class'            => "auxin-attachment auxin-featured-image attachment-$string_size",
            'alt'              => trim(strip_tags( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) )), // Use Alt field first
            'width_attr_name'  => '',
            'height_attr_name' => ''
        );

        if ( empty( $default_attr['alt'] ) )
            $default_attr['alt'] = trim( strip_tags( $attachment->post_excerpt ) ); // If not, Use the Caption
        if ( empty( $default_attr['alt'] ) )
            $default_attr['alt'] = trim( strip_tags( $attachment->post_title   ) ); // Finally, use the title


        $attr = wp_parse_args( $attr, $default_attr );


        if( ! empty( $attr['width_attr_name'] ) || ! empty( $attr['height_attr_name'] ) )
            $metadata = wp_get_attachment_metadata( $attachment_id );

        if( ! empty( $attr['width_attr_name'] ) )
            $attr[ $attr['width_attr_name'] ] = $metadata['width'];

        if( ! empty( $attr['height_attr_name'] ) )
            $attr[ $attr['height_attr_name'] ] = $metadata['height'];


        unset( $attr['width_attr_name' ] );
        unset( $attr['height_attr_name'] );


        /**
         * Filter the list of attachment image attributes.
         *
         * @param mixed $attr          Attributes for the image markup.
         * @param int   $attachment_id Image attachment ID.
         */
        $attr = apply_filters( 'wp_get_attachment_image_attributes', $attr, $attachment, array( $width, $height ) );
        $attr = array_map( 'esc_attr', $attr );
        $html = rtrim("<img $hwstring");
        foreach ( $attr as $name => $value ) {
            $html .= " $name=" . '"' . esc_attr( $value ) . '"';
        }
        $html .= ' />';

        return $html;
    }

        /**
         * Get resized image by post id
         *
         * @param  string   $post_id  The post id
         * @param  integer  $width    New image Width
         * @param  integer  $height   New image height
         * @param  bool     $crop     Whether to crop image to specified height and width or resize. Default false (soft crop).
         * @param  integer  $quality  New image quality - a number between 0 and 100
         * @return string   new image src
         */
        if( ! function_exists("auxin_get_the_post_thumbnail_src") ){

            function auxin_get_the_post_thumbnail_src( $post_id = null, $width = null , $height = null, $crop = null , $quality = 100, $upscale = false ) {
                $post_id = is_null( $post_id ) ? get_the_ID() : $post_id;
                $post_thumbnail_id = get_post_thumbnail_id( $post_id );

                $img_url = wp_get_attachment_url( $post_thumbnail_id ,'full' ); //get img URL

                $resized_img = $post_thumbnail_id ? auxin_aq_resize( $img_url, (int)$width, (int)$height, $crop, $quality, true, $upscale ) : false;
                return apply_filters( 'auxin_get_the_post_thumbnail_src', $resized_img, $img_url, $width, $height, $crop, $quality );
            }

        }

        /**
         * Get full URI of an featured image for a post id
         *
         * @param  integer $post_id  The post id to get featured image of
         * @return string  Returns a full URI for featured image or false on failure.
         */
        if( ! function_exists( 'auxin_get_the_post_thumbnail_full_src' ) ){

            function auxin_get_the_post_thumbnail_full_src( $post_id = null ) {
                $post_id = is_null( $post_id ) ? get_the_ID() : $post_id;
                $post_thumbnail_id = get_post_thumbnail_id( $post_id );

                return wp_get_attachment_url( $post_thumbnail_id, 'full' );
            }

        }


    /**
     * Returns a cropped post image (featured image or first image in content) from a post id
     *
     * @param  integer $post_id      The post id to get post image of
     * @param  string  $image_from   where to look for post image. possible values are : auto, featured, first. Default to 'auto'
     * @param  integer  $width       New image Width
     * @param  integer  $height      New image height
     * @param  bool     $crop        Whether to crop image to specified height and width or resize. Default false (soft crop).
     * @param  integer  $quality     New image quality - a number between 0 and 100
     *
     * @return string  Returns a  image tag or empty string on failure.
     */
    if( ! function_exists( 'auxin_get_auto_post_thumbnail' ) ){

        function auxin_get_auto_post_thumbnail( $post_id = null, $image_from = 'auto', $width = null , $height = null, $crop = null , $quality = 100, $upscale = false ) {

            $post = get_post( $post_id );
            $image_src = auxin_get_auto_post_thumbnail_src( $post->ID, $image_from );
            $image_src  = $image_src ? auxin_aq_resize( $image_src, $width, $height, $crop, $quality, true, $upscale ) : false;

            return $image_src ? '<img src="'.esc_url( $image_src ).'" alt="'.esc_attr( $post->post_title ).'" />' : '';
        }

    }

        /**
         * Get full URI of a post image (featured image or first image in content) for a post id
         *
         * @param  integer $post_id  The post id to get post image of
         * @param  string  $image_from   where to look for post image. possible values are : auto, featured, first. Default to 'auto'
         *
         * @return string  Returns a full URI for post image or empty string on failure.
         */
        if( ! function_exists( 'auxin_get_auto_post_thumbnail_src' ) ){

            function auxin_get_auto_post_thumbnail_src( $post_id = null, $image_from = 'auto' ) {

                $post = get_post( $post_id );
                $img_src = '';

                if( empty( $post ) ) return '';

                if ( 'auto' == $image_from ) {
                    $img_src = has_post_thumbnail( $post->ID ) ? auxin_get_the_post_thumbnail_full_src( $post->ID ) : '';

                    if( empty( $img_src ) ) {
                        $img_src = auxin_get_first_image_src_from_string( $post->post_content );
                    }

                } elseif( 'featured' == $image_from ) {
                    $img_src = has_post_thumbnail( $post->ID ) ? auxin_get_the_post_thumbnail_full_src( $post->ID ) : '';

                } elseif ( 'first' == $image_from ) {
                    $img_src = auxin_get_first_image_src_from_string( $post->post_content );
                }

                return $img_src;
            }

        }

// get list of resized images by attachment list id //////////////////////////////////////////////

// return resized image tag
function auxin_get_the_resized_attachments_list( $post_id, $attachment_meta_key = null, $width = null , $height = null, $crop = null , $quality = 100, $attr = '' ) {

    if( ! $post_id ){
        return array();
    }

    $attach_ids_str = get_post_meta( $post_id, $attachment_meta_key, true );
    return auxin_get_the_resized_images_by_attach_ids( $attach_ids_str, $width, $height, $crop, $quality, $attr );
}


    function auxin_get_the_resized_images_by_attach_ids( $attachment_ids, $width = null , $height = null, $crop = null , $quality = 100, $attr = '' ) {
        $image_tag_list = array();

        $attachment_ids  = ! is_array( $attachment_ids ) ? explode( ',', $attachment_ids ) : $attachment_ids;

        foreach ( $attachment_ids as $attach_id ) {

            $src = auxin_get_the_resized_attachment_src( $attach_id, $width , $height, $crop, $quality );
            if( empty( $src ) ) return '';

            $html = '';
            $attachment = get_post( $attach_id );

            $string_size = $width . 'x' . $height;
            $hwstring = image_hwstring( $width, $height );

            $size       = $width;
            $image_meta = get_post_meta( $attach_id, '_wp_attachment_metadata', true );

            // if size is valid and defined
            if( ! is_numeric( $size ) ){
                $size_array = _wp_get_image_size_from_meta( $size, $image_meta );
                if( $size_array ){
                    $width  = $size_array[0];
                    $height = $size_array[1];
                }
            } else {
                $size = '';
                $size_array = array(
                    absint( $width  ),
                    absint( $height )
                );
            }

            // default image attributes
            $default_attr = array(
                'src'   => $src,
                'class' => "auxin-attachment attachment-$string_size",
                'alt'   => trim(strip_tags( get_post_meta( $attach_id, '_wp_attachment_image_alt', true ) )), // Use Alt field first
            );

            if ( empty( $default_attr['alt'] ) )
                $default_attr['alt'] = trim( strip_tags( $attachment->post_excerpt ) ); // If not, Use the Caption
            if ( empty( $default_attr['alt'] ) )
                $default_attr['alt'] = trim( strip_tags( $attachment->post_title   ) ); // Finally, use the title

            $img_attr = wp_parse_args( $attr, $default_attr );

            /**
             * Filter the list of attachment image attributes.
             *
             * @param mixed $attr          Attributes for the image markup.
             * @param int   $attach_id     Image attachment ID.
             */
            $img_attr = apply_filters( 'wp_get_attachment_image_attributes', $img_attr, $attachment, $size_array );
            $img_attr = array_map( 'esc_attr', $img_attr );
            $html = rtrim("<img $hwstring");
            foreach ( $img_attr as $name => $value ) {
                $html .= " $name=" . '"' . esc_attr( $value ) . '"';
            }
            $html .= ' />';

            $image_tag_list[ $attach_id ] = $html;
        }

        return $image_tag_list;
    }


    /**
     * Get resized image src by attachment id
     *
     * @param  string   $attach_id  The attachment id
     * @param  integer  $width    New image Width
     * @param  integer  $height   New image height
     * @param  bool     $crop     Whether to crop image to specified height and width or resize. Default false (soft crop).
     * @param  integer  $quality  New image quality - a number between 0 and 100
     * @return string   new image src
     */
    if( ! function_exists( 'auxin_get_the_resized_attachments_src_list' ) ){

        function auxin_get_the_resized_attachments_src_list( $post_id, $attachment_meta_key = null, $width = null , $height = null, $crop = null , $quality = 100, $upscale = false ) {

            $img_list = array();

            if( ! $post_id ){
                return $list;
            }

            $attach_ids_str = get_post_meta( $post_id, $attachment_meta_key, true );
            $attach_ids     = explode( ',', $attach_ids_str );

            foreach ( $attach_ids as $attach_id ) {

                $img_url    = wp_get_attachment_url( $attach_id ,'full' ); //get img URL
                $img_list[] = $img_url ? auxin_aq_resize( $img_url, $width, $height, $crop, $quality, true, $upscale ) : false;
            }
        }

    }


//// returns the number of active columns in subfooter  ////////////////////////////////


/**
 * Retrieves the width of each column when inserted fully in page
 *
 * @param  int     $col_num The number of column in one row
 * @param  int     $gutter  The spaces between the columns
 *
 * @return int              Width of each column in pixel
 */
function auxin_get_content_column_width( $col_num, $gutter = 15, $aux_content_width = '' ){
    if(  empty( $aux_content_width ) || ! is_numeric( $aux_content_width ) ) {
        global $aux_content_width;
    }

    $gutter =  !empty( $gutter ) ? $gutter : 0 ;
    return  ( $aux_content_width / $col_num ) - 2 * $gutter;
}


//// validate the variable as boolean  /////////////////////////////////////////

if( ! function_exists('auxin_is_true') ){

    function auxin_is_true( $var ) {
        if ( is_bool( $var ) ) {
            return $var;
        }

        if ( is_string( $var ) ){
            $var = strtolower( $var );
            if( in_array( $var, array( 'yes', 'on', 'true', 'checked' ) ) ){
                return true;
            }
        }

        if ( is_numeric( $var ) ) {
            return (bool) $var;
        }

        return false;
    }

}

///// extract image from content ///////////////////////////////////////////////

/**
 * Get first image tag from string
 *
 * @param  string $content  The content to extract image from
 * @return string           First image tag on success and empty string if nothing found
 */
function auxin_get_first_image_from_string( $content ){
    $images = auxin_extract_string_images( $content );
    return ( $images && count( $images[0]) ) ? $images[0][0] : '';
}

/**
 * Get first image src from content
 *
 * @param  string $content  The content to extract image from
 * @return string           First image URL on success and empty string if nothing found
 */
function auxin_get_first_image_src_from_string( $content ){
    $images = auxin_extract_string_images( $content );
    return ( $images && count( $images[1]) ) ? $images[1][0] : '';
}

    /**
     * Extract all images from content
     *
     * @param  string $content   The content to extract images from
     * @return array             List of images in array
     */
    if( ! function_exists( 'auxin_extract_string_images' ) ){

        function auxin_extract_string_images( $content ){
            preg_match_all( '|<img.*?src=[\'"](.*?)[\'"].*?>|i', $content, $matches );
            return isset( $matches ) && count( $matches[0] ) ? $matches : false;
        }

    }


/**
 * Creates and stores content in a file (#admin)
 *
 * @param  string $content    The content for writing in the file
 * @param  string $file_name  The name of the file that we plan to store the content in. Default value is 'customfile'
 * @param  string $file_dir   The directory that we plan to store the file in. Default dir is wp-contents/uploads/{THEME_ID}
 *
 * @return boolean            Returns true if the file is created and updated successfully, false on failure
 */
function auxin_put_contents_dir( $content, $file_name = '', $file_dir = null, $chmode = 0644 ){

    // Check if the fucntion for writing the files is enabled
    if( ! function_exists('auxin_put_contents') ){
        return false;
    }

    if( is_null( $file_dir ) ){
        $file_dir  = THEME_CUSTOM_DIR;
    }
    $file_dir = trailingslashit( $file_dir );


    if( empty( $file_name ) ){
        $file_name = 'customfile';
    }

    $file_location = $file_dir . $file_name;

    return auxin_put_contents( $content, $file_location, $chmode );
}

/*-----------------------------------------------------------------------------------*/
/*  breadcrumb functions
/*-----------------------------------------------------------------------------------*/

if( ! function_exists( 'auxin_the_breadcrumbs' ) ){

    function auxin_the_breadcrumbs( $home_icon = '' ,$sep_icon = '' ) {
        $breadcrumb = new Auxin_Breadcrumb();
        $breadcrumb->set_separator_icon( $sep_icon );
        $breadcrumb->home_icon = $home_icon;
        $breadcrumb->render();
    }

}

/*-----------------------------------------------------------------------------------*/
/*  Returns alternative for post type names if user defined custom name in option panel
/*-----------------------------------------------------------------------------------*/

if( ! function_exists( 'auxin_get_the_post_type_user_defined_name' ) ){

    function auxin_get_the_post_type_user_defined_name( $post_type = '' ){
        $post_type      = empty( $post_type ) ? get_post_type() : $post_type;
        $post_type_obj  = get_post_type_object( $post_type );
        $menu_name = is_object( $post_type_obj ) ? $post_type_obj->labels->menu_name : '';
        
        return auxin_get_option( $post_type.'_archive_breadcrumb_label', $menu_name );
    }

}

/*-----------------------------------------------------------------------------------*/
/*  Generate and returns proper styles for background option fields
/*-----------------------------------------------------------------------------------*/

/**
 * Generate and returns proper styles for background option fields
 *
 * @param  string $field_prefix The prefix name for background id of the fields.
 * @param  string $field_type   Specifies the type of fields. 'option' if background fields are options, 'metafield' if they are post meta fields.
 * @param  array  $field_names  The id of different corresponding background options
 * @return string               The generated style for background option fields
 */
function auxin_generate_styles_for_backgroud_fields( $field_prefix, $field_type = 'option', $field_names = array(), $field_suffixs = array() ){

    global $post;


    if( 'option' !== $field_type ){
        $post = get_post( $post );
        if( empty( $post ) ){
            return '';
        }
    }

    $styles = '';

    if( empty( $field_names ) ){
        $field_names = array(
            'color'     => $field_prefix . '_color',
            'pattern'   => $field_prefix . '_pattern',
            'image'     => $field_prefix . '_image',
            'repeat'    => $field_prefix . '_repeat',
            'size'      => $field_prefix . '_size',
            'position'  => $field_prefix . '_position',
            'attach'    => $field_prefix . '_attach',
            'clip'      => $field_prefix . '_clip'
        );
    }

    if( empty( $field_suffixs ) ){
        $field_suffixs = array(
            'color'     => '',
            'image'     => '',
            'repeat'    => '',
            'size'      => '',
            'position'  => '',
            'attach'    => '',
            'clip'      => ''
        );
    }

    $background_images = '';

    foreach ( $field_names as $field_key => $field_id ) {
        if( 'option' == $field_type ){
            $field_value = auxin_get_option( $field_id );
        } else {
            $field_value = get_post_meta( $post->ID, $field_id, true );
        }

        if( empty( $field_value ) ){
            continue;
        }

        switch ( $field_key ) {
            case 'color':
                $styles .= "background-color:". $field_value .' '. ( ! empty( $field_suffixs[ $field_key ] ) ? $field_suffixs[ $field_key ] : '' ) . "; ";
                break;

            case 'image':
                $field_value = is_numeric( $field_value ) ? wp_get_attachment_url( $field_value ) : $field_value;
                if( ! empty( $background_images ) )
                    $background_images .= ', ';

                $background_images .= "url(". esc_url( $field_value ) .') ';
                break;

            case 'pattern':
                $field_value = is_numeric( $field_value ) ? wp_get_attachment_url( $field_value ) : $field_value;
                if( ! empty( $background_images ) )
                    $background_images .= ', ';

                $background_images .= "url(". esc_url( $field_value ) .') ';

                break;

            case 'repeat':
                $styles .= "background-repeat:". $field_value .' '. ( ! empty( $field_suffixs[ $field_key ] ) ? $field_suffixs[ $field_key ] : '' ) . "; ";
                break;

            case 'position':
                $styles .= "background-position:". $field_value .' '. ( ! empty( $field_suffixs[ $field_key ] ) ? $field_suffixs[ $field_key ] : '' ) . "; ";
                break;

            case 'attach':
                $styles .= "background-attachment:". $field_value .' '. ( ! empty( $field_suffixs[ $field_key ] ) ? $field_suffixs[ $field_key ] : '' ) . "; ";
                break;

            case 'size':
                $styles .= "background-size:". $field_value .' '. ( ! empty( $field_suffixs[ $field_key ] ) ? $field_suffixs[ $field_key ] : '' ) . "; ";
                break;

            case 'clip':
                $styles .= "background-clip:". $field_value .' '. ( ! empty( $field_suffixs[ $field_key ] ) ? $field_suffixs[ $field_key ] : '' ) . "; ";
                break;
        }
    }

    if( ! empty( $background_images ) ){
        $styles .= "background-image:" . $background_images . ( ! empty( $field_suffixs[ 'image' ] ) ? $field_suffixs[ 'image' ] : '' ) . "; ";
    }

    return esc_attr( $styles );
}

/*-----------------------------------------------------------------------------------*/
/*  Ensures a string is a valid SQL order clause.
/*-----------------------------------------------------------------------------------*/

if( ! function_exists( 'auxin_sanitize_sql_order' ) ){

    function auxin_sanitize_sql_order( $order ){
        return 'asc' === strtolower( $order ) ? 'ASC' : 'DESC';
    }

}

/*-----------------------------------------------------------------------------------*/
/*  Disk transient functions
/*-----------------------------------------------------------------------------------*/

/**
 * Set/update the value of a transient.
 *
 * You do not need to serialize values. If the value needs to be serialized, then
 * it will be serialized before it is set.
 *
 *
 * @param string $transient  Transient name. Expected to not be SQL-escaped. Must be
 *                           172 characters or fewer in length.
 * @param mixed  $value      Transient value. Must be serializable if non-scalar.
 *                           Expected to not be SQL-escaped.
 * @param int    $expiration Optional. Time until expiration in seconds. Default 0 (no expiration).
 * @return bool False if value was not set and true if value was set.
 */
function auxin_set_transient( $transient, $value, $expiration = 0 ) {
    global $_wp_using_ext_object_cache;

    $current_using_cache = $_wp_using_ext_object_cache;
    $_wp_using_ext_object_cache = false;

    $result = set_transient( $transient, $value, $expiration );

    $_wp_using_ext_object_cache = $current_using_cache;

    return $result;
}


/**
 * Get the value of a transient.
 *
 * If the transient does not exist, does not have a value, or has expired,
 * then the return value will be false.
 *
 * @param string $transient Transient name. Expected to not be SQL-escaped.
 * @return mixed Value of transient.
 */
function auxin_get_transient( $transient ) {
    global $_wp_using_ext_object_cache;

    $current_using_cache = $_wp_using_ext_object_cache;
    $_wp_using_ext_object_cache = false;

    $result = get_transient( $transient );

    $_wp_using_ext_object_cache = $current_using_cache;

    return $result;
}


/**
 * Delete a transient.
 *
 * @param string $transient Transient name. Expected to not be SQL-escaped.
 * @return bool true if successful, false otherwise
 */
function auxin_delete_transient( $transient ) {
    global $_wp_using_ext_object_cache;

    $current_using_cache = $_wp_using_ext_object_cache;
    $_wp_using_ext_object_cache = false;

    $result = delete_transient( $transient );

    $_wp_using_ext_object_cache = $current_using_cache;

    return $result;
}

/*-----------------------------------------------------------------------------------*/
/*  Triggers a user error if WP_DEBUG is true.
/*-----------------------------------------------------------------------------------*/

if( ! function_exists( 'auxin_error' ) ){

    function auxin_error( $error ){
        if ( WP_DEBUG && apply_filters( 'auxin_trigger_error_message', true ) ) {
            trigger_error( $error );
        }
    }

}

/*-----------------------------------------------------------------------------------*/
/*  Checks whether the current theme version is Pro or not
/*-----------------------------------------------------------------------------------*/

function auxin_is_pro(){
    return defined('THEME_PRO') && THEME_PRO;
}

/*-----------------------------------------------------------------------------------*/
/*  get the_content value with passing the data through the_content filter
/*-----------------------------------------------------------------------------------*/

if( ! function_exists( 'auxin_get_the_content' ) ){

    /**
     * Display the post content.
     *
     * @param string $more_link_text Optional. Content for when there is more text.
     * @param bool   $strip_teaser   Optional. Strip teaser content before the more text. Default is false.
     */
    function auxin_get_the_content( $more_link_text = null, $strip_teaser = false) {
        $content = get_the_content( $more_link_text, $strip_teaser );

        /**
         * Filters the post content.
         *
         * @since 0.71
         *
         * @param string $content Content of the current post.
         */
        $content = apply_filters( 'the_content', $content );
        return  str_replace( ']]>', ']]&gt;', $content );
    }

}

/*-----------------------------------------------------------------------------------*/
/*  A function to print array or objects nicely!
/*-----------------------------------------------------------------------------------*/
/**
 * Retrieves the list of socials for site or an specific part of website
 *
 * @param  string  $type           the name of social list. Pass 'site', if you want
 *                                 to get the main socials of the website
 * @param  boolean $include_values True, to include the address of the socials in
 *                                 result; false, to return the name of socials
 *
 * @return array                   The list socials for an specific type
 */
function auxin_get_social_list( $type = 'site', $include_values = false ) {

    $socials_dictionary = array();

    $socials_dictionary['site'] = array(
        'facebook'    => '', 'twitter'     => '',
        'googleplus'  => '', 'dribbble'    => '',
        'youtube'     => '', 'vimeo'       => '',
        'flickr'      => '', 'digg'        => '',
        'stumbleupon' => '', 'lastfm'      => '',
        'delicious'   => '', 'skype'       => '',
        'linkedin'    => '', 'tumblr'      => '',
        'pinterest'   => '', 'instagram'   => '',
        'vk'          => '', 'telegram'    => '',
        'rss'         => ''
    );

    if( ! isset( $socials_dictionary[ $type ] ) ){
        $socials_dictionary[ $type ] = array();
    }

    // whether to fill the values with social address or not
    if( $include_values ){
        foreach ( $socials_dictionary[ $type ] as $name => $value ) {

            $url = auxin_get_option( $name );

            if ( parse_url( $url ,PHP_URL_HOST) ){
                $socials_dictionary[ $type ][ $name ] = esc_url( auxin_get_option( $name ) );
            }

        }

    }
    return apply_filters( 'auxin_get_social_list', $socials_dictionary[ $type ], $type, $include_values );
}


/*-----------------------------------------------------------------------------------*/
/*  A function to generate metabox/metabox_hub for post types
/*-----------------------------------------------------------------------------------*/

function auxin_maybe_render_metabox_hub_for_post_type( $args ){

    if( empty( $args ) ){
        return;
    }

    $defaults = array(
        'post_type'     => 'post',             // the main post type that we intend to implement the metabox for
        'hub_id'        => uniqid('aux_hub_'), // a unique id for metabox
        'hub_title'     => '',                 // title of the metabox
        'to_post_types' => array()             // the post types that we want to add the metabox to
    );

    $args = wp_parse_args( $args, $defaults );
    // make sure to pass array for to_post_types param
    $args['to_post_types'] = (array) $args['to_post_types'];

    $models = apply_filters( 'auxin_admin_metabox_models', array(), $args['post_type'], $args['hub_id'], $args );

    $models = apply_filters( "auxin_admin_metabox_models_{$args['post_type']}", $models, $args['post_type'], $args['hub_id'], $args );

    if( ! empty( $models ) ){

        // if there is just one model, you can pass the Auxin_Metabox as $models
        if( $models instanceof Auxin_Metabox ){
            $models->render();

        }  elseif( is_array( $models ) ){
            $hub_models = array();

            foreach ( $models as $model ) {

                // the model can be a function name which will return a Auxin_Metabox_Model instance
                if( is_string( $model ) ){
                    if( function_exists( $model ) ){
                        $model = call_user_func( $model );
                    } else {
                        echo auxin_error( sprintf( __( 'The function name "%s" not found for Metabox hub "%s".', 'phlox-pro' ), $model, $args['hub_id'] ) );
                    }
                }

                if( $model instanceof Auxin_Metabox ){
                    $model->render();
                } elseif( $model['model'] instanceof Auxin_Metabox ){
                    $model['model']->render();
                } elseif( $model instanceof Auxin_Metabox_Model ){
                    $hub_models[] = array( 'model' => $model, 'priority' => '10');
                } elseif( $model['model'] instanceof Auxin_Metabox_Model ){
                    $hub_models[] = $model;
                }

            }

            if( ! empty( $hub_models ) ){
                // Create Metabox hub instance
                $metabox_hub        = new Auxin_Metabox_Hub();
                $metabox_hub->id    = $args['hub_id'];
                $metabox_hub->title = $args['hub_title'];
                $metabox_hub->type  = $args['to_post_types'];

                $metabox_hub->add_models( $hub_models );
                $metabox_hub->maybe_render();
            }

        }

    }

}

/*-----------------------------------------------------------------------------------*/
/*  A function to insert latest post slider
/*-----------------------------------------------------------------------------------*/

if ( ! function_exists( 'auxin_get_latest_posts_slider' ) ) {

    function auxin_get_latest_posts_slider ( $options = array() ) {

        if( ! function_exists( 'AUXELS' ) ){
            return;
        }

        $defaults = array (
            'slides_num'            => esc_attr( auxin_get_option('post_archive_slider_slides_num', '10') ),
            'exclude'               => auxin_get_option('post_archive_slider_exclude'),
            'include'               => auxin_get_option('post_archive_slider_include'),
            'offset'                => esc_attr( auxin_get_option('post_archive_slider_offset') ),
            'order_by'              => esc_attr( auxin_get_option('post_archive_slider_order_by', 'date') ),
            'order_dir'             => esc_attr( auxin_get_option('post_archive_slider_order_dir', 'DESC') ),
            'skin'                  => esc_attr( auxin_get_option('post_archive_slider_skin', 'aux-light-skin') ),
            'add_title'             => esc_attr( auxin_get_option('post_archive_slider_add_title', '1') ),
            'add_meta'              => esc_attr( auxin_get_option('post_archive_slider_add_meta', '1') ),
            'image_from'            => esc_attr( auxin_get_option('post_archive_slider_image_from', 'auto') ),
            'custom_image'          => esc_attr( auxin_get_option('post_archive_slider_custom_image') ),
            'exclude_without_image' => esc_attr( auxin_get_option('post_archive_slider_exclude_without_images', '1') ),
            'width'                 => esc_attr( auxin_get_option('post_archive_slider_width', '960' ) ),
            'height'                => esc_attr( auxin_get_option('post_archive_slider_height', '560') ),
            'arrows'                => esc_attr( auxin_get_option('post_archive_slider_arrows', '0') ),
            'space'                 => esc_attr( auxin_get_option('post_archive_slider_space', '5') ),
            'loop'                  => esc_attr( auxin_get_option('post_archive_slider_loop', '1') ),
            'slideshow'             => esc_attr( auxin_get_option('post_archive_slider_slideshow', '0') ),
            'slideshow_delay'       => esc_attr( auxin_get_option('post_archive_slider_slideshow_delay', '2' ))
        );

        $options = wp_parse_args( $options, $defaults );

        // generate the shortcode
        $post_slider_shortcode = '[aux_latest_posts_slider ';

        foreach ( $options as $key => $value ) {
            $post_slider_shortcode .= $key . '="' . $value . '" ';
        }

        $post_slider_shortcode .= ']';

        return do_shortcode( $post_slider_shortcode );
    }
}

/* -------------------------------------------------------------------------- */

/**
 * Retrieves the last post ID from a post type
 *
 * @param  array     $args WP_Query args
 * @return int|bool        Post ID or false on failure
 */
function auxin_get_last_post_id( $args ){

    // WP_Query arguments
    $defaults = array(
        'post_type'              => 'post',
        'post_status'            => 'published',
        'posts_per_page'         => '1'
    );

    wp_parse_args( $args, $defaults );

    $posts = get_posts( $args );
    if ( count( $posts ) ) {
        return $posts[0]->ID;
    }
    return false;
}


/**
 * Retrieves post IDs from a WP Query
 *
 * @param  array     $args WP_Query args
 * @return array|bool        List of Post IDs or false on failure
 */
function auxin_query_ids( $args ){
    $post_ids = array();

    // WP_Query arguments
    $defaults = array(
        'post_type'              => 'post',
        'post_status'            => 'published',
        'posts_per_page'         => '-1'
    );

    wp_parse_args( $args, $defaults );

    // The Query
    $the_query = new WP_Query( $args );

    if ( $the_query->have_posts() ) {
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $post_ids[] = $the_query->post->ID;
        }
    }

    // Restore original Post Data
    wp_reset_postdata();

    return $post_ids;
}


/**
 * Retrieves the last post URL from a post type
 *
 * @param  array     $args WP_Query args
 * @return int|bool        Post URL or false on failure
 */
function auxin_get_last_post_permalink( $args ){
    if( $post_id = auxin_get_last_post_id( $args ) ){
        if( is_customize_preview() ) {
            return auxin_get_shortlink( $post_id );
        } else {
            return get_permalink( $post_id );
        }
    }
    return false;
}

/**
 * Retrieves the shortlink from a post ID
 *
 * @param  int          $post_id
 * @return int|bool     Post URL or false on failure
 */
function auxin_get_shortlink( $post_id = '' ) {

    $post = get_post( $post_id );

    if ( empty( $post->ID ) ){
        return false;
    }

    return home_url( '?p=' . $post->ID );
}

/**
 * Retrieves the archive shortlink from a post_type
 *
 * @param  string       $post_type
 * @return int|bool     Archive URL or false on failure
 */
function auxin_get_post_type_archive_shortlink( $post_type = '' ) {

    if ( empty( $post_type ) ){
        return false;
    }

    return home_url( '?post_type=' . $post_type );
}

/* -------------------------------------------------------------------------- */


/**
 * A wrapper function that fallbacks to parent theme mod if the the mod for the child theme is not set yet.
 *
 * @param  string  $name    Theme modification name.
 * @param  boolean $default Default value for theme modification name.
 *
 * @return string           Theme modification value.
 */
function auxin_get_theme_mod( $name, $default = false ) {
    if ( is_child_theme() )
        return get_theme_mod( $name, auxin_get_parent_theme_mod( $name, $default ) );

    return get_theme_mod( $name, $default );
}

/**
 * Retrieve all parent theme modifications.
 *
 * @return array|void  Theme modifications.
 */
function auxin_get_parent_theme_mods() {
    $slug = get_option( 'template' );

    return get_option( "theme_mods_{$slug}", array() );
}

/**
 * A wrapper function that retrieves a parent theme mod.
 *
 * @param  string  $name    Parent theme modification name.
 * @param  boolean $default Default value for parent theme modification name.
 *
 * @return string           Parent theme modification value.
 */
function auxin_get_parent_theme_mod( $name, $default = false ) {
    $mods = auxin_get_parent_theme_mods();

    if ( isset( $mods[ $name ] ) )
        return $mods[ $name ];

    if ( is_string( $default ) )
        $default = sprintf( $default, get_template_directory_uri(), get_stylesheet_directory_uri() );

    return $default;
}

/* ------------------------------------------------------------------------------ */


function auxin_get_background_patterns( $insert_array = array(), $where_to_insert = 'after' ){

    $patterns = array(
        THEME_URL . 'css/images/pattern/p1.png'=>
            array(
                'label' =>__('pattern 1', 'phlox-pro'),
                'image' => AUXIN_URL . 'images/visual-select/pattern1.png'
            ),
        THEME_URL . 'css/images/pattern/p2.png'=>
            array(
               'label' =>__('pattern 2', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern2.png'
            ),
        THEME_URL . 'css/images/pattern/p3.png'=>
            array(
               'label' =>__('pattern 3', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern3.png'
            ),
        THEME_URL . 'css/images/pattern/p4.png'=>
            array(
               'label' =>__('pattern 4', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern4.png'
            ),
        THEME_URL . 'css/images/pattern/p5.png'=>
            array(
               'label' =>__('pattern 5', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern5.png'
            ),
        THEME_URL . 'css/images/pattern/p6.png'=>
            array(
               'label' =>__('pattern 6', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern6.png'
            ),
        THEME_URL . 'css/images/pattern/p7.png'=>
            array(
               'label' =>__('pattern 7', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern7.png'
            ),
        THEME_URL . 'css/images/pattern/p8.png'=>
            array(
               'label' =>__('pattern 8', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern8.png'
            ),
        THEME_URL . 'css/images/pattern/p9.png'=>
            array(
               'label' =>__('pattern 9', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern9.png'
            ),
        THEME_URL . 'css/images/pattern/p10.png'=>
            array(
               'label' =>__('pattern 10', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern10.png'
            ),
        THEME_URL . 'css/images/pattern/p11.png'=>
            array(
               'label' =>__('pattern 11', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern11.png'
             ),
        THEME_URL . 'css/images/pattern/p12.png'=>
            array(
               'label' =>__('pattern 12', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern12.png'
            ),
        THEME_URL . 'css/images/pattern/p14.png'=>
            array(
               'label' =>__('pattern 14', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern14.png'
            ),
        THEME_URL . 'css/images/pattern/p15.png'=>
            array(
               'label' =>__('pattern 15', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern15.png'
            ),
        THEME_URL . 'css/images/pattern/p16.png'=>
            array(
               'label' =>__('pattern 16', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern16.png'
            ),
        THEME_URL . 'css/images/pattern/p17.png'=>
            array(
               'label' =>__('pattern 17', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern17.png'
            ),
        THEME_URL . 'css/images/pattern/p18.png'=>
            array(
               'label' =>__('pattern 18', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern18.png'
            ),
        THEME_URL . 'css/images/pattern/p19.png'=>
            array(
               'label' =>__('pattern 19', 'phlox-pro'),
               'image' => AUXIN_URL . 'images/visual-select/pattern19.png'
            )


    );

    if( ! empty( $insert_array ) ){
        if( 'after' == $where_to_insert ){
            $patterns = array_merge( $patterns, (array)$insert_array );
        } else {
            $patterns = array_merge( (array)$insert_array, $patterns );
        }
    }

    return apply_filters( 'auxin_get_background_patterns', $patterns );
}


/**
 * Retrieves the type of top header layout for current page
 */
if( ! function_exists( 'auxin_get_top_header_layout' ) ) {
     function auxin_get_top_header_layout( $post_id = '' ){
        $post   = get_post( $post_id );
        $layout = '';

        if( ! empty( $post->ID ) ){
            $layout = get_post_meta( $post->ID, 'page_header_top_layout', true );
        }
        if( empty( $layout ) || 'default' == $layout ){
            $layout = auxin_get_option( 'site_header_top_layout' );
        }
        return esc_attr( $layout );
    }
}


/**
 * Retrieves the content between two characters
 */
if( ! function_exists( 'auxin_get_string_between' ) ) {
     function auxin_get_string_between( $string, $start, $end ){
        $string  = ' ' . $string;
        $ini     = strpos($string, $start);
        if ($ini == 0) return '';
        $ini     += strlen($start);
        $len     = strpos($string, $end, $ini) - $ini;

        return substr($string, $ini, $len);
    }
}

/**
 * Get an intermediate image size
 *
 * @param  string $size_name   Image size name
 *
 * @return array|bool          An array containing image size for false if the size does not exists
 */
function auxin_wp_get_image_size( $size_name ){
    $all_image_sizes = auxin_get_all_image_sizes();

    if( 'full' === $size_name ){
        return false;
    }

    if( ! empty( $all_image_sizes[ $size_name ] ) ){
        return $all_image_sizes[ $size_name ];
    }
    auxin_error( sprintf( 'Invalid image size name (%s) for "%s" function.', $size_name, __FUNCTION__ ) );

    return false;
}


function auxin_get_all_image_sizes() {
    global $_wp_additional_image_sizes;

    $default_image_sizes = array( 'thumbnail', 'medium', 'medium_large', 'large' );

    $all_image_sizes = array();

    foreach ( $default_image_sizes as $size ) {
        $all_image_sizes[ $size ] = array(
            'width'  => (int)  get_option( $size . '_size_w' ),
            'height' => (int)  get_option( $size . '_size_h' ),
            'crop'   => (bool) get_option( $size . '_crop'   )
        );
    }

    if ( ! empty( $_wp_additional_image_sizes ) ) {
        $all_image_sizes = array_merge( $all_image_sizes, $_wp_additional_image_sizes );
    }

    return apply_filters( 'auxin_all_image_sizes', $all_image_sizes );
}


/**
 * Display the attributes for an HTML element.
 *
 * @return void
 */
function auxin_dom_attributes( $dom_name = '' ){
    if( empty( $dom_name ) ){
        auxin_error( sprintf( __('Please specify a unique dom name for %s', 'phlox-pro' ), __FUNCTION__ ) );
        return;
    }
    $attributes = apply_filters( "auxin_{$dom_name}_attributes", array() );

    $attrs_string = ' ';
    foreach ( $attributes as $attribute => $attribute_value) {
        $attrs_string .= sprintf( ' %s="%s"', esc_attr( $attribute ), esc_attr( $attribute_value ) );
    }
    echo $attrs_string;
}


/**
 * Get max width layout value
 *
 * @return string
 */
function auxin_get_content_width(){
    global $post;

    $theme_width_name = auxin_get_option( 'site_max_width_layout', 's-fhd' );
    $post_type        = get_post_type( get_the_ID() );

    if( is_singular() && ! is_front_page() ) {
        if( 'default' == $post_type_width_name = auxin_get_post_meta( $post, 'page_max_width_layout', 'default' ) ){
            if( $post_type_width_name = auxin_get_option( sprintf('%s_max_width_layout', $post_type ) ) ){
                $theme_width_name = $post_type_width_name;
            }
        } else {
            $theme_width_name = $post_type_width_name;
        }
    } elseif( ( is_archive() || auxin_is_blog() ) ){
        if( $post_type_width_name = auxin_get_option( sprintf('%s_archive_max_width_layout', $post_type ) ) ){
            $theme_width_name = $post_type_width_name;
        }
    }

    return $theme_width_name;
}


/**
 * Get list of registered menus
 *
 * @return array $menus list of menus by term_id and name as array key and value
 */
function auxin_registered_nav_menus() {

    $terms = get_terms( 'nav_menu' );

    $menus = array(
        'default' => __( 'Theme Default' , 'phlox-pro' ),
        'none'    => __( '- No Menu -', 'phlox-pro' )
    );

    foreach ( $terms as $menu ) {
        $menus[$menu->term_id] = $menu->name;
    }

    return $menus;

}


/**
 * Creating filter markup
 *
 * @param  array             $args WP_Query args
 * @param  string $type      Specific the type of filter
 * @param  string $align     Specific the position of filter
 * @param  string $classname Extra classname for filter wrapper
 * @return string            Return the output markup of filter
 */
function auxin_filter_output( $args, $type, $align, $classname = null, $sort_args = null ){

    $type = str_replace ( "aux-","", $type );

    $terms = get_terms( $args );

    if ( !empty($terms) && !is_wp_error($terms) ) {

        $taxonomy = preg_split("/[_,\- ]+/", $args['taxonomy']);
        $taxonomy = $taxonomy[1];

        $filter_name = 'cat' === $taxonomy ?  __('Category', 'phlox-pro') : $taxonomy ;

        switch( $type ) {
            case 'dropdown-filter':
                $filter_classname = 'aux-dropdown-filter';
                $filter_extra_output = '<span class="aux-filter-by">' . $filter_name .':<span class="aux-filter-name">' . __('All', 'phlox-pro') . '</span></span>';
                break;
            case 'slideup':
                $filter_classname = 'aux-togglable aux-slideup';
                $filter_extra_output = '<div class="aux-select-overlay"></div>';
                break;
            case 'fill':
                $filter_classname = 'aux-togglable aux-fill';
                $filter_extra_output = '<div class="aux-select-overlay"></div>';
                break;
            case 'cube':
                $filter_classname = 'aux-togglable aux-cube';
                $filter_extra_output = '<div class="aux-select-overlay"></div>';
                break;
            case 'underline':
                $filter_classname = 'aux-togglable aux-underline';
                $filter_extra_output = '<div class="aux-select-overlay"></div>';
                break;
            case 'overlay':
                $filter_classname = 'aux-togglable aux-overlay';
                $filter_extra_output = '<div class="aux-select-overlay"></div>';
                break;
            case 'bordered':
                $filter_classname = 'aux-togglable aux-bordered';
                $filter_extra_output = '<div class="aux-select-overlay"></div>';
                break;
            case 'overlay underline-anim':
                $filter_classname = 'aux-togglable aux-overlay aux-underline-anim';
                $filter_extra_output = '<div class="aux-select-overlay"></div>';
                break;
            default:
                $filter_classname = 'aux-togglable aux-slideup';
                $filter_extra_output = '<div class="aux-select-overlay"></div>';
                break;
        }

        $lists_output  = '<ul>';

        if ( sizeof( $terms ) > 1 ) {
            $lists_output .= '<li data-filter="all" data-category-id="all"><a href="#"><span data-select="' . __('All', 'phlox-pro') . '">' . __('All', 'phlox-pro') . '</span></a></li>';
        }

        foreach ( $terms as $term ) {
            $term->slug = str_replace( '%', '-', $term->slug );
            $lists_output .='<li data-filter="'.$term->slug.'" data-category-id="'.$term->term_id.'" ><a href="#"><span data-select="'.$term->name.'">'.$term->name.'</span></a></li>';
        }

        $lists_output .= '</ul>';

        $filter_output = sprintf('<div class="aux-filters %s %s %s">', $filter_classname, $align, $classname);
        $filter_output .= $filter_extra_output;
        $filter_output .= $lists_output;
        $filter_output .= '</div>';

        if ( $sort_args ) {

            if( 'aux-right' === $align ) {
                $sort_align = 'aux-left';
            } else if ( 'aux-left' === $align ) {
                $sort_align = 'aux-right';
            } else {
                $sort_align = 'aux-center';
            }

            $sort_output = '<ul>';
            $sort_output .= '<li data-filter="default"><a href="#"><span>' . __('Default sorting', 'phlox-pro') . '</span></a></li>';
            foreach ( $sort_args as $item => $key ) {

                if ( is_array( $key ) ){
                    $sort_output .= '<li data-filter="' . $key['orderby'] . '" data-filter-order="' . $key['order'] . '"><a href="#"><span>' . __('Sort By ', 'phlox-pro') . $item . '</span></a></li>';
                } else {
                    $sort_output .= '<li data-filter="' . $key . '"><a href="#"><span>' . __('Sort By ', 'phlox-pro') . $item . '</span></a></li>';
                }

            }
            $sort_output .= '</ul>';

            $filter_output .= '<div class="aux-sort-filter aux-filters aux-dropdown-filter ' . $sort_align . '" data-insert-text="false">';
            $filter_output .= '<span class="aux-filter-by">' . __('Sort By ', 'phlox-pro') .  '<span class="aux-filter-name"><i class="auxicon-chevron-down-1"></i></span></span>';
            $filter_output .= $sort_output ;
            $filter_output .= '</div>';
        }

        echo $filter_output;

    } else {
        return _e('Terms Not Found', 'phlox-pro');
    }


}

/**
 * Returns markup for search box
 *
 * @param  array  $args the search params
 *
 * @return string       Markupp for search box
 */
function auxin_get_search_box( $args = array() ){

    $defaults = array(
        'id'                => '',
        'has_toggle_icon'   => true,
        'has_field'         => true,
        'has_submit'        => true,
        'has_form'          => true,
        'has_category'      => false,
        'has_submit_icon'   => false, // this option added for changing submit type
        'css_class'         => '',
        'toggle_icon_class' => '',
        'icon_classname'    => 'auxicon-search-4',
        'is_ajax'           => false
    );


    $args = wp_parse_args( $args, $defaults );

    if ( $args['has_category'] ) {
        $post_type = 'post';
        $taxonomies = auxin_general_post_types_category_slug();

        $dropdown_args = array (
            'show_option_all' =>  __('All Categories', 'phlox-pro'),
            'taxonomy' => array_keys( $taxonomies ),
            'value_field' => 'slug'
        );

        if ( $args['is_ajax'] ) {
            $dropdown_args['hide_empty'] = false;
        }

    }

    $id_attr = !empty( $args['id']) ? 'id="' . esc_attr( $args['id'] ) . '"' : '';

    if ( $args['is_ajax'] ){
        $args[ 'css_class' ] .= ' is-ajax';
    }

ob_start();
?>
    <div <?php echo esc_attr( $id_attr ); ?> class="aux-search-section <?php echo esc_attr( $args[ 'css_class' ] ); ?>">
    <?php if( $args['has_toggle_icon'] ){ ?>
        <button class="aux-search-icon  <?php echo esc_attr( $args[ 'icon_classname' ] ); ?> <?php echo esc_attr( $args[ 'toggle_icon_class' ] ); ?> "></button>
    <?php } ?>
    <?php if( $args['has_form'] ){ ?>
        <div <?php  ?> class="aux-search-form <?php echo $args['has_submit_icon'] ? 'aux-iconic-search' : '' ?>">
            <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" >
            <div class="aux-search-input-form">
            <?php if( $args['has_field'] ){
                $placeholder  = $args['has_submit_icon'] ? __('Search...', 'phlox-pro') : __('Type here..', 'phlox-pro');
            ?>
                <input type="text" class="aux-search-field"  placeholder="<?php echo esc_attr( $placeholder ); ?>" name="s" autocomplete="off" />
            <?php } ?>
            <?php if ( $args['has_category'] ) {
                wp_dropdown_categories( $dropdown_args );
            }?>
            </div>
            <?php if( $args['has_submit_icon'] ){ ?>
                <div class="aux-submit-icon-container <?php echo esc_attr( $args[ 'icon_classname' ] ); ?> ">
                    <input type="submit" class="aux-iconic-search-submit" value="<?php esc_attr_e( 'Search', 'phlox-pro' ); ?>" >
                </div>
            <?php } elseif( $args['has_submit'] ){ ?>
                <input type="submit" class="aux-black aux-search-submit aux-uppercase" value="<?php esc_attr_e( 'Search', 'phlox-pro' ); ?>" >
            <?php } ?>
            </form>
        </div><!-- end searchform -->
        <?php if ( $args['is_ajax'] ) { ?>
        <div class="aux-spinner"></div>
        <div class="aux-search-result"></div>
        <?php } ?>
    <?php } ?>
    </div>

<?php
    return ob_get_clean();
}


/**
 * Get cart items list for shopping cart
 */
if ( ! function_exists( 'auxin_get_cart_items' ) ) {

    function auxin_get_cart_items( $args ){

        if ( ! class_exists( 'WooCommerce' ) )
            return;

        global $woocommerce;

        if ( empty( $args ) || !is_array( $args ) ) {
            
            //get action type (hover/click)
            $action = auxin_get_option('product_cart_dropdown_action_on');
            //Get the cart URL if hover option is enabled
            // $url = $action == 'hover' ? $woocommerce->cart->get_cart_url() : '#';
            //Get skin template
            $skin   = auxin_get_option('product_cart_dropdown_skin');


            $icon   = auxin_get_option( 'product_cart_icon', 'auxicon-shopping-cart-1-1' );

            $defaults   = array(
                'title'          => '',
                'css_class'      => '',
                'dropdown_class' => '',
                'color_class'    => 'aux-black',
                'action_on'      => $action,
                'cart_url'       => '#',
                'dropdown_skin'  => $skin,
                'icon'           => $icon,
                'size'           => 'thumbnail',
                'simple_mode'    => false,
                'basket_animation' => false,
                'cart_header_text' => '',
                'total_price_text_in_dropdown' => '',
                'checkout_text'  => ''
            );

            $args = wp_parse_args( $args, $defaults );
        }

        $simple_mode = isset( $args['simple_mode'] ) ? $args['simple_mode'] : false;

        ob_start();

        $items = $woocommerce->cart->get_cart();
        echo '<div class="aux-card-box">';

        foreach( $items as $item => $values ){
?>
            <div class="aux-card-item" data-cart_item_key="<?php echo esc_attr( $item ); ?>">
                <div class="aux-card-item-img">
                <?php echo auxin_get_the_responsive_attachment( get_post_thumbnail_id( $values['product_id']  ) ,
                        array(
                            'quality'         => 100,
                            'preloadable'     => false,
                            'preload_preview' => false,
                            'size'            => $args['size'],
                            'crop'            => true,
                            'add_hw'          => true,
                            'upscale'         => false,
                            'original_src'    => 'full' === $args['size'] ? true : false,
                        )
                    );
                ?>
                </div>
                <div class="aux-card-item-details">
                    <a class="aux-item-permalink" href="<?php echo esc_url( get_permalink( $values['product_id'] ) ); ?>">
                        <h3><?php echo $values['data']->get_title(); ?></h3>
                    </a>
                    <span>
                        <?php echo $values['quantity'] . ' &times; ' . $values['data']->get_price_html(); ?>
                    </span>
                    <a href="<?php echo esc_url( wc_get_cart_remove_url( $item ) ); ?>" class="aux-remove-cart-content aux-svg-symbol aux-small-cross <?php echo esc_attr( $args['color_class'] ); ?>" data-verify_nonce="<?php echo wp_create_nonce( 'remove_cart-' . $values['product_id'] ); ?>" data-product_id="<?php echo esc_attr( $values['product_id'] ); ?>" data-cart_item_key="<?php echo esc_attr( $item ); ?>"></a>
                </div>
            </div>
<?php
        }
        echo '</div>';
?>
        <div class="aux-inline-card-checkout">
            <?php if ( defined( 'AUXSHP_VERSION' ) ) { ?>
                <span class="aux-cart-total-items">
                    <span class="number"></span>
                    <?php esc_html_e( 'items', 'phlox-pro' ) ;?>
                </span>
            <?php } ?>
            <div class="aux-card-final-amount aux-cart-subtotal">
            <?php
                echo ! empty( $args['total_price_text_in_dropdown'] ) ? $args['total_price_text_in_dropdown'] : auxin_get_option('site_header_cart_text', __( 'Sub total', 'phlox-pro' ) );
                echo $woocommerce->cart->get_cart_subtotal();
            ?>
            </div>
            <div class="aux-button-wrapper">
                <?php
                $checkout = auxin_is_true( $simple_mode ) ? __( 'Proceed to checkout', 'phlox-pro' ) : __( 'Checkout', 'phlox-pro' );
                $checkout = ! empty( $args['checkout_text'] ) ? $args['checkout_text'] : $checkout;
                ?>
                <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="aux-button aux-checkout-button aux-large <?php echo esc_attr( $args['color_class'] ); ?> aux-uppercase">
                    <span class="aux-overlay"></span>
                    <span class="aux-text"><?php echo esc_html( $checkout ); ?></span>
                </a>
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="aux-button aux-cart-button aux-large aux- <?php echo esc_attr( $args['color_class'] ); ?> aux-outline aux-uppercase">
                    <span class="aux-overlay"></span>
                    <span class="aux-text"><?php esc_html_e( 'View Cart', 'phlox-pro' ); ?></span>
                </a>
            </div>
        </div>
    <?php
        return ob_get_clean();
    }
}


/**
 * Get basket details for cart contents
 */
if ( ! function_exists( 'auxin_get_cart_basket' ) ) {

    function auxin_get_cart_basket( $args, $count ){

        if ( ! class_exists( 'WooCommerce' ) )
            return;

        global $woocommerce;

        if ( empty( $args ) || !is_array( $args ) ) {
            
            //get action type (hover/click)
            $action = auxin_get_option('product_cart_dropdown_action_on');
            //Get the cart URL if hover option is enabled
            // $url = $action == 'hover' ? $woocommerce->cart->get_cart_url() : '#';
            //Get skin template
            $skin   = auxin_get_option('product_cart_dropdown_skin');


            $icon   = auxin_get_option( 'product_cart_icon', 'auxicon-shopping-cart-1-1' );

            $defaults   = array(
                'title'          => '',
                'css_class'      => '',
                'dropdown_class' => '',
                'color_class'    => 'aux-black',
                'action_on'      => $action,
                'cart_url'       => '#',
                'dropdown_skin'  => $skin,
                'icon'           => $icon,
                'size'           => 'thumbnail',
                'simple_mode'    => false,
                'basket_animation' => false,
                'cart_header_text' => '',
                'total_price_text_in_dropdown' => '',
                'checkout_text'  => ''
            );

            $args = wp_parse_args( $args, $defaults );
        }

        $args['simple_mode'] = isset( $args['simple_mode'] ) ? $args['simple_mode'] : false;
        if ( ! $args['simple_mode'] )
            $args['simple_mode'] = auxin_get_option('site_header_card_mode', '0');

        $basket_text = ! empty( $args['cart_header_text'] ) ? $args['cart_header_text'] : auxin_get_option('site_header_cart_text', __( 'Shopping Basket', 'phlox-pro' ) );
        $subtotal    = is_object( $woocommerce->cart ) ? $woocommerce->cart->get_cart_subtotal() : 0;

        ob_start();
    ?>
        <a class="aux-cart-contents <?php echo esc_attr( $args['icon'] ); ?>" href="<?php echo esc_url( $args['cart_url'] ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'phlox-pro' ); ?>">
            <?php echo isset( $args['title'] ) ? $args['title'] : '';
            echo '<span>' . $count . '</span>'; ?>
        </a>

        <?php if ( ! auxin_is_true( $args['simple_mode'] ) ) { ?>
        <div class="aux-shopping-cart-info aux-phone-off">
            <span class="aux-shopping-title"><?php echo esc_html( $basket_text ); ?></span>
            <span class="aux-shopping-amount aux-cart-subtotal"><?php echo $subtotal; ?></span>
        </div>
        <?php }

        return ob_get_clean();
    }

}


/**
 * Returns available post types for full screen search option
 *
 * @return array    Available Post Types
 */
function auxin_get_available_post_types_for_search() {
    $available_post_type = array(
        'post' => 'post',
        'page' => 'page'
    );
    $post_types = get_post_types(
        array(
            'public'    => true,
            '_builtin'  => false
        )
    );

    if ( isset( $post_types['elementor_library'] ) ) {
        unset( $post_types['elementor_library'] );
    }
    return array_merge( $available_post_type, $post_types );
}

/**
 * Returns available post types which has archive
 *
 * @return array    Available Post Types
 */
function auxin_get_available_post_types_with_archive() {
    $available_post_type = array(
        'post' => 'post'
    );
    $post_types = get_post_types(
        array(
            'public'    => true,
            '_builtin'  => false,
            'has_archive' => true
        )
    );

    return array_merge( $available_post_type, $post_types );
}

/**
 * Return General Posts Category slug
 *
 */
if ( ! function_exists('auxin_general_post_types_category_slug') ) {
    function auxin_general_post_types_category_slug() {

        $post_types = [
            'category' => __( 'Post', 'phlox-pro' )
        ];

        if ( class_exists( 'WooCommerce' ) ) {
            $post_types['product_cat'] = __( 'Product', 'phlox-pro' );
        }

        if ( class_exists( 'AUXPFO' ) ) {
            $post_types['portfolio-cat'] = __( 'Portfolio', 'phlox-pro' );
        }

        if ( class_exists( 'AUXNEW' ) ) {
            $post_types['news-category'] = __( 'News', 'phlox-pro' );
        }

        if ( class_exists( 'AUXPRO' )) {
            $post_types['faq-category'] = __( 'FAQ', 'phlox-pro' );
        }

        return apply_filters( 'auxin_general_post_types_category_slug', $post_types );
    }
}

/**
 * Return categories taxonomy slug by post type
 *
 */
if ( ! function_exists('auxin_get_categories_slug_by_post_type') ) {
    function auxin_get_categories_slug_by_post_type( $post_type ) {

        $categories_list = [
            'post' => 'category'
        ];

        if ( class_exists( 'WooCommerce' ) ) {
            $categories_list['product'] = 'product_cat';
        }

        if ( class_exists( 'AUXPFO' ) ) {
            $categories_list['portfolio'] = 'portfolio-cat';
        }

        if ( class_exists( 'AUXNEW' ) ) {
            $categories_list['news'] = 'news-category';
        }

        if ( class_exists( 'AUXPRO' )) {
            $categories_list['faq'] = 'faq-category';
        }

        $categories_list = apply_filters( 'auxin_get_categories_slug_by_post_type', $categories_list );

        return isset( $categories_list[ $post_type ] ) ? $categories_list[ $post_type ] : '';

    }
}

/**
 * Check if attachment url is local or external
 *
 * @param string $url
 *
 * @return boolean
 */
if ( ! function_exists( 'auxin_is_local_url' ) ) {
    function auxin_is_local_url( $url ){
        $uploads_dir = wp_upload_dir();
        return strpos( $url, $uploads_dir['baseurl'] ) !== false;
    }
}

/**
 * Filters text content and strips out disallowed HTML.
 *
 * @param string $input
 * @param array $allowed_tags
 * @param string $namespace
 * @param boolean $auto_p
 * @return void
 */
function auxin_kses($input, $allowed_tags = null, $namespace = null, $auto_p = false) {
    $tags = apply_filters('auxin_wp_sanitize_html_tags_' . ($namespace ? $namespace : 'default'), $allowed_tags ? $allowed_tags : [
        'em' => [],
        'strong' => [],
        'small' => [],
        'sub' => [],
        'sup' => [],
        'b' => [],
        'i' => [],
        'ul' => [],
        'ol' => [],
        'hgroup' => [],
        'h1' => [],
        'h2' => [],
        'h3' => [],
        'h4' => [],
        'h5' => [],
        'h6' => [],
        'table' => [],
        'tbody' => [],
        'tfoot' => [],
        'thead' => [],
        'dd' => [],
        'dt' => [],
        'dl' => [],
        'tr' => [],
        'th' => [],
        'td' => [],
        'figure' => [],
        'figcaption' => [],
        'caption' => [],
        'img' => [
            'src' => true,
            'alt' => true,
            'width' => true,
            'height' => true,
            'class' => true,
            'data-*' => true,
            'srcset' => true,
            'sizes' => true,
        ],
        'video'      => array(
            'autoplay'    => true,
            'controls'    => true,
            'height'      => true,
            'loop'        => true,
            'muted'       => true,
            'playsinline' => true,
            'poster'      => true,
            'preload'     => true,
            'src'         => true,
            'width'       => true,
        ),
        'a' => [
            'href' => true,
            'title' => true,
            'rev'      => true,
            'rel' => true,
            'target' => true,
            'download' => ['valueless' => 'y'],
        ],
        'li' => [],
        'blockquote' => [],
        'cite' => [],
        'code' => [],
        'hr' => [],
        'p' => [],
        'br' => [],
        'span' => [
            'class' => true
        ]
    ]);
    $output =  trim(wp_kses(trim($input), $tags));

    if($auto_p) {
        $output = wpautop($output);
    }

    $image_place_holder = "image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
    if ( strpos( $output, $image_place_holder ) ) {
        $output = str_replace( 'src="' . $image_place_holder, 'src="data:' . $image_place_holder, $output );
    }

    return $output;
}