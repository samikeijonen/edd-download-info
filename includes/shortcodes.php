<?php

/* Add download link shortcode. */
add_shortcode( 'edd_download_info_link', 'edd_download_info_link_shortcode' );

/**
 * Download Link Shortcode. This is meant to be for free downloads, which can be in wordpress.org for example.
 *
 * Retrieves a download link.
 *
 * @access      public
 * @since       0.1.0
 * @return      string
*/

function edd_download_info_link_shortcode( $atts, $content = null ) {
	global $edd_options;

	extract( shortcode_atts( array(
			'text'  => __( 'Download', 'edd-download-info' ),
			'url'   => '',
			'open'  => 'yes',
			'style' => isset( $edd_options[ 'button_style' ] ) 	 	? $edd_options[ 'button_style' ] 		: 'button',
			'color' => isset( $edd_options[ 'checkout_color' ] ) 	? $edd_options[ 'checkout_color' ] 		: 'blue',
			'class' => 'edd-submit'
		),
		$atts )
	);
	
	/* By default link opens in new window. */
	if ( 'yes' == $open  )
		$open = '_blank';
	else
		$open = '_self';
	
	$edd_download_info_link = sprintf( 
			'<a href="%1$s" class="%2$s %3$s" title="' . esc_attr( $text ) . '" target="%4$s">' . esc_attr( $text ) . '</a>', 
			esc_url( $url ),
			esc_attr( 'edd_go_to_checkout' ),
			implode( ' ', array( $style, $color, trim( $class ) ) ),
			esc_attr( $open )
		);
	
	return $edd_download_info_link;

}

?>