<?php

session_start();
// session_destroy();
// session_destroy();
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

	// SHORTCODE FOR SHOP PAGE 
	
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

		$loop = new WP_Query( array('posts_per_page'=>2, 'post_type'=>'products','paged' => get_query_var('page') ? get_query_var('page') : 1) );


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
			'current' => max( 1, get_query_var('page') ),
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
			// $inventory_msg = "";
			if(isset($_POST['edit'])){
				$user_id = get_current_user_id();
				$user_meta = get_user_meta( $user_id, 'add_cart' , true);
				$ids = $_POST['edit'];
				// echo $ids;
				$quantity = $_POST['quantity'];
				// echo $quantity;
				$flag = 0;
				foreach($user_meta as $key=> $value){
					if($ids == $value['post_id']){
						$post_inventory_data = get_post_meta($value['post_id'], 'inventory_meta_key', true );
						print_r($post_inventory_data);
						print_r($user_meta[$key]['inventory']);
						print_r($quantity);

						if($post_inventory_data < $quantity) {
							echo "Oops!.. ".$value['title']. " is out of stock";
							// break;
						}else  {
							$user_meta[$key]['inventory'] = $quantity ;
							$flag = 1;
						}

						// $user_meta[$key]['inventory'] = $quantity ;
					
						// update_user_meta( $user_id, 'add_cart', $user_meta ); 
					
					}
				}
				if($flag == 1){
					update_user_meta( $user_id, 'add_cart', $user_meta ); 
					echo "<script>alert('Product updated successfully')</script>";

				}
				// update_user_meta( $user_id, 'add_cart', $user_meta ); 
				// echo "<script>alert('Product updated successfully')</script>";

			}
			
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

		}?>
		<div>
		
			<!-- <button type = "submit" class = "btn btn-primary" name = "checkout" value = "<?php echo $value['post_id'];?>">Checkout</button> -->
			<button><a href="checkouts" style ="text-decoration : none">Checkout</a></button>
		</div><?

		

	}


	//    SHORTCODE FOR THANKYOU
	
	/**
	 * ced_thankyou_page
	 * 
	 * Description : create a shortcode for thankyou page after checkout
	 * Date : 11-01-2021
	 * @since : 1.0.0
	 * @version : 1.0
	 *
	 * @return void
	 */
	function ced_thankyou_page(){
		$url=home_url();
		?>
		<body>
        <h1>Thanks for Shopping. Your Order is successfully Placed</h1>
        <div>

            <p><a href="<?php echo $url?>">Continue Shopping</a></p>
        </div>
    </body>
	<?
	echo "thanks";
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
				$invent = $user_meta->inventory;

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

			if(isset($_POST['checkout'])){

				$user_id = get_current_user_id();
				$user_meta = get_user_meta( $user_id, 'add_cart' , true);
				$user_meta_db = json_encode($user_meta);
				// print_r($user_meta_db);

				$total_amount = 0;
				foreach($user_meta as $key => $value){
					$total_amount += $value['price'] * $value['inventory'];
				}

				// echo $total_amount;
				
				$name = $_POST['firstname'];
				$email = $_POST['email'];
				$billing_address = $_POST['address'];
				$mobile = $_POST['mobile'];
				$state = $_POST['state'];
				$zip = $_POST['zip'];

				$bill_add = array('address' => $billing_address, 'state' => $state, 'zip' => $zip);
				$bill_add = json_encode($bill_add);
				
				if(isset($_POST['cardname'])){
					$payment_mode = "Cash On Delivery";
				}
				
				if(isset($_POST['sameadr'])){
					$ship_add = $_POST['bill_address'];
					$ship_state = $_POST['bill_state'];
					$ship_zip = $_POST['bill_zip'];
					$shipping_address = array('address' => $ship_add, 'state' => $ship_state, 'zip'=> $ship_zip);
					$shipping_address = json_encode($shipping_address);
					
				}

			
				$customer_details = array('name' => $name, 'email' => $email, 'mobile' => $mobile);
				$customer_details = json_encode($customer_details);
				print_r($customer_details);

				global $wpdb;
    				
				$table_name =  'orders';
				
				$wpdb->insert( 
					$table_name, 
					array( 
						'user_id' => $user_id, 
						'customer_details' => $customer_details, 
						'prod_details' => $user_meta_db, 
						'billing_address' => $bill_add,
						'shipping_address' => $shipping_address, 
						'total_amount' => $total_amount, 
						'payment_method' => 'cash on delivery'
						
					) 
				);

				
				$current_user_meta = get_user_meta( $user_id, 'add_cart' , true);

				foreach($current_user_meta as $key => $value){
					$current_product_inventory = get_post_meta($value['post_id'], 'inventory_meta_key', true );
					
					$current_product_inventory -= $value['inventory'];
					// print_r($current_product_inventory);

					// Update inventory after checkout
					update_post_meta($value['post_id'], 'inventory_meta_key', $current_product_inventory);

				}

				// Empty user_meta data after checkout 

				$meta = array();
				update_user_meta( $user_id, 'add_cart', $meta );

				echo '<script>location.replace("thankyou");</script>';

				// $current_inventory = 
				// $update_inventory = 



			}
		
			$user_id = get_current_user_id();
			$user_meta = get_user_meta( $user_id, 'add_cart' , true);
			

			 foreach($user_meta as $key => $value){
			?>

				<div class="card col-25" style="width: 18rem;">
					<div class="container card-body">
						<h4 class = "card-title">Cart Details
							<span class="price" style="color:black">
								<i class="fa fa-shopping-cart"></i>
								<b><p>Product ID : <?php echo $value['post_id'];?></p></b>
							</span>
						</h4>

						<p>Product name : <?php echo $value['title'];?></p>
						<p>Price : <?php echo $value['price'];?></p>
						<p>Quantity : <?php echo $value['inventory'];?></p>
				
						<hr>
						<p>Total <span class="price" style="color:black"><b>$<?php echo $value['price'] * $value['inventory'];?></b></span></p>
					</div>
			 	</div>
				 <br>
			 <?php }

				?>

			<!-- CHECKOUT FORM -->

			<div class="row">
				<div class="col-75">
					<div class="container">
						<form method ="post">
							<div class="row">
								<div class="col-50">
									<h3>Billing Address</h3>
									<label for="fname"><i class="fa fa-user"></i> Full Name</label>
									<input onkeypress="return /^[a-zA-Z ]*$/.test(event.key)" type="text" id="fname" name="firstname" placeholder="John M. Doe">
									<label for="email"><i class="fa fa-envelope"></i> Email</label>
									<input type="email" id="email" name="email" placeholder="john@example.com">
									<label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
									<input type="text" id="address" name="address" placeholder="542 W. 15th Street">
									
									<label for="mobile"><i class="fa fa-institution"></i> Mobile no.</label>
									<input type="number" id="ship_mobile" name="mobile" placeholder="ex. 123"  min ="0" maxlength = "10">

									<div class="row">
										<div class="col-50">
											<label for="state">State</label>
											<input type="text" id="state" name="state" placeholder="NY">
										</div>
										<div class="col-50">
											<label for="zip">Zip</label>
											<input type="text" id="zip" name="zip" placeholder="10001" min = "6" max = "6">
										</div>
									</div>

									<h3>Shipping Address</h3>
									
									<label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
									<input type="text" id="ship_address" name="bill_address" placeholder="542 W. 15th Street">
									

									<div class="row">
										<div class="col-50">
											<label for="state">State</label>
											<input type="text" id="ship_state" name="bill_state" placeholder="NY">
										</div>
										<div class="col-50">
											<label for="zip">Zip</label>
											<input type="text" id="ship_zip" name="bill_zip" placeholder="10001" min = "6" max = "6">
										</div>
									</div>
								</div>

								<div class="col-50">
									<h3>Payment mode</h3>
									
									<label for="cname">Cash on delivery</label>
									<input type="radio" id="cname" name="cardname" placeholder="John More Doe">
								</div>
							</div>
							<label>
								<input type="checkbox" id ="check" name="sameadr"> Shipping address same as billing
							</label>
							<input type="submit" value="Continue to checkout" name ="checkout" >
							
						</form>
					</div>
				</div>
			</div>
			<?
		}else{

			if(isset($_POST['checkout'])){

				$user_id = get_current_user_id();
				// $user_meta = get_user_meta( $user_id, 'add_cart' , true);
				$user_meta = $_SESSION['cart_Array'];
				$user_meta_db = json_encode($user_meta);
				print_r($user_meta_db);

				$total_amount = 0;
				foreach($_SESSION['cart_Array'] as $key => $value){
					$total_amount += $value['price'] * $value['inventory'];
				}

				echo $total_amount;
				
				$name = $_POST['firstname'];
				$email = $_POST['email'];
				$billing_address = $_POST['address'];
				$mobile = $_POST['mobile'];
				$state = $_POST['state'];
				$zip = $_POST['zip'];

				$bill_add = array('address' => $billing_address, 'state' => $state, 'zip' => $zip);
				$bill_add = json_encode($bill_add);
				
				if(isset($_POST['cardname'])){
					$payment_mode = "Cash On Delivery";
				}
				
				if(isset($_POST['sameadr'])){
					$ship_add = $_POST['bill_address'];
					$ship_state = $_POST['bill_state'];
					$ship_zip = $_POST['bill_zip'];
					$shipping_address = array('address' => $ship_add, 'state' => $ship_state, 'zip'=> $ship_zip);
					$shipping_address = json_encode($shipping_address);
					
				}

			
				$customer_details = array('name' => $name, 'email' => $email, 'mobile' => $mobile);
				$customer_details = json_encode($customer_details);
				print_r($customer_details);

				global $wpdb;
    				
				$table_name =  'orders';
				
				$check = $wpdb->insert( 
					$table_name, 
					array( 
						'user_id' => $user_id, 
						'customer_details' => $customer_details, 
						'prod_details' => $user_meta_db, 
						'billing_address' => $bill_add,
						'shipping_address' => $shipping_address, 
						'total_amount' => $total_amount, 
						'payment_method' => 'cash on delivery'
						
					) 
				);

				
				// $current_user_meta = get_user_meta( $user_id, 'add_cart' , true);

				foreach($_SESSION['cart_Array'] as $key => $value){
					$current_product_inventory = get_post_meta($value['post_id'], 'inventory_meta_key', true );
					
					$current_product_inventory -= $value['inventory'];
					print_r($current_product_inventory);
					update_post_meta($value['post_id'], 'inventory_meta_key', $current_product_inventory);

				}
				if($check){
					$meta = array();
					update_user_meta( $user_id, 'add_cart', $meta );

					echo '<script>location.replace("thankyou");</script>';
				}
				

			}
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
			foreach($_SESSION['cart_Array'] as $key => $value){
				?>
	
				<div class="card col-25" style="width: 18rem;">
					<div class="container card-body">
						<h4 class = "card-title">Cart Details
							<span class="price" style="color:black">
								<i class="fa fa-shopping-cart"></i>
								<b><p>Product ID : <?php echo $value['post_id'];?></p></b>
							</span>
						</h4>

						<p>Product name : <?php echo $value['title'];?></p>
						<p>Price : <?php echo $value['price'];?></p>
						<p>Quantity : <?php echo $value['inventory'];?></p>
				
						<hr>
						<p>Total <span class="price" style="color:black"><b>$<?php echo $value['price'] * $value['inventory'];?></b></span></p>
					</div>
				</div>
				<br>
			<?php }

			?>
			<!-- CHECKOUT FORM -->

			<div class="row">
				<div class="col-75">
					<div class="container">
						<form method ="post">
							<div class="row">
								<div class="col-50">
									<h3>Billing Address</h3>
									<label for="fname"><i class="fa fa-user"></i> Full Name</label>
									<input onkeypress="return /^[a-zA-Z ]*$/.test(event.key)" type="text" id="fname" name="firstname" placeholder="John M. Doe">
									<label for="email"><i class="fa fa-envelope"></i> Email</label>
									<input type="email" id="email" name="email" placeholder="john@example.com">
									<label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
									<input type="text" id="address" name="address" placeholder="542 W. 15th Street">
									
									<label for="mobile"><i class="fa fa-institution"></i> Mobile no.</label>
									<input type="number" id="ship_mobile" name="mobile" placeholder="ex. 123"  min ="0" maxlength = "10">

									<div class="row">
										<div class="col-50">
											<label for="state">State</label>
											<input type="text" id="state" name="state" placeholder="NY">
										</div>
										<div class="col-50">
											<label for="zip">Zip</label>
											<input type="text" id="zip" name="zip" placeholder="10001" min = "6" max = "6">
										</div>
									</div>

									<h3>Shipping Address</h3>
									
									<label for="adr"><i class="fa fa-address-card-o"></i> Address</label>
									<input type="text" id="ship_address" name="bill_address" placeholder="542 W. 15th Street">
									

									<div class="row">
										<div class="col-50">
											<label for="state">State</label>
											<input type="text" id="ship_state" name="bill_state" placeholder="NY">
										</div>
										<div class="col-50">
											<label for="zip">Zip</label>
											<input type="text" id="ship_zip" name="bill_zip" placeholder="10001" min = "6" max = "6">
										</div>
									</div>
								</div>

								<div class="col-50">
									<h3>Payment mode</h3>
									
									<label for="cname">Cash on delivery</label>
									<input type="radio" id="cname" name="cardname" placeholder="John More Doe">
								</div>
							</div>
							<label>
								<input type="checkbox" id ="check" name="sameadr"> Shipping address same as billing
							</label>
							<input type="submit" value="Continue to checkout" name ="checkout" >
							
						</form>
					</div>
				</div>
			</div>
			
			<?
		}
		
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

		if ( is_user_logged_in() == true && !empty($_SESSION['cart_Array'])) {
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
