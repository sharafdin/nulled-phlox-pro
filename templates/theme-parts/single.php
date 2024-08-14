<?php
                while ( have_posts() ) : the_post();

                    get_template_part('templates/theme-parts/entry/single', 'general' );

                endwhile; // end of the loop.
?>
