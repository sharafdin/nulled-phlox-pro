<?php global $post;

    $post_vars = auxin_get_post_format_media(
        $post,
        array(
            'request_from'       => 'single',
            'image_from_content' => false,
            'media_size'         => auxin_get_option( 'post_single_image_size', '' ),
            'crop'               => auxin_is_true( auxin_get_option( 'post_single_image_keep_aspect_ratio', false ) ) ? false : true,
        )
    );

    extract( $post_vars );

    // Get the alignment of the title in page content
    if( 'default' === $title_alignment = auxin_get_post_meta( $post, 'page_content_title_alignment', 'default' ) ){
        $title_alignment = auxin_get_option( 'post_single_title_alignment' );
    }
    $title_alignment = 'default' === $title_alignment ? '' : 'aux-text-align-' .$title_alignment;


    if( 'default' === $post_content_style = auxin_get_post_meta( $post, 'post_content_style', 'default' ) ){
        $post_content_style = auxin_get_option( 'post_single_content_style' );
    }
    $post_extra_classes = $post_content_style ? 'aux-'. esc_attr( $post_content_style ) .'-context' : '';

    // Whether to display post meta info or not
    if( 'default' === $show_post_meta_info = auxin_get_post_meta( $post, 'aux_post_info_show', true ) ){
        $show_post_meta_info = auxin_get_option( 'show_post_single_meta_info' );
    }
    $show_post_meta_info = auxin_is_true( $show_post_meta_info );

    // Whether the title bar is enabled or not
    if ( 'default' === $show_titlebar = auxin_get_post_meta( $post, 'aux_title_bar_show', "default" ) ) {
        $show_titlebar = auxin_get_option( $post->post_type . '_title_bar_show' );
    }
    // Use H1 for entry title if title bar is disabled
    $entry_title_tag = auxin_is_true( $show_titlebar ) ? 'h2' : 'h1';

?>
                                    <article <?php post_class( $post_extra_classes ); ?> >

                                            <?php if ( $has_attach ) : ?>
                                            <div class="entry-media">
                                                <?php echo $the_media; ?>
                                            </div>
                                            <?php endif; ?>
                                            <div class="entry-main">

                                                <header class="entry-header <?php echo esc_attr( $title_alignment ); ?>">
                                                <?php
                                                    if( 'quote' == $post_format ) {
                                                        echo '<p class="quote-format-excerpt">'. $excerpt .'</p>';
                                                    }

                                                    printf( '<%s class="entry-title %s">', $entry_title_tag, ( $show_title ? '' : ' aux-visually-hide' ) );

                                                        $post_title = !empty( $the_name ) ? esc_html( $the_name ) : get_the_title();

                                                        if( ! empty( $the_link ) ){
                                                            echo '<cite><a href="'.esc_url( $the_link ).'" title="'.esc_attr( $post_title ).'">'.$post_title.'</a></cite>';
                                                        } else {
                                                            echo $post_title;
                                                        }

                                                        if( "link" == $post_format ){ echo '<br/><cite><a href="'.esc_url( $the_link ).'" title="'.esc_attr( $post_title ).'">'.$the_link.'</a></cite>'; }

                                                    printf( '</%s>', $entry_title_tag );
                                                ?>
                                                    <div class="entry-format">
                                                        <div class="post-format"> </div>
                                                    </div>
                                                </header>

                                                <?php
                                                if( $show_post_meta_info || is_customize_preview() ){
                                                ?>
                                                <div class="entry-info <?php echo esc_attr( $title_alignment ); ?>">
                                                    <?php
                                                    if ( auxin_get_option( 'post_meta_date_show', true ) ) {
                                                    ?>
                                                    <div class="entry-date"><time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" ><?php echo get_the_date(); ?></time></div>
                                                    <?php }
                                                    if ( auxin_get_option( 'post_meta_author_show', true ) ) {
                                                    ?>
                                                    <div class="entry-author">
                                                        <span class="meta-sep"><?php esc_html_e("by", 'phlox-pro'); ?></span>
                                                        <span class="author vcard">
                                                            <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', 'phlox-pro'), get_the_author() ) ); ?>" >
                                                                <?php the_author(); ?>
                                                            </a>
                                                        </span>
                                                    </div>
                                                    <?php }
                                                    if ( auxin_get_option( 'post_meta_comments_show', true ) ) {
                                                    ?>
                                                    <div class="entry-comments">
                                                        <span class="meta-sep"><?php esc_html_e("with", 'phlox-pro'); ?></span>
                                                        <span class="meta-comment"><?php comments_number( __('no comment', 'phlox-pro'), __('one comment', 'phlox-pro'), __('% comments', 'phlox-pro') );?></span>
                                                    </div>
                                                    <?php }
                                                    if ( auxin_get_option( 'post_meta_categories_show', true ) ) {
                                                    ?>
                                                    <div class="entry-tax">
                                                        <?php // the_category(' '); we can use this template tag, but customizable way is needed! ?>
                                                        <?php $tax_name = 'category';
                                                              if( ( $cat_terms = wp_get_post_terms( $post->ID, $tax_name ) ) && ! is_wp_error( $cat_terms ) ){
                                                                  foreach( $cat_terms as $term ){
                                                                      echo '<a href="'. get_term_link( $term->slug, $tax_name ) .'" title="'.esc_attr__("View all posts in ", 'phlox-pro'). esc_attr( $term->name ) .'" rel="category" >'. esc_html( $term->name ) .'</a>';
                                                                  }
                                                              }
                                                        ?>
                                                    </div>
                                                    <?php }
                                                        edit_post_link(__("Edit", 'phlox-pro'), '<div class="entry-edit">', '</div>', null, 'aux-post-edit-link');

                                                        if( ( auxin_get_option( 'show_blog_post_like_button', 1 ) && 'top' === auxin_get_option( 'blog_post_like_button_position', 'top' ) ) || is_customize_preview() ){
                                                            if( function_exists('wp_ulike') ){
                                                                add_filter( 'wp_ulike_add_templates_args', 'auxin_change_like_icon', 1, 1);
                                                                wp_ulike( 'get', array( 'style' => 'wpulike-heart', 'button_type' => 'image', 'wrapper_class' => 'aux-wpulike aux-wpulike-single' ) );
                                                                remove_filter( 'wp_ulike_add_templates_args', 'auxin_change_like_icon', 1 );
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                                <?php
                                                }
                                                ?>

                                                <div class="entry-content">
                                                    <?php if( 'quote' == $post_format ) {
                                                        echo $the_attach;
                                                    } else {
                                                        the_content( __( 'Continue reading', 'phlox-pro') );
                                                        // clear the floated elements at the end of content
                                                        echo '<div class="clear"></div>';
                                                        // create pagination for page content
                                                        wp_link_pages( array( 'before' => '<div class="page-links"><span>' . esc_html__( 'Pages:', 'phlox-pro') .'</span>', 'after' => '</div>' ) );
                                                    } ?>
                                                </div>

                                                <?php
                                                $show_share_links = auxin_get_option( 'show_post_single_tags_section', true );
                                                $the_tags         = get_the_tag_list('<span>'. esc_html__("Tags: ", 'phlox-pro'). '</span>', '<i>, </i>', '');

                                                if( $show_share_links ){
                                                ?>
                                                <footer class="entry-meta">
                                                <?php $share_icon = auxin_get_option( 'blog_post_share_button_icon', 'auxicon-share' ) ; ?>
                                                <?php if( $show_share_links && defined( 'AUXELS' ) ){ ?>
                                                        <div class="aux-post-share">
                                                            <div class="aux-tooltip-socials aux-tooltip-dark aux-socials aux-icon-left aux-medium">
                                                                <span class="aux-icon <?php echo esc_attr( $share_icon ); ?>"></span>
                                                                <span class="aux-text"><?php esc_html_e( 'Share', 'phlox-pro' ); ?></span>
                                                            </div>
                                                        </div>
                                                <?php } if( $the_tags ){ ?>
                                                        <div class="entry-tax">
                                                            <?php echo $the_tags; ?>
                                                        </div>
                                                <?php } else { ?>
                                                        <div class="entry-tax"><span><?php esc_html_e("Tags: No tags", 'phlox-pro' ); ?></span></div>
                                                    <?php }
                                                    if ( auxin_get_option( 'show_blog_post_share_button', false ) ) {
                                                        $data_text = ( 'text' === $share_type = auxin_get_option( 'blog_post_share_button_type', 'icon' ) ) ? 'data-text="' . esc_attr__( 'Share', 'phlox-pro' ) . '"' : '';
                                                        $icon_class = ( $share_type == 'text' ) ? 'aux-has-text' : 'aux-icon ' . $share_icon;
                                                    ?>
                                                        <div class="aux-single-post-share">
                                                             <div class="aux-tooltip-socials aux-tooltip-dark aux-socials aux-icon-left aux-medium aux-tooltip-social-no-text" <?php echo $data_text; ?> >
                                                                 <span class="<?php echo esc_attr( $icon_class ); ?>" <?php echo $data_text;?>></span>
                                                             </div>
                                                         </div>
                                                    <?php }
                                                    if ( auxin_get_option( 'show_blog_post_like_button', 1 ) && 'bottom' === auxin_get_option( 'blog_post_like_button_position', 'top' ) ) {
                                                        if ( function_exists( 'wp_ulike' ) ) {
                                                            add_filter( 'wp_ulike_add_templates_args', 'auxin_change_like_icon', 1, 1 );
                                                            wp_ulike( 'get', array( 'style' => 'wpulike-heart', 'button_type' => 'image', 'wrapper_class' => 'aux-wpulike aux-wpulike-single' ) );
                                                            remove_filter( 'wp_ulike_add_templates_args', 'auxin_change_like_icon', 1 );
                                                        }
                                                    }
                                                    ?>

                                                </footer>
                                                <?php } ?>
                                            </div>


                                            <?php // get related posts
                                            if( auxin_is_true( auxin_get_option('show_post_single_next_prev_nav') ) ){

                                                auxin_single_page_navigation( array(
                                                    'prev_text'      => esc_html__( 'Previous Post', 'phlox-pro' ),
                                                    'next_text'      => esc_html__( 'Next Post'    , 'phlox-pro' ),
                                                    'taxonomy'       => 'category',
                                                    'skin'           => esc_attr( auxin_get_option( 'post_single_next_prev_nav_skin' ) ) // minimal, thumb-no-arrow, thumb-arrow, boxed-image
                                                ));

                                            }

                                            if( function_exists( 'rp4wp_children' ) ){
                                                echo '<div class="aux-related-posts-container">' . rp4wp_children( false, false ) . '</div>';
                                            }
                                            ?>


                                            <?php if( auxin_get_option( 'show_blog_author_section', 1 ) ) { ?>
                                            <div class="entry-author-info">
                                                    <div class="author-avatar">
                                                        <?php echo get_avatar( get_the_author_meta("user_email"), 100 ); ?>
                                                    </div><!-- #author-avatar -->
                                                    <div class="author-description">
                                                        <dl>
                                                            <dt>
                                                                <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', 'phlox-pro'), get_the_author() ) ); ?>" >
                                                                    <?php the_author(); ?>
                                                                </a>
                                                            </dt>
                                                            <dd>
                                                            <?php if( get_the_author_meta('skills') ) { ?>
                                                                <span><?php the_author_meta('skills');?></span>
                                                            <?php }
                                                            if( auxin_get_option( 'show_blog_author_section_text' ) && ( get_the_author_meta('user_description') ) ) {
                                                                ?>
                                                                <p><?php the_author_meta('user_description');?>.</p>
                                                                <?php } ?>
                                                            </dd>
                                                        </dl>
                                                        <?php if( auxin_get_option( 'show_blog_author_section_social' ) ) {
                                                            auxin_the_socials( array(
                                                                'css_class' => ' aux-author-socials',
                                                                'size'      => 'medium',
                                                                'direction' => 'horizontal',
                                                                'social_list'   => array(
                                                                    'facebook'   => get_the_author_meta('facebook'),
                                                                    'twitter'    => get_the_author_meta('twitter'),
                                                                    'googleplus' => get_the_author_meta('googleplus'),
                                                                    'flickr'     => get_the_author_meta('flickr'),
                                                                    'dribbble'   => get_the_author_meta('dribbble'),
                                                                    'delicious'  => get_the_author_meta('delicious'),
                                                                    'pinterest'  => get_the_author_meta('pinterest'),
                                                                    'github'     => get_the_author_meta('github')
                                                                ),
                                                                'social_list_type'   => 'site',
                                                                'fill_social_values' => false
                                                            ));
                                                        }
                                                        ?>
                                                    </div><!-- #author-description -->

                                            </div> <!-- #entry-author-info -->
                                            <?php } ?>

                                       </article>
