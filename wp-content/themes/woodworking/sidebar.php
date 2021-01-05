<div id="sidebar">
	<div id="search">
	<h3>Color <p><?php $id= get_the_ID(); echo $id; $meta_value = get_post_meta($id, '_wporg_meta_key', true);?><?php echo $meta_value;?></p></h3>
		<h2>Search</h2>
		<form method="get" action="">
			<fieldset>
				<input type="text" name="s" id="search-text" size="15" value="enter keywords here..." />
				<input type="submit" id="search-submit" value="GO" />
			</fieldset>
		</form>
	</div>
	<?php dynamic_sidebar('sidebar-1');?>

</div>
<!-- end #sidebar -->