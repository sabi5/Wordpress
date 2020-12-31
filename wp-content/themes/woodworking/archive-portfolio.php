<?php 
/**
* Template Name: Full Width Page
*
* @package WordPress
* @subpackage Twenty_Fourteen
* @since Twenty Fourteen 1.0
*/
get_template_part("template_part/portfolio", "header");

$loop = new WP_Query( array( 'post_type' => 'Portfolio', 'posts_per_page' => 10 ) );
while ( $loop->have_posts() ) : $loop->the_post();
the_title('<h2 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '" rel="bookmark">', '</a></h2>' );


?>

<div class="entry-content">

    <div class="entry">
                                    
    <p><?php the_post_thumbnail( 'thumbnail', array( 'class' => 'alignleft border' ) );?><?php echo the_content();?></p>

    </div>
    
</div>

<?php endwhile;

get_template_part("template_part/portfolio", "footer");

?>