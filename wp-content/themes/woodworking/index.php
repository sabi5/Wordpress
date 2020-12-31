
		<?php get_header();?>
		<div id="page">
			<div id="page-bgtop">
				<div id="page-bgbtm">
					<div id="content">
					
					<?php 
					
						if ( have_posts() ) : 
							while ( have_posts() ) : the_post(); 
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
							  endwhile; 
							endif; 
						?>
						
					</div>
					<!-- end #content -->
					<?php get_sidebar();?>
					<div style="clear: both;">&nbsp;</div>
				</div>
			</div>
		</div>
		<!-- end #page -->
		<?php get_footer();?>
