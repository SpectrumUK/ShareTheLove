<!-- ALL OF US LOVE GALLERY CONTENT //-->

<?php
// this file can be either accessed directly as a seasonal_article  (when viewed as a standalone item)
// or as a child of the mancave item (where we include the file so everything is on one page).

// as such there are two possible arrays where our information could be in.

// STANDALONE - the details would be in seasonal_details

// CHILD - the details would be in $child  (as defined by the content page looping through the children) originally it will be within the $seasonal_details['children'] array.

// because of this we need to define where our data is and use it accordingly.   The easiest way is to check for the $child variable


// we will store the values we want to use into a new variable called $article_details
if (isset($child)){
	// we are being included as a child.
	$article_details = $child;
}else{
	// we are standalone.
	$article_details = $seasonal_details;
}
?>

<?php if (isset($article_details['user_images']['total_images']) && $article_details['user_images']['total_images'] > 1){
	  	if (isset($article_details['user_images']['total_images']) && $article_details['user_images']['total_images'] > 4){
?>
<h3 class="generalh3_product"><?php echo sr_heart_replace($article_details['text_one']);?></h3>
<div class="productsgallery_mosaic170 mosaicgap5right">
	<?php echo dsf_image($article_details['user_images']['images'][4]['image_one_thumb'],'','','','class="img-responsive"');?>
	<div class="height10"></div>
	<?php echo dsf_image($article_details['user_images']['images'][3]['image_one_thumb'],'','','','class="img-responsive"');?>
</div>
<div class="productsgallery_mosaic170 mosaicgap5left">
	<?php echo dsf_image($article_details['user_images']['images'][2]['image_one_thumb'],'','','','class="img-responsive"');?>
	<div class="height10"></div>
    <div class="redsquare_telluswhatyou_ltxt">
    	<a href="<?php echo $SSL_bref;?>image_upload.html?mechanicID=1 
        <?php /*echo $article_details['allocated_items'][0]['seasonal_details']['url']*/;?>">
    		<span class="gothambold font18"><?php echo sr_heart_replace($article_details['allocated_items'][0]['seasonal_details']['text_one']);?></span>
    	</a>
    </div>
</div>
<div class="productsgallery_mosaic340 mosaicgap10left5right">
	<?php echo dsf_image($article_details['user_images']['images'][1]['image_one'],'','340','350');?>	
</div>
<div class="productsgallery_mosaic170 mosaicgap5left">
	<div class="redsquare_stat">
    		<span class="gothambold font32"><?php echo sr_heart_replace($article_details['allocated_items'][1]['seasonal_details']['text_one']);?></span>
            <span class="gothammed font18 red_stattxt"><?php echo sr_heart_replace($article_details['allocated_items'][1]['seasonal_details']['text_two']);?></span>
    </div>
	<div class="height10"></div>
	<?php echo dsf_image($article_details['user_images']['images'][0]['image_one_thumb'],'','','','class="img-responsive"');?>
</div>
<?php 
	}else{
?>
<h3 class="generalh3_product"><?php echo sr_heart_replace($article_details['text_one']);?></h3>
<div class="productsgallery_mosaic170 mosaicgap5right">
	<div class="redsquare_telluswhatyou_ltxt">
    	<a href="<?php echo $SSL_bref;?>image_upload.html?mechanicID=1 
        <?php /*echo $article_details['allocated_items'][0]['seasonal_details']['url']*/;?>">
    		<span class="gothambold font18"><?php echo sr_heart_replace($article_details['allocated_items'][0]['seasonal_details']['text_one']);?></span>
    	</a>
    </div>
	<div class="height10"></div>
	<div class="redsquare_stat">
    		<span class="gothambold font32"><?php echo sr_heart_replace($article_details['allocated_items'][1]['seasonal_details']['text_one']);?></span>
            <span class="gothammed font18 red_stattxt"><?php echo sr_heart_replace($article_details['allocated_items'][1]['seasonal_details']['text_two']);?></span>
    </div>
</div>
<div class="productsgallery_mosaic340 mosaicgap5left">
	<?php echo dsf_image($article_details['user_images']['images'][1]['image_one'],'','340','350');?>		
</div>
<div class="productsgallery_mosaic340 mosaicgap10left0right">
	<?php echo dsf_image($article_details['user_images']['images'][0]['image_one'],'','340','350');?>		
</div>
	<?php
    }
    ?>
<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>
<?php 
}
?>
<?php 
 //echo dsf_print_array ($article_details['allocated_items'][1]['seasonal_details']);
?>