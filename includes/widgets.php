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
		
		/* Get version number from EDD version or EDD Software Licence Plugin. */
		$version = get_post_meta( $id, '_edd_sl_version', true );
		
		/* If there is no demo, support, doc link and version, get out of here. */
		if ( empty( $download_demo_link ) && empty( $download_support_link ) && empty( $download_doc_link )&& empty( $version ) )
			return false;

		/* Open the before widget HTML. */
		echo $before_widget;

		/* Output the widget title. */
		if ( $instance['title'] )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;
		
		?>
		
		<ul class="edd-download-info">
		
		<?php
		
		/* If version is set, echo it. */
		if ( !empty( $version ) ) { ?>
			
			<li><?php printf( esc_html__( 'Version: %1$s', 'edd-download-info' ), $version ); ?></li>
		
		<?php }
		
		/* If demo link is set, echo it. */
		if ( !empty( $download_demo_link ) ) { ?>
			
			<li><a href="<?php echo $download_demo_link; ?>" title="<?php _e( 'Demo', 'edd-download-info' ); ?>"><?php _e( 'Demo', 'edd-download-info' ); ?></a></li>
		
		<?php }
		
		/* If suppport forum link is set, echo it. */
		if ( !empty( $download_support_link ) ) { ?>
			
			<li><a href="<?php echo $download_support_link; ?>" title="<?php _e( 'Support', 'edd-download-info' ); ?>"><?php _e( 'Support', 'edd-download-info' ); ?></a></li>
		
		<?php }
		
		/* If documentation link is set, echo it. */
		if ( !empty( $download_doc_link ) ) { ?>
			
			<li><a href="<?php echo $download_doc_link; ?>" title="<?php _e( 'Documentation', 'edd-download-info' ); ?>"><?php _e( 'Documentation', 'edd-download-info' ); ?></a></li>
		
		<?php } ?>
		
		</ul>
		
		<?php
		
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
			'title' => __( 'Download info', 'edd-download-info' )
		) );

		$instance = wp_parse_args( (array) $instance, $defaults );
		
		?>

			<p>
				<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'edd-download-info' ); ?></label>
				<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
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

		/* Open the before widget HTML. */
		echo $before_widget;

		/* Output the widget title. */
		if ( $instance['title'] )
			echo $before_title . apply_filters( 'widget_title',  $instance['title'], $instance, $this->id_base ) . $after_title;
		
		/* Action hook.*/
		do_action( 'edd_before_feature_widget' );
		
		/* Get terms from taxonomy 'edd_download_info_feature'. */
        $features = get_terms( 'edd_download_info_feature' );
		
		/* List features if there is no error. */
		if ( is_wp_error( $features ) ) {
                return;
            } else {
                echo "<ul class=\"edd-download-info-features-widget\">\n";
                
				foreach ( $features as $feature ) {
					if ( $instance['show_download_features_links'] ) {
						echo '<li><a href="' . get_term_link( $feature ) . '" title="' . esc_attr( $feature->name ) . '" rel="bookmark">' . $feature->name . '</a></li>'."\n";
					}
					else {
						echo '<li>' . $feature->name . '</li>'."\n";
					}
				}
				
				
                echo "</ul>\n";
            }
			
		/* Action hook.*/
		do_action( 'edd_after_feature_widget' );
		
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
		$instance['show_download_features_links_links'] = strip_tags( $new_instance['show_download_features_links'] );
		
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