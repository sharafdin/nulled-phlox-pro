                        <?php $post_classes = ( ! empty($post_classes) )? $post_classes :  ''; ?>
                        <?php $no_media = ( ! ( $has_attach ) )? ' no-media' :  '' ?>

                        <article <?php post_class( $post_classes . $no_media ); ?> >
                            <?php if ( $has_attach ) : ?>

                            <div class="entry-media">
                                <?php echo $the_media; ?>
                            </div>
                            <?php endif; ?>

                            <div class="entry-main">

                                <?php if( auxin_is_true( $display_title ) ) {  ?>
                                <header class="entry-header">
                                    <h4 class="entry-title">
                                        <a href="<?php echo !empty( $the_link ) ? esc_url( $the_link ) : esc_url( get_permalink() ); ?>">
                                            <?php echo !empty( $the_name ) ? $the_name : get_the_title(); ?>
                                        </a>
                                    </h4>
                                </header>
                                <?php } ?>

                                <?php if( auxin_is_true(  $show_info ) ) { ?>
                                <div class="entry-info">
                                    <?php if( auxin_is_true( $show_date ) ) { ?>
                                    <div class="entry-date">
                                        <a href="<?php the_permalink(); ?>">
                                            <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" title="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" ><?php echo get_the_date(); ?></time>
                                        </a>
                                    </div>
                                    <?php } if ( auxin_is_true(  $display_categories ) ) { ?>
                                    <span class="entry-tax">
                                        <?php // the_category(' '); we can use this template tag, but customizable way is needed! ?>
                                        <?php $tax_name = empty( $tax_name ) ? 'category' : $tax_name;
                                              if( $cat_terms = wp_get_post_terms( $post->ID, $tax_name ) ){
                                                  foreach( $cat_terms as $term ){
                                                      echo '<a href="'. esc_url( get_term_link( $term->slug, $tax_name ) ) .'" title="'.esc_attr__("View all posts in ", 'phlox-pro'). esc_attr( $term->name ) .'" rel="category" >'. esc_html( $term->name ) .'</a>';
                                                  }
                                              }
                                        ?>
                                    </span>
                                    <?php } edit_post_link( esc_html__("Edit", 'phlox-pro'), '<i> | </i>', ''); ?>
                                </div>
                                <?php } ?>

                            </div>

                        </article>
