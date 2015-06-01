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

<!-- WHAT WILL APPEAR BELOW HERE?? //-->
<?php 
	// only show featured products section if there are products to show.
	if (isset($article_details['products']) && sizeof($article_details['products'])> 0){

		$total_products = sizeof($article_details['products']);
?>
	<?php
	
	for ($i=0, $n=$total_products; $i<$n; $i++) {
		?>
			<div class="dsPROList"><?php
			
		if (isset($article_details['products'][$i]['awards'][0]['image'])) { // if we have an item in the array, we just want the first one found as we can not have new and special used together
				echo dsf_image($article_details['products'][$i]['awards'][0]['small_image'], $article_details['products'][$i]['awards'][0]['title'], '','', 'class="dsPROLabel"');
			}// end if award
		?>
			<a href="<?php echo $article_details['products'][$i]['url'];?>" title="<?php echo TRANSLATION_FIND_OUT_MORE . ' ' . $article_details['products'][$i]['title'];?>">
			<?php echo dsf_image($article_details['products'][$i]['image'], TRANSLATION_FIND_OUT_MORE . ' ' . $article_details['products'][$i]['title'], $article_details['products'][$i]['width'], $article_details['products'][$i]['height'], 'class="dsProIMG"');?></a>
			<div class="dsProTitle"><a href="<?php echo $article_details['products'][$i]['url'];?>" title="<?php echo TRANSLATION_FIND_OUT_MORE . ' ' . $article_details['products'][$i]['title'];?>"><?php echo $article_details['products'][$i]['title'];?></a></div>
			<div class="dsProModel"><a href="<?php echo $article_details['products'][$i]['url'];?>" title="<?php echo TRANSLATION_FIND_OUT_MORE . ' ' . $article_details['products'][$i]['title'];?>"><?php echo $article_details['products'][$i]['model'];?></a></div>
			</div>
	<?php
	}
	?>
<?php
}
?>
<!-- WHAT WILL APPEAR ABOVE HERE?? //-->

<!-- Show Prods Love Four Column Carousel //-->
<div class="col-sm-12 nopaddingright">
	<h3 class="generalh3_product"><?php echo $article_details['text_one'];?></h3>
	<div class="jcarousel-wrapper fourcarouselwrap">
		<div class="jcarousel">
			<?php
				// check we have items to show
				
				if ((int)$dsv_product_items >0){
				// start with category name with a unique id using the slug field
				
				$total_products = sizeof($dsv_products);
				
				// create unordered list
				$data_to_return .='<ul class="itemsfull">';
				
				// loop through the remaining products
				for ($i=0, $n=$total_products; $i<$n; $i++) {
				
				$data_to_return .= '<li class="itemsfull curvedcorners">';
			?>
				<div class="imageholders">
					<?php echo '<a href="' . $item['url'] . '">' . dsf_image($item['image'], $item['name'] . ' ' . $item['model'], $item['width'], $item['height'], 'class="img-responsive productcarousel_position"') . '</a>';?>
				<div>
				<div class="productcarousel_text">
					<?php echo '<a href="' . $item['url'] . '">' . $item['name'] . '</a>';?>
					<img class="img-responsive" style="margin: 0 auto;" src="../../../images/custom/ihearthome/icons/rating_stats.png" alt=""/>
					<?php echo '<a href="' . $item['url'] . '">' . $item['model'] . '</a>';?>
					<div class="height20"></div>
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
		<a href="#" class="jcarousel-control-prev productslideleft">
			<img class="" src="../../../images/custom/ihearthome/icons/productslideleft.png" alt=""/>
		</a>
		<a href="#" class="jcarousel-control-next productslideright">
			<img class="" src="../../../images/custom/ihearthome/icons/productslideright.png" alt=""/>
		</a>
	</div>
</div>

<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>