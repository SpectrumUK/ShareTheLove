<div id="dsContent">
    <div class="dsMETAleft">
    	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo ds_strtoupper(TRANSLATION_PAGE_PRIVACY); ?></h1>
		<?php echo ($dsv_page_text); ?>
    </div>
    <div class="dsMETAright">
        <div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
        <?php include ('custom_modules/default/signup.php');?>
        <div class="clear"></div>
        <?php include ('custom_modules/default/meta_menu.php');?>
    </div>
</div>
<?php
if (isset($ex_script_text)){
	echo $ex_script_text;
}
?>