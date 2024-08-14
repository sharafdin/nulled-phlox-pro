<?php
        while ( have_posts() ) : the_post();

            get_template_part('templates/theme-parts/entry/single','attachment' );

        endwhile; // end of the loop.
?>
