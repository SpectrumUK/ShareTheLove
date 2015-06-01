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

<!-- Feature Panel //-->
<div class="col-sm-7 nopaddingoutter">
	<h3 class="generalh3_product"><?php echo $article_details['text_one'];?></h3>
	<div class="col-sm-6 nopaddingoutter productdetails">	
		<p class="font16"><strong><?php echo $article_details['text_two'];?></strong></p>
		<p class="font14"><?php echo $article_details['text_block_one'];?></p>
		<p class="redtxt font16"><?php echo $article_details['text_three'];?></p>
		<?php echo $article_details['text_block_two'];?>
		<p><a href=""><?php echo $article_details['text_four'];?></a></p>
	</div>

	<div class="col-sm-6 paddingtop25 nopaddingoutter">	
		<div class="container-fluid">
			<div id="custom_carousel" class="carousel slide" data-ride="carousel" data-interval="false">
				<!-- Wrapper for slides -->
				<div class="carousel-inner">
					<div class="item active">
						<div class="container-fluid">
							<div class="row">
								<img src="../../../images/custom/ihearthome/products/cooking/breadmaker_show1.png" class="img-responsive">
							</div>
						</div>
					</div> 
				<!-- End Item -->
				</div>
				<!-- End Carousel Inner -->
				
				<div class="controls">
					<ul class="nav">
						<li data-target="#custom_carousel" data-slide-to="0" ><a href="#"><img src="../../../images/custom/ihearthome/products/cooking/breadmaker_show1_thumb.png" style="border: 1px solid #fff;"></a></li>
						<li data-target="#custom_carousel" data-slide-to="1"><a href="#"><img src="../../../images/custom/ihearthome/products/cooking/breadmaker_show2_thumb.png" style="border: 1px solid #fff;"></a></li>
						<li data-target="#custom_carousel" data-slide-to="2"><a href="#"><img src="../../../images/custom/ihearthome/products/cooking/breadmaker_show3_thumb.png" style="border: 1px solid #fff;"></a></li>
					</ul>
				</div>
			</div>
		<!-- End Carousel -->
		</div>
	</div>

</div>

<!-- Video Panel //-->
<div class="col-sm-5 nopaddingright">
	<h3 class="generalh3_product"><?php echo $article_details['text_five'];?></h3>
	<div class="videoWrapper">
		<?php echo $article_details['article_youtube_link'];?>
	</div>
	<div class="productslider_bg text-center video_notcompetition">
		<p class="paddingtop15 gothambold font18"><?php echo $article_details['video_title'];?></p>
		<p><?php echo $article_details['video_text'];?></p>
		<div class="height5"></div>
		<button type="button" class="btn btn-red btn-xs font14">Shop now</button>
	</div>
</div>

<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>