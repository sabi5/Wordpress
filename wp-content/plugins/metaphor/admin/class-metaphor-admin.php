<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       cedcommerce
 * @since      1.0.0
 *
 * @package    Metaphor
 * @subpackage Metaphor/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Metaphor
 * @subpackage Metaphor/admin
 * @author     Sabreen Shakeel <sabreenshakeel@cedcoss.com>
 */
class Metaphor_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Metaphor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Metaphor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/metaphor-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Metaphor_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Metaphor_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/metaphor-admin.js', array( 'jquery' ), $this->version, false );

	}


	// CUSTOM POST TYPE	
	/**
	 * ced_wporg_custom_post_type
	 * 
	 * Description : create a custom post type - Products
	 * Date : 8-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 *
	 * @return void
	 */

	function ced_wporg_custom_post_type() {
		register_post_type('products',
		
			array(
				'labels'      => array(
					'name'          => __('Products', 'textdomain'),
					'singular_name' => __('Product', 'textdomain'),
					
				),
				'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions'),
					'public'      => true,
					'has_archive' => true,
					
			)
			
		);
	}
	


	// CUSTOM META BOXE TITLE
	
	/**
	 * ced_register_meta
	 * 
	 * Description : This function is used for registering Meta boxes
	 * Date : 8-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 *
	 * @return void
	 */
	public function ced_register_meta(){

		add_meta_box('boil_price_id', 'Pricing', array($this,'ced_price_meta'), 'products');
		add_meta_box('boil_inventory_id', 'Inventory', array($this,'ced_inventory_meta'), 'products');
		

	}
	
	/**
	 * ced_price_meta
	 * 
	 * Description : This function is used for Meta box layout
	 * Date : 8-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 *
	 * @return void
	 */
	public function ced_price_meta() {
		?>
		<label for="wporg_field">Discounted Price</label>
		<input type="number" name="discount" id="discountbox" min = "0" value = "<?php
		 echo get_post_meta( get_the_ID(), 'price_discount_key', true );?>" >

		 <span id ="error"></span><br>

		<label for="wporg_field">Regular Price</label>
		<input type="number" name="regular" id="regularbox" min = "0" value = "<?php
		 echo get_post_meta( get_the_ID(), 'price_meta_key', true );?>" >
		
		<?php
	}
	
	/**
	 * ced_inventory_meta
	 *	Description : This function is used for Meta box layout
	 * Date : 8-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 * @return void
	 */
	public function ced_inventory_meta() {
		?>
		<label for="wporg_field">Inventory value</label>
		<input type="number" name="inventory" id="wporg_field_boiler" min = "0" class="postbox" value= "<?php
		 echo get_post_meta( get_the_ID(), 'inventory_meta_key', true );?>">
		
		<?php
	}

	//  SAVING META DATA
	
	/**
	 * ced_boiler_wporg_save_postdata
	 * Description : This function is used for Saving Meta box values
	 * Date : 8-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 * 
	 * @param  mixed $post_id - meta box id
	 * @return void
	 */
	
	public function ced_boiler_wporg_save_postdata( $post_id ) {
		if ( array_key_exists( 'inventory', $_POST ) ) {
			update_post_meta(
				$post_id,
				'inventory_meta_key',
				$_POST['inventory']
			);
		}
	}
	
	/**
	 * ced_price_wporg_save_postdata
	 *
	 * Description : This function is used for Saving Meta box values
	 * Date : 8-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 * 
	 * @param  mixed $post_id -> meta box id
	 * @return void
	 */
	
	public function ced_price_wporg_save_postdata( $post_id ) {
		
			if(array_key_exists( 'regular', $_POST ) ){
				update_post_meta(
					$post_id,
					'price_meta_key',
					$_POST['regular']
				);
			}
		
			if ( array_key_exists( 'discount', $_POST ) ) {
				update_post_meta(
					$post_id,
					'price_discount_key',
					$_POST['discount']
				);
			}
		
	}
	

	// 1. CLOTHING CUSTOM TAXONOMIES
	
	/**
	 * ced_wporg_register_taxonomy_clothing
	 *
	 * Description : This function is used for creating taxonomy
	 * Date : 8-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 * 
	 * @return void
	 */
	public function ced_wporg_register_taxonomy_clothing() {
		$labels = array(
			'name'              => _x( 'Product taxonomy', 'taxonomy general name' ),
			'singular_name'     => _x( 'Product taxonomy', 'taxonomy singular name' ),
			'search_items'      => __( 'Search Product taxonomy' ),
			'all_items'         => __( 'All Product taxonomy' ),
			'parent_item'       => __( 'Parent Product taxonomy' ),
			'parent_item_colon' => __( 'Parent Product taxonomy:' ),
			'edit_item'         => __( 'Edit Product taxonomy' ),
			'update_item'       => __( 'Update Product taxonomy' ),
			'add_new_item'      => __( 'Add New Product taxonomy' ),
			'new_item_name'     => __( 'New Product taxonomy Name' ),
			'menu_name'         => __( 'Product taxonomy' ),
		);
		$args   = array(
			'hierarchical'      => true, // make it hierarchical (like categories)
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => [ 'slug' => 'Product taxonomy' ],
		);
		register_taxonomy( 'Product taxonomy', [ 'products' ], $args );
	}

	   
		/**
		* ced_cpt_wporg_options_page_html
		
		* Description : content for custom admin menu 
		* Date : 14-01-2021
		* @since : 1.0.0
		* @version : 1.0
		* 
		* @return void
		*/
		public function ced_cpt_wporg_options_page_html() {
		
			// $args = array(
			// 	'public' => true,
			// 	'_builtin' => false
			// 	);
				
				$output = 'names'; // 'names' or 'objects' (default: 'names')
				$operator = 'or'; // 'and' or 'or' (default: 'and')
			echo "hello";
				require_once('admin/partials/Class_list_table.php' );
		}


	/**
	* ced_cpt_wporg_options_page
	* Description : creating custom admin menu for display orders list 
	* Date : 14-01-2021
	* @since : 1.0.0
	* @version : 1.0
	* @return void
	*/
	public function ced_cpt_wporg_options_page() {
		add_menu_page(
			'Metaphor', //menu title
			'metaphor menu', //menu name
			'manage_options', // capabality
			'meta', //slug
			'ced_cpt_wporg_options_page_html', //function
			0, //position
			5
		);
	}
	   
}
