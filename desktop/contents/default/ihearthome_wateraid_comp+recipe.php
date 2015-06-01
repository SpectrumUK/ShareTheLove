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

<!-- Competition Panel -->
<div class="col-sm-7 compholder_product wateraid_compholder">
	<div class="col-sm-12 wateraid_compholder_info">
		<h4 class="comptitle_product gothambold">
			<?php echo sr_heart_replace($article_details['text_one']);?>
		</h4>
	</div>
	<div class="col-sm-6 wateraid_compholder_info">
		<p class="compsubtitle_product">
			<?php echo sr_heart_replace($article_details['text_two']);?>
		</p>
		<div class="fontfixsizer">
			<?php echo sr_heart_replace($article_details['text_block_one']);?>
		</div>
	</div>
	<div class="col-sm-12 padding020">
		<div class="enterboxes_red curvedcorners">
			<p class="whitetxt nopaddingoutter nomargin"><a href="<?php echo $SSL_bref;?>image_upload.html?mechanicID=1"><?php echo sr_heart_replace($article_details['text_six']);?></a></p>
		</div>
	</div>
</div>

<!-- WaterAid Info Panel -->
<div class="col-sm-5 howto_competition">
	<h3 class="generalh3_product"><?php echo sr_heart_replace($article_details['text_three']);?></h3>
	<div class="jcarousel-wrapper">
		<div class="jcarousel">
			<ul>
				<li class="howto">
					<img class="img-responsive" src="../../../images/custom/ihearthome/layout/wateraid/howto_wateraid_main_img.jpg" alt="WaterAid" />
					<div class="productslider_bg text-center paddingtop15 nopaddingoutter height140">
						<p class="font18 gothambold"><?php echo $article_details['text_four'];?></p>
						<div class="height15"></div>
						<a href="<?php echo ($article_details['allocated_items'][0]['seasonal_details']['url']);?>" class="btn btn-red btn-xs font14"><?php echo TRANSLATION_FIND_OUT_MORE;?></a>
						
						
					</div>
				</li>
			</ul>
		</div>
	</div>
</div>

<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>