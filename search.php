<?php
/**
 * The template for displaying Search Results pages.
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/
get_header(); ?>

    <main id="main" <?php auxin_content_main_class( 'search-result' ); ?> >
        <div class="aux-wrapper">
            <div class="aux-container aux-fold">

                <div id="primary" class="aux-primary" >
                    <div class="content" role="main" data-target="index" >


                        <?php get_template_part('templates/theme-parts/loop', "search" ); ?>


                    </div><!-- end content -->
                </div><!-- end primary -->


                <?php get_sidebar(); ?>


            </div><!-- end container -->
        </div><!-- end wrapper -->
    </main><!-- end main -->

<?php get_sidebar("footer"); ?>
<?php get_footer(); ?>
