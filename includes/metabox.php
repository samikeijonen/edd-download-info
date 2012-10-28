<?php

/* Add custom meta box for 'download' */
add_action( 'add_meta_boxes', 'edd_download_info_create_meta_boxes' );

/* Save metabox data. */
add_action( 'save_post', 'edd_download_info_save_meta_boxes', 10, 2 );


/**
 * Add Download Info Meta Box.
 *
 * @since 0.1
 */
function edd_download_info_create_meta_boxes() {

	add_meta_box( 'edd_download_info_metabox', esc_html__( 'Download Info', 'edd-download-info' ), 'edd_download_info_class_meta_box', 'download', 'side', 'core' );

}

/**
 * Display the download info meta box.
 *
 * @since 0.1
 */
function edd_download_info_class_meta_box( $object, $box ) { ?>

	<?php wp_nonce_field( basename( __FILE__ ), 'edd_download_info_meta_box_nonce' ); ?>
	
	<?php do_action( 'edd_download_info_before_link_fields', $object->ID ); // Add action hook before output. ?>

	<p>
		<label for="download_demo_link"><?php _e( "Add demo URL.", 'edd-download-info' ); ?></label>
		<br />
		<input class="widefat" type="text" name="download_demo_link" id="download_demo_link" value="<?php echo esc_attr( get_post_meta( $object->ID, '_download_demo_link', true ) ); ?>" size="30" />
	</p>
	
	<p>
		<label for="download_support_link"><?php _e( "Add forum support URL.", 'edd-download-info' ); ?></label>
		<br />
		<input class="widefat" type="text" name="download_support_link" id="download_support_link" value="<?php echo esc_attr( get_post_meta( $object->ID, '_download_support_link', true ) ); ?>" size="30" />
	</p>
	
	<p>
		<label for="download_doc_link"><?php _e( "Add document URL.", 'edd-download-info' ); ?></label>
		<br />
		<input class="widefat" type="text" name="download_doc_link" id="download_doc_link" value="<?php echo esc_attr( get_post_meta( $object->ID, '_download_doc_link', true ) ); ?>" size="30" />
	</p>
	
	<?php do_action( 'edd_download_info_after_link_fields', $object->ID ); // Add action hook after output. ?>
	
	<p><strong><?php _e( 'Download Features', 'edd-download-info' )?></strong></p>
	
	<?php
	
	/* Get download features. */
	$download_features = edd_download_info_get_download_features();
	
	?>
	
	<ul>
	<?php
	/* Sort download features in case-insensitive ordering. */
	//sort( $download_features, SORT_NATURAL | SORT_FLAG_CASE );
	
	foreach ( $download_features as $feature_key => $feature_value ) { ?>
		<li><input type="checkbox" name="<?php echo esc_attr( $feature_key ); ?>" id="<?php echo esc_attr( $feature_key ); ?>" value="<?php echo esc_attr( $feature_key ); ?>" <?php checked( esc_attr( get_post_meta( $object->ID, '_download_feature_' . $feature_key , true ) ), $feature_key ); ?> /> <label for="<?php echo esc_attr( $feature_key ); ?>"><?php echo esc_attr( $feature_value ); ?></label></li>
	<?php } ?>
	</ul>
	
	<?php do_action( 'edd_download_info_after_download_features', $object->ID ); // Add action hook after download features. ?>
	
	<?php
}

/**
 * Save data from download info meta box.
 *
 * @since 0.1
 */
function edd_download_info_save_meta_boxes( $post_id, $post ) {

	/* Verify the nonce before proceeding. */
	if ( !isset( $_POST['edd_download_info_meta_box_nonce'] ) || !wp_verify_nonce( $_POST['edd_download_info_meta_box_nonce'], basename( __FILE__ ) ) )
		return $post_id;
		
	/* Check autosave. */
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )
		return $post_id;

	/* Get the post type object. */
	$post_type = get_post_type_object( $post->post_type );

	/* Check if the current user has permission to edit the post. */
	if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
		return $post_id;
		
	/* Get meta keys links in an array and save. */
	$download_meta_info_all = apply_filters( 'edd_download_info_metabox_fields_save', array(
			'download_demo_link',
			'download_support_link', 
			'download_doc_link' 
		)
	);
	
	/* Loop through all the links. */
	foreach ( $download_meta_info_all as $download_meta_info ) {

		/* Get the posted data and sanitize it for use as an link. */
		$new_meta_value = ( isset( $_POST[ $download_meta_info ] ) ? esc_url_raw( $_POST[ $download_meta_info ] ) : '' );

		/* Get the meta key like this: _download_demo_link. */
		$meta_key = '_' . $download_meta_info;

		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );

		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );
	
	}

	/* Loop through all the download feaures. */
	
	/* Get download features. */
	$download_features = edd_download_info_get_download_features();
	
	foreach ( $download_features as $feature_key => $feature_value ) {
			
		/* Get the posted data and sanitize it for use as an link. */
		$new_meta_value = ( isset( $_POST[ $feature_key ] ) ? esc_html( $_POST[ $feature_key ] ) : '' );

		/* Get the meta key like this: _download_feature_bbpress. */
		$meta_key = '_download_feature_' . $feature_key;

		/* Get the meta value of the custom field key. */
		$meta_value = get_post_meta( $post_id, $meta_key, true );

		/* If a new meta value was added and there was no previous value, add it. */
		if ( $new_meta_value && '' == $meta_value )
			add_post_meta( $post_id, $meta_key, $new_meta_value, true );

		/* If the new meta value does not match the old value, update it. */
		elseif ( $new_meta_value && $new_meta_value != $meta_value )
			update_post_meta( $post_id, $meta_key, $new_meta_value );

		/* If there is no new meta value but an old value exists, delete it. */
		elseif ( '' == $new_meta_value && $meta_value )
			delete_post_meta( $post_id, $meta_key, $meta_value );
			
	}

}

/**
 * Get array of download features.
 *
 * @since 0.1
 */
function edd_download_info_get_download_features() {
	
	/* List download features. */
	$download_features = apply_filters( 'edd_download_info_features', array(
			'bbpress' => __( 'bbPress', 'edd-download-info' ),
			'breadcrumbs' => __( 'Breadcrumbs', 'edd-download-info' ),
			'custom-background' => __( 'Custom Background', 'edd-download-info' ),
			'custom-header' => __( 'Custom Header', 'edd-download-info' ),
			'customize' => __( 'Customize', 'edd-download-info' ),
			'editor-style' => __( 'Editor Style', 'edd-download-info' ),
			'featured-image-header' => __( 'Featured Image Header', 'edd-download-info' ),
			'featured-images' => __( 'Featured Images', 'edd-download-info' ),
			'nav-menus' => __( 'Nav Menus', 'edd-download-info' ),
			'page-templates' => __( 'Page Templates', 'edd-download-info' ),
			'post-formats' => __( 'Post Formats', 'edd-download-info' ),
			'post-stylesheets' => __( 'Post Stylesheets', 'edd-download-info' ),
			'sticky-posts' => __( 'Sticky Posts', 'edd-download-info' ),
			'download-layouts' => __( 'Download Layouts', 'edd-download-info' ),
			'download-options' => __( 'Download Options', 'edd-download-info' ),
			'threaded-comments' => __( 'Threaded Comments', 'edd-download-info' ),
			'translation-ready' => __( 'Translation Ready', 'edd-download-info' )		
		)
	);
	
	return $download_features;
	
}

?>