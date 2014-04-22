<?php
/**
 * @package NLK
 * @subpackage 2.0
 */

/*
Template Name: Our Work
*/
get_header(); ?>
<?php get_sidebar('projects'); ?>
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php the_content('<p>more...</p>'); ?>
</div>
<div style="float: left; width: 958px; margin: 10px;">
<h1>San Diego Web Design Portfolio</h1>
Ninthlink has an extensive website design portfolio. We have helped hundreds of clients over the past ten years achieve success on the web through creative communications, layout design, photography, illustrations, videos and more. Qualify to be part of our San Diego web design portfolio. We work with all types of business - small, medium and fortune 500.

Call today to become part of our list of San Diego Web Design Portfolio success stories. <a href="http://www.ninthlink.com/contact/">Contact Us Today</a>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
		<?php endwhile; endif; ?>
	<?php edit_post_link('Edit this entry.', '<p>', '</p>'); ?>
</div>
<script type="text/javascript">
jQuery(function() {
var wwhash = '' + window.location.hash;
if(wwhash == '#alex') {
jQuery('#clients').addClass('showa');
}
});
</script>
<style type="text/css">
#clients.showa li.a { background-color: #ff0; }
</style>
<?php
get_footer();
?>