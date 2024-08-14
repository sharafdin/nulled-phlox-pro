
                        <article <?php post_class( $post_classes ); ?>>
                            <?php if ( $has_attach && $show_media ) { ?>
                            <div class="entry-media"><?php echo $the_media; ?></div>
                            <?php } ?>

                            <div class="entry-main">
                            <?php
                                $taxonomy_name    = ! isset( $taxonomy_name    ) ? 'category' : $taxonomy_name;
                                $max_taxonomy_num = empty( $max_taxonomy_num ) ? 3 : $max_taxonomy_num;
                                $cat_terms        = wp_get_post_terms( $post->ID, $taxonomy_name );
                                $featured_color   = get_post_meta( $post->ID, 'auxin_featured_color_enabled', true ) ? get_post_meta( $post->ID, 'auxin_featured_color', true ) : auxin_get_option( 'post_single_featured_color' );
                            ?>
                            <?php ob_start(); ?>

                                <header class="entry-header">
                                <?php
                                if( auxin_is_true(  $display_title ) || 'quote' == $post_format) {
                                    if( 'quote' == $post_format ) { echo '<p class="quote-format-excerpt">'. $excerpt .'</p>'; } ?>

                                    <h4 class="entry-title">
                                        <a href="<?php echo !empty( $the_link ) ? esc_url( $the_link ) : esc_url( get_permalink() ); ?>">
                                            <?php
                                                $the_name = ! empty( $the_name ) ? $the_name : get_the_title();
                                                echo empty( $words_num ) ? $the_name : wp_trim_words( $the_name, $words_num );
                                            ?>
                                        </a>
                                    </h4>
                                <?php
                                } ?>
                                    <div class="entry-format">
                                        <a href="<?php the_permalink(); ?>">
                                            <div class="post-format format-<?php echo esc_attr( $post_format ); ?>"> </div>
                                        </a>
                                    </div>
                                </header>
                            <?php
                            $entry_header = ob_get_clean();

                            if ( empty( $post_info_position ) ) {
                                $post_info_position = 'after-title';
                            }

                            // print entry-header before entry-info if post info position was set to 'before-title'
                            echo 'after-title' == $post_info_position ? $entry_header : '';

                            if( 'quote' !== $post_format && auxin_is_true( $show_info ) ) {
                                $show_date = ! isset( $show_date ) ? true : $show_date;
                            ?>
                                <?php if ( ! empty( $cat_terms ) && isset( $show_badge ) && auxin_is_true( $show_badge ) ) { ?>
                                    <span class="entry-badge aux-featured-color" data-featured-color="<?php echo !empty( $featured_color ) ? esc_html( $featured_color ) : ''; ?>">
                                        <a href="<?php the_permalink(); ?>"><?php echo esc_html( $cat_terms[0]->name ); ?></a>
                                    </span>
                                <?php } ?>

                                <div class="entry-info">
                                <?php if( auxin_is_true( $show_date ) ){ ?>
                                    <div class="entry-date">
                                        <a href="<?php the_permalink(); ?>">
                                            <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" title="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" ><?php echo get_the_date(); ?></time>
                                        </a>
                                    </div>
                                <?php } ?>
                                <?php if ( isset( $display_author_header ) && auxin_is_true( $display_author_header ) ) { ?>
                                    <span class="entry-meta-sep meta-sep"><?php esc_html_e("by", 'phlox-pro'); ?></span>
                                    <span class="author vcard">
                                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', 'phlox-pro'), get_the_author() ) ); ?>" >
                                            <?php the_author(); ?>
                                        </a>
                                    </span>
                                <?php } ?>
                                <?php if ( auxin_is_true(  $display_categories ) ) {
                                    $tax_class_name = ! auxin_is_true( $show_date ) ? 'aux-no-sep' : '';
                                ?>
                                    <span class="entry-tax <?php echo esc_attr( $tax_class_name ); ?>">
                                        <?php
                                            if( $cat_terms ){

                                                foreach( $cat_terms as $index => $term ){
                                                    if( $index + 1 > $max_taxonomy_num ){
                                                       break;
                                                    }
                                                    if ( !is_wp_error( get_term_link( $term->slug, $taxonomy_name ) ) ) {
                                                        echo '<a href="'. get_term_link( $term->slug, $taxonomy_name ) .'" title="'.esc_attr__("View all posts in ", 'phlox-pro'). esc_attr( $term->name ) .'" rel="category" >'. esc_html( $term->name ) .'</a>';
                                                    }
                                                }
                                            }
                                        ?>
                                    </span>
                                    <?php } ?>
                                    <?php edit_post_link(__("Edit", 'phlox-pro'), '<i> | </i>', ''); ?>
                                    <?php if( 'video' === $post_format && ( isset( $show_format_icon ) && auxin_is_true( $show_format_icon ) )  ) { ?>
                                    <span class="entry-post-format aux-lightbox-video">
                                        <?php
                                            $get_video_url = get_post_meta( $post->ID, '_format_video_embed', true );
                                            if( ! empty( $get_video_url ) ){
                                                echo sprintf( '<a href="%s" class="aux-open-video aux-post-format-icon" data-type="video"><i class="auxicon-play-1" aria-hidden="true"></i></a>', $get_video_url);
                                            } else {
                                                echo '<span class="aux-post-format-icon"><i class="auxicon-play-1" aria-hidden="true"></i></span>';
                                            }
                                        ?>
                                    </span>
                                    <?php } ?>
                                </div>
                            <?php }
                            // print entry-header after entry-info if post info position was set to 'before-title'
                            echo 'before-title' == $post_info_position ? $entry_header : '';

                            ob_start();?>
                            <?php if( 'none' !== $author_or_readmore ) {?>
                                <footer class="entry-meta aux-<?php echo isset( $meta_info_position ) ? esc_attr( $meta_info_position ) : 'after-content'; ?>">
                                    <?php if( 'readmore' === $author_or_readmore ) {?>
                                    <div class="readmore">
                                        <a href="<?php the_permalink(); ?>" class="aux-read-more"><span class="aux-read-more-text"><?php echo esc_html( auxin_get_option( 'post_index_read_more_text' ) ); ?></span></a>
                                    </div>
                                    <?php
                                    } elseif ( 'author' === $author_or_readmore && 'quote' !== $post_format && 'link' !== $post_format && isset( $display_author_footer ) && auxin_is_true( $display_author_footer ) ) { ?>
                                    <div class="author vcard">
                                        <?php echo get_avatar( get_the_author_meta("user_email"), 32 ); ?>
                                        <span class="meta-sep"><?php esc_html_e("by", 'phlox-pro'); ?></span>
                                        <a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" rel="author" title="<?php echo esc_attr( sprintf( __( 'View all posts by %s', 'phlox-pro'), get_the_author() ) ); ?>" >
                                            <?php the_author(); ?>
                                        </a>
                                    </div>
                                    <?php }

                                    if ( 'quote' !== $post_format && 'link' !== $post_format && $show_comments && comments_open() ) {
                                    ?>
                                    <div class="comments-iconic">
                                        <?php
                                            if( auxin_is_true(  $display_like ) ){
                                                if(function_exists('wp_ulike')) wp_ulike( 'get', array( 'style' => 'wpulike-heart', 'button_type' => 'image', 'wrapper_class' => 'aux-wpulike  aux-wpulike-widget' ) );
                                            }

                                            if( isset( $display_comments ) && auxin_is_true(  $display_comments ) ){
                                        ?>
                                            <a href="<?php the_permalink(); ?>#comments" class="meta-comment" >
                                                <span class="auxicon-comment"></span><span class="comments-number"><?php echo get_comments_number(); ?></span>
                                            </a>
                                        <?php
                                            }
                                        ?>
                                    </div>
                                    <?php
                                    } elseif( auxin_is_true( $display_like ) && (function_exists('wp_ulike') ) ){ ?>
                                    <div class="comments-iconic">
                                        <?php wp_ulike( 'get' , array( 'style' => 'wpulike-heart', 'button_type' => 'image', 'wrapper_class' => 'aux-wpulike aux-wpulike-widget' ) ); ?>
                                    </div>
                                    <?php } ?>
                                </footer>
                            <?php }
                            $entry_meta = ob_get_clean();

                            if( isset( $meta_info_position ) && 'before-content' == $meta_info_position ){
                                echo str_replace( 'footer', 'div', $entry_meta );
                            }
                            ?>

                            <?php if( ( 'quote' !== $post_format && auxin_is_true( $show_excerpt ) ) && auxin_is_true( $show_content ) ) { ?>
                                <div class="entry-content">
                                    <?php
                                    if( 'link' == $post_format ) {
                                        echo '<a href="'. esc_url( $the_link ) .'" class="link-format-excerpt">' . $the_link . '</a>';

                                    } elseif ( has_excerpt() ) { ?>
                                        <p><?php the_excerpt() ;?></p><?php
                                    } else { ?>
                                        <p><?php auxin_the_trim_excerpt( null, (int) $excerpt_len, null, true ); ?></p><?php

                                        // clear the floated elements at the end of content
                                        echo '<div class="clear"></div>';
                                    }
                                    ?>
                                </div>
                            <?php }
                            if( ! isset( $meta_info_position ) || 'after-content' == $meta_info_position ){
                                echo $entry_meta;
                            }
                            ?>

                            </div>

                        </article>
