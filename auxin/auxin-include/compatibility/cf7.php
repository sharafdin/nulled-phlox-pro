<?php
/**
 * Contact form 7 compatibility
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


/**
 * Remove contact form 7 auto break lines
 *
 * @version 2.5.0
 */
function auxin_check_autop_or_not() {
	$wpcf7 = WPCF7_ContactForm::get_current();

	return !is_null( $wpcf7 ) && 'yes' !== get_post_meta( $wpcf7->id(), 'auxin-autop', true );
}
add_filter( 'wpcf7_autop_or_not', 'auxin_check_autop_or_not' );


/**
 * Adds custom fields to the Contact Form 7 edit screen
 *
 * @param array $panels    An array of all the panels currently displayed on the Contact Form 7 edit screen
 */
function auxin_cf7_add_custom_setting_panel( $panels ) {
    $panels['auxin-custom-settings'] = array(
        'title'    => esc_html__( 'Theme Settings', 'phlox-pro' ),
        'callback' => 'auxin_cf7_print_custom_settings'
    );

    return $panels;
}
add_filter( 'wpcf7_editor_panels', 'auxin_cf7_add_custom_setting_panel' );


/**
 * Hooks into the save_post method and stores post meta to the contact form
 *
 * @param $post_id - post ID of the current post being saved
 */
function auxin_cf7_save_custom_settings( $post_id ) {
	if( class_exists( 'WPCF7_ContactForm' ) ){
		$autop = ( ! empty( $_POST['auxin-autop'] ) )  ? 'yes' : 'no';
		update_post_meta( $post_id, 'auxin-autop', $autop );
	}
}
add_action( 'save_post', 'auxin_cf7_save_custom_settings' );


/**
 * Sets up the fields inside our new custom panel
 *
 * @param WPCF7_ContactForm $post - modified post type object from Contact Form 7 containing information about the current contact form
 */
function auxin_cf7_print_custom_settings( $post ) {
    ?>
    <h2><?php esc_html_e( 'Theme Settings', 'phlox-pro' ); ?></h2>
    <fieldset>
        <legend></legend>
		<input type="checkbox" id="auxin-autop" name="auxin-autop" value="enable" <?php checked( get_post_meta( $post->id(), 'auxin-autop', true ), 'yes' ); ?>>
        <label for="auxin-autop"><?php esc_html_e( "Don't add line breaks and paragraphs automatically.", 'phlox-pro' );?></label>
    </fieldset>
    <?php
}