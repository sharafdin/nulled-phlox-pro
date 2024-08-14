<?php
/**
 * General hooks
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


/*-----------------------------------------------------------------------------------*/
/*  Setup Header
/*-----------------------------------------------------------------------------------*/

function auxin_after_setup_theme(){
    $theme_support_features = Auxin()->Config->theme_support;

    if ( function_exists( 'add_theme_support' ) ) {

        foreach ( $theme_support_features as $the_theme_support ) {
            if( $the_theme_support ){

                /*  Add Post Formats
                /*----------------------------*/
                if( 'post-formats' == $the_theme_support ){
                    add_theme_support( 'post-formats',
                        apply_filters( 'auxin_post_formats',
                            array( 'aside', 'gallery', 'image', 'link', 'quote', 'video', 'audio' )
                        )
                    );
                    continue;
                }

                if( 'html5' == $the_theme_support ){
                    add_theme_support( 'html5',
                        array( 'comment-list', 'comment-form', 'search-form', 'gallery', 'caption', 'style', 'script' )
                    );
                    continue;
                }

                add_theme_support( $the_theme_support );
            }
        }

        // Unfortunately theme-check plugin cannot understand passing variable to 'add_theme_support', so we have to add these two line manually!
        add_theme_support( 'automatic-feed-links' ); // Adds RSS feed links to <head> for posts and comments.
        add_theme_support( 'title-tag' );

    }

    set_post_thumbnail_size( 280, 180, true ); // Featured image display size


    /*  Config excerpts length
    /*------------------------------------------------------------------------------*/
    add_filter( 'the_content_more_link'  , 'auxin_change_content_more_link'     , 15, 3 );
    add_filter( 'the_content_more_link'  , 'auxin_change_trim_excerpt_more_link', 20, 3 );


    /*  Fallback to load translation from /languages folder too
    /*------------------------------------------------------------------------------*/
    /* Translations can be added to the /languages/ directory. */
    if( ! load_theme_textdomain( 'phlox-pro', get_stylesheet_directory() . '/languages' ) ){
          load_theme_textdomain( 'phlox-pro', get_template_directory()   . '/languages' );
    }

}

add_action( 'after_setup_theme', 'auxin_after_setup_theme' );

/*-----------------------------------------------------------------------------------*/
/*  Declare nav menu & starter content
/*-----------------------------------------------------------------------------------*/

/**
 * Registers support for various WordPress features.
 *
 */
function auxin_implement_starter_content() {

    /*  Register Theme menus
    /*------------------------------------------------------------------------*/

    // Adds Header menu
    register_nav_menu( 'header-primary'     , __( 'Header Primary Navigation'  , 'phlox-pro') );
    register_nav_menu( 'header-secondary'   , __( 'Header Secondary Navigation', 'phlox-pro') );

    // adds Footer menu
    register_nav_menu( 'footer'  , __( 'Footer Navigation', 'phlox-pro') );

    /*------------------------------------------------------------------------*/

    // Define and register starter content to showcase the theme on new sites.
    $starter_content = array(


        // Specify the post and pages for starter content
        'posts' => array(
            'home',
            'about',
            'contact',
            'blog',
            'news',
            'policy' => array(
                'post_type'    => 'page',
                'post_title'   => _x( 'Privacy Policy', 'Theme starter content', 'phlox-pro' ),
                'post_content' => _x( 'This is a page with some basic information about our privacy policy.', 'Theme starter content', 'phlox-pro' )
            ),
            'terms' => array(
                'post_type'    => 'page',
                'post_title'   => _x( 'Terms', 'Theme starter content', 'phlox-pro' ),
                'post_content' => _x( 'This is a page with some basic terms and conditions terms.', 'Theme starter content', 'phlox-pro' )
            ),

            'mountains' => array(
                'post_type'    => 'post',
                'thumbnail'    => '',
                'post_title'   => _x( 'Montain and Winter Cold Weather', 'Theme starter content', 'phlox-pro' ),
                'post_content' => _x( 'If several languages coalesce, the grammar of the resulting language is more simple and regular than that of the individual languages. The new common language will be more simple and regular than the existing European languages. It will be as simple as Occidental; in fact, it will be Occidental.', 'Theme starter content', 'phlox-pro' )
            ),

            'bridge' => array(
                'post_type'    => 'post',
                'thumbnail'    => '',
                'post_title'   => _x( 'Serious Problems with Cables in CIty', 'Theme starter content', 'phlox-pro' ),
                'post_content' => _x( 'The new common language will be more simple and regular than the existing European languages. It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family.', 'Theme starter content', 'phlox-pro' )
            ),

            'bluewall' => array(
                'post_type'    => 'post',
                'thumbnail'    => '',
                'post_title'   => _x( 'Road to Eye-catching Landscape', 'Theme starter content', 'phlox-pro' ),
                'post_content' => _x( 'The new common language will be more simple and regular than the existing European languages. It will be as simple as Occidental; in fact, it will be Occidental. To an English person, it will seem like simplified English, as a skeptical Cambridge friend of mine told me what Occidental is. The European languages are members of the same family.', 'Theme starter content', 'phlox-pro' )
            )

        ),

        // the widgets
        'widgets' => array(

            // Add widgets for global primary sidebar
            'auxin-global-primary-sidebar-widget-area' => array(
                'search'
            ),

            // Add widgets for global secondary sidebar
            'auxin-global-secondary-sidebar-widget-area' => array(
            ),

            // Add widgets for pages primary sidebar
            'auxin-pages-primary-sidebar-widget-area' => array(
                'text_business_info',
                'calendar',
                'meta'
            ),

            // Add widgets for pages secondary sidebar
            'auxin-pages-secondary-sidebar-widget-area' => array(
                'recent-posts',
                'archives',
                'meta'
            ),

            // Add widgets for blog primary sidebar
            'auxin-blog-primary-sidebar-widget-area' => array(
                'text_business_info',
                'calendar',
                'meta'
            ),

            // Add widgets for blog secondary sidebar
            'auxin-blog-secondary-sidebar-widget-area' => array(
                'text_business_info',
                'archives',
                'meta'
            ),

            // Add widgets for search sidebar
            'auxin-search-sidebar-widget-area' => array(
                'recent-posts',
                'archives',
                'text_business_info',
                'meta'
            ),

            // Add widgets for subfooter-bar sidebar
            'auxin-subfooter-bar-widget-area' => array(
                'text_subfooter_sugestions' => array( 'text', array(
                        'title' => '',
                        'text'  => '<h4 style="text-align:center; margin-bottom:5px;">'.
                                    _x( 'You can put special widgets in this bar; like, instagram stream, newsletter, recent tweets or partners.', 'Theme starter content', 'phlox-pro' ).'</h4>'
                    )
                )
            ),

            // Add widgets for first column in subfooter sidebar
            'auxin-footer1-sidebar-widget-area' => array(
                'text_business_info'
            ),

            // Add widgets for the second column in subfooter sidebar
            'auxin-footer2-sidebar-widget-area' => array(
                'text_our_website' => array( 'text', array(
                    'title' => _x( 'About Author', 'Theme starter content', 'phlox-pro' ),
                    'text'  => '<div class="aux-widget-about"><dl><dt class="aux-about-name">'. _x('John Doe', 'Theme starter content', 'phlox-pro') .'</dt>'.
                        '<dd class="aux-about-skills">'. _x( 'Company CEO', 'Theme starter content', 'phlox-pro') . '</dd>'.
                        '<dd class="aux-about-content">'. _x( 'Drops of rain could be heard hitting the pane, which made him feel quite sad. How about if I sleep a little bit longer and forget all this nonsense', 'Theme starter content', 'phlox-pro'). '</dd></dl></div>'
                ))
            ),

            // Add widgets for the third column in subfooter sidebar
            'auxin-footer3-sidebar-widget-area' => array(
                'meta'
            )

        ),


        // Default to a static front page and assign the front and posts pages.
        'options' => array(
            'show_on_front'  => 'page',
            'page_on_front'  => '{{home}}',
            'page_for_posts' => '{{blog}}',
            'blogdescription'=> __( 'Yet another awesome website by Phlox theme.', 'phlox-pro' )
        ),


        // Set up nav menus for each of the two areas registered in the theme.
        'nav_menus' => array(
            // Assign a menu to the "top" location.
            'header-primary' => array(
                'name' => __( 'Header Primary Menu', 'phlox-pro' ),
                'items' => array(
                    'page_home',
                    'page_blog',
                    'page_news',
                    'page_about',
                    'page_contact'
                )
            ),

            // Assign a menu to the "social" location.
            'header-secondary' => array(
                'name'  => __( 'Top Header Menu', 'phlox-pro' ),
                'items' => array(
                    'page_terms' => array(
                        'type'      => 'post_type',
                        'object'    => 'page',
                        'object_id' => '{{terms}}'
                    ),
                    'page_about',
                    'page_policy' => array(
                        'type'      => 'post_type',
                        'object'    => 'page',
                        'object_id' => '{{policy}}'
                    )
                ),
            ),

            // Assign a menu to the "social" location.
            'footer' => array(
                'name' => __( 'Footer Social Menu', 'phlox-pro' ),
                'items' => array(
                    'link_twitter' => array(
                        'title' => _x( 'Twitter', 'Theme starter content', 'phlox-pro' ),
                        'url'   => 'https://twitter.com/'
                    ),
                    'link_facebook' => array(
                        'title' => _x( 'Facebook', 'Theme starter content', 'phlox-pro' ),
                        'url'   => 'https://facebook.com/'
                    ),
                    'link_instagram' => array(
                        'title' => _x( 'Instagram', 'Theme starter content', 'phlox-pro' ),
                        'url'   => 'https://instagram.com/'
                    )
                )
            )


        ),
    );

    add_theme_support( 'starter-content', $starter_content );
}
add_action( 'after_setup_theme', 'auxin_implement_starter_content' );

function auxin_save_initial_info() {
    if ( empty( get_theme_mod( 'initial_date', '' ) ) ) {
        set_theme_mod( 'initial_date', date("Y-m-d H:i:s") );
    }

    if ( empty( get_theme_mod( 'initial_version', '' ) ) ) {
        set_theme_mod( 'initial_version', THEME_VERSION );
    }
}
add_action( 'after_setup_theme', 'auxin_save_initial_info' );

/*----------------------------------------------------------------------------*/
/*  Set content width
/*----------------------------------------------------------------------------*/

function auxin_set_content_width(){
    global $post;

    global $aux_content_width, $content_width;

    // Make sure to run this function only once
    if( ! empty( $aux_content_width ) && ! empty( $content_width ) ){
        return $aux_content_width;
    }

    // the theme wrapper width
    $theme_width_name = esc_attr( auxin_get_content_width() );
    $theme_width_list = Auxin()->Config->theme_width_list;

    if( 'default' === $content_layout = auxin_get_post_meta( $post, 'content_layout', 'default' ) ){
        $content_layout = auxin_get_option( 'page_content_layout' );
    }

    if( ! empty( $post ) && 'full' === $content_layout ){
        $theme_width = 2000;
    } else {
        $theme_width = isset( $theme_width_list[ $theme_width_name ] ) ? $theme_width_list[ $theme_width_name ] : 1200;
    }

    // calculate the content width if there is sibebar on page
    $sidebar_num = (int) auxin_has_sidebar( $post );
    if( $sidebar_num ){
        if( 1 === $sidebar_num ){
            if ( auxin_primary_sidebar_has_content() ) {
                $theme_width -= 300;
            }
        } elseif( 2 === $sidebar_num ){
            if ( auxin_primary_sidebar_has_content() && auxin_secondary_sidebar_has_content() ) {
                $theme_width -= 560;
            }

            if ( auxin_primary_sidebar_has_content() || auxin_secondary_sidebar_has_content() ) {
                $theme_width -= 300;
            }
        }
    }

    global $aux_content_width, $content_width;

    $aux_content_width = apply_filters( 'auxin_content_width', $theme_width );
    $content_width     = empty( $content_width ) ? $theme_width : $content_width;

    return $aux_content_width;
}

add_action( 'wp', 'auxin_set_content_width' );

/*-----------------------------------------------------------------------------------*/
/*  Front end query modifications
/*-----------------------------------------------------------------------------------*/

function auxin_front_end_update_query( $query ) {
    if ( is_admin() || ! $query->is_main_query() ){
        return;
    }

    // if current query is archive blog
    if ( $query->is_home || $query->is_date || $query->is_author || $query->is_category || $query->is_tag || is_post_type_archive( 'post' ) ){
        // get template type id
        $template_type_id = esc_attr( auxin_get_option( 'post_index_template_type', 'default' ) );

        // if layout is grid(5) or masonry(6) or timeline(7) or land(8) or tile(9) and exclude media is enabled, exclude the posts that dont have featured image
        if( in_array( $template_type_id, array( 5,6,7,8,9 ) ) && auxin_get_option( 'exclude_without_media', 1 ) ){
            $query->query_vars['meta_query'][] = array(
                'key'       => '_thumbnail_id',
                'value'     => '',
                'compare'   => '!='
            );
        }

        // if template type is timeline exclude 'link' and 'quote' post formats
        if( 7 == $template_type_id ){

            // exclude the redundant taxonomies (post-format)
            $query->query_vars['tax_query'][] = array(
                'taxonomy' => 'post_format',
                'field'    => 'slug',
                'terms'    => array( 'post-format-quote', 'post-format-link' ),
                'operator' => 'NOT IN'
            );
        }

        return $query;
    }

    // If it is archive for a custom post type
    if( $query->is_post_type_archive ){

        if ( is_post_type_archive('portfolio') ){
            $perpage = auxin_get_option("portfolio_archive_items_perpage", 12);
            $perpage = (int)$perpage < 1 ? -1 : $perpage;
            $perpage = esc_attr( $perpage );

            $query->set( 'posts_per_page', $perpage );
            return $query;
        }

        if ( is_post_type_archive('news') ) {
            $query->set( 'orderby', 'menu_order date' );
            return $query;
        }

        if ( is_post_type_archive('service') ) {
            $query->set( 'posts_per_page', 12 );
            return $query;
        }

        if ( is_post_type_archive('faq') ) {
            $query->set( 'posts_per_page', 30 );
            return $query;
        }

        if ( is_post_type_archive('staff') ) {
            $query->set( 'posts_per_page', 12 );
            return $query;
        }

        if ( is_post_type_archive('testimonial') ) {
            $query->set( 'posts_per_page', 20 );
            return $query;
        }

    }

    // If it is archive for a taxonomy
    if( $query->is_tax ){

        if ( $query->is_tax('portfolio-cat') || $query->is_tax('portfolio-tag') ) {
            $perpage = auxin_get_option("portfolio_category_page_items_perpage");
            $perpage = (int)$perpage < 1 ? -1 : $perpage;
            $perpage = esc_attr( $perpage );

            $query->set( 'posts_per_page', $perpage );
            return $query;
        }

        if ( $query->is_tax('news-category') || $query->is_tax('news-tag') ) {
            $query->set( 'orderby', 'menu_order date' );
            return $query;
        }

        if ( $query->is_tax('service-category') ) {
            $query->set( 'posts_per_page', 12 );
            return $query;
        }

        if ( $query->is_tax('faq-category') ) {
            $query->set( 'posts_per_page', 20 );
            return $query;
        }

        if ( $query->is_tax('department') ) {
            $query->set( 'posts_per_page', 12 );
            return $query;
        }

    }

    // Filter Search and only display results from main post types
     if ( $query->is_search ) {
        $query->set(
            'post_type', array( 'page', 'post', 'portfolio', 'staff', 'service', 'testimonial', 'news', 'faq' , 'product' )
        );

        if ( ! empty( $_GET['post_type'] ) ) {
            $query->set( 'post_type', explode( ',', sanitize_text_field( $_GET['post_type'] ) ) );
        }
        return $query;
    }

}
add_action( 'pre_get_posts', 'auxin_front_end_update_query', 1 );


/**
 * Adding extra attributes for custom logo image
 *
 * @param  array  $attr       The attributes list
 * @param  int    $attachment The attachment id
 * @param  string $size       the attachment size
 *
 * @return array              The list of attributes
 */
function auxin_change_custom_logo_attributes( $attr, $attachment, $size ){
    if( ! empty( $attr['class'] ) && 'custom-logo' == $attr['class'] ){
        $attr['class'] .= ' aux-logo-image aux-logo-image1 aux-logo-light';
        $attr['alt']    = get_bloginfo( 'name', 'display' );
    }
    return $attr;
}


/*-----------------------------------------------------------------------------------*/


/**
 * Retrieve the custom background styles for the page
 *
 * @since 2.0.0
 *
 * @return string   The custom background styles for the page
 */
function auxin_get_page_background_style( $css, $post ){
    global $post;

    if( empty( $post ) || is_404() || ! is_singular() )
        return '';

    $output = "";

    if( auxin_is_true( auxin_get_post_meta( $post, 'aux_custom_bg_show', true ) == 1 ) ){

        $styles = auxin_generate_styles_for_backgroud_fields(
            'aux_custom_bg',
            'post_meta',
            array(
                'color'     => 'aux_custom_bg_color',
                'image'     => 'aux_custom_bg_image',
                'repeat'    => 'aux_custom_bg_repeat',
                'size'      => 'aux_custom_bg_size',
                'position'  => 'aux_custom_bg_position',
                'attach'    => 'aux_custom_bg_attach',
                'clip'      => 'aux_custom_bg_clip'
            )
        );
        $output .= "\thtml body {\t" . $styles . "} \n";

        $pattern = auxin_get_post_meta( $post, 'aux_custom_bg_pattern' );
        if( ! empty( $pattern ) ){
            $output .= "\tbody:before {\t height:100%; background-image:url(". $pattern .") } \n";
        }

    }

    if( ! empty( $output ) ){
        $output = stripslashes( $output );
    }

    return $output;
}

add_filter( 'auxin_header_inline_styles', 'auxin_get_page_background_style', 10, 2 );


/*-----------------------------------------------------------------------------------*/
/*  Print custom css styles using the wp_get_custom_css
/*-----------------------------------------------------------------------------------*/

function auxin_print_inline_styles_with_wp_custom_css( $wp_css ){
    global $post;

    //  Prints the custom inline styles of the page in header //////////////
    if( $css = apply_filters( 'auxin_header_inline_styles', '', $post ) ){
        $wp_css .= $css;
    }
    return $wp_css;
}

add_filter('wp_get_custom_css', 'auxin_print_inline_styles_with_wp_custom_css', 14, 1);

/*-----------------------------------------------------------------------------------*/
/*  Remove all auto generated p tags & line breaks beside shortcode content
/*-----------------------------------------------------------------------------------*/

function auxin_cleanup_beside_shortcodes($content){
    $array = array (
        '<p>['    => '[',
        ']</p>'   => ']',
        ']<br />' => ']'
    );
    $content = strtr( $content, $array );
    return $content;
}

add_filter('the_content', 'auxin_cleanup_beside_shortcodes');


/*-----------------------------------------------------------------------------------*/
/*  Allow shortcode functioning as value of srcset over img tags
/*-----------------------------------------------------------------------------------*/
function auxin_allow_img_srcset_shortcode( $allowedposttags, $context ) {
    if ( 'post' == $context ) {
        $allowedposttags['img']['srcset'] = 1;
        $allowedposttags['source'] = [
            'type' => 1,
            'src'  => 1
        ];
		$allowedposttags['iframe'] = [
			'src'             => true,
			'height'          => true,
			'width'           => true,
            'style'           => true,
			'frameborder'     => true,
			'allowfullscreen' => true,
		];
        $allowedposttags['svg'] = [
            'xmlns' => [],
            'fill' => [],
            'viewbox' => [],
            'width' => [],
            'height' => [],
            'transform' => [],
            'role' => [],
            'aria-hidden' => [],
            'focusable' => [],
            'class' => [],
            'id' => [],
            'style' => [],
            'enable-background' => []
        ];
        $allowedposttags['path'] = [
            'id' => [],
            'class' => [],
            'd' => [],
            'fill' => [],
            'fill-rule' => [],
            'width' => [],
            'height' => [],
            'transform' => [],
            'stroke-width' => [],
            'stroke' => [],
            'opacity' => [],
            'style' => [],
        ];
        $allowedposttags['line'] = [
            'id' => [],
            'class' => [],
            'd' => [],
            'fill' => [],
            'fill-rule' => [],
            'width' => [],
            'height' => [],
            'transform' => [],
            'stroke-width' => [],
            'stroke' => [],
            'opacity' => [],
            'style' => [],
            'x1'  => [],
            'x2'  => [],
            'y1'  => [],
            'y2'  => [],
        ];
        $allowedposttags['g'] = [
            'id' => [],
            'class' => [],
            'fill' => [],
            'width' => [],
            'height' => [],
            'transform' => [],
            'data-name' => [],
            'stroke-width' => [],
            'stroke' => [],
            'opacity' => [],
            'style' => [],
            'filter' => [],
            'mask' => [],
        ];
        $allowedposttags['rect'] = [
            'id' => [],
            'class' => [],
            'fill' => [],
            'width' => [],
            'height' => [],
            'transform' => [],
            'opacity' => [],
            'data-name' => [],
            'x' => [],
            'y' => [],
            'rx' => [],
            'ry' => [],
            'style' => [],
            'stroke' => [],
            'stroke-linecap' => [],
            'stroke-linejoin' => [],
            'stroke-width' => []
        ];
        $allowedposttags['circle'] = [
            'id' => [],
            'class' => [],
            'fill' => [],
            'transform' => [],
            'data-name' => [],
            'cx' => [],
            'cy' => [],
            'r' => [],
            'stroke-width' => [],
            'stroke' => [],
            'opacity' => [],
            'style' => []
        ];
        $allowedposttags['ellipse'] = [
            'id'   => [],
            'class' => [],
            'fill' => [],
            'transform' => [],
            'opacity'   => [],
            'data-name' => [],
            'cx' => [],
            'cy' => [],
            'rx' => [],
            'ry' => [],
            'style' => []
        ];
        $allowedposttags['text'] = [
            'fill' => [],
            'width' => [],
            'height' => [],
            'transform' => [],
            'font-size' => [],
            'font-family' => [],
            'font-weight' => [],
            'letter-spacing' => [],
            'x' => [],
            'y' => [],
            'opacity' => [],
            'style' => []
        ];
        $allowedposttags['tspan'] = [
            'fill' => [],
            'transform' => [],
            'font-size' => [],
            'font-family' => [],
            'letter-spacing' => [],
            'x' => [],
            'y' => [],
            'opacity' => []
        ];
        $allowedposttags['style'] = [
            'type' => [],
            'media' => []
        ];
        $allowedposttags['lineargradient'] = [
            'id'  => [],
            'href'=> [],
            'x1'  => [],
            'x2'  => [],
            'y1'  => [],
            'y2'  => [],
            'spreadmethod'  => [],
            'gradientunits' => [],
            'xlink:href' => []
        ];
        $allowedposttags['stop'] = [
            'offset'     => [],
            'stop-color' => [],
            'stop-opacity' => []
        ];
        $allowedposttags['radialgradient'] = [
            'id' => [],
            'cx' => [],
            'cy' => [],
            'r' => [],
            'gradienttransform' => [],
            'gradientunits' => []
        ];
        $allowedposttags['defs'] = [];
        $allowedposttags['clippath'] = [
            'id' => []
        ];
        $allowedposttags['filter'] = [
            'filterunits' => [],
            'id' => [],
            'class' => [],
            'width' => [],
            'height' => [],
            'x' => [],
            'y' => [],
            'opacity' => [],
            'color-interpolation-filters' => []
        ];
        $allowedposttags['feoffset'] = [
            'dx' => [],
            'dy' => [],
            'input' => [],
        ];
        $allowedposttags['fegaussianblur'] = [
            'stddeviation' => [],
            'result' => []
        ];
        $allowedposttags['feflood'] = [
            'flood-color' => [],
            'flood-opacity' => [],
            'result' => []
        ];
        $allowedposttags['feblend'] = [
            'mode' => [],
            'in' => [],
            'in2' => [],
            'result' => []
        ];
        $allowedposttags['fecomposite'] = [
            'operator' => [],
            'in' => [],
            'in2' => [],
        ];
        $allowedposttags['desc'] = [];
        $allowedposttags['marker'] = [];
        $allowedposttags['mask'] = [
            'id' => [],
            'style' => [],
            'maskunits' => [],
            'x' => [],
            'y' => [],
            'width' => [],
            'height' => [],
        ];
        $allowedposttags['metadata'] = [];
        $allowedposttags['pattern'] = [
            'id' => [],
            'patterncontentunits' => [],
            'width' => [],
            'height' => [],
        ];
        $allowedposttags['textpath'] = [];
        $allowedposttags['use'] = [
            'xlink:href' => [],
            'transform' => [],
        ];
        $allowedposttags['image'] = [
            'xlink:href' => [],
            'width' => [],
            'height' => [],
            'id' => [],
        ];
    }

    return $allowedposttags;
}

add_filter( 'wp_kses_allowed_html', 'auxin_allow_img_srcset_shortcode', 10, 2 );

function auxin_allow_css_properties( $properties ) {

    return array_merge( $properties, [
        'fill',
        'opacity',
        'stroke',
        'stroke-width',
        'stroke-opacity',
        'fill-opacity'
    ]);
}
add_filter( 'safe_style_css', 'auxin_allow_css_properties' );

/*-----------------------------------------------------------------------------------*/
/*  Add layout and other required classes to body tag
/*-----------------------------------------------------------------------------------*/

function auxin_body_class( $classes ) {
    global $post;

    if( is_string( $classes ) ){
        $classes = array( $classes );
    }

    $menu_layout = auxin_get_post_meta( $post, 'page_header_navigation_layout', 'default' ) ;
    $menu_layout = 'default' === $menu_layout ? auxin_get_option( 'site_header_top_layout', 'horizontal-menu-right' ) : $menu_layout ;

    $classes[] = THEME_ID;
    $classes[] = 'aux-dom-unready';
    $classes[] = 'boxed' == auxin_get_option( 'site_wrapper_size') ? 'aux-boxed' : 'aux-full-width';
    $classes[] = auxin_get_option( 'enable_site_reponsiveness', true ) ? 'aux-resp' : '';
    $classes['max_width_layout'] = 'aux-' . esc_attr( auxin_get_content_width() );

    if ( 'default' === $is_header_sticky = auxin_get_post_meta( $post, 'page_header_top_sticky', 'default' ) ) {
        $is_header_sticky = auxin_get_option( 'site_header_top_sticky', true );
    }

    if ( auxin_is_true( $is_header_sticky ) && 'vertical' !==  $menu_layout ) {
        $classes['top_header_sticky'] = 'aux-top-sticky';
    }

    $classes[] = auxin_get_option( 'page_preload_enable' ) ? 'aux-page-preload' : '';

    if ( auxin_get_option('page_animation_nav_enable') ) {
        $classes[] = 'aux-page-animation';
        $classes[] = 'aux-page-animation-' . esc_attr( auxin_get_option('page_animation_nav_type', 'fade') );
    }

    if( is_customize_preview() ){
        $classes[] = 'aux-customize-preview';
    }

    $sticky_footer = auxin_get_post_meta( $post, 'page_footer_is_sticky', 'default') ;
    $sticky_footer = 'default' === $sticky_footer ? auxin_get_option( 'site_footer_is_sticky', 'horizontal-menu-right' ) : $sticky_footer ;

    if( auxin_is_true( $sticky_footer ) ){
        $classes[] = 'aux-sticky-footer';
    }

    if( auxin_get_option( 'site_frame_show', false ) ){
        $classes[] = 'aux-framed';
    }

    if ( 'vertical' === $menu_layout ){
        $classes[] = 'aux-vertical-menu';
    }

    if ( ! auxin_is_true( auxin_get_option( 'page_animation_nav_enable', '0' ) ) ) {
        $classes[] = 'aux-page-animation-off';
    }

    if ( auxin_is_true( auxin_get_post_meta( $post, 'display_page_header_cover', 'default') ) ) {
        $classes[] = 'aux-page-cover';
    }

    return $classes;
}

add_filter( 'body_class', 'auxin_body_class', 12 );


/*-----------------------------------------------------------------------------------*/
/*  Apply shortcodes to widgets
/*-----------------------------------------------------------------------------------*/

add_filter( 'widget_text', 'do_shortcode');
add_filter( 'the_excerpt', 'do_shortcode');


/*-----------------------------------------------------------------------------------*/
/*  Adds background color for address bar
/*-----------------------------------------------------------------------------------*/

function auxin_comment_and_browser_features(){
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
    $color = auxin_get_option('site_mobile_browser_toolbar_color');
?>
<!-- Chrome, Firefox OS and Opera -->
<meta name="theme-color" content="<?php echo esc_attr( $color ); ?>" />
<!-- Windows Phone -->
<meta name="msapplication-navbutton-color" content="<?php echo esc_attr( $color ); ?>" />
<!-- iOS Safari -->
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">

<?php
}

add_action( 'wp_head', 'auxin_comment_and_browser_features' );

/*-----------------------------------------------------------------------------------*/
/*  Adds pingback for single pages
/*-----------------------------------------------------------------------------------*/

function auxin_add_header_pingback(){
    if ( is_singular() && pings_open() ) {
        printf( "<!-- pingback -->\n<link rel=\"pingback\" href=\"%s\">\n", get_bloginfo( 'pingback_url' ) );
    }
}

add_action( 'wp_head', 'auxin_add_header_pingback' );

/*-----------------------------------------------------------------------------------*/
/*  Adds the custom CSS class of the page to body element
/*-----------------------------------------------------------------------------------*/

function auxin_page_custom_css_class( $classes ){
    global $post;

    if( empty( $post ) || is_404() ){
        return $classes;
    }

    if( $body_class = get_post_meta( $post->ID, 'aux_custom_body_class', true ) ){
        $classes[] = trim( str_replace( '.', ' ', $body_class ) );
    }

    return $classes;
}

add_filter( 'body_class', 'auxin_page_custom_css_class' );

/*-----------------------------------------------------------------------------------*/
/*  Adds title bar and slider to header.php
/*-----------------------------------------------------------------------------------*/

add_action( 'auxin_after_inner_body_open' ,'auxin_the_top_header_section'        , 4 ); // top header section - priority 4 for elementor section hook
add_action( 'auxin_after_inner_body_open' ,'auxin_the_main_header_section'       , 4 ); // main header section - priority 4 for elementor section hook
add_action( 'auxin_after_inner_body_open', 'auxin_the_main_title_section'            ); // main title section
add_action( 'auxin_after_inner_body_open', 'auxin_the_header_slider_section'         ); // slider section
add_action( 'auxin_after_inner_body_open', 'auxin_the_archive_slider_section'        ); // post slider section


/*-----------------------------------------------------------------------------------*/
/*  Adds footer section to footer.php file
/*-----------------------------------------------------------------------------------*/

add_action( 'auxin_before_the_footer', 'auxin_the_site_footer' );

/*-----------------------------------------------------------------------------------*/
/*  Adds title bar and slider to header.php
/*-----------------------------------------------------------------------------------*/

add_action( 'auxin_before_body_close', 'auxin_add_hidden_blocks' );

/*-----------------------------------------------------------------------------------*/
/*  Don't generate the top slider for archive pages
/*-----------------------------------------------------------------------------------*/

function auxin_validate_the_header_slider_slug( $slider_slug, $post ){
    if( is_archive() ){
        $slider_slug = '';
    }
    return $slider_slug;
}
add_filter( 'auxin_header_slider_slug', 'auxin_validate_the_header_slider_slug', 10, 2 ); // slider section

/*-----------------------------------------------------------------------------------*/
/*  Adds goto top button to footer.php
/*-----------------------------------------------------------------------------------*/

function auxin_add_goto_top_btn(){

    global $post;

    if ( 'default' === $page_show_goto_top_btn = auxin_get_post_meta( $post, 'page_show_goto_top_btn', 'default' ) ) {
        $page_show_goto_top_btn = auxin_get_option( 'show_goto_top_btn', false );
    }

    if ( ! $page_show_goto_top_btn ) {
        return '';
    }

    if ( 'default' === $page_goto_top_alignment = auxin_get_post_meta( $post, 'page_goto_top_alignment', 'default' ) ) {
        $page_goto_top_alignment = auxin_get_option( 'goto_top_alignment', 'left' );
    }



    $goto_top = '<div class="aux-goto-top-btn aux-align-btn-'. esc_attr( $page_goto_top_alignment ) .'" data-animate-scroll="'. esc_attr( auxin_get_option('goto_top_animate') ) .'">'.
        '<div class="aux-hover-slide aux-arrow-nav aux-round aux-outline">'.
        '    <span class="aux-overlay"></span>'.
        '    <span class="aux-svg-arrow aux-h-small-up"></span>'.
        '    <span class="aux-hover-arrow aux-svg-arrow aux-h-small-up aux-white"></span>'.
        '</div>'.
    '</div>';

    echo $goto_top;
}

add_action( 'auxin_before_body_close', 'auxin_add_goto_top_btn' );

/*-----------------------------------------------------------------------------------*/
/*  Adds copyright and policy page to footer
/*-----------------------------------------------------------------------------------*/

add_action( 'auxin_footer_copyright_markup', 'auxin_footer_copyright_markup');

/*-----------------------------------------------------------------------------------*/
/*  Init customizer on demand
/*-----------------------------------------------------------------------------------*/

if( version_compare( PHP_VERSION, '5.3.0', '>=') ){

    function auxin_init_customizer(){
        if( is_customize_preview() ){
            Auxin_Customizer::get_instance()->maybe_render();
        }
    }

    add_action( 'init', 'auxin_init_customizer' );
}

/*-----------------------------------------------------------------------------------*/
/*  Change related posts plugin thumbnail size
/*-----------------------------------------------------------------------------------*/
function auxin_rp4wp_custom_thumbnail_size( $thumb_size ){
    return 'medium';
}
add_filter( 'rp4wp_thumbnail_size', 'auxin_rp4wp_custom_thumbnail_size' );


/*-----------------------------------------------------------------------------------*/
/*  Remove + symbol from the counter of wp ulike button plugin
/*-----------------------------------------------------------------------------------*/

function auxin_wp_ulike_number_format( $value, $num, $plus ){

    // If this function was called by ajax, get the post id from $_POST object, Otherwise, the global $post object
    if( ! ( isset( $_POST['id'] ) && $post = get_post( $_POST['id'] ) ) ){
        global $post;
    }

    if( empty( $post ) ){
        return $value;
    }

    if ( $num >= 1000 && get_option('wp_ulike_format_number') == '1' ){
        $value = round( $num / 1000, 2 ) . 'K';
    } else {
        $value = $num;
    }

    if( ( 'portfolio' == $post->post_type ) && ( is_single( $post ) ) ){

        return ( auxin_get_option( 'portfolio_single_like_button_type', false ) == 'icon' ) ? __( 'Likes', 'phlox-pro' ) . ' (' . $value . ')' : $value ;
    }

    return $value;
}
add_filter( 'wp_ulike_format_number','auxin_wp_ulike_number_format', 11, 3 );


/*-----------------------------------------------------------------------------------*/
/*  Register widgetized areas
/*-----------------------------------------------------------------------------------*/


function auxin_theme_widgets_init() {

    $dropdown_skin = auxin_get_option('sidebar_custom_dropdown', 0 );
    $extra_class   = auxin_is_true( auxin_get_option('sidebar_widget_togglable', 0 ) ) ?  'aux-toggle-widget ' : '';
    $extra_class  .= auxin_is_true( auxin_get_option('sidebar_widget_expand_on_init', 1 ) ) ? ' aux-open ' : '';
    $extra_class  .= 'none' != $dropdown_skin ? 'aux-custom-dropdown aux-dropdown-skin-' . $dropdown_skin  . ' ': '';

//---- Default sidebar widget areas --------------------------------------

    register_sidebar( array(
        'name'          => __( 'Global Primary Widget Area', 'phlox-pro'),
        'id'            => 'auxin-global-primary-sidebar-widget-area',
        'description'   => __( 'It is accessible everywhere on primary sidebars.' , 'phlox-pro'),
        'before_widget' => '<section id="%1$s" class="' . $extra_class .'widget-container %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>'
    ));

    register_sidebar( array(
        'name'          => __( 'Global Secondary Widget Area' , 'phlox-pro'),
        'id'            => 'auxin-global-secondary-sidebar-widget-area',
        'description'   => __( 'It is accessible everywhere on secondary sidebars.' , 'phlox-pro'),
        'before_widget' => '<section id="%1$s" class="' . $extra_class .'widget-container %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>'
    ));

    if ( function_exists('is_shop') ) {
        register_sidebar( array(
            'name'          => __( 'Shop Sidebar Widget Area' , 'phlox-pro'),
            'id'            => 'auxin-shop-sidebar-widget-area',
            'description'   => __( 'It is accessible on shop page sidebar.' , 'phlox-pro'),
            'before_widget' => '<section id="%1$s" class="' . $extra_class .'widget-container %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        ));
    }

    register_sidebar( array(
        'name'          => __( 'Pages Primary Widget Area' , 'phlox-pro'),
        'id'            => 'auxin-pages-primary-sidebar-widget-area',
        'description'   => __( 'It is accessible on primary sidebars except the blog pages.' , 'phlox-pro'),
        'before_widget' => '<section id="%1$s" class="' . $extra_class .'widget-container %2$s ">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>'
    ));

    register_sidebar( array(
        'name'          => __( 'Pages Secondary Widget Area' , 'phlox-pro'),
        'id'            => 'auxin-pages-secondary-sidebar-widget-area',
        'description'   => __( 'It is accessible on secondary sidebars except the blog pages.' , 'phlox-pro'),
        'before_widget' => '<section id="%1$s" class="' . $extra_class .'widget-container %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>'
    ));

    register_sidebar( array(
        'name'          => __( 'Blog Primary Widget Area' , 'phlox-pro'),
        'id'            => 'auxin-blog-primary-sidebar-widget-area',
        'description'   => __( 'It is accessible only on primary sidebars in blog pages.' , 'phlox-pro'),
        'before_widget' => '<section id="%1$s" class="' . $extra_class .'widget-container %2$s ">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>'
    ));

    register_sidebar( array(
        'name'          => __( 'Blog Secondary Widget Area' , 'phlox-pro'),
        'id'            => 'auxin-blog-secondary-sidebar-widget-area',
        'description'   => __( 'It is accessible only on secondary sidebars in blog pages.' , 'phlox-pro'),
        'before_widget' => '<section id="%1$s" class="' . $extra_class .'widget-container %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>'
    ));

    register_sidebar( array(
        'name'          => __( 'Search Result Widget Area' , 'phlox-pro'),
        'id'            => 'auxin-search-sidebar-widget-area',
        'description'   => __( 'It is accessible only on primary sidebars in search result page.' , 'phlox-pro'),
        'before_widget' => '<section id="%1$s" class="' . $extra_class .'widget-container %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>'
    ));


    //---- Footer sidebar (subfooter top bar) widget areas --------------------------------------
    register_sidebar( array(
        'name'          => __( 'Subfooter Bar Widget Area' , 'phlox-pro'),
        'id'            => 'auxin-subfooter-bar-widget-area',
        'description'   => __( 'The widget area above the subfooter section. Perfect for placing the "Newsletter", "Social icons" or "Instagram" widget.' , 'phlox-pro'),
        'before_widget' => '<section id="%1$s" class="widget-container %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>'
    ));

    //---- Footer sidebar widget areas --------------------------------------

    // get number of active subfooters
    // user can change this number via option panel
    $layout    = auxin_get_option( 'subfooter_layout' );
    $grid_cols = explode( '_', $layout);
    $col_nums  = count( $grid_cols );

    $footer_names = array( "First", "Second", "Third", "Fourth", "Fifth" );

    for ( $i=1; $i <= $col_nums; $i++ ) {

        register_sidebar( array(
            'name'          => sprintf(__( 'Subfooter %s Widget Area', 'phlox-pro'), $footer_names[ $i - 1 ]),
            'id'            => 'auxin-footer'.$i.'-sidebar-widget-area',
            'description'   => sprintf(__( 'The %s column in subfooter section.' , 'phlox-pro'), $footer_names[ $i - 1 ]),
            'before_widget' => '<section id="%1$s" class="widget-container %2$s _ph_">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
        ) );
    }

    unset( $layout, $grid_cols, $col_nums ,$footer_names );


    //---- Sidebar generator -------------------------------------------------------------

    // get and register all user define sidebars
    $auxin_sidebars = auxin_get_theme_mod( 'auxin_sidebars' );

    if( isset( $auxin_sidebars )  && ! empty( $auxin_sidebars ) ) {
        foreach( $auxin_sidebars as $key => $value ) {
            $sidebar_id = THEME_ID .'-'. strtolower( str_replace( ' ', '-', $value ) );

            register_sidebar( array(
                'name'          => $value,
                'id'            => $sidebar_id,
                'description'   => '',
                'before_widget' => '<section id="%1$s" class="widget-container %2$s _ph_">',
                'after_widget'  => '</section>',
                'before_title'  => '<h3 class="widget-title">',
                'after_title'   => '</h3>'
            ) );

        }
    }
}

add_action( 'widgets_init', 'auxin_theme_widgets_init' );




/**
 * Render metafield sections for page and post edit panel
 *
 */
function auxin_add_post_type_metafields(){

    // Load metabox fields on admin
    if( is_admin() ){

        $metabox_args = array(
            'post_type'     => 'post',
            'hub_id'        => 'axi_meta_hub_post',
            'hub_title'     => __('Post Options', 'phlox-pro' ),
            'to_post_types' => array('post')
        );
        auxin_maybe_render_metabox_hub_for_post_type( $metabox_args );

        $metabox_args = array(
            'post_type'     => 'page',
            'hub_id'        => 'axi_meta_hub_'. 'page',
            'hub_title'     => __('Page Options', 'phlox-pro' ),
            'to_post_types' => array('page')
        );
        auxin_maybe_render_metabox_hub_for_post_type( $metabox_args );

    }

}

add_action( 'init', 'auxin_add_post_type_metafields' );




/**
 * Add page preload animations
 *
 * @return void
 */
function auxin_add_page_preload_animation(){

    if ( class_exists( '\Elementor\Plugin' ) && \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
        return;
    }

    if ( auxin_get_option( 'site_frame_show', false ) ) {
        // insert a division for overlay page animations
        echo '<div class="aux-side-frames" data-thickness="20"></div>';
    }

    // insert progress bar element
    if ( auxin_get_option('page_preload_enable') ) {
        if ( auxin_get_option('page_preload_prgoress_bar') ) {
            $progressbar_style = auxin_get_option( 'page_preload_prgoress_bar_color' ) ? 'style="background-color:'.  esc_attr( auxin_get_option( 'page_preload_prgoress_bar_color' ) ) .';"' : '';
            $progressbar_style    = auxin_get_option( 'page_preload_prgoress_bar_color' ) ? 'style="background-color:'.  esc_attr( auxin_get_option( 'page_preload_prgoress_bar_color' ) ) .';"': '';
            $progressbar_position = 'aux-progressbar-' . auxin_get_option( 'page_preload_prgoress_bar_position' ) ;
        ?>
    <div id="pagePreloadProgressbar" class="aux-no-js <?php echo esc_attr( $progressbar_position ) ;?> " <?php echo $progressbar_style; ?> ></div>
        <?php
        }

        if ( auxin_get_option('page_preload_custom_loading') && auxin_get_option('page_preload_loading_image') ) {
        ?>
    <div id="pagePreloadLoading" class="aux-page-loading">
        <img src="<?php echo esc_url( auxin_get_attachment_url( auxin_get_option('page_preload_loading_image') , 'full' ) ); ?>" alt="<?php esc_attr_e( 'Loading', 'phlox-pro' ) ?>" >
    </div>
        <?php
        }
    }

    if ( auxin_get_option('page_animation_nav_enable') ) {
        // insert a division for overlay page animations
        $output  = '';
        $output .= '<div class="aux-page-animation-overlay">';
        $output .= 'slideup' === auxin_get_option('page_animation_nav_type') ? '<h2 class="aux-animation-title">' . get_bloginfo('name') . '</h2> <p class="aux-animation-desc">' . get_bloginfo('description') .'</p>' : '';
        $output .= '</div>';
        echo $output;
    }
}

add_action( 'auxin_after_body_open', 'auxin_add_page_preload_animation' );



/**
 * Adding support for new wp_body_open hook
 *
 * @since WP 5.2.0
 * @return void
 */
function auxin_do_wp_body_open(){
    do_action( 'wp_body_open' );
}
add_action( 'auxin_after_body_open', 'auxin_do_wp_body_open' );


/**
 * Add anim attributes to body element
 *
 * @param  array   $attributes List of default attributes
 * @return array               List of modified attributes
 */
function auxin_add_body_anim_attributes( $attributes ){
    if ( auxin_get_option('page_animation_nav_enable') ) {
        $attributes['data-page-animation'] = 'true';
        $attributes['data-page-animation-type'] = auxin_get_option( 'page_animation_nav_type', 'fade' );
    }
    $attributes['data-framed'] = (string) auxin_get_option( 'site_frame_show', '0' );

    return $attributes;
}
add_filter( 'auxin_body_attributes', 'auxin_add_body_anim_attributes' );



/**
 * Add required attributes to site_header element
 *
 * @param  array   $attributes List of default attributes
 * @return array               List of modified attributes
 */
function auxin_add_site_header_attributes( $attributes ){

    global $post;

    if ( ! isset( $attributes['class'] ) ){
        $attributes['class'] = '';
    }

    if ( ! isset( $attributes['style'] ) ) {
        $attributes['style'] = '';
    }

    $display_top_header = auxin_get_option( 'show_topheader' ) ;

    if ( 'default' === $overlay_header = auxin_get_post_meta( $post, 'page_overlay_header', 'default' ) ) {
       $overlay_header = auxin_get_option('site_overlay_header');
    }

    if ( 'default' === $header_animation = auxin_get_post_meta( $post, 'page_header_animation', 'default' ) ) {
       $header_animation = auxin_get_option('site_header_animation');
    }

    if ( 'default' === $add_border = auxin_get_post_meta( $post, 'page_header_border_bottom', 'default' ) ) {
       $add_border = auxin_get_option('site_header_border_bottom');
    }

    if ( 'default' === $header_width = auxin_get_post_meta( $post, 'page_header_width', 'default' ) ) {
       $header_width = auxin_get_option('site_header_width');
    }

    if ( 'default' === $header_color_scheme = auxin_get_post_meta( $post, 'page_header_color_scheme', 'default' ) ) {
       $header_color_scheme = auxin_get_option('site_header_color_scheme');
    }

    $attributes['class'] .= 'site-header-section ';
    $attributes['class'] .= 'aux-territory aux-' . esc_attr( $header_width ) . '-container ';
    $attributes['class'] .= 'aux-header-' . esc_attr( $header_color_scheme ) . ' ' ;
    $attributes['class'] .=  auxin_is_true( $add_border ) ? 'aux-add-border ' : '';
    $attributes['class'] .=  auxin_is_true( $header_animation ) ? 'aux-animate-in ' : '';
    $attributes['class'] .= 'logo-left-menu-right-over' === auxin_get_top_header_layout() ? ' aux-over-content ' : '';

    if ( auxin_is_true ( $overlay_header ) ) {
        $attributes['class'] .= auxin_is_true( $display_top_header ) ? 'aux-overlay-with-tb ' : 'aux-overlay-header ';
    }

    if ( auxin_is_true( $header_animation ) ) {
        if ( 'default' === $header_animation_delay = auxin_get_post_meta( $post, 'page_header_animation_delay', 'default' ) ) {
           $header_animation_delay = auxin_get_option('site_header_animation_delay');
        }
        if ( $header_animation_delay != '0' ) {
            $attributes['style'] .= 'animation-delay:' . esc_attr( $header_animation_delay ) . 's';
        }
    }

    if ( 'default' === $attributes['data-sticky-height'] = auxin_get_post_meta( $post, 'page_header_container_scaled_height', 'default' ) ) {
        $attributes['data-sticky-height'] = auxin_get_option( 'site_header_container_scaled_height','60' );
    }

    if ( 'default' === $is_header_sticky = auxin_get_post_meta( $post, 'page_header_top_sticky', 'default' ) ) {
        $is_header_sticky = auxin_get_option( 'site_header_top_sticky', true );
    }

    if( auxin_is_true( $is_header_sticky ) ){
        $attributes['data-color-scheme'] = $header_color_scheme;

        if ( 'default' === $attributes['data-sticky-scheme'] = auxin_get_post_meta( $post, 'page_header_sticky_color_scheme', 'default' ) ) {
            $attributes['data-sticky-scheme'] = auxin_get_option( 'site_header_sticky_color_scheme' );
        }
    }

    return $attributes;
}
add_filter( 'auxin_site_header_attributes', 'auxin_add_site_header_attributes' );

/**
 * Compile custom styles and scripts on theme activation
 *
 * @return void
 */
function auxin_save_styles_on_theme_activation() {
    add_action( 'admin_init', array( Auxin_Option::api()->controller, 'save_custom_assets' ), 12 );
    flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'auxin_save_styles_on_theme_activation' );


/**
 * Add Hentry Class to Post Classes
 *
 * @return void
 */
function auxin_modify_post_class ($classes, $class, $post_id ){

    if ( is_search() && false ===  array_search( 'hentry', $classes ) ) {
             $classes[] = 'hentry';
        }
    return $classes;
}

add_filter( 'post_class', 'auxin_modify_post_class', 22, 3 );


/**
 * Generate the page builder content markup for blog template
 *
 * @param  string $the_content_markup    The page builder content with corresponding containers
 * @param  string $content               The page content
 * @param  string $page_content_location The location that page builder content should appear
 * @return string                        The page markup
 */
function auxin_get_the_blog_page_template_content_markup( $the_content_markup, $content, $page_content_location ){

    if( ! empty( $content ) ){
        $layout_classes = in_array( $page_content_location, array( 'above-boxed', 'below-boxed' ) ) ? 'aux-fold aux-center-margin clearfix' : '';

        ob_start();
        ?>
        <article <?php post_class( $layout_classes ); ?> >
            <div class="entry-main">
                <div class="entry-content">
                <?php
                    echo $content;
                    // clear the floated elements at the end of content
                    echo '<div class="clear"></div>';
                ?>
                </div>
            </div>
        </article>
        <?php
        $the_content_markup = ob_get_clean();
    }

    return $the_content_markup;
}
add_filter( 'auxin_blog_page_template_content_markup', 'auxin_get_the_blog_page_template_content_markup', 10, 3 );


/**
 * Enable modern form stylesheet
 *
 * @return array
 */
function auxin_modern_comment_form( $comment_form, $params ){

    $skin          = auxin_get_option( 'comment_forms_skin', 'classic' );
    $layout        = auxin_get_option( 'comment_forms_layout', 'default' );
    $inputs        = auxin_get_option( 'comment_forms_inputs', array( 'email', 'name' ,'url' ) );
    $reply_title   = auxin_get_option( 'comment_forms_replay_title', __( 'Add a Comment', 'phlox-pro' ) );
    $comment_notes = auxin_get_option( 'comment_forms_notes', __( 'Your email address will not be published. Required fields are marked *', 'phlox-pro' ) );
    $use_label     = auxin_get_option( 'comment_forms_label', '0' ) ;
    $use_label     = auxin_is_true( $use_label );

    $layout = 'default' !== $layout ? 'aux-form-inline-' . esc_attr( $layout ) . ' ' : '';

    $comment_form['class_form']  = 'modern' === $skin  ? 'aux-modern-form ': 'comment-form ';
    $comment_form['class_form'] .= $layout;

    extract( $params );

    if ( $use_label ||  'classic' != $skin ) {
        $comment_form['fields']['author'] = '<label for = "author">' . $author_label . '</label>' . $comment_form['fields']['author'];
        $comment_form['fields']['email']  = '<label for = "email">' . $email_label . '</label>' . $comment_form['fields']['email'];
        $comment_form['fields']['url']    = '<label for = "url">' . $url_label . '</label>' . $comment_form['fields']['url'];
        $comment_form['comment_field']    = '<label for = "comment">' . $textarea_label . '</label>' . $comment_form['comment_field'];
    }

    foreach( $comment_form['fields'] as $field => $output ) {
        if ( ! in_array( $field, $inputs )) {
            unset( $comment_form['fields'][$field]);
        }
    }

    if ( 'modern' === $skin ) {

        foreach( $comment_form['fields'] as $field => $output ) {
            if ( 'cookies' !== $field ) {
                preg_match_all('/placeholder="([^"]*)"/',$output , $placeholder);
                $output                         = str_replace( $placeholder[0][0], '', $output);
                $comment_form['fields'][$field] = '<div class = "aux-input-group aux-inline-inputs">' . $output .'<div class="aux-modern-form-border"></div></div>';
            }
        }

        preg_match_all('/placeholder="([^"]*)"/',$comment_form['comment_field'] , $placeholder);
        $comment_form['comment_field'] = str_replace( $placeholder[0][0], '', $comment_form['comment_field']);
        $comment_form['comment_field'] = '<div class="aux-input-group aux-block-inputs">' . $comment_form['comment_field'] .'<div class="aux-modern-form-border"></div></div>';
    } else {
        foreach( $comment_form['fields'] as $field => $output ) {
            if ( 'cookies' !== $field ) {
                $comment_form['fields'][$field] = '<div class="aux-input-group aux-inline-inputs">' . $comment_form['fields'][$field] . '</div>';
            }
        }
        $comment_form['comment_field'] = '<div class="aux-input-group aux-block-inputs">' . $comment_form['comment_field'] .'</div>';
    }

    $comment_form['title_reply']          = '<span>' .$reply_title . '</span>';
    $comment_form['comment_notes_before'] = '<p class = "comment-notes">' . $comment_notes .'</p>';

    return $comment_form;
}

add_filter( 'auxin_default_comment_form', 'auxin_modern_comment_form', 10, 2 );

/**
 * Since WorePress 4.4 comment textarea section moves to top
 * this function moves it back to the bottom in comment fields
 *
 */
function auxin_move_comment_field_to_bottom( $fields ) {
    $comment_field     = $fields['comment'];
    unset( $fields['comment'] );
    $fields['comment'] = $comment_field;

    if ( auxin_get_option( 'comment_forms_skin', 'classic' ) !== 'modern' ) {
        $comment_field     = $fields['comment'];
        unset( $fields['comment'] );
        $fields['comment'] = $comment_field;
    }

    return $fields;
}

add_filter( 'comment_form_fields', 'auxin_move_comment_field_to_bottom' );

/**
 * MediaElement JS Settings Override
 *
 */

function auxin_media_element_settings( $settings ) {
    $settings['stretching'] = 'auto';
    return $settings;
}
add_filter('mejs_settings', 'auxin_media_element_settings');
