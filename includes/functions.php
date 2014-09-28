<?php

/**
 * Get purchase and demo link.
 *
 * @return    string
 * @access    private
 * @since     0.1.0
*/

/* Exit if accessed directly. */
if ( ! defined( 'ABSPATH' ) ) exit;

function edd_download_info_purchase_demo_link() {

	/* Get download demo link. */
	$download_demo_link = get_post_meta( get_the_ID(), '_download_demo_link', true );

	/* Get color from edd settings. */
	global $edd_options;
	$color = isset( $edd_options[ 'checkout_color' ] ) ? $edd_options[ 'checkout_color' ] : 'green';
	$style = isset( $edd_options[ 'button_style' ] ) ? $edd_options[ 'button_style' ] : 'button';
	
	if ( ! edd_item_in_cart( get_the_ID() ) ) {
		if ( edd_has_variable_prices( get_the_ID() ) ) {
			echo '<div class="edd-download-info-purchase-link"><a href="' . get_permalink() . '" class="'. $style . ' ' . $color . ' edd-submit">' . __( 'View Details:', 'edd-download-info' ) . ' ' . edd_download_info_the_price( get_the_ID() ) . '</a></div>';
			} else {
			echo '<div class="edd-download-info-purchase-link">' . do_shortcode( '[purchase_link id="' . get_the_ID() . '" text="' . __( 'Add To Cart', 'edd-download-info' ) . '" style="'. $style . ' ' . $color . ' edd-submit"]' ) . '</div>';
				}
		} else {
			echo '<div class="edd-download-info-purchase-link"><a href="' . get_permalink( $edd_options['purchase_page'] ) . '" class="'. $style . ' ' . $color . ' edd-submit edd_go_to_checkout">' . __( 'Checkout', 'edd-download-info' ) . '</a></div>';
		}
		
	/* If demo link is set, echo it. */
	if ( !empty( $download_demo_link ) ) { ?> 
		
		<div class="edd-download-info-demo-link"><a href="<?php echo $download_demo_link; ?>" title="<?php _e( 'Demo', 'edd-download-info' ); ?>" class="<?php echo $style . ' ' . $color . ' edd-submit'; ?>" target=""><?php _e( 'Demo', 'edd-download-info' ); ?></a></div>
		
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

/**
 * Get the Price of download.
 *
 * @author    Digital Store Theme
 * @copyright Copyright (c) 2013, Pippin
 * @link      https://easydigitaldownloads.com/theme/digital-store/
 *
 * Echoes the price with a custom format.
 *
 * @return    string
 * @access    private
 * @since     0.1.8
*/

if ( ! function_exists( 'edd_download_info_the_price' ) ) {
    function edd_download_info_the_price( $download_id ) {
        if ( edd_has_variable_prices( $download_id ) ) {
             $prices = get_post_meta( $download_id, 'edd_variable_prices', true );
             edd_download_info_sort_prices_by( $prices, 'amount' );
             $total = count( $prices ) - 1;
             if ( $prices[0]['amount'] < $prices[$total]['amount'] ) {
                 $min = $prices[0]['amount'];
                 $max = $prices[$total]['amount'];
             } else {
                 $min = $prices[$total]['amount'];
                 $max = $prices[0]['amount'];
             }
             return sprintf( '%s - %s', edd_currency_filter( $min ), edd_currency_filter( $max ) );
         } else {
             return edd_currency_filter( edd_format_amount( edd_get_download_price( $download_id ) ) );
         }
    }
}

/**
 * Sort Prices By
 
 * @author      Digital Store Theme
 * @copyright   Copyright (c) 2013, Pippin
 * @link        https://easydigitaldownloads.com/theme/digital-store/
 *
 * @access      private
 * @since       0.1.8
 * @return      void
*/
if ( ! function_exists( 'edd_download_info_sort_prices_by' ) ) {
    function edd_download_info_sort_prices_by( &$arr, $col ) {
        $sort_col = array();
        foreach ( $arr as $key => $row ) {
            $sort_col[$key] = $row[$col];
        }

        array_multisort( $sort_col, SORT_ASC, $arr );
    }
}