<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



////
function dsf_image_swap($src){
return DS_IMAGES_FOLDER . $src;
}


// output an image in HTML format unless link_only or relative_only is set.

    function dsf_image($src, $alt = '', $width = '', $height = '', $parameters = '', $link_only='', $relative_only='') {
	global $bref;

	if ($relative_only == 'YES'){
		$link_bref = '';
	}else{
		$link_bref = $bref;
	}
	

	// always prefix the src with the images folder.
	$src = DS_IMAGES_FOLDER . $src;
	


    if ((empty($src) || ($src == DS_IMAGES_FOLDER)) && (IMAGE_REQUIRED == 'false')) {
    return false;
    }


    $image_check = substr($src, -3, 3);
	
	if ((strtoupper($image_check) == 'GIF') || (strtoupper($image_check) == 'JPG') || (strtoupper($image_check) == 'PEG') || (strtoupper($image_check) == 'PNG')){
		//fine
	}else{
		return false;
	}



if ($link_only == 'YES'){
	// just return a url to the image, not the actual image.
	$image = $link_bref . dsf_output_string($src);
	return $image;
}else{
	// return the image
	


			// alt is added to the img tag even if it is null to prevent browsers from outputting
			// the image filename as default
			   $image = '<img src="' . $link_bref . dsf_output_string($src) . '" alt="' . dsf_output_string($alt) . '"';
			
			   if (dsf_not_null($alt)) {
			   $image .= ' title=" ' . dsf_output_string($alt) . ' "';
			   }
			
			   if ((CONFIG_CALCULATE_IMAGE_SIZE == 'true') && (empty($width) || empty($height))) {
					
			// if we have not been given sizes, create them.
				 if ($image_size = @getimagesize($src)) {
			
					 if (empty($width) && dsf_not_null($height)) {
				
						$ratio = $height / $image_size[1];
						$width = $image_size[0] * $ratio;
					 } elseif (dsf_not_null($width) && empty($height)) {
				
						$ratio = $width / $image_size[0];
						$height = $image_size[1] * $ratio;
					 } elseif (empty($width) && empty($height)) {
				
					   $width = $image_size[0];
					   $height = $image_size[1];
					  }
				  } elseif (IMAGE_REQUIRED == 'false') {
					return false;
				  }
			
			 }
			
				if (dsf_not_null($width) && dsf_not_null($height)) {
				  $image .= ' width="' . dsf_output_string($width) . '" height="' . dsf_output_string($height) . '"';
				}
			
				if (dsf_not_null($parameters)) $image .= ' ' . $parameters;
			
				$image .= ' />';
			
				return $image;

 } // end image or link
} // end function



function dsf_submit_image($image, $alt='', $paramters = '', $relative_only=''){
	// alias of dsf_image_submit as different function names used before on content files.
	return dsf_image_submit($image, $alt, $paramters, $relative_only);
}


// Output a separator either through whitespace, or with an image
  function dsf_blank_submit($alt='', $parameters='') {
  global $bref ;
  
    $image_submit = '<input type="image" src="' . $bref . DS_IMAGES_FOLDER . 'trans.gif' . '" alt="' . dsf_output_string($alt) . '"';

    if (dsf_not_null($alt)) $image_submit .= ' title=" ' . dsf_output_string($alt) . ' "';

    if (dsf_not_null($parameters)) $image_submit .= ' ' . $parameters;

    $image_submit .= ' />';

    return $image_submit;
  }




  function dsf_image_submit($image, $alt = '', $parameters = '', $relative_only='') {
    global $language, $bref;


	if ($relative_only == 'YES'){
		$link_bref = '';
	}else{
		$link_bref = $bref;
	}


    $image_submit = '<input type="image" src="' . $link_bref . dsf_output_string(DS_IMAGES_FOLDER . 'page/buttons/' . LANGUAGE_URL_SUFFIX . '/' . $image) . '" alt="' . dsf_output_string($alt) . '"';

    if (dsf_not_null($alt)) $image_submit .= ' title=" ' . dsf_output_string($alt) . ' "';

    if (dsf_not_null($parameters)) $image_submit .= ' ' . $parameters;

    $image_submit .= ' />';

    return $image_submit;
  }

////
function dsf_button_image($image, $alt = '', $parameters = '', $relative_only=''){
// alias of dsf_image_button as different function names used before on content files.
    return dsf_image('page/buttons/' . LANGUAGE_URL_SUFFIX . '/' . $image, $alt, '', '', $parameters, '', $relative_only);
}


// Output a function button in the selected language
  function dsf_image_button($image, $alt = '', $parameters = '') {

    return dsf_image('page/buttons/' . LANGUAGE_URL_SUFFIX . '/' . $image, $alt, '', '', $parameters,'', '');
  }

////
// Output a separator either through whitespace, or with an image
  function dsf_draw_separator($image = 'pixel_black.gif', $width = '100%', $height = '1') {
    return dsf_image($image, '', $width, $height);
  }

// Output a separator either through whitespace, or with an image
  function dsf_blank_image($width = '1', $height = '1', $alt='') {
    return dsf_image('trans.gif', $alt , $width, $height);
  }



function dsf_flash_file($mwidth, $mheight, $msource, $mname, $mtitle, $parameters=false, $mmode='opaque') {
	 global $bref;
	 
	 echo '<script language="JavaScript1.1" type="text/javascript">';
	 echo "\n<!--\n";
	 echo "writeflash ('" . $mwidth ."','" . $mheight ."','" . $bref . DS_IMAGES_FOLDER . $msource ."','" .$mname ."','" . dsf_parse_input_field_data($mtitle, array("'" => '&quot;')) ."','" .$mmode ."');\n";
	 echo"   //-->\n";
	echo"</script>\n";

	if ($parameters){
		echo '<noscript>' . $parameters .'</noscript>';
	}else{
		echo'<noscript><span class="missingjavaerror">Javascript is Required on all of our web pages with flash designs on them. It appears that javascript is disabled on your browser.</span></noscript>' . "\n";
	}
}


// show an image if it exists otherwise show a not found text.

  function dsf_info_image($image, $alt, $width = '', $height = '') {
	  
    if (dsf_not_null($image) && strpos($image , '.') > 1){
			 if (file_exists(DS_IMAGES_FOLDER . $image)) {
		  
					if (substr(strtolower($image), -3 ,3) == 'swf' ){
							$image = dsf_raw_flash_file($width, $height, DS_IMAGES_FOLDER . $image, $image, $alt,'<strong>' . $alt . '</strong>');
					}else{
						  $image = dsf_thumb_image(DS_IMAGES_FOLDER . $image, $alt, $width, $height);
					}
			 }else{
     			 $image = 'Image Not Found';
			 }
	
	} else {
      $image = 'No Image Uploaded';
    }

    return $image;
  }




// create a new thumb image from given image
function dsf_thumb_image($src, $alt = '', $width = '', $height = '', $params = '', $linkonly = '', $nowatermark = '') { 
	 global $bref;

	$required_width = $width;
	$required_height = $height;
	
   $image = '<img src="' . dsf_output_string($src) . '"';

    if ((empty($src) || ($src == DS_IMAGES_FOLDER)) && (IMAGE_REQUIRED == 'false')) {
    return false;
    }


    // Don't calculate if the image is set to a "%" width
    if (strstr($width,'%') == false || strstr($height,'%') == false) { 
     $dont_calculate = 0; 
     } else {
       $dont_calculate = 1; 		
     }	


    // Do we calculate the image size?
     if ((CONFIG_CALCULATE_IMAGE_SIZE && !$dont_calculate)) { 

		
        // Get the image's information
           if ($image_size = @getimagesize($src)) { 
				
				if ($image_size[2]==6){ // bmp
					return dsf_image($src,$alt, $width, $height, $params);
				}
				
				
				    // Set the width and height to the proper ratio
                    if ($image_size = @getimagesize($src)) {

                         if (empty($width) && dsf_not_null($height)) { // scale on height value

                            $ratio = $height / $image_size[1];
                            $width = $image_size[0] * $ratio;
							$required_width = $width;
                         
						 } elseif (dsf_not_null($width) && empty($height)) { // scale on width value

                           $ratio = $width / $image_size[0];
                           $height = $image_size[1] * $ratio;
						   $required_height = $height;
						   
						 }  elseif (empty($width) && empty($height)) { // no values input so no scale

                           $width = $image_size[0];
                           $height = $image_size[1];
                           $required_width = $image_size[0];
                           $required_height = $image_size[1];
                      
					     } elseif (dsf_not_null($width) && dsf_not_null($height)) { // calculate best fit.
								
							   if ($width < $image_size[0]){
									$ratio = $width / $image_size[0];
									$height = $image_size[1] * $ratio;
							 	
									if ($required_height < $height){ // resized width but still too high.
	                            		$ratio = $required_height / $image_size[1];
                            			$width = $image_size[0] * $ratio;
										$height = $required_height;

									}
								
								}else if ($height < $image_size[1]){
                            		$ratio = $height / $image_size[1];
                            		$width = $image_size[0] * $ratio;
							 	
									if ($required_width < $width){ // resized height but still too wide.
	                            		$ratio = $required_width / $image_size[0];
                            			$height = $image_size[1] * $ratio;
										$width = $required_width;
									}
						 		}else{
								 // no resize required.
								       $width = $image_size[0];
                           				$height = $image_size[1];
								}


						 }
						 
						 
                   } elseif (IMAGE_REQUIRED == 'false') {
                      return false;
                   }

         } elseif (IMAGE_REQUIRED == 'false') { 
            return ''; 
         } 

    } 

            // Scale the image if larger than the set width or height
 
	 if ($linkonly == 'true'){
	 		$image = $bref . 'image_output.php?img='.$src.'&amp;w='.round(dsf_output_string($width)).'&amp;h='.round(dsf_output_string($height)).'&amp;rw='.round(dsf_output_string($required_width)).'&amp;rh='.round(dsf_output_string($required_height));

				if ($nowatermark == 'hide'){
					$image.='&nwm=true';
				}	
	 }else{
	 
				if (dsf_not_null($width) && dsf_not_null($height)) {
							 $image = '<img src="' . $bref . 'image_output.php?img='.$src.'&amp;w='.round(dsf_output_string($width)).'&amp;h='.round(dsf_output_string($height)).'&amp;rw='.round(dsf_output_string($required_width)).'&amp;rh='.round(dsf_output_string($required_height));
							}
				if ($nowatermark == 'hide'){
					$image.='&amp;nwm=true';
				}	
									
				$image.= '"';
									
									
				if (dsf_not_null($params)) $image .= ' ' . $params;
				$image .= ' border="0" alt="' . dsf_output_string($alt) . '"';
					if ($alt) $image .= ' title="' . dsf_output_string($alt) . '"'; 
					
					
				$image .= ' />';
	}	
	
     return $image; 
}




function dsf_notavailable_image($width=0, $height=0, $params=''){
	if ($width > 0 && $height > 0){
		
		if (file_exists(DS_IMAGES_FOLDER . LANGUAGE_URL_SUFFIX . '_error_noimageavailable.png')){
			return dsf_thumb_image(DS_IMAGES_FOLDER . LANGUAGE_URL_SUFFIX . '_error_noimageavailable.png', '', $width, $height, $params);
		}else{
			return dsf_thumb_image(DS_IMAGES_FOLDER . LANGUAGE_URL_SUFFIX . '_error_noimageavailable.gif', '', $width, $height, $params);
		}
		
	}else{
		return false;
	}
}




// resizing images


function dsf_save_resize_image($ipath='', $iprefix='', $img, $iwidth=0, $iheight=0, $rwidth=0, $rheight=0, $watermark='',$exact_size=''){

$hex = 'ffffff';
		$r = (int)hexdec(substr($hex, 0, 2));
		$g = (int)hexdec(substr($hex, 2, 2));
		$b = (int)hexdec(substr($hex, 4, 2));

$use_resampling = true;
$use_truecolor = true;
$gif_as_jpeg = false;

$new_image = DS_IMAGES_FOLDER . 'sized/' . $ipath . $iprefix . $img;
$img = DS_IMAGES_FOLDER . $ipath .  $img;


if ($exact_size == 'nosize'){
		 copy($img, $new_image);
		
}else{
				$image = @getimagesize($img);
				
				
				$new_width = $iwidth;
				$new_height = $iheight;
				$required_width = $rwidth;
				$required_height = $rheight;
				
				if($watermark){
					$watermark = DS_IMAGES_FOLDER . $watermark;
				}
				
				$dest_x = round(($required_width - $new_width)/2); // center align
				$dest_y = round(($required_height - $new_height)/2); // bottom align
				
				 // Do not resize if get values are larger than orig image and stretch is off.
				if ($iwidth > $image[0] || $iheight > $image[1]){
							$new_width = $image[0]; // set back to smaller image
							$new_height = $image[1]; // set back to smaller image
				}
				
				
				// Create a new, empty image based on settings
				if (function_exists('imagecreatetruecolor') && $use_truecolor){
					$tmp_img = imagecreatetruecolor($required_width,$required_height);
				}else{
					$tmp_img = imagecreate($required_width,$required_height); 
				}
				
				
				$th_bg_color = imagecolorallocatealpha($tmp_img, $r, $g, $b, 127);
				imagefill($tmp_img, 0, 0, $th_bg_color);

				
				// Create the image to be scaled
				if ($image[2] == 2 && function_exists('imagecreatefromjpeg')) {
				
				
					$src = imagecreatefromjpeg($img);
				} elseif ($image[2] == 1 && function_exists('imagecreatefromgif')) {
					$src = imagecreatefromgif($img);
				} elseif (($image[2] == 3 || $image[2] == 1) && function_exists('imagecreatefrompng')) {
						imagecolortransparent($tmp_img, $th_bg_color);
						imagealphablending($tmp_img, false);
						imagesavealpha($tmp_img, true);
						$src = imagecreatefrompng($img);
				} 
				
				
				
				// Scale the image based on settings
				if (function_exists('imagecopyresampled') && $use_resampling){
					@imagecopyresampled($tmp_img, $src, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $image[0], $image[1]);
				}else{
					@imagecopyresized($tmp_img, $src, $dest_x, $dest_y, 0, 0, $new_width, $new_height, $image[0], $image[1]);
				}
						

				// Output the image
				
				if (($image[2] == 2) || ($image[2] == 1 && $gif_as_jpeg)) {
				 
				 // this is a jpeg. therefore look to see if watermark is required.
				   if ($watermark){
				   
								//Loading
								$watermark_img = imagecreatefromgif($watermark);
								
								$wmrk_size = getimagesize($watermark);
				
								$posy = ($required_height - ImageSY($watermark_img))/2;
									$posx = ($required_width - ImageSX($watermark_img))/2;
									//$posy = ($_GET['h'] - ImageSY($watermark_img))/2;
								imagecopymerge($tmp_img, $watermark_img, $posx, $posy, 0, 0, $wmrk_size[0], $wmrk_size[1],100);
				
				
						imagedestroy($watermark_img);
								
				   }
				   
				 // show the image
				  imagejpeg($tmp_img,$new_image,85);
					
					
				} elseif ($image[2] == 1 && function_exists('imagegif')) {
					imagegif($tmp_img,$new_image);
				} elseif ($image[2] == 3 || $image[2] == 1) {
					imagepng($tmp_img,$new_image);
				}
				
				// Clear the image from memory
				@imagedestroy($src);
				@imagedestroy($tmp_img);

} // end of exact size
}



function dsf_image_resize($ipath='', $iprefix='', $img, $width=0, $height=0, $wmark=''){
	$required_width = $width;
	$required_height = $height;

				$src = DS_IMAGES_FOLDER . $ipath . $img;

                    if ($image_size = @getimagesize($src)) {


						// check for exact sizes
						if ((int)$width == (int)$image_size[0] && (int)$height == (int)$image_size[1] && strlen($wmark) == 0){
							// exact width and height already, do not need to resize as no watermark enabled.
							$exact_size='nosize';
						}else{
							$exact_size ='';
							
								 if ($width == 0 && $height >0) { // scale on height value
									$ratio = $height / $image_size[1];
									$width = $image_size[0] * $ratio;
									$required_width = $width;
								    if ($image_size[1] < $height){ // new statement
										$height=$image_size[1]; 
									}
									
									
								 } elseif ($width >0 && $height ==0) { // scale on width value
								   $ratio = $width / $image_size[0];
								   $height = $image_size[1] * $ratio;
								   $required_height = $height;
								   
								   if ($image_size[0] < $width){ // new statement
								      $width = $image_size[0]; 
								   }
								   
								   
								   
								 }  elseif ($width==0 && $height=0) { // no values input so no scale
								   $width = $image_size[0];
								   $height = $image_size[1];
								   $required_width = $image_size[0];
								   $required_height = $image_size[1];
							  
								 } elseif ($width>0 && $height>0) { // calculate best fit.
										
									   if ($width < $image_size[0]){
											$ratio = $width / $image_size[0];
											$height = $image_size[1] * $ratio;
										
											if ($required_height < $height){ // resized width but still too high.
												$ratio = $required_height / $image_size[1];
												$width = $image_size[0] * $ratio;
												$height = $required_height;
		
											}
										
										}else if ($height < $image_size[1]){
											$ratio = $height / $image_size[1];
											$width = $image_size[0] * $ratio;
										
											if ($required_width < $width){ // resized height but still too wide.
												$ratio = $required_width / $image_size[0];
												$height = $image_size[1] * $ratio;
												$width = $required_width;
											}
										}else{
										 // no resize required.
											   $width = $image_size[0];
												$height = $image_size[1];
										}
		
		
								 }
						} // end of exact size no template
					} // end of if getimagesize
				$mail_message = 'Details' . "\n";
				$mail_message .= $ipath . "\n";
				$mail_message .= $iprefix . "\n";
				$mail_message .= $img . "\n";
				$mail_message .= $width . "\n";
				$mail_message .= $height . "\n";
				$mail_message .= $required_width . "\n";
				$mail_message .= $required_height . "\n";
				$mail_message .= $wmark . "\n";
				$mail_message .= $exact_size . "\n";
				
				$width = number_format($width,0);
				$height = number_format($height,0);
				
					
dsf_save_resize_image($ipath, $iprefix, $img, $width, $height, $required_width, $required_height, $wmark, $exact_size);
}



function dsf_image_rotate($path='', $img, $rotation){
$new_image = DS_IMAGES_FOLDER . $path . '/' . $img;
$img = DS_IMAGES_FOLDER . $path . '/' . $img;

									$source = imagecreatefromjpeg($img);
									// Rotate
									$rotate = imagerotate($source, $rotation, 0);
									// Output
									// imagejpeg($rotate); 	
  									imagejpeg($rotate,$new_image,100);
					$dojob = @imagedestroy($source);
					$dojob = @imagedestroy($rotate);

}



?>