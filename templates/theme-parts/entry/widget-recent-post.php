        <article class="media-land">
            <?php  if( $show_media == true && $entry_media = auxin_get_the_post_thumbnail( null, 160, 160, true ) ) { ?>

            <div class="entry-media">
                <div class="aux-media-frame aux-media-image">
                    <a href="<?php the_permalink(); ?>">
                        <?php echo $entry_media; ?>
                    </a>
                </div>
            </div>
            <?php } if( $show_format ) { ?>
            <div class="entry-format">
                <a href="<?php the_permalink(); ?>" class="post-format format-<?php echo esc_attr( get_post_format() ); ?>"></a>
            </div>
            <?php } ?>
            <div class="entry-info">
                <header class="entry-header">
                    <h4 class="entry-title"><a href="<?php the_permalink(); ?>"><?php echo auxin_get_trimmed_string( get_the_title(), 40, "..." ); ?></a></h4>
                </header>

                <div class="entry-content">
                    <?php if($show_date != false ) { ?>
                    <time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" title="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>" ><?php echo get_the_date(); ?></time>
                    <?php } if( $show_excerpt != false ) { ?>
                    <p><?php auxin_the_trim_excerpt( null, (int) $excerpt_len, null, true ); ?></p>
                    <?php } ?>
                </div>
            </div>
        </article>
