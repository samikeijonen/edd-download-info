<?php
/**
 * Setup Doc Taxonomies
 *
 * Registers the custom taxonomy 'doc' post type.
 *
 * @since 0.1.0

*/

add_action( 'init', 'foxnet_themes_shop_plugin_taxonomies' );

function foxnet_themes_shop_plugin_taxonomies() {
	$doc_category_labels = array(
		'name' 				=> _x( 'Doc Categories', 'taxonomy general name', 'foxnet-themes-shop-plugin' ),
		'singular_name' 	=> _x( 'Doc category', 'taxonomy singular name', 'foxnet-themes-shop-plugin' ),
		'search_items' 		=> __( 'Search Doc Categories', 'foxnet-themes-shop-plugin' ),
		'all_items' 		=> __( 'All Doc Categories', 'foxnet-themes-shop-plugin' ),
		'parent_item' 		=> __( 'Parent Doc Category', 'foxnet-themes-shop-plugin' ),
		'parent_item_colon' => __( 'Parent Doc Category:', 'foxnet-themes-shop-plugin' ),
		'edit_item' 		=> __( 'Edit Doc Categories', 'foxnet-themes-shop-plugin' ), 
		'update_item' 		=> __( 'Update Doc Category', 'foxnet-themes-shop-plugin' ),
		'add_new_item' 		=> __( 'Add New Doc Category', 'foxnet-themes-shop-plugin' ),
		'new_item_name' 	=> __( 'New Doc Category Name', 'foxnet-themes-shop-plugin' ),
		'menu_name' 		=> __( 'Doc Categories', 'foxnet-themes-shop-plugin' ),
	); 	

	$doc_category_args = apply_filters( 'edd_download_info_feature_args', array(
			'hierarchical' 	=> true,
			'labels' 		=> apply_filters( 'foxnet_themes_shop_plugin_doc_labels', $doc_category_labels ),
			'show_ui' 		=> true,
			'query_var' 	=> 'doc_category',
			'rewrite' 		=> array( 'slug' => 'docs/for' )
		)
	);

	register_taxonomy( 'doc_category', array( 'doc' ), $doc_category_args );
	
}

?>