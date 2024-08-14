<?php
/**
 * The header of all pages.
 *
 * Displays all of the <head> section and everything up till <main id="main">
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
 */
global $post;
do_action( "auxin_before_head_open", $post );
?>
<!DOCTYPE html>
<!--[if IE 9 ]>   <html class="no-js oldie ie9 ie" <?php language_attributes(); ?> > <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html class="no-js" <?php language_attributes(); ?> > <!--<![endif]-->
<head>
        <meta charset="<?php esc_attr( bloginfo( 'charset' ) ); ?>" >
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!-- devices setting -->
        <meta name="viewport"   content="initial-scale=1<?php echo auxin_get_option( 'enable_site_reponsiveness', 1 ) ? ',user-scalable=no,width=device-width' : ''; ?>">

<!-- outputs by wp_head -->
<?php wp_head(); ?>
<!-- end wp_head -->
</head>


<body <?php body_class(); auxin_dom_attributes( 'body' );?>>

<?php do_action( "auxin_after_body_open", $post ); ?>

<div id="inner-body">

<?php do_action( "auxin_after_inner_body_open", $post );
