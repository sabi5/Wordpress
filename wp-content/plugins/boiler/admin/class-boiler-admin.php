<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       cedcommerce
 * @since      1.0.0
 *
 * @package    Boiler
 * @subpackage Boiler/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Boiler
 * @subpackage Boiler/admin
 * @author     Sabreen Shakeel <sabreenshakeel@cedcoss.com>
 */
class Boiler_Admin {

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
		 * defined in Boiler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Boiler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/boiler-admin.css', array(), $this->version, 'all' );

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
		 * defined in Boiler_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Boiler_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name.'vgyvy', plugin_dir_url( __FILE__ ) . 'js/boiler-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/custom.js', array( 'jquery' ), $this->version, false );
		wp_localize_script(  $this->plugin_name , 'boiler_ajax_url', array('ajax_url'=>admin_url('admin-ajax.php')) );

	}

	// ADMIN MENU 

	// add_action( 'admin_menu', 'ced_boiler_wporg_options_page' );
	public function ced_boiler_wporg_options_page() {
		add_menu_page(
			'Ced Menu', //menu title
			'Boiler', //menu name
			'manage_options', // capabality
			'boiler', //slug
			array($this,'ced_boiler_wporg_options_page_html'), //function
			0, //position
			5
		);
	
		add_submenu_page(
			'boiler',  // parent slug
			'Subboiler', //menu title
			'Ced Subboiler', //menu name
			'manage_options', // capabality
			'boiler1', //slug
			array($this,'ced_boiler_wporg_options_page_html') //function
		);
	}


	public function ced_boiler_wporg_options_page_html() {
 
		
		$args = array(
            'public' => true,
            '_builtin' => false
            );
            
            $output = 'names'; // 'names' or 'objects' (default: 'names')
            $operator = 'or'; // 'and' or 'or' (default: 'and')
            
            $post_types = get_post_types( $args, $output, $operator );
            
            if ( $post_types ) { // If there are any custom public post types.
                $checked='';  
                ?>
                <form action='' method='post'>
                <?php  
                $posttypes=get_option('meta_option_custom');
            foreach ( $post_types as $post_type ) {
                if($post_type=='wpforms'){
                    continue;
                }
                $checked="";
                if(is_array($posttypes)){
                    if(in_array($post_type,$posttypes)){
                        $checked="checked";
                    } else {
                        $checked="";
                    }
                } else{
                    $checked="";
                }
            ?>
            <br><input name="posttype[]" type="checkbox" class ="all_post" value="<?php echo $post_type; ?>" <?php echo $checked ?> /> <?php echo $post_type ?>
           
            <?php
            }
            
            } 
            
        ?>  
     <input type="button" name="submit_meta_option" id="save" class ="save" value="Save Option for meta box">
     </form>
      <?php 
      
      
    //   require_once('list-table/Class_list_table.php' );
      ?>
    	</div>
    	<?php

		// if(isset($_POST['submit_meta_option'])){
		// 	$option=$_POST['posttype'];
		// 	update_option('meta_option_custom',$option);
		// }
	}


	function meta_ajax_data(){

		$meta_data = array();
		if (isset($_POST['arr'])){
			$meta_data = $_POST['arr'];
			
		}
		$update = update_option('meta_option_custom',$meta_data);
		print_r($meta_data);

		echo "successfully updated";

		// if($update){
		// 	echo "<script>alert('updated successfully')</script>";
		// }
	}



	// CUSTOM META BOX

	public function ced_register_meta(){

		add_meta_box('boil_meta_id', 'Boil meta box', array($this,'ced_boiler_meta'), 'post');

	}

	public function ced_boiler_meta( $post_boiler ) {
		?>
		<label for="wporg_field">Boiler Meta box</label>
		<input type="text" name="wporg_field_boiler" id="wporg_field_boiler" class="postbox" value= "<?php
		 echo get_post_meta( get_the_ID(), 'boiler_meta_key', true );?>">
		
		<?php
	}

	//  SAVING META DATA

	public function boiler_wporg_save_postdata( $post_id ) {
		if ( array_key_exists( 'wporg_field_boiler', $_POST ) ) {
			update_post_meta(
				$post_id,
				'boiler_meta_key',
				$_POST['wporg_field_boiler']
			);
		}
	}
	
	
	
}
