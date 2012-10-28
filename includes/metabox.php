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

}

?>