<?php
/**
 * Header Template Functions.
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */

function auxin_main_title_preset_args( $defaults, $post = null ){
    if( empty( $post ) ){
        return $defaults;
    }

    $titlebar_args = array();

    // title bar is required to appears in archive pages.
    if ( is_archive() ) {

        if( $titlebar_args['show_titlebar'] = auxin_get_option( $post->post_type . '_archive_titlebar_enabled', true ) ){
            $show_titlebar = true;

            if( auxin_get_option( $post->post_type . '_archive_titlebar_title_enabled', true ) ){
                if( $custom_title = auxin_get_option( $post->post_type . '_archive_titlebar_title_context' ) ){
                    $titlebar_args['title'] = $custom_title;
                }
            } else {
                $titlebar_args['titles_enabled'] = '';
            }

            $titlebar_args['bread_enabled'] = auxin_get_option( $post->post_type . '_archive_titlebar_breadcrumb_enabled', true );
        }

    } elseif ( is_search() ) {
        $titlebar_args['show_titlebar'] = true;
        $show_titlebar = true;

    } elseif( $post ){
        // Whether to display title bar or not
        if ( 'default' === $show_titlebar = auxin_get_post_meta( $post, 'aux_title_bar_show', "default" ) ) {
            $show_titlebar = auxin_get_option( $post->post_type . '_title_bar_show' );
        }
        $titlebar_args['show_titlebar'] = $show_titlebar;

        if( $post->ID === get_option( 'page_on_front' ) && 'default' === $show_titlebar ){
            $titlebar_args['show_titlebar'] = '0';
        }
    }

    $titlebar_args['show_titlebar'] = auxin_is_true( $titlebar_args['show_titlebar'] );


    if( ! is_singular() ){
        $defaults['heading_bordered'] = 0;
        $defaults['bread_bordered']   = 0;
        $defaults['bread_enabled']    = 1;
        $defaults['meta_enabled']     = 0;
        $defaults['bread_sep_style']  = 'auxicon-chevron-right-1';
        $defaults['text_align']       = '';

        return wp_parse_args( $titlebar_args, $defaults );
    }

    if( $titlebar_args['show_titlebar'] ){

        if ( 'default' === $show_titlebar || ( auxin_is_true( $show_titlebar ) &&  'default' === auxin_get_post_meta( $post, 'aux_title_bar_preset', 'default' ) ) ) {

            if ( $opt_val = auxin_get_option( $post->post_type . '_title_bar_content_width_type' ) ) {
                $titlebar_args['content_width_type'] = $opt_val;
            }

            if ( $opt_val = auxin_get_option( $post->post_type . '_title_bar_content_section_height' ) ) {
                $titlebar_args['section_height']     = $opt_val;
            }

            $titlebar_args['heading_bordered']   = auxin_get_option( $post->post_type . '_title_bar_heading_bordered' );
            $titlebar_args['heading_boxed']      = auxin_get_option( $post->post_type . '_title_bar_heading_boxed' );
            $titlebar_args['heading_bg_color']   = auxin_get_option( $post->post_type . '_title_bar_heading_bg_color' );
            $titlebar_args['titles_enabled']     = auxin_get_option( $post->post_type . '_title_bar_title_show' );
            $titlebar_args['meta_enabled']       = auxin_get_option( $post->post_type . '_title_bar_meta_enabled' );
            $titlebar_args['bread_enabled']      = auxin_get_option( $post->post_type . '_title_bar_bread_enabled' );
            $titlebar_args['bread_bordered']     = auxin_get_option( $post->post_type . '_title_bar_bread_bordered' );

            if ( $opt_val = auxin_get_option( $post->post_type . '_title_bar_bread_sep_style' ) ) {
                $titlebar_args['bread_sep_style']     = $opt_val;
            }

            if ( $opt_val = auxin_get_option( $post->post_type . '_title_bar_text_align' ) ) {
                $titlebar_args['text_align']     = $opt_val;
            }

            if ( $opt_val = auxin_get_option( $post->post_type . '_title_bar_vertical_align' ) ) {
                $titlebar_args['vertical_align']     = $opt_val;
            }

            if ( $opt_val = auxin_get_option( $post->post_type . '_title_bar_scroll_arrow' ) ) {
                $titlebar_args['scroll_arrow']     = $opt_val;
            }

            if ( $opt_val = auxin_get_option( $post->post_type . '_title_bar_color_style' ) ) {
                $titlebar_args['color_style']     = $opt_val;
            }

            if ( $opt_val = auxin_get_option( $post->post_type . '_title_bar_overlay_color' ) ) {
                $titlebar_args['overlay_color']     = $opt_val;
            }

            if ( $opt_val = auxin_get_option( $post->post_type . '_title_bar_overlay_pattern' ) ) {
                $titlebar_args['overlay_pattern']     = $opt_val;
            }

            if ( $meta_val = auxin_get_option( $post->post_type . '_title_bar_bg_show', false ) ) {

                // bg image
                if ( $meta_val = auxin_get_option( $post->post_type . '_title_bar_bg_image', '' ) ) {
                    $titlebar_args['bg_image'] = $meta_val;
                }

                // bg size
                if ( $meta_val = auxin_get_option( $post->post_type . '_title_bar_bg_size', 'cover' ) ) {
                    $titlebar_args['bg_size'] = $meta_val;
                }

                // bg color
                if ( $meta_val = auxin_get_option( $post->post_type . '_title_bar_bg_color', '' ) ) {
                    $titlebar_args['bg_color'] = $meta_val;
                }

                // bg video mp4
                if ( $meta_val = auxin_get_option( $post->post_type . '_title_bar_bg_video_mp4', '' ) ) {
                    $titlebar_args['video_mp4'] = wp_get_attachment_url( $meta_val );
                }

                // bg video webm
                if ( $meta_val = auxin_get_option( $post->post_type . '_title_bar_bg_video_webm', '' ) ) {
                    $titlebar_args['video_webm'] = wp_get_attachment_url( $meta_val );
                }

                // bg video ogg
                if ( $meta_val = auxin_get_option( $post->post_type . '_title_bar_bg_video_ogg', '' ) ) {
                    $titlebar_args['video_ogg'] = wp_get_attachment_url( $meta_val );
                }

                // bg parallax
                $titlebar_args['bg_parallax'] = auxin_get_option( $post->post_type . '_title_bar_bg_parallax', false );
            }

        } else {

            // content_width_type
            if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_content_width_type', 'boxed' ) ){
                $titlebar_args['content_width_type'] = $meta_val;
            }

            // section_height
            if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_content_section_height', '' ) ){
                $titlebar_args['section_height'] = $meta_val;
            }

            // heading_bordered
            $titlebar_args['heading_bordered'] = auxin_get_post_meta( $post, 'aux_title_bar_heading_bordered', 0 );

            // heading_boxed
            $titlebar_args['heading_boxed']  = auxin_get_post_meta( $post, 'aux_title_bar_heading_boxed', 0 );

            // heading bg color
            $titlebar_args['heading_bg_color']  = auxin_get_post_meta( $post, 'aux_title_bar_heading_bg_color', '' );

            // post title enabled
            $titlebar_args['titles_enabled']   = auxin_get_post_meta( $post, 'aux_title_bar_title_show', 1 );

            // post meta enabled
            $titlebar_args['meta_enabled']   = auxin_get_post_meta( $post, 'aux_title_bar_meta_enabled', 0 );

            // bread_enabled
            $titlebar_args['bread_enabled']  = auxin_get_post_meta( $post, 'aux_title_bar_bread_enabled', 1 );

            // bread_bordered
            $titlebar_args['bread_bordered'] = auxin_get_post_meta( $post, 'aux_title_bar_bread_bordered', 0 );

            // bread_sep_style
            if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_bread_sep_style', 'auxicon-chevron-right-1' ) ){
                $titlebar_args['bread_sep_style'] = $meta_val;
            }

            // text_align
            if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_text_align', 'left' ) ){
                $titlebar_args['text_align'] = $meta_val;
            }

            // vertical_align
            if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_vertical_align', 'top' ) ){
                $titlebar_args['vertical_align'] = $meta_val;
            }

            // scroll_arrow
            if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_scroll_arrow', 'none' ) ){
                $titlebar_args['scroll_arrow'] = $meta_val;
            }

            // color_style
            if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_color_style', 'dark' ) ){
                $titlebar_args['color_style'] = $meta_val;
            }

            // overlay_color
            if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_overlay_color', '' ) ){
                $titlebar_args['overlay_color'] = $meta_val;
            }

            // overlay_pattern
            if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_overlay_pattern', '' ) ){
                $titlebar_args['overlay_pattern'] = $meta_val;
            }

            if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_bg_show', false ) ){

                // bg image
                if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_bg_image', '' ) ){
                    $titlebar_args['bg_image'] = $meta_val;
                }

                // bg size
                if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_bg_size', 'cover' ) ){
                    $titlebar_args['bg_size'] = $meta_val;
                }

                // bg color
                if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_bg_color', '' ) ){
                    $titlebar_args['bg_color'] = $meta_val;
                }

                // bg video mp4
                if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_bg_video_mp4', '' ) ){
                    $titlebar_args['video_mp4'] = wp_get_attachment_url( $meta_val );
                }

                // bg video webm
                if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_bg_video_webm', '' ) ){
                    $titlebar_args['video_webm'] = wp_get_attachment_url( $meta_val );
                }

                // bg video ogg
                if( $meta_val = auxin_get_post_meta( $post, 'aux_title_bar_bg_video_ogg', '' ) ){
                    $titlebar_args['video_ogg'] = wp_get_attachment_url( $meta_val );
                }

                // bg parallax
                $titlebar_args['bg_parallax'] = auxin_get_post_meta( $post, 'aux_title_bar_bg_parallax', false );
            }
        }

    }

    if ( is_singular() ) { // in this case one of is_single, is_page, is_page returns true

        if( is_single() && ( 'testimonial' == get_post_type() ) ) {
            $titlebar_args['subtitle'] = ! empty( $post ) ? auxin_get_post_meta( $post, 'customer_job' , '' ) : '';
        } else{
            $titlebar_args['subtitle'] = ! empty( $post ) ? auxin_get_post_meta( $post, 'page_subtitle', '' ) : '';
            $titlebar_args['position'] = ! empty( $post ) ? auxin_get_post_meta( $post, 'subtitle_position', 'after' ) : 'after';
        }

    }

    return wp_parse_args( $titlebar_args, $defaults );
}
add_filter( 'auxin_main_title_args', 'auxin_main_title_preset_args', 19, 2 );



/**
 * Display page title section
 *
 * @since 2.0.0
 */
if( ! function_exists( 'auxin_the_main_title_section' ) ){

    function auxin_the_main_title_section( $args = array() ){
        global $post;

        //  dont display title bar on 404 page
        if( is_404() ){
            return;
        }

        // default title section args
        $defaults = array(
            'show_titlebar'     => 1, // whether display title bar or not
            'title'             => '',
            'subtitle'          => '',
            'position'          => '',
            'content_width_type'=> 'boxed', // boxed, semi-full, full, default
            'section_height'    => '', // full, 300px, auto
            'heading_bordered'  => 1,
            'heading_boxed'     => 0,
            'heading_bg_color'  => '',
            'bread_bordered'    => 1,
            'bread_enabled'     => 1,
            'titles_enabled'    => 1,
            'meta_enabled'      => 1,
            'bread_sep_style'   => 'auxicon-chevron-right-1',
            'text_align'        => 'center', // center, left, right
            'vertical_align'    => 'top', // top, middle, bottom, bottom-overlap
            'color_style'       => 'dark', // light, dark,
            'scroll_arrow'      => '', // round, classic
            'overlay_color'     => '', // light, dark
            'overlay_pattern'   => '', // hash, ..
            'bg_image'          => '', // section background image
            'bg_size'           => '',  // section background image size
            'bg_color'          => '',  // section background color
            'bg_parallax'       => 0,
            'video_mp4'         => '',
            'video_ogg'         => '',
            'video_webm'        => '',
            'has_helper_wrapper'=> true
        );


        if( is_home() ){

            $posts_page_id = get_option( 'page_for_posts' );
            $defaults['title'] = get_the_title( $posts_page_id );
            // lets disable titlebar on home page temporary
            return '';

        } elseif ( is_search() ){

            $defaults['title'] = __( 'Results for: ', 'phlox-pro') . '<span>'. get_search_query() . '</span>';

        /* If this is a category archive */
        } elseif ( is_archive() ) {

            if( is_category() ){
                $defaults['title'] = __('Posts in category', 'phlox-pro'). ': '. single_cat_title( '', false);
                $defaults['subtitle'] = category_description();
            /* If this is a tag archive */
            } elseif( is_tag() ){
                $defaults['title'] = __('Posts tagged', 'phlox-pro') . ': '. single_tag_title('', false);
            /* If this is a daily archive */
            } elseif ( is_day() ){
                $defaults['title'] = __("Daily Archives", 'phlox-pro') .': '. get_the_date();
            /* If this is a monthly archive */
            } elseif ( is_month() ){
                $defaults['title'] = __("Monthly Archives", 'phlox-pro') .': '. get_the_date('F Y');
            /* If this is a yearly archive */
            } elseif ( is_year() ){
                $defaults['title'] = __("Yearly Archives", 'phlox-pro') .': '. get_the_date('Y');
            /* If this is an author archive */
            } elseif ( is_author() ){
                $defaults['title'] = _x("All posts by : ", "Title of all posts by author", 'phlox-pro') . get_the_author();
            /* If this is an author archive */
            } elseif ( is_tax() ) {
                $term  = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
                $defaults['title'] = $term->name;
            /* If this is a custom post type archive(index) page */
            } elseif( is_post_type_archive() ){
                $defaults['title'] = auxin_get_the_post_type_user_defined_name();
            }

        } elseif ( is_singular() ) { // in this case one of is_single, is_page, is_page returns true
            $defaults['title'] = get_the_title();
        }

        // if it was 'no-result' page
        if( ! $post ){
            $defaults['meta_enabled']       = false;
            $defaults['heading_bordered']   = false;
            $defaults['text_align']         = 'left';
            $defaults['content_width_type'] = 'boxed';
        }


        $args = wp_parse_args( $args, $defaults );
        $args = apply_filters( 'auxin_main_title_args', $args, $post );

        if( null === $args ){ return; }

        if( ! auxin_is_true( $args['show_titlebar'] ) ){
            return;
        }

        $customizer_container = is_customize_preview() && $args['has_helper_wrapper'] ? array( 'before' => '<div class="aux-customizer-page-title-container">', 'after' => '</div>' ) : array( 'before' => '', 'after' =>'' );

        // Default classes for title bar
        $header_classes = array('page-header', 'aux-wrapper');

        if( ! empty( $args['subtitle'] ) ){
            $header_classes[] = 'has-subtitle';
        }


        if( ! empty( $args['section_height'] ) ){
            $header_classes[] = 'aux-'.$args['section_height'].'-height';
        }
        if( ! empty( $args['content_width_type'] ) && 'default' != $args['content_width_type'] ){
            $header_classes[] = 'aux-'. $args['content_width_type'] .'-container';
        }
        if( $args['heading_bordered'] ){
            $header_classes[] = 'aux-heading-bordered';
        }
        if( $args['heading_boxed'] ){
            $header_classes[] = 'aux-heading-boxed';
        }
        if( $args['bread_bordered'] ){
            $header_classes[] = 'aux-bread-bordered';
        }
        if( ! empty( $args['text_align'] ) ){
            $header_classes[] = 'aux-'. $args['text_align'];
        }
        if( ! empty( $args['vertical_align'] ) ){
            $header_classes[] = 'aux-'. $args['vertical_align'];
        }
        if( ! empty( $args['color_style'] ) ){
            $header_classes[] = 'aux-'. $args['color_style'];
        }
        if( ! empty( $args['scroll_arrow'] ) ){
            $header_classes[] = 'aux-arrow-'. $args['scroll_arrow'];
        }
        if( ! empty( $args['overlay_pattern'] ) && 'none' !== $args['overlay_pattern'] ){
            $header_classes[] = 'aux-overlay-bg-'. $args['overlay_pattern'];
        }
        if( $args['bg_parallax'] ){
            $header_classes[] = 'aux-parallax-box';
        }

        $page_header_style = "display:block; ";


        $bg_img_url = '';

        if( ! empty( $args['bg_image'] ) ){

            $attach_ids = explode( ',', $args['bg_image'] );

            $bg_img_url    = wp_get_attachment_url( $attach_ids[0] ,'full' ); //get img URL
        }

        if( ! empty( $args['bg_color'] ) ){
            $page_header_style .= 'background-color: ' . $args['bg_color'] . ' !important; ';
        }
        if( ! empty( $args['bg_size'] ) && 'cover' != $args['bg_size'] ){
            $page_header_style .= 'background-size: ' . $args['bg_size'] . ' !important; ';
        }


        $inline_style = '';
        if( ! empty( $page_header_style ) ){
            $inline_style = ' style="' . esc_attr( $page_header_style ) . '" ';
        }

        // get the bg color of heading box
        $title_group_inline_style =  $args['heading_boxed'] && ! empty( $args['heading_bg_color'] ) ? 'style="background-color: ' . esc_attr( $args['heading_bg_color'] ) . ' !important;"' : '';

        echo $customizer_container['before'];
        ?>
        <header id="site-title" class="page-title-section">

            <div <?php echo auxin_make_html_class_attribute( $header_classes ); echo $inline_style; ?>  >

                <?php // Print video background
                    echo auxin_get_media_background(
                        array(
                            'color' => $args['bg_color'],
                            'image' => $bg_img_url,
                            'ogg'   => $args['video_ogg' ],
                            'webm'  => $args['video_webm'],
                            'mp4'   => $args['video_mp4' ],
                            'size'  => $args['bg_size'   ],
                            'parallax' => 0.5
                        )
                    );
                ?>

                <div class="aux-container" >

                    <?php // ------------- breadcrumb ---------------
                        if( $args['bread_enabled'] ){
                            auxin_the_breadcrumbs( '', $args['bread_sep_style'] );
                        }
                    ?>

                    <?php if( $args['titles_enabled'] || $args['meta_enabled'] ){ ?>
                    <div class="aux-page-title-entry">
                    <?php if ( $args['bg_parallax'] ) {?>
                        <div class="aux-page-title-box aux-parallax" data-parallax-depth="0.5">
                    <?php } else { ?>
                        <div class="aux-page-title-box">
                    <?php } ?>
                            <section class="page-title-group" <?php echo $title_group_inline_style; ?>>
                                <?php if( ! empty( $args['subtitle'] ) && $args['position'] === 'before'  ) { ?>
                                <h3 class="page-subtitle" ><?php echo wp_kses( $args['subtitle'], array() ); ?></h3>
                                <?php } if( $args['titles_enabled'] && ! empty( $args['title'] ) ) { ?>
                                <h1 class="page-title"><?php echo wp_kses( $args['title'], array() ); ?></h1>
                                <?php } if( ! empty( $args['subtitle'] ) && $args['position'] === 'after'  ) {  ?>
                                <h3 class="page-subtitle" ><?php echo wp_kses( $args['subtitle'], array() ); ?></h3>
                                <?php } ?>
                            </section>

                            <?php if( $args['meta_enabled'] ){ // Post meta ?>
                            <div class="page-title-meta aux-single-inline-meta">
                                <span><?php _e("Posted on", 'phlox-pro'); ?></span>
                                <time datetime="<?php esc_attr( get_the_date( DATE_W3C ) ); ?>" ><?php the_date(); ?></time>
                                <span class="entry-meta-sep meta-sep"><?php _e("by", 'phlox-pro'); ?></span>
                                <span class="author vcard">
                                    <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php echo esc_url( sprintf( __( 'View all posts by %s', 'phlox-pro' ), get_the_author() ) ); ?>" >
                                        <?php the_author(); ?>
                                    </a>
                                </span>
                                <?php edit_post_link( __('Edit', 'phlox-pro'), '<i> | </i>', '' ); ?>
                            </div>
                            <?php } ?>
                        </div>
                    </div><!-- end title entry -->
                    <?php
                    }

                    $arrow_color_style =  'light' == $args['color_style'] ? 'aux-white' : '';
                    $arrow_hover_color_style =  'light' == $args['color_style'] ? '' : 'aux-white';

                    if ( 'none' !== $args['scroll_arrow'] && 'full' == $args['section_height'] ) {
                        printf( '<div class="aux-title-scroll-down %s" %s>', ( $args['bg_parallax'] ? 'aux-parallax' : '' ), ( $args['bg_parallax'] ? 'data-parallax-depth="1"' : '' ) );
                    ?>
                         <div class="aux-down-arrow aux-arrow-nav aux-round aux-hover-fill <?php echo esc_attr( $arrow_color_style ); ?>">
                                <span class="aux-svg-arrow aux-h-medium-down prim-arrow <?php echo esc_attr( $arrow_hover_color_style ); ?>"></span>
                                <span class="aux-hover-arrow aux-svg-arrow aux-h-medium-down prim-arrow <?php echo esc_attr( $arrow_color_style ); ?>"></span>
                        </div>
                    </div>
                    <?php } ?>
                </div>

                <?php
                    if( ! empty( $args['overlay_color'] ) ){
                        echo '<div class="aux-header-overlay" style="background-color: ' . $args['overlay_color'] . '"></div>';
                    }
                ?>

            </div><!-- end page header -->
        </header> <!-- end page header -->
        <?php
        echo $customizer_container['after'];
    }

}



/**
 * Display the slider for the page
 *
 * @since 2.0.0
 *
 * @return string   The custom background styles for the page
 */
if( ! function_exists( 'auxin_the_header_slider_section' ) ){

    function auxin_the_header_slider_section(){
        global $post;

        if( ! is_object( $post ) )
            return '';

        // get slider ID
        $slider_slug = apply_filters( 'auxin_header_slider_slug', get_post_meta( $post->ID, 'top_slider_id', true ), $post );

        // get slider layout
        $slider_width    = '';
        $container_class = array('aux-top-slider');
        $container_class = apply_filters( 'auxin_header_slider_class', $container_class, $post, $slider_slug, $slider_width );
        if( is_array( $container_class ) ){
            $container_class = join( ' ', $container_class );
        }

        $styles = '';
        if( $margin = auxin_get_post_meta( $post, 'top_slider_margin_top', '' )){
            $styles .= 'margin-top:'. trim($margin, 'px').'px;';
        }
        if( $margin = auxin_get_post_meta( $post, 'top_slider_margin_bottom', '' )){
            $styles .= 'margin-bottom:'. trim($margin, 'px').'px;';
        }
        unset( $margin );


        $wrapper_start_tag = '<div id="site_topslider" class="'.$container_class.'" style="'. esc_attr( $styles ) .'"><div class="aux-wrapper"><div class="aux-container">';
        $wrapper_end_tag   = '</div></div></div>';

        do_action( 'auxin_the_header_slider', $post, $slider_slug );


        if( empty( $slider_slug ) || $slider_slug == 'none' )
            return '';

        // the slider is flex or nivo slider
        if( is_numeric( $slider_slug ) ){

            // echo slider wrapper
            echo $wrapper_start_tag;

            $slider_options = get_post_meta( $slider_slug, 'slider-data', true );

            if( $slider_options["type"] == 'flex' )
                echo do_shortcode('[the_flexslider id="'.$slider_slug.'" ]');
            elseif($slider_options["type"] == 'nivo' )
                echo do_shortcode('[the_nivoslider id="'.$slider_slug.'" ]');

            // action to display more slider types here
            do_action("auxin_the_header_builtin_slider", $slider_options["type"], $slider_slug);

            echo $wrapper_end_tag;

        // if the slider is cute slider
        } elseif( substr( $slider_slug, 0, 3 ) == "ms_" ){
            echo $wrapper_start_tag;

            $ms_id = substr($slider_slug, 3);
            echo do_shortcode( '[masterslider id="'.$ms_id.'" ]' );

            echo $wrapper_end_tag;

        // if the slider is layer slider
        } elseif( substr( $slider_slug, 0, 3 ) == "ls_" ){
            echo $wrapper_start_tag;

            $ls_id = substr( $slider_slug, 3 );
            echo do_shortcode( '[layerslider id="'.$ls_id.'" ]' );

            echo $wrapper_end_tag;

        // if the slider is cute slider
        } elseif( substr( $slider_slug, 0, 3 ) == "cs_" ){
            echo $wrapper_start_tag;

            $cs_id = substr($slider_slug, 3);
            echo do_shortcode('[cuteslider id="'.$cs_id.'" ]');

            echo $wrapper_end_tag;

        // the slider is revolution slider
        } elseif ( class_exists( 'RevSlider' ) ){
            echo '<div id="site_topslider" class="aux-top-slider" >';

            putRevSlider( $slider_slug );

            echo $wrapper_end_tag;
        }

    }

}

/**
 * Retrieves the markup of archive post slider section
 *
 * @param  string $post_type The post type for post slider. Default 'post'
 * @param  string $location  The requested location of post slider, possible values: 'content', 'block'
 * @return string            The markup of section
 */
function auxin_get_the_archive_slider( $post_type = 'post', $request_for_location = 'block' ){

    // skip if auxin elements plugin is not active
    if ( ! function_exists('AUXELS') || ! auxin_get_option( 'post_archive_slider_show' ) ) {
        return '';
    }
    // skip if it is a woocommerce or portfolio arhicve.
    if( is_tax() || is_post_type_archive('portfolio') || is_post_type_archive('news') || ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product_category() || is_product_tag() ) ) ) {
                return'';
        }
    // get and compare the allowed location for archive post slider
    if( $request_for_location !== ( $allowed_location = auxin_get_option( 'post_archive_slider_location' ) ) ){
        return '';
    }

    if( auxin_is_blog() && !is_search() ){

        // store the slider markup
        $the_slider_markup = '';

        // if the slider type is masterslider
        if( 'masterslider' === auxin_get_option('post_archive_slider_type', 'default')  ){

            if( defined( 'MSWP_AVERTA_VERSION' ) && ( $slider_slug = auxin_get_option( 'post_archive_slider_id' ) ) && 'none' !== $slider_slug ){
                if( substr( $slider_slug, 0, 3 ) == "ms_" ){
                    $the_slider_markup .= do_shortcode( '[masterslider id="'. substr( $slider_slug, 3 ) .'" ]' );
                }
            }

        // if it's default built-in slider
        } else {
            $the_slider_markup .= auxin_get_latest_posts_slider();
        }


        if( 'content' == $request_for_location ){
            // insert post slider at top of blog archive page
            return '<div class="aux-archive-post-slider aux-wrapper-post-slider">' . $the_slider_markup . '</div>';

        } else {
                $result  = '<div class="aux-top-slider aux-top-post-slider aux-wrapper-post-slider"><div class="aux-wrapper"><div class="aux-container aux-fold">';
                $result .= $the_slider_markup;
                $result .= '</div></div></div>';
                return $result;
        }

    }

    return null;
}


/**
 * Retrieves the header layout
 *
 * @param  string $layout The layout name
 * @return string         Markup for header section
 */
function auxin_get_header_layout( $layout = '' ){
    global $post;

    if( empty( $layout ) ){
        $layout = auxin_get_post_meta( $post, 'page_header_navigation_layout', 'default') ;
        $layout = 'default' === $layout ? auxin_get_option( 'site_header_top_layout', 'horizontal-menu-right' ) : $layout;
    }

    $header_position = auxin_get_option( 'site_header_position', 'top' );  // header position on desktop size (top, right, left)

    $mobile_menu_position = auxin_get_option( 'site_header_mobile_menu_position', 'toggle-bar' );  // the menu position on mobile and tablet size (toggle-bar, offcanvas, overlay, none)

    if ( 'default' === $can_scale = auxin_get_post_meta( $post, 'page_header_logo_can_scale', '1' ) ) {
        $can_scale = auxin_get_option( 'site_header_logo_can_scale', true );
    }

    if ( 'default' === $add_search = auxin_get_post_meta( $post, 'page_header_search_button', 'default' ) ) {
        $add_search    = auxin_get_option( 'site_header_search_button' );
    }

    if ( 'default' === $social_display = auxin_get_post_meta( $post, 'page_header_social_icons', 'default' ) ) {
        $social_display    = auxin_get_option( 'site_header_social_icons' );
    }

    if ( 'default' === $icon_size = auxin_get_post_meta( $post, 'page_header_social_icons_size', 'default' ) ) {
        $icon_size    = auxin_get_option( 'site_header_social_icons_size', 'small' );
    }

    if ( 'default' === $add_cart = auxin_get_post_meta( $post, 'page_show_header_cart', 'default' ) ) {
        $add_cart = auxin_get_option( 'show_header_cart' );
    }

    if ( 'default' === $my_account = auxin_get_post_meta( $post, 'page_show_my_account', 'default' ) ) {
        $my_account = auxin_get_option( 'show_header_myaccount' );
    }

    if ( 'default' === $wishlist = auxin_get_post_meta( $post, 'page_show_wishlist', 'default' ) ) {
        $wishlist = auxin_get_option( 'show_header_wishlist' );
    }

    $device_classes = auxin_is_true( auxin_get_option( 'tablet_show_header_cart', false ) ) ? '' : ' aux-tablet-off';
    $device_classes .= auxin_is_true( auxin_get_option( 'mobile_show_header_cart', false ) ) ? '' : ' aux-phone-off';

    $logo_markup   = auxin_get_custom_logo_block( array(
        'css_class' => 'aux-logo-header-inner' . ( auxin_is_true( $can_scale ) ? ' aux-scale' : '' ),
        'middle'    => true
    ));

    // whether locate submenu below the menu items.
    $submenu_below = auxin_get_option( 'site_header_navigation_sub_location', 'below-menu-item' ) == 'below-menu-item';

    ob_start();

    $site_mobile_header_toggle_button_style = esc_attr( auxin_get_option( 'site_mobile_header_toggle_button_style', 'aux-lite-small' ) );

    if ( 'default' === $dropdown_skin = auxin_get_post_meta( $post, 'page_header_cart_dropdown_skin', 'default' ) ) {
        $dropdown_skin = auxin_get_option('header_cart_dropdown_skin');
    }

    if ( 'default' === $cart_icon = auxin_get_post_meta( $post, 'page_header_cart_icon', 'default' ) ) {
        $cart_icon = auxin_get_option( 'header_cart_icon' , 'auxicon-shopping-cart-1-1' );
    }

    if ( 'default' === $action_on = auxin_get_post_meta( $post, 'page_header_cart_dropdown_action_on', 'default' ) ) {
        $action_on = auxin_get_option('header_cart_dropdown_action_on');
    }

    if ( 'default' === $cart_type = auxin_get_post_meta( $post, 'page_header_cart_type', 'default' ) ) {
        $cart_type = auxin_get_option('header_cart_type');
    }

    // check to display none cart dropdown if the style of cart is off canvas
    if ( $cart_type == 'offcanvas' ) {
        $dropdown_class = ' aux-desktop-off aux-tablet-off';
    } else {
        if ( 'dropdown' == auxin_get_option( 'tablet_header_cart_type', 'dropdown' ) ) {
            $dropdown_class = "";
        } else {
            $dropdown_class = " aux-tablet-off";
        }
    }

    $simple_mode = auxin_get_option('site_header_card_mode', '0');
    if ( ! auxin_is_true( $simple_mode ) ) {
        $dropdown_class .= " aux-modern-dropdown";
    }

    $button1_breakpoints  = auxin_get_option ( 'site_header_show_btn1_on_tablet', '1') ? 'aux-tablet-off ': '';
    $button1_breakpoints .= auxin_get_option ( 'site_header_show_btn1_on_phone', '1') ? 'aux-phone-off ' : '';

    $button2_breakpoints  = auxin_get_option ( 'site_header_show_btn2_on_tablet', '1') ? 'aux-tablet-off ': '';
    $button2_breakpoints .= auxin_get_option ( 'site_header_show_btn2_on_phone', '1') ? 'aux-phone-off ' : '';

    $menu = 'default' !== auxin_get_post_meta( $post, 'page_header_menu' ) ? auxin_get_post_meta( $post, 'page_header_menu' ) : null;

    switch ( $layout ) {

        case 'horizontal-menu-left':
            ?>
            <div class="aux-header aux-header-elements-wrapper aux-float-layout">
                <!-- ribbon bar -->
                <div class="aux-header-elements">

                    <!-- logo -->
                    <div id="logo" class="aux-logo-header aux-end aux-fill aux-tablet-center aux-phone-left">
                        <?php echo $logo_markup; ?>
                    </div>
                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- burger -->
                    <div id="nav-burger" class="aux-burger-box aux-start aux-phone-on aux-middle" data-target-panel="<?php echo esc_attr( $mobile_menu_position ); ?>" data-target-content=".site-header-section .aux-master-menu">
                        <div class="aux-burger <?php echo esc_attr( $site_mobile_header_toggle_button_style ); ?>"><span class="mid-line"></span></div>
                    </div>
                    <?php } ?>

                    <div class="aux-btns-box aux-btn1-box aux-start aux-middle <?php echo esc_attr( $button1_breakpoints );?>">
                        <?php if( function_exists( 'auxin_get_header_button' ) ){ echo auxin_get_header_button( 1 ); } ?>
                    </div>
                    <div class="aux-btns-box aux-btn2-box aux-start aux-middle <?php echo esc_attr( $button2_breakpoints );?>">
                        <?php if( function_exists( 'auxin_get_header_button' ) ){ echo auxin_get_header_button( 2 ); } ?>
                    </div>
                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- menu -->
                    <div class="aux-menu-box aux-phone-off aux-auto-locate aux-start <?php echo $submenu_below ? 'aux-middle aux-tabel-center-middle' : 'aux-fill aux-tablet-center'; ?>" data-tablet=".aux-header .secondary-bar-2">
                    <?php

                        /* The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.*/
                        wp_nav_menu( array(
                            'menu' => $menu,
                            'container_id'   => 'master-menu-main-header',
                            'theme_location' => 'header-primary'
                        ));
                    ?>
                    </div>
                    <?php } ?>
                    <?php if ( auxin_is_true( $add_search ) ) { ?>
                    <!-- search -->
                    <div class="aux-search-box aux-desktop-on aux-start aux-middle">
                        <?php echo auxin_get_search_box( array( 'has_form' => false, 'has_toggle_icon' => true, 'toggle_icon_class' => 'aux-overlay-search' ) );?>
                    </div>
                    <?php } ?>
                    <?php
                        if( auxin_is_true( $add_cart ) ) {
                            auxin_wc_add_to_cart(
                                array(
                                    'css_class'     => 'aux-cart-box aux-start aux-fill ' . $device_classes .' aux-cart-type-'.$cart_type,
                                    'dropdown_skin' => $dropdown_skin,
                                    'dropdown_class'=> $dropdown_class,
                                    'action_on'     => $action_on,
                                    'icon'          => $cart_icon,
                                    'simple_mode'   => $simple_mode
                                )
                            );
                        }
                    ?>
                    <?php
                        if( auxin_is_true( $social_display ) ) {
                            auxin_the_socials( array(
                                'css_class' => 'aux-start aux-middle aux-tablet-off aux-phone-off',
                                'size'      => $icon_size,
                                'direction' => 'horizontal'
                            ));
                        }
                    ?>
                </div>
                <!-- secondary bar: this element will be filled in tablet size -->
                <div class="bottom-bar secondary-bar secondary-bar-2  aux-tablet-on aux-float-wrapper"></div>

                <!-- toggle menu bar: this element will be filled in tablet and mobile size -->
                <div class="aux-toggle-menu-bar"></div>
            </div>
            <?php
            break;

        case 'burger-right':

            ?>
            <div class="aux-header aux-header-elements-wrapper aux-float-layout">
                <!-- ribbon bar -->
                <div class="aux-header-elements">

                    <!-- logo -->
                    <div id="logo" class="aux-logo-header aux-start aux-fill aux-tablet-center aux-phone-center">
                        <?php echo $logo_markup; ?>
                    </div>

                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- burger -->
                    <div id="nav-burger" class="aux-burger-box aux-end aux-middle" data-target-panel="<?php echo esc_attr( $mobile_menu_position ); ?>"  data-target-content=".site-header-section .aux-master-menu">
                        <div class="aux-burger <?php echo esc_attr( $site_mobile_header_toggle_button_style ); ?>"><span class="mid-line"></span></div>
                    </div>
                    <?php } ?>

                    <?php if ( auxin_is_true( $add_search ) ) { ?>
                     <!-- search -->
                    <div class="aux-search-box aux-desktop-on aux-end aux-middle">
                        <?php echo auxin_get_search_box( array( 'has_form' => false, 'has_toggle_icon' => true, 'toggle_icon_class' => 'aux-overlay-search' ) );?>
                    </div>
                    <?php } ?>
                    <?php
                        if( auxin_is_true( $add_cart ) ) {
                            auxin_wc_add_to_cart(
                                array(
                                    'css_class' => 'aux-cart-box aux-end aux-fill ' . $device_classes .' aux-cart-type-'.$cart_type,
                                    'dropdown_skin' => $dropdown_skin,
                                    'dropdown_class'=> $dropdown_class,
                                    'action_on'     => $action_on,
                                    'icon'          => $cart_icon,
                                    'simple_mode'   => $simple_mode
                                )
                            );
                        }
                    ?>
                    <?php
                        if( auxin_is_true( $social_display ) ) {
                            auxin_the_socials( array(
                                'css_class' => 'aux-end aux-middle aux-tablet-off aux-phone-off',
                                'size'      => $icon_size,
                                'direction' => 'horizontal'
                            ));
                        }
                    ?>
                    <?php if ( 'none' !== $menu ) { ?>
                    <div class="aux-menu-box aux-off aux-auto-locate aux-end aux-fill aux-tablet-center" >
                    <?php
                        /* The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.*/
                        wp_nav_menu( array(
                            'menu' => $menu,
                            'container_id'   => 'master-menu-main-header',
                            'theme_location' => 'header-primary',
                            'mobile_under'   => 7000
                        ));
                    ?>
                    </div>
                    <?php } ?>
                </div>

                <!-- toggle menu bar: this element will be filled in tablet and mobile size -->
                <div class="aux-toggle-menu-bar"></div>

            </div>
            <?php
            break;

        case 'burger-left':

            ?>
            <div class="aux-header aux-header-elements-wrapper aux-float-layout">
                <!-- ribbon bar -->
                <div class="aux-header-elements">

                    <!-- logo -->
                    <div id="logo" class="aux-logo-header aux-end aux-fill aux-tablet-center aux-phone-left">
                        <?php echo $logo_markup; ?>
                    </div>
                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- burger -->
                    <div id="nav-burger" class="aux-burger-box aux-start aux-middle" data-target-panel="<?php echo esc_attr( $mobile_menu_position ); ?>" data-target-content=".site-header-section .aux-master-menu">
                        <div class="aux-burger <?php echo esc_attr( $site_mobile_header_toggle_button_style ); ?>"><span class="mid-line"></span></div>
                    </div>
                    <?php } ?>
                    <?php if ( auxin_is_true( $add_search ) ) { ?>
                    <!-- search -->
                    <div class="aux-search-box aux-desktop-on aux-start aux-middle">
                        <?php echo auxin_get_search_box( array( 'has_form' => false, 'has_toggle_icon' => true, 'toggle_icon_class' => 'aux-overlay-search' ) );?>
                    </div>
                    <?php } ?>
                    <?php
                        if( auxin_is_true( $add_cart ) ) {
                            auxin_wc_add_to_cart(
                                array(
                                    'css_class' => 'aux-cart-box aux-start aux-fill ' . $device_classes .' aux-cart-type-'.$cart_type,
                                    'dropdown_skin' => $dropdown_skin,
                                    'dropdown_class'=> $dropdown_class,
                                    'action_on'     => $action_on,
                                    'icon'          => $cart_icon,
                                    'simple_mode'   => $simple_mode
                                )
                            );
                        }
                    ?>
                    <?php
                        if( auxin_is_true( $social_display ) ) {
                            auxin_the_socials( array(
                                'css_class' => 'aux-start aux-middle aux-tablet-off aux-phone-off',
                                'size'      => $icon_size,
                                'direction' => 'horizontal'
                            ));
                        }
                    ?>
                    <?php if ( 'none' !== $menu ) { ?>
                    <div class="aux-menu-box aux-off aux-auto-locate aux-start aux-fill aux-tablet-center" >
                    <?php
                        /* The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.*/
                        wp_nav_menu( array(
                            'menu' => $menu,
                            'container_id'   => 'master-menu-main-header',
                            'theme_location' => 'header-primary',
                            'mobile_under'   => 7000
                        ));
                    ?>
                    </div>
                    <?php } ?>
                </div>

                <!-- toggle menu bar: this element will be filled in tablet and mobile size -->
                <div class="aux-toggle-menu-bar"></div>

            </div>
            <?php
            break;

        case 'horizontal-menu-center':

            ?>
            <div class="aux-header aux-header-elements-wrapper aux-float-layout">
                <!-- ribbon bar -->
                <div class="aux-header-elements">

                    <!-- logo -->
                    <div id="logo" class="aux-logo-header aux-fill aux-center aux-phone-center">
                        <?php echo $logo_markup; ?>
                    </div>
                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- burger -->
                    <div id="nav-burger" class="aux-burger-box aux-start aux-phone-on aux-middle" data-target-panel="<?php echo esc_attr( $mobile_menu_position ); ?>" data-target-content=".site-header-section .aux-master-menu">
                        <div class="aux-burger <?php echo esc_attr( $site_mobile_header_toggle_button_style ); ?>"><span class="mid-line"></span></div>
                    </div>
                    <?php } ?>

                    <?php if ( auxin_is_true( $add_search ) ) { ?>
                     <!-- search -->
                    <div class="aux-search-box aux-desktop-on aux-end aux-middle">
                        <?php echo auxin_get_search_box( array( 'has_form' => false, 'has_toggle_icon' => true, 'toggle_icon_class' => 'aux-overlay-search' ) );?>
                    </div>
                    <?php } ?>
                    <?php
                        if( auxin_is_true( $add_cart ) ) {
                            auxin_wc_add_to_cart(
                                array(
                                    'css_class' => 'aux-cart-box aux-start aux-fill ' . $device_classes .' aux-cart-type-'.$cart_type,
                                    'dropdown_skin' => $dropdown_skin,
                                    'dropdown_class'=> $dropdown_class,
                                    'action_on'     => $action_on,
                                    'icon'          => $cart_icon,
                                    'simple_mode'   => $simple_mode
                                )
                            );
                        }
                    ?>
                    <?php
                        if( auxin_is_true( $social_display ) ) {
                            auxin_the_socials( array(
                                'css_class' => 'aux-start aux-middle aux-tablet-off aux-phone-off',
                                'size'      => $icon_size,
                                'direction' => 'horizontal'
                            ));
                        }
                    ?>
                </div>

                <div class="bottom-bar secondary-bar aux-phone-off aux-float-wrapper">
                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- menu -->
                    <div class="aux-menu-box <?php echo $submenu_below ? 'aux-middle aux-center-middle' : 'aux-fill aux-center'; ?>">
<?php
    /* The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.*/
    wp_nav_menu( array( 'menu' => $menu, 'container_id' => 'master-menu-main-header', 'theme_location' => 'header-primary' ) );
?>
                    </div>
                    <?php } ?>
                </div>

                <!-- toggle menu bar: this element will be filled in tablet and mobile size -->
                <div class="aux-toggle-menu-bar"></div>
            </div>
            <?php
            break;

        case 'logo-in-middle-menu':

            ?>
            <div class="aux-header aux-header-elements-wrapper aux-float-layout">
                <!-- ribbon bar -->
                <div class="aux-header-elements">

                    <!-- logo -->
                    <div id="logo" class="aux-logo-header aux-center aux-fill">
                        <?php echo $logo_markup; ?>
                    </div>

                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- burger -->
                    <div id="nav-burger" class="aux-burger-box aux-end aux-phone-on aux-middle" data-target-panel="<?php echo esc_attr( $mobile_menu_position ); ?>" data-target-content=".site-header-section .aux-master-menu>
                        <div class="aux-burger <?php echo esc_attr( $site_mobile_header_toggle_button_style ); ?>"><span class="mid-line"></span></div>
                    </div>
                    <!-- menu -->
                    <div class="aux-menu-box aux-phone-off aux-auto-locate aux-center-middle aux-phone-center-middle aux-fill aux-tablet-center" data-tablet=".aux-header .secondary-bar-2">
                    <?php
                        /* The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.*/
                        wp_nav_menu( array( 'menu' => $menu, 'container_id' => 'master-menu-main-header', 'theme_location' => 'header-primary' ) );
                    ?>
                    </div>
                    <?php } ?>
                </div>
                <!-- secondary bar: this element will be filled in tablet size -->
                <div class="bottom-bar secondary-bar secondary-bar-2  aux-tablet-on aux-float-wrapper"></div>

                <!-- toggle menu bar: this element will be filled in tablet and mobile size -->
                <div class="aux-toggle-menu-bar"></div>
            </div>
            <?php
            break;

        case 'logo-left-menu-right-over':

            ?>
            <div class="aux-header aux-header-elements-wrapper aux-float-layout aux-over-content">
                <!-- ribbon bar -->
                <div class="aux-header-elements">

                    <!-- logo -->
                    <div id="logo" class="aux-logo-header aux-start aux-fill aux-tablet-center aux-phone-left">
                        <?php echo $logo_markup; ?>
                    </div>
                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- burger -->
                    <div id="nav-burger" class="aux-burger-box aux-start aux-phone-on aux-middle" data-target-panel="<?php echo esc_attr( $mobile_menu_position ); ?>" data-target-menu="overlay" >
                        <div class="aux-burger <?php echo esc_attr( $site_mobile_header_toggle_button_style ); ?>"><span class="mid-line"></span></div>
                    </div>
                    <?php } ?>
                    <div class="aux-btns-box aux-btn1-box aux-end aux-middle <?php echo esc_attr( $button1_breakpoints );?>">
                        <?php if( function_exists( 'auxin_get_header_button' ) ){ echo auxin_get_header_button( 1 ); } ?>
                    </div>
                    <div class="aux-btns-box aux-btn2-box aux-end aux-middle <?php echo esc_attr( $button2_breakpoints );?>">
                        <?php if( function_exists( 'auxin_get_header_button' ) ){ echo auxin_get_header_button( 2 ); } ?>
                    </div>
                    <?php if ( auxin_is_true( $add_search ) ) { ?>
                    <!-- search -->
                    <div class="aux-search-box aux-desktop-on aux-end aux-middle">
                        <?php echo auxin_get_search_box( array( 'has_form' => false, 'has_toggle_icon' => true, 'toggle_icon_class' => 'aux-overlay-search' ) );?>
                    </div>
                    <?php } ?>
                    <?php
                        if( auxin_is_true( $add_cart ) ) {
                            auxin_wc_add_to_cart(
                                array(
                                    'css_class' => 'aux-cart-box aux-end aux-fill ' . $device_classes .' aux-cart-type-'.$cart_type,
                                    'dropdown_skin' => $dropdown_skin,
                                    'dropdown_class'=> $dropdown_class,
                                    'action_on'     => $action_on,
                                    'icon'          => $cart_icon,
                                    'simple_mode'   => $simple_mode
                                )
                            );
                        }
                    ?>
                    <?php
                        if( auxin_is_true( $social_display ) ) {
                            auxin_the_socials( array(
                                'css_class' => 'aux-end aux-middle aux-tablet-off aux-phone-off',
                                'size'      => $icon_size,
                                'direction' => 'horizontal'
                            ));
                        }
                    ?>
                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- menu -->
                    <div class="aux-menu-box aux-phone-off aux-auto-locate aux-end <?php echo $submenu_below ? 'aux-middle aux-tablet-center-middle' : 'aux-fill aux-tablet-center'; ?>" data-tablet=".aux-header .secondary-bar">
                    <?php
                        /* The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.*/
                        wp_nav_menu( array( 'menu' => $menu, 'container_id' => 'master-menu-main-header', 'theme_location' => 'header-primary' ) );
                    ?>
                    </div>
                    <?php } ?>
                </div>
                <!-- secondary bar: this element will be filled in tablet size -->
                <div class="bottom-bar secondary-bar aux-tablet-on aux-float-wrapper"></div>

                <!-- toggle menu bar: this element will be filled in tablet and mobile size -->
                <div class="aux-toggle-menu-bar"></div>
            </div>
            <?php

            break;

        case 'logo-left-menu-bottom-left':

            ?>
            <div class="aux-header aux-header-elements-wrapper aux-float-layout">
                <!-- ribbon bar -->
                <div class="aux-header-elements">

                    <!-- logo -->
                    <div id="logo" class="aux-logo-header aux-start aux-fill">
                        <?php echo $logo_markup; ?>
                    </div>
                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- burger -->
                    <div id="nav-burger" class="aux-burger-box aux-end aux-phone-on aux-middle" data-target-panel="<?php echo esc_attr( $mobile_menu_position ); ?>" data-target-menu="overlay" data-target-content=".site-header-section .aux-master-menu">
                        <div class="aux-burger <?php echo esc_attr( $site_mobile_header_toggle_button_style ); ?>"><span class="mid-line"></span></div>
                    </div>
                    <?php } ?>
                    <?php if ( auxin_is_true( $add_search ) ) { ?>
                    <!-- search -->
                    <div class="aux-search-box aux-phone-off aux-end aux-middle">
                        <?php echo auxin_get_search_box( array( 'has_form' => false, 'has_toggle_icon' => true, 'toggle_icon_class' => 'aux-overlay-search' ) );?>
                    </div>
                    <?php } ?>
                    <?php
                        if( auxin_is_true( $add_cart ) ) {
                            auxin_wc_add_to_cart(
                                array(
                                    'css_class' => 'aux-cart-box aux-end aux-fill ' . $device_classes .' aux-cart-type-'.$cart_type,
                                    'dropdown_skin' => $dropdown_skin,
                                    'dropdown_class'=> $dropdown_class,
                                    'action_on'     => $action_on,
                                    'icon'          => $cart_icon,
                                    'simple_mode'   => $simple_mode
                                )
                            );
                        }
                    ?>
                    <?php
                        if( auxin_is_true( $social_display ) ) {
                            auxin_the_socials( array(
                                'css_class' => 'aux-end aux-middle aux-tablet-off aux-phone-off',
                                'size'      => $icon_size,
                                'direction' => 'horizontal'
                            ));
                        }
                    ?>
                </div>
                <!-- secondary bar: this element will be filled in tablet size -->
                <div class="bottom-bar secondary-bar aux-float-wrapper aux-sticky-off aux-phone-off">
                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- menu -->
                    <div class="aux-menu-box aux-phone-off aux-auto-locate aux-start <?php echo $submenu_below ? 'aux-middle' : 'aux-fill'; ?>" data-sticky-move="#logo" data-sticky-move-method="after">
                    <?php
                        /* The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.*/
                        wp_nav_menu( array( 'menu' => $menu, 'container_id' => 'master-menu-main-header', 'theme_location' => 'header-primary' ) );
                    ?>
                    </div>
                    <?php } ?>
                </div>

                <!-- toggle menu bar: this element will be filled in tablet and mobile size -->
                <div class="aux-toggle-menu-bar"></div>
            </div>
            <?php

            break;

        // If the post metafields sets to no-header
        case 'no-header':
            echo 'no-header';
            break;

        case 'vertical':

            $bg_color    = auxin_get_post_meta( $post, 'page_vertical_menu_background_color', 'default' );
            $bg_color    = empty( $bg_color ) ? '' : 'style=" background-color:' . esc_attr( $bg_color ) . '" ';

            $items_align = auxin_get_post_meta( $post, 'page_vertical_header_items_align', 'default' );
            $items_align = 'default' === $items_align ? 'aux-vertical-items-' . auxin_get_option('site_vertical_header_items_align', 'left') : 'aux-vertical-items-' . $items_align . ' ';

            $footer_display = auxin_get_post_meta( $post, 'page_vertical_menu_footer_display', 'default' );
            $footer_display = 'default' === $footer_display ? auxin_get_option('site_vertical_menu_footer_display', 'yes') :  $footer_display ;

            $search_border = auxin_get_post_meta( $post, 'page_vertical_header_search_border', 'default' );
            $search_border = 'default' === $search_border ? auxin_get_option('site_vertical_header_search_border', 'yes') :  $search_border ;

            $search_border = auxin_is_true ( $search_border ) ? '' : 'aux-search-no-border ' ;

            ?>
            <!-- burger -->
            <div id="nav-burger" class="aux-burger-box aux-end aux-phone-on aux-middle" data-target-panel="<?php echo esc_attr( $mobile_menu_position ); ?>" data-target-menu="overlay" data-target-content=".aux-vertical-menu-side .aux-master-menu">
                <div class="aux-burger <?php echo esc_attr( $site_mobile_header_toggle_button_style ); ?>"><span class="mid-line"></span></div>
            </div>
            <div class="aux-vertical-menu-side aux-header aux-header-elements-wrapper <?php echo esc_attr( $items_align ) ;?>" <?php echo $bg_color ;?> >
                <!-- ribbon bar -->
                <div class="aux-vertical-menu-elements aux-header-elements ">
                    <!-- logo -->
                    <div id="logo" class="aux-logo-header">
                        <?php echo $logo_markup; ?>
                    </div>
                    <!-- menu -->
                    <div class="aux-menu-box aux-phone-off aux-auto-locate aux-tablet-center'; ?>" data-tablet=".aux-header .secondary-bar-2">
                    <?php
                        if ( 'none' !== $menu ) {
                            /* The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.*/
                            wp_nav_menu( array(
                                'menu' => $menu,
                                'container_id'   => 'master-menu-main-header',
                                'theme_location' => 'header-primary',
                                'direction'      => 'vertical'
                            ));
                        }
                        if( auxin_is_true( $add_cart ) ) {
                            auxin_wc_add_to_cart(
                                array(
                                    'css_class'     => $device_classes,
                                    'title'         => __( 'Shopping Cart', 'phlox-pro' ),
                                    'dropdown_skin' => $dropdown_skin,
                                    'action_on'     => $action_on,
                                    'icon'          => $cart_icon,
                                    'simple_mode'   => $simple_mode
                                )
                            );
                        }
                    ?>

                    </div>
                    <?php if ( auxin_is_true( $footer_display ) ) : ?>
                        <!-- Footer for vertical menu -->
                        <footer class="aux-vertical-menu-footer aux-phone-off">
                            <!-- search -->
                            <div class="aux-search-box aux-phone-off aux-end aux-middle <?php echo esc_attr( $search_border ) ;?> ">
                                <?php echo auxin_get_search_box( array( 'has_form' => true, 'has_toggle_icon' => false, 'has_submit_icon' => true ) );?>
                            </div>
                            <?php
                            if ( auxin_is_true( $social_display ) ) {
                                echo auxin_the_socials( array( 'size' => $icon_size ) );
                            }
                            if ( auxin_is_true( auxin_get_option( 'site_vertical_menu_copyright' ) ) ) : ?>
                                <div class="copyright">
                                    <?php
                                    echo '<div id="copyright" class="aux-copyright">';
                                        if( $copyright_text = auxin_get_option('copyright') ) {
                                            $date_format = 'Y'; // to pass theme check plugin
                                            $copyright_text = str_replace( array( '{{Y}}', '{{sitename}}' ), array( date_i18n( $date_format ), get_bloginfo( 'name' ) ), $copyright_text );
                                            echo '<small>' . do_shortcode( stripslashes( $copyright_text ) ) . '</small>';
                                        }
                                        if ( auxin_get_option( 'attribution', false ) ) {
                                            echo sprintf( '<small class="attribution"> %1$s <a href="https://wordpress.org/themes/phlox/" title="%2$s"> %3$s </a></small>',
                                                __( 'Powered by', 'phlox-pro' ),
                                                __( 'Phlox Free WordPress Theme', 'phlox-pro' ),
                                                __( 'Phlox Theme', 'phlox-pro' )
                                            );
                                        }
                                    echo '</div>';
                                    ?>
                                </div>
                            <?php endif; ?>
                        </footer>
                    <?php endif; ?>
                </div>
            </div>
            <?php
            break;
            case 'logo-left-menu-middle':
                ?>
                    <div class="aux-header aux-header-elements-wrapper aux-float-layout aux-over-content">

                        <!-- ribbon bar -->
                        <div class="aux-header-elements">

                            <!-- logo -->
                            <div id="logo" class="aux-logo-header aux-start aux-fill aux-tablet-center aux-phone-left">
                                <?php echo $logo_markup; ?>
                            </div>
                            <?php if ( 'none' !== $menu ) { ?>
                            <!-- burger -->
                            <div id="nav-burger" class="aux-burger-box aux-end aux-phone-on aux-middle" data-target-panel="<?php echo esc_attr( $mobile_menu_position ); ?>" data-target-content=".site-header-section .aux-master-menu">
                                <div class="aux-burger <?php echo esc_attr( $site_mobile_header_toggle_button_style ); ?>"><span class="mid-line"></span></div>
                            </div>

                            <div class="aux-menu-box aux-phone-off aux-auto-locate aux-center-middle aux-phone-center-middle aux-fill aux-tablet-center" data-tablet=".aux-header .secondary-bar-2">
                                <?php
                                    /* The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.*/
                                    wp_nav_menu( array( 'menu' => $menu, 'container_id' => 'master-menu-main-header', 'theme_location' => 'header-primary' ) );
                                ?>
                            </div>
                            <?php } ?>
                            <!-- button 1 -->
                            <div class="aux-btns-box aux-btn1-box aux-end aux-middle <?php echo esc_attr( $button1_breakpoints );?>">
                                <?php if( function_exists( 'auxin_get_header_button' ) ){ echo auxin_get_header_button( 1 ); } ?>
                            </div>

                            <!-- button 2 -->
                            <div class="aux-btns-box aux-btn2-box aux-end aux-middle <?php echo esc_attr( $button2_breakpoints );?>">
                                <?php if( function_exists( 'auxin_get_header_button' ) ){ echo auxin_get_header_button( 2 ); } ?>
                            </div>

                            <!-- WC Cart -->
                            <?php
                                if( auxin_is_true( $add_cart ) ) {
                                    auxin_wc_add_to_cart(
                                        array(
                                            'css_class' => 'aux-cart-box aux-end aux-fill ' . $device_classes .' aux-cart-type-'.$cart_type,
                                            'dropdown_skin' => $dropdown_skin,
                                            'dropdown_class'=> $dropdown_class,
                                            'action_on'     => $action_on,
                                            'icon'          => $cart_icon,
                                            'simple_mode'   => $simple_mode
                                        )
                                    );
                                }
                            ?>

                            <!-- wishlist -->
                            <?php

                                if ( function_exists('auxin_wc_wishlist') && auxin_is_true( $wishlist ) ) {

                                    auxin_wc_wishlist( array(
                                        'css_class' => 'aux-wishlist-box aux-end aux-middle aux-tablet-off aux-phone-off'
                                    ));

                                }

                            ?>

                            <!-- myaccount -->
                            <?php

                                if ( auxin_is_true( $my_account ) ) {

                                    auxin_wc_my_account( array(
                                        'css_class' => 'aux-myaccount-box aux-end aux-middle aux-tablet-off aux-phone-off'
                                    ));

                                }

                            ?>

                            <!-- search -->
                            <?php if ( auxin_is_true( $add_search ) ) { ?>
                            <div class="aux-search-box aux-desktop-on aux-end aux-middle">
                                <?php echo auxin_get_search_box( array( 'has_form' => false, 'has_toggle_icon' => true, 'toggle_icon_class' => 'aux-overlay-search' ) );?>
                            </div>
                            <?php } ?>

                            <!-- socials -->
                            <?php
                                if ( auxin_is_true( $social_display ) ) {
                                    auxin_the_socials( array(
                                        'css_class' => 'aux-end aux-middle aux-tablet-off aux-phone-off',
                                        'size'      => $icon_size,
                                        'direction' => 'horizontal'
                                    ));
                                }
                            ?>

                        </div>

                        <!-- secondary bar: this element will be filled in tablet size -->
                        <div class="bottom-bar secondary-bar secondary-bar-2  aux-tablet-on aux-float-wrapper"></div>

                        <!-- toggle menu bar: this element will be filled in tablet and mobile size -->
                        <div class="aux-toggle-menu-bar"></div>

                    </div>
                <?php
                break;

            case 'burger-right-msg':

            ?>
            <div class="aux-header aux-header-elements-wrapper aux-float-layout">
                <!-- ribbon bar -->
                <div class="aux-header-elements">

                    <!-- logo -->
                    <div id="logo" class="aux-logo-header aux-start aux-fill aux-tablet-left aux-phone-left">
                        <?php echo $logo_markup; ?>
                    </div>
                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- burger -->
                    <div id="nav-burger" class="aux-burger-box aux-end aux-middle" data-target-panel="<?php echo esc_attr( $mobile_menu_position ); ?>"  data-target-content=".site-header-section .aux-master-menu">
                        <div class="aux-burger <?php echo esc_attr( $site_mobile_header_toggle_button_style ); ?>"><span class="mid-line"></span></div>
                    </div>
                    <?php } ?>
                    <?php if ( auxin_is_true( $add_search ) ) { ?>
                     <!-- search -->
                    <div class="aux-search-box aux-desktop-on aux-end aux-middle">
                        <?php echo auxin_get_search_box( array( 'has_form' => false, 'has_toggle_icon' => true, 'toggle_icon_class' => 'aux-overlay-search' ) );?>
                    </div>
                    <?php } ?>
                    <?php
                        if( auxin_is_true( $add_cart ) ) {
                            auxin_wc_add_to_cart(
                                array(
                                    'css_class' => 'aux-cart-box aux-end aux-fill ' . $device_classes .' aux-cart-type-'.$cart_type,
                                    'dropdown_skin' => $dropdown_skin,
                                    'dropdown_class'=> $dropdown_class,
                                    'action_on'     => $action_on,
                                    'icon'          => $cart_icon,
                                    'simple_mode'   => $simple_mode
                                    )
                                );
                            }
                            ?>
                    <?php
                        if( auxin_is_true( $social_display ) ) {
                            auxin_the_socials( array(
                                'css_class' => 'aux-end aux-middle aux-tablet-off aux-phone-off',
                                'size'      => $icon_size,
                                'direction' => 'horizontal'
                            ));
                        }
                        ?>
                    <span class="aux-header-msg aux-end aux-middle aux-tablet-off aux-phone-off">
                        <?php
                            $message = auxin_get_option('site_header_msg_text');
                            echo do_shortcode( stripslashes( $message ) );
                        ?>
                    </span>
                    <?php if ( 'none' !== $menu ) { ?>
                    <div class="aux-menu-box aux-off aux-auto-locate aux-end aux-fill aux-tablet-center" >
                    <?php
                        /* The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.*/
                        wp_nav_menu( array(
                            'menu' => $menu,
                            'container_id'   => 'master-menu-main-header',
                            'theme_location' => 'header-primary',
                            'mobile_under'   => 7000
                        ));
                    ?>
                    </div>
                    <?php } ?>

                </div>

                <!-- toggle menu bar: this element will be filled in tablet and mobile size -->
                <div class="aux-toggle-menu-bar"></div>

            </div>
            <?php
            break;

        default:

            ?>
            <div class="aux-header aux-header-elements-wrapper aux-float-layout">
                <!-- ribbon bar -->
                <div class="aux-header-elements">

                    <!-- logo -->
                    <div id="logo" class="aux-logo-header aux-start aux-fill aux-tablet-center aux-phone-left">
                        <?php echo $logo_markup; ?>
                    </div>
                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- burger -->
                    <div id="nav-burger" class="aux-burger-box aux-end aux-phone-on aux-middle" data-target-panel="<?php echo esc_attr( $mobile_menu_position ); ?>" data-target-menu="overlay" data-target-content=".site-header-section .aux-master-menu">
                        <div class="aux-burger <?php echo esc_attr( $site_mobile_header_toggle_button_style ); ?>"><span class="mid-line"></span></div>
                    </div>
                    <?php } ?>
                    <?php
                        if( auxin_is_true( $add_cart ) ) {
                            auxin_wc_add_to_cart(
                                array(
                                    'css_class'     => 'aux-cart-box aux-end aux-fill ' . $device_classes .' aux-cart-type-'.$cart_type,
                                    'dropdown_skin' => $dropdown_skin,
                                    'dropdown_class'=> $dropdown_class,
                                    'action_on'     => $action_on,
                                    'icon'          => $cart_icon,
                                    'simple_mode'   => $simple_mode
                                )
                            );
                        }
                    ?>
                    <?php if ( auxin_is_true( $add_search ) ) { ?>
                    <!-- search -->
                    <div class="aux-search-box aux-desktop-on aux-end aux-middle">
                        <?php echo auxin_get_search_box( array( 'has_form' => false, 'has_toggle_icon' => true, 'toggle_icon_class' => 'aux-overlay-search' ) );?>
                    </div>
                    <?php } ?>
                    <div class="aux-btns-box aux-btn1-box aux-end aux-middle <?php echo esc_attr( $button1_breakpoints );?>">
                        <?php if( function_exists( 'auxin_get_header_button' ) ){ echo auxin_get_header_button( 1 ); } ?>
                    </div>
                    <div class="aux-btns-box aux-btn2-box aux-end aux-middle <?php echo esc_attr( $button2_breakpoints );?>">
                        <?php if( function_exists( 'auxin_get_header_button' ) ){ echo auxin_get_header_button( 2 ); } ?>
                    </div>
                    <?php
                        if( auxin_is_true( $social_display ) ) {
                            auxin_the_socials( array(
                                'css_class' => 'aux-end aux-middle aux-tablet-off aux-phone-off',
                                'size'      => $icon_size,
                                'direction' => 'horizontal'
                            ));
                        }
                    ?>
                    <?php if ( 'none' !== $menu ) { ?>
                    <!-- menu -->
                    <div class="aux-menu-box aux-phone-off aux-auto-locate aux-end <?php echo $submenu_below ? 'aux-middle aux-tablet-center-middle' : 'aux-fill aux-tablet-center'; ?>" data-tablet=".aux-header .secondary-bar">
                    <?php
                        /* The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.*/
                        wp_nav_menu( array( 'menu' => $menu, 'container_id' => 'master-menu-main-header', 'theme_location' => 'header-primary' ) );
                    ?>
                    </div>
                    <?php } ?>
                </div>
                <!-- secondary bar: this element will be filled in tablet size -->
                <div class="bottom-bar secondary-bar aux-tablet-on aux-float-wrapper"></div>

                <!-- toggle menu bar: this element will be filled in tablet and mobile size -->
                <div class="aux-toggle-menu-bar"></div>
            </div>
            <?php

            break;
    }

    return ob_get_clean();
}



/**
 * Retrieves the markup for custom logo element
 *
 * @param  array  $args The properties fort this element
 *
 * @return string       The markup for logo element
 */
function auxin_get_custom_logo_block( $args = array() ){
    global $post;

    $defaults = array(
        'css_class'      => '',
        'middle'         => true
    );

    $args = wp_parse_args( $args, $defaults );


    if ( 'default' === $show_logo = auxin_get_post_meta( $post, 'page_header_logo_display', 'default' ) ) {
        $show_logo = auxin_get_option( 'show_header_logo', '1' );
    }

    if( ! auxin_is_true ( $show_logo ) ) {
        return;
    }

    ob_start();
?>
    <div class="aux-logo <?php echo esc_attr( $args['css_class'] ); ?>">
    <?php
        echo auxin_get_custom_logo_image();
        $logo_desc = get_bloginfo( 'description' );
    ?>
        <section class="aux-logo-text <?php echo $args['middle'] ? 'aux-middle' : ''; ?>">
            <h3 class="site-title">
                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
            </h3>
            <?php if( $logo_desc ){ echo '<p class="site-description">' . $logo_desc . '</p>'; } ?>
        </section>

    </div><!-- end logo aux-fold -->

<?php
    return ob_get_clean();
}


/**
 * Retrieves the custom logo image tag
 *
 * @param  string $title The logo title
 * @param  strint $type  Which logo we intent to get. possible values
 *
 * @return string        The markup for logo image
 */
function auxin_get_custom_logo_image(){

    $logo_markup = '';

    // add extra attributes to custom logo image
    add_filter( 'wp_get_attachment_image_attributes', 'auxin_change_custom_logo_attributes', 10, 3 );

    // extra css classes for primary logo
    $primary_logo_classes   = 'aux-logo-anchor1 aux-middle';
    $primary_logo_classes  .= has_custom_logo() ? ' aux-has-logo' : '';

    // extra css classes for secondary logo
    $secondary_logo_classes = 'aux-middle';

    // special css classes for the logo which appears in sticky mode
    $sticky_menu_classes  = ' aux-logo-sticky aux-logo-hidden';

    // make the header logo config filterable - by using this filter you can disable or customize each logo
    $header_logo_config = apply_filters( 'auxin_header_logo_config',
        array(
            'primary_logo_extra_classes'   => $primary_logo_classes,
            'secondary_logo_extra_classes' => $secondary_logo_classes . $sticky_menu_classes,
            'skip_primary_logo'            => false,
            'skip_secondary_logo'          => false
        ),
        $primary_logo_classes,
        $secondary_logo_classes,
        $sticky_menu_classes
    );

    // retrieve markup for primary logo
    if( ! $header_logo_config['skip_primary_logo'] ){
        // get logo markup
        $logo_markup = get_custom_logo();

        // append new class names and inline style to logo anchor
        $logo_markup = str_replace( 'custom-logo-link', 'custom-logo-link aux-logo-anchor ' . esc_attr( $header_logo_config['primary_logo_extra_classes'] ), $logo_markup );
    }

    // end adding extra attributes to custom logo image
    remove_filter( 'wp_get_attachment_image_attributes', 'auxin_change_custom_logo_attributes' );

    // the secondary logo for sticky header
    if( function_exists('auxin_get_custom_logo2') && ! $header_logo_config['skip_secondary_logo'] ){
        $logo_markup .= auxin_get_custom_logo2( 0, array( 'anchor_extra_classes' => esc_attr( $header_logo_config['secondary_logo_extra_classes'] ) ) );
    }

    return $logo_markup;
}

/**
 * Prints the post slider on archive and corresponding pages
 *
 * @return void
 */
if( ! function_exists('auxin_the_archive_slider_section') ){
    function auxin_the_archive_slider_section(){
        echo auxin_get_the_archive_slider( 'post', 'block' );
    }
}


/**
 * Adds top header section
 *
 * @return void
 */
if( ! function_exists('auxin_the_top_header_section') ){

    function auxin_the_top_header_section(){
        global $post;

        $menu_direction = auxin_get_post_meta( $post, 'page_header_navigation_layout', 'default') ;
        $menu_direction = 'default' === $menu_direction ? auxin_get_option( 'site_header_top_layout', 'horizontal-menu-right' ) : $menu_direction;

        // header width option
        if ( 'default' === $site_header_width = auxin_get_post_meta( $post, 'page_header_width' ) ) {
            $site_header_width = auxin_get_option( 'site_header_width' );
        };
        // top header display option
        if ( 'default' === $display_top_header = auxin_get_post_meta( $post, 'aux_show_topheader', 'default' ) ) {
            $display_top_header = auxin_get_option( 'show_topheader' );
        };

        if( 'vertical' !== $menu_direction && ( auxin_is_true( $display_top_header ) || is_customize_preview() ) ) {
            $classes  = "aux-". esc_attr( $site_header_width ) . "-container";
            $classes .= is_customize_preview() ? ' aux-hide' : '';
        ?>
            <div id="top-header" class="aux-top-header aux-territory <?php echo esc_attr( $classes ); ?>">
                <div class="aux-wrapper aux-float-layout">

                    <?php echo auxin_get_top_header_markup(); ?>

                </div><!-- end wrapper -->
            </div><!-- end top header -->
        <?php
        }
    }

}


/**
 * Adds main header section
 *
 * @return void
 */
function auxin_the_main_header_section(){
    global $post;

    if( 'default' === $menu_direction = auxin_get_post_meta( $post, 'page_header_navigation_layout', 'default') ){
        $menu_direction = auxin_get_option( 'site_header_top_layout', 'horizontal-menu-right' );
    }

    // if site_header_top_layout is no-header, dont generate the header
    if ( 'no-header' !== ( $top_header_layout = auxin_get_header_layout() ) ) {
    ?>
    <header id="site-header" <?php auxin_dom_attributes('site_header'); ?> role="banner">
        <div class="aux-wrapper">

    <?php
        if( 'vertical' === $menu_direction ){
            echo $top_header_layout ;
        } else {
    ?>
            <div class="aux-container aux-fold">
                <?php echo $top_header_layout ; ?>
            </div>
        <?php } ?>
        </div><!-- end of wrapper -->
    </header><!-- end header -->
    <?php
    }
}
