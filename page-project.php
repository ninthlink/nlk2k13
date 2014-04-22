<?php
/**
 * @package NLK
 * @subpackage 2.0
 *
 * Template Name: The Project
 */
get_header(); ?>
	<div id="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
				<?php the_content('<p>more...</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	<?php /* comments_template(); */ ?>
	</div>
<div id="right" class="request"><?php dynamic_sidebar('appt'); ?></div>
<?php
get_sidebar('projects');
get_footer();
?>
