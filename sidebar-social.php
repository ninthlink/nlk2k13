<?php
/**
 * @package NLK
 * @subpackage 2.0
 */
?>
<div class="fbox soc">
    <h3><a href="#social">Social Chatter Feeds</a></h3>
    <div class="bin">
        <ul class="tabs">
            <li class="t1 on"><a href="#fboxB">Blog</a></li>
            <li><a href="#fboxT">Twitter</a></li>
            <li><a href="#fboxF">Facebook</a></li>
        </ul>
        <div class="tab on" id="fboxB">
        <?php
            global $post;
            $myposts = get_posts('numberposts=3');
            foreach($myposts as $post) :
            echo '<p><a href="'. get_permalink() .'">'. get_the_title() .'</a><br /><small>Added by: <a href="'. get_author_posts_url(get_the_author_meta('ID', $post->post_author)) .'">'.get_the_author_meta('display_name',$post->post_author) .'</a> on '. get_the_date('F d, Y') .'</small></p>';
			//echo '<pre style="display:none">'. print_r($post,true) .'</pre>';
            endforeach;
        ?>
        <p class="last typeface-js"><a href="<?php echo get_permalink(5677); ?>">Visit the Blog &gt;</a></p>
        </div>
        <div class="tab" id="fboxT">
        <?php
		if ( function_exists('getTweets') ) {
			$mytweets = getTweets(3, 'ninthlink', array('include_rts'=>1));
			if ( isset( $mytweets['error'] ) ) {
				// doh
			} else {
				foreach ( $mytweets as $t ) {
					$mytweetcount = $t['user']['statuses_count'];
					$ents = isset( $t['entities'] ) ? $t['entities'] : array();
					$mytwitterstatus = nlkTwitterTweet($t['text'], $ents);
					$mytwittercreated = nlkTwitterRelativeTime($t['created_at']);	
					$mytwittersource = $t['source'];
					$mytweeturl = 'https://twitter.com/ninthlink/status/'. $t['id'];
					echo '<p>'. $mytwitterstatus .'<br /><small><a href="'. $mytweeturl .'" target="_blank">'. $mytwittercreated .'</a> via '. $mytwittersource .'</small></p>';
				}
			}
		}
		?>
        <p class="last typeface-js"><a href="http://twitter.com/ninthlink" target="_blank">Follow us on Twitter &gt;</a></p>
        </div>
        <div class="tab" id="fboxF">
        <iframe src="http://www.facebook.com/plugins/likebox.php?id=362960366842&amp;width=301&amp;connections=10&amp;stream=false&amp;header=false&amp;height=255" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:231px;"></iframe>
        </div>
    </div>
</div>