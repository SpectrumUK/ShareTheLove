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

<!-- Competition Panel //-->
<div class="col-sm-7 compholder_product">
	<div class="col-sm-6 competitionholder_info">
		<h4 class="comptitle_product"><?php echo $article_details['text_one'];?></h4>
		<p class="compsubtitle_product"><?php echo $article_details['text_two'];?></p>
		<p class="fontfixsizer"><?php echo $article_details['text_block_one'];?></p>
		<p class="font13 redtxt"><?php echo $article_details['text_three'];?></p>
	</div>
	<div class="col-sm-6 paddingtop15 nopaddingoutter">	
		 <img class="img-responsive" src="../../../images/custom/ihearthome/layout/breakfast/aurakitchen_comp.png" alt="i love breakfast" />
	</div>
	<div class="col-sm-12 padding020">
		<div class="enterboxes curvedcorners">
			<p class="small11 blacktxt"><?php echo $article_details['text_four'];?></p>
			<div class="steps_numbered"></div>
		</div>
		<div class="enterboxes curvedcorners">
			<p class="small11 blacktxt"><?php echo $article_details['text_five'];?></p>
			<div class="steps_numbered_2"></div>
		</div>
		<div class="enterboxes_red curvedcorners">
			<p class="whitetxt nopaddingoutter nomargin"><?php echo $article_details['text_six'];?></p>
		</div> 
	</div>
</div>

<!-- Recipe Panel //-->
<div class="col-sm-5 howto_competition">
	<h3 class="generalh3_product"><?php echo $article_details['text_seven'];?></h3>
	<div class="jcarousel-wrapper">
		<div class="jcarousel">
			<ul>
				<li class="howto">
					<img class="img-responsive" src="../../../images/custom/ihearthome/layout/breakfast/smoothie1.jpg" alt="i love breakfast" />
					<div class="productslider_bg text-center paddingtop15 nopaddingoutter height140">
						<p class="font18 gothambold">Banana, vanilla <br>&amp; honey smoothie</p>
						<div class="height15"></div>
						<button type="button" class="btn btn-red btn-xs font14">How to make it</button>
					</div>
				</li>
			</ul>
		</div>
	
		<a href="#" class="jcarousel-control-prev howtoprev"><img class="img-responsive" src="../../../images/custom/ihearthome/icons/productslideleft.png" alt=""/></a>
		<a href="#" class="jcarousel-control-next howtonext"><img class="img-responsive" src="../../../images/custom/ihearthome/icons/productslideright.png" alt=""/></a>
	</div>
</div>

<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>