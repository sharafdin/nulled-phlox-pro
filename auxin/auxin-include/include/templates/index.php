<?php
/**
 * Include template functions
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */

// include the template parts only on frontend
if( ! is_admin() ||
    ( ! empty( $_REQUEST['action'] ) ) && ( 'elementor' == $_REQUEST['action'] || 'elementor_ajax' == $_REQUEST['action'] || 'elementor_get_template_data' == $_REQUEST['action'] )
  ){
    locate_template( AUXIN_INC . 'include/functions.php', true, true );
    locate_template( AUXIN_INC . 'include/templates/templates-header.php', true, true );
    locate_template( AUXIN_INC . 'include/templates/templates-footer.php', true, true );
}

locate_template( AUXIN_INC . 'include/templates/templates-post.php', true, true );
