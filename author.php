<?php
/**
 * @package NLK
 * @subpackage 2.0
 */
global $wp_query;
$aID = $wp_query->queried_object_id;
// set up author links
$mylinks = array();
$mywebsite = get_the_author_meta( 'user_url', $aID );
if($mywebsite) {
	$mylinks[] = $mywebsite;
}
$myfacebook = get_the_author_meta( 'facebook', $aID );
if($myfacebook) {
	$mylinks[] = $myfacebook;
}
$mytwitter = get_the_author_meta( 'twitter', $aID );
$mytweetcount = false;
if($mytwitter) {
	$mylinks[] = 'http://twitter.com/'. $mytwitter;
	//wp_enqueue_script( 'nlkMyTwitter', 'http://api.twitter.com/1/statuses/user_timeline.json?include_rts=true&amp;screen_name='.$mytwitter.'&amp;count=1&amp;callback=nlkMyTwitter', array('nlkjs'), 1.0, true );
	$mylatesttweet = '';
	$mytweetcount = 0;
	if ( function_exists('getTweets') ) {
		$mytweets = getTweets(1, $mytwitter, array('include_rts'=>1, 'trim_user'=>false));
		if ( isset( $mytweets['error'] ) ) {
			// doh
		} else {
			$mytweetcount = $mytweets[0]['user']['statuses_count'];
			$ents = isset( $mytweets[0]['entities'] ) ? $mytweets[0]['entities'] : array();
			$mytwitterstatus = nlkTwitterTweet($mytweets[0]['text'], $ents);
			$mytwittercreated = nlkTwitterRelativeTime($mytweets[0]['created_at']);	
			$mytwittersource = $mytweets[0]['source'];
			$mytweeturl = 'https://twitter.com/'. $mytwitter .'/status/'. $mytweets[0]['id'];
		}
	}
}
$myplusone = get_the_author_meta( 'plusone', $aID );
if($myplusone) {
	$mylinks[] = 'http://plus.google.com/'. $myplusone .'/';
}
$mylinkedin = get_the_author_meta( 'linkedin', $aID );
if($mylinkedin) {
	$mylinks[] = $mylinkedin;
}
$myinstagram = get_the_author_meta( 'instagram', $aID );
if($myinstagram) {
	$mylinks[] = 'http://followgram.me/'. $myinstagram;
}
$myflickr = get_the_author_meta( 'flickr', $aID );
if($myflickr) {
	$mylinks[] = 'http://www.flickr.com/photos/'. $myflickr;
	wp_enqueue_script( 'nlkMyFlickr', 'http://api.flickr.com/services/feeds/photos_public.gne?id='. $myflickr .'&lang=en-us&format=json', array('nlkjs'), 1.0, true );
}
$mypicasa = get_the_author_meta( 'picasa', $aID );
if($mypicasa) {
	$mylinks[] = 'http://picasaweb.google.com/'. $mypicasa;
	wp_enqueue_script( 'nlkMyPicasa', 'http://picasaweb.google.com/data/feed/base/user/'. $mypicasa .'?alt=json&kind=photo&hl=en_US&access=public&callback=nlkPicasa', array('nlkjs'), 1.0, true );
}
$myvimeo = get_the_author_meta( 'vimeo', $aID );
if($myvimeo) {
	$mylinks[] = 'http://vimeo.com/'. $myvimeo;
	wp_enqueue_script( 'nlkMyVimeo', 'http://vimeo.com/api/v2/'. $myvimeo .'/videos.json?callback=nlkVimeo', array('nlkjs'), 1.0, true );
}
$myyoutube = get_the_author_meta( 'youtube', $aID );
if($myyoutube) {
	$mylinks[] = 'http://www.youtube.com/user/'. $myyoutube;
}
$mylastfm = get_the_author_meta( 'lastfm', $aID );
if($mylastfm) {
	$mylinks[] = 'http://www.last.fm/user/'. $mylastfm;
}

get_header(); ?>
			<div id="main">

<?php
	/* Queue the first post, that way we know who
	 * the author is when we try to get their name,
	 * URL, description, avatar, etc.
	 *
	 * We reset this later so we can run the loop
	 * properly with a call to rewind_posts().
	 */
	if ( have_posts() )
		the_post();
?>
<div id="us">
    <h1 class="author"><?php echo get_the_author() .' <em>'. esc_attr( get_the_author_meta( 'jobtitle' ) ) .'</em>'; ?></h1>
    <div id="ab">
    <?php the_author_meta( 'description' ); ?>
    </div>
    <div class="count posts typeface-js"><?php echo count_user_posts(get_the_author_meta('ID')); ?><span class="fx"></span></div>
    <?php if ( $mytweetcount ) echo '<div class="count tweet typeface-js">'. $mytweetcount  .'<span class="fx" /></div>'; ?>
    <div class="me">
    <h3>Follow Me</h3>
    <ul>
    <?php
	if($myfacebook) echo '<li class="fb"><a href="'. $myfacebook .'" target="_blank">Facebook</a></li>';
	if($mytwitter) echo '<li class="tw"><a href="http://twitter.com/'. $mytwitter .'" target="_blank">Twitter</a></li>';
	if($myplusone) echo '<li class="gp"><a href="http://plus.google.com/'. $myplusone .'/" target="_blank" rel="author">Google+</a></li>';
	if($mylinkedin) echo '<li class="li"><a href="'. $mylinkedin .'" target="_blank">LinkedIn</a></li>';
	if($myinstagram) echo '<li class="in"><a href="http://followgram.me/'. $myinstagram .'" target="_blank">Insta</a></li>';
	if($myflickr) echo '<li class="fl"><a href="http://www.flickr.com/photos/'. $myflickr .'" target="_blank">Flickr</a></li>';
	if($mypicasa) echo '<li class="pi"><a href="http://picasaweb.google.com/'. $mypicasa .'" target="_blank">Picasa</a></li>';
	if($myvimeo) echo '<li class="vm"><a href="http://vimeo.com/'. $myvimeo .'" target="_blank">Vimeo</a></li>';
	if($myyoutube) echo '<li class="yt"><a href="http://www.youtube.com/user/'. $myyoutube .'" target="_blank">YouTube</a></li>';
	if($mylastfm) echo '<li class="fm"><a href="http://www.last.fm/user/'. $mylastfm .'" target="_blank">Last.FM</a></li>';
	?>
	<li class="rss"><a href="<?php echo get_bloginfo('url') . '/author/'. get_the_author_meta('user_login') .'/feed/'; ?>" target="_blank">RSS</a></li>
    </ul>
    </div>
    <?php userphoto_the_author_photo('','','',''); ?>
</div>
<?php
	/* Since we called the_post() above, we need to
	 * rewind the loop back to the beginning that way
	 * we can run the loop properly, in full.
	 */
	rewind_posts();

	/* Run the loop for the author archive page to output the authors posts
	 * If you want to overload this in a child theme then include a file
	 * called loop-author.php and that will be used instead.
	 */
	 get_template_part( 'loop', 'author' );
	 
	 // also add nav bar for other author pages
	 nlkTeam(true);
?>
			</div>
<div id="right">
<?php
if ( $mytwitter ) {
	if ( $mytweetcount ) {
		echo '<div class="block tweet"><h3>Tweets <a href="http://twitter.com/'. $mytwitter .'" target="_blank" class="i">http://twitter.com/'. $mytwitter .'</a></h3>';
		echo '<p>'. $mytwitterstatus .'<br /><small><a href="'. $mytweeturl .'" target="_blank">'. $mytwittercreated .'</a> via '. $mytwittersource .'</small></p>';
		echo '</div>';
	}
}

if($myinstagram) {
	$instafeed = 'http://followgram.me/'. $myinstagram .'/rss';
	include_once(ABSPATH . WPINC . '/feed.php');
	$rss = fetch_feed($instafeed);
	$instamax = 0;
if (!is_wp_error( $rss ) ) { // Checks that the object is created correctly 
    // Figure out how many total items there are, but limit it to 5. 
    $instamax = $rss->get_item_quantity(1); 

    // Build an array of all the items, starting with element 0 (first element).
    $rss_items = $rss->get_items(0, $instamax); 
		if ($instamax > 0) {
			echo '<div class="block insta"><h3>Instagram <a class="i" href="http://followgram.me/'. $myinstagram .'" target="_blank">'. $myinstagram .'</a></h3>';
			// Loop through each feed item and display each item as a hyperlink.
			foreach ( $rss_items as $item ) {
				echo '<a href="'. $item->get_link() .'" target="_blank">'. $item->get_description() .'</a>';
			}
		}
		echo '</div>';
	}
}
if ( is_author('alex') ) { // yay

	//$alextweets = getTweets(1,'chousmith');
	//echo '<pre title="getweets t'. $mytweetcount .'" style="display:none">'. print_r($mytweets,true) .'</pre>';

	$instafeed = 'http://catshirts.chousmith.com/latestfeed';
	include_once(ABSPATH . WPINC . '/feed.php');
	$rss = fetch_feed($instafeed);
	$instamax = 0;
	if (!is_wp_error( $rss ) ) { // Checks that the object is created correctly 
		// Figure out how many total items there are, but limit it to 5. 
		$instamax = $rss->get_item_quantity(1); 
	
		// Build an array of all the items, starting with element 0 (first element).
		$rss_items = $rss->get_items(0, $instamax); 
		if ($instamax > 0) {
			echo '<div class="block insta"><h3>Latest Catshirt</h3>';
			// Loop through each feed item and display each item as a hyperlink.
			foreach ( $rss_items as $item ) {
				echo $item->get_description();
			}
		}
		echo '</div>';
	}
}

if(count($mylinks) > 0) { ?>
<div class="block links"><h3>Additional Links</h3>
<ul>
<?php
foreach($mylinks as $lnk) {
	echo '<li><a href="'. $lnk .'" target="_blank">'. str_replace('http://','',str_replace('www.','',$lnk)) .'</a></li>';
}
if ( is_author('alex') ) {
	echo '<li><a href="http://catshirts.chousmith.com" target="_blank">catshirts.chousmith.com</a></li>';
}
?>
</ul>
</div>
<?php }

if($mylastfm) echo '<div class="block fm"><h3>Last.fm <a href="http://www.last.fm/user/'. $mylastfm .'" target="_blank" class="i">http://www.last.fm/user/'. $mylastfm .'</a></h3><p><img src="http://imagegen.last.fm/basicrt10/recenttracks/'. $mylastfm .'.gif" alt="Recently Played..." /></p></div>';
//get_sidebar('holidayhours');
get_sidebar('team');
?>
</div>
<?php get_footer(); ?>
