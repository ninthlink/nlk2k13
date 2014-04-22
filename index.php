<?php
/**
 * @package NLK
 * @subpackage 2.0
 */

wp_enqueue_script( 'nlkFlickr', 'http://api.flickr.com/services/feeds/photos_public.gne?id=93125447@N00&lang=en-us&format=json', array('nlkjs'), 1.0, true );
get_header(); ?>
    <div id="main">

    <?php
    /* Run the loop to output the posts.
     * If you want to overload this in a child theme then include a file
     * called loop-index.php and that will be used instead.
     */
     get_template_part( 'loop', 'index' );
	 
	 get_sidebar('fresht');
    ?>
    </div><!-- #content -->
<div id="right">
<?php get_sidebar('blog'); ?>
</div>
<?php get_footer(); ?>
