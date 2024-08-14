<?php
/**
 * The footer sidebar widget area is triggered if any of the areas have widgets.
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */

if ( 'default' === $use_legacy_footer = auxin_get_post_meta( $post, 'page_footer_use_legacy', 'default' ) ) {
    $use_legacy_footer = auxin_get_option('site_footer_use_legacy');
}

if (
    ( ! function_exists( 'elementor_theme_do_location' ) || ! elementor_theme_do_location( 'auxin_subfooter' ) ) &&
      ! ( function_exists('hfe_footer_enabled') && hfe_footer_enabled() ) &&
      ! ( class_exists( '\Elementor\Plugin' ) && ! auxin_is_true( $use_legacy_footer ) )
    ) {

    if( auxin_get_option('show_subfooter_bar') || is_customize_preview() ) {
        $layout  = auxin_get_option('subfooter_bar_layout');
    ?>
        <aside class="aux-subfooter-bar <?php echo esc_attr( $layout ); ?>">
            <div class="aux-wrapper">
                <div class="aux-container <?php echo esc_attr( in_array( $layout, array( 'vertical-none-boxed', 'vertical-small-boxed' ) ) ? 'aux-fold' : '' ); ?>">
                    <div class="aux-widget-area">
                        <?php
                        if( is_active_sidebar( 'auxin-subfooter-bar-widget-area' ) ){
                            dynamic_sidebar( 'auxin-subfooter-bar-widget-area' );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </aside>
    <?php
    }


    if( 'default' === $display_subfooter = auxin_get_post_meta( $post, 'page_show_subfooter', 'default') ){
        $display_subfooter = auxin_get_option( 'show_subfooter', '1' );
    }

    if( auxin_is_true( $display_subfooter ) ) {

        // class names for subfooter
        $classes   = array();
        $classes[] = auxin_get_option ( 'footer_widget_dark_mode' ) ? 'aux-dark': '';
        $classes[] = auxin_get_option ( 'subfooter_hide_on_tablet') ? 'aux-tablet-off' : '';
        $classes[] = auxin_get_option ( 'subfooter_hide_on_phone' ) ? 'aux-phone-off'  : '';
     ?>

        <aside <?php echo auxin_make_html_class_attribute( $classes, 'subfooter aux-subfooter' ); ?>>
            <div class="aux-wrapper">
                <div class="aux-container aux-fold">

                    <div class="aux-row">

    <?php
        $layout    = auxin_get_option( 'subfooter_layout' );
        $grid_cols = explode( '_', $layout);
        $col_nums  = count( $grid_cols );

        for ( $i = 1; $i <= $col_nums; $i++ ) {
            $grid_tablet_class = 'aux-tb-' . ( $col_nums > 2 ? 3 : $col_nums );
    ?>
                    <div class="aux-widget-area <?php echo 'aux-' . esc_attr( $grid_cols[ $i-1 ] ) . ' ' . esc_attr( $grid_tablet_class ); ?> aux-mb-1">
    <?php
                        if ( is_active_sidebar( 'auxin-footer'.$i.'-sidebar-widget-area' ) ) {
                            dynamic_sidebar( 'auxin-footer'.$i.'-sidebar-widget-area' );
                        }
    ?>
                    </div>
    <?php
        }
    ?>
                    </div>

                </div><!-- end of container -->

                <?php do_action('auxin_in_the_subfooter'); ?>

            </div><!-- end of wrapper -->

        </aside><!-- end footer widget -->

    <?php
    }

}
