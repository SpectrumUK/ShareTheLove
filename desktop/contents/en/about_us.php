<div id="dsContent">
    <div class="dsMETAleft">
    	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
        <?php /*<div class="dsCIMG">
   		  	<div class="dsIMGLeftCorner"><?php echo dsf_image('custom/article_left_cover.png', '', '100', '87');?></div>
            <div class="dsIMGRightCorner"><?php echo dsf_image('custom/contact_right_cover.png', '', '100', '87');?></div>
			<?php
	if (isset($dsv_about_details['image']) && strlen($dsv_about_details['image'])>1){
		echo dsf_image($dsv_about_details['image'],'','','','align="centre"');
	}
	 ?>
        </div>*/?>
    		<h1><?php echo strtoupper(TRANSLATION_PAGE_ABOUT); ?></h1>
        	<?php
if (isset($dsv_about_details['about_text']) && strlen($dsv_about_details['about_text'])>1){

	/*echo '<div id="timelineContainer">
<div class="timelineToggle"><p><a class="expandAll">expand all</a></p></div><br class="clear">'; */
	echo $dsv_about_details['about_text'];
}?>
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