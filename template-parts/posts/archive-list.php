<?php if ( have_posts() ) : ?>

<?php
	// Create IDS
	$ids = array();
	while ( have_posts() ) : the_post();
		array_push($ids, get_the_ID());
	endwhile; // end of the loop.
	$ids = implode(',', $ids);
?>

	<?php
	echo flatsome_apply_shortcode( 'blog_posts', array(
		'type'        => 'row',
		'image_width' => '35',
		'depth'       => get_theme_mod( 'blog_posts_depth', 0 ),
		'depth_hover' => get_theme_mod( 'blog_posts_depth_hover', 0 ),
		'text_align'  => get_theme_mod( 'blog_posts_title_align', 'center' ),
		'excerpt_length' => 15,
		'show_category' => 'true',
		'text_pos' => 'top',
		'offset' => '2',
		 'image_hover' => 'zoom',
		'style'       => 'vertical',
		'columns'     => '1',
		'show_date' => 'text', // badge, tex
		'ids'         => $ids,
	) );
	?>

<?php flatsome_posts_pagination(); ?>

<?php else : ?>

	<?php get_template_part( 'template-parts/posts/content','none'); ?>

<?php endif; ?>
