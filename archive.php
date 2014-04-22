<?php
/**
 * @package NLK
 * @subpackage 2.0
 */
wp_enqueue_script( 'nlkFlickr', 'http://api.flickr.com/services/feeds/photos_public.gne?id=93125447@N00&lang=en-us&format=json', array('nlkjs'), 1.0, true );
get_header(); ?>
			<div id="main">

<?php
	/* Queue the first post, that way we know
	 * what date we're dealing with (if that is the case).
	 *
	 * We reset this later so we can run the loop
	 * properly with a call to rewind_posts().
	 */
	if ( have_posts() )
		the_post();
?>

			<h1 class="page-title"><?php if (is_category()) :
single_cat_title(); echo ' Archive';
elseif (is_tag()) :
single_tag_title(); echo ' Archive';
elseif ( is_day() ) :
echo 'Daily Archives: <span>'. get_the_date() .'</span>';
elseif ( is_month() ) :
echo 'Monthly Archives: <span>'. get_the_date('F Y') .'</span>';
elseif ( is_year() ) :
echo 'Yearly Archives: <span>'. get_the_date('Y') .'</span>';
else :
echo 'Blog Archives';
endif; ?></h1>

<?php
	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();

	/* Run the loop for the archives page to output the posts.
	 * If you want to overload this in a child theme then include a file
	 * called loop-archives.php and that will be used instead.
	 */
	 get_template_part( 'loop', 'archive' );
	 
	 
	 
	 get_sidebar('fresht');
?>

			</div>
<div id="right">
<?php get_sidebar('blog'); ?>
</div>
<?php get_footer(); ?>
