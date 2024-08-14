<?php
/**
 * Go Pricing compatibility
 *
 * 
 * @package    Auxin
 * @author     averta (c) 2014-2024
 * @link       http://averta.net
*/

// no direct access allowed
if ( ! defined('ABSPATH') )  exit;


if ( class_exists( 'AUXELS' ) && defined( 'AUXELS_ADMIN_URL' ) ) {

	add_filter( 'go_pricing_styles',      'auxin_go_pricing_styles', 99, 1 );
	add_filter( 'go_pricing_style_types', 'auxin_go_pricing_style_types', 99, 1 );
	add_filter( 'go_pricing_sign_types',  'auxin_go_pricing_sign_types' );
	add_filter( 'go_pricing_signs',       'auxin_go_pricing_signs' );
	add_filter( 'go_pricing_admin_editor_popup_general_layout-style_phlox', 'auxin_go_pricing_col_color_option', 10, 2 );
	add_filter( 'go_pricing_front_header_html_phlox',                       'auxin_go_pricing_header_generator', 10, 2 );
	add_filter( 'go_pricing_front_footer_html',                             'auxin_go_pricing_footer_generator', 10, 2 );
	add_filter( 'go_pricing_admin_editor_popup_body_row_phlox',             'auxin_go_pricing_body_row_popup',   10, 2 );
	add_filter( 'go_pricing_admin_editor_popup_footer_row_phlox',           'auxin_go_pricing_footer_row_popup', 10, 2 );
	add_filter( 'go_pricing_front_colwrap_classes',                         'auxin_go_pricing_col_wrap_classes', 10, 2 );
}


function auxin_go_pricing_styles( $styles ) {

	$styles[] = array(
		'name' => __( 'Phlox', 'phlox-pro' ),
		'id' => 'phlox'
	);

	return $styles;

}


function auxin_go_pricing_style_types( $styles ) {

	$styles['phlox'][] = array(
		'group_name' => __( 'Modern', 'phlox-pro' ),
		'group_data' => array(
			array(
				'name'  => __( 'Modern normal', 'phlox-pro' ),
				'value' => 'auxin_modern',
				'data'  => AUXELS_ADMIN_URL . '/includes/compatibility/gopricing/images/templates/modern.png',
				'type'  => 'cpricing'
			),
			array(
				'name'  => __( 'Modern Circle', 'phlox-pro' ),
				'value' => 'auxin_circle',
				'data'  => AUXELS_ADMIN_URL . '/includes/compatibility/gopricing/images/templates/circle.png',
				'type'  => 'cpricing'
			)
		)
	);

	$styles['phlox'][] = array(
		'group_name' => __( 'Hosting', 'phlox-pro' ),
		'group_data' => array(
			array(
				'name'  => __( 'Start Column', 'phlox-pro' ),
				'value' => 'auxin_hosting_start',
				'data'  => AUXELS_ADMIN_URL . '/includes/compatibility/gopricing/images/templates/host-start.png',
				'type'  => 'cpricing'
			),
			array(
				'name'  => __( 'Normal Column', 'phlox-pro' ),
				'value' => 'auxin_hosting_normal',
				'data'  => AUXELS_ADMIN_URL . '/includes/compatibility/gopricing/images/templates/host-normal.png',
				'type'  => 'cpricing'
			),
			array(
				'name'  => __( 'Semi highlighted Column', 'phlox-pro' ),
				'value' => 'auxin_hosting_semi',
				'data'  => AUXELS_ADMIN_URL . '/includes/compatibility/gopricing/images/templates/host-normal.png',
				'type'  => 'cpricing'
			)
		)
	);

	$styles['phlox'][] = array(
		'group_name' => __( 'Classic', 'phlox-pro' ),
		'group_data' => array(
			array(
				'name'  => __( 'Classic Normal', 'phlox-pro' ),
				'value' => 'auxin_classic',
				'data'  => AUXELS_ADMIN_URL . '/includes/compatibility/gopricing/images/templates/classic.png',
				'type'  => 'cpricing'
			)
		)
	);

	return $styles;

}


function auxin_go_pricing_sign_types( $types ) {

	$types[] = array(
		'group_name' => __( 'Auxin signs', 'phlox-pro' ),
		'group_data' => array(
			array(
				'name' => __( 'Circle', 'phlox-pro' ),
				'id'   => 'auxin-circle'
			),
			array(
				'name' => __( 'Ribbon', 'phlox-pro' ),
				'id'   => 'auxin-ribbon'
			),
			array(
				'name' => __( 'Badge', 'phlox-pro' ),
				'id'   => 'auxin-badge'
			),
			array(
				'name' => __( 'Rectangle', 'phlox-pro' ),
				'id'   => 'auxin-rectangle'
			)
		)
	);

	return $types;

}


function auxin_go_pricing_signs( $signs ) {

	$signs['auxin-circle'][] = array(
		'group_name' => __( 'Sale', 'phlox-pro' ),
		'group_data' => array(
			array(
				'name' => __( 'Blue Sale', 'phlox-pro' ),
				'value' => 'auxin-circle-sale-blue',
				'data' => AUXELS_ADMIN_URL . '/includes/compatibility/gopricing/images/signs/circle-sale-blue.png'
			)
		)
	);

	$signs['auxin-ribbon'][] = array(
		'group_name' => __( 'Popular', 'phlox-pro' ),
		'group_data' => array(
			array(
				'name' => __( 'Blue Popular', 'phlox-pro' ),
				'value' => 'auxin-ribbon-popular-blue',
				'data' => AUXELS_ADMIN_URL . '/includes/compatibility/gopricing/images/signs/ribbon-popular-blue.png'
			)
		)
	);

	$signs['auxin-badge'][] = array(
		'group_name' => __( 'Popular', 'phlox-pro' ),
		'group_data' => array(
			array(
				'name' => __( 'Blue Popular', 'phlox-pro' ),
				'value' => 'auxin-badge-popular-blue',
				'data' => AUXELS_ADMIN_URL . '/includes/compatibility/gopricing/images/signs/badge-popular-blue.png'
			)
		)
	);

	$signs['auxin-rectangle'][] = array(
		'group_name' => __( 'Most Popular', 'phlox-pro' ),
		'group_data' => array(
			array(
				'name' => __( 'Blue Most Popular', 'phlox-pro' ),
				'value' => 'auxin-rectangle-mostpopular-blue',
				'data' => AUXELS_ADMIN_URL . '/includes/compatibility/gopricing/images/signs/rectangle-mostpopular-blue.png'
			),
			array(
				'name' => __( 'Small Blue Most Popular', 'phlox-pro' ),
				'value' => 'auxin-rectangle-mostpopular-blue-small',
				'data' => AUXELS_ADMIN_URL . '/includes/compatibility/gopricing/images/signs/small-rectangle-mostpopular-blue.png'
			)
		)
	);

	return $signs;

}


function auxin_go_pricing_col_color_option( $html, $postdata ) {

	ob_start();
	$content = '';
	?>
		<div class="gwa-table-separator"></div>
		<div class="gwa-section"><span><?php _e( 'Style Settings', 'phlox-pro' ); ?></span></div>
		<table class="gwa-table">
		    <tr>
		        <th><label><?php _e( 'Main Color', 'phlox-pro' ); ?></label></th>
		        <td><label><div class="gwa-colorpicker gwa-colorpicker-inline" tabindex="0"><input type="hidden" name="main-color" value="<?php echo esc_attr( isset( $postdata['main-color'] ) ? $postdata['main-color'] : '' ); ?>"><span class="gwa-cp-picker"><span<?php echo ( !empty( $postdata['main-color'] ) ? ' style="background:' . $postdata['main-color'] . ';"' : '' ); ?>></span></span><span class="gwa-cp-label"><?php echo ( !empty( $postdata['main-color'] ) ? $postdata['main-color'] : '&nbsp;' ); ?></span><div class="gwa-cp-popup"><div class="gwa-cp-popup-inner"></div><div class="gwa-input-btn"><input type="text" tabindex="-1" value="<?php echo esc_attr( !empty( $postdata['main-color'] ) ? $postdata['main-color'] : '' ); ?>"><a href="#" data-action="cp-fav" tabindex="-1" title="<?php _e( 'Add To Favourites', 'phlox-pro' ); ?>"><i class="fa fa-heart"></i></a></div></div></div></label></td>
		        <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Main color of the pricing table.', 'phlox-pro' ); ?></p></td>
		    </tr>
		</table>
	<?php

	$content = ob_get_clean();

	$html .= $content;
	return $html;

}


function auxin_go_pricing_header_generator( $html, $args ) {

	if ( ! class_exists('GW_GoPricing_Shortcodes') ) {
		return $html;
	}

	// Return custom html, when replace selected
	if( ! empty( $html ) && isset( $args['col_data']['header']['general']['replace'] ) && ! empty( $args['col_data']['header']['general']['html'] ) ){
		return sprintf( '<div class="aux-gw-go-header">%s</div>', $html );
	}

	global $go_pricing;
	$general_settings = get_option( 'go_pricing_table_settings' );

	$price_format = !empty( $general_settings['currency'][0]['position'] ) && $general_settings['currency'][0]['position'] == 'left' ? '<span data-id="price" data-currency="%1$s" data-price="%4$s"><span data-id="currency">%2$s</span><span data-id="amount">%3$s</span></span>' : '<span data-id="price" data-currency="%1$s" data-price="%4$s"><span data-id="amount">%3$s</span><span data-id="currency">%2$s</span></span>';

	$price_type = isset( $args['col_data']['price']['type'] ) ? $args['col_data']['price']['type'] : '';

	switch( $price_type ) {

		case 'price-html' :
			$price = sprintf( '<span>%s</span>', isset( $args['col_data']['price']['price-html']['content'] ) ?  $args['col_data']['price']['price-html']['content'] : ''  );
			$payment = isset( $args['col_data']['price']['payment']['content'] ) ?  $args['col_data']['price']['payment']['content'] : '';
			break;

		case 'price' :
			$decimals = isset( $general_settings['currency'][0]['decimal-no'] ) ? (int)$general_settings['currency'][0]['decimal-no'] : 2;
			$currency_symbol = '';
			foreach ( (array)$go_pricing['currency'] as $currency ) {
				if ( !empty( $currency['id'] ) && !empty( $currency['symbol'] ) && !empty( $general_settings['currency'][0]['currency'] ) && $currency['id'] == $general_settings['currency'][0]['currency'] ) $currency_symbol = $currency['symbol'];
				if ( isset( $general_settings['currency'][0]['symbol'] ) && trim( $general_settings['currency'][0]['symbol'] ) !== '' ) $currency_symbol = trim( $general_settings['currency'][0]['symbol'] );
			}

			if ( isset( $args['col_data']['price']['price'][0]['amount'][0] ) && $args['col_data']['price']['price'][0]['amount'][0] != '' ) {

				if ( empty( $general_settings['currency'][0]['trailing-zero'] ) ) {

					$dec = explode ( '.', (float)$args['col_data']['price']['price'][0]['amount'][0] );
					if ( !empty( $dec[1] ) ) {
						if ( strlen( $dec[1] ) < $decimals ) $decimals = strlen( $dec[1] );
					} else {
						$decimals = 0;
					}
				}

				$price = sprintf( $price_format,
					isset( $general_settings['currency'][0] ) ? GW_GoPricing_Helper::esc_attr( wp_json_encode( $general_settings['currency'][0] ) ) : '',
					$currency_symbol,
					number_format(
						(float)$args['col_data']['price']['price'][0]['amount'][0],
						$decimals,
						isset( $general_settings['currency'][0]['decimal-sep'] ) ? $general_settings['currency'][0]['decimal-sep'] : '.',
						isset( $general_settings['currency'][0]['thousand-sep'] ) ? $general_settings['currency'][0]['thousand-sep'] : ','
					),
					isset( $args['col_data']['price']['price'][0]['amount'][0] ) ? number_format( (float)$args['col_data']['price']['price'][0]['amount'][0], $decimals, '.', '' ) : 0


				);

			}

			$payment = isset( $args['col_data']['price']['price'][0]['name'] ) ?  $args['col_data']['price']['price'][0]['name'] : '';
			break;

	}

	ob_start();

	if ( ! empty( $args['sign_html'] ) ) : ?>
		<div class="gw-go-sign">
			<?php echo $args['sign_html']; ?>
		</div>
	<?php endif;

	if ( in_array( $args['col_data']['col-style-type'], array( 'auxin_modern', 'auxin_circle' ) ) ) : ?>
		<div class="aux-gw-go-header">
	 		<div class="aux-gw-go-header-top">
	 			<?php if ( isset( $args['col_data']['title']['title']['content'] ) ) : ?>
	 				<h3 class="aux-gw-go-title"><?php echo $args['col_data']['title']['title']['content']; ?></h3>
	 			<?php endif; ?>
	 		</div>
 			<hr class="aux-gw-go-hr">
	 		<?php if ( isset( $price ) ) : ?>
		 		<div class="aux-gw-go-header-price">
		 			<?php echo $price; ?>
		 			<span class="payment"><?php echo $payment; ?></span>
		 		</div>
	 		<?php endif; ?>
	 		<?php
	 			if( isset( $args['col_data']['header']['general']['html'] ) ) {
	 				echo $args['col_data']['header']['general']['html'];
	 			}
	 		?>
 		</div>
 	<?php elseif ( in_array( $args['col_data']['col-style-type'], array( 'auxin_classic', 'auxin_hosting_normal', 'auxin_hosting_semi') ) ) : ?>
		<div class="aux-gw-go-header">
	 		<div class="aux-gw-go-header-top">
	 			<?php if ( isset( $args['col_data']['title']['title']['content'] ) ) : ?>
	 				<h3 class="aux-gw-go-title"><?php echo $args['col_data']['title']['title']['content']; ?></h3>
	 			<?php endif; ?>
	 		</div>
	 		<?php if ( isset( $price ) ) : ?>
		 		<div class="aux-gw-go-header-price">
		 			<?php echo $price; ?>
		 			<span class="payment"><?php echo $payment; ?></span>
		 		</div>
	 		<?php endif; ?>
	 		<?php
	 			if( isset( $args['col_data']['header']['general']['html'] ) ) {
	 				echo $args['col_data']['header']['general']['html'];
	 			}
	 		?>
 		</div>
 	<?php elseif ( 'auxin_hosting_start' === $args['col_data']['col-style-type'] ) : ?>
		<div class="aux-gw-go-header">
	 		<div class="aux-gw-go-header-top">
	 			<?php if ( isset( $args['col_data']['title']['title']['content'] ) ) : ?>
	 				<h3 class="aux-gw-go-title"><?php echo $args['col_data']['title']['title']['content']; ?></h3>
	 			<?php endif; ?>
	 		</div>
	 		<?php
	 			if( isset( $args['col_data']['header']['general']['html'] ) ) {
	 				echo $args['col_data']['header']['general']['html'];
	 			}
	 		?>
 		</div>
 	<?php endif;

	$header_data['html'] = ob_get_clean();


 	$title_styles = $price_styles = $payment_styles = array();

	$title_styles   = auxin_go_pricing_font_loader( $args['col_data'], 'title', 'title' );
	$price_styles   = auxin_go_pricing_font_loader( $args['col_data'], 'price', 'price-style' );
	$payment_styles = auxin_go_pricing_font_loader( $args['col_data'], 'price', 'payment' );


	ob_start();

		$title_styles   = implode( ';', (array) $title_styles );
		$price_styles   = implode( ';' , (array) $price_styles );
		$payment_styles = implode( ';', (array) $payment_styles );
	?>
	<style>
		.gw-go-col-wrap-<?php echo $args['col_index']; ?> .gw-go-col.gw-go-<?php echo $args['col_data']['col-style-type']; ?> .aux-gw-go-header .aux-gw-go-title {
			<?php echo $title_styles; ?>
		}
		.gw-go-col-wrap-<?php echo $args['col_index']; ?> .gw-go-col.gw-go-<?php echo $args['col_data']['col-style-type']; ?> .aux-gw-go-header .aux-gw-go-header-price [data-id="amount"] {
			<?php echo $price_styles; ?>
		}
		.gw-go-col-wrap-<?php echo $args['col_index']; ?> .gw-go-col.gw-go-<?php echo $args['col_data']['col-style-type']; ?> .aux-gw-go-header .aux-gw-go-header-price .payment {
			<?php echo $payment_styles; ?>
		}
		.gw-go-col-wrap-<?php echo $args['col_index']; ?>.gw-go-hover .gw-go-col.gw-go-auxin_circle .gw-go-col-inner,
		.gw-go-col-wrap-<?php echo $args['col_index']; ?>.gw-go-hover .gw-go-col.gw-go-auxin_modern .gw-go-col-inner,
		.gw-go-col-wrap-<?php echo $args['col_index']; ?> .gw-go-col.gw-go-auxin_classic .aux-gw-go-header-top,
		.gw-go-col-wrap-<?php echo $args['col_index']; ?>.gw-go-hover .gw-go-col.gw-go-auxin_classic .aux-gw-go-header-price,
		.gw-go-col-wrap-<?php echo $args['col_index']; ?> .gw-go-col.gw-go-auxin_circle .aux-gw-go-header-price {
			<?php if ( $args['col_data']['layout-style']['main-color'] ) { printf( 'background-color:%s;', $args['col_data']['layout-style']['main-color'] ); } ?>
		}
		.gw-go-col-wrap-<?php echo $args['col_index']; ?> .gw-go-col.gw-go-auxin_hosting_normal .aux-gw-go-header-top,
		.gw-go-col-wrap-<?php echo $args['col_index']; ?> .gw-go-col.gw-go-auxin_hosting_semi .aux-gw-go-header-price,
		.gw-go-col-wrap-<?php echo $args['col_index']; ?>.gw-go-hover .gw-go-col.gw-go-auxin_hosting_normal .aux-gw-go-header-price {
			<?php if ( $args['col_data']['layout-style']['main-color'] ) { printf( 'background-color:%s;', $args['col_data']['layout-style']['main-color'] ); } ?>
		}
		.gw-go-col-wrap-<?php echo $args['col_index']; ?> .gw-go-col.gw-go-auxin_classic {
			<?php if ( $args['col_data']['layout-style']['main-color'] ) { printf( 'border:1px solid %s;', $args['col_data']['layout-style']['main-color'] ); } ?>
		}
	</style>
	<?php

	$header_data['css'] = (array) ob_get_clean();

	return $header_data;

}


function auxin_go_pricing_footer_generator( $html, $args ) {

	if (  in_array( $args['pricing_table']['col-data'][0]['col-style-type'], array( 'auxin_modern', 'auxin_circle' ) ) ) {
		$html = '<hr class="aux-gw-go-hr">' . $html;
	}

	return $html;

}


function auxin_go_pricing_body_row_popup( $html, $postdata ) {

	global $go_pricing;
	if( is_array( $postdata ) ){
		$postdata['type'] = 'html';
	}

	ob_start(); ?>

	<div class="gwa-popup-tab-contents">
		<div class="gwa-popup-tab-content gwa-current">


		<!-- Type Selector -->
		<table class="gwa-table">
			<tr>
				<th><label><?php _e( 'Row Type', 'phlox-pro' ); ?></label></th>
				<td>
					<select name="type" data-title="type">
						<option value="html"<?php echo !empty ( $postdata['type'] ) && $postdata['type'] == 'html' ? ' selected="selected"' : ''; ?>><?php _e( 'HTML Content', 'phlox-pro' ); ?></option>
					</select>
				</td>
				<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Type of the footer row.', 'phlox-pro' ); ?></p></td>
			</tr>
		</table>
		<div class="gwa-table-separator"></div>
		<!-- / Type Selector -->

	    <!-- HTML Content -->
	    <table class="gwa-table" data-parent-id="type" data-parent-value="html">
	        <tr class="gwa-row-fullwidth">
	            <th><label><?php _e( 'Content', 'phlox-pro' ); ?></label></th>
	            <td><div class="gwa-textarea-code"><div class="gwa-textarea-btn-top"><span class="gwa-textarea-align"><input type="hidden" name="html[text-align]" value="<?php echo !empty( $postdata['html']['text-align'] ) ? esc_attr( $postdata['html']['text-align'] ) : ''; ?>"><a href="#" data-align="left" title="<?php _e( 'Align Left', 'phlox-pro' ); ?>" class="<?php echo !empty( $postdata['html']['text-align'] ) && $postdata['html']['text-align'] == 'left' ? 'gwa-current' : ''; ?>"><i class="fa fa-align-left"></i></a><a href="#" data-align="" title="<?php _e( 'Align Center', 'phlox-pro' ); ?>" class="<?php echo empty( $postdata['html']['text-align'] ) ? 'gwa-current' : ''; ?>"><i class="fa fa-align-center"></i></a><a href="#" data-align="right" title="<?php _e( 'Align Right', 'phlox-pro' ); ?>" class="<?php echo !empty( $postdata['html']['text-align'] ) && $postdata['html']['text-align'] == 'right' ? 'gwa-current' : ''; ?>"><i class="fa fa-align-right"></i></a></span><a href="#" data-action="popup"  data-popup="sc-row-icon" title="<?php _e( 'Add Shortcode', 'phlox-pro' ); ?>" class="gwa-fr"><i class="fa fa-code"></i></a></div><textarea name="html[content]" rows="5" data-popup="sc-row-icon" data-editor-height="180" data-editor-type="htmlmixed" data-preview="<?php esc_attr_e( 'Content', 'phlox-pro' ); ?>"><?php echo isset( $postdata['html']['content'] ) ? esc_textarea( $postdata['html']['content'] ) : '' ; ?></textarea></div></td>
	            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Content of the row.', 'phlox-pro' ); ?></p></td>
	        </tr>
	    </table>
	    <!-- / HTML Content -->
	    </div>

		<div class="gwa-popup-tab-content">

	     <!-- HTML Content -->
	     <table class="gwa-table" data-parent-id="type" data-parent-value="html">
	        <tr>
	            <th><label><?php _e( 'Font Family', 'phlox-pro' ); ?></label></th>
	            <td>
	                <select name="html[font-family]">
	                    <?php
	                    foreach ( (array)$go_pricing['fonts'] as $fonts ) :
	                    if ( !empty( $fonts['group_name'] ) )	:
	                    ?>
	                    <optgroup label="<?php echo esc_attr( $fonts['group_name'] ); ?>"></optgroup>
	                    <?php
	                    foreach ( (array)$fonts['group_data'] as $font_data ) :
	                    ?>
	                    <option value="<?php echo esc_attr( !empty( $font_data['value'] ) ? $font_data['value'] : '' ); ?>"<?php echo ( !empty( $font_data['value'] ) && isset( $postdata['html']['font-family'] ) && $font_data['value'] == $postdata['html']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $font_data['name'] ) ? $font_data['name'] : '' ); ?></option>
	                    <?php
	                    endforeach;
	                    else :
	                    ?>
	                    <option value="<?php echo esc_attr( !empty( $fonts['value'] ) ? $fonts['value'] : '' ); ?>"<?php echo ( !empty( $fonts['value'] ) && isset( $postdata['html']['font-family'] ) && $fonts['value'] == $postdata['html']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $fonts['name'] ) ? $fonts['name'] : '' ); ?></option>
	                    <?php
	                    endif;
	                    endforeach;
	                    ?>
	                </select>
	            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font family of the row content.', 'phlox-pro' ); ?></p></td>
	        </tr>
	        <tr>
	            <th><label><?php _e( 'Font Size / Line H.', 'phlox-pro' ); ?> <span class="gwa-info">(px)</span></label></th>
	            <td><input type="text" name="html[font-size]" value="<?php echo !empty( $postdata['html']['font-size'] ) ? esc_attr( $postdata['html']['font-size'] ) : 12; ?>" class="gwa-input-mid"><input type="text" name="html[line-height]" value="<?php echo !empty( $postdata['html']['line-height'] ) ? esc_attr( $postdata['html']['line-height'] ) : 16; ?>" class="gwa-input-mid"><div class="gwa-icon-btn"><a href="#" title="<?php esc_attr_e( 'Bold', 'phlox-pro' ); ?>" data-action="font-style-bold"<?php echo !empty( $postdata['html']['font-style']['bold'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-bold"></i><input type="hidden" name="html[font-style][bold]" value="<?php echo !empty( $postdata['html']['font-style']['bold'] ) ? esc_attr( $postdata['html']['font-style']['bold'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Italic', 'phlox-pro' ); ?>" data-action="font-style-italic"<?php echo !empty( $postdata['html']['font-style']['italic'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-italic"></i><input type="hidden" name="html[font-style][italic]" value="<?php echo !empty( $postdata['html']['font-style']['italic'] ) ? esc_attr( $postdata['html']['font-style']['italic'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Strikethrough', 'phlox-pro' ); ?>" data-action="font-style-strikethrough"<?php echo !empty( $postdata['html']['font-style']['strikethrough'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-strikethrough"></i><input type="hidden" name="html[font-style][strikethrough]" value="<?php echo !empty( $postdata['html']['font-style']['strikethrough'] ) ? esc_attr( $postdata['html']['font-style']['strikethrough'] ) : ''; ?>"></a></div></td>
	            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font size and line height of the row content in pixels.', 'phlox-pro' ); ?></p></td>
	        </tr>
	    </table>
	    <!-- / HTML Content -->
		</div>
	</div>

	<?php
	$html = ob_get_clean();

	return $html;

}


function auxin_go_pricing_footer_row_popup( $html, $postdata ) {

	global $go_pricing;
	$postdata['type'] = 'html';
	ob_start(); ?>

	<div class="gwa-popup-tab-contents">
		<div class="gwa-popup-tab-content gwa-current">


		<!-- Type Selector -->
		<table class="gwa-table">
			<tr>
				<th><label><?php _e( 'Row Type', 'phlox-pro' ); ?></label></th>
				<td>
					<select name="type" data-title="type">
						<option value="html"<?php echo !empty ( $postdata['type'] ) && $postdata['type'] == 'html' ? ' selected="selected"' : ''; ?>><?php _e( 'HTML Content', 'phlox-pro' ); ?></option>
					</select>
				</td>
				<td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Type of the footer row.', 'phlox-pro' ); ?></p></td>
			</tr>
		</table>
		<div class="gwa-table-separator"></div>
		<!-- / Type Selector -->

	    <!-- HTML Content -->
	    <table class="gwa-table" data-parent-id="type" data-parent-value="html">
	        <tr class="gwa-row-fullwidth">
	            <th><label><?php _e( 'Content', 'phlox-pro' ); ?></label></th>
	            <td><div class="gwa-textarea-code"><div class="gwa-textarea-btn-top"><span class="gwa-textarea-align"><input type="hidden" name="html[text-align]" value="<?php echo !empty( $postdata['html']['text-align'] ) ? esc_attr( $postdata['html']['text-align'] ) : ''; ?>"><a href="#" data-align="left" title="<?php _e( 'Align Left', 'phlox-pro' ); ?>" class="<?php echo !empty( $postdata['html']['text-align'] ) && $postdata['html']['text-align'] == 'left' ? 'gwa-current' : ''; ?>"><i class="fa fa-align-left"></i></a><a href="#" data-align="" title="<?php _e( 'Align Center', 'phlox-pro' ); ?>" class="<?php echo empty( $postdata['html']['text-align'] ) ? 'gwa-current' : ''; ?>"><i class="fa fa-align-center"></i></a><a href="#" data-align="right" title="<?php _e( 'Align Right', 'phlox-pro' ); ?>" class="<?php echo !empty( $postdata['html']['text-align'] ) && $postdata['html']['text-align'] == 'right' ? 'gwa-current' : ''; ?>"><i class="fa fa-align-right"></i></a></span><a href="#" data-action="popup"  data-popup="sc-row-icon" title="<?php _e( 'Add Shortcode', 'phlox-pro' ); ?>" class="gwa-fr"><i class="fa fa-code"></i></a></div><textarea name="html[content]" rows="5" data-popup="sc-row-icon" data-editor-height="180" data-editor-type="htmlmixed" data-preview="<?php esc_attr_e( 'Content', 'phlox-pro' ); ?>"><?php echo isset( $postdata['html']['content'] ) ? esc_textarea( $postdata['html']['content'] ) : '' ; ?></textarea></div></td>
	            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Content of the row.', 'phlox-pro' ); ?></p></td>
	        </tr>
	    </table>
	    <!-- / HTML Content -->
	    </div>

		<div class="gwa-popup-tab-content">

	     <!-- HTML Content -->
	     <table class="gwa-table" data-parent-id="type" data-parent-value="html">
	        <tr>
	            <th><label><?php _e( 'Font Family', 'phlox-pro' ); ?></label></th>
	            <td>
	                <select name="html[font-family]">
	                    <?php
	                    foreach ( (array)$go_pricing['fonts'] as $fonts ) :
	                    if ( !empty( $fonts['group_name'] ) )	:
	                    ?>
	                    <optgroup label="<?php echo esc_attr( $fonts['group_name'] ); ?>"></optgroup>
	                    <?php
	                    foreach ( (array)$fonts['group_data'] as $font_data ) :
	                    ?>
	                    <option value="<?php echo esc_attr( !empty( $font_data['value'] ) ? $font_data['value'] : '' ); ?>"<?php echo ( !empty( $font_data['value'] ) && isset( $postdata['html']['font-family'] ) && $font_data['value'] == $postdata['html']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $font_data['name'] ) ? $font_data['name'] : '' ); ?></option>
	                    <?php
	                    endforeach;
	                    else :
	                    ?>
	                    <option value="<?php echo esc_attr( !empty( $fonts['value'] ) ? $fonts['value'] : '' ); ?>"<?php echo ( !empty( $fonts['value'] ) && isset( $postdata['html']['font-family'] ) && $fonts['value'] == $postdata['html']['font-family'] ? ' selected="selected"' : '' ); ?>><?php echo ( !empty( $fonts['name'] ) ? $fonts['name'] : '' ); ?></option>
	                    <?php
	                    endif;
	                    endforeach;
	                    ?>
	                </select>
	            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font family of the row content.', 'phlox-pro' ); ?></p></td>
	        </tr>
	        <tr>
	            <th><label><?php _e( 'Font Size / Line H.', 'phlox-pro' ); ?> <span class="gwa-info">(px)</span></label></th>
	            <td><input type="text" name="html[font-size]" value="<?php echo !empty( $postdata['html']['font-size'] ) ? esc_attr( $postdata['html']['font-size'] ) : 12; ?>" class="gwa-input-mid"><input type="text" name="html[line-height]" value="<?php echo !empty( $postdata['html']['line-height'] ) ? esc_attr( $postdata['html']['line-height'] ) : 16; ?>" class="gwa-input-mid"><div class="gwa-icon-btn"><a href="#" title="<?php esc_attr_e( 'Bold', 'phlox-pro' ); ?>" data-action="font-style-bold"<?php echo !empty( $postdata['html']['font-style']['bold'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-bold"></i><input type="hidden" name="html[font-style][bold]" value="<?php echo !empty( $postdata['html']['font-style']['bold'] ) ? esc_attr( $postdata['html']['font-style']['bold'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Italic', 'phlox-pro' ); ?>" data-action="font-style-italic"<?php echo !empty( $postdata['html']['font-style']['italic'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-italic"></i><input type="hidden" name="html[font-style][italic]" value="<?php echo !empty( $postdata['html']['font-style']['italic'] ) ? esc_attr( $postdata['html']['font-style']['italic'] ) : ''; ?>"></a><a href="#" title="<?php esc_attr_e( 'Strikethrough', 'phlox-pro' ); ?>" data-action="font-style-strikethrough"<?php echo !empty( $postdata['html']['font-style']['strikethrough'] ) ? ' class="gwa-current"' : ''; ?>><i class="fa fa-strikethrough"></i><input type="hidden" name="html[font-style][strikethrough]" value="<?php echo !empty( $postdata['html']['font-style']['strikethrough'] ) ? esc_attr( $postdata['html']['font-style']['strikethrough'] ) : ''; ?>"></a></div></td>
	            <td class="gwa-abox-info"><p class="gwa-info"><i class="fa fa-info-circle"></i><?php _e( 'Font size and line height of the row content in pixels.', 'phlox-pro' ); ?></p></td>
	        </tr>
	    </table>
	    <!-- / HTML Content -->
		</div>
	</div>

	<?php
	$html = ob_get_clean();

	return $html;

}


function auxin_go_pricing_font_loader( $col_data, $section, $subsection ) {

	$google_font = '';
	$google_fonts = $styles = array();
	global $go_pricing;

	if ( !empty( $col_data[ $section ][ $subsection ]['font-size'] ) ) {
		$styles[] = sprintf( 'font-size:%spx !important' , (int)$col_data[ $section ][ $subsection ]['font-size'] );
	}

	if ( !empty( $col_data[ $section ][ $subsection ]['line-height'] ) ) {
		$styles[] = sprintf( 'line-height:%spx !important' , (int)$col_data[ $section ][ $subsection ]['line-height'] );
	}

	if ( !empty( $col_data[ $section ][ $subsection ]['font-style']['bold'] ) ) {
		$styles[] = 'font-weight:bold !important';
	}

	if ( !empty( $col_data[ $section ][ $subsection ]['font-style']['italic'] ) ) {
		$styles[] = 'font-style:italic !important';
	}

	if ( !empty( $col_data[ $section ][ $subsection ]['font-style']['strikethrough'] ) ) {
		$styles[] = 'text-decoration:line-through !important';
	}


	if ( !empty( $col_data[ $section ][ $subsection ]['font-family'] ) ) {
		foreach( (array)$go_pricing['fonts'] as $fonts ) {

			if ( !empty( $fonts['group_name'] ) && !empty( $fonts['group_data'] ) ) {
				foreach( (array)$fonts['group_data'] as $font ) {
					if ( !empty( $font['value'] ) && $font['value'] == $col_data[ $section ][ $subsection ]['font-family'] ) {
						if ( !empty( $font['name'] ) && !empty( $font['url'] ) ) {

							$font_url_params = array();

							/* Google Font */
							if ( preg_match( '/fonts.googleapis.com/', $font['url'] ) ) {
								$font_url_params[] = '400';
								if ( !empty( $col_data[ $section ][ $subsection ]['font-style']['bold'] ) ) $font_url_params[] = 'b';
								if ( !empty( $col_data[ $section ][ $subsection ]['font-style']['italic'] ) ) $font_url_params[] = 'i';
								$font['url'] .= sprintf( ':%s', implode( ',', $font_url_params ) );
							}
						}

						if ( !empty( $font['url'] ) && !empty( $font_url_params ) ) {
							$google_font = sprintf( '@' . 'import url(%s)', $font['url'] );
							if ( !in_array( $google_font, (array)$google_fonts ) ) $google_fonts[] = $google_font;
						}

						if ( !empty( $font['value'] ) ) $styles[] = sprintf( 'font-family:%s !important' , $font['value'] );
					}

				}
			}

		}
	}

	return $styles;

}


function auxin_go_pricing_col_wrap_classes( $atts, $args ) {

	$atts[] = $args['pricing_table']['col-data'][0]['col-style-type'];

	return $atts;
}
