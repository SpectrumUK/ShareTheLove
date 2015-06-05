<?php 
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.


//require ('program_files/system/general_functions.php');

function dsf_user_imaage_upload($item_array, $mechanicID=0){
	global $dsv_image_item_id;
	
	// This is a temporary function to save the image inforamtion.   Unfortunately the data has only been released to Designshops Today and needs to be completed by end of play.
	// all error checking is therefore non operational for the time being we save what is possible and error the rest.
	
	// to map data to other fields for the time being so we don't loose anything.
	
	
	// update - simon is using a form to generate custom fields for the content page,  however, he is not passing back the forms fields but instead the fields as
	// created by bray in their code therefore, we continue to map data until he can make amendments.
	
	// getting this data out the longer it goes on will be very difficult.
	
	
	
$return_value = 'true';	
	
	if (isset($item_array['FirstName']) && isset($item_array['LastName'])){
		
		// we have information therefore we can proceed if we have an image.
		
		if (isset($item_array['jpgData']) && strlen($item_array['jpgData']) > 50){
			// we have image data
			
			
				$master_insert_data = array('created_from' => $dsv_master_select_language,
										   'image_name' => dsf_db_prepare_input($item_array['FirstName']) . ' ' . dsf_db_prepare_input($item_array['LastName']) );
										   
				// save the item and get an ID for it.
				
				
								$upd = dsf_db_perform(DS_DB_MASTER . ".image_upload_items", $master_insert_data);
								$itemID = dsf_db_insert_id();				
			
			
							// now create the item
			
								$dsv_firstname = (isset($item_array['FirstName']) ?  $item_array['FirstName']: '');
								$dsv_lastname = (isset($item_array['LastName']) ?  $item_array['LastName']: '');
								$dsv_email_address = (isset($item_array['Email']) ?  $item_array['Email']: '');
								$dsv_futureoffers = (isset($item_array['FutureOffers']) ?  $item_array['FutureOffers']: '');
								$dsv_filter_id = (isset($item_array['imageCategory']) && (int)$item_array['imageCategory'] > 0 ?  (int)$item_array['imageCategory']: '0');
								$dsv_item_image_one = $itemID . '_1.jpg';
								$dsv_text_one = (isset($item_array['TextHeart']) ?  $item_array['TextHeart']: '');
								$dsv_text_two = (isset($item_array['Whatyoulove']) ?  $item_array['Whatyoulove']: '');
								$dsv_text_three = '';
								$dsv_text_four = '';
								$dsv_block_text_one = '';
								$dsv_block_text_two = '';
								$dsv_block_text_three = '';
								$dsv_block_text_four = '';
								$dsv_item_image_one_text = (isset($item_array['DOB']) ?  $item_array['DOB']: '');
								$dsv_item_image_two_text = (isset($item_array['Terms']) ?  $item_array['Terms']: '');;
								$dsv_item_image_three_text = (isset($item_array['PhotoRights']) ?  $item_array['PhotoRights']: '');;
								$dsv_item_image_four_text = (isset($item_array['Country']) ?  $item_array['Country']: '');;

								$dsv_item_audit = 'Image uploaded by IP ' . dsf_get_ip_address();
								


				
								$sql_data_array = array('item_id' => (int)$itemID,
														'mechanic_id' => (int)$mechanicID,
														'filter_id' => $dsv_filter_id,
														'image_name' => dsf_db_prepare_input($dsv_firstname . ' ' . $dsv_lastname),
														'item_image_one' => dsf_db_prepare_input($dsv_item_image_one),
														'item_image_one_text' => dsf_db_prepare_input($dsv_item_image_one_text),
														'item_image_two_text' => dsf_db_prepare_input($dsv_item_image_two_text),
														'item_image_three_text' => dsf_db_prepare_input($dsv_item_image_three_text),
														'item_image_four_text' => dsf_db_prepare_input($dsv_item_image_four_text),
														'email_address' => dsf_db_prepare_input($dsv_email_address),
														'firstname' => dsf_db_prepare_input($dsv_firstname),
														'lastname' => dsf_db_prepare_input($dsv_lastname),
														'filter_id' => (int)$dsv_filter_id,
														'image_upload_date' => 'now()',
														'image_audit_trail' => dsf_db_prepare_input($dsv_item_audit),
														'text_one' => dsf_db_prepare_input($dsv_text_one),
														'text_two' => dsf_db_prepare_input($dsv_text_two),
														'text_three' => dsf_db_prepare_input($dsv_text_three),
														'text_four' => dsf_db_prepare_input($dsv_text_four)
														
								);
			


								// save the item
								
								$upd = dsf_db_perform(DS_DB_SHOP . ".image_upload_items", $sql_data_array);
								
								
								// save the image
								$upd_img = dsf_save_base64_image($item_array['jpgData'] , $dsv_item_image_one);
								
								// lastly.  resize any images.
								
								
									dsf_image_resize('user/' , '', $dsv_item_image_one, LARGE_USER_IMAGE_WIDTH, LARGE_USER_IMAGE_HEIGHT);
									dsf_image_resize('user/' , 'small_', $dsv_item_image_one, SMALL_USER_IMAGE_WIDTH, SMALL_USER_IMAGE_HEIGHT);
								


								// save the itemID into a session variable because the success page needs to know what the id is to get the image details but
								// the mechanic is expecting only a single variable return in JSON format.
								
								$dsv_image_item_id = $itemID;
								
								dsf_resave_session('dsv_image_item_id');
								
								
								


							    // future offers part here
								


		}else{
			
			$return_value = 'false';	
		}
		
		
	}else{
		
		$return_value = 'false';	
		
	}
		



return $return_value;

	
	
} // end function



function dsf_save_base64_image($base_code='' , $filename=''){
	
$return_value = 'true';

if (strlen($base_code) > 0 && strlen($filename) > 3){
	

$data = str_replace("data:image/jpeg;base64,","", $base_code);

	// ok to proceed.
	$write_image = file_put_contents('images/user/' . $filename, base64_decode($data));
	
	
}else{
	
	$return_value = 'false';
	
}


return $return_value;

}


// ######### END FUNCTIONS






// this is a root include file as it can be loaded in from different areas.


$dsv_page_name = 'image_upload';


if (isset($_GET['mechanicID'])){
	
	$mechanicID = (int)$_GET['mechanicID'];
}else{
	
	$mechanicID = 0;
}




if (isset($_GET['action'])){
	$action = $_GET['action'];
}else{
	$action = '';
}


// image upload Master details
if ($mechanicID > 0){
	// valid id supplied.
	$image_upload_details = dsf_get_user_image_upload_array($mechanicID);

// check for layout and content overrides

		if(isset($image_upload_details['override_required']) && (int)$image_upload_details['override_required'] == 1){
		
			// override is set to true.
			$dsv_page_overrides_required = 'true';
			
			
			if (isset($image_upload_details['override_layout_folder']) && strlen($image_upload_details['override_layout_folder']) > 1){
		
				$dsv_page_overrides_layout_folder = $image_upload_details['override_layout_folder'];
			}
			
			if (isset($image_upload_details['override_layout_file']) && strlen($image_upload_details['override_layout_file']) > 1){
		
				$dsv_page_overrides_layout_file = $image_upload_details['override_layout_file'];
			}
			
			
			if (isset($image_upload_details['override_content_folder']) && strlen($image_upload_details['override_content_folder']) > 1){
		
				$dsv_page_overrides_content_folder = $image_upload_details['override_content_folder'];
			}
			
			
			if (isset($image_upload_details['override_content_file']) && strlen($image_upload_details['override_content_file']) > 1){
		
				$dsv_page_overrides_content_file = $image_upload_details['override_content_file'];
			}
			
			
		} // end overrides

// set page variables

    $dsv_firstname = '';
    $dsv_lastname = '';
    $dsv_email_address = '';
    $dsv_futureoffers = '';
    $dsv_text_one = '';
    $dsv_text_two = '';
    $dsv_text_three = '';
    $dsv_text_four = '';
    $dsv_block_text_one = '';
    $dsv_block_text_two = '';
    $dsv_block_text_three = '';
    $dsv_block_text_four = '';
	$dsv_item_image_one = '';
	$dsv_item_image_two = '';
	$dsv_item_image_three = '';
	$dsv_item_image_four = '';
	



if ($action == 'ajax_submit'  || $action == 'submit'){
	
	// page is in submit mode.
	
	// all posting checks here.
	$dsv_posting_errors = array();
	$error = false;
	


	$email_message = 'image upload is having data posted to it.' . "<br />";
	
	$data = file_get_contents("php://input");


	$email_message .= 'CONTENT = ' . $data . '<br />';
	
	$email_message .= 'IP Address = ' . dsf_get_ip_address() . '<br />';
	
	$email_message .= 'Domain ' . HTTP_DOMAIN . '<br />';
	



	if (strlen($data) > 2){
		
		// we have data therefore we can progress
		
		$json_one = json_decode($data, true);
		
		


	}else{
		
		$error = true;
		
		
	}
	
	
	// DEBUG - send all image upload variables to Simon for testing.
	// dsf_send_email('IMAGE UPLOAD', 'simon.royle@eu.spectrumbrands.com', 'Image upload post.',    $email_message,    STORE_OWNER, EMAIL_FROM);
	

	// SAVE THE DATA INCASE WE ARE NOT SEEING THE WHOLE PICTURE
	
		$upload_image = dsf_user_imaage_upload($json_one, $mechanicID);


	// disabed the error checking for time being as Simon is having issues with external code defining what to do based on this answer.
	// he is working on the fact that all sends are successful.
	

//	if ($error == true){
//		header('Content-Type: application/json; charset=' . $dsv_html_charset); 
//		echo json_encode(array('response' => false));
//	}else{
		header('Content-Type:');
		header('Content-Type: application/json; charset=' . $dsv_html_charset); 
		echo json_encode(array('response' => true));
		
		
		// put all json values into post variables so the form processing can work.
		
		foreach($json_one as $jkey => $jvalue){
			$_POST[$jkey] = $jvalue;
		}
		
		$_GET['action'] = 'send';
		
		
		
		
//	}

  	dsf_session_close();
	die();

// disable all competition code as simon has decided he needs to use a form instead of competition.
	
/*
	  
    $dsv_comp_firstname = dsf_db_prepare_input($_POST['firstname']);
    $dsv_comp_surname = dsf_db_prepare_input($_POST['surname']);
    $dsv_comp_email_address = dsf_db_prepare_input($_POST['email_address']);
    $dsv_comp_address = dsf_db_prepare_input($_POST['address']);
    $dsv_comp_postcode = dsf_db_prepare_input($_POST['postcode']);
	
    $dsv_comp_answer = dsf_db_prepare_input($_POST['answer']);
    $dsv_comp_futureoffers = dsf_db_prepare_input($_POST['furureoffers']);

	
	if ((!$dsv_comp_firstname) || ($dsv_comp_firstname == $dsv_comp_email_address) || (strlen($dsv_comp_firstname) < 2)){
		$error = true;
      $dsv_posting_errors[] = TRANSLATION_ERROR_FIRST_NAME ;
	}

	if ((!$dsv_comp_surname) || ($dsv_comp_surname == $dsv_comp_email_address) || (strlen($dsv_comp_surname) < 2)){
		$error = true;
      	$dsv_posting_errors[] = TRANSLATION_ERROR_LAST_NAME;
	}


	// only check if error not already false
	if ($error == false){
	
		if (dsf_validate_email($dsv_comp_email_address) == false) {
      		$dsv_posting_errors[] = TRANSLATION_ERROR_EMAIL_ADDRESS;
		  $error = true;
		}
	}


// make sure someones not trying to spoof our domain.
		$givenemail = strtolower($dsv_comp_email_address); // checks for our domain name within the email address given.
		$spoofcheck = substr_count($givenemail, SITE_DOMAIN); 
		if ($spoofcheck >0){
		// trying to spoof us.
				$error = true;
      		$dsv_posting_errors[] = TRANSLATION_ERROR_EMAIL_ADDRESS;
		}




// block any HTML Chars.
	if ($error == false){
			// join all fields together to check on.
		
		$big_field = $dsv_comp_firstname  . $dsv_comp_surname  . $dsv_comp_email_address . $dsv_comp_address . $dsv_comp_postcode . $dsv_comp_answer . $dsv_comp_futureoffers;

		$givenenquiry = urldecode(strtolower($big_field)); // checks for our domain name within the email address given.
		$spoofcheck = substr_count($givenenquiry, '<'); 
		if ($spoofcheck >0){
		// trying to spoof us.
				$error = true;
		}
		
		$spoofcheck = substr_count($givenenquiry, '>'); 
		if ($spoofcheck >0){
		// trying to spoof us.
				$error = true;
		}
		
		if ($error == true){
			 $dsv_posting_errors[] = TRANSLATION_HTML_ERROR;
		}


	}

*/

	
	if ($error == false){
		
/*

		// remainder of competition code disabled. 

		// we are fine, the information checked out so we can post the information.


			$sql_data_array = array('firstname' => $dsv_comp_firstname,
									'surname' => $dsv_comp_surname,
									'email_address' => $dsv_comp_email_address,
									'address' => $dsv_comp_address,
									'postcode' => $dsv_comp_postcode,
									'answer' => $dsv_comp_answer,
									'comp_id' => $compID,
									'futureoffers' => $dsv_comp_futureoffers);
		
		
			// insert the item
				$upd = dsf_db_perform(DS_DB_SHOP . ".comp_entries", $sql_data_array);



			if ($dsv_comp_futureoffers == 1){
				// also wants to sign up to future offers.
				
					// customer has subscribed to mailing list.
					  $sql_data_array = array('customer_name' => $dsv_comp_firstname . ' ' . $dsv_comp_surname,
											  'customer_firstname' => $dsv_comp_firstname,
											  'customer_lastname' => $dsv_lastname,
											  'customer_email' => $dsv_comp_email_address);
		
					// do a quick check on the email address
					  $check_email_query = dsf_db_query("select count(*) as total from " . DS_DB_SHOP . ".mailing_lists where customer_email = '" . dsf_db_input($dsv_comp_email_address) . "'");
					  $check_email = dsf_db_fetch_array($check_email_query);
					  if (!$check_email['total']) { // email not already in system so add it.
							dsf_db_perform(DS_DB_SHOP . ".mailing_lists", $sql_data_array);
					  }
				
			}


*/
	
		$image_upload_details['mechanic_form']['status'] = 'success';
		
	}else{
		
		// something went wrong - show a failed message;
		
		$image_upload_details['mechanic_form']['status'] = 'error';
		$image_upload_details['mechanic_form']['errors'] = $dsv_posting_errors;
		
	}
	
	
	
 // end submit = true;
 	
	
	
	
}else{
	
	// we are initially viewing the page.
	
	$image_upload_details['mechanic_form']['status'] = 'display';
}





// check for image that has been saved as a session variable.

if (isset($dsv_image_item_id) && (int)$dsv_image_item_id > 0){
	
	$itemID = $dsv_image_item_id;
	$user_image_details = dsf_get_user_image_details($itemID);

}

// end bringing in image information.






// calculate any form information

if (isset($image_upload_details['form_id']) && (int)$image_upload_details['form_id'] > 0){
	// we have a form ID therefore we check to see if we already have a form on the page (we can't have more than one on the same page - relevant for when used as an include)
	
	if (function_exists('dsf_create_dynamic_form_array')){
		// already exists therefore we cannot bring it in again.
		
	}else{
		// include the form functions
			$dsv_dynamic_form_id = (int)$image_upload_details['form_id'];
			require(DS_FUNCTIONS . 'dynamic_form_functions.php');
			
	}
	
}









} // end if mechanic_id



include('program_files/layout_header.php');

// if we are coming from an ajax page then we just load back up the ajax page.

if ($action == 'ajax_submit'){
	
	 include ($content_include);
	
}else{
	
	// do standard procedures
require (DS_LAYOUT . DS_LAYOUT_TEMPLATE_NAME);
//require ('desktop/contents/default/ilovehome_photomechanic.php');

}
?>