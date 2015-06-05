<?php

		$banner_array = array('image_one' => $dsv_banner_one_image,
						 'thumb_one' => $dsv_banner_one_thumb,
						 'url_one' => $dsv_banner_one_url,
						 'image_two' => $dsv_banner_two_image,
						 'thumb_two' => $dsv_banner_two_thumb,
						 'url_two' => $dsv_banner_two_url,
						 'image_three' => $dsv_banner_three_image,
						 'thumb_three' => $dsv_banner_three_thumb,
						 'url_three' => $dsv_banner_three_url,
						 'image_four' => $dsv_banner_four_image,
						 'thumb_four' => $dsv_banner_four_thumb,
						 'url_four' => $dsv_banner_four_url,
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
			$dsv_banner_override_height = 393;
			
?>
<div id="dsContentMask"></div>
<div id="dsMaskHolder"></div>
<div id="contentHeader"><?php echo dsf_background_scroll($banner_array); ?></div>
<div id="dsContent">
<?php
	/*
	The next stage to the homepage is upto 8 items, each of which could be any one of 10 items
	
	Because of that we need to do a loop of all the possible items and then within the loop check
	which type of item it is and echo which one it is to the page.
	
	The items are held within the Multi-array variable dsv_home_page_items
	
	This variable will be set as an array regardless of whether it contains any data therefore the
	first check should always be to ensure the size is greater than 0.  If it is then the next stage
	is to create the holder and ul sections before starting the loop.
	*/
	

	if (is_array($dsv_home_page_items) && sizeof($dsv_home_page_items)> 0){
	
		// we have items,  create the holder and UL section.
?>
	<div id="dsSMLbanEmpty">&nbsp;</div>
	<?php /* <div id="dsSMLban">
    	<ul>
        	<li>
            	<div class="dsSMLLeft">
                	<a href="#">Free UK Delivery*<br /><span class="dsSMLItem">*UK Mainland Only</span></a>
                </div>    
            </li>
            <li>
            	<div class="dsSMLMid">
            		<a href="http://www.productregister.co.uk/rhobbs" target="_blank">Register Your Product<span class="dsSMLItem"><br />Register online and collect rewards</span></a>
                </div>
            </li>
            <li>
            	<div class="dsSMLRight">
                <a href="<?php echo dsf_link('sale.html');?>">Up to 50% Off*<span class="dsSMLItem"><br />*selected products whilst stock last</span></a>
                </div>
            </li>
        </ul>
    </div> */?>
    <div class="clear"></div>
    <div id="dsList">
    	<ul>
<?php
	
		foreach($dsv_home_page_items as $item){
			
			
			/*
			now we are inside the loop all of the current items data should be in an array
			inside the variable item.   we need to ensure it is an array and that the specific field type
			is set.   it is the value of the field type that we use to decide what to do next.
	
			Possible answers are:
			
			article
			buying_guide
			competition
			gift_idea
			news
			info_articles_one  (this variable is always the same although the actual title in admin can be changed)
			info_articles_two  (this variable is always the same although the actual title in admin can be changed)
			info_articles_three  (this variable is always the same although the actual title in admin can be changed)
			category
			product
			
			
			The last thing we do is to put an onclick event onto each LI.  we need to do this due to all of the overlays
			used for design, we need to make sure wherever the user clicks within the container, we can go to the correct
			link associated with the item.
			
			For SEO purposes however, we also need to add a link to each items title.
			*/
			
			// check for existance of type
			if (is_array($item) && isset($item['type']) && strlen($item['type']) > 1){
			
	
				// calculate the link (same for all items) based on whether or not a new windows is selected.
				// it is easier to do this twice here as we use one link as javasript on the div and the other
				// is a standard link
				
				if (strlen($item['url']) > 1 ){
						if (isset($item['new_window']) && $item['new_window'] == 'true'){
							
							$js_link = 'onclick="window.open(\'' . $item['url'] . '\')"  style="CURSOR:pointer"';
							$htp_link = '<a href="' . $item['url'] . '" target="_blank">';
						}else{
						
						$js_link = 'onclick="document.location.href=\'' . $item['url'] . '\'"  style="CURSOR:pointer"';
							$htp_link = '<a href="' . $item['url'] . '">';
						
						}
				}else{
						$js_link = '';
						$htp_link = '<a href="#">';
				}
				
				// End url creation
				
	
				// we have a type, swap to the answer and show the correct format accordingly
				
	    		switch ($item['type']) {
				
// 1)
     					 case 'article': // standard article  (layout to be confirmed)

						 break;
	
	
// 2)
     					 case 'buying_guide': // buying guide  (layout to be confirmed)

						 break;
	
// 3)
     					 case 'competition': // competition item
?>
						<li class="dsARTHome" <?php echo $js_link;?>>
							<?php
								if (isset($item['image']) && strlen($item['image']) > 1){
									?>
										<div class="dsARTIMG"><?php echo dsf_image($item['image'], $item['title'], $item['image_width'], $item['image_height']);?></div>
								    <?php
								}
								?>
								<div class="dsARTTitle"><?php echo $htp_link . ds_strtoupper ($item['name']);?></a></div>
								<div class="dsARTTXT"><?php echo $item['text'];?></div>
						</li>
<?php						 
						 break;
	
// 4)
     					 case 'gift_idea': // gift idea  (layout to be confirmed)

						 break;
	
// 5)
     					 case 'news': // news  (layout to be confirmed)

						 break;

// 6)
     					 case 'info_articles_one': // info article type 1  (layout to be confirmed)
?>
						<li class="dsARTHome" <?php echo $js_link;?>>
							<?php
								if (isset($item['image']) && strlen($item['image']) > 1){
									?>
										<div class="dsARTIMG"><?php echo dsf_image($item['image'], $item['title'], $item['image_width'], $item['image_height']);?></div>
								    <?php
								}
								?>
							
								<div class="dsARTTitle"><?php echo $htp_link . ds_strtoupper ($item['name']);?></a></div>
								<div class="dsARTTXT"><?php echo $item['text'];?></div>
						</li>
<?php						 
						 break;


// 7)
     					 case 'info_articles_two': // info article type 2  (layout to be confirmed)
?>
						<li class="dsARTHome" <?php echo $js_link;?>>
							<?php
								if (isset($item['image']) && strlen($item['image']) > 1){
									?>
										<div class="dsARTIMG"><?php echo dsf_image($item['image'], $item['title'], $item['image_width'], $item['image_height']);?></div>
								    <?php
								}
								?>
								<div class="dsARTTitle"><?php echo $htp_link . ds_strtoupper ($item['name']);?></a></div>
								<div class="dsARTTXT"><?php echo $item['text'];?></div>
						</li>
<?php						 
						 break;

// 8)
     					 case 'info_articles_three': // info article type 3  (layout to be confirmed)
?>
						<li class="dsARTHome" <?php echo $js_link;?>>
							<?php
								if (isset($item['image']) && strlen($item['image']) > 1){
									?>
										<div class="dsARTIMG"><?php echo dsf_image($item['image'], $item['title'], $item['image_width'], $item['image_height']);?></div>
								    <?php
								}
								?>
								<div class="dsARTTitle"><?php echo $htp_link . strtoupper ($item['name']);?></a></div>
								<div class="dsARTTXT"><?php echo $item['text'];?></div>
                             </li>
<?php						 
						 break;

// 9)
     					 case 'category': // category link
?>					
					  <li class="dsCATHome" <?php echo $js_link;?>>
                      		<div class="dsCatTitle"><?php echo $htp_link . ds_strtoupper($item['title']);?></a></div>
							<div class="dsCatNo"><strong><?php echo $item['products'];?></strong> <?php echo strtoupper (TRANSLATION_TEXT_PRODUCTS);?></div>
							<?php
								if (isset($item['image']) && strlen($item['image']) > 1){
									?>
									<div class="dsCatImage"><?php echo dsf_image($item['image'], $item['title'], $item['image_width'], $item['image_height']);?></div>
								    <?php
								}
								?>
							
					  </li>

<?php						 
						 break;

// 10)
     					 case 'product': // product link
?>
					  <li class="dsPROHome" <?php echo $js_link;?>>
							<?php
								// check for award / promotion item
								if (is_array($item['awards']) && isset($item['awards'][0]['image'])) { // if we have an item in the array, we just want the first one found as we can not have new and special used together
									echo dsf_image($item['awards'][0]['image'], $item['awards'][0]['title'], '','', 'class="dslabel"');
								} // end if award
							 ?>
            					<div class="dsProTitle"><?php echo $item['name'];?></div>
								<div class="dsProModel"><?php echo $htp_link . $item['model'];?></a></div>
							<?php
							
								if (isset($item['image']) && strlen($item['image']) > 1){
									?>
									<div class="dsProIMG"><?php echo dsf_image($item['image'], $item['name'], $item['image_width'], $item['image_height']);?></div>
								    <?php
								}
								
								// Only Do Standard pricing routine if ecommerce is not disabled
								
								if ($dsv_disable_ecommerce == 'false'){
											// prices - there are two possibilities.  if on special or not.
											if (isset($item['offer_price']) && strlen($item['offer_price']) > 1){
												// on special
											?>
												<div class="dsWas"><?php echo $item['price'];?></div>
												<div class="dsSpecial"><?php echo $item['offer_price'];?></div>
											<?php
											}else {
												// normal price
											?>
												<div class="dsPrice"><?php echo $item['price'];?></div>
											<?php
											} // end price check
								
								
								}else{ // ecommerce is disabled - look to see if we are showing an rrp
								
										if ($dsv_enable_rrp == 'true'){
										
											if (isset($item['rrp_price']) && strlen($item['rrp_price']) > 1){
												?>
												<div class="dsPrice"><?php echo TRANSLATION_RRP . ' ' . $item['rrp_price'];?></div>
												<?php
											}
										
								
										}
								
								} // end disable ecommerce check.
								
								?>
								
					  </li>

<?php						 
						 break;
	
				} // end switch on type
				
			} // end check for type
		
		} // end the foreach dsv_home_page_items loop
		
		// close off the ul list
?>
        </ul>
    </div>
<?php
	} // end if items within array dsv_home_page_items
?>
<div class="clear"></div>
</div>