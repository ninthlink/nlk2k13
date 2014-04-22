<?php
/**
 * @package NLK
 * @subpackage 2.0
 */
?>
<div id="bt"><h4><a href="<?php echo get_permalink(5677); ?>">BLOG &gt;</a></h4>
<div id="btick">
<?php
global $post;
$myposts = get_posts('numberposts=9');
$firstpost = true;
foreach($myposts as $post) : 
echo '<div class="post'. ($firstpost ? ' on' : '') .'">';
if($firstpost) $firstpost = false;
echo '<h2><a href="'. get_permalink() .'">'. nlkSpaceOff(get_the_title(),45) .'</a></h2>';
$pa = '<p><a href="'. get_permalink() .'">';
echo $pa . nlkBTExcerpt($post->post_content) . $pa . 'READ MORE</a></p>';
//echo '<pre style="display:none">'. print_r($post,true) .'</pre>';
?>
</div>
<?php endforeach; ?>
</div>
<div class="block" id="tweets">
<h3>Tweets <a href="http://twitter.com/ninthlink" target="_blank" class="i">http://twitter.com/ninthlink</a></h3>
<?php

	if ( function_exists('getTweets') ) {
		$mytweets = getTweets(1, 'ninthlink',array('include_rts'=>1));
		if ( isset( $mytweets['error'] ) ) {
			// doh
		} else {
			$mytweetcount = $mytweets[0]['user']['statuses_count'];
			$ents = isset( $mytweets[0]['entities'] ) ? $mytweets[0]['entities'] : array();
			$mytwitterstatus = nlkTwitterTweet($mytweets[0]['text'], $ents);
			$mytwittercreated = nlkTwitterRelativeTime($mytweets[0]['created_at']);	
			$mytwittersource = $mytweets[0]['source'];
			$mytweeturl = 'https://twitter.com/ninthlink/status/'. $mytweets[0]['id'];
			echo '<p>'. $mytwitterstatus .'<br /><small><a href="'. $mytweeturl .'" target="_blank">'. $mytwittercreated .'</a> via '. $mytwittersource .'</small></p>';
		}
	}
//jQuery('#tweets').append('<p>'+status+'<br /><small>'+relative_time(twitters[i].created_at)+' via '+ twitters[i].source +'</small></p>');
//tweets here
?>
</div>
</div>