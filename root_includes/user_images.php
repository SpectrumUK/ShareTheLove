<?php 
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.


// this is a root include file as it can be loaded in from different areas.


$dsv_page_name = 'user_images';


if (isset($_GET['itemID'])){
	$itemID = (int)$_GET['itemID'];
}else{
	$itemID = 0;
}


if (isset($_GET['filterID'])){
	$filterID = (int)$_GET['filterID'];
}


if (isset($_GET['mechanicID'])){
	$mechanicID = (int)$_GET['mechanicID'];
}




// determine if we are getting the data from ajax query.

if (isset($_GET['ajax_page'])){
	$dsv_image_page_type = 'ajax_';
	$dsv_image_call = 'ajax';
	
	$dsv_ajax_page = 'true';
	header("Cache-Control: no-cache");
	header('Content-Type: text/html; charset=' . $dsv_html_charset);
	 	
	$dsv_image_page = (int)$_GET['ajax_page'];
	$_GET['page'] = (int)$_GET['ajax_page'];
}else{
	$dsv_image_page_type = '';
	$dsv_image_call ='';
}

	
if (isset($_GET['page'])){
	$dsv_image_page = (int)$_GET['page'];
}else{
	$dsv_image_page = 1;
}


	


// determine level

if ($itemID > 0){
	$dsv_image_level = 'image';
}else{
	
	// if we have a filterID then we must have a mechanicID and if we don't it is easy enough to find it as its connected to the filter table.
	if (isset($filterID) && $filterID > 0){
			$dsv_image_level = $dsv_image_page_type . 'filtered_listing';
	}else{
		$dsv_image_level = $dsv_image_page_type . 'listing';
	}
	
}





// do image by itself first.

if ($dsv_image_level == 'image'){
	
	$user_image_details = dsf_get_user_image_details($itemID);
	
// check for layout and content overrides

		if(isset($user_image_details['override_required']) && (int)$user_image_details['override_required'] == 1){
		
			// override is set to true.
			$dsv_page_overrides_required = 'true';
			
			
			if (isset($user_image_details['override_layout_folder']) && strlen($user_image_details['override_layout_folder']) > 1){
		
				$dsv_page_overrides_layout_folder = $user_image_details['override_layout_folder'];
			}
			
			if (isset($user_image_details['override_layout_file']) && strlen($user_image_details['override_layout_file']) > 1){
		
				$dsv_page_overrides_layout_file = $user_image_details['override_layout_file'];
			}
			
			
			if (isset($user_image_details['override_content_folder']) && strlen($user_image_details['override_content_folder']) > 1){
		
				$dsv_page_overrides_content_folder = $user_image_details['override_content_folder'];
			}
			
			
			if (isset($user_image_details['override_content_file']) && strlen($user_image_details['override_content_file']) > 1){
		
				$dsv_page_overrides_content_file = $user_image_details['override_content_file'];
			}
			
			
		} // end overrides
		
		$mechanicID = $user_image_details['mechanic_id'];
		$filterID = $user_image_details['filter_id'];
		
	
	
		$user_images = dsf_get_user_image_items($mechanicID, 0, $dsv_image_page,  0 , $itemID);


		$user_image_details['user_images'] = $user_images;

		unset($user_images);
		

	
	
	
	
	
	
}


if ($dsv_image_level == 'filtered_listing' || $dsv_image_level == 'ajax_filtered_listing' ){
	// the data comes from the same place,  the level is only for content
	
	
	// get details of the filter firstly.
	
	 $user_image_details = dsf_get_image_filter_information($filterID);

  	$mechanicID = $user_image_details['mechanic_id'];

	// find all images associated with this filter.
	


			$user_images = dsf_get_user_image_items(0, $filterID, $dsv_image_page);


		$user_image_details['user_images'] = $user_images;

		unset($user_images);


// check for layout and content overrides

		if(isset($user_image_details['override_required']) && (int)$user_image_details['override_required'] == 1){
		
			// override is set to true.
			$dsv_page_overrides_required = 'true';
			
			
			if (isset($user_image_details['override_layout_folder']) && strlen($user_image_details['override_layout_folder']) > 1){
		
				$dsv_page_overrides_layout_folder = $user_image_details['override_layout_folder'];
			}
			
			if (isset($user_image_details['override_layout_file']) && strlen($user_image_details['override_layout_file']) > 1){
		
				$dsv_page_overrides_layout_file = $user_image_details['override_layout_file'];
			}
			
			
			if (isset($user_image_details['override_content_folder']) && strlen($user_image_details['override_content_folder']) > 1){
		
				$dsv_page_overrides_content_folder = $user_image_details['override_content_folder'];
			}
			
			
			if (isset($user_image_details['override_content_file']) && strlen($user_image_details['override_content_file']) > 1){
		
				$dsv_page_overrides_content_file = $user_image_details['override_content_file'];
			}
			
			
		} // end overrides
	
	
}




if ($dsv_image_level == 'listing' || $dsv_image_level == 'ajax_listing' ){
	// the data comes from the same place,  the level is only for content
	
	// get details of the filter firstly.
	
	 $user_image_details = dsf_get_image_mechanic_listing($mechanicID);



			$user_images = dsf_get_user_image_items($mechanicID, 0, $dsv_image_page);


		$user_image_details['user_images'] = $user_images;

		unset($user_images);


// check for layout and content overrides

		if(isset($user_image_details['override_required']) && (int)$user_image_details['override_required'] == 1){
		
			// override is set to true.
			$dsv_page_overrides_required = 'true';
			
			
			if (isset($user_image_details['override_layout_folder']) && strlen($user_image_details['override_layout_folder']) > 1){
		
				$dsv_page_overrides_layout_folder = $user_image_details['override_layout_folder'];
			}
			
			if (isset($user_image_details['override_layout_file']) && strlen($user_image_details['override_layout_file']) > 1){
		
				$dsv_page_overrides_layout_file = $user_image_details['override_layout_file'];
			}
			
			
			if (isset($user_image_details['override_content_folder']) && strlen($user_image_details['override_content_folder']) > 1){
		
				$dsv_page_overrides_content_folder = $user_image_details['override_content_folder'];
			}
			
			
			if (isset($user_image_details['override_content_file']) && strlen($user_image_details['override_content_file']) > 1){
		
				$dsv_page_overrides_content_file = $user_image_details['override_content_file'];
			}
			
			
		} // end overrides
	
	
	
}




// get the menu


$user_image_menu = dsf_create_user_image_upper_menu($mechanicID, $filterID);
	
// depending on whether we are being passed a mechanic ID or filter ID depends on the information we supply.



include('program_files/layout_header.php');

// if we are coming from an ajax page then we just load back up the ajax page.

if ($dsv_image_call == 'ajax'){
	
	 include ($content_include);
	
}else{
	
	// do standard procedures

require (DS_LAYOUT . DS_LAYOUT_TEMPLATE_NAME);

}
?>