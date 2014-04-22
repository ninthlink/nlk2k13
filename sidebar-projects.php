<?php
/**
 * @package NLK
 * @subpackage 2.0
 */
if(is_page(6310)) {
	?><div id="clients" class="all"><h2>Featured Projects and Our Client List</h2>
<?php
	$hidemore = false;
} else {
	?><div id="clients"><h2>See some of our recent projects</h2>
<?php
	$hidemore = true;
} ?>
<div class="thms">
<?php
global $post;
$rec = get_posts('numberposts=-1&post_type=page&post_parent=6310&orderby=menu_order&order=ASC');
$i = 0;
foreach( $rec as $post ) {
	echo '<a href="'. get_permalink() .'" class="pthm"';
	if($i++>4 && $hidemore) {
		echo ' style="display:none"';
	}
	echo '>'. get_the_post_thumbnail($post->ID, 'pthm') . the_title('','',false) ."</a>\n";
} ?>
</div>
<?php
/*
if(is_page(array('about','team'))) {
$rec = get_posts('post_type=page&include=6310');
foreach( $rec as $post ) {
	echo $post->post_content;
}
}
*/
?>
<?php if(!is_page(6310)) { ?></div><?php } ?>