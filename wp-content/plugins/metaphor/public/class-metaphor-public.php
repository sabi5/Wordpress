<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       cedcommerce
 * @since      1.0.0
 *
 * @package    Metaphor
 * @subpackage Metaphor/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Metaphor
 * @subpackage Metaphor/public
 * @author     Sabreen Shakeel <sabreenshakeel@cedcoss.com>
 */
class Metaphor_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/metaphor-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/metaphor-public.js', array( 'jquery' ), $this->version, false );
		

	}

	//    SHORTCODE FOR SHOP PAGE 
	
	/**
	 * ced_shop_page
	 * 
	 * Description : create a shortcode to display product list
	 * Date : 8-01-2020
	 * @since : 1.0.0
	 * @version : 1.0
	 *
	 * @return void
	 */
	function ced_shop_page(){

		$loop = new WP_Query( array( 'post_type' => 'products', 'posts_per_page' => 10 ) );
		while ( $loop->have_posts() ) : $loop->the_post();
			the_title('<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' );

		?>

			<div class="entry-content">

				<div class="entry">
												
				<p><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) );?><?php echo the_content();
				
				
				// echo get_post_meta(get_the_ID(), 'price_meta_key', true);

				if((get_post_meta(get_the_ID(), 'price_discount_key', true)) == 0 || (get_post_meta(get_the_ID(), 'price_discount_key', true)) == " " ){
					echo get_post_meta(get_the_ID(), 'price_meta_key', true);
				}else{
					echo get_post_meta(get_the_ID(), 'price_discount_key', true);
				}
				
				// echo get_post_meta(get_the_ID(), 'price_inventory_key', true);
				
				?>
				<!-- <h1>This is my first product</h1> -->
				</p>

				</div>
				
			</div>

		<?php endwhile;

	}

	//  single page for products

	public function ced_cart_page($arg){

		if(get_post_type() == 'products' && is_single()){

			// die("partial");
			return( ABSPATH . 'wp-content/plugins/metaphor/public/partials/cart_page.php' );

				
			
		}else{
			return $arg;
		}



	}
		
}
