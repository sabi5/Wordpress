<?php 
    get_header();
    // get_sidebar();
    // get_comments();
    // the_title();
    // the_content();
    // die("single");

?>

    <table>
        <tr>
            <th>Title</th>
            <th>Product</th>
            <th>Description</th>
            <th>Inventory</th>
            <th>Price</th>
        </tr>

        <tr>
            <td>
            <div class="post">
            <h2 class="title"><a href="<?php the_permalink();?>"><?php the_title();?> </a></h2>
            <p class="meta">Posted by <a href="#"><?php the_author();?></a> on <?php $date= get_the_date();
            echo $date;?>
                &nbsp;&bull;&nbsp; <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
                </td>

            <td>
            <div class="entry">
            
                <p><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) );?><?php echo the_content();?></p>
            
            </div>
            </td>
       
        
            </div>
        
    

    <!-- <div class="post">
        <h2 class="title"><a href="<?php the_permalink();?>"><?php the_title();?> </a></h2>
        <p class="meta">Posted by <a href="#"><?php the_author();?></a> on <?php $date= get_the_date();
        echo $date;?>
            &nbsp;&bull;&nbsp; <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
        <div class="entry">
        
            <p><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) );?><?php echo the_content();?></p>
           
        </div> -->
        
    </div>

    <td>
        <?php 
        if((get_post_meta(get_the_ID(), 'price_discount_key', true)) == 0 || (get_post_meta(get_the_ID(), 'price_discount_key', true)) == " " ){
					echo get_post_meta(get_the_ID(), 'price_meta_key', true);
				}else{
					echo get_post_meta(get_the_ID(), 'price_discount_key', true);
                }
        ?><br></td>
       
        <td><h1>This is my first page</h1></td>
        <td>
            <?php
            echo get_post_meta(get_the_ID(), 'inventory_meta_key', true);
        ?></td>
        </tr>
        
    <td>
    <p>
        <input type="submit" name = "add_to_cart" value = "Add To Cart">
    </p></td>
    </table>



<?php
// If comments are open or there is at least one comment, load up the comment template.
// if ( comments_open() || get_comments_number() ) {
//     comments_template();
// }
    get_footer();
?>