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

<!-- Weekly Winner Panel //-->
<div class="col-md-2 nopaddingoutter weeklywinner">
	<img class="img-responsive" src="../../../images/custom/ihearthome/layout/homepage/weeklywinner.jpg" alt=""/>
	<div class="height15"></div>
	<img class="img-responsive" src="../../../images/custom/ihearthome/layout/breakfast/thumb_cereal_love.png" alt=""/>
</div>

<!-- Show Breakfast Love Single Column Carousel //-->
<div class="col-sm-4 items250holder_home midrange_carouselholder" >
	<h3 class="generalh3_product marginbottom10fix"><?php echo $article_details['text_one'];?></h3>
	<div class="jcarousel-wrapper">
		<div class="jcarousel">
			<?php
				// check we have items to show
				
				if ((int)$dsv_product_items >0){
				// start with category name with a unique id using the slug field
				
				$total_products = sizeof($dsv_products);
				
				// create unordered list
				$data_to_return .='<ul>';
				
				// loop through the remaining products
				for ($i=0, $n=$total_products; $i<$n; $i++) {
				
				$data_to_return .= '<li class="items250 curvedcorners">';
			?>
				<div class="imageholdersitems250">
					<?php echo '<a href="' . $item['url'] . '">' . dsf_image($item['image'], $item['name'] . ' ' . $item['model'], $item['width'], $item['height'], 'class="img-responsive productcarousel_position"') . '</a>';?>
				<div>
				<div class="productcarousel_text">
					<?php echo '<a href="' . $item['url'] . '">' . $item['name'] . '</a>';?>
					<img class="img-responsive" style="margin: 0 auto;" src="../../../images/custom/ihearthome/icons/rating_stats.png" alt=""/>
					<?php echo '<a href="' . $item['url'] . '">' . $item['model'] . '</a>';?>
					<div class="height30"></div>
					<button type="button" class="btn btn-red btn-xs font14">Shop now</button>
				</div>
			<?php
				$data_to_return .= '</li>';
				
				}
				// end remaining products loop.
				
				// close unordered list
				$data_to_return .= '</ul>';
			}?>
		</div>
		
		<!-- carousel controls -->
		<a href="#" class="jcarousel-control-prev items250sliderleftfixer">
			<img class="" src="../../../images/custom/ihearthome/icons/productslideleft.png" alt=""/>
		</a>
		<a href="#" class="jcarousel-control-next items250sliderright">
			<img class="" src="../../../images/custom/ihearthome/icons/productslideright.png" alt=""/>
		</a>
	</div>
</div>

<div class="height5 visible-sm"></div>

<!-- We Love Video Panel //-->
<div class="col-md-6 video_home nopaddingright">
	<h3 class="generalh3_product marginbottom10fix"><?php echo $article_details['text_two'];?></h3>
	<div class="videoWrapper">
		<?php echo $article_details['article_youtube_link'];?>
	</div>
	<div class="productslider_bg text-center">
		<p class="paddingtop15"><?php echo $article_details['video_text'];?></p>
		<div class="height5"></div>
		<button type="button" class="btn btn-red btn-xs font14 marginbottom15">Shop now</button>
	</div>
</div>

<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>