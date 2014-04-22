<?php
/**
 * @package NLK
 * @subpackage 2.0
 */
?>
<div id="shm" class="typeface-js fresh">
<?php
global $post;
$myposts = get_posts('numberposts=9');
$firstpost = true;
foreach($myposts as $post) : 
echo '<div'. ($firstpost ? ' class="on"' : '') .'>';
if($firstpost) $firstpost = false;
$title = get_the_title();
echo '<a href="'. get_permalink() .'" title="Read \''. esc_attr($title) .'\'">'. nlkSpaceOff($title,38) .'</a>';
echo '</div>';
endforeach; ?>
</div>