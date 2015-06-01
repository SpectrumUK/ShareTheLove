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

<!-- Homepage Header Panel //-->
<div class="col-md-12 firstfix nopaddingright positionrelative">
	<?php echo dsf_image($article_details['dsv_banner_one_image'],'','', 'class="img-responsive"');?>
	<div class="hero_darkgraybg">
		<p class="font22 gothambold marginbottom0"><?php echo $article_details['text_one'];?></p>
		<p><?php echo $article_details['text_two'];?></p>
		<p class="redtxt font18"><strong><?php echo $article_details['text_three'];?></strong></p>
		
		<div class="home_stepsbox curvedcorners">
			<div class="home_stepsbox_icon pull-left"><img class="img-responsive" src="../../../images/custom/ihearthome/icons/steps_icon1.png" alt=""/></div>
			
			<p class="small11 blacktxt"><?php echo $article_details['text_four'];?></p>
		</div>
		<div class="home_stepsbox curvedcorners">
			<div class="pull-left home_stepsbox_icon"><img class="img-responsive" src="../../../images/custom/ihearthome/icons/steps_icon2.png" alt=""/></div>
			<p class="small11 blacktxt"><?php echo $article_details['text_five'];?></p>
		</div>
		<div class="home_stepsboxlast curvedcorners">
			<p class="whitetxt font14 text-center paddingall12"><strong><?php echo $article_details['text_six'];?></p>
		</div>
	</div>
	<div class="home_productplace">
		<a href="#"><img class="img-responsive" src="../../../images/custom/ihearthome/layout/homepage/hero_product.png" alt=""/></a>
		<?php echo $article_details['text_seven'];?>
	</div>
</div>

<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>