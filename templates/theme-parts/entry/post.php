<?php global $post, $more, $aux_content_width; $more = 0; // to enable read more tag

    $show_post_info = $show_post_date = $show_post_author = $show_post_categories = false;

    if ( auxin_is_blog() ) {
        $show_post_info       = auxin_get_option( 'display_post_info', true );
        $show_post_date       = auxin_get_option( 'display_post_info_date', true );
        $show_post_author     = auxin_get_option( 'display_post_info_author', true );
        $show_post_categories = auxin_get_option( 'display_post_info_categories', true );
        $display_comments     = auxin_get_option( 'display_post_info_comments', true );
    } elseif ( is_tag() || is_category() || is_author() ) {
        $show_post_info       = auxin_get_option( 'display_post_taxonomy_info', true );
        $show_post_date       = auxin_get_option( 'display_post_taxonomy_info_date', true );
        $show_post_author     = auxin_get_option( 'display_post_taxonomy_info_author', true );
        $show_post_categories = auxin_get_option( 'display_post_taxonomy_info_categories', true );
        $display_comments     = auxin_get_option( 'display_post_taxonomy_info_comments', true );
    }



    $post_vars   = auxin_get_post_format_media( $post, array(
        'request_from' => 'archive',
        'crop'         => true, // 'true' hard crop, 'false' soft crop, array the crop focus point
        'mask_image'   => auxin_get_option( 'blog_archive_mask_featured_image', true ), // whether to mask the vertical images or not
        'image_sizes'  => array(
            array( 'min' => '',      'max' => '1025px', 'width' => '80vw' ),
            array( 'min' => ''     , 'max' => '',      'width' => round( $aux_content_width ).'px' )
        ),
        'srcset_sizes'  => array(
            array( 'width' =>     500 , 'height' => 'auto' ),
            array( 'width' =>     $aux_content_width, 'height' => 'auto' ),
            array( 'width' => 2 * $aux_content_width, 'height' => 'auto' )
        )
    ) );
    extract( $post_vars );
?>
                        <article <?php post_class(); ?> >
                            <?php if ( $has_attach ) : ?>
                            <div class="entry-media">

                                <?php echo $the_media; ?>

                            </div>
                            <?php endif; ?>

                            <div class="entry-main">

                                <header class="entry-header">
                                <?php
                                if( auxin_is_true( $show_title ) ) {
                                    if( 'quote' == $post_format ) { echo '<p class="quote-format-excerpt">'. $excerpt .'</p>'; } ?>

                                    <h3 class="entry-title">
                                        <a href="<?php echo !empty( $the_link ) ? esc_url( $the_link ) : esc_url( get_permalink() ); ?>">
                                            <?php echo !empty( $the_name ) ? $the_name : get_the_title(); ?>
                                        </a>
                                    </h3>
                                <?php
                                } ?>
                                    <div class="entry-format">
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="post-format format-<?php echo esc_attr( $post_format ); ?>"> </div>
                                        </a>
                                    </div>
                                </header>

                                <?php if( 'quote' !== $post_format ) { ?>
                                <?php if ( auxin_is_true( $show_post_info ) ) : ?>
                                <div class="entry-info">
                                    <?php if ( auxin_is_true( $show_post_date ) ) : ?>
                                    <div class="entry-date">
                                        <a href="<?php the_permalink(); ?>">
                                            <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" title="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" ><?php echo get_the_date(); ?></time>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                    <?php if ( auxin_is_true( $show_post_author ) ) : ?>
                                    <span class="entry-meta-sep meta-sep meta-author"><?php esc_html_e("by", 'phlox-pro'); ?></span>
                                    <span class="author vcard meta-author">
                                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', 'phlox-pro'), get_the_author() ) ); ?>" >
                                            <?php the_author(); ?>
                                        </a>
                                    </span>
                                    <?php endif; ?>
                                    <?php if( comments_open() && auxin_is_true( $display_comments ) ){ /* just display comments number if the comments is not closed. */?>
                                    <span class="meta-sep"><?php esc_html_e("with", 'phlox-pro'); ?></span>
                                    <a href="<?php the_permalink(); ?>#comments" class="meta-comment" ><?php comments_number( __('No Comment', 'phlox-pro'), __('One Comment', 'phlox-pro'), __('% Comments', 'phlox-pro') );?></a>
                                    <?php } ?>
                                    <?php if ( auxin_is_true( $show_post_categories ) ) : ?>
                                    <span class="entry-tax">
                                        <?php // the_category(' '); we can use this template tag, but customizable way is needed! ?>
                                        <?php $tax_name = 'category';
                                              if( $cat_terms = wp_get_post_terms( $post->ID, $tax_name ) ){
                                                  foreach( $cat_terms as $term ){
                                                      echo '<a href="'. esc_url( get_term_link( $term->slug, $tax_name ) ) .'" title="'.esc_attr__("View all posts in ", 'phlox-pro'). esc_attr( $term->name ) .'" rel="category" >'. esc_html( $term->name ) .'</a>';
                                                  }
                                              }
                                        ?>
                                    </span>
                                    <?php endif; ?>
                                    <?php edit_post_link( esc_html__("Edit", 'phlox-pro'), '<i> | </i>', ''); ?>
                                </div>
                                <?php endif; ?>
                                <?php } ?>

                                <?php if( 'quote' !== $post_format ) {
                                    $content_listing_type   = is_category() || is_tag() || is_author() ? auxin_get_option( 'post_taxonomy_archive_content_on_listing' ) : auxin_get_option( 'blog_content_on_listing' );
                                    $content_listing_length = is_category() || is_tag() || is_author() ? auxin_get_option( 'post_taxonomy_archive_on_listing_length', 255 ) :
                                                            auxin_get_option( 'blog_content_on_listing_length', 255 );

                                if ( $content_listing_type !== 'none') {
                                ?>
                                    <div class="entry-content">
                                        <?php
                                        if( 'link' == $post_format ) {
                                            echo '<a href="'. esc_url( $the_link ) .'" class="link-format-excerpt">' . $the_link . '</a>';

                                        } else {

                                            if( has_excerpt() ){
                                                the_excerpt();
                                            } elseif( $content_listing_type == 'full' ) {
                                                the_content( __( 'Continue Reading', 'phlox-pro' ) );
                                            } elseif( $content_listing_type == 'excerpt') {
                                                auxin_the_trim_excerpt( null, $content_listing_length, null, false, 'p' );
                                            }


                                            // clear the floated elements at the end of content
                                            echo '<div class="clear"></div>';

                                            // create pagination for page content
                                            wp_link_pages( array( 'before' => '<div class="page-links"><span>' . esc_html__( 'Pages:', 'phlox-pro') .'</span>', 'after' => '</div>' ) );
                                        }
                                        ?>
                                    </div>
                                <?php }
                                }
                                ?>

                                <footer class="entry-meta">
                                    <div class="readmore">
                                        <a href="<?php the_permalink(); ?>" class="aux-read-more aux-outline aux-large"><span class="aux-read-more-text"><?php echo esc_html( auxin_get_option( 'post_index_read_more_text' ) ); ?></span></a>
                                    </div>
                                </footer>

                            </div>

                        </article>
