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



//echo '<h1>ARRAY = </h1>' . dsf_print_array($article_details);



// out of this document we need to create the following options:
/*

1. Full row of products no video no associated item
2. Products with video no associated item
3. All active
4. product and associated items no video

*/

$sr_display_level = 0;

if (isset($article_details['allocated_items'][0]['article_include_type'])){
	
	$sr_allocated = 'true';
}else{
	$sr_allocated = 'false';
}

if (isset($article_details['article_products']) && sizeof($article_details['article_products']) > 0){
	
	$sr_products = 'true';
}else{
	$sr_products = 'false';
}


if (isset($article_details['article_youtube_link']) && strlen($article_details['article_youtube_link']) > 10){
	
	$sr_video = 'true';
}else{
	$sr_video = 'false';
}

if ($sr_allocated == 'true' && $sr_products == 'true' && $sr_video == 'true'){
	$sr_display_level = 1;
}elseif ($sr_allocated == 'false' && $sr_products == 'true' && $sr_video == 'true'){
	$sr_display_level = 2;
}elseif ($sr_allocated == 'false' && $sr_products == 'true' && $sr_video == 'false'){
	$sr_display_level = 3;
//}elseif ($sr_allocated == 'false' && $sr_products == 'true' && $sr_video == 'false'){
	//$sr_display_level = 4;
}

//echo '<div style="color:#ffff00;">';
//echo 'ALLOCATED ITEM = ' . $sr_allocated . '<br />';
//echo 'PRODUCTS = ' . $sr_products . '<br />';
//echo 'VIDEO = ' . $sr_video . '<br />';
//echo 'LEVEL = ' . $sr_display_level;

//echo '</div>';


if ($sr_display_level == 1){
	// displaying products, video and article
	
			
?>
<div class="col-md-2 nopaddingoutter weeklywinner">

    <div class="height15"></div>
    <div class="">empty manual item</div>
</div>
    
<div class="col-sm-4 items250holder_home" style="width: 277px; ">
<h3 class="generalh3_product marginbottom10fix"><?php echo sr_heart_replace($article_details['text_one']);?></h3>
	   <div class="jcarousel-wrapper">
	        <div class="jcarousel">
	            <ul>
            <?php
				// loop through children
				foreach ($article_details['article_products'] as $item){
			?>
                   	<li class="items250 curvedcorners">
                    <div class="imageholders"><a href="<?php echo $item['url'];?>"><?php echo dsf_image($item['standard_image'], $item['name'], '', '', 'class="img-responsive productcarousel_position"');?></a></div>
                    <div class="productcarousel_text">
                        <p class="productcarousel_name"><?php echo $item['name'];?></p>
                        <div class="height30"></div>
                        <a class="btn btn-red btn-xs font14" href="<?php echo $item['url'];?>">
        				<?php 
                                  if ($dsv_disable_ecommerce == 'false'){
                                      echo TRANSLATION_MOBILE_SHOP_NOW;
                                  }else{
                                      echo TRANSLATION_FIND_OUT_MORE;
                                  }
                        ?>
						</a>
                    </div>
                </li>   
			<?php 
			}
			?>

            </ul>
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

<div class="col-sm-6 nopaddingright">
	<h3 class="generalh3_product"><?php echo sr_heart_replace($article_details['text_two']);?></h3>
	<div class="videoWrapper">
		<?php echo $article_details['article_youtube_link'];?>
	</div>
	<div class="productslider_bg text-center">
		<p class="paddingtop15"><?php echo sr_heart_replace($article_details['article_video_text']);?></p>
		<div class="height5"></div>
		<a class="btn btn-red btn-xs font14 marginbottom15" href="<?php echo $article_details['text_eight'];?>">
		<?php         
			  if ($dsv_disable_ecommerce == 'false'){
				  echo TRANSLATION_MOBILE_SHOP_NOW;
			  }else{
				  echo TRANSLATION_FIND_OUT_MORE;
			  }
		?>
			</a>
	</div>
</div>

<?php
} // end 1

if ($sr_display_level == 2){
	// displaying products, video only
	
?>

<div class="col-sm-6 firstfix">
	<h3 class="generalh3_product"><?php echo sr_heart_replace($article_details['text_one']);?></h3>
	<div class="jcarousel-wrapper paddingleft30">
		<div class="jcarousel">
            <ul>
            <?php
				// loop through children
				foreach ($article_details['article_products'] as $item){
			?>
                   	<li class="items curvedcorners">
                    <div class="imageholders"><a href="<?php echo $item['url'];?>"><?php echo dsf_image($item['standard_image'], $item['name'], '', '', 'class="img-responsive productcarousel_position"');?></a></div>
                    <div class="productcarousel_text">
                        <p class="productcarousel_name"><?php echo $item['name'];?></p>
                        <div class="height30"></div>
                        <a class="btn btn-red btn-xs font14" href="<?php echo $item['url'];?>">
        				<?php 
                                  if ($dsv_disable_ecommerce == 'false'){
                                      echo TRANSLATION_MOBILE_SHOP_NOW;
                                  }else{
                                      echo TRANSLATION_FIND_OUT_MORE;
                                  }
                        ?>
						</a>
                    </div>
                </li>   
			<?php 
			}
			?>
 
            </ul>
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

<div class="col-sm-6 nopaddingright">
	<h3 class="generalh3_product"><?php echo sr_heart_replace($article_details['text_two']);?></h3>
	<div class="videoWrapper">
		<?php echo $article_details['article_youtube_link'];?>
	</div>
	<div class="productslider_bg text-center">
		<p class="paddingtop15"><?php echo sr_heart_replace($article_details['article_video_text']);?></p>
		<div class="height5"></div>
		<a class="btn btn-red btn-xs font14 marginbottom15" href="<?php echo $article_details['article_products'][0]['url'];?>">
		<?php         
			  if ($dsv_disable_ecommerce == 'false'){
				  echo TRANSLATION_MOBILE_SHOP_NOW;
			  }else{
				  echo TRANSLATION_FIND_OUT_MORE;
			  }
		?>
			</a>
	</div>
</div>

<?php
} // end 2

if ($sr_display_level == 3){
	// displaying products only
	
?>

<div class="col-sm-12 nopaddingright">
	<h3 class="generalh3_product"><?php echo sr_heart_replace($article_details['text_one']);?></h3>
	<div class="jcarousel-wrapper fourcarouselwrap">
		<div class="jcarousel">
            <ul class="itemsfull">                    
            <?php
				// loop through children
				foreach ($article_details['article_products'] as $item){
			?>
                   	<li class="itemsfull curvedcorners">
                    <div class="imageholders"><a href="<?php echo $item['url'];?>"><?php echo dsf_image($item['standard_image'], $item['name'], '', '', 'class="img-responsive productcarousel_position"');?></a></div>
                    <div class="productcarousel_text">
                        <p class="productcarousel_name"><?php echo $item['name'];?></p>
                        <div class="height30"></div>
                        <a class="btn btn-red btn-xs font14" href="<?php echo $item['url'];?>">
        				<?php 
                                  if ($dsv_disable_ecommerce == 'false'){
                                      echo TRANSLATION_MOBILE_SHOP_NOW;
                                  }else{
                                      echo TRANSLATION_FIND_OUT_MORE;
                                  }
                        ?>
						</a>
                    </div>
                </li>   
			<?php 
			}
			?>
            
            </ul>
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

<?php
} // end 3

?>

<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>