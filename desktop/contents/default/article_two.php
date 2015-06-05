<!-- body //-->
<?php
		/* 
There are three possible options for showing an article item and these are held
within the variable dsv_article_level

hub - shows upper most hub page
nested - shows a list of items available for that folder
article - the actual article.

		
		*/

// the banner section is only available when showing either a hub or nested listing.

if ($dsv_article_level == 'top' || $dsv_article_level == 'nested'){

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

		// then add the function as an echo into the already created header div
?>

<div id="dsContentMaskB"></div>
<div id="dsMaskHolderB"></div>
<div id="contentHeader"><?php echo dsf_background_scrollB($banner_array); ?></div>

<?php
} // end check hub or nested







// now start with content

// ###########################################################################################################################
//                                                        TOP SECTION
// ###########################################################################################################################


if ($dsv_article_level == 'top'){

// display the main sections.
?>

<div id="dsContent" class="dsTOPContent">
    <div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    <div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
    <div class="clear"></div>
<?php


// start the specific items routine.

       if (isset($sub_articles) && is_array($sub_articles)){

?>
	<div id="dsITholder">
	<h1><?php echo ds_strtoupper (TRANSLATION_ARTICLE_TWO_TITLE);?></h1>
    <div class="dsAHAZ"><a href="#" onclick="showAZ();"><?php echo TRANSLATION_A_Z_ALT_BUTTON;?></a></div>
    <?php /*<div class="dsHAO">
    	<ul>
		<?php
			foreach($sub_articles as $item){
			
				// create javascript and html links for the items  (we do it on a li rather than just an item);
				
				if (strlen($item['override_url']) > 1 ){ // we have an override url there default new window
							$js_link = ' onclick="window.open(\'' . $item['override_url'] . '\')"  style="CURSOR:pointer"';
							$htp_link = '<a href="' . $item['override_url'] . '" target="_blank">';
						
				}elseif (strlen($item['url']) > 1){
						$js_link = ' onclick="document.location.href=\'' . $item['url'] . '\'"  style="CURSOR:pointer"';
							$htp_link = '<a href="' . $item['url'] . '">';
						
				}else{
						$js_link = '';
						$htp_link = '<a href="#">';
				}
			
			?>
			
			<li<?php echo $js_link;?>>
				<div class="dsHAOHolder">
				<div class="dsHAOImg"><?php echo dsf_image($item['image'], $item['title'], $item['image_width'], $item['image_height']);?></div>
				<div class="dsHAOTitle"><?php echo ds_strtoupper ($item['name']);?></div>
				<div class="dsHAOTxt"><?php echo $item['text'];?></div>
                </div>
			</li>
			
			
			<?php
			} // end foreach
		?>	
		
		</ul>
        <div class="clear"></div>
    </div> */?>  
	</div>   
	   
	   
	   
	   
	   
<?php	   
	   }
	   


	// start the a-z routine.
	
		// a-z
		if (isset($a_z_array['items']) && is_array($a_z_array['items'])){
		
		// can only do a-z if we have an array of the values
				$total_letters = sizeof($a_z_array['items']);
				$total_items = $a_z_array['total'];
				//  echo 'TOTAL LETTERS = ' . $total_letters . '<br />';
				//  echo 'TOTAL ITEMS = ' . $total_items . '<br />';
				 // average is each letter is worth twice the lines.
				 $total_gross_items = ($total_letters * 2) + $total_items;
				 $average = ((int)($total_gross_items / 4) + 1);
				//   echo 'TOTAL GROSS = ' . $total_gross_items . '<br />';
				//   echo 'TOTAL AVERAGE = ' . $average . '<br />';
		?>
	<div id="dsAZholder">
    <div class="clear"></div>
	<h1><?php echo ds_strtoupper (TRANSLATION_ARTICLE_TWO_TITLE);?></h1>
    <div class="dsAHHO"><a href="#" onclick="hideAZ();"><?php echo TRANSLATION_CUSTOM_TEXT_THREE;?></a></div>
    <div id="dsAZContent">
		
		<?php
			// programming nightmare.   start looping through the array whilst doing a count
			// to decide whether or not to start another column.
			$azcounter = 0;
			$aztotal = 0;
			$prev_letter = '';
			$az_column = 1;
			
			
			$text = '<div class="dsAZColum">' . "\n"; 
			$end = '</div>' . "\n"; 
			
			// draw the first div
			foreach($a_z_array['items'] as $letter => $value){
				$aztotal ++;
				
				// check for change
				if ($letter <> $prev_letter){
				
					 // check to make sure if we add this, then we will not be adding just a letter
					 // and then starting contents on the next div but do a check to make sure we are
					 // not on the last div.
						$azcounter = $azcounter + 2;
					 
					 if ($azcounter < (int)$average){  //less than average, not equal too because we want to add at least one line under it.
						// we can add it without problem
						$text .= '   <div class="dsAZTitle">' . $letter . '</div>' . "\n"; 
						$prev_letter = $letter;
					}else{
				
						// just start a new div if we are not on the last column.
						$az_column ++;
						if ($az_column <=4){
							$text .= $end . '<div class="dsAZColum">' . "\n";
							$azcounter = 2;
						}
						$text .= '  <div class="dsAZTitle">' . $letter . '</div>' . "\n"; 
						$prev_letter = $letter;
					}
				} // end letter check.
				
				// now print the actual lines.
            
					// these will be in a further array inside the variable value
					foreach ($value as $item){
							$azcounter ++;
						
							 if ($azcounter <= (int)$average) {
								$text .= '         <a href="' . $item['url'] . '" title="' . $item['name'] . '">' . $item['name'] . '</a>' . "\n"; 
							 }else{
								// start a new div if not on last column
								$az_column ++;
								if ($az_column <=4){
									$text .= $end . '<div class="dsAZColum">' . "\n";
									$azcounter = 1;
								}
								$text .= '          <a href="' . $item['url'] . '" title="' . $item['name'] . '">' . $item['name'] . '</a>' . "\n"; 
							 }
					} 
					
			} // end foreach
			
			// there should be an open div,  therefore close it.
			$text .= $end;
			
			// echo the a-z divs
			echo $text;
			
			?>
            <div class="clear">&nbsp;</div>
        </div>
    </div>
<?php				  
				  
				  
		
		  } // end we have a-z array
			
		


		
?>

<script type="text/javascript">
	function showArts(dssid, dspid, dslvl){
	
							$.ajax({
							method: "get",url: "article_two_ajax.php",data: "id="+dssid + "&pid=" + dspid + "&lvl=" + dslvl +"&tme=" + <?php echo time();?>,
							success: function(html){ 
							$("#Articles").html(html);
							
							RVP_width = dsScrValues[dssid];
							RVP_current = 0;

					 		}
				 			}); 
	}
	
	
function tabScrollRVP(item_direction){


	if (item_direction == 'left'){
		RVP_current -= RVP_scroll;
			if (RVP_current <0){
				RVP_current = 0;
			}else{
				$('#dsASScrItem').animate({"left":"+=160px"},"slow");
			}
	}

	if (item_direction == 'right'){
		RVP_current += RVP_scroll;
			if (RVP_current > RVP_width){
				RVP_current = RVP_width;
			}else{
				$('#dsASScrItem').animate({"left":"-=160px"},"slow");
			}
	}
	$('.dsASLArrow').blur();
} // end function




var dsScrValues = new Array();
<?php
   // use the articles value from dsv_nested_menu to get a list of articles
   // for each menu item to use as a scroll array.
   reset($dsv_nested_menu);
   $first_item_id = 0;
   
   foreach ($dsv_nested_menu as $item){
   		// we need to subtract what is already visible (6) from the number
		if ((int)$item['articles'] > 6){
			$titem = (int)$item['articles'] - 6;
		}else{
			$titem = 0;
		}
		if ($first_item_id == 0){
				$first_item_id = $item['id'];
		}
   echo 'dsScrValues["' . $item['id'] . '"] = ' . $titem . ';' . "\n";
   }
 ?>  
   

// set scroll parameters.
	
	var RVP_width = 1;
	var RVP_current = 0;
	var RVP_scroll = 1;
									
	
// load the ajax contents	
	showArts(<?php echo (int)$first_item_id . ' , ' . $dsv_article_id . ' , ' . "'" . $dsv_article_level . "'";?>);
									
</script>
<div id="Articles">&nbsp;</div>
</div>
<?php

}// end if hub
// ###########################################################################################################################
//                                                        END TOP SECTION
// ###########################################################################################################################








// ###########################################################################################################################
//                                                        HUB SECTION
// ###########################################################################################################################


if ($dsv_article_level == 'hub'){

	// added override for showing menu
	if (isset($dsv_hide_nested_menu) && $dsv_hide_nested_menu == 'true'){
		// do nothing override in effect
		
	}else{
		// show the menu

			if (isset($dsv_nested_menu) && is_array($dsv_nested_menu)){
				// we have a nested menu within the array therefore this is shown at the top of the page
				
				// this is different to other nested menus because we are not only going to scroll to the item
				// but we also need to run some javascript to get it to change the scroller to the desired item.
				
				
				?>
				<div id="dsSUBNav">
				<div id="dsCATLabel"><?php echo ds_strtoupper($dsv_article_name);?></div>
				<ul>
				<?php
					// loop through children - MAXIMUM of 6
					$mcounter = 0;
					foreach ($dsv_nested_menu as $item){
						$mcounter ++;
						if ($mcounter <=6){
							echo '<li><a href="' . dsf_article_two_url($dsv_article_id) . '#Articles" title="' . $item['name'] . '" onclick="showArts(' . $item['id'] . ',' . $item['parent_id'] . ');" class="aScroll">' . ds_strtoupper($item['name']) . '</a></li>';
						}
					}
				?>
				</ul>
				</div>
			
			<?php
			}
	 } // end override


// display the main sections.
?>
<?php /*<div id="dsPROstrip" style="background-image: url('<?php echo dsf_image($dsv_article['sub_title_image'],'','','','','YES');?>');">&nbsp;</div>*/?>
<div id="dsCRESTstrip">&nbsp;</div>
<div id="dsContent" class="dsHUBContent">
    <div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    <div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
    <div class="clear"></div>

<?php


// start the specific items routine.

       if (isset($sub_articles) && is_array($sub_articles)){

?>	  <div id="dsITholder">
	<h1><?php echo ds_strtoupper ($dsv_article_name);?></h1>
    <?php /*<div class="dsAHAZ"><a href="#" onclick="showAZ();"><?php echo TRANSLATION_A_Z_ALT_BUTTON;?></a></div>*/?>
    <div class="dsHAO">
    	<ul>
		<?php
			foreach($sub_articles as $item){
			
				// create javascript and html links for the items  (we do it on a li rather than just an item);
				
				if (strlen($item['override_url']) > 1 ){ // we have an override url there default new window
							$js_link = ' onclick="window.open(\'' . $item['url'] . '\')"  style="CURSOR:pointer"';
							$htp_link = '<a href="' . $item['url'] . '" target="_blank">';
						
				}elseif (strlen($item['url']) > 1){
						$js_link = ' onclick="document.location.href=\'' . $item['url'] . '\'"  style="CURSOR:pointer"';
							$htp_link = '<a href="' . $item['url'] . '">';
						
				}else{
						$js_link = '';
						$htp_link = '<a href="#">';
				}
			
			?>
			
			<li<?php echo $js_link;?>>
				<div class="dsHAOHolder">
				<div class="dsHAOImg"><?php echo dsf_image($item['image'], $item['title'], $item['image_width'], $item['image_height']);?></div>
				<div class="dsHAOTitle"><?php echo ds_strtoupper ($item['name']);?></div>
				<div class="dsHAOTxt"><?php echo $item['text'];?></div>
                </div>
			</li>
			
			
			<?php
			} // end foreach
		?>	
		
		</ul>
        <div class="clear"></div>
    </div>
	</div>
	     
	   
	   
	   
<?php	   
	   }
	   



	// start the a-z routine.
	
		// a-z
		/*if (isset($a_z_array['items']) && is_array($a_z_array['items'])){
		
		// can only do a-z if we have an array of the values
				$total_letters = sizeof($a_z_array['items']);
				$total_items = $a_z_array['total'];
				//  echo 'TOTAL LETTERS = ' . $total_letters . '<br />';
				//  echo 'TOTAL ITEMS = ' . $total_items . '<br />';
				 // average is each letter is worth twice the lines.
				 $total_gross_items = ($total_letters * 2) + $total_items;
				 $average = ((int)($total_gross_items / 3) + 1);
				//   echo 'TOTAL GROSS = ' . $total_gross_items . '<br />';
				//   echo 'TOTAL AVERAGE = ' . $average . '<br />';
		?>
	<div id="dsAZholder">
    <div class="clear"></div>
	<h1>A-Z</h1>
    <div class="dsAHHO"><a href="#" onclick="hideAZ();"><?php echo TRANSLATION_HIGHLIGHTS_ALT_BUTTON;?></a></div>
    <div id="dsAZContent">
		
		<?php
			// programming nightmare.   start looping through the array whilst doing a count
			// to decide whether or not to start another column.
			$azcounter = 0;
			$aztotal = 0;
			$prev_letter = '';
			$az_column = 1;
			
			
			$text = '<div class="dsAZColum">' . "\n"; 
			$end = '</div>' . "\n"; 
			
			// draw the first div
			foreach($a_z_array['items'] as $letter => $value){
				$aztotal ++;
				
				// check for change
				if ($letter <> $prev_letter){
				
					 // check to make sure if we add this, then we will not be adding just a letter
					 // and then starting contents on the next div but do a check to make sure we are
					 // not on the last div.
						$azcounter = $azcounter + 2;
					 
					 if ($azcounter < (int)$average){  //less than average, not equal too because we want to add at least one line under it.
						// we can add it without problem
						$text .= '   <h2>' . $letter . '</h2>' . "\n"; 
						$prev_letter = $letter;
					}else{
				
						// just start a new div if we are not on the last column.
						$az_column ++;
						if ($az_column <=3){
							$text .= $end . '<div class="dsAZColum">' . "\n";
							$azcounter = 2;
						}
						$text .= '  <h2>' . $letter . '</h2>' . "\n"; 
						$prev_letter = $letter;
					}
				} // end letter check.
				
				// now print the actual lines.
            
					// these will be in a further array inside the variable value
					foreach ($value as $item){
							$azcounter ++;
						
							 if ($azcounter <= (int)$average) {
								$text .= '         <a href="' . $item['url'] . '" title="' . $item['name'] . '">' . $item['name'] . '</a>' . "\n"; 
							 }else{
								// start a new div if not on last column
								$az_column ++;
								if ($az_column <=3){
									$text .= $end . '<div class="dsAZColum">' . "\n";
									$azcounter = 1;
								}
								$text .= '          <a href="' . $item['url'] . '" title="' . $item['name'] . '">' . $item['name'] . '</a>' . "\n"; 
							 }
					} 
					
			} // end foreach
			
			// there should be an open div,  therefore close it.
			$text .= $end;
			
			// echo the a-z divs
			echo $text;
			
			?>
        </div>
    </div>
<?php				  
				  
				  
		
		  } // end we have a-z array
			
		
*/?>

<script type="text/javascript">
	function showArts(dssid, dspid){
	
							$.ajax({
							method: "get",url: "article_two_ajax.php",data: "id="+dssid + "&pid=" + dspid +"&tme=" + <?php echo time();?>,
							success: function(html){ 
							$("#Articles").html(html);
							
							RVP_width = dsScrValues[dssid];
							RVP_current = 0;

					 		}
				 			}); 
	}
	
	
function tabScrollRVP(item_direction){


	if (item_direction == 'left'){
		RVP_current -= RVP_scroll;
			if (RVP_current <0){
				RVP_current = 0;
			}else{
				$('#dsASScrItem').animate({"left":"+=160px"},"slow");
			}
	}

	if (item_direction == 'right'){
		RVP_current += RVP_scroll;
			if (RVP_current > RVP_width){
				RVP_current = RVP_width;
			}else{
				$('#dsASScrItem').animate({"left":"-=160px"},"slow");
			}
	}
	$('.dsASLArrow').blur();
} // end function




var dsScrValues = new Array();
<?php
   // use the articles value from dsv_nested_menu to get a list of articles
   // for each menu item to use as a scroll array.
   reset($dsv_nested_menu);
   $first_item_id = 0;
   
   foreach ($dsv_nested_menu as $item){
   		// we need to subtract what is already visible (6) from the number
		if ((int)$item['articles'] > 6){
			$titem = (int)$item['articles'] - 6;
		}else{
			$titem = 0;
		}
		if ($first_item_id == 0){
				$first_item_id = $item['id'];
		}
   echo 'dsScrValues["' . $item['id'] . '"] = ' . $titem . ';' . "\n";
   }
 ?>  
   

// set scroll parameters.
	
	var RVP_width = 1;
	var RVP_current = 0;
	var RVP_scroll = 1;
									
	
// load the ajax contents	
	showArts(<?php echo (int)$first_item_id . ' , ' . $dsv_article_id;?>);
									
</script>
<div id="Articles">&nbsp;</div>
</div>
<?php

} // end if hub
// ###########################################################################################################################
//                                                        END HUB SECTION
// ###########################################################################################################################


// ###########################################################################################################################
//                                                        NESTED SECTION
// ###########################################################################################################################


/*if ($dsv_article_level == 'nested'){


	// added override for showing menu
	if (isset($dsv_hide_nested_menu) && $dsv_hide_nested_menu == 'true'){
		// do nothing override in effect
		
	}else{
			// show the menu
			if (isset($dsv_nested_menu) && is_array($dsv_nested_menu)){
				// we have a nested menu within the array therefore this is shown at the top of the page
				
				// this is different to other nested menus because we are not only going to scroll to the item
				// but we also need to run some javascript to get it to change the scroller to the desired item.
				
				
				?>
				<div id="dsSUBNav">
				<div id="dsCATLabel"><?php echo ds_strtoupper($dsv_article_name);?></div>
				<ul>
				<?php
					// loop through children MAXIMUM of 6
					$mcounter = 0;
					foreach ($dsv_nested_menu as $item){
						$mcounter ++;
						if ($mcounter <=6){
							echo '<li><a href="' . dsf_article_two_url($item['id']) . '">' . ds_strtoupper($item['name']) . '</a></li>';
						}
					}
				?>
				</ul>
				</div>
			
			<?php
			}
	}

// display the main sections.
?>
<div id="contentContainer">
	<div id="dsITholder">
	<div class="artCrumb"><?php echo $dsv_breadcrumb; ?></div>
    <div class="clear"></div>
	<h1><?php echo $dsv_article_name;?></h1>
	<div class="dsALSocial"><?php include ('custom_modules/addthis.php');?></div>
<?php


// start the specific items routine.

       if (isset($sub_articles) && is_array($sub_articles)){


// LARGE IMAGE TYPES 
/*
?>	   

<div id="dsITholder">
    <div class="dsHAO">
    	<ul>
		<?php
			foreach($sub_articles as $item){
			
				// create javascript and html links for the items  (we do it on a li rather than just an item);
				
				if (strlen($item['override_url']) > 1 ){ // we have an override url there default new window
							$js_link = ' onclick="window.open(\'' . $item['override_url'] . '\')"  style="CURSOR:pointer"';
							$htp_link = '<a href="' . $item['override_url'] . '" target="_blank">';
						
				}elseif (strlen($item['url']) > 1){
						$js_link = ' onclick="document.location.href=\'' . $item['url'] . '\'"  style="CURSOR:pointer"';
							$htp_link = '<a href="' . $item['url'] . '">';
						
				}else{
						$js_link = '';
						$htp_link = '<a href="#">';
				}
			
			?>
			
			<li<?php echo $js_link;?>>
				<div class="dsHAOIMG"><?php echo dsf_image($item['image'], $item['title'], $item['image_width'], $item['image_height']);?></div>
				<div class="dsHAOTXT">
					<div class="dsHAOTXTlink"><?php echo $item['title'];?></div>
					<div><?php echo $item['text'];?></div>
				</div>
			</li>
			
			
			<?php
			} // end foreach
		?>	
		
		</ul>
    </div>
</div>	   
	   
<?php
*/ // end large image type

// Smaller image type

/*
?>
	   
<div id="dsITholder">
    <div id="dsANItems">
    	<ul>
		<?php
			foreach($sub_articles as $item){
			
				// create javascript and html links for the items  (we do it on a li rather than just an item);
				
				if (strlen($item['override_url']) > 1 ){ // we have an override url there default new window
							$js_link = ' onclick="window.open(\'' . $item['override_url'] . '\')"  style="CURSOR:pointer"';
							$htp_link = '<a href="' . $item['override_url'] . '" target="_blank">';
						
				}elseif (strlen($item['url']) > 1){
						$js_link = ' onclick="document.location.href=\'' . $item['url'] . '\'"  style="CURSOR:pointer"';
							$htp_link = '<a href="' . $item['url'] . '">';
						
				}else{
						$js_link = '';
						$htp_link = '<a href="#">';
				}
			
			?>
			
			<li<?php echo $js_link;?>>
				<div class="dsAImg"><?php echo dsf_image($item['small_image'], $item['title']);?></div>
                <div class="dsATitle"><?php echo $item['title'];?></div>
                <div class="dsATxt"><?php echo $item['text'];?></div>
			</li>
			
			
			<?php
			} // end foreach
		?>	
		
		</ul>
    </div>
</div>	   
	   
<?php	 


// scroller section
?>
</div>
    <div class="clear"></div>
	<div id="dsAList">
	<?php
		// scroll
		if (is_array($sub_articles) && sizeof($sub_articles)>0){
		 // we have items to scroll therefore go through routine.
		 
			// find out how many items are in the related items to decide whether or not we show scroll items.
			$total_scroll_items = sizeof($sub_articles);
			if ((int)$total_scroll_items > 6){
				// show scroll arrows
				?>
<script type="text/javascript">
	
	
function tabScrollRVP(item_direction){

	if (item_direction == 'left'){
		RVP_current -= RVP_scroll;
			if (RVP_current <0){
				RVP_current = 0;
			}else{
				$('#dsASScrItem').animate({"left":"+=160px"},"slow");
			}
	}

	if (item_direction == 'right'){
		RVP_current += RVP_scroll;
			if (RVP_current > RVP_width){
				RVP_current = RVP_width;
			}else{
				$('#dsASScrItem').animate({"left":"-=160px"},"slow");
			}
	}
	$('.dsASLArrow').blur();
} // end function


// set scroll parameters.
	
	var RVP_width = <?php echo (int)$total_scroll_items -6;?>;
	var RVP_current = 0;
	var RVP_scroll = 1;
									
									
</script>

					<div class="dsASLArrow"><a href="javascript:void(0);" onclick="tabScrollRVP('left');"><?php echo dsf_image('custom/artLeft_btn.png', 'Left', '44', '44');?></a></div>
					<div class="dsASRArrow"><a href="javascript:void(0);" onclick="tabScrollRVP('right');"><?php echo dsf_image('custom/artRight_btn.png', 'Right', '44', '44');?></a></div>
				<?php
			}
				?>
					
					<div id="dsASItems">
						 <ul>
						 
						 <?php
							foreach($sub_articles as $item){
									if (isset($item['override_url']) && strlen($item['override_url']) > 1 ){ // we have an override url there default new window
												$js_link = ' onclick="window.open(\'' . $item['override_url'] . '\')"  style="CURSOR:pointer"';
												$htp_link = '<a href="' . $item['override_url'] . '" target="_blank">';
											
									}elseif (isset($item['url']) && strlen($item['url']) > 1){
											$js_link = ' onclick="document.location.href=\'' . $item['url'] . '\'"  style="CURSOR:pointer"';
												$htp_link = '<a href="' . $item['url'] . '">';
											
									}else{
											$js_link = '';
											$htp_link = '<a href="#">';
									}




									?>
									<li<?php echo $js_link;?>>
										<div class="dsAImg"><?php echo $http_link . dsf_image($item['small_image'], $item['name']) . '</a>';?></div>
										<div class="dsACon">
											<div class="dsATitle"><?php echo $item['name'];?></div>
											<div class="dsATxt"><?php echo $item['text'];?></div>
                                        </div>
									</li>
									<?php
							}
						 
						?>
						</ul>
			</div>
            </div>
		<?php
		} // end of we have related articles
		?>
    
<?php

  
	   }
	   


</div> 
<?php

} // end if nested
// ###########################################################################################################################
//                                                        END NESTED SECTION
// ###########################################################################################################################


// ###########################################################################################################################
//                                                        ARTICLE SECTION
// ###########################################################################################################################
*/
if ($dsv_article_level == 'article'){

?>
<?php /*<div id="dsPROstrip" style="background-image: url('<?php echo dsf_image($dsv_article_details['sub_title_image'],'','','','','YES');?>');">&nbsp;</div>*/?>
<div id="dsCRESTstrip">&nbsp;</div>
<div id="dsContent" class="dsARTContent">
    <div class="dsARTleft">
    <div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    <div class="clear"></div>
    <div class="dsROverview">
		<div class="dsRIMG"><?php echo dsf_image($dsv_article_details['title_image'], $dsv_article_details['name']);?></div>
        <div class="dsRTxt">
        	<h1><?php echo $dsv_article_details['name'];?></h1>
            <p><?php echo $dsv_article_details['text'];?></p>
        </div>
    </div>
    <div class="dsRDivide"></div>
    <div class="dsRDetails">
    	<div class="dsRMethod"><?php echo $dsv_article_details['text_block_two'];?>
        
        <?php
			if (strtoupper(substr($dsv_article_details['youtube_link'],0,4)) == 'HTTP'){
					// url only
			
				echo '<div class="dsASVideo"><object style="height: 293px; width: 520px"><param name="movie" value="' . $dsv_article_details['youtube_link'] . '"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><param name="wmode" value="opaque"><embed src="' . $dsv_article_details['youtube_link'] . '" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="284" height="504" wmode="opaque"></object></div>';
			
			}else{
				// full content
				echo $dsv_article_details['youtube_link'];
			}
			?>
        
        </div>
    	<div class="dsRIngredients">
			<div class="dsRIngredTitle"><?php echo TRANSLATION_CUSTOM_TEXT_TWO;?></div>
			<?php echo $dsv_article_details['text_block_one'];?>
            <div id="dsRIngredFtr"><?php echo dsf_image('custom/ingredient_ftr_bk.png', '', '220', '16');?></div>
        </div>
    </div>
    </div>
    <div class="dsMETAright">
	<div class="addthisA"><?php include ('custom_modules/default/addthis.php');?></div>
	<?php include ('custom_modules/default/signup.php');?>
    <div class="clear"></div>
	<div class="dsMETAmenu">
	<?php /*<div class="dsMAETATitle">NAVIGATE TO:</div>*/?>
		<?php


			/*
					if (isset($dsv_related_items) && sizeof($dsv_related_items) > 0){
						?>
						<ul>
							<?php
							foreach ($dsv_related_items as $item){
									if (isset($item['override_url']) && strlen($item['override_url']) > 3){
											echo '<li><a href="' . $item['override_url'] . '" target="_blank" title="' . $item['name'] . '">' . ($item['id'] == $dsv_article_id ? '<strong>' . $item['name'] . '</strong>' : $item['name']) . '</a></li>';
									}else{
											echo '<li><a href="' . $item['url'] . '" title="' . $item['name'] . '">' . ($item['id'] == $dsv_article_id ? '<strong>' . $item['name'] . '</strong>' : $item['name']) . '</a></li>';
									}
								} // end foreach
								?>
						</ul>
					<?php
					} // end if items
				
			*/
				
					if (isset($dsv_top_menu) && sizeof($dsv_top_menu) > 0){
						?>
						<ul>
							<?php
							foreach ($dsv_top_menu as $item){
											echo '<li><a href="' . $item['url'] . '" title="' . $item['name'] . ($item['url_window'] == 'true' ? '" target="_blank"' : '') . '">' .  $item['name'] . '</a></li>';
								} // end foreach
								?>
						</ul>
					<?php
					} // end if items
				
				
					?>


</div>
<?php
		
		
		 // only show featured products section if there are products to show.
		 if (isset($dsv_article_details['products']) && sizeof($dsv_article_details['products'])> 0){

			$total_products = sizeof($dsv_article_details['products']);
		
		 
		 ?>
				<div id="dsARProd">
					<div class="dsARFeatTitle"><?php echo ds_strtoupper(TRANSLATION_FEATURED_PRODUCTS);?></div>
					
	<?php /*<!-- Large Product -->				
					<div class="dsPROHot"><?php
							if (isset($dsv_article_details['products'][0]['awards'][0]['image'])) { // if we have an item in the array, we just want the first one found as we can not have new and special used together
									echo dsf_image($dsv_article_details['products'][0]['awards'][0]['image'], $dsv_article_details['products'][0]['awards'][0]['title'], '','', 'class="dsHOTlabel"');
								}// end if award
							?>
					
					<div class="dsHOTProTitle"><?php echo $dsv_article_details['products'][0]['model'];?></div>
					<div class="dsHOTProModel"><?php echo $dsv_article_details['products'][0]['title'];?></div>
					<a href="<?php echo $dsv_article_details['products'][0]['url'];?>" title="<?php echo TRANSLATION_FIND_OUT_MORE . ' ' . $dsv_article_details['products'][0]['title'];?>">
					<?php echo dsf_image($dsv_article_details['products'][0]['large_image'], TRANSLATION_FIND_OUT_MORE . ' ' . $dsv_article_details['products'][0]['title'], $dsv_article_details['products'][0]['large_width'], $dsv_article_details['products'][0]['large_height'], 'class="dsHOTProIMG"');?></a>
					
					<?php
													if ($dsv_enable_rrp == 'true'){
											
																 if (isset($dsv_article_details['products'][0]['rrp_price']) && strlen($dsv_article_details['products'][0]['rrp_price'])>1){
																		echo '<div class="dsHOTNormal">' . TRANSLATION_RRP . ' ' . $dsv_article_details['products'][0]['rrp_price'] . '</div>';
																  }else{
																		// we need a blank row to keep everything formatted correctly.
																		echo '<div class="dsHOTNormal">&nbsp;</div>';
																 }
													}else{
													// we need to put a blank in to make everything format correctly.
																		echo  '<div class="dsHOTNormal">&nbsp;</div>';
													}
													
													// put blank stock line in.
													
															echo '<div class="dsHOTInStock">&nbsp;</div>' . "\n";
					
					?>
					
					<div><a href="<?php echo $dsv_article_details['products'][0]['url'];?>" title="<?php echo TRANSLATION_FIND_OUT_MORE . ' ' . $dsv_article_details['products'][0]['title'];?>"><?php echo dsf_image('custom/hotPro_b1.gif', TRANSLATION_FIND_OUT_MORE . ' ' . $dsv_article_details['products'][0]['title'], '140', '33', 'class="dsPROHOTbut"');?></a>
					</div>
					</div> */?>
					
	<!-- Small Products -->				
					<div id="dsARTProSML">
					
						<?php
							 for ($i=0, $n=$total_products; $i<$n; $i++) {
								?>
									<div class="dsPROList"><?php
									
							if (isset($dsv_article_details['products'][$i]['awards'][0]['image'])) { // if we have an item in the array, we just want the first one found as we can not have new and special used together
									echo dsf_image($dsv_article_details['products'][$i]['awards'][0]['small_image'], $dsv_article_details['products'][$i]['awards'][0]['title'], '','', 'class="dsPROLabel"');
								}// end if award
							?>
									<a href="<?php echo $dsv_article_details['products'][$i]['url'];?>" title="<?php echo TRANSLATION_FIND_OUT_MORE . ' ' . $dsv_article_details['products'][$i]['title'];?>">
									<?php echo dsf_image($dsv_article_details['products'][$i]['image'], TRANSLATION_FIND_OUT_MORE . ' ' . $dsv_article_details['products'][$i]['title'], $dsv_article_details['products'][$i]['width'], $dsv_article_details['products'][$i]['height'], 'class="dsProIMG"');?></a>
									<div class="dsProTitle"><a href="<?php echo $dsv_article_details['products'][$i]['url'];?>" title="<?php echo TRANSLATION_FIND_OUT_MORE . ' ' . $dsv_article_details['products'][$i]['title'];?>"><?php echo $dsv_article_details['products'][$i]['title'];?></a></div>
									<div class="dsProModel"><a href="<?php echo $dsv_article_details['products'][$i]['url'];?>" title="<?php echo TRANSLATION_FIND_OUT_MORE . ' ' . $dsv_article_details['products'][$i]['title'];?>"><?php echo $dsv_article_details['products'][$i]['model'];?></a></div>
									</div>
							<?php
							}
							?>
					
					</div>
					
					<div class="clear"></div>
</div>
			<?php
			}
			?>
		
     
</div>
</div>
		
<?php


}
// ###########################################################################################################################
//                                                      END ARTICLE SECTION
// ###########################################################################################################################

// close content
?>
<!-- body_eof //-->