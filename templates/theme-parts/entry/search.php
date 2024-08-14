<?php /* Finds and displays search results. */?>

                        <?php while ( have_posts() ) : the_post(); ?>

                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> role="article" >

                            <?php
                                global $post;

                                if ( has_post_thumbnail() ) {
                                    $size  = auxin_get_image_size('side');
                                    $the_attach = auxin_get_the_post_thumbnail( $post->ID, $size[0], $size[1], true );

                            ?>
                            <div class="entry-media">
                                <div class="aux-media-frame aux-media-image">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php echo $the_attach; ?>
                                    </a>
                                </div>
                            </div>
                            <?php } ?>

                            <div class="entry-main">

                                <div class="entry-header">
                                    <h3 class="entry-title"><a href="<?php the_permalink();?>"><?php the_title();?></a></h3>
                                </div>

                                <div class="entry-content">
                                    <?php the_excerpt(); ?>
                                </div>

                                <div class="entry-info">
                                    <div class="entry-date">
                                        <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" title="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" ><?php echo get_the_date(); ?></time>
                                    </div>
                                        <?php // the_category(' '); we can use this template tag, but customizable way is needed!
                                            $tax_name = 'category';
                                            if( $cat_terms = wp_get_post_terms( $post->ID, $tax_name ) ){
                                        ?>
                                            <span class="entry-tax">
                                        <?php
                                        foreach( $cat_terms as $term ){
                                            echo '<a href="'. get_term_link( $term->slug, $tax_name ) .'" title="'.esc_attr__("View all posts in ", 'phlox-pro'). esc_attr( $term->name ) .'" rel="category" >'. esc_html( $term->name ) .'</a>';
                                        }
                                        ?>
                                            </span>
                                        <?php
                                            }
                                        ?>
                                </div>

                            </div><!-- end entry-main -->

                        </article> <!-- end article -->


                        <?php endwhile; ?>
