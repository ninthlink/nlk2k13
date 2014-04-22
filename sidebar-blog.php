<?php
/**
 * @package NLK
 * @subpackage 2.0
 */

//get_sidebar('holidayhours');
if ( is_single() ) {
	$mgp = get_the_author_meta( 'plusone' );
	if ( $mgp ) {
?>
<div class="block">
<h3><a href="https://plus.google.com/<?php the_author_meta( 'plusone' ) ?>/?rel=author" rel="author"" target="_blank">+<?php echo get_the_author(); ?></a></h3>
<p><?php echo '<a href="'. get_author_posts_url(get_the_author_meta( 'ID' )) .'">'; userphoto_thumbnail(get_the_author_meta( 'ID' ),'','',array('class'=>'alignright')); echo '</a>'; the_author_meta( 'description' ); ?></p>
</div>
<?php }
}
?>
<div class="block links">
<h3>Categories</h3>
<ul>
<?php wp_list_categories('orderby=ID&title_li='); ?> 
</ul>
</div>
<?php
$args = array(
		'before_widget' => '<div class="block links posts">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>'
		);
the_widget('WP_Widget_Recent_Posts','title=Recent Entries&number=9',$args);

// and now we will repurpose the MONTHLY archives...
$monthly = wp_get_archives('type=monthly&show_post_count=true&echo=0');
// something like '<li><a href="http://www.ninthlink.com/2k10/2010/08/" title="August 2010">August 2010</a>&nbsp;(7)</li>...'
$months = explode('</li>',$monthly);
$years = array();
$curyear = 0;
// first set up nested array to break apart the group of months by year
for($i=0; $i<count($months); $i++) {
	$thisyear = substr($months[$i],strrpos($months[$i],' ')+1,4);
	if($thisyear) {
		if($i==0) $years[] = array('y'=>$thisyear,'m'=>array());
		elseif($years[$curyear]['y']!=$thisyear) {
			$curyear++;
			$years[$curyear] = array('y'=>$thisyear,'m'=>array());
		}
		$monthLI = $months[$i]; // '<li><a href="http://www.ninthlink.com/2k10/2010/08/" title="August 2010">August 2010</a>&nbsp;(7)'
		$monthLI = substr($monthLI,0,strrpos($monthLI,' ')) . substr($monthLI,strrpos($monthLI,'</a>')) .'</li>';
		$years[$curyear]['m'][] = $monthLI;
	}
}
// then want to alternate months
$yearselect = '';
$monthULs = '';
for($i=0; $i<count($years); $i++) {
	$yearselect .= '<option value="'. $i . ($i==0 ? '" selected="selected' : '') .'">'. $years[$i]['y'] .'</option>';
	$monthULs .= '<ul'. ($i>0 ? ' style="display:none"' : '') .'>';
	$nummonths = count($years[$i]['m']);
	for($j=0; $j<$nummonths; $j++) {
		if($j%2 == 0) {
			$ind = $nummonths - ($j/2) - 1;
		} else {
			$ind = ceil(($nummonths-$j)/2) -1;
		}
		$monthULs .= $years[$i]['m'][$ind];
	}
	$monthULs .= '</ul>';
}

echo '<div class="block links" id="months"><h3>Archives</h3><select>'. $yearselect .'</select>';
echo $monthULs;
echo '</div>';

	if ( function_exists('getTweets') ) {
		$mytweets = getTweets(1, 'ninthlink', array('include_rts'=>1));
		if ( isset( $mytweets['error'] ) ) {
			// doh
		} else {
			$mytweetcount = $mytweets[0]['user']['statuses_count'];
			$ents = isset( $mytweets[0]['entities'] ) ? $mytweets[0]['entities'] : array();
			$mytwitterstatus = nlkTwitterTweet($mytweets[0]['text'], $ents);
			$mytwittercreated = nlkTwitterRelativeTime($mytweets[0]['created_at']);	
			$mytwittersource = $mytweets[0]['source'];
			$mytweeturl = 'https://twitter.com/ninthlink/status/'. $mytweets[0]['id'];
			
			echo '<div class="block tweet"><h3>Tweets <a href="http://twitter.com/ninthlink" target="_blank" class="i">http://twitter.com/ninthlink</a></h3>';
			echo '<p>'. $mytwitterstatus .'<br /><small><a href="'. $mytweeturl .'" target="_blank">'. $mytwittercreated .'</a> via '. $mytwittersource .'</small></p>';
			echo '</div>';
		}
	}
//<script type="text/javascript" src="http://api.flickr.com/services/feeds/photos_public.gne?id=93125447@N00&lang=en-us&format=json"></script>

get_sidebar('team');

?>
<div class="block join"><h3>Facebook</h3>
<div style="display:block; width:300px; margin: 10px 0 0 -11px;">
<iframe src="http://www.facebook.com/plugins/likebox.php?id=362960366842&amp;width=300&amp;connections=10&amp;stream=false&amp;header=false&amp;height=255" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:300px; height:255px;"></iframe>
</div>
</div>