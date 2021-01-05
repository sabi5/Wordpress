<?php

/**
 * Fired during plugin activation
 *
 * @link       cedcommerce
 * @since      1.0.0
 *
 * @package    Boiler
 * @subpackage Boiler/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Boiler
 * @subpackage Boiler/includes
 * @author     Sabreen Shakeel <sabreenshakeel@cedcoss.com>
 */
class Boiler_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {

	
		// if(!in_array( 'plugin-myplug.php', (array) get_option( 'active_plugins', array() ), true ) ){

		// 	wp_die("plugin not activated");
		// 	deactivate_plugins( 'boiler/boiler.php' );
		// }

		// ADDING PLUGIN CHECK BEFORE ACTIVATION

		if(is_plugin_active('plugin-myplug/plugin-myplug.php')){
			return true;
		}else{
			wp_die('plugin not activated', 'boiler'); // msg and text-domain (in boiler.php)
			deactivate_plugins( 'boiler/boiler.php' );
		}

	}

}
