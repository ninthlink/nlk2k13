<?php
/**
 * @package NLK
 * @subpackage 2.0
 */
//wp_enqueue_script( 'nlkTwitterC2', 'http://twitter.com/statuses/user_timeline/ninthlink.json?callback=nlkTwitterC2&amp;count=1', array('nlkjs'), 1.0, true );

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
<?php if(is_page(5679)) { ?>
<div id="right"><?php get_sidebar('team'); ?></div>
<?php
}
//if(!is_page('projects')) {
get_sidebar('bt');
//}
get_footer();
?>
