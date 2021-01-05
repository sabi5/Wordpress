<?php 
   get_template_part("template_part/portfolio", "header");

    // the_title();
    // the_content();
     get_sidebar();

    

    // die("single-port");
?>

    <div class="post">
        <h2 class="title"><a href="<?php the_permalink();?>"><?php the_title();?> </a></h2>
        <p class="meta">Posted by <a href="#"><?php the_author();?></a> on <?php $date= get_the_date();
        echo $date;?>
       
            &nbsp;&bull;&nbsp; <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
        <div class="entry">
        <!-- <h3>Color<?php $id= get_the_ID(); echo $id;$meta_value = get_post_meta($id, '_wporg_meta_key', 1);?><?php echo $meta_value;?></h3> -->
            <p><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) );?><?php echo the_content();
            ?></p>
            

        </div>
    </div>



<?php

    // for comments box
    
    if ( comments_open() || get_comments_number() ) {
		comments_template(); // including comments.php file
    }
    
    // get_comments();
    // get_sidebar();
    get_template_part("template_part/portfolio", "footer");
?>