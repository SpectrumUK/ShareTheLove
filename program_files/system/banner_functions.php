<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.




// ###################
// return banner with thumbnails, requires styles which should be within the general.css file
 // slider function
 
 function dsf_header_scroll($details=''){
 
 $return_values = '';

 if (is_array($details)){
 	
		foreach($details as $id => $value){
			$$id = $value;
		}
 
// values should be
/*							$image_one = '', 
 							$thumb_one = '',
							$url_one = '',
							$image_two = '' ,
							$thumb_two = '',
							$url_two = '',
							$image_three = '',
							$thumb_three = '',
							$url_three = '',
							$image_four = '',
							$thumb_four = '',
							$url_four = '',
							$slider_speed=500,
							$slider_delay=6000
*/

 
 
			 // find number of images being sent, these must be filled up in order 1,2,3 etc.
			 $total_images = 0;
			 
			 if (isset($image_one) && strlen($image_one)> 5 && isset($thumb_one) && strlen($thumb_one)>5){
				$total_images ++;
			 }
			 
			  if (isset($image_two) && strlen($image_two)> 5 && isset($thumb_two) && strlen($thumb_two)>5){
				$total_images ++;
			 }
			
			   if (isset($image_three) && strlen($image_three)> 5 && isset($thumb_three) && strlen($thumb_three)>5){
				$total_images ++;
			 }
			
			   if (isset($image_four) && strlen($image_four)> 5 && isset($thumb_four) && strlen($thumb_four)>5){
				$total_images ++;
			 }
			 
			 
				$image_width = BANNER_IMAGE_WIDTH;	// default width
				$image_height = BANNER_IMAGE_HEIGHT;	// default height
			 
				$thumb_width = BANNER_THUMB_WIDTH;	// default width
				$thumb_height = BANNER_THUMB_HEIGHT;	// default height
			
			  if (!isset($slider_speed) || (int)$slider_speed == 0){
				$slider_speed = 900;	// default speed
			 }
			
			  if (!isset($slider_delay) || (int)$slider_delay == 0){
				$slider_delay = 8000;	// default delay
			 }
			
			
			
			 // start return values to echo
			 
			 if ($total_images > 1){
			 
			 
						$return_values .=' 				<div id="dsScrollHolder">' . "\n";
						$return_values .='					<div id="dsScrollSlider">' . "\n";
						$return_values .='					<script type="text/javascript">' . "\n";
						$return_values .='					<!--' . "\n";
						$return_values .='					// Initialise scroll variables' . "\n";
						$return_values .='					var dsV_scroll_total = ' . $total_images . ';' . "\n";
						$return_values .='					var dsV_scroll_width = ' . $image_width . ';' . "\n";
						$return_values .='					var dsV_thumb_width = ' . ($thumb_width + 4) . ';' . "\n";
						$return_values .='					var dsV_scroll_pos = 0;' . "\n";
						$return_values .='					var dsV_scroll_move = 1;' . "\n";
						$return_values .='					var dsV_scroll_speed = ' . $slider_speed . ';' . "\n";
						$return_values .='					var dsV_scroll_delay = ' . $slider_delay . ';' . "\n";
						$return_values .='					var dsV_scroll_active = false;' . "\n";
											
											
						$return_values .='					// scroll functions' . "\n";
						$return_values .='					function dsF_scroll_clear(){' . "\n";
						$return_values .='						dsV_scroll_active = false;' . "\n";
						$return_values .='					}' . "\n";
											
						$return_values .='					function dsF_scroll_auto() {' . "\n";
											
						$return_values .='						dsV_scroll_move += 1;' . "\n";
						$return_values .='						if (dsV_scroll_move > dsV_scroll_total){' . "\n";
												
						$return_values .='							dsV_scroll_move = 1;' . "\n";
						$return_values .='						}' . "\n";
												
						$return_values .='							dsF_scroll_item(dsV_scroll_move);' . "\n";
						$return_values .='					}' . "\n";
							
							
						$return_values .='					function dsF_scroll_item(item_num){' . "\n";
											
						$return_values .='					// only id not already running' . "\n";
						$return_values .='							if (!dsV_scroll_active == true){' . "\n";
													
						$return_values .='							// define movement' . "\n";
						$return_values .='									dsV_scroll_active = ' . 'true;' . "\n";
						$return_values .='									dsV_scroll_pos = \'-\' + ((item_num-1) * dsV_scroll_width);' . "\n";
						$return_values .='									dsV_thumb_pos =  ((item_num-1) * dsV_thumb_width);' . "\n";
							
						$return_values .='									$("#dsScrollSlider").animate({' . "\n";
														
						$return_values .='										left: dsV_scroll_pos' . "\n";
														
						$return_values .='									},dsV_scroll_speed);' . "\n";
															
						$return_values .='									$("#dsScrollThumbSelect").animate({' . "\n";
														
						$return_values .='										left: dsV_thumb_pos' . "\n";
														
						$return_values .='									},dsV_scroll_speed,function(){' . "\n";
						$return_values .='								        dsF_scroll_clear(); ' . "\n";
						
						$return_values .='    								});' . "\n";
															
								
						$return_values .='							}' . "\n";
						$return_values .='					}' . "\n";
							
						$return_values .='					function dsF_scroll_to(item_num) {' . "\n";
											
						$return_values .='						if (item_num > 0 && item_num <= dsV_scroll_total) {' . "\n";
												
						$return_values .='							if (!dsV_scroll_active == true){' . "\n";
						$return_values .='								// clear autorun' . "\n";
						$return_values .='								 clearInterval(scrollAuto);' . "\n";
						$return_values .='								// scroll to item' . "\n";
						$return_values .='								dsF_scroll_item(item_num);' . "\n";
						$return_values .='							}' . "\n";
												
						$return_values .='						}' . "\n";
												
											
						$return_values .='					}' . "\n";
						
						
						$return_values .='					// start auto run' . "\n";
						$return_values .='					    scrollAuto = setInterval("dsF_scroll_auto()", dsV_scroll_delay );' . "\n";
						
						$return_values .='					-->' . "\n";
						$return_values .='					</script>' . "\n";
						
			  if (isset($url_one) && strlen($url_one)> 0){
						  if (strpos('a' . $url_one,'#')>0){
							$item_class=' class="aScroll"';
						  }else{
							$item_class='';
						  }
						  
						  if (isset($url_one_window) && $url_one_window == 'true'){
							  $url_link = ' target="_blank"';
						  }else{
							  $url_link = '';
						  }
						  
						  
						$return_values .='				    <div class="dsScrollI"><a href="' . $url_one . '"' . $item_class . $url_link .'><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
			  }else{
						$return_values .='				    <div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
			  
			  }
			  if (isset($url_two) && strlen($url_two)> 0){
								  if (strpos('a' . $url_two,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

						  if (isset($url_two_window) && $url_two_window == 'true'){
							  $url_link = ' target="_blank"';
						  }else{
							  $url_link = '';
						  }

						$return_values .='					<div class="dsScrollI"><a href="' . $url_two . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_two . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
			  }else{
						$return_values .='					<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_two . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
			  }
					
						if ($total_images >= 3){
							 if (isset($url_three) && strlen($url_three)> 0){
								  if (strpos('a' . $url_three,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

								  if (isset($url_three_window) && $url_three_window == 'true'){
									  $url_link = ' target="_blank"';
								  }else{
									  $url_link = '';
								  }

								$return_values .='					<div class="dsScrollI"><a href="' . $url_three . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_three . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
							 }else{
								$return_values .='					<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_three . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
							 }
						}
						if ($total_images >= 4){
							 if (isset($url_four) && strlen($url_four)> 0){
								  if (strpos('a' . $url_four,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

								  if (isset($url_four_window) && $url_four_window == 'true'){
									  $url_link = ' target="_blank"';
								  }else{
									  $url_link = '';
								  }

								$return_values .='					<div class="dsScrollI"><a href="' . $url_four . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_four . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
							 }else{
								$return_values .='					<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_four . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
							 }
						
						}					
						$return_values .='					</div>' . "\n";
						
						
						if ($total_images >= 4){
							$return_values .='					<div id="dsScrollThumbFour">' . "\n";
						}elseif ($total_images == 3){
							$return_values .='					<div id="dsScrollThumbThree">' . "\n";
						}elseif ($total_images == 2){
							$return_values .='					<div id="dsScrollThumbTwo">' . "\n";
						}
						
						$return_values .='						<div id="dsScrollThumbItems">' . "\n";
						$return_values .='							<div id="dsScrollThumbSelect"><div id="dsScrollArrow"><img src="' . DS_IMAGES_FOLDER . 'scroll_arrow.png" alt="" width="9" height="4" /></div></div>' . "\n";
						$return_values .='							<div class="dsScrollT"><a href="#" rel="nofollow" onclick="dsF_scroll_to(1);"><img src="' . DS_IMAGES_FOLDER . $thumb_one . '" alt="" width="' . $thumb_width . '" height="' . $thumb_height . '" /></a></div>' . "\n";
						$return_values .='							<div class="dsScrollT"><a href="#" rel="nofollow" onclick="dsF_scroll_to(2);"><img src="' . DS_IMAGES_FOLDER . $thumb_two . '" alt="" width="' . $thumb_width . '" height="' . $thumb_height . '" /></a></div>' . "\n";
						
						if ($total_images >= 3){
							$return_values .='							<div class="dsScrollT"><a href="#" rel="nofollow" onclick="dsF_scroll_to(3);"><img src="' . DS_IMAGES_FOLDER . $thumb_three . '" alt="" width="' . $thumb_width . '" height="' . $thumb_height . '" /></a></div>' . "\n";
						}
						if ($total_images >= 4){
							$return_values .='							<div class="dsScrollT"><a href="#" rel="nofollow" onclick="dsF_scroll_to(4);"><img src="' . DS_IMAGES_FOLDER . $thumb_four . '" alt="" width="' . $thumb_width . '" height="' . $thumb_height . '" /></a></div>' . "\n";
						}
						$return_values .='						</div>' . "\n";
						$return_values .='					</div>' . "\n";
											
						$return_values .='				</div>' . "\n";
			
			
			}else{
				// only 1 image can not do slider and thumb
			
						$return_values .=' 				<div id="dsScrollHolder">' . "\n";
						$return_values .='					<div id="dsScrollSlider">' . "\n";
						if (strlen($url_one)>0){
								  if (strpos('a' . $url_one,'#') >0){
									$item_class =' class="aScroll"';
								  }else{
									$item_class ='';
								  }
							$return_values .='				<div class="dsScrollI"><a href="' . $url_one . '"' . $item_class . '><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
						}else{
							$return_values .='				<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
						}
						$return_values .='					</div>' . "\n";
						$return_values .='				</div>' . "\n";
			}

} // end if array
return $return_values;

} // end function
// ######################################




 function dsf_temp_scroll($details='', $banner_type='icons' , $icon_width='24'){
 	global $dsv_banner_override_width, $dsv_banner_override_height;
 $return_values = '';

$overriding_banner_sizes = 'false';

 if (is_array($details)){
 	
		foreach($details as $id => $value){
			$$id = $value;
		}
 
// values should be
/*							$image_one = '', 
 							$thumb_one = '',
							$url_one = '',
							$image_two = '' ,
							$thumb_two = '',
							$url_two = '',
							$image_three = '',
							$thumb_three = '',
							$url_three = '',
							$image_four = '',
							$thumb_four = '',
							$url_four = '',
							$slider_speed=500,
							$slider_delay=6000
*/

 
 
			 // find number of images being sent, these must be filled up in order 1,2,3 etc.
			 $total_images = 0;
			 
			 if (isset($image_one) && strlen($image_one)> 5 && isset($thumb_one) && strlen($thumb_one)>5){
				$total_images ++;
			 }
			 
			  if (isset($image_two) && strlen($image_two)> 5 && isset($thumb_two) && strlen($thumb_two)>5){
				$total_images ++;
			 }
			
			   if (isset($image_three) && strlen($image_three)> 5 && isset($thumb_three) && strlen($thumb_three)>5){
				$total_images ++;
			 }
			
			   if (isset($image_four) && strlen($image_four)> 5 && isset($thumb_four) && strlen($thumb_four)>5){
				$total_images ++;
			 }
			 
			 
			 if (isset($dsv_banner_override_width) && (int)$dsv_banner_override_width > 0){
				 $image_width = $dsv_banner_override_width;
			 }else{
				$image_width = BANNER_IMAGE_WIDTH;	// default width
			 }
			 
			 if (isset($dsv_banner_override_height) && (int)$dsv_banner_override_height > 0){
				 $image_height = $dsv_banner_override_height;
			 }else{
				$image_height = BANNER_IMAGE_HEIGHT;	// default height
			 }
			 
			 
			 
			 
			 
				$thumb_width = BANNER_THUMB_WIDTH;	// default width
				$thumb_height = BANNER_THUMB_HEIGHT;	// default height
			
			  if (!isset($slider_speed) || (int)$slider_speed == 0){
				$slider_speed = 1100;	// default speed 900
			 }
			
			  if (!isset($slider_delay) || (int)$slider_delay == 0){
				$slider_delay = 8000;	// default delay
			 }
			
			
			
			
			// define background colour or slides which we will use javascript to change.
			// ONE
			
			if (isset($background_one) && strlen($background_one) > 1){
				$bg_one = "'background-image':'url(" . $background_one . ")'";
			}
			
			if (isset($colour_one) && strlen($colour_one) > 1){
				if (isset($bg_one) && strlen($bg_one)> 1){
					$bg_one .= ",'background-color':'" . $colour_one . "'";
				}else{
					$bg_one = "'background-color':'" . $colour_one . "','background-image':'none'";
				}
			}
			
			if (!isset($bg_one)){
					$bg_one = "'background-color':'none','background-image':'none'";
			}
			
			
			// TWO
			if (isset($background_two) && strlen($background_two) > 1){
				$bg_two = "'background-image':'url(" . $background_two . ")'";
			}
			
			if (isset($colour_two) && strlen($colour_two) > 1){
				if (strlen($bg_two)> 1){
					$bg_two .= ",'background-color':'" . $colour_two . "'";
				}else{
					$bg_two = "'background-color':'" . $colour_two . "','background-image':'none'";
				}
			}
			
			if (!isset($bg_two)){
					$bg_two = "'background-color':'none','background-image':'none'";
			}
			
			
			// THREE
			if (isset($background_three) && strlen($background_three) > 1){
				$bg_three = "'background-image':'url(" . $background_three . ")'";
			}
			
			if (isset($colour_three) && strlen($colour_three) > 1){
				if (strlen($bg_three)> 1){
					$bg_three .= ",'background-color':'" . $colour_three . "'";
				}else{
					$bg_three = "'background-color':'" . $colour_three . "','background-image':'none'";
				}
			}

			if (!isset($bg_three)){
					$bg_three = "'background-color':'none','background-image':'none'";
			}

			// FOUR
			if (isset($background_four) && strlen($background_four) > 1){
				$bg_four = "'background-image':'url(" . $background_four . ")'";
			}
			
			if (isset($colour_four) && strlen($colour_four) > 1){
				if (strlen($bg_four)> 1){
					$bg_four .= ",'background-color':'" . $colour_four . "'";
				}else{
					$bg_four = "'background-color':'" . $colour_four . "','background-image':'none'";
				}
			}

			if (!isset($bg_four)){
					$bg_four = "'background-color':'none','background-image':'none'";
			}




			
			$bg_one = '{' . $bg_one . '}';
			$bg_two = '{' . $bg_two . '}';
			$bg_three = '{' . $bg_three . '}';
			$bg_four = '{' . $bg_four . '}';
			
			
			
			
			
			 // start return values to echo
			 
			 if ($total_images > 1){
			 
			 
						$return_values .=' 				<div id="dsScrollHolder">' . "\n";
						$return_values .='					<div id="dsScrollSlider">' . "\n";
						$return_values .='					<script type="text/javascript">' . "\n";
						$return_values .='					<!--' . "\n";
						$return_values .='					// Initialise scroll variables' . "\n";
						$return_values .='					var dsV_scroll_total = ' . $total_images . ';' . "\n";
						$return_values .='					var dsV_scroll_width = ' . $image_width . ';' . "\n";
						
						if ($banner_type =='icons'){
							$return_values .='					var dsV_thumb_width = ' . $icon_width . ';' . "\n";
						}else{
							$return_values .='					var dsV_thumb_width = ' . ($thumb_width + 4) . ';' . "\n";
						}
						$return_values .='					var dsV_scroll_pos = 0;' . "\n";
						$return_values .='					var dsV_scroll_move = 1;' . "\n";
						$return_values .='					var dsV_scroll_speed = ' . $slider_speed . ';' . "\n";
						$return_values .='					var dsV_scroll_delay = ' . $slider_delay . ';' . "\n";
						$return_values .='					var dsV_scroll_active = false;' . "\n";
											
						$return_values .='					// scroll functions' . "\n";
						$return_values .='					function dsF_scroll_clear(){' . "\n";
						$return_values .='						dsV_scroll_active = false;' . "\n";
						$return_values .='					}' . "\n";
											
						$return_values .='					function dsF_scroll_auto() {' . "\n";
											
						$return_values .='						dsV_scroll_move += 1;' . "\n";
						$return_values .='						if (dsV_scroll_move > dsV_scroll_total){' . "\n";
						$return_values .='							dsV_scroll_move = 1;' . "\n";
						$return_values .='						}' . "\n";
												
						$return_values .='							dsF_scroll_item(dsV_scroll_move);' . "\n";
						$return_values .='					}' . "\n";
							


						$return_values .='					function dsF_change_back(item_num){' . "\n";

						$return_values .='					if (item_num == 1){' . "\n";
						$return_values .='                          $("#contentDiv").css(' . $bg_one . ');' . "\n";
						$return_values .='                  }' . "\n";

						$return_values .='					if (item_num == 2){' . "\n";
						$return_values .='                          $("#contentDiv").css(' . $bg_two . ');' . "\n";
						$return_values .='                  }' . "\n";

						$return_values .='					if (item_num == 3){' . "\n";
						$return_values .='                          $("#contentDiv").css(' . $bg_three . ');' . "\n";
						$return_values .='                  }' . "\n";
						$return_values .='					if (item_num == 4){' . "\n";
						$return_values .='                          $("#contentDiv").css(' . $bg_four . ');' . "\n";
						$return_values .='                  }' . "\n";



						$return_values .='					}' . "\n";
						
						
						$return_values .='					function dsF_scroll_item(item_num){' . "\n";
											
						$return_values .='					// only id not already running' . "\n";
						$return_values .='							if (!dsV_scroll_active == true){' . "\n";
													
						$return_values .='							// define movement' . "\n";
						$return_values .='									dsV_scroll_active = ' . 'true;' . "\n";
						$return_values .='									dsV_scroll_pos = \'-\' + ((item_num-1) * dsV_scroll_width);' . "\n";
						$return_values .='									dsV_thumb_pos =  ((item_num-1) * dsV_thumb_width);' . "\n";
							
						$return_values .='									$("#dsScrollSlider").animate({' . "\n";
														
						$return_values .='										left: dsV_scroll_pos' . "\n";
														
							$return_values .='									},dsV_scroll_speed,function(){' . "\n";
							$return_values .='								        dsF_change_back(item_num); ' . "\n";
							$return_values .='    								});' . "\n";
						
						if ($banner_type =='icons'){
							// highlight the icon involved
							
							$return_values .='									for (i=1;i<=dsV_scroll_total;i++) {' . "\n";
		   					$return_values .='                                     $("#dsScrollIcon" + i).toggleClass(\'dsSIcon\', true);' . "\n";
		   					$return_values .='                                     $("#dsScrollIcon" + i).toggleClass(\'dsSIconSelect\', false);' . "\n";
							$return_values .='                                  }' . "\n";
		   					$return_values .='                                     $("#dsScrollIcon" + item_num).toggleClass(\'dsSIcon\', false);' . "\n";
		   					$return_values .='                                      $("#dsScrollIcon" + item_num).toggleClass(\'dsSIconSelect\', true);' . "\n";


						
						
							
							
							$return_values .='								        dsF_scroll_clear(); ' . "\n";
						}else{
							$return_values .='									$("#dsScrollThumbSelect").animate({' . "\n";
														
							$return_values .='										left: dsV_thumb_pos' . "\n";
														
							$return_values .='									},dsV_scroll_speed,function(){' . "\n";
							$return_values .='								        dsF_scroll_clear(); ' . "\n";
						
							$return_values .='    								});' . "\n";
						}
						
								
						$return_values .='							}' . "\n";
						$return_values .='					}' . "\n";
							
						$return_values .='					function dsF_scroll_to(item_num) {' . "\n";
											
						$return_values .='						if (item_num > 0 && item_num <= dsV_scroll_total) {' . "\n";
												
						$return_values .='							if (!dsV_scroll_active == true){' . "\n";
						$return_values .='								// clear autorun' . "\n";
						$return_values .='								 clearInterval(scrollAuto);' . "\n";
						$return_values .='								// scroll to item' . "\n";
						$return_values .='								dsF_scroll_item(item_num);' . "\n";
						$return_values .='							}' . "\n";
												
						$return_values .='						}' . "\n";
												
											
						$return_values .='					}' . "\n";
						
						
						$return_values .='					// start auto run' . "\n";
						$return_values .='								        dsF_change_back(1); ' . "\n";
						$return_values .='					    scrollAuto = setInterval("dsF_scroll_auto()", dsV_scroll_delay );' . "\n";
						
						$return_values .='					-->' . "\n";
						$return_values .='					</script>' . "\n";
						
			  if (isset($url_one) && strlen($url_one)> 0){
						  if (strpos('a' . $url_one,'#')>0){
							$item_class=' class="aScroll"';
						  }else{
							$item_class='';
						  }
						  
						  if (isset($url_one_window) && $url_one_window == 'true'){
							  $url_link = ' target="_blank"';
						  }else{
							  $url_link = '';
						  }
						  
						  
						$return_values .='				    <div class="dsScrollI"><a href="' . $url_one . '"' . $item_class . $url_link .'><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
			  }else{
						$return_values .='				    <div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
			  
			  }
			  if (isset($url_two) && strlen($url_two)> 0){
								  if (strpos('a' . $url_two,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

						  if (isset($url_two_window) && $url_two_window == 'true'){
							  $url_link = ' target="_blank"';
						  }else{
							  $url_link = '';
						  }

						$return_values .='					<div class="dsScrollI"><a href="' . $url_two . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_two . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
			  }else{
						$return_values .='					<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_two . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
			  }
					
						if ($total_images >= 3){
							 if (isset($url_three) && strlen($url_three)> 0){
								  if (strpos('a' . $url_three,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

								  if (isset($url_three_window) && $url_three_window == 'true'){
									  $url_link = ' target="_blank"';
								  }else{
									  $url_link = '';
								  }

								$return_values .='					<div class="dsScrollI"><a href="' . $url_three . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_three . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
							 }else{
								$return_values .='					<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_three . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
							 }
						}
						if ($total_images >= 4){
							 if (isset($url_four) && strlen($url_four)> 0){
								  if (strpos('a' . $url_four,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

								  if (isset($url_four_window) && $url_four_window == 'true'){
									  $url_link = ' target="_blank"';
								  }else{
									  $url_link = '';
								  }

								$return_values .='					<div class="dsScrollI"><a href="' . $url_four . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_four . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
							 }else{
								$return_values .='					<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_four . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
							 }
						
						}					
						$return_values .='					</div>' . "\n";
						
						
						if ($total_images >= 4){
							$return_values .='					<div id="dsScrollIconFour">' . "\n";
						}elseif ($total_images == 3){
							$return_values .='					<div id="dsScrollIconThree">' . "\n";
						}elseif ($total_images == 2){
							$return_values .='					<div id="dsScrollIconTwo">' . "\n";
						}
						
						
						// thumbs
						
						if ($banner_type =='icons'){
						
								$return_values .='						<div id="dsScrollThumbItems">' . "\n";
								$return_values .='							<div class="dsScrollIcon"><a href="#" rel="nofollow" onclick="dsF_scroll_to(1);" class="dsSIconSelect" id="dsScrollIcon1">&nbsp;</a></div>' . "\n";
								$return_values .='							<div class="dsScrollIcon"><a href="#" rel="nofollow" onclick="dsF_scroll_to(2);" class="dsSIcon" id="dsScrollIcon2">&nbsp;</a></div>' . "\n";
								if ($total_images >= 3){
									$return_values .='							<div class="dsScrollIcon"><a href="#" rel="nofollow" onclick="dsF_scroll_to(3);" class="dsSIcon" id="dsScrollIcon3">&nbsp;</a></div>' . "\n";
								}
								if ($total_images >= 4){
									$return_values .='							<div class="dsScrollIcon"><a href="#" rel="nofollow" onclick="dsF_scroll_to(4);" class="dsSIcon" id="dsScrollIcon4">&nbsp;</a></div>' . "\n";
								}
								$return_values .='						</div>' . "\n";
						}else{
							
								$return_values .='						<div id="dsScrollThumbItems">' . "\n";
								$return_values .='							<div id="dsScrollThumbSelect"><div id="dsScrollArrow"><img src="' . DS_IMAGES_FOLDER . 'scroll_arrow.png" alt="" width="9" height="4" /></div></div>' . "\n";
								$return_values .='							<div class="dsScrollT"><a href="#" rel="nofollow" onclick="dsF_scroll_to(1);"><img src="' . DS_IMAGES_FOLDER . $thumb_one . '" alt="" width="' . $thumb_width . '" height="' . $thumb_height . '" /></a></div>' . "\n";
								$return_values .='							<div class="dsScrollT"><a href="#" rel="nofollow" onclick="dsF_scroll_to(2);"><img src="' . DS_IMAGES_FOLDER . $thumb_two . '" alt="" width="' . $thumb_width . '" height="' . $thumb_height . '" /></a></div>' . "\n";
								
								if ($total_images >= 3){
									$return_values .='							<div class="dsScrollT"><a href="#" rel="nofollow" onclick="dsF_scroll_to(3);"><img src="' . DS_IMAGES_FOLDER . $thumb_three . '" alt="" width="' . $thumb_width . '" height="' . $thumb_height . '" /></a></div>' . "\n";
								}
								if ($total_images >= 4){
									$return_values .='							<div class="dsScrollT"><a href="#" rel="nofollow" onclick="dsF_scroll_to(4);"><img src="' . DS_IMAGES_FOLDER . $thumb_four . '" alt="" width="' . $thumb_width . '" height="' . $thumb_height . '" /></a></div>' . "\n";
								}
								$return_values .='						</div>' . "\n";
						}
								
								$return_values .='					</div>' . "\n";
						// end thumbs
						
						
											
						$return_values .='				</div>' . "\n";
			
			
			}else{
				// only 1 image can not do slider and thumb
			
						$return_values .=' 				<div id="dsScrollHolder">' . "\n";
						$return_values .='					<div id="dsScrollSlider">' . "\n";
						if (strlen($url_one)>0){
								  if (strpos('a' . $url_one,'#') >0){
									$item_class =' class="aScroll"';
								  }else{
									$item_class ='';
								  }
							$return_values .='				<div class="dsScrollI"><a href="' . $url_one . '"' . $item_class . '><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
						}else{
							$return_values .='				<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
						}
						$return_values .='					</div>' . "\n";
						$return_values .='				</div>' . "\n";
						
						$return_values .='					<script type="text/javascript">' . "\n";
						$return_values .='$("#contentDiv").css(' . $bg_one . ');' . "\n";
						$return_values .='</script>';
						
						
						
			}

} // end if array
return $return_values;

} // end function
// ######################################



 function dsf_cat_scroll($details='', $banner_type='icons' , $icon_width='24'){
 	global $dsv_banner_override_width, $dsv_banner_override_height;
 $return_values = '';

$overriding_banner_sizes = 'false';

 if (is_array($details)){
 	
		foreach($details as $id => $value){
			$$id = $value;
		}
 
// values should be
/*							$image_one = '', 
 							$thumb_one = '',
							$url_one = '',
							$image_two = '' ,
							$thumb_two = '',
							$url_two = '',
							$image_three = '',
							$thumb_three = '',
							$url_three = '',
							$image_four = '',
							$thumb_four = '',
							$url_four = '',
							$slider_speed=500,
							$slider_delay=6000
*/

 
 
			 // find number of images being sent, these must be filled up in order 1,2,3 etc.
			 $total_images = 0;
			 
			 if (isset($image_one) && strlen($image_one)> 5 && isset($thumb_one) && strlen($thumb_one)>5){
				$total_images ++;
			 }
			 
			  if (isset($image_two) && strlen($image_two)> 5 && isset($thumb_two) && strlen($thumb_two)>5){
				$total_images ++;
			 }
			
			   if (isset($image_three) && strlen($image_three)> 5 && isset($thumb_three) && strlen($thumb_three)>5){
				$total_images ++;
			 }
			
			   if (isset($image_four) && strlen($image_four)> 5 && isset($thumb_four) && strlen($thumb_four)>5){
				$total_images ++;
			 }
			 
			 
			 if (isset($dsv_banner_override_width) && (int)$dsv_banner_override_width > 0){
				 $image_width = $dsv_banner_override_width;
			 }else{
				$image_width = BANNER_IMAGE_WIDTH;	// default width
			 }
			 
			 if (isset($dsv_banner_override_height) && (int)$dsv_banner_override_height > 0){
				 $image_height = $dsv_banner_override_height;
			 }else{
				$image_height = BANNER_IMAGE_HEIGHT;	// default height
			 }
			 
			 
			 
			 
			 
				$thumb_width = BANNER_THUMB_WIDTH;	// default width
				$thumb_height = BANNER_THUMB_HEIGHT;	// default height
			
			  if (!isset($slider_speed) || (int)$slider_speed == 0){
				$slider_speed = 1100;	// default speed 900
			 }
			
			  if (!isset($slider_delay) || (int)$slider_delay == 0){
				$slider_delay = 8000;	// default delay
			 }
			
			
			
			
			// define background colour or slides which we will use javascript to change.
			// ONE
			
			if (isset($background_one) && strlen($background_one) > 1){
				$bg_one = "'background-image':'url(" . $background_one . ")'";
			}
			
			if (isset($colour_one) && strlen($colour_one) > 1){
				if (isset($bg_one) && strlen($bg_one)> 1){
					$bg_one .= ",'background-color':'" . $colour_one . "'";
				}else{
					$bg_one = "'background-color':'" . $colour_one . "','background-image':'none'";
				}
			}
			
			if (!isset($bg_one)){
					$bg_one = "'background-color':'none','background-image':'none'";
			}
			
			
			// TWO
			if (isset($background_two) && strlen($background_two) > 1){
				$bg_two = "'background-image':'url(" . $background_two . ")'";
			}
			
			if (isset($colour_two) && strlen($colour_two) > 1){
				if (strlen($bg_two)> 1){
					$bg_two .= ",'background-color':'" . $colour_two . "'";
				}else{
					$bg_two = "'background-color':'" . $colour_two . "','background-image':'none'";
				}
			}
			
			if (!isset($bg_two)){
					$bg_two = "'background-color':'none','background-image':'none'";
			}
			
			
			// THREE
			if (isset($background_three) && strlen($background_three) > 1){
				$bg_three = "'background-image':'url(" . $background_three . ")'";
			}
			
			if (isset($colour_three) && strlen($colour_three) > 1){
				if (strlen($bg_three)> 1){
					$bg_three .= ",'background-color':'" . $colour_three . "'";
				}else{
					$bg_three = "'background-color':'" . $colour_three . "','background-image':'none'";
				}
			}

			if (!isset($bg_three)){
					$bg_three = "'background-color':'none','background-image':'none'";
			}

			// FOUR
			if (isset($background_four) && strlen($background_four) > 1){
				$bg_four = "'background-image':'url(" . $background_four . ")'";
			}
			
			if (isset($colour_four) && strlen($colour_four) > 1){
				if (strlen($bg_four)> 1){
					$bg_four .= ",'background-color':'" . $colour_four . "'";
				}else{
					$bg_four = "'background-color':'" . $colour_four . "','background-image':'none'";
				}
			}

			if (!isset($bg_four)){
					$bg_four = "'background-color':'none','background-image':'none'";
			}





			
			$bg_one = '{' . $bg_one . '}';
			$bg_two = '{' . $bg_two . '}';
			$bg_three = '{' . $bg_three . '}';
			$bg_four = '{' . $bg_four . '}';
			
			
			
			
			
			 // start return values to echo
			 
			 if ($total_images > 1){
			 
			 
						$return_values .=' 				<div id="dsCatScrollHolder">' . "\n";
						$return_values .='					<div id="dsCatScrollSlider">' . "\n";
						$return_values .='					<script type="text/javascript">' . "\n";
						$return_values .='					<!--' . "\n";
						$return_values .='					// Initialise scroll variables' . "\n";
						$return_values .='					var dsV_scroll_total = ' . $total_images . ';' . "\n";
						$return_values .='					var dsV_scroll_width = ' . $image_width . ';' . "\n";
						
						if ($banner_type =='icons'){
							$return_values .='					var dsV_thumb_width = ' . $icon_width . ';' . "\n";
						}else{
							$return_values .='					var dsV_thumb_width = ' . ($thumb_width + 4) . ';' . "\n";
						}
						$return_values .='					var dsV_scroll_pos = 0;' . "\n";
						$return_values .='					var dsV_scroll_move = 1;' . "\n";
						$return_values .='					var dsV_scroll_speed = ' . $slider_speed . ';' . "\n";
						$return_values .='					var dsV_scroll_delay = ' . $slider_delay . ';' . "\n";
						$return_values .='					var dsV_scroll_active = false;' . "\n";
											
						$return_values .='					// scroll functions' . "\n";
						$return_values .='					function dsF_scroll_clear(){' . "\n";
						$return_values .='						dsV_scroll_active = false;' . "\n";
						$return_values .='					}' . "\n";
											
						$return_values .='					function dsF_scroll_auto() {' . "\n";
											
						$return_values .='						dsV_scroll_move += 1;' . "\n";
						$return_values .='						if (dsV_scroll_move > dsV_scroll_total){' . "\n";
						$return_values .='							dsV_scroll_move = 1;' . "\n";
						$return_values .='						}' . "\n";
												
						$return_values .='							dsF_scroll_item(dsV_scroll_move);' . "\n";
						$return_values .='					}' . "\n";
							


						$return_values .='					function dsF_change_back(item_num){' . "\n";

						$return_values .='					if (item_num == 1){' . "\n";
						$return_values .='                          $("#contentDiv").css(' . $bg_one . ');' . "\n";
						$return_values .='                  }' . "\n";

						$return_values .='					if (item_num == 2){' . "\n";
						$return_values .='                          $("#contentDiv").css(' . $bg_two . ');' . "\n";
						$return_values .='                  }' . "\n";

						$return_values .='					if (item_num == 3){' . "\n";
						$return_values .='                          $("#contentDiv").css(' . $bg_three . ');' . "\n";
						$return_values .='                  }' . "\n";
						$return_values .='					if (item_num == 4){' . "\n";
						$return_values .='                          $("#contentDiv").css(' . $bg_four . ');' . "\n";
						$return_values .='                  }' . "\n";




						$return_values .='					}' . "\n";
						
						
						$return_values .='					function dsF_scroll_item(item_num){' . "\n";
											
						$return_values .='					// only id not already running' . "\n";
						$return_values .='							if (!dsV_scroll_active == true){' . "\n";
													
						$return_values .='							// define movement' . "\n";
						$return_values .='									dsV_scroll_active = ' . 'true;' . "\n";
						$return_values .='									dsV_scroll_pos = \'-\' + ((item_num-1) * dsV_scroll_width);' . "\n";
						$return_values .='									dsV_thumb_pos =  ((item_num-1) * dsV_thumb_width);' . "\n";
							
						$return_values .='									$("#dsCatScrollSlider").animate({' . "\n";
														
						$return_values .='										left: dsV_scroll_pos' . "\n";
														
							$return_values .='									},dsV_scroll_speed,function(){' . "\n";
							$return_values .='								        dsF_change_back(item_num); ' . "\n";
							$return_values .='    								});' . "\n";
						
						if ($banner_type =='icons'){
							// highlight the icon involved
							
							$return_values .='									for (i=1;i<=dsV_scroll_total;i++) {' . "\n";
		   					$return_values .='                                     $("#dsScrollIcon" + i).toggleClass(\'dsSIcon\', true);' . "\n";
		   					$return_values .='                                     $("#dsScrollIcon" + i).toggleClass(\'dsSIconSelect\', false);' . "\n";
							$return_values .='                                  }' . "\n";
		   					$return_values .='                                     $("#dsScrollIcon" + item_num).toggleClass(\'dsSIcon\', false);' . "\n";
		   					$return_values .='                                      $("#dsScrollIcon" + item_num).toggleClass(\'dsSIconSelect\', true);' . "\n";


						
							
							$return_values .='								        dsF_scroll_clear(); ' . "\n";
						}else{
							$return_values .='									$("#dsScrollThumbSelect").animate({' . "\n";
														
							$return_values .='										left: dsV_thumb_pos' . "\n";
														
							$return_values .='									},dsV_scroll_speed,function(){' . "\n";
							$return_values .='								        dsF_scroll_clear(); ' . "\n";
						
							$return_values .='    								});' . "\n";
						}
						
								
						$return_values .='							}' . "\n";
						$return_values .='					}' . "\n";
							
						$return_values .='					function dsF_scroll_to(item_num) {' . "\n";
											
						$return_values .='						if (item_num > 0 && item_num <= dsV_scroll_total) {' . "\n";
												
						$return_values .='							if (!dsV_scroll_active == true){' . "\n";
						$return_values .='								// clear autorun' . "\n";
						$return_values .='								 clearInterval(scrollAuto);' . "\n";
						$return_values .='								// scroll to item' . "\n";
						$return_values .='								dsF_scroll_item(item_num);' . "\n";
						$return_values .='							}' . "\n";
												
						$return_values .='						}' . "\n";
												
											
						$return_values .='					}' . "\n";
						
						
						$return_values .='					// start auto run' . "\n";
						$return_values .='								        dsF_change_back(1); ' . "\n";
						$return_values .='					    scrollAuto = setInterval("dsF_scroll_auto()", dsV_scroll_delay );' . "\n";
						
						$return_values .='					-->' . "\n";
						$return_values .='					</script>' . "\n";
						
			  if (isset($url_one) && strlen($url_one)> 0){
						  if (strpos('a' . $url_one,'#')>0){
							$item_class=' class="aScroll"';
						  }else{
							$item_class='';
						  }
						  
						  if (isset($url_one_window) && $url_one_window == 'true'){
							  $url_link = ' target="_blank"';
						  }else{
							  $url_link = '';
						  }
						  
						  
						$return_values .='				    <div class="dsCatScrollI"><a href="' . $url_one . '"' . $item_class . $url_link .'><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
			  }else{
						$return_values .='				    <div class="dsCatScrollI"><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
			  
			  }
			  if (isset($url_two) && strlen($url_two)> 0){
								  if (strpos('a' . $url_two,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

						  if (isset($url_two_window) && $url_two_window == 'true'){
							  $url_link = ' target="_blank"';
						  }else{
							  $url_link = '';
						  }

						$return_values .='					<div class="dsCatScrollI"><a href="' . $url_two . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_two . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
			  }else{
						$return_values .='					<div class="dsCatScrollI"><img src="' . DS_IMAGES_FOLDER . $image_two . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
			  }
					
						if ($total_images >= 3){
							 if (isset($url_three) && strlen($url_three)> 0){
								  if (strpos('a' . $url_three,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

								  if (isset($url_three_window) && $url_three_window == 'true'){
									  $url_link = ' target="_blank"';
								  }else{
									  $url_link = '';
								  }

								$return_values .='					<div class="dsCatScrollI"><a href="' . $url_three . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_three . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
							 }else{
								$return_values .='					<div class="dsCatScrollI"><img src="' . DS_IMAGES_FOLDER . $image_three . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
							 }
						}
						if ($total_images >= 4){
							 if (isset($url_four) && strlen($url_four)> 0){
								  if (strpos('a' . $url_four,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

								  if (isset($url_four_window) && $url_four_window == 'true'){
									  $url_link = ' target="_blank"';
								  }else{
									  $url_link = '';
								  }

								$return_values .='					<div class="dsCatScrollI"><a href="' . $url_four . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_four . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
							 }else{
								$return_values .='					<div class="dsCatScrollI"><img src="' . DS_IMAGES_FOLDER . $image_four . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
							 }
						
						}					
						$return_values .='					</div>' . "\n";
						
						
						if ($total_images >= 4){
							$return_values .='					<div id="dsScrollIconFour">' . "\n";
						}elseif ($total_images == 3){
							$return_values .='					<div id="dsScrollIconThree">' . "\n";
						}elseif ($total_images == 2){
							$return_values .='					<div id="dsScrollIconTwo">' . "\n";
						}
						
						
						// thumbs
						
						if ($banner_type =='icons'){
						
								$return_values .='						<div id="dsScrollThumbItems">' . "\n";
								$return_values .='							<div class="dsScrollIcon"><a href="#" rel="nofollow" onclick="dsF_scroll_to(1);" class="dsSIconSelect" id="dsScrollIcon1">&nbsp;</a></div>' . "\n";
								$return_values .='							<div class="dsScrollIcon"><a href="#" rel="nofollow" onclick="dsF_scroll_to(2);" class="dsSIcon" id="dsScrollIcon2">&nbsp;</a></div>' . "\n";
								if ($total_images >= 3){
									$return_values .='							<div class="dsScrollIcon"><a href="#" rel="nofollow" onclick="dsF_scroll_to(3);" class="dsSIcon" id="dsScrollIcon3">&nbsp;</a></div>' . "\n";
								}
								if ($total_images >= 4){
									$return_values .='							<div class="dsScrollIcon"><a href="#" rel="nofollow" onclick="dsF_scroll_to(4);" class="dsSIcon" id="dsScrollIcon4">&nbsp;</a></div>' . "\n";
								}
								$return_values .='						</div>' . "\n";
						}else{
							
								$return_values .='						<div id="dsScrollThumbItems">' . "\n";
								$return_values .='							<div id="dsScrollThumbSelect"><div id="dsScrollArrow"><img src="' . DS_IMAGES_FOLDER . 'scroll_arrow.png" alt="" width="9" height="4" /></div></div>' . "\n";
								$return_values .='							<div class="dsCatScrollT"><a href="#" rel="nofollow" onclick="dsF_scroll_to(1);"><img src="' . DS_IMAGES_FOLDER . $thumb_one . '" alt="" width="' . $thumb_width . '" height="' . $thumb_height . '" /></a></div>' . "\n";
								$return_values .='							<div class="dsCatScrollT"><a href="#" rel="nofollow" onclick="dsF_scroll_to(2);"><img src="' . DS_IMAGES_FOLDER . $thumb_two . '" alt="" width="' . $thumb_width . '" height="' . $thumb_height . '" /></a></div>' . "\n";
								
								if ($total_images >= 3){
									$return_values .='							<div class="dsCatScrollT"><a href="#" rel="nofollow" onclick="dsF_scroll_to(3);"><img src="' . DS_IMAGES_FOLDER . $thumb_three . '" alt="" width="' . $thumb_width . '" height="' . $thumb_height . '" /></a></div>' . "\n";
								}
								if ($total_images >= 4){
									$return_values .='							<div class="dsCatScrollT"><a href="#" rel="nofollow" onclick="dsF_scroll_to(4);"><img src="' . DS_IMAGES_FOLDER . $thumb_four . '" alt="" width="' . $thumb_width . '" height="' . $thumb_height . '" /></a></div>' . "\n";
								}
								$return_values .='						</div>' . "\n";
						}
								
								$return_values .='					</div>' . "\n";
						// end thumbs
						
						
											
						$return_values .='				</div>' . "\n";
			
			
			}else{
				// only 1 image can not do slider and thumb
			
						$return_values .=' 				<div id="dsCatScrollHolder">' . "\n";
						$return_values .='					<div id="dsCatScrollSlider">' . "\n";
						if (strlen($url_one)>0){
								  if (strpos('a' . $url_one,'#') >0){
									$item_class =' class="aScroll"';
								  }else{
									$item_class ='';
								  }
							$return_values .='				<div class="dsCatScrollI"><a href="' . $url_one . '"' . $item_class . '><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
						}else{
							$return_values .='				<div class="dsCatScrollI"><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
						}
						$return_values .='					</div>' . "\n";
						$return_values .='				</div>' . "\n";
						
						$return_values .='					<script type="text/javascript">' . "\n";
						$return_values .='$("#contentDiv").css(' . $bg_one . ');' . "\n";
						$return_values .='</script>';
						
						
						
			}

} // end if array
return $return_values;

} // end function
// ######################################





// #############################################################################################

 function dsf_background_scroll($details='', $banner_type='icons' , $icon_width='24'){
 	global $dsv_banner_override_width, $dsv_banner_override_height;
 $return_values = '';
 
 $preload_text = '';
 

$overriding_banner_sizes = 'false';

 if (is_array($details)){
 	
		foreach($details as $id => $value){
			$$id = $value;
		}
 
// values should be
/*							$image_one = '', 
 							$thumb_one = '',
							$url_one = '',
							$image_two = '' ,
							$thumb_two = '',
							$url_two = '',
							$image_three = '',
							$thumb_three = '',
							$url_three = '',
							$image_four = '',
							$thumb_four = '',
							$url_four = '',
							$slider_speed=500,
							$slider_delay=6000
*/

			 // find number of images being sent, these must be filled up in order 1,2,3 etc.
			 $total_images = 0;
			 
			 if (isset($image_one) && strlen($image_one)> 5 && isset($thumb_one) && strlen($thumb_one)>5){
				$total_images ++;
			 }
			 
			  if (isset($image_two) && strlen($image_two)> 5 && isset($thumb_two) && strlen($thumb_two)>5){
				$total_images ++;
			 }
			
			   if (isset($image_three) && strlen($image_three)> 5 && isset($thumb_three) && strlen($thumb_three)>5){
				$total_images ++;
			 }
			
			   if (isset($image_four) && strlen($image_four)> 5 && isset($thumb_four) && strlen($thumb_four)>5){
				$total_images ++;
			 }
			 
			 
			 if (isset($dsv_banner_override_width) && (int)$dsv_banner_override_width > 0){
				 $image_width = $dsv_banner_override_width;
			 }else{
				$image_width = BANNER_IMAGE_WIDTH;	// default width
			 }
			 
			 if (isset($dsv_banner_override_height) && (int)$dsv_banner_override_height > 0){
				 $image_height = $dsv_banner_override_height;
			 }else{
				$image_height = BANNER_IMAGE_HEIGHT;	// default height
			 }
			 
			 
			 
			 
			 
				$thumb_width = BANNER_THUMB_WIDTH;	// default width
				$thumb_height = BANNER_THUMB_HEIGHT;	// default height
			
			  if (!isset($slider_speed) || (int)$slider_speed == 0){
				$slider_speed = 100;	// default speed 900
			 }
			
			  if (!isset($slider_delay) || (int)$slider_delay == 0){
				$slider_delay = 12000;	// default delay
			 }
			
			
			
			
			// define background colour or slides which we will use javascript to change.
			// ONE
			
			if (isset($background_one) && strlen($background_one) > 1){
				$bg_one = "'background-image':'url(" . $background_one . ")'";
					$preload_text .= "MM_preloadImages('" .  $background_one . "');\n";

			}
			
			if (isset($colour_one) && strlen($colour_one) > 1){
				if (isset($bg_one) && strlen($bg_one)> 1){
					$bg_one .= ",'background-color':'" . $colour_one . "'";
				}else{
					$bg_one = "'background-color':'" . $colour_one . "','background-image':'none'";
				}
			}
			
			if (!isset($bg_one)){
					$bg_one = "'background-color':'none','background-image':'none'";
			}
			
			
			// TWO
			if (isset($background_two) && strlen($background_two) > 1){
				$bg_two = "'background-image':'url(" . $background_two . ")'";
					$preload_text .= "MM_preloadImages('" .  $background_two . "');\n";
			}
			
			if (isset($colour_two) && strlen($colour_two) > 1){
				if (strlen($bg_two)> 1){
					$bg_two .= ",'background-color':'" . $colour_two . "'";
				}else{
					$bg_two = "'background-color':'" . $colour_two . "','background-image':'none'";
				}
			}
			
			if (!isset($bg_two)){
					$bg_two = "'background-color':'none','background-image':'none'";
			}
			
			
			// THREE
			if (isset($background_three) && strlen($background_three) > 1){
				$bg_three = "'background-image':'url(" . $background_three . ")'";
					$preload_text .= "MM_preloadImages('" .  $background_three . "')\n;";
			}
			
			if (isset($colour_three) && strlen($colour_three) > 1){
				if (strlen($bg_three)> 1){
					$bg_three .= ",'background-color':'" . $colour_three . "'";
				}else{
					$bg_three = "'background-color':'" . $colour_three . "','background-image':'none'";
				}
			}


			if (!isset($bg_three)){
					$bg_three = "'background-color':'none','background-image':'none'";
			}

			// FOUR
			if (isset($background_four) && strlen($background_four) > 1){
				$bg_four = "'background-image':'url(" . $background_four . ")'";
					$preload_text .= "MM_preloadImages('" .  $background_four . "');\n";
			}
			
			if (isset($colour_four) && strlen($colour_four) > 1){
				if (strlen($bg_four)> 1){
					$bg_four .= ",'background-color':'" . $colour_four . "'";
				}else{
					$bg_four = "'background-color':'" . $colour_four . "','background-image':'none'";
				}
			}

			if (!isset($bg_four)){
					$bg_four = "'background-color':'none','background-image':'none'";
			}




			
			$bg_one = '{' . $bg_one . '}';
			$bg_two = '{' . $bg_two . '}';
			$bg_three = '{' . $bg_three . '}';
			$bg_four = '{' . $bg_four . '}';
			
			
			
			
			
			 // start return values to echo
			 
			 if ($total_images > 1){
			 
			 
						$return_values .=' 				<div id="dsScrollHolder">' . "\n";
						$return_values .=' 	<div id="dsBanLArrow"><a href="javascript:void(0);" onclick="dsF_Bscroll_left();">&nbsp;</a></div>';
						$return_values .=' 	<div id="dsBanRArrow"><a href="javascript:void(0);" onclick="dsF_Bscroll_right();">&nbsp;</a></div>';

						$return_values .='					<div id="dsScrollSlider">' . "\n";
						
						
						
						
						$return_values .='					<script type="text/javascript">' . "\n";
						$return_values .='					<!--' . "\n";
						
						if (strlen($preload_text) > 1){
							$return_values .= $preload_text;
						}
						
						
						
						$return_values .='					// Initialise scroll variables' . "\n";
						$return_values .='					var dsV_scroll_total = ' . $total_images . ';' . "\n";
						$return_values .='					var dsV_scroll_width = ' . $image_width . ';' . "\n";
						
						$return_values .='					var dsV_scroll_pos = 0;' . "\n";
						$return_values .='					var dsV_scroll_move = 1;' . "\n";
						$return_values .='					var dsV_scroll_speed = ' . $slider_speed . ';' . "\n";
						$return_values .='					var dsV_scroll_delay = ' . $slider_delay . ';' . "\n";
						$return_values .='					var dsV_scroll_active = false;' . "\n";
											
						$return_values .='					// scroll functions' . "\n";
						$return_values .='					function dsF_scroll_clear(){' . "\n";
						$return_values .='						dsV_scroll_active = false;' . "\n";
						$return_values .='					}' . "\n";
											
						$return_values .='					function dsF_scroll_auto() {' . "\n";
											
						$return_values .='						dsV_scroll_move += 1;' . "\n";
						$return_values .='						if (dsV_scroll_move > dsV_scroll_total){' . "\n";
						$return_values .='							dsV_scroll_move = 1;' . "\n";
						$return_values .='						}' . "\n";
												
						$return_values .='							dsF_scroll_item(dsV_scroll_move);' . "\n";
						$return_values .='					}' . "\n";
							


						$return_values .='					function dsF_change_back(item_num){' . "\n";

						$return_values .='					if (item_num == 1){' . "\n";
						$return_values .='                          $("#dsContentMask").fadeOut("800", function () {' . "\n";
						$return_values .='                          $("#dsContentMask").css(' . $bg_one . ');' . "\n";
						$return_values .='                          $("#dsContentMask").fadeIn("800");' . "\n";
						$return_values .='                  });' . "\n";
						$return_values .='                  }' . "\n";

						$return_values .='					if (item_num == 2){' . "\n";
						$return_values .='                          $("#dsContentMask").fadeOut("800", function () {' . "\n";
						$return_values .='                          $("#dsContentMask").css(' . $bg_two . ');' . "\n";
						$return_values .='                          $("#dsContentMask").fadeIn("800");' . "\n";
						$return_values .='                  });' . "\n";
						$return_values .='                  }' . "\n";

						$return_values .='					if (item_num == 3){' . "\n";
						$return_values .='                          $("#dsContentMask").fadeOut("800", function () {' . "\n";
						$return_values .='                          $("#dsContentMask").css(' . $bg_three . ');' . "\n";
						$return_values .='                          $("#dsContentMask").fadeIn("800");' . "\n";
						$return_values .='                  });' . "\n";
						$return_values .='                  }' . "\n";
						$return_values .='					if (item_num == 4){' . "\n";
						$return_values .='                          $("#dsContentMask").fadeOut("800", function () {' . "\n";
						$return_values .='                          $("#dsContentMask").css(' . $bg_four . ');' . "\n";
						$return_values .='                          $("#dsContentMask").fadeIn("800");' . "\n";
						$return_values .='                  });' . "\n";
						$return_values .='                  }' . "\n";



						$return_values .='					}' . "\n";
						
						
						$return_values .='					function dsF_scroll_item(item_num){' . "\n";
											
						$return_values .='					// only id not already running' . "\n";
						$return_values .='							if (!dsV_scroll_active == true){' . "\n";
													
						$return_values .='							// define movement' . "\n";
						$return_values .='									dsV_scroll_active = ' . 'true;' . "\n";
						$return_values .='									dsV_scroll_pos = \'-\' + ((item_num-1) * dsV_scroll_width);' . "\n";
							
						$return_values .='									$("#dsScrollSlider").animate({' . "\n";
														
						$return_values .='										left: dsV_scroll_pos' . "\n";
														
							$return_values .='									},dsV_scroll_speed,function(){' . "\n";
							$return_values .='								        dsF_change_back(item_num); ' . "\n";
							$return_values .='    								});' . "\n";
						
							$return_values .='								        dsF_scroll_clear(); ' . "\n";
						
								
						$return_values .='							}' . "\n";
						$return_values .='					}' . "\n";
							
						$return_values .='					function dsF_scroll_to(item_num) {' . "\n";
											
						$return_values .='						if (item_num > 0 && item_num <= dsV_scroll_total) {' . "\n";
												
						$return_values .='							if (!dsV_scroll_active == true){' . "\n";
						$return_values .='								// clear autorun' . "\n";
						$return_values .='								 clearInterval(scrollAuto);' . "\n";
						$return_values .='								// scroll to item' . "\n";
						$return_values .='								dsF_scroll_item(item_num);' . "\n";
						$return_values .='							}' . "\n";
												
						$return_values .='						}' . "\n";
												
											
						$return_values .='					}' . "\n";



						$return_values .='					function dsF_Bscroll_left() {' . "\n";
						$return_values .='						if (dsV_scroll_move > 1 ) {' . "\n";
						$return_values .='							dsV_scroll_move = dsV_scroll_move - 1;' . "\n";
						$return_values .='						dsF_scroll_to(dsV_scroll_move)' . "\n";
						$return_values .="						$('#dsBanLArrow a').blur();" . "\n";
						
						
						
						$return_values .='						}' . "\n";
												
						$return_values .='					}' . "\n";


						$return_values .='					function dsF_Bscroll_right() {' . "\n";
						$return_values .='						if (dsV_scroll_move < dsV_scroll_total ) {' . "\n";
						$return_values .='							dsV_scroll_move = dsV_scroll_move + 1;' . "\n";
						$return_values .='						dsF_scroll_to(dsV_scroll_move)' . "\n";
						$return_values .="						$('#dsBanRArrow a').blur();" . "\n";
						
						$return_values .='						}' . "\n";
												
						$return_values .='					}' . "\n";

						
						
						$return_values .='					// start auto run' . "\n";
						$return_values .='								        dsF_change_back(1); ' . "\n";
						$return_values .='					    scrollAuto = setInterval("dsF_scroll_auto()", dsV_scroll_delay );' . "\n";
						
						$return_values .='					-->' . "\n";
						$return_values .='					</script>' . "\n";
						
			  if (isset($url_one) && strlen($url_one)> 0){
						  if (strpos('a' . $url_one,'#')>0){
							$item_class=' class="aScroll"';
						  }else{
							$item_class='';
						  }
						  
						  if (isset($url_one_window) && $url_one_window == 'true'){
							  $url_link = ' target="_blank"';
						  }else{
							  $url_link = '';
						  }
						  
						  
						$return_values .='				    <div class="dsScrollI"><a href="' . $url_one . '"' . $item_class . $url_link .'><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
			  }else{
						$return_values .='				    <div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
			  
			  }
			  if (isset($url_two) && strlen($url_two)> 0){
								  if (strpos('a' . $url_two,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

						  if (isset($url_two_window) && $url_two_window == 'true'){
							  $url_link = ' target="_blank"';
						  }else{
							  $url_link = '';
						  }

						$return_values .='					<div class="dsScrollI"><a href="' . $url_two . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_two . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
			  }else{
						$return_values .='					<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_two . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
			  }
					
						if ($total_images >= 3){
							 if (isset($url_three) && strlen($url_three)> 0){
								  if (strpos('a' . $url_three,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

								  if (isset($url_three_window) && $url_three_window == 'true'){
									  $url_link = ' target="_blank"';
								  }else{
									  $url_link = '';
								  }

								$return_values .='					<div class="dsScrollI"><a href="' . $url_three . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_three . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
							 }else{
								$return_values .='					<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_three . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
							 }
						}
						if ($total_images >= 4){
							 if (isset($url_four) && strlen($url_four)> 0){
								  if (strpos('a' . $url_four,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

								  if (isset($url_four_window) && $url_four_window == 'true'){
									  $url_link = ' target="_blank"';
								  }else{
									  $url_link = '';
								  }

								$return_values .='					<div class="dsScrollI"><a href="' . $url_four . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_four . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
							 }else{
								$return_values .='					<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_four . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
							 }
						
						}					
						$return_values .='					</div>' . "\n";
						
						
						
						
											
						$return_values .='				</div>' . "\n";
			
			
			}else{
				// only 1 image can not do slider and thumb
			
						$return_values .=' 				<div id="dsScrollHolder">' . "\n";
						$return_values .='					<div id="dsScrollSlider">' . "\n";
						if (strlen($url_one)>0){
								  if (strpos('a' . $url_one,'#') >0){
									$item_class =' class="aScroll"';
								  }else{
									$item_class ='';
								  }
							$return_values .='				<div class="dsScrollI"><a href="' . $url_one . '"' . $item_class . '><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
						}else{
							$return_values .='				<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
						}
						$return_values .='					</div>' . "\n";
						$return_values .='				</div>' . "\n";
						
						$return_values .='					<script type="text/javascript">' . "\n";
						$return_values .='$("#dsContentMask").css(' . $bg_one . ');' . "\n";
						$return_values .='</script>';
						
						
						
			}

} // end if array
return $return_values;

} // end function
// ######################################


// #############################################################################################

 function dsf_background_scrollB($details='', $banner_type='icons' , $icon_width='24'){
 	global $dsv_banner_override_width, $dsv_banner_override_height;
 $return_values = '';
 $preload_text = '';

$overriding_banner_sizes = 'false';

 if (is_array($details)){
 	
		foreach($details as $id => $value){
			$$id = $value;
		}
 
// values should be
/*							$image_one = '', 
 							$thumb_one = '',
							$url_one = '',
							$image_two = '' ,
							$thumb_two = '',
							$url_two = '',
							$image_three = '',
							$thumb_three = '',
							$url_three = '',
							$image_four = '',
							$thumb_four = '',
							$url_four = '',
							$slider_speed=500,
							$slider_delay=6000
*/

			 // find number of images being sent, these must be filled up in order 1,2,3 etc.
			 $total_images = 0;
			 
			 if (isset($image_one) && strlen($image_one)> 5 && isset($thumb_one) && strlen($thumb_one)>5){
				$total_images ++;
			 }
			 
			  if (isset($image_two) && strlen($image_two)> 5 && isset($thumb_two) && strlen($thumb_two)>5){
				$total_images ++;
			 }
			
			   if (isset($image_three) && strlen($image_three)> 5 && isset($thumb_three) && strlen($thumb_three)>5){
				$total_images ++;
			 }
			
			   if (isset($image_four) && strlen($image_four)> 5 && isset($thumb_four) && strlen($thumb_four)>5){
				$total_images ++;
			 }
			 
			 
			 if (isset($dsv_banner_override_width) && (int)$dsv_banner_override_width > 0){
				 $image_width = $dsv_banner_override_width;
			 }else{
				$image_width = BANNER_IMAGE_WIDTH;	// default width
			 }
			 
			 if (isset($dsv_banner_override_height) && (int)$dsv_banner_override_height > 0){
				 $image_height = $dsv_banner_override_height;
			 }else{
				$image_height = BANNER_IMAGE_HEIGHT;	// default height
			 }
			 
			 
			 
			 
			 
				$thumb_width = BANNER_THUMB_WIDTH;	// default width
				$thumb_height = BANNER_THUMB_HEIGHT;	// default height
			
			  if (!isset($slider_speed) || (int)$slider_speed == 0){
				$slider_speed = 100;	// default speed 900
			 }
			
			  if (!isset($slider_delay) || (int)$slider_delay == 0){
				$slider_delay = 12000;	// default delay
			 }
			
			
			
			
			// define background colour or slides which we will use javascript to change.
			// ONE
			
			if (isset($background_one) && strlen($background_one) > 1){
				$bg_one = "'background-image':'url(" . $background_one . ")'";
					$preload_text .= "MM_preloadImages('" .  $background_one . "');\n";
			}
			
			if (isset($colour_one) && strlen($colour_one) > 1){
				if (isset($bg_one) && strlen($bg_one)> 1){
					$bg_one .= ",'background-color':'" . $colour_one . "'";
				}else{
					$bg_one = "'background-color':'" . $colour_one . "','background-image':'none'";
				}
			}
			
			if (!isset($bg_one)){
					$bg_one = "'background-color':'none','background-image':'none'";
			}
			
			
			// TWO
			if (isset($background_two) && strlen($background_two) > 1){
				$bg_two = "'background-image':'url(" . $background_two . ")'";
					$preload_text .= "MM_preloadImages('" .  $background_two . "');\n";
			}
			
			if (isset($colour_two) && strlen($colour_two) > 1){
				if (strlen($bg_two)> 1){
					$bg_two .= ",'background-color':'" . $colour_two . "'";
				}else{
					$bg_two = "'background-color':'" . $colour_two . "','background-image':'none'";
				}
			}
			
			if (!isset($bg_two)){
					$bg_two = "'background-color':'none','background-image':'none'";
			}
			
			
			// THREE
			if (isset($background_three) && strlen($background_three) > 1){
				$bg_three = "'background-image':'url(" . $background_three . ")'";
					$preload_text .= "MM_preloadImages('" .  $background_three . "');\n";
			}
			
			if (isset($colour_three) && strlen($colour_three) > 1){
				if (strlen($bg_three)> 1){
					$bg_three .= ",'background-color':'" . $colour_three . "'";
				}else{
					$bg_three = "'background-color':'" . $colour_three . "','background-image':'none'";
				}
			}


			if (!isset($bg_three)){
					$bg_three = "'background-color':'none','background-image':'none'";
			}

			// FOUR
			if (isset($background_four) && strlen($background_four) > 1){
				$bg_four = "'background-image':'url(" . $background_four . ")'";
					$preload_text .= "MM_preloadImages('" .  $background_four . "');\n";
			}
			
			if (isset($colour_four) && strlen($colour_four) > 1){
				if (strlen($bg_four)> 1){
					$bg_four .= ",'background-color':'" . $colour_four . "'";
				}else{
					$bg_four = "'background-color':'" . $colour_four . "','background-image':'none'";
				}
			}

			if (!isset($bg_four)){
					$bg_four = "'background-color':'none','background-image':'none'";
			}




			
			$bg_one = '{' . $bg_one . '}';
			$bg_two = '{' . $bg_two . '}';
			$bg_three = '{' . $bg_three . '}';
			$bg_four = '{' . $bg_four . '}';
			
			
			
			
			
			 // start return values to echo
			 
			 if ($total_images > 1){
			 
			 
						$return_values .=' 				<div id="dsScrollHolderB">' . "\n";
						$return_values .=' 	<div id="dsCBanLArrow"><a href="javascript:void(0);" onclick="dsF_Bscroll_left();">&nbsp;</a></div>';
						$return_values .=' 	<div id="dsCBanRArrow"><a href="javascript:void(0);" onclick="dsF_Bscroll_right();">&nbsp;</a></div>';


						$return_values .='					<div id="dsScrollSliderB">' . "\n";
						$return_values .='					<script type="text/javascript">' . "\n";
						$return_values .='					<!--' . "\n";


						if (strlen($preload_text) > 1){
							$return_values .= $preload_text;
						}
						


						$return_values .='					// Initialise scroll variables' . "\n";
						$return_values .='					var dsV_scroll_total = ' . $total_images . ';' . "\n";
						$return_values .='					var dsV_scroll_width = ' . $image_width . ';' . "\n";
						
						$return_values .='					var dsV_scroll_pos = 0;' . "\n";
						$return_values .='					var dsV_scroll_move = 1;' . "\n";
						$return_values .='					var dsV_scroll_speed = ' . $slider_speed . ';' . "\n";
						$return_values .='					var dsV_scroll_delay = ' . $slider_delay . ';' . "\n";
						$return_values .='					var dsV_scroll_active = false;' . "\n";
											
						$return_values .='					// scroll functions' . "\n";
						$return_values .='					function dsF_scroll_clear(){' . "\n";
						$return_values .='						dsV_scroll_active = false;' . "\n";
						$return_values .='					}' . "\n";
											
						$return_values .='					function dsF_scroll_auto() {' . "\n";
											
						$return_values .='						dsV_scroll_move += 1;' . "\n";
						$return_values .='						if (dsV_scroll_move > dsV_scroll_total){' . "\n";
						$return_values .='							dsV_scroll_move = 1;' . "\n";
						$return_values .='						}' . "\n";
												
						$return_values .='							dsF_scroll_item(dsV_scroll_move);' . "\n";
						$return_values .='					}' . "\n";
							


						$return_values .='					function dsF_change_back(item_num){' . "\n";

						$return_values .='					if (item_num == 1){' . "\n";
						$return_values .='                          $("#dsContentMaskB").fadeOut("800", function () {' . "\n";
						$return_values .='                          $("#dsContentMaskB").css(' . $bg_one . ');' . "\n";
						$return_values .='                          $("#dsContentMaskB").fadeIn("800");' . "\n";
						$return_values .='                  });' . "\n";
						$return_values .='                  }' . "\n";

						$return_values .='					if (item_num == 2){' . "\n";
						$return_values .='                          $("#dsContentMaskB").fadeOut("800", function () {' . "\n";
						$return_values .='                          $("#dsContentMaskB").css(' . $bg_two . ');' . "\n";
						$return_values .='                          $("#dsContentMaskB").fadeIn("800");' . "\n";
						$return_values .='                  });' . "\n";
						$return_values .='                  }' . "\n";

						$return_values .='					if (item_num == 3){' . "\n";
						$return_values .='                          $("#dsContentMaskB").fadeOut("800", function () {' . "\n";
						$return_values .='                          $("#dsContentMaskB").css(' . $bg_three . ');' . "\n";
						$return_values .='                          $("#dsContentMaskB").fadeIn("800");' . "\n";
						$return_values .='                  });' . "\n";
						$return_values .='                  }' . "\n";
						$return_values .='					if (item_num == 4){' . "\n";
						$return_values .='                          $("#dsContentMaskB").fadeOut("800", function () {' . "\n";
						$return_values .='                          $("#dsContentMaskB").css(' . $bg_four . ');' . "\n";
						$return_values .='                          $("#dsContentMaskB").fadeIn("800");' . "\n";
						$return_values .='                  });' . "\n";
						$return_values .='                  }' . "\n";


						$return_values .='					}' . "\n";
						
						
						$return_values .='					function dsF_scroll_item(item_num){' . "\n";
											
						$return_values .='					// only id not already running' . "\n";
						$return_values .='							if (!dsV_scroll_active == true){' . "\n";
													
						$return_values .='							// define movement' . "\n";
						$return_values .='									dsV_scroll_active = ' . 'true;' . "\n";
						$return_values .='									dsV_scroll_pos = \'-\' + ((item_num-1) * dsV_scroll_width);' . "\n";
							
						$return_values .='									$("#dsScrollSliderB").animate({' . "\n";
														
						$return_values .='										left: dsV_scroll_pos' . "\n";
														
							$return_values .='									},dsV_scroll_speed,function(){' . "\n";
							$return_values .='								        dsF_change_back(item_num); ' . "\n";
							$return_values .='    								});' . "\n";
						
				
							$return_values .='								        dsF_scroll_clear(); ' . "\n";
						
								
						$return_values .='							}' . "\n";
						$return_values .='					}' . "\n";
							
						$return_values .='					function dsF_scroll_to(item_num) {' . "\n";
											
						$return_values .='						if (item_num > 0 && item_num <= dsV_scroll_total) {' . "\n";
												
						$return_values .='							if (!dsV_scroll_active == true){' . "\n";
						$return_values .='								// clear autorun' . "\n";
						$return_values .='								 clearInterval(scrollAuto);' . "\n";
						$return_values .='								// scroll to item' . "\n";
						$return_values .='								dsF_scroll_item(item_num);' . "\n";
						$return_values .='							}' . "\n";
												
						$return_values .='						}' . "\n";
												
											
						$return_values .='					}' . "\n";


						$return_values .='					function dsF_Bscroll_left() {' . "\n";
						$return_values .='						if (dsV_scroll_move > 1 ) {' . "\n";
						$return_values .='							dsV_scroll_move = dsV_scroll_move - 1;' . "\n";
						$return_values .='						dsF_scroll_to(dsV_scroll_move)' . "\n";
						$return_values .="						$('#dsCBanLArrow a').blur();" . "\n";
						
						
						
						$return_values .='						}' . "\n";
												
						$return_values .='					}' . "\n";


						$return_values .='					function dsF_Bscroll_right() {' . "\n";
						$return_values .='						if (dsV_scroll_move < dsV_scroll_total ) {' . "\n";
						$return_values .='							dsV_scroll_move = dsV_scroll_move + 1;' . "\n";
						$return_values .='						dsF_scroll_to(dsV_scroll_move)' . "\n";
						$return_values .="						$('#dsCBanRArrow a').blur();" . "\n";
						
						$return_values .='						}' . "\n";
												
						$return_values .='					}' . "\n";

						

						
						
						$return_values .='					// start auto run' . "\n";
						$return_values .='								        dsF_change_back(1); ' . "\n";
						$return_values .='					    scrollAuto = setInterval("dsF_scroll_auto()", dsV_scroll_delay );' . "\n";
						
						$return_values .='					-->' . "\n";
						$return_values .='					</script>' . "\n";
						
			  if (isset($url_one) && strlen($url_one)> 0){
						  if (strpos('a' . $url_one,'#')>0){
							$item_class=' class="aScroll"';
						  }else{
							$item_class='';
						  }
						  
						  if (isset($url_one_window) && $url_one_window == 'true'){
							  $url_link = ' target="_blank"';
						  }else{
							  $url_link = '';
						  }
						  
						  
						$return_values .='				    <div class="dsScrollI"><a href="' . $url_one . '"' . $item_class . $url_link .'><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
			  }else{
						$return_values .='				    <div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
			  
			  }
			  if (isset($url_two) && strlen($url_two)> 0){
								  if (strpos('a' . $url_two,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

						  if (isset($url_two_window) && $url_two_window == 'true'){
							  $url_link = ' target="_blank"';
						  }else{
							  $url_link = '';
						  }

						$return_values .='					<div class="dsScrollI"><a href="' . $url_two . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_two . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
			  }else{
						$return_values .='					<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_two . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
			  }
					
						if ($total_images >= 3){
							 if (isset($url_three) && strlen($url_three)> 0){
								  if (strpos('a' . $url_three,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

								  if (isset($url_three_window) && $url_three_window == 'true'){
									  $url_link = ' target="_blank"';
								  }else{
									  $url_link = '';
								  }

								$return_values .='					<div class="dsScrollI"><a href="' . $url_three . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_three . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
							 }else{
								$return_values .='					<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_three . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
							 }
						}
						if ($total_images >= 4){
							 if (isset($url_four) && strlen($url_four)> 0){
								  if (strpos('a' . $url_four,'#')>0){
									$item_class=' class="aScroll"';
								  }else{
									$item_class='';
								  }

								  if (isset($url_four_window) && $url_four_window == 'true'){
									  $url_link = ' target="_blank"';
								  }else{
									  $url_link = '';
								  }

								$return_values .='					<div class="dsScrollI"><a href="' . $url_four . '"' . $item_class . $url_link . '><img src="' . DS_IMAGES_FOLDER . $image_four . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
							 }else{
								$return_values .='					<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_four . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
							 }
						
						}					
						$return_values .='					</div>' . "\n";
						
						
						
											
						$return_values .='				</div>' . "\n";
			
			
			}else{
				// only 1 image can not do slider and thumb
			
						$return_values .=' 				<div id="dsScrollHolderB">' . "\n";
						$return_values .='					<div id="dsScrollSliderB">' . "\n";
						if (strlen($url_one)>0){
								  if (strpos('a' . $url_one,'#') >0){
									$item_class =' class="aScroll"';
								  }else{
									$item_class ='';
								  }
							$return_values .='				<div class="dsScrollI"><a href="' . $url_one . '"' . $item_class . '><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></a></div>' . "\n";
						}else{
							$return_values .='				<div class="dsScrollI"><img src="' . DS_IMAGES_FOLDER . $image_one . '" alt="" width="' . $image_width . '" height="' . $image_height . '" /></div>' . "\n";
						}
						$return_values .='					</div>' . "\n";
						$return_values .='				</div>' . "\n";
						
						$return_values .='					<script type="text/javascript">' . "\n";

						$return_values .='$("#dsContentMaskB").css(' . $bg_one . ');' . "\n";
						$return_values .='</script>';
						
						
						
			}

} // end if array
return $return_values;

} // end function
// ######################################


?>