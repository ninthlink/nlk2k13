<?php
/**
 * @package NLK
 * @subpackage 2.0
 */

/*
Template Name: One Column
*/

get_header(); ?>

	<div id="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div id="shm" class="typeface-js"><?php echo get_post_meta($post->ID, 'nlk_short_headline', true); ?></div>
				<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	
	<?php 
		if($post->post_parent ==6310) {
			for($dotwice=2; $dotwice>0; $dotwice--) {
			echo '<a href="../" id="back'. ($dotwice==1 ? 'B' : '') .'">&lt; Back to all Projects</a>';
			//next / prev link http://codex.wordpress.org/Next_and_Previous_Links
			$pagelist = get_pages('sort_column=menu_order&child_of=6310');
			$pages = array();
			foreach ($pagelist as $page) {
			   $pages[] += $page->ID;
			}
			
			$current = array_search($post->ID, $pages);
			$prevID = $pages[$current-1];
			$nextID = $pages[$current+1];
			?>
			
			<div id="snav<?php if($dotwice==1) echo 'B'; ?>">
			<?php if (!empty($prevID)) { ?>
			<a href="<?php echo get_permalink($prevID); ?>" class="p">&lt; Previous <?php echo get_the_title($prevID); ?></a>
			<?php }
			if (!empty($nextID)) { 
				if (!empty($prevID)) echo ' | ';
			?>
			<a href="<?php echo get_permalink($nextID); ?>">Next <?php echo get_the_title($nextID); ?> &gt;</a>
			<?php }
			if($dotwice==2) echo '</div></div>';
			}
		}?>
		<?php endwhile; endif; ?>
	
	</div>

<?php get_footer(); ?>
