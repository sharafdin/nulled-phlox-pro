<?php
/**
 * Header Template Functions.
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */


/**
 * Display comments
 *
 * @since 2.0.0
 */
if( ! function_exists( 'auxin_comment' ) ){

    function auxin_comment( $comment, $args, $depth ) {
       global $post;
       $GLOBALS['comment'] = $comment;
       $avatar_size        = auxin_get_option('comment_avatar_size', '60');
       $author_indicator   = $comment->user_id === $post->post_author ? '<span class = "author-indicator">' . esc_html__('Author', 'phlox-pro' ) . '</span>': '';
       ?>
       <li>
         <article <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
           <?php echo get_avatar( $comment, $avatar_size, '' ); ?>
           <header class="comment-author vcard">
              <?php printf( '<cite class="fn">%s</cite>', get_comment_author_link() . $author_indicator ) ?>
              <time><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s', 'phlox-pro'), get_comment_date(),  get_comment_time() ) ?></a></time>
              <?php if ( $comment->comment_approved == '0' ) : ?>
                  <em><?php _e('Your comment is awaiting moderation.', 'phlox-pro') ?></em>
                  <br />
               <?php endif; ?>
              <?php edit_comment_link(__('(Edit)', 'phlox-pro'),'  ','') ?>
           </header>

           <div class="comment-body">
               <?php comment_text() ?>
           </div>

           <nav class="comment-reply-nav">
             <?php comment_reply_link( array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
           </nav>
         </article>
        <!-- </li> is added by wordpress automatically -->
    <?php
    }

}




function auxin_single_page_navigation( $args = array() ){

    global $post;

    $defaults = array(
        'prev_text'      => __( '&larr; Previous Post', 'phlox-pro' ),
        'next_text'      => __( 'Next &rarr;'    , 'phlox-pro' ),
        'skin'           => 'thumb-arrow',
        'show_title'     => true,
        'taxonomy'       => 'category',
        'excluded_terms' => '',
        'archive_button' => '',
        'echo'           => true
    );

    $args = wp_parse_args( $args, $defaults );

    $overlay_color = 'linear-gradient( rgba(255, 255, 255, 0.8), rgba(255, 255, 255, 0.8) )';

    $portfolio_archive_link    = esc_url( get_post_type_archive_link( 'portfolio' ) );
    $portfolio_link_customizer = esc_url( auxin_get_option( 'portfolio_single_next_prev_nav_btn_link' ) );
    $portfolio_link_metafield  = esc_url( auxin_get_post_meta( $post, '_next_prev_nav_btn_link') );
    $portfolio_link_customizer = empty( $portfolio_link_customizer ) ? $portfolio_archive_link :  $portfolio_link_customizer;
    $portfolio_link_btn        = empty( $portfolio_link_metafield ) ? $portfolio_link_customizer : $portfolio_link_metafield ;

    switch ( $args['skin'] ) {
        case 'boxed-image-dark':
            $css_class     = 'nav-skin-boxed-image aux-dark-th';
            $args['skin']  = 'boxed-image';
            $overlay_color = 'linear-gradient( rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7) )';
            break;
        case 'thumb-no-arrow':
            $css_class     = 'nav-skin-thumb-arrow no-arrow';
            $args['skin']  = 'thumb-arrow';
            break;
        case 'thumb-arrow-sticky':
            $css_class     = 'nav-skin-thumb-arrow aux-sticky-nav';
            $args['skin']  = 'thumb-arrow';
            break;
        case 'classic':
            $css_class              = 'nav-skin-classic';
            $args['show_title']     = false;
            $args['archive_button'] = 'classic';
            $args['btn_link']       = $portfolio_link_btn;
            break;
        case 'classic-title':
            $css_class              = 'nav-skin-classic';
            $args['archive_button'] = 'classic';
            $args['btn_link']       = $portfolio_link_btn;
            break;
        case 'modern':
            $css_class              = 'nav-skin-modern';
            $args['archive_button'] = 'square';
            $args['show_title']     = false;
            $args['btn_link']       = $portfolio_link_btn;
            break;
        default:
            $css_class     = 'nav-skin-'. $args['skin'];
            break;
    }

    if( ! $args['echo'] ){
        ob_start();
    }
?>

    <nav class="aux-next-prev-posts <?php echo esc_attr( $css_class ); ?>">

        <?php $prev_post = get_adjacent_post( false, $args['excluded_terms'], true, $args['taxonomy'] );
              if ( is_a( $prev_post, 'WP_Post' ) ) {
                $nav_image = 'thumb-arrow' == $args['skin'] ? auxin_get_the_post_thumbnail( $prev_post, 80, 80, true ) : '';
                $style     = '';
                if( 'boxed-image' == $args['skin'] ){
                    $nav_image = esc_url( auxin_get_the_attachment_url( $prev_post, 'medium' ) );
                    $style     = 'background-image: '. $overlay_color .', url('.$nav_image.');';
                }

                $container_style =  !empty( $style ) ? 'style="' .esc_attr( $style ).'"' : '';
        ?>
        <section class="np-prev-section <?php echo $nav_image ? 'has-nav-thumb':''; ?>"  <?php echo ( $container_style ) ;?> >
            <a href="<?php echo get_permalink( $prev_post->ID ); ?>">
                <div class="np-arrow">
                    <?php if( 'thumb-arrow' == $args['skin'] ){ ?>
                    <div class="aux-hover-slide aux-arrow-nav aux-outline">
                        <span class="aux-svg-arrow aux-medium-left"></span>
                        <span class="aux-hover-arrow aux-svg-arrow aux-medium-left"></span>
                    </div>
                    <?php echo $nav_image;
                    } else { ?>
                    <div class="aux-arrow-nav aux-hover-slide aux-round aux-outline aux-medium">
                        <span class="aux-overlay"></span>
                        <span class="aux-svg-arrow aux-medium-left"></span>
                        <span class="aux-hover-arrow aux-svg-arrow aux-medium-left aux-white"></span>
                    </div>
                    <?php } ?>
                </div>
                <p class="np-nav-text"><?php echo esc_html( $args['prev_text'] ); ?></p>
                <?php if( $args['show_title'] ){ ?>
                <h4 class="np-title"><?php echo get_the_title( $prev_post->ID ); ?></h4>
                <?php } ?>
            </a>
        </section>
        <?php } ?>

        <?php if ( 'classic' == $args['archive_button'] ){ ?>
            <div class="aux-port-archive-btn">
                <a href="<?php echo esc_url( $args['btn_link'] ) ;?> ">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                      <path id="main_folios" data-name="main portfolio" class="ico-main-port" d="M742,847h3v3h-3v-3Zm7,0h3v3h-3v-3Zm7,0h3v3h-3v-3Zm-14,7h3v3h-3v-3Zm7,0h3v3h-3v-3Zm7,0h3v3h-3v-3Zm-14,7h3v3h-3v-3Zm7,0h3v3h-3v-3Zm7,0h3v3h-3v-3Z" transform="translate(-742 -847)"/>
                    </svg>

                </a>
            </div>
        <?php } elseif ( 'square' == $args['archive_button'] ) { ?>
            <div class="aux-port-archive-btn">
                <a href="<?php echo  $args['btn_link'] ;?> ">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="4499 3684 14 14">
                <defs>
                  <style>
                    .cls-1 {
                      fill: #3d3d3d;
                    }
                  </style>
                </defs>
                <g id="back_to_portfolio" data-name="back to  portfolio" transform="translate(3749 2104)">
                  <rect id="Rectangle_8" data-name="Rectangle 8" class="cls-1" width="6" height="6" transform="translate(750 1580)"/>
                  <rect id="Rectangle_10" data-name="Rectangle 10" class="cls-1" width="6" height="6" transform="translate(750 1588)"/>
                  <rect id="Rectangle_9" data-name="Rectangle 9" class="cls-1" width="6" height="6" transform="translate(758 1580)"/>
                  <rect id="Rectangle_11" data-name="Rectangle 11" class="cls-1" width="6" height="6" transform="translate(758 1588)"/>
                </g>
              </svg>
                </a>
            </div>
        <?php } ?>

        <?php $next_post = get_adjacent_post( false, $args['excluded_terms'], false, $args['taxonomy'] );
              if ( is_a( $next_post, 'WP_Post' ) ) {
                $nav_image = 'thumb-arrow' == $args['skin'] ? auxin_get_the_post_thumbnail( $next_post, 80, 80, true ) : '';
                $style     = '';
                if( 'boxed-image' == $args['skin'] ){
                    $nav_image = esc_url( auxin_get_the_attachment_url( $next_post, 'medium' ) );
                    $style     = 'background-image: '. $overlay_color .', url('. $nav_image .');';
                }

                $container_style =  !empty( $style ) ? 'style="' .esc_attr( $style ).'"' : '';

        ?>
        <section class="np-next-section <?php echo $nav_image ? 'has-nav-thumb':''; ?>" <?php echo ( $container_style ) ;?> >
            <a href="<?php echo get_permalink( $next_post->ID ); ?>">
                <div class="np-arrow">
                    <?php if( 'thumb-arrow' == $args['skin'] ){ ?>
                    <div class="aux-arrow-nav aux-hover-slide aux-outline">
                        <span class="aux-svg-arrow aux-medium-right"></span>
                        <span class="aux-hover-arrow aux-svg-arrow aux-medium-right"></span>
                    </div>
                    <?php echo $nav_image;
                    } else { ?>
                    <div class="aux-arrow-nav aux-hover-slide aux-round aux-outline aux-medium">
                        <span class="aux-overlay"></span>
                        <span class="aux-svg-arrow aux-medium-right"></span>
                        <span class="aux-hover-arrow aux-svg-arrow aux-medium-right aux-white"></span>
                    </div>
                    <?php } ?>
                </div>
                <p class="np-nav-text"><?php echo esc_html( $args['next_text'] ); ?></p>
                <?php if( $args['show_title'] ){ ?>
                <h4 class="np-title"><?php echo get_the_title( $next_post->ID ); ?></h4>
                <?php } ?>
            </a>
        </section>
        <?php } ?>

    </nav>
<?php
    if( ! $args['echo'] ){
        return ob_get_clean();
    }
}






/**
 * Display the classes for the main content element.
 *
 * @since 2.0.0
 *
 * @param string|array $class One or more classes to add to the class list.
 */
function auxin_content_main_class( $class = '' ){
    // Separates classes with a single space, collates classes
    echo 'class="' . join( ' ', auxin_get_content_main_css_classes( $class ) ) . '"';
}

    /**
     * Retrieve the css classes for the main content element as an array.
     *
     * @since 2.0.0
     *
     * @param string|array $class One or more classes to add to the class list.
     * @return array Array of classes.
     */
    function auxin_get_content_main_css_classes( $class = '' ){
        global $post;

        $classes = array(
            'territory'     => 'aux-main aux-territory',
            'template_type' => ''
        );

        $sidebar_decoration = '';

        if( is_page() ){
            $classes[] = 'aux-single aux-page';
            if( has_shortcode( $post->post_content, 'auxshp-wishlist-page') ) {
                $classes[] .= 'woocommerce';
            }
        }
        if( is_single() ){
            $classes[] = 'aux-single';
        }
        if( is_archive() ){
            $classes[''] = 'aux-archive';
        }
        if( is_home() ){
            $classes[] = 'aux-home aux-archive';
        }
        if( is_tax() ){
            $classes[] = 'aux-tax';
        }
        if( is_search() ){
            $classes[] = 'aux-search';

            if ( class_exists( 'AUXELS' ) )
            	$classes[] = 'aux-advanced-search';
        }


        // Check if WooCommerce is active
        if ( class_exists('WooCommerce') ) {
            if( is_product_category() || is_product_tag() ){
                $classes[] = 'aux-shop-archive';
                $sidebar_decoration = auxin_get_option( 'product_category_sidebar_decoration' );
            } elseif( is_product() ){
                $sidebar_decoration = auxin_get_option( 'product_single_sidebar_decoration' );
            } elseif( is_shop() ){
                $classes[] = 'aux-shop-archive';
                $sidebar_decoration = auxin_get_option( 'product_index_sidebar_decoration' );
            }
        }

        if( is_singular() ){

            // if the page is 'page template' for blog archive
            if( is_page_template() ){

                // get current page template slug
                $page_template = get_page_template_slug( get_queried_object_id() );

                // the list of known archive template types
                $blog_page_template_types = array(
                    'blog-type-default.php'  => 'default',
                    'blog-type-1.php'  => '1',
                    'blog-type-2.php'  => '2',
                    'blog-type-3.php'  => '3',
                    'blog-type-4.php'  => '4',
                    'blog-type-5.php'  => '5',
                    'blog-type-6.php'  => '6',
                    'blog-type-7.php'  => '7',
                    'blog-type-8.php'  => '8',
                    'blog-type-9.php'  => '9',
                    'blog-type-10.php' => '10'
                );

                // assign proper template type class base on the name of blog 'page template'. ie $page_template can be 'templates/blog1.php'
                foreach ( $blog_page_template_types as $blog_template_slug => $blog_template_type ) {
                    if( false !== strpos( $page_template, $blog_template_slug ) ){
                        $classes['template_type'] = 'aux-template-type-' . $blog_template_type;
                        $classes[] = 'aux-archive';
                        break;
                    }
                }

            }

            global $auxin_content_layout;
            if( 'full' === $auxin_content_layout ){
                $classes[] = 'aux-full-container';
            } else {
                $classes[] = 'aux-boxed-container';
            }

            // ----------------------
            if( $post ){

                if( 'default' === $show_top_margin = auxin_get_post_meta( $post, 'show_content_top_margin', 'default' ) ){
                    $show_top_margin = auxin_get_option( $post->post_type . '_show_content_top_margin', true );
                }
                $classes['content_top_margin'] = auxin_is_true( $show_top_margin )? 'aux-content-top-margin' : '';

                if( 'default' === $sidebar_decoration = auxin_get_post_meta( $post, 'page_sidebar_style', 'default' ) ){
                    $sidebar_decoration = auxin_get_option( $post->post_type . '_single_sidebar_decoration', 'simple' );
                }

            }

        // if it is default blog index page
        } elseif( is_home() || is_post_type_archive( 'post' ) ){

            $classes['template_type'] = 'aux-template-type-' . auxin_get_option( 'post_index_template_type', 'default' );

            $classes['content_top_margin'] = 'aux-content-top-margin';
            $sidebar_decoration = auxin_get_option( 'post_index_sidebar_decoration' );

        } elseif( is_tax() ){

            // add list-{post_type} class for all archive listing pages
            if( ! empty( $post ) ){
                $classes['template_type'] = 'aux-template-type-' . auxin_get_option( $post->post_type . '_taxonomy_archive_template_type', 'default' );
                $classes[] = 'list-'. get_post_type();
            }

            $classes['content_top_margin'] = 'aux-content-top-margin';

        } elseif( is_archive() ){


            if( is_category() || is_tag() || is_author() ){ // for category.php
                $classes['template_type'] = 'aux-template-type-' . auxin_get_option( 'post_taxonomy_archive_template_type', 'default' );

            } elseif( $post ) { // for archive.php
                $classes['template_type'] = 'aux-template-type-' . auxin_get_option( $post->post_type . '_index_template_type', 'default' );
            }

            $classes['content_top_margin'] = 'aux-content-top-margin';

            $sidebar_decoration = $post ? auxin_get_option( $post->post_type . '_index_sidebar_decoration' ) : '';

            // add list-{post_type} class for all archive listing pages
            if( ! empty( $post ) ){
                $classes[] = 'list-'. get_post_type();
            }

        } elseif( is_search() ){
            $classes['template_type'] = 'aux-template-type-side-media';
            $classes['content_top_margin'] = 'aux-content-top-margin';
        } elseif( is_404() ){

        }

        if ( class_exists( 'AUXSHP' ) && class_exists( 'WooCommerce' ) ) {

            if ( is_shop() ) {
                $show_top_margin = auxin_get_option('product_index_top_content_margin', '1') ;
                $classes['content_top_margin'] = auxin_is_true( $show_top_margin ) ? 'aux-content-top-margin' : '';
            }
        }

        // ----------------------------

        $classes['sidebar_pos']   = auxin_get_page_sidebar_pos( $post );

        // ----------------------------

        if( $sidebar_decoration ){
            $classes['sidebar_border'] = 'aux-sidebar-style-'. esc_attr( $sidebar_decoration ); // aux-sidebar-style-overlap , aux-sidebar-style-border
        }

        // escape the class name for template type
        $classes['template_type'] = esc_attr( $classes['template_type'] );

        // ----------------------------

        $classes['user_entry']    = 'aux-user-entry';

        // determine if the content has sidebar
        if( 'no-sidebar' !== $classes['sidebar_pos'] && ( auxin_primary_sidebar_has_content() || auxin_secondary_sidebar_has_content() ) ){
            $classes['sidebar_pos'] .= ' aux-has-sidebar';
        }

        $classes = auxin_merge_css_classes( $classes, $class );

        /**
         * Filter the list of CSS content classes for the current post or page.
         *
         * @since 2.0.0
         *
         * @param array  $classes An array of main content classes.
         * @param string $class   A comma-separated list of additional classes added to the header.
        */
        $classes = apply_filters( 'auxin_content_main_class', $classes, $class );

        return array_unique( $classes );
    }


//// prints site socials   /////////////////////////////////////////////////////////

// print site socials ///
function auxin_the_socials( $args = array() ) {
    echo auxin_get_the_socials( $args );
}

    if( ! function_exists( 'auxin_get_the_socials' ) ){

        // get site socials ///
        function auxin_get_the_socials( $args = array() ) {

            $defaults = array(
                'css_class'          => '',
                'direction'          => 'horizontal',
                'size'               => 'medium', // small, menium, large, extra large
                'social_list'        => '',
                'social_list_type'   => 'site',
                'fill_social_values' => true
            );

            $args = wp_parse_args( $args, $defaults );

            $output = array();

            $args['css_class'] .= ' aux-' . $args['direction'];
            $args['css_class'] .= ' aux-' . $args['size'];

            $brand_color       = auxin_get_option('socials_brand_color') ;
            $brand_color_hover = auxin_get_option('socials_brand_color_hover') ;

            if ( auxin_is_true ( $brand_color ) && ! auxin_is_true( $brand_color_hover ) ) {
                $args['css_class'] .= ' aux-brand-color';
            } elseif ( ! auxin_is_true ( $brand_color ) && auxin_is_true( $brand_color_hover ) ){
                $args['css_class'] .= ' aux-brand-color-hover';
            }


            $args['css_class']  = esc_attr( $args['css_class'] );

            $socials            = $args['social_list'] ? $args['social_list'] : auxin_get_social_list( $args['social_list_type'], $args['fill_social_values'] );


            $output['open_container_tag'] = "<section class=\"widget-socials aux-socials-container {$args['css_class']}\">\n";
            $output['open_tag'] = "<ul class=\"aux-social-list\">\n";

                $markup_template = '<li ><a class="%s" href="%s" target="_blank" ><span class="auxicon-%s"></span></a></li>';

                // get all socials links from site options and generate appropriate markup
                foreach ( $socials as $name => $value ) {
                    if( ! empty( $value ) ){
                        $name = esc_attr( $name );
                        $output[ $name ] = sprintf( $markup_template, $name, esc_url( $value ), $name );
                    }
                }

            $output['close_tag'] = "</ul><!-- end socials -->\n";
            $output['close_container_tag'] = "</section><!-- end socials container -->\n";

            $output = apply_filters( 'auxin_get_the_socials', $output, $socials, $markup_template);

            if( is_array( $output ) ){
              $output = implode( "\n\t\t", $output );
            }

            return $output;
        }

    }



function auxin_parse_top_header_layout( $args ){
    global $post;

    $display_topheader_cart = auxin_get_option('show_topheader_cart');

    // top header layout option
    if ( 'default' === $layout_name = auxin_get_post_meta( $post, 'aux_topheader_layout', 'default' ) ) {
        $layout_name = auxin_get_option( 'site_top_header_layout' );
    };

    switch ( $layout_name ) {

        case 'topheader1':
            $args['container'] = array(
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['message'] = array(
                'order'        => 10,
                'align'        => 'left', // left, right
                'phone_align'  => 'center', // left, right
                'enable'       => false,
                'desktop'      => true,
                'tablet'       => true,
                'phone'        => true
            );
            $args['search'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['social'] = array(
                'order'  => 20,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['menu'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['cart'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            break;

        case 'topheader2':
            $args['message'] = array(
                'order'       => 10,
                'align'       => 'left', // left, right
                'phone_align' => 'center', // left, right
                'enable'      => true,
                'desktop'     => true,
                'tablet'      => true,
                'phone'       => true
            );
            $args['search'] = array(
                'order'  => 6,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['social'] = array(
                'order'  => 8,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['cart'] = array(
                'order'  => 7,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['menu'] = array(
                'order'  => 20,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            break;

        case 'topheader3':
            $args['container'] = array(
                'desktop' => true,
                'tablet'  => true,
                'phone'   => false
            );
            $args['message'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['search'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['social'] = array(
                'order'  => 30,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['menu'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['cart'] = array(
                'order'  => 20,
                'align'  => 'right', // left, right
                'enable' => $display_topheader_cart,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            break;

        case 'topheader4':
            $args['message'] = array(
                'order'        => 50,
                'align'        => 'right', // left, right
                'tablet_align' => 'left', // left, right
                'phone_align'  => 'center', // left, right
                'enable'       => true,
                'desktop'      => true,
                'tablet'       => true,
                'phone'        => true
            );
            $args['search'] = array(
                'order'  => 20,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['social'] = array(
                'order'  => 40,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['cart'] = array(
                'order'  => 30,
                'align'  => 'right', // left, right
                'enable' => $display_topheader_cart,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['menu'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            break;

        case 'topheader5':
            $args['message'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['search'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['social'] = array(
                'order'  => 20,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['menu'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['cart'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => $display_topheader_cart,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            break;

        case 'topheader6':
            $args['message'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['search'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['social'] = array(
                'order'  => 30,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['menu'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['cart'] = array(
                'order'  => 20,
                'align'  => 'right', // left, right
                'enable' => $display_topheader_cart,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            break;

        case 'topheader7':
            $args['message'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['search'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['social'] = array(
                'order'  => 20,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['menu'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['cart'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'phone_align'  => 'left', // left, right
                'enable' => $display_topheader_cart,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            break;

        case 'topheader8':
            $args['message'] = array(
                'order'  => 40,
                'align'  => 'right', // left, right
                'tablet_align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['search'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['social'] = array(
                'order'  => 30,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => true
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['menu'] = array(
                'order'  => 20,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['cart'] = array(
                'order'  => 20,
                'align'  => 'right', // left, right
                'enable' => $display_topheader_cart,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            break;

        case 'topheader9':

            $args['message'] = array(
                'align'  => 'left', // left, right
                'tablet_align'  => 'left', // left, right
                'order'  => 10,
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );

            $args['secondary_message'] = array(
                'align'  => 'right', // left, right
                'tablet_align'  => 'right', // left, right
                'phone_align'  => 'right', // left, right
                'order'  => 20,
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );

            $args['search'] = array(
                'enable' => false,
                'order'  => 30,
                'align'  => 'left', // left, right
            );
            $args['social'] = array(
                'enable' => false,
                'order'  => 40,
                'align'  => 'left', // left, right
            );
            $args['language'] = array(
                'enable' => false,
                'order'  => 50,
                'align'  => 'left', // left, right
            );
            $args['flag'] = array(
                'enable' => false,
                'order'  => 60,
                'align'  => 'left', // left, right
            );
            $args['menu'] = array(
                'enable' => false,
                'order'  => 70,
                'align'  => 'left', // left, right
            );
            $args['cart'] = array(
                'enable' => false,
                'order'  => 80,
                'align'  => 'left', // left, right
            );
            break;

        case 'topheader6':
        default:

            $args['message'] = array(
                'order'  => 20,
                'align'  => 'right', // left, right
                'phone_align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['search'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['social'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['menu'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['cart'] = array(
                'order'  => 20,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );

            break;
    }

    $args['social']['tablet'] = auxin_is_true( auxin_get_option('socials_hide_on_tablet', '1') ) ;
    $args['social']['phone']  = auxin_is_true( auxin_get_option('socials_hide_on_phone', '1') ) ;

    return $args;
}
add_filter( 'auxin_top_header_args', 'auxin_parse_top_header_layout' );



function auxin_get_top_header_markup( $args = '' ){
    global $post;

    $defaults = array(
        'class_names' => 'aux-container aux-fold aux-float-wrapper', // classnames over container
        'container' => array(
            'desktop' => true,
            'tablet'  => true,
            'phone'   => true
        ),
        'message' => array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => true,
            'phone'  => true
        ),
        'search' => array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => true,
            'phone'  => true
        ),
        'social' => array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => true,
            'phone'  => true
        ),
        'language' => array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => true,
            'phone'  => true
        ),
        'flag' => array(
            'order'  => 10,
            'align'  => 'right', // left, right
            'enable' => false,
            'desktop'=> true,
            'tablet' => true,
            'phone'  => true
        ),
        'menu' => array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => true,
            'phone'  => true
        ),
        'cart' => array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => true,
            'phone'  => true
        )
    );

    $args = wp_parse_args( $args, $defaults );

    $args = apply_filters( 'auxin_top_header_args', $args );

    // $args['socials']['tablet'] = auxin_is_true( auxin_get_option('socials_hide_on_tablet', '1') ) ? true : false;
    // $args['socials']['phone'] = auxin_is_true( auxin_get_option('socials_hide_on_phone', '1') ) ? true : false;

    // do not show top header if passed false
    if( ! $args ){
        return;
    }

    // split elements in two right and left groups
    $right_elements = array();
    $left_elements  = array();

    foreach ( $args as $element_id => $element_info ) {
        // skip container element
        if( 'container' == $element_id || 'class_names' == $element_id ){
            continue;
        }
        // add id to element info too
        $element_info[ 'element' ] = $element_id;

        // split element in groups base on alignment
        if( in_array( $element_info['align'], array( 'left', 'start' ) ) ){
            $left_elements[ $element_id ]  = $element_info;
        } else {
            $right_elements[ $element_id ] = $element_info;
        }

    }

    // Sort array nodes base on order value
    usort( $right_elements, 'auxin_cmp_components_order' );
    usort( $left_elements , 'auxin_cmp_components_order' );

    $sorted_elements = array_merge( $left_elements, $right_elements );

    ob_start();

    // container
    $container_css_class = $args['class_names'];
    if( ! $args['container']['desktop'] ){ $container_css_class .= ' aux-desktop-off'; }
    if( ! $args['container']['tablet']  ){ $container_css_class .= ' aux-tablet-off' ; }
    if( ! $args['container']['phone']   ){ $container_css_class .= ' aux-phone-off'  ; }

    echo '<div class="' . esc_attr( $container_css_class ) . '">';

    foreach ( $sorted_elements as $element_info ) {

        // dont generate the element if it is not enabled
        if( ! $element_info['enable'] ){
            continue;
        }

        $align_css_class  = in_array( $element_info['align'], array( 'left', 'start' ) ) ? 'aux-start ' : 'aux-end ';
        if ( in_array( $element_info['align'], array( 'center' ) ) ) {
            $align_css_class = 'aux-center-middle ';
        } else {
            $align_css_class .= 'aux-middle ';
        }

        // tablet alignmet
        if( isset( $element_info['tablet_align'] ) ){
            $tablet_align = in_array( $element_info['tablet_align'], array( 'left', 'start' ) ) ? 'aux-tablet-start ' : 'aux-tablet-end ';
            if ( in_array( $element_info['tablet_align'], array( 'center' ) ) ) { $tablet_align = 'aux-tablet-center-middle '; }
            $align_css_class .= $tablet_align;
        }

        // phone alignment
        if( isset( $element_info['phone_align'] ) ){
            $phone_align = in_array( $element_info['phone_align'], array( 'left', 'start' ) ) ? 'aux-phone-start ' : 'aux-phone-end ';
            if ( in_array( $element_info['phone_align'], array( 'center' ) ) ) { $phone_align = 'aux-phone-center-middle '; }
            $align_css_class .= $phone_align;
        }

        if( ! $element_info['desktop'] ){ $align_css_class .= ' aux-desktop-off'; }
        if( ! $element_info['tablet']  ){ $align_css_class .= ' aux-tablet-off' ; }
        if( ! $element_info['phone']   ){ $align_css_class .= ' aux-phone-off'  ; }

        // escape class names
        $align_css_class = esc_attr( $align_css_class );

        switch ( $element_info['element'] ) {

            case 'secondary_message':
                // Is it allowed on the page or not
                if ( 'no' === $display_secondary_message = auxin_get_post_meta( $post, 'aux_show_topheader_secondary_message', 'default' ) ) {
                    break;
                }

                // get default or custom top header message for this page
                $top_sec_message = ( 'default' === $display_secondary_message ) ? auxin_get_option( 'topheader_secondary_message' ) : auxin_get_post_meta( $post, 'aux_topheader_secondary_message' );
                echo '<div class="aux-header-sec-msg ' . $align_css_class . '"><p>'. do_shortcode( stripslashes( $top_sec_message ) ) .'</p></div>';
                break;

            case 'message':
                // Is it allowed on the page or not
                if ( 'no' === $display_message = auxin_get_post_meta( $post, 'aux_show_topheader_message', 'default' ) ) {
                    break;
                }
                // get default or custom top header message for this page
                $top_message = ( 'default' === $display_message ) ? auxin_get_option( 'topheader_message' ) : auxin_get_post_meta( $post, 'aux_topheader_message' );
                echo '<div class="aux-header-msg ' . $align_css_class . '"><p>'. do_shortcode( stripslashes( $top_message ) ) .'</p></div>';
                break;

            case 'search':
                echo auxin_get_search_box( array(
                    'has_form'          => false,
                    'css_class'         => $align_css_class,
                    'has_toggle_icon'   => true,
                    'toggle_icon_class' => 'aux-overlay-search'
                ));

                break;

            case 'social':
                auxin_the_socials( array(
                    'css_class' => $align_css_class . ' aux-socials-header',
                    'size'      => 'small',
                    'direction' => 'horizontal'
                ));
                break;

            case 'menu':
                $locations = auxin_get_theme_mod('nav_menu_locations');

                if( isset( $locations['header-secondary'] ) && $locations['header-secondary'] ){
                    wp_nav_menu(
                        array(
                            'container_id'    => 'master-menu-top-header',
                            'container_class' => 'mm-top-header ' . $align_css_class,
                            'theme_location'  => 'header-secondary'
                        )
                    );
                } elseif( is_customize_preview() ) {
                    echo '<div class="'.$align_css_class.'">' . __( 'Menu for "header-secondary" location is not found.', 'phlox-pro' ) . '</div>';
                }

                break;

            case 'language':
                auxin_get_language_selector( array( 'css_class' => $align_css_class ) );
                break;

            case 'flag':
                auxin_language_selector_flags( array( 'css_class' => $align_css_class ) );
                break;

            case 'cart':
                auxin_wc_add_to_cart( array( 'css_class' => $align_css_class ) );
                break;
        }

    }

    echo '</div>';

    return ob_get_clean();
}






function auxin_parse_footer_layout( $args ){
    global $post;

    $layout_name = ! empty( $post->ID ) ? auxin_get_post_meta( $post, 'page_footer_components_layout', 'default') : '';
    $layout_name = 'default' === $layout_name ? auxin_get_option( 'site_footer_components_layout' ) : $layout_name;

    switch ( $layout_name ) {

        case 'footer_preset1':

            $args['copyright'] = array(
                'order'       => 20,
                'align'       => 'right', // left, right
                'phone_align' => 'center', // left, right
                'enable'      => true,
                'desktop'     => true,
                'tablet'      => true,
                'phone'       => true
            );
            $args['social'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['menu'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['logo'] = array(
                'order'  => 20,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );

            break;

        case 'footer_preset2':

            $args['copyright'] = array(
                'order'   => 20,
                'align'   => 'center', // left, right
                'enable'  => true,
                'desktop' => true,
                'tablet'  => true,
                'phone'   => true
            );
            $args['social'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['menu'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['logo'] = array(
                'order'  => 20,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );

            break;

        case 'footer_preset3':

            $args['copyright'] = array(
                'order'  => 20,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['social'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['menu'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['logo'] = array(
                'order'  => 20,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            break;

        case 'footer_preset5':

        $args['copyright'] = array(
            'order'       => 20,
            'align'       => 'center', // left, right
            'phone_align' => 'center', // left, right
            'enable'      => true,
            'desktop'     => true,
            'tablet'      => true,
            'phone'       => true
        );
        $args['social'] = array(
            'order'  => 10,
            'align'  => 'right', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => false,
            'phone'  => false
        );
        $args['language'] = array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => false,
            'desktop'=> true,
            'tablet' => true,
            'phone'  => true
        );
        $args['flag'] = array(
            'order'  => 10,
            'align'  => 'right', // left, right
            'enable' => false,
            'desktop'=> true,
            'tablet' => true,
            'phone'  => true
        );
        $args['menu'] = array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => false,
            'phone'  => false
        );
        $args['logo'] = array(
            'order'  => 20,
            'align'  => 'left', // left, right
            'enable' => false,
            'desktop'=> true,
            'tablet' => false,
            'phone'  => false
        );

            break;

        case 'footer_preset4':
        default:

            $args['copyright'] = array(
                'order'  => 30,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['social'] = array(
                'order'  => 20,
                'align'  => 'right', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => false,
                'phone'  => false
            );
            $args['language'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['flag'] = array(
                'order'  => 10,
                'align'  => 'right', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => true
            );
            $args['menu'] = array(
                'order'  => 10,
                'align'  => 'left', // left, right
                'enable' => false,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );
            $args['logo'] = array(
                'order'  => 20,
                'align'  => 'left', // left, right
                'enable' => true,
                'desktop'=> true,
                'tablet' => true,
                'phone'  => false
            );

            break;
    }

    return $args;
}
add_filter( 'auxin_footer_components_args', 'auxin_parse_footer_layout' );





function auxin_get_footer_components_markup( $args = '' ){

    $defaults = array(
        'class_names' => 'aux-container aux-fold aux-float-wrapper', // classnames over container
        'container' => array(
            'desktop' => true,
            'tablet'  => true,
            'phone'   => true
        ),
        'copyright' => array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => true,
            'phone'  => true
        ),
        'social' => array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => true,
            'phone'  => false
        ),
        'language' => array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => false,
            'phone'  => false
        ),
        'flag' => array(
            'order'  => 10,
            'align'  => 'right', // left, right
            'enable' => false,
            'desktop'=> true,
            'tablet' => false,
            'phone'  => false
        ),
        'menu' => array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => false,
            'phone'  => false
        ),
        'logo' => array(
            'order'  => 10,
            'align'  => 'left', // left, right
            'enable' => true,
            'desktop'=> true,
            'tablet' => false,
            'phone'  => false
        )
    );

    $args = wp_parse_args( $args, $defaults );

    $args = apply_filters( 'auxin_footer_components_args', $args );

    // do not show footer if passed false
    if( ! $args ){
        return;
    }

    // split elements in two right and left groups
    $right_elements = array();
    $left_elements  = array();

    foreach ( $args as $element_id => $element_info ) {
        // skip container element
        if( 'container' == $element_id || 'class_names' == $element_id ){
            continue;
        }

        // dont generate the element if it is not enabled
        if( ! $element_info['enable'] ){
            continue;
        }

        // add id to element info too
        $element_info[ 'element' ] = $element_id;

        // split element in groups base on alignment
        if( in_array( $element_info['align'], array( 'left', 'start' ) ) ){
            $left_elements[ $element_id ]  = $element_info;
        } else {
            $right_elements[ $element_id ] = $element_info;
        }

    }

    // Sort array nodes base on order value
    usort( $right_elements, 'auxin_cmp_components_order' );
    usort( $left_elements , 'auxin_cmp_components_order' );

    $sorted_elements = array_merge( $left_elements, $right_elements );
    // container
    $container_css_class = $args['class_names'];
    if( ! $args['container']['desktop'] ){ $container_css_class .= ' aux-desktop-off'; }
    if( ! $args['container']['tablet']  ){ $container_css_class .= ' aux-tablet-off' ; }
    if( ! $args['container']['phone']   ){ $container_css_class .= ' aux-phone-off'  ; }

    ob_start();

    echo '<div class="' . esc_attr( $container_css_class ) . '">';

    foreach ( $sorted_elements as $element_info ) {

        $align_css_class  = in_array( $element_info['align'], array( 'left', 'start' ) ) ? 'aux-start ' : 'aux-end ';
        if ( in_array( $element_info['align'], array( 'center' ) ) ) {
            $align_css_class = 'aux-center-middle ';
        } else {
            $align_css_class .= 'aux-middle ';
        }

        // tablet alignmet
        if( isset( $element_info['tablet_align'] ) ){
            $tablet_align = in_array( $element_info['tablet_align'], array( 'left', 'start' ) ) ? 'aux-tablet-start ' : 'aux-tablet-end ';
            if ( in_array( $element_info['tablet_align'], array( 'center' ) ) ) { $tablet_align = 'aux-tablet-center-middle '; }
            $align_css_class .= $tablet_align;
        }

        // phone alignment
        if( isset( $element_info['phone_align'] ) ){
            $phone_align = in_array( $element_info['phone_align'], array( 'left', 'start' ) ) ? 'aux-phone-start ' : 'aux-phone-end ';
            if ( in_array( $element_info['phone_align'], array( 'center' ) ) ) { $phone_align = 'aux-phone-center-middle '; }
            $align_css_class .= $phone_align;
        }

        if( ! $element_info['desktop'] ){ $align_css_class .= ' aux-desktop-off'; }
        if( ! $element_info['tablet']  ){ $align_css_class .= ' aux-tablet-off' ; }
        if( ! $element_info['phone']   ){ $align_css_class .= ' aux-phone-off'  ; }

        // escape class names
        $align_css_class = esc_attr( $align_css_class );

        switch ( $element_info['element'] ) {
            case 'copyright':
                echo '<div id="copyright" class="aux-copyright ' . $align_css_class . '">';
                do_action( "auxin_footer_copyright_markup", true );
                echo '</div>';
                break;

            case 'social':
                auxin_the_socials( array(
                    'css_class' => $align_css_class . ' aux-socials-footer',
                    'size'      => 'small',
                    'direction' => 'horizontal'
                ));
                break;

            case 'menu':
                $locations = auxin_get_theme_mod('nav_menu_locations');

                if( ! empty( $locations['footer'] ) ){
                    wp_nav_menu(
                        array(
                            'container_id'    => 'menu-footer-nav',
                            'container_class' => 'footer-menu ' . $align_css_class,
                            'theme_location'  => 'footer',
                            'depth'           => 1
                        )
                    );
                } elseif( is_customize_preview() ) {
                    echo '<div class="'.$align_css_class.'">' . __( 'Admin notice: Menu for "footer" location not found.', 'phlox-pro' ) . '</div>';
                }
                break;

            case 'language':
                auxin_get_language_selector( array( 'css_class' => $align_css_class . ' aux-footer-lang' ) );
                break;

            case 'flag':
                auxin_language_selector_flags( array( 'css_class' => $align_css_class . ' aux-footer-flag' ) );
                break;

            case 'logo':
                if( function_exists('auxin_get_footer_logo_block') ){
                    echo auxin_get_footer_logo_block( array(
                        'css_class'       => 'aux-logo-footer ' . $align_css_class,
                        'middle'          => false
                    ));
                    break;
                }
        }

    }

    echo '</div>';

    return ob_get_clean();
}




/**
 * Add Cart icon and count to header if WC is active
 */
function auxin_wc_add_to_cart( $args = array() ){

    //Check status of woocommerce activation
    if ( class_exists( 'WooCommerce' ) ) {

        global $woocommerce;

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

        if( 'custom' == $args['size'] ){
            $args['size'] = array( 'width' => $args['width'], 'height' => $args['height'] );
        }

        if( $args['dropdown_skin'] === 'dark') {
            $args['dropdown_class'] .= ' aux-card-dropdown-dark';
            $args['color_class']    = 'aux-white';
        }

        if ( $args['basket_animation'] )
            $args['css_class'] .= ' aux-basket-animation';
        else
            $args['css_class'] .= auxin_is_true( auxin_get_option('site_header_cart_animation' ) ) ? ' aux-basket-animation' : '';

        // Localize cart options
	    if ( defined( 'AUXELS_SLUG' ) ) {
	    	wp_localize_script( AUXELS_SLUG .'-scripts', 'auxin_cart_options', $args );
	    }

	    //Get cart contents count number
	    $count  = is_object( $woocommerce->cart ) ? (int) $woocommerce->cart->cart_contents_count : 0;

        ob_start();
    ?>

        <div class="aux-cart-wrapper aux-elegant-cart <?php echo esc_attr( $args['css_class'] ); ?>">
            <div class="aux-shopping-basket aux-phone-off aux-action-on-<?php echo esc_attr( $args['action_on'] ); ?>">
            <?php echo auxin_get_cart_basket( $args, $count ); ?>
            </div>
            <div id="shopping-basket-burger" class="aux-shopping-basket aux-basket-burger aux-phone-on">
                <a class="aux-cart-contents <?php echo esc_attr( $args['icon'] ); ?>"
                href="<?php echo esc_url( $args['cart_url'] ); ?>"
                title="<?php esc_attr_e( 'View your shopping cart', 'phlox-pro' ); ?>">
            <?php
                echo ! empty( $args['title'] ) ? esc_html( $args['title'] ) : '';
                if ( $count > 0 ) {
                    echo '<span>' . esc_html( $count ) . '</span>';
                }
            ?>
                </a>
            </div>
            <?php if( ! is_cart() && ! is_checkout() ){ ?>
                <?php if( $count > 0 ) { ?>
                    <div class="aux-card-dropdown aux-phone-off <?php echo esc_attr( $args['dropdown_class'] ); ?>">
                    <?php echo auxin_get_cart_items( $args ); ?>
                    </div>
                <?php } else { ?>
                    <div class="aux-card-dropdown aux-phone-off <?php echo esc_attr( $args['dropdown_class'] ); ?>">
                        <div class="aux-card-box aux-empty-cart">
                            <img src="<?php echo esc_url( AUXIN_URL . 'images/other/empty-cart.svg' ); ?>">
                            <?php esc_html_e( 'Cart is empty', 'phlox-pro' ) ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
        <?php

        echo apply_filters( 'auxin_the_shopping_basket', ob_get_clean(), $args );
    }

}


//// prints site socials   /////////////////////////////////////////////////////////

/**
 * Generates and retrives the media background markup for a section
 *
 * @param  array  $args The options for media background
 * @return string       The output
 */
function auxin_get_media_background( $args = array() ){

    if( empty( $args ) ){ return ''; }

    $output = '';
    $media_bg_style = '';

    $defaults = array(
        'color'           => '',
        'size'            => 'cover',
        'image'           => '',
        'ogg'             => '',
        'webm'            => '',
        'mp4'             => '',
        'mute'            => 1,
        'loop'            => 1,
        'parallax'        => 0,
        'parallax_origin' => 'top'
    );

    $args = wp_parse_args( $args, $defaults );

    if( ! empty( $args['color'] ) ){
        $media_bg_style .= 'background-color: ' . $args['color'] . '; ';
    }
    if( ! empty( $args['size'] ) && 'cover' != $args['size'] ){
        $media_bg_style .= 'background-size: ' . $args['size'] . '; ';
    }
    if( ! empty( $args['image'] ) && 'cover' != $args['image'] ){
        $media_bg_style .= 'background-image: url(' . $args['image'] . '); ';
    }

    // escape the class attribue
    $media_bg_style = esc_attr( $media_bg_style );

    $media_parallax_attributes = '';
    $media_parallax_class = '';

    if ( 0 != $args['parallax'] ) {
        $media_parallax_attributes = 'data-parallax-depth="' . esc_attr( $args['parallax'] ) . '" data-parallax-origin="' . esc_attr( $args['parallax_origin'] ) . '"';
        $media_parallax_class = 'aux-parallax';
    }

    $video_srcs   = $args['mp4' ]  ? sprintf( '<source src="%s" type="video/mp4"  />', esc_url( $args['mp4'  ] ) ) : '';
    $video_srcs  .= $args['ogg' ]  ? sprintf( '<source src="%s" type="video/ogg"  />', esc_url( $args['ogg'  ] ) ) : '';
    $video_srcs  .= $args['webm']  ? sprintf( '<source src="%s" type="video/webm" />', esc_url( $args['webm' ] ) ) : '';


    if( ! empty( $video_srcs ) || ! empty( $args['image'] ) ){

        $output .= "<div class=\"aux-meida-bg-holder aux-video-box $media_parallax_class\" data-fill=\"fill\" $media_parallax_attributes style=\"$media_bg_style\" >";

        if( ! empty( $video_srcs ) ){
            $video_attrs  = $args['mute']  ? ' muted' : '';
            $video_attrs .= $args['loop']  ? ' loop' : '';

            if (  0 != $args['parallax'] ) {
                $video_attrs .= ' class="aux-parallax" data-parallax-depth="' . esc_attr( $args['parallax'] ) . '" data-parallax-origin="' . esc_attr( $args['parallax_origin'] ) . '"';
            }

            $output .= sprintf( "<video %s>\n%s\n</video>\n", $video_attrs, $video_srcs );
        }

        if( ! empty( $args['image'] ) ){
            $output .= sprintf( "<img src=\"%s\" alt=\"\" />\n", esc_url( $args['image'] ) );
        }

        $output .= "</div>";
    }

    return $output;

}


function auxin_cmp_components_order( $a, $b ){
    return $a['order'] - $b['order'];
}


//// Prints pagination nav   ///////////////////////////////////////////////////////

if( ! function_exists( 'auxin_the_paginate_nav' ) ){

    function auxin_the_paginate_nav( $args = null ){

        if( empty( $args['wp_query'] ) || ! is_object( $args['wp_query'] ) ) {
            global $wp_query;
        } else {
            $wp_query = $args['wp_query'];
        }

        $total_pages = $wp_query->max_num_pages;

        if ( $total_pages > 1 ){

            $defaults = array(
                'total'          => $total_pages,
                'first_last'     => true,
                'prev_text'      => __('Previous', 'phlox-pro'),
                'next_text'      => __('Next'    , 'phlox-pro'),
                'first_text'     => __('First'   , 'phlox-pro'),
                'last_text'      => __('Last'    , 'phlox-pro'),
                'type'           => 'array',
                'css_class'      => '',    // if it is not empty, the next options for border and styles will be ignored
                'border_round'   => true,  // Make the border of all pages rounded
                'page_no_border' => false, // Remove the borders from page numbers
                'no_border'      => false  // Remove borders from all elements in pagination
            );

            $paginate_args = wp_parse_args( $args, $defaults );


            $class_names = array( 'aux-pagination' );

            if( $paginate_args['css_class'] ){
                $class_names['css_class'] = $paginate_args['css_class'];
            } else {
                if( $paginate_args['border_round']   ){ $class_names['round']     = 'aux-round';          }
                if( $paginate_args['page_no_border'] ){ $class_names['page_no']   = 'aux-page-no-border'; }
                if( $paginate_args['no_border']      ){ $class_names['no_border'] = 'aux-no-border';      }
            }

            $class_attr = auxin_make_html_class_attribute( $class_names );

            echo "<nav $class_attr >".
                    '<ul class="pagination">';

            $paginate_links = auxin_paginate_list( $paginate_args );
            foreach ( $paginate_links as $paginate_item ) {
                echo $paginate_item;
            }

            echo    '</ul>'.
            '</nav>';
        }
    }

}



if( ! function_exists( 'auxin_the_search_paginate_nav' ) ){

    function auxin_the_search_paginate_nav( $args = null, $custom_query = array() ){
        if ( $custom_query ) {
        	$wp_query = $custom_query;
        } else {
        	global $wp_query;
        }

        $total_pages = $wp_query->max_num_pages;

        if ( $total_pages > 1 ){

            $defaults = array(
                'total'          => $total_pages,
                'first_last'     => true,
                'prev_text'      => __('Previous', 'phlox-pro'),
                'next_text'      => __('Next'    , 'phlox-pro'),
                'first_text'     => __('First'   , 'phlox-pro'),
                'last_text'      => __('Last'    , 'phlox-pro'),
                'type'           => 'array',
                'css_class'      => '',    // if it is not empty, the next options for border and styles will be ignored
                'border_round'   => true,  // Make the border of all pages rounded
                'page_no_border' => false, // Remove the borders from page numbers
                'no_border'      => false  // Remove borders from all elements in pagination
            );
            $paginate_args = wp_parse_args( $args, $defaults );

            $class_names = array( 'aux-pagination' );

            if( $paginate_args['css_class'] ){
                $class_names['css_class'] = $paginate_args['css_class'];
            } else {
                if( $paginate_args['border_round']   ){ $class_names['round']     = 'aux-round';          }
                if( $paginate_args['page_no_border'] ){ $class_names['page_no']   = 'aux-page-no-border'; }
                if( $paginate_args['no_border']      ){ $class_names['no_border'] = 'aux-no-border';      }
            }

            $class_attr = auxin_make_html_class_attribute( $class_names );

            echo "<nav $class_attr >".
                    '<ul class="pagination">';

            $paginate_links = auxin_paginate_list( $paginate_args );
            foreach ( $paginate_links as $paginate_item ) {
                echo $paginate_item;
            }

            echo    '</ul>'.
            '</nav>';
        }

        if ( !empty($custom_query_args) )
        	wp_reset_postdata();
    }

}


/**
 * Retrieve paginated link list for archive post pages.
 *
 * @param string|array $args {
 *     Optional. Array or string of arguments for generating paginated links for archives.
 *
 *     @type string $base               Base of the paginated url. Default empty.
 *     @type string $format             Format for the pagination structure. Default empty.
 *     @type int    $total              The total amount of pages. Default is the value WP_Query's
 *                                      `max_num_pages` or 1.
 *     @type int    $current            The current page number. Default is 'paged' query var or 1.
 *     @type bool   $show_all           Whether to show all pages. Default false.
 *     @type int    $end_size           How many numbers on either the start and the end list edges.
 *                                      Default 1.
 *     @type int    $mid_size           How many numbers to either side of the current pages. Default 2.
 *     @type bool   $prev_next          Whether to include the previous and next links in the list. Default true.
 *     @type bool   $prev_text          The previous page text. Default '« Previous'.
 *     @type bool   $next_text          The next page text. Default '« Previous'.
 *     @type bool   $first_last         Whether to include the first and last links in the list. Default true.
 *     @type bool   $first_text         The first page text. Default 'First'.
 *     @type bool   $last_text          The last page text. Default 'Last'.
 *     @type string $type               Controls format of the returned value. Possible values are 'plain',
 *                                      'array' and 'list'. Default is 'plain'.
 *     @type array  $add_args           An array of query args to add. Default false.
 *     @type string $add_fragment       A string to append to each link. Default empty.
 *     @type string $before_page_number A string to appear before the page number. Default empty.
 *     @type string $after_page_number  A string to append after the page number. Default empty.
 * }
 * @return array|string|void String of page links or array of page links.
 */
function auxin_paginate_list( $args = '' ) {
    global $wp_rewrite;

    if( ! isset( $args['wp_query'] ) || ! is_object( $args['wp_query'] ) ) {
        global $wp_query;
    } else {
        $wp_query = $args['wp_query'];
        unset( $args['wp_query'] );
    }

    // Setting up default values based on the current URL.
    $pagenum_link = wp_doing_ajax() ? wp_get_referer() : html_entity_decode( get_pagenum_link() );
    $url_parts    = explode( '?', $pagenum_link );

    // Get max pages and current page out of the current query, if available.
    $total     = isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1;
    $current   = max( 1, get_query_var('paged'), get_query_var('page') );

    // Append the format placeholder to the base URL.
    $pagenum_link = trailingslashit( $url_parts[0] ) . '%_%';

    // URL base depends on permalink settings.
    $format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
    $format .= ( $wp_rewrite->using_permalinks() && ! isset( $url_parts[1] ) ) ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

    $defaults = array(
        'base'               => $pagenum_link, // http://example.com/all_posts.php%_% : %_% is replaced by format (below)
        'format'             => $format, // ?page=%#% : %#% is replaced by the page number
        'total'              => $total,
        'current'            => $current,
        'show_all'           => false,
        'prev_next'          => true,
        'first_last'         => true,
        'prev_text'          => __('&laquo; Previous', 'phlox-pro'),
        'next_text'          => __('Next &raquo;', 'phlox-pro'),
        'first_text'         => __('First', 'phlox-pro'),
        'last_text'          => __('Last', 'phlox-pro'),
        'end_size'           => 1,
        'mid_size'           => 2,
        'type'               => 'plain',
        'add_args'           => array(), // array of query args to add
        'add_fragment'       => '',
        'before_page_number' => '',
        'after_page_number'  => ''
    );

    $args = wp_parse_args( $args, $defaults );

    if ( ! is_array( $args['add_args'] ) ) {
        $args['add_args'] = array();
    }

    // Merge additional query vars found in the original URL into 'add_args' array.
    if ( isset( $url_parts[1] ) ) {
        // Find the format argument.
        $format = explode( '?', str_replace( '%_%', $args['format'], $args['base'] ) );
        $format_query = isset( $format[1] ) ? $format[1] : '';
        wp_parse_str( $format_query, $format_args );

        // Find the query args of the requested URL.
        wp_parse_str( $url_parts[1], $url_query_args );

        // Remove the format argument from the array of query arguments, to avoid overwriting custom format.
        foreach ( $format_args as $format_arg => $format_arg_value ) {
            unset( $url_query_args[ $format_arg ] );
        }

        $args['add_args'] = array_merge( $args['add_args'], urlencode_deep( $url_query_args ) );
    }

    // Who knows what else people pass in $args
    $total = (int) $args['total'];
    if ( $total < 2 ) {
        return;
    }
    $current  = (int) $args['current'];
    $end_size = (int) $args['end_size']; // Out of bounds?  Make it the default.
    if ( $end_size < 1 ) {
        $end_size = 1;
    }
    $mid_size = (int) $args['mid_size'];
    if ( $mid_size < 0 ) {
        $mid_size = 2;
    }
    $add_args = $args['add_args'];
    $r = '';
    $page_links = array();
    $dots = false;

    if ( $args['first_last'] && $current && 1 < $current ) :
        $link = str_replace( '%_%', '', $args['base'] );
        $link = str_replace( '%#%', 1, $link );
        if ( $add_args )
            $link = add_query_arg( $add_args, $link );
        $link .= $args['add_fragment'];

        /**
         * Filter the paginated links for the given archive pages.
         *
         * @since 3.0.0
         *
         * @param string $link The paginated link URL.
         */
        $page_links[] = '<li class="first"><a class="page-numbers" data-paged="1" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $args['first_text'] . '</a></li>';
    endif;

    if ( $args['prev_next'] && $current && 1 < $current ) :
        $link = str_replace( '%_%', 2 == $current ? '' : $args['format'], $args['base'] );
        $link = str_replace( '%#%', $current - 1, $link );
        if ( $add_args )
            $link = add_query_arg( $add_args, $link );
        $link .= $args['add_fragment'];

        /**
         * Filter the paginated links for the given archive pages.
         *
         * @since 3.0.0
         *
         * @param string $link The paginated link URL.
         */
        $page_links[] = '<li class="prev"><a class="page-numbers" data-paged="'.( $current - 1 ).'"  href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $args['prev_text'] . '</a></li>';
    endif;

    for ( $n = 1; $n <= $total; $n++ ) :
        if ( $n == $current ) :
            $page_links[] = "<li class='page active'><span class='page-numbers'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</span></li>";
            $dots = true;
        else :
            if ( $args['show_all'] || ( $n <= $end_size || ( $current && $n >= $current - $mid_size && $n <= $current + $mid_size ) || $n > $total - $end_size ) ) :
                $link = str_replace( '%_%', 1 == $n ? '' : $args['format'], $args['base'] );
                $link = str_replace( '%#%', $n, $link );
                if ( $add_args )
                    $link = add_query_arg( $add_args, $link );
                $link .= $args['add_fragment'];

                /** This filter is documented in wp-includes/general-template.php */
                $page_links[] = "<li class='page'><a class='page-numbers' data-paged='$n' href='" . esc_url( apply_filters( 'paginate_links', $link ) ) . "'>" . $args['before_page_number'] . number_format_i18n( $n ) . $args['after_page_number'] . "</a></li>";
                $dots = true;
            elseif ( $dots && ! $args['show_all'] ) :
                $page_links[] = '<li class="page"><span class="page-numbers dots">...</span></li>';
                $dots = false;
            endif;
        endif;
    endfor;

    if ( $args['prev_next'] && $current && ( $current < $total || -1 == $total ) ) :
        $link = str_replace( '%_%', $args['format'], $args['base'] );
        $link = str_replace( '%#%', $current + 1, $link );
        if ( $add_args )
            $link = add_query_arg( $add_args, $link );
        $link .= $args['add_fragment'];

        /** This filter is documented in wp-includes/general-template.php */
        $page_links[] = '<li class="next"><a class="page-numbers" data-paged="'.( $current + 1 ).'" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $args['next_text'] . '</a></li>';
    endif;

    if ( $args['first_last'] && $current && ( $current < $total || -1 == $total ) ) :
        $link = str_replace( '%_%', $args['format'], $args['base'] );
        $link = str_replace( '%#%', $total, $link );
        if ( $add_args )
            $link = add_query_arg( $add_args, $link );
        $link .= $args['add_fragment'];

        /** This filter is documented in wp-includes/general-template.php */
        $page_links[] = '<li class="last"><a class="page-numbers" data-paged="'. $total .'" href="' . esc_url( apply_filters( 'paginate_links', $link ) ) . '">' . $args['last_text'] . '</a></li>';
    endif;

    switch ( $args['type'] ) {
        case 'array' :
            return $page_links;

        case 'list' :
            $r .= "<ul class='page-numbers'>\n\t<li>";
            $r .= join("</li>\n\t<li>", $page_links);
            $r .= "</li>\n</ul>\n";
            break;

        default :
            $r = join("\n", $page_links);
            break;
    }
    return $r;
}


/**
 * Generates and retrives the posts markup by query args
 *
 * @param  array  $args            The WP_Query args
 * @param  string $tempale_path    The template part path
 * @param  array  $extra_variables The extra variables that we intent to path to template part
 * @return string                  The generated posts markup
 */
function auxin_get_post_type_markup( $args, $tempale_path = '', $extra_variables = array() ){

    $defaults = array(
        'post_type'           => 'post',
        'orderby'             => 'date',
        'order'               => 'desc',
        'post_status'         => 'publish',
        'posts_per_page'      => '10',
        'ignore_sticky_posts' => 1
    );

    $query_args = wp_parse_args( $args, $defaults );
    $query_args = apply_filters( 'auxin_get_post_type_markup', $query_args, $args, $defaults );
    extract( $extra_variables );

    $custom_query = new WP_Query( $args );

    ob_start();

    // start output ----------------------------------------------

    if( $custom_query->have_posts() ):  while ( $custom_query->have_posts() ) : $custom_query->the_post();

        include locate_template( $tempale_path );

    endwhile; endif;

    // end output ------------------------------------------------

    wp_reset_postdata();

    return ob_get_clean();
}

/**
 * Generates and returns media for posts
 *
 * @param  object $post     The post object
 * @param  array  $settings The setting args
 * @return array            The output params in array
 */
function auxin_get_post_format_media( $post, $settings = array(), $aux_content_width = NULL ){

    if(  is_null( $aux_content_width ) ) {
        global $aux_content_width;
    }

    $defaults = array(
        'post_type'          => 'post',
        'request_from'       => 'archive',
        'no_gallery'         => false,
        'ignore_media'       => false, // whether to ignore generating the media for post or not
        'crop'               => true,
        'mask_image'         => true, // add max height for the image frame
        'content_width'      => '',
        'upscale_image'      => false,
        'media_size'         => '', // large, medium, thumbnail
        'aspect_ratio'       => 9/16,
        'image_from_content' => true, // whether to try to get image from content or not
        'preloadable'        => false, // whether to lazyload the images or not
        'preload_preview'    => true,
        'preload_bgcolor'    => '',
        'add_image_hw'       => true, // whether to add with and height attrs to image
        'image_sizes'        => 'auto',
        'srcset_sizes'       => 'auto',
        'ignore_formats'     => array() // ignore specific post formats or all by adding *
    );

    $settings = wp_parse_args( $settings, $defaults );
    extract( $settings );

    if ( empty( $media_width ) ) {
        $media_width = $aux_content_width;
    }

    // the array format that will be returned by this function
    $args = array(
        'post_format' => '',
        'has_attach'  => false,
        'the_attach'  => '',
        'the_media'   => '',
        'the_name'    => '',
        'the_link'    => '',
        'show_title'  => true,
        'page_layout' => '',
        'excerpt'     => ''
    );

    if( empty( $post ) ){
        return $args;
    }


    // calculate and extract the media size
    if( ! empty( $media_size ) ){
        if( is_array( $media_size ) ){
            $size = array( 'width' => $media_size['width'], 'height' => $media_size['height'] );
        } elseif ( $media_size != 'full' ) {
            $size = auxin_wp_get_image_size( $media_size );
            $size = array( 'width' => $size['width'], 'height' => $size['height'] );
        } else {
            $size = array( 'width' => $media_width, 'height' => $media_width * $aspect_ratio );
        }
    } else {
        $size = array( 'width' => $media_width, 'height' => $media_width * $aspect_ratio );
    }

    // retrieve the post format
    $args['post_format'] = get_post_format( $post->ID );
    $the_post_format = $args['post_format'];
    if ( in_array( '*', $ignore_formats ) || in_array( $the_post_format, $ignore_formats ) ) {
        $the_post_format = 'standard';
    }

    // whether this post has sidebar or not
    $args['post_layout'] = auxin_get_page_sidebar_pos( $post->ID );

    // get the extra classes for image frame
    $image_frame_extra_class = $mask_image ? 'aux-image-mask' : '';


    if( 'single' === $request_from ){

        if ( 'default' === $show_post_title = auxin_get_post_meta( $post, 'aux_post_title_show', 'default' ) ){
            $show_post_title = auxin_get_option( $post->post_type . '_single_title_show_over_content', 'yes' );
        }
        if( ! auxin_is_true( $show_post_title ) ){
            $args['show_title'] = false;
        }

        if( 'default' === $show_single_media = auxin_get_post_meta( $post, 'blog_single_show_media', 'default' ) ){
            $show_single_media = auxin_get_option( 'show_post_single_media' );
        }
        if( ! $show_single_media = auxin_is_true( $show_single_media ) ){
            $ignore_media = true;
        }

    } elseif( 'archive' === $request_from ){
        if( ! auxin_is_true( auxin_get_option( 'blog_archive_show_featured_image' ) ) ){
            $ignore_media = true;
        }
    }

    switch ( $the_post_format ) {

        case 'gallery':

            // skip generating media for this format
            if( $ignore_media ){
                break;
            }

            $attachments = get_post_meta( $post->ID, '_format_gallery_type', true );
            $attach_ids = explode( ',', $attachments );

            if( empty( $attach_ids ) ){
                return '';
            }

            $cropped_image_srcs = auxin_get_the_resized_attachment_src( $attach_ids, $size['width'], $size['height'], true, 100, $upscale_image );


            if( ! $args['has_attach'] = ! empty( $cropped_image_srcs ) ){
                break;
            }

            // sometimes we need to remove gallery slider from post media, like adding post inside a carousel.
            if ( isset( $no_gallery ) && $no_gallery ) {

                $first_attachment_src = reset( $cropped_image_srcs );
                $first_attachment_id  = key( $cropped_image_srcs );


                $args['the_media']  .= '<div class="aux-media-frame aux-media-image '. esc_attr( $image_frame_extra_class ) .'"><a href="'. wp_get_attachment_url( $first_attachment_id ) .'" >'.
                    '<img src="'. esc_url( $first_attachment_src ) .'" alt="'. esc_attr( trim( strip_tags( get_post_meta( $first_attachment_id, '_wp_attachment_image_alt', true ) ) ) ).'" />'.
                    '</a></div>';
                break;
            }

            $args['the_media']  = '<div class="aux-no-js aux-media-frame aux-media-gallery aux-lightbox-in-slider master-carousel-slider" data-navigation="perpage" data-loop="true" data-space="0" data-auto-height="true" data-empty-height="0">';

            foreach ( $cropped_image_srcs as $cropped_attach_id => $cropped_image_src ) {
                $full_image_src = wp_get_attachment_url( $cropped_attach_id );

                $image_primary_meta     = wp_get_attachment_metadata( $cropped_attach_id );
                $lightbox_attrs         = 'data-original-width="' . esc_attr( $image_primary_meta['width'] ) . '" data-original-height="' . esc_attr( $image_primary_meta['height'] ) . '" ' .
                                          'data-caption="' . esc_attr( auxin_attachment_caption( $cropped_attach_id ) ) . '"';

                $args['the_media']  .= '<a class="aux-lightbox-slide aux-lightbox-btn aux-no-page-animate aux-mc-item" href="'. esc_url( $full_image_src ).'" ' . $lightbox_attrs . ' >'.
                    '<img src="'. esc_url( $cropped_image_src ) .'" alt="'. esc_attr( trim( strip_tags( get_post_meta( $cropped_attach_id, '_wp_attachment_image_alt', true ) ) ) ).'" />'.
                '</a>';
            }

            // insert custom arrows
            $args['the_media'] .=
                    '<div class="aux-next-arrow aux-arrow-nav aux-white aux-round aux-hover-slide">'.
                    '    <span class="aux-overlay"></span>'.
                    '    <span class="aux-svg-arrow aux-medium-right"></span>'.
                    '    <span class="aux-hover-arrow aux-svg-arrow aux-medium-right"></span>'.
                    '</div>';

            $args['the_media'] .=
                    '<div class="aux-prev-arrow aux-arrow-nav aux-white aux-round aux-hover-slide">'.
                    '    <span class="aux-overlay"></span>'.
                    '    <span class="aux-svg-arrow aux-medium-left"></span>'.
                    '    <span class="aux-hover-arrow aux-svg-arrow aux-medium-left"></span>'.
                    '</div>';


            $args['the_media'] .= '</div>';

            $args['has_attach'] = true;


            break;

        case 'image':

            if( ! $args['has_attach'] = has_post_thumbnail() )
                break;

            // skip generating media for this format
            if( $ignore_media ){
                break;
            }

            // dont generate media for image and standard post format if the featured image is disabled on archive blog by client
            if( 'archive' === $request_from ){

                $show_featured_image = true;
                $show_featured_image_meta_field = auxin_get_post_meta( $post, 'blog_archive_show_featured_image', 'auto' );

                // get metafield featured image visibility option
                if( in_array( $show_featured_image_meta_field, array( 'auto', 'default') ) ){
                    // if( 'full' == auxin_get_option( 'blog_content_on_listing', 'full' ) ){
                    //     $post_content = get_the_content();
                    //     $show_featured_image_meta_field = ! ( false !== strpos( $post_content, '<img' ) );
                    //     $show_featured_image = $show_featured_image_meta_field ? auxin_get_option( 'blog_archive_show_featured_image', 1 ): $show_featured_image_meta_field;
                    // } else {
                    //     $show_featured_image = auxin_get_option( 'blog_archive_show_featured_image', 1 );
                    // }
                    $show_featured_image = auxin_get_option( 'blog_archive_show_featured_image', 1 );
                } else {
                    $show_featured_image = auxin_is_true( $show_featured_image_meta_field );
                }

                if( ! $show_featured_image ){
                    break;
                }

            }

            $args['the_attach'] = auxin_get_the_post_responsive_thumbnail(
                $post->ID,
                array(
                    'size'            => $media_size == 'full' ? 'full' : $size,
                    'crop'            => $crop,
                    'preloadable'     => $preloadable,
                    'preload_preview' => $preload_preview,
                    'preload_bgcolor' => $preload_bgcolor,
                    'add_hw'          => $add_image_hw,
                    'image_sizes'     => $image_sizes,
                    'srcset_sizes'    => $srcset_sizes,
                    'attr'            => array( 'width_attr_name' => 'data-original-src-width', 'height_attr_name' => 'data-original-src-height'  ),
                    'upscale'         => $upscale_image
                )
            );

            $attachment_id          = get_post_thumbnail_id( $post->ID );
            $image_primary_meta     = wp_get_attachment_metadata( $attachment_id );
            $lightbox_attrs         = 'data-original-width="' . esc_attr( $image_primary_meta['width'] ) . '" data-original-height="' . esc_attr( $image_primary_meta['height'] ) . '" ' .
                                      'data-caption="' . esc_attr( auxin_attachment_caption( $attachment_id ) ) . '"';

            $args['the_media'] = '<div class="aux-media-frame aux-media-image aux-lightbox-frame aux-hover-active '. esc_attr( $image_frame_extra_class ) .'">'.
                            '<a href="'.auxin_get_the_attachment_url( $post->ID, 'full' ).'" class="aux-lightbox-btn" ' . $lightbox_attrs . '>'.
                                '<div class="aux-hover-scale-circle-plus">'.
                                '    <span class="aux-symbol-plus"></span>'.
                                '    <span class="aux-symbol-circle"></span>'.
                                '</div>'.
                                '<div class="aux-frame-darken">'.$args['the_attach'].'</div>'.
                            '</a>'.
                         '</div>';


            break;

        case 'link':

            if( ! $args['the_link'] = get_post_meta( $post->ID, "_format_link_url", true ) ) {
                // get the first url in content
                if( preg_match( "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/", get_the_content(), $url ) ) {
                    $args['the_link'] = ! empty( $url[0] ) ? esc_url( $url[0] ) : '';
                }
            }

            $args['show_title'] = true;
            $args['has_attach'] = false;

            break;

        case 'aside':
            $args['has_attach'] = false;

            break;

        case 'video':
            $url    = get_post_meta( $post->ID, '_format_video_embed'             , true );
            $src    = get_post_meta( $post->ID, '_format_video_attachment'        , true );
            $poster = get_post_meta( $post->ID, '_format_video_attachment_poster' , true );

            // Get default skins from theme options
            if( 'default' === $skin = auxin_get_post_meta( $post, '_format_video_player_skin', 'default' ) ){
                $skin = esc_attr( auxin_get_option( 'global_video_player_skin', 'dark') );
            }

            // skip generating media for this format
            if( $ignore_media ){
                break;
            }

            $args['has_attach'] = ( ! empty( $url ) || ! empty( $src ) );

            if( ! $args['has_attach'] )
                break;

            global $wp_press_this;

            if( ! empty( $src ) ){
                // if plugin for auxin elements was active use auxin custom video shortcode
                if( function_exists('AUXELS') ){
                    $args['the_attach'] = do_shortcode(
                        sprintf(
                            '[aux_video src="%s" poster="%s" skin="%s" width="%s" height="%s"]',
                            $src,
                            $poster,
                            $skin,
                            $size['width'],
                            $size['height']
                        )
                    );
                } else {
                    $args['the_attach'] = wp_video_shortcode(
                        array(
                            'src'      => wp_get_attachment_url( $src ),
                            'class'    => 'wp-video-shortcode aux-player-' . esc_attr( $skin ),
                            'width'    => $size['width'],
                            'height'   => $size['height'],
                            'poster'   => $poster
                        )
                    );
                }

            } elseif ( preg_match('#<if'.'rame(.+)</if'.'rame>#i', $url ) ){
                $args['the_attach'] = $url;

            } else {
                $args['the_attach'] = wp_oembed_get(
                    $url,
                    array(
                        'width'  => $size['width'],
                        'height' => $size['height']
                    )
                );
            }

            $args['the_media'] = '<div class="aux-media-frame aux-media-video">'.
                $args['the_attach'].
            '</div>';


            unset( $url, $src, $poster, $skin, $size );
            break;

        case 'audio':
            $_oembed = get_post_meta( $post->ID, '_format_audio_embed'        , true );
            $src     = get_post_meta( $post->ID, '_format_audio_attachment'   , true );
            $skin    = get_post_meta( $post->ID, '_format_audio_player_skin'  , true );

            // get default skins from theme options
            if( 'default' === $skin = auxin_get_post_meta( $post, '_format_audio_player_skin', 'default' ) ){
                $skin = esc_attr( auxin_get_option( 'global_audio_player_skin', 'dark') );
            }

            // skip generating media for this format
            if( $ignore_media ){
                break;
            }

            $args['has_attach'] = ( ! empty( $src ) || ! empty( $_oembed ) );

            if( ! $args['has_attach'] )
                break;

            // if plugin for auxin elements was active use auxin custom audio shortcode
            if( defined('AUXELS_VERSION') ){
                $shortcode_name = 'aux_audio';
            } else {
                $shortcode_name = 'audio';
                $src = wp_get_attachment_url( $src );
            }

            if( ! empty( $src ) ){
                $args['the_attach'] = do_shortcode( sprintf( '[%s src="%s" loop="0" autoplay="0" preload="0" skin="%s"]', $shortcode_name, $src, $skin ) );
            } elseif( preg_match('#<if'.'rame(.+)</if'.'rame>#i', $_oembed ) ){
                $args['the_attach'] = $_oembed;
            } else {
                $args['the_attach'] = wp_oembed_get( $_oembed );
            }

            $args['the_media'] = '<div class="aux-media-frame aux-media-audio">'.
                $args['the_attach'].
             '</div>';


            unset( $mp3, $skin, $_oembed );
            break;

        case 'quote':
            if( auxin_get_option( 'blog_content_on_listing' ) == 'full' ) {
                $args['excerpt']  = get_the_content( __( 'Continue reading', 'phlox-pro') );
            } else {
                $args['excerpt']  = get_the_excerpt();
            }

            $args['the_name']   = get_post_meta( $post->ID, '_format_quote_source_name' , true );
            $args['the_link']   = get_post_meta( $post->ID, '_format_quote_source_url'  , true );

            $args['show_title'] = true;
            $args['has_attach'] = false;

            break;

        default:

        $args['has_attach'] = has_post_thumbnail();

            // skip generating media for this format
            if( $ignore_media ){
                break;
            }

            // dont generate media for image and standard post format if the featured image is disabled on archive blog by client
            if( 'archive' === $request_from ){

                $show_featured_image = true;
                $show_featured_image_meta_field = auxin_get_post_meta( $post, 'blog_archive_show_featured_image', 'auto' );

                // get metafield featured image visibility option
                if( in_array( $show_featured_image_meta_field, array( 'auto', 'default') ) ){
                    // if( 'full' == auxin_get_option( 'blog_content_on_listing', 'full' ) ){
                    //     $post_content = get_the_content();
                    //     $show_featured_image_meta_field = ! ( false !== strpos( $post_content, '<img' ) );
                    //     $show_featured_image = $show_featured_image_meta_field ? auxin_get_option( 'blog_archive_show_featured_image', 1 ): $show_featured_image_meta_field;
                    // } else {
                    //     $show_featured_image = auxin_get_option( 'blog_archive_show_featured_image', 1 );
                    // }
                    $show_featured_image = auxin_get_option( 'blog_archive_show_featured_image', 1 );
                } else {
                    $show_featured_image = auxin_is_true( $show_featured_image_meta_field );
                }

                if( ! $show_featured_image ){
                    break;
                }

            }

            if( $image_from_content && ! $args['has_attach'] ) {
                $args['the_attach'] = auxin_get_first_image_from_string( get_the_content() );
                $args['has_attach'] = ! empty( $args['the_attach'] );
            } else {
                $args['the_attach'] = auxin_get_the_post_responsive_thumbnail(
                    $post->ID,
                    array(
                        'size'            => $media_size == 'full' ? 'full' : $size,
                        'crop'            => $crop,
                        'add_hw'          => $add_image_hw,
                        'preloadable'     => $preloadable,
                        'preload_preview' => $preload_preview,
                        'preload_bgcolor' => $preload_bgcolor,
                        'image_sizes'     => $image_sizes,
                        'srcset_sizes'    => $srcset_sizes,
                        'upscale'         => $upscale_image
                    )
                );
            }

            if( ! $args['has_attach'] )
                break;


            $args['the_media'] = '<div class="aux-media-frame aux-media-image '. esc_attr( $image_frame_extra_class ) .'">'.
                            '<a href="'.get_permalink().'">'.
                                $args['the_attach'].
                            '</a>'.
                         '</div>';

            unset( $size );

            break;
    }

    return $args;
}


/**
 * Generates and returns media and output params for a post type
 *
 * @param  object $post     The post object
 * @param  array  $settings The setting args
 * @return array            The output params in array
 */
function auxin_get_post_type_media_args( $post, $settings = array() ){

    global $aux_content_width;

    $defaults = array(
        'post_type'          => 'post',
        'request_from'       => 'archive',
        'no_gallery'         => false,
        'ignore_media'       => false, // whether to ignore generating the media for post or not
        'crop'               => true,
        'mask_image'         => true, // add max height for the image frame
        'content_width'      => '',
        'upscale_image'      => false,
        'media_size'         => '', // large, medium, thumbnail
        'aspect_ratio'       => 9/16,
        'image_from_content' => true, // whether to try to get image from content or not
        'preloadable'        => true, // whether to lazyload the images or not
        'preload_preview'    => true,
        'preload_bgcolor'    => '',
        'add_image_hw'       => true, // whether to add with and height attrs to image
        'image_sizes'        => 'auto',
        'srcset_sizes'       => 'auto',
        'ignore_formats'     => array() // ignore specific post formats or all by adding *
    );

    $settings = wp_parse_args( $settings, $defaults );
    extract( $settings );

    // call post format media function if post type is post
    if( $post && 'post' == $post_type ) {
        return auxin_get_post_format_media( $post, $settings );
    }

    if ( empty( $media_width ) ) {
        $media_width = $aux_content_width;
    }

    // the array format that will be returned by this function
    $args = array(
        'post_format' => '',
        'has_attach'  => false,
        'the_attach'  => '',
        'the_media'   => '',
        'the_name'    => '',
        'the_link'    => '',
        'show_title'  => true,
        'page_layout' => '',
        'excerpt'     => ''
    );

    if( empty( $post ) ){
        return $args;
    }

    $args['has_attach'] = has_post_thumbnail();


    if( $image_from_content && ! $args['has_attach'] ) {
        $args['the_attach'] = auxin_get_first_image_from_string( get_the_content() );
        $args['has_attach'] = ! empty( $args['the_attach'] );
    } else {
        $args['the_attach'] = auxin_get_the_post_responsive_thumbnail(
            $post->ID,
            array(
                'size'            => $media_size,
                'crop'            => $crop,
                'add_hw'          => $add_image_hw,
                'preloadable'     => $preloadable,
                'preload_preview' => $preload_preview,
                'preload_bgcolor' => $preload_bgcolor,
                'image_sizes'     => $image_sizes,
                'srcset_sizes'    => $srcset_sizes,
                'upscale'         => $upscale_image
            )
        );
    }

    if( ! $args['has_attach'] )
        return $args;

    // get the extra classes for image frame
    $image_frame_extra_class = $mask_image ? 'aux-image-mask' : '';

    $args['the_media'] = '<div class="aux-media-frame aux-media-image '. esc_attr( $image_frame_extra_class ) .'">'.
                    '<a href="'.get_permalink().'">'.
                        $args['the_attach'].
                    '</a>'.
                 '</div>';

    return $args;
}

/**
 * Add  Myaccount Icon and To Header if WC is Active
 *
 * @return string            The HTML Output
 */

function auxin_wc_my_account( $args = array() ){

    $defaults   = array(
            'css_class'      => '',
            'icon_class' => 'auxicon-user',
    );

    $args = wp_parse_args( $args, $defaults );

    if ( class_exists( 'WooCommerce' ) ) {
        $my_account_url = wc_get_page_permalink( 'myaccount' );

        $output  = '<div class="aux-myaccount-wrapper ' . esc_attr( $args['css_class'] ) . '">';
        $output .= '<a class="aux-myaccount-url" href="' . esc_url( $my_account_url ) . '">';
        $output .= '<i class="' . $args['icon_class'] . '"></i>';
        $output .= '</a>';
        $output .= '</div>';

        echo $output;
    } else {
        return;
    }

}
