<?php get_header(); ?>

	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<article <?php post_class() ?> id="post-<?php the_ID(); ?>">
			
			<h1 class="entry-title"><?php the_title(); ?></h1>

			<div class="entry-content">
				<?php
				if( has_post_thumbnail() )  {
					the_post_thumbnail();
					//if customized presentation of featured image needed
					//$thumb_id = get_post_thumbnail_id();
					//$thumb_url = wp_get_attachment_image_src($thumb_id,'full', true);
					//echo $thumb_url[0];				
				}
				?>
				
				<?php the_content(); ?>

				<?php wp_link_pages(array('before' => __('Pages: ', 'html5reset'), 'next_or_number' => 'number')); ?>
				
				<?php the_tags( __('Tags: ', 'html5reset'), ', ', ''); ?>
			
				<?php posted_on(); ?>

			</div>
			
			<?php edit_post_link(__('Edit this entry', 'html5reset'),'','.'); ?>
			
		</article>
		<?php comment_form(); ?>
		<?php comments_template(); ?>

	<?php endwhile; endif; ?>

<?php post_navigation(); ?>
	
<?php get_sidebar(); ?>

<?php get_footer(); ?>