<?php

/* Add demo link style option in settings (Settings >> Style). */
add_filter( 'edd_settings_styles', 'edd_download_info_add_styles' );

/**
 * Registers the new EDD Download info theme link style options in Style
 * *
 * @access      private
 * @since       0.1.0
 * @param       $settings array the existing plugin settings
 * @return      array
*/
function edd_download_info_add_styles( $settings ) {

	$style_settings = array(
		'edd_download_info_demo_link_style' => array(
			'id' => 'edd_download_info_demo_link_style',
			'name' => __( 'Default demo link Style', 'edd-download-info' ),
			'desc' => __( 'Choose the style you want to use for the demo link button', 'edd-download-info' ),
			'type' => 'color_select',
			'options' => edd_get_button_colors()
		)
	);

	return array_merge( $settings, $style_settings );
	
}

?>