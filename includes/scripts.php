<?php

/* Load admin script. */
add_action( 'admin_enqueue_scripts', 'edd_download_info_load_admin_scripts', 100 );

/**
 * Load Admin Scripts
 *
 * Enqueues the required admin scripts.
 *
 * @access      private
 * @since       1.0
 * @return      void
*/

function edd_download_info_load_admin_scripts( $hook ) {
	global $post;

	if( ( $hook == 'post.php' || $hook == 'post-new.php' ) && $post->post_type == 'download' ) {
		/* Add datepicker. */
		wp_enqueue_script( 'edd-download-info-datepicker-settings', EDD_DOWNLOAD_INFO_URL. 'js/admin-scripts.js', array( 'jquery-ui-datepicker' ), '1712012', true );
		
		/* Localize dateformat. @link: http://pippinsplugins.com/use-wp_localize_script-it-is-awesome */
		wp_localize_script( 'edd-download-info-datepicker-settings', 'datepicker_settings_vars', array(
			'dateformat' => apply_filters( 'edd_download_info_datepicker_date', 'mm/dd/yy' )
			)
		);

		$ui_style = ( 'classic' == get_user_option( 'admin_color' ) ) ? 'classic' : 'fresh';
		wp_enqueue_style( 'jquery-ui-css', trailingslashit( EDD_PLUGIN_URL ) . 'assets/css/jquery-ui-' . $ui_style . '.css' );
	}
	
}


?>