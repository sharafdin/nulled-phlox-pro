<?php
/**
 * The main template file.
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
get_header(); ?>

    <main id="main" <?php auxin_content_main_class(); ?> >
        <div class="aux-wrapper">
            <div class="aux-container aux-fold">

                <div id="primary" class="aux-primary" >
                    <div class="content" role="main" data-target="index" >

                        <?php
                        // if is archive page
                        if ( have_posts() ) {
                            if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'archive' ) ) {
                                get_template_part( 'templates/theme-parts/loop', get_post_type() );
                            }
                        // if is 404 page
                        } elseif( is_404() ){
                            if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
                                get_template_part( 'templates/theme-parts/entry/404' );
                            }
                        // if search result not found
                        } else {
                            if ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'single' ) ) {
                                get_template_part( 'templates/theme-parts/content', 'none' );
                            }
                        }
                        ?>

                    </div><!-- end content -->
                </div><!-- end primary -->


                <?php get_sidebar(); ?>


            </div><!-- end container -->
        </div><!-- end wrapper -->
    </main><!-- end main -->

<?php get_sidebar("footer"); ?>
<?php get_footer(); ?>
