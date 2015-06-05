

<!-- body //-->
<?php

// #########################################
		$banner_array = array('image_one' => $dsv_banner_one_image,
						 'thumb_one' => $dsv_banner_one_thumb,
						 'url_one' => $dsv_banner_one_url,
						 'url_one_window' => $dsv_banner_one_window,
						 'image_two' => $dsv_banner_two_image,
						 'thumb_two' => $dsv_banner_two_thumb,
						 'url_two' => $dsv_banner_two_url,
						 'url_two_window' => $dsv_banner_two_window,
						 'image_three' => $dsv_banner_three_image,
						 'thumb_three' => $dsv_banner_three_thumb,
						 'url_three' => $dsv_banner_three_url,
						 'url_three_window' => $dsv_banner_three_window,
						 'image_four' => $dsv_banner_four_image,
						 'thumb_four' => $dsv_banner_four_thumb,
						 'url_four' => $dsv_banner_four_url,
						 'url_four_window' => $dsv_banner_one_window,
						 'colour_one' => $banner_one_bak_colour,
						 'background_one' => $banner_one_bak_image,
						 'colour_two' => $banner_two_bak_colour,
						 'background_two' => $banner_two_bak_image,
						 'colour_three' => $banner_three_bak_colour,
						 'background_three' => $banner_three_bak_image,
						 'colour_four' => $banner_four_bak_colour,
						 'background_four' => $banner_four_bak_image
						 );
	
			$dsv_banner_override_width = 980;
			$dsv_banner_override_height = 176;
			
 // #######  SECTION 1 #############

  if ($dsv_category_level == 'nested') {
	// include the nested category module.
?>
		
<div id="dsContentMaskB"></div>
<div id="dsMaskHolderB"></div>
<div id="contentHeader"><?php echo dsf_background_scrollB($banner_array); ?></div>
<div id="dsContent">
	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    <div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
    <div class="clear"></div>
    <h1><?php echo ds_strtoupper($dsv_category_name); ?></h1>
    
    <?php /*
		<div id="dsSUBNav">
			<div id="dsCATLabel"><?php echo TRANSLATION_ACCESSORIES;?></div>
			<?php include('custom_modules/categories_parts_nav.php');?>
			</div>
	*/?>
	
<?php

	// decide whether or not to show a listing image
	
	  /* if (isset($dsv_category_listing_image) && strlen($dsv_category_listing_image)>1){
	  
	  	// next check to see if its flash or whether or standard image.
			if (isset($dsv_category_listing_image_type) && $dsv_category_listing_image_type == 'flash'){
				echo '<div class="categoryImage">' . dsf_flash_file($dsv_category_listing_image_width, $dsv_category_listing_image_height, $dsv_category_listing_image, $dsv_category_name, $dsv_category_name) . '</div>';
			}else{
				echo '<div class="categoryImage">' . dsf_image($dsv_category_listing_image, $dsv_category_name) . '</div>';
			}
		
	 
	  }
	*/?>
<?php	
		if (isset($dsv_category_short_text) && strlen($dsv_category_short_text) >1){
			echo'<div class="dsCATtxt">' . $dsv_category_short_text . '</div><div class="lineBreak"></div>';
		} ?>
		
	<?php include($dsv_modules . 'default/nested_category_parts.php');

// end of nested category:

 // #######  SECTION 2 #############

// otherwise check for sub-homepage

  }elseif ($dsv_category_level == 'subpage') {

	// include the nested category module then subpage stuff at the end.
	
?>
<div id="dsContentMaskB"></div>
<div id="dsMaskHolderB"></div>
<div id="contentHeader"><?php echo dsf_background_scrollB($banner_array); ?></div>
<div id="dsContent">
	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
   	<div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
    <div class="clear"></div>
    <h1><?php echo ds_strtoupper($dsv_category_name); ?></h1>

	<?php	
		if (isset($dsv_category_short_text) && strlen($dsv_category_short_text) >1){
			echo'<div class="dsCATtxt">' . $dsv_category_short_text . '</div><div class="lineBreak"></div>';
		} ?>
        
	<?php include($dsv_modules . 'default/nested_category_parts.php');


// end of subpage category:

 // #######  SECTION 3 #############

	// otherwise check for products listing
  } else if ($dsv_category_level == 'products') {

	// decide whether to put text title or image title
	
	/*if (isset($dsv_category_title_image) && strlen($dsv_category_title_image)> 3){
		?>
	<div id="dspagesHeaderTitle"><?php echo dsf_image($dsv_category_title_image , $dsv_category_title); ?></div>
	<?php
	}
	
	*/?>
		
<div id="dsContentMaskB"></div>
<div id="dsMaskHolderB"></div>
<div id="contentHeader"><?php echo dsf_background_scrollB($banner_array); ?></div>
<div id="dsContent">
	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    <div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
    <div class="clear"></div>
    <h1><?php echo ds_strtoupper($dsv_category_name); ?></h1>

	<?php	
		if (isset($dsv_category_short_text) && strlen($dsv_category_short_text) >1){
			echo'<div class="dsCATtxt">' . $dsv_category_short_text . '</div><div class="lineBreak"></div>';
		}

	// sort products box but only if there are items to show.
		if ((int)$dsv_product_items >1){
			echo'<div class="sortBox">' . $dsv_products_sort_box . '</div><div class="clear"></div>';
		}

				if ($dsv_list_type == 'grid'){
					include($dsv_modules . 'default/product_listing_column_parts.php');
				}

  } // end of nested or products
?>

</div>
<!-- body_end //-->
<?php 
// any external scripts (floodlight) will be in this variable of it will be blank.
if (isset($ex_script_text)){
	echo $ex_script_text;
}
?>