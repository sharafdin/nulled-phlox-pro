<?php $is_pass_protected = post_password_required(); ?>

                <?php if ( ! $is_pass_protected ) : ?>

                        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                            <div class="entry-main">

                                <div class="entry-content">

                                    <?php the_content();

                                    // clear the floated elements at the end of content
                                    echo '<div class="clear"></div>';

                                    // create pagination for page content
                                    wp_link_pages( array( 'before' => '<div class="page-links"><span>' . esc_html__( 'Pages:', 'phlox-pro') .'</span>', 'after' => '</div>' ) );
                                    ?>

                                </div> <!-- end article section -->

                                <footer class="entry-meta">
                                    <?php the_tags('<p class="tags"><span class="tags-title">' . esc_html__("Tags", 'phlox-pro') . ':</span> ', ', ', '</p>'); ?>
                                </footer> <!-- end article footer -->

                            </div>

                        </article> <!-- end article -->


                        <?php endwhile; ?>

                        <div class="clear"></div>

                        <?php else : ?>

                        <article id="post-not-found">
                            <header>
                                <h1><?php esc_html_e("Not Found", 'phlox-pro'); ?></h1>
                            </header>

                            <section class="entry-content">
                                <p><?php esc_html_e("Sorry, but the requested resource was not found on this site.", 'phlox-pro'); ?></p>
                            </section>

                            <footer>
                            </footer>
                        </article>

                        <?php endif; ?>

                        <div class="clear"></div>

                        <?php comments_template(); ?>

                <?php else : ?>

                    <?php echo get_the_password_form(); ?>

                <?php endif; ?>
