<?php 

/**
 * Plugin Name:       meta
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

  // META CUSTOM BOX

  function wporg_add_custom_box() {
      $optionforMeta=get_option('meta_option_custom');
      $screens = [ $optionforMeta];
    foreach ( $screens as $screen ) {
        add_meta_box(
            'wporg_box_id',                 // Unique ID
            'Custom Meta Box Title',      // Box title
            'wporg_custom_box_html',  // Content callback, must be of type callable
            $screen                            // Post type
        );
    }
    // add_option('meta_option_custom','','yes');
}
add_action( 'add_meta_boxes', 'wporg_add_custom_box' );

function wporg_custom_box_html( $post ) {
    ?>
    <label for="wporg_field">Custom Meta box</label>
    <input type="text" name="wporg_field" id="wporg_field" class="postbox" value= "<?php echo $post->_wporg_meta_key;?>">
    
    <?php
}

function wporg_save_postdata( $post_id ) {
    if ( array_key_exists( 'wporg_field', $_POST ) ) {
        update_post_meta(
            $post_id,
            '_wporg_meta_key',
            $_POST['wporg_field']
        );
    }
}
add_action( 'save_post', 'wporg_save_postdata' );


//  Top-level Menus



function ced_wporg_options_page_html() {
     
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
            <br><input name="posttype[]" type="checkbox" value="<?php echo $post_type; ?>" <?php echo $checked ?> /> <?php echo $post_type ?>
           
            <?php
            }
            
            } 
            
        ?>  
     <input type="submit" name="submit_meta_option" value="Save Option for meta box">
     </form>
      <?php 
      
      
      require_once('list-table/Class_list_table.php' );
      ?>
    </div>
    <?php
}


add_action( 'admin_menu', 'ced_wporg_options_page' );

if(isset($_POST['submit_meta_option'])){
$option=$_POST['posttype'];
update_option('meta_option_custom',$option);
}

function ced_wporg_options_page() {
    add_menu_page(
        'Ced Menu', //menu title
        'Meta', //menu name
        'manage_options', // capabality
        'menu', //slug
        'ced_wporg_options_page_html', //function
        0, //position
        5
    );

    add_submenu_page(
        'menu',  // parent slug
        'Submeta', //menu title
        'Ced Submenu1', //menu name
        'manage_options', // capabality
        'submenu1', //slug
        'ced_wporg_options_page_html' //function
    );
}

?>