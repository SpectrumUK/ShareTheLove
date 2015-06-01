<!-- ALL OF US LOVE GALLERY CONTENT //-->
<?php 
// check to see if we are viewing this as an include or via the gallery page directly to calculate the URL
if (isset($seasonal_details['url'])){
	$gal_page_url = $seasonal_details['url'];
	
}else{
	
$gal_page_url = $gallery_details['url'];

}

// check whether we are showing an item straight away - the id will be under gID

if (isset($gID) && (int)$gID > 0){
	$current_gal_page_url = $gal_page_url . '?gID=' . $gID;
}else{
	$current_gal_page_url = $gal_page_url;
}
?>
<h3 class="generalh3_product"><?php echo $article_details['text_one'];?></h3>

<div class="productsgallery_mosaic170 mosaicgap5right">
	<img class="img-responsive" src="../../../images/gallery/ihearthome_thumb_healthstart.png" alt=""/>
	<div class="height10"></div>
	<img class="img-responsive" src="../../../images/gallery/ihearthome_thumb_stayingbed.jpg" alt=""/>
</div>
<div class="productsgallery_mosaic170 mosaicgap5left">
	<img class="img-responsive" src="../../../images/gallery/ihearthome_thumb_jammytoast.jpg" alt=""/>
	<div class="height10"></div>
	<img class="img-responsive" src="../../../images/gallery/ihearthome_thumb_telluswin.jpg" alt=""/>
</div>
<div class="productsgallery_mosaic340 mosaicgap10left5right">
	<img class="img-responsive" src="../../../images/gallery/ihearthome_thumb_healthbreakfast.png" alt=""/>		
</div>
<div class="productsgallery_mosaic170 mosaicgap5left">
	<img class="img-responsive" src="../../../images/gallery/ihearthome_thumb_cereal_love.png" alt=""/>
	<div class="height10"></div>
	<img class="img-responsive" src="../../../images/gallery/ihearthome_thumb_goodcatchup.jpg" alt=""/>
</div>

<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>

<?php 
// echo dsf_print_array($gallery_details);
?>