<?php 

/**
 * Plugin Name:       myplug
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.10.3
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sabreen Shakeeel
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */


// code for plugin

function dh_modify_read_more_link() {

    return '<a class="more-link" href="' . get_permalink() . '">Click to Read!</a>';

}

add_filter( 'the_content_more_link', 'dh_modify_read_more_link' );

//  Top-level Menus



function wporg_options_page_html() {
    ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <form action="options.php" method="post">
        <?php
        // output security fields for the registered setting "wporg_options"
        settings_fields( 'wporg_options' );
        // output setting sections and their fields
        // (sections are registered for "wporg", each field is registered to a specific section)
        do_settings_sections( 'wporg' );
        // output save settings button
        submit_button( __( 'Save Settings', 'textdomain' ) );
     
        
        ?>  
      </form>
      <?php 
      
      
      require_once('list-table/Class_list_table.php' );
      ?>
    </div>
    <?php
}


add_action( 'admin_menu', 'wporg_options_page' );

function wporg_options_page() {
    add_menu_page(
        'Ced Menu', //menu title
        'Ced Menu', //menu name
        'manage_options', // capabality
        'menu', //slug
        'wporg_options_page_html', //function
        0, //position
        5
    );

    add_submenu_page(
        'menu',  // parent slug
        'Submenu1', //menu title
        'Ced Submenu1', //menu name
        'manage_options', // capabality
        'submenu1', //slug
        'wporg_options_page_html' //function
    );
}

// Shortcode 

function my_scripts() {
    wp_enqueue_style('bootstrap4', 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css');
    wp_enqueue_script( 'boot1','https://code.jquery.com/jquery-3.3.1.slim.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'boot2','https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js', array( 'jquery' ),'',true );
    wp_enqueue_script( 'boot3','https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js', array( 'jquery' ),'',true );
}
add_action( 'wp_enqueue_scripts', 'my_scripts' );

function first_code(){
?>
    <form method="post">
        <div class="form-group row">
            <label for="username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" id="inputEmail3" placeholder="username" name="username"  required>
            </div>
        </div>
        <br>

        <div class="form-group row">
            <label for="email" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
            <input type="email" class="form-control" id="inputEmail3" placeholder="email" name="email" required>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
            <input type="password" class="form-control" id="inputPassword3" placeholder="Password" name ="password" required>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <label for="mobile" class="col-sm-2 col-form-label">Mobile no. </label>
            <div class="col-sm-10">
            <input type="number" class="form-control" id="inputEmail3" placeholder="mobile no" name ="mobile" required>
            </div>
        </div>
        <br>
        <div class="form-group row">
            <div class="col-sm-10">
            <input type="submit" name ="submit" class="btn btn-primary"></button>
            </div>
        </div>
    </form>
<?php
}

add_shortcode('contact', 'first_code');



// ######  create table when plugin activated  #######


function ced_create_table() {
    global $wpdb;
    
	$table_name = $wpdb->prefix . 'contact';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`username` varchar(255) NOT NULL,
		`email` varchar(255) NOT NULL,
		`mobile` int(255) NOT NULL,
		`password` varchar(255) NOT NULL,
        PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta( $sql );
    
    $table_name = $wpdb->prefix . 'subscription';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql1 = "CREATE TABLE $table_name (
		`id` int(11) NOT NULL AUTO_INCREMENT,
		`post_id` int(255) NOT NULL,
		`email` varchar(255) NOT NULL,
		`date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
		
        PRIMARY KEY  (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql1 );


	
}

register_activation_hook( __FILE__, 'ced_create_table' );


if(isset($_POST['submit'])){

        /**
     * After t f's comment about putting global before the variable.
     * Not necessary (http://php.net/manual/en/language.variables.scope.php)
     */
    global $name, $email, $mobile, $password ;
    $name = $_POST['username'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $password = $_POST['password'];

    ced_insert_data($name, $email, $mobile, $password);
}

if(isset($_POST['subscribe'])){

    /**
 * After t f's comment about putting global before the variable.
 * Not necessary (http://php.net/manual/en/language.variables.scope.php)
 */
global  $email ;

$email = $_POST['email'];

ced_insert_subscribe( $email);
}


function ced_insert_data($name, $email, $mobile, $password) {
    global $wpdb;
    
    $welcome_name = 'Mr. WordPress';
    $welcome_text = 'Congratulations, you just completed the installation!';
    
    $table_name = $wpdb->prefix . 'contact';
    
    $wpdb->insert( 
        $table_name, 
        array( 
            'username' => $name, 
            'email' => $email, 
            'mobile' => $mobile, 
            'password' => $password
        ) 
    );
}

function ced_insert_subscribe( $email) {
    global $wpdb;
    
    $table_name = $wpdb->prefix . 'subscription';
    
    $wpdb->insert( 
        $table_name, 
        array( 
            // 'post_id' => $name, 
            'email' => $email, 
            // 'date' => $mobile, 
            
        ) 
    );
}

// INSERTING DATA INTO POST_META TABLE

if(isset($_POST['subscribe'])){

    $arr = array();
    $email = $_POST['email'];
    $post_id = $_POST['id'];
    // echo $post_id;

    $var = get_post_meta($post_id, 'subscribe_data', 1 );

    if(!empty($var)){
        $var[] = $_POST['email'];
    }else{
        $var = array($_POST['email']);
    }



}


// ########################################################

/* Custom Post Type Start */
function ced_create_posttype() {
    register_post_type( 'Blog',
    // CPT Options
    array(
      'labels' => array(
       'name' => __( 'Blog' ),
       'singular_name' => __( 'Blog123' )
      ),
      'public' => true,
      'has_archive' => false,
      'rewrite' => array('slug' => 'Blog'),
     )
    );
    }
    // Hooking up our function to theme setup
    add_action( 'init', 'ced_create_posttype' );
    /* Custom Post Type End */


    /*Custom Post type start*/
// function ced_cw_post_type_blog() {
//     $supports = array(
//     'title', // post title
//     'editor', // post content
//     'author', // post author
//     'thumbnail', // featured images
//     'excerpt', // post excerpt
//     'custom-fields', // custom fields
//     'comments', // post commenget_postts
//     'revisions', // post revisions
//     'post-formats', // post formats
//     );
//     $labels = array(
//     'name' => _x('Blog', 'plural'),
//     'singular_name' => _x('Blog', 'singular'),
//     'menu_name' => _x('Blog', 'admin menu'),
//     'name_admin_bar' => _x('Blog', 'admin bar'),
//     'add_new' => _x('Add Blog', 'add new'),
//     'add_new_item' => __('Add New blog'),
//     'new_item' => __('New blogs'),
//     'edit_item' => __('Edit blogs'),
//     'view_item' => __('View blogs'),
//     'all_items' => __('All blogs'),
//     'search_items' => __('Search blogs'),
//     'not_found' => __('No blogs found.'),
//     );
//     $args = array(
//     'supports' => $supports,
//     'labels' => $labels,
//     'public' => true,
//     'query_var' => true,
//     'rewrite' => array('slug' => 'blogs'),
//     'has_archive' => true,
//     'hierarchical' => false,
//     );
//     register_post_type('news', $args);
//     }
//     add_action('init', 'ced_cw_post_type_blog');
    /*Custom Post type end*/


 // ##################### widgets

    class wpb_subs extends WP_Widget {
        function __construct() {
        parent::__construct(
        
        // Base ID of your widget
        'wpb_subs',
        
        // Widget name will appear in UI
        __('subscribe now', 'wpb_subs_domain'),
        
        // Widget description
        array( 'description' => __( 'Sample widget based on WPBeginner Tutorial', 'wpb_subs_domain' ), )
        );
        }
        
        // Creating widget front-end
        
        public function widget( $args, $instance ) {
        $title = apply_filters( 'widget_title', $instance['title'] );
        
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];
        if ( ! empty( $title ) )
        
        echo $args['before_title'] . $title . $args['after_title'];
        
        $args = array(
        'public' => true,
        '_builtin' => false
        );


        // Run code only for Single post page
        if ( is_single() ) {

            if(in_array(get_post_type(), $instance['posttype'])){
            ?>
                
                <form method="POST">
                <div>
                <label for="email" >Email: </label>
                <input type="email" placeholder="Enter email" name="email" required>
                </div></br>
                <input type="hidden" name="id" value="<?php echo get_the_ID(); ?>">
                <button type="submit" name="subscribe" class="btn btn-primary">Subscribe</button>
                </form></br>
                <?php
            }
        }

    }
    
        // Widget Backend
        public function form( $instance ) {
        if ( isset( $instance[ 'title' ] ) ) {
        $title = $instance[ 'title' ];
        }
        else {
        $title = __( 'New title', 'wpb_subs_domain' );
        }
        //$instance['posttype'];
        // print_r($instance['posttype']);
        $checked ="";
        // Widget admin form
        ?>
        <?php
       $args = array(
        'public' => true,
        '_builtin' => false
        );
        
        $output = 'names'; // 'names' or 'objects' (default: 'names')
        $operator = 'or'; // 'and' or 'or' (default: 'and')
        
        $post_types = get_post_types( $args, $output, $operator );
        
        if ( $post_types ) { // If there are any custom public post types.
        foreach ( $post_types as $post_type ) {
        if($post_type == "attachment" || $post_type == "wpforms") {
        continue;
        }
        else {
        if(is_array( $instance['posttype'])) {
        if (in_array($post_type, $instance['posttype'])) { //check if Post Type checkbox is checked and display as check if so
        $checked = "checked='checked'";
        }
        else {
        $checked = "";
        }
        } else{
        $checked = "";
        }
        ?>
        <input id="<?php echo $this->get_field_id('posttype') . $post_type; ?>" name="<?php echo $this->get_field_name('posttype[]'); ?>" type="checkbox" value="<?php echo $post_type; ?>" <?php echo $checked ?> /> <?php echo $post_type ?>
        <?php
        }
        
        } ?>
        <p>
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
        </p>
        <?php }
        ?>
        <?php
        }
        
        // Updating widget replacing old instances with new
        public function update( $new_instance, $old_instance ) {
        $instance = array();
        $instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
        $instance['posttype'] = isset( $new_instance['posttype'] ) ? $new_instance['posttype'] : false;
        return $instance;
        }
        
        // Class wpb_widget ends here
        }
        
        // Register and load the widget
        function wpb_subscribe_load_widget() {
        register_widget( 'wpb_subs' );
        }
        add_action( 'widgets_init', 'wpb_subscribe_load_widget' );

       
        
?>