<!-- body //-->
        <?php
/* All products details variables are stored within the array $dsv_product_details */

// make sure product is found and active.


if ((int)$dsv_product_details['id'] > 0 && $dsv_product_details['status'] == 'active'){



// product ok to show
?>
<div id="dsPROstrip" style="background-image: url('<?php echo dsf_image($dsv_product_details['title_image_1'],'','','','','YES');?>');">&nbsp;</div>
<div id="dsContent">
	<div id="dsPROTitle">
		<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo ds_strtoupper ($dsv_product_details['name']);?></h1>
    	<h2><?php echo $dsv_product_details['model']; ?></h2>
    </div>
    <div id="dsPROEcom">
    	<?php         
			// ONLY DO PRICE AND STOCK IF ECOMMERCE IS NOT DISABLED
			if ($dsv_disable_ecommerce == 'false'){
					


				// amendment on 2011-05-31 to show different itmems depending on whether the item is available to purchase.
				
				if ($dsv_product_details['allow_purchase'] == 'true'){


					// Item available to purchase - Standard Routine
					// DELIVERY MESSAGE
				?>
		 						<div class="dsPROStock"><?php
					
					
						
						
										// two different messages depending on whether instock or not
											if ((int)$dsv_product_details['stock'] > 0){
												echo TRANSLATION_INSTOCK;
											}else{
												echo '<span class="dsPRONoStock">' . TRANSLATION_OUTOFSTOCK . '</span>';
											}
									
									?></div>
				
								<?php
				
										if (isset($dsv_product_details['offer_price']) && strlen($dsv_product_details['offer_price'])> 1){
											?>
                                            <div class="dsPROPrice">
											<span class="dsPROWas"><?php echo $dsv_product_details['price'];?></span><span class="dsPRONow">&nbsp;&nbsp;<?php echo $dsv_product_details['offer_price'];?></span></div>
											<?php
										}else{
											?>
											<div class="dsPROPrice"><span class="dsPRORRP"><?php echo $dsv_product_details['price'];?></span></div>
											<?php
										}
						
					}else{
						// the item is not available to purchase therefore look at both the rrp and exclusive tags to see what to do.
						


					// Item available to purchase - Standard Routine
					// DELIVERY MESSAGE
				
				
				
							// if the item is an exclusive, we show the word exlusive in the red out of stock font
							// otherwise we show nothing here.
							
							
							if ($dsv_product_details['web_exclusive'] == 'true'){
								
							?>
		 						<div id="dsPRODel"><div class="dsPROexcl"><?php echo TRANSLATION_EXCLUSIVES;?></div></div>
				
								<?php
							}
							
							
									if ($dsv_enable_rrp == 'true'){
							
												 if (isset($dsv_product_details['rrp_price']) && strlen($dsv_product_details['rrp_price'])>1){
														?>
														<div class="dsPROPrice"><span class="dsPRORRP"><?php echo TRANSLATION_RRP . ' ' . $dsv_product_details['rrp_price'];?></span></div>
														<?php
												  }else{
														// we need a blank row to keep everything formatted correctly.
														?>
														<div class="dsPROPrice"><span class="dsPRORRP">&nbsp;</span></div>
														<?php
												 }
									}else{
									// we need to put a blank in to make everything format correctly.
														?>
														<div class="dsPROPrice"><span class="dsPRORRP">&nbsp;</span></div>
														<?php
									}
						
					}
					
					
					
						
						
			}else{ // ecommerce is disabled.
			
						if ($dsv_enable_rrp == 'true'){
				
									 if (isset($dsv_product_details['rrp_price']) && strlen($dsv_product_details['rrp_price'])>1){
											?>
											<div class="dsPROPrice"><span class="dsPRORRP"><?php echo TRANSLATION_RRP . ' ' . $dsv_product_details['rrp_price'];?></span></div>
											<?php
									  }else{
											// we need a blank row to keep everything formatted correctly.
											?>
											<div class="dsPROPrice"><span class="dsPRORRP">&nbsp;</span></div>
											<?php
									 }
						}else{
						// we need to put a blank in to make everything format correctly.
											?>
											<div class="dsPROPrice"><span class="dsPRORRP">&nbsp;</span></div>
											<?php
						}
			
			} // end ecommerce disabled
			?>
            
            <div class="dsPROBtn">
    	<?php
		if (isset($dsv_product_details['buy_url']) && strlen($dsv_product_details['buy_url']) > 2){
			?>
			<a href="<?php echo $dsv_product_details['buy_url'];?>"><?php echo dsf_image_button('button_add_to_basket.gif', TRANSLATION_ADD_TO_BASKET_BUTTON);?></a>
			<?php
		}else { // show where to buy button
			?>
			<a href="<?php echo $dsv_product_details['wtb_url'];?>"><?php echo dsf_image_button('w2b_btn.gif', TRANSLATION_WTB_BUTTON);?></a>
			<?php
		}
		?>
    </div>
    </div>
    <div class="clear"></div>
    <div id="dsPROLeft">
    	<div class="dsPROImg">
    		<div class="dsPROMain">
			<?php 
					if (isset($dsv_product_details['category_image']) && strlen($dsv_product_details['category_image'])>1){
							$file = str_replace("sized/details/" , "" , $dsv_product_details['category_image']);
							echo dsf_image($file , $dsv_product_details['name']);
					}?>
            <!-- thumbnails -->
		<?php if(isset($dsv_product_details['image_1_thumb']) && strlen($dsv_product_details['image_1_thumb'])>1){
		// only do small product thumbs if at least 1 exists.
				
				
				// we need to do a totally different procedures to normal for this design.
				
				// firstly,  instead of just creating a thumbnail with javascript to change the main pic,  we have to create an overlay
				// to store the large popup image in.
				
				// secondly we need to create the thumbnails with javascript mouseover and mouseout controls to make it all work.
				
				// to do this,  we need to loop through the images to see what we need to create and then create two items (large pic and thumb)
				// rather than just echoing thumbnails as the previous code would normally do.
				
				// JOB 1, put the images into a usable array that we can loop through.
				
				$swapOver = array();
				
						if (isset($dsv_product_details['image_1_thumb']) && strlen($dsv_product_details['image_1_thumb']) >1){
							$swapOver[1] = array('image' => $dsv_product_details['image_1'],
												 'image_alt' => '',
												 'thumb' => $dsv_product_details['image_1_thumb'],
												 'thumb_alt' => '');
						}
						
						
							if (isset($dsv_product_details['image_2_thumb']) && strlen($dsv_product_details['image_2_thumb']) >1){
							$swapOver[2] = array('image' => $dsv_product_details['image_2'],
												 'image_alt' => '',
												 'thumb' => $dsv_product_details['image_2_thumb'],
												 'thumb_alt' => '');
						}
					
						
							if (isset($dsv_product_details['image_3_thumb']) && strlen($dsv_product_details['image_3_thumb']) >1){
							$swapOver[3] = array('image' => $dsv_product_details['image_3'],
												 'image_alt' => '',
												 'thumb' => $dsv_product_details['image_3_thumb'],
												 'thumb_alt' => '');
						}

							if (isset($dsv_product_details['image_4_thumb']) && strlen($dsv_product_details['image_4_thumb']) >1){
							$swapOver[4] = array('image' => $dsv_product_details['image_4'],
												 'image_alt' => '',
												 'thumb' => $dsv_product_details['image_4_thumb'],
												 'thumb_alt' => '');
						}
				
				
				
				// create an absolute div reference to put all of the found hover images into?>
                
                <div id="dsPROHvrInset">
                	<?php
						reset($swapOver); // reset array to begining.
						foreach ($swapOver as $id => $value){
								?>
                                <div id="dsPROHvr<?php echo $id;?>" class="dsPROHvrItem"><?php echo dsf_image($value['image'] , $value['image_alt']);?></div>
								<?php
						}
						?>
                </div>
                
          
          
          </div>
                <div class="dsPROInsets"><?php
				
				// now create the thumbails for the above large images

						reset($swapOver); // reset array to begining.
						foreach ($swapOver as $id => $value){
								?>
                                <a href="javascript:void(0);" onmouseover="dsShow('dsPROHvr<?php echo $id;?>');" onmouseout="dsHide('dsPROHvr<?php echo $id;?>');"><?php echo dsf_image($value['thumb'] , $value['thumb_alt'], $dsv_product_details['thumb_width'], $dsv_product_details['thumb_height']);?></a>
								<?php
						}



	/*
	// previous thumb code.
	
				
	 // small thumb 1 if it exists
	if (isset($dsv_product_details['image_1_thumb']) && strlen($dsv_product_details['image_1_thumb']) >1){
	?>
		  <a href="javascript:LargeImage('mainpic','','<?php echo dsf_image_swap($dsv_product_details['image_1']);?>',0);" onmouseover="LargeImage('mainpic','','<?php echo dsf_image_swap($dsv_product_details['image_1']);?>',0);">
		  <?php echo dsf_image($dsv_product_details['image_1_thumb'],'',$dsv_product_details['thumb_width'], $dsv_product_details['thumb_height'],'name="thumb1"');?></a>
	<?php
	}
	
	// small thumb 2 if it exists
	if (isset($dsv_product_details['image_2_thumb']) && strlen($dsv_product_details['image_2_thumb']) >1){
	?>
		  <a href="javascript:LargeImage('mainpic','','<?php echo dsf_image_swap($dsv_product_details['image_2']);?>',0);" onmouseover="LargeImage('mainpic','','<?php echo dsf_image_swap($dsv_product_details['image_2']);?>',0);">
		  <?php echo dsf_image($dsv_product_details['image_2_thumb'],'',$dsv_product_details['thumb_width'], $dsv_product_details['thumb_height'],'name="thumb2"');?></a>
	<?php
	}

	// small thumb 3 if it exists
	if (isset($dsv_product_details['image_3_thumb']) && strlen($dsv_product_details['image_3_thumb']) >1){
	?>
		  <a href="javascript:LargeImage('mainpic','','<?php echo dsf_image_swap($dsv_product_details['image_3']);?>',0);" onmouseover="LargeImage('mainpic','','<?php echo dsf_image_swap($dsv_product_details['image_3']);?>',0);">
		  <?php echo dsf_image($dsv_product_details['image_3_thumb'],'',$dsv_product_details['thumb_width'], $dsv_product_details['thumb_height'],'name="thumb3"');?></a>
	<?php
	}

	// small thumb 4 if it exists
	if (isset($dsv_product_details['image_4_thumb']) && strlen($dsv_product_details['image_4_thumb']) >1){
	?>
		  <a href="javascript:LargeImage('mainpic','','<?php echo dsf_image_swap($dsv_product_details['image_4']);?>',0);" onmouseover="LargeImage('mainpic','','<?php echo dsf_image_swap($dsv_product_details['image_4']);?>',0);">
		  <?php echo dsf_image($dsv_product_details['image_4_thumb'],'',$dsv_product_details['thumb_width'], $dsv_product_details['thumb_height'],'name="thumb4"');?></a>
	<?php
	}



	*/ 
	// end of previous thumb code.

	?>
 
				
				<?php
				
		} // end of deciding whether to do thumbnails.
		?>
<!-- end thumbnails -->
               </div>   
    	</div>
        <?php /*if (isset($dsv_product_details['flash_1']) && strlen($dsv_product_details['flash_1']) > 3){
				?>
        <div class="dsPROVideo">
        	<?php echo dsf_flash_file($dsv_product_details['flash_1_width'], $dsv_product_details['flash_1_height'], $dsv_product_details['flash_1'], $dsv_product_details['promo_title'], $dsv_product_details['promo_title']);?></div>
        	<div class="dsPROVTitle"><?php echo $dsv_product_details['promo_title'];?></div>
			<div class="dsPROVTxt"><?php echo $dsv_product_details['promo_description'];?></div>
         
		<?php
		// end we have video.   check to see if we have a youtube line instead.
	}elseif (isset($dsv_product_details['youtube_link']) && strlen($dsv_product_details['youtube_link']) > 3){ 
				?>
        <div class="dsPROVideo">
	<?php
						// look to see if only the url has been input or full code.
						if (strtoupper(substr($dsv_product_details['youtube_link'],0,4)) == 'HTTP'){
								// url only
						
							echo '<object style="height: 259px; width: 460px"><param name="movie" value="' . $dsv_product_details['youtube_link'] . '"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><param name="wmode" value="opaque"><embed src="' . $dsv_product_details['youtube_link'] . '" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="460" height="259" wmode="opaque"></object>';
						
						}else{
							// full content
							echo $dsv_product_details['youtube_link'];
						}
	?></div>
        	<div class="dsPROVTitle"><?php echo $dsv_product_details['promo_title'];?></div>
			<div class="dsPROVTxt"><?php echo $dsv_product_details['promo_description'];?></div>
    	<?php
			}
			*/?>
    </div>
    <div id="dsPRORight">
    	<div id="dsTABRight">
        	<ul>
		        <li class="RTAB_OverviewActive" onclick="showdamenu(2);" id="tabAltTwo"><a href="#"><?php echo TRANSLATION_CUSTOM_TEXT_FIVE;?></a></li>
                <?php /*<li class="RTAB_Features" onclick="showdamenu(1);" id="tabAltOne"><a href="#"><?php echo TRANSLATION_ALL_FEATURES;?></a></li>*/?>
</ul>
        </div>
		<div id="RATB_Holder">
            <?php /*<div id="tab-features">
            	<?php
				 if (isset($dsv_product_details['products_othernames']) && is_array($dsv_product_details['products_othernames'])){
				 	?>
					<div class="featureList">
            		<ul>
                		<?php
							foreach ($dsv_product_details['products_othernames'] as $item){
								echo '<li>' . $item . '</li>' . "\n";
							}
							?>
                	</ul>
                </div>
				<?php
				} // end we have features
				
				
				// feature icons
				if (is_array($dsv_product_details['feature_images'])){
				?>
				
                <div class="featureIcons">
            		<ul>
                <?php
						foreach($dsv_product_details['feature_images'] as $item){
							echo '<li>' . dsf_image($item['image'] , $item['title']) . '</li>' . "\n";
                		}
				?>
					</ul>
                </div>
				<?php
				}
				?>
            </div>*/?>
		  <div id="tab-overview">
            	<div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
                <?php /*<div class="dsPROtxt"><?php echo $dsv_product_details['description'];?></div>*/?>
                <div class="featureList"><?php echo $dsv_product_details['products_othernames'];?></div>
				<?php
				// end we have features
                
                if (isset($dsv_product_details['flash_1']) && strlen($dsv_product_details['flash_1']) > 3){
				?>
        <div class="dsPROVideo">
        	<?php echo dsf_flash_file($dsv_product_details['flash_1_width'], $dsv_product_details['flash_1_height'], $dsv_product_details['flash_1'], $dsv_product_details['promo_title'], $dsv_product_details['promo_title']);?></div>
        	<div class="dsPROVTitle"><?php echo $dsv_product_details['promo_title'];?></div>
			<div class="dsPROVTxt"><?php echo $dsv_product_details['promo_description'];?></div>
         
		<?php
		// end we have video.   check to see if we have a youtube line instead.
	}elseif (isset($dsv_product_details['youtube_link']) && strlen($dsv_product_details['youtube_link']) > 3){ 
				?>
        <div class="dsPROVideo">
	<?php
						// look to see if only the url has been input or full code.
						if (strtoupper(substr($dsv_product_details['youtube_link'],0,4)) == 'HTTP'){
								// url only
						
							echo '<object style="height: 248px; width: 440px"><param name="movie" value="' . $dsv_product_details['youtube_link'] . '"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><param name="wmode" value="opaque"><embed src="' . $dsv_product_details['youtube_link'] . '" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="440" height="248" wmode="opaque"></object>';
						
						}else{
							// full content
							echo $dsv_product_details['youtube_link'];
						}
	?></div>
        	<div class="dsPROVTitle"><?php echo $dsv_product_details['promo_title'];?></div>
			<div class="dsPROVTxt"><?php echo $dsv_product_details['promo_description'];?></div>
    	<?php
			}
			?>
                <?php
	
	if (isset($dsv_product_details['disclaimer_text']) && is_array($dsv_product_details['disclaimer_text'])){

				echo '<div class="dsPROdisclaimer">' . $dsv_product_details['disclaimer_text'] . '</div>';				
	}
	
	if (isset($dsv_product_details['articles']) && is_array($dsv_product_details['articles']) && sizeof($dsv_product_details['articles']) > 0){
	
		?>
        <div class="dsPROArt">
        	<ul>
        		<?php
				
				foreach($dsv_product_details['articles'] as $item){
				
				?> 
				<li><div class="dsPROArtImg"><?php echo dsf_image($item['image'], $item['title'], $item['image_width'], $item['image_height']);?></div>
                	<div class="dsPROArtTitle"><?php echo $item['title'];?></div>
                    <?php echo $item['teaser'];?>
                </li>
				<?php
				}
				?>
        	</ul>
        </div>
        <?php 
				}
	if (isset($dsv_product_details['products_documentation']) && strlen($dsv_product_details['products_documentation'])){
	?>
	    <div class="dsPROdoc">
        	<a href="<?php echo $dsv_product_details['products_documentation'];?>" title="<?php echo $dsv_product_details['name'] . ' ' . $dsv_product_details['model'];?>" target="blank"><?php echo TRANSLATION_DOWNLOAD_MANUAL;?></a>
        </div>
	<?php
	}
	?>
		  </div>
			<div id="RATB_ftr"><?php echo dsf_image('custom/protab_holder_ftr.png', '', '469', '18');?></div>
		</div>
		

    
	
	
	</div>
    <div class="clear"></div>  
<div id="dsTABMore">
    	<ul>
        	<li class="TABM_RelatedActive" onclick="showdamenu(3);" id="tabAltThree"><a href="#" rel="nofollow"><?php echo TRANSLATION_RELATED_PRODUCTS;?></a></li>
        </ul>
        <div class="clear"></div>
		
        <div id="dsRPContent">
        	<?php
			if (isset($dsv_product_details['related_products']) && is_array($dsv_product_details['related_products'])){
				?>
			 <ul>
            	<?php
				$total_related = sizeof($dsv_product_details['related_products']);
				if ($total_related > 6){
					$total_related = 6;
				}
				$total_counter = 0;
				foreach($dsv_product_details['related_products'] as $item){
						$total_counter ++;
						
						if ($total_counter <= $total_related){
							?>
							<li class="dsRPList">
								<?php echo '<a href="' . $item['url'] . '">' . dsf_image($item['image'], $item['name'] . ' ' . $item['model'], $item['width'], $item['height']) . '</a>';?>
								<div class="dsPROTitle"><?php echo '<a href="' . $item['url'] . '">' . $item['name'] . '</a>';?></div>
								<div class="dsPROModel"><?php echo '<a href="' . $item['url'] . '">' . $item['model'] . '</a>';?></div>
							</li>
						<?php
						}
				}
						?>
            </ul>
			<?php
			}
			?>
            <div class="clear"></div>  
        </div>
		<div class="clear"></div>
    </div>

</div>     

<?php 
}else{
	// product is either not found or disabled
	echo '<div class="dsProdNotFound">' . TRANSLATION_PRODUCT_DETAILS_NOT_FOUND . '</div>';
} // end checking for product active.
?>
	</div>
</div>
<?php 
// any external scripts (floodlight) will be in this variable of it will be blank.
if (isset($ex_script_text)){
	echo $ex_script_text;
}
?>