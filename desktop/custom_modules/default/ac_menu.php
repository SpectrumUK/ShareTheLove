<div class="dsMETAmenu">
	<?php /*<div class="dsMAETATitle">NAVIGATE TO:</div>*/?>
		<ul>
			<li><?php echo ' <a href="' . dsf_link('account_edit.html', '', 'SSL') . '">' . TRANSLATION_WORD_ACCOUNT_INFO . '</a>'; ?></li>
            <li><?php echo ' <a href="' . dsf_link('account_history.html', '', 'SSL') . '">' . TRANSLATION_ACCOUNTS_ORDER_HISTORY . '</a>'; ?></li>
            <?php if(strtolower(CONTENT_COUNTRY)=='de' || strtolower(CONTENT_COUNTRY)=='it'){
			//do nothing
		}else{
			echo '<li><a href="' . dsf_link('account_password.html', '', 'SSL') . '">' . TRANSLATION_ACCOUNT_RESET_PASSWORD . '</a></li>' ; }?>
            <li><a href="<?php echo dsf_link('user-manuals.html');?>" title="<?php echo TRANSLATION_PAGE_MANUALS;?>"><?php echo TRANSLATION_PAGE_MANUALS;?></a></li>
    	</ul>
</div>