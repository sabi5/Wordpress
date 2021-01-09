<?php 

/**
 * Plugin Name:       cpt_plugin
 * Plugin URI:        https://example.com/plugins/the-basics/
 * Description:       Handle the basics with this plugin.
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sabreen Shakeeel
 * Author URI:        https://author.example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       my-basics-plugin
 * Domain Path:       /languages
 */

 //  Top-level Menus

/**
 * ced_wporg_options_page_html
 *
 * @return void
 */
function ced_cpt_wporg_options_page_html() {
     
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
        <!-- <br><input name="posttype[]" type="checkbox" value="<?php echo $post_type; ?>" <?php echo $checked ?> /> <?php echo $post_type ?> -->

        <!-- <form method="POST">
                <div>
                <label for="name" >Name: </label>
                <input type="text" placeholder="Enter name" name="name" required>
                </div></br>
                <input type="hidden" name="id" value="<?php echo get_the_ID(); ?>">
                <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
                </form></br> 
                <?php
       
      
        }
        
        } 
        
    ?>  
    <form method="POST">
                <div>
                <label for="name" >Name: </label>
                <input type="text" placeholder="Enter name" name="name" required>
                </div></br>
                <input type="hidden" name="id" value="<?php echo get_the_ID(); ?>">
                <!-- <button type="submit" name="submit" class="btn btn-primary">Submit</button> -->
                </form></br>
 <input type="submit" name="submit_meta_option" value="Submit">
 </form>
  <?php 
  
  
//   require_once('list-table/Class_list_table.php' );
  ?>
</div>
<?php
}


add_action( 'admin_menu', 'ced_cpt_wporg_options_page' );

// if(isset($_POST['submit_meta_option'])){
// $option=$_POST['posttype'];
// update_option('meta_option_custom',$option);
// }

/**
* ced_wporg_options_page
*
* @return void
*/
function ced_cpt_wporg_options_page() {
add_menu_page(
    'Ced Menu', //menu title
    'cpt menu', //menu name
    'manage_options', // capabality
    'cpt', //slug
    'ced_cpt_wporg_options_page_html', //function
    0, //position
    5
);

add_submenu_page(
    'cpt',  // parent slug
    'Submeta', //menu title
    'Cpt Submenu', //menu name
    'manage_options', // capabality
    'cpt_submenu', //slug
    'ced_cpt_wporg_options_page_html' //function
);
}

?>