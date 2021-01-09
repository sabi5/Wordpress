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
					'post_content'  => '[shop]',
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

	}

	// get_page_by_title

}
