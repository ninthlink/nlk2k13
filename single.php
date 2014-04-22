<?php
/**
 * @package NLK
 * @subpackage 2.0
 */

wp_enqueue_script( 'nlkFlickr', 'http://api.flickr.com/services/feeds/photos_public.gne?id=93125447@N00&lang=en-us&format=json', array('nlkjs'), 1.0, true );
get_header();
?>
	<div id="main">
	<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

		<div <?php post_class() ?> id="post-<?php the_ID(); ?>" name="post-<?php the_ID(); ?>">
			<h2 class="title"><?php the_title(); ?></h2>

			<div class="entry-content">
				<?php the_content('<p class="serif">Read the rest of this entry &raquo;</p>'); ?>

				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>
            </div>

			<div class="meta<?php if(userphoto_exists(get_the_author_meta('ID'))) { ?>">
            	<a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>" class="thm"><?php userphoto_thumbnail(get_the_author_meta( 'ID' ),'','',array('width'=>'42',height=>'47')); ?></a>	<?php } else echo ' nothm">'; ?><div class="inf">
					<?php nlkPostedOn();
					edit_post_link( __( 'Edit', 'twentyten' ), ' <span class="meta-sep"> |</span> <span class="edit-link">', '</span>' );  ?>
                    <?php if ( count( get_the_category() ) ) : ?>
                    <br />Categories: <?php echo nlkCatCleanup($post->ID); ?>
                    <?php endif; ?>
					</div>
					<div class="sha"><?php if (function_exists('sharethis_button')) { ?><?php sharethis_button(); ?><?php } ?>
                    <span class="c sb"><?php comments_popup_link('0', '1', '%' ); ?></span>
                    </div>
			</div>
		</div><!-- #post-## -->

	<?php comments_template(); ?>

	<?php endwhile; else: ?>

		<p>Sorry, no posts matched your criteria.</p>

<?php endif; 
	 
	 if(!in_category('digizines')) {
		 get_sidebar('fresht');
?>

	</div>

<div id="right">
<?php get_sidebar('blog');
	 }
?>
</div>
<?php get_footer(); ?>
