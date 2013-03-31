<?php

/**
 * EDD Download Info Widget class.
 *
 * @since 0.1.0
 */
class EDD_Download_Info_Widget extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 0.1.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'edd-download-info',
			'description' => esc_html__( 'Display download info.', 'edd-download-info' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350,
			'id_base' => 'edd-download-info'
		);

		/* Create the widget. */
		$this->WP_Widget(
			'edd-download-info',							// $this->id_base
			__( 'Download Info', 'edd-download-info' ),	   	// $this->name
			$widget_options,								// $this->widget_options
			$control_options								// $this->control_options
		);
	}
	
	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.1.0
	 */
	function widget( $args, $instance ) {
		extract( $args );
		
		/* If we are not in singular download page, get out of here. */
		if ( !is_singular( 'download' ) )
			return false;
			
		global $wp_query;
		
		/* Get id of the 'download'. */
		$id = $wp_query->get_queried_object_id();
		
		/* Get download demo link. */
		$download_demo_link = get_post_meta( $id, '_download_demo_link', true );
		
		/* Get support forum link. */
		$download_support_link = get_post_meta( $id, '_download_support_link', true );
		
		/* Get documentation link. */
		$download_doc_link = get_post_meta( $id, '_download_doc_link', true );

		/* Get updated date. */
		$download_updated_date = get_post_meta( $id, '_download_updated_date', true );
		
		/* Get version number from EDD version or EDD Software Licence Plugin. */
		$version = get_post_meta( $id, '_edd_sl_version', true );
		
		/* Get download count. */
		if( function_exists( 'edd_get_download_sales_stats' ) ) {
			$download_count = edd_get_download_sales_stats( $id );
		}
		
		/* If there is no feature image, purchase link, demo, support, doc link, download count or updated date, get out of here. */
		if ( !( $instance['show_feature_image'] && has_post_thumbnail( $id ) ) && !$instance['show_purchase_link'] && ( !$instance['show_demo_link'] || empty( $download_demo_link ) ) && empty( $download_demo_link ) && empty( $download_support_link ) && empty( $download_doc_link ) && ( !$instance['show_download_count'] || empty( $download_count ) ) && empty( $download_updated_date ) )
			return false;

		/* Open the before widget HTML. */
		echo $before_widget;

		/* Output the widget title. */
		if ( $instance['title'] )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;
		
		/* Action hook. */
		do_action( 'edd_download_info_before_widget' );
		
		/* If feature image is set, echo it. */
		if ( $instance['show_feature_image'] && has_post_thumbnail( $id ) ) {
			echo get_the_post_thumbnail( $id, apply_filters( 'edd_download_info_feature_image_size', 'medium' ) );
		}
		
		/* If purchase link is set, echo it. */
		if ( $instance['show_purchase_link'] ) {
			//echo do_shortcode( apply_filters( 'edd_download_info_purchase_link', '[purchase_link id="' . $id . '" text="' . __( 'Purchase', 'edd-download-info' ) . '"]' ) );
			if( function_exists( 'edd_append_purchase_link' ) ) {
				edd_append_purchase_link( $id );
			}
		}
		
		/* Get color from edd settings. */
		global $edd_options;
		$color = isset( $edd_options[ 'edd_download_info_demo_link_style' ] ) ? $edd_options[ 'edd_download_info_demo_link_style' ] : 'green';
		$style = isset( $edd_options[ 'button_style' ] ) ? $edd_options[ 'button_style' ] : 'button';
		
		/* Open demo link in a new window or not. */
		$open = $instance['open_demo_link'] ? '_blank' : '_self';
		
		/* If demo link is set, echo it. */
		if ( $instance['show_demo_link'] && !empty( $download_demo_link ) ) { ?> 
		
			<a href="<?php echo $download_demo_link; ?>" title="<?php _e( 'Demo', 'edd-download-info' ); ?>" class="<?php echo $style . ' ' . $color . ' edd-submit'; ?>" target="<?php echo $open; ?>"><?php _e( 'Demo', 'edd-download-info' ); ?></a>
		
		<?php
		}
		?>
		
		<ul class="edd-download-info">
		
		<?php
		
		/* Action hook. */
		do_action( 'edd_download_info_before_list' );
		
		/* If demo link is set and it is not as button, echo it. */
		if ( !empty( $download_demo_link ) && !$instance['show_demo_link'] ) { ?>
			
			<li><a href="<?php echo $download_demo_link; ?>" title="<?php _e( 'Demo', 'edd-download-info' ); ?>" target="<?php echo $open; ?>"><?php _e( 'Demo', 'edd-download-info' ); ?></a></li>
		
		<?php }
		
		/* If suppport forum link is set, echo it. */
		if ( !empty( $download_support_link ) ) { ?>
			
			<li><a href="<?php echo $download_support_link; ?>" title="<?php _e( 'Support', 'edd-download-info' ); ?>"><?php _e( 'Support', 'edd-download-info' ); ?></a></li>
		
		<?php }
		
		/* If documentation link is set, echo it. */
		if ( !empty( $download_doc_link ) ) { ?>
			
			<li><a href="<?php echo $download_doc_link; ?>" title="<?php _e( 'Documentation', 'edd-download-info' ); ?>"><?php _e( 'Documentation', 'edd-download-info' ); ?></a></li>
		
		<?php }		
		
		/* If version is set, echo it. */
		if ( !empty( $version ) ) { ?>
			
			<li><?php printf( __( '<span class="edd-download-info-version">Version:</span> %1$s', 'edd-download-info' ), $version ); ?></li>
		
		<?php }
		
		/* If download_count is set, echo it. */
		if ( !empty( $download_count ) && $instance['show_download_count'] ) { ?>
			
			<li><?php printf( __( '<span class="edd-download-info-download">Downloads:</span> %1$s', 'edd-download-info' ), $download_count ); ?></li>
		
		<?php }
		
		/* If updated date is set, echo it. */
		if ( !empty( $download_updated_date ) ) { ?>
			
			<li><?php _e( '<span class="edd-download-info-updated">Updated:</span>', 'edd-download-info' ); ?> <?php echo date_i18n( get_option( 'date_format' ), esc_attr( $download_updated_date ) ); ?></li>
		
		<?php } 
		
		/* Action hook. */
		do_action( 'edd_download_info_after_list' );
		
		?>
		
		</ul>
		
		<?php
		
		/* Action hook. */
		do_action( 'edd_download_info_after_widget' );
		
		/* Close the after widget HTML. */
		echo $after_widget;
	}
	
	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 0.1.0
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Set the instance to the new instance. */
		$instance = $new_instance;

		/* Strip tags from elements that don't need them. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_feature_image'] = isset( $new_instance['show_feature_image'] ) ? strip_tags( $new_instance['show_feature_image'] ) : '';
		$instance['show_purchase_link'] = isset( $new_instance['show_purchase_link'] ) ? strip_tags( $new_instance['show_purchase_link'] ) : '';
		$instance['show_demo_link'] = isset( $new_instance['show_demo_link'] ) ? strip_tags( $new_instance['show_demo_link'] ) : '';
		$instance['open_demo_link'] = isset( $new_instance['open_demo_link'] ) ? strip_tags( $new_instance['open_demo_link'] ) : '';
		$instance['show_download_count'] = isset( $new_instance['show_download_count'] ) ? strip_tags( $new_instance['show_download_count'] ) : '';
		
		return $instance;
		
	}
	
	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 0.1.0
	 */
	function form( $instance ) {

		/* Set up the defaults. */
		$defaults = apply_filters( 'edd_download_info_widget_defaults', array(
			'title'    => __( 'Download info', 'edd-download-info' ),
			'show_feature_image' => 1,
			'show_purchase_link' => 1,
			'show_demo_link' => 1,
			'open_demo_link' => 1,
			'show_download_count' => 1
		) );

		$instance = wp_parse_args( (array) $instance, $defaults );
		
		?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'edd-download-info' ); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
			</p>
			
			<p>
				<input type="checkbox" value="1" <?php checked( '1', $instance['show_feature_image'] ); ?> id="<?php echo $this->get_field_id( 'show_feature_image' ); ?>" name="<?php echo $this->get_field_name( 'show_feature_image' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_feature_image' ); ?>"><?php _e( 'Show Feature Image?', 'edd-download-info' ); ?></label> 
			</p>
			
			<p>
				<input type="checkbox" value="1" <?php checked( '1', $instance['show_purchase_link'] ); ?> id="<?php echo $this->get_field_id( 'show_purchase_link' ); ?>" name="<?php echo $this->get_field_name( 'show_purchase_link' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_purchase_link' ); ?>"><?php _e( 'Show purchase link in button?', 'edd-download-info' ); ?></label> 
			</p>
			
			<p>
				<input type="checkbox" value="1" <?php checked( '1', $instance['show_demo_link'] ); ?> id="<?php echo $this->get_field_id( 'show_demo_link' ); ?>" name="<?php echo $this->get_field_name( 'show_demo_link' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_demo_link' ); ?>"><?php _e( 'Show demo link in button?', 'edd-download-info' ); ?></label> 
			</p>
			
			<p>
				<input type="checkbox" value="1" <?php checked( '1', $instance['open_demo_link'] ); ?> id="<?php echo $this->get_field_id( 'open_demo_link' ); ?>" name="<?php echo $this->get_field_name( 'open_demo_link' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'open_demo_link' ); ?>"><?php _e( 'Open demo link in a new window?', 'edd-download-info' ); ?></label> 
			</p>
			
			<p>
				<input type="checkbox" value="1" <?php checked( '1', $instance['show_download_count'] ); ?> id="<?php echo $this->get_field_id( 'show_download_count' ); ?>" name="<?php echo $this->get_field_name( 'show_download_count' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_download_count' ); ?>"><?php _e( 'Show download count?', 'edd-download-info' ); ?></label> 
			</p>
			
		<div style="clear:both;">&nbsp;</div>
	<?php
	}

}

/**
 * EDD Download Features.
 *
 * @since 0.1.0
 */
class EDD_Download_Info_Features_Widget extends WP_Widget {

	/**
	 * Set up the widget's unique name, ID, class, description, and other options.
	 *
	 * @since 0.1.0
	 */
	function __construct() {

		/* Set up the widget options. */
		$widget_options = array(
			'classname' => 'edd-download-info-features',
			'description' => esc_html__( 'Display the downloads features.', 'edd-download-info' )
		);

		/* Set up the widget control options. */
		$control_options = array(
			'width' => 200,
			'height' => 350,
			'id_base' => 'edd-download-info-features'
		);

		/* Create the widget. */
		$this->WP_Widget(
			'edd-download-info-features',					// $this->id_base
			__( 'Download Features', 'edd-download-info' ),	// $this->name
			$widget_options,								// $this->widget_options
			$control_options								// $this->control_options
		);
	}
	
	/**
	 * Outputs the widget based on the arguments input through the widget controls.
	 *
	 * @since 0.1.0
	 */
	function widget( $args, $instance ) {
		extract( $args );
		
		/* If we are not in singular download page, get out of here. */
		if ( !is_singular( 'download' ) )
			return false;
			
		global $wp_query;
		
		/* Get id of the 'download'. */
		$id = $wp_query->get_queried_object_id();
		
		/* Get terms from taxonomy 'edd_download_info_feature'. */
        $features = get_the_terms( $id, 'edd_download_info_feature' );
		
		/* If there is no features, get out of here. */
		if ( empty( $features ) )
			return false;

		/* Open the before widget HTML. */
		echo $before_widget;

		/* Output the widget title. */
		if ( $instance['title'] )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;
		
		/* Action hook.*/
		do_action( 'edd_download_info_before_feature_widget' );
		
		/* Get terms from taxonomy 'edd_download_info_feature'. */
        $features = get_the_terms( $id, 'edd_download_info_feature' );
		
		/* List features if not empty. This is kind of a doublecheck. */
		if ( empty( $features ) ) {
			return;
            } else {
                echo "<ul class=\"edd-download-info-features-widget\">\n";
                
				foreach ( $features as $feature ) {
					if ( $instance['show_download_features_links'] ) {
						echo '<li><a href="' . get_term_link( $feature ) . '" title="' . esc_attr( $feature->name ) . '" rel="bookmark">' . $feature->name . '</a></li>' . "\n";
					}
					else {
						echo '<li>' . $feature->name . '</li>' . "\n";
					}
				}
				
				
                echo "</ul>\n";
            }
			
		/* Action hook.*/
		do_action( 'edd_download_info_after_feature_widget' );
		
		/* Close the after widget HTML. */
		echo $after_widget;
	}
	
	/**
	 * Updates the widget control options for the particular instance of the widget.
	 *
	 * @since 0.1.0
	 */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Set the instance to the new instance. */
		$instance = $new_instance;

		/* Strip tags from elements that don't need them. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['show_download_features_links'] = strip_tags( $new_instance['show_download_features_links'] );
		
		return $instance;
		
	}
	
	/**
	 * Displays the widget control options in the Widgets admin screen.
	 *
	 * @since 0.1.0
	 */
	function form( $instance ) {

		/* Set up the defaults. */
		$defaults = apply_filters( 'edd_download_info_features_defaults', array(
			'title' 						=> __( 'Download Features', 'edd-download-info' ),
			'show_download_features_links'	=> 1
		) );

		$instance = wp_parse_args( (array) $instance, $defaults );
		
		?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'edd-download-info' ); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
			</p>
			
			<p>
				<input type="checkbox" value="1" <?php checked( '1', $instance['show_download_features_links'] ); ?> id="<?php echo $this->get_field_id( 'show_download_features_links' ); ?>" name="<?php echo $this->get_field_name( 'show_download_features_links' ); ?>" />
				<label for="<?php echo $this->get_field_id( 'show_download_features_links' ); ?>"><?php _e( 'Show features as links?' , 'edd-download-info' ); ?></label>
			</p>
			
		<div style="clear:both;">&nbsp;</div>
	<?php
	}

}

/**
 * Register Widgets
 *
 * @since       0.1.0 
*/

function edd_download_info_register_widgets() {
   
    register_widget( 'EDD_Download_Info_Widget' );
    register_widget( 'EDD_Download_Info_Features_Widget' );
 
}

add_action( 'widgets_init', 'edd_download_info_register_widgets' );

?>