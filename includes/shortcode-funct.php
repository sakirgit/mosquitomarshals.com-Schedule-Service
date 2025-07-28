<?php 

/* 
 * ==== REGISTER SHORTCODE 	====
*/
add_shortcode( 'custom_pest_mosquito', function($atts) {
	ob_start();
	$atts = shortcode_atts( array(	'display' => '' ), $atts, 'custom_pest_mosquito' );
	if ( !is_admin() ) :
		if ( $atts['display'] == 'form' ) : 
		include_once JOHNNIE_TEMPLATES . 'shortcode-service-form.php';
		endif;
	endif;
	return ob_get_clean();
} );


add_shortcode( 'wp_ct_form_3', function($atts) {
	ob_start();
	$atts = shortcode_atts( array(	'display' => '' ), $atts, 'wp_ct_form_3' );
	if ( !is_admin() ) :
		if ( $atts['display'] == '' ) : 
			include_once JOHNNIE_TEMPLATES . 'form_location.php';
		elseif( $atts['display'] == 'normal' ) :
			include_once JOHNNIE_TEMPLATES . 'form-location-default.php';	
		endif;
		
	endif;
	return ob_get_clean();
} );