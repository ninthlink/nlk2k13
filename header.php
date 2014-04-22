<?php
/**
 * @package NLK
 * @subpackage 2.0
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>

<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />

<title><?php wp_title('&laquo;', true, 'right'); ?> <?php bloginfo('name'); ?></title>

<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

<?php 
wp_head();
if(is_front_page()) {
?>
<meta name="verify-v1" content="D9nw3Fkvfk3yy5Dbv2c7DORrHuxxkWtFaaCAC9WPftc=" />
<link href="https://plus.google.com/116503819071997610976" rel="publisher" />
<?php
}
?>
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-1147417-6']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
</head>
<body <?php body_class(); ?>>
<div id="page">
<div id="hdr">
<div id="nlk"><a href="<?php echo get_option('home'); ?>/" title="Web Design Company"><?php bloginfo('name'); ?></a></div>
<?php wp_nav_menu( array('menu' => 'topnav', 'container' => '', 'menu_class' => 'nav' )); ?>
<?php
// Check if this is a post or page, if it has a thumbnail, and if it's a big one
if (is_page()) {
	if(has_post_thumbnail( $post->ID ) && !is_front_page()) {
		if(is_page_template('page-shortheader.php') || is_page_template('page-onecolumn.php') || is_page_template('page-ourwork.php')) {
			echo '<div id="sh">'. get_the_post_thumbnail( $post->ID, 'post-thumbnail',array('alt'=>wp_title('',0), 'title'=>'')) .'</div>';
		} elseif(is_page_template('page-pricelist.php')) {
			echo '<div id="bimg">'. get_the_post_thumbnail( $post->ID, 'post-thumbnail',array('alt'=>wp_title('',0), 'title'=>'', 'usemap'=>'#tabMap', 'border'=>'0')) . '</div>';
		} else {
			echo '<div id="bimg">'. get_the_post_thumbnail( $post->ID, 'post-thumbnail',array('alt'=>wp_title('',0), 'title'=>'')) . '</div>';
		}
	}
} elseif(is_home() || is_single() || (is_archive() && !is_author())) {
	echo '<div id="sh">';
	if(is_category('digizines') || (is_single() && in_category('digizines'))) echo '<a href="'. get_bloginfo('url') .'/category/digizines/"><img src="'. get_bloginfo('template_url') .'/images/digizines.jpg" alt="DIGIZINES" /></a>';
	else echo '<a href="'. get_permalink(5677) .'" title="Ninthlink Blog &gt;">'. get_the_post_thumbnail( 5677, 'post-thumbnail',array('alt'=>wp_title('',0), 'title'=>'')) .'</a>';
	echo '</div>';
}
?>
</div>
