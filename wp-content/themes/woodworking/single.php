<?php 
    get_header();
    get_sidebar();
    // get_comments();
    // the_title();
    // the_content();

?>

    <div class="post">
        <h2 class="title"><a href="<?php the_permalink();?>"><?php the_title();?> </a></h2>
        <p class="meta">Posted by <a href="#"><?php the_author();?></a> on <?php $date= get_the_date();
        echo $date;?>
            &nbsp;&bull;&nbsp; <a href="#" class="comments">Comments (64)</a> &nbsp;&bull;&nbsp; <a href="#" class="permalink">Full article</a></p>
        <div class="entry">
        
            <p><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) );?><?php echo the_content();?></p>

        </div>
    </div>



<?php
// If comments are open or there is at least one comment, load up the comment template.
if ( comments_open() || get_comments_number() ) {
    comments_template();
}
    get_footer();
?>