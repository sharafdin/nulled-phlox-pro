<?php
    ob_start();
    the_content();
    $page_content = ob_get_clean();

    if( ! empty( $page_content ) ) {
?>
                                    <article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?> role="article" >
                                        <?php 
                                        if ( has_post_thumbnail() ) {
                                            echo '<section class="entry-media">';
                                                the_post_thumbnail( 'full' );
                                            echo '</secion>';
                                        }
                                        ?>
                                        <section class="entry-content clearfix">
                                            <?php echo $page_content; unset( $page_content ); ?>
                                        </section> <!-- end article section -->

                                    </article> <!-- end article -->
<?php } ?>
