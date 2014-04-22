<?php
/**
 * @package NLK
 * @subpackage 2.0
 */
get_header(); ?>
	<div id="main" class="home">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<div class="post" id="post-<?php the_ID(); $homeid = $post->ID; ?>">
			<div class="entry">
<h1>Interactive Agency Producing High Performance Websites</h1>
<h2>Established in 2000. Our team produces measurable results for clients; promoting and growing them online through design, development, and marketing strategies.  Our proven process has been developed to provide reliable and measurable results across your website traffic campaigns, website conversion & customer loyalty programs.  Ninthlink is an experienced and savvy team of professionals dedicated to getting real results from your website.  If your website needs a shot of marketing adrenaline, we have the juice that is worth the squeeze.  Call us today at 858-427-1470 for a Free Website Analysis & Consultation. <a href="/contact/" title="Get Started">Let's Get Started ></a></h2>
<div id="steps">
<div><h3>Website Design</h3>
<p>Ninthlink designers are ready to listen to your business needs and create websites, emails, facebook pages, and more.<br /><br /><a href="<?php echo get_permalink(5683); ?>#website-design">Get Started ></a></p></div>
<div><h3>Website Programming</h3>
<p>Ninthlink programmers are experienced in developing software and databases to meet all your business requirements.<br /><br /><a href="<?php echo get_permalink(5683); ?>#web-programming">Learn More ></a></p></div>
<div><h3>Internet Marketing</h3>
<p>Ninthlink marketing teams have the ability to drive high quality traffic and conversion to your products &amp; services.<br /><br /><a href="<?php echo get_permalink(5683); ?>#internet-marketing">Learn More ></a></p></div>
</div>
<?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
				<?php wp_link_pages(array('before' => '<p><strong>Pages:</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>

	<?php /* edit_post_link('Edit this entry.', '<p>', '</p>'); */ ?>
			</div>
		</div>
		<?php endwhile; endif; ?>
	
	<?php /* comments_template(); */ ?>
	
<?php get_sidebar('latestone'); ?>
<div style="display:none">
<!--NetworkedBlogs Start--><style type="text/css"><!--.networkedblogs_widget a {text-decoration:none;color:#3B5998;font-weight:normal;}.networkedblogs_widget .networkedblogs_footer a {text-decoration:none;color:#FFFFFF;font-weight:normal;}--></style><div id='networkedblogs_container' style='height:180px;padding-top:20px;'><div id='networkedblogs_above'></div><div id='networkedblogs_widget' style="width:120px;margin:0px auto;padding:0px 0px 3px 0px;font-family:'lucida grande',tahoma,Verdana,Arial,Sans-Serif;font-size:11px;font-weight:normal;text-decoration:none;background:#3B5998 none repeat scroll 0% 0%;border:none;line-height:13px;"><div id='networkedblogs_header' style="padding:1px 1px 2px 3px;text-align:left;"><a href='http://www.facebook.com/apps/application.php?id=9953271133' style="text-decoration:none;color:#FFFFFF;font-weight:normal;font-size:11px;background-repeat:no-repeat;">NetworkedBlogs</a></div><div id='networkedblogs_body' style="background-color:#FFFFFF;color:#444444;padding:4px;border-left:1px solid #D8DFEA;border-right:1px solid #D8DFEA;text-align:left;"><table cellpadding="0" cellspacing="0"><tr><td><span style="color:#777777;">Blog:</span></td></tr><tr><td><a target="_blank" href="http://networkedblogs.com/blog/ninthlink_inc/" style="text-decoration:none;color:#3B5998;">Ninthlink, Inc</a></td></tr><tr><td><div style="padding:0px;padding-top:5px;color:#777777;">Topics:</div></td></tr><tr><td><a target='_blank' href='http://networkedblogs.com/topic/Web+Design' style='text-decoration:none;color:#3B5998;'>Web Design</a>, <a target='_blank' href='http://networkedblogs.com/topic/Web+Development' style='text-decoration:none;color:#3B5998;'>Web Development</a>, <a target='_blank' href='http://networkedblogs.com/topic/Web+Marketing' style='text-decoration:none;color:#3B5998;'>Web Marketing</a></td></tr><tr><td><div id='networkedblogs_badges'>&nbsp;</div></td></tr><tr><td><div style='padding:0px;text-align:center;'><a target="_blank" href="http://networkedblogs.com/blog/ninthlink_inc/?ahash=b32b8b08adece531eded231b893a2629" style="text-decoration:none;color:#666666;font-weight:normal;font-size:10px;">Follow my blog</a></div></td></tr></table></div></div><div id='networkedblogs_below' class='networkedblogs_below'></div></div><script type="text/javascript"><!--
if(typeof(networkedblogs)=="undefined"){networkedblogs = {};networkedblogs.blogId=610111;networkedblogs.shortName="ninthlink_inc";}
--></script><script type="text/javascript" src="http://widget.networkedblogs.com/getwidget?bid=610111"></script><!--NetworkedBlogs End-->						
</div>
	</div></div>
<?php
nlkHome($homeid);
get_footer();
?>