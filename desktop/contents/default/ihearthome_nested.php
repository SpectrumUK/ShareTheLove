<?php

// EXPLANATION OF A REPLACE SOLUTION

// you would put the function at the top of each content page (including any being loaded by ajax)


if (!function_exists('sr_heart_replace')){
	function sr_heart_replace($string_to_check = ''){
	
	// it is possible to do a single replace mode by using arrays as the first and seccond parameters however,
	// by doing that in this case it is going to be rather difficult to ready and adjust.
	
	// we will therefore just do a sequence of single replace commands one after the other until testing is complete and you are
	// happy with the outcome, this could then be changed to a single command with arrays later.
	
	$string_to_check = str_replace("[REDHEART1]" , '<span class="heart_red_header"></span>' , $string_to_check);
	$string_to_check = str_replace("[REDHEART2]" , '<span class="heart_red"></span>' , $string_to_check);
	$string_to_check = str_replace("[REDHEART3]" , '<span class="topright_redheart"></span>' , $string_to_check);
	$string_to_check = str_replace("[WHITEHEART1]" , '<span class="heart_white"></span>' , $string_to_check);
	$string_to_check = str_replace("[WHITEHEART2]" , '<span class="heart_white_poll" style="margin: 3px 0 0 0;"></span>' , $string_to_check);
	$string_to_check = str_replace("[WHITEHEART3]" , '<span class="topright_whiteheart"></span>' , $string_to_check);
	$string_to_check = str_replace("[WHITEHEART4]" , '<span class="heart_white_red_block"></span>' , $string_to_check);
	
	// alternatively,  if you didn't want to use the internal dsf_image function because you wanted to do some additional styles etc....  you could replace
	// using standard html
	
	
	// $string_to_check = str_replace("[WHITEHEART2]" , '<img src="custom/visa_icon.jpg" width="100" height="100" class="someclass" />' , $string_to_check);
	
	
	
	
// return back to the calling script the answer
	return $string_to_check;
	
	} // end function
} // end checking for function already loaded.

?>

<div class="nav_topright">
<p><a href="<?php echo $SSL_bref;?>image_upload.html?mechanicID=1"><?php echo sr_heart_replace(TRANSLATION_USER_CUSTOM_TEN);?></a> &nbsp;|&nbsp;<a href="<?php echo $bref;?>user_images.html?mechanicID=1"><?php echo TRANSLATION_GALLERY_HEADER;?></a>
<?php /*&nbsp;&nbsp;<span class="topright_instagram"></span> <span class="topright_facebook"></span>*/?></p>
</div>
	
	<div class="height15"></div>
	
	<div class="col-sm-4 firstfix">
    <?php echo '<a href="' . $seasonal_details_menu['url'] . '">' . dsf_image($seasonal_details_menu ['image'], $seasonal_details_menu['name'],'','', 'class="img-responsive"') . '</a>';?>
	</div>
	<div class="col-sm-8 navigationholder">
	
	<div class="jcarousel-wrapper" style="float: right; width: 536px;">
		<div class="jcarousel">
			<ul>
            	
            <?php 
			
			echo '<li ';

    if ($seasonal_details_menu['selected'] == 'true'){
      echo 'class="active navigation_sub" class="navigation_sub">';
      }else{
      echo 'class="navigation_sub">';  
      }

    echo '<a href="' . $seasonal_details_menu['url'] . '">' . $seasonal_details_menu['title'] .'</a></li>';
			
				// loop through children
    foreach ($seasonal_details_menu['children'] as $item){
 
 		echo '<li ';

 			if ($item['selected'] == 'true'){
  				echo 'class="active navigation_sub" class="navigation_sub">';
 					}else{
  				echo 'class="navigation_sub">';  
 					}

				echo '<a href="' . $item['url'] . '">' . $item['name'] .'</a></li>';
    
    		}
		?>   <li>&nbsp;</li>
			</ul>
		</div>
		
		<a href="#" class="jcarousel-control-prev navigationslideleft"><img class="img-responsive" src="../../../images/custom/ihearthome/icons/navarrow_left.png" alt=""/></a>
		<a href="#" class="jcarousel-control-next navigationslideright"><img class="img-responsive" src="../../../images/custom/ihearthome/icons/navarrow_right.png" alt=""/></a>
		</div>
	</div>

	<div class="height15"></div>

<?php

// The contents of the seasonal article is within the array $seasonal_details

// to see the contents of the array run the following command

// echo dsf_print_array($seasonal_details);

/*

The value of $seasonal_details['article_level'] is the most important aspect as that will supply different options
for an if statement to show different things from within the same content file based on the level of the article.


Possible values are:	article	- a physical article to display the details.
						asset	- this is an asset folder and as such should not be displayed.
						include	- referencing a different item to include as if it was an article (read details below)
						hub		- a folder at root level
						nested	- a folder further down from the root.
						none	- an error has occurred finding the item

$seasonal_details['article_level'] = include

This will have the following attibutes set.

$seasonal_details['article_include_id']
$seasonal_details['article_include_type']
$seasonal_details['article_include_path']
$seasonal_details['article_include_file']

By referencing the $seasonal_details['article_include_type'] value you can decipher which array the necessary details will be in

for instance :

$seasonal_details['article_include_type'] == 'gallery'

will mean an array called $seasonal_details['gallery_details'] will be set containing all of the fields as if you had viewed the gallery.php file directly.

Additionally, the variable $seasonal_details['article_include_path'] will contain the FULL server path rather than just the path /contents/desktop etc....
this is required as the content file you are including this item from will already be in a set path. As such the relative paths can change. To ensure the correct path each time we reference the absolute path to the folder.

*/

// see what level we are referencing

if (isset($seasonal_details['article_level'])){

// ##### HUB TYPE

	if ($seasonal_details['article_level'] == 'hub'){
		?>

        <div class="col-md-12 firstfix nopaddingright positionrelative">
        <?php echo dsf_image($seasonal_details['banner_desktop']['dsv_banner_one_image'], $seasonal_details['name'],'','', 'class="img-responsive"');?>
		
		<div class="hero_darkgraybg">
			<p class="font22 gothambold marginbottom0" style="z-index:100; position:relative; line-height:25px; width:620px;"><?php echo sr_heart_replace($seasonal_details['text_one']);?></p>
			<p style="z-index:100; position:relative; width:620px;"><?php echo sr_heart_replace($seasonal_details['text_two']);?></p>
			<p class="redtxt font18"><strong><?php echo $seasonal_details['text_three'];?></strong></p>

			<div class="home_stepsbox curvedcorners">
				<div class="home_stepsbox_icon pull-left"><img class="img-responsive" src="../../../images/custom/ihearthome/icons/steps_icon1.png" alt=""/></div>
				<p class="small11 blacktxt"><?php echo $seasonal_details['text_four'];?></p>
			</div>
			<div class="home_stepsbox curvedcorners">
				<div class="pull-left home_stepsbox_icon"><img class="img-responsive" src="../../../images/custom/ihearthome/icons/steps_icon2.png" alt=""/></div>				
				<p class="small11 blacktxt"><?php echo $seasonal_details['text_five'];?></p>
			</div>
			<div class="home_stepsboxlast curvedcorners">		
				<p class="whitetxt font14 text-center paddingall12"><a href="<?php echo $SSL_bref;?>image_upload.html?mechanicID=1"><strong><?php echo sr_heart_replace($seasonal_details['text_six']);?></strong></a></p>
			</div>						
			<div class="clear"></div>
		</div>
		<div class="home_productplace">
        <a href="<?php echo $seasonal_details['article_products'][0]['url'];?>"><?php echo dsf_image($seasonal_details['article_image_one'], $seasonal_details['text_seven'], '', '', 'class="img-responsive"');?></a>
		</div>
	</div>
    <div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>


        <?php

// we using allocated items as children within the homepage section, therefore for the children content files to work correctly, we need to set the values accordingly.
	
		if (isset($seasonal_details['allocated_items']) && sizeof($seasonal_details['allocated_items']) > 0){
			
			foreach($seasonal_details['allocated_items'] as $allocated_item){


// echo 'BEFORE' . dsf_print_array($allocated_item);

				// if the allocated item is a seasonal article then its possible that it will be an include on an include
				
					if (isset($allocated_item['article_include_type']) && $allocated_item['article_include_type'] == 'seasonal_article'){
	
						$child = $allocated_item['seasonal_details'];
						
						// additional check with seasonal articles includes to see if there is something further down to set.
						
								if (isset($allocated_item['seasonal_details']['article_include_type']) && $allocated_item['seasonal_details']['article_include_type'] == 'gallery'){
												//				$gallery_details = $allocated_item['seasonal_details']['gallery_details'];						
						
								}elseif (isset($allocated_item['seasonal_details']['article_include_type']) && $allocated_item['seasonal_details']['article_include_type'] == 'consumer_poll'){
												//				$consumer_poll_details = $allocated_item['seasonal_details']['consumer_poll_details'];						
						
														$consumer_poll_details = $child['consumer_poll_details'];
								

								}elseif (isset($allocated_item['seasonal_details']['article_include_type']) && $allocated_item['seasonal_details']['article_include_type'] == 'competition'){
												//				$competition_details = $allocated_item['seasonal_details']['competition_details'];						
						
								}
						
						
						
						// details would be in $item['seasonal_details'];
						include ($child['override_include_file']);
				
				
					}elseif (isset($allocated_item['article_include_type']) && $allocated_item['article_include_type'] == 'article'){
						// we are a plain simple seasonal article child.
					
						// we cannot make the seasonal_article array as we do with includes as it would overrite the original we are working with.
						// therefore any include files for a seasonal article nested item need to use either the $item array directly or make a different variable accordingly.
							$child = $allocated_item['seasonal_details'];
							
							include ($child['override_include_file']);
						
					
					}elseif (isset($allocated_item['article_include_type']) && $allocated_item['article_include_type'] == 'gallery'){
							$child = $allocated_item['gallery_details'];
								$gallery_details = $allocated_item['gallery_details'];
								include ($child['override_include_file']);
							
								

						// consumer poll
						
					}elseif (isset($allocated_item['article_include_type']) && $allocated_item['article_include_type'] == 'consumer_poll'){
							$child = $allocated_item['consumer_poll_details'];
								$consumer_poll_details = $allocated_item['consumer_poll_details'];
								include ($child['override_include_file']);
							




						// competition
					}elseif (isset($allocated_item['article_include_type']) && $allocated_item['article_include_type'] == 'competition'){
							$child = $allocated_item['competition_details'];
								$competition_details = $allocated_item['competition_details'];
								include ($child['override_include_file']);
							

					} // end what type of article.
					
					
					
		//				echo dsf_print_array($child);

			
			
			} // end foreach
			
			// unset the temp child variable we created
			unset($child);
			unset($allocated_item);
		
		
		} // end of children.
	}
	
// ###### END HUB TYPE



// ##### NESTED TYPE

	if ($seasonal_details['article_level'] == 'nested'){

		?>
    
    <div class="header__breakfast">
	<div class="col-sm-5 headerleft_red">
		<h1 class="headertitle"><?php echo sr_heart_replace($seasonal_details['text_one']);?></h1>
		<p class="introtext"><?php echo sr_heart_replace($seasonal_details['text_two']);?></p>
		<?php echo sr_heart_replace($seasonal_details['text_block_one']);?>
	</div>
	<div class="col-sm-7 nopaddingoutter overflowhidden">
    	<?php echo dsf_image($seasonal_details['article_image_one'], $seasonal_details['name'],'','', '');?>
	</div>
</div>

<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>

<?php
	
		if (isset($seasonal_details['children']) && sizeof($seasonal_details['children']) > 0){
			
			foreach($seasonal_details['children'] as $child){
				
				
				// we want the level.  - so we can set the required aray.
				// we also want to see if there is an override_include_file value being set.
				
				if(isset($child['override_include_file']) && strlen($child['override_include_file']) > 0){
					
					
					// we have a file to load up.   Thats the first stage as we are using includes in this page so we must have a file to include.
					
					if ($child['article_level'] == 'article'){
						// we are a plain simple seasonal article child.
					
						// we cannot make the seasonal_article array as we do with includes as it would overrite the original we are working with.
						// therefore any include files for a seasonal article nested item need to use either the $item array directly or make a different variable accordingly.

							include ($child['override_include_file']);
						
					
					}elseif ($child['article_level'] == 'include'){
						// we are an include item therefore we need to find out what type of include and set accordingly.
						// gallery
						
							if (isset($child['article_include_type']) && $child['article_include_type'] == 'gallery'){
								$gallery_details = $child['gallery_details'];
								include ($child['override_include_file']);
							}
								

						// consumer poll
						
							if (isset($child['article_include_type']) && $child['article_include_type'] == 'consumer_poll'){
								$consumer_poll_details = $child['consumer_poll_details'];
								include ($child['override_include_file']);
							}




						// competition
							if (isset($child['article_include_type']) && $child['article_include_type'] == 'competition'){
								$competition_details = $child['competition_details'];
								include ($child['override_include_file']);
							}

					   // seasonal article as an include
					   // as with an article type - we cannot set the array to $seasonal_details as it would overwrite the parent.  all include files therefore need to take this into consideration
					   // and work either directly with the item contents or make a different variable.
							if (isset($child['article_include_type']) && $child['article_include_type'] == 'seasonal_article'){
								
								// details would be in $item['seasonal_details'];
								include ($child['override_include_file']);
							}
							
					} // end what type of article.
					
				}
			
			
			} // end foreach
			
			// unset the temp child variable we created
			unset($child);
		
		
		} // end of children.
	}

// ###### END NESTED TYPE




// ##### ARTICLE TYPE

	if ($seasonal_details['article_level'] == 'article'){
		
		// a standalone article.

		echo '<div><br /><br /><br /><br /><br /><br /><br />LEVEL = ARTICLE</div>';
		echo '<div>DIRECT LINK TO A URL INCLUDING A SEASONAL ARTICLE.</div>';

	}

// ###### END ARTICLE TYPE


// ######  INCLUDE TYPE


	if ($seasonal_details['article_level'] == 'include'){
		
		// check to see what type of include it is.
		// set the necessary top level array
		// include the file.
	
		if ($seasonal_details['article_include_type'] == 'gallery'){
			
			$gallery_details = $seasonal_details['gallery_details'];
			
			// include the file
			
				include($seasonal_details['article_include_path'] . $seasonal_details['article_include_file']);
			
	
		}elseif ($seasonal_details['article_include_type'] == 'competition'){
			
			$competition_details = $seasonal_details['competition_details'];
			
			// include the file
			
				include($seasonal_details['article_include_path'] . $seasonal_details['article_include_file']);
	

		}elseif ($seasonal_details['article_include_type'] == 'consumer_poll'){
			
			$consumer_poll_details = $seasonal_details['consumer_poll_details'];
			
			// include the file
			
				include($seasonal_details['article_include_path'] . $seasonal_details['article_include_file']);


	
		}elseif ($seasonal_details['article_include_type'] == 'seasonal_article'){ // only ever used if pulling in a file from an asset folder which should not be necessary at this level.
			
			// overwrite seasonal details array with details from inside the variable.  it is better to create a new array first to store the value
			// rather than attempting to write parts of the same array over itself.
				$temp_details = $seasonal_details['seasonal_details'];
				$temp_file_to_include = $seasonal_details['article_include_path'] . $seasonal_details['article_include_file'];
				$seasonal_details = $temp_details;
			
			// include the file
			
				include($temp_file_to_include);
	
		}
		
		// if we are here and have not already included a file there is a problem with the value of $seasonal_details['article_include_type']
	
	
	
	}

// END INCLUDE TYPE



// LEVEL TYPE NONE (ERROR) may be beneficial here



}else{
	// no level is found therefore an error message should be shown.
}



// TEMP SHOW SEASONAL ARRAY
// echo 'ARRAY DETAILS ###########<br />';
//echo dsf_print_array($seasonal_details_menu);
//echo dsf_print_array($seasonal_details);
?>