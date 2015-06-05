<?php
/* cookie text for page is stored in variable $dsv_cookie_details as an array

Available fields

bar_text
bar_button_text
bar_link_text

*/


// only show this bar etc... if we do not already have approval and we are not showing the cookie page
	if (isset($dsv_show_cookie_bar) && $dsv_show_cookie_bar == 'true'){
			echo $dsv_cookie_form_start;
		?>
        <div id="cookieBar">
		<div id="cookieBarContent">
        <div id="cookieBarLogo"></div>
		<div id="cookieBarText"><?php echo $dsv_cookie_details['bar_text'];?></div>
		<div id="cookieBarBtn"><?php echo dsf_submit_image('cookie_bar_btn.gif', $dsv_cookie_details['bar_button_text']);?></div>
		<div id="cookieBarInfo"><a href="<?php echo dsf_link('cookie_usage.html');?>" ><?php echo $dsv_cookie_details['bar_link_text'];?></a></div>
        </div>
	</div>
	<?php
		echo  dsf_form_hidden('ds_confirm_cookie','yes');
		echo  dsf_form_hidden('ds_confirm_all','yes');
		echo $dsv_cookie_form_end;
	}
?>