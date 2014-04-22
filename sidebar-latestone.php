<?php
/**
 * @package NLK
 * @subpackage 2.0
 */
?>
<div id="lo">
<h4 class="widgettitle"><a href="<?php echo get_permalink(5677); ?>">BLOG &gt;</a></h4>
<?php
	global $post;
	$myposts = get_posts('numberposts=2');
	foreach($myposts as $post) :
//	echo '<pre style="display:none">'. print_r($post,true) .'</pre>';
	echo '<h3><a href="'. get_permalink() .'">'. nlkSpaceOff(get_the_title(),33) .'</a></h3><p>';
	echo nlkSpaceOff(strip_tags(($post->post_excerpt ? $post->post_excerpt : $post->post_content)), 100);
	echo '<br /><br /><a href="'. get_permalink() .'">Read More</a></p>';
	endforeach;
?>
</div>