<?php
// if no refult found for archive pages
?>
                    <article class="post no-results not-found" >

                        <div class="entry-main">

                            <div class="entry-content">

                                <h3 class="entry-title"><?php esc_html_e( 'Nothing Found', 'phlox-pro' ); ?></h3>
                                <p class="message404" ><?php esc_html_e( 'Sorry, no results were found. Perhaps searching will help to find what you are looking for.', 'phlox-pro' ); ?></p>
                            </div>

                            <?php echo auxin_get_search_box ( array( 'has_form' => true, 'css_class' => 'aux-404-search', 'has_submit_icon' => true) ); ?>

                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="aux-back-to-home"> <span class="aux-simple-arrow-left-symbol"></span><?php esc_html_e( 'Bring me back home', 'phlox-pro' ); ?> </a>

                        </div>

                   </article>
