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
<!-- Cooking Header Panel //-->
<div class="header__cookbake">
	<div class="col-sm-5 headerleft_red">
		<h1 class="headertitle"><?php echo $article_details['text_one'];?></h1>
		<p class="introtext"><?php echo $article_details['text_two'];?></p>
		<p><?php echo $article_details['text_block_one'];?></p>
	</div>
	<div class="col-sm-7 nopaddingoutter overflowhidden">
	 <?php echo dsf_image($article_details['article_image_one'], $article_details['article_image_one_text'],'','');?>
	</div>
</div>

<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>