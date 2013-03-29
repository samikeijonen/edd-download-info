<?php
/**
 * Setup Download Taxonomies
 *
 * Registers the custom taxonomy download features.
 *
 * @since 0.1.0
*/

add_action( 'init', 'edd_download_info_taxonomies' );

function edd_download_info_taxonomies() {

	$slug = 'downloads';
	if ( defined( 'EDD_SLUG' ) ) {
		$slug = EDD_SLUG;
	}

	$feature_labels = array(
		'name' 				=> _x( 'Download Features', 'taxonomy general name', 'edd-download-info' ),
		'singular_name' 	=> _x( 'Feature', 'taxonomy singular name', 'edd-download-info' ),
		'search_items' 		=> __( 'Search Features', 'edd-download-info' ),
		'all_items' 		=> __( 'All Features', 'edd-download-info' ),
		'parent_item' 		=> __( 'Parent Feature', 'edd-download-info' ),
		'parent_item_colon' => __( 'Parent Feature:', 'edd-download-info' ),
		'edit_item' 		=> __( 'Edit Features', 'edd-download-info' ), 
		'update_item' 		=> __( 'Update Feature', 'edd-download-info' ),
		'add_new_item' 		=> __( 'Add New Feature', 'edd-download-info' ),
		'new_item_name' 	=> __( 'New Feature Name', 'edd-download-info' ),
		'menu_name' 		=> __( 'Features', 'edd-download-info' ),
	); 	

	$feature_args = apply_filters( 'edd_download_info_feature_args', array(
			'hierarchical' 	=> true,
			'labels' 		=> apply_filters( 'edd_download_info_feature_labels', $feature_labels ),
			'show_ui' 		=> true,
			'query_var' 	=> 'download_feature',
			'rewrite' 		=> array( 'slug' => $slug . '/feature' )
		)
	);

	register_taxonomy( 'edd_download_info_feature', array( 'download' ), $feature_args );
	
}

?>