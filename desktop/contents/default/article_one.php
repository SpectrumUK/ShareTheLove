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

if ($dsv_article_level == 'hub' || $dsv_article_level == 'nested'){

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
//                                                        HUB SECTION
// ###########################################################################################################################


/* ##### Line < Added #####

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
				<div id="dsCATLabel"><?php echo strtoupper($dsv_article_name);?></div>
				<ul>
				<?php
					// loop through children - MAXIMUM of 6
					$mcounter = 0;
					foreach ($dsv_nested_menu as $item){
						$mcounter ++;
						if ($mcounter <=6){
							echo '<li><a href="' . dsf_article_one_url($dsv_article_id) . '#Articles" title="' . $item['name'] . '" onclick="showArts(' . $item['id'] . ',' . $item['parent_id'] . ');" class="aScroll">' . strtoupper($item['name']) . '</a></li>';
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
<div id="contentContainer">

<?php


// start the specific items routine.

       if (isset($sub_articles) && is_array($sub_articles)){

?>	   
<div id="dsITholder">
	<div class="artCrumb"><?php echo $dsv_breadcrumb; ?></div>
    <div class="clear"></div>
	<h1><?php echo TRANSLATION_TITLE_HIGHLIGHTS;?></h1>
    <div class="dsAHAZ"><a href="#" onclick="showAZ();"><?php echo TRANSLATION_A_Z_BUTTON;?></a></div>
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
				<div>
					<div class="dsHAOTXTlink"><?php echo $item['name'];?></div>
					<div class="dsHAOTXT"><?php echo $item['text'];?></div>
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
		if (isset($a_z_array['items']) && is_array($a_z_array['items'])){
		
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
    <div class="artCrumb"><?php echo $dsv_breadcrumb; ?></div>
    <div class="clear"></div>
	<h1>A-Z</h1>
    <div class="dsAHHO"><a href="#" onclick="hideAZ();"><?php echo TRANSLATION_HIGHLIGHTS_BUTTON;?></a></div>
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
			
		
?>

<script type="text/javascript">
	function showArts(dssid, dspid){
	
							$.ajax({
							method: "get",url: "article_one_ajax.php",data: "id="+dssid + "&pid=" + dspid +"&tme=" + <?php echo time();?>,
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


if ($dsv_article_level == 'nested'){


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
				<div id="dsCATLabel"><?php echo strtoupper($dsv_article_name);?></div>
				<ul>
				<?php
					// loop through children MAXIMUM of 6
					$mcounter = 0;
					foreach ($dsv_nested_menu as $item){
						$mcounter ++;
						if ($mcounter <=6){
							echo '<li><a href="' . dsf_article_one_url($item['id']) . '">' . strtoupper($item['name']) . '</a></li>';
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
*/

// scroller section
?>
<?php /* #### line added < ###</div>
    <div class="clear"></div>
	<div id="dsAList">
	<?php
		// scroll
		if (is_array($sub_articles) && sizeof($sub_articles)>0){
		 // we have items to scroll therefore go through routine.
		 
			// find out how many items are in the related items to decide whether or not we show scroll items.
			$total_scroll_items = sizeof($sub_articles);
			if ((int)$total_scroll_items > 666){
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
	   

?>
</div>
<?php

} // end if nested
// ###########################################################################################################################
//                                                        END NESTED SECTION
// ###########################################################################################################################


// ###########################################################################################################################
//                                                        ARTICLE SECTION
// ###########################################################################################################################
> added */

if ($dsv_article_level == 'article'){

?>
<div id="dsPROstrip" style="background-image: url('<?php echo dsf_image($dsv_article_details['sub_title_image'],'','','','','YES');?>');">&nbsp;</div>
<div id="dsContent" class="dsARTContent">
    <div class="dsARTleft">
    
    <?php /*<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>*/?>
    <div class="breadCrumb">
    <ul>
				<li><a href="<?php echo dsf_link('index.html');?>"><?php echo TRANSLATION_HOME;?></a></li>
	</ul>
	</div>
    <div class="clear"></div>
     <?php
   /* remove date for the minute.
        <div class="dsADate"><?php echo $dsv_article_details['date'];?></div>
   */


	if (isset($dsv_article_details['video']) && strlen($dsv_article_details['video'])> 1){
			?>
            <div class="dsAFLASH"><?php echo dsf_flash_file($dsv_article_details['video_width'], $dsv_article_details['video_height'], $dsv_article_details['video'], $dsv_article_details['name'], $dsv_article_details['name']);?></div>
		<?php
    }elseif (isset($dsv_article_details['youtube_link']) && strlen($dsv_article_details['youtube_link'])> 1){
			// look to see if only the url has been input or full code.
		?>
        <div class="dsASVideo"><?php
			if (strtoupper(substr($dsv_article_details['youtube_link'],0,4)) == 'HTTP'){
					// url only
			
				echo '<object style="height: 284px; width: 504px"><param name="movie" value="' . $dsv_article_details['youtube_link'] . '"><param name="allowFullScreen" value="true"><param name="allowScriptAccess" value="always"><param name="wmode" value="opaque"><embed src="' . $dsv_article_details['youtube_link'] . '" type="application/x-shockwave-flash" allowfullscreen="true" allowScriptAccess="always" width="284" height="504" wmode="opaque"></object>';
			
			}else{
				// full content
				echo $dsv_article_details['youtube_link'];
			}
			?>
            </div>
       <?php
		
	}elseif (isset($dsv_article_details['title_image']) && substr(strtolower($dsv_article_details['title_image']), -3 ,3) == 'swf' ){
		// flash file therefore do separate routine.
	?>     <div class="dsAFLASH"><?php echo dsf_flash_file(578, 320, $dsv_article_details['title_image'], $dsv_article_details['name'], $dsv_article_details['name']);?></div>
    <?php
		
	}elseif (isset($dsv_article_details['title_image']) && strlen($dsv_article_details['title_image'])>1){
		// do previous routine of showing image.
   ?>     
   <div class="dsAIMG">
   		  	<div class="dsIMGLeftCorner"><?php echo dsf_image('custom/article_left_cover.png', '', '100', '87');?></div>
            <div class="dsIMGRightCorner"><?php echo dsf_image('custom/article_right_cover.png', '', '100', '87');?></div>
	<?php echo dsf_image($dsv_article_details['title_image'], $dsv_article_details['name']);?></div>
	<?php
	}else{
	?>
		<div class="dsBlankIMG">&nbsp;</div>
	<?php
    }
	?>
    
    	<h1 class="dsATitle"><?php echo ds_strtoupper($dsv_article_details['name']);?></h1>
        <div class="dsMAtxt"><?php echo $dsv_article_details['text_block_one'];?></div>
		<div class="clear"></div>
<?php
 if (isset($dsv_article_details['gallery']) && is_array($dsv_article_details['gallery'])){
  // we have a gallery item,  check to see what type it is.
  
  if ($dsv_article_details['gallery']['type'] == 1){
    // step by step.
    ?>
     <div class="dsAGHolder">
      <div class="dsAGTitle"><?php 
       // no longer show step by step text but show the gallery title instead.
       //echo TRANSLATION_STEP_BY_STEP;
       echo strtoupper($dsv_article_details['gallery']['title']);
       
       ?> 

      </div>
      <div class="dsAGTxt"><?php echo $dsv_article_details['gallery']['text'];?></div>
      <div class="dsAGImg"><a href="<?php echo dsf_link('gallery_ajax.php' , 'gID=' . $dsv_article_details['gallery']['id'] . '&atype=1');?>" class="articleajax" rel="nofollow"><?php echo dsf_image($dsv_article_details['gallery']['image'], $dsv_article_details['gallery']['title'], $dsv_article_details['gallery']['image_width'], $dsv_article_details['gallery']['image_height']);?></a></div>
      
     </div>

<?php
  } // end step by step
  elseif ($dsv_article_details['gallery']['type'] == 2){
    // step by step.
    ?>
     <div class="dsAGHolder">
      <div class="dsAGTitle"><?php 
       // no longer show step by step text but show the gallery title instead.
       //echo TRANSLATION_STEP_BY_STEP;
       echo $dsv_article_details['gallery']['title'];
       
       ?>
       
      </div>
      <div class="dsAGTxt"><?php echo $dsv_article_details['gallery']['text'];?></div>
      <div class="dsAGImg"><a href="<?php echo dsf_link('gallery_ajax.php' , 'gID=' . $dsv_article_details['gallery']['id'] . '&atype=1');?>" class="articleajax" rel="nofollow"><?php echo dsf_image($dsv_article_details['gallery']['image'], $dsv_article_details['gallery']['title'], $dsv_article_details['gallery']['image_width'], $dsv_article_details['gallery']['image_height']);?></a></div>
      
     </div>

<?php  } // end gallery type check
} // end gallery check
?>

        <div class="dsMAtxt"><?php echo $dsv_article_details['text_block_two'];?></div>
        <div class="dsMAtxt"><?php echo $dsv_article_details['text_block_three'];?></div>            
    	<div class="dsADisclaimer"><?php echo $dsv_article_details['article_image_disclaimer'];?></div>
		 <div id="dsAlinks">
        <?php
		/*
			<div><a href="http://www.youtube.com/remingtoneurope" title="<?php echo TRANSLATION_YOUTUBE_PAGE;?>" target="_blank">
            	<?php echo dsf_image('custom/artYouTube.gif', TRANSLATION_YOUTUBE_PAGE, '320', '64');?></a></div>
				
            <?php
		*/
			if (isset($dsv_article_details['pdf_one']) && strlen($dsv_article_details['pdf_one'])> 3){
					?>
					<div class="dsAPDF"><a href="<?php echo $dsv_article_details['pdf_one'];?>" title="<?php echo $dsv_article_details['pdf_one_text'];?>" target="blank"><?php echo $dsv_article_details['pdf_one_text'];?></a></div>
			<?php
			}
			if (isset($dsv_article_details['pdf_two']) && strlen($dsv_article_details['pdf_two'])> 3){
					?>
					<div class="dsAPDF"><a href="<?php echo $dsv_article_details['pdf_two'];?>" title="<?php echo $dsv_article_details['pdf_two_text'];?>" target="blank"><?php echo $dsv_article_details['pdf_two_text'];?></a></div>
			<?php
			}
			?>
			
			
        </div>
</div>
        			
                    
<div class="dsMETAright">
	<div class="addthisA"><?php include ('custom_modules/default/addthis.php');?></div>
	<?php /*include ('custom_modules/default/signup.php');*/?>
    <div class="clear"></div>
	<div class="dsMETAmenu">
	<?php /*<div class="dsMAETATitle">NAVIGATE TO:</div>*/?>
		<?php /*
					if (isset($dsv_related_items) && sizeof($dsv_related_items) > 0){
						?>
						<ul>
							<?php
							foreach ($dsv_related_items as $item){
									if (isset($item['override_url']) && strlen($item['override_url']) > 3){
											echo '<li><a href="' . $item['override_url'] . '" target="_blank" title="' . $item['name'] . '">' . ($item['id'] == $dsv_article_id ? $item['name'] : $item['name']) . '</a></li>';
									}else{
											echo '<li><a href="' . $item['url'] . '" title="' . $item['name'] . '">' . ($item['id'] == $dsv_article_id ? $item['name'] : $item['name']) . '</a></li>';
									}
								} // end foreach
								?>
						</ul>
					<?php
					} // end if items
					*/?>
</div>
<?php
		
		
		 // only show featured products section if there are products to show.
		 if (isset($dsv_article_details['products']) && sizeof($dsv_article_details['products'])> 0){

			$total_products = sizeof($dsv_article_details['products']);
		
		 
		 ?>
				<div id="dsARProd">
					<div class="dsARFeatTitle"><?php echo strtoupper(TRANSLATION_FEATURED_PRODUCTS);?></div>
					
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
    <div class="clear"></div> 	
</div>
		
<?php


}
// ###########################################################################################################################
//                                                      END ARTICLE SECTION
// ###########################################################################################################################

// close content
?>
<!-- body_eof //-->