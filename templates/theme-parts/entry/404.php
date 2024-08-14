                        <article class="post error404 not-found" >

                            <div class="entry-main">

                                <div class="entry-content">
                                    <h2>404</h2>
                                    <div class="aux-404-icon"></div>
                                    <h3 class="entry-title"><?php esc_html_e( 'Oops! Page Not Found', 'phlox-pro' ); ?></h3>
                                    <p class="message404" ><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'phlox-pro' ); ?></p>
                                </div>

                                <?php echo auxin_get_search_box ( array( 'has_form' => true, 'css_class' => 'aux-404-search', 'has_submit_icon' => true) ); ?>

                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="aux-back-to-home"> <span class="aux-simple-arrow-left-symbol"></span> <?php esc_html_e( 'Bring me back home', 'phlox-pro' ); ?> </a>

                            </div>

                       </article>
