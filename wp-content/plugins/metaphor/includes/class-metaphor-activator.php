<?php

/**
 * Fired during plugin activation
 *
 * @link       cedcommerce
 * @since      1.0.0
 *
 * @package    Metaphor
 * @subpackage Metaphor/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Metaphor
 * @subpackage Metaphor/includes
 * @author     Sabreen Shakeel <sabreenshakeel@cedcoss.com>
 */
class Metaphor_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		
		$page_title = get_page_by_title( 'Shop' );
		
		
		if(!$page_title){

			$my_post = array(
				'post_title'    => wp_strip_all_tags( 'Shop' ),
				'post_content'  => 'My custom page content',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			);
		
			// Insert the post into the database
			wp_insert_post( $my_post );
		}

		// CREATING CART PAGE ON PLUGIN ACTIVATION

		$page_cart = get_page_by_title( 'Cart' );

		if(!$page_cart){

			$my_post_cart = array(
				'post_title'    => wp_strip_all_tags( 'Cart' ),
				'post_content'  => 'My custom page content',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			);
		
			// Insert the post into the database
			wp_insert_post( $my_post_cart );
		}

		// CREATING CHECKOUT PAGE ON PLUGIN ACTIVATION

		$page_checkout = get_page_by_title( 'Checkouts' );

		if(!$page_checkout){

			$my_post_checkout = array(
				'post_title'    => wp_strip_all_tags( 'Checkouts' ),
				'post_content'  => 'My custom page content',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			);
		
			// Insert the post into the database
			wp_insert_post( $my_post_checkout );
		}

		//  CREATING THANKYOU PAGE ON PLUGIN ACTIVATION

		$page_thankyou = get_page_by_title( 'Thankyou' );

		if(!$page_thankyou){

			$my_post_thankyou = array(
				'post_title'    => wp_strip_all_tags( 'Thankyou' ),
				'post_content'  => 'My custom page content',
				'post_status'   => 'publish',
				'post_author'   => 1,
				'post_type'     => 'page',
			);
		
			// Insert the post into the database
			wp_insert_post( $my_post_thankyou );
		}



		//   create table when plugin activated

		global $wpdb;
		
		$table_name = $wpdb->prefix . 'orders';
		
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE `orders` (
			`order_id` int(11) NOT NULL AUTO_INCREMENT,
			`user_id` varchar(255) NOT NULL,
			`customer_details` varchar(255) NOT NULL,
			`prod_details` varchar(255) NOT NULL,
			`total_amount` int(255) NOT NULL,
			`payment_method` varchar(255) NOT NULL,
			PRIMARY KEY (`order_id`)
		   ) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
		
	}



}
