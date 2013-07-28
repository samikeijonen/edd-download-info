<?php

/**
 * Get purchase and demo link.
 *
 * @return    string
 * @access    private
 * @since     0.1.0
*/

function edd_download_info_purchase_demo_link() {

	/* Get download demo link. */
	$download_demo_link = get_post_meta( get_the_ID(), '_download_demo_link', true );

	/* Get color from edd settings. */
	global $edd_options;
	$color = isset( $edd_options[ 'checkout_color' ] ) ? $edd_options[ 'checkout_color' ] : 'green';
	$style = isset( $edd_options[ 'button_style' ] ) ? $edd_options[ 'button_style' ] : 'button';
	
	if ( ! edd_item_in_cart( get_the_ID() ) ) {
		if ( edd_has_variable_prices( get_the_ID() ) ) {
			echo '<a href="' . get_permalink() . '" class="'. $style . ' ' . $color . ' edd-submit">' . __( 'View Details:', 'eino' ) . ' ' . eino_edd_the_price( get_the_ID() ) . '</a>';
			} else {
			echo do_shortcode( '[purchase_link id="' . get_the_ID() . '" text="' . __( 'Add To Cart', 'eino' ) . '" style="'. $style . ' ' . $color . ' edd-submit"]' );
				}
		} else {
			echo '<a href="' . get_permalink( $edd_options['purchase_page'] ) . '" class="'. $style . ' ' . $color . ' edd-submit edd_go_to_checkout">' . __( 'Checkout', 'eino' ) . '</a>';
		}
		
	/* If demo link is set, echo it. */
	if ( !empty( $download_demo_link ) ) { ?> 
		
		<a href="<?php echo $download_demo_link; ?>" title="<?php _e( 'Demo', 'edd-download-info' ); ?>" class="<?php echo $style . ' ' . $color . ' edd-submit'; ?>" target=""><?php _e( 'Demo', 'edd-download-info' ); ?></a>
		
	<?php }

}

/**
 * Get demo link.
 *
 * @return    string
 * @access    private
 * @since     0.1.0
*/

function edd_download_info_demo_link() {

	/* Get download demo link. */
	$download_demo_link = get_post_meta( get_the_ID(), '_download_demo_link', true );

	/* Get color from edd settings. */
	global $edd_options;
	$color = isset( $edd_options[ 'checkout_color' ] ) ? $edd_options[ 'checkout_color' ] : 'green';
	$style = isset( $edd_options[ 'button_style' ] ) ? $edd_options[ 'button_style' ] : 'button';
		
	/* If demo link is set, echo it. */
	if ( isset( $download_demo_link ) && !empty( $download_demo_link ) ) { ?> 
		
		<a href="<?php echo $download_demo_link; ?>" title="<?php _e( 'Demo', 'edd-download-info' ); ?>" class="<?php echo $style . ' ' . $color . ' edd-submit'; ?>" target=""><?php _e( 'Demo', 'edd-download-info' ); ?></a>
		
	<?php }

}

/**
 * Check demo link.
 *
 * @return    boolean
 * @access    private
 * @since     0.1.0
*/

function edd_download_info_check_demo_link() {

	/* Get download demo link. */
	$download_demo_link = get_post_meta( get_the_ID(), '_download_demo_link', true );
	
	if ( isset( $download_demo_link ) && !empty( $download_demo_link ) )
		return true;
	else
		return false;

}

?>