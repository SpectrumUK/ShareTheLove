<!-- body //-->
<div id="dsCRESTstrip">&nbsp;</div>
<div id="dsContentList">
	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    <div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
    <div class="clear"></div>
    <h1><?php echo ds_strtoupper (TRANSLATION_SEARCH_RESULTS);?></h1>
    <?php
					include($dsv_modules . 'default/product_listing_column.php');
?>
</div>