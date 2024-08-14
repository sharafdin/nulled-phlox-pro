<?php
/**
 * The template for displaying taxonomies
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/
get_header(); ?>

    <main id="main" <?php auxin_content_main_class(); ?> >
        <div class="aux-wrapper">
            <div class="aux-container aux-fold clearfix">

                <div id="primary" class="aux-primary" >
                    <div class="content" role="main" data-target="archive"  >
<?php
                if( have_posts() ) {
                    get_template_part('templates/theme-parts/tax', get_query_var('taxonomy') );
                } else {
                    get_template_part('templates/theme-parts/content', 'none' );
                }
?>
                    </div><!-- end content -->
                </div><!-- end primary -->


                <?php get_sidebar(); ?>

            </div><!-- end container -->
        </div><!-- end wrapper -->
    </main><!-- end main -->

<?php get_sidebar('footer'); ?>
<?php get_footer(); ?>
