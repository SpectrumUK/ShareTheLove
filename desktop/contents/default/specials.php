<!-- body //-->
<div id="dsCRESTstrip">&nbsp;</div>
<div id="dsContentList">
	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    <div class="addthis"><?php include ('custom_modules/addthis.php');?></div>
    <div class="clear"></div>
    <h1><?php echo strtoupper (TRANSLATION_CUSTOM_TEXT_EIGHT);?></h1>
    <?php	
		/*if (isset($dsv_category_short_text) && strlen($dsv_category_short_text) >1){
			echo'<div class="dsCATtxt">' . $dsv_category_short_text . '</div><div class="lineBreak"></div>';
		}*/

	// sort products box but only if there are items to show.
		if ((int)$dsv_product_items >1){
	//		echo'<div class="dsSortBox">' . $dsv_products_sort_box . '</div>';
		}

		include(DS_MODULES . 'product_listing_column.php');

?>
</div>
<!-- body_eof //-->