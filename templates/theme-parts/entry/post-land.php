<?php
    global $post, $more; $more = 0; // to enable read more tag

    $post_classes = ( ! empty($post_classes) )? $post_classes . ' column-entry' :  'column-entry';
    $no_media = ( ! ( $has_attach && auxin_is_true( $show_media ) ) )? ' no-media' :  '';

    $post_vars   = auxin_get_post_format_media( $post, array( 'request_from' => 'archive' ) );
    extract( $post_vars );
?>
                        <article <?php post_class( $post_classes . $no_media ); ?> >
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
                                        <a href="<?php echo !empty( $the_link ) ? esc_attr( $the_link ) : esc_url( get_permalink() ); ?>">
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

                               <?php if( 'quote' !== $post_format && auxin_is_true(  $show_info ) ) { ?>
                                <div class="entry-info">
                                <?php
                                if( auxin_is_true( $show_date ) ) {  ?>
                                    <div class="entry-date">
                                        <a href="<?php the_permalink(); ?>">
                                            <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" title="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" ><?php echo get_the_date(); ?></time>
                                        </a>
                                    </div>
                                <?php
                                } if( auxin_is_true( $display_categories ) ) { ?>
                                    <span class="entry-tax">
                                        <?php // the_category(' '); we can use this template tag, but customizable way is needed! ?>
                                        <?php $tax_name = 'category';
                                              if( $cat_terms = wp_get_post_terms( $post->ID, $tax_name ) ){
                                                  foreach( $cat_terms as $term ){
                                                      echo '<a href="'. get_term_link( $term->slug, $tax_name ) .'" title="'.esc_attr__("View all posts in ", 'phlox-pro'). esc_attr( $term->name ) .'" rel="category" >'. esc_html( $term->name ) .'</a>';
                                                  }
                                              }
                                        ?>
                                    </span>
                                    <?php edit_post_link(__("Edit", 'phlox-pro'), '<i> | </i>', ''); ?>
                                </div>
                                <?php }
                                } if( 'quote' !== $post_format && auxin_is_true( $show_excerpt ) ) {  ?>
                                <div class="entry-content">
                                    <?php
                                    if( 'link' == $post_format ) {
                                        echo '<a href="'. esc_url( $the_link ) .'" class="link-format-excerpt">' . $the_link . '</a>';

                                    } else {
                                        $content_listing_type   = is_category() || is_tag() || is_author() ? auxin_get_option( 'post_taxonomy_archive_content_on_listing' ) : auxin_get_option( 'blog_content_on_listing' );
                                        $content_listing_length = is_category() || is_tag() || is_author() ? auxin_get_option( 'post_taxonomy_archive_on_listing_length', 255 ) : auxin_get_option( 'excerpt_len', 255 );

                                        if( has_excerpt() ){
                                            the_excerpt();
                                        } elseif( $content_listing_type == 'full' ) {
                                            the_content( __( 'Continue Reading', 'phlox-pro' ) );
                                        } else {
                                            auxin_the_trim_excerpt( null, $content_listing_length, null, false, 'p' );
                                        }


                                        // clear the floated elements at the end of content
                                        echo '<div class="clear"></div>';

                                        // create pagination for page content
                                        wp_link_pages( array( 'before' => '<div class="page-links"><span>' . esc_html__( 'Pages:', 'phlox-pro') .'</span>', 'after' => '</div>' ) );
                                    }
                                    ?>
                                </div>
                                <?php } ?>

                                <footer class="entry-meta">
                                    <div class="readmore">
                                        <a href="<?php the_permalink(); ?>" class="aux-read-more aux-outline aux-large"><span class="aux-read-more-text"><?php echo esc_html( auxin_get_option( 'post_index_read_more_text' ) ); ?></span></a>
                                    </div>
                                </footer>

                            </div>

                        </article>
