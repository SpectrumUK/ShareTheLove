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
<h3 class="generalh3_product"><?php echo sr_heart_replace($article_details['text_one']);?></h3>

<div class="productsgallery_mosaic170 mosaicgap5right">
	<img class="img-responsive" src="../../../images/custom/ihearthome/layout/neat/thumb_stat_cleaning.png" alt=""/>
	<div class="height10"></div>
	<img class="img-responsive" src="../../../images/custom/ihearthome/layout/neat/thumb_stat_iron.png" alt=""/>
</div>
<div class="productsgallery_mosaic340 mosaicgap5left">
	<img class="img-responsive" src="../../../images/custom/ihearthome/layout/neat/thumb_smart.png" alt=""/>		
</div>
<div class="productsgallery_mosaic340 mosaicgap10left0right">
	<img class="img-responsive" src="../../../images/custom/ihearthome/layout/neat/thumb_assistant.png" alt=""/>		
</div>

<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>

<?php 
// echo dsf_print_array($gallery_details);
?>