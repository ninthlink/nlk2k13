<?php
/**
 * @package NLK
 * @subpackage 2.0
 *
 * Template Name: Price List
 */
get_header(); ?>
	<div id="main">
		<?php if (have_posts()) : while (have_posts()) : the_post();
		$topmap = get_post_meta($post->ID,'nlk_img_map',true);
		$mayneed = get_post_meta($post->ID,'nlk_may_need',true);
		?>
        	<h1><?php the_title(); ?></h1>
			<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
        	<h3>Chat with a Ninthlink Pro Today : <strong>Call 858-427-1470 or <a href="http://www.ninthlink.com/contact/">Contact Us</a></strong></h3>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); echo $topmap; ?>
	</div>
    <div id="mayn">
    <?php echo $mayneed; ?>
    </div>
</div>
<?php get_footer(); ?>
