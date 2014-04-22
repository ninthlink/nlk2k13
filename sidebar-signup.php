<?php
/**
 * @package NLK
 * @subpackage 2.0
 */
?>
<script type="text/javascript" src='http://login.sendmetric.com/phase2/bhecho_files/smartlists/check_entry.js'></script>
<script type="text/javascript">
	<!--
		function check_cdfs(form) {
			return true;
		}
	-->
</script><script language='javascript' type='text/javascript'>
<!--
    function doSubmit() {
        if (check_cdfs(document.survey)) {
			window.open('','signup','resizable=1,scrollbars=0,width=300,height=150');
            return true;
        }
        else { return false; }
    }
-->
</script><form action="http://login.sendmetric.com/phase2/bullseye/contactupdate1.php3" method="post" name="be" id="be" onsubmit="return doSubmit();" target="signup">
<h4>Newsletter Sign Up : </h4>
<input type="text" name="firstname" class="txt" value="Name" />
<input type="hidden" name="cid" value="7e0b71851897a542f2ba20c566a067" />
<input type="text" name="email" class="txt" value="Email Address" />
<input type="hidden" name="message" value="Thank you. Your information has been submitted. To ensure delivery of your newsletter(s), please add EMAIL_ADDRESS@WHERE_ITS_FROM.COM to your address book, spam filter whitelist, or tell your company's IT group to allow this address to pass through any filtering software they may have set up." />
<input type="image" src="<?php bloginfo('template_url'); ?>/images/fsub.png" name="SubmitBullsEye" value="submit" class="sub" />
<input type="hidden" name="grp[]" value="1640" />
</form>
