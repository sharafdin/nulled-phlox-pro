                                    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> >

                                        <?php $attach =  wp_get_attachment_image_src(get_the_ID(), "full"); ?>
                                        <div class="entry-media">
                                            <a href="<?php echo esc_url( $attach[0] ); ?>">
                                                <?php echo wp_get_attachment_image(get_the_ID(), "full", false, array( 'title' => get_the_excerpt() )); ?>
                                            </a>
                                        </div>

                                        <div class="entry-main">
                                            <div class="entry-content">
                                                <?php echo get_the_content(); ?>
                                            </div>
                                        </div>
                                    </article>
