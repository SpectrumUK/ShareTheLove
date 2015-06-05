<div id="dsFTSignup">
    	<div class="dsFTTitle"><?php echo TRANSLATION_TEXT_SIGNUP ;?></div>
    	<div id="dsFTSignHold">
			<form onsubmit="return emailsub();">
			<div id="dsFTemail"><?php echo dsf_form_email('signupemail','', '' ,'ftrEmail', TRANSLATION_WORD_ENTER_EMAIL) . dsf_form_hidden('signuplocation' , dsf_link('signup.html'));?></div>
			<div id="dsFTsubmit"><?php echo dsf_submit_image('ok_button.png', TRANSLATION_SUBMIT_BUTTON); ?></div>
			<div id="dsFTerror">&nbsp;</div>
			</form>
		</div>
        </div>