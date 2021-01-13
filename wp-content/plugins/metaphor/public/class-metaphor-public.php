<?php

// session_start();
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
	 * Description : create a shortcode to display products list
	 * Date : 11-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 *
	 * @return void
	 */
	function ced_shop_page(){

		// PAGINATION FOR CART PAGE

		$loop = new WP_Query( array('posts_per_page'=>3, 'post_type'=>'products','paged' => get_query_var('paged') ? get_query_var('paged') : 1) );

		// print_r($loop);
		// print_r(get_query_var('paged'));

			// print_r(array(
			// 	'current' => max( 1, get_query_var('paged') ),
			// 	'total' => $loop->max_num_pages
			// 	));

		// $loop = new WP_Query( array( 'post_type' => 'products', 'posts_per_page' => 10 ) );
		while ( $loop->have_posts() ) : $loop->the_post();
			the_title('<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' );

		?>

			<div class="entry-content">

				<div class="entry">
												
					<p><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) );?><?php echo the_content();
					
					if((get_post_meta(get_the_ID(), 'price_discount_key', true)) == 0 || (get_post_meta(get_the_ID(), 'price_discount_key', true)) == " " ){
						echo get_post_meta(get_the_ID(), 'price_meta_key', true);
					}else{
						echo get_post_meta(get_the_ID(), 'price_discount_key', true);
					}
					
					?>
				
					</p>

				</div>
				
			</div>

		<?php endwhile;
		echo paginate_links(array(
			'current' => max( 1, get_query_var('paged') ),
			'total' => $loop->max_num_pages
			));

	}

	//    SHORTCODE FOR CART PAGE 
	
	/**
	 * ced_cart_display
	 * 
	 * Description : create a shortcode to display cart list
	 * Date : 8-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 * @return void
	 */
	function ced_cart_display(){
		$user_id = get_current_user_id();

		if(!empty($user_id)){

			// DELETE PRODUCT

			if(isset($_POST['delete'])){
				$user_id = get_current_user_id();
				$user_meta = get_user_meta( $user_id, 'add_cart' , true);
				$id = $_POST['delete'];
				// echo $id;
				if (!empty($user_meta)) {
					foreach ($user_meta as $key => $val) {
						// print_r($val);
						if($val["post_id"] == $id)
						{
							unset($user_meta[$key]);
							
						}
					}
					update_user_meta( $user_id, 'add_cart', $user_meta );
					echo "<script>alert('Product deleted successfully')</script>";
				}
			}

			// UPDATE PRODUCT
			
			if(isset($_POST['edit'])){
				$user_id = get_current_user_id();
				$user_meta = get_user_meta( $user_id, 'add_cart' , true);
				$ids = $_POST['edit'];
				// echo $ids;
				$quantity = $_POST['quantity'];
				// echo $quantity;

				foreach($user_meta as $key=> $value){
					if($ids == $value['post_id']){
						$user_meta[$key]['inventory'] = $quantity ;
					
						// update_user_meta( $user_id, 'add_cart', $user_meta ); 
					
					}
				}
				update_user_meta( $user_id, 'add_cart', $user_meta ); 
				echo "<script>alert('Product updated successfully')</script>";

			}
			// echo $id;
			$user_id = get_current_user_id();
			$user_meta = get_user_meta( $user_id, 'add_cart' , true);
			// $tile =  get_the_title();
			// print_r($user_meta);
			?>
			<table style ="border : 1px solid white">
				<tr>
					<th>ID</th>
					<th>product name</th>
					<th>Image</th>
					<th>price</th>
					<th>Inventory</th>
					<th>Total</th>
					<th>Action</th>
				</tr>
				<?
				// $loop = new WP_Query( array('posts_per_page'=>1, 'post_type'=>'products','paged' => get_query_var('paged') ? get_query_var('paged') : 1) );
				// print_r(get_query_var('paged'));
				foreach($user_meta as $key => $value){
					// print_r($value);?>

					<tr>
						<form method="post">
							<td><?php echo $value['post_id'];?></td>
							<td><?php echo $value['title'];?></td>
							<td><img src="<?php echo $value['image'];?>" style="height : 150px"></td>
							<td><?php echo $value['price'];?></td>
							<td><input type="number" min = "1" name ="quantity" value = "<?php echo $value['inventory'];?>"></td>
							<td><?php echo $value['price'] * $value['inventory'];?></td>
							<td><button type = "submit" name = "delete" value = "<?php echo $value['post_id'];?>">Delete</button></td>
							<td><button type = "submit" name = "edit" value = "<?php echo $value['post_id'];?>">EDIT</button></td>
						</form>
					</tr>

				<?}
				?>
			</table>
			<?

		}else{
			// DELETE PRODUCT

			if(isset($_POST['delete'])){
				$user_id = get_current_user_id();
				// $user_meta = get_user_meta( $user_id, 'add_cart' , true);
				$id = $_POST['delete'];
				// echo $id;
				if (!empty($_SESSION['cart_Array'])) {
					foreach ($_SESSION['cart_Array'] as $key => $val) {
						// print_r($val);
						if($val["post_id"] == $id)
						{
							unset($_SESSION['cart_Array'][$key]);
							
						}
					}
					// update_user_meta( $user_id, 'add_cart', $user_meta );
					echo "<script>alert('Product deleted successfully')</script>";
				}
			}

			// UPDATE PRODUCT
			
			if(isset($_POST['edit'])){
				$user_id = get_current_user_id();
				// $user_meta = get_user_meta( $user_id, 'add_cart' , true);
				$ids = $_POST['edit'];
				// echo $ids;
				$quantity = $_POST['quantity'];
				// echo $quantity;

				foreach($_SESSION['cart_Array'] as $key=> $value){
					if($ids == $value['post_id']){
						$_SESSION['cart_Array'][$key]['inventory'] = $quantity ;
					
						// update_user_meta( $user_id, 'add_cart', $user_meta ); 
					
					}
				}
				// update_user_meta( $user_id, 'add_cart', $user_meta ); 
				echo "<script>alert('Product updated successfully')</script>";

			}
			
			?>
			<table style ="border : 1px solid white">
				<tr>
					<th>ID</th>
					<th>product name</th>
					<th>Image</th>
					<th>price</th>
					<th>Inventory</th>
					<th>Total</th>
					<th>Action</th>
				</tr>
				<?
				
				foreach($_SESSION['cart_Array'] as $key => $value){
					// print_r($value);?>

					<tr>
						<form method="post">
							<td><?php echo $value['post_id'];?></td>
							<td><?php echo $value['title'];?></td>
							<td><img src="<?php echo $value['image'];?>" style="height : 150px"></td>
							<td><?php echo $value['price'];?></td>
							<td><input type="number" min = "1" name ="quantity" value = "<?php echo $value['inventory'];?>"></td>
							<td><?php echo $value['price'] * $value['inventory'];?></td>
							<td><button type = "submit" name = "delete" value = "<?php echo $value['post_id'];?>">Delete</button></td>
							<td><button type = "submit" name = "edit" value = "<?php echo $value['post_id'];?>">EDIT</button></td>
						</form>
					</tr>

				<?}
				?>
			</table>
			<?

		}

	}


	//    SHORTCODE FOR CHECKOUT PAGE 
	
	/**
	 * ced_checkout_display
	 * 
	 * Description : create a shortcode to display checkout page content
	 * Date : 13-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 * @return void
	 */
	function ced_checkout_display(){
		$user_id = get_current_user_id();

		if(!empty($user_id)){

			// DELETE PRODUCT

			if(isset($_POST['delete'])){
				$user_id = get_current_user_id();
				$user_meta = get_user_meta( $user_id, 'add_cart' , true);
				$id = $_POST['delete'];
				// echo $id;
				if (!empty($user_meta)) {
					foreach ($user_meta as $key => $val) {
						// print_r($val);
						if($val["post_id"] == $id)
						{
							unset($user_meta[$key]);
							
						}
					}
					update_user_meta( $user_id, 'add_cart', $user_meta );
					echo "<script>alert('Product deleted successfully')</script>";
				}
			}

			// UPDATE PRODUCT
			
			if(isset($_POST['edit'])){
				$user_id = get_current_user_id();
				$user_meta = get_user_meta( $user_id, 'add_cart' , true);
				$ids = $_POST['edit'];
				// echo $ids;
				$quantity = $_POST['quantity'];
				// echo $quantity;

				foreach($user_meta as $key=> $value){
					if($ids == $value['post_id']){
						$user_meta[$key]['inventory'] = $quantity ;
					
						// update_user_meta( $user_id, 'add_cart', $user_meta ); 
					
					}
				}
				update_user_meta( $user_id, 'add_cart', $user_meta ); 
				echo "<script>alert('Product updated successfully')</script>";

			}
			// echo $id;
			$user_id = get_current_user_id();
			$user_meta = get_user_meta( $user_id, 'add_cart' , true);
			// $tile =  get_the_title();
			// print_r($user_meta);
			?>
			<table style ="border : 1px solid white">
				<tr>
					<th>ID</th>
					<th>product name</th>
					<th>Image</th>
					<th>price</th>
					<th>Inventory</th>
					<th>Total</th>
					<th>Action</th>
				</tr>
				<?
				
				foreach($user_meta as $key => $value){
					// print_r($value);?>

					<tr>
						<form method="post">
							<td><?php echo $value['post_id'];?></td>
							<td><?php echo $value['title'];?></td>
							<td><img src="<?php echo $value['image'];?>" style="height : 150px"></td>
							<td><?php echo $value['price'];?></td>
							<td><input type="number" min = "1" name ="quantity" value = "<?php echo $value['inventory'];?>"></td>
							<td><?php echo $value['price'] * $value['inventory'];?></td>
							<td><button type = "submit" name = "delete" value = "<?php echo $value['post_id'];?>">Delete</button></td>
							<td><button type = "submit" name = "edit" value = "<?php echo $value['post_id'];?>">EDIT</button></td>
						</form>
					</tr>

				<?}
				?>
			</table>
			<?

		}else{
			// DELETE PRODUCT

			if(isset($_POST['delete'])){
				$user_id = get_current_user_id();
				// $user_meta = get_user_meta( $user_id, 'add_cart' , true);
				$id = $_POST['delete'];
				// echo $id;
				if (!empty($_SESSION['cart_Array'])) {
					foreach ($_SESSION['cart_Array'] as $key => $val) {
						// print_r($val);
						if($val["post_id"] == $id)
						{
							unset($_SESSION['cart_Array'][$key]);
							
						}
					}
					// update_user_meta( $user_id, 'add_cart', $user_meta );
					echo "<script>alert('Product deleted successfully')</script>";
				}
			}

			// UPDATE PRODUCT
			
			if(isset($_POST['edit'])){
				$user_id = get_current_user_id();
				// $user_meta = get_user_meta( $user_id, 'add_cart' , true);
				$ids = $_POST['edit'];
				// echo $ids;
				$quantity = $_POST['quantity'];
				// echo $quantity;

				foreach($_SESSION['cart_Array'] as $key=> $value){
					if($ids == $value['post_id']){
						$_SESSION['cart_Array'][$key]['inventory'] = $quantity ;
					
						// update_user_meta( $user_id, 'add_cart', $user_meta ); 
					
					}
				}
				// update_user_meta( $user_id, 'add_cart', $user_meta ); 
				echo "<script>alert('Product updated successfully')</script>";

			}
			
			?>
			<table style ="border : 1px solid white">
				<tr>
					<th>ID</th>
					<th>product name</th>
					<th>Image</th>
					<th>price</th>
					<th>Inventory</th>
					<th>Total</th>
					<th>Action</th>
				</tr>
				<?
				
				foreach($_SESSION['cart_Array'] as $key => $value){
					// print_r($value);?>

					<tr>
						<form method="post">
							<td><?php echo $value['post_id'];?></td>
							<td><?php echo $value['title'];?></td>
							<td><img src="<?php echo $value['image'];?>" style="height : 150px"></td>
							<td><?php echo $value['price'];?></td>
							<td><input type="number" min = "1" name ="quantity" value = "<?php echo $value['inventory'];?>"></td>
							<td><?php echo $value['price'] * $value['inventory'];?></td>
							<td><button type = "submit" name = "delete" value = "<?php echo $value['post_id'];?>">Delete</button></td>
							<td><button type = "submit" name = "edit" value = "<?php echo $value['post_id'];?>">EDIT</button></td>
						</form>
					</tr>

				<?}
				?>
			</table>
			<?

		}

		?>
		<div>
		<button type = "submit" class = "btn btn-primary" name = "delete" value = "<?php echo $value['post_id'];?>">Checkout</button>
		</div>
		<?
	}


	
	/**
	 * ced_guests_login
	 *
	 * Description : checking condition whether guests user login or not
	 * Date : 13-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 * @return void
	 */
	public function ced_guests_login(){

		if ( is_user_logged_in() && !empty($_SESSION['cart_Array'])) {
			$user_id = get_current_user_id();
			echo $user_id;
			update_user_meta( $user_id, 'add_cart', $_SESSION['cart_Array'] ); 
		} 

	}

	
	//  single cart page for products
	
	/**
	 * ced_cart_page
	 *
	 * Description : single page for products when user click on a product item by using 			   					single_template hook
	 * Date : 8-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 * @param  mixed $arg
	 * @return void
	 */

	public function ced_cart_page($arg){

		// print_r($arg);

		if(get_post_type() == 'products' && is_single()){

			return( ABSPATH . 'wp-content/plugins/metaphor/public/partials/cart_page.php' );
		}else{
			return $arg;
		}
	}
	
	
	
}
