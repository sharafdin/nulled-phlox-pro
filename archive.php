<?php
/**
 * The Template for displaying all posttype items.
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
get_header();?>

    <main id="main" <?php auxin_content_main_class(); ?> >
        <div class="aux-wrapper">
            <div class="aux-container aux-fold clearfix">

                <div id="primary" class="aux-primary" >
                    <div class="content" role="main" data-target="archive"  >

                <?php
                if ( ! ( function_exists( 'auxin_theme_do_location' ) && auxin_theme_do_location( 'archive' ) ) && ! ( function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( 'archive' ) ) ) {

                    if( have_posts() ) {
                        $slug = 'templates/theme-parts/loop';
                        $name = get_post_type();

                        // if loop template part for current post type was not defined, use post template instead
                        if( ! locate_template( $slug .'-'. $name .'.php' ) ){
                            $name = 'post';
                        }
                        get_template_part( $slug, $name );

                    } else {
                        get_template_part('templates/theme-parts/content', 'none' );
                    }

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
