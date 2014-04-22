<?php
/**
 * @package NLK
 * @subpackage 2.0
 */

add_action( 'after_setup_theme', 'nlkSetup' );
if ( ! function_exists( 'nlkSetup' ) ):
function nlkSetup() {
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'pthm', 170, 158, true );
	
	add_theme_support( 'automatic-feed-links' );
	
	register_nav_menus( array(
		'topnav' => 'Main Site Navigation',
		'footer' => 'Footer Navigation'
	) );
	
	add_action( 'widgets_init', 'nlkWidgets' );
	add_action('admin_init', 'nlkAdminInit');
	add_action( 'show_user_profile', 'nlkAddPFields' );
	add_action( 'edit_user_profile', 'nlkAddPFields' );
	add_action( 'personal_options_update', 'nlkSavePFields' );
	add_action( 'edit_user_profile_update', 'nlkSavePFields' );
	add_action( 'wp_print_styles', 'nlk_dereg', 100 );
	add_action('wp_print_scripts', 'nlk_scripts');
	add_action('save_post', 'nlk_save_meta');
	add_action( 'login_head', 'progo_custom_login_logo' );
	add_action( 'login_headerurl', 'progo_custom_login_url' );
	
	// and
	remove_action('wp_head', 'rsd_link');
	remove_action('wp_head', 'wlwmanifest_link');
	remove_action('wp_head', 'wp_generator');
	remove_action('wp_head', 'start_post_rel_link');
	remove_action('wp_head', 'index_rel_link');
	remove_action('wp_head', 'adjacent_posts_rel_link');
	
	add_filter('body_class','nlkBC');
	add_filter('the_content', 'nlkCFilter');
	//add_filter('embed_oembed_html', 'nlkEmbed', 10, 3);
}
endif;

function nlkWidgets() {
	register_sidebar(array(
		'before_widget' => '<div class="fbox chat">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3><a href="#chat">',
		'after_title' => '</a></h3><div class="bin">',
		'name' => 'chat'
	));
	register_sidebar(array(
		'before_widget' => '<div class="fbox quot">',
		'after_widget' => '</div></div>',
		'before_title' => '<h3><a href="#quote">',
		'after_title' => '</a></h3><div class="bin">',
		'name' => 'quote'
	));
	register_sidebar(array(
		'before_widget' => '<div class="request">',
		'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
		'name' => 'appt'
	));
}

function nlkHome($homeid) {
	echo '<div id="home">';
	/*
	$code = get_the_post_thumbnail( $homeid, 'post-thumbnail',array('alt'=>wp_title('',0), 'title'=>''));
	echo '<!-- nlkHome('. $homeid .') : '. $code .' -->';
	$imgStart = strpos($code,'src="')+5;
	$imgEnd = strpos($code,'"',$imgStart);
	$imgSrc = substr($code,$imgStart,$imgEnd-$imgStart);
	echo '<div id="home" style="background-image: url('. $imgSrc .')"><img style="display:none" src="'. $imgSrc .'" alt="Web Design Company" />';
	echo '</div><div id="freeform" style="display:none">'. do_shortcode('[contact-form 5 "Homepage Form"]') .'';
	*/
}

function nlkBC($classes) {
	if(is_page(5675)) $classes[] = 'work';
	if(is_archive() || is_single()) $classes[] = 'blog';
	if(is_page_template('page-shortheader.php') || is_page_template('page-onecolumn.php') || is_page_template('page-ourwork.php')) $classes[] = 'sh';
//	if(is_page_template('nlk-homepage.php') && !is_home()) $classes[] = 'home';
	if(is_page_template('page-pricelist.php')) $classes[] = 'pl';
	if(is_page_template('page-services.php')) $classes[] = 'serv';
	if(is_category('digizines') || (is_single() && in_category('digizines'))) $classes[] = 'digi';
	global $post;
	if(is_page() && ($post->post_parent ==6310)) $classes[] = 'study';
	return $classes;
}

function nlkCFilter($content) {
	if(is_page() && !is_front_page()) {
		// break left column after end of H3 callout
		$cfix = str_replace('<p>[right]</p>','</div><div id="right" class="pts">',str_replace('<p>[/right]</p>','</div><div class="alignleft">',$content));
		$content = $cfix;
	}
	$content = str_replace('<p>[line]</p>','<div class="nln"></div>',$content);
	
	return $content;
}

function nlkEmbed($oembvideo, $url, $attr) {
	if(strpos($url,'youtube.com')!== false) {
		$patterns = array();
		$replacements = array();
		$patterns[] = '/<embed/';
		$patterns[] = '/allowscriptaccess="always"/';
		$patterns[] = '/feature=oembed/';
		
		$replacements[] = '<param name="wmode" value="opaque" /><embed';
		$replacements[] = 'wmode="opaque" allowscriptaccess="always"';
		$replacements[] = 'feature=oembed&amp;wmode=opaque';
		
		return preg_replace($patterns, $replacements, $oembvideo);
	}
	if(strpos($url,'vimeo.com')!== false) {
		// $oembvideo is something like '<iframe src="http://player.vimeo.com/video/4090367" width="504" height="284" frameborder="0"></iframe>'
		// so lets stretch WIDTH to $attr[width] and adjust HEIGHT accordingly
		$width = 0;
		$height = 0;
		$newheight = 0;
		$attrstart = strpos($oembvideo,'width="');
		if($attrstart !== false) {
			$attrstart += 7;
			$width = substr($oembvideo, $attrstart, strpos($oembvideo,'"',$attrstart+1)-$attrstart);
			$attrstart = strpos($oembvideo,'height="');
			if(($attrstart !== false) && $width>0) {
				$attrstart += 8;
				$height = substr($oembvideo, $attrstart, strpos($oembvideo,'"',$attrstart+1)-$attrstart);
				$newheight = round($height*$attr['width']/$width);
				
				$oembvideo = str_replace('height="'.$height,'height="'.$newheight, str_replace('width="'.$width,'width="'.$attr['width'], $oembvideo));
			}
			// 504 x 284 :: 608 x 343
		}
	}
	
	return $oembvideo;
}

function nlkBTExcerpt($content) {
	$imgstart = strpos($content,'<img ');
	$img = ($imgstart !== false) ? substr($content, $imgstart, (strpos($content,'/>',$imgstart)-$imgstart+2)) : '';
	
	$content = strip_tags($content);
	//replace youtube link http://www.youtube.com/watch?v=kHWu5ABCBY0 with thumb image http://i.ytimg.com/vi/a0b90YppquE/0.jpg
	$yts = strpos($content,'http://www.youtube.com/watch');
	if($yts !== false) {
		$yid = substr($content,$yts+31,11);
		$content = substr($content,0,$yts) . substr($content,$yts+42);
		if($img=='') $img = '<img src="http://i.ytimg.com/vi/'. $yid .'/0.jpg" alt="youtube" width="138" />';
	}
	return $img .'</a>'. nlkSpaceOff($content,194) .'</p>';
}

if ( ! function_exists( 'nlkPostedOn' ) ) :
function nlkPostedOn() {
	$uid = get_the_author_meta( 'ID' );
	if(userphoto_exists($uid)) {
		printf( __( '<span class="by">By %1$s on %2$s</span>', 'nlk' ),
			sprintf( '<a class="url fn n" href="%1$s" title="%2$s">%3$s</a>',
				(get_author_posts_url( $uid )),
				sprintf( esc_attr__( 'View all posts by %s', 'twentyten' ), get_the_author() ),
				get_the_author()
			),
				get_the_date()
		);
	} else {
		printf( __( '<span class="by">Posted by %1$s on %2$s</span>', 'nlk' ),
			get_the_author(),
			get_the_date()
		);
	}
}
endif;

function nlkAddPFields( $user ) { ?>
	<h3>NLK Team Profile Information</h3>
	<table class="form-table">
		<tr>
			<th><label for="jobtitle">Job Title</label></th>
			<td>
				<input type="text" name="jobtitle" id="jobtitle" value="<?php echo esc_attr( get_the_author_meta( 'jobtitle', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">what ARE you?</span>
			</td>
		</tr>
		<tr>
			<th><label for="facebook">Facebook</label></th>
			<td>
				<input type="text" name="facebook" id="facebook" value="<?php echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Paste your Facebook URL (entire URL, like http://www.facebook.com/chousmith ) here (if you want?)</span>
			</td>
		</tr>
		<tr>
			<th><label for="twitter">Twitter</label></th>
			<td>
				<input type="text" name="twitter" id="twitter" value="<?php echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Twitter username?</span>
			</td>
		</tr>
		<tr>
			<th><label for="plusone">Google+</label></th>
			<td>
				<input type="text" name="plusone" id="plusone" value="<?php echo esc_attr( get_the_author_meta( 'plusone', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">http://plus.google.com/[what?]</span>
			</td>
		</tr>
		<tr>
			<th><label for="linkedin">LinkedIn</label></th>
			<td>
				<input type="text" name="linkedin" id="linkedin" value="<?php echo esc_attr( get_the_author_meta( 'linkedin', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">http://www.linkedin.com/in/[what?]</span>
			</td>
		</tr>
		<tr>
			<th><label for="flickr">Flickr</label></th>
			<td>
				<input type="text" name="flickr" id="flickr" value="<?php echo esc_attr( get_the_author_meta( 'flickr', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Please enter your Flickr ID. Use <a href="http://idgettr.com/" target="_blank">http://idgettr.com/</a> if you need to.</span>
			</td>
		</tr>
		<tr>
			<th><label for="picasa">Picasa</label></th>
			<td>
				<input type="text" name="picasa" id="picasa" value="<?php echo esc_attr( get_the_author_meta( 'picasa', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Or maybe you have a Picasa username?</span>
			</td>
		</tr>
		<tr>
			<th><label for="youtube">YouTube</label></th>
			<td>
				<input type="text" name="youtube" id="youtube" value="<?php echo esc_attr( get_the_author_meta( 'youtube', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">http://www.youtube.com/user/[what?] - Paste your YouTube User ID here, if you want</span>
			</td>
		</tr>
		<tr>
			<th><label for="vimeo">Vimeo</label></th>
			<td>
				<input type="text" name="vimeo" id="vimeo" value="<?php echo esc_attr( get_the_author_meta( 'vimeo', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">hhttp://vimeo.com/[what is your userID?] - Paste your Vimeo User ID here, if you want</span>
			</td>
		</tr>
		<tr>
			<th><label for="lastfm">LastFM</label></th>
			<td>
				<input type="text" name="lastfm" id="lastfm" value="<?php echo esc_attr( get_the_author_meta( 'lastfm', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Do you have a Last.FM username?</span>
			</td>
		</tr>
		<tr>
			<th><label for="instagram">Instagram</label></th>
			<td>
				<input type="text" name="instagram" id="instagram" value="<?php echo esc_attr( get_the_author_meta( 'instagram', $user->ID ) ); ?>" class="regular-text" /><br />
				<span class="description">Do you use Instagram? If yes, what's your username?</span>
			</td>
		</tr>
	</table>
<?php }

function nlkSavePFields( $user_id ) {
	if( !current_user_can( 'edit_user', $user_id ) ) return false;
	update_usermeta( $user_id, 'jobtitle', $_POST['jobtitle'] );
	update_usermeta( $user_id, 'facebook', $_POST['facebook'] );
	update_usermeta( $user_id, 'twitter', $_POST['twitter'] );
	update_usermeta( $user_id, 'plusone', $_POST['plusone'] );
	update_usermeta( $user_id, 'linkedin', $_POST['linkedin'] );
	update_usermeta( $user_id, 'flickr', $_POST['flickr'] );
	update_usermeta( $user_id, 'picasa', $_POST['picasa'] );
	update_usermeta( $user_id, 'youtube', $_POST['youtube'] );
	update_usermeta( $user_id, 'vimeo', $_POST['vimeo'] );
	update_usermeta( $user_id, 'lastfm', $_POST['lastfm'] );
	update_usermeta( $user_id, 'instagram', $_POST['instagram'] );
}

function nlkTeam($tick = false) {
	$us = array('aimee','alex','craig','david','jeromy','matt','megan','ron','russell','tracy','ting');
	echo '<ul'. ($tick ? ' id="ourteam"' : '') .'>';
	if($tick) {
		$teamcount = count($us);
		$prevind = -1;
		$nextind = -1;
		$onind = 0;
		// search for what author page we are on?
		for($i=0; $i<$teamcount; $i++) {
			if(is_author($us[$i])) {
				$onind = $i;
				$prevind = $i - 1;
				$nextind = $i + 1;
			}
		}
		if($prevind < 0) $prevind = $teamcount -1;
		if($nextind == $teamcount) $nextind = 0;
		// reset
		$teamcount = 1;
		echo '<li class="p"><a href="'. get_bloginfo('url') .'/author/'. $us[$prevind] .'/"></a></li>';
	}
	foreach($us as $me) {
		echo '<li'. (is_author($me) ? ' class="here"' : '') .'><a href="'. get_bloginfo('url') .'/author/'. $me .'/">';
		echo $tick ? ($teamcount++ .'<span class="thm">') : '';
		userphoto_thumbnail($me,'','',array('width'=>'64',height=>'72'));
		echo $tick ? '</span>' : '';
		echo '</a></li>';
	}
	echo $tick ? '<li class="n"><a href="'. get_bloginfo('url') .'/author/'. $us[$nextind] .'/"></a></li>' : '';
	echo '</ul>';
}

function nlkSpaceOff($blurb,$cutoff = 46) {
	$blurb = str_replace(array('&#8220;','&#8221;','&#8217;'),array('"','"','\''),$blurb);
	
	$shorter = substr($blurb,0,$cutoff);
	// one note : "&amp;" takes up just 1 character space.
	$amps = substr_count($shorter,'&#038;');
	if($amps) {
		$cutoff += 5*$amps;
		$shorter = substr($blurb,0,$cutoff);
	}
	
	if(strlen($blurb) < $cutoff) return $blurb;
	
	$shorter = substr($shorter,0,strrpos($shorter,' '));
	return $shorter . '...';
}

function nlk_dereg() {
	wp_deregister_style( 'NextGEN' );
}

function nlk_scripts() {
	if(!is_admin()) {
		if ( is_single() ) {
			wp_enqueue_script('comment-reply');
		}
		wp_deregister_script('jquery');
		wp_register_script( 'jquery', 'http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js', array(), '1.7.2', true);
		
		wp_enqueue_script( 'nlkjs', get_bloginfo('template_url') .'/scripts.js', array('jquery'), false, true );
		
		//wp_enqueue_script( 'nlk-twitter-footer', 'http://twitter.com/statuses/user_timeline/ninthlink.json?callback=nlkTwitterCallback&amp;count=3', array('nlkjs'), 1.0, true );
	}
}

function nlkAdminInit() {
	// check for a template type
	$post_id = $_GET['post'] ? $_GET['post'] : $_POST['post_ID'];
	$template_file = get_post_meta($post_id,'_wp_page_template',TRUE);
	if ($template_file == 'page-pricelist.php')
	{
		add_meta_box("nlk_img_map", "Top Image Map", "nlk_img_map", "page", "normal", "high");
		add_meta_box("nlk_may_need", "You May Need...", "nlk_may_need", "page", "side", "");
	}
}

function nlk_img_map() {
	global $post;
	$custom = get_post_custom($post->ID);
	$nlk_img_map = $custom["nlk_img_map"][0];
	?>
    <textarea name="nlk_img_map" cols="100" rows="3"><?php echo $nlk_img_map; ?></textarea>
    <p>Paste Image Map code here, for the top (Featured Image) on this Page</p>
	<?php
}

function nlk_may_need() {
	global $post;
	$custom = get_post_custom($post->ID);
	$nlk_may_need = $custom["nlk_may_need"][0];
	?>
    <textarea name="nlk_may_need" cols="37" rows="6" style="font-size:11px"><?php echo $nlk_may_need; ?></textarea>
    <p>Enter HTML here for the "You May Need..." bottom right area</p>
	<?php
}

function nlk_save_meta(){
	global $post;
	
	update_post_meta($post->ID, "nlk_img_map", $_POST["nlk_img_map"]);
	update_post_meta($post->ID, "nlk_may_need", $_POST["nlk_may_need"]);
}

function nlkCatCleanup($id) {
	$nicer = array(3=>'Design', 4=>'Develop', 5=>'Market', 2104=>'Culture', 2105=>'Tips', 2106=>'Press/News');
	$catsarr = get_the_category($id);
	$oot = '';
	for($i=0;$i<count($catsarr); $i++) {
		if($i>0) $oot .= ', ';
		$goodcatname = isset($nicer[$catsarr[$i]->term_id]) ? $nicer[$catsarr[$i]->term_id] : $catsarr[$i]->name;
		$oot .= '<a rel="category tag" title="View all posts in '. $catsarr[$i]->name .'" href="'. get_category_link($catsarr[$i]->term_id) .'">'. $goodcatname .'</a>';
	}
	return $oot;
}

function nlkIssuu( $atts ) {
	extract( shortcode_atts( array(
		'folderid' => '',
		'documentid' => '',
		'username' => '',
		'docname' => '',
		'loadinginfotext' => '',
		'tag' => '',
		'showflipbtn' => false,
		'proshowmenu' => false,
		'proshowsidebar' => false,
		'autoflip' => false,
		'autofliptime' => '6000',
		'backgroundcolor' => '',
		'layout' => 'http%3A%2F%2Fskin.issuu.com%2Fv%2Flight%2Flayout.xml',
		'height' => '',
		'width' => '',
		'unit' => 'px',
		'viewmode' => '',
		'pagenumber' => 1,
		'logo' => '',
		'logooffsetx' => 0,
		'logooffsety' => 0,
	), $atts ) );
	
    $viewerurl = "http://static.issuu.com/webembed/viewers/style1/v1/IssuuViewer.swf";
    
    $flashvars = "mode=embed";
    if ($folderid) $flashvars .= "&amp;folderId=$folderid";
    else {
        if ($documentid) $flashvars .= "&amp;documentId=$documentid";
        if ($docname) $flashvars .= "&amp;docName=$docname";
        if ($username) $flashvars .= "&amp;username=$username";
        if ($loadinginfotext) $flashvars .= "&amp;loadingInfoText=$loadinginfotext";
    }
    if ($showflipbtn == "true") $flashvars .= "&amp;showFlipBtn=true";
    if ($proshowmenu == "true") $flashvars .= "&amp;proShowMenu=true";
    if ($proshowsidebar == "true")$flashvars .= "&amp;proShowSidebar=true";
    if ($autoflip == "true") $flashvars .= "&amp;autoFlip=true" . ($autofliptime ? "&amp;autoFlipTime=$autofliptime" : "");
    if ($backgroundcolor) $flashvars .= "&amp;backgroundColor=$backgroundcolor";
    if ($layout) $flashvars .= "&amp;layout=$layout";
    if ($viewmode) $flashvars .= "&amp;viewMode=$viewmode";
    if ($pagenumber > 1) $flashvars .= "&amp;pageNumber=$pagenumber";
    if ($logo) $flashvars .= "&amp;logo=$logo&amp;logoOffsetX=$logooffsetx&amp;logoOffsetY=$logooffsety";
    
	if(is_single() || is_category('2128')) {
		$width = 960;
		$height = 622;
	} else {
		$width = 607;
		$height = 393;
	}
	
    return '<p><object style="width:' . $width . $unit . ';height:' . $height . $unit. '" ><param name="movie" value="' . $viewerurl . '?' . $flashvars . '" />' . 
           '<param name="allowfullscreen" value="true"/><param name="menu" value="false"/><param name="wmode" value="opaque"/>' . 
           '<embed src="' . $viewerurl . '" type="application/x-shockwave-flash" style="width:' . $width . $unit . ';height:' . $height . $unit . '" flashvars="' .
           $flashvars . '" allowfullscreen="true" menu="false" wmode="opaque" /></object></p>';
}
add_shortcode( 'issuu', 'nlkIssuu' );

if ( ! function_exists( 'progo_custom_login_logo' ) ):
/**
 * hooked to 'login_head' by add_action in progo_setup()
 * @since Business Pro 1.0
 */
function progo_custom_login_logo() { ?>
<style type="text/css">
.login h1 a { background: url(<?php bloginfo( 'template_url' ); ?>/images/login-logo.png) no-repeat top center; height: 76px; }
body.login { background-color: #000 }
.login #nav, .login #backtoblog { text-shadow: none }
body.login #nav a, body.login #backtoblog a { color: #ccc !important; font-family: Georgia, "Times New Roman", Times, serif; display: block; text-align: center }
</style>
<?php
}
endif;
if ( ! function_exists( 'progo_custom_login_url' ) ):
/**
 * hooked to 'login_headerurl' by add_action in progo_setup()
 * @uses get_option() To check if a custom logo has been uploaded to the back end
 * @return the custom URL
 * @since Business Pro 1.0
 */
function progo_custom_login_url() {
	return get_bloginfo('url');
}
endif;

function nlkTwitterRelativeTime($t) {
	/*
	 date("l M j \- g:ia",strtotime($time));
	
	$t = explode(" ", $time);
	$timestr = $t[2] .' '. $t[1] .' '. $t[5] .' '. $t[3] .' '. $t[4];//time_value = values[1] + " " + values[2] + ", " + values[5] + " " + values[3];
	//return $timestr;
	
	$ts = strtotime($timestr);
	$nows = strtotime('now');
	*/
	$ts = strtotime($t);
	$d = time() - strtotime($t);
	/*
	var parsed_date = Date.parse(time_value);
	var relative_to = (arguments.length > 1) ? arguments[1] : new Date();
	var delta = parseInt((relative_to.getTime() - parsed_date) / 1000);
	delta = delta + (relative_to.getTimezoneOffset() * 60);
	*/
	// 1349292
	if ($d < 60) {
		$nt = 'less than a minute ago';
	} elseif($d < 120) {
		$nt = 'about a minute ago';
	} elseif($d < 3600) { // 60seconds x 60minutes
		$nt = round($d / 60) .' minutes ago';
	} elseif($d < 7200) { // 60seconds x 60minutes x 2
		$nt = 'about an hour ago';
	} elseif($d < (24*60*60)) {
		$nt = 'about '. round($d / 3600) .' hours ago';
	} elseif($d < (48*60*60)) {
		$nt = '1 day ago';
	} else {
		$nt = round($d / 86400) .' days ago';
	}
	return '<span title="'. $d .'">'. $nt .'</span>';
}

function nlkTwitterTweet( $text, $ents ) {
	$oot = $text;
	$lc = 0;
	
	$allents = array();
	
	if ( isset( $ents['hashtags'] ) ) {
		foreach ( $ents['hashtags'] as $h ) {
			$allents[$h['indices'][0]] = array(
				'type' => 'hashtags',
				'startat' => $h['indices'][0],
				'endat' => $h['indices'][1],
				'replacewith' => '<a href="https://twitter.com/search?q=%23'. $h['text'] .'&src=hash" target="_blank">#'. $h['text'] .'</a>'
			);
		}
	}
	
	
	if ( isset( $ents['urls'] ) ) {
		foreach ( $ents['urls'] as $h ) {
			$allents[$h['indices'][0]] = array(
				'type' => 'urls',
				'startat' => $h['indices'][0],
				'endat' => $h['indices'][1],
				'replacewith' => '<a href="'. $h['expanded_url'] .'" target="_blank">'. $h['display_url'] .'</a>'
			);
		}
	}
	
	if ( isset( $ents['user_mentions'] ) ) {
		foreach ( $ents['user_mentions'] as $h ) {
			$allents[$h['indices'][0]] = array(
				'type' => 'user_mentions',
				'startat' => $h['indices'][0],
				'endat' => $h['indices'][1],
				'replacewith' => '<a href="https://twitter.com/'. $h['screen_name'] .'" target="_blank">@'. $h['screen_name'] .'</a>'
			);
		}
	}
	
	ksort($allents);
	
	foreach ( $allents as $h ) {
		$oldlength = strlen($oot);
		$newt = substr( $oot, 0, $h['startat'] + $lc ) . $h['replacewith'] . substr( $oot, $h['endat'] + $lc );
		$oot = $newt;
		$lc = ( strlen($oot) - $oldlength ) + $lc;
	}
		
	return $oot;
}