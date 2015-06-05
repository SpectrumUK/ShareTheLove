<!-- body //-->
<div id="dsCRESTstrip">&nbsp;</div>
<div id="dsContentList">
	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    <div class="addthis"><?php include ('custom_modules/addthis.php');?></div>
    <div class="clear"></div>
    <h1><?php echo strtoupper (TRANSLATION_SEARCH_RESULTS);?></h1>
    <?php


				if ($dsv_list_type == 'grid'){
					include($dsv_modules . 'default/product_listing_column_parts.php');
				}else{
					include($dsv_modules . 'default/product_listing.php');
				}
?>
</div>

<?php /*<?php
$dsv_category_name = TRANSLATION_TITLE_RESULTS_FOUND;
		
		
		$banner_array = array('image_one' => 'custom/search_banner_img.jpg',
						 'thumb_one' => 'custom/search_thumb_img.jpg',
						 'url_one' => '',
						 'image_two' => '',
						 'thumb_two' => '',
						 'url_two' => '',
						 'image_three' => '',
						 'thumb_three' => '',
						 'url_three' => '',
						 'image_four' => '',
						 'thumb_four' => '',
						 'url_four' => '');

		// then add the function as an echo into the already created header div
?>
<div class="details" id="contentDiv">
		<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div></div>
	</div>
	<div id="contentContainer">
    	<div id="content">
        	<div id="dsSUBNav">
			<div id="dsCATLabel"><?php echo TRANSLATION_ACCESSORIES;?></div>
			<?php include('custom_modules/categories_parts_nav.php');?>
			</div>

<div id="rightContent">
	<div class="pagTitles">
	<h1><?php echo TRANSLATION_SEARCH_RESULTS;?></h1>
    <div class="addthis"><?php include ('custom_modules/addthis.php');?></div>
	</div>
    <div id="clear"></div>
<div class="lineBreak"></div>

<?php
		include(DS_MODULES . 'product_listing_column_parts.php');

?>
</div>
</div>
</div>*/?>