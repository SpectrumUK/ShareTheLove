<!-- search //-->
<div id="dssearchBak">
<?php
 echo $dsv_column_search_form_start;
 echo dsf_form_search('keywords', (strlen($keywords) >3 ? $keywords : ''), 'size="28" maxlength="255" id="kwinp"','dssearchitem',TRANSLATION_SEARCH_PLACEHOLDER); ?>
 <div id="searchButton"><?php echo dsf_submit_image('button_search.gif', TRANSLATION_SEARCH_BUTTON); ?></div>
 <?php echo $dsv_column_search_form_end;?>
</div>