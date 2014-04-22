<?php
/**
 * @package NLK
 * @subpackage 2.0
 *
 * Template Name: Services
 */
get_header(); ?>
	<div id="serv">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<h1><?php the_title(); ?></h1>
				<?php the_content('<p>more...</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php endwhile; endif; ?>
	<?php /* comments_template(); */ ?>
	</div>
<?php
get_sidebar('projects');
get_footer(); ?>