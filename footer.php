<?php
/**
 * @package NLK
 * @subpackage 2.0
 */
?>

</div>
<div id="frap">
<div id="ftr">
<div id="bar">
<?php
dynamic_sidebar('chat');
get_sidebar('social');
dynamic_sidebar('quote');
?>
</div>
<?php
wp_nav_menu(array('menu'=>'footer', 'container' => '', 'menu_id'=>'fnav', 'menu_class'=>'typeface-js'));
get_sidebar('signup');
?>
<div class="end">
    <div class="alignleft">
        <a href="http://goo.gl/maps/1pbO" target="_blank">3861 Front St. San Diego, CA 92103</a>.  P: 858.427.1470   <a href="http://www.ninthlink.com">Ninthlink, Inc.</a> Copyright 2012
        <span><a href="<?php echo get_permalink(5685); ?>">Privacy</a> &nbsp;|&nbsp; <a href="<?php echo get_permalink(5678); ?>">Contact</a> &nbsp;|&nbsp; <?php if(is_front_page()) { ?><a class="style2" onclick="jQuery('#resourceftr').toggle(); return false;" href="#">Resources</a> &nbsp;|&nbsp; <?php } ?><a href="<?php echo get_permalink(5686); ?>">Sitemap</a></span><?php if(is_front_page()) { ?>
<span id="resourceftr">
<a title="San Diego SEO Company" href="<?php echo get_permalink(8364); ?>">San Diego SEO Company</a>
&nbsp; | &nbsp;
<a title="San Diego Internet Consulting" href="<?php echo get_permalink(8361); ?>">San Diego Internet Consulting</a>
&nbsp; | &nbsp;
<a title="San Diego Internet Marketing Company" href="<?php echo get_permalink(8346); ?>">San Diego Internet Marketing Company</a>
&nbsp; | &nbsp;
<a title="SEO Copywriting" href="<?php echo get_permalink(8369); ?>">SEO Copywriting</a>
&nbsp; | &nbsp;
<a title="San Diego Website Consulting" href="<?php echo get_permalink(8357); ?>">San Diego Website Consulting</a>
&nbsp; | &nbsp;
<a title="Conversion Optimization Services" href="<?php echo get_permalink(8383); ?>">Conversion Optimization Services</a>
&nbsp; | &nbsp;
<a title="San Diego Social Media Marketing" href="<?php echo get_permalink(8331); ?>">San Diego Social Media Marketing</a>
&nbsp; | &nbsp;
<a title="San Diego SEO" href="<?php echo get_permalink(8314); ?>">San Diego SEO</a>
&nbsp; | &nbsp;
<a title="Internet Optimization Management Services" href="<?php echo get_permalink(8373); ?>">Internet Optimization Management Services</a>
&nbsp; | &nbsp;
<a title="San Diego Online Marketing Services" href="<?php echo get_permalink(8340); ?>">San Diego Online Marketing Services</a>
&nbsp; | &nbsp;<br>
<a title="Internet Marketing Company in San Diego" href="<?php echo get_permalink(8353); ?>">Internet Marketing Company in San Diego</a>
<br>
</span><?php } ?>
    </div>
    <div class="alignright">
<h4>Follow Ninthlink : </h4>
        <ul id="fn">
        <li id="f"><a href="http://www.facebook.com/Ninthlink" target="_blank">Facebook</a></li>
        <li id="t"><a href="http://twitter.com/Ninthlink" target="_blank">Twitter</a></li>
        <li id="l"><a href="http://www.linkedin.com/company/ninthlink/" target="_blank">LinkedIn</a></li>
        <li id="r"><a href="<?php bloginfo('rss2_url'); ?>">RSS</a></li>
        </ul>
    </div>
<div class="alignright">
<p><a href="https://adwords.google.com/professionals/profile/org?id=02461395204671452277&hl=en" target="_blank"><img src="<?php bloginfo('template_url'); ?>/images/gPartnerBadge-Horizontal1.png" alt="Google AdWords Certified Partner" width="119" height="44" /></a> &nbsp; <a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank"><img src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="Valid CSS!" width="88" height="31" /></a></p>
</div>
</div>
</div>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
<?php /* "Just what do you think you're doing Dave?" */
wp_footer(); ?>
</body>
</html>