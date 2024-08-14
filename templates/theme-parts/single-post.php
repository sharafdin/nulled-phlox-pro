<?php
        while ( have_posts() ) : the_post();

        locate_template('templates/theme-parts/entry/single-post.php', true );

        endwhile; // end of the loop.
?>
