<?php
/**
 * @package NLK
 * @subpackage 2.0
 */

/*
Template Name: ShortHeader
*/

get_header(); ?>
	<div id="main">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
        <div id="shm" class="typeface-js"><?php echo get_post_meta($post->ID, 'nlk_short_headline', true); ?></div>
			<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>

            <?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
	</div>
<?php $noside = get_post_meta($post->ID,'nlk_noside',true);
if($noside != 'true') { ?>
<div id="right">
<div class="block com">
<?php if(is_page(5678)) { ?>
<a href="http://goo.gl/maps/1pbO" target="_blank" title="View Map"><img src="<?php bloginfo('template_url'); ?>/images/location.jpg" alt="San Diego, California" /></a>
<p>Address: 3861 Front Street<br />
San Diego, CA 92103 : <a href="http://goo.gl/maps/1pbO" target="_blank">view map</a><br />
Email: <a href="mailto:info@ninthlink.com">info@ninthlink.com</a><br />
Phone: (858) 427 - 1470<br />
Fax: (858) 244 - 7260<br /><br />
Ninthlink - Los Angeles<br />
1040 N. Las Palmas<br />
Building #24 Suite #202<br />
Hollywood CA 90038</p>
<?php } else { ?>
<h3>Common questions we help clients solve every day.</h3>
<ul>
<li>How do we get the most value for our web budget?</li>
<li>How do we drive more traffic, conversion and loyalty?</li>
<li>What should we consider in our site redesign &amp; development?</li>
</ul>
<a href="<?php echo get_permalink(5678); ?>" class="cp">Contact a Pro Today</a>
<?php } ?>
</div>
</div>
<?php } ?>
<?php get_footer(); ?>
