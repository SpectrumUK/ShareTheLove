<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.


define('DS_DB_SERVER', 'localhost');		// in most cases should always be localhost. Change only if localhost does not work.
define('DS_DB_MASTER', 'ds_master');
define('DS_DB_USERNAME', 'ds_master_user'); 	// the username to connect to the database.
define('DS_DB_PASSWORD', 'Pw002f!945');			// the password to connect to the database.
define('DS_DB_COLLATION', 'utf8');	




function dsf_db_connect($server = DS_DB_SERVER, $username = DS_DB_USERNAME, $password = DS_DB_PASSWORD, $database = DS_DB_MASTER, $link = 'db_link') {
  
    global $$link;


    $$link = mysql_connect($server, $username, $password);

   	if ($$link) {
		mysql_select_db($database);
		
		if (defined('DS_DB_COLLATION')){
			if (DS_DB_COLLATION == 'utf8'){
		
					if (function_exists('mysql_set_charset')){
						 mysql_set_charset('utf8',$$link);
					}
			}else{
					if (function_exists('mysql_set_charset')){
						 mysql_set_charset('latin1',$$link);
					}
			}
		}
			
	}

    return $$link;
  }
  
  dsf_db_connect();

//function dsf_db_fetch_array($db_query) {
//    return mysql_fetch_array($db_query, MYSQL_ASSOC);
//  }  
  
function dsf_form_create($name, $action, $method = 'post', $params = '') {
    $form = '<form name="' . dsf_output_string($name) . '" action="' . $action;
	
    $form .= '" method="' . dsf_output_string($method) . '"';
    if (dsf_not_null($params)) {
      $form .= ' ' . $params;
    }
    $form .= '>';

    return $form;
  }

 function dsf_href_link($page = '', $parameters = '', $connection = 'NONSSL') {
    global $dsv_request_type, $session_started, $cpgn, $chosen_menu_type, $dsv_allow_system_cookie, $spider_flag;

    if (!dsf_not_null($page)) {
    	// we will just return the homepage as exact url.
		$nopage = 'true';
		
    }
	
		$connection = strtoupper(trim($connection));
	

	if ($connection <> 'SSL'){
		$connection = 'NONSSL';
	}


	if (defined('NO_SSL_AVAILABLE') && NO_SSL_AVAILABLE == 'true'){
		$connection = 'NONSSL';
	}
	



    if ($connection == 'NONSSL') {
      $link = DS_HTTP_SERVER . DS_WS_SHOP;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL == true) {
        $link = DS_HTTPS_SERVER . DS_WS_SHOP;
      } else {
        $link = DS_HTTP_SERVER . DS_WS_SHOP;
      }
    } else {
		if (DS_ERROR_SHOW == 'true'){	
	  		echo('<div><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br></b>Connection = ' . $connection . 'page= ' . $page . ' <br><br>Full Details:<br>Page = ' . $page . '<br>Params = ' . $parameters . '<br>Connetion = ' . $connection . '<br>Add Session = ' . $add_session . '<br>Search Engine Safe = ' . $search_engine_safe . '<br>Lamp Search Safe = ' . $lamp_engine_safe . '</div>');
		}else{
			return;
		}
    }
	

    if (dsf_not_null($parameters)) {
      $link .= $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

	


		// differences made due to cookie law 2012-05-28 ########################
			
			if (isset($dsv_allow_system_cookie) && $dsv_allow_system_cookie == 'true'){
				// we are fine do not need to do anything with URLS
			}else{
				// we add an implied consent to the end of each url providing it is not the
				// form request (that needs to use dsf_href_refer_link   - additionally we don't
				// add it for known spiders
				
							if (defined('DS_COOKIE_SET_ALWAYS') && DS_COOKIE_SET_ALWAYS == 'true'){
								// forcing therefore do not need implied
							}else{
								
									if ($spider_flag == false){
										$link .= $separator .  'cookie_implied=yes';
									}
							}
			}
		//  end cookie law difference ###########################################



     $link = str_replace('&', '&amp;', $link);

	if (isset($nopage) && $nopage == 'true'){
		// we didn't pass a url page, so look for trailing slash and remove it.
			if (strlen(SITE_SUBFOLDER) > 1){
				// dont do anything as we have a sub folder.
			}else{
				if (substr($link, -1) == '/'){
				 $link = substr($link, 0, -1);
				}
			}
	}

    return dsf_parse_injection($link);
  }  
  
  function dsf_parse_injection($text=''){

		if (isset($text) && strlen($text) > 1){
			
			// prefix the text so that we will always find something with the strpos > 0  even if it is the first characters.
			
			$text = '[pppp]' . $text;
			
			$strip_array = array('<img' , '&lt;img', '[img', 'script','quot;','<src' ,'&lt;src' ,'[src' , '<' , '>','&lt;' , '&gt;', 'javascript' , 'java' , 'alert', '%0d' , '%0a', '%3c' , '%3e', '%5c', "\\", "\n" , "\r" );
		
			foreach ($strip_array as $value){
				// look for start
					$work_text = $text;
					
					$find_a = strpos(strtolower($text), $value , 0 );
					
					if ((int)$find_a >0){
							// we have one -  try to repair by looking for the end
						
							
							
						$find_b = strpos(strtolower($text), '/' . $value , (int)$find_a ) +1;
				
							// if we have a value for find_b then we will strip all of the content
							// between the two values.
							if ((int)$find_b > 1){
									$work_text = substr($text, 0, $find_a);
									$work_text .= substr($text, ((int)$find_b + strlen($value)) );
									
							// otherwise we strip everything after to be on the safe side.
							}else{
									$work_text = substr($text, 0, $find_a);
							}
						$text = $work_text;	
					}		
			
			}
		
		}
	
	if (strlen($text)>0){
		$text = str_replace(array("'", '"' , 'amp;', '[pppp]') , '' , $text);
	}
	
	
return $text;
}
  
  
  
// function dsf_array($db_query) {
//  		return dsf_db_fetch_array($db_query);
//  }


// Stop from parsing any further PHP code
  function dsf_exit() {
   dsf_session_close();
   exit();
  }

// ###


// Redirect to another page or site
  function dsf_redirect($url) {
    
    header('Location: ' . $url);

    dsf_exit();
  }

function dsf_query($query) {
		return dsf_db_query($query);
	}  
        
function dsf_db_query($query, $link = 'db_link') {
    global $$link;

  
    $result = mysql_query($query, $$link);

    return $result;
  }        
  

// ###
  
function dsf_create_dynamic_form_array($form_id=0) {


$field_types = array();
$field_types[1] = 'check box field (multiple)';
$field_types[9] = 'check box field (on / off)';
$field_types[10] = 'calander';
$field_types[2] = 'date field';
$field_types[3] = 'email field';
$field_types[4] = 'input field';
$field_types[5] = 'password field';
$field_types[6] = 'radio button field';
$field_types[7] = 'select field (dropdown)';
$field_types[8] = 'text box field';

$field_types[11] = 'firstname field';
$field_types[12] = 'lastname field';

$field_types[13] = 'category / product matrix';
$field_types[14] = 'subscription checkbox (on / off)';
$field_types[15] = 'h3 Text';
$field_types[16] = 'Paragraph text';







if ($form_id > 0){                

			$form_query = dsf_query("select * from " . DS_DB_SHOP . ".form_fields where form_id='" . $form_id . "' order by sort_order");
                        
                   //     var_dump($form_query);die();
			
			$dsv_fields_array = array();
			
			while ($form_results = dsf_array($form_query)){
			
				$field_name = $form_results['field_name'];
				$field_type = $form_results['field_type'];
				
				if (strlen($field_name) < 1){
					$field_name = $form_results['field_id'];
				}
				
				
				$dsv_fields_array[$field_name] = array('field_id' => $form_results['field_id'],
														'field_name' => $form_results['field_name'],
														'field_type_id' => $form_results['field_type'],
														'field_type_text' => $field_types[$field_type],
														'field_values' => $form_results['field_values'],
														'field_text' => $form_results['field_text'],
														'field_start_year' => $form_results['field_start_year'],
														'field_end_year' => $form_results['field_end_year'],
														'other_allowed' => ($form_results['field_other'] == 1 ? 'true' : 'false'),
														'field_columns' => $form_results['field_columns'],
														'field_rows' => $form_results['field_rows'],
														'other_text' => $form_results['other_text'],
														'other_error' => $form_results['other_error'],
														'long_text' => $form_results['additional_text'],
														'min_length' => $form_results['field_min_length'],
														'required' => ($form_results['field_required'] == 1 ? 'true' : 'false'),
														'required_error' => $form_results['required_error'],
														'min_error' => $form_results['min_error'],
														'field_format_class' => $form_results['field_format_class'],
														'field_format_id' => $form_results['field_format_id'],
														'other_format_class' => $form_results['other_format_class'],
														'other_format_id' => $form_results['other_format_id'],
														'encapsulate_field' => ($form_results['field_encapsulate'] == 1 ? 'true' : 'false'),
														'encapsulate_id' => $form_results['field_encapsulate_id'],
														'encapsulate_class' => $form_results['field_encapsulate_class'],
														'field_category_levels' => $form_results['field_category_levels'],
														'field_category_hide_root' => $form_results['field_category_hide_root'],
														'field_category_one_class' => $form_results['field_category_one_class'],
														'field_category_two_class' => $form_results['field_category_two_class'],
														'field_product_class' => $form_results['field_product_class'],
														'javascript_control' => ($form_results['field_js_control'] == 1 ? 'true' : 'false'),
														'javascript_control_onclick' => $form_results['field_js_control_onclick'],
														'javascript_control_onchange' => $form_results['field_js_control_onchange'],
														'javascript_control_onmouseover' => $form_results['field_js_control_onmouseover'],
														'javascript_control_onmouseout' => $form_results['field_js_control_onmouseout']
														);


			}
}else{
	$dsv_fields_array = 'Invalid Form ID';
}

return $dsv_fields_array;

} // end function  

function dsf_create_dynamic_field_array($field_id=0) {


if ($field_id > 0){

			$form_query = dsf_query("select * from " . DS_DB_SHOP . ".form_fields where field_id='" . $field_id . "'");
			
			
			$form_results = dsf_array($form_query);
			
				$field_name = $form_results['field_name'];
				$field_type = $form_results['field_type'];
				
				
				$dsv_fields_array = array('field_id' => $form_results['field_id'],
														'field_name' => $form_results['field_name'],
														'field_type_id' => $form_results['field_type'],
														'field_values' => $form_results['field_values'],
														'field_text' => $form_results['field_text'],
														'field_start_year' => $form_results['field_start_year'],
														'field_end_year' => $form_results['field_end_year'],
														'other_allowed' => ($form_results['field_other'] == 1 ? 'true' : 'false'),
														'field_columns' => $form_results['field_columns'],
														'field_rows' => $form_results['field_rows'],
														'other_text' => $form_results['other_text'],
														'other_error' => $form_results['other_error'],
														'long_text' => $form_results['additional_text'],
														'min_length' => $form_results['field_min_length'],
														'required' => ($form_results['field_required'] == 1 ? 'true' : 'false'),
														'required_error' => $form_results['required_error'],
														'min_error' => $form_results['min_error'],
														'field_format_class' => $form_results['field_format_class'],
														'field_format_id' => $form_results['field_format_id'],
														'other_format_class' => $form_results['other_format_class'],
														'other_format_id' => $form_results['other_format_id'],
														'encapsulate_field' => ($form_results['field_encapsulate'] == 1 ? 'true' : 'false'),
														'encapsulate_id' => $form_results['field_encapsulate_id'],
														'encapsulate_class' => $form_results['field_encapsulate_class'],
														'field_category_levels' => $form_results['field_category_levels'],
														'field_category_hide_root' => $form_results['field_category_hide_root'],
														'field_category_one_class' => $form_results['field_category_one_class'],
														'field_category_two_class' => $form_results['field_category_two_class'],
														'field_product_class' => $form_results['field_product_class'],
														'javascript_control' => ($form_results['field_js_control'] == 1 ? 'true' : 'false'),
														'javascript_control_onclick' => $form_results['field_js_control_onclick'],
														'javascript_control_onchange' => $form_results['field_js_control_onchange'],
														'javascript_control_onmouseover' => $form_results['field_js_control_onmouseover'],
														'javascript_control_onmouseout' => $form_results['field_js_control_onmouseout']
														);


}else{
	$dsv_fields_array = 'Invalid field ID';
}

return $dsv_fields_array;

} // end function




// #######

// function to only echo the field box , dropdown etc....    based on a value supplied in field_info.   Note this does not do labels or encapsulating items.


function dsf_output_form_array_field_only($field_info='', $parameters = '', $style=''){

// ALL OPTIONS TO BE EDITED AND CHECKED ONCE WE HAVE THE COMPLETE ITEMS PROGRAMMED CORRECTLY.

if (is_array($field_info)){


			// job 1  find out what kind of item it is.
			
			if (isset($field_info['field_type_id']) && $field_info['field_type_id'] > 0){
			
				// we are ok to continue
			
				// type 1 
					if ($field_info['field_type_id'] == 1){
					
							// multiple checkboxes
							$cboxes = explode("\n" , $field_info['field_values']);
							if (is_array($cboxes) && sizeof($cboxes)> 0){
								// we have an array therefore lets display them all
								$return_text = '';
								
								$rvalue = $field_info['field_name'];
								
								foreach ($cboxes as $item){
									$item = str_replace(array("\n", "\r" , "\l"),"", $item);
									$fname = $rvalue . '[' . $item . ']';
									
									
									$return_text .= '<label for="' . $fname . '">' . $item . '</label>' . dsf_form_checkbox($fname, 1 ,'',(strlen($parameters)>0 ? $parameters : ''));
								
								
								}
								
								
								
							}
					// end type 1
					}elseif ($field_info['field_type_id'] == 2){
					
							// dropdown date fields.  this needs to go back some years

								if ((int)$field_info['field_end_year'] > 0){
									$year_end = (int)$field_info['field_end_year'];
								}else{
									$year_end =date("Y",time());
								}
								
								if ((int)$field_info['field_start_year'] > 0){
									$year_start = (int)$field_info['field_start_year'];
								}else{
									$year_start =date("Y",time());
								}
								


								$day_array = array(array('id' => '' , 'text' => TRANSLATION_DAY));
								
								for ($i=1, $n=31; $i<=$n; $i++) {
								
								$day_array[] = array('id' => $i,
															 'text' => (strlen($i) == 1) ? '0' . $i : $i);
								}
						
								$month_array = array(array('id' => '' , 'text' => TRANSLATION_MONTH));
								
								for ($i=1, $n=12; $i<=$n; $i++) {
								
								$month_array[] = array('id' => $i,
															 'text' => (strlen($i) == 1) ? '0' . $i : $i);
								}
						
								$year_array = array(array('id' => '' , 'text' => TRANSLATION_YEAR));
								
								 for ($i= $year_start, $n=$year_end; $i<=$n; $i++) {
								
								$year_array[] = array('id' => $i,
															 'text' => (strlen($i) == 1) ? '0' . $i : $i);
								}

								
								$rvalue = $field_info['field_name'];
								
									$fday = $rvalue . '[day]';
									$fmonth = $rvalue . '[month]';
									$fyear = $rvalue . '[year]';
									
								
								
								
								if (defined('DATE_FORMAT')){
									if (DATE_FORMAT == 'dd/mm/yyy'){
											$return_text .= dsf_form_dropdown($fday , $day_array, '', $parameters, $style);
											$return_text .= dsf_form_dropdown($fmonth , $month_array, '', $parameters, $style);
											$return_text .= dsf_form_dropdown($fyear , $year_array, '', $parameters, $style);
								
									}elseif (DATE_FORMAT == 'mm/dd/yyy'){
											$return_text .= dsf_form_dropdown($fmonth , $month_array, '', $parameters, $style);
											$return_text .= dsf_form_dropdown($fday , $day_array, '', $parameters, $style);
											$return_text .= dsf_form_dropdown($fyear , $year_array, '', $parameters, $style);
									
									}elseif (DATE_FORMAT == 'yyyy/dd/mm'){
											$return_text .= dsf_form_dropdown($fyear , $year_array, '', $parameters, $style);
											$return_text .= dsf_form_dropdown($fday , $day_array, '', $parameters, $style);
											$return_text .= dsf_form_dropdown($fmonth , $month_array, '', $parameters, $style);
									
									}elseif (DATE_FORMAT == 'yyyy/mm/dd'){
											$return_text .= dsf_form_dropdown($fyear , $year_array, '', $parameters, $style);
											$return_text .= dsf_form_dropdown($fmonth , $month_array, '', $parameters, $style);
											$return_text .= dsf_form_dropdown($fday , $day_array, '', $parameters, $style);
									}else{
											$return_text .= dsf_form_dropdown($fday , $day_array, '', $parameters, $style);
											$return_text .= dsf_form_dropdown($fmonth , $month_array, '', $parameters, $style);
											$return_text .= dsf_form_dropdown($fyear , $year_array, '', $parameters, $style);
									}
								}else{
									
									$return_text .= dsf_form_dropdown($fday , $day_array, '', $parameters, $style);
									$return_text .= dsf_form_dropdown($fmonth , $month_array, '', $parameters, $style);
									$return_text .= dsf_form_dropdown($fyear , $year_array, '', $parameters, $style);
								}
			
			
						}elseif ($field_info['field_type_id'] == 3){
					
							// email input

									
									$return_text .= dsf_form_email($field_info['field_name'] , '', $parameters, $style);
								
			
						}elseif ($field_info['field_type_id'] == 4){
					
							// input

									
									$return_text .= dsf_form_input($field_info['field_name'] , '', $parameters, $style);
								
			
			
					}elseif ($field_info['field_type_id'] == 11){
					
							// input

									
									$return_text .= dsf_form_input($field_info['field_name'] , '', $parameters, $style);
								
			
					}elseif ($field_info['field_type_id'] == 12){
					
							// input

									
									$return_text .= dsf_form_input($field_info['field_name'] , '', $parameters, $style);
								
			
				// type 6 
					}elseif ($field_info['field_type_id'] == 6){
					
							// multiple checkboxes
							$cboxes = explode("\n" , $field_info['field_values']);
							if (is_array($cboxes) && sizeof($cboxes)> 0){
								// we have an array therefore lets display them all
								
								$rvalue = $field_info['field_name'];
								
								foreach ($cboxes as $item){
									$item = str_replace(array("\n", "\r" , "\l"),"", $item);
									$fname = $rvalue . '[' . $item . ']';
									
									
									$return_text .= '<label>' . $item . '</label>' . dsf_form_radio($rvalue, $item ,'',(strlen($parameters)>0 ? $parameters : '')) . '&nbsp;';
								
								
								}
								
								
								
							}
					// end type 6
			











				
					 } // end field types
				
			}else{
			
				$return_text = 'No Field type set';
			}


}else{
	$return_text = 'No Field values';
}	


return $return_text;




}


// #####

function dsf_output_form_array_complete_item($field_info='', $parameters = '', $style=''){


$return_text = '';



if (is_array($field_info)){

			// job 1  find out what kind of item it is.
			
			if (isset($field_info['field_type_id']) && $field_info['field_type_id'] > 0){
			
				// we are ok to continue
				
				
				// check for encapsulating.
				
				if ($field_info['encapsulate_field'] == 'true'){
					
					$return_text .= '<div' . (strlen($field_info['encapsulate_id']) > 0 ? ' id="' . $field_info['encapsulate_id'] . '"' : '');
					$return_text .= (strlen($field_info['encapsulate_class']) > 0 ? ' class="' . $field_info['encapsulate_class'] . '"' : '');
					$return_text .='>';
				}
				
				
				
				// check for javascript control
				
				
				if ($field_info['javascript_control'] == 'true'){
					
					
					if (strlen($field_info['javascript_control_onchange']) > 0){
						
						$parameters .= " onchange=\"" . str_replace('"',"'",$field_info['javascript_control_onchange']) . "\"";			
					
					}
		
		
					if (strlen($field_info['javascript_control_onclick']) > 0){
						
						$parameters .= " onclick=\"" . str_replace('"',"'",$field_info['javascript_control_onclick']) . "\"";			
					
					}
		
					if (strlen($field_info['javascript_control_onmouseover']) > 0){
						
						$parameters .= " onmouseover=\"" . str_replace('"',"'",$field_info['javascript_control_onmouseover']) . "\"";			
					
					}
			
					if (strlen($field_info['javascript_control_onmouseout']) > 0){
						
						$parameters .= " onmouseout=\"" . str_replace('"',"'",$field_info['javascript_control_onmouseout']) . "\"";			
					
					}

					
				}
				
				
				
				
			
				// type 1 
					if ($field_info['field_type_id'] == 1){
					
						// multiple checkboxes
							$return_text .= '<p>' . $field_info['field_text'] . ($field_info['required'] == 'true' ? '<span class="dsRequired">*</span>' : '') . '</p>';


					if (strlen($field_info['field_format_id']) > 0){
							$return_text .='<div id="' . $field_info['field_format_id'] . '">';
					}
					

							$cboxes = explode("\n" , $field_info['field_values']);
							if (is_array($cboxes) && sizeof($cboxes)> 0){
								// we have an array therefore lets display them all
								
								$rvalue = $field_info['field_name'];
								
								foreach ($cboxes as $item){
									$item = str_replace(array("\n", "\r" , "\l"),"", $item);
									$fname = $rvalue . '[' . $item . ']';
									
									
									$return_text .= '<label for="' . $fname . '">' . $item . '</label>' . dsf_form_checkbox($fname, 1 ,(isset($_POST[$fname]) ? true : ''),$parameters,(strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
								
								
								}
								
								
								
							}
							
							
							// check for other.
							
							if ($field_info['other_allowed'] == 'true'){
								
								// field other.


									if (strlen($field_info['other_format_id']) > 0){
											$return_text .='<div id="' . $field_info['other_format_id'] . '">';
									}



									$return_text .= '<label for="' . $field_info['field_name'] . '_other">' . $field_info['other_text'] . '</label>';
										
										$text_field = $field_info['field_name'] . '_other';
										
									$return_text .= dsf_form_input($field_info['field_name'] . '_other' , (isset($_POST[$text_field]) ? $_POST[$text_field] : ''), '', (strlen($field_info['other_format_class']) > 0 ? $field_info['other_format_class']  : ''));

								
									if (strlen($field_info['other_format_id']) > 0){
											$return_text .='</div>';
									}
								
								
							} // end other
							
							
							
							
					if (strlen($field_info['field_format_id']) > 0){
							$return_text .='</div>';
					}
							
							
					// end type 1
					
					
					
					}elseif ($field_info['field_type_id'] == 2){
					
							// dropdown date fields.  this needs to go back some years
								$return_text .= '<label>' . $field_info['field_text'] . ($field_info['required'] == 'true' ? '<span class="dsRequired">*</span>' : '') . '</label>';
								

					if (strlen($field_info['field_format_id']) > 0){
							$return_text .='<div id="' . $field_info['field_format_id'] . '">';
					}

								if ((int)$field_info['field_end_year'] > 0){
									$year_end = (int)$field_info['field_end_year'];
								}else{
									$year_end =date("Y",time());
								}
								
								if ((int)$field_info['field_start_year'] > 0){
									$year_start = (int)$field_info['field_start_year'];
								}else{
									$year_start =date("Y",time());
								}


								$day_array = array(array('id' => '' , 'text' => TRANSLATION_DAY));
								
								for ($i=1, $n=31; $i<=$n; $i++) {
								
								$day_array[] = array('id' => $i,
															 'text' => (strlen($i) == 1) ? '0' . $i : $i);
								}
						
								$month_array = array(array('id' => '' , 'text' => TRANSLATION_MONTH));
								
								for ($i=1, $n=12; $i<=$n; $i++) {
								
								$month_array[] = array('id' => $i,
															 'text' => (strlen($i) == 1) ? '0' . $i : $i);
								}
						
								$year_array = array(array('id' => '' , 'text' => TRANSLATION_YEAR));
								
								 for ($i= $year_start, $n=$year_end; $i<=$n; $i++) {
								
								$year_array[] = array('id' => $i,
															 'text' => (strlen($i) == 1) ? '0' . $i : $i);
								}

								
								$rvalue = $field_info['field_name'];
								
									$fday = $rvalue . '[day]';
									$fmonth = $rvalue . '[month]';
									$fyear = $rvalue . '[year]';
									
									$tfday = $rvalue . "['day']";
									$tfmonth = $rvalue . "['month']";
									$tfyear = $rvalue . "['year']";
								
								
								
								if (defined('DATE_FORMAT')){
									if (DATE_FORMAT == 'D/M/Y' || DATE_FORMAT == 'D-M-Y'){
											$return_text .= dsf_form_dropdown($fday , $day_array, (isset($_POST[$rvalue]['day']) ? $_POST[$rvalue]['day'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
											$return_text .= dsf_form_dropdown($fmonth , $month_array, (isset($_POST[$rvalue]['month']) ? $_POST[$rvalue]['month'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
											$return_text .= dsf_form_dropdown($fyear , $year_array, (isset($_POST[$rvalue]['year']) ? $_POST[$rvalue]['year'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
								
									}elseif (DATE_FORMAT == 'M/D/Y' || DATE_FORMAT == 'M-D-Y'){
											$return_text .= dsf_form_dropdown($fmonth , $month_array, (isset($_POST[$rvalue]['month']) ? $_POST[$rvalue]['month'] : '') , $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
											$return_text .= dsf_form_dropdown($fday , $day_array, (isset($_POST[$rvalue]['day']) ? $_POST[$rvalue]['day'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
											$return_text .= dsf_form_dropdown($fyear , $year_array, (isset($_POST[$rvalue]['year']) ? $_POST[$rvalue]['year'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
									
									}elseif (DATE_FORMAT == 'Y/M/D' || DATE_FORMAT == 'Y-M-D'){
											$return_text .= dsf_form_dropdown($fyear , $year_array, (isset($_POST[$rvalue]['year']) ? $_POST[$rvalue]['year'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
											$return_text .= dsf_form_dropdown($fmonth , $month_array, (isset($_POST[$rvalue]['month']) ? $_POST[$rvalue]['month'] : '') , $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
											$return_text .= dsf_form_dropdown($fday , $day_array, (isset($_POST[$rvalue]['day']) ? $_POST[$rvalue]['day'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
									}else{
											$return_text .= dsf_form_dropdown($fday , $day_array, (isset($_POST[$rvalue]['day']) ? $_POST[$rvalue]['day'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
											$return_text .= dsf_form_dropdown($fmonth , $month_array, (isset($_POST[$rvalue]['month']) ? $_POST[$rvalue]['month'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
											$return_text .= dsf_form_dropdown($fyear , $year_array, (isset($_POST[$rvalue]['year']) ? $_POST[$rvalue]['year'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
									}
								}else{
									
									$return_text .= dsf_form_dropdown($fday , $day_array, (isset($_POST[$rvalue]['day']) ? $_POST[$rvalue]['day'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
									$return_text .= dsf_form_dropdown($fmonth , $month_array, (isset($_POST[$rvalue]['month']) ? $_POST[$rvalue]['month'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
									$return_text .= dsf_form_dropdown($fyear , $year_array, (isset($_POST[$rvalue]['year']) ? $_POST[$rvalue]['year'] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
								}
			
					if (strlen($field_info['field_format_id']) > 0){
							$return_text .='</div>';
					}


			
						}elseif ($field_info['field_type_id'] == 3){
					
							// email input

								$return_text .= '<label for="' . $field_info['field_name'] . '">' . $field_info['field_text'] . ($field_info['required'] == 'true' ? '<span class="dsRequired">*</span>' : '') . '</label>';
									
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='<div id="' . $field_info['field_format_id'] . '">';
								}
									$text_field = $field_info['field_name'];
									
									$return_text .= dsf_form_email($field_info['field_name'] , (isset($_POST[$text_field]) ? $_POST[$text_field] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
								
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='</div>';
								}
			
			
			


						}elseif ($field_info['field_type_id'] == 14){
					
							// signup check box (specific)

								$return_text .= '<label for="' . $field_info['field_name'] . '">' . $field_info['field_text'] . '</label>';
									
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='<div id="' . $field_info['field_format_id'] . '">';
								}
								
								$text_field = $field_info['field_name'];
								
									$return_text .= dsf_form_checkbox($field_info['field_name'], 1 ,(isset($_POST[$text_field]) && (int)$_POST[$text_field] ==1 ? true : false),$parameters,(strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
								
								
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='</div>';
								}
			
			
			
						}elseif ($field_info['field_type_id'] == 9){
					
							// standard check box

								$return_text .= '<label for="' . $field_info['field_name'] . '">' . $field_info['field_text'] . '</label>';
									
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='<div id="' . $field_info['field_format_id'] . '">';
								}
								$text_field = $field_info['field_name'];

									$return_text .= dsf_form_checkbox($field_info['field_name'], 1 ,(isset($_POST[$text_field]) && (int)$_POST[$text_field] ==1 ? true : false),$parameters,(strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
								
								
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='</div>';
								}
			
			





			
			
						}elseif ($field_info['field_type_id'] == 4){
					
							// input

									
								$return_text .= '<label for="' . $field_info['field_name'] . '">' . $field_info['field_text'] . ($field_info['required'] == 'true' ? '<span class="dsRequired">*</span>' : '') . '</label>';


								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='<div id="' . $field_info['field_format_id'] . '">';
								}
									
									$text_field = $field_info['field_name'];
									
									$return_text .= dsf_form_input($field_info['field_name'] , (isset($_POST[$text_field]) ? $_POST[$text_field] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
								
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='</div>';
								}
			
			
					}elseif ($field_info['field_type_id'] == 11){
					
							// input

									
								$return_text .= '<label for="' . $field_info['field_name'] . '">' . $field_info['field_text'] . ($field_info['required'] == 'true' ? '<span class="dsRequired">*</span>' : '') . '</label>';


								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='<div id="' . $field_info['field_format_id'] . '">';
								}

									$text_field = $field_info['field_name'];

									$return_text .= dsf_form_input($field_info['field_name'] , (isset($_POST[$text_field]) ? $_POST[$text_field] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
								
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='</div>';
								}
			
					}elseif ($field_info['field_type_id'] == 12){
					
							// input

								$return_text .= '<label for="' . $field_info['field_name'] . '">' . $field_info['field_text'] . ($field_info['required'] == 'true' ? '<span class="dsRequired">*</span>' : '') . '</label>';
								
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='<div id="' . $field_info['field_format_id'] . '">';
								}
									$text_field = $field_info['field_name'];
									$return_text .= dsf_form_input($field_info['field_name'] , (isset($_POST[$text_field]) ? $_POST[$text_field] : ''), $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
								
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='</div>';
								}
			
				// type 6 
					}elseif ($field_info['field_type_id'] == 6){
					
								$return_text .= '<p>' . $field_info['field_text'] . ($field_info['required'] == 'true' ? '<span class="dsRequired">*</span>' : '') . '</p>';

								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='<div id="' . $field_info['field_format_id'] . '">';
								}

							// multiple checkboxes
							$cboxes = explode("\n" , $field_info['field_values']);
							if (is_array($cboxes) && sizeof($cboxes)> 0){
								// we have an array therefore lets display them all
								
								$rvalue = $field_info['field_name'];
								$cnt = 0;
								
								
								foreach ($cboxes as $item){
									$item = str_replace(array("\n", "\r" , "\l"),"", $item);
									$fname = $rvalue . '[' . $item . ']';
									$cnt ++;
									
									
									
									$return_text .= '<label>' . $item . '</label>' . dsf_form_radio($rvalue, $item ,(isset($_POST[$fname]) ? true : ''),(strlen($parameters)>0 ? $parameters : ''), (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''),$rvalue . '_' . $cnt) . '&nbsp;';
								
								
								}
								
								
								
							}
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='</div>';
								}
					// end type 6
			



				// type 7 
					}elseif ($field_info['field_type_id'] == 7){
					
 						 $drop_array = array(array('id' => '' , 'text' => TRANSLATION_PLEASE_SELECT));
							
								$return_text .= '<label for="' . $field_info['field_name'] . '">' . $field_info['field_text'] . ($field_info['required'] == 'true' ? '<span class="dsRequired">*</span>' : '') . '</label>';
							
							// dropdown
							$cboxes = explode("\n" , $field_info['field_values']);
							if (is_array($cboxes) && sizeof($cboxes)> 0){
								
								
								
								foreach ($cboxes as $item){
									$item = str_replace(array("\n", "\r" , "\l"),"", $item);
									
									$drop_array[] = array('id' => $item, 'text' => $item);
									
									
								}
								
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='<div id="' . $field_info['field_format_id'] . '">';
								}
									
									$text_field = $field_info['field_name'];
									
									$return_text .= dsf_form_dropdown($field_info['field_name'], $drop_array ,(isset($_POST[$text_field]) ? $_POST[$text_field] : ''),(strlen($parameters)>0 ? $parameters : ''),(strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));
								



							// check for other.
							
							if ($field_info['other_allowed'] == 'true'){
								
								// field other.


									if (strlen($field_info['other_format_id']) > 0){
											$return_text .='<div id="' . $field_info['other_format_id'] . '">';
									}



									$return_text .= '<label for="' . $field_info['field_name'] . '_other">' . $field_info['other_text'] . '</label>';
									$text_field = $field_info['field_name'] . '_other';
									$return_text .= dsf_form_input($field_info['field_name'] . '_other' , (isset($_POST[$text_field]) ? $_POST[$text_field] : ''), '', (strlen($field_info['other_format_class']) > 0 ? $field_info['other_format_class']  : ''));

								
									if (strlen($field_info['other_format_id']) > 0){
											$return_text .='</div>';
									}
								
								 
							} // end other










								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='</div>';
								}
								
								
								
							}
					// end type 7


				// type 8
					}elseif ($field_info['field_type_id'] == 8){
					
							// input

								$return_text .= '<label for="' . $field_info['field_name'] . '">' . $field_info['field_text'] . ($field_info['required'] == 'true' ? '<span class="dsRequired">*</span>' : '') . '</label>';
									
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='<div id="' . $field_info['field_format_id'] . '">';
								}
								
									 $text_field = $field_info['field_name'];
									  $return_text .= dsf_form_text($field_info['field_name'], (isset($_POST[$text_field]) ? $_POST[$text_field] : ''), (int)$field_info['field_columns'], (int)$field_info['field_rows'], $parameters, (strlen($field_info['field_format_class']) > 0 ? $field_info['field_format_class']  : ''));

								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='</div>';
								}
			
			// end type 8





				// type 15
					}elseif ($field_info['field_type_id'] == 15){
					
							// h3 text
									
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='<div id="' . $field_info['field_format_id'] . '">';
								}
								
									 
									  $return_text .= '<h3' . (strlen($field_info['field_format_class']) > 0 ? ' class="' . $field_info['field_format_class'] . '"'  : '') . '>' . $field_info['long_text'] . '</h3>';

								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='</div>';
								}
			
			// end type 15



				// type 16
					}elseif ($field_info['field_type_id'] == 16){
					
							// paragraph text
									
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='<div id="' . $field_info['field_format_id'] . '">';
								}
								
									 
									  $return_text .= '<p' . (strlen($field_info['field_format_class']) > 0 ? ' class="' . $field_info['field_format_class'] . '"'  : '') . '>' . $field_info['long_text'] . '</p>';

								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='</div>';
								}
			
			// end type 16






				// product matrix
					}elseif ($field_info['field_type_id'] == 13){
						


								$return_text .= '<label>' . $field_info['field_text'] . ($field_info['required'] == 'true' ? '<span class="dsRequired">*</span>' : '') . '</label>';
									
								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='<div id="' . $field_info['field_format_id'] . '">';
								}
								
							// box 1
							$return_text .='<div id="dsform_cat_one">';
							
									// create a drop array based on the category
									
									if (isset($field_info['field_category_hide_root']) && (int)$field_info['field_category_hide_root'] > 0){
										$drop_array = dsf_get_category_matrix($field_info['field_category_hide_root']);
									
									}else{
										$drop_array = dsf_get_category_matrix(0);
									}
									
									$parameters =' onchange="dsj_matrix_show(' . $field_info['field_id'] . ',1,' . $field_info['field_category_levels'] .');"';
							
									$return_text .= dsf_form_listbox('ds_matrix_one', $drop_array ,(isset($_POST['ds_matrix_one']) ? $_POST['ds_matrix_one'] : ''),(strlen($parameters)>0 ? $parameters : ''),(strlen($field_info['field_category_one_class']) > 0 ? $field_info['field_category_one_class']  : ''));
							$return_text .='</div>' ."\n";


							// box 2
							
							if((int)$field_info['field_category_levels'] == 2){
								
								
							$return_text .='<div id="dsform_cat_two">';
							
									// create a drop array based on the category
									
									if (isset($_POST['ds_matrix_one']) && (int)$_POST['ds_matrix_one'] > 0){
										$drop_array = dsf_get_category_matrix($_POST['ds_matrix_one']);
									}else{
										$drop_array = array();
									}
									
									$parameters =' onchange="dsj_matrix_show(' . $field_info['field_id'] . ',2,' . $field_info['field_category_levels'] .');"';
							
									$return_text .= dsf_form_listbox('ds_matrix_two', $drop_array ,(isset($_POST['ds_matrix_two']) ? $_POST['ds_matrix_two'] : ''),(strlen($parameters)>0 ? $parameters : ''),(strlen($field_info['field_category_two_class']) > 0 ? $field_info['field_category_two_class']  : ''));
							$return_text .='</div>' ."\n";
								
								
							}


						 // box 3   (for product but we do not have any information



							$return_text .='<div id="dsform_cat_three">';
							
									// create a drop array based on the category
									
									if (isset($_POST['ds_matrix_two']) && (int)$_POST['ds_matrix_two'] > 0){
										$drop_array = dsf_get_product_matrix($_POST['ds_matrix_two']);
									}else{
										$drop_array = array();
									}
									
									$return_text .= dsf_form_listbox('ds_matrix_three', $drop_array ,(isset($_POST['ds_matrix_three']) ? $_POST['ds_matrix_three'] : ''),(strlen($parameters)>0 ? $parameters : ''),(strlen($field_info['field_product_class']) > 0 ? $field_info['field_product_class']  : ''));
							$return_text .='</div>' ."\n";







							// check for other.
							
							if ($field_info['other_allowed'] == 'true'){
								
								// field other.


									if (strlen($field_info['other_format_id']) > 0){
											$return_text .='<div id="' . $field_info['other_format_id'] . '">';
									}



									$return_text .= '<label for="' . $field_info['field_name'] . '_other">' . $field_info['other_text'] . '</label>';
	
									$text_field = $field_info['field_name'] . '_other';
									
									$return_text .= dsf_form_input($field_info['field_name'] . '_other' , (isset($_POST[$text_field]) ? $_POST[$text_field] : ''), '', (strlen($field_info['other_format_class']) > 0 ? $field_info['other_format_class']  : ''));

								
									if (strlen($field_info['other_format_id']) > 0){
											$return_text .='</div>';
									}
								
								 
							} // end other
















								if (strlen($field_info['field_format_id']) > 0){
										$return_text .='</div>';
								}









				
					 } // end field types
					 
				
				
				
				
				if ($field_info['encapsulate_field'] == 'true'){
					
					$return_text .= '</div>' . "\n";
				}
					 
				
			}else{
			
				$return_text .= 'No Field type set';
			}


}else{
	$return_text .= 'No Field values';
}	


return $return_text;

}


function dsf_form_hidden($name, $value = '', $parameters = '') {
    $field = '<input type="hidden" name="' . dsf_output_string($name) . '" id="' . dsf_output_string($name) . '"';
	
    if (dsf_not_null($value)) {
      $field .= ' value="' . dsf_output_string($value) . '"';
    }

    if (dsf_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= ' />';

    return $field;
  }



// as we only ever include this file function file if we have a form to display,  we can safely start to create the sections we need.


// job 1 is to create the form field array from the form id and put it into a variable.

$dsv_dynamic_form_id=1;

$dsv_dynamic_form_fields = dsf_create_dynamic_form_array($dsv_dynamic_form_id);
$dsv_dynamic_form_action = '';

	$dsv_dynamic_form_start = dsf_form_create('dsDynamicForm', dsf_href_link($dsv_current_page_url , 'action=send' , 'SSL'));
	$dsv_dynamic_form_end = dsf_form_hidden('dynamic_form_id' , $dsv_dynamic_form_id) . '</form>';


$dsv_dynamic_form_error = '';
$dsv_dynamic_form_success_text = '';
$dsv_dynamic_form_action = '';
$dsv_form_error = 'false';
$dsv_form_signup = 'false';


$dsv_firstname = '';
$dsv_lastname = '';


	// get the forms data for use in authenticating the send and getting original page name.
	
	
	
	$frm_query = dsf_db_query("select form_name, customer_email, customer_text, customer_subject, sitecopy_email, sitecopy_email_address, sitecopy_text, sitecopy_subject, form_success_text from " . DS_DB_SHOP . ".form_item where form_id='" . $dsv_dynamic_form_id . "'");
	$frm_results = dsf_db_fetch_array($frm_query);
	
	// we are getting the data at this point because we need to create the email based on the answers supplied before we save it.

$dsv_dynamic_form_name = $frm_results['form_name'];






if (isset($_GET['action']) && $_GET['action'] == 'send'){
	
		
	// the form is being posted.  we need to check the results and advise accordingly.
	
	// we need to check through every field and if there is an error add this to the error session.
	
	$sql_data_array = array();
	
	
			foreach($dsv_dynamic_form_fields as $item => $value){

					$save_item = '';
					

					if (isset($_POST[$item])){
						
						
						// check for date field - we have do do all checking in one go as they are posted as an array.
						
						
						if ((int)$value['field_type_id'] == 2){
							// date field found - make a valid date to save in program mode  YYYY-MM-DD
							
									if ( (isset($_POST[$item]['year']) && strlen($_POST[$item]['year']) > 1)  &&  (isset($_POST[$item]['month']) && strlen($_POST[$item]['month']) > 0) && (isset($_POST[$item]['day']) && strlen($_POST[$item]['day']) > 0) ){
										
										if (defined('DATE_FORMAT')){
											if (DATE_FORMAT == 'D/M/Y'){
												$save_item = dsf_format_fixed_length($_POST[$item]['day'],2,'right','0') . '/' . dsf_format_fixed_length($_POST[$item]['month'],2,'right','0') . '/' . $_POST[$item]['year'];
											}elseif (DATE_FORMAT == 'D-M-Y'){
												$save_item = dsf_format_fixed_length($_POST[$item]['day'],2,'right','0') . '-' . dsf_format_fixed_length($_POST[$item]['month'],2,'right','0') . '-' . $_POST[$item]['year'];
											}elseif (DATE_FORMAT == 'D.M.Y'){
												$save_item = dsf_format_fixed_length($_POST[$item]['day'],2,'right','0') . '.' . dsf_format_fixed_length($_POST[$item]['month'],2,'right','0') . '.' . $_POST[$item]['year'];
											}elseif (DATE_FORMAT == 'M/D/Y'){
												$save_item = dsf_format_fixed_length($_POST[$item]['month'],2,'right','0') . '/' . dsf_format_fixed_length($_POST[$item]['day'],2,'right','0') . '/' . $_POST[$item]['year'];
											}elseif (DATE_FORMAT == 'M-D-Y'){
												$save_item = dsf_format_fixed_length($_POST[$item]['month'],2,'right','0') . '-' . dsf_format_fixed_length($_POST[$item]['day'],2,'right','0') . '-' . $_POST[$item]['year'];
											}elseif (DATE_FORMAT == 'M.D.Y'){
												$save_item = dsf_format_fixed_length($_POST[$item]['month'],2,'right','0') . '.' . dsf_format_fixed_length($_POST[$item]['day'],2,'right','0') . '.' . $_POST[$item]['year'];
											
											}elseif (DATE_FORMAT == 'Y/M/D'){
												$save_item = $_POST[$item]['year'] . '/' . dsf_format_fixed_length($_POST[$item]['month'],2,'right','0') . '/' . dsf_format_fixed_length($_POST[$item]['day'],2,'right','0');
											}elseif (DATE_FORMAT == 'Y-M-D'){
												$save_item = $_POST[$item]['year'] . '-' . dsf_format_fixed_length($_POST[$item]['month'],2,'right','0') . '-' . dsf_format_fixed_length($_POST[$item]['day'],2,'right','0');
											}elseif (DATE_FORMAT == 'Y.M.D'){
												$save_item = $_POST[$item]['year'] . '.' . dsf_format_fixed_length($_POST[$item]['month'],2,'right','0') . '.' . dsf_format_fixed_length($_POST[$item]['day'],2,'right','0');
											
											}else{
												$save_item = $_POST[$item]['year'] . '-' . dsf_format_fixed_length($_POST[$item]['month'],2,'right','0') . '-' . dsf_format_fixed_length($_POST[$item]['day'],2,'right','0');
											}
										}else{
												$save_item = $_POST[$item]['year'] . '-' . dsf_format_fixed_length($_POST[$item]['month'],2,'right','0') . '-' . dsf_format_fixed_length($_POST[$item]['day'],2,'right','0');
										}
									}else{
												$save_item = '';
												
									}
							
							
						}else{
							//standard field
							$save_item = $_POST[$item];
						}
						
						
						
						
						if ((int)$value['field_type_id'] == 14){ // check to see if we need to save signup information
							
							if ((int)$save_item == 1){	// box is ticked.
								$dsv_form_signup = 'true';
							}
							
						}
						
						
						
						// we have a post value therefore see if validation is fine.
						
							if ((int)$value['field_type_id'] == 11){
								
								$dsv_firstname = $save_item;
								
							}
							if ((int)$value['field_type_id'] == 12){
								
								$dsv_lastname = $save_item;
								
							}

						
						
						
						// check for product matrix
						
						
						if ((int)$value['field_type_id'] == 13){ // product matrix - value is in hardcoded field.
							
							$save_item = $_POST['ds_matrix_three'];
							
						}
						
						
						
						// check for valid email address
						
						if ((int)$value['field_type_id'] == 3){ 
							
							// only check if there is something in the field.
							if (strlen($save_item) > 1){
								
								if (dsf_validate_email($save_item) == false) {
									$messageStack->add(TRANSLATION_ERROR_EMAIL_ADDRESS , '<br />');
									$dsv_form_error = 'true';
								}
								
							$dsv_email = $save_item;

							}
							
						}
						
						
						// check for html problem.

								$html_error = false;
								
								$html_check = urldecode(strtolower($save_item)); // checks for our domain name within the email address given.
								$spoofcheck = substr_count($html_check, '<'); 
								if ($spoofcheck >0){
								// html found.
										$html_error = true;
								}
								
								$spoofcheck = substr_count($html_check, '>'); 
								if ($spoofcheck >0){
								// html found.
										$html_error = true;
								}
								
								if ($html_error == true){
									 $messageStack->add($value['field_text'] . ' : ' . TRANSLATION_HTML_ERROR , '<br />');
									$dsv_form_error = 'true';
								}


						
						
						// check min length issue but only if a required is set as true.   This was changed 2014-01-29 at Simons request,
						// previously a min length error would be created regardless of required field.
						
						
						if ($value['required'] == 'true'){
						
								if ($value['min_length'] > 0 && (strlen($save_item) < $value['min_length']) ){
									
									$messageStack->add($value['min_error'] . '<br />');
									$dsv_form_error = 'true';
		
								}
						}
						
						
						// check for required when we have a post item (some don't post for example tick boxes)  additionally we can't force a required
						// on an item with an other box as that may have a value in it.
						
						
						if (strlen($save_item) < 1 && $value['required'] == 'true'){
							
							 if ($value['other_allowed'] == 'true'){	
							
							
									// check to see if we have a post in the other field.
									
									$other_field = $item . '_other';
									
									if (isset($_POST[$other_field]) && strlen($_POST[$other_field]) > 0){
										// we have a value in the other field.
										$save_item = $_POST[$other_field];
										
										
									}else{
										// no value so create error.
											 $messageStack->add($value['other_error'] . '<br />');
											 $dsv_form_error = 'true';
										
									}
									
							
							
							
							 }else{
								 $messageStack->add($value['required_error'] . '<br />');
								 $dsv_form_error = 'true';
							 }
							 
							
						}
						
						
						
						
						
						
						
							$sql_data_array[$item] = $save_item;
					
						
						
						
					}else{
						
						// we don't have a post item. - check to see if it was a required item as if it was we need to do an error.
						
						
						if ((int)$value['field_type_id'] == 13){ // product matrix - value is in hardcoded field.
							
							$save_item = $_POST['ds_matrix_three'];
							
						}


						// date field size check
						
						
						
						// check for other field
						
						if (strlen($save_item) < 1 && $value['required'] == 'true'){
							
							 if ($value['other_allowed'] == 'true'){	
							
							
									// check to see if we have a post in the other field.
									
									$other_field = $item . '_other';
									
									if (isset($_POST[$other_field]) && strlen($_POST[$other_field]) > 0){
										// we have a value in the other field.
										
										$save_item = $_POST[$other_field];
										
										
									}else{
										// no value so create error.
											 $messageStack->add($value['other_error'] . '<br />');
											 $dsv_form_error = 'true';
									}
									
							
							
							
							 }else{
								 $messageStack->add($value['required_error'] . '<br />');
								 $dsv_form_error = 'true';
							 }
							 
							
						}
						
						
						
							if ((int)$value['field_type_id'] == 15){
									// h3 tag do not save.
							}elseif ((int)$value['field_type_id'] == 16){
									// paragraph tag do not save.
							}else{
								// valid field without an answer.
						
						
								$sql_data_array[$item] = $save_item;
							
							}
							
							
						
						
					} // end of checking for post item.
	
			} // end foreach dynamic form item.
			
			
			
			
			
			
			if ($dsv_form_error == 'false'){
				// we are fine to save the item.
				




						if ($dsv_form_signup == 'true'){
							
								// customer has subscribed to mailing list.
								  $save_data_array = array('customer_name' => $dsv_firstname . ' ' . $dsv_lastname,
														  'customer_firstname' => $dsv_firstname,
														  'customer_lastname' => $dsv_lastname,
														  'customer_email' => $dsv_email);
					
								// do a quick check on the email address
								  $check_email_query = dsf_db_query("select count(*) as total from " . DS_DB_SHOP . ".mailing_lists where customer_email = '" . dsf_db_input($dsv_email) . "'");
								  $check_email = dsf_db_fetch_array($check_email_query);
								  if (!$check_email['total']) { // email not already in system so add it.
										dsf_db_perform(DS_DB_SHOP . ".mailing_lists", $save_data_array);
								  }

						}
						
						
						
						
						
						
						
						
						// put the initial text into arrays that we can work with.
						
						
						if ($frm_results['customer_email'] == 1){
							// an email is required.
							
							$customers_email_text = $frm_results['customer_text'];
							$customers_email_subject = $frm_results['customer_subject'];
							
						}else{
							
							$customers_email_text = '';
							$customers_email_subject = '';
						}
						
						
						
						if ($frm_results['sitecopy_email'] == 1){
							// an email is required.
							
							$sitecopy_email_text = $frm_results['sitecopy_text'];
							$sitecopy_email_subject = $frm_results['sitecopy_subject'];
							$sitecopy_email_address = $frm_results['sitecopy_email_address'];
							
						}else{
							
							$sitecopy_email_text = '';
							$sitecopy_email_subject = '';
							$sitecopy_email_address = '';
						}
						
						

				// dsv_dynamic_form_success_text  (this is what we show as the results
						
						$dsv_dynamic_form_success_text = $frm_results['form_success_text'];



						
					// save the forms data into the forms_subscribed table.   at the same time put the variables and answers into the emails and success text.
					
					$data_text = '';
					
					reset($sql_data_array);
					
					foreach($sql_data_array as $id => $value){
						$data_text .= $id . '::' . $value . "\n";
						
						// replace text on the emails.
						$customers_email_text = str_replace('[' . $id . ']' , $value , $customers_email_text);
						$sitecopy_email_text = str_replace('[' . $id . ']' , $value , $sitecopy_email_text);
						$dsv_dynamic_form_success_text = str_replace('[' . $id . ']' , $value , $dsv_dynamic_form_success_text);
						
					}
					
					
						
					$save_data_array = array('form_id' => $dsv_dynamic_form_id,
											'results' => $data_text,
											'posted_data' => dsf_print_array($sql_data_array),
											'converted_text' => serialize($sql_data_array));
			
			
					$upd_frm = dsf_db_perform(DS_DB_SHOP . '.forms_subscribed', $save_data_array);
					
					$dsv_dynamic_form_unique_id = CONTENT_COUNTRY . LANGUAGE_URL_SUFFIX . dsf_db_insert_id();
			
					$dsv_dynamic_form_action = 'success';
				
					$dsv_dynamic_form_success_text = str_replace("[UNIQUE_ID]", $dsv_dynamic_form_unique_id, $dsv_dynamic_form_success_text);
					$dsv_dynamic_form_success_text = str_replace("[unique_id]", $dsv_dynamic_form_unique_id, $dsv_dynamic_form_success_text);
						
						
						
				// email routine here.
				
						
				if (isset($dsv_email) && strlen($dsv_email)>4){
					
					// we have a valid email address so see if there is a customer copy required.
					
							if ($frm_results['customer_email'] == 1){
								
								
								$client_name = '';
								if (isset($dsv_firstname) && strlen($dsv_firstname)> 0){
									$client_name .= $dsv_first_name . ' ';
								}
								
								if (isset($dsv_lastname) && strlen($dsv_lastname)> 0){
									$client_name .= $dsv_lastname . ' ';
								}
								
								$client_name = trim($client_name);
								
								
								$customers_email_subject = str_replace("[UNIQUE_ID]", $dsv_dynamic_form_unique_id, $customers_email_subject);
								$customers_email_subject = str_replace("[unique_id]", $dsv_dynamic_form_unique_id, $customers_email_subject);
								$customers_email_text = str_replace("[UNIQUE_ID]", $dsv_dynamic_form_unique_id, $customers_email_text);
								$customers_email_text = str_replace("[unique_id]", $dsv_dynamic_form_unique_id, $customers_email_text);
								
								
								
								
								
								dsf_send_email((strlen($client_name) > 0 ? $clent_name : $dsv_email), $dsv_email, $customers_email_subject, '', STORE_OWNER, EMAIL_FROM, $customers_email_text);
	
								
							}
							

					
					
				}
				
				
				// check for sitecopy email.
				
				
							if ($frm_results['sitecopy_email'] == 1){
								
								$sitecopy_email_subject = str_replace("[UNIQUE_ID]", $dsv_dynamic_form_unique_id, $sitecopy_email_subject);
								$sitecopy_email_subject = str_replace("[unique_id]", $dsv_dynamic_form_unique_id, $sitecopy_email_subject);
								$sitecopy_email_text = str_replace("[UNIQUE_ID]", $dsv_dynamic_form_unique_id, $sitecopy_email_text);
								$sitecopy_email_text = str_replace("[unique_id]", $dsv_dynamic_form_unique_id, $sitecopy_email_text);
								
								
								// check if we have a valid email address to send duplicate to in the email address.
								
								// otherwise send it to default receiving address.
								
								if (dsf_validate_email($sitecopy_email_address) == true){
									dsf_send_email(STORE_OWNER, $sitecopy_email_address, $sitecopy_email_subject, '', STORE_OWNER, EMAIL_FROM, $sitecopy_email_text);
								}else{
									dsf_send_email(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $sitecopy_email_subject, '', STORE_OWNER, EMAIL_FROM, $sitecopy_email_text);
								}
								
							}
				

				
				
			}
			
			

	  if ($messageStack->size() > 0) {
			$dsv_dynamic_form_error = $messageStack->output();
		}else{
			$dsv_dynamic_form_error = '';
	  }
	
	
	
} // end submission section checks.








// Parse the data used in the html tags to ensure the tags will not break
  function dsf_parse_input_field_data($data, $parse) {
    return strtr(trim($data), $parse);
  }

// ###

// 
  function dsf_output_string($string, $translate = false, $protected = false) {
    if ($protected == true) {
      return htmlspecialchars($string);
    } else {
      if ($translate == false) {
        return dsf_parse_input_field_data($string, array('"' => '&quot;'));
      } else {
        return dsf_parse_input_field_data($string, $translate);
      }
    }
  }

// ###

  function dsf_output_string_protected($string) {
    return dsf_output_string($string, false, true);
  }

// 

  function dsf_sanitize_string($string) {
    $string = str_replace(' +', ' ', trim($string));

    return preg_replace("/[<>]/", '_', $string);
  }

// ###



// Return a product's name
  function dsf_get_products_name($product_id) {
    $product_query = dsf_db_query("select sp.products_name as ov_products_name,  lp.products_name from " . DS_DB_SHOP . ".products sp left join " . DS_DB_LANGUAGE . ".products lp on (sp.products_id = lp.products_id) where sp.products_id = '" . (int)$product_id . "'");
    $product = dsf_db_fetch_array($product_query);

	if (strlen($product['ov_products_name']) > 0){
		$product_name = $product['ov_products_name'];
	}else{
		$product_name = $product['products_name'];
	}
	
    return $product_name;

  }
  
  
 // ###
  

////
// Return a product's special price (returns nothing if there is no offer)
  function dsf_get_products_special_price($product_id) {
    $product_query = dsf_db_query("select specials_new_products_price from " . DS_DB_SHOP . ".specials where products_id = '" . (int)$product_id . "' and status='1'");
    $product = dsf_db_fetch_array($product_query);

    if (isset($product['specials_new_products_price'])){
		$price = $product['specials_new_products_price'];
	}else{
		$price = false;
	}
	
	return $price;
  
  }

// ###



// Sets the status of a special product
  function dsf_set_specials_status($specials_id, $status) {
    return dsf_db_query("update " . DS_DB_SHOP . ".specials set status = '" . $status . "', date_status_change = now() where specials_id = '" . (int)$specials_id . "'");
  }

// ###

////
// Auto expire products on special
  function dsf_expire_specials() {
    $specials_query = dsf_db_query("select specials_id from " . DS_DB_SHOP . ".specials where status = '1' and now() >= expires_date and expires_date > 0");
    if (dsf_db_num_rows($specials_query)) {
      while ($specials = dsf_db_fetch_array($specials_query)) {
        dsf_set_specials_status($specials['specials_id'], '0');
      }
    }
  }

// ###



// update whos online

function dsf_update_whos_online() {
    global $customer_id, $spider_flag, $spider_name;

    if (dsf_session_is_registered('customer_id')) {
      $wo_customer_id = $customer_id;

      $customer_query = dsf_db_query("select customers_firstname, customers_lastname from " . DS_DB_SHOP . ".customers where customers_id = '" . (int)$customer_id . "'");
      $customer = dsf_db_fetch_array($customer_query);

      $wo_full_name = $customer['customers_firstname'] . ' ' . $customer['customers_lastname'];

	      	if ($spider_flag == true){
	  			$wo_full_name = 'Spider -' . $spider_name . ' ' . $customer_id;
			}


    } else {
      $wo_customer_id = '';
      	if ($spider_flag == true){
	  		$wo_full_name = 'Spider -' . $spider_name;
		}else{
	  		$wo_full_name = '';
		}
    }

    $wo_session_id = dsf_session_id();
	
    $wo_ip_address = (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '');
    $wo_last_page_url = (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '');
	$wo_previous_url = (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '');



    $current_time = time();
    $xx_mins_ago = ($current_time - 900);

// remove entries that have expired
    dsf_db_query("delete from " . DS_DB_SHOP . ".whos_online where time_last_click < '" . $xx_mins_ago . "'");

    $stored_customer_query = dsf_db_query("select count(*) as count from " . DS_DB_SHOP . ".whos_online where session_id = '" . dsf_db_input($wo_session_id) . "' and ip_address ='" . $wo_ip_address ."'");
    $stored_customer = dsf_db_fetch_array($stored_customer_query);

    if ((int)$stored_customer['count'] > 0) {
      dsf_db_query("update " . DS_DB_SHOP . ".whos_online set customer_id = '" . (int)$wo_customer_id . "', full_name = '" . dsf_db_input($wo_full_name) . "', ip_address = '" . dsf_db_input($wo_ip_address) . "', time_last_click = '" . dsf_db_input($current_time) . "', last_page_url = '" . dsf_db_input($wo_last_page_url) . "', hit_counter = hit_counter + 1 where session_id = '" . dsf_db_input($wo_session_id) . "' and ip_address = '" . dsf_db_input($wo_ip_address) . "'");
    } else {
      dsf_db_query("insert into " . DS_DB_SHOP . ".whos_online (customer_id, full_name, session_id, ip_address, time_entry, time_last_click, last_page_url) values ('" . (int)$wo_customer_id . "', '" . dsf_db_input($wo_full_name) . "', '" . dsf_db_input($wo_session_id) . "', '" . dsf_db_input($wo_ip_address) . "', '" . dsf_db_input($current_time) . "', '" . dsf_db_input($current_time) . "', '" . dsf_db_input($wo_last_page_url) . "')");
    }
  }



// ###


 ////
 // Returns a products stock where products_options are involved (products_attributes)
 function dsf_get_options_stock($products_id, $options_id){
 
 $product_info_query = dsf_db_query("select product_options_stock from " . DS_DB_SHOP . ".products where products_id='" . (int)$products_id . "'");
 $product_info = dsf_db_fetch_array($product_info_query);
 
 						$stock_counter =0;
						$product_items = explode("\n", $product_info['product_options_stock']);	// make seperate lines
					
					foreach($product_items as $pi) {
						$pa = explode("~" , $pi);		// make seperate arrays
						  $dosort = asort($pa);
						$pa_back='';
						
								// put it back together.
							foreach($pa as $individuals) {
										$pa_back .= '~' . $individuals;
							}
					
					$pa_back = trim(str_replace("~~","~",$pa_back));
					
					// seperate it into two fields for array
								$pitems = explode("~ZZZStock:" , $pa_back);
								
								$id=trim($pitems[0]);
								$text=trim($pitems[1]);
					
						if ($text) $stock_array[$id] = $text;
						$stock_counter ++;
					}
 return (int)$stock_array[$options_id];
 
 }


// ###




function dsf_add_campaign_result($products_id, $type, $campaign_id){
if ((!$products_id) || (!$type) || (!$campaign_id)){
	return false;
}

$current_year = date("Y");
$current_month = date("m");

          $sql_data_array = array('result_year'   => dsf_db_prepare_input($current_year),
                                  'campaign_id'  => dsf_db_prepare_input($campaign_id),
                                  'result_month'  => dsf_db_prepare_input($current_month),
								  'products_id' => dsf_db_prepare_input($products_id),
								  'result_action' => $type,
								  'ipnum' => dsf_get_ip_address());
     
          dsf_db_perform(DS_DB_SHOP . ".campaign_results", $sql_data_array);
}






  function dsf_get_products_stock($products_id) {
	
	
	$pieces = explode('}', $products_id);
	
		if (isset($pieces[1])){
		 // there are options
		// these are in the format products_id{option}value{option}value{option}value etc....
	
					$pieces = explode('{', $products_id);
					
					// gives us   	products_id
					//				firstitem}value
					//				seconditem}value etc.....
					
					// delete the first value (products_id)
					$products_id = trim($pieces[0]);
					$pieces[0] = '';
					
					// sort the array to make it the same order as the stock items from products.products_options_stock
					
					$temp_sort = asort($pieces);
					
					$checker_line='';
					
					foreach($pieces as $key => $value){
					
							if ($value){ // get rid of empty first item.
							$checker_line .= '~' . trim($value);
							}
					}

					$checker_line = str_replace("}",":",$checker_line);
			
					return dsf_get_options_stock($products_id, $checker_line);		
		
		 }else{
		 
				$products_id = dsf_get_prid($products_id);
				$stock_query = dsf_db_query("select products_quantity from " . DS_DB_SHOP . ".products where products_id = '" . (int)$products_id . "'");
				$stock_values = dsf_db_fetch_array($stock_query);
			
				return $stock_values['products_quantity'];
		}
  }


////
// Check if the required stock is available
// If insufficent stock is available return an out of stock message
  function dsf_check_stock($products_id, $products_quantity) {
    $stock_left = dsf_get_products_stock($products_id) - $products_quantity;
    $out_of_stock = '';

    if ($stock_left < 0) {
      $out_of_stock = '<span class="insufficientStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
		  if (dsf_get_products_stock($products_id) > 0){
		   $out_of_stock = '<span class="insufficientStock">' . STOCK_MARK_PRODUCT_INSUFFICIENT_STOCK . '<br>Only ' . dsf_get_products_stock($products_id) .' available</span>';
		  }
	}

    return $out_of_stock;
  }

// #######



////
// Return all GET variables, except those passed as a parameter
// useful when creating forms to post.
  function dsf_get_all_get_params($exclude_array = '') {

    if (!is_array($exclude_array)) $exclude_array = array();

// always add specifics to the exclude regardless.
	$exclude_array[] = 'dm_i';
	$exclude_array[] = 'icid';
	$exclude_array[] = 'Ref';
	$exclude_array[] = 'rr';
	$exclude_array[] = 'gclid';
	$exclude_array[] = 'rid';
	$exclude_array[] = 'cookie_implied';
	$exclude_array[] = 'cpgn';
	$exclude_array[] = 'slug';
	$exclude_array[] = 'x';
	$exclude_array[] = 'y';
	$exclude_array[] = 'othername';
	
    $get_url = '';
    if (is_array($_GET) && (sizeof($_GET) > 0)) {
      reset($_GET);
      while (list($key, $value) = each($_GET)) {
        if ( (strlen($value) > 0) && ($key != dsf_session_name()) && ($key != 'error') && (!in_array($key, $exclude_array)) ) {
          $get_url .= $key . '=' . rawurlencode(stripslashes($value)) . '&';
        }
      }
    }

    return $get_url;
  }



// ###




// Returns an array with countries,  we address the local language file for the name as that may be different
// to the master file,   for example  Germany and Deutsland


  function dsf_get_countries($countries_id=0) {
    $countries_array = array();
    
	if ((int)$countries_id > 0) {
        $countries = dsf_db_query("select m.country_id, m.country_iso_code_2, m.country_iso_code_3, l.country_name from " . DS_DB_LANGUAGE . ".country_names l left join " . DS_DB_MASTER . ".countries m on (l.country_id = m.country_id) where l.country_id = '" . (int)$countries_id . "' order by l.country_name");


    } else {
      $countries = dsf_db_query("select m.country_id, m.country_iso_code_2, m.country_iso_code_3, l.country_name from " . DS_DB_LANGUAGE . ".country_names l left join " . DS_DB_MASTER . ".countries m on (l.country_id = m.country_id) order by l.country_name");

	}
			  while ($countries_values = dsf_db_fetch_array($countries)) {
				$countries_array[] = array('countries_id' => $countries_values['country_id'],
										'countries_name' => $countries_values['country_name'],
										 'countries_iso_code_2' => $countries_values['country_iso_code_2'],
										 'countries_iso_code_3' => $countries_values['country_iso_code_3']);
			  }


    return $countries_array;
  }

// ####


////
// 
  function dsf_get_country_name($country_id) {
        $countries = dsf_db_query("select country_name from " . DS_DB_MASTER . ".countries where country_id = '" . (int)$country_id . "'");
		$countries_values = dsf_db_fetch_array($countries);


    return $countries_values['country_name'];
  }


// ###

////
// Creates a pull-down list of countries

  function dsf_country_list($name, $selected = '', $parameters = '', $iclass='', $country_id=0) {
     $countries_array = array();
   	 
	 // make decision of whether a specific country_id is being requested.
	 
	 if ((int)$country_id > 0){
	 
	 		$countries = dsf_get_countries($country_id);
	 }else{
		 
	 		$countries = dsf_get_countries();
	 }
	 
	 
	 
	 
    if (is_array($countries) && sizeof($countries) > 0){
					// we have to do a slightly different rountine to break them up.
				foreach ($countries as $id => $value) {
					$countries_array[] = array('id' => $value['countries_id'], 'text' => $value['countries_name']);
				}
	}


	
    return dsf_form_dropdown($name, $countries_array, $selected, $parameters, $iclass);
  }



// ###


////
// round a number to decimal places
  function dsf_round($number, $precision) {
    if (strpos($number, '.') && (strlen(substr($number, strpos($number, '.')+1)) > $precision)) {
      $number = substr($number, 0, strpos($number, '.') + 1 + $precision + 1);

      if (substr($number, -1) >= 5) {
        if ($precision > 1) {
          $number = substr($number, 0, -1) + ('0.' . str_repeat(0, $precision-1) . '1');
        } elseif ($precision == 1) {
          $number = substr($number, 0, -1) + 0.1;
        } else {
          $number = substr($number, 0, -1) + 1;
        }
      } else {
        $number = substr($number, 0, -1);
      }
    }

    return $number;
  }

// ###



////
// Returns the vat rate
  function dsf_get_tax_rate($class_id=0) {
    global $dsv_master_country_id;


		$tax_multiplier = 0;
		  
	if ((int)$dsv_master_country_id > 0){

			// get the tax rate from the database - first make sure we are supplied a class_id between 1 and 5 or the field request will fail with db error
			if ((int)$class_id > 0 && (int)$class_id < 6){
				
					$rfield = 'tax_rate_' . (int)$class_id;
					$query = dsf_db_query("select " . $rfield . " from " . DS_DB_MASTER . ".countries where country_id='" . $dsv_master_country_id . "'");
					$results = dsf_db_fetch_array($query);
					$tax_multiplier = $results[$rfield];
					
			}
	}
	
	return $tax_multiplier;
		
  }


// ###



function dsf_get_default_vat_rate(){
    global $dsv_master_country_id;


		$tax_multiplier = 0;
		  
	if ((int)$dsv_master_country_id > 0){

			// get the first tax rate from the database
					$rfield = 'tax_rate_1';
					$query = dsf_db_query("select " . $rfield . " from " . DS_DB_MASTER . ".countries where country_id='" . $dsv_master_country_id . "'");
					$results = dsf_db_fetch_array($query);
					$tax_multiplier = $results[$rfield];
	}
	
	return $tax_multiplier;
		
  }



// ###





////
// Return the tax description for a class
  function dsf_get_tax_description($class_id) {
 
     global $dsv_master_country_id;


		$tax_description = 'VAT';
		  
	if ((int)$dsv_master_country_id > 0){

			// get the tax rate from the database - first make sure we are supplied a class_id between 1 and 5 or the field request will fail with db error
			if ((int)$class_id > 0 && (int)$class_id < 6){
				
					$rfield = 'tax_rate_' . (int)$class_id . '_desc';
					$query = dsf_db_query("select " . $rfield . " from " . DS_DB_MASTER . ".countries where country_id='" . $dsv_master_country_id . "'");
					$results = dsf_db_fetch_array($query);
					$tax_description = $results[$rfield];
					
			}
	}
	
	return $tax_description;

  }


// ###


////
// Add tax to a products price to 4 decimal places
  function dsf_add_tax($price, $tax) {
 
      return dsf_round($price, 4) + dsf_calculate_tax($price, $tax);
  }

// ###


// Calculates Tax rounding the result to 4 decimal places
  function dsf_calculate_tax($price, $tax) {

    return dsf_round($price * $tax / 100, 4);
  }


// ###


////
// Return the number of products in a category
  function dsf_count_products_in_category($category_id, $include_inactive = false) {
    $products_count = 0;
    if ($include_inactive == true) {
      $products_query = dsf_db_query("select count(p.products_id) as total from " . DS_DB_SHOP . ".products p left join " . DS_DB_SHOP . ".products_to_categories p2c on (p.products_id = p2c.products_id) where p2c.categories_id = '" . (int)$category_id . "'");
    } else {
      $products_query = dsf_db_query("select count(p.products_id) as total from " . DS_DB_SHOP . ".products p left join " . DS_DB_SHOP . ".products_to_categories p2c on (p.products_id = p2c.products_id) where p.products_status = '1' and p2c.categories_id = '" . (int)$category_id . "'");
    }
    $products = dsf_db_fetch_array($products_query);
    $products_count += $products['total'];

    $child_categories_query = dsf_db_query("select categories_id from " . DS_DB_SHOP . ".categories where parent_id = '" . (int)$category_id . "'");
    if (dsf_db_num_rows($child_categories_query)) {
      while ($child_categories = dsf_db_fetch_array($child_categories_query)) {
        $products_count += dsf_count_products_in_category($child_categories['categories_id'], $include_inactive);
      }
    }

    return $products_count;
  }

// ###


////
// Return the number of parts in a category 
  function dsf_count_products_parts_in_category($category_id, $include_inactive = false) {
    $products_count = 0;
    if ($include_inactive == true) {
      $products_query = dsf_db_query("select count(p.products_id) as total from " . DS_DB_SHOP . ".products_parts p left join " . DS_DB_SHOP . ".products_parts_to_categories_parts p2c on (p.products_id = p2c.products_id) where p2c.categories_id = '" . (int)$category_id . "'");
    } else {
      $products_query = dsf_db_query("select count(p.products_id) as total from " . DS_DB_SHOP . ".products_parts p left join " . DS_DB_SHOP . ".products_parts_to_categories_parts p2c on (p.products_id = p2c.products_id) where p.products_status = '1' and p2c.categories_id = '" . (int)$category_id . "'");
    }
    $products = dsf_db_fetch_array($products_query);
    $products_count += $products['total'];

    $child_categories_query = dsf_db_query("select categories_id from " . DS_DB_SHOP . ".categories_parts where parent_id = '" . (int)$category_id . "'");
    if (dsf_db_num_rows($child_categories_query)) {
      while ($child_categories = dsf_db_fetch_array($child_categories_query)) {
        $products_count += dsf_count_products_parts_in_category($child_categories['categories_id'], $include_inactive);
      }
    }

    return $products_count;
  }


// ###

// Return true if the category has subcategories
  function dsf_has_category_subcategories($category_id) {
    $child_category_query = dsf_db_query("select count(categories_id) as count from " . DS_DB_SHOP . ".categories where parent_id = '" . (int)$category_id . "' and categories_status='1'");
    $child_category = dsf_db_fetch_array($child_category_query);

    if ($child_category['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }


// ###


  function dsf_invoice_address_label($customers_id, $html = false) {
    $address_query = dsf_db_query("select invoice_name as name, invoice_company as company, invoice_house as house, invoice_street as street, invoice_district as district, invoice_town as town, invoice_county as county, invoice_postcode as postcode, invoice_country as country_id from " . DS_DB_SHOP . ".customers_addresses where customers_id = '" . (int)$customers_id . "'");
    $address = dsf_db_fetch_array($address_query);

    return dsf_address_format($address, ($html == true ? '<br />' : ''));
  }

// ###

  function dsf_delivery_address_label($customers_id, $html = false) {
    $address_query = dsf_db_query("select delivery_name as name, delivery_company as company, delivery_house as house, delivery_street as street, delivery_district as district, delivery_town as town, delivery_county as county, delivery_postcode as postcode, delivery_country as country_id from " . DS_DB_SHOP . ".customers_addresses where customers_id = '" . (int)$customers_id . "'");
    $address = dsf_db_fetch_array($address_query);

    return dsf_address_format($address, ($html == true ? '<br />' : ''));
  }

// ###

// 


  function dsf_address_format($address, $eoln = "\n") {
	  global $dsv_master_country_id;
	  
	  
	  $query = dsf_db_query("select country_address_format from " . DS_DB_MASTER . ".countries where country_id='" . $dsv_master_country_id . "'");
	  $results = dsf_db_fetch_array($query);
	  
	  
	  
	  $return_address = $results['country_address_format'];
	  
	  // address is passed to us as an array therefore all we need to do is to get the addrses format from the master countries table
	  // and then do some find and replaces.
	  

	/* things to replace are:
	[COMPANY]
	[NAME]
	[HOUSE]
	[STREET]
	[DISTRICT]
	[TOWN]
	[COUNTY]
	[POSTCODE]
	[COUNTRY]
	
	

	*/

    $company = dsf_output_string_protected($address['company']);
    $name = dsf_output_string_protected($address['name']);
	$house = dsf_output_string_protected($address['house']);
	$street = dsf_output_string_protected($address['street']);
    $district = dsf_output_string_protected($address['district']);
    $town = dsf_output_string_protected($address['town']);
    $county = dsf_output_string_protected($address['county']);
    $postcode = dsf_output_string_protected($address['postcode']);
	
    if (isset($address['country_id']) && dsf_not_null($address['country_id'])) {
      $country = dsf_get_country_name($address['country_id']);
    } elseif (isset($address['country']) && dsf_not_null($address['country'])) {
      $country = dsf_output_string_protected($address['country']);
    } else {
      $country = '';
    }
	
	
	$return_address = str_replace(array('[COMPANY]' , '[NAME]' , '[HOUSE]' , '[STREET]' , '[DISTRICT]' , '[TOWN]' , '[COUNTY]' , '[POSTCODE]' , '[COUNTRY]'),
								  array($company, $name, $house, $street, $district, $town, $county, $postcode, $country), $return_address);
								  
	
	
	// now the values are replaced,  we need to remove any blank lines and then put it all back together again.
	
	$ad_split = explode("\n" , $return_address);
	$new_address = '';
	
	foreach($ad_split as $item){
		if (strlen($item) > 2){
			$new_address .= $item . "\n";
		}
	}
	

// last but not least,  we make a decision on how the information is to be returned based on the eoln field.

if ($eoln == '<br />'){
	$return_address = str_replace("\n" , "<br />" , $new_address);
}else{
	$return_address = $new_address;
}



    return $return_address;
  }


// ###



function dsf_leading_zero($value){
		if ((int)$value <10){
			$new_value ='0' . $value;
		}else{
			$new_value = $value;
		}
		return $new_value;
}

// ###


function dsf_format_fixed_length($text='', $length='', $align='left',$seperator=' '){
   $n = mb_strlen($text, 'utf-8');
   $req_n = (int)$length;
   $req_align = $align;
   $filler = $req_n - $n;
   
   
   if ($n < $req_n){
   			if ($align == "right"){
				$text = str_repeat($seperator, $filler) . $text ;
			}else{
				$text .= str_repeat($seperator, $filler);
			}
   }

	$text = mb_substr($text,0,$req_n, 'utf-8');

return $text;
}


// ####


// Return all subcategory IDs
  function dsf_get_subcategories(&$subcategories_array, $parent_id = 0) {
    $subcategories_query = dsf_db_query("select categories_id from " . DS_DB_SHOP . ".categories where parent_id = '" . (int)$parent_id . "'");
    while ($subcategories = dsf_db_fetch_array($subcategories_query)) {
      $subcategories_array[sizeof($subcategories_array)] = $subcategories['categories_id'];
      if ($subcategories['categories_id'] != $parent_id) {
        dsf_get_subcategories($subcategories_array, $subcategories['categories_id']);
      }
    }
  }


// ###


// Output a raw date string in the selected locale date format
// $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS
  function dsf_date_long($raw_date) {
    if ( ($raw_date == '0000-00-00 00:00:00') || ($raw_date == '') ) return false;

    $year = (int)substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);

    return strftime(DATE_FORMAT_LONG, mktime($hour,$minute,$second,$month,$day,$year));
  }

// ###


////
// Output a raw date string in the selected locale date format
// $raw_date needs to be in this format: YYYY-MM-DD HH:MM:SS

  function dsf_date_short($raw_date) {
    if ( ($raw_date == '0000-00-00 00:00:00') || empty($raw_date) ) return false;

    $year = substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);

    if (@date('Y', mktime($hour, $minute, $second, $month, $day, $year)) == $year) {
		
		
		if (defined('DATE_FORMAT') && strlen(DATE_FORMAT) > 3){
		
		// make d and m lowercase
			$dte_format = str_replace(array('D','M') , array('d','m') , DATE_FORMAT);
			
		}else{
			$dte_format = 'd/m/Y';
		}
		
		
		
		
		
      return date($dte_format, mktime($hour, $minute, $second, $month, $day, $year));
		
    } else {
      return '';
    }
  }

// ###


  function dsf_time_and_date($raw_date) {
    if ( ($raw_date == '0000-00-00 00:00:00') || empty($raw_date) ) return false;

    $year = substr($raw_date, 0, 4);
    $month = substr($raw_date, 5, 2);
    $day = substr($raw_date, 8, 2);
    $hour = substr($raw_date, 11, 2);
    $minute = substr($raw_date, 14, 2);
    $second = substr($raw_date, 17, 2);

    return $day . '/' . $month . '/' . $year . ' - ' . $hour . ':' . $minute . ':' . $second;
	
	
  }

// ###

function dsf_date_raw($date, $reverse = false) {
  if ($reverse) {
    return substr($date, 0, 2) . substr($date, 3, 2) . substr($date, 6, 4);
  } else {
    return substr($date, 6, 4) . substr($date, 3, 2) . substr($date, 0, 2);
  }
}

// ###

// Check if year is a leap year
  function dsf_is_leap_year($year) {
    if ($year % 100 == 0) {
      if ($year % 400 == 0) return true;
    } else {
      if (($year % 4) == 0) return true;
    }

    return false;
  }


// ###


// Return a product ID with attributes
  function dsf_get_uprid($prid, $params, $cprid='', $lprid='', $bprid='') {
    $uprid = $prid;
 
 
    if ( (is_array($params)) && (!strstr($prid, '{')) ) {
      while (list($option, $value) = each($params)) {
        $uprid = $uprid . '{' . $option . '}' . $value;
      }

    }

	// warranty
	if ($cprid && (!strstr($prid, '{'))){
		$uprid = $uprid . '{999}' . $cprid;
	}
	
	// lamp
	if ($lprid && (!strstr($prid, '{'))){
		$uprid = $uprid . '{998}' . $lprid;
	}

	// bracket
	if ($bprid && (!strstr($prid, '{'))){
		$uprid = $uprid . '{997}' . $bprid;
	}

	
    return $uprid;
  }


// ###


////
// Return a product ID from a product ID with attributes
  function dsf_get_prid($uprid) {
    $pieces = explode('{', $uprid);

    return $pieces[0];
  }

// ###


// check if a product has attributes

  function dsf_has_product_attributes($products_id) {
    $attributes_query = dsf_db_query("select count(products_attributes_id) as count from " . DS_DB_SHOP . ".products_attributes where products_id = '" . (int)$products_id . "'");
    $attributes = dsf_db_fetch_array($attributes_query);

    if ($attributes['count'] > 0) {
      return true;
    } else {
      return false;
    }
  }

// ###


// check for null or empty variable
  function dsf_not_null($value) {
    if (is_array($value)) {
      if (sizeof($value) > 0) {
        return true;
      } else {
        return false;
      }
    } else {
      if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
        return true;
      } else {
        return false;
      }
    }
  }

// ###


// Return a random value
  function dsf_rand($min = null, $max = null) {
    static $seeded;

    if (!isset($seeded)) {
      mt_srand((double)microtime()*1000000);
      $seeded = true;
    }

    if (isset($min) && isset($max)) {
      if ($min >= $max) {
        return $min;
      } else {
        return mt_rand($min, $max);
      }
    } else {
      return mt_rand();
    }
  }


// ###

  function dsf_setcookie($name, $value = '', $expire = 0, $path = '/', $domain = '', $secure = 0) {
    setcookie($name, $value, $expire, $path, (dsf_not_null($domain) ? $domain : ''), $secure);
  }


// ###



    function dsf_get_products_short($product_id) {

    $product_query = dsf_db_query("select sp.products_short as ov_products_short, lp.products_short from " . DS_DB_SHOP . ".products sp left join " . DS_DB_LANGUAGE . ".products lp on (sp.products_id = lp.products_id) where sp.products_id = '" . $product_id . "'");
    $product = dsf_db_fetch_array($product_query);


	if (isset($product['ov_products_short']) && strlen($product['ov_products_short']) > 0){
		
			$newproduct_desc = $product['ov_products_short'];
	}else{
			$newproduct_desc = $product['products_short'];
	}
	
    return $newproduct_desc;
  }


// ###


  // Return a product's price
  function dsf_get_products_price($product_id) {

    $product_query = dsf_db_query("select products_price from " . DS_DB_SHOP . ".products where products_id = '" . $product_id . "'");
    $product = dsf_db_fetch_array($product_query);

    return $product['products_price'];
  }

// ###

// Return a product's tax class
  function dsf_get_products_tax_class_id($product_id) {

    $product_query = dsf_db_query("select products_tax_class_id from " . DS_DB_SHOP . ".products where products_id = '" . $product_id . "'");
    $product = dsf_db_fetch_array($product_query);

    return $product['products_tax_class_id'];
  }


// ###



function dsf_get_products_image($product_id){
			$products_query = dsf_db_query("SELECT sp.category_image as ov_category_image, sp.products_name as ov_products_name, lp.category_image,  lp.products_name FROM " . DS_DB_SHOP .".products sp left join " . DS_DB_LANGUAGE . ".products lp on (sp.products_id = lp.products_id)  WHERE sp.products_id = '". $product_id . "'");
			$products = dsf_db_fetch_array($products_query);


			if (isset($products['ov_category_image']) && strlen($products['ov_category_image']) > 1){
				$category_image = $products['ov_category_image'];
			}elseif (isset($products['category_image']) && strlen($products['category_image']) > 1){
				$category_image = $products['category_image'];
			}else{
				$category_image = 'error_noimageavailable.gif';
			}
			
			
			if (isset($products['ov_products_name']) && strlen($products['ov_products_name']) > 1){
				$products_name = $products['ov_products_name'];
			}else{
				$products_name = $products['products_name'];
			}
				
				
		$theimage = dsf_thumb_image($category_image, $products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);



return $theimage;
}


// ###

function dsf_get_basket_image($product_id, $iwidth='', $iheight=''){

if (!$iwidth) $iwidth = BASKET_IMAGE_WIDTH;
if (!$iheight) $iheight = BASKET_IMAGE_HEIGHT;


			$products_query = dsf_db_query("SELECT sp.category_image as ov_category_image, sp.products_name as ov_products_name, lp.category_image,  lp.products_name FROM " . DS_DB_SHOP .".products sp left join " . DS_DB_LANGUAGE . ".products lp on (sp.products_id = lp.products_id)  WHERE sp.products_id = '". $product_id . "'");
			$products = dsf_db_fetch_array($products_query);


			if (isset($products['ov_category_image']) && strlen($products['ov_category_image']) > 1){
				$category_image = $products['ov_category_image'];
			}elseif (isset($products['category_image']) && strlen($products['category_image']) > 1){
				$category_image = $products['category_image'];
			}else{
						if (file_exists(DS_IMAGES_FOLDER . LANGUAGE_URL_SUFFIX . '_error_noimageavailable.png')){
								$category_image = LANGUAGE_URL_SUFFIX . '_error_noimageavailable.png';
						}else{
								$category_image = LANGUAGE_URL_SUFFIX . '_error_noimageavailable.gif';
						}
			}
			
			
			if (isset($products['ov_products_name']) && strlen($products['ov_products_name']) > 1){
				$products_name = $products['ov_products_name'];
			}else{
				$products_name = $products['products_name'];
			}
				
				
		$theimage = dsf_thumb_image(DS_IMAGES_FOLDER . $category_image, $products_name, $iwidth, $iheight);



return $theimage;
}

// ###

  function dsf_get_product_category($products_id) {

    $category_query = dsf_db_query("select products_main_cat from " . DS_DB_SHOP . ".products where products_id = '" . (int)$products_id . "'");
      $category = dsf_db_fetch_array($category_query);

      $dsv_category_id = $category['products_main_cat'];

    return $dsv_category_id;
  }

// ###


 function dsf_get_category_name($cat_id){
  $category_query = dsf_db_query("select sp.categories_name as ov_categories_name,  lp.categories_name from " . DS_DB_SHOP . ".categories sp left join " . DS_DB_LANGUAGE . ".categories lp on (sp.categories_id = lp.categories_id) where sp.categories_id ='" . (int)$cat_id . "'");
  $category = dsf_db_fetch_array($category_query);
  
			if (isset($category['ov_categories_name']) && strlen($category['ov_categories_name']) > 1){
				$categories_name = $category['ov_categories_name'];
			}else{
				$categories_name = $category['categories_name'];
			}
  
  return $categories_name;
  }


// ###



  function dsf_get_products_model($product_id) {

    $product_query = dsf_db_query("select sp.products_model as ov_products_model,  lp.products_model from " . DS_DB_SHOP . ".products sp left join " . DS_DB_LANGUAGE . ".products lp on (sp.products_id = lp.products_id) where sp.products_id = '" . (int)$product_id . "'");
    $product = dsf_db_fetch_array($product_query);

			if (isset($product['ov_products_model']) && strlen($product['ov_products_model']) > 1){
				$products_model = $product['ov_products_model'];
			}else{
				$products_model = $product['products_model'];
			}
	return $products_model;

 }

// ###


function dsf_find_attributes_stock($product_id, $attribute){

$product_sql_query = dsf_db_query("select product_options_stock from " . DS_DB_SHOP . ".products where products_id='" . (int)$product_id . "'");
$product_sql = dsf_db_fetch_array($product_sql_query);

				// split the products options stock variable into an array to sort it alpha and then to put it into two arrays.
				
						$stock_counter =0;
						$product_items = explode("\n", $product_sql['product_options_stock']);	// make seperate lines
					
					foreach($product_items as $pi) {
						$pa = explode("~" , $pi);		// make seperate arrays
						  $dosort = asort($pa);
						$pa_back='';
						
									// put it back together.
								foreach($pa as $individuals) {
											$pa_back .= '~' . $individuals;
								}
					
						$pa_back = trim(str_replace("~~","~",$pa_back));
					
					// seperate it into two fields for array
								$pitems = explode("~ZZZStock:" , $pa_back);
								
								$id=trim($pitems[0]);
								$text=trim($pitems[1]);
					
						if ($pitems[0] == $attribute){
							return $pitems[1];
							break;
						}
						
						// if ($text) $stock_array[$id] = $text;
						// $stock_counter ++;
					}
// return $stock_array;

}


function dsf_update_attributes_stock($product_id, $item_line, $previous_stock, $new_stock){


$product_sql_query = dsf_db_query("select product_options_stock from " . DS_DB_SHOP . ".products where products_id='" . (int)$product_id . "'");
$product_sql = dsf_db_fetch_array($product_sql_query);

$new_stock_text = $product_sql['product_options_stock'];

$calculated_previous_line = $item_line . '~ZZZStock:' . $previous_stock;
$calculated_new_line = $item_line . '~ZZZStock:' . $new_stock;
$new_stock_text = str_replace($calculated_previous_line, $calculated_new_line, $new_stock_text);
 
 
	dsf_db_query("update " . DS_DB_SHOP . ".products set product_options_stock = '" . $new_stock_text . "' where products_id = '" . $product_id . "'");

}



// ###


function dsf_stock_value($p_id){

						  if (dsf_find_attributes($p_id) == 'true'){
						  		// there are attributes, get default options.
								 $created_attrib_lookup = $p_id;
								 
										  $p_o_n = dsf_db_query("select distinct popt.products_options_id, popt.products_options_name from " . DS_DB_SHOP . ".products_options popt, " . DS_DB_SHOP . ".products_attributes patrib where patrib.products_id='" . (int)$p_id . "' and patrib.options_id = popt.products_options_id");
										  while ($p_o_n_v = dsf_db_fetch_array($p_o_n)) { 
											$created_attrib_lookup .= '{' . $p_o_n_v['products_options_id'] . '}'; 
											$p_o = dsf_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix from " . DS_DB_SHOP . ".products_attributes pa, " . DS_DB_SHOP . ".products_options_values pov where pa.products_id = '" . $p_id . "' and pa.options_id = '" . $p_o_n_v['products_options_id'] . "' and pa.options_values_id = pov.products_options_values_id order by pa.default_item, pov.products_options_values_name limit 1");
											while ($p_o_v = dsf_db_fetch_array($p_o)) {
											  $created_attrib_lookup .= $p_o_v['products_options_values_id'];
											}
										  }
								$new_stock = dsf_get_products_stock($created_attrib_lookup, '1');
						  
						  }else{
							$new_stock = dsf_get_products_stock($p_id, '1');
						  }
return $new_stock;
}


// ###

function dsf_stock_parts_value($p_id){
		$new_stock = dsf_get_products_parts_stock($p_id, '1');

return $new_stock;
}


// ###


function dsf_get_products_parts_stock($products_id) {
	
		 
				$products_id = dsf_get_prid($products_id);
				$stock_query = dsf_db_query("select products_quantity from " . DS_DB_SHOP . ".products_parts where products_id = '" . (int)$products_id . "'");
				$stock_values = dsf_db_fetch_array($stock_query);
			
				return $stock_values['products_quantity'];
  }



// ###

function dsf_find_attributes($product_id){
	$products_attributes = dsf_db_query("select popt.products_options_name from " . DS_DB_SHOP . ".products_options popt, " . DS_DB_SHOP . ".products_attributes patrib where patrib.products_id='" . $product_id . "' and patrib.options_id = popt.products_options_id");
	if (dsf_db_num_rows($products_attributes)>0) {
	  return 'true';
	} else {
	  return 'false';
	}
}



// ###



function dsf_lookup_mobile($customer_id){
$cust_query = dsf_db_query("select customers_mobile from " . DS_DB_SHOP . ".customers where customers_id ='" . (int)$customer_id . "'");
$cust_details = dsf_db_fetch_array($cust_query);

return $cust_details['customers_mobile'];
}


// ###


function dsf_get_actual_price($products_id){
        $listing_sql = dsf_db_query("select p.products_id, p.products_tax_class_id, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price from " . DS_DB_SHOP . ".products p left join " . DS_DB_SHOP . ".specials s on (p.products_id = s.products_id) where p.products_id='" . (int)$products_id ."'");
		$listing = dsf_db_fetch_array($listing_sql);
		
		return array('tax' => $listing['products_tax_class_id'],
					 'price' => $listing['final_price']);
}


// ###



function dsf_get_products_breadcrumb_tree($categories_id, $loopstopper = 1, $required_name ='', $range_id=0, $ignore_top=0){
		
		// prevent problems with url if categories id is not set but range id is.
		
		if ((int)$categories_id == 0 && (int)$range_id > 0){
				// do range only
			
			$categories_query = dsf_db_query("SELECT sr.range_name as ov_range_name, lr.range_name FROM " . DS_DB_SHOP . ".ranges sr left join " . DS_DB_LANGUAGE . ".ranges lr on (sr.range_id = lr.range_id) WHERE sr.range_id = '". $range_id . "'");
			$categories = dsf_db_fetch_array($categories_query);


			if (isset($catgories['ov_range_name']) && strlen($categories['ov_range_name']) > 1){
				$range_name = $categories['ov_range_name'];
			}else{
				$range_name = $categoreis['range_name'];
			}
			



			$required_name = '<li><a href="' . dsf_range_url($range_id) . '">' .$range_name . '</a>' . BREADCRUMB_SEPERATOR . '</li>' . $required_name;
				
				
		}else{
			// standard routine
								$categories_query = dsf_db_query("SELECT sc.categories_id, sc.parent_id, sc.categories_name as ov_categories_name, lc.categories_name FROM " . DS_DB_SHOP .".categories sc left join " . DS_DB_LANGUAGE . ".categories lc on (sc.categories_id = lc.categories_id)  WHERE sc.categories_id = '". (int)$categories_id . "'");
								$categories = dsf_db_fetch_array($categories_query);
				
				
								if (isset($categories['ov_categories_name']) && strlen($categories['ov_categories_name']) > 1){
									$category_name = $categories['ov_categories_name'];
								}else{
									$category_name = $categories['categories_name'];
								}
				
				
					if ($categories['parent_id'] ==0){
					  
					  if ($ignore_top == 1){ 
					  	// not putting upper item in so leave required name as it was before.
						  }else{
						  
						   if ($required_name){
								$required_name = '<li><a href="' . dsf_category_url($categories['categories_id'], '','',true,$range_id) . '">' .$category_name . '</a>' .  BREADCRUMB_SEPERATOR . '</li>' . $required_name;
						   }else{
								$required_name = '<li><a href="' . dsf_category_url($categories['categories_id'], '','',true,$range_id) . '">' . $category_name . '</a></li>';
						   }
					   
					   }
					   
					 }else{
						$loopstopper ++;
							if ($loopstopper < 6) { // max 4 links down, stops loops on rouge unlinked categories.
			
									if($required_name){
														$required_name = dsf_get_products_breadcrumb_tree ($categories['parent_id'], $loopstopper, '<li><a href="' . dsf_category_url($categories['categories_id'], '','',true,$range_id) . '">' . $category_name . '</a>'  . BREADCRUMB_SEPERATOR . '</li>' .  $required_name, $range_id, $ignore_top);
									}else{
														$required_name = dsf_get_products_breadcrumb_tree ($categories['parent_id'], $loopstopper, '<li><a href="' . dsf_category_url($categories['categories_id'], '','',true,$range_id) . '">' . $category_name . '</a></li>',$range_id,$ignore_top);
									}
							}
					}
		}

return $required_name;
}

// ###


function dsf_get_level_breadcrumb_tree($categories_id, $loopstopper = 1, $required_name =''){
					
								$categories_query = dsf_db_query("SELECT sc.categories_id, sc.parent_id, sc.categories_name as ov_categories_name, lc.categories_name FROM " . DS_DB_SHOP .".categories sc left join " . DS_DB_LANGUAGE . ".categories lc on (sc.categories_id = lc.categories_id)  WHERE sc.categories_id = '". (int)$categories_id . "'");
								$categories = dsf_db_fetch_array($categories_query);
		
								if (isset($categories['ov_categories_name']) && strlen($categories['ov_categories_name']) > 1){
									$category_name = $categories['ov_categories_name'];
								}else{
									$category_name = $categories['categories_name'];
								}
				

			if ($categories['parent_id'] ==0){
			   if ($required_name){
			   		$required_name = $categories['categories_id']. ':' . $required_name;
			   }else{
			   		$required_name = $categories['categories_id'] . ':';
			   }
			 }else{
			    $loopstopper ++;
					if ($loopstopper < 6) { // max 4 links down, stops loops on rouge unlinked categories.
	
							if($required_name){
												$required_name = dsf_get_level_breadcrumb_tree ($categories['parent_id'], $loopstopper, $categories['categories_id'] . ':' . $required_name);
							}else{
												$required_name = dsf_get_level_breadcrumb_tree ($categories['parent_id'], $loopstopper, $categories['categories_id'] . ':');
							}
					}
			}
			
return $required_name;
}

// ###


 function dsf_get_category_title($cat_id){
  
	$categories_title = '';

								$categories_query = dsf_db_query("SELECT sc.categories_id, sc.parent_id, sc.categories_title as ov_categories_title, lc.categories_title FROM " . DS_DB_SHOP .".categories sc left join " . DS_DB_LANGUAGE . ".categories lc on (sc.categories_id = lc.categories_id)  WHERE sc.categories_id = '". (int)$cat_id . "'");
								$categories = dsf_db_fetch_array($categories_query);
		
								if (isset($categories['ov_categories_title']) && strlen($categories['ov_categories_title']) > 1){
									$categories_title = $categories['ov_categories_title'];
								}else{
									$categories_title = $categories['categories_title'];
								}



  return $categories_title;
  }

// ###



// return a categories menu image if it exists.
function dsf_category_menu_image($cat_id){
	  $category_query = dsf_db_query("select sc.menu_image as ov_menu_image,  lc.menu_image FROM " . DS_DB_SHOP .".categories sc left join " . DS_DB_LANGUAGE . ".categories lc on (sc.categories_id = lc.categories_id)  WHERE sc.categories_id = '". (int)$cat_id . "'");
 		 $categories = dsf_db_fetch_array($category_query);
  
  
		if (isset($categories['ov_menu_image']) && strlen($categories['ov_menu_image']) > 1){
			$menu_image = $categories['ov_menu_image'];
		}else{
			$menu_image = $categories['menu_image'];
		}

  return $menu_image;

}

// ###



  function dsf_update_transaction($order_number, $details ='') {
   
   $new_order_query = dsf_db_query("select orders_id, transaction_details from " . DS_DB_SHOP . ".orders where orders_id='" . (int)$order_number . "'");
 	$total_records_found = dsf_db_num_rows ($new_order_query);
	
	$new_order_info = dsf_db_fetch_array($new_order_query);

  $our_order_id = $new_order_info['orders_id'];
  
  if ((int)$our_order_id > 1){
 				$new_comments = date('Y-m-d H:i:s') . ' :- ' . $details . "\n\n" . $new_order_info['transaction_details'];

  		  $sql_data_array = array('transaction_details' => $new_comments);
		  dsf_db_perform(DS_DB_SHOP . '.orders', $sql_data_array, 'update', "orders_id = '" . (int)$our_order_id . "'");
  }
  
  return 'updated_record';
}


// ###


function dsf_print_array($array){

			$text = '<br><pre>';
			$text .= print_r($array,true);
			$text .= '</pre><br><br>';
		
			return $text;
}


// ###

  function dsf_stock($products_id, $products_quantity) {
    $stock_left = dsf_get_products_stock($products_id) - $products_quantity;
    
	if ((int)$stock_left >= 0 ){
			$out_of_stock = 1;
	}else{
			$out_of_stock = 0;
	}
	
    return $out_of_stock;
  }


// ###




function dsf_document_link($document='', $text='', $iclass='', $new_wind='true', $show_total='true'){

	if (!isset($document) || strlen($document) <4){
		return '';
	}else{
	
		$link = '<a href="' . dsf_href_link(DS_DIR_WS_DOCUMENTATION . $document) . '" title="' . str_replace(array('<br />',' - ') , '', $text) . '"';
		
		if (isset($iclass) && strlen($iclass) > 1){
			$link .= ' class="' . $iclass . '"';
		}
		
		if ($new_wind == 'true'){
			$link .=' target="_blank"';
		}
		
		$link .='>' . $text;
		
		if ($show_total == 'true'){
			if (file_exists(DS_DIR_WS_DOCUMENTATION . $document)) {
				$link .= ' ' . round(filesize(DS_DIR_WS_DOCUMENTATION . $document)/1048576,0) . ' Mb';
			}
		}
		
		$link .= '</a>';
		
		return $link;
	}
}


// ###


// SEO URLS FUNCTIONS
function dsf_get_article_one_slug_tree($article_id, $loopstopper = 1, $required_name =''){
					
			$categories_query = dsf_db_query("SELECT sa.article_id, sa.parent_id, sa.article_slug as ov_article_slug, la.article_slug FROM " . DS_DB_SHOP . ".article_one sa left join " . DS_DB_LANGUAGE . ".article_one la on (sa.article_id = la.article_id) WHERE sa.article_id = '". (int)$article_id . "'");
			$categories = dsf_db_fetch_array($categories_query);
		

			if (isset($categories['ov_article_slug']) && strlen($categories['ov_article_slug']) > 1){
				$article_slug = $categories['ov_article_slug'];
			}else{
				$article_slug = $categories['article_slug'];
			}
			


			if ($categories['parent_id'] ==0){
			   
			   if ($required_name){
			   		$required_name = $article_slug . '/' . $required_name;
			   }else{
			   		$required_name = $article_slug . '/';
			   }
		   
			 }else{
			    $loopstopper ++;
					if ($loopstopper < 6) { // max 6 links down, stops loops on rouge unlinked categories.
	
							if($required_name){
												$required_name = dsf_get_article_one_slug_tree($categories['parent_id'], $loopstopper, $article_slug . '/' . $required_name);
							}else{
												$required_name = dsf_get_article_one_slug_tree($categories['parent_id'], $loopstopper, $article_slug . '/');
							}
					}
			}
			

return $required_name;
}

// ###

function dsf_get_article_two_slug_tree($article_id, $loopstopper = 1, $required_name =''){
					
			$categories_query = dsf_db_query("SELECT sa.article_id, sa.parent_id, sa.article_slug as ov_article_slug, la.article_slug FROM " . DS_DB_SHOP . ".article_two sa left join " . DS_DB_LANGUAGE . ".article_two la on (sa.article_id = la.article_id) WHERE sa.article_id = '". (int)$article_id . "'");
			$categories = dsf_db_fetch_array($categories_query);
		

			if (isset($categories['ov_article_slug']) && strlen($categories['ov_article_slug']) > 1){
				$article_slug = $categories['ov_article_slug'];
			}else{
				$article_slug = $categories['article_slug'];
			}
			


			if ($categories['parent_id'] ==0){
			   
			   if ($required_name){
			   		$required_name = $article_slug . '/' . $required_name;
			   }else{
			   		$required_name = $article_slug . '/';
			   }
		   
			 }else{
			    $loopstopper ++;
					if ($loopstopper < 6) { // max 6 links down, stops loops on rouge unlinked categories.
	
							if($required_name){
												$required_name = dsf_get_article_two_slug_tree($categories['parent_id'], $loopstopper, $article_slug . '/' . $required_name);
							}else{
												$required_name = dsf_get_article_two_slug_tree($categories['parent_id'], $loopstopper, $article_slug . '/');
							}
					}
			}
			

return $required_name;
}

// ###

function dsf_get_article_three_slug_tree($article_id, $loopstopper = 1, $required_name =''){
					
			$categories_query = dsf_db_query("SELECT sa.article_id, sa.parent_id, sa.article_slug as ov_article_slug, la.article_slug FROM " . DS_DB_SHOP . ".article_three sa left join " . DS_DB_LANGUAGE . ".article_three la on (sa.article_id = la.article_id) WHERE sa.article_id = '". (int)$article_id . "'");
			$categories = dsf_db_fetch_array($categories_query);
		

			if (isset($categories['ov_article_slug']) && strlen($categories['ov_article_slug']) > 1){
				$article_slug = $categories['ov_article_slug'];
			}else{
				$article_slug = $categories['article_slug'];
			}
			


			if ($categories['parent_id'] ==0){
			   
			   if ($required_name){
			   		$required_name = $article_slug . '/' . $required_name;
			   }else{
			   		$required_name = $article_slug . '/';
			   }
		   
			 }else{
			    $loopstopper ++;
					if ($loopstopper < 6) { // max 6 links down, stops loops on rouge unlinked categories.
	
							if($required_name){
												$required_name = dsf_get_article_three_slug_tree($categories['parent_id'], $loopstopper, $article_slug . '/' . $required_name);
							}else{
												$required_name = dsf_get_article_three_slug_tree($categories['parent_id'], $loopstopper, $article_slug . '/');
							}
					}
			}
			

return $required_name;
}

// ###


function dsf_get_article_one_breadcrumb_tree($article_id, $loopstopper = 1, $required_name =''){
					
			$categories_query = dsf_db_query("SELECT sa.article_id, sa.parent_id, sa.article_name as ov_article_name, la.article_name FROM " . DS_DB_SHOP . ".article_one sa left join " . DS_DB_LANGUAGE . ".article_one la on (sa.article_id = la.article_id) WHERE sa.article_id = '". (int)$article_id . "'");
			$categories = dsf_db_fetch_array($categories_query);
		

			if (isset($categories['ov_article_name']) && strlen($categories['ov_article_name']) > 1){
				$article_name = $categories['ov_article_name'];
			}else{
				$article_name = $categories['article_name'];
			}
		
			if ($categories['parent_id'] == 0){
			   if ($required_name){
			   		$required_name = '<li><a href="' . dsf_article_one_url($categories['article_id']) . '">' .$article_name . '</a>'  . BREADCRUMB_SEPERATOR .  '</li>' . $required_name;
			   }else{
			   		$required_name = '<li><a href="' . dsf_article_one_url($categories['article_id']) . '">' . $article_name . '</a></li>';
			   }
			 }else{
			    $loopstopper ++;
					if ($loopstopper < 6) { // max 4 links down, stops loops on rouge unlinked categories.
	
							if($required_name){
												$required_name = dsf_get_article_one_breadcrumb_tree ($categories['parent_id'], $loopstopper, '<li><a href="' . dsf_article_one_url($categories['article_id']) . '">' . $article_name . '</a>'  . BREADCRUMB_SEPERATOR . '</li>' . $required_name);
							}else{
												$required_name = dsf_get_article_one_breadcrumb_tree ($categories['parent_id'], $loopstopper, '<li><a href="' . dsf_article_one_url($categories['article_id']) . '">' . $article_name . '</a></li>');
							}
					}
			}
			

return $required_name;
}

// ###

function dsf_get_article_two_breadcrumb_tree($article_id, $loopstopper = 1, $required_name =''){
					
			$categories_query = dsf_db_query("SELECT sa.article_id, sa.parent_id, sa.article_name as ov_article_name, la.article_name FROM " . DS_DB_SHOP . ".article_two sa left join " . DS_DB_LANGUAGE . ".article_two la on (sa.article_id = la.article_id) WHERE sa.article_id = '". (int)$article_id . "'");
			$categories = dsf_db_fetch_array($categories_query);
		

			if (isset($categories['ov_article_name']) && strlen($categories['ov_article_name']) > 1){
				$article_name = $categories['ov_article_name'];
			}else{
				$article_name = $categories['article_name'];
			}
		
			if ($categories['parent_id'] == 0){
			   if ($required_name){
			   		$required_name = '<li><a href="' . dsf_article_two_url($categories['article_id']) . '">' .$article_name . '</a>'  . BREADCRUMB_SEPERATOR .  '</li>' . $required_name;
			   }else{
			   		$required_name = '<li><a href="' . dsf_article_two_url($categories['article_id']) . '">' . $article_name . '</a></li>';
			   }
			 }else{
			    $loopstopper ++;
					if ($loopstopper < 6) { // max 4 links down, stops loops on rouge unlinked categories.
	
							if($required_name){
												$required_name = dsf_get_article_two_breadcrumb_tree ($categories['parent_id'], $loopstopper, '<li><a href="' . dsf_article_two_url($categories['article_id']) . '">' . $article_name . '</a>'  . BREADCRUMB_SEPERATOR . '</li>' . $required_name);
							}else{
												$required_name = dsf_get_article_two_breadcrumb_tree ($categories['parent_id'], $loopstopper, '<li><a href="' . dsf_article_two_url($categories['article_id']) . '">' . $article_name . '</a></li>');
							}
					}
			}
			

return $required_name;
}

// ###


function dsf_get_article_three_breadcrumb_tree($article_id, $loopstopper = 1, $required_name =''){
					
			$categories_query = dsf_db_query("SELECT sa.article_id, sa.parent_id, sa.article_name as ov_article_name, la.article_name FROM " . DS_DB_SHOP . ".article_three sa left join " . DS_DB_LANGUAGE . ".article_three la on (sa.article_id = la.article_id) WHERE sa.article_id = '". (int)$article_id . "'");
			$categories = dsf_db_fetch_array($categories_query);
		

			if (isset($categories['ov_article_name']) && strlen($categories['ov_article_name']) > 1){
				$article_name = $categories['ov_article_name'];
			}else{
				$article_name = $categories['article_name'];
			}
		
			if ($categories['parent_id'] == 0){
			   if ($required_name){
			   		$required_name = '<li><a href="' . dsf_article_three_url($categories['article_id']) . '">' .$article_name . '</a>'  . BREADCRUMB_SEPERATOR .  '</li>' . $required_name;
			   }else{
			   		$required_name = '<li><a href="' . dsf_article_three_url($categories['article_id']) . '">' . $article_name . '</a></li>';
			   }
			 }else{
			    $loopstopper ++;
					if ($loopstopper < 6) { // max 4 links down, stops loops on rouge unlinked categories.
	
							if($required_name){
												$required_name = dsf_get_article_three_breadcrumb_tree ($categories['parent_id'], $loopstopper, '<li><a href="' . dsf_article_three_url($categories['article_id']) . '">' . $article_name . '</a>'  . BREADCRUMB_SEPERATOR . '</li>' . $required_name);
							}else{
												$required_name = dsf_get_article_three_breadcrumb_tree ($categories['parent_id'], $loopstopper, '<li><a href="' . dsf_article_three_url($categories['article_id']) . '">' . $article_name . '</a></li>');
							}
					}
			}
			

return $required_name;
}

// ###


function dsf_get_subpage_item_data($sub_item=''){

// there are lookups depending on what is passed to the function.  the sub_item value will consist of
// two values seperated by a colon :   the first value is the type of item to lookup based on the following table,
// the second value is the items value.
/*
1 = Articles
2 =Buying Guides
3 =Competition
4 =Gift Ideas
5 =Latest News
6 =Recipes
7 = article 1
8 = article 2
9 = article 3
10 = category
11 = product
12 = page
13 external link
14 = include file

17 - seasonal article

*/
$return_array = '';

// job 1 split the two values up.

	if (isset($sub_item) && strpos($sub_item, ':') > 0){

	// we can continue
	
		$split = explode(':' , $sub_item);
		$sub_one = $split[0];
		$sub_two = $split[1];

		if (isset($sub_two) && strtolower($sub_two) == 'http') {
			$sub_two .= ':' . $split[2];
		}
		
		
		
		// articles
			if ((int)$sub_one == 1){
			
						$query = dsf_db_query("select sa.article_id, sa.article_title as ov_article_title, sa.article_image as ov_article_image, sa.article_short as ov_article_short, la.article_title, la.article_image, la.article_short from " . DS_DB_SHOP . ".product_articles sa left join " . DS_DB_LANGUAGE . ".product_articles la on (sa.article_id = la.article_id) where sa.article_id='" . (int)$sub_two . "'");
						
						$results = dsf_db_fetch_array($query);
						
						if (isset($results['article_id'])){
						
							if (isset($results['ov_article_title']) && strlen($results['ov_article_title']) > 1){
								$article_title = $results['ov_article_title'];
							}else{
								$article_title = $results['article_title'];
							}
						
						
							if (isset($results['ov_article_image']) && strlen($results['ov_article_image']) > 1){
								$article_image = $results['ov_article_image'];
							}else{
								$article_image = $results['article_image'];
							}
						
						
							if (isset($results['ov_article_short']) && strlen($results['ov_article_short']) > 1){
								$article_short = $results['ov_article_short'];
							}else{
								$article_short = $results['article_short'];
							}
						
								$return_array = array('title' => $article_title,
									 'name' => $article_title,
									 'id' => $results['article_id'],
									 'image' => (strlen($article_image) > 3 ? 'sized/home/' . $article_image : ''),
									 'image_width' => FRONT_ANNOUNCEMENT_IMAGE_WIDTH,
									 'image_height' => FRONT_ANNOUNCEMENT_IMAGE_HEIGHT,
									 'type' => 'article',
									 'text' => $article_short
									 );
						}
	
		// buying guides
		
			}elseif ((int)$sub_one == 2){
						
						
						$query = dsf_db_query("select * from " . DS_DB_SHOP . ".buying_guides where guide_id='" . (int)$sub_two . "'");
						$results = dsf_db_fetch_array($query);
						
						if (isset($results['guide_id'])){
						
								$return_array = array('url' => dsf_href_link('buying-guides/' . $results['guide_slug'] . '.html'),
									 'name' => $results['guide_title'],
									 'title' => $results['guide_title'],
									 'id' => $results['guide_id'],
									 'header_image' => $results['guide_header_image'],
									 'header_title' => $results['guide_header_title'],
									 'image' => (strlen($results['guide_image']) > 3 ? 'sized/home/' . $results['guide_image'] : ''),
									 'image_width' => FRONT_ANNOUNCEMENT_IMAGE_WIDTH,
									 'image_height' => FRONT_ANNOUNCEMENT_IMAGE_HEIGHT,
									 'menu_image' => (strlen($results['menu_image']) > 3 ? 'sized/home/' . $results['menu_image'] : ''),
									 'menu_image_width' => MENU_IMAGE_WIDTH,
									 'menu_image_height' => MENU_IMAGE_HEIGHT,
									 'type' => 'buying_guide',
									 'text' => $results['guide_short']
									 );
						} 
	
		// competition
		
			}elseif ((int)$sub_one == 3){
			

						$query = dsf_db_query("select sc.comp_id, sc.comp_title as ov_comp_title, sc.comp_slug as ov_comp_slug, sc.comp_header_image as ov_comp_header_image, sc.comp_header_title as ov_comp_header_title, sc.comp_image as ov_comp_image, sc.menu_image as ov_menu_image, sc.comp_short as ov_comp_short, 
						lc.comp_title, lc.comp_slug, lc.comp_header_image, lc.comp_header_title, lc.comp_image, lc.menu_image, lc.comp_short from " . DS_DB_SHOP . ".competition sc left join " . DS_DB_LANGUAGE . ".competition lc on (sc.comp_id = lc.comp_id) where sc.comp_id='" . (int)$sub_two . "'");
						


						$results = dsf_db_fetch_array($query);
						
						if (isset($results['comp_id'])){
						
							if (isset($results['ov_comp_slug']) && strlen($results['ov_comp_slug']) > 1){
								$comp_slug = $results['ov_comp_slug'];
							}else{
								$comp_slug = $results['comp_slug'];
							}
							
							
							if (isset($results['ov_comp_title']) && strlen($results['ov_comp_title']) > 1){
								$comp_title = $results['ov_comp_title'];
							}else{
								$comp_title = $results['comp_title'];
							}
						
						
							if (isset($results['ov_comp_header_image']) && strlen($results['ov_comp_header_image']) > 1){
								$comp_header_image = $results['ov_comp_header_image'];
							}else{
								$comp_header_image = $results['comp_header_image'];
							}
						
							if (isset($results['ov_comp_header_title']) && strlen($results['ov_comp_header_title']) > 1){
								$comp_header_title = $results['ov_comp_header_title'];
							}else{
								$comp_header_title = $results['comp_header_title'];
							}
						
							if (isset($results['ov_comp_image']) && strlen($results['ov_comp_image']) > 1){
								$comp_image = $results['ov_comp_image'];
							}else{
								$comp_image = $results['comp_image'];
							}
						
						
							if (isset($results['ov_menu_image']) && strlen($results['ov_menu_image']) > 1){
								$menu_image = $results['ov_menu_image'];
							}else{
								$menu_image = $results['menu_image'];
							}
						
							if (isset($results['ov_comp_short']) && strlen($results['ov_comp_short']) > 1){
								$comp_short = $results['ov_comp_short'];
							}else{
								$comp_short = $results['comp_short'];
							}

						
								$return_array = array('url' => dsf_href_link('competitions/' . $comp_slug . '.html'),
									 'title' => $comp_title,
									 'name' => $comp_title,
									'id' => $results['comp_id'],
									 'header_image' => $comp_header_image,
									 'header_title' => $comp_header_title,
									 'image' => (strlen($comp_image) > 3 ? 'sized/home/' . $comp_image : ''),
									 'image_width' => FRONT_COMPETITION_IMAGE_WIDTH,
									 'image_height' => FRONT_COMPETITION_IMAGE_HEIGHT,
									 'menu_image' => (strlen($menu_image) > 3 ? 'sized/home/' . $menu_image : ''),
									 'menu_image_width' => MENU_IMAGE_WIDTH,
									 'menu_image_height' => MENU_IMAGE_HEIGHT,
									 'type' => 'competition',
									 'text' => $comp_short
									 );
						} 
	
	
		// gift ideas
		
			}elseif ((int)$sub_one == 4){
			

						$query = dsf_db_query("select * from " . DS_DB_SHOP . ".gift_ideas where gift_id='" . (int)$sub_two . "'");
						$results = dsf_db_fetch_array($query);
						
						if (isset($results['gift_id'])){
						
								$return_array = array('url' => dsf_href_link('gift-ideas/' . $results['gift_slug'] . '.html'),
									 'title' => $results['gift_title'],
									 'name' => $results['gift_title'],
									 'id' => $results['gift_id'],
									 'header_image' => $results['gift_header_image'],
									 'header_title' => $results['gift_header_title'],
									 'image' => (strlen($results['gift_image']) > 3 ? 'sized/home/' . $results['gift_image'] : ''),
									 'image_width' => FRONT_ANNOUNCEMENT_IMAGE_WIDTH,
									 'image_height' => FRONT_ANNOUNCEMENT_IMAGE_HEIGHT,
									 'type' => 'gift_idea',
									 'menu_image' => (strlen($results['menu_image']) > 3 ? 'sized/home/' . $results['menu_image'] : ''),
									 'menu_image_width' => MENU_IMAGE_WIDTH,
									 'menu_image_height' => MENU_IMAGE_HEIGHT,
									 'text' => $results['gift_text']
									 );
						} 
	
	
		// latest news
		
			}elseif ((int)$sub_one == 5){
			
						$query = dsf_db_query("select * from " . DS_DB_SHOP . ".news where news_id='" . (int)$sub_two . "'");
						$results = dsf_db_fetch_array($query);
						
						if (isset($results['news_id'])){
						
								$return_array = array('url' => dsf_href_link('news/' . $results['news_slug'] . '.html'),
									 'title' => $results['news_title'],
									 'name' => $results['news_title'],
									 'id' => $results['news_id'],
									 'header_image' => $results['news_header_image'],
									 'header_title' => $results['news_header_title'],
									 'image' => (strlen($results['news_image']) > 3 ? 'sized/home/' . $results['news_image'] : ''),
									 'image_width' => FRONT_ANNOUNCEMENT_IMAGE_WIDTH,
									 'image_height' => FRONT_ANNOUNCEMENT_IMAGE_HEIGHT,
									 'menu_image' => (strlen($results['menu_image']) > 3 ? 'sized/home/' . $results['menu_image'] : ''),
									 'menu_image_width' => MENU_IMAGE_WIDTH,
									 'menu_image_height' => MENU_IMAGE_HEIGHT,
									 'type' => 'news',
									 'text' => $results['news_short']
									 );
						} 
	
	
		// recipes
		
			}elseif ((int)$sub_one == 6){
			
						// recipies is no longer a valid item
			
	
	
		// article 1
		
			}elseif ((int)$sub_one == 7){
			


						$query = dsf_db_query("select sa.article_id, sa.article_slug as ov_article_slug, sa.article_name as ov_article_name, sa.article_title as ov_article_title, sa.title_image as ov_title_image, sa.article_image as ov_article_image, sa.menu_image as ov_menu_image, sa.subpage_text as ov_subpage_text,la.article_slug, la.article_name, la.article_title, la.title_image, la.article_image, la.menu_image, la.subpage_text from " . DS_DB_SHOP . ".article_one sa left join " . DS_DB_LANGUAGE . ".article_one la on (sa.article_id = la.article_id) where sa.article_id='" . (int)$sub_two . "'");
						
						$results = dsf_db_fetch_array($query);
						
						if (isset($results['article_id'])){
						
							if (isset($results['ov_article_slug']) && strlen($results['ov_article_slug']) > 1){
								$article_slug = $results['ov_article_slug'];
							}else{
								$article_slug = $results['article_slug'];
							}
							
							
							if (isset($results['ov_article_name']) && strlen($results['ov_article_name']) > 1){
								$article_name = $results['ov_article_name'];
							}else{
								$article_name = $results['article_name'];
							}
						
						
							if (isset($results['ov_title_image']) && strlen($results['ov_title_image']) > 1){
								$title_image = $results['ov_title_image'];
							}else{
								$title_image = $results['title_image'];
							}
						
							if (isset($results['ov_article_title']) && strlen($results['ov_article_title']) > 1){
								$article_title = $results['ov_article_title'];
							}else{
								$article_title = $results['article_title'];
							}
						
							if (isset($results['ov_article_image']) && strlen($results['ov_article_image']) > 1){
								$article_image = $results['ov_article_image'];
							}else{
								$article_image = $results['article_image'];
							}
						
						
							if (isset($results['ov_menu_image']) && strlen($results['ov_menu_image']) > 1){
								$menu_image = $results['ov_menu_image'];
							}else{
								$menu_image = $results['menu_image'];
							}
						
							if (isset($results['ov_subpage_text']) && strlen($results['ov_subpage_text']) > 1){
								$subpage_text = $results['ov_subpage_text'];
							}else{
								$subpage_text = $results['subpage_text'];
							}
						
								$return_array = array('url' => dsf_article_one_url($results['article_id']),
									 'title' => $article_name,
									 'name' => $article_name,
									 'id' => $results['article_id'],
									 'header_image' => $title_image,
									 'header_title' => $article_title,
									 'image' => (strlen($article_image) > 3 ? 'sized/home/' . $article_image : ''),
									 'image_width' => FRONT_ARTICLE_IMAGE_WIDTH,
									 'image_height' => FRONT_ARTICLE_IMAGE_HEIGHT,
									 'menu_image' => (strlen($menu_image) > 3 ? 'sized/home/' . $menu_image : ''),
									 'menu_image_width' => MENU_IMAGE_WIDTH,
									 'menu_image_height' => MENU_IMAGE_HEIGHT,
									 'type' => 'info_articles_one',
									 'text' => $subpage_text
									 );
						} 
	
	


		// article 2
		
			}elseif ((int)$sub_one == 8){
			
						$query = dsf_db_query("select sa.article_id, sa.article_slug as ov_article_slug, sa.article_name as ov_article_name, sa.article_title as ov_article_title, sa.title_image as ov_title_image, sa.article_image as ov_article_image, sa.menu_image as ov_menu_image, sa.subpage_text as ov_subpage_text,la.article_slug, la.article_name, la.article_title, la.title_image, la.article_image, la.menu_image, la.subpage_text from " . DS_DB_SHOP . ".article_two sa left join " . DS_DB_LANGUAGE . ".article_two la on (sa.article_id = la.article_id) where sa.article_id='" . (int)$sub_two . "'");
						
						$results = dsf_db_fetch_array($query);
						
						if (isset($results['article_id'])){
						
							if (isset($results['ov_article_slug']) && strlen($results['ov_article_slug']) > 1){
								$article_slug = $results['ov_article_slug'];
							}else{
								$article_slug = $results['article_slug'];
							}
							
							
							if (isset($results['ov_article_name']) && strlen($results['ov_article_name']) > 1){
								$article_name = $results['ov_article_name'];
							}else{
								$article_name = $results['article_name'];
							}
						
						
							if (isset($results['ov_title_image']) && strlen($results['ov_title_image']) > 1){
								$title_image = $results['ov_title_image'];
							}else{
								$title_image = $results['title_image'];
							}
						
							if (isset($results['ov_article_title']) && strlen($results['ov_article_title']) > 1){
								$article_title = $results['ov_article_title'];
							}else{
								$article_title = $results['article_title'];
							}
						
							if (isset($results['ov_article_image']) && strlen($results['ov_article_image']) > 1){
								$article_image = $results['ov_article_image'];
							}else{
								$article_image = $results['article_image'];
							}
						
						
							if (isset($results['ov_menu_image']) && strlen($results['ov_menu_image']) > 1){
								$menu_image = $results['ov_menu_image'];
							}else{
								$menu_image = $results['menu_image'];
							}
						
							if (isset($results['ov_subpage_text']) && strlen($results['ov_subpage_text']) > 1){
								$subpage_text = $results['ov_subpage_text'];
							}else{
								$subpage_text = $results['subpage_text'];
							}
						
								$return_array = array('url' => dsf_article_two_url($results['article_id']),
									 'title' => $article_name,
									 'name' => $article_name,
									 'id' => $results['article_id'],
									 'header_image' => $title_image,
									 'header_title' => $article_title,
									 'image' => (strlen($article_image) > 3 ? 'sized/home/' . $article_image : ''),
									 'image_width' => FRONT_ARTICLE_IMAGE_WIDTH,
									 'image_height' => FRONT_ARTICLE_IMAGE_HEIGHT,
									 'menu_image' => (strlen($menu_image) > 3 ? 'sized/home/' . $menu_image : ''),
									 'menu_image_width' => MENU_IMAGE_WIDTH,
									 'menu_image_height' => MENU_IMAGE_HEIGHT,
									 'type' => 'info_articles_one',
									 'text' => $subpage_text
									 );
						} 
	
	

		// article 3
		
			}elseif ((int)$sub_one == 9){
			
						$query = dsf_db_query("select sa.article_id, sa.article_slug as ov_article_slug, sa.article_name as ov_article_name, sa.article_title as ov_article_title, sa.title_image as ov_title_image, sa.article_image as ov_article_image, sa.menu_image as ov_menu_image, sa.subpage_text as ov_subpage_text,la.article_slug, la.article_name, la.article_title, la.title_image, la.article_image, la.menu_image, la.subpage_text from " . DS_DB_SHOP . ".article_three sa left join " . DS_DB_LANGUAGE . ".article_three la on (sa.article_id = la.article_id) where sa.article_id='" . (int)$sub_two . "'");
						
						$results = dsf_db_fetch_array($query);
						
						if (isset($results['article_id'])){
						
							if (isset($results['ov_article_slug']) && strlen($results['ov_article_slug']) > 1){
								$article_slug = $results['ov_article_slug'];
							}else{
								$article_slug = $results['article_slug'];
							}
							
							
							if (isset($results['ov_article_name']) && strlen($results['ov_article_name']) > 1){
								$article_name = $results['ov_article_name'];
							}else{
								$article_name = $results['article_name'];
							}
						
						
							if (isset($results['ov_title_image']) && strlen($results['ov_title_image']) > 1){
								$title_image = $results['ov_title_image'];
							}else{
								$title_image = $results['title_image'];
							}
						
							if (isset($results['ov_article_title']) && strlen($results['ov_article_title']) > 1){
								$article_title = $results['ov_article_title'];
							}else{
								$article_title = $results['article_title'];
							}
						
							if (isset($results['ov_article_image']) && strlen($results['ov_article_image']) > 1){
								$article_image = $results['ov_article_image'];
							}else{
								$article_image = $results['article_image'];
							}
						
						
							if (isset($results['ov_menu_image']) && strlen($results['ov_menu_image']) > 1){
								$menu_image = $results['ov_menu_image'];
							}else{
								$menu_image = $results['menu_image'];
							}
						
							if (isset($results['ov_subpage_text']) && strlen($results['ov_subpage_text']) > 1){
								$subpage_text = $results['ov_subpage_text'];
							}else{
								$subpage_text = $results['subpage_text'];
							}
						
								$return_array = array('url' => dsf_article_three_url($results['article_id']),
									 'title' => $article_name,
									 'name' => $article_name,
									 'id' => $results['article_id'],
									 'header_image' => $title_image,
									 'header_title' => $article_title,
									 'image' => (strlen($article_image) > 3 ? 'sized/home/' . $article_image : ''),
									 'image_width' => FRONT_ARTICLE_IMAGE_WIDTH,
									 'image_height' => FRONT_ARTICLE_IMAGE_HEIGHT,
									 'menu_image' => (strlen($menu_image) > 3 ? 'sized/home/' . $menu_image : ''),
									 'menu_image_width' => MENU_IMAGE_WIDTH,
									 'menu_image_height' => MENU_IMAGE_HEIGHT,
									 'type' => 'info_articles_one',
									 'text' => $subpage_text
									 );
						} 
	



// Seasonal article

			}elseif ((int)$sub_one == 17){
			
						$query = dsf_db_query("select sa.article_id, sa.article_slug as ov_article_slug, sa.article_name as ov_article_name, sa.article_title as ov_article_title, sa.title_image as ov_title_image, sa.article_image_one as ov_article_image_one, sa.menu_image as ov_menu_image, sa.subpage_text as ov_subpage_text,la.article_slug, la.article_name, la.article_title, la.title_image, la.article_image_one, la.menu_image, la.subpage_text from " . DS_DB_SHOP . ".seasonal_articles sa left join " . DS_DB_LANGUAGE . ".seasonal_articles la on (sa.article_id = la.article_id) where sa.article_id='" . (int)$sub_two . "'");
						
						$results = dsf_db_fetch_array($query);
						
						if (isset($results['article_id'])){
						
							if (isset($results['ov_article_slug']) && strlen($results['ov_article_slug']) > 1){
								$article_slug = $results['ov_article_slug'];
							}else{
								$article_slug = $results['article_slug'];
							}
							
							
							if (isset($results['ov_article_name']) && strlen($results['ov_article_name']) > 1){
								$article_name = $results['ov_article_name'];
							}else{
								$article_name = $results['article_name'];
							}
						
						
							if (isset($results['ov_title_image']) && strlen($results['ov_title_image']) > 1){
								$title_image = $results['ov_title_image'];
							}else{
								$title_image = $results['title_image'];
							}
						
							if (isset($results['ov_article_title']) && strlen($results['ov_article_title']) > 1){
								$article_title = $results['ov_article_title'];
							}else{
								$article_title = $results['article_title'];
							}
						
							if (isset($results['ov_article_image_one']) && strlen($results['ov_article_image_one']) > 1){
								$article_image_one = $results['ov_article_image_one'];
							}else{
								$article_image_one = $results['article_image_one'];
							}
						
						
							if (isset($results['ov_menu_image']) && strlen($results['ov_menu_image']) > 1){
								$menu_image = $results['ov_menu_image'];
							}else{
								$menu_image = $results['menu_image'];
							}
						
							if (isset($results['ov_subpage_text']) && strlen($results['ov_subpage_text']) > 1){
								$subpage_text = $results['ov_subpage_text'];
							}else{
								$subpage_text = $results['subpage_text'];
							}
						
								$return_array = array('url' => dsf_seasonal_article_url($results['article_id']),
									 'title' => $article_name,
									 'name' => $article_name,
									 'id' => $results['article_id'],
									 'header_image' => $title_image,
									 'header_title' => $article_title,
									 'image' => (strlen($article_image_one) > 3 ? 'sized/home/' . $article_image_one : ''),
									 'image_width' => FRONT_ARTICLE_IMAGE_WIDTH,
									 'image_height' => FRONT_ARTICLE_IMAGE_HEIGHT,
									 'menu_image' => (strlen($menu_image) > 3 ? 'sized/home/' . $menu_image : ''),
									 'menu_image_width' => MENU_IMAGE_WIDTH,
									 'menu_image_height' => MENU_IMAGE_HEIGHT,
									 'type' => 'info_seasonal_article',
									 'text' => $subpage_text
									 );
						} 
	
	








	
		// category
		
			}elseif ((int)$sub_one == 10){
			
						$query = dsf_db_query("select sc.categories_id, sc.categories_name as ov_categories_name, sc.title_image as ov_title_image, sc.categories_title as ov_categories_title, sc.categories_image as ov_categories_image, sc.menu_image as ov_menu_image, sc.categories_text as ov_categories_text, lc.categories_name, lc.title_image, lc.categories_title, lc.categories_image, lc.menu_image, lc.categories_text from " . DS_DB_SHOP . ".categories sc left join " . DS_DB_LANGUAGE . ".categories lc on (sc.categories_id = lc.categories_id) where sc.categories_id='" . (int)$sub_two . "'");
						$results = dsf_db_fetch_array($query);
						
						if (isset($results['categories_id'])){
						

							if (isset($results['ov_categories_name']) && strlen($results['ov_categories_name']) > 1){
								$categories_name = $results['ov_categories_name'];
							}else{
								$categories_name = $results['categories_name'];
							}


							if (isset($results['ov_title_image']) && strlen($results['ov_title_image']) > 1){
								$title_image = $results['ov_title_image'];
							}else{
								$title_image = $results['title_image'];
							}

							if (isset($results['ov_categories_title']) && strlen($results['ov_categories_title']) > 1){
								$categories_title = $results['ov_categories_title'];
							}else{
								$categories_title = $results['categories_title'];
							}

							if (isset($results['ov_categories_image']) && strlen($results['ov_categories_image']) > 1){
								$categories_image = $results['ov_categories_image'];
							}else{
								$categories_image = $results['categories_image'];
							}

							if (isset($results['ov_menu_image']) && strlen($results['ov_menu_image']) > 1){
								$menu_image = $results['ov_menu_image'];
							}else{
								$menu_image = $results['menu_image'];
							}

							if (isset($results['ov_categories_text']) && strlen($results['ov_categories_text']) > 1){
								$categories_text = $results['ov_categories_text'];
							}else{
								$categories_text = $results['categories_text'];
							}


								$return_array = array('url' => dsf_category_url($results['categories_id']),
									 'title' => $categories_name,
									 'name' => $categories_name,
									 'id' => $results['categories_id'],
									 'header_image' => $title_image,
									 'header_title' => $categories_title,
									 'image' => (strlen($categories_image) > 3 ? 'sized/home/cat_' . $categories_image : ''),
									 'image_width' => FRONT_CATEGORY_IMAGE_WIDTH,
									 'image_height' => FRONT_CATEGORY_IMAGE_HEIGHT,
									 'type' => 'category',
									 'menu_image' => (strlen($menu_image) > 3 ? 'sized/home/' . $menu_image : ''),
									 'menu_image_width' => MENU_IMAGE_WIDTH,
									 'menu_image_height' => MENU_IMAGE_HEIGHT,
									 'text' => $categories_text,
									 'products' =>	dsf_count_products_in_category($results['categories_id'])
									  );
						} 


		// product
		
			}elseif ((int)$sub_one == 11){
			
					$return_array = dsf_get_subpage_product_data($sub_two);
					$return_array['type'] = 'product';
	
		  


		// category parts
		
			}elseif ((int)$sub_one == 15){
			
						$query = dsf_db_query("select sc.categories_id, sc.categories_name as ov_categories_name, sc.title_image as ov_title_image, sc.categories_title as ov_categories_title, sc.categories_image as ov_categories_image, sc.menu_image as ov_menu_image, sc.categories_text as ov_categories_text, lc.categories_name, lc.title_image, lc.categories_title, lc.categories_image, lc.menu_image, lc.categories_text from " . DS_DB_SHOP . ".categories_parts sc left join " . DS_DB_LANGUAGE . ".categories_parts lc on (sc.categories_id = lc.categories_id) where sc.categories_id='" . (int)$sub_two . "'");
						$results = dsf_db_fetch_array($query);
						
						if (isset($results['categories_id'])){
						

							if (isset($results['ov_categories_name']) && strlen($results['ov_categories_name']) > 1){
								$categories_name = $results['ov_categories_name'];
							}else{
								$categories_name = $results['categories_name'];
							}


							if (isset($results['ov_title_image']) && strlen($results['ov_title_image']) > 1){
								$title_image = $results['ov_title_image'];
							}else{
								$title_image = $results['title_image'];
							}

							if (isset($results['ov_categories_title']) && strlen($results['ov_categories_title']) > 1){
								$categories_title = $results['ov_categories_title'];
							}else{
								$categories_title = $results['categories_title'];
							}

							if (isset($results['ov_categories_image']) && strlen($results['ov_categories_image']) > 1){
								$categories_image = $results['ov_categories_image'];
							}else{
								$categories_image = $results['categories_image'];
							}

							if (isset($results['ov_menu_image']) && strlen($results['ov_menu_image']) > 1){
								$menu_image = $results['ov_menu_image'];
							}else{
								$menu_image = $results['menu_image'];
							}

							if (isset($results['ov_categories_text']) && strlen($results['ov_categories_text']) > 1){
								$categories_text = $results['ov_categories_text'];
							}else{
								$categories_text = $results['categories_text'];
							}


								$return_array = array('url' => dsf_category_parts_url($results['categories_id']),
									 'title' => $categories_name,
									 'name' => $categories_name,
									 'id' => $results['categories_id'],
									 'header_image' => $title_image,
									 'header_title' => $categories_title,
									 'image' => (strlen($categories_image) > 3 ? 'sized/home/cat_' . $categories_image : ''),
									 'image_width' => FRONT_CATEGORY_IMAGE_WIDTH,
									 'image_height' => FRONT_CATEGORY_IMAGE_HEIGHT,
									 'type' => 'category',
									 'menu_image' => (strlen($menu_image) > 3 ? 'sized/home/' . $menu_image : ''),
									 'menu_image_width' => MENU_IMAGE_WIDTH,
									 'menu_image_height' => MENU_IMAGE_HEIGHT,
									 'text' => $categories_text,
									 'products' =>	dsf_count_products_parts_in_category($results['categories_id'])
									  );
						} 


		// product
		
			}elseif ((int)$sub_one == 16){
			
					$return_array = dsf_get_subpage_product_parts_data($sub_two);
					$return_array['type'] = 'product';
	
		  


		  
			}elseif ((int)$sub_one == 12){
			
						$query = dsf_db_query("select * from " . DS_DB_SHOP . ".layouts where page_id='" . (int)$sub_two . "'");
						$results = dsf_db_fetch_array($query);
						
						if (isset($results['page_id'])){
						
							// AMENDMENT 2014-09-01 not to show index.php / index.html
								if ($results['page_file'] == 'index.php'){
									// we don't do index page by itself we show the domain name only.
									$url = dsf_href_link();
								}else{
							// was previously just this else line
									$url = dsf_href_link(str_replace('.php', '.html' , $results['page_file']));
								}
								
								$return_array = array('url' => $url,
									 'title' => $results['page_name'],
									 'name' => $results['page_name'],
									 'id' => $results['page_id']
									  );
						} 
		  
	
			}elseif ((int)$sub_one == 13){
			
								$return_array = array('url' => $sub_two
									  );
	
			
			}elseif ((int)$sub_one == 14){

			
								$return_array = array('include_file' => $sub_two
									  );
		  
		// category parts
		
			}elseif ((int)$sub_one == 15){
			
						$query = dsf_db_query("select sc.categories_name as ov_categories_name, sc.title_image as ov_title_image, sc.categories_title as ov_categories_title, sc.categories_image as ov_categories_image, sc.menu_image as ov_menu_image, sc.categories_text as ov_categories_text, lc.categories_name, lc.title_image, lc.categories_title, lc.categories_image, lc.menu_image, lc.categories_text from " . DS_DB_SHOP . ".categories_parts sc left join " . DS_DB_LANGUAGE . ".categories_parts lc on (sc.categories_id = lc.categories_id) where sc.categories_id='" . (int)$sub_two . "'");
						$results = dsf_db_fetch_array($query);
						
						if (isset($results['categories_id'])){
						

							if (isset($results['ov_categories_name']) && strlen($results['ov_categories_name']) > 1){
								$categories_name = $results['ov_categories_name'];
							}else{
								$categories_name = $results['categories_name'];
							}


							if (isset($results['ov_title_image']) && strlen($results['ov_title_image']) > 1){
								$title_image = $results['ov_title_image'];
							}else{
								$title_image = $results['title_image'];
							}

							if (isset($results['ov_categories_title']) && strlen($results['ov_categories_title']) > 1){
								$categories_title = $results['ov_categories_title'];
							}else{
								$categories_title = $results['categories_title'];
							}

							if (isset($results['ov_categories_image']) && strlen($results['ov_categories_image']) > 1){
								$categories_image = $results['ov_categories_image'];
							}else{
								$categories_image = $results['categories_image'];
							}

							if (isset($results['ov_menu_image']) && strlen($results['ov_menu_image']) > 1){
								$menu_image = $results['ov_menu_image'];
							}else{
								$menu_image = $results['menu_image'];
							}

							if (isset($results['ov_categories_text']) && strlen($results['ov_categories_text']) > 1){
								$categories_text = $results['ov_categories_text'];
							}else{
								$categories_text = $results['categories_text'];
							}


								$return_array = array('url' => dsf_category_parts_url($results['categories_id']),
									 'title' => $categories_name,
									 'name' => $categories_name,
									 'id' => $results['categories_id'],
									 'header_image' => $title_image,
									 'header_title' => $categories_title,
									 'image' => (strlen($categories_image) > 3 ? 'sized/home/cat_' . $categories_image : ''),
									 'image_width' => FRONT_CATEGORY_IMAGE_WIDTH,
									 'image_height' => FRONT_CATEGORY_IMAGE_HEIGHT,
									 'type' => 'category',
									 'menu_image' => (strlen($menu_image) > 3 ? 'sized/home/' . $menu_image : ''),
									 'menu_image_width' => MENU_IMAGE_WIDTH,
									 'menu_image_height' => MENU_IMAGE_HEIGHT,
									 'text' => $categories_text,
									 'products' =>	dsf_count_products_parts_in_category($results['categories_id'])
									  );
						} 


		// product
		
			}elseif ((int)$sub_one == 16){
			
					$return_array = dsf_get_subpage_product_parts_data($sub_two);
					$return_array['type'] = 'product';
	
		  
		  }
		  
		  
		  
		  
		  
		  
		  
		  
		   // end of creating array based on answer
	} // end if something set
	
	return $return_array;
} // end function


// ###

function dsf_get_subpage_product_data($product=0){
global $currencies;

$return_array = '';


 if ((int)$product > 0){
 
				// get accessories info
					 $accessory_info_query = dsf_db_query("select sp.products_id, sp.products_name as ov_products_name, sp.products_description as ov_products_description, sp.products_othernames as ov_products_othernames, sp.products_model as ov_products_model, sp.products_main_cat as ov_products_main_cat, sp.products_slug as ov_products_slug, sp.products_image_one as ov_products_image_one, sp.category_image as ov_category_image, sp.products_price, sp.products_tax_class_id, sp.rrp_price, sp.allow_purchase, sp.web_exclusive, sp.products_awards as ov_products_awards, sp.menu_image as ov_menu_image, lp.products_name, lp.products_description, lp.products_othernames, lp.products_model, lp.products_main_cat, lp.products_slug, lp.products_image_one, lp.category_image, lp.products_awards, lp.menu_image from " . DS_DB_SHOP . ".products sp left join " . DS_DB_LANGUAGE . ".products lp on (sp.products_id = lp.products_id) where sp.products_status = '1' and sp.products_id = '" . (int)$product . "'");
						
						
					if (dsf_db_num_rows($accessory_info_query) > 0){
						
										$accessory_info_values = dsf_db_fetch_array($accessory_info_query);
								
						
									if ($acc_price = dsf_get_products_special_price($accessory_info_values['products_id'])) {
									  $offer_price = $currencies->display_price($acc_price, dsf_get_tax_rate($accessory_info_values['products_tax_class_id']));
									} else{
									  $offer_price = '';
									}
									
									
									if ((int)$accessory_info_values['rrp_price'] > 0){
									  $rrp_price = $currencies->display_price($accessory_info_values['rrp_price'], 0);
									}else{
										$rrp_price = '';
									}
									
								  $accessory_price = $currencies->display_price($accessory_info_values['products_price'], dsf_get_tax_rate($accessory_info_values['products_tax_class_id']));
									
			
			
			
										if (isset($accessory_info_values['ov_category_image']) && strlen($accessory_info_values['ov_category_image']) > 1){
											$category_image = $accessory_info_values['ov_category_image'];
										}else{
											$category_image = $accessory_info_values['category_image'];
										}
									
			
										if (isset($accessory_info_values['ov_menu_image']) && strlen($accessory_info_values['ov_menu_image']) > 1){
											$menu_image = $accessory_info_values['ov_menu_image'];
										}else{
											$menu_image = $accessory_info_values['menu_image'];
										}
									
										if (isset($accessory_info_values['ov_products_main_cat']) && (int)$accessory_info_values['ov_products_main_cat'] > 0){
											$products_main_cat = $accessory_info_values['ov_products_main_cat'];
										}else{
											$products_main_cat = $accessory_info_values['products_main_cat'];
										}
			
			
										if (isset($accessory_info_values['ov_products_name']) && strlen($accessory_info_values['ov_products_name']) > 1){
											$products_name = $accessory_info_values['ov_products_name'];
										}else{
											$products_name = $accessory_info_values['products_name'];
										}
			
			
										if (isset($accessory_info_values['ov_products_model']) && strlen($accessory_info_values['ov_products_model']) > 1){
											$products_model = $accessory_info_values['ov_products_model'];
										}else{
											$products_model = $accessory_info_values['products_model'];
										}
			
			
										if (isset($accessory_info_values['ov_products_slug']) && strlen($accessory_info_values['ov_products_slug']) > 1){
											$products_slug = $accessory_info_values['ov_products_slug'];
										}else{
											$products_slug = $accessory_info_values['products_slug'];
										}
			
										if (isset($accessory_info_values['ov_products_awards']) && strlen($accessory_info_values['ov_products_awards']) > 0){
											$new_products_awards = $accessory_info_values['ov_products_awards'];
										}else{
											$new_products_awards = $accessory_info_values['products_awards'];
										}
			
			
			
			
			
			
									$accessory_image = (strlen($category_image)>1 ? 'sized/listing/rel_' . $category_image : '');
									
									if  ((int)$accessory_info_values['allow_purchase'] == 1 && DISABLE_ECOMMERCE == 'false'){
										$buy_url = dsf_product_url($accessory_info_values['products_id'] , $products_main_cat, $products_slug, 'action=buy_now');
										$add_url = dsf_product_url($accessory_info_values['products_id'] , $products_main_cat, $products_slug, 'action=buy_now&add=yes');
									}else{
										$buy_url = '';
										$add_url = '';
									}
			
			
			
									if (isset($new_products_awards) && strlen($new_products_awards)>0){
										$acc_split = explode("~" , $new_products_awards);
										
										$products_awards = array();
										
										if (is_array($acc_split)){
													foreach ($acc_split as $spacc){
														$awards_query = dsf_db_query("select sa.awards_name as ov_awards_name, sa.awards_image as ov_awards_image, la.awards_name, la.awards_image from " . DS_DB_SHOP . ".awards sa left join " . DS_DB_LANGUAGE .".awards la on (sa.awards_id = la.awards_id) where sa.awards_id='" . (int)$spacc . "'");
														
														if (dsf_db_num_rows($awards_query) > 0){
																$awards = dsf_db_fetch_array($awards_query);
												
					
					
															if (isset($awards['ov_awards_image']) && strlen($awards['ov_awards_image']) > 1){
																$awards_image = $awards['ov_awards_image'];
															}else{
																$awards_image = $awards['awards_image'];
															}
					
					
															if (isset($awards['ov_awards_name']) && strlen($awards['ov_awards_name']) > 1){
																$awards_name = $awards['ov_awards_image'];
															}else{
																$awards_name = $awards['ov_awards_name'];
															}
					
																$products_awards[] = array('image' => $awards_image,
																							  'title' => $awards_name,
																							  'width' => AWARDS_IMAGE_WIDTH,
																							  'height' => AWARDS_IMAGE_HEIGHT);
																}
														
													}
										
											  unset($acc_split);
											  unset($spacc);
											  unset($acc_item);
										}else{
											$products_awards = '';
										}
									}else{
										$products_awards = '';
									}
				
			
			
			
							$return_array = array('prod_id' => $product,
														   'title' => $products_name,
														  'model' => $products_model,
														  'name' => $products_name,
														  'price' => $accessory_price,
														  'rrp_price' => $rrp_price,
														  'offer_price' => $offer_price,
														 'image' => (strlen($category_image) > 3 ? 'sized/home/' . $category_image : ''),
														 'image_width' => FRONT_IMAGE_WIDTH,
														 'image_height' => FRONT_IMAGE_HEIGHT,
														 'menu_image' => (strlen($menu_image) > 3 ? 'sized/home/' . $menu_image : ''),
														 'menu_image_width' => MENU_IMAGE_WIDTH,
														 'menu_image_height' => MENU_IMAGE_HEIGHT,
														  'allow_purchase' => ((int)$accessory_info_values['allow_purchase'] == 1 ? 'true' : 'false'),
														  'web_exclusive' => ((int)$accessory_info_values['web_exclusive'] == 1 ? 'true' : 'false'),
														  'url' => dsf_product_url($accessory_info_values['products_id'] , $products_main_cat, $products_slug),
														  'buy_url' => $buy_url,
														  'add_url' => $add_url,
														  'awards' => $products_awards
														  );
				
									unset($products_awards);
									
					} // end check if product exists.
}
 
 return $return_array;

}


// #####


function dsf_get_subpage_product_parts_data($product=0){
global $currencies;

$return_array = '';

 if ((int)$product > 0){
 
				// get accessories info
					 $accessory_info_query = dsf_db_query("select sp.products_id, sp.products_name as ov_products_name, sp.products_description as ov_products_description, sp.products_othernames as ov_products_othernames, sp.products_model as ov_products_model, sp.products_main_cat as ov_products_main_cat, sp.products_slug as ov_products_slud, sp.products_image_one as ov_products_image_one, sp.category_image as ov_category_image, sp.products_price, sp.products_tax_class_id, sp.rrp_price, sp.allow_purchase, sp.web_exclusive, sp.products_awards as ov_products_awards, sp.menu_image as ov_menu_image , lp.products_name, lp.products_description, lp.products_othernames, lp.products_model, lp.products_main_cat, lp.products_slug, lp.products_image_one, lp.category_image, lp.products_awards, lp.menu_image from " . DS_DB_SHOP . ".products_parts sp left join " . DS_DB_LANGUAGE . ".products_parts lp on (sp.products_id = lp.products_id) where sp.products_status = '1' and sp.products_id = '" . (int)$product . "'");
						
						
						$accessory_info_values = dsf_db_fetch_array($accessory_info_query);
					
						if ($acc_price = dsf_get_products_parts_special_price($accessory_info_values['products_id'])) {
						  $offer_price = $currencies->display_price($acc_price, dsf_get_tax_rate($accessory_info_values['products_tax_class_id']));
						} else{
						  $offer_price = '';
						}
						
						if ((int)$accessory_info_values['rrp_price'] > 0){
						  $rrp_price = $currencies->display_price($accessory_info_values['rrp_price'], 0);
						}else{
							$rrp_price = '';
						}
						
						  $accessory_price = $currencies->display_price($accessory_info_values['products_price'], dsf_get_tax_rate($accessory_info_values['products_tax_class_id']));
						


							if (isset($accessory_info_values['ov_category_image']) && strlen($accessory_info_values['ov_category_image']) > 1){
								$category_image = $accessory_info_values['ov_category_image'];
							}else{
								$category_image = $accessory_info_values['category_image'];
							}
						

							if (isset($accessory_info_values['ov_menu_image']) && strlen($accessory_info_values['ov_menu_image']) > 1){
								$menu_image = $accessory_info_values['ov_menu_image'];
							}else{
								$menu_image = $accessory_info_values['menu_image'];
							}
						
							if (isset($accessory_info_values['ov_products_main_cat']) && (int)$accessory_info_values['ov_products_main_cat'] > 0){
								$products_main_cat = $accessory_info_values['ov_products_main_cat'];
							}else{
								$products_main_cat = $accessory_info_values['products_main_cat'];
							}


							if (isset($accessory_info_values['ov_products_name']) && strlen($accessory_info_values['ov_products_name']) > 1){
								$products_name = $accessory_info_values['ov_products_name'];
							}else{
								$products_name = $accessory_info_values['products_name'];
							}


							if (isset($accessory_info_values['ov_products_model']) && strlen($accessory_info_values['ov_products_model']) > 1){
								$products_model = $accessory_info_values['ov_products_model'];
							}else{
								$products_model = $accessory_info_values['products_model'];
							}


							if (isset($accessory_info_values['ov_products_slug']) && strlen($accessory_info_values['ov_products_slug']) > 1){
								$products_slug = $accessory_info_values['ov_products_slug'];
							}else{
								$products_slug = $accessory_info_values['products_slug'];
							}

							if (isset($accessory_info_values['ov_products_awards']) && strlen($accessory_info_values['ov_products_awards']) > 1){
								$products_awards = $accessory_info_values['ov_products_awards'];
							}else{
								$products_awards = $accessory_info_values['products_awards'];
							}


						$accessory_image = (strlen($category_image)>1 ? 'sized/listing/rel_' . $category_image : '');
						
						if  ((int)$accessory_info_values['allow_purchase'] == 1 && DISABLE_ECOMMERCE == 'false'){
							$buy_url = dsf_product_url($accessory_info_values['products_id'] , $products_main_cat, $products_slug, 'action=buy_now');
							$add_url = dsf_product_url($accessory_info_values['products_id'] , $products_main_cat, $products_slug, 'action=buy_now&add=yes');
						}else{
							$buy_url = '';
							$add_url = '';
						}



						if (isset($products_awards) && strlen($products_awards)>1){
							$products_awards = array();
							$acc_split = explode("~" , $products_awards);
							
							foreach ($acc_split as $spacc){
									$awards_query = dsf_db_query("select sa.awards_name as ov_awards_name, sa.awards_image as ov_awards_image, la.awards_name, la.awards_image from " . DS_DB_SHOP . ".awards sa left join " . DS_DB_LANGUAGE .".awards la on (sa.awards_id = la.awards_id) where sa.awards_id='" . (int)$spacc . "'");
									
									if (dsf_db_num_rows($awards_query) > 0){
											$awards = dsf_db_fetch_array($awards_query);
							


										if (isset($awards['ov_awards_image']) && strlen($awards['ov_awards_image']) > 1){
											$awards_image = $awards['ov_awards_image'];
										}else{
											$awards_image = $awards['awards_image'];
										}


										if (isset($awards['ov_awards_name']) && strlen($awards['ov_awards_name']) > 1){
											$awards_name = $awards['ov_awards_image'];
										}else{
											$awards_name = $awards['ov_awards_name'];
										}

											$products_awards[] = array('image' => $awards_image,
																		  'title' => $awards_name,
																		  'width' => AWARDS_IMAGE_WIDTH,
																		  'height' => AWARDS_IMAGE_HEIGHT);
											}
									
								}
							
						  unset($acc_split);
						  unset($spacc);
						  unset($acc_item);
						}else{
							$products_awards = '';
						}
	



				$return_array = array('prod_id' => $product,
											   'title' => $products_name,
											  'model' => $products_model,
											  'name' => $products_name,
											  'price' => $accessory_price,
											  'rrp_price' => $rrp_price,
											  'offer_price' => $offer_price,
											 'image' => (strlen($category_image) > 3 ? 'sized/home/' . $category_image : ''),
											 'image_width' => FRONT_IMAGE_WIDTH,
											 'image_height' => FRONT_IMAGE_HEIGHT,
											 'menu_image' => (strlen($menu_image) > 3 ? 'sized/home/' . $menu_image : ''),
											 'menu_image_width' => MENU_IMAGE_WIDTH,
											 'menu_image_height' => MENU_IMAGE_HEIGHT,
											  'allow_purchase' => ((int)$accessory_info_values['allow_purchase'] == 1 ? 'true' : 'false'),
											  'web_exclusive' => ((int)$accessory_info_values['web_exclusive'] == 1 ? 'true' : 'false'),
											  'url' => dsf_product_url($accessory_info_values['products_id'] , $products_main_cat, $products_slug),
											  'buy_url' => $buy_url,
											  'add_url' => $add_url,
											  'awards' => $products_awards
											  );
 	
 	  					unset($products_awards);
}
 
 return $return_array;

}

// ####


// return all possible categories from under the current category

  function dsf_nav_tree($parent_id=0, $spacing = '', $ending = '', $category_tree_array = '', $loopcount = '', $current_parent=0, $foolcat=0) {

    if (((int)$current_parent > 0 ) && (int)$current_parent == (int)$foolcat){
	
			$additional_where = "and sc.main_category='1' ";
	}else{
			$additional_where = '';
	}
	
	
	
		$categories_query_raw = "select sc.categories_id, sc.categories_name as ov_categories_name, sc.parent_id, sc.category_type, sc.virtual_category, sc.subpage, lc.categories_name from " . DS_DB_SHOP . ".categories sc left join " . DS_DB_LANGUAGE . ".categories lc on (sc.categories_id = lc.categories_id) where sc.parent_id = '" . (int)$parent_id . "' ". $additional_where . "and sc.categories_status='1' order by sc.sort_order, sc.categories_name, lc.categories_name";

		// first of all check for records
		if (dsf_db_num_rows(dsf_db_query($categories_query_raw)) > 0) {
		  
		   
		   if (!$spacing){
			   $category_tree_array.='<ul>' . "\n"; // create initial block requires id
			   $spacing = "yes";
			   $loopcount = 1;
			 }else{
			  $category_tree_array.= "\n" . '  <ul>' . "\n"; // create blocks thereafter
				$loopcount ++; 
		  }
		  
		  
			$categories_query = dsf_db_query($categories_query_raw);
		
			while ($categories = dsf_db_fetch_array($categories_query)) {
			   
			   
			   
							if (isset($categories['ov_categories_name']) && strlen($categories['ov_categories_name']) > 1){
								$categories_name = $categories['ov_categories_name'];
							}else{
								$categories_name = $categories['categories_name'];
							}

			   
			
						// loop for sub-categories.
					 
				   $count_query_raw = "select sc.categories_id from " . DS_DB_SHOP . ".categories sc where sc.parent_id = '" . (int)$categories['categories_id'] . "' ". $additional_where . "order by sc.sort_order";
					if (dsf_db_num_rows(dsf_db_query($count_query_raw)) > 0) {
							  // we have submenu, so don't close the line yet. look for sub menus.
								  
						// This is a clickable menu, there are subfolders below it.
						// check for subhome page.
							
								$category_tree_array .= '     <li><a href="' .dsf_category_url($categories['categories_id']) . '">' . $categories_name . '</a>' . "\n      ";
							 
							 $ending ='</li>';
							 $category_tree_array = dsf_nav_tree($categories['categories_id'], $spacing, $ending, $category_tree_array, $loopcount, $current_parent, $foolcat);
					}else{
						// there are no submenus
						// decide reference depending on category type and echo results.
						
						if ($categories['category_type'] == '1'){
							// virtual category .
		
						
						}else{ // not a virtual category
						
						$category_tree_array .= '     <li><a href="' . dsf_category_url($categories['categories_id']) . '" >' . $categories_name . '</a></li>' . "\n";
						
						}
						
						
					}
					
			}
		
			if ($loopcount >1){
				$category_tree_array.= '</ul>' . $ending . "\n"; // end block
				$ending = '';
			}else{
				$category_tree_array.= '</ul>' . "\n"; // end block
			}
		}



    return $category_tree_array;
  }


// ####

  function dsf_site_cat_tree($parent_id = '0', $spacing = '', $ending = '', $category_tree_array = '', $loopcount = 0, $max_count=500) {

   if ($loopcount <= $max_count ){
   
		$categories_query_raw = "select sc.categories_id, sc.categories_name as ov_categories_name, sc.parent_id, sc.category_type, sc.virtual_category, sc.subpage, lc.categories_name from " . DS_DB_SHOP . ".categories sc left join " . DS_DB_LANGUAGE . ".categories lc on (sc.categories_id = lc.categories_id) where sc.parent_id = '" . (int)$parent_id . "' and sc.categories_status='1' and sc.category_type='0' order by sc.sort_order";
		
				// first of all check for records
				if (dsf_db_num_rows(dsf_db_query($categories_query_raw)) > 0) {
				  
				   
				   if (!$spacing){
					   $category_tree_array.='<ul>' . "\n"; // create initial block requires id
					   $spacing = "yes";
					   $loopcount = 1;
					 }else{
					  $category_tree_array.= "\n" . '  <ul>' . "\n"; // create blocks thereafter
						$loopcount ++; 
				  }
				  
				  
					$categories_query = dsf_db_query($categories_query_raw);
				
					while ($categories = dsf_db_fetch_array($categories_query)) {
					   
			   
							if (isset($categories['ov_categories_name']) && strlen($categories['ov_categories_name']) > 1){
								$categories_name = $categories['ov_categories_name'];
							}else{
								$categories_name = $categories['categories_name'];
							}

					
								// loop for sub-categories.
							 
						   $count_query_raw = "select categories_id from " . DS_DB_SHOP . ".categories where parent_id = '" . (int)$categories['categories_id'] . "' and category_type='0' order by sort_order";
				
							if (dsf_db_num_rows(dsf_db_query($count_query_raw)) > 0) {
									  // we have submenu, so don't close the line yet. look for sub menus.
										  
								// This is a clickable menu, there are subfolders below it.
								// check for subhome page.
									
										$category_tree_array .= '     <li><a href="' .dsf_category_url($categories['categories_id']) . '">' . $categories_name . '</a>';
									 
									 $ending ='</li>';
									 $category_tree_array = dsf_site_cat_tree($categories['categories_id'], $spacing, $ending, $category_tree_array, $loopcount);
							}else{
								// there are no submenus
								// decide reference depending on category type and echo results.
								
								
								$category_tree_array .= '     <li><a href="' . dsf_category_url($categories['categories_id']) . '">' . $categories_name . '</a></li>' . "\n";
								
								
								
							}
							
					}
				
					if ($loopcount >1){
						$category_tree_array.= '</ul>' . $ending . "\n"; // end block
						$ending = '';
					}else{
						$category_tree_array.= '</ul>' . "\n"; // end block
					}
				}

	}else{
		// we have gone over the count requested therefore just return what we already have
	}

    return $category_tree_array;
  }

// ###


function dsf_get_article_one_cat($article_id=0, $loopstopper=1, $article_category=0){

	
	if ((int)$article_id > 0){
	
		// only proceed if we haven't already got a category number
		if ((int)$article_category == 0){
		
								$categories_query = dsf_db_query("SELECT article_id, article_category, parent_id FROM " . DS_DB_SHOP . ".article_one WHERE article_id = '". $article_id . "'");
								$categories = dsf_db_fetch_array($categories_query);
				
					
					if ((int)$categories['article_category'] > 0){
							// we have a number
							$article_category = $categories['article_category'];
							
					}else{
							// see if we can find the next level down.
							
							if ($categories['parent_id'] == 0){
							   // we are at the highest level,  if we dont have a category_id by now we dont have one.
							   $article_category = 0;
							 }else{
								$loopstopper ++;
									if ($loopstopper < 4) { // max 4 links down, stops loops on rouge unlinked categories.
					
											$article_category = dsf_get_article_one_cat($categories['parent_id'], $loopstopper);
									}
							}
					}
		 }	

	}
	return $article_category;

}

// ###


function dsf_get_article_two_cat($article_id, $loopstopper=1, $article_category=0){

	
	if ((int)$article_id > 0){
	
		// only proceed if we haven't already got a category number
		if ((int)$article_category == 0){
		
								$categories_query = dsf_db_query("SELECT article_id, article_category, parent_id FROM " . DS_DB_SHOP . ".article_two WHERE article_id = '". $article_id . "'");
								$categories = dsf_db_fetch_array($categories_query);
				
					if ($categories['parent_id'] == 0){
					   // we are at the highest level,  if we dont have a category_id by now we dont have one.
					 }else{
						$loopstopper ++;
							if ($loopstopper < 4) { // max 4 links down, stops loops on rouge unlinked categories.
			
									$article_category = dsf_get_article_two_cat($categories['parent_id'], $loopstopper, $categories['article_category']);
							}
					}
		 }	

	}
	return $article_category;

}

// ###


function dsf_get_article_three_cat($article_id, $loopstopper=1, $article_category=0){

	
	if ((int)$article_id > 0){
	
		// only proceed if we haven't already got a category number
		if ((int)$article_category == 0){
		
								$categories_query = dsf_db_query("SELECT article_id, article_category, parent_id FROM " . DS_DB_SHOP . ".article_three WHERE article_id = '". $article_id . "'");
								$categories = dsf_db_fetch_array($categories_query);
				
					if ($categories['parent_id'] == 0){
					   // we are at the highest level,  if we dont have a category_id by now we dont have one.
					 }else{
						$loopstopper ++;
							if ($loopstopper < 4) { // max 4 links down, stops loops on rouge unlinked categories.
			
									$article_category = dsf_get_article_three_cat($categories['parent_id'], $loopstopper, $categories['article_category']);
							}
					}
		 }	

	}
	return $article_category;

}

// ###


// STRTOUPPER AND STRTOLOWER ALTERNATIVE FOR FOREIGN CHARACTER SETS
// ################################################################
define("DS_UC_CHARS", "�������A�CE����������N������SL�����ZZ");
define("DS_LC_CHARS", "�������a�ce����������n������sl�����zz");

function ds_strtoupper($str) {


// PREVIOUS code written originally for Remington where unknowingly the problem with the
// database connection make all the wrongs look write however, it totally doesn't work
// when on a correct connection like russellhobbs.

		if (DEFAULT_CHARSET == 'utf-8'){
			// we could have problems here depending on whether the
			// collation has been setup correctly and then even if it has whether
			// or not the function actually exists (it doesn't for Arcos server
			
						$cnvrt = 'utf-8';
						
						
						if (defined('DS_DB_COLLATION')){
							// it is defined now check for utf8
						
									if (DS_DB_COLLATION == 'utf8'){
					
											if (function_exists('mysql_set_charset')){
												
												// excellent we have all connections setup correctly,  data should be stored
												// in raw utf8
												$cnvrt = 'utf-8';
												
			
											}else{
												// function does not exists therefore back to latin connection
												$cnvrt = 'latin';
											}
									}else{
										// definition defined wrong therefore back to latin connection
												$cnvrt = 'latin';
									}
									
						}else{
							// definition does not exist therefore back to latin connection
												$cnvrt = 'latin';
							
						}
						
					
					if ($cnvrt == 'utf-8'){
						// pure utf8 - great to work with
						
						$new_string = mb_strtoupper($str, 'utf-8');
					
					}else{
						
						// wrongly encoded so we have latin connection regardless of reason
						
						$new_string = strtoupper($str);
						
					}
						
			
		}else{
			
			// we are latin character set
			
			$new_string = mb_strtoupper($str, 'iso-8859-1');
			
		}

return $new_string;



}

// ####



function ds_strtolower($str) {


// PREVIOUS code written originally for Remington where unknowingly the problem with the
// database connection dmake all the wrongs look write however, it totally doesn't work
// when on a correct connection like russellhobbs.


		if (DEFAULT_CHARSET == 'utf-8'){
			// we could have problems here depending on whether the
			// collation has been setup correctly and then even if it has whether
			// or not the function actually exists (it doesn't for Arcos server
			
						$cnvrt = 'utf-8';
						
						
						if (defined('DS_DB_COLLATION')){
							// it is defined now check for utf8
						
									if (DS_DB_COLLATION == 'utf8'){
					
											if (function_exists('mysql_set_charset')){
												
												// excellent we have all connections setup correctly,  data should be stored
												// in raw utf8
												$cnvrt = 'utf-8';
												
			
											}else{
												// function does not exists therefore back to latin connection
												$cnvrt = 'latin';
											}
									}else{
										// definition defined wrong therefore back to latin connection
												$cnvrt = 'latin';
									}
									
						}else{
							// definition does not exist therefore back to latin connection
												$cnvrt = 'latin';
							
						}
						
					
					if ($cnvrt == 'utf-8'){
						// pure utf8 - great to work with
						
						$new_string = mb_strtolower($str, 'utf-8');
					
					}else{
						
						// wrongly encoded so we have latin connection regardless of reason
						
						$new_string = strtolower($str);
						
					}
						
			
		}else{
			
			// we are latin character set
			
			$new_string = mb_strtolower($str, 'iso-8859-1');
			
		}

return $new_string;


}


// #####




function dsf_de_date($raw_date){
    if ( ($raw_date == '0000-00-00 00:00:00') || empty($raw_date) ) return false;

    $year = substr($raw_date, 0, 4);
    $month = (int)substr($raw_date, 5, 2);
    $day = (int)substr($raw_date, 8, 2);
    $hour = (int)substr($raw_date, 11, 2);
    $minute = (int)substr($raw_date, 14, 2);
    $second = (int)substr($raw_date, 17, 2);

    if (@date('Y', mktime($hour, $minute, $second, $month, $day, $year)) == $year) {
      return date('d.m.Y', mktime($hour, $minute, $second, $month, $day, $year));
    } else {
      return '';
    }
}

// ###


function dsf_get_products_parts_breadcrumb_tree($categories_id, $loopstopper = 1, $required_name ='', $range_id=0, $ignore_top=0){
		
		// prevent problems with url if categories id is not set but range id is.
		
		if ((int)$categories_id == 0 && (int)$range_id > 0){
				// do range only
			
			$categories_query = dsf_db_query("SELECT sr.range_name as ov_range_name, lr.range_name FROM " . DS_DB_SHOP . ".ranges sr left join " . DS_DB_LANGUAGE . ".ranges lr on (sr.range_id = lr.range_id) WHERE sr.range_id = '". $range_id . "'");
			$categories = dsf_db_fetch_array($categories_query);


			if (isset($catgories['ov_range_name']) && strlen($categories['ov_range_name']) > 1){
				$range_name = $categories['ov_range_name'];
			}else{
				$range_name = $categoreis['range_name'];
			}
			



			$required_name = '<li><a href="' . dsf_range_url($range_id) . '">' .$range_name . '</a>' . BREADCRUMB_SEPERATOR . '</li>' . $required_name;
				
				
		}else{
			// standard routine
								$categories_query = dsf_db_query("SELECT sc.categories_id, sc.parent_id, sc.categories_name as ov_categories_name, lc.categories_name FROM " . DS_DB_SHOP .".categories_parts sc left join " . DS_DB_LANGUAGE . ".categories_parts lc on (sc.categories_id = lc.categories_id)  WHERE sc.categories_id = '". (int)$categories_id . "'");
								$categories = dsf_db_fetch_array($categories_query);
				
				
								if (isset($categories['ov_categories_name']) && strlen($categories['ov_categories_name']) > 1){
									$category_name = $categories['ov_categories_name'];
								}else{
									$category_name = $categories['categories_name'];
								}
				
				
					if ($categories['parent_id'] ==0){
					  
					  if ($ignore_top == 1){ 
					  	// not putting upper item in so leave required name as it was before.
						  }else{
						  
						   if ($required_name){
								$required_name = '<li><a href="' . dsf_category_parts_url($categories['categories_id'], '','',true,$range_id) . '">' .$category_name . '</a>' .  BREADCRUMB_SEPERATOR . '</li>' . $required_name;
						   }else{
								$required_name = '<li><a href="' . dsf_category_parts_url($categories['categories_id'], '','',true,$range_id) . '">' . $category_name . '</a></li>';
						   }
					   
					   }
					   
					 }else{
						$loopstopper ++;
							if ($loopstopper < 6) { // max 4 links down, stops loops on rouge unlinked categories.
			
									if($required_name){
														$required_name = dsf_get_products_parts_breadcrumb_tree($categories['parent_id'], $loopstopper, '<li><a href="' . dsf_category_parts_url($categories['categories_id'], '','',true,$range_id) . '">' . $category_name . '</a>'  . BREADCRUMB_SEPERATOR . '</li>' .  $required_name, $range_id, $ignore_top);
									}else{
														$required_name = dsf_get_products_parts_breadcrumb_tree($categories['parent_id'], $loopstopper, '<li><a href="' . dsf_category_parts_url($categories['categories_id'], '','',true,$range_id) . '">' . $category_name . '</a></li>',$range_id,$ignore_top);
									}
							}
					}
		}

return $required_name;
}

// ###

 function dsf_get_category_parts_name($cat_id){
  $category_query = dsf_db_query("select sp.categories_name as ov_categories_name,  lp.categories_name from " . DS_DB_SHOP . ".categories_parts sp left join " . DS_DB_LANGUAGE . ".categories_parts lp on (sp.categories_id = lp.categories_id) where sp.categories_id ='" . (int)$cat_id . "'");
  $category = dsf_db_fetch_array($category_query);
  
			if (isset($category['ov_categories_name']) && strlen($category['ov_categories_name']) > 1){
				$categories_name = $category['ov_categories_name'];
			}else{
				$categories_name = $category['categories_name'];
			}
  
  return $categories_name;
  }


// ###



  function dsf_site_cat_parts_tree($parent_id = '0', $spacing = '', $ending = '', $category_tree_array = '', $loopcount = 0, $max_count=500) {

   if ($loopcount <= $max_count ){
   
		$categories_query_raw = "select sc.categories_id, sc.categories_name as ov_categories_name, sc.parent_id, sc.category_type, sc.virtual_category, sc.subpage, lc.categories_name from " . DS_DB_SHOP . ".categories_parts sc left join " . DS_DB_LANGUAGE . ".categories_parts lc on (sc.categories_id = lc.categories_id) where sc.parent_id = '" . (int)$parent_id . "' and sc.categories_status='1' and sc.category_type='0' order by sc.sort_order";
		
				// first of all check for records
				if (dsf_db_num_rows(dsf_db_query($categories_query_raw)) > 0) {
				  
				   
				   if (!$spacing){
					   $category_tree_array.='<ul>' . "\n"; // create initial block requires id
					   $spacing = "yes";
					   $loopcount = 1;
					 }else{
					  $category_tree_array.= "\n" . '  <ul>' . "\n"; // create blocks thereafter
						$loopcount ++; 
				  }
				  
				  
					$categories_query = dsf_db_query($categories_query_raw);
				
					while ($categories = dsf_db_fetch_array($categories_query)) {
					   
			   
							if (isset($categories['ov_categories_name']) && strlen($categories['ov_categories_name']) > 1){
								$categories_name = $categories['ov_categories_name'];
							}else{
								$categories_name = $categories['categories_name'];
							}

					
								// loop for sub-categories.
							 
						   $count_query_raw = "select categories_id from " . DS_DB_SHOP . ".categories_parts where parent_id = '" . (int)$categories['categories_id'] . "' and category_type='0' order by sort_order";
				
							if (dsf_db_num_rows(dsf_db_query($count_query_raw)) > 0) {
									  // we have submenu, so don't close the line yet. look for sub menus.
										  
								// This is a clickable menu, there are subfolders below it.
								// check for subhome page.
									
										$category_tree_array .= '     <li><a href="' .dsf_category_parts_url($categories['categories_id']) . '">' . $categories_name . '</a>';
									 
									 $ending ='</li>';
									 $category_tree_array = dsf_site_cat_parts_tree($categories['categories_id'], $spacing, $ending, $category_tree_array, $loopcount);
							}else{
								// there are no submenus
								// decide reference depending on category type and echo results.
								
								
								$category_tree_array .= '     <li><a href="' . dsf_category_parts_url($categories['categories_id']) . '">' . $categories_name . '</a></li>' . "\n";
								
								
								
							}
							
					}
				
					if ($loopcount >1){
						$category_tree_array.= '</ul>' . $ending . "\n"; // end block
						$ending = '';
					}else{
						$category_tree_array.= '</ul>' . "\n"; // end block
					}
				}

	}else{
		// we have gone over the count requested therefore just return what we already have
	}

    return $category_tree_array;
  }

// ###





  function dsf_get_products_parts_special_price($product_id) {
    $product_query = dsf_db_query("select specials_new_products_price from " . DS_DB_SHOP . ".specials_parts where products_id = '" . (int)$product_id . "' and status='1'");
    $product = dsf_db_fetch_array($product_query);

    return $product['specials_new_products_price'];
  }


// ###


  function dsf_get_product_parts_category($products_id) {

    $category_query = dsf_db_query("select products_main_cat from " . DS_DB_SHOP . ".products_parts where products_id = '" . (int)$products_id . "'");
    if (dsf_db_num_rows($category_query)) {
      $category = dsf_db_fetch_array($category_query);

      $dsv_category_id = $category['products_main_cat'];
    }

    return $dsv_category_id;
  }

// ###



 function dsf_get_category_parts_title($cat_id){
  
	$categories_title = '';

								$categories_query = dsf_db_query("SELECT sc.categories_id, sc.parent_id, sc.categories_title as ov_categories_title, lc.categories_title FROM " . DS_DB_SHOP .".categories_parts sc left join " . DS_DB_LANGUAGE . ".categories_parts lc on (sc.categories_id = lc.categories_id)  WHERE sc.categories_id = '". (int)$cat_id . "'");
								$categories = dsf_db_fetch_array($categories_query);
		
								if (isset($categories['ov_categories_title']) && strlen($categories['ov_categories_title']) > 1){
									$categories_title = $categories['ov_categories_title'];
								}else{
									$categories_title = $categories['categories_title'];
								}



  return $categories_title;
  }

// ###


  function dsf_stock_parts($products_id, $products_quantity) {
    $stock_left = dsf_get_products_parts_stock($products_id) - $products_quantity;
    
	if ((int)$stock_left >= 0 ){
			$out_of_stock = 1;
	}else{
			$out_of_stock = 0;
	}
	
    return $out_of_stock;
  }


// ###

  function dsf_check_parts_stock($products_id, $products_quantity) {
    $stock_left = dsf_get_products_parts_stock($products_id) - $products_quantity;
    $out_of_stock = '';

    if ($stock_left < 0) {
      $out_of_stock = '<span class="insufficientStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '</span>';
		  if (dsf_get_products_parts_stock($products_id) > 0){
		   $out_of_stock = '<span class="insufficientStock">' . STOCK_MARK_PRODUCT_INSUFFICIENT_STOCK . '<br>Only ' . dsf_get_products_stock($products_id) .' available</span>';
		  }
	}

    return $out_of_stock;
  }


// ###


function dsf_get_basket_parts_image($product_id, $iwidth='', $iheight=''){

if (!$iwidth) $iwidth = BASKET_IMAGE_WIDTH;
if (!$iheight) $iheight = BASKET_IMAGE_HEIGHT;


			$products_query = dsf_db_query("SELECT sp.category_image as ov_category_image, sp.products_name as ov_products_name, lp.category_image,  lp.products_name FROM " . DS_DB_SHOP .".products_parts sp left join " . DS_DB_LANGUAGE . ".products_parts lp on (sp.products_id = lp.products_id)  WHERE sp.products_id = '". $product_id . "'");
			$products = dsf_db_fetch_array($products_query);


			if (isset($products['ov_category_image']) && strlen($products['ov_category_image']) > 1){
				$category_image = $products['ov_category_image'];
			}elseif (isset($products['category_image']) && strlen($products['category_image']) > 1){
				$category_image = $products['category_image'];
			}else{
				
						if (file_exists(DS_IMAGES_FOLDER . LANGUAGE_URL_SUFFIX . '_error_noimageavailable.png')){
								$category_image = LANGUAGE_URL_SUFFIX . '_error_noimageavailable.png';
						}else{
								$category_image = LANGUAGE_URL_SUFFIX . '_error_noimageavailable.gif';
						}

			}
			
			
			if (isset($products['ov_products_name']) && strlen($products['ov_products_name']) > 1){
				$products_name = $products['ov_products_name'];
			}else{
				$products_name = $products['products_name'];
			}
				
				
		$theimage = dsf_thumb_image(DS_IMAGES_FOLDER . $category_image, $products_name, $iwidth, $iheight);



return $theimage;
}

// ###


// get manufacturers name from id number
  function dsf_get_manufacturers_name($manufacturers_id) {

    $manufacturers_query = dsf_db_query("select sm.manufacturers_name as ov_manufacturers_name, lm.manufacturers_name from " . DS_DB_SHOP . ".manufacturers sm left join " . DS_DB_LANGUAGE . ".manufacturers lm on (sm.manufacturers_id = lm.manufacturers_id) where sm.manufacturers_id = '" . (int)$manufacturers_id ."'");
    $manufacturers = dsf_db_fetch_array($manufacturers_query);
   
   
 			if (isset($manufacturers['ov_manufacturers_name']) && strlen($manufacturers['ov_manufacturers_name']) > 1){
				$manufacturers_name = $manufacturers['ov_manufacturers_name'];
			}else{
				$manufacturers_name = $manufacturers['manufacturers_name'];
			}
  
   
   
    return $manufacturers_name;
  }

// ###


function dsf_get_groups_name ($group_id=0, $group_value=0){

if ((int)$group_id < 1 ||(int)$group_value < 1){
	return false;
}

	$group_query = dsf_db_query("select sg.group_value_name as ov_group_value_name, lg.group_value_name from " . DS_DB_SHOP . ".groups_values sg left join " . DS_DB_LANGUAGE . ".group_values lg on (sg.group_id = lg.group_id) where sg.group_id='" . (int)$group_id  . "' and sg.group_value_id='" . (int)$group_value . "'");
	$group_info = dsf_db_fetch_array($group_query);


 			if (isset($group_info['ov_group_value_name']) && strlen($group_info['ov_group_value_name']) > 1){
				$group_value_name = $group_info['ov_group_value_name'];
			}else{
				$group_value_name = $group_info['group_value_name'];
			}


	return $group_value_name;
}

// ###


// funtion to return an array of category information from the 'FILTERS' GET VAR
function dsf_get_filter_array($filter, $over_ride='false', $specific_type=''){
global $dsv_category_id;

// break them down into their seperate categories
$new_filters = explode('_cat_', $filter);

// break them down further.

$cat_filter_array = array();

 for($i=0, $n=sizeof($new_filters); $i<$n; $i++) {
		 if (strlen($new_filters[$i]) > 1){
				// we have items
				$breakdown_array = explode('__', $new_filters[$i]);
				
				$cat_breakdown_id = $breakdown_array[0];
				
				if ($over_ride == 'false'){
					$ensure_category = dsf_confirm_valid_category($cat_breakdown_id, $dsv_category_id);
				}
				
				if ($ensure_category == 'valid' || $over_ride == 'true'){
				
						$cat_filter_array[] = array ('category' => $cat_breakdown_id,
												 'filter_type' => dsf_find_category_filter_type($breakdown_array[0], $specific_type),
												 'id' => $breakdown_array[1],
												 'value' => $breakdown_array[2]
												 );
		
				} // end ensure valid category if
		 } // end if
 } // end for
return $cat_filter_array;
}



// ###




function dsf_confirm_valid_category($category_id=0, $parent_id=0){
			$confirm_query_raw = dsf_db_query("select categories_id from " . DS_DB_SHOP . ".categories where categories_id ='" . (int)$category_id . "' and parent_id = '" . (int)$parent_id . "'");
			
			if (dsf_db_num_rows($confirm_query_raw) >0){
				$return_value = 'valid';
			}else{
				$return_value = 'invalid';
			}
return $return_value;
}

// ###


function dsf_find_category_filter_type($category_id, $specific=''){
	
	if (isset($specific) && strlen($specific) >1){
		$cat_info = $specific;
	}else{
		
				$cat_query = dsf_db_query("select sc.virtual_category as ov_virtual_category, sc.category_type as ov_category_type, lc.virtual_category, lc.category_type from " . DS_DB_SHOP . ".categories sc left join " . DS_DB_LANGUAGE . ".categories lc on (sc.categories_id = lc.categories_id) where sc.categories_id ='" . (int)$category_id . "'");
				$cat_results = dsf_db_fetch_array ($cat_query);
				
				
				
 			if (isset($cat_results['ov_virtual_category']) && strlen($cat_results['ov_virtual_category']) > 1){
				$vcat = $cat_results['ov_virtual_category'];
			}else{
				$vcat = $cat_results['virtual_category'];
			}

				
 			if (isset($cat_results['ov_category_type']) && strlen($cat_results['ov_category_type']) > 1){
				$cattype = $cat_results['ov_category_type'];
			}else{
				$cattype = $cat_results['category_type'];
			}

				
				
				
				$cat_info = '';
				
					if ((int)$cattype == 1){
						
						$vc_split = explode(":",$vcat);
														
						if ($vcat == 'Brand'){
								$cat_info = 'Brand';
														
						}elseif ($vcat == 'Price'){
								$cat_info = 'Price';
						
						}elseif ($vc_split[0] == 'Group'){
								$cat_info = 'Group';
						}else {
								$cat_info = 'Filter';
						}
					}else{
						// not virtual
						$cat_info = 'Standard';
						
					}
			
		}
	return $cat_info;
}

// ###


function dsf_get_filter_price ($cat_id=0, $price_from=0, $price_to=0){

   
		$price_query = dsf_db_query("select sc.price_range_1 as ov_price_range_1, sc.price_range_2 as ov_price_range_2, sc.price_range_3 as ov_price_range_3, lc.price_range_1, lc.price_range_2, lc.price_range_3 from " . DS_DB_SHOP . ".categories sc left join " . DS_DB_LANGUAGE . ".categories lc on (sc.categories_id = lc.categories_id) where sc.categories_id = '" . (int)$cat_id . "'");
		

		$price_ranges = dsf_db_fetch_array($price_query);

 			if (isset($price_ranges['ov_price_range_1']) && strlen($price_ranges['ov_price_range_1']) > 1){
				$prange_1 = $price_ranges['ov_price_range_1'];
			}else{
				$prange_1 = $price_ranges['price_range_1'];
			}


 			if (isset($price_ranges['ov_price_range_2']) && strlen($price_ranges['ov_price_range_2']) > 1){
				$prange_2 = $price_ranges['ov_price_range_2'];
			}else{
				$prange_2 = $price_ranges['price_range_2'];
			}

 			if (isset($price_ranges['ov_price_range_3']) && strlen($price_ranges['ov_price_range_3']) > 1){
				$prange_3 = $price_ranges['ov_price_range_3'];
			}else{
				$prange_3 = $price_ranges['price_range_3'];
			}


$linereturn = '';

if ((int)$price_from == 0){
	$linereturn = '0';
}elseif ($price_from == $prange_1){
	$linereturn =  $prange_1;
}elseif ($price_from == $prange_2){
	$linereturn =  $prange_2;
}elseif ($price_from == $prange_3){
	$linereturn =  $prange_3;
}

if ((int)$price_to >0){
	if ($price_to == $prange_1){
		$linereturn .=  $prange_1;
	}elseif ($price_to == $prange_2){
		$linereturn .=  $prange_2;
	}elseif ($price_to == $prange_3){
		$linereturn .=  $prange_3;
	}
}else{
	$linereturn .= '+';
}

return $linereturn;
}

// ###


// return a products awards images.
function dsf_return_awards_array($product_id){
		
			$product_query = dsf_db_query("select sp.products_awards as ov_products_awards, lp. products_awards from " . DS_DB_SHOP . ".products sp left join " . DS_DB_LANGUAGE . ".products lp on (sp.products_id = lp.products_id)  where sp.products_id = '" . (int)$product_id ."'");
			$product = dsf_db_fetch_array($product_query);

					$pawards = (strlen($product['ov_products_awards']) >0 ? $product['ov_products_awards'] : $product['products_awards']);

					if (isset($pawards) && strlen($pawards)>1){
							$products_awards = array();
							$acc_split = explode("~" , $pawards);
							
							foreach ($acc_split as $spacc){
									$awards_query = dsf_db_query("select sa.awards_name as ov_awards_name, sa.awards_image as ov_awards_image, sa.small_image as ov_small_image, la.awards_name, la.awards_image, la.small_image from " . DS_DB_SHOP . ".awards sa left join " . DS_DB_LANGUAGE . ".awards la on (sa.awards_id = la.awards_id)  where sa.awards_id='" . (int)$spacc . "'");
									
									if (dsf_db_num_rows($awards_query) > 0){
											$awards = dsf_db_fetch_array($awards_query);
							
											$products_awards[] = array('image' => (strlen($awards['ov_awards_image']) >0 ? $awards['ov_awards_image'] : $awards['awards_image']),
																		  'title' => (strlen($awards['ov_awards_name']) >0 ? $awards['ov_awards_name'] : $awards['awards_name']),
																		  'width' => AWARDS_IMAGE_WIDTH,
																		  'height' => AWARDS_IMAGE_HEIGHT,
																		  'small_image' => (strlen($awards['ov_small_image']) >0 ? $awards['ov_small_image'] : $awards['small_image'])
																		  );
											}
									
								}
							
						  unset($acc_split);
						  unset($spacc);
						  unset($acc_item);
					}else{
						$products_awards = '';
					}
	return $products_awards;	
}


// ###



function dsf_get_product_flat_delivery_charge($product) {
	global $currencies;
	
 $query = dsf_db_query("select p.products_price, p.products_tax_class_id, s.specials_new_products_price, s.status from " . DS_DB_SHOP . ".products p left join " . DS_DB_SHOP . ".specials s on (p.products_id = s.products_id) where p.products_id = '" . (int)$product . "'");
    $results = dsf_db_fetch_array($query);
	
	$pprice = $currencies->display_numeric_price($results['products_price'], dsf_get_tax_rate($results['products_tax_class_id']));
	
	if (isset($results['status'])){
		if ((int)$results['specials_new_products_price'] > 0 && (int)$results['status'] == 1){
			$pprice = $currencies->display_numeric_price($results['specials_new_products_price'], dsf_get_tax_rate($results['products_tax_class_id']));
		}
	}

// based on price of product,  decide delivery charge,  thes are hardocoded into the flat rate.
if (defined('MODULE_SHIPPING_FLAT_FREE_VALUE') && (int)MODULE_SHIPPING_FLAT_FREE_VALUE > 0){
	
	if ((float)$pprice < (float)MODULE_SHIPPING_FLAT_FREE_VALUE) {
		
		$del_charge_value = $currencies->display_numeric_price(MODULE_SHIPPING_FLAT_COST, dsf_get_tax_rate($results['products_tax_class_id']));
		
		if ((int)MODULE_SHIPPING_FLAT_COST > 0){
				$del_charge_text = $currencies->display_price(MODULE_SHIPPING_FLAT_COST, dsf_get_tax_rate($results['products_tax_class_id']));
		}else{
			// it is free
				$del_charge_text = TRANSLATION_CHECKOUT_FREE;
		}
		
		
	}else{
		
		// must be free
		$del_charge_value = 0;
		$del_charge_text = TRANSLATION_CHECKOUT_FREE;
	}

}else{
	// free not defined or not over 0 therefore delivery charge applicable.
	
		$del_charge_value = $currencies->display_numeric_price(MODULE_SHIPPING_FLAT_COST, dsf_get_tax_rate($results['products_tax_class_id']));

		if ((int)MODULE_SHIPPING_FLAT_COST > 0){
				$del_charge_text = $currencies->display_price(MODULE_SHIPPING_FLAT_COST, dsf_get_tax_rate($results['products_tax_class_id']));
		}else{
			// it is free
				$del_charge_text = TRANSLATION_CHECKOUT_FREE;
		}
	
}

return array('cost' => $del_charge_value,
			 'text' => $del_charge_text);

	
}

// ###


function dsf_get_product_parts_flat_delivery_charge($product) {
	global $currencies;
	
 $query = dsf_db_query("select p.products_price, p.products_tax_class_id, s.specials_new_products_price, s.status from " . DS_DB_SHOP . ".products_parts p left join " . DS_DB_SHOP . ".specials_parts s on (p.products_id = s.products_id) where p.products_id = '" . (int)$product . "'");
    $results = dsf_db_fetch_array($query);
	
	$pprice = $currencies->display_numeric_price($results['products_price'], dsf_get_tax_rate($results['products_tax_class_id']));
	
	if (isset($results['status'])){
		if ((int)$results['specials_new_products_price'] > 0 && (int)$results['status'] == 1){
			$pprice = $currencies->display_numeric_price($results['specials_new_products_price'], dsf_get_tax_rate($results['products_tax_class_id']));
		}
	}

// based on price of product,  decide delivery charge,  thes are hardocoded into the flat rate.
if (defined('MODULE_SHIPPING_FLAT_FREE_VALUE') && (int)MODULE_SHIPPING_FLAT_FREE_VALUE > 0){
	
	if ((float)$pprice < (float)MODULE_SHIPPING_FLAT_FREE_VALUE) {
		
		$del_charge_value = $currencies->display_numeric_price(MODULE_SHIPPING_FLAT_COST, dsf_get_tax_rate($results['products_tax_class_id']));
		
		if ((int)MODULE_SHIPPING_FLAT_COST > 0){
				$del_charge_text = $currencies->display_price(MODULE_SHIPPING_FLAT_COST, dsf_get_tax_rate($results['products_tax_class_id']));
		}else{
			// it is free
				$del_charge_text = TRANSLATION_CHECKOUT_FREE;
		}
		
		
	}else{
		
		// must be free
		$del_charge_value = 0;
		$del_charge_text = TRANSLATION_CHECKOUT_FREE;
	}

}else{
	// free not defined or not over 0 therefore delivery charge applicable.
	
		$del_charge_value = $currencies->display_numeric_price(MODULE_SHIPPING_FLAT_COST, dsf_get_tax_rate($results['products_tax_class_id']));

		if ((int)MODULE_SHIPPING_FLAT_COST > 0){
				$del_charge_text = $currencies->display_price(MODULE_SHIPPING_FLAT_COST, dsf_get_tax_rate($results['products_tax_class_id']));
		}else{
			// it is free
				$del_charge_text = TRANSLATION_CHECKOUT_FREE;
		}
	
}

return array('cost' => $del_charge_value,
			 'text' => $del_charge_text);

	
}

// ###
  function dsf_create_random_value($length, $type = 'mixed') {
    if ( ($type != 'mixed') && ($type != 'chars') && ($type != 'digits')) return false;

    $rand_value = '';
    while (strlen($rand_value) < $length) {
      if ($type == 'digits') {
        $char = dsf_rand(0,9);
      } else {
        $char = chr(dsf_rand(0,255));
      }
      if ($type == 'mixed') {
        if (eregi('^[a-z0-9]$', $char)) $rand_value .= $char;
      } elseif ($type == 'chars') {
        if (eregi('^[a-z]$', $char)) $rand_value .= $char;
      } elseif ($type == 'digits') {
        if (ereg('^[0-9]$', $char)) $rand_value .= $char;
      }
    }

    return $rand_value;
  }

// ###

  function dsf_count_payment_modules() {
    return dsf_count_modules(MODULE_PAYMENT_INSTALLED);
  }

// ###

  function dsf_count_shipping_modules() {
    return dsf_count_modules(MODULE_SHIPPING_INSTALLED);
  }
// ###

  function dsf_count_modules($modules = '') {
    $count = 0;

    if (empty($modules)) return $count;

    $modules_array = split(';', $modules);

    for ($i=0, $n=sizeof($modules_array); $i<$n; $i++) {
      $class = substr($modules_array[$i], 0, strrpos($modules_array[$i], '.'));

      if (is_object($GLOBALS[$class])) {
        if ($GLOBALS[$class]->enabled) {
          $count++;
        }
      }
    }

    return $count;
  }

// ###

  function dsf_word_count($string, $needle = ' ') {
   
    $temp_array = split($needle, $string);

    if (is_array($temp_array)){
		return sizeof($temp_array);
	}else{
		return 0;
	}
  
  }

// ###


function dsf_get_up_cat_tree($categories_id, $loopstopper = 1, $required_name =''){
					
						$categories_query = dsf_db_query("SELECT categories_id, parent_id FROM " . DS_DB_SHOP .".categories WHERE categories_id = '". (int)$categories_id . "'");
						$categories = dsf_db_fetch_array($categories_query);
		
			if ($categories['parent_id'] ==0){
			   if ($required_name){
			   		$required_name = $categories['categories_id'] . ':' . $required_name;
			   }else{
			   		$required_name = $categories['categories_id'] . ':';
			   }
			 }else{
			    $loopstopper ++;
					if ($loopstopper < 8) { // max 8 links down, stops loops on rouge unlinked categories.
	
							if($required_name){
												$required_name = dsf_get_up_cat_tree ($categories['parent_id'], $loopstopper, $categories['categories_id'] . ':' . $required_name);
							}else{
												$required_name = dsf_get_up_cat_tree ($categories['parent_id'], $loopstopper, $categories['categories_id']);
							}
					}
			}
			

return $required_name;
}

//  ###

function dsf_get_up_cat_parts_tree($categories_id, $loopstopper = 1, $required_name =''){
					
						$categories_query = dsf_db_query("SELECT categories_id, parent_id FROM " . DS_DB_SHOP .".categories_parts WHERE categories_id = '". (int)$categories_id . "'");
						$categories = dsf_db_fetch_array($categories_query);
		
			if ($categories['parent_id'] ==0){
			   if ($required_name){
			   		$required_name = $categories['categories_id'] . ':' . $required_name;
			   }else{
			   		$required_name = $categories['categories_id'] . ':';
			   }
			 }else{
			    $loopstopper ++;
					if ($loopstopper < 8) { // max 8 links down, stops loops on rouge unlinked categories.
	
							if($required_name){
												$required_name = dsf_get_up_cat_parts_tree ($categories['parent_id'], $loopstopper, $categories['categories_id'] . ':' . $required_name);
							}else{
												$required_name = dsf_get_up_cat_parts_tree ($categories['parent_id'], $loopstopper, $categories['categories_id']);
							}
					}
			}
			

return $required_name;
}

// ###


// objective - get a list of categories to pass to the function dsf_get_up_cat_tree
// then using the data returned,  put all of the values into an array so that every single
// upper category has a list of all sub categories (and their subcategories) under it.
function dsf_create_up_cat_tree() {
	global $cat_parent_array;
	
		if (!isset($cat_parent_array) || !is_array($cat_parent_array)){
			$cat_parent_array = array();
		}
		
		$categories = dsf_db_query("select categories_id from " . DS_DB_SHOP . ".categories order by categories_id");
		while ($results = dsf_db_fetch_array($categories)){
			$cat_id = $results['categories_id'];
			
			
			$info = dsf_get_up_cat_tree($results['categories_id'], 1);
				
					$items = explode(':' , $info);
					
					foreach ($items as $id){
							if (isset($id) && (int)$id > 0){
								
								if (isset($cat_parent_array[$id])){
								
										// check to see there is some products in that category,  if there are not, we are not interested
										$pr_query = dsf_db_query("select products_id from " . DS_DB_SHOP . ".products_to_categories where categories_id='" . (int)$cat_id . "'");
										
										if (dsf_db_num_rows($pr_query) > 0){
											// only add if there are products found
													$cat_parent_array[$id] = $cat_parent_array[$id] . ':' . $cat_id;
												
										}		
								}else{
									$cat_parent_array[$id] = $cat_id;
								}
							
							}
					}
			
		}
		

// we do not need to return anything, other than for consistancy.  all of the results
// have been put into the global variable $cat_parent_array()

return true;		
	
}

// ###


// objective - get a list of categories to pass to the function dsf_get_up_cat_tree
// then using the data returned,  put all of the values into an array so that every single
// upper category has a list of all sub categories (and their subcategories) under it.
function dsf_create_up_cat_parts_tree() {
	global $cat_parent_array;
	
		if (!isset($cat_parent_array) || !is_array($cat_parent_array)){
			$cat_parent_array = array();
		}
		
		$categories = dsf_db_query("select categories_id from " . DS_DB_SHOP .".categories_parts order by categories_id");

		while ($results = dsf_db_fetch_array($categories)){
			
			$cat_id = $results['categories_id'];
			
			
			$info = dsf_get_up_cat_parts_tree($results['categories_id'], 1);
				
					$items = explode(':' , $info);
					
					foreach ($items as $id){
							if (isset($id) && (int)$id > 0){
								
								if (isset($cat_parent_array[$id])){
								
										// check to see there is some products in that category,  if there are not, we are not interested
										$pr_query = dsf_db_query("select products_id from " . DS_DB_SHOP . ".products_parts_to_categories_parts where categories_id='" . (int)$cat_id . "'");
										
										if (dsf_db_num_rows($pr_query) > 0){
											// only add if there are products found
													$cat_parent_array[$id] = $cat_parent_array[$id] . ':' . $cat_id;
												
										}		
								}else{
									$cat_parent_array[$id] = $cat_id;
								}
							
							}
					}
			
		}
		

// we do not need to return anything, other than for consistancy.  all of the results
// have been put into the global variable $cat_parent_array()

return true;		
	
}

// ###


////
// Parse search string into indivual objects
  function dsf_parse_search_string($search_str = '', &$objects) {
    $search_str = trim(strtolower($search_str));

// Break up $search_str on whitespace; quoted string will be reconstructed later
    $pieces = split('[[:space:]]+', $search_str);
    $objects = array();
    $tmpstring = '';
    $flag = '';

    for ($k=0; $k<count($pieces); $k++) {
      while (substr($pieces[$k], 0, 1) == '(') {
        $objects[] = '(';
        if (strlen($pieces[$k]) > 1) {
          $pieces[$k] = substr($pieces[$k], 1);
        } else {
          $pieces[$k] = '';
        }
      }

      $post_objects = array();

      while (substr($pieces[$k], -1) == ')')  {
        $post_objects[] = ')';
        if (strlen($pieces[$k]) > 1) {
          $pieces[$k] = substr($pieces[$k], 0, -1);
        } else {
          $pieces[$k] = '';
        }
      }

// Check individual words

      if ( (substr($pieces[$k], -1) != '"') && (substr($pieces[$k], 0, 1) != '"') ) {
        $objects[] = trim($pieces[$k]);

        for ($j=0; $j<count($post_objects); $j++) {
          $objects[] = $post_objects[$j];
        }
      } else {
/* This means that the $piece is either the beginning or the end of a string.
   So, we'll slurp up the $pieces and stick them together until we get to the
   end of the string or run out of pieces.
*/

// Add this word to the $tmpstring, starting the $tmpstring
        $tmpstring = trim(ereg_replace('"', ' ', $pieces[$k]));

// Check for one possible exception to the rule. That there is a single quoted word.
        if (substr($pieces[$k], -1 ) == '"') {
// Turn the flag off for future iterations
          $flag = 'off';

          $objects[] = trim($pieces[$k]);

          for ($j=0; $j<count($post_objects); $j++) {
            $objects[] = $post_objects[$j];
          }

          unset($tmpstring);

// Stop looking for the end of the string and move onto the next word.
          continue;
        }

// Otherwise, turn on the flag to indicate no quotes have been found attached to this word in the string.
        $flag = 'on';

// Move on to the next word
        $k++;

// Keep reading until the end of the string as long as the $flag is on

        while ( ($flag == 'on') && ($k < count($pieces)) ) {
          while (substr($pieces[$k], -1) == ')') {
            $post_objects[] = ')';
            if (strlen($pieces[$k]) > 1) {
              $pieces[$k] = substr($pieces[$k], 0, -1);
            } else {
              $pieces[$k] = '';
            }
          }

// If the word doesn't end in double quotes, append it to the $tmpstring.
          if (substr($pieces[$k], -1) != '"') {
// Tack this word onto the current string entity
            $tmpstring .= ' ' . $pieces[$k];

// Move on to the next word
            $k++;
            continue;
          } else {
/* If the $piece ends in double quotes, strip the double quotes, tack the
   $piece onto the tail of the string, push the $tmpstring onto the $haves,
   kill the $tmpstring, turn the $flag "off", and return.
*/
            $tmpstring .= ' ' . trim(ereg_replace('"', ' ', $pieces[$k]));

// Push the $tmpstring onto the array of stuff to search for
            $objects[] = trim($tmpstring);

            for ($j=0; $j<count($post_objects); $j++) {
              $objects[] = $post_objects[$j];
            }

            unset($tmpstring);

// Turn off the flag to exit the loop
            $flag = 'off';
          }
        }
      }
    }

// add default logical operators if needed
    $temp = array();
    for($i=0; $i<(count($objects)-1); $i++) {
      $temp[] = $objects[$i];
      if ( ($objects[$i] != 'and') &&
           ($objects[$i] != 'or') &&
           ($objects[$i] != '(') &&
           ($objects[$i+1] != 'and') &&
           ($objects[$i+1] != 'or') &&
           ($objects[$i+1] != ')') ) {
        $temp[] = 'and';
      }
    }
    $temp[] = $objects[$i];
    $objects = $temp;

    $keyword_count = 0;
    $operator_count = 0;
    $balance = 0;
    for($i=0; $i<count($objects); $i++) {
      if ($objects[$i] == '(') $balance --;
      if ($objects[$i] == ')') $balance ++;
      if ( ($objects[$i] == 'and') || ($objects[$i] == 'or') ) {
        $operator_count ++;
      } elseif ( ($objects[$i]) && ($objects[$i] != '(') && ($objects[$i] != ')') ) {
        $keyword_count ++;
      }
    }

    if ( ($operator_count < $keyword_count) && ($balance == 0) ) {
      return true;
    } else {
      return false;
    }
  }



// ####


// return a text version of the vat value without trailing zeros
function dsf_tax_text($value = ''){
		if (!$value){
			$rate = dsf_get_default_vat_rate();
		}else{
			if ((int)$value > 0  && strlen($value)>0){
				$rate = $value;
			}else{
			$rate = dsf_get_default_vat_rate();
			}
		}
		
		// format the rate to remove trailing zeros
		$rate = number_format($rate,2,'.','');
		
		if (substr($rate,-2,2) == '00'){ // two trailing zeros no decimal places
				$rate = (int)$rate;
		}elseif (substr($rate,-1,1) == '0'){ // one trailing zeros
				$rate = substr($rate,0,(strlen($rate)-1));
		}
		
		
		return $rate;
}





// ####
// Return all products for a specific category number in an array.

function dsf_return_categories_products($category_id){
	global $currencies, $dsv_disable_ecommerce;
	
	
	$order_by = ' order by p2c.main_product DESC, p2c.sort_order';
	
										$select_column_list = "p.products_id, p.products_quantity, p.TotalReviewCount, p.AverageOverallRating, IF(s.status, s.specials_new_products_price, NULL) as specials_new_products_price, IF(s.status, s.specials_new_products_price, p.products_price) as final_price, p.products_price, p.products_tax_class_id, sl.latency_title, p.rrp_price, p.allow_purchase, p.products_main_cat, p2c.main_product, ";

										$listing_sql = "select " . $select_column_list . " p.products_model as ov_products_model, p.products_slug as ov_products_slug, p.category_image as ov_category_image, p.products_awards as ov_products_awards, p.products_name as ov_products_name, p.products_short as ov_products_short, p.manufacturers_id as ov_manufacturers_id, sm.manufacturers_image as ov_manufacturers_image, sm.manufacturers_name as ov_manufacturers_name,
										lp.products_model, lp.products_slug, lp.category_image, lp.products_awards, lp.products_name, lp.products_short, lp.manufacturers_id, lm.manufacturers_image, lm.manufacturers_name  
										 from " . DS_DB_SHOP . ".products p left join " . DS_DB_LANGUAGE . ".products lp on (p.products_id = lp.products_id)
										 left join " . DS_DB_SHOP . ".manufacturers sm on p.manufacturers_id = sm.manufacturers_id left join " . DS_DB_LANGUAGE . ".manufacturers lm on (lp.manufacturers_id = lm.manufacturers_id)
										 left join " . DS_DB_SHOP . ".products_to_categories p2c on (p.products_id = p2c.products_id) left join " . DS_DB_SHOP . ".specials s on (p.products_id = s.products_id) left join " . DS_DB_SHOP . ".shipping_latency sl on (p.shipping_latency = sl.latency_id) where p.products_status = '1' and p2c.categories_id = '" . (int)$category_id . "' " . $order_by;
	
	
	
	
	
	$dsv_products = array();

	$listing = dsf_db_query($listing_sql);
	
	while ($products = dsf_db_fetch_array($listing)){
	
													$ptax_rate = dsf_get_tax_rate($products['products_tax_class_id']);
													
														$awards =  dsf_return_awards_array($products['products_id']);
												
													
														if (defined('PRODUCT_LIST_PRODUCT_ICONS') && PRODUCT_LIST_PRODUCT_ICONS == 'true'){
															$product_features =  dsf_return_feature_images_array($products['products_id']);
														}else{
															$product_features = '';
														}
								
								
														$tmp_man_image = (strlen($products['ov_manufacturers_image']) >0 ? $products['ov_manufacturers_image'] : $products['manufacturers_image']);
														$tmp_cat_image = (strlen($products['ov_category_image']) >0 ? $products['ov_category_image'] : $products['category_image']);
														$tmp_slug = (strlen($products['ov_products_slug']) >0 ? $products['ov_products_slug'] : $products['products_slug']);
														
								
								
														if  ((int)$products['allow_purchase'] == 1 && $dsv_disable_ecommerce == 'false'){
															$buy_url = dsf_product_url($products['products_id'] , $products['products_main_cat'], $tmp_slug, 'action=buy_now');
															$add_url = dsf_product_url($products['products_id'] , $products['products_main_cat'], $tmp_slug, 'action=buy_now&add=yes');
														}else{
															$buy_url = '';
															$add_url = '';
														}	
														
													$an_prod_temp_array = array('id' => $products['products_id'],
																			'model' => (strlen($products['ov_products_model']) >0 ? $products['ov_products_model'] : $products['products_model']),
																			'name' => (strlen($products['ov_products_name']) >0 ? $products['ov_products_name'] : $products['products_name']),
																			'short_description' => (strlen($products['ov_products_short']) >0 ? $products['ov_products_short'] : $products['products_short']),
																			'brand_name' => (strlen($products['ov_manufacturers_name']) >0 ? $products['ov_manufacturers_name'] : $products['manufacturers_name']),
																			'brand_image' => (strlen($tmp_man_image)>1 ? 'sized/listing/' . $tmp_man_image : ''),
																			
																			'image' => (strlen($tmp_cat_image)>1 ? 'sized/listing/' . $tmp_cat_image : ''),
																			'large_image' => (strlen($tmp_cat_image)>1 ? 'sized/listing/large_' . $tmp_cat_image : ''),
																			
											
																			'url' => dsf_product_url($products['products_id'] , $products['products_main_cat'] , $tmp_slug),
																			'buy_url' => $buy_url,
																			'add_url' => $add_url,
																			'vat_rate' => $ptax_rate,
																			'allow_purchase' => ($products['allow_purchase'] == 1 ? 'true' : 'false'),
																			
																			'price' => $currencies->display_price($products['products_price'], $ptax_rate),
																			'rrp_price' => $currencies->display_price($products['rrp_price'], 0),
																			'offer_price' => $currencies->display_price($products['specials_new_products_price'], $ptax_rate),
																			
																			'width' => PRODUCTLISTING_IMAGE_WIDTH,
																			'height' => PRODUCTLISTING_IMAGE_HEIGHT,
																			'large_width' => PRODUCTLISTING_LARGE_IMAGE_WIDTH,
																			'large_height' => PRODUCTLISTING_LARGE_IMAGE_HEIGHT,
																			'row_image' => (strlen($tmp_cat_image)>1 ? 'sized/listing/row_' . $tmp_cat_image : ''),
																			'row_width' => PRODUCTROW_IMAGE_WIDTH,
																			'row_height' => PRODUCTROW_IMAGE_HEIGHT,
										
																			'stock' => (int)dsf_stock_value($products['products_id']),
																			'awards' => $awards,
																			'feature_images' => $product_features,
																			
																			'latency' => $products['latency_title'],
																			'TotalReviewCount' => $products['TotalReviewCount'],
																			'AverageOverallRating' => $products['AverageOverallRating'],
																			'RatingImage' => BAZAAR_STAR_IMAGE_LOCATION . "rating-" . str_replace(".", "_", $products['AverageOverallRating']) . "." . BAZAAR_STAR_TYPE
																			);
																		
													$dsv_products[] = $an_prod_temp_array;
													unset($an_prod_temp_array);
	
	}
	

return 	$dsv_products;
	
}


// #####
// return a list of feature images (products icons) for a product.

function dsf_return_feature_images_array($products_id){
	
	$query = dsf_db_query("select p.feature_images as ov_feature_images, lp.feature_images from " . DS_DB_SHOP . ".products p left join " . DS_DB_LANGUAGE . ".products lp on (p.products_id = lp.products_id) where p.products_id='" . $products_id . "'");
	$product_info_values = dsf_db_fetch_array($query);
	
	$feature_images = array();
		
	$tmp_doc = (strlen($product_info_values['ov_feature_images']) > 1 ? $product_info_values['ov_feature_images'] : $product_info_values['feature_images']);

	if (strlen($tmp_doc)>1){

		$acc_split = explode("~" , $tmp_doc);
		
		foreach ($acc_split as $spacc){
				$awards_query = dsf_db_query("select sf.feature_name as ov_feature_name, sf.feature_image as ov_feature_image, lf.feature_name, lf.feature_image from " . DS_DB_SHOP . ".feature_images sf left join " . DS_DB_LANGUAGE . ".feature_images lf on (sf.feature_id = lf.feature_id) where sf.feature_id='" . (int)$spacc . "'");
				
				if (dsf_db_num_rows($awards_query) > 0){
						$awards = dsf_db_fetch_array($awards_query);
		
						$feature_images[] = array('image' => (strlen($awards['ov_feature_image']) > 1 ? $awards['ov_feature_image'] : $awards['feature_image']),
													  'title' => (strlen($awards['ov_feature_name']) > 1 ? $awards['ov_feature_name'] : $awards['feature_name'])
													  );
						}
				
			}
		
	  unset($acc_split);
	  unset($spacc);
	  unset($acc_item);
	}
	
	return $feature_images;
	
}




// ###
// date format used for both SAP and Convar API feeds.
function dsf_sort_date($raw_date){
	
    $year = substr($raw_date, 0, 4);
    $month = substr($raw_date, 5, 2);
    $day = substr($raw_date, 8, 2);
	
return $year . $month . $day;	
	
}

// ###
	function dsf_get_products_sku($products_id){
	$prod_query = dsf_db_query("select sp.products_sku as ov_products_sku, lp.products_sku from " . DS_DB_SHOP . ".products sp left join " . DS_DB_LANGUAGE . ".products lp on (sp.products_id = lp.products_id) where sp.products_id ='" . (int)$products_id . "'");
	$prod_details = dsf_db_fetch_array($prod_query);
	
	if (isset($prod_details['ov_products_sku']) && strlen($prod_details['ov_products_sku']) > 1){
		$products_sku = $prod_details['ov_products_sku'];
	}else{
		$products_sku = $prod_details['products_sku'];
	}
	
	
	return $products_sku;
		
		
	}


// ###

	function dsf_get_products_parts_sku($products_id){
	$prod_query = dsf_db_query("select sp.products_sku as ov_products_sku, lp.products_sku from " . DS_DB_SHOP . ".products_parts sp left join " . DS_DB_LANGUAGE . ".products_parts lp on (sp.products_id = lp.products_id) where sp.products_id ='" . (int)$products_id . "'");
	$prod_details = dsf_db_fetch_array($prod_query);
	
	if (isset($prod_details['ov_products_sku']) && strlen($prod_details['ov_products_sku']) > 1){
		$products_sku = $prod_details['ov_products_sku'];
	}else{
		$products_sku = $prod_details['products_sku'];
	}
	
	
	return $products_sku;
		
	}


// ###


 function dsf_get_category_matrix($parent_id=0){
  $return_array = array(array('id' => '' , 'text' => TRANSLATION_PLEASE_SELECT));
  
  $category_query = dsf_db_query("select sc.categories_id, sc.categories_name, sc.categories_name as ov_categories_name,  lc.categories_name from " . DS_DB_SHOP . ".categories sc left join " . DS_DB_LANGUAGE . ".categories lc on (sc.categories_id = lc.categories_id) where sc.parent_id ='" . (int)$parent_id . "' order by IF(LENGTH(sc.categories_name) > 0, sc.categories_name, lc.categories_name)");
  while($category = dsf_db_fetch_array($category_query)){
  
			if (isset($category['ov_categories_name']) && strlen($category['ov_categories_name']) > 1){
				$categories_name = $category['ov_categories_name'];
			}else{
				$categories_name = $category['categories_name'];
			}
  
  	$return_array[] = array('id' => $category['categories_id'],
							'text' => $categories_name);
  
  
  }
  return $return_array;
  }


// ###


 function dsf_get_product_matrix($category_id=0){
  global $category_children_cache;
  
  
  $return_array = array(array('id' => '' , 'text' => TRANSLATION_PLEASE_SELECT));
  
  if ((int)$category_id > 0){
	  
	  $category_where = '';
	  
	  // see if we have a list of categories from the category_children_cache
	  
	  if (isset($category_children_cache[$category_id])){
		  
		  $cat_items = explode(":" , $category_children_cache[$category_id]);
		  
		  
		  foreach($cat_items as $item){
			  
				if (strlen($category_where) > 1){
					$category_where .= " or sc.categories_id='" . $item . "'";
				}else{
					$category_where .= " sc.categories_id='" . $item . "'";
				}
		  }
		  
	  }else{
		// just get products from current category.  
		  
				$category_where .= " sc.categories_id='" . $category_id . "'";
		  
	  }
	  

	$category_where = ' and (' . $category_where . ')';
	  
	  
		  $product_query = dsf_db_query("select distinct sp.products_id, lp.products_model, sp.products_model as ov_products_model from " . DS_DB_SHOP . ".products sp left join " . DS_DB_LANGUAGE . ".products lp on (sp.products_id=lp.products_id) left join " . DS_DB_SHOP . ".products_to_categories sc on (sc.products_id = sp.products_id) where sp.products_id >'0' " . $category_where . " order by IF(LENGTH(sp.products_model) > 0, sp.products_model, lp.products_model)");
		  while($products = dsf_db_fetch_array($product_query)){
		  
					if (isset($products['ov_products_model']) && strlen($products['ov_products_model']) > 1){
						$products_model = $products['ov_products_model'];
					}else{
						$products_model = $products['products_model'];
					}
		  
			$return_array[] = array('id' => $products_model,
									'text' => $products_model);
		  
		  
		  }
  
  }
  
  return $return_array;
  }


// ###

  function dsf_array_to_string($array, $exclude = '', $equals = '=', $separator = '&') {
    if (!is_array($exclude)) $exclude = array();

    $get_string = '';
    if (sizeof($array) > 0) {
      while (list($key, $value) = each($array)) {
        if ( (!in_array($key, $exclude)) && ($key != 'x') && ($key != 'y') ) {
          $get_string .= $key . $equals . $value . $separator;
        }
      }
      $remove_chars = strlen($separator);
      $get_string = substr($get_string, 0, -$remove_chars);
    }

    return $get_string;
  }





// ###
function dsf_correct_ampersand($text){

// loop though text for the & character and if a ; is not found within 6 chars, replace the & with &amp;	
$text = preg_replace('/&[^; ]{0,6}.?/e', "((substr('\\0',-1) == ';') ? '\\0' : '&amp;'.substr('\\0',1))", $text);
	
// this is not an ideal fix as &sometext; would become &amp;sometext; however it should remove 90% of issues cause with the unescaped & character
// by itself.

// to increase to 7 characters etc..   replace with 	$text = preg_replace('/&[^; ]{0,7}.?/e',   etc.....
return $text;
	
}





// ####
function dsf_display_as_currency($item_value, $item_decimals=999){
	
	  global $dsv_master_country_id;
		
		$return_text = '';
		
      if (is_numeric($item_value)){
		  
			  // we need to get the curreny values from the country website based on what shop we currently have loaded.
				  if ((int)$dsv_master_country_id > 0){
				  $currencies_text_query = dsf_db_query("select currency_title, currency_symbol_left, currency_symbol_right, currency_decimal_point, currency_thousand_point, currency_decimal_places from " . DS_DB_MASTER . ".countries where country_id='" . $dsv_master_country_id . "'");
				  $currencies_text = dsf_db_fetch_array($currencies_text_query);
				
					// using the currency values return a text variation of the value by processing it via the currency fields returned.
					
					if ((int)$item_decimals == 999){	// the default value (if not passed to function is to get it from the currency)
						$item_decimals = $currencies_text['currency_decimal_places'];
					}
					
					$return_text = $currencies_text['currency_symbol_left'] . number_format((float)$item_value, (int)$item_decimals, $currencies_text['currency_decimal_point'], $currencies_text['currency_thousand_point']) . $currencies_text['currency_symbol_right'];
			
				}else{
					// No currency values therefore we can only return back what we were given.
					 $return_text = $item_value;
				}
		
	  }else{ // else numeric value not given return what we were given only.
		 
		  $return_text = $item_value;
		  
	  }
	
	
	return $return_text;
		
		
}

// ####

function dsf_get_gallery_item_array($pID=0, $gID=0){
	
	$gallery_details = '';
	
	$dsv_sql_fields_required = array('gallery_id','unit_id','item_translated','override_required','override_layout_folder','override_layout_file','override_content_folder','override_content_file','gallery_type','gallery_title','gallery_image','gallery_image_two','gallery_image_three','mobile_gallery_image','mobile_gallery_image_two','mobile_gallery_image_three','tablet_gallery_image','tablet_gallery_image_two','tablet_gallery_image_three','gallery_text','text_one','text_two','text_three','text_four','text_block_one','text_block_two','text_block_three','text_block_four','sort_order','comp_id','item_approved');
	$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sg','lg');
	
    // get details of the gallery items
    
    $gallery_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".gallery sg left join " . DS_DB_LANGUAGE . ".gallery lg on (sg.gallery_id = lg.gallery_id) where sg.gallery_id='" . $pID . "'");
    $gallery_results = dsf_db_fetch_array($gallery_query);
	
//	echo dsf_print_array($gallery_results);
	
	$gallery_details = dsf_sql_override_values($dsv_sql_fields_required, $gallery_results);
	// at this point we make amendments or additions to the array.
	
	// resolve issue with layout override being a 0 on a shop.
	if ((int)$gallery_results['override_required'] == -9){
		// shop says absolute NO.
		
		$gallery_details['override_required'] = 0;
		unset($gallery_details['override_layout_folder']);
		unset($gallery_details['override_layout_file']);
		unset($gallery_details['override_content_folder']);
		unset($gallery_details['override_content_file']);
		
		// language specifically says override therefore we accept that.		
	}elseif ((int)$gallery_results['override_required'] == 1){
		
		$gallery_details['override_required'] = 1;
		
		// now check if language override_required is 0 - if it is remove any remains that may be left over in the other fields.		
	}else{
		
		$gallery_results['override_required'] = 0;
		unset($gallery_details['override_layout_folder']);
		unset($gallery_details['override_layout_file']);
		unset($gallery_details['override_content_folder']);
		unset($gallery_details['override_content_file']);
	}
	
	
	//unset a couple of fields
	unset($gallery_details['item_translated']);


	
	
	// check for a competition value
	
	if ((int)$gallery_results['ov_comp_id'] == -9){
		// shop says absolute NO.
		$gallery_details['comp_id'] = 0;
	
	}elseif ((int)$gallery_results['comp_id'] > 1){
		$gallery_details['comp_id'] = (int)$gallery_results['comp_id'];
		$gallery_details['competition_details'] = dsf_get_competition_item_array($gallery_results['comp_id']);
		
	}else{
		$gallery_results['comp_id'] = 0;		
		
	}
	
	
	
	
	
	

	$gallery_details['url'] = 	dsf_href_link('gallery.html' , 'gID=' . $pID );
	$gallery_details['attributes'] = 'gID=' . $pID;

	
	// make amendments to image values if they exist.
	
	if (strlen($gallery_details['gallery_image']) > 1){
		$gallery_details['gallery_image'] = 'gallery/' . $gallery_details['gallery_image'];
		$gallery_details['gallery_image_sized'] = 'sized/gallery/' . $gallery_details['gallery_image'];
	}

	if (strlen($gallery_details['gallery_image_two']) > 1){
		$gallery_details['gallery_image_two'] = 'gallery/' . $gallery_details['gallery_image_two'];
		$gallery_details['gallery_image_two_sized'] = 'sized/gallery/' . $gallery_details['gallery_image_two'];
	}
	
	if (strlen($gallery_details['gallery_image_three']) > 1){
		$gallery_details['gallery_image_three'] = 'gallery/' . $gallery_details['gallery_image_three'];
		$gallery_details['gallery_image_three_sized'] = 'sized/gallery/' . $gallery_details['gallery_image_three'];
	}



	if (strlen($gallery_details['mobile_gallery_image']) > 1){
		$gallery_details['mobile_gallery_image'] = 'gallery/' . $gallery_details['mobile_gallery_image'];
		$gallery_details['mobile_gallery_image_sized'] = 'sized/gallery/' . $gallery_details['mobile_gallery_image'];
	}

	if (strlen($gallery_details['mobile_gallery_image_two']) > 1){
		$gallery_details['mobile_gallery_image_two'] = 'gallery/' . $gallery_details['mobile_gallery_image_two'];
		$gallery_details['mobile_gallery_image_two_sized'] = 'sized/gallery/' . $gallery_details['mobile_gallery_image_two'];
	}
	
	if (strlen($gallery_details['mobile_gallery_image_three']) > 1){
		$gallery_details['mobile_gallery_image_three'] = 'gallery/' . $gallery_details['mobile_gallery_image_three'];
		$gallery_details['mobile_gallery_image_three_sized'] = 'sized/gallery/' . $gallery_details['mobile_gallery_image_three'];
	}



	if (strlen($gallery_details['tablet_gallery_image']) > 1){
		$gallery_details['tablet_gallery_image'] = 'gallery/' . $gallery_details['tablet_gallery_image'];
		$gallery_details['tablet_gallery_image_sized'] = 'sized/gallery/' . $gallery_details['tablet_gallery_image'];
	}

	if (strlen($gallery_details['tablet_gallery_image_two']) > 1){
		$gallery_details['tablet_gallery_image_two'] = 'gallery/' . $gallery_details['tablet_gallery_image_two'];
		$gallery_details['tablet_gallery_image_two_sized'] = 'sized/gallery/' . $gallery_details['tablet_gallery_image_two'];
	}
	
	if (strlen($gallery_details['tablet_gallery_image_three']) > 1){
		$gallery_details['tablet_gallery_image_three'] = 'gallery/' . $gallery_details['tablet_gallery_image_three'];
		$gallery_details['tablet_gallery_image_three_sized'] = 'sized/gallery/' . $gallery_details['tablet_gallery_image_three'];
	}


	
	 $dsv_sql_children_required = array('item_id','unit_id','item_translated','gallery_id','image_one','image_one_title','image_one_text','image_one_link','image_one_window','image_two','image_two_title','image_two_text','image_two_link','image_two_window','image_three','image_three_title','image_three_text','image_three_link','image_three_window','image_four','image_four_title','image_four_text','image_four_link','image_four_window','sequence_value','text_one','text_two','text_three','text_four','text_block_one','text_block_two','text_block_three','text_block_four','mobile_image_one','mobile_image_one_title','mobile_image_one_text','mobile_image_one_link','mobile_image_one_window','mobile_image_two','mobile_image_two_title','mobile_image_two_text','mobile_image_two_link','mobile_image_two_window','mobile_image_three','mobile_image_three_title','mobile_image_three_text','mobile_image_three_link','mobile_image_three_window','mobile_image_four','mobile_image_four_title','mobile_image_four_text','mobile_image_four_link','mobile_image_four_window','tablet_image_one','tablet_image_one_title','tablet_image_one_text','tablet_image_one_link','tablet_image_one_window','tablet_image_two','tablet_image_two_title','tablet_image_two_text','tablet_image_two_link','tablet_image_two_window','tablet_image_three','tablet_image_three_title','tablet_image_three_text','tablet_image_three_link','tablet_image_three_window','tablet_image_four','tablet_image_four_title','tablet_image_four_text','tablet_image_four_link','tablet_image_four_window','sort_order','item_approved');
	 $dsv_sql_fields = dsf_sql_override_select($dsv_sql_children_required, 'sg','lg');
	
    // get details of the gallery items
    
     $gallery_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".gallery_items sg left join " . DS_DB_LANGUAGE . ".gallery_items lg on (sg.item_id = lg.item_id) where sg.gallery_id='" . $pID . "'  order by sg.sort_order");
     
	 $total_items = dsf_rows($gallery_query);
	
     $children = array();
	 $selected = array();
	 
	 
	 while ($gallery_results = dsf_db_fetch_array($gallery_query)){
		 	$array_results =  dsf_sql_override_values($dsv_sql_children_required, $gallery_results);
			
			// at this point we make amendments or additions to the array.
			$array_results['url'] = dsf_href_link('gallery.html' , 'gID=' . urlencode($pID . ':' . $gallery_results['item_id']) );
			$array_results['attributes'] = 'gID=' . urlencode($pID . ':' . $gallery_results['item_id']);

		 	
			if (strlen($array_results['image_one']) > 1){
				$array_results['image_one_sized'] = 'sized/gallery/' . $array_results['image_one'];
				$array_results['image_one_thumb'] = 'sized/gallery/thumb_' . $array_results['image_one'];
				$array_results['image_one'] = 'gallery/' . $array_results['image_one'];
			}
			
			if (strlen($array_results['image_two']) > 1){
				$array_results['image_two_sized'] = 'sized/gallery/' . $array_results['image_two'];
				$array_results['image_two_thumb'] = 'sized/gallery/thumb_' . $array_results['image_two'];
				$array_results['image_two'] = 'gallery/' . $array_results['image_two'];
			}
			
			if (strlen($array_results['image_three']) > 1){
				$array_results['image_three_sized'] = 'sized/gallery/' . $array_results['image_three'];
				$array_results['image_three_thumb'] = 'sized/gallery/thumb_' . $array_results['image_three'];
				$array_results['image_three'] = 'gallery/' . $array_results['image_three'];
			}

			if (strlen($array_results['image_four']) > 1){
				$array_results['image_four_sized'] = 'sized/gallery/' . $array_results['image_four'];
				$array_results['image_four_thumb'] = 'sized/gallery/thumb_' . $array_results['image_four'];
				$array_results['image_four'] = 'gallery/' . $array_results['image_four'];
			}
			

			if (strlen($array_results['mobile_image_one']) > 1){
				$array_results['mobile_image_one_sized'] = 'sized/gallery/' . $array_results['mobile_image_one'];
				$array_results['mobile_image_one_thumb'] = 'sized/gallery/thumb_' . $array_results['mobile_image_one'];
				$array_results['mobile_image_one'] = 'gallery/' . $array_results['mobile_image_one'];
			}
			
			if (strlen($array_results['mobile_image_two']) > 1){
				$array_results['mobile_image_two_sized'] = 'sized/gallery/' . $array_results['mobile_image_two'];
				$array_results['mobile_image_two_thumb'] = 'sized/gallery/thumb_' . $array_results['mobile_image_two'];
				$array_results['mobile_image_two'] = 'gallery/' . $array_results['mobile_image_two'];
			}
			
			if (strlen($array_results['mobile_image_three']) > 1){
				$array_results['mobile_image_three_sized'] = 'sized/gallery/' . $array_results['mobile_image_three'];
				$array_results['mobile_image_three_thumb'] = 'sized/gallery/thumb_' . $array_results['mobile_image_three'];
				$array_results['mobile_image_three'] = 'gallery/' . $array_results['mobile_image_three'];
			}

			if (strlen($array_results['mobile_image_four']) > 1){
				$array_results['mobile_image_four_sized'] = 'sized/gallery/' . $array_results['mobile_image_four'];
				$array_results['mobile_image_four_thumb'] = 'sized/gallery/thumb_' . $array_results['mobile_image_four'];
				$array_results['mobile_image_four'] = 'gallery/' . $array_results['mobile_image_four'];
			}


			if (strlen($array_results['tablet_image_one']) > 1){
				$array_results['tablet_image_one_sized'] = 'sized/gallery/' . $array_results['tablet_image_one'];
				$array_results['tablet_image_one_thumb'] = 'sized/gallery/thumb_' . $array_results['tablet_image_one'];
				$array_results['tablet_image_one'] = 'gallery/' . $array_results['tablet_image_one'];
			}
			
			if (strlen($array_results['tablet_image_two']) > 1){
				$array_results['tablet_image_two_sized'] = 'sized/gallery/' . $array_results['tablet_image_two'];
				$array_results['tablet_image_two_thumb'] = 'sized/gallery/thumb_' . $array_results['tablet_image_two'];
				$array_results['tablet_image_two'] = 'gallery/' . $array_results['tablet_image_two'];
			}
			
			if (strlen($array_results['tablet_image_three']) > 1){
				$array_results['tablet_image_three_sized'] = 'sized/gallery/' . $array_results['tablet_image_three'];
				$array_results['tablet_image_three_thumb'] = 'sized/gallery/thumb_' . $array_results['tablet_image_three'];
				$array_results['tablet_image_three'] = 'gallery/' . $array_results['tablet_image_three'];
			}

			if (strlen($array_results['tablet_image_four']) > 1){
				$array_results['tablet_image_four_sized'] = 'sized/gallery/' . $array_results['tablet_image_four'];
				$array_results['tablet_image_four_thumb'] = 'sized/gallery/thumb_' . $array_results['tablet_image_four'];
				$array_results['tablet_image_four'] = 'gallery/' . $array_results['tablet_image_four'];
			}

			//unset a couple of fields
			unset($array_results['item_translated']);


			if (is_array($array_results)){
				
				ksort($array_results);	
			}



			// add the values to the chilren array as an additional item.
			
			$children[] = $array_results;
			
		 if ($array_results['item_id'] == $gID){
			 $gallery_details['selected'] = $array_results;
		 }
	 }
	 
   
     $gallery_details['children'] = $children;
	 


	// sort the array
	if (is_array($gallery_details)){
		
		ksort($gallery_details);	
	}



return $gallery_details;

} 


// ####



function dsf_get_competition_item_array($compID=0){

// there are more items required for a competition than just the information stored in the database when it comes to 
// getting the post variables which can only been supplied from a root / root include file.


	$competition_details = '';
	
	$dsv_sql_fields_required = array('comp_id', 'unit_id', 'item_translated', 'override_required', 'override_layout_folder', 'override_layout_file', 'override_content_folder', 'override_content_file', 'comp_text', 'comp_short', 'comp_slug', 'comp_image', 'comp_image_two', 'comp_image_three', 'comp_image_four', 'mobile_comp_image', 'mobile_comp_image_two', 'mobile_comp_image_three', 'mobile_comp_image_four', 'tablet_comp_image', 'tablet_comp_image_two', 'tablet_comp_image_three', 'tablet_comp_image_four', 'menu_image', 'comp_title', 'sort_order', 'comp_header_image', 'comp_header_title', 'comp_question', 'comp_answers', 'comp_status', 'answer_option', 'single_answer', 'seo_title', 'seo_keywords', 'seo_description', 'terms_text', 'terms_text_block', 'text_one', 'text_two', 'text_three', 'text_four', 'text_block_one', 'text_block_two', 'text_block_three', 'text_block_four', 'text_success', 'text_block_success');
	$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sg','lg');
	
    // get details of the gallery items
    
    $competition_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".competition sg left join " . DS_DB_LANGUAGE . ".competition lg on (sg.comp_id = lg.comp_id) where sg.comp_id='" . (int)$compID . "' and sg.comp_status='1'");
  
  
  if (dsf_db_num_rows($competition_query) > 0){
	    $competition_results = dsf_db_fetch_array($competition_query);
			
			$competition_details = dsf_sql_override_values($dsv_sql_fields_required, $competition_results);
			// at this point we make amendments or additions to the array.
		
			$competition_details['url'] = dsf_href_link('competitions.html' , 'compID=' . $compID );
			$competition_details['attributes'] = 'compID=' . $compID ;
			
			
			//unset a couple of fields
			unset($competition_details['item_translated']);
			
			// resolve issue with layout override being a 0 on a shop.
			if ((int)$competition_details['override_required'] == -9){
				// shop says absolute NO.
				
				$competition_details['override_required'] = 0;
				unset($competition_details['override_layout_folder']);
				unset($competition_details['override_layout_file']);
				unset($competition_details['override_content_folder']);
				unset($competition_details['override_content_file']);
				
				// language specifically says override therefore we accept that.		
			}elseif ((int)$competition_details['override_required'] == 1){
				
				$competition_details['override_required'] = 1;
				
				// now check if language override_required is 0 - if it is remove any remains that may be left over in the other fields.		
			}else{
				
				$competition_details['override_required'] = 0;
				unset($competition_details['override_layout_folder']);
				unset($competition_details['override_layout_file']);
				unset($competition_details['override_content_folder']);
				unset($competition_details['override_content_file']);
			}
			
					
			
			// add fields information
			
			$competition_details['form'] = array();
			
			$fields_array = array();
			$fields_array['firstname'] = 'input type text 32 characters';
			$fields_array['surname'] = 'input type text 32 characters';
			$fields_array['email_address'] = 'input type email (text) 64 characters';
			$fields_array['address'] = 'input type textarea';
			$fields_array['postocde'] = 'input type text 16 characters';
			$fields_array['answer'] = 'input type text 32 characters';
			$fields_array['futureoffers'] = 'checkbox 1 = on 0 = off';
			
			$competition_details['form']['fields'] = $fields_array;
			$competition_details['form']['post-url'] = dsf_href_link('competitions.html' , 'compID=' . $compID .'&action=submit' );
			$competition_details['form']['post-url-ajax'] = dsf_href_link('competitions.html' , 'compID=' . $compID .'&action=ajax_submit' );
			$competition_details['form']['information'] = 'Variables will be created automatically for all fields using the prefix ' . '$' . 'dsv_comp_  ie ' . '$' . 'dsv_comp_firstname  when the form has been posted, these variables contain the information submitted' ."\n\n" . 'Note the different URL for ajax posting. If you wish the allocated content file to be returned as part of an ajax request then the ajax url needs to be used to prevent the layout file being processed as part of the return.' . "\n\n" . 'Single answer or multiple choice is defined by the value of answer_option.  0 = Single Answer, 1 = Multiple Choice, 2 = No Answer Required' . "\n\n" . 'form[status] has 3 possibilities' . "\ndetails - Never submitted show initial form\nsuccess - Form submitted and everything fine show success content\nerror - page was submitted and an error was generated the field form[errors] will contain a list of errors to display";

			$competition_details['form']['status'] = 'display'; // root files accessing this function need to change this value accordingly.


		
			// there are other items that need to be added to the array directly on the page requesting the submission (post details responses).
	
			if (is_array($competition_details)){
			
				ksort($competition_details);	
			}

	
  }
  
	
return $competition_details;	
}


function dsf_get_seasonal_article_slug_tree($article_id, $loopstopper = 1, $required_name =''){
					
			$categories_query = dsf_db_query("SELECT sa.article_id, sa.parent_id, sa.article_slug as ov_article_slug, la.article_slug, sa.article_type as ov_article_type, la.article_type FROM " . DS_DB_SHOP . ".seasonal_articles sa left join " . DS_DB_LANGUAGE . ".seasonal_articles la on (sa.article_id = la.article_id) WHERE sa.article_id = '". (int)$article_id . "'");
			$categories = dsf_db_fetch_array($categories_query);
		

			if ($categories['article_type'] > 0){
				$article_type = $categories['ov_article_type'];
			}else{
				$article_type = $categories['article_type'];
			}
			

			if ($article_type == 2){
				
				// asset urls are not part of the sequence.
				

				if ($categories['parent_id'] == 0){
					
					// we are at the top therefore we don't need to do anything.
					
				}else{
					
					// just loop again.
					
							$loopstopper ++;
								if ($loopstopper < 6) { // max 6 links down, stops loops on rouge unlinked categories.
				
										$required_name = dsf_get_seasonal_article_slug_tree($categories['parent_id'], $loopstopper, $required_name);
								}
					
				}


			}else{
				
				// run the standard sequence.
				

						if (isset($categories['ov_article_slug']) && strlen($categories['ov_article_slug']) > 1){
							$article_slug = $categories['ov_article_slug'];
						}else{
							$article_slug = $categories['article_slug'];
						}
						
			
			
						if ($categories['parent_id'] ==0){
						   
						   if ($required_name){
								$required_name = $article_slug . '/' . $required_name;
						   }else{
								$required_name = $article_slug . '/';
						   }
					   
						
						 }else{
							$loopstopper ++;
								if ($loopstopper < 6) { // max 6 links down, stops loops on rouge unlinked categories.
				
										if($required_name){
															$required_name = dsf_get_seasonal_article_slug_tree($categories['parent_id'], $loopstopper, $article_slug . '/' . $required_name);
										}else{
															$required_name = dsf_get_seasonal_article_slug_tree($categories['parent_id'], $loopstopper, $article_slug . '/');
										}
								}
						
						
						
						}
			}

return $required_name;
}

// ###
function dsf_get_seasonal_article_breadcrumb_tree($article_id, $loopstopper = 1, $required_name =''){
					
			$categories_query = dsf_db_query("SELECT sa.article_id, sa.parent_id, sa.article_name as ov_article_name, la.article_name, sa.article_type as ov_article_type, la.article_type FROM " . DS_DB_SHOP . ".seasonal_articles sa left join " . DS_DB_LANGUAGE . ".seasonal_articles la on (sa.article_id = la.article_id) WHERE sa.article_id = '". (int)$article_id . "'");
			$categories = dsf_db_fetch_array($categories_query);
		
			if ($categories['article_type'] > 0){
				$article_type = $categories['ov_article_type'];
			}else{
				$article_type = $categories['article_type'];
			}
			

			if ($article_type == 2){
				
				// asset urls are not part of the sequence.
				

				if ($categories['parent_id'] == 0){
					
					// we are at the top therefore we don't need to do anything.
					
				}else{
					
					// just loop again.
					
							$loopstopper ++;
								if ($loopstopper < 6) { // max 6 links down, stops loops on rouge unlinked categories.
				
										$required_name = dsf_get_seasonal_article_breadcrumb_tree($categories['parent_id'], $loopstopper, $required_name);
								}
					
				}


			}else{
				
				// run the standard sequence.


			
						if (isset($categories['ov_article_name']) && strlen($categories['ov_article_name']) > 1){
							$article_name = $categories['ov_article_name'];
						}else{
							$article_name = $categories['article_name'];
						}
					
						if ($categories['parent_id'] == 0){
						   if ($required_name){
								$required_name = '<li><a href="' . dsf_seasonal_article_url($categories['article_id']) . '">' .$article_name . '</a>'  . BREADCRUMB_SEPERATOR .  '</li>' . $required_name;
						   }else{
								$required_name = '<li><a href="' . dsf_seasonal_article_url($categories['article_id']) . '">' . $article_name . '</a></li>';
						   }
						 }else{
							$loopstopper ++;
								if ($loopstopper < 6) { // max 4 links down, stops loops on rouge unlinked categories.
				
										if($required_name){
															$required_name = dsf_get_seasonal_article_breadcrumb_tree ($categories['parent_id'], $loopstopper, '<li><a href="' . dsf_article_three_url($categories['article_id']) . '">' . $article_name . '</a>'  . BREADCRUMB_SEPERATOR . '</li>' . $required_name);
										}else{
															$required_name = dsf_get_seasonal_article_breadcrumb_tree ($categories['parent_id'], $loopstopper, '<li><a href="' . dsf_article_three_url($categories['article_id']) . '">' . $article_name . '</a></li>');
										}
								}
						}
			}

return $required_name;
}




// #####

function dsf_get_seasonal_article_sub($article_id=0){
	
$return_array = '';


				$seasonal_query_where = " and sa.article_status='1'";

	
		if (isset($article_id) && (int)$article_id > 0){
			
			
			$aquery = dsf_db_query("select sa.article_id, sa.article_title as ov_article_title, sa.article_name as ov_article_name, sa.article_slug as ov_article_slug, sa.article_image_one as ov_article_image_one, sa.sub_title_image as ov_sub_title_image, sa.article_override_url as ov_article_override_url, sa.article_url_window as ov_article_url_window, sa.title_image as ov_title_image, sa.menu_image as ov_menu_image, sa.mobile_menu_image as ov_mobile_menu_image, sa.tablet_menu_image as ov_tablet_menu_image, sa.subpage_text as ov_subpage_text,  
			la.article_title, la.article_name, la.article_slug, la.article_image_one, la.sub_title_image, la.article_override_url, la.article_url_window, la.title_image,la.menu_image, la.mobile_menu_image, la.tablet_menu_image, la.subpage_text from " . DS_DB_SHOP . ".seasonal_articles sa left join " . DS_DB_LANGUAGE . ".seasonal_articles la on (sa.article_id = la.article_id) where sa.article_id='" . $article_id ."'" . $seasonal_query_where);
			
			$aresults = dsf_db_fetch_array($aquery);
			
			
						
						if (isset($aresults['article_id'])){
						
							$tmp_val = (strlen($aresults['ov_article_override_url']) >0 ? $aresults['ov_article_override_url'] : $aresults['article_override_url']);



								// identify url
								 if (strlen($tmp_val) > 1){
									 // override url
									 $url = $tmp_val;
								 }else{
									 $url = dsf_seasonal_article_url($aresults['article_id']);
								 }


							$win_type = (strlen($aresults['ov_article_url_window']) >0 ? $aresults['ov_article_url_window'] : $aresults['article_url_window']);
							$tmp_im = (strlen($aresults['ov_article_image_one']) >0 ? $aresults['ov_article_image_one'] : $aresults['article_image_one']);
							$tmp_men = (strlen($aresults['ov_menu_image']) >0 ? $aresults['ov_menu_image'] : $aresults['menu_image']);
							$tmp_mobile_men = (strlen($aresults['ov_mobile_menu_image']) >0 ? $aresults['ov_mobile_menu_image'] : $aresults['mobile_menu_image']);
							$tmp_tablet_men = (strlen($aresults['ov_tablet_menu_image']) >0 ? $aresults['ov_tablet_menu_image'] : $aresults['tablet_menu_image']);

							// get the four article items.
							
											
									$return_array = array('url' => $url,
														 'url_window' => ((int)$win_type == 1 ? 'true' : 'false'),
														 'title' => (strlen($aresults['ov_article_title']) >0 ? $aresults['ov_article_title'] : $aresults['article_title']),
														 'name' => (strlen($aresults['ov_article_name']) >0 ? $aresults['ov_article_name'] : $aresults['article_name']),
														 'id' => $aresults['article_id'],
														 'header_image' => (strlen($aresults['ov_title_image']) >0 ? $aresults['ov_title_image'] : $aresults['title_image']),
														 'header_title' => (strlen($aresults['ov_article_title']) >0 ? $aresults['ov_article_title'] : $aresults['article_title']),
														 'image' => (strlen($tmp_im) > 3 ? 'sized/home/' . $tmp_im : ''),
														 'image_width' => FRONT_SEASONAL_IMAGE_WIDTH,
														 'image_height' => FRONT_SEASONAL_IMAGE_HEIGHT,
														 'menu_image' => (strlen($tmp_men) > 3 ? 'sized/home/' . $tmp_men : ''),
														 'menu_image_width' => MENU_IMAGE_WIDTH,
														 'menu_image_height' => MENU_IMAGE_HEIGHT,
														 'mobile_menu_image' => (strlen($tmp_mobile_men) > 3 ? 'sized/home/' . $tmp_mobile_men : ''),
														 'mobile_menu_image_width' => MOBILE_MENU_IMAGE_WIDTH,
														 'mobile_menu_image_height' => MOBILE_MENU_IMAGE_HEIGHT,
														 'tablet_menu_image' => (strlen($tmp_tablet_men) > 3 ? 'sized/home/' . $tmp_tablet_men : ''),
														 'tablet_menu_image_width' => TABLET_MENU_IMAGE_WIDTH,
														 'tablet_menu_image_height' => TABLET_MENU_IMAGE_HEIGHT,
														 'type' => 'info_seasonal_article',
														 'text' => (strlen($aresults['ov_subpage_text']) >0 ? $aresults['ov_subpage_text'] : $aresults['subpage_text'])
														 );
											

			
							unset($tmp_val);
							unset($tmp_im);
							unset($tmp_men);
							unset($tmp_type);



						}  // end if found
		} 
	return $return_array;

  }


function dsf_get_seasonal_article_product($products_id = 0){
	global $currencies;
	
$return_array = '';

		
		if ((int)$products_id >0){
		
			// get prod details
					 $accessory_info_query = dsf_db_query("select sp.products_id, sp.products_name as ov_products_name, sp.products_description as ov_products_description, sp.products_othernames as ov_products_othernames, sp.products_model as ov_products_model, sp.products_main_cat, sp.products_slug as ov_products_slug, sp.category_image as ov_category_image, sp.products_price, sp.products_tax_class_id, sp.rrp_price, sp.allow_purchase, sp.web_exclusive, sp.products_image_one as ov_products_image_one, sp.products_image_two as ov_products_image_two, sp.products_image_three as ov_products_image_three, sp.products_image_four as ov_products_image_four,lp.products_image_one , lp.products_image_two , lp.products_image_three, lp.products_image_four, 
											lp.products_name, lp.products_description, lp.products_othernames, lp.products_model, lp.products_slug, lp.category_image from " . DS_DB_SHOP . ".products sp left join " . DS_DB_LANGUAGE . ".products lp on (sp.products_id = lp.products_id) where sp.products_status = '1' and sp.products_id = '" . (int)$products_id . "'");
						
						
						
						// only do the rest if the product is actually found (may be disabled.)
						if (dsf_db_num_rows($accessory_info_query) > 0){
							
								$accessory_info_values = dsf_db_fetch_array($accessory_info_query);
								
									if ($acc_price = dsf_get_products_special_price($accessory_info_values['products_id'])) {
									  $offer_price = $currencies->display_price($acc_price, dsf_get_tax_rate($accessory_info_values['products_tax_class_id']));
									} else {
									 $offer_price = '';
									}
									
									 $price = $currencies->display_price($accessory_info_values['products_price'], dsf_get_tax_rate($accessory_info_values['products_tax_class_id']));
									 $rrp_price = $currencies->display_price($accessory_info_values['rrp_price'],0);
					
									 
									 $tmp_im = (strlen($accessory_info_values['ov_category_image']) > 0 ? $accessory_info_values['ov_category_image'] : $accessory_info_values['category_image']);
									 
									 
									if (defined('ARTICLE_PRODUCT_LISTING_WIDTH')){
												$image = (strlen($tmp_im)>1 ? 'sized/listing/atcl_' . $tmp_im : '');
									}else{
												$image = (strlen($tmp_im)>1 ? 'sized/listing/' . $tmp_im : '');
									}
							
									  $standard_image = (strlen($tmp_im)>1 ? 'sized/listing/' . $tmp_im : '');
							
									  $large_image = (strlen($tmp_im)>1 ? 'sized/listing/large_' . $tmp_im : '');
									  
									  
										$tmp_doc = (strlen($accessory_info_values['ov_products_image_one']) > 1 ? $accessory_info_values['ov_products_image_one'] : $accessory_info_values['products_image_one']);
									
										$image_1 = (strlen($tmp_doc)>1 ? 'sized/details/' . $tmp_doc : '');
										$image_1_thumb = (strlen($tmp_doc)>1 ? 'sized/details/thumb_' . $tmp_doc : '');
										$image_1_original = (strlen($tmp_doc)>1 ?  $tmp_doc : '');
										
										$tmp_doc = (strlen($accessory_info_values['ov_products_image_two']) > 1 ? $accessory_info_values['ov_products_image_two'] : $accessory_info_values['products_image_two']);
									
										$image_2 = (strlen($tmp_doc)>1 ? 'sized/details/' . $tmp_doc : '');
										$image_2_thumb = (strlen($tmp_doc)>1 ? 'sized/details/thumb_' . $tmp_doc : '');
										$image_2_original = (strlen($tmp_doc)>1 ?  $tmp_doc : '');
									
									
										$tmp_doc = (strlen($accessory_info_values['ov_products_image_three']) > 1 ? $accessory_info_values['ov_products_image_three'] : $accessory_info_values['products_image_three']);
									
										$image_3 = (strlen($tmp_doc)>1 ? 'sized/details/' . $tmp_doc : '');
										$image_3_thumb = (strlen($tmp_doc)>1 ? 'sized/details/thumb_' . $tmp_doc : '');
										$image_3_original = (strlen($tmp_doc)>1 ?  $tmp_doc : '');
									
									
										$tmp_doc = (strlen($accessory_info_values['ov_products_image_four']) > 1 ? $accessory_info_values['ov_products_image_four'] : $accessory_info_values['products_image_four']);
									
										$image_4 = (strlen($tmp_doc)>1 ? 'sized/details/' . $tmp_doc : '');
										$image_4_thumb = (strlen($tmp_doc)>1 ? 'sized/details/thumb_' . $tmp_doc : '');
										$image_4_original = (strlen($tmp_doc)>1 ?  $tmp_doc : '');
									
									  
									  
									  
									  
									  
									  
									  
									  
									  
									
									 $tmp_slug = (strlen($accessory_info_values['ov_products_slug']) > 0 ? $accessory_info_values['ov_products_slug'] : $accessory_info_values['products_slug']);
									
									 $url = dsf_product_url($accessory_info_values['products_id'] , $accessory_info_values['products_main_cat'], $tmp_slug);
									
									
									
									if  ((int)$accessory_info_values['allow_purchase'] == 1 && $dsv_disable_ecommerce == 'false'){
										$buy_url = dsf_product_url($accessory_info_values['products_id'] , $accessory_info_values['products_main_cat'], $tmp_slug, 'action=buy_now');
										$add_url = dsf_product_url($accessory_info_values['products_id'] , $accessory_info_values['products_main_cat'], $tmp_slug, 'action=buy_now&add=yes');
									}else{
										$buy_url = '';
										$add_url = '';
									}
										
									 $allow_purchase = ((int)$accessory_info_values['allow_purchase'] == 1 ? 'true' : 'false');
									 
									 $awards =  dsf_return_awards_array($products_id);
			
									 $return_array = array('id' => $products_id,
															  'title' => (strlen($accessory_info_values['ov_products_name']) > 0 ? $accessory_info_values['ov_products_name'] : $accessory_info_values['products_name']),
															  'name' => (strlen($accessory_info_values['ov_products_name']) > 0 ? $accessory_info_values['ov_products_name'] : $accessory_info_values['products_name']),
															  'model' => (strlen($accessory_info_values['ov_products_model']) > 0 ? $accessory_info_values['ov_products_model'] : $accessory_info_values['products_model']),
															  'image' => $image,
															  'large_image' => $large_image,
															  'standard_image' => $standard_image,
															  'image_1' => $image_1,
															  'image_1_thumb' => $image_1_thumb,
															  'image_1_original' => $image_1_original,
															  'image_2' => $image_2,
															  'image_2_thumb' => $image_2_thumb,
															  'image_2_original' => $image_2_original,
															  'image_3' => $image_3,
															  'image_3_thumb' => $image_3_thumb,
															  'image_3_original' => $image_3_original,
															  'image_4' => $image_4,
															  'image_4_thumb' => $image_4_thumb,
															  'image_4_original' => $image_4_original,

															  'url' => $url,
															  'buy_url' => $buy_url,
															  'add_url' => $add_url,
															  'allow_purchase' => $allow_purchase,
															  'rrp_price' => $rrp_price,
															  'offer_price' => $offer_price,
															  'price' => $price,
																'width' => (defined('ARTICLE_PRODUCT_LISTING_WIDTH') ? ARTICLE_PRODUCT_LISTING_WIDTH : PRODUCTLISTING_IMAGE_WIDTH),
																'height' => (defined('ARTICLE_PRODUCT_LISTING_HEIGHT') ? ARTICLE_PRODUCT_LISTING_HEIGHT : PRODUCTLISTING_IMAGE_HEIGHT),
																'large_width' => PRODUCTLISTING_LARGE_IMAGE_WIDTH,
																'large_height' => PRODUCTLISTING_LARGE_IMAGE_HEIGHT,
																'standard_width' => PRODUCTLISTING_IMAGE_WIDTH,
																'standard_height' => PRODUCTLISTING_IMAGE_HEIGHT,
															  'awards' => $awards
															  );
						}
		}



	return $return_array;
	
	
}


// #####

function dsf_get_article_three_sub($article_id=0){
	
$return_array = '';

	
		if (isset($article_id) && (int)$article_id > 0){
			
			$aquery = dsf_db_query("select sa.article_id, sa.article_title as ov_article_title, sa.article_name as ov_article_name, sa.article_slug as ov_article_slug, sa.article_image as ov_article_image, sa.sub_title_image as ov_sub_title_image, sa.article_override_url as ov_article_override_url, sa.article_url_window as ov_article_url_window, sa.title_image as ov_title_image, sa.menu_image as ov_menu_image, sa.subpage_text as ov_subpage_text,  
			la.article_title, la.article_name, la.article_slug, la.article_image, la.sub_title_image, la.article_override_url, la.article_url_window, la.title_image,la.menu_image, la.subpage_text from " . DS_DB_SHOP . ".article_three sa left join " . DS_DB_LANGUAGE . ".article_three la on (sa.article_id = la.article_id) where sa.article_id='" . $article_id ."'");
			
			
			$aresults = dsf_db_fetch_array($aquery);
			
						
						if (isset($aresults['article_id'])){
						
							$tmp_val = (strlen($aresults['ov_article_override_url']) >0 ? $aresults['ov_article_override_url'] : $aresults['article_override_url']);



								// identify url
								 if (strlen($tmp_val) > 1){
									 // override url
									 $url = $tmp_val;
								 }else{
									 $url = dsf_article_three_url($aresults['article_id']);
								 }


							$win_type = (strlen($aresults['ov_article_url_window']) >0 ? $aresults['ov_article_url_window'] : $aresults['article_url_window']);
							$tmp_im = (strlen($aresults['ov_article_image']) >0 ? $aresults['ov_article_image'] : $aresults['article_image']);
							$tmp_men = (strlen($aresults['ov_menu_image']) >0 ? $aresults['ov_menu_image'] : $aresults['menu_image']);


			
			
							// get the four article items.
							
											
									$return_array = array('url' => $url,
														 'url_window' => ((int)$win_type == 1 ? 'true' : 'false'),
														 'title' => (strlen($aresults['ov_article_title']) >0 ? $aresults['ov_article_title'] : $aresults['article_title']),
														 'name' => (strlen($aresults['ov_article_name']) >0 ? $aresults['ov_article_name'] : $aresults['article_name']),
														 'id' => $aresults['article_id'],
														 'header_image' => (strlen($aresults['ov_title_image']) >0 ? $aresults['ov_title_image'] : $aresults['title_image']),
														 'header_title' => (strlen($aresults['ov_article_title']) >0 ? $aresults['ov_article_title'] : $aresults['article_title']),
														 'image' => (strlen($tmp_im) > 3 ? 'sized/home/' . $tmp_im : ''),
														 'image_width' => FRONT_ARTICLE_IMAGE_WIDTH,
														 'image_height' => FRONT_ARTICLE_IMAGE_HEIGHT,
														 'menu_image' => (strlen($tmp_men) > 3 ? 'sized/home/' . $tmp_men : ''),
														 'menu_image_width' => MENU_IMAGE_WIDTH,
														 'menu_image_height' => MENU_IMAGE_HEIGHT,
														 'type' => 'info_articles_three',
														 'text' => (strlen($aresults['ov_subpage_text']) >0 ? $aresults['ov_subpage_text'] : $aresults['subpage_text'])
														 );
											

			
							unset($tmp_val);
							unset($tmp_im);
							unset($tmp_men);
							unset($tmp_type);



				
						}  // end if found
		} // end item
		
		return $return_array;
}
// ####

function dsf_get_article_two_sub($article_id=0){
	
$return_array = '';

	
		if (isset($article_id) && (int)$article_id > 0){
			
			$aquery = dsf_db_query("select sa.article_id, sa.article_title as ov_article_title, sa.article_name as ov_article_name, sa.article_slug as ov_article_slug, sa.article_image as ov_article_image, sa.sub_title_image as ov_sub_title_image, sa.article_override_url as ov_article_override_url, sa.article_url_window as ov_article_url_window, sa.title_image as ov_title_image, sa.menu_image as ov_menu_image, sa.subpage_text as ov_subpage_text,  
			la.article_title, la.article_name, la.article_slug, la.article_image, la.sub_title_image, la.article_override_url, la.article_url_window, la.title_image,la.menu_image, la.subpage_text from " . DS_DB_SHOP . ".article_two sa left join " . DS_DB_LANGUAGE . ".article_two la on (sa.article_id = la.article_id) where sa.article_id='" . $article_id ."'");
			
			
			$aresults = dsf_db_fetch_array($aquery);
			
						
						if (isset($aresults['article_id'])){
						
							$tmp_val = (strlen($aresults['ov_article_override_url']) >0 ? $aresults['ov_article_override_url'] : $aresults['article_override_url']);



								// identify url
								 if (strlen($tmp_val) > 1){
									 // override url
									 $url = $tmp_val;
								 }else{
									 $url = dsf_article_two_url($aresults['article_id']);
								 }


							$win_type = (strlen($aresults['ov_article_url_window']) >0 ? $aresults['ov_article_url_window'] : $aresults['article_url_window']);
							$tmp_im = (strlen($aresults['ov_article_image']) >0 ? $aresults['ov_article_image'] : $aresults['article_image']);
							$tmp_men = (strlen($aresults['ov_menu_image']) >0 ? $aresults['ov_menu_image'] : $aresults['menu_image']);


			
			
							// get the four article items.
							
											
									$return_array = array('url' => $url,
														 'url_window' => ((int)$win_type == 1 ? 'true' : 'false'),
														 'title' => (strlen($aresults['ov_article_title']) >0 ? $aresults['ov_article_title'] : $aresults['article_title']),
														 'name' => (strlen($aresults['ov_article_name']) >0 ? $aresults['ov_article_name'] : $aresults['article_name']),
														 'id' => $aresults['article_id'],
														 'header_image' => (strlen($aresults['ov_title_image']) >0 ? $aresults['ov_title_image'] : $aresults['title_image']),
														 'header_title' => (strlen($aresults['ov_article_title']) >0 ? $aresults['ov_article_title'] : $aresults['article_title']),
														 'image' => (strlen($tmp_im) > 3 ? 'sized/home/' . $tmp_im : ''),
														 'image_width' => FRONT_ARTICLE_IMAGE_WIDTH,
														 'image_height' => FRONT_ARTICLE_IMAGE_HEIGHT,
														 'menu_image' => (strlen($tmp_men) > 3 ? 'sized/home/' . $tmp_men : ''),
														 'menu_image_width' => MENU_IMAGE_WIDTH,
														 'menu_image_height' => MENU_IMAGE_HEIGHT,
														 'type' => 'info_articles_three',
														 'text' => (strlen($aresults['ov_subpage_text']) >0 ? $aresults['ov_subpage_text'] : $aresults['subpage_text'])
														 );
											

			
							unset($tmp_val);
							unset($tmp_im);
							unset($tmp_men);
							unset($tmp_type);



				
						}  // end if found
		} // end item
		
		return $return_array;
}
// ####

function dsf_get_article_one_sub($article_id=0){
	
$return_array = '';

	
		if (isset($article_id) && (int)$article_id > 0){
			
			$aquery = dsf_db_query("select sa.article_id, sa.article_title as ov_article_title, sa.article_name as ov_article_name, sa.article_slug as ov_article_slug, sa.article_image as ov_article_image, sa.sub_title_image as ov_sub_title_image, sa.article_override_url as ov_article_override_url, sa.article_url_window as ov_article_url_window, sa.title_image as ov_title_image, sa.menu_image as ov_menu_image, sa.subpage_text as ov_subpage_text,  
			la.article_title, la.article_name, la.article_slug, la.article_image, la.sub_title_image, la.article_override_url, la.article_url_window, la.title_image,la.menu_image, la.subpage_text from " . DS_DB_SHOP . ".article_one sa left join " . DS_DB_LANGUAGE . ".article_one la on (sa.article_id = la.article_id) where sa.article_id='" . $article_id ."'");
			
			
			$aresults = dsf_db_fetch_array($aquery);
			
						
						if (isset($aresults['article_id'])){
						
							$tmp_val = (strlen($aresults['ov_article_override_url']) >0 ? $aresults['ov_article_override_url'] : $aresults['article_override_url']);



								// identify url
								 if (strlen($tmp_val) > 1){
									 // override url
									 $url = $tmp_val;
								 }else{
									 $url = dsf_article_one_url($aresults['article_id']);
								 }


							$win_type = (strlen($aresults['ov_article_url_window']) >0 ? $aresults['ov_article_url_window'] : $aresults['article_url_window']);
							$tmp_im = (strlen($aresults['ov_article_image']) >0 ? $aresults['ov_article_image'] : $aresults['article_image']);
							$tmp_men = (strlen($aresults['ov_menu_image']) >0 ? $aresults['ov_menu_image'] : $aresults['menu_image']);


			
			
							// get the four article items.
							
											
									$return_array = array('url' => $url,
														 'url_window' => ((int)$win_type == 1 ? 'true' : 'false'),
														 'title' => (strlen($aresults['ov_article_title']) >0 ? $aresults['ov_article_title'] : $aresults['article_title']),
														 'name' => (strlen($aresults['ov_article_name']) >0 ? $aresults['ov_article_name'] : $aresults['article_name']),
														 'id' => $aresults['article_id'],
														 'header_image' => (strlen($aresults['ov_title_image']) >0 ? $aresults['ov_title_image'] : $aresults['title_image']),
														 'header_title' => (strlen($aresults['ov_article_title']) >0 ? $aresults['ov_article_title'] : $aresults['article_title']),
														 'image' => (strlen($tmp_im) > 3 ? 'sized/home/' . $tmp_im : ''),
														 'image_width' => FRONT_ARTICLE_IMAGE_WIDTH,
														 'image_height' => FRONT_ARTICLE_IMAGE_HEIGHT,
														 'menu_image' => (strlen($tmp_men) > 3 ? 'sized/home/' . $tmp_men : ''),
														 'menu_image_width' => MENU_IMAGE_WIDTH,
														 'menu_image_height' => MENU_IMAGE_HEIGHT,
														 'type' => 'info_articles_three',
														 'text' => (strlen($aresults['ov_subpage_text']) >0 ? $aresults['ov_subpage_text'] : $aresults['subpage_text'])
														 );
											

			
							unset($tmp_val);
							unset($tmp_im);
							unset($tmp_men);
							unset($tmp_type);



				
						}  // end if found
		} // end item
		
		return $return_array;
}
// ####


// ####
function dsf_get_consumer_poll_item_array($pollID=0, $include_related='true'){

// there are more items required for a poll than just the information stored in the database when it comes to 
// getting the post variables which can only been supplied from a root / root include file.


	$consumer_poll_details = '';
	
	$dsv_sql_fields_required = array('poll_id', 'poll_type', 'parent_id', 'unit_id', 'item_translated', 'override_required', 'override_layout_folder', 'override_layout_file', 'override_content_folder', 'override_content_file', 'item_approved', 'poll_text', 'poll_short', 'poll_slug', 'poll_image', 'poll_image_two', 'poll_image_three', 'poll_image_four', 'mobile_poll_image', 'mobile_poll_image_two', 'mobile_poll_image_three', 'mobile_poll_image_four', 'tablet_poll_image', 'tablet_poll_image_two', 'tablet_poll_image_three', 'tablet_poll_image_four', 'menu_image', 'poll_title', 'sort_order', 'poll_header_image', 'poll_header_title', 'poll_question', 'poll_answers', 'poll_status', 'answer_option', 'single_answer', 'seo_title', 'seo_keywords', 'seo_description', 'terms_text', 'terms_text_block', 'text_one', 'text_two', 'text_three', 'text_four', 'text_block_one', 'text_block_two', 'text_block_three', 'text_block_four', 'text_success', 'text_block_success');
	$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sg','lg');
	
    // get details of the poll items
    
    $poll_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".consumer_poll sg left join " . DS_DB_LANGUAGE . ".consumer_poll lg on (sg.poll_id = lg.poll_id) where sg.poll_id='" . (int)$pollID . "' and (sg.poll_status='1' or sg.poll_status='2') ");
  
  
  if (dsf_db_num_rows($poll_query) > 0){
	    $poll_results = dsf_db_fetch_array($poll_query);
	
			
			$consumer_poll_details = dsf_sql_override_values($dsv_sql_fields_required, $poll_results);
			// at this point we make amendments or additions to the array.
		
			$consumer_poll_details['url'] = dsf_href_link('consumer_polls.html' , 'pollID=' . $pollID );
			$consumer_poll_details['attributes'] = 'pollID=' . $pollID ;
			
			
			//unset a couple of fields
			unset($consumer_poll_details['item_translated']);
			
			// resolve issue with layout override being a 0 on a shop.
			if ((int)$consumer_poll_details['override_required'] == -9){
				// shop says absolute NO.
				
				$consumer_poll_details['override_required'] = 0;
				unset($consumer_poll_details['override_layout_folder']);
				unset($consumer_poll_details['override_layout_file']);
				unset($consumer_poll_details['override_content_folder']);
				unset($consumer_poll_details['override_content_file']);
				
				// language specifically says override therefore we accept that.		
			}elseif ((int)$consumer_poll_details['override_required'] == 1){
				
				$consumer_poll_details['override_required'] = 1;
				
				// now check if language override_required is 0 - if it is remove any remains that may be left over in the other fields.		
			}else{
				
				$consumer_poll_details['override_required'] = 0;
				unset($consumer_poll_details['override_layout_folder']);
				unset($consumer_poll_details['override_layout_file']);
				unset($consumer_poll_details['override_content_folder']);
				unset($consumer_poll_details['override_content_file']);
			}
			
			
			// poll type.
			if (isset($consumer_poll_details['poll_type']) && (int)$consumer_poll_details['poll_type'] == 1){
				$consumer_poll_details['poll_type'] = 'File';
			}else{
				$consumer_poll_details['poll_type'] = 'Folder';
			}
			
			
			
			// poll Status.
			if (isset($consumer_poll_details['poll_status']) && (int)$consumer_poll_details['poll_status'] == 1){
				$consumer_poll_details['poll_status'] = 'Active';
			}elseif (isset($consumer_poll_details['poll_status']) && (int)$consumer_poll_details['poll_status'] == 2){
				$consumer_poll_details['poll_status'] = 'Complete';
			}else{
				$consumer_poll_details['poll_status'] = 'Disabled';
			}
					
			
			// poll Status info
			
			$consumer_poll_details['poll_status_info'] = "There are 3 possible status values.  \nActive - should show item for customer to vote providing the form element does not say they have already voted.\nComplete - the voting is over should show the results in content file\nDisabled - should not be showing anything for the item";
			


// SPECIFIC ITEMS FOR FILE ONLY 			
	if ((int)$poll_results['poll_type'] == 1){
		// it is a file
				
			// add fields information
			
			$consumer_poll_details['form'] = array();
			
			$fields_array = array();
			$fields_array['poll_answer'] = 'input type text 128 characters';
			
			$consumer_poll_details['form']['fields'] = $fields_array;
			$consumer_poll_details['form']['post-url'] = dsf_href_link('consumer_polls.html' , 'pollID=' . $pollID .'&action=submit' );
			$consumer_poll_details['form']['post-url-ajax'] = dsf_href_link('consumer_polls.html' , 'pollID=' . $pollID .'&action=ajax_submit' );
			$consumer_poll_details['form']['information'] = 'Variables will be created automatically for all fields using the prefix ' . '$' . 'dsv_  ie ' . '$' . 'dsv_poll_answer  when the form has been posted, these variables contain the information submitted' ."\n\n" . 'Note the different URL for ajax posting. If you wish the allocated content file to be returned as part of an ajax request then the ajax url needs to be used to prevent the layout file being processed as part of the return.' . "\n\n" . 'form[status] has 3 possibilities' . "\ndisplay - Never submitted show initial form\nsuccess - Form submitted and everything fine show success content\nerror - page was submitted and an error was generated the field form[errors] will contain a list of errors to display";

			$consumer_poll_details['form']['status'] = 'display'; // root files accessing this function need to change this value accordingly.




			// check to see if this session number has already submitted information before.
				$dsv_poll_session_id = dsf_session_id();
			
				$query = dsf_db_query("select poll_answer from " . DS_DB_SHOP . ".consumer_poll_results where session_id='" . $dsv_poll_session_id . "' and poll_id='" . $pollID . "'");
				
				if (dsf_db_num_rows($query) > 0){
					$dsv_poll_already_submitted = 'true';
				}else{
					$dsv_poll_already_submitted = 'false';
				}
			
			
				$consumer_poll_details['user_already_completed'] = $dsv_poll_already_submitted;
				
			



// get other related polls

			// look for related live items (same parent);
		if ($include_related == 'true'){
			// only do this if true otherwise we will end up in an infinite loop.
				
			$consumer_poll_details['related_active_poll_items'] = array();
			
			$query = dsf_db_query("select poll_id from " . DS_DB_SHOP . ".consumer_poll where parent_id='" . (int)$consumer_poll_details['parent_id'] . "' and poll_id <>'" . $pollID . "' and poll_type='1' and poll_status='1'");
			while ($results = dsf_db_fetch_array($query)){
				
				$consumer_poll_details['related_active_poll_items'][] = dsf_get_consumer_poll_item_array($results['poll_id'], 'false');
			
			}

		}


			// look for related dropped (completed) items (same parent);
			
		if ($include_related == 'true'){
			// only do this if true otherwise we will end up in an infinite loop.
				
			$consumer_poll_details['related_complete_poll_items'] = array();
			
			$query = dsf_db_query("select poll_id from " . DS_DB_SHOP . ".consumer_poll where parent_id='" . (int)$consumer_poll_details['parent_id'] . "' and poll_id <>'" . $pollID . "' and poll_type='1' and poll_status='2'");
			while ($results = dsf_db_fetch_array($query)){
				
				$consumer_poll_details['related_complete_poll_items'][] = dsf_get_consumer_poll_item_array($results['poll_id'], 'false');
			
			}

		}




			
			// lastly check to see if there are any results.

				$consumer_poll_details['results'] = array();
				$consumer_poll_details['results']['answers'] = array();
				

				// first thing to do is get the total number of items.
				
				$query = dsf_db_query("select poll_answer from " . DS_DB_SHOP . ".consumer_poll_results where poll_id='" . $pollID . "'");
				
				$total_responses = dsf_db_num_rows($query);
				
	
	
			if ((int)$total_responses > 0){
				
					// next get the answers that we are looking for and save them into an array so we can check for these results.
					
					$query = dsf_db_query("select s.poll_answers as ov_poll_answers, l.poll_answers from " . DS_DB_SHOP . ".consumer_poll s left join " . DS_DB_LANGUAGE . ".consumer_poll l on (s.poll_id = l.poll_id) where s.poll_id='" . $pollID . "'");
					$results = dsf_db_fetch_array($query);
					
					if (isset($results['ov_poll_answers']) && strlen($results['ov_poll_answers']) > 3){
						// use the shops values
						$poll_answers = $results['ov_poll_answers'];
					}else{
						// use the language values
						$poll_answers = $results['poll_answers'];
					}
					
					$valid_answers = array();
					
							$split_answer_box = explode("\n", $poll_answers);
							
							$highest_value = 0;
							$highest_key = '';
							
							
							foreach($split_answer_box as $answer_name){
								
								if (strlen($answer_name) > 0){
									
									$check_answer = trim($answer_name);
									
									$query = dsf_db_query("select session_id from " . DS_DB_SHOP . ".consumer_poll_results where poll_answer='" . $check_answer . "' and poll_id='" . $pollID . "'");
									$total_items = dsf_db_num_rows($query);
									
									
									if ((int)$total_items > 0){
										
										$score = (float)($total_items / $total_responses) * 100;
										
										$total_percent = number_format( ($total_items / $total_responses) * 100 , 2,'.','') . '%';
									}else{
										$total_percent = '0%';
									}
								
								
									if ($score > $highest_value){
										$highest_value = $score;
										$highest_key = $check_answer;
									}
									
								
								
									$valid_answers[$check_answer] = array('total' => $total_items , 'percent' => $total_percent, 'winner' => '');
									
								
								} // end checking we have a name.
								
								
							}
					
					
					if (strlen($highest_key) > 0){
						$valid_answers[$highest_key]['winner'] = 'true';
					}
					
					
					
					
					if (sizeof($valid_answers) > 0){
						// we have answers to show
						
							$consumer_poll_details['results']['answers'] = $valid_answers;
				
				
					}

							$consumer_poll_details['results']['total_entries'] = $total_responses;

			}else{
				
				// no entries
				
							$consumer_poll_details['results']['total_entries'] = 0;
				
			}





// put the poll answers into an array from the line breaked text field so its easier to work with.



$possible_answers = array();

$split_answer_box = explode("\n", $consumer_poll_details['poll_answers']);
							
							foreach($split_answer_box as $answer_name){
								
								
								$answer_name = trim($answer_name);
								
								if (strlen($answer_name) > 0){
									$possible_answers[] = $answer_name;
									
									// set the anwer of this item to 0 if it has not already been set.
									if (!isset($consumer_poll_details['results']['answers'][$answer_name])){
										$consumer_poll_details['results']['answers'][$answer_name] = array('total' => 0 , 'percent' => '0%');
										
									}
									
									
									
									
								}
							}
							
							$consumer_poll_details['possible_answers'] = $possible_answers;
							



	}else{
		// we are not a file therefore we can remove lots of elements from the array
		
		
			unset($consumer_poll_details['poll_header_image']);
			unset($consumer_poll_details['poll_header_title']);
			unset($consumer_poll_details['poll_image']);
			unset($consumer_poll_details['poll_image_two']);
			unset($consumer_poll_details['poll_image_three']);
			unset($consumer_poll_details['poll_image_four']);
			unset($consumer_poll_details['mobile_poll_image']);
			unset($consumer_poll_details['mobile_poll_image_two']);
			unset($consumer_poll_details['mobile_poll_image_three']);
			unset($consumer_poll_details['mobile_poll_image_four']);
			unset($consumer_poll_details['tablet_poll_image']);
			unset($consumer_poll_details['tablet_poll_image_two']);
			unset($consumer_poll_details['tablet_poll_image_three']);
			unset($consumer_poll_details['tablet_poll_image_four']);
			unset($consumer_poll_details['poll_question']);
			unset($consumer_poll_details['poll_short']);
			unset($consumer_poll_details['poll_status_info']);
			unset($consumer_poll_details['poll_status']);
			unset($consumer_poll_details['poll_text']);
			unset($consumer_poll_details['sort_order']);
			unset($consumer_poll_details['terms_text']);
			unset($consumer_poll_details['terms_text_block']);
			unset($consumer_poll_details['text_block_one']);
			unset($consumer_poll_details['text_block_two']);
			unset($consumer_poll_details['text_block_three']);
			unset($consumer_poll_details['text_block_four']);
			unset($consumer_poll_details['text_block_success']);
			unset($consumer_poll_details['text_success']);
		
		
	
	
	
	
	} // end check for file only items.
	
	
			unset($consumer_poll_details['poll_answers']);
			unset($consumer_poll_details['single_answer']);
			unset($consumer_poll_details['unit_id']);
			unset($consumer_poll_details['answer_option']);
			unset($consumer_poll_details['item_approved']);
			



		
			// there are other items that need to be added to the array directly on the page requesting the submission (post details responses).
	
			if (is_array($consumer_poll_details)){
			
				ksort($consumer_poll_details);	
			}

	
  } // end we have a result
  
	
return $consumer_poll_details;	
}





// ####
function dsf_get_consumer_poll_random_item($pollID=0){

// a randomiser to get a poll from a parent.

	$consumer_poll_details = '';
	
	$dsv_sql_fields_required = array('poll_id', 'poll_type');
	$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sg','lg');
	
    // get details of the poll items
    
    $poll_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".consumer_poll sg left join " . DS_DB_LANGUAGE . ".consumer_poll lg on (sg.poll_id = lg.poll_id) where sg.poll_id='" . (int)$pollID . "' and sg.poll_status='1' ");
  
  if (dsf_db_num_rows($poll_query) > 0){
	    $poll_results = dsf_db_fetch_array($poll_query);
	
			$random_check = dsf_sql_override_values($dsv_sql_fields_required, $poll_results);
			// at this point we make amendments or additions to the array.
		
			// poll type.
			if (isset($random_check['poll_type']) && (int)$random_check['poll_type'] == 1){
				// we are a file so get the details
					$consumer_poll_details = dsf_get_consumer_poll_item_array($pollID);
			}else{
				
				// we get a random item number
					$results = dsf_random_select("select poll_id from " . DS_DB_SHOP . ".consumer_poll where parent_id='" . $pollID . "' and poll_status='1'");
  					
					if (isset($results['poll_id']) && (int)$results['poll_id'] > 0){
							$consumer_poll_details = dsf_get_consumer_poll_item_array($results['poll_id']);
					}
			}
  
  } // end we have a result.
	
return $consumer_poll_details;	
}


















// #####

function dsf_get_user_image_upload_array($mechanicID=0){

// there are more items required for a competition than just the information stored in the database when it comes to 
// getting the post variables which can only been supplied from a root / root include file.


	$image_upload_details = '';
	
	$dsv_sql_fields_required = array('mechanic_id', 'unit_id', 'item_translated', 'override_required', 'override_layout_folder', 'override_layout_file', 'override_content_folder', 'override_content_file', 'mechanic_name', 'mechanic_title', 'mechanic_meta' , 'mechanic_keywords' , 'total_images' , 'ex_script_text' , 'form_id' , 'menu_title' , 'menu_image' , 'mobile_menu_image' , 'tablet_menu_image' , 'mechanic_image_one' , 'mechanic_image_two' , 'mechanic_image_three' , 'mechanic_image_four' , 'mechanic_image_one_text' , 'mechanic_image_two_text' , 'mechanic_image_three_text' , 'mechanic_image_four_text' , 'mobile_mechanic_image_one' , 'mobile_mechanic_image_two' , 'mobile_mechanic_image_three' , 'mobile_mechanic_image_four', 'tablet_mechanic_image_one' , 'tablet_mechanic_image_two' , 'tablet_mechanic_image_three' , 'tablet_mechanic_image_four' , 'text_one', 'text_two', 'text_three', 'text_four', 'text_five', 'text_six', 'text_seven' , 'text_eight' , 'text_block_one', 'text_block_two', 'text_block_three', 'text_block_four', 'text_block_five' ,'text_block_six' , 'text_block_seven' , 'text_block_eight','email_approved_subject' , 'email_approved_text' , 'email_declined_subject' , 'email_declined_text');
	$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sg','lg');
	
    // get details of the gallery items
    
    $mechanic_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".image_upload_mechanics sg left join " . DS_DB_LANGUAGE . ".image_upload_mechanics lg on (sg.mechanic_id = lg.mechanic_id) where sg.mechanic_id='" . (int)$mechanicID . "' and sg.mechanic_status='1'");
  
  
  if (dsf_db_num_rows($mechanic_query) > 0){
	    $mechanic_results = dsf_db_fetch_array($mechanic_query);
	
			$image_upload_details = dsf_sql_override_values($dsv_sql_fields_required, $mechanic_results);
			// at this point we make amendments or additions to the array.
		
			$image_upload_details['url'] = dsf_href_link('image_upload.html' , 'mechanicID=' . $mechanicID );
			$image_upload_details['attributes'] = 'mechanicID=' . $mechanicID ;
			
			
			//unset a couple of fields
			unset($image_upload_details['item_translated']);
			
			// resolve issue with layout override being a 0 on a shop.
			if ((int)$image_upload_details['override_required'] == -9){
				// shop says absolute NO.
				
				$image_upload_details['override_required'] = 0;
				unset($image_upload_details['override_layout_folder']);
				unset($image_upload_details['override_layout_file']);
				unset($image_upload_details['override_content_folder']);
				unset($image_upload_details['override_content_file']);
				
				// language specifically says override therefore we accept that.		
			}elseif ((int)$image_upload_details['override_required'] == 1){
				
				$image_upload_details['override_required'] = 1;
				
				// now check if language override_required is 0 - if it is remove any remains that may be left over in the other fields.		
			}else{
				
				$image_upload_details['override_required'] = 0;
				unset($image_upload_details['override_layout_folder']);
				unset($image_upload_details['override_layout_file']);
				unset($image_upload_details['override_content_folder']);
				unset($image_upload_details['override_content_file']);
			}
			
					
			
			// add fields information
			
			$image_upload_details['mechanic_form'] = array();
			
			$fields_array = array();
			$fields_array['firstname'] = 'input type text 32 characters';
			$fields_array['lastname'] = 'input type text 32 characters';
			$fields_array['email_address'] = 'input type email (text) 64 characters';
			$fields_array['text_one'] = 'input type text 128 characters';
			$fields_array['text_two'] = 'input type text 128 characters';
			$fields_array['text_three'] = 'input type text 128 characters';
			$fields_array['text_four'] = 'input type text 128 characters';
			$fields_array['text_block_one'] = 'input type textarea';
			$fields_array['text_block_two'] = 'input type textarea';
			$fields_array['text_block_three'] = 'input type textarea';
			$fields_array['text_block_four'] = 'input type textarea';

			if ((int)$image_upload_details['total_images'] > 0){
				$fields_array['item_image_one'] = 'file';
			}

			if ((int)$image_upload_details['total_images'] > 1){
				$fields_array['item_image_two'] = 'file';
			}

			if ((int)$image_upload_details['total_images'] > 2){
				$fields_array['item_image_three'] = 'file';
			}

			if ((int)$image_upload_details['total_images'] > 3){
				$fields_array['item_image_four'] = 'file';
			}


			$fields_array['futureoffers'] = 'checkbox 1 = on 0 = off';
			
			$image_upload_details['mechanic_form']['fields'] = $fields_array;


		// get any filters
		
			$dsv_sql_fields_required = array('filters_id' , 'filter_name');
			$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sg','lg');
			
			// get details of the gallery items
			
			$filter_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".image_upload_filters sg left join " . DS_DB_LANGUAGE . ".image_upload_filters lg on (sg.filters_id = lg.filters_id) where sg.mechanic_id='" . (int)$mechanicID . "' and sg.filter_status='1'");
		
			$item_filters = array();
			
			while($filter_results = dsf_db_fetch_array($filter_query)){
					
				$filter_item_array = dsf_sql_override_values($dsv_sql_fields_required, $filter_results);
		
				$filter_value = $filter_item_array['filters_id'];
				$filter_name = $filter_item_array['filter_name'];
				
				$item_filters[$filter_value] = $filter_name;
				
				unset($filter_item_array);
			}
			
			$image_upload_details['mechanic_form']['filters'] = $item_filters;
			
			unset($item_filters);











			$image_upload_details['mechanic_form']['post-url'] = dsf_href_link('image_upload.html' , 'mechanicID=' . $mechanicID .'&action=submit' );
			$image_upload_details['mechanic_form']['post-url-ajax'] = dsf_href_link('image_upload.html' , 'mechanicID=' . $mechanicID .'&action=ajax_submit' );
			$image_upload_details['mechanic_form']['information'] = 'The value of total_images decides how many images can be uploaded, these are to be files ' ."\n\n" . 'The filters array is in the format filter_id => filter name.  it is the filter_id which needs to be returned in the post. ' ."\n\n" . 'Note the different URL for ajax posting. If you wish the allocated content file to be returned as part of an ajax request then the ajax url needs to be used to prevent the layout file being processed as part of the return.'  . "\n\n" . 'mechanic_form[status] has 3 possibilities' . "\ndisplay - Never submitted show initial form\nsuccess - Form submitted and everything fine show success content\nerror - page was submitted and an error was generated the field mechanic_form[errors] will contain a list of errors to display";

			$image_upload_details['mechanic_form']['status'] = 'display'; // root files accessing this function need to change this value accordingly.




		
			// there are other items that need to be added to the array directly on the page requesting the submission (post details responses).
	
			if (is_array($image_upload_details)){
			
				ksort($image_upload_details);	
			}

	
  }
  
	
return $image_upload_details;	
}



// ###### USER IMAGES SECTION ##################



function dsf_user_image_url($itemID=0, $parameters = '', $connection = 'NONSSL') {
    global $dsv_request_type, $session_started, $cpgn;

    if ((int)$itemID < 1) {
		if (DS_ERROR_SHOW == 'true'){	
			echo('<div style="color:#ff0000;"><strong>Error!</strong>Unable to determine the image!<br /><br />Details are: item ID ' . $itemID . ' Params ' . $parameters . ' connection ' . $connection ) . '</div>';
    	}else{
			return;
		}
	
	}

	
	$page = dsf_href_link('user_images.html', 'itemID=' . $itemID, $connection);
		
	$link = '';
	
    if (dsf_not_null($parameters)) {
      $link .= $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

     $link = str_replace('&amp;', '&', $link);
     $link = str_replace('?&', '?', $link);
     $link = str_replace('&', '&amp;', $link);
     $link = str_replace('///', '/', $link);
     $link = str_replace('//', '/', $link);
     $link = str_replace('http:/', 'http://', $link);
     $link = str_replace('https:/', 'https://', $link);
	
    return dsf_parse_injection($link);
  }

	




function dsf_user_image_filter_url($filterID=0, $parameters = '', $connection = 'NONSSL') {
    global $dsv_request_type, $session_started, $cpgn;

    if ((int)$filterID < 1) {
		if (DS_ERROR_SHOW == 'true'){	
			echo('<div style="color:#ff0000;"><strong>Error!</strong>Unable to determine the image!<br /><br />Details are: filter ID ' . $filterID . ' Params ' . $parameters . ' connection ' . $connection ) . '</div>';
    	}else{
			return;
		}
	
	}

	
	
	$page = dsf_href_link('user_images.html', 'filterID=' . $filterID, $connection);
		
	$link = '';
	
    if (dsf_not_null($parameters)) {
      $link .= $page . '&' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

     $link = str_replace('&amp;', '&', $link);
     $link = str_replace('?&', '?', $link);
     $link = str_replace('&', '&amp;', $link);
     $link = str_replace('///', '/', $link);
     $link = str_replace('//', '/', $link);
     $link = str_replace('http:/', 'http://', $link);
     $link = str_replace('https:/', 'https://', $link);
	
    return dsf_parse_injection($link);
  }


// ########



function dsf_user_image_mechanic_url($mechanicID=0, $parameters = '', $connection = 'NONSSL') {
    global $dsv_request_type, $session_started, $cpgn;

    if ((int)$mechanicID < 1) {
		if (DS_ERROR_SHOW == 'true'){	
			echo('<div style="color:#ff0000;"><strong>Error!</strong>Unable to determine the image!<br /><br />Details are: mechanic ID ' . $mechanicID . ' Params ' . $parameters . ' connection ' . $connection ) . '</div>';
    	}else{
			return;
		}
	
	}

	
	$page = dsf_href_link('user_images.html', 'mechanicID=' . $mechanicID, $connection);
		
	$link = '';
	
    if (dsf_not_null($parameters)) {
      $link .= $page . '&' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

     $link = str_replace('&amp;', '&', $link);
     $link = str_replace('?&', '?', $link);
     $link = str_replace('&', '&amp;', $link);
     $link = str_replace('///', '/', $link);
     $link = str_replace('//', '/', $link);
     $link = str_replace('http:/', 'http://', $link);
     $link = str_replace('https:/', 'https://', $link);
	
    return dsf_parse_injection($link);
  }


// ########






function dsf_get_user_image_details($itemID=0, $include_mech='true'){
	$user_image_details = '';
	
		// either awaiting approval or approved (never 2 specifically declined)
		$approved_filter = " and (image_approved='0' or image_approved='1')";
	
	

	// images are only at shop level therefore easy to query
	
	
	if ((int)$itemID > 0){
		// we have an ID to get the info
		
		$query = dsf_db_query("select * from " . DS_DB_SHOP . ".image_upload_items where item_id='" . $itemID . "'" . $approved_filter);
		
		if (dsf_db_num_rows($query) > 0){
			// we have an item to return.
				$user_image_details = dsf_db_fetch_array($query);
				


			$user_image_details['url'] = dsf_user_image_url($itemID);
			$user_image_details['attributes'] = 'item_id=' . $itemID ;
			
			if ($user_image_details['filter_id'] > 0){
				
				$user_image_details['url_filter_listing'] = dsf_user_image_filter_url($user_image_details['filter_id']);
				$user_image_details['url_all_listing'] = dsf_user_image_mechanic_url($user_image_details['mechanic_id']);
				
			}


		   if($user_image_details['image_approved'] == 1){
			   $user_image_details['image_status'] = 'approved';
			   $user_image_details['image_status_show'] = 'true';
		   }elseif($user_image_details['image_approved'] == 2){
			   $user_image_details['image_status'] = 'declined';
			   $user_image_details['image_status_show'] = 'false';
		   }else{
			   $user_image_details['image_status'] = 'awaiting approval';

				if (DS_APPROVE_USER_CONTENT == 'true'){
			   		$user_image_details['image_status_show'] = 'false';
				}else{
			   		$user_image_details['image_status_show'] = 'true';
				}

		   }

				
			// now we have details of the image,  we need to get details of both filter and mechancic from the image as these two items will contain possible overrides
			// we could have done it as one big query but with images only being shop level and the other two items being language and shop level, its easier to do things seperately.
			
				
				// mechanic first
				$dsv_sql_fields_required = array('secondary_override_required','secondary_override_layout_folder','secondary_override_layout_file','secondary_override_content_folder','secondary_override_content_file');
				$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sa','la');
	
    			// get details 
    
   				 $mech_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".image_upload_mechanics sa left join " . DS_DB_LANGUAGE . ".image_upload_mechanics la on (sa.mechanic_id = la.mechanic_id) where sa.mechanic_id='" . $user_image_details['mechanic_id'] . "'");
				 $mech_results = dsf_db_fetch_array($mech_query);
				 
				 $mech_details = dsf_sql_override_values($dsv_sql_fields_required, $mech_results);

				 
				// make the overrides equal to the mechanic in the first place (we should always have a mechanic not always a filter
				
				
				if ((int)$mech_results['ov_secondary_override_required'] == -9){
					// shop says absolute NO.  Nothing to do
					
					// shop or language specifically says override therefore we accept that.		
				}elseif ((int)$mech_results['ov_secondary_override_required'] == 1 || (int)$mech_results['secondary_override_required'] == 1){
					
					$user_image_details['override_required'] = 1;
					$user_image_details['override_layout_folder'] = $mech_details['secondary_override_layout_folder'];
					$user_image_details['override_layout_file'] = $mech_details['secondary_override_layout_file'];
					$user_image_details['override_content_folder'] = $mech_details['secondary_override_content_folder'];
					$user_image_details['override_content_file'] = $mech_details['secondary_override_content_file'];

				}else{
					$user_image_details['override_required'] = 0;
				}
				
				
				
				// now filter if it exists.
				if ($user_image_details['filter_id'] > 0){
						$dsv_sql_fields_required = array('override_required','override_layout_folder','override_layout_file','override_content_folder','override_content_file');
						$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sa','la');
			
						// get details 
			
						 $mech_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".image_upload_filters sa left join " . DS_DB_LANGUAGE . ".image_upload_filters la on (sa.filters_id = la.filters_id) where sa.filters_id='" . $user_image_details['filter_id'] . "'");
						 $mech_results = dsf_db_fetch_array($mech_query);
						
						 $mech_details = dsf_sql_override_values($dsv_sql_fields_required, $mech_results);
						
						// only if an override has been set - otherwise we do nothing which falls back to previous check on mechanic
						
						if ((int)$mech_results['ov_override_required'] == 1 || (int)$mech_results['override_required'] == 1){
							
							$user_image_details['override_required'] = 1;
							$user_image_details['override_layout_folder'] = $mech_details['secondary_override_layout_folder'];
							$user_image_details['override_layout_file'] = $mech_details['secondary_override_layout_file'];
							$user_image_details['override_content_folder'] = $mech_details['secondary_override_content_folder'];
							$user_image_details['override_content_file'] = $mech_details['secondary_override_content_file'];				
						
						}
				} // end if filter
				
		// thats the end of the overrides
		
		// next check for images
		
		
					$user_image_details['image_one'] = (strlen($user_image_details['item_image_one']) >1 ? 'sized/user/' . $user_image_details['item_image_one'] : '');
					$user_image_details['image_one_thumb'] = (strlen($user_image_details['item_image_one']) >1 ? 'sized/user/small_' . $user_image_details['item_image_one'] : '');
		
					$user_image_details['image_two'] = (strlen($user_image_details['item_image_two']) >1 ? 'sized/user/' . $user_image_details['item_image_two'] : '');
					$user_image_details['image_two_thumb'] = (strlen($user_image_details['item_image_two']) >1 ? 'sized/user/small_' . $user_image_details['item_image_two'] : '');
		
					$user_image_details['image_three'] = (strlen($user_image_details['item_image_three']) >1 ? 'sized/user/' . $user_image_details['item_image_three'] : '');
					$user_image_details['image_three_thumb'] = (strlen($user_image_details['item_image_three']) >1 ? 'sized/user/small_' . $user_image_details['item_image_three'] : '');

					$user_image_details['image_four'] = (strlen($user_image_details['item_image_four']) >1 ? 'sized/user/' . $user_image_details['item_image_four'] : '');
					$user_image_details['image_four_thumb'] = (strlen($user_image_details['item_image_four']) >1 ? 'sized/user/small_' . $user_image_details['item_image_four'] : '');
		

				// unset the originals
				
				unset($user_image_details['item_image_one']);
				unset($user_image_details['item_image_two']);
				unset($user_image_details['item_image_three']);
				unset($user_image_details['item_image_four']);
				



		// specific internal items to unset
		
				unset($user_image_details['unit_id']);
				unset($user_image_details['item_translated']);
				unset($user_image_details['item_approved']);
				unset($user_image_details['item_slug']);
				unset($user_image_details['image_sort_order']);
				unset($user_image_details['image_highlight']);
				unset($user_image_details['image_audit_trail']);



		// resort the array
				ksort($user_image_details);	
	 

		// lastly add on mechanic data
		
		if ($include_mech == 'true'){
			$user_image_details['mechanic'] = dsf_get_user_image_upload_array($user_image_details['mechanic_id']);
		}



		} // end we have item to return
	
	} // end we have an item id.
	
	return $user_image_details;
}





function dsf_get_image_filter_information($filter_id=0){
	
$filter_details = '';

if ((int)$filter_id > 0){
	


		$dsv_sql_fields_required = array('filters_id', 'mechanic_id', 'override_required', 'override_layout_folder', 'override_layout_file', 'override_content_folder', 'override_content_file', 'filter_style_id', 'filter_style_class', 'filter_name', 'filter_slug', 'filter_image_one', 'filter_image_two', 'filter_image_three', 'filter_image_four', 'filter_image_one_text', 'filter_image_two_text', 'filter_image_three_text', 'filter_image_four_text', 'mobile_filter_image_one', 'mobile_filter_image_two', 'mobile_filter_image_three', 'mobile_filter_image_four', 'tablet_filter_image_one', 'tablet_filter_image_two', 'tablet_filter_image_three', 'tablet_filter_image_four', 'menu_image', 'mobile_menu_image', 'tablet_menu_image', 'text_one', 'text_two', 'text_three', 'text_four', 'text_block_one', 'text_block_two', 'text_block_three', 'text_block_four', 'filter_keywords', 'filter_title', 'filter_meta', 'filter_status', 'ex_script_text', 'menu_title');
		$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sa','la');


		// get details 

		 $filter_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".image_upload_filters sa left join " . DS_DB_LANGUAGE . ".image_upload_filters la on (sa.filters_id = la.filters_id) where sa.filters_id='" . (int)$filter_id . "' and sa.filter_status='1'");
		 $filter_results = dsf_db_fetch_array($filter_query);
		 
		 $filter_details = dsf_sql_override_values($dsv_sql_fields_required, $filter_results);


			//unset a couple of fields
			unset($filter_details['filter_status']);

		// override information
		
			// resolve issue with layout override being a 0 on a shop.
			if ((int)$filter_results['ov_override_required'] == -9){
				// shop says absolute NO.
				
				$filter_details['override_required'] = 0;
				unset($filter_details['override_layout_folder']);
				unset($filter_details['override_layout_file']);
				unset($filter_details['override_content_folder']);
				unset($filter_details['override_content_file']);
				
				// language specifically says override therefore we accept that.		
			}elseif ((int)$filter_results['override_required'] == 1){
				
				$filter_details['override_required'] = 1;
				
				// now check if language override_required is 0 - if it is remove any remains that may be left over in the other fields.		
			}else{
				
				$filter_details['override_required'] = 0;
				unset($filter_details['override_layout_folder']);
				unset($filter_details['override_layout_file']);
				unset($filter_details['override_content_folder']);
				unset($filter_details['override_content_file']);
			}
		
		
		
		
		
		
		// if we have not found any override information then look at the mechanic to see if there is override information in that to bring through.
		
		
		if ($filter_details['override_required'] == 0){
			
			// no override found therefore check mechanic
			
		
				$dsv_sql_fields_required = array('secondary_override_required','secondary_override_layout_folder','secondary_override_layout_file','secondary_override_content_folder','secondary_override_content_file');
				$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sa','la');
	
    			// get details 
    
   				 $mech_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".image_upload_mechanics sa left join " . DS_DB_LANGUAGE . ".image_upload_mechanics la on (sa.mechanic_id = la.mechanic_id) where sa.mechanic_id='" . $filter_details['mechanic_id'] . "'");
				 $mech_results = dsf_db_fetch_array($mech_query);
				 
				 $mech_details = dsf_sql_override_values($dsv_sql_fields_required, $mech_results);

				 
				// make the overrides equal to the mechanic in the first place (we should always have a mechanic not always a filter
				
				
				if ((int)$mech_results['ov_secondary_override_required'] == -9){
					// shop says absolute NO.  Nothing to do
					
					// shop or language specifically says override therefore we accept that.		
				}elseif ((int)$mech_results['ov_secondary_override_required'] == 1 || (int)$mech_results['secondary_override_required'] == 1){
					
					$filter_details['override_required'] = 1;
					$filter_details['override_layout_folder'] = $mech_details['secondary_override_layout_folder'];
					$filter_details['override_layout_file'] = $mech_details['secondary_override_layout_file'];
					$filter_details['override_content_folder'] = $mech_details['secondary_override_content_folder'];
					$filter_details['override_content_file'] = $mech_details['secondary_override_content_file'];

				}
		
		
		
		
		
		}




			$filter_details['mechanic'] = dsf_get_user_image_upload_array($filter_details['mechanic_id']);




		// resort the array
				ksort($filter_details);	



} // end we have a filter id


	return $filter_details;
	
}





function dsf_create_user_image_upper_menu($mechanicID=0, $filterID=0){
	
// depending on whether we are being passed a mechanic ID or filter ID depends on the information we supply.

$user_image_menu = '';


if (isset($filterID) && (int)$filterID > 0){
	// see if we are a parent.
	$get_parent_query = dsf_db_query("select mechanic_id from " . DS_DB_SHOP . ".image_upload_filters where filters_id='" . (int)$filterID . "'");
	$get_parent_results = dsf_db_fetch_array($get_parent_query);
	
	
		$mechanic_id = (int)$get_parent_results['mechanic_id'];
		
		$selected_type='filter';
		$selected_item = $filterID;
	

	}else{
		// we have no filter therefore we must be mechanic
		$mechanic_id = (int)$mechanicID;
		
		$selected_type='mechanic';
		$selected_item = 0;
}




// now we have our mechanic, we can get items for this including any filters.

// get mechanic information

	$dsv_sql_fields_required = array('mechanic_id', 'mechanic_name', 'menu_title', 'mechanic_slug', 'mechanic_title', 'menu_image', 'mobile_menu_image', 'tablet_menu_image');
	
	$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sa','la');
	
    // get details of the article items
    
    $menu_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".image_upload_mechanics sa left join " . DS_DB_LANGUAGE . ".image_upload_mechanics la on (sa.mechanic_id = la.mechanic_id) where sa.mechanic_id='" . (int)$mechanic_id . "'");
  

  if (dsf_db_num_rows($menu_query) > 0){
	    $menu_results = dsf_db_fetch_array($menu_query);
	
			
			$menu_details = dsf_sql_override_values($dsv_sql_fields_required, $menu_results);
			// at this point we make amendments or additions to the array.

		
		
				if (strlen($menu_details['menu_title']) > 1){
					$menu_title = $menu_details['menu_title'];
				}else{
					$menu_title = $menu_details['mechanic_name'];
				}
				
		
			$user_image_menu = array('mechanic_id' => $menu_details['mechanic_id'],
									'name' => $menu_details['mechanic_name'],
									'title' => $menu_title,
									'image' => $menu_details['menu_image'],
									'mobile_image' => $menu_details['mobile_menu_image'],
									'tablet_image' => $menu_details['tablet_menu_image'],
									'url' => dsf_user_image_mechanic_url($menu_details['mechanic_id']),
									'selected' => ($selected_type == 'mechanic' ? 'true' : 'false')
									);
			



			// now we need to find the children folders
				
			$children_items = array();
			
 	$dsv_sql_fields_required = array('filters_id', 'mechanic_id', 'filter_name', 'menu_title', 'filter_slug', 'filter_title', 'menu_image', 'mobile_menu_image', 'tablet_menu_image');
	
	$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sa','la');
   
    $children_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".image_upload_filters sa left join " . DS_DB_LANGUAGE . ".image_upload_filters la on (sa.filters_id = la.filters_id) where sa.mechanic_id='" . (int)$mechanic_id . "' and sa.filter_status='1'");
  

	  
			while($children_results = dsf_db_fetch_array($children_query)){
				$menu_children = dsf_sql_override_values($dsv_sql_fields_required, $children_results);
				// at this point we make amendments or additions to the array.
	
	
	
				if (strlen($menu_children['menu_title']) > 1){
					$menu_title = $menu_children['menu_title'];
				}else{
					$menu_title = $menu_children['filter_name'];
				}
				
		
				$child_menu = array('filters_id' => $children_results['filters_id'],
									'mechanic_id' => $mechanic_id,
									'name' => $menu_children['filter_name'],
									'title' => $menu_title,
									'image' => $menu_children['menu_image'],
									'mobile_image' => $menu_children['mobile_menu_image'],
									'tablet_image' => $menu_children['tablet_menu_image'],
									'url' => dsf_user_image_filter_url($children_results['filters_id']),
									'selected' => ($children_results['filters_id'] == $selected_item ? 'true' : 'false')
									);
											
					$children_items[] = $child_menu;
					unset($child_menu);
					
	
	
			} // end while


		$user_image_menu['children'] = $children_items;


  }
	

return $user_image_menu;
	
	
} // end function



























function dsf_get_image_mechanic_listing($mechanicID=0){
	
$user_image_details = '';

				// mechanic first
				$dsv_sql_fields_required = array('secondary_override_required','secondary_override_layout_folder','secondary_override_layout_file','secondary_override_content_folder','secondary_override_content_file');
				$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sa','la');
	
    			// get details 
    
   				 $mech_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".image_upload_mechanics sa left join " . DS_DB_LANGUAGE . ".image_upload_mechanics la on (sa.mechanic_id = la.mechanic_id) where sa.mechanic_id='" . $mechanicID . "'");
				 $mech_results = dsf_db_fetch_array($mech_query);
				 
				 $mech_details = dsf_sql_override_values($dsv_sql_fields_required, $mech_results);

				 
				// make the overrides equal to the mechanic in the first place (we should always have a mechanic not always a filter
				
				
				if ((int)$mech_results['ov_secondary_override_required'] == -9){
					// shop says absolute NO.  Nothing to do
					
					// shop or language specifically says override therefore we accept that.		
				}elseif ((int)$mech_results['ov_secondary_override_required'] == 1 || (int)$mech_results['secondary_override_required'] == 1){
					
					$user_image_details['override_required'] = 1;
					$user_image_details['override_layout_folder'] = $mech_details['secondary_override_layout_folder'];
					$user_image_details['override_layout_file'] = $mech_details['secondary_override_layout_file'];
					$user_image_details['override_content_folder'] = $mech_details['secondary_override_content_folder'];
					$user_image_details['override_content_file'] = $mech_details['secondary_override_content_file'];

				}else{
					$user_image_details['override_required'] = 0;
				}




			$user_image_details['mechanic'] = dsf_get_user_image_upload_array($mechanicID);


return $user_image_details;


}













function dsf_get_user_image_items($mechanicID=0, $filterID=0, $pageID=1, $maximum_images=0, $exclude_id=0){

// items per page is stored in 	USER_IMAGE_PER_PAGE
$images_details = '';


if ($mechanicID > 0 || $filterID >0){
	
	
	if (DS_APPROVE_USER_CONTENT == 'true'){
		// we must have an item approved.
		$approved_filter = " and image_approved='1'";
	}else{
		// either awaiting approval or approved (never 2 specifically declined)
		$approved_filter = " and (image_approved='0' or image_approved='1')";
	}
	
	if ((int)$exclude_id > 0){
		$approved_filter .= " and item_id <>'" . (int)$exclude_id . "'";
		
	}


	// decide if we are getting data from filter or mechanic.
	
	if ($filterID > 0){

			$listing_sql = "select item_id, filter_id, mechanic_id, image_name, item_image_one, item_image_two, item_image_three, item_image_four, item_image_one_text, item_image_two_text, item_image_three_text, item_image_four_text, text_one, text_two, text_three, text_four, text_five, text_block_one, text_block_two, text_block_three, text_block_four, text_block_five, firstname, lastname, email_address from " . DS_DB_SHOP . ".image_upload_items where filter_id='" . $filterID . "'" . $approved_filter . " order by item_id DESC";

	}else{
		
			$listing_sql = "select item_id, filter_id, mechanic_id, image_name, item_image_one, item_image_two, item_image_three, item_image_four, item_image_one_text, item_image_two_text, item_image_three_text, item_image_four_text, text_one, text_two, text_three, text_four, text_five, text_block_one, text_block_two, text_block_three, text_block_four, text_block_five, firstname, lastname, email_address from " . DS_DB_SHOP . ".image_upload_items where mechanic_id='" . $mechanicID . "'" . $approved_filter. " order by item_id DESC";
		
	}
	
	
	
	if ((int)$maximum_images < 2){
		$maximum_images = USER_IMAGE_PER_PAGE;
	}
	
		  
	$listing_split = new splitPageResults($listing_sql, $maximum_images, 'item_id');
    $listing = dsf_db_query($listing_split->sql_query);
	// there are records.
	

	$images_details = array('total_images' => $listing_split->number_of_rows,
							'current_page' => $listing_split->current_page_number,
							'total_pages' => $listing_split->number_of_pages,
							'images_per_page' => $listing_split->number_of_rows_per_page);
							


	$url_pages = array();
	$url_ajax_pages = array();
	
	
	// urls
	
	 for($k=1, $j=$listing_split->number_of_pages +1; $k<$j; $k++) {
	
			
			
			if ($filterID > 0){
				$url_pages[$k] = dsf_user_image_filter_url($filterID, ($k > 1 ? 'page=' . $k : ''));
				$url_ajax_pages[$k] = dsf_user_image_filter_url($filterID, 'ajax_page=' . $k );
			}else{
				$url_pages[$k] = dsf_user_image_mechanic_url($mechanicID, ($k > 1 ? 'page=' . $k : ''));
				$url_ajax_pages[$k] = dsf_user_image_mechanic_url($mechanicID, 'ajax_page=' . $k );
			}


	 }

	$images_details['page_urls'] = $url_pages;
	$images_details['page_ajax_urls'] = $url_ajax_pages;



	$image_details_images = array();
	
	// loop through the images.
	
	while ($user_image_details = dsf_db_fetch_array($listing)){
		


			$user_image_details['url'] = dsf_user_image_url($user_image_details['item_id']);
			$user_image_details['attributes'] = 'item_id=' . $user_image_details['item_id'] ;
			
			if ($user_image_details['filter_id'] > 0){
				
				$user_image_details['url_filter_listing'] = dsf_user_image_filter_url($user_image_details['filter_id']);
				
			}



					$user_image_details['image_one'] = (strlen($user_image_details['item_image_one']) >1 ? 'sized/user/' . $user_image_details['item_image_one'] : '');
					$user_image_details['image_one_thumb'] = (strlen($user_image_details['item_image_one']) >1 ? 'sized/user/small_' . $user_image_details['item_image_one'] : '');
		
					$user_image_details['image_two'] = (strlen($user_image_details['item_image_two']) >1 ? 'sized/user/' . $user_image_details['item_image_two'] : '');
					$user_image_details['image_two_thumb'] = (strlen($user_image_details['item_image_two']) >1 ? 'sized/user/small_' . $user_image_details['item_image_two'] : '');
		
					$user_image_details['image_three'] = (strlen($user_image_details['item_image_three']) >1 ? 'sized/user/' . $user_image_details['item_image_three'] : '');
					$user_image_details['image_three_thumb'] = (strlen($user_image_details['item_image_three']) >1 ? 'sized/user/small_' . $user_image_details['item_image_three'] : '');

					$user_image_details['image_four'] = (strlen($user_image_details['item_image_four']) >1 ? 'sized/user/' . $user_image_details['item_image_four'] : '');
					$user_image_details['image_four_thumb'] = (strlen($user_image_details['item_image_four']) >1 ? 'sized/user/small_' . $user_image_details['item_image_four'] : '');
		

				// unset the originals
				
				unset($user_image_details['item_image_one']);
				unset($user_image_details['item_image_two']);
				unset($user_image_details['item_image_three']);
				unset($user_image_details['item_image_four']);
				

		// resort the array
				ksort($user_image_details);	


				$image_details_images[] = $user_image_details;

		
	}


	$images_details['images'] = $image_details_images;







} // end mechanic or filter set.

return $images_details;
}



// END USER IMAGES SECTION #####################





// SEASONAL ARTICLES AND ARTICLES ONE TWO AND THREE ITEMS FOR SEASONAL ARTICLES



function dsf_get_seasonal_article_item_array($article_id=0){
global $bref, $dsv_system_folder_prefix;



				$seasonal_query_where = " and sa.article_status='1'";


	$seasonal_details = '';
	
	$dsv_sql_fields_required = array('article_id', 'article_type', 'unit_id', 'item_translated', 'item_approved', 'override_required', 'override_layout_folder', 'override_layout_file', 'override_content_folder', 'override_content_file', 'article_style_id', 'article_style_class', 'include_element', 'include_children', 'parent_id', 'sort_order', 'article_name', 'menu_title', 'article_slug', 'article_image_one', 'article_image_two', 'article_image_three', 'article_image_four', 'article_image_five', 'article_image_six', 'article_image_seven', 'article_image_eight', 'article_image_one_text', 'article_image_two_text', 'article_image_three_text', 'article_image_four_text', 'article_image_five_text', 'article_image_six_text', 'article_image_seven_text', 'article_image_eight_text', 'mobile_article_image_one', 'mobile_article_image_two', 'mobile_article_image_three', 'mobile_article_image_four', 'mobile_article_image_five', 'mobile_article_image_six', 'mobile_article_image_seven', 'mobile_article_image_eight', 'tablet_article_image_one', 'tablet_article_image_two', 'tablet_article_image_three', 'tablet_article_image_four', 'tablet_article_image_five', 'tablet_article_image_six', 'tablet_article_image_seven', 'tablet_article_image_eight', 'title_image', 'sub_title_image', 'menu_image', 'mobile_menu_image', 'tablet_menu_image', 'mobile_title_image', 'tablet_title_image', 'mobile_sub_title_image', 'tablet_sub_title_image', 'text_one', 'text_two', 'text_three', 'text_four', 'text_five', 'text_six', 'text_seven', 'text_eight', 'text_block_one', 'text_block_two', 'text_block_three', 'text_block_four', 'text_block_five', 'text_block_six', 'text_block_seven', 'text_block_eight', 'article_keywords', 'article_title', 'article_meta', 'subpage_text', 'sub_prod_one', 'sub_prod_two', 'sub_prod_three', 'sub_prod_four', 'sub_prod_five', 'sub_prod_six', 'sub_prod_seven', 'sub_prod_eight', 'sub_article_items', 'article_category', 'sub_art_one', 'sub_art_two', 'sub_art_three', 'sub_art_four', 'article_date', 'article_image_disclaimer', 'article_override_url', 'article_video', 'article_video_title', 'video_width', 'video_height', 'article_video_text', 'article_youtube_link', 'image_collection_one', 'image_collection_one_text', 'image_collection_two', 'image_collection_two_text', 'pdf_one', 'pdf_one_text', 'pdf_two', 'pdf_two_text', 'article_hide_menu', 'article_status', 'article_url_window', 'ex_script_text', 'user_photo_mechanic_id', 'user_photo_gallery' , 'secondary_banner', 'banner_one', 'banner_two', 'banner_three', 'banner_four', 'banner_five', 'banner_six', 'banner_one_link', 'banner_two_link', 'banner_three_link', 'banner_four_link', 'banner_five_link', 'banner_six_link', 'banner_one_bak_colour', 'banner_one_bak_image', 'banner_two_bak_colour', 'banner_two_bak_image', 'banner_three_bak_colour', 'banner_three_bak_image', 'banner_four_bak_colour', 'banner_four_bak_image', 'banner_five_bak_colour', 'banner_five_bak_image', 'banner_six_bak_colour', 'banner_six_bak_image', 'banner_one_window', 'banner_two_window', 'banner_three_window', 'banner_four_window', 'banner_five_window', 'banner_six_window', 'banner_one_image_override', 'banner_two_image_override', 'banner_three_image_override', 'banner_four_image_override', 'banner_five_image_override', 'banner_six_image_override', 'mobile_banner_one', 'mobile_banner_one_link', 'mobile_banner_one_bak_colour', 'mobile_banner_one_bak_image', 'mobile_banner_one_window', 'mobile_banner_one_image_override', 'mobile_banner_two', 'mobile_banner_two_link', 'mobile_banner_two_bak_colour', 'mobile_banner_two_bak_image', 'mobile_banner_two_window', 'mobile_banner_two_image_override', 'mobile_banner_three', 'mobile_banner_three_link', 'mobile_banner_three_bak_colour', 'mobile_banner_three_bak_image', 'mobile_banner_three_window', 'mobile_banner_three_image_override', 'mobile_banner_four', 'mobile_banner_four_link', 'mobile_banner_four_bak_colour', 'mobile_banner_four_bak_image', 'mobile_banner_four_window', 'mobile_banner_four_image_override', 'mobile_banner_five', 'mobile_banner_five_link', 'mobile_banner_five_bak_colour', 'mobile_banner_five_bak_image', 'mobile_banner_five_window', 'mobile_banner_five_image_override', 'mobile_banner_six', 'mobile_banner_six_link', 'mobile_banner_six_bak_colour', 'mobile_banner_six_bak_image', 'mobile_banner_six_window', 'mobile_banner_six_image_override', 'tablet_banner_one', 'tablet_banner_one_link', 'tablet_banner_one_bak_colour', 'tablet_banner_one_bak_image', 'tablet_banner_one_window', 'tablet_banner_one_image_override', 'tablet_banner_two', 'tablet_banner_two_link', 'tablet_banner_two_bak_colour', 'tablet_banner_two_bak_image', 'tablet_banner_two_window', 'tablet_banner_two_image_override', 'tablet_banner_three', 'tablet_banner_three_link', 'tablet_banner_three_bak_colour', 'tablet_banner_three_bak_image', 'tablet_banner_three_window', 'tablet_banner_three_image_override', 'tablet_banner_four', 'tablet_banner_four_link', 'tablet_banner_four_bak_colour', 'tablet_banner_four_bak_image', 'tablet_banner_four_window', 'tablet_banner_four_image_override', 'tablet_banner_five', 'tablet_banner_five_link', 'tablet_banner_five_bak_colour', 'tablet_banner_five_bak_image', 'tablet_banner_five_window', 'tablet_banner_five_image_override', 'tablet_banner_six', 'tablet_banner_six_link', 'tablet_banner_six_bak_colour', 'tablet_banner_six_bak_image', 'tablet_banner_six_window', 'tablet_banner_six_image_override');
	
	$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sa','la');
	
   
   
    // get details of the article items

    
    $seasonal_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".seasonal_articles sa left join " . DS_DB_LANGUAGE . ".seasonal_articles la on (sa.article_id = la.article_id) where sa.article_id='" . (int)$article_id . "'" . $seasonal_query_where);
  

  if (dsf_db_num_rows($seasonal_query) > 0){
	    $seasonal_results = dsf_db_fetch_array($seasonal_query);
	
		//	echo dsf_print_array($gallery_results);
			
			$seasonal_details = dsf_sql_override_values($dsv_sql_fields_required, $seasonal_results);
			// at this point we make amendments or additions to the array.

		
			$seasonal_details['url'] = dsf_seasonal_article_url($article_id);
			$seasonal_details['attributes'] = 'article_id=' . $article_id ;
			
			
			// check for the type of article (exclude a 0 from shop values)
			
			if ($seasonal_results['ov_article_type'] > 0){
				// fine it is already set.
			}else{
				// its not been overridden therefore language takes over.
				$seasonal_details['article_type'] = $seasonal_results['article_type'];
			}
			
			
			
			//unset a couple of fields
			unset($seasonal_details['item_translated']);
			
			// resolve issue with layout override being a 0 on a shop.
			if ((int)$seasonal_results['ov_override_required'] == -9){
				// shop says absolute NO.
				
				$seasonal_details['override_required'] = 0;
				unset($seasonal_details['override_layout_folder']);
				unset($seasonal_details['override_layout_file']);
				unset($seasonal_details['override_content_folder']);
				unset($seasonal_details['override_content_file']);
				
				// language specifically says override therefore we accept that.		
			}elseif ((int)$seasonal_results['override_required'] == 1){
				
				$seasonal_details['override_required'] = 1;
				
				// now check if language override_required is 0 - if it is remove any remains that may be left over in the other fields.		
			}else{
				
				$seasonal_details['override_required'] = 0;
				unset($seasonal_details['override_layout_folder']);
				unset($seasonal_details['override_layout_file']);
				unset($seasonal_details['override_content_folder']);
				unset($seasonal_details['override_content_file']);
			}




// addition 2014-09-29 for sub items we need to have override information for home page.


			if(isset($seasonal_details['override_required']) && (int)$seasonal_details['override_required'] == 1){
			
				if (isset($seasonal_details['override_content_folder']) && strlen($seasonal_details['override_content_folder']) > 1){
			
					$seasonal_details['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . $seasonal_details['override_content_folder'] . '/';
				}else{
					$seasonal_details['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . 'default/';
				}
				
				
				if (isset($seasonal_details['override_content_file']) && strlen($seasonal_details['override_content_file']) > 1){
			
					$seasonal_details['article_include_file'] = $seasonal_details['override_content_file'];
				}else{
					$seasonal_details['article_include_file'] = 'seasonal_articles.php';
				}
				

					$seasonal_details['override_include_file'] = $seasonal_details['article_include_path'] . $seasonal_details['article_include_file'];
										
										
			} // end overrides





// end addition



		
		// fix article type
		
			$seasonal_details['article_type'] = $seasonal_results['article_type'];
		
		// fix include children
		
			if ((int)$seasonal_results['include_children'] == -9){
				// shop says absolute NO.
				
				$seasonal_details['include_children'] = 0;
			}elseif ($seasonal_results['ov_include_children'] == 0){
				$seasonal_details['include_children'] = $seasonal_results['include_children'];
			}
			
			


// images

// menu images

	if (strlen($seasonal_details['menu_image']) > 1){
		$seasonal_details['menu_image'] = 'sized/home/' . $seasonal_details['menu_image'];
	}

	if (strlen($seasonal_details['mobile_menu_image']) > 1){
		$seasonal_details['mobile_menu_image'] = 'sized/home/' . $seasonal_details['mobile_menu_image'];
	}


	if (strlen($seasonal_details['tablet_menu_image']) > 1){
		$seasonal_details['tablet_menu_image'] = 'sized/home/' . $seasonal_details['tablet_menu_image'];
	}

// banner images


$desktop_banner = array();

					$desktop_banner['dsv_banner_one_image'] = $seasonal_details['banner_one'];
					$desktop_banner['dsv_banner_two_image'] = $seasonal_details['banner_two'];
					$desktop_banner['dsv_banner_three_image'] = $seasonal_details['banner_three'];
					$desktop_banner['dsv_banner_four_image'] = $seasonal_details['banner_four'];
					$desktop_banner['dsv_banner_five_image'] = $seasonal_details['banner_five'];
					$desktop_banner['dsv_banner_six_image'] = $seasonal_details['banner_six'];
					
					$desktop_banner['dsv_banner_one_thumb'] = (strlen($seasonal_details['banner_one']) >1 ? 'sized/listing/thumb_' . $seasonal_details['banner_one'] : '');
					$desktop_banner['dsv_banner_two_thumb'] = (strlen($seasonal_details['banner_two']) >1 ? 'sized/listing/thumb_' . $seasonal_details['banner_two'] : '');
					$desktop_banner['dsv_banner_three_thumb'] = (strlen($seasonal_details['banner_three']) >1 ? 'sized/listing/thumb_' . $seasonal_details['banner_three'] : '');
					$desktop_banner['dsv_banner_four_thumb'] = (strlen($seasonal_details['banner_four']) >1 ? 'sized/listing/thumb_' . $seasonal_details['banner_four'] : '');
					$desktop_banner['dsv_banner_five_thumb'] = (strlen($seasonal_details['banner_five']) >1 ? 'sized/listing/thumb_' . $seasonal_details['banner_five'] : '');
					$desktop_banner['dsv_banner_six_thumb'] = (strlen($seasonal_details['banner_six']) >1 ? 'sized/listing/thumb_' . $seasonal_details['banner_six'] : '');
	
					$desktop_banner['dsv_banner_one_url'] = $seasonal_details['banner_one_link'];
					$desktop_banner['dsv_banner_two_url'] = $seasonal_details['banner_two_link'];
					$desktop_banner['dsv_banner_three_url'] = $seasonal_details['banner_three_link'];
					$desktop_banner['dsv_banner_four_url'] = $seasonal_details['banner_four_link'];
					$desktop_banner['dsv_banner_five_url'] = $seasonal_details['banner_five_link'];
					$desktop_banner['dsv_banner_six_url'] = $seasonal_details['banner_six_link'];
			
					$desktop_banner['dsv_banner_one_window'] = ((int)$seasonal_results['banner_one_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_two_window'] = ((int)$seasonal_results['banner_two_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_three_window'] = ((int)$seasonal_results['banner_three_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_four_window'] = ((int)$seasonal_results['banner_four_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_five_window'] = ((int)$seasonal_results['banner_five_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_six_window'] = ((int)$seasonal_results['banner_six_window'] == 1 ? 'true' : 'false');
	
					$desktop_banner['dsv_banner_one_bimage'] = $seasonal_details['banner_one_bak_image'];
					$desktop_banner['dsv_banner_two_bimage'] = $seasonal_details['banner_two_bak_image'];
					$desktop_banner['dsv_banner_three_bimage'] = $seasonal_details['banner_three_bak_image'];
					$desktop_banner['dsv_banner_four_bimage'] = $seasonal_details['banner_four_bak_image'];
					$desktop_banner['dsv_banner_five_bimage'] = $seasonal_details['banner_five_bak_image'];
					$desktop_banner['dsv_banner_six_bimage'] = $seasonal_details['banner_six_bak_image'];
					
					$desktop_banner['banner_one_bak_image'] = (strlen($seasonal_details['banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['banner_one_bak_image'] : '');
					$desktop_banner['banner_two_bak_image'] = (strlen($seasonal_details['banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['banner_two_bak_image'] : '');
					$desktop_banner['banner_three_bak_image'] = (strlen($seasonal_details['banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['banner_three_bak_image'] : '');
					$desktop_banner['banner_four_bak_image'] = (strlen($seasonal_details['banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['banner_four_bak_image'] : '');
					$desktop_banner['banner_five_bak_image'] = (strlen($seasonal_details['banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['banner_five_bak_image'] : '');
					$desktop_banner['banner_six_bak_image'] = (strlen($seasonal_details['banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['banner_six_bak_image'] : '');
			
					$desktop_banner['banner_one_bak_colour'] = $seasonal_details['banner_one_bak_colour'];
					$desktop_banner['banner_two_bak_colour'] = $seasonal_details['banner_two_bak_colour'];
					$desktop_banner['banner_three_bak_colour'] = $seasonal_details['banner_three_bak_colour'];
					$desktop_banner['banner_four_bak_colour'] = $seasonal_details['banner_four_bak_colour'];
					$desktop_banner['banner_five_bak_colour'] = $seasonal_details['banner_five_bak_colour'];
					$desktop_banner['banner_six_bak_colour'] = $seasonal_details['banner_six_bak_colour'];


// unset previous variables as to not confuse content developers.
					unset($seasonal_details['banner_one']);
					unset($seasonal_details['banner_two']);
					unset($seasonal_details['banner_three']);
					unset($seasonal_details['banner_four']);
					unset($seasonal_details['banner_five']);
					unset($seasonal_details['banner_six']);
					
					unset($seasonal_details['banner_one_link']);
					unset($seasonal_details['banner_two_link']);
					unset($seasonal_details['banner_three_link']);
					unset($seasonal_details['banner_four_link']);
					unset($seasonal_details['banner_five_link']);
					unset($seasonal_details['banner_six_link']);
			
					unset($seasonal_details['banner_one_window']);
					unset($seasonal_details['banner_two_window']);
					unset($seasonal_details['banner_three_window']);
					unset($seasonal_details['banner_four_window']);
					unset($seasonal_details['banner_five_window']);
					unset($seasonal_details['banner_six_window']);
	
					unset($seasonal_details['banner_one_bak_image']);
					unset($seasonal_details['banner_two_bak_image']);
					unset($seasonal_details['banner_three_bak_image']);
					unset($seasonal_details['banner_four_bak_image']);
					unset($seasonal_details['banner_five_bak_image']);
					unset($seasonal_details['banner_six_bak_image']);
					
					unset($seasonal_details['banner_one_bak_image']);
					unset($seasonal_details['banner_two_bak_image']);
					unset($seasonal_details['banner_three_bak_image']);
					unset($seasonal_details['banner_four_bak_image']);
					unset($seasonal_details['banner_five_bak_image']);
					unset($seasonal_details['banner_six_bak_image']);
			
					unset($seasonal_details['banner_one_bak_colour']);
					unset($seasonal_details['banner_two_bak_colour']);
					unset($seasonal_details['banner_three_bak_colour']);
					unset($seasonal_details['banner_four_bak_colour']);
					unset($seasonal_details['banner_five_bak_colour']);
					unset($seasonal_details['banner_six_bak_colour']);


$seasonal_details['banner_desktop'] = $desktop_banner;



$mobile_banner = array();

					$mobile_banner['dsv_banner_one_image'] = $seasonal_details['mobile_banner_one'];
					$mobile_banner['dsv_banner_two_image'] = $seasonal_details['mobile_banner_two'];
					$mobile_banner['dsv_banner_three_image'] = $seasonal_details['mobile_banner_three'];
					$mobile_banner['dsv_banner_four_image'] = $seasonal_details['mobile_banner_four'];
					$mobile_banner['dsv_banner_five_image'] = $seasonal_details['mobile_banner_five'];
					$mobile_banner['dsv_banner_six_image'] = $seasonal_details['mobile_banner_six'];
					
					$mobile_banner['dsv_banner_one_thumb'] = (strlen($seasonal_details['mobile_banner_one']) >1 ? 'sized/listing/thumb_' . $seasonal_details['mobile_banner_one'] : '');
					$mobile_banner['dsv_banner_two_thumb'] = (strlen($seasonal_details['mobile_banner_two']) >1 ? 'sized/listing/thumb_' . $seasonal_details['mobile_banner_two'] : '');
					$mobile_banner['dsv_banner_three_thumb'] = (strlen($seasonal_details['mobile_banner_three']) >1 ? 'sized/listing/thumb_' . $seasonal_details['mobile_banner_three'] : '');
					$mobile_banner['dsv_banner_four_thumb'] = (strlen($seasonal_details['mobile_banner_four']) >1 ? 'sized/listing/thumb_' . $seasonal_details['mobile_banner_four'] : '');
					$mobile_banner['dsv_banner_five_thumb'] = (strlen($seasonal_details['mobile_banner_five']) >1 ? 'sized/listing/thumb_' . $seasonal_details['mobile_banner_five'] : '');
					$mobile_banner['dsv_banner_six_thumb'] = (strlen($seasonal_details['mobile_banner_six']) >1 ? 'sized/listing/thumb_' . $seasonal_details['mobile_banner_six'] : '');
	
					$mobile_banner['dsv_banner_one_url'] = $seasonal_details['mobile_banner_one_link'];
					$mobile_banner['dsv_banner_two_url'] = $seasonal_details['mobile_banner_two_link'];
					$mobile_banner['dsv_banner_three_url'] = $seasonal_details['mobile_banner_three_link'];
					$mobile_banner['dsv_banner_four_url'] = $seasonal_details['mobile_banner_four_link'];
					$mobile_banner['dsv_banner_five_url'] = $seasonal_details['mobile_banner_five_link'];
					$mobile_banner['dsv_banner_six_url'] = $seasonal_details['mobile_banner_six_link'];
			
					$mobile_banner['dsv_banner_one_window'] = ((int)$seasonal_results['mobile_banner_one_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_two_window'] = ((int)$seasonal_results['mobile_banner_two_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_three_window'] = ((int)$seasonal_results['mobile_banner_three_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_four_window'] = ((int)$seasonal_results['mobile_banner_four_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_five_window'] = ((int)$seasonal_results['mobile_banner_five_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_six_window'] = ((int)$seasonal_results['mobile_banner_six_window'] == 1 ? 'true' : 'false');
	
					$mobile_banner['dsv_banner_one_bimage'] = $seasonal_details['mobile_banner_one_bak_image'];
					$mobile_banner['dsv_banner_two_bimage'] = $seasonal_details['mobile_banner_two_bak_image'];
					$mobile_banner['dsv_banner_three_bimage'] = $seasonal_details['mobile_banner_three_bak_image'];
					$mobile_banner['dsv_banner_four_bimage'] = $seasonal_details['mobile_banner_four_bak_image'];
					$mobile_banner['dsv_banner_five_bimage'] = $seasonal_details['mobile_banner_five_bak_image'];
					$mobile_banner['dsv_banner_six_bimage'] = $seasonal_details['mobile_banner_six_bak_image'];
					
					$mobile_banner['banner_one_bak_image'] = (strlen($seasonal_details['mobile_banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['mobile_banner_one_bak_image'] : '');
					$mobile_banner['banner_two_bak_image'] = (strlen($seasonal_details['mobile_banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['mobile_banner_two_bak_image'] : '');
					$mobile_banner['banner_three_bak_image'] = (strlen($seasonal_details['mobile_banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['mobile_banner_three_bak_image'] : '');
					$mobile_banner['banner_four_bak_image'] = (strlen($seasonal_details['mobile_banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['mobile_banner_four_bak_image'] : '');
					$mobile_banner['banner_five_bak_image'] = (strlen($seasonal_details['mobile_banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['mobile_banner_five_bak_image'] : '');
					$mobile_banner['banner_six_bak_image'] = (strlen($seasonal_details['mobile_banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['mobile_banner_six_bak_image'] : '');
			
					$mobile_banner['banner_one_bak_colour'] = $seasonal_details['mobile_banner_one_bak_colour'];
					$mobile_banner['banner_two_bak_colour'] = $seasonal_details['mobile_banner_two_bak_colour'];
					$mobile_banner['banner_three_bak_colour'] = $seasonal_details['mobile_banner_three_bak_colour'];
					$mobile_banner['banner_four_bak_colour'] = $seasonal_details['mobile_banner_four_bak_colour'];
					$mobile_banner['banner_five_bak_colour'] = $seasonal_details['mobile_banner_five_bak_colour'];
					$mobile_banner['banner_six_bak_colour'] = $seasonal_details['mobile_banner_six_bak_colour'];


// unset previous variables as to not confuse content developers.
					unset($seasonal_details['mobile_banner_one']);
					unset($seasonal_details['mobile_banner_two']);
					unset($seasonal_details['mobile_banner_three']);
					unset($seasonal_details['mobile_banner_four']);
					unset($seasonal_details['mobile_banner_five']);
					unset($seasonal_details['mobile_banner_six']);
					
					unset($seasonal_details['mobile_banner_one_link']);
					unset($seasonal_details['mobile_banner_two_link']);
					unset($seasonal_details['mobile_banner_three_link']);
					unset($seasonal_details['mobile_banner_four_link']);
					unset($seasonal_details['mobile_banner_five_link']);
					unset($seasonal_details['mobile_banner_six_link']);
			
					unset($seasonal_details['mobile_banner_one_window']);
					unset($seasonal_details['mobile_banner_two_window']);
					unset($seasonal_details['mobile_banner_three_window']);
					unset($seasonal_details['mobile_banner_four_window']);
					unset($seasonal_details['mobile_banner_five_window']);
					unset($seasonal_details['mobile_banner_six_window']);
	
					unset($seasonal_details['mobile_banner_one_bak_image']);
					unset($seasonal_details['mobile_banner_two_bak_image']);
					unset($seasonal_details['mobile_banner_three_bak_image']);
					unset($seasonal_details['mobile_banner_four_bak_image']);
					unset($seasonal_details['mobile_banner_five_bak_image']);
					unset($seasonal_details['mobile_banner_six_bak_image']);
					
					unset($seasonal_details['mobile_banner_one_bak_image']);
					unset($seasonal_details['mobile_banner_two_bak_image']);
					unset($seasonal_details['mobile_banner_three_bak_image']);
					unset($seasonal_details['mobile_banner_four_bak_image']);
					unset($seasonal_details['mobile_banner_five_bak_image']);
					unset($seasonal_details['mobile_banner_six_bak_image']);
			
					unset($seasonal_details['mobile_banner_one_bak_colour']);
					unset($seasonal_details['mobile_banner_two_bak_colour']);
					unset($seasonal_details['mobile_banner_three_bak_colour']);
					unset($seasonal_details['mobile_banner_four_bak_colour']);
					unset($seasonal_details['mobile_banner_five_bak_colour']);
					unset($seasonal_details['mobile_banner_six_bak_colour']);


$seasonal_details['banner_mobile'] = $mobile_banner;



$tablet_banner = array();

					$tablet_banner['dsv_banner_one_image'] = $seasonal_details['tablet_banner_one'];
					$tablet_banner['dsv_banner_two_image'] = $seasonal_details['tablet_banner_two'];
					$tablet_banner['dsv_banner_three_image'] = $seasonal_details['tablet_banner_three'];
					$tablet_banner['dsv_banner_four_image'] = $seasonal_details['tablet_banner_four'];
					$tablet_banner['dsv_banner_five_image'] = $seasonal_details['tablet_banner_five'];
					$tablet_banner['dsv_banner_six_image'] = $seasonal_details['tablet_banner_six'];
					
					$tablet_banner['dsv_banner_one_thumb'] = (strlen($seasonal_details['tablet_banner_one']) >1 ? 'sized/listing/thumb_' . $seasonal_details['tablet_banner_one'] : '');
					$tablet_banner['dsv_banner_two_thumb'] = (strlen($seasonal_details['tablet_banner_two']) >1 ? 'sized/listing/thumb_' . $seasonal_details['tablet_banner_two'] : '');
					$tablet_banner['dsv_banner_three_thumb'] = (strlen($seasonal_details['tablet_banner_three']) >1 ? 'sized/listing/thumb_' . $seasonal_details['tablet_banner_three'] : '');
					$tablet_banner['dsv_banner_four_thumb'] = (strlen($seasonal_details['tablet_banner_four']) >1 ? 'sized/listing/thumb_' . $seasonal_details['tablet_banner_four'] : '');
					$tablet_banner['dsv_banner_five_thumb'] = (strlen($seasonal_details['tablet_banner_five']) >1 ? 'sized/listing/thumb_' . $seasonal_details['tablet_banner_five'] : '');
					$tablet_banner['dsv_banner_six_thumb'] = (strlen($seasonal_details['tablet_banner_six']) >1 ? 'sized/listing/thumb_' . $seasonal_details['tablet_banner_six'] : '');
	
					$tablet_banner['dsv_banner_one_url'] = $seasonal_details['tablet_banner_one_link'];
					$tablet_banner['dsv_banner_two_url'] = $seasonal_details['tablet_banner_two_link'];
					$tablet_banner['dsv_banner_three_url'] = $seasonal_details['tablet_banner_three_link'];
					$tablet_banner['dsv_banner_four_url'] = $seasonal_details['tablet_banner_four_link'];
					$tablet_banner['dsv_banner_five_url'] = $seasonal_details['tablet_banner_five_link'];
					$tablet_banner['dsv_banner_six_url'] = $seasonal_details['tablet_banner_six_link'];
			
					$tablet_banner['dsv_banner_one_window'] = ((int)$seasonal_results['tablet_banner_one_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_two_window'] = ((int)$seasonal_results['tablet_banner_two_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_three_window'] = ((int)$seasonal_results['tablet_banner_three_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_four_window'] = ((int)$seasonal_results['tablet_banner_four_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_five_window'] = ((int)$seasonal_results['tablet_banner_five_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_six_window'] = ((int)$seasonal_results['tablet_banner_six_window'] == 1 ? 'true' : 'false');
	
					$tablet_banner['dsv_banner_one_bimage'] = $seasonal_details['tablet_banner_one_bak_image'];
					$tablet_banner['dsv_banner_two_bimage'] = $seasonal_details['tablet_banner_two_bak_image'];
					$tablet_banner['dsv_banner_three_bimage'] = $seasonal_details['tablet_banner_three_bak_image'];
					$tablet_banner['dsv_banner_four_bimage'] = $seasonal_details['tablet_banner_four_bak_image'];
					$tablet_banner['dsv_banner_five_bimage'] = $seasonal_details['tablet_banner_five_bak_image'];
					$tablet_banner['dsv_banner_six_bimage'] = $seasonal_details['tablet_banner_six_bak_image'];
					
					$tablet_banner['banner_one_bak_image'] = (strlen($seasonal_details['tablet_banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['tablet_banner_one_bak_image'] : '');
					$tablet_banner['banner_two_bak_image'] = (strlen($seasonal_details['tablet_banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['tablet_banner_two_bak_image'] : '');
					$tablet_banner['banner_three_bak_image'] = (strlen($seasonal_details['tablet_banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['tablet_banner_three_bak_image'] : '');
					$tablet_banner['banner_four_bak_image'] = (strlen($seasonal_details['tablet_banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['tablet_banner_four_bak_image'] : '');
					$tablet_banner['banner_five_bak_image'] = (strlen($seasonal_details['tablet_banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['tablet_banner_five_bak_image'] : '');
					$tablet_banner['banner_six_bak_image'] = (strlen($seasonal_details['tablet_banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $seasonal_details['tablet_banner_six_bak_image'] : '');
			
					$tablet_banner['banner_one_bak_colour'] = $seasonal_details['tablet_banner_one_bak_colour'];
					$tablet_banner['banner_two_bak_colour'] = $seasonal_details['tablet_banner_two_bak_colour'];
					$tablet_banner['banner_three_bak_colour'] = $seasonal_details['tablet_banner_three_bak_colour'];
					$tablet_banner['banner_four_bak_colour'] = $seasonal_details['tablet_banner_four_bak_colour'];
					$tablet_banner['banner_five_bak_colour'] = $seasonal_details['tablet_banner_five_bak_colour'];
					$tablet_banner['banner_six_bak_colour'] = $seasonal_details['tablet_banner_six_bak_colour'];


// unset previous variables as to not confuse content developers.
					unset($seasonal_details['tablet_banner_one']);
					unset($seasonal_details['tablet_banner_two']);
					unset($seasonal_details['tablet_banner_three']);
					unset($seasonal_details['tablet_banner_four']);
					unset($seasonal_details['tablet_banner_five']);
					unset($seasonal_details['tablet_banner_six']);
					
					unset($seasonal_details['tablet_banner_one_link']);
					unset($seasonal_details['tablet_banner_two_link']);
					unset($seasonal_details['tablet_banner_three_link']);
					unset($seasonal_details['tablet_banner_four_link']);
					unset($seasonal_details['tablet_banner_five_link']);
					unset($seasonal_details['tablet_banner_six_link']);
			
					unset($seasonal_details['tablet_banner_one_window']);
					unset($seasonal_details['tablet_banner_two_window']);
					unset($seasonal_details['tablet_banner_three_window']);
					unset($seasonal_details['tablet_banner_four_window']);
					unset($seasonal_details['tablet_banner_five_window']);
					unset($seasonal_details['tablet_banner_six_window']);
	
					unset($seasonal_details['tablet_banner_one_bak_image']);
					unset($seasonal_details['tablet_banner_two_bak_image']);
					unset($seasonal_details['tablet_banner_three_bak_image']);
					unset($seasonal_details['tablet_banner_four_bak_image']);
					unset($seasonal_details['tablet_banner_five_bak_image']);
					unset($seasonal_details['tablet_banner_six_bak_image']);
					
					unset($seasonal_details['tablet_banner_one_bak_image']);
					unset($seasonal_details['tablet_banner_two_bak_image']);
					unset($seasonal_details['tablet_banner_three_bak_image']);
					unset($seasonal_details['tablet_banner_four_bak_image']);
					unset($seasonal_details['tablet_banner_five_bak_image']);
					unset($seasonal_details['tablet_banner_six_bak_image']);
			
					unset($seasonal_details['tablet_banner_one_bak_colour']);
					unset($seasonal_details['tablet_banner_two_bak_colour']);
					unset($seasonal_details['tablet_banner_three_bak_colour']);
					unset($seasonal_details['tablet_banner_four_bak_colour']);
					unset($seasonal_details['tablet_banner_five_bak_colour']);
					unset($seasonal_details['tablet_banner_six_bak_colour']);

$seasonal_details['banner_tablet'] = $tablet_banner;


unset($desktop_banner);
unset($mobile_banner);
unset($tablet_banner);



// overrides not currently in use
unset($seasonal_details['banner_one_image_override']);
unset($seasonal_details['banner_two_image_override']);
unset($seasonal_details['banner_three_image_override']);
unset($seasonal_details['banner_four_image_override']);
unset($seasonal_details['banner_five_image_override']);
unset($seasonal_details['banner_six_image_override']);

unset($seasonal_details['mobile_banner_one_image_override']);
unset($seasonal_details['mobile_banner_two_image_override']);
unset($seasonal_details['mobile_banner_three_image_override']);
unset($seasonal_details['mobile_banner_four_image_override']);
unset($seasonal_details['mobile_banner_five_image_override']);
unset($seasonal_details['mobile_banner_six_image_override']);

unset($seasonal_details['tablet_banner_one_image_override']);
unset($seasonal_details['tablet_banner_two_image_override']);
unset($seasonal_details['tablet_banner_three_image_override']);
unset($seasonal_details['tablet_banner_four_image_override']);
unset($seasonal_details['tablet_banner_five_image_override']);
unset($seasonal_details['tablet_banner_six_image_override']);



// sort out the products array if any products have been set.
		$article_products = array();
		
		if (isset($seasonal_details['sub_prod_one']) && (int)$seasonal_details['sub_prod_one'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($seasonal_details['sub_prod_one']);
		}
		
		if (isset($seasonal_details['sub_prod_two']) && (int)$seasonal_details['sub_prod_two'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($seasonal_details['sub_prod_two']);
		}
		
		if (isset($seasonal_details['sub_prod_three']) && (int)$seasonal_details['sub_prod_three'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($seasonal_details['sub_prod_three']);
		}
		
		if (isset($seasonal_details['sub_prod_four']) && (int)$seasonal_details['sub_prod_four'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($seasonal_details['sub_prod_four']);
		}
		
		if (isset($seasonal_details['sub_prod_five']) && (int)$seasonal_details['sub_prod_five'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($seasonal_details['sub_prod_five']);
		}
		
		if (isset($seasonal_details['sub_prod_six']) && (int)$seasonal_details['sub_prod_six'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($seasonal_details['sub_prod_six']);
		}
		
		if (isset($seasonal_details['sub_prod_seven']) && (int)$seasonal_details['sub_prod_seven'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($seasonal_details['sub_prod_seven']);
		}
		
		if (isset($seasonal_details['sub_prod_eight']) && (int)$seasonal_details['sub_prod_eight'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($seasonal_details['sub_prod_eight']);
		}


	$seasonal_details['article_products'] = $article_products;

	unset($article_products);

// unset the original values.

		unset($seasonal_details['sub_prod_one']);
		unset($seasonal_details['sub_prod_two']);
		unset($seasonal_details['sub_prod_three']);
		unset($seasonal_details['sub_prod_four']);
		unset($seasonal_details['sub_prod_five']);
		unset($seasonal_details['sub_prod_six']);
		unset($seasonal_details['sub_prod_seven']);
		unset($seasonal_details['sub_prod_eight']);




// check for any user image mechanic allocated.
if (isset($seasonal_details['user_photo_mechanic_id']) && (int)$seasonal_details['user_photo_mechanic_id'] > 0){
	$seasonal_details['user_photo_mechanic_details'] = dsf_get_user_image_upload_array($seasonal_details['user_photo_mechanic_id']);
}

		unset($seasonal_details['user_photo_mechanic_id']);




// check for any user image mechanic allocated.
if (isset($seasonal_details['user_photo_gallery']) && strlen($seasonal_details['user_photo_gallery']) > 0){
	
		 $user_image_details = explode(":" , $seasonal_details['user_photo_gallery']);
		
			if (isset($user_image_details[0]) && isset($user_image_details[1]) ){
				// we have two values, therefore decide whether mechanic or filter.

					
						if ($user_image_details[0] == 'M'){
							// mechanic
							$user_images = dsf_get_user_image_items($user_image_details[1], 0, 1, 8);
						}else{
							// filter
							$user_images = dsf_get_user_image_items(0, $user_image_details[1], 1, 8);
						}
		
		
					// unset some user_image items
		
					if (is_array($user_images)){
						
						
						if ((int)$user_images['total_images'] > 8){
							$user_images['total_images'] = 8;
						}
						
						
						// unset some things
						unset($user_images['current_page']);
						unset($user_images['total_pages']);
						unset($user_images['images_per_page']);
						unset($user_images['page_urls']);
						unset($user_images['page_ajax_urls']);
						
						
						$seasonal_details['user_images'] = $user_images;
		
						unset($user_images);
			
					}
			}
			
}

 unset($seasonal_details['user_photo_gallery']);










// check for any specific sub allocated articles.
		
// get the sub_art items as we use them a couple of times below and it should not be necessary to have to query the database multiple times.

						
							// get the 4 article items that can be allocated to a folder item.
							$sub_articles = array();
							
									if (isset($seasonal_details['sub_art_one']) && (int)$seasonal_details['sub_art_one'] > 0){
										$sub_articles[] = dsf_get_seasonal_article_sub($seasonal_details['sub_art_one']);
									}
							
									if (isset($seasonal_details['sub_art_two']) && (int)$seasonal_details['sub_art_two'] > 0){
										$sub_articles[] = dsf_get_seasonal_article_sub($seasonal_details['sub_art_two']);
									}
							
									if (isset($seasonal_details['sub_art_three']) && (int)$seasonal_details['sub_art_three'] > 0){
										$sub_articles[] = dsf_get_seasonal_article_sub($seasonal_details['sub_art_three']);
									}
							
									if (isset($seasonal_details['sub_art_four']) && (int)$seasonal_details['sub_art_four'] > 0){
										$sub_articles[] = dsf_get_seasonal_article_sub($seasonal_details['sub_art_four']);
									}
							
							
									$seasonal_details['sub_articles'] = $sub_articles;
							
								unset($sub_articles);
							
						
						

		// check for allocated items - these need to also be in children therefore moved into function call.
		


		$seasonal_details['allocated_items'] = array();
		
		
		
		if (isset($seasonal_details['sub_article_items']) && strlen($seasonal_details['sub_article_items']) > 2){
			
			// we need to explode the values and loop through them to see what to add.
			
				$allocated_items = explode("~", $seasonal_details['sub_article_items']);
				
				
				foreach($allocated_items as $temp_item){
					
					$actual_item = explode("::" , $temp_item);
					
					if (isset($actual_item[0]) && (int)$actual_item[0] > 0 && isset($actual_item[1]) && (int)$actual_item[1] > 0){
						
						// we have an item to work with.
						
							
									$temp_child = array();
									
									if ((int)$actual_item[0] == 1){
										// competition
										
										$temp_child['article_include_type'] = 'competition';
										// get the details.
										$temp_child['competition_details'] = dsf_get_competition_item_array($actual_item[1]);
										

									}elseif ((int)$actual_item[0] == 4){
										// gallery
										
										$temp_child['article_include_type'] = 'gallery';
										// get the details.
										$temp_child['gallery_details'] = dsf_get_gallery_item_array($actual_item[1], $gID);


									}elseif ((int)$actual_item[0] == 5){
										// seasonal article
										
										$temp_child['article_include_type'] = 'article_one';
										// get the details.
										$temp_child['article_one_details'] = dsf_get_article_one_item_array($actual_item[1]);

										// article 1 does not have content overrides

										

									}elseif ((int)$actual_item[0] == 6){
										// seasonal article
										
										$temp_child['article_include_type'] = 'article_two';
										// get the details.
										$temp_child['article_two_details'] = dsf_get_article_two_item_array($actual_item[1]);

										// article 2 does not have content overrides


									}elseif ((int)$actual_item[0] == 7){
										// seasonal article
										
										$temp_child['article_include_type'] = 'article_three';
										// get the details.
										$temp_child['article_three_details'] = dsf_get_article_three_item_array($actual_item[1]);

										// article 3 does not have content overrides


										
										
									}elseif ((int)$actual_item[0] == 8){
										// seasonal article
										
										$temp_child['article_include_type'] = 'seasonal_article';
										// get the details.
										$temp_child['seasonal_details'] = dsf_get_seasonal_article_item_array($actual_item[1]);
										
										
								// AMENDMENT 2014-09-29
								
										// for seasonal article items,  it is possible the item being brought in is already an include in which case we need more info.
										if ((int)$temp_child['seasonal_details']['article_type'] == 1){
											
											
														$temp_child['seasonal_details']['article_level'] = 'article';
				
														if(isset($temp_child['seasonal_details']['override_required']) && (int)$temp_child['seasonal_details']['override_required'] == 1){
														
															if (isset($temp_child['seasonal_details']['override_content_folder']) && strlen($temp_child['seasonal_details']['override_content_folder']) > 1){
														
																$temp_child['seasonal_details']['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . $temp_child['seasonal_details']['override_content_folder'] . '/';
															}else{
																$temp_child['seasonal_details']['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . 'default/';
															}
															
															
															if (isset($temp_child['seasonal_details']['override_content_file']) && strlen($temp_child['seasonal_details']['override_content_file']) > 1){
														
																$temp_child['seasonal_details']['article_include_file'] = $temp_child['seasonal_details']['override_content_file'];
															}else{
																$temp_child['seasonal_details']['article_include_file'] = 'seasonal_articles.php';
															}
															
				
																$temp_child['seasonal_details']['override_include_file'] = $temp_child['seasonal_details']['article_include_path'] . $temp_child['seasonal_details']['article_include_file'];
																					
																					
														} // end overrides

									}elseif ((int)$temp_child['seasonal_details']['article_type'] == 3){ // the item found is marked as being an include.
											
											$temp_child['seasonal_details']['article_level'] = 'include';
											
											// we need to know what kind of include this is and allocate the details accordingly.  the only items someoneone can complete
											// for an include are:
											
											// include type.
											// include id
											// slug
											// override info
											// style id
											// style class
											// SEO fields.
											
											// get the include details.
											
											if (isset($temp_child['seasonal_details']['include_element']) && strpos($temp_child['seasonal_details']['include_element'], ":" , 0) > 0){
													$temp_include_split = explode(":" , $temp_child['seasonal_details']['include_element']);
											
											
													if (isset($temp_include_split[0]) && isset($temp_include_split[1])){
														
															$temp_child['seasonal_details']['article_include_id'] = (int)$temp_include_split[1];
															
															if ((int)$temp_include_split[0] == 1){
																// competition
																
																$temp_child['seasonal_details']['article_include_type'] = 'competition';
																// get the details.
																$temp_child['seasonal_details']['competition_details'] = dsf_get_competition_item_array($temp_child['seasonal_details']['article_include_id']);
																
						
						
															}elseif ((int)$temp_include_split[0] == 10){
																// competition
																
																$temp_child['seasonal_details']['article_include_type'] = 'consumer_poll';
																// get the details.
																$temp_child['seasonal_details']['consumer_poll_details'] = dsf_get_consumer_poll_random_item($temp_child['seasonal_details']['article_include_id']);
						
						
						
															}elseif ((int)$temp_include_split[0] == 4){
																// gallery
																
																$temp_child['seasonal_details']['article_include_type'] = 'gallery';
																// get the details.
																$temp_child['seasonal_details']['gallery_details'] = dsf_get_gallery_item_array($temp_child['seasonal_details']['article_include_id'], $gID);
																
						
														// check for layout and content overrides
														
																if(isset($temp_child['seasonal_details']['gallery_details']['override_required']) && (int)$temp_child['seasonal_details']['gallery_details']['override_required'] == 1){
																
																	if (isset($temp_child['seasonal_details']['gallery_details']['override_content_folder']) && strlen($temp_child['seasonal_details']['gallery_details']['override_content_folder']) > 1){
																
																		$temp_child['seasonal_details']['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . $temp_child['seasonal_details']['gallery_details']['override_content_folder'] . '/';
																	}else{
																		$temp_child['seasonal_details']['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . 'default/';
																	}
																	
																	
																	if (isset($temp_child['seasonal_details']['gallery_details']['override_content_file']) && strlen($temp_child['seasonal_details']['gallery_details']['override_content_file']) > 1){
																
																		$temp_child['seasonal_details']['article_include_file'] = $temp_child['seasonal_details']['gallery_details']['override_content_file'];
																	}else{
																		$temp_child['seasonal_details']['article_include_file'] = 'gallery.php';
																	}
																	
						
																		$temp_child['seasonal_details']['override_include_file'] = $temp_child['seasonal_details']['article_include_path'] . $temp_child['seasonal_details']['article_include_file'];
																							
																							
																} // end overrides
						
						
						
						
															}elseif ((int)$temp_include_split[0] == 5){
																// seasonal article
																
																$temp_child['seasonal_details']['article_include_type'] = 'article_one';
																// get the details.
																$temp_child['seasonal_details']['article_one_details'] = dsf_get_article_one_item_array($temp_child['seasonal_details']['article_include_id']);
						
																// article 1 does not have content overrides
						
																
						
															}elseif ((int)$temp_include_split[0] == 6){
																// seasonal article
																
																$temp_child['seasonal_details']['article_include_type'] = 'article_two';
																// get the details.
																$temp_child['seasonal_details']['article_two_details'] = dsf_get_article_two_item_array($temp_child['seasonal_details']['article_include_id']);
						
																// article 2 does not have content overrides
						
						
															}elseif ((int)$temp_include_split[0] == 7){
																// seasonal article
																
																$temp_child['seasonal_details']['article_include_type'] = 'article_three';
																// get the details.
																$temp_child['seasonal_details']['article_three_details'] = dsf_get_article_three_item_array($temp_child['seasonal_details']['article_include_id']);
						
																// article 3 does not have content overrides
						
						
																
																
															}elseif ((int)$temp_include_split[0] == 8){
																// seasonal article
																
																$temp_child['seasonal_details']['article_include_type'] = 'seasonal_article';
																// get the details.
																$temp_child['seasonal_details']['seasonal_details'] = dsf_get_seasonal_article_item_array($temp_child['seasonal_details']['article_include_id']);
															
														// check for layout and content overrides
														
																if(isset($temp_child['seasonal_details']['override_required']) && (int)$temp_child['seasonal_details']['override_required'] == 1){
																
																	if (isset($temp_child['seasonal_details']['override_content_folder']) && strlen($temp_child['seasonal_details']['override_content_folder']) > 1){
																
																		$temp_child['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . $temp_child['seasonal_details']['override_content_folder'] . '/';
																	}else{
																		$temp_child['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . 'default/';
																	}
																	
																	
																	if (isset($temp_child['seasonal_details']['override_content_file']) && strlen($temp_child['seasonal_details']['override_content_file']) > 1){
																
																		$temp_child['article_include_file'] = $temp_child['seasonal_details']['override_content_file'];
																	}else{
																		$temp_child['article_include_file'] = 'seasonal_articles.php';
																	}
																	
						
																		$temp_child['override_include_file'] = $temp_child['article_include_path'] . $temp_child['article_include_file'];
																							
																							
																} // end overrides
															
															
															
															} // end split types
															

													} // end isset include type.
													
											} // end splitting the element up.
											
									} // end article type 3




									// END AMENDMENT
									
									
				// end article type
											
											
											
										
										
										
										
										
										
						
						
									}elseif ((int)$actual_item[0] == 10){
										// consumer poll.
										
										$temp_child['article_include_type'] = 'consumer_poll';
										// get the details.
										$temp_child['consumer_poll_details'] = dsf_get_consumer_poll_random_item($actual_item[1]);
						
						
						
									}
						// allocate the details as an additional item.


						$seasonal_details['allocated_items'][] = $temp_child;
						unset($temp_child);
						


						
					}
					
					
					
				} // end foreach
			
			
			
			unset($allocated_items);			
			
			unset($seasonal_details['sub_article_items']);
			
			
			
		} // end checking for allocated items.







// image collections added.

	if ((int)$seasonal_details['image_collection_one'] > 0){
		$seasonal_details['gallery_one_array'] = dsf_get_gallery_item_array($seasonal_details['image_collection_one']);
	}else{
		$seasonal_details['gallery_one_array'] = '';
	}
	
		$seasonal_details['gallery_one_text'] = $seasonal_details['image_collection_one_text'];
	
	
	if ((int)$seasonal_details['image_collection_two'] > 0){
		$seasonal_details['gallery_two_array'] = dsf_get_gallery_item_array($seasonal_details['image_collection_two']);
	}else{
		$seasonal_details['gallery_two_array'] = '';
	}
	
		$seasonal_details['gallery_two_text'] = $seasonal_details['image_collection_two_text'];
	
		
	
	unset($seasonal_details['image_collection_one']);
	unset($seasonal_details['image_collection_one_text']);
	unset($seasonal_details['image_collection_two']);
	unset($seasonal_details['image_collection_two_text']);
	
	


			
		// resort the array
				ksort($seasonal_details);	


  } //end if records found.

return $seasonal_details;

} // END FUNCTION


// ######

function dsf_get_article_three_item_array($article_id=0){


	$article_three_details = '';
	
	$dsv_sql_fields_required = array('article_id', 'unit_id', 'item_translated', 'item_approved', 'article_image', 'article_name', 'article_slug', 'article_title', 'title_image', 'sub_title_image', 'menu_image', 'banner_one', 'banner_two', 'banner_three', 'banner_four', 'parent_id', 'sort_order', 'article_text', 'article_keywords', 'article_meta', 'subpage_text', 'sub_prod_one', 'sub_prod_two', 'sub_prod_three', 'sub_prod_four', 'sub_prod_five', 'sub_prod_six', 'sub_prod_seven', 'sub_prod_eight', 'article_type', 'article_category', 'sub_art_one', 'sub_art_two', 'sub_art_three', 'sub_art_four', 'article_date', 'article_image_disclaimer', 'article_override_url', 'text_block_two', 'text_block_three', 'article_video', 'video_width', 'video_height', 'article_video_text', 'article_youtube_link', 'image_collection', 'image_collection_text', 'pdf_one', 'pdf_one_text', 'pdf_two', 'pdf_two_text', 'article_video_title', 'article_hide_menu', 'article_status', 'banner_one_link', 'banner_two_link', 'banner_three_link', 'banner_four_link', 'banner_one_bak_colour', 'banner_one_bak_image', 'banner_two_bak_colour', 'banner_two_bak_image', 'banner_three_bak_colour', 'banner_three_bak_image', 'banner_four_bak_colour', 'banner_four_bak_image', 'article_url_window', 'banner_one_window', 'banner_two_window', 'banner_three_window', 'banner_four_window', 'ex_script_text', 'secondary_banner', 'banner_five', 'banner_five_link', 'banner_five_bak_colour', 'banner_five_bak_image', 'banner_five_window', 'banner_six', 'banner_six_link', 'banner_six_bak_colour', 'banner_six_bak_image', 'banner_six_window', 'banner_one_image_override', 'banner_two_image_override', 'banner_three_image_override', 'banner_four_image_override', 'banner_five_image_override', 'banner_six_image_override', 'mobile_banner_one', 'mobile_banner_one_link', 'mobile_banner_one_bak_colour', 'mobile_banner_one_bak_image', 'mobile_banner_one_window', 'mobile_banner_one_image_override', 'mobile_banner_two', 'mobile_banner_two_link', 'mobile_banner_two_bak_colour', 'mobile_banner_two_bak_image', 'mobile_banner_two_window', 'mobile_banner_two_image_override', 'mobile_banner_three', 'mobile_banner_three_link', 'mobile_banner_three_bak_colour', 'mobile_banner_three_bak_image', 'mobile_banner_three_window', 'mobile_banner_three_image_override', 'mobile_banner_four', 'mobile_banner_four_link', 'mobile_banner_four_bak_colour', 'mobile_banner_four_bak_image', 'mobile_banner_four_window', 'mobile_banner_four_image_override', 'mobile_banner_five', 'mobile_banner_five_link', 'mobile_banner_five_bak_colour', 'mobile_banner_five_bak_image', 'mobile_banner_five_window', 'mobile_banner_five_image_override', 'mobile_banner_six', 'mobile_banner_six_link', 'mobile_banner_six_bak_colour', 'mobile_banner_six_bak_image', 'mobile_banner_six_window', 'mobile_banner_six_image_override', 'tablet_banner_one', 'tablet_banner_one_link', 'tablet_banner_one_bak_colour', 'tablet_banner_one_bak_image', 'tablet_banner_one_window', 'tablet_banner_one_image_override', 'tablet_banner_two', 'tablet_banner_two_link', 'tablet_banner_two_bak_colour', 'tablet_banner_two_bak_image', 'tablet_banner_two_window', 'tablet_banner_two_image_override', 'tablet_banner_three', 'tablet_banner_three_link', 'tablet_banner_three_bak_colour', 'tablet_banner_three_bak_image', 'tablet_banner_three_window', 'tablet_banner_three_image_override', 'tablet_banner_four', 'tablet_banner_four_link', 'tablet_banner_four_bak_colour', 'tablet_banner_four_bak_image', 'tablet_banner_four_window', 'tablet_banner_four_image_override', 'tablet_banner_five', 'tablet_banner_five_link', 'tablet_banner_five_bak_colour', 'tablet_banner_five_bak_image', 'tablet_banner_five_window', 'tablet_banner_five_image_override', 'tablet_banner_six', 'tablet_banner_six_link', 'tablet_banner_six_bak_colour', 'tablet_banner_six_bak_image', 'tablet_banner_six_window', 'tablet_banner_six_image_override');
	
	$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sa','la');
	
    // get details of the gallery items
    
    $seasonal_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".article_three sa left join " . DS_DB_LANGUAGE . ".article_three la on (sa.article_id = la.article_id) where sa.article_id='" . (int)$article_id . "'");
  

  if (dsf_db_num_rows($seasonal_query) > 0){
	    $seasonal_results = dsf_db_fetch_array($seasonal_query);
	
			
			$article_three_details = dsf_sql_override_values($dsv_sql_fields_required, $seasonal_results);
			// at this point we make amendments or additions to the array.

		
			$article_three_details['url'] = dsf_article_three_url($article_id);
			$article_three_details['attributes'] = 'article_id=' . $article_id ;
			
			
			// check for the type of article (exclude a 0 from shop values)
			
			if ($seasonal_results['ov_article_type'] > 0){
				// fine it is already set.
			}else{
				// its not been overridden therefore language takes over.
				$article_three_details['article_type'] = $seasonal_results['article_type'];
			}
			
			
			
			//unset a couple of fields
			unset($article_three_details['item_translated']);
			
		
		// fix article type
		
			$article_three_details['article_type'] = $seasonal_results['article_type'];
		


// images

// menu images

	if (strlen($article_three_details['menu_image']) > 1){
		$article_three_details['menu_image'] = 'sized/home/' . $article_three_details['menu_image'];
	}

	if (strlen($article_three_details['mobile_menu_image']) > 1){
		$article_three_details['mobile_menu_image'] = 'sized/home/' . $article_three_details['mobile_menu_image'];
	}


	if (strlen($article_three_details['tablet_menu_image']) > 1){
		$article_three_details['tablet_menu_image'] = 'sized/home/' . $article_three_details['tablet_menu_image'];
	}

// banner images


$desktop_banner = array();

					$desktop_banner['dsv_banner_one_image'] = $article_three_details['banner_one'];
					$desktop_banner['dsv_banner_two_image'] = $article_three_details['banner_two'];
					$desktop_banner['dsv_banner_three_image'] = $article_three_details['banner_three'];
					$desktop_banner['dsv_banner_four_image'] = $article_three_details['banner_four'];
					$desktop_banner['dsv_banner_five_image'] = $article_three_details['banner_five'];
					$desktop_banner['dsv_banner_six_image'] = $article_three_details['banner_six'];
					
					$desktop_banner['dsv_banner_one_thumb'] = (strlen($article_three_details['banner_one']) >1 ? 'sized/listing/thumb_' . $article_three_details['banner_one'] : '');
					$desktop_banner['dsv_banner_two_thumb'] = (strlen($article_three_details['banner_two']) >1 ? 'sized/listing/thumb_' . $article_three_details['banner_two'] : '');
					$desktop_banner['dsv_banner_three_thumb'] = (strlen($article_three_details['banner_three']) >1 ? 'sized/listing/thumb_' . $article_three_details['banner_three'] : '');
					$desktop_banner['dsv_banner_four_thumb'] = (strlen($article_three_details['banner_four']) >1 ? 'sized/listing/thumb_' . $article_three_details['banner_four'] : '');
					$desktop_banner['dsv_banner_five_thumb'] = (strlen($article_three_details['banner_five']) >1 ? 'sized/listing/thumb_' . $article_three_details['banner_five'] : '');
					$desktop_banner['dsv_banner_six_thumb'] = (strlen($article_three_details['banner_six']) >1 ? 'sized/listing/thumb_' . $article_three_details['banner_six'] : '');
	
					$desktop_banner['dsv_banner_one_url'] = $article_three_details['banner_one_link'];
					$desktop_banner['dsv_banner_two_url'] = $article_three_details['banner_two_link'];
					$desktop_banner['dsv_banner_three_url'] = $article_three_details['banner_three_link'];
					$desktop_banner['dsv_banner_four_url'] = $article_three_details['banner_four_link'];
					$desktop_banner['dsv_banner_five_url'] = $article_three_details['banner_five_link'];
					$desktop_banner['dsv_banner_six_url'] = $article_three_details['banner_six_link'];
			
					$desktop_banner['dsv_banner_one_window'] = ((int)$seasonal_results['banner_one_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_two_window'] = ((int)$seasonal_results['banner_two_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_three_window'] = ((int)$seasonal_results['banner_three_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_four_window'] = ((int)$seasonal_results['banner_four_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_five_window'] = ((int)$seasonal_results['banner_five_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_six_window'] = ((int)$seasonal_results['banner_six_window'] == 1 ? 'true' : 'false');
	
					$desktop_banner['dsv_banner_one_bimage'] = $article_three_details['banner_one_bak_image'];
					$desktop_banner['dsv_banner_two_bimage'] = $article_three_details['banner_two_bak_image'];
					$desktop_banner['dsv_banner_three_bimage'] = $article_three_details['banner_three_bak_image'];
					$desktop_banner['dsv_banner_four_bimage'] = $article_three_details['banner_four_bak_image'];
					$desktop_banner['dsv_banner_five_bimage'] = $article_three_details['banner_five_bak_image'];
					$desktop_banner['dsv_banner_six_bimage'] = $article_three_details['banner_six_bak_image'];
					
					$desktop_banner['banner_one_bak_image'] = (strlen($article_three_details['banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['banner_one_bak_image'] : '');
					$desktop_banner['banner_two_bak_image'] = (strlen($article_three_details['banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['banner_two_bak_image'] : '');
					$desktop_banner['banner_three_bak_image'] = (strlen($article_three_details['banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['banner_three_bak_image'] : '');
					$desktop_banner['banner_four_bak_image'] = (strlen($article_three_details['banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['banner_four_bak_image'] : '');
					$desktop_banner['banner_five_bak_image'] = (strlen($article_three_details['banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['banner_five_bak_image'] : '');
					$desktop_banner['banner_six_bak_image'] = (strlen($article_three_details['banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['banner_six_bak_image'] : '');
			
					$desktop_banner['banner_one_bak_colour'] = $article_three_details['banner_one_bak_colour'];
					$desktop_banner['banner_two_bak_colour'] = $article_three_details['banner_two_bak_colour'];
					$desktop_banner['banner_three_bak_colour'] = $article_three_details['banner_three_bak_colour'];
					$desktop_banner['banner_four_bak_colour'] = $article_three_details['banner_four_bak_colour'];
					$desktop_banner['banner_five_bak_colour'] = $article_three_details['banner_five_bak_colour'];
					$desktop_banner['banner_six_bak_colour'] = $article_three_details['banner_six_bak_colour'];


// unset previous variables as to not confuse content developers.
					unset($article_three_details['banner_one']);
					unset($article_three_details['banner_two']);
					unset($article_three_details['banner_three']);
					unset($article_three_details['banner_four']);
					unset($article_three_details['banner_five']);
					unset($article_three_details['banner_six']);
					
					unset($article_three_details['banner_one_link']);
					unset($article_three_details['banner_two_link']);
					unset($article_three_details['banner_three_link']);
					unset($article_three_details['banner_four_link']);
					unset($article_three_details['banner_five_link']);
					unset($article_three_details['banner_six_link']);
			
					unset($article_three_details['banner_one_window']);
					unset($article_three_details['banner_two_window']);
					unset($article_three_details['banner_three_window']);
					unset($article_three_details['banner_four_window']);
					unset($article_three_details['banner_five_window']);
					unset($article_three_details['banner_six_window']);
	
					unset($article_three_details['banner_one_bak_image']);
					unset($article_three_details['banner_two_bak_image']);
					unset($article_three_details['banner_three_bak_image']);
					unset($article_three_details['banner_four_bak_image']);
					unset($article_three_details['banner_five_bak_image']);
					unset($article_three_details['banner_six_bak_image']);
					
					unset($article_three_details['banner_one_bak_image']);
					unset($article_three_details['banner_two_bak_image']);
					unset($article_three_details['banner_three_bak_image']);
					unset($article_three_details['banner_four_bak_image']);
					unset($article_three_details['banner_five_bak_image']);
					unset($article_three_details['banner_six_bak_image']);
			
					unset($article_three_details['banner_one_bak_colour']);
					unset($article_three_details['banner_two_bak_colour']);
					unset($article_three_details['banner_three_bak_colour']);
					unset($article_three_details['banner_four_bak_colour']);
					unset($article_three_details['banner_five_bak_colour']);
					unset($article_three_details['banner_six_bak_colour']);


$article_three_details['banner_desktop'] = $desktop_banner;



$mobile_banner = array();

					$mobile_banner['dsv_banner_one_image'] = $article_three_details['mobile_banner_one'];
					$mobile_banner['dsv_banner_two_image'] = $article_three_details['mobile_banner_two'];
					$mobile_banner['dsv_banner_three_image'] = $article_three_details['mobile_banner_three'];
					$mobile_banner['dsv_banner_four_image'] = $article_three_details['mobile_banner_four'];
					$mobile_banner['dsv_banner_five_image'] = $article_three_details['mobile_banner_five'];
					$mobile_banner['dsv_banner_six_image'] = $article_three_details['mobile_banner_six'];
					
					$mobile_banner['dsv_banner_one_thumb'] = (strlen($article_three_details['mobile_banner_one']) >1 ? 'sized/listing/thumb_' . $article_three_details['mobile_banner_one'] : '');
					$mobile_banner['dsv_banner_two_thumb'] = (strlen($article_three_details['mobile_banner_two']) >1 ? 'sized/listing/thumb_' . $article_three_details['mobile_banner_two'] : '');
					$mobile_banner['dsv_banner_three_thumb'] = (strlen($article_three_details['mobile_banner_three']) >1 ? 'sized/listing/thumb_' . $article_three_details['mobile_banner_three'] : '');
					$mobile_banner['dsv_banner_four_thumb'] = (strlen($article_three_details['mobile_banner_four']) >1 ? 'sized/listing/thumb_' . $article_three_details['mobile_banner_four'] : '');
					$mobile_banner['dsv_banner_five_thumb'] = (strlen($article_three_details['mobile_banner_five']) >1 ? 'sized/listing/thumb_' . $article_three_details['mobile_banner_five'] : '');
					$mobile_banner['dsv_banner_six_thumb'] = (strlen($article_three_details['mobile_banner_six']) >1 ? 'sized/listing/thumb_' . $article_three_details['mobile_banner_six'] : '');
	
					$mobile_banner['dsv_banner_one_url'] = $article_three_details['mobile_banner_one_link'];
					$mobile_banner['dsv_banner_two_url'] = $article_three_details['mobile_banner_two_link'];
					$mobile_banner['dsv_banner_three_url'] = $article_three_details['mobile_banner_three_link'];
					$mobile_banner['dsv_banner_four_url'] = $article_three_details['mobile_banner_four_link'];
					$mobile_banner['dsv_banner_five_url'] = $article_three_details['mobile_banner_five_link'];
					$mobile_banner['dsv_banner_six_url'] = $article_three_details['mobile_banner_six_link'];
			
					$mobile_banner['dsv_banner_one_window'] = ((int)$seasonal_results['mobile_banner_one_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_two_window'] = ((int)$seasonal_results['mobile_banner_two_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_three_window'] = ((int)$seasonal_results['mobile_banner_three_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_four_window'] = ((int)$seasonal_results['mobile_banner_four_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_five_window'] = ((int)$seasonal_results['mobile_banner_five_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_six_window'] = ((int)$seasonal_results['mobile_banner_six_window'] == 1 ? 'true' : 'false');
	
					$mobile_banner['dsv_banner_one_bimage'] = $article_three_details['mobile_banner_one_bak_image'];
					$mobile_banner['dsv_banner_two_bimage'] = $article_three_details['mobile_banner_two_bak_image'];
					$mobile_banner['dsv_banner_three_bimage'] = $article_three_details['mobile_banner_three_bak_image'];
					$mobile_banner['dsv_banner_four_bimage'] = $article_three_details['mobile_banner_four_bak_image'];
					$mobile_banner['dsv_banner_five_bimage'] = $article_three_details['mobile_banner_five_bak_image'];
					$mobile_banner['dsv_banner_six_bimage'] = $article_three_details['mobile_banner_six_bak_image'];
					
					$mobile_banner['banner_one_bak_image'] = (strlen($article_three_details['mobile_banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['mobile_banner_one_bak_image'] : '');
					$mobile_banner['banner_two_bak_image'] = (strlen($article_three_details['mobile_banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['mobile_banner_two_bak_image'] : '');
					$mobile_banner['banner_three_bak_image'] = (strlen($article_three_details['mobile_banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['mobile_banner_three_bak_image'] : '');
					$mobile_banner['banner_four_bak_image'] = (strlen($article_three_details['mobile_banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['mobile_banner_four_bak_image'] : '');
					$mobile_banner['banner_five_bak_image'] = (strlen($article_three_details['mobile_banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['mobile_banner_five_bak_image'] : '');
					$mobile_banner['banner_six_bak_image'] = (strlen($article_three_details['mobile_banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['mobile_banner_six_bak_image'] : '');
			
					$mobile_banner['banner_one_bak_colour'] = $article_three_details['mobile_banner_one_bak_colour'];
					$mobile_banner['banner_two_bak_colour'] = $article_three_details['mobile_banner_two_bak_colour'];
					$mobile_banner['banner_three_bak_colour'] = $article_three_details['mobile_banner_three_bak_colour'];
					$mobile_banner['banner_four_bak_colour'] = $article_three_details['mobile_banner_four_bak_colour'];
					$mobile_banner['banner_five_bak_colour'] = $article_three_details['mobile_banner_five_bak_colour'];
					$mobile_banner['banner_six_bak_colour'] = $article_three_details['mobile_banner_six_bak_colour'];


// unset previous variables as to not confuse content developers.
					unset($article_three_details['mobile_banner_one']);
					unset($article_three_details['mobile_banner_two']);
					unset($article_three_details['mobile_banner_three']);
					unset($article_three_details['mobile_banner_four']);
					unset($article_three_details['mobile_banner_five']);
					unset($article_three_details['mobile_banner_six']);
					
					unset($article_three_details['mobile_banner_one_link']);
					unset($article_three_details['mobile_banner_two_link']);
					unset($article_three_details['mobile_banner_three_link']);
					unset($article_three_details['mobile_banner_four_link']);
					unset($article_three_details['mobile_banner_five_link']);
					unset($article_three_details['mobile_banner_six_link']);
			
					unset($article_three_details['mobile_banner_one_window']);
					unset($article_three_details['mobile_banner_two_window']);
					unset($article_three_details['mobile_banner_three_window']);
					unset($article_three_details['mobile_banner_four_window']);
					unset($article_three_details['mobile_banner_five_window']);
					unset($article_three_details['mobile_banner_six_window']);
	
					unset($article_three_details['mobile_banner_one_bak_image']);
					unset($article_three_details['mobile_banner_two_bak_image']);
					unset($article_three_details['mobile_banner_three_bak_image']);
					unset($article_three_details['mobile_banner_four_bak_image']);
					unset($article_three_details['mobile_banner_five_bak_image']);
					unset($article_three_details['mobile_banner_six_bak_image']);
					
					unset($article_three_details['mobile_banner_one_bak_image']);
					unset($article_three_details['mobile_banner_two_bak_image']);
					unset($article_three_details['mobile_banner_three_bak_image']);
					unset($article_three_details['mobile_banner_four_bak_image']);
					unset($article_three_details['mobile_banner_five_bak_image']);
					unset($article_three_details['mobile_banner_six_bak_image']);
			
					unset($article_three_details['mobile_banner_one_bak_colour']);
					unset($article_three_details['mobile_banner_two_bak_colour']);
					unset($article_three_details['mobile_banner_three_bak_colour']);
					unset($article_three_details['mobile_banner_four_bak_colour']);
					unset($article_three_details['mobile_banner_five_bak_colour']);
					unset($article_three_details['mobile_banner_six_bak_colour']);


$article_three_details['banner_mobile'] = $mobile_banner;



$tablet_banner = array();

					$tablet_banner['dsv_banner_one_image'] = $article_three_details['tablet_banner_one'];
					$tablet_banner['dsv_banner_two_image'] = $article_three_details['tablet_banner_two'];
					$tablet_banner['dsv_banner_three_image'] = $article_three_details['tablet_banner_three'];
					$tablet_banner['dsv_banner_four_image'] = $article_three_details['tablet_banner_four'];
					$tablet_banner['dsv_banner_five_image'] = $article_three_details['tablet_banner_five'];
					$tablet_banner['dsv_banner_six_image'] = $article_three_details['tablet_banner_six'];
					
					$tablet_banner['dsv_banner_one_thumb'] = (strlen($article_three_details['tablet_banner_one']) >1 ? 'sized/listing/thumb_' . $article_three_details['tablet_banner_one'] : '');
					$tablet_banner['dsv_banner_two_thumb'] = (strlen($article_three_details['tablet_banner_two']) >1 ? 'sized/listing/thumb_' . $article_three_details['tablet_banner_two'] : '');
					$tablet_banner['dsv_banner_three_thumb'] = (strlen($article_three_details['tablet_banner_three']) >1 ? 'sized/listing/thumb_' . $article_three_details['tablet_banner_three'] : '');
					$tablet_banner['dsv_banner_four_thumb'] = (strlen($article_three_details['tablet_banner_four']) >1 ? 'sized/listing/thumb_' . $article_three_details['tablet_banner_four'] : '');
					$tablet_banner['dsv_banner_five_thumb'] = (strlen($article_three_details['tablet_banner_five']) >1 ? 'sized/listing/thumb_' . $article_three_details['tablet_banner_five'] : '');
					$tablet_banner['dsv_banner_six_thumb'] = (strlen($article_three_details['tablet_banner_six']) >1 ? 'sized/listing/thumb_' . $article_three_details['tablet_banner_six'] : '');
	
					$tablet_banner['dsv_banner_one_url'] = $article_three_details['tablet_banner_one_link'];
					$tablet_banner['dsv_banner_two_url'] = $article_three_details['tablet_banner_two_link'];
					$tablet_banner['dsv_banner_three_url'] = $article_three_details['tablet_banner_three_link'];
					$tablet_banner['dsv_banner_four_url'] = $article_three_details['tablet_banner_four_link'];
					$tablet_banner['dsv_banner_five_url'] = $article_three_details['tablet_banner_five_link'];
					$tablet_banner['dsv_banner_six_url'] = $article_three_details['tablet_banner_six_link'];
			
					$tablet_banner['dsv_banner_one_window'] = ((int)$seasonal_results['tablet_banner_one_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_two_window'] = ((int)$seasonal_results['tablet_banner_two_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_three_window'] = ((int)$seasonal_results['tablet_banner_three_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_four_window'] = ((int)$seasonal_results['tablet_banner_four_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_five_window'] = ((int)$seasonal_results['tablet_banner_five_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_six_window'] = ((int)$seasonal_results['tablet_banner_six_window'] == 1 ? 'true' : 'false');
	
					$tablet_banner['dsv_banner_one_bimage'] = $article_three_details['tablet_banner_one_bak_image'];
					$tablet_banner['dsv_banner_two_bimage'] = $article_three_details['tablet_banner_two_bak_image'];
					$tablet_banner['dsv_banner_three_bimage'] = $article_three_details['tablet_banner_three_bak_image'];
					$tablet_banner['dsv_banner_four_bimage'] = $article_three_details['tablet_banner_four_bak_image'];
					$tablet_banner['dsv_banner_five_bimage'] = $article_three_details['tablet_banner_five_bak_image'];
					$tablet_banner['dsv_banner_six_bimage'] = $article_three_details['tablet_banner_six_bak_image'];
					
					$tablet_banner['banner_one_bak_image'] = (strlen($article_three_details['tablet_banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['tablet_banner_one_bak_image'] : '');
					$tablet_banner['banner_two_bak_image'] = (strlen($article_three_details['tablet_banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['tablet_banner_two_bak_image'] : '');
					$tablet_banner['banner_three_bak_image'] = (strlen($article_three_details['tablet_banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['tablet_banner_three_bak_image'] : '');
					$tablet_banner['banner_four_bak_image'] = (strlen($article_three_details['tablet_banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['tablet_banner_four_bak_image'] : '');
					$tablet_banner['banner_five_bak_image'] = (strlen($article_three_details['tablet_banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['tablet_banner_five_bak_image'] : '');
					$tablet_banner['banner_six_bak_image'] = (strlen($article_three_details['tablet_banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_three_details['tablet_banner_six_bak_image'] : '');
			
					$tablet_banner['banner_one_bak_colour'] = $article_three_details['tablet_banner_one_bak_colour'];
					$tablet_banner['banner_two_bak_colour'] = $article_three_details['tablet_banner_two_bak_colour'];
					$tablet_banner['banner_three_bak_colour'] = $article_three_details['tablet_banner_three_bak_colour'];
					$tablet_banner['banner_four_bak_colour'] = $article_three_details['tablet_banner_four_bak_colour'];
					$tablet_banner['banner_five_bak_colour'] = $article_three_details['tablet_banner_five_bak_colour'];
					$tablet_banner['banner_six_bak_colour'] = $article_three_details['tablet_banner_six_bak_colour'];


// unset previous variables as to not confuse content developers.
					unset($article_three_details['tablet_banner_one']);
					unset($article_three_details['tablet_banner_two']);
					unset($article_three_details['tablet_banner_three']);
					unset($article_three_details['tablet_banner_four']);
					unset($article_three_details['tablet_banner_five']);
					unset($article_three_details['tablet_banner_six']);
					
					unset($article_three_details['tablet_banner_one_link']);
					unset($article_three_details['tablet_banner_two_link']);
					unset($article_three_details['tablet_banner_three_link']);
					unset($article_three_details['tablet_banner_four_link']);
					unset($article_three_details['tablet_banner_five_link']);
					unset($article_three_details['tablet_banner_six_link']);
			
					unset($article_three_details['tablet_banner_one_window']);
					unset($article_three_details['tablet_banner_two_window']);
					unset($article_three_details['tablet_banner_three_window']);
					unset($article_three_details['tablet_banner_four_window']);
					unset($article_three_details['tablet_banner_five_window']);
					unset($article_three_details['tablet_banner_six_window']);
	
					unset($article_three_details['tablet_banner_one_bak_image']);
					unset($article_three_details['tablet_banner_two_bak_image']);
					unset($article_three_details['tablet_banner_three_bak_image']);
					unset($article_three_details['tablet_banner_four_bak_image']);
					unset($article_three_details['tablet_banner_five_bak_image']);
					unset($article_three_details['tablet_banner_six_bak_image']);
					
					unset($article_three_details['tablet_banner_one_bak_image']);
					unset($article_three_details['tablet_banner_two_bak_image']);
					unset($article_three_details['tablet_banner_three_bak_image']);
					unset($article_three_details['tablet_banner_four_bak_image']);
					unset($article_three_details['tablet_banner_five_bak_image']);
					unset($article_three_details['tablet_banner_six_bak_image']);
			
					unset($article_three_details['tablet_banner_one_bak_colour']);
					unset($article_three_details['tablet_banner_two_bak_colour']);
					unset($article_three_details['tablet_banner_three_bak_colour']);
					unset($article_three_details['tablet_banner_four_bak_colour']);
					unset($article_three_details['tablet_banner_five_bak_colour']);
					unset($article_three_details['tablet_banner_six_bak_colour']);

$article_three_details['banner_tablet'] = $tablet_banner;


unset($desktop_banner);
unset($mobile_banner);
unset($tablet_banner);



// overrides not currently in use
unset($article_three_details['banner_one_image_override']);
unset($article_three_details['banner_two_image_override']);
unset($article_three_details['banner_three_image_override']);
unset($article_three_details['banner_four_image_override']);
unset($article_three_details['banner_five_image_override']);
unset($article_three_details['banner_six_image_override']);

unset($article_three_details['mobile_banner_one_image_override']);
unset($article_three_details['mobile_banner_two_image_override']);
unset($article_three_details['mobile_banner_three_image_override']);
unset($article_three_details['mobile_banner_four_image_override']);
unset($article_three_details['mobile_banner_five_image_override']);
unset($article_three_details['mobile_banner_six_image_override']);

unset($article_three_details['tablet_banner_one_image_override']);
unset($article_three_details['tablet_banner_two_image_override']);
unset($article_three_details['tablet_banner_three_image_override']);
unset($article_three_details['tablet_banner_four_image_override']);
unset($article_three_details['tablet_banner_five_image_override']);
unset($article_three_details['tablet_banner_six_image_override']);



// sort out the products array if any products have been set.
		$article_products = array();
		
		if (isset($article_three_details['sub_prod_one']) && (int)$article_three_details['sub_prod_one'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_three_details['sub_prod_one']);
		}
		
		if (isset($article_three_details['sub_prod_two']) && (int)$article_three_details['sub_prod_two'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_three_details['sub_prod_two']);
		}
		
		if (isset($article_three_details['sub_prod_three']) && (int)$article_three_details['sub_prod_three'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_three_details['sub_prod_three']);
		}
		
		if (isset($article_three_details['sub_prod_four']) && (int)$article_three_details['sub_prod_four'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_three_details['sub_prod_four']);
		}
		
		if (isset($article_three_details['sub_prod_five']) && (int)$article_three_details['sub_prod_five'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_three_details['sub_prod_five']);
		}
		
		if (isset($article_three_details['sub_prod_six']) && (int)$article_three_details['sub_prod_six'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_three_details['sub_prod_six']);
		}
		
		if (isset($article_three_details['sub_prod_seven']) && (int)$article_three_details['sub_prod_seven'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_three_details['sub_prod_seven']);
		}
		
		if (isset($article_three_details['sub_prod_eight']) && (int)$article_three_details['sub_prod_eight'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_three_details['sub_prod_eight']);
		}


	$article_three_details['article_products'] = $article_products;

	unset($article_products);

// unset the original values.

		unset($article_three_details['sub_prod_one']);
		unset($article_three_details['sub_prod_two']);
		unset($article_three_details['sub_prod_three']);
		unset($article_three_details['sub_prod_four']);
		unset($article_three_details['sub_prod_five']);
		unset($article_three_details['sub_prod_six']);
		unset($article_three_details['sub_prod_seven']);
		unset($article_three_details['sub_prod_eight']);




// check for any specific sub allocated articles.
		
// get the sub_art items as we use them a couple of times below and it should not be necessary to have to query the database multiple times.

						
							// get the 4 article items that can be allocated to a folder item.
							$sub_articles = array();
							
									if (isset($article_three_details['sub_art_one']) && (int)$article_three_details['sub_art_one'] > 0){
										$sub_articles[] = dsf_get_article_three_sub($article_three_details['sub_art_one']);
									}
							
									if (isset($article_three_details['sub_art_two']) && (int)$article_three_details['sub_art_two'] > 0){
										$sub_articles[] = dsf_get_article_three_sub($article_three_details['sub_art_two']);
									}
							
									if (isset($article_three_details['sub_art_three']) && (int)$article_three_details['sub_art_three'] > 0){
										$sub_articles[] = dsf_get_article_three_sub($article_three_details['sub_art_three']);
									}
							
									if (isset($article_three_details['sub_art_four']) && (int)$article_three_details['sub_art_four'] > 0){
										$sub_articles[] = dsf_get_article_three_sub($article_three_details['sub_art_four']);
									}
							
							
									$article_three_details['sub_articles'] = $sub_articles;
							
								unset($sub_articles);
							
						
						



			
		// resort the array
				ksort($article_three_details);	


  } //end if records found.

return $article_three_details;

} // END FUNCTION









// ######

function dsf_get_article_two_item_array($article_id=0){


	$article_two_details = '';
	
	$dsv_sql_fields_required = array('article_id', 'unit_id', 'item_translated', 'item_approved', 'article_image', 'article_name', 'article_slug', 'article_title', 'title_image', 'sub_title_image', 'menu_image', 'banner_one', 'banner_two', 'banner_three', 'banner_four', 'parent_id', 'sort_order', 'article_text', 'article_keywords', 'article_meta', 'subpage_text', 'sub_prod_one', 'sub_prod_two', 'sub_prod_three', 'sub_prod_four', 'sub_prod_five', 'sub_prod_six', 'sub_prod_seven', 'sub_prod_eight', 'article_type', 'article_category', 'sub_art_one', 'sub_art_two', 'sub_art_three', 'sub_art_four', 'article_date', 'article_image_disclaimer', 'article_override_url', 'text_block_two', 'text_block_three', 'article_video', 'video_width', 'video_height', 'article_video_text', 'article_youtube_link', 'image_collection', 'image_collection_text', 'pdf_one', 'pdf_one_text', 'pdf_two', 'pdf_two_text', 'article_video_title', 'article_hide_menu', 'article_status', 'banner_one_link', 'banner_two_link', 'banner_three_link', 'banner_four_link', 'banner_one_bak_colour', 'banner_one_bak_image', 'banner_two_bak_colour', 'banner_two_bak_image', 'banner_three_bak_colour', 'banner_three_bak_image', 'banner_four_bak_colour', 'banner_four_bak_image', 'article_url_window', 'banner_one_window', 'banner_two_window', 'banner_three_window', 'banner_four_window', 'ex_script_text', 'secondary_banner', 'banner_five', 'banner_five_link', 'banner_five_bak_colour', 'banner_five_bak_image', 'banner_five_window', 'banner_six', 'banner_six_link', 'banner_six_bak_colour', 'banner_six_bak_image', 'banner_six_window', 'banner_one_image_override', 'banner_two_image_override', 'banner_three_image_override', 'banner_four_image_override', 'banner_five_image_override', 'banner_six_image_override', 'mobile_banner_one', 'mobile_banner_one_link', 'mobile_banner_one_bak_colour', 'mobile_banner_one_bak_image', 'mobile_banner_one_window', 'mobile_banner_one_image_override', 'mobile_banner_two', 'mobile_banner_two_link', 'mobile_banner_two_bak_colour', 'mobile_banner_two_bak_image', 'mobile_banner_two_window', 'mobile_banner_two_image_override', 'mobile_banner_three', 'mobile_banner_three_link', 'mobile_banner_three_bak_colour', 'mobile_banner_three_bak_image', 'mobile_banner_three_window', 'mobile_banner_three_image_override', 'mobile_banner_four', 'mobile_banner_four_link', 'mobile_banner_four_bak_colour', 'mobile_banner_four_bak_image', 'mobile_banner_four_window', 'mobile_banner_four_image_override', 'mobile_banner_five', 'mobile_banner_five_link', 'mobile_banner_five_bak_colour', 'mobile_banner_five_bak_image', 'mobile_banner_five_window', 'mobile_banner_five_image_override', 'mobile_banner_six', 'mobile_banner_six_link', 'mobile_banner_six_bak_colour', 'mobile_banner_six_bak_image', 'mobile_banner_six_window', 'mobile_banner_six_image_override', 'tablet_banner_one', 'tablet_banner_one_link', 'tablet_banner_one_bak_colour', 'tablet_banner_one_bak_image', 'tablet_banner_one_window', 'tablet_banner_one_image_override', 'tablet_banner_two', 'tablet_banner_two_link', 'tablet_banner_two_bak_colour', 'tablet_banner_two_bak_image', 'tablet_banner_two_window', 'tablet_banner_two_image_override', 'tablet_banner_three', 'tablet_banner_three_link', 'tablet_banner_three_bak_colour', 'tablet_banner_three_bak_image', 'tablet_banner_three_window', 'tablet_banner_three_image_override', 'tablet_banner_four', 'tablet_banner_four_link', 'tablet_banner_four_bak_colour', 'tablet_banner_four_bak_image', 'tablet_banner_four_window', 'tablet_banner_four_image_override', 'tablet_banner_five', 'tablet_banner_five_link', 'tablet_banner_five_bak_colour', 'tablet_banner_five_bak_image', 'tablet_banner_five_window', 'tablet_banner_five_image_override', 'tablet_banner_six', 'tablet_banner_six_link', 'tablet_banner_six_bak_colour', 'tablet_banner_six_bak_image', 'tablet_banner_six_window', 'tablet_banner_six_image_override');
	
	$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sa','la');
	
    // get details of the gallery items
    
    $seasonal_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".article_two sa left join " . DS_DB_LANGUAGE . ".article_two la on (sa.article_id = la.article_id) where sa.article_id='" . (int)$article_id . "'");
  

  if (dsf_db_num_rows($seasonal_query) > 0){
	    $seasonal_results = dsf_db_fetch_array($seasonal_query);
	
		//	echo dsf_print_array($gallery_results);
			
			$article_two_details = dsf_sql_override_values($dsv_sql_fields_required, $seasonal_results);
			// at this point we make amendments or additions to the array.

		
			$article_two_details['url'] = dsf_article_two_url($article_id);
			$article_two_details['attributes'] = 'article_id=' . $article_id ;
			
			
			// check for the type of article (exclude a 0 from shop values)
			
			if ($seasonal_results['ov_article_type'] > 0){
				// fine it is already set.
			}else{
				// its not been overridden therefore language takes over.
				$article_two_details['article_type'] = $seasonal_results['article_type'];
			}
			
			
			
			//unset a couple of fields
			unset($article_two_details['item_translated']);
			
		
		// fix article type
		
			$article_two_details['article_type'] = $seasonal_results['article_type'];
		


// images

// menu images

	if (strlen($article_two_details['menu_image']) > 1){
		$article_two_details['menu_image'] = 'sized/home/' . $article_two_details['menu_image'];
	}

	if (strlen($article_two_details['mobile_menu_image']) > 1){
		$article_two_details['mobile_menu_image'] = 'sized/home/' . $article_two_details['mobile_menu_image'];
	}


	if (strlen($article_two_details['tablet_menu_image']) > 1){
		$article_two_details['tablet_menu_image'] = 'sized/home/' . $article_two_details['tablet_menu_image'];
	}

// banner images


$desktop_banner = array();

					$desktop_banner['dsv_banner_one_image'] = $article_two_details['banner_one'];
					$desktop_banner['dsv_banner_two_image'] = $article_two_details['banner_two'];
					$desktop_banner['dsv_banner_three_image'] = $article_two_details['banner_three'];
					$desktop_banner['dsv_banner_four_image'] = $article_two_details['banner_four'];
					$desktop_banner['dsv_banner_five_image'] = $article_two_details['banner_five'];
					$desktop_banner['dsv_banner_six_image'] = $article_two_details['banner_six'];
					
					$desktop_banner['dsv_banner_one_thumb'] = (strlen($article_two_details['banner_one']) >1 ? 'sized/listing/thumb_' . $article_two_details['banner_one'] : '');
					$desktop_banner['dsv_banner_two_thumb'] = (strlen($article_two_details['banner_two']) >1 ? 'sized/listing/thumb_' . $article_two_details['banner_two'] : '');
					$desktop_banner['dsv_banner_three_thumb'] = (strlen($article_two_details['banner_three']) >1 ? 'sized/listing/thumb_' . $article_two_details['banner_three'] : '');
					$desktop_banner['dsv_banner_four_thumb'] = (strlen($article_two_details['banner_four']) >1 ? 'sized/listing/thumb_' . $article_two_details['banner_four'] : '');
					$desktop_banner['dsv_banner_five_thumb'] = (strlen($article_two_details['banner_five']) >1 ? 'sized/listing/thumb_' . $article_two_details['banner_five'] : '');
					$desktop_banner['dsv_banner_six_thumb'] = (strlen($article_two_details['banner_six']) >1 ? 'sized/listing/thumb_' . $article_two_details['banner_six'] : '');
	
					$desktop_banner['dsv_banner_one_url'] = $article_two_details['banner_one_link'];
					$desktop_banner['dsv_banner_two_url'] = $article_two_details['banner_two_link'];
					$desktop_banner['dsv_banner_three_url'] = $article_two_details['banner_three_link'];
					$desktop_banner['dsv_banner_four_url'] = $article_two_details['banner_four_link'];
					$desktop_banner['dsv_banner_five_url'] = $article_two_details['banner_five_link'];
					$desktop_banner['dsv_banner_six_url'] = $article_two_details['banner_six_link'];
			
					$desktop_banner['dsv_banner_one_window'] = ((int)$seasonal_results['banner_one_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_two_window'] = ((int)$seasonal_results['banner_two_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_three_window'] = ((int)$seasonal_results['banner_three_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_four_window'] = ((int)$seasonal_results['banner_four_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_five_window'] = ((int)$seasonal_results['banner_five_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_six_window'] = ((int)$seasonal_results['banner_six_window'] == 1 ? 'true' : 'false');
	
					$desktop_banner['dsv_banner_one_bimage'] = $article_two_details['banner_one_bak_image'];
					$desktop_banner['dsv_banner_two_bimage'] = $article_two_details['banner_two_bak_image'];
					$desktop_banner['dsv_banner_three_bimage'] = $article_two_details['banner_three_bak_image'];
					$desktop_banner['dsv_banner_four_bimage'] = $article_two_details['banner_four_bak_image'];
					$desktop_banner['dsv_banner_five_bimage'] = $article_two_details['banner_five_bak_image'];
					$desktop_banner['dsv_banner_six_bimage'] = $article_two_details['banner_six_bak_image'];
					
					$desktop_banner['banner_one_bak_image'] = (strlen($article_two_details['banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['banner_one_bak_image'] : '');
					$desktop_banner['banner_two_bak_image'] = (strlen($article_two_details['banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['banner_two_bak_image'] : '');
					$desktop_banner['banner_three_bak_image'] = (strlen($article_two_details['banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['banner_three_bak_image'] : '');
					$desktop_banner['banner_four_bak_image'] = (strlen($article_two_details['banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['banner_four_bak_image'] : '');
					$desktop_banner['banner_five_bak_image'] = (strlen($article_two_details['banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['banner_five_bak_image'] : '');
					$desktop_banner['banner_six_bak_image'] = (strlen($article_two_details['banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['banner_six_bak_image'] : '');
			
					$desktop_banner['banner_one_bak_colour'] = $article_two_details['banner_one_bak_colour'];
					$desktop_banner['banner_two_bak_colour'] = $article_two_details['banner_two_bak_colour'];
					$desktop_banner['banner_three_bak_colour'] = $article_two_details['banner_three_bak_colour'];
					$desktop_banner['banner_four_bak_colour'] = $article_two_details['banner_four_bak_colour'];
					$desktop_banner['banner_five_bak_colour'] = $article_two_details['banner_five_bak_colour'];
					$desktop_banner['banner_six_bak_colour'] = $article_two_details['banner_six_bak_colour'];


// unset previous variables as to not confuse content developers.
					unset($article_two_details['banner_one']);
					unset($article_two_details['banner_two']);
					unset($article_two_details['banner_three']);
					unset($article_two_details['banner_four']);
					unset($article_two_details['banner_five']);
					unset($article_two_details['banner_six']);
					
					unset($article_two_details['banner_one_link']);
					unset($article_two_details['banner_two_link']);
					unset($article_two_details['banner_three_link']);
					unset($article_two_details['banner_four_link']);
					unset($article_two_details['banner_five_link']);
					unset($article_two_details['banner_six_link']);
			
					unset($article_two_details['banner_one_window']);
					unset($article_two_details['banner_two_window']);
					unset($article_two_details['banner_three_window']);
					unset($article_two_details['banner_four_window']);
					unset($article_two_details['banner_five_window']);
					unset($article_two_details['banner_six_window']);
	
					unset($article_two_details['banner_one_bak_image']);
					unset($article_two_details['banner_two_bak_image']);
					unset($article_two_details['banner_three_bak_image']);
					unset($article_two_details['banner_four_bak_image']);
					unset($article_two_details['banner_five_bak_image']);
					unset($article_two_details['banner_six_bak_image']);
					
					unset($article_two_details['banner_one_bak_image']);
					unset($article_two_details['banner_two_bak_image']);
					unset($article_two_details['banner_three_bak_image']);
					unset($article_two_details['banner_four_bak_image']);
					unset($article_two_details['banner_five_bak_image']);
					unset($article_two_details['banner_six_bak_image']);
			
					unset($article_two_details['banner_one_bak_colour']);
					unset($article_two_details['banner_two_bak_colour']);
					unset($article_two_details['banner_three_bak_colour']);
					unset($article_two_details['banner_four_bak_colour']);
					unset($article_two_details['banner_five_bak_colour']);
					unset($article_two_details['banner_six_bak_colour']);


$article_two_details['banner_desktop'] = $desktop_banner;



$mobile_banner = array();

					$mobile_banner['dsv_banner_one_image'] = $article_two_details['mobile_banner_one'];
					$mobile_banner['dsv_banner_two_image'] = $article_two_details['mobile_banner_two'];
					$mobile_banner['dsv_banner_three_image'] = $article_two_details['mobile_banner_three'];
					$mobile_banner['dsv_banner_four_image'] = $article_two_details['mobile_banner_four'];
					$mobile_banner['dsv_banner_five_image'] = $article_two_details['mobile_banner_five'];
					$mobile_banner['dsv_banner_six_image'] = $article_two_details['mobile_banner_six'];
					
					$mobile_banner['dsv_banner_one_thumb'] = (strlen($article_two_details['mobile_banner_one']) >1 ? 'sized/listing/thumb_' . $article_two_details['mobile_banner_one'] : '');
					$mobile_banner['dsv_banner_two_thumb'] = (strlen($article_two_details['mobile_banner_two']) >1 ? 'sized/listing/thumb_' . $article_two_details['mobile_banner_two'] : '');
					$mobile_banner['dsv_banner_three_thumb'] = (strlen($article_two_details['mobile_banner_three']) >1 ? 'sized/listing/thumb_' . $article_two_details['mobile_banner_three'] : '');
					$mobile_banner['dsv_banner_four_thumb'] = (strlen($article_two_details['mobile_banner_four']) >1 ? 'sized/listing/thumb_' . $article_two_details['mobile_banner_four'] : '');
					$mobile_banner['dsv_banner_five_thumb'] = (strlen($article_two_details['mobile_banner_five']) >1 ? 'sized/listing/thumb_' . $article_two_details['mobile_banner_five'] : '');
					$mobile_banner['dsv_banner_six_thumb'] = (strlen($article_two_details['mobile_banner_six']) >1 ? 'sized/listing/thumb_' . $article_two_details['mobile_banner_six'] : '');
	
					$mobile_banner['dsv_banner_one_url'] = $article_two_details['mobile_banner_one_link'];
					$mobile_banner['dsv_banner_two_url'] = $article_two_details['mobile_banner_two_link'];
					$mobile_banner['dsv_banner_three_url'] = $article_two_details['mobile_banner_three_link'];
					$mobile_banner['dsv_banner_four_url'] = $article_two_details['mobile_banner_four_link'];
					$mobile_banner['dsv_banner_five_url'] = $article_two_details['mobile_banner_five_link'];
					$mobile_banner['dsv_banner_six_url'] = $article_two_details['mobile_banner_six_link'];
			
					$mobile_banner['dsv_banner_one_window'] = ((int)$seasonal_results['mobile_banner_one_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_two_window'] = ((int)$seasonal_results['mobile_banner_two_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_three_window'] = ((int)$seasonal_results['mobile_banner_three_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_four_window'] = ((int)$seasonal_results['mobile_banner_four_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_five_window'] = ((int)$seasonal_results['mobile_banner_five_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_six_window'] = ((int)$seasonal_results['mobile_banner_six_window'] == 1 ? 'true' : 'false');
	
					$mobile_banner['dsv_banner_one_bimage'] = $article_two_details['mobile_banner_one_bak_image'];
					$mobile_banner['dsv_banner_two_bimage'] = $article_two_details['mobile_banner_two_bak_image'];
					$mobile_banner['dsv_banner_three_bimage'] = $article_two_details['mobile_banner_three_bak_image'];
					$mobile_banner['dsv_banner_four_bimage'] = $article_two_details['mobile_banner_four_bak_image'];
					$mobile_banner['dsv_banner_five_bimage'] = $article_two_details['mobile_banner_five_bak_image'];
					$mobile_banner['dsv_banner_six_bimage'] = $article_two_details['mobile_banner_six_bak_image'];
					
					$mobile_banner['banner_one_bak_image'] = (strlen($article_two_details['mobile_banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['mobile_banner_one_bak_image'] : '');
					$mobile_banner['banner_two_bak_image'] = (strlen($article_two_details['mobile_banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['mobile_banner_two_bak_image'] : '');
					$mobile_banner['banner_three_bak_image'] = (strlen($article_two_details['mobile_banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['mobile_banner_three_bak_image'] : '');
					$mobile_banner['banner_four_bak_image'] = (strlen($article_two_details['mobile_banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['mobile_banner_four_bak_image'] : '');
					$mobile_banner['banner_five_bak_image'] = (strlen($article_two_details['mobile_banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['mobile_banner_five_bak_image'] : '');
					$mobile_banner['banner_six_bak_image'] = (strlen($article_two_details['mobile_banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['mobile_banner_six_bak_image'] : '');
			
					$mobile_banner['banner_one_bak_colour'] = $article_two_details['mobile_banner_one_bak_colour'];
					$mobile_banner['banner_two_bak_colour'] = $article_two_details['mobile_banner_two_bak_colour'];
					$mobile_banner['banner_three_bak_colour'] = $article_two_details['mobile_banner_three_bak_colour'];
					$mobile_banner['banner_four_bak_colour'] = $article_two_details['mobile_banner_four_bak_colour'];
					$mobile_banner['banner_five_bak_colour'] = $article_two_details['mobile_banner_five_bak_colour'];
					$mobile_banner['banner_six_bak_colour'] = $article_two_details['mobile_banner_six_bak_colour'];


// unset previous variables as to not confuse content developers.
					unset($article_two_details['mobile_banner_one']);
					unset($article_two_details['mobile_banner_two']);
					unset($article_two_details['mobile_banner_three']);
					unset($article_two_details['mobile_banner_four']);
					unset($article_two_details['mobile_banner_five']);
					unset($article_two_details['mobile_banner_six']);
					
					unset($article_two_details['mobile_banner_one_link']);
					unset($article_two_details['mobile_banner_two_link']);
					unset($article_two_details['mobile_banner_three_link']);
					unset($article_two_details['mobile_banner_four_link']);
					unset($article_two_details['mobile_banner_five_link']);
					unset($article_two_details['mobile_banner_six_link']);
			
					unset($article_two_details['mobile_banner_one_window']);
					unset($article_two_details['mobile_banner_two_window']);
					unset($article_two_details['mobile_banner_three_window']);
					unset($article_two_details['mobile_banner_four_window']);
					unset($article_two_details['mobile_banner_five_window']);
					unset($article_two_details['mobile_banner_six_window']);
	
					unset($article_two_details['mobile_banner_one_bak_image']);
					unset($article_two_details['mobile_banner_two_bak_image']);
					unset($article_two_details['mobile_banner_three_bak_image']);
					unset($article_two_details['mobile_banner_four_bak_image']);
					unset($article_two_details['mobile_banner_five_bak_image']);
					unset($article_two_details['mobile_banner_six_bak_image']);
					
					unset($article_two_details['mobile_banner_one_bak_image']);
					unset($article_two_details['mobile_banner_two_bak_image']);
					unset($article_two_details['mobile_banner_three_bak_image']);
					unset($article_two_details['mobile_banner_four_bak_image']);
					unset($article_two_details['mobile_banner_five_bak_image']);
					unset($article_two_details['mobile_banner_six_bak_image']);
			
					unset($article_two_details['mobile_banner_one_bak_colour']);
					unset($article_two_details['mobile_banner_two_bak_colour']);
					unset($article_two_details['mobile_banner_three_bak_colour']);
					unset($article_two_details['mobile_banner_four_bak_colour']);
					unset($article_two_details['mobile_banner_five_bak_colour']);
					unset($article_two_details['mobile_banner_six_bak_colour']);


$article_two_details['banner_mobile'] = $mobile_banner;



$tablet_banner = array();

					$tablet_banner['dsv_banner_one_image'] = $article_two_details['tablet_banner_one'];
					$tablet_banner['dsv_banner_two_image'] = $article_two_details['tablet_banner_two'];
					$tablet_banner['dsv_banner_three_image'] = $article_two_details['tablet_banner_three'];
					$tablet_banner['dsv_banner_four_image'] = $article_two_details['tablet_banner_four'];
					$tablet_banner['dsv_banner_five_image'] = $article_two_details['tablet_banner_five'];
					$tablet_banner['dsv_banner_six_image'] = $article_two_details['tablet_banner_six'];
					
					$tablet_banner['dsv_banner_one_thumb'] = (strlen($article_two_details['tablet_banner_one']) >1 ? 'sized/listing/thumb_' . $article_two_details['tablet_banner_one'] : '');
					$tablet_banner['dsv_banner_two_thumb'] = (strlen($article_two_details['tablet_banner_two']) >1 ? 'sized/listing/thumb_' . $article_two_details['tablet_banner_two'] : '');
					$tablet_banner['dsv_banner_three_thumb'] = (strlen($article_two_details['tablet_banner_three']) >1 ? 'sized/listing/thumb_' . $article_two_details['tablet_banner_three'] : '');
					$tablet_banner['dsv_banner_four_thumb'] = (strlen($article_two_details['tablet_banner_four']) >1 ? 'sized/listing/thumb_' . $article_two_details['tablet_banner_four'] : '');
					$tablet_banner['dsv_banner_five_thumb'] = (strlen($article_two_details['tablet_banner_five']) >1 ? 'sized/listing/thumb_' . $article_two_details['tablet_banner_five'] : '');
					$tablet_banner['dsv_banner_six_thumb'] = (strlen($article_two_details['tablet_banner_six']) >1 ? 'sized/listing/thumb_' . $article_two_details['tablet_banner_six'] : '');
	
					$tablet_banner['dsv_banner_one_url'] = $article_two_details['tablet_banner_one_link'];
					$tablet_banner['dsv_banner_two_url'] = $article_two_details['tablet_banner_two_link'];
					$tablet_banner['dsv_banner_three_url'] = $article_two_details['tablet_banner_three_link'];
					$tablet_banner['dsv_banner_four_url'] = $article_two_details['tablet_banner_four_link'];
					$tablet_banner['dsv_banner_five_url'] = $article_two_details['tablet_banner_five_link'];
					$tablet_banner['dsv_banner_six_url'] = $article_two_details['tablet_banner_six_link'];
			
					$tablet_banner['dsv_banner_one_window'] = ((int)$seasonal_results['tablet_banner_one_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_two_window'] = ((int)$seasonal_results['tablet_banner_two_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_three_window'] = ((int)$seasonal_results['tablet_banner_three_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_four_window'] = ((int)$seasonal_results['tablet_banner_four_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_five_window'] = ((int)$seasonal_results['tablet_banner_five_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_six_window'] = ((int)$seasonal_results['tablet_banner_six_window'] == 1 ? 'true' : 'false');
	
					$tablet_banner['dsv_banner_one_bimage'] = $article_two_details['tablet_banner_one_bak_image'];
					$tablet_banner['dsv_banner_two_bimage'] = $article_two_details['tablet_banner_two_bak_image'];
					$tablet_banner['dsv_banner_three_bimage'] = $article_two_details['tablet_banner_three_bak_image'];
					$tablet_banner['dsv_banner_four_bimage'] = $article_two_details['tablet_banner_four_bak_image'];
					$tablet_banner['dsv_banner_five_bimage'] = $article_two_details['tablet_banner_five_bak_image'];
					$tablet_banner['dsv_banner_six_bimage'] = $article_two_details['tablet_banner_six_bak_image'];
					
					$tablet_banner['banner_one_bak_image'] = (strlen($article_two_details['tablet_banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['tablet_banner_one_bak_image'] : '');
					$tablet_banner['banner_two_bak_image'] = (strlen($article_two_details['tablet_banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['tablet_banner_two_bak_image'] : '');
					$tablet_banner['banner_three_bak_image'] = (strlen($article_two_details['tablet_banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['tablet_banner_three_bak_image'] : '');
					$tablet_banner['banner_four_bak_image'] = (strlen($article_two_details['tablet_banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['tablet_banner_four_bak_image'] : '');
					$tablet_banner['banner_five_bak_image'] = (strlen($article_two_details['tablet_banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['tablet_banner_five_bak_image'] : '');
					$tablet_banner['banner_six_bak_image'] = (strlen($article_two_details['tablet_banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_two_details['tablet_banner_six_bak_image'] : '');
			
					$tablet_banner['banner_one_bak_colour'] = $article_two_details['tablet_banner_one_bak_colour'];
					$tablet_banner['banner_two_bak_colour'] = $article_two_details['tablet_banner_two_bak_colour'];
					$tablet_banner['banner_three_bak_colour'] = $article_two_details['tablet_banner_three_bak_colour'];
					$tablet_banner['banner_four_bak_colour'] = $article_two_details['tablet_banner_four_bak_colour'];
					$tablet_banner['banner_five_bak_colour'] = $article_two_details['tablet_banner_five_bak_colour'];
					$tablet_banner['banner_six_bak_colour'] = $article_two_details['tablet_banner_six_bak_colour'];


// unset previous variables as to not confuse content developers.
					unset($article_two_details['tablet_banner_one']);
					unset($article_two_details['tablet_banner_two']);
					unset($article_two_details['tablet_banner_three']);
					unset($article_two_details['tablet_banner_four']);
					unset($article_two_details['tablet_banner_five']);
					unset($article_two_details['tablet_banner_six']);
					
					unset($article_two_details['tablet_banner_one_link']);
					unset($article_two_details['tablet_banner_two_link']);
					unset($article_two_details['tablet_banner_three_link']);
					unset($article_two_details['tablet_banner_four_link']);
					unset($article_two_details['tablet_banner_five_link']);
					unset($article_two_details['tablet_banner_six_link']);
			
					unset($article_two_details['tablet_banner_one_window']);
					unset($article_two_details['tablet_banner_two_window']);
					unset($article_two_details['tablet_banner_three_window']);
					unset($article_two_details['tablet_banner_four_window']);
					unset($article_two_details['tablet_banner_five_window']);
					unset($article_two_details['tablet_banner_six_window']);
	
					unset($article_two_details['tablet_banner_one_bak_image']);
					unset($article_two_details['tablet_banner_two_bak_image']);
					unset($article_two_details['tablet_banner_three_bak_image']);
					unset($article_two_details['tablet_banner_four_bak_image']);
					unset($article_two_details['tablet_banner_five_bak_image']);
					unset($article_two_details['tablet_banner_six_bak_image']);
					
					unset($article_two_details['tablet_banner_one_bak_image']);
					unset($article_two_details['tablet_banner_two_bak_image']);
					unset($article_two_details['tablet_banner_three_bak_image']);
					unset($article_two_details['tablet_banner_four_bak_image']);
					unset($article_two_details['tablet_banner_five_bak_image']);
					unset($article_two_details['tablet_banner_six_bak_image']);
			
					unset($article_two_details['tablet_banner_one_bak_colour']);
					unset($article_two_details['tablet_banner_two_bak_colour']);
					unset($article_two_details['tablet_banner_three_bak_colour']);
					unset($article_two_details['tablet_banner_four_bak_colour']);
					unset($article_two_details['tablet_banner_five_bak_colour']);
					unset($article_two_details['tablet_banner_six_bak_colour']);

$article_two_details['banner_tablet'] = $tablet_banner;


unset($desktop_banner);
unset($mobile_banner);
unset($tablet_banner);



// overrides not currently in use
unset($article_two_details['banner_one_image_override']);
unset($article_two_details['banner_two_image_override']);
unset($article_two_details['banner_three_image_override']);
unset($article_two_details['banner_four_image_override']);
unset($article_two_details['banner_five_image_override']);
unset($article_two_details['banner_six_image_override']);

unset($article_two_details['mobile_banner_one_image_override']);
unset($article_two_details['mobile_banner_two_image_override']);
unset($article_two_details['mobile_banner_three_image_override']);
unset($article_two_details['mobile_banner_four_image_override']);
unset($article_two_details['mobile_banner_five_image_override']);
unset($article_two_details['mobile_banner_six_image_override']);

unset($article_two_details['tablet_banner_one_image_override']);
unset($article_two_details['tablet_banner_two_image_override']);
unset($article_two_details['tablet_banner_three_image_override']);
unset($article_two_details['tablet_banner_four_image_override']);
unset($article_two_details['tablet_banner_five_image_override']);
unset($article_two_details['tablet_banner_six_image_override']);



// sort out the products array if any products have been set.
		$article_products = array();
		
		if (isset($article_two_details['sub_prod_one']) && (int)$article_two_details['sub_prod_one'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_two_details['sub_prod_one']);
		}
		
		if (isset($article_two_details['sub_prod_two']) && (int)$article_two_details['sub_prod_two'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_two_details['sub_prod_two']);
		}
		
		if (isset($article_two_details['sub_prod_three']) && (int)$article_two_details['sub_prod_three'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_two_details['sub_prod_three']);
		}
		
		if (isset($article_two_details['sub_prod_four']) && (int)$article_two_details['sub_prod_four'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_two_details['sub_prod_four']);
		}
		
		if (isset($article_two_details['sub_prod_five']) && (int)$article_two_details['sub_prod_five'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_two_details['sub_prod_five']);
		}
		
		if (isset($article_two_details['sub_prod_six']) && (int)$article_two_details['sub_prod_six'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_two_details['sub_prod_six']);
		}
		
		if (isset($article_two_details['sub_prod_seven']) && (int)$article_two_details['sub_prod_seven'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_two_details['sub_prod_seven']);
		}
		
		if (isset($article_two_details['sub_prod_eight']) && (int)$article_two_details['sub_prod_eight'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_two_details['sub_prod_eight']);
		}


	$article_two_details['article_products'] = $article_products;

	unset($article_products);

// unset the original values.

		unset($article_two_details['sub_prod_one']);
		unset($article_two_details['sub_prod_two']);
		unset($article_two_details['sub_prod_three']);
		unset($article_two_details['sub_prod_four']);
		unset($article_two_details['sub_prod_five']);
		unset($article_two_details['sub_prod_six']);
		unset($article_two_details['sub_prod_seven']);
		unset($article_two_details['sub_prod_eight']);




// check for any specific sub allocated articles.
		
// get the sub_art items as we use them a couple of times below and it should not be necessary to have to query the database multiple times.

						
							// get the 4 article items that can be allocated to a folder item.
							$sub_articles = array();
							
									if (isset($article_two_details['sub_art_one']) && (int)$article_two_details['sub_art_one'] > 0){
										$sub_articles[] = dsf_get_article_two_sub($article_two_details['sub_art_one']);
									}
							
									if (isset($article_two_details['sub_art_two']) && (int)$article_two_details['sub_art_two'] > 0){
										$sub_articles[] = dsf_get_article_two_sub($article_two_details['sub_art_two']);
									}
							
									if (isset($article_two_details['sub_art_three']) && (int)$article_two_details['sub_art_three'] > 0){
										$sub_articles[] = dsf_get_article_two_sub($article_two_details['sub_art_three']);
									}
							
									if (isset($article_two_details['sub_art_four']) && (int)$article_two_details['sub_art_four'] > 0){
										$sub_articles[] = dsf_get_article_two_sub($article_two_details['sub_art_four']);
									}
							
							
									$article_two_details['sub_articles'] = $sub_articles;
							
								unset($sub_articles);
							
						
						



			
		// resort the array
				ksort($article_two_details);	


  } //end if records found.

return $article_two_details;

} // END FUNCTION



// ######

function dsf_get_article_one_item_array($article_id=0){


	$article_one_details = '';
	
	$dsv_sql_fields_required = array('article_id', 'unit_id', 'item_translated', 'item_approved', 'article_image', 'article_name', 'article_slug', 'article_title', 'title_image', 'sub_title_image', 'menu_image', 'banner_one', 'banner_two', 'banner_three', 'banner_four', 'parent_id', 'sort_order', 'article_text', 'article_keywords', 'article_meta', 'subpage_text', 'sub_prod_one', 'sub_prod_two', 'sub_prod_three', 'sub_prod_four', 'sub_prod_five', 'sub_prod_six', 'sub_prod_seven', 'sub_prod_eight', 'article_type', 'article_category', 'sub_art_one', 'sub_art_two', 'sub_art_three', 'sub_art_four', 'article_date', 'article_image_disclaimer', 'article_override_url', 'text_block_two', 'text_block_three', 'article_video', 'video_width', 'video_height', 'article_video_text', 'article_youtube_link', 'image_collection', 'image_collection_text', 'pdf_one', 'pdf_one_text', 'pdf_two', 'pdf_two_text', 'article_video_title', 'article_hide_menu', 'article_status', 'banner_one_link', 'banner_two_link', 'banner_three_link', 'banner_four_link', 'banner_one_bak_colour', 'banner_one_bak_image', 'banner_two_bak_colour', 'banner_two_bak_image', 'banner_three_bak_colour', 'banner_three_bak_image', 'banner_four_bak_colour', 'banner_four_bak_image', 'article_url_window', 'banner_one_window', 'banner_two_window', 'banner_three_window', 'banner_four_window', 'ex_script_text', 'secondary_banner', 'banner_five', 'banner_five_link', 'banner_five_bak_colour', 'banner_five_bak_image', 'banner_five_window', 'banner_six', 'banner_six_link', 'banner_six_bak_colour', 'banner_six_bak_image', 'banner_six_window', 'banner_one_image_override', 'banner_two_image_override', 'banner_three_image_override', 'banner_four_image_override', 'banner_five_image_override', 'banner_six_image_override', 'mobile_banner_one', 'mobile_banner_one_link', 'mobile_banner_one_bak_colour', 'mobile_banner_one_bak_image', 'mobile_banner_one_window', 'mobile_banner_one_image_override', 'mobile_banner_two', 'mobile_banner_two_link', 'mobile_banner_two_bak_colour', 'mobile_banner_two_bak_image', 'mobile_banner_two_window', 'mobile_banner_two_image_override', 'mobile_banner_three', 'mobile_banner_three_link', 'mobile_banner_three_bak_colour', 'mobile_banner_three_bak_image', 'mobile_banner_three_window', 'mobile_banner_three_image_override', 'mobile_banner_four', 'mobile_banner_four_link', 'mobile_banner_four_bak_colour', 'mobile_banner_four_bak_image', 'mobile_banner_four_window', 'mobile_banner_four_image_override', 'mobile_banner_five', 'mobile_banner_five_link', 'mobile_banner_five_bak_colour', 'mobile_banner_five_bak_image', 'mobile_banner_five_window', 'mobile_banner_five_image_override', 'mobile_banner_six', 'mobile_banner_six_link', 'mobile_banner_six_bak_colour', 'mobile_banner_six_bak_image', 'mobile_banner_six_window', 'mobile_banner_six_image_override', 'tablet_banner_one', 'tablet_banner_one_link', 'tablet_banner_one_bak_colour', 'tablet_banner_one_bak_image', 'tablet_banner_one_window', 'tablet_banner_one_image_override', 'tablet_banner_two', 'tablet_banner_two_link', 'tablet_banner_two_bak_colour', 'tablet_banner_two_bak_image', 'tablet_banner_two_window', 'tablet_banner_two_image_override', 'tablet_banner_three', 'tablet_banner_three_link', 'tablet_banner_three_bak_colour', 'tablet_banner_three_bak_image', 'tablet_banner_three_window', 'tablet_banner_three_image_override', 'tablet_banner_four', 'tablet_banner_four_link', 'tablet_banner_four_bak_colour', 'tablet_banner_four_bak_image', 'tablet_banner_four_window', 'tablet_banner_four_image_override', 'tablet_banner_five', 'tablet_banner_five_link', 'tablet_banner_five_bak_colour', 'tablet_banner_five_bak_image', 'tablet_banner_five_window', 'tablet_banner_five_image_override', 'tablet_banner_six', 'tablet_banner_six_link', 'tablet_banner_six_bak_colour', 'tablet_banner_six_bak_image', 'tablet_banner_six_window', 'tablet_banner_six_image_override');
	
	$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sa','la');
	
    // get details of the gallery items
    
    $seasonal_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".article_one sa left join " . DS_DB_LANGUAGE . ".article_one la on (sa.article_id = la.article_id) where sa.article_id='" . (int)$article_id . "'");
  

  if (dsf_db_num_rows($seasonal_query) > 0){
	    $seasonal_results = dsf_db_fetch_array($seasonal_query);
	
			
			$article_one_details = dsf_sql_override_values($dsv_sql_fields_required, $seasonal_results);
			// at this point we make amendments or additions to the array.

		
			$article_one_details['url'] = dsf_article_one_url($article_id);
			$article_one_details['attributes'] = 'article_id=' . $article_id ;
			
			
			// check for the type of article (exclude a 0 from shop values)
			
			if ($seasonal_results['ov_article_type'] > 0){
				// fine it is already set.
			}else{
				// its not been overridden therefore language takes over.
				$article_one_details['article_type'] = $seasonal_results['article_type'];
			}
			
			
			
			//unset a couple of fields
			unset($article_one_details['item_translated']);
			
		
		// fix article type
		
			$article_one_details['article_type'] = $seasonal_results['article_type'];
		


// images

// menu images

	if (strlen($article_one_details['menu_image']) > 1){
		$article_one_details['menu_image'] = 'sized/home/' . $article_one_details['menu_image'];
	}

	if (strlen($article_one_details['mobile_menu_image']) > 1){
		$article_one_details['mobile_menu_image'] = 'sized/home/' . $article_one_details['mobile_menu_image'];
	}


	if (strlen($article_one_details['tablet_menu_image']) > 1){
		$article_one_details['tablet_menu_image'] = 'sized/home/' . $article_one_details['tablet_menu_image'];
	}

// banner images


$desktop_banner = array();

					$desktop_banner['dsv_banner_one_image'] = $article_one_details['banner_one'];
					$desktop_banner['dsv_banner_two_image'] = $article_one_details['banner_two'];
					$desktop_banner['dsv_banner_three_image'] = $article_one_details['banner_three'];
					$desktop_banner['dsv_banner_four_image'] = $article_one_details['banner_four'];
					$desktop_banner['dsv_banner_five_image'] = $article_one_details['banner_five'];
					$desktop_banner['dsv_banner_six_image'] = $article_one_details['banner_six'];
					
					$desktop_banner['dsv_banner_one_thumb'] = (strlen($article_one_details['banner_one']) >1 ? 'sized/listing/thumb_' . $article_one_details['banner_one'] : '');
					$desktop_banner['dsv_banner_two_thumb'] = (strlen($article_one_details['banner_two']) >1 ? 'sized/listing/thumb_' . $article_one_details['banner_two'] : '');
					$desktop_banner['dsv_banner_three_thumb'] = (strlen($article_one_details['banner_three']) >1 ? 'sized/listing/thumb_' . $article_one_details['banner_three'] : '');
					$desktop_banner['dsv_banner_four_thumb'] = (strlen($article_one_details['banner_four']) >1 ? 'sized/listing/thumb_' . $article_one_details['banner_four'] : '');
					$desktop_banner['dsv_banner_five_thumb'] = (strlen($article_one_details['banner_five']) >1 ? 'sized/listing/thumb_' . $article_one_details['banner_five'] : '');
					$desktop_banner['dsv_banner_six_thumb'] = (strlen($article_one_details['banner_six']) >1 ? 'sized/listing/thumb_' . $article_one_details['banner_six'] : '');
	
					$desktop_banner['dsv_banner_one_url'] = $article_one_details['banner_one_link'];
					$desktop_banner['dsv_banner_two_url'] = $article_one_details['banner_two_link'];
					$desktop_banner['dsv_banner_three_url'] = $article_one_details['banner_three_link'];
					$desktop_banner['dsv_banner_four_url'] = $article_one_details['banner_four_link'];
					$desktop_banner['dsv_banner_five_url'] = $article_one_details['banner_five_link'];
					$desktop_banner['dsv_banner_six_url'] = $article_one_details['banner_six_link'];
			
					$desktop_banner['dsv_banner_one_window'] = ((int)$seasonal_results['banner_one_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_two_window'] = ((int)$seasonal_results['banner_two_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_three_window'] = ((int)$seasonal_results['banner_three_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_four_window'] = ((int)$seasonal_results['banner_four_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_five_window'] = ((int)$seasonal_results['banner_five_window'] == 1 ? 'true' : 'false');
					$desktop_banner['dsv_banner_six_window'] = ((int)$seasonal_results['banner_six_window'] == 1 ? 'true' : 'false');
	
					$desktop_banner['dsv_banner_one_bimage'] = $article_one_details['banner_one_bak_image'];
					$desktop_banner['dsv_banner_two_bimage'] = $article_one_details['banner_two_bak_image'];
					$desktop_banner['dsv_banner_three_bimage'] = $article_one_details['banner_three_bak_image'];
					$desktop_banner['dsv_banner_four_bimage'] = $article_one_details['banner_four_bak_image'];
					$desktop_banner['dsv_banner_five_bimage'] = $article_one_details['banner_five_bak_image'];
					$desktop_banner['dsv_banner_six_bimage'] = $article_one_details['banner_six_bak_image'];
					
					$desktop_banner['banner_one_bak_image'] = (strlen($article_one_details['banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['banner_one_bak_image'] : '');
					$desktop_banner['banner_two_bak_image'] = (strlen($article_one_details['banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['banner_two_bak_image'] : '');
					$desktop_banner['banner_three_bak_image'] = (strlen($article_one_details['banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['banner_three_bak_image'] : '');
					$desktop_banner['banner_four_bak_image'] = (strlen($article_one_details['banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['banner_four_bak_image'] : '');
					$desktop_banner['banner_five_bak_image'] = (strlen($article_one_details['banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['banner_five_bak_image'] : '');
					$desktop_banner['banner_six_bak_image'] = (strlen($article_one_details['banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['banner_six_bak_image'] : '');
			
					$desktop_banner['banner_one_bak_colour'] = $article_one_details['banner_one_bak_colour'];
					$desktop_banner['banner_two_bak_colour'] = $article_one_details['banner_two_bak_colour'];
					$desktop_banner['banner_three_bak_colour'] = $article_one_details['banner_three_bak_colour'];
					$desktop_banner['banner_four_bak_colour'] = $article_one_details['banner_four_bak_colour'];
					$desktop_banner['banner_five_bak_colour'] = $article_one_details['banner_five_bak_colour'];
					$desktop_banner['banner_six_bak_colour'] = $article_one_details['banner_six_bak_colour'];


// unset previous variables as to not confuse content developers.
					unset($article_one_details['banner_one']);
					unset($article_one_details['banner_two']);
					unset($article_one_details['banner_three']);
					unset($article_one_details['banner_four']);
					unset($article_one_details['banner_five']);
					unset($article_one_details['banner_six']);
					
					unset($article_one_details['banner_one_link']);
					unset($article_one_details['banner_two_link']);
					unset($article_one_details['banner_three_link']);
					unset($article_one_details['banner_four_link']);
					unset($article_one_details['banner_five_link']);
					unset($article_one_details['banner_six_link']);
			
					unset($article_one_details['banner_one_window']);
					unset($article_one_details['banner_two_window']);
					unset($article_one_details['banner_three_window']);
					unset($article_one_details['banner_four_window']);
					unset($article_one_details['banner_five_window']);
					unset($article_one_details['banner_six_window']);
	
					unset($article_one_details['banner_one_bak_image']);
					unset($article_one_details['banner_two_bak_image']);
					unset($article_one_details['banner_three_bak_image']);
					unset($article_one_details['banner_four_bak_image']);
					unset($article_one_details['banner_five_bak_image']);
					unset($article_one_details['banner_six_bak_image']);
					
					unset($article_one_details['banner_one_bak_image']);
					unset($article_one_details['banner_two_bak_image']);
					unset($article_one_details['banner_three_bak_image']);
					unset($article_one_details['banner_four_bak_image']);
					unset($article_one_details['banner_five_bak_image']);
					unset($article_one_details['banner_six_bak_image']);
			
					unset($article_one_details['banner_one_bak_colour']);
					unset($article_one_details['banner_two_bak_colour']);
					unset($article_one_details['banner_three_bak_colour']);
					unset($article_one_details['banner_four_bak_colour']);
					unset($article_one_details['banner_five_bak_colour']);
					unset($article_one_details['banner_six_bak_colour']);


$article_one_details['banner_desktop'] = $desktop_banner;



$mobile_banner = array();

					$mobile_banner['dsv_banner_one_image'] = $article_one_details['mobile_banner_one'];
					$mobile_banner['dsv_banner_two_image'] = $article_one_details['mobile_banner_two'];
					$mobile_banner['dsv_banner_three_image'] = $article_one_details['mobile_banner_three'];
					$mobile_banner['dsv_banner_four_image'] = $article_one_details['mobile_banner_four'];
					$mobile_banner['dsv_banner_five_image'] = $article_one_details['mobile_banner_five'];
					$mobile_banner['dsv_banner_six_image'] = $article_one_details['mobile_banner_six'];
					
					$mobile_banner['dsv_banner_one_thumb'] = (strlen($article_one_details['mobile_banner_one']) >1 ? 'sized/listing/thumb_' . $article_one_details['mobile_banner_one'] : '');
					$mobile_banner['dsv_banner_two_thumb'] = (strlen($article_one_details['mobile_banner_two']) >1 ? 'sized/listing/thumb_' . $article_one_details['mobile_banner_two'] : '');
					$mobile_banner['dsv_banner_three_thumb'] = (strlen($article_one_details['mobile_banner_three']) >1 ? 'sized/listing/thumb_' . $article_one_details['mobile_banner_three'] : '');
					$mobile_banner['dsv_banner_four_thumb'] = (strlen($article_one_details['mobile_banner_four']) >1 ? 'sized/listing/thumb_' . $article_one_details['mobile_banner_four'] : '');
					$mobile_banner['dsv_banner_five_thumb'] = (strlen($article_one_details['mobile_banner_five']) >1 ? 'sized/listing/thumb_' . $article_one_details['mobile_banner_five'] : '');
					$mobile_banner['dsv_banner_six_thumb'] = (strlen($article_one_details['mobile_banner_six']) >1 ? 'sized/listing/thumb_' . $article_one_details['mobile_banner_six'] : '');
	
					$mobile_banner['dsv_banner_one_url'] = $article_one_details['mobile_banner_one_link'];
					$mobile_banner['dsv_banner_two_url'] = $article_one_details['mobile_banner_two_link'];
					$mobile_banner['dsv_banner_three_url'] = $article_one_details['mobile_banner_three_link'];
					$mobile_banner['dsv_banner_four_url'] = $article_one_details['mobile_banner_four_link'];
					$mobile_banner['dsv_banner_five_url'] = $article_one_details['mobile_banner_five_link'];
					$mobile_banner['dsv_banner_six_url'] = $article_one_details['mobile_banner_six_link'];
			
					$mobile_banner['dsv_banner_one_window'] = ((int)$seasonal_results['mobile_banner_one_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_two_window'] = ((int)$seasonal_results['mobile_banner_two_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_three_window'] = ((int)$seasonal_results['mobile_banner_three_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_four_window'] = ((int)$seasonal_results['mobile_banner_four_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_five_window'] = ((int)$seasonal_results['mobile_banner_five_window'] == 1 ? 'true' : 'false');
					$mobile_banner['dsv_banner_six_window'] = ((int)$seasonal_results['mobile_banner_six_window'] == 1 ? 'true' : 'false');
	
					$mobile_banner['dsv_banner_one_bimage'] = $article_one_details['mobile_banner_one_bak_image'];
					$mobile_banner['dsv_banner_two_bimage'] = $article_one_details['mobile_banner_two_bak_image'];
					$mobile_banner['dsv_banner_three_bimage'] = $article_one_details['mobile_banner_three_bak_image'];
					$mobile_banner['dsv_banner_four_bimage'] = $article_one_details['mobile_banner_four_bak_image'];
					$mobile_banner['dsv_banner_five_bimage'] = $article_one_details['mobile_banner_five_bak_image'];
					$mobile_banner['dsv_banner_six_bimage'] = $article_one_details['mobile_banner_six_bak_image'];
					
					$mobile_banner['banner_one_bak_image'] = (strlen($article_one_details['mobile_banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['mobile_banner_one_bak_image'] : '');
					$mobile_banner['banner_two_bak_image'] = (strlen($article_one_details['mobile_banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['mobile_banner_two_bak_image'] : '');
					$mobile_banner['banner_three_bak_image'] = (strlen($article_one_details['mobile_banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['mobile_banner_three_bak_image'] : '');
					$mobile_banner['banner_four_bak_image'] = (strlen($article_one_details['mobile_banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['mobile_banner_four_bak_image'] : '');
					$mobile_banner['banner_five_bak_image'] = (strlen($article_one_details['mobile_banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['mobile_banner_five_bak_image'] : '');
					$mobile_banner['banner_six_bak_image'] = (strlen($article_one_details['mobile_banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['mobile_banner_six_bak_image'] : '');
			
					$mobile_banner['banner_one_bak_colour'] = $article_one_details['mobile_banner_one_bak_colour'];
					$mobile_banner['banner_two_bak_colour'] = $article_one_details['mobile_banner_two_bak_colour'];
					$mobile_banner['banner_three_bak_colour'] = $article_one_details['mobile_banner_three_bak_colour'];
					$mobile_banner['banner_four_bak_colour'] = $article_one_details['mobile_banner_four_bak_colour'];
					$mobile_banner['banner_five_bak_colour'] = $article_one_details['mobile_banner_five_bak_colour'];
					$mobile_banner['banner_six_bak_colour'] = $article_one_details['mobile_banner_six_bak_colour'];


// unset previous variables as to not confuse content developers.
					unset($article_one_details['mobile_banner_one']);
					unset($article_one_details['mobile_banner_two']);
					unset($article_one_details['mobile_banner_three']);
					unset($article_one_details['mobile_banner_four']);
					unset($article_one_details['mobile_banner_five']);
					unset($article_one_details['mobile_banner_six']);
					
					unset($article_one_details['mobile_banner_one_link']);
					unset($article_one_details['mobile_banner_two_link']);
					unset($article_one_details['mobile_banner_three_link']);
					unset($article_one_details['mobile_banner_four_link']);
					unset($article_one_details['mobile_banner_five_link']);
					unset($article_one_details['mobile_banner_six_link']);
			
					unset($article_one_details['mobile_banner_one_window']);
					unset($article_one_details['mobile_banner_two_window']);
					unset($article_one_details['mobile_banner_three_window']);
					unset($article_one_details['mobile_banner_four_window']);
					unset($article_one_details['mobile_banner_five_window']);
					unset($article_one_details['mobile_banner_six_window']);
	
					unset($article_one_details['mobile_banner_one_bak_image']);
					unset($article_one_details['mobile_banner_two_bak_image']);
					unset($article_one_details['mobile_banner_three_bak_image']);
					unset($article_one_details['mobile_banner_four_bak_image']);
					unset($article_one_details['mobile_banner_five_bak_image']);
					unset($article_one_details['mobile_banner_six_bak_image']);
					
					unset($article_one_details['mobile_banner_one_bak_image']);
					unset($article_one_details['mobile_banner_two_bak_image']);
					unset($article_one_details['mobile_banner_three_bak_image']);
					unset($article_one_details['mobile_banner_four_bak_image']);
					unset($article_one_details['mobile_banner_five_bak_image']);
					unset($article_one_details['mobile_banner_six_bak_image']);
			
					unset($article_one_details['mobile_banner_one_bak_colour']);
					unset($article_one_details['mobile_banner_two_bak_colour']);
					unset($article_one_details['mobile_banner_three_bak_colour']);
					unset($article_one_details['mobile_banner_four_bak_colour']);
					unset($article_one_details['mobile_banner_five_bak_colour']);
					unset($article_one_details['mobile_banner_six_bak_colour']);


$article_one_details['banner_mobile'] = $mobile_banner;



$tablet_banner = array();

					$tablet_banner['dsv_banner_one_image'] = $article_one_details['tablet_banner_one'];
					$tablet_banner['dsv_banner_two_image'] = $article_one_details['tablet_banner_two'];
					$tablet_banner['dsv_banner_three_image'] = $article_one_details['tablet_banner_three'];
					$tablet_banner['dsv_banner_four_image'] = $article_one_details['tablet_banner_four'];
					$tablet_banner['dsv_banner_five_image'] = $article_one_details['tablet_banner_five'];
					$tablet_banner['dsv_banner_six_image'] = $article_one_details['tablet_banner_six'];
					
					$tablet_banner['dsv_banner_one_thumb'] = (strlen($article_one_details['tablet_banner_one']) >1 ? 'sized/listing/thumb_' . $article_one_details['tablet_banner_one'] : '');
					$tablet_banner['dsv_banner_two_thumb'] = (strlen($article_one_details['tablet_banner_two']) >1 ? 'sized/listing/thumb_' . $article_one_details['tablet_banner_two'] : '');
					$tablet_banner['dsv_banner_three_thumb'] = (strlen($article_one_details['tablet_banner_three']) >1 ? 'sized/listing/thumb_' . $article_one_details['tablet_banner_three'] : '');
					$tablet_banner['dsv_banner_four_thumb'] = (strlen($article_one_details['tablet_banner_four']) >1 ? 'sized/listing/thumb_' . $article_one_details['tablet_banner_four'] : '');
					$tablet_banner['dsv_banner_five_thumb'] = (strlen($article_one_details['tablet_banner_five']) >1 ? 'sized/listing/thumb_' . $article_one_details['tablet_banner_five'] : '');
					$tablet_banner['dsv_banner_six_thumb'] = (strlen($article_one_details['tablet_banner_six']) >1 ? 'sized/listing/thumb_' . $article_one_details['tablet_banner_six'] : '');
	
					$tablet_banner['dsv_banner_one_url'] = $article_one_details['tablet_banner_one_link'];
					$tablet_banner['dsv_banner_two_url'] = $article_one_details['tablet_banner_two_link'];
					$tablet_banner['dsv_banner_three_url'] = $article_one_details['tablet_banner_three_link'];
					$tablet_banner['dsv_banner_four_url'] = $article_one_details['tablet_banner_four_link'];
					$tablet_banner['dsv_banner_five_url'] = $article_one_details['tablet_banner_five_link'];
					$tablet_banner['dsv_banner_six_url'] = $article_one_details['tablet_banner_six_link'];
			
					$tablet_banner['dsv_banner_one_window'] = ((int)$seasonal_results['tablet_banner_one_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_two_window'] = ((int)$seasonal_results['tablet_banner_two_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_three_window'] = ((int)$seasonal_results['tablet_banner_three_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_four_window'] = ((int)$seasonal_results['tablet_banner_four_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_five_window'] = ((int)$seasonal_results['tablet_banner_five_window'] == 1 ? 'true' : 'false');
					$tablet_banner['dsv_banner_six_window'] = ((int)$seasonal_results['tablet_banner_six_window'] == 1 ? 'true' : 'false');
	
					$tablet_banner['dsv_banner_one_bimage'] = $article_one_details['tablet_banner_one_bak_image'];
					$tablet_banner['dsv_banner_two_bimage'] = $article_one_details['tablet_banner_two_bak_image'];
					$tablet_banner['dsv_banner_three_bimage'] = $article_one_details['tablet_banner_three_bak_image'];
					$tablet_banner['dsv_banner_four_bimage'] = $article_one_details['tablet_banner_four_bak_image'];
					$tablet_banner['dsv_banner_five_bimage'] = $article_one_details['tablet_banner_five_bak_image'];
					$tablet_banner['dsv_banner_six_bimage'] = $article_one_details['tablet_banner_six_bak_image'];
					
					$tablet_banner['banner_one_bak_image'] = (strlen($article_one_details['tablet_banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['tablet_banner_one_bak_image'] : '');
					$tablet_banner['banner_two_bak_image'] = (strlen($article_one_details['tablet_banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['tablet_banner_two_bak_image'] : '');
					$tablet_banner['banner_three_bak_image'] = (strlen($article_one_details['tablet_banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['tablet_banner_three_bak_image'] : '');
					$tablet_banner['banner_four_bak_image'] = (strlen($article_one_details['tablet_banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['tablet_banner_four_bak_image'] : '');
					$tablet_banner['banner_five_bak_image'] = (strlen($article_one_details['tablet_banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['tablet_banner_five_bak_image'] : '');
					$tablet_banner['banner_six_bak_image'] = (strlen($article_one_details['tablet_banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $article_one_details['tablet_banner_six_bak_image'] : '');
			
					$tablet_banner['banner_one_bak_colour'] = $article_one_details['tablet_banner_one_bak_colour'];
					$tablet_banner['banner_two_bak_colour'] = $article_one_details['tablet_banner_two_bak_colour'];
					$tablet_banner['banner_three_bak_colour'] = $article_one_details['tablet_banner_three_bak_colour'];
					$tablet_banner['banner_four_bak_colour'] = $article_one_details['tablet_banner_four_bak_colour'];
					$tablet_banner['banner_five_bak_colour'] = $article_one_details['tablet_banner_five_bak_colour'];
					$tablet_banner['banner_six_bak_colour'] = $article_one_details['tablet_banner_six_bak_colour'];


// unset previous variables as to not confuse content developers.
					unset($article_one_details['tablet_banner_one']);
					unset($article_one_details['tablet_banner_two']);
					unset($article_one_details['tablet_banner_three']);
					unset($article_one_details['tablet_banner_four']);
					unset($article_one_details['tablet_banner_five']);
					unset($article_one_details['tablet_banner_six']);
					
					unset($article_one_details['tablet_banner_one_link']);
					unset($article_one_details['tablet_banner_two_link']);
					unset($article_one_details['tablet_banner_three_link']);
					unset($article_one_details['tablet_banner_four_link']);
					unset($article_one_details['tablet_banner_five_link']);
					unset($article_one_details['tablet_banner_six_link']);
			
					unset($article_one_details['tablet_banner_one_window']);
					unset($article_one_details['tablet_banner_two_window']);
					unset($article_one_details['tablet_banner_three_window']);
					unset($article_one_details['tablet_banner_four_window']);
					unset($article_one_details['tablet_banner_five_window']);
					unset($article_one_details['tablet_banner_six_window']);
	
					unset($article_one_details['tablet_banner_one_bak_image']);
					unset($article_one_details['tablet_banner_two_bak_image']);
					unset($article_one_details['tablet_banner_three_bak_image']);
					unset($article_one_details['tablet_banner_four_bak_image']);
					unset($article_one_details['tablet_banner_five_bak_image']);
					unset($article_one_details['tablet_banner_six_bak_image']);
					
					unset($article_one_details['tablet_banner_one_bak_image']);
					unset($article_one_details['tablet_banner_two_bak_image']);
					unset($article_one_details['tablet_banner_three_bak_image']);
					unset($article_one_details['tablet_banner_four_bak_image']);
					unset($article_one_details['tablet_banner_five_bak_image']);
					unset($article_one_details['tablet_banner_six_bak_image']);
			
					unset($article_one_details['tablet_banner_one_bak_colour']);
					unset($article_one_details['tablet_banner_two_bak_colour']);
					unset($article_one_details['tablet_banner_three_bak_colour']);
					unset($article_one_details['tablet_banner_four_bak_colour']);
					unset($article_one_details['tablet_banner_five_bak_colour']);
					unset($article_one_details['tablet_banner_six_bak_colour']);

$article_one_details['banner_tablet'] = $tablet_banner;


unset($desktop_banner);
unset($mobile_banner);
unset($tablet_banner);



// overrides not currently in use
unset($article_one_details['banner_one_image_override']);
unset($article_one_details['banner_two_image_override']);
unset($article_one_details['banner_three_image_override']);
unset($article_one_details['banner_four_image_override']);
unset($article_one_details['banner_five_image_override']);
unset($article_one_details['banner_six_image_override']);

unset($article_one_details['mobile_banner_one_image_override']);
unset($article_one_details['mobile_banner_two_image_override']);
unset($article_one_details['mobile_banner_three_image_override']);
unset($article_one_details['mobile_banner_four_image_override']);
unset($article_one_details['mobile_banner_five_image_override']);
unset($article_one_details['mobile_banner_six_image_override']);

unset($article_one_details['tablet_banner_one_image_override']);
unset($article_one_details['tablet_banner_two_image_override']);
unset($article_one_details['tablet_banner_three_image_override']);
unset($article_one_details['tablet_banner_four_image_override']);
unset($article_one_details['tablet_banner_five_image_override']);
unset($article_one_details['tablet_banner_six_image_override']);



// sort out the products array if any products have been set.
		$article_products = array();
		
		if (isset($article_one_details['sub_prod_one']) && (int)$article_one_details['sub_prod_one'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_one_details['sub_prod_one']);
		}
		
		if (isset($article_one_details['sub_prod_two']) && (int)$article_one_details['sub_prod_two'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_one_details['sub_prod_two']);
		}
		
		if (isset($article_one_details['sub_prod_three']) && (int)$article_one_details['sub_prod_three'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_one_details['sub_prod_three']);
		}
		
		if (isset($article_one_details['sub_prod_four']) && (int)$article_one_details['sub_prod_four'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_one_details['sub_prod_four']);
		}
		
		if (isset($article_one_details['sub_prod_five']) && (int)$article_one_details['sub_prod_five'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_one_details['sub_prod_five']);
		}
		
		if (isset($article_one_details['sub_prod_six']) && (int)$article_one_details['sub_prod_six'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_one_details['sub_prod_six']);
		}
		
		if (isset($article_one_details['sub_prod_seven']) && (int)$article_one_details['sub_prod_seven'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_one_details['sub_prod_seven']);
		}
		
		if (isset($article_one_details['sub_prod_eight']) && (int)$article_one_details['sub_prod_eight'] > 0){
			$article_products[] = dsf_get_seasonal_article_product($article_one_details['sub_prod_eight']);
		}


	$article_one_details['article_products'] = $article_products;

	unset($article_products);

// unset the original values.

		unset($article_one_details['sub_prod_one']);
		unset($article_one_details['sub_prod_two']);
		unset($article_one_details['sub_prod_three']);
		unset($article_one_details['sub_prod_four']);
		unset($article_one_details['sub_prod_five']);
		unset($article_one_details['sub_prod_six']);
		unset($article_one_details['sub_prod_seven']);
		unset($article_one_details['sub_prod_eight']);




// check for any specific sub allocated articles.
		
// get the sub_art items as we use them a couple of times below and it should not be necessary to have to query the database multiple times.

						
							// get the 4 article items that can be allocated to a folder item.
							$sub_articles = array();
							
									if (isset($article_one_details['sub_art_one']) && (int)$article_one_details['sub_art_one'] > 0){
										$sub_articles[] = dsf_get_article_one_sub($article_one_details['sub_art_one']);
									}
							
									if (isset($article_one_details['sub_art_two']) && (int)$article_one_details['sub_art_two'] > 0){
										$sub_articles[] = dsf_get_article_one_sub($article_one_details['sub_art_two']);
									}
							
									if (isset($article_one_details['sub_art_three']) && (int)$article_one_details['sub_art_three'] > 0){
										$sub_articles[] = dsf_get_article_one_sub($article_one_details['sub_art_three']);
									}
							
									if (isset($article_one_details['sub_art_four']) && (int)$article_one_details['sub_art_four'] > 0){
										$sub_articles[] = dsf_get_article_one_sub($article_one_details['sub_art_four']);
									}
							
							
									$article_one_details['sub_articles'] = $sub_articles;
							
								unset($sub_articles);
							
						























						



			
		// resort the array
				ksort($article_one_details);	


  } //end if records found.

return $article_one_details;

} // END FUNCTION






// ###############################
// ####

function dsf_get_seasonal_article_item_details($dsv_article_id=0, $dsv_hide_children='false'){
	global $dsv_system_folder_prefix;
	
	
$original_details = dsf_get_seasonal_article_item_array($dsv_article_id);


			if ((int)$original_details['article_type'] == 1){ // the item found is marked as being an article file.
					$dsv_article_level = 'article';
					$seasonal_details = $original_details;
					$seasonal_details['article_level'] = 'article';
					



			
			}elseif ((int)$original_details['article_type'] == 2){ // the item found is marked as being an asset folder - we don't show these..
					$dsv_article_level = 'asset';
					$seasonal_details['article_level'] = 'asset';
			
			}elseif ((int)$original_details['article_type'] == 3){ // the item found is marked as being an include.
					$dsv_article_level = 'include';
					
					$seasonal_details['article_level'] = 'include';
					
					// we need to know what kind of include this is and allocate the details accordingly.  the only items someoneone can complete
					// for an include are:
					
					// include type.
					// include id
					// slug
					// override info
					// style id
					// style class
					// SEO fields.
					
					// get the include details.
					
					if (isset($original_details['include_element']) && strpos($original_details['include_element'], ":" , 0) > 0){
							$temp_include_split = explode(":" , $original_details['include_element']);
					
					
							if (isset($temp_include_split[0]) && isset($temp_include_split[1])){
								
									$seasonal_details['article_include_id'] = (int)$temp_include_split[1];
									
									if ((int)$temp_include_split[0] == 1){
										// competition
										
										$seasonal_details['article_include_type'] = 'competition';
										// get the details.
										$seasonal_details['competition_details'] = dsf_get_competition_item_array($seasonal_details['article_include_id']);
										
									}elseif ((int)$temp_include_split[0] == 10){
										// competition
										
										$seasonal_details['article_include_type'] = 'consumer_poll';
										// get the details.
										$seasonal_details['consumer_poll_details'] = dsf_get_consumer_poll_random_item($seasonal_details['article_include_id']);

									}elseif ((int)$temp_include_split[0] == 4){
										// gallery
										
										$seasonal_details['article_include_type'] = 'gallery';
										// get the details.
										$seasonal_details['gallery_details'] = dsf_get_gallery_item_array($seasonal_details['article_include_id'], $gID);
										

								// check for layout and content overrides
								
										if(isset($seasonal_details['gallery_details']['override_required']) && (int)$seasonal_details['gallery_details']['override_required'] == 1){
										
											if (isset($seasonal_details['gallery_details']['override_content_folder']) && strlen($seasonal_details['gallery_details']['override_content_folder']) > 1){
										
												$seasonal_details['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . $seasonal_details['gallery_details']['override_content_folder'] . '/';
											}else{
												$seasonal_details['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . 'default/';
											}
											
											
											if (isset($seasonal_details['gallery_details']['override_content_file']) && strlen($seasonal_details['gallery_details']['override_content_file']) > 1){
										
												$seasonal_details['article_include_file'] = $seasonal_details['gallery_details']['override_content_file'];
											}else{
												$seasonal_details['article_include_file'] = 'gallery.php';
											}
											
											
										} // end overrides





									}elseif ((int)$temp_include_split[0] == 5){
										// seasonal article
										
										$seasonal_details['article_include_type'] = 'article_one';
										// get the details.
										$seasonal_details['article_one_details'] = dsf_get_article_one_item_array($seasonal_details['article_include_id']);

										// article 1 does not have content overrides


									}elseif ((int)$temp_include_split[0] == 6){
										// seasonal article
										
										$seasonal_details['article_include_type'] = 'article_two';
										// get the details.
										$seasonal_details['article_two_details'] = dsf_get_article_two_item_array($seasonal_details['article_include_id']);


										// article 2 does not have content overrides

									}elseif ((int)$temp_include_split[0] == 7){
										// seasonal article
										
										$seasonal_details['article_include_type'] = 'article_three';
										// get the details.
										$seasonal_details['article_three_details'] = dsf_get_article_three_item_array($seasonal_details['article_include_id']);

										// article 3 does not have content overrides

										
										
									}elseif ((int)$temp_include_split[0] == 8){
										// seasonal article
										
										$seasonal_details['article_include_type'] = 'seasonal_article';
										// get the details.
										$seasonal_details['seasonal_details'] = dsf_get_seasonal_article_item_array($seasonal_details['article_include_id']);
									
									
									
									
									}
									



									
									// NOW ALL INCLUDE TYPES ARE PROCESSED - PROCESS ANY OVERRIDES IN THE SEASONAL ARTICLE ITEM.
									
					// slug
					// override info
					// style id
					// style class
					// SEO fields.
										$seasonal_details['article_style_id'] = $original_details['article_style_id'];
										$seasonal_details['article_style_class'] = $original_details['article_style_class'];
										$seasonal_details['url'] = $original_details['url'];
										$seasonal_details['attributes'] = $original_details['attributes'];
										
										$seasonal_details['article_title'] = $original_details['article_title'];
										$seasonal_details['article_keywords'] = $original_details['article_keywords'];
										$seasonal_details['article_meta'] = $original_details['article_meta'];

									
									



									
									
							}else{
								
								// we don't have the neccessary info information.
								
								
							$seasonal_details['article_include_type'] = 'not found';
							$seasonal_details['article_include_id'] = 'not found';
								
							}
									
					}else{
						
						// we don't have the neccessary info information.
						
						
					$seasonal_details['article_include_type'] = 'not found';
					$seasonal_details['article_include_id'] = 'not found';
						
					}
					
					
					
			
			}else{
				// go off an find what the level should be
				
					
					if ((int)$original_details['parent_id'] == 0){
						$dsv_article_level = 'hub';
						
					$seasonal_details = $original_details;
					$seasonal_details['article_level'] = 'hub';
					
					}else{
					
						$level_query = dsf_db_query("select count(article_id) as total from " . DS_DB_SHOP . ".seasonal_articles where parent_id='" . (int)$dsv_article_id . "'" . " and article_status='1'");
						$level_results = dsf_db_fetch_array($level_query);
						
							if ($level_results['total'] > 0){
								$dsv_article_level = 'nested';
								$seasonal_details = $original_details;
								$seasonal_details['article_level'] = 'nested';
								
							}else{
								$dsv_article_level = 'article';
								$seasonal_details = $original_details;
								$seasonal_details['article_level'] = 'article';
								
							}
					}
					
					
					
					
					
						
						if ($dsv_article_level == 'hub' || $dsv_article_level == 'nested'){
							
							// if we are a folder then we check to see if we are excluding any children that are specifically defined here.
						
								$neg_counter = 0;
								$neg_items = '';
						
						
							
							if ((int)$seasonal_details['include_children'] == 2){
								
								// we are specifically asked to remove duplicates
													
									if (isset($seasonal_details['sub_art_one']) && (int)$seasonal_details['sub_art_one'] > 0){
										$neg_items .= " and sa.article_id <> '" . $seasonal_details['sub_art_one'] . "'";
										$neg_counter ++;
									}
									
									if (isset($seasonal_details['sub_art_two']) && (int)$seasonal_details['sub_art_two'] > 0){
										$neg_items .= " and sa.article_id <> '" . $seasonal_details['sub_art_two'] . "'";
										$neg_counter ++;
									}
									
									if (isset($seasonal_details['sub_art_three']) && (int)$seasonal_details['sub_art_three'] > 0){
										$neg_items .= " and sa.article_id <> '" . $seasonal_details['sub_art_three'] . "'";
										$neg_counter ++;
									}
									
									
									if (isset($seasonal_details['sub_art_four']) && (int)$seasonal_details['sub_art_four'] > 0){
										$neg_items .= " and sa.article_id <> '" . $seasonal_details['sub_art_four'] . "'";
										$neg_counter ++;
									}
						
							}
							
						
						

				
				
				
				// additional parameter 2014-10-06 to allow a parent to be viewed without children regardless of settings by using initial function parameter.
				if ($dsv_hide_children == 'true'){
					
					// don't do children
					
					
					
					
				}else{
					
					// previous routine get all of the childrens information if the article is setup to show children.
					
					
				
				
							// get the children details but only if the folder is set to get children (to cut down on database processing.
				
				
				
								
								
							if ((int)$seasonal_details['include_children'] == 1 || (int)$seasonal_details['include_children'] == 2){
									
								$children_array = array();
								
									$children_query = dsf_db_query("select article_id from " . DS_DB_SHOP . ".seasonal_articles sa where sa.parent_id='" . $dsv_article_id . "'" . $neg_items . " and sa.article_status='1' order by sa.sort_order");
									while ($children_array_results = dsf_db_fetch_array($children_query)){
										
										
										$temp_array = dsf_get_seasonal_article_item_array($children_array_results['article_id'], 'false');
										
										$temp_child = array();
										
										
										

			if ((int)$temp_array['article_type'] == 0){ // the item found is marked as being a folder.
					$temp_child = $temp_array;
					$temp_child['article_level'] = 'folder';



										if(isset($temp_child['override_required']) && (int)$temp_child['override_required'] == 1){
										
											if (isset($temp_child['override_content_folder']) && strlen($temp_child['override_content_folder']) > 1){
										
												$temp_child['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . $temp_child['override_content_folder'] . '/';
											}else{
												$temp_child['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . 'default/';
											}
											
											
											if (isset($temp_child['override_content_file']) && strlen($temp_child['override_content_file']) > 1){
										
												$temp_child['article_include_file'] = $temp_child['override_content_file'];
											}else{
												$temp_child['article_include_file'] = 'seasonal_articles.php';
											}
											

												$temp_child['override_include_file'] = $temp_child['article_include_path'] . $temp_child['article_include_file'];
																	
																	
										} // end overrides


				// end article type
			}elseif ((int)$temp_array['article_type'] == 1){ // the item found is marked as being an article file.
					$temp_child = $temp_array;
					$temp_child['article_level'] = 'article';

										if(isset($temp_child['override_required']) && (int)$temp_child['override_required'] == 1){
										
											if (isset($temp_child['override_content_folder']) && strlen($temp_child['override_content_folder']) > 1){
										
												$temp_child['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . $temp_child['override_content_folder'] . '/';
											}else{
												$temp_child['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . 'default/';
											}
											
											
											if (isset($temp_child['override_content_file']) && strlen($temp_child['override_content_file']) > 1){
										
												$temp_child['article_include_file'] = $temp_child['override_content_file'];
											}else{
												$temp_child['article_include_file'] = 'seasonal_articles.php';
											}
											

												$temp_child['override_include_file'] = $temp_child['article_include_path'] . $temp_child['article_include_file'];
																	
																	
										} // end overrides


				// end article type


			}elseif ((int)$temp_array['article_type'] == 2){ // the item found is marked as being an asset folder - we don't show these..
					$temp_child['article_level'] = 'asset';
			
			
				// end asset type
			
			}elseif ((int)$temp_array['article_type'] == 3){ // the item found is marked as being an include.
					
					$temp_child['article_level'] = 'include';
					
					// we need to know what kind of include this is and allocate the details accordingly.  the only items someoneone can complete
					// for an include are:
					
					// include type.
					// include id
					// slug
					// override info
					// style id
					// style class
					// SEO fields.
					
					// get the include details.
					
					if (isset($temp_array['include_element']) && strpos($temp_array['include_element'], ":" , 0) > 0){
							$temp_include_split = explode(":" , $temp_array['include_element']);
					
					
							if (isset($temp_include_split[0]) && isset($temp_include_split[1])){
								
									$temp_child['article_include_id'] = (int)$temp_include_split[1];
									
									if ((int)$temp_include_split[0] == 1){
										// competition
										
										$temp_child['article_include_type'] = 'competition';
										// get the details.
										$temp_child['competition_details'] = dsf_get_competition_item_array($temp_child['article_include_id']);
										


									}elseif ((int)$temp_include_split[0] == 10){
										// competition
										
										$temp_child['article_include_type'] = 'consumer_poll';
										// get the details.
										$temp_child['consumer_poll_details'] = dsf_get_consumer_poll_random_item($temp_child['article_include_id']);



									}elseif ((int)$temp_include_split[0] == 4){
										// gallery
										
										$temp_child['article_include_type'] = 'gallery';
										// get the details.
										$temp_child['gallery_details'] = dsf_get_gallery_item_array($temp_child['article_include_id'], $gID);
										

								// check for layout and content overrides
								
										if(isset($temp_child['gallery_details']['override_required']) && (int)$temp_child['gallery_details']['override_required'] == 1){
										
											if (isset($temp_child['gallery_details']['override_content_folder']) && strlen($temp_child['gallery_details']['override_content_folder']) > 1){
										
												$temp_child['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . $temp_child['gallery_details']['override_content_folder'] . '/';
											}else{
												$temp_child['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . 'default/';
											}
											
											
											if (isset($temp_child['gallery_details']['override_content_file']) && strlen($temp_child['gallery_details']['override_content_file']) > 1){
										
												$temp_child['article_include_file'] = $temp_child['gallery_details']['override_content_file'];
											}else{
												$temp_child['article_include_file'] = 'gallery.php';
											}
											

												$temp_child['override_include_file'] = $temp_child['article_include_path'] . $temp_child['article_include_file'];
																	
																	
										} // end overrides




									}elseif ((int)$temp_include_split[0] == 5){
										// seasonal article
										
										$temp_child['article_include_type'] = 'article_one';
										// get the details.
										$temp_child['article_one_details'] = dsf_get_article_one_item_array($temp_child['article_include_id']);

										// article 1 does not have content overrides

										

									}elseif ((int)$temp_include_split[0] == 6){
										// seasonal article
										
										$temp_child['article_include_type'] = 'article_two';
										// get the details.
										$temp_child['article_two_details'] = dsf_get_article_two_item_array($temp_child['article_include_id']);

										// article 2 does not have content overrides


									}elseif ((int)$temp_include_split[0] == 7){
										// seasonal article
										
										$temp_child['article_include_type'] = 'article_three';
										// get the details.
										$temp_child['article_three_details'] = dsf_get_article_three_item_array($temp_child['article_include_id']);

										// article 3 does not have content overrides


										
										
									}elseif ((int)$temp_include_split[0] == 8){
										// seasonal article
										
										$temp_child['article_include_type'] = 'seasonal_article';
										// get the details.
										$temp_child['seasonal_details'] = dsf_get_seasonal_article_item_array($temp_child['article_include_id']);
									
								// check for layout and content overrides
								
										if(isset($temp_child['seasonal_details']['override_required']) && (int)$temp_child['seasonal_details']['override_required'] == 1){
										
											if (isset($temp_child['seasonal_details']['override_content_folder']) && strlen($temp_child['seasonal_details']['override_content_folder']) > 1){
										
												$temp_child['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . $temp_child['seasonal_details']['override_content_folder'] . '/';
											}else{
												$temp_child['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . 'default/';
											}
											
											
											if (isset($temp_child['seasonal_details']['override_content_file']) && strlen($temp_child['seasonal_details']['override_content_file']) > 1){
										
												$temp_child['article_include_file'] = $temp_child['seasonal_details']['override_content_file'];
											}else{
												$temp_child['article_include_file'] = 'seasonal_articles.php';
											}
											

												$temp_child['override_include_file'] = $temp_child['article_include_path'] . $temp_child['article_include_file'];
																	
																	
										} // end overrides
									
									
									
									}
									



									
									// NOW ALL INCLUDE TYPES ARE PROCESSED - PROCESS ANY OVERRIDES IN THE SEASONAL ARTICLE ITEM.
									
					// slug
					// override info
					// style id
					// style class
					// SEO fields.
										$temp_child['article_style_id'] = $temp_array['article_style_id'];
										$temp_child['article_style_class'] = $temp_array['article_style_class'];
										$temp_child['url'] = $temp_array['url'];
										$temp_child['attributes'] = $temp_array['attributes'];
										
										$temp_child['article_title'] = $temp_array['article_title'];
										$temp_child['article_keywords'] = $temp_array['article_keywords'];
										$temp_child['article_meta'] = $temp_array['article_meta'];

									


										// we do a further set of override checks as any overrides in the child articles will overrule any overrides in the original include item.

										if(isset($temp_array['override_required']) && (int)$temp_array['override_required'] == 1){
										
											if (isset($temp_array['override_content_folder']) && strlen($temp_array['override_content_folder']) > 1){
										
												$temp_child['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . $temp_array['override_content_folder'] . '/';
											}else{
												
												// see if we already have an override,  if we do then we set nothing.
												if (isset($temp_child['article_include_path']) && strlen($temp_child['article_include_path']) > 1){
													// already have one therefore do nothing.
												
												}else{
													// set as default.
													$temp_child['article_include_path'] = DS_FS_WEBSHOP . $dsv_system_folder_prefix . 'contents/' . 'default/';
													
												}
												
											}
											
											
											if (isset($temp_array['override_content_file']) && strlen($temp_array['override_content_file']) > 1){
										
												$temp_child['article_include_file'] = $temp_array['override_content_file'];
											}else{
												// see if we already have an override,  if we do then we set nothing.
												if (isset($temp_child['article_include_file']) && strlen($temp_child['article_include_file']) > 1){
													// already have one therefore do nothing.
												
												}else{
													// set as default.
														$temp_child['article_include_file'] = 'seasonal_articles.php';
												}
											}
											

												$temp_child['override_include_file'] = $temp_child['article_include_path'] . $temp_child['article_include_file'];
																	
																	
										} // end overrides


									
							}else{
								
								// we don't have the neccessary info information.
								
								
							$temp_child['article_include_type'] = 'not found';
							$temp_child['article_include_id'] = 'not found';
								
							}
									
					}else{
						
						// we don't have the neccessary info information.
						
						
					$temp_child['article_include_type'] = 'not found';
					$temp_child['article_include_id'] = 'not found';
						
					}
					
					
					// end include type
					
			} // end article type checks.
// ############################################################################################
										
						
											ksort($temp_child);
						
						
										$children_array[] = $temp_child;
										unset($temp_array);
										unset($temp_child);
										
									} // end children while
						
						
								$seasonal_details['children'] = $children_array;
								unset($children_array);
						
								
							} // end children requested check
						
						
				} // end children check on function call.
				
				
						} // else we are not a folder therefore we won't be including children.


					
						 
			} // end checking for hub or nested










// last but not least unset some items if they exist

if (isset($seasonal_details['sub_art_one'])){
	unset($seasonal_details['sub_art_one']);
}

if (isset($seasonal_details['sub_art_two'])){
	unset($seasonal_details['sub_art_two']);
}

if (isset($seasonal_details['sub_art_three'])){
	unset($seasonal_details['sub_art_three']);
}

if (isset($seasonal_details['sub_art_four'])){
	unset($seasonal_details['sub_art_four']);
}

if (isset($seasonal_details['sub_article_items'])){
	unset($seasonal_details['sub_article_items']);
}


ksort($seasonal_details);

return $seasonal_details;


}

// ###############################
// ####




function dsf_create_seasonal_articles_upper_menu($article_id=0){
	
	
// depending on whether we are being passed a parent article or not depends on the information we supply.

$seasonal_menu = '';


if (isset($article_id) && (int)$article_id > 0){
	// see if we are a parent.
	$get_parent_query = dsf_db_query("select article_id, article_type, parent_id from " . DS_DB_SHOP . ".seasonal_articles where parent_id='" . (int)$article_id . "' and article_type='0'");
	
	
	if (dsf_db_num_rows($get_parent_query) > 0){
		
		// we are a parent folder. therefore we should be using this parents ID number and finding its children.

		$current_parent = $article_id;
		$required_parent = $article_id;
		$selected_item = $article_id;
	

	}else{
		// we are not a parent therefore we need to find this items parent to use.
		
		// we are a file or folder lower than one level therefore we need to find the parent of this files parent.
		$get_parent_query = dsf_db_query("select article_id, article_type, parent_id from " . DS_DB_SHOP . ".seasonal_articles where article_id='" . (int)$article_id . "'");
		$get_parent_results = dsf_db_fetch_array($get_parent_query);
		
		$current_parent = $get_parent_results['parent_id'];
		
		if ($get_parent_results['article_type'] == 0){
			// we are a folder therefore we are fine to use this parent.
				$required_parent = $get_parent_results['parent_id'];
				$selected_item = $get_parent_results['article_id'];

		}else{
			// we are a file therefore we need to find this files parent.

				$get_parent_query_two = dsf_db_query("select article_type, parent_id from " . DS_DB_SHOP . ".seasonal_articles where article_id='" . (int)$get_parent_results['parent_id'] . "'");
				$get_parent_results_two = dsf_db_fetch_array($get_parent_query_two);
				
				$required_parent = $get_parent_results_two['parent_id'];
				$selected_item = $get_parent_results['parent_id'];
		}
	}
}else{
	$required_parent = 0;
}

// now we have our required parent, we can get items for this including any children.

	$dsv_sql_fields_required = array('article_id', 'article_type', 'parent_id', 'sort_order', 'article_name', 'menu_title', 'article_slug', 'menu_image', 'mobile_menu_image', 'tablet_menu_image', 'article_override_url');
	
	$dsv_sql_fields = dsf_sql_override_select($dsv_sql_fields_required, 'sa','la');
	
    // get details of the article items
    
    $seasonal_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".seasonal_articles sa left join " . DS_DB_LANGUAGE . ".seasonal_articles la on (sa.article_id = la.article_id) where sa.article_id='" . (int)$required_parent . "'");
  

  if (dsf_db_num_rows($seasonal_query) > 0){
	    $seasonal_results = dsf_db_fetch_array($seasonal_query);
	
			
			$seasonal_details = dsf_sql_override_values($dsv_sql_fields_required, $seasonal_results);
			// at this point we make amendments or additions to the array.

		
		
				if (strlen($seasonal_details['menu_title']) > 1){
					$menu_title = $seasonal_details['menu_title'];
				}else{
					$menu_title = $seasonal_details['article_name'];
				}
				
		
			$seasonal_menu = array('article_id' => $seasonal_results['article_id'],
									'name' => $seasonal_details['article_name'],
									'title' => $menu_title,
									'image' => $seasonal_details['menu_image'],
									'mobile_image' => $seasonal_details['mobile_menu_image'],
									'tablet_image' => $seasonal_details['tablet_menu_image'],
									'url' => dsf_seasonal_article_url($seasonal_results['article_id']),
									'article_override_url' => $seasonal_details['article_override_url'],
									'selected' => ($seasonal_results['article_id'] == $selected_item ? 'true' : 'false')
									);
			



			// now we need to find the children folders
				
			$children_items = array();
			
    
    $children_query = dsf_db_query("select " . $dsv_sql_fields . " from " . DS_DB_SHOP . ".seasonal_articles sa left join " . DS_DB_LANGUAGE . ".seasonal_articles la on (sa.article_id = la.article_id) where sa.parent_id='" . (int)$required_parent . "' and sa.article_type='0' order by sa.sort_order");
  

	  
			while($children_results = dsf_db_fetch_array($children_query)){
				$seasonal_children = dsf_sql_override_values($dsv_sql_fields_required, $children_results);
				// at this point we make amendments or additions to the array.
	
	
	
				if (strlen($seasonal_children['menu_title']) > 1){
					$menu_title = $seasonal_children['menu_title'];
				}else{
					$menu_title = $seasonal_children['article_name'];
				}
				
		
				$child_menu = array('article_id' => $children_results['article_id'],
									'name' => $seasonal_children['article_name'],
									'title' => $menu_title,
									'image' => $seasonal_children['menu_image'],
									'mobile_image' => $seasonal_children['mobile_menu_image'],
									'tablet_image' => $seasonal_children['tablet_menu_image'],
									'url' => dsf_seasonal_article_url($children_results['article_id']),
									'article_override_url' => $children_results['article_override_url'],
									'selected' => ($children_results['article_id'] == $selected_item ? 'true' : 'false')
									);
											
					$children_items[] = $child_menu;
					unset($child_menu);
					
	
	
			} // end while


		$seasonal_menu['children'] = $children_items;


  }
	

return $seasonal_menu;
	
	
} // end function






// #####

// get an individual item by not showing any children using the true parameter.
function dsf_get_individual_seasonal_article_details($dsv_article_id=0){
	return dsf_get_seasonal_article_item_details($dsv_article_id, 'true');
}


// #####

// get an individual item by not showing any related using the true parameter.
function dsf_get_individual_consumer_poll_details($dsv_poll_id=0){
	return dsf_get_consumer_poll_item_array($dsv_poll_id, 'false');
}








function dsf_get_device_banners($results=''){
// desktop banner images
global $bref;

$return_array = array();


if (is_array($results)){

		$desktop_banner = array();

	
							$desktop_banner['dsv_banner_one_image'] = $results['banner_one'];
							$desktop_banner['dsv_banner_two_image'] = $results['banner_two'];
							$desktop_banner['dsv_banner_three_image'] = $results['banner_three'];
							$desktop_banner['dsv_banner_four_image'] = $results['banner_four'];
							$desktop_banner['dsv_banner_five_image'] = $results['banner_five'];
							$desktop_banner['dsv_banner_six_image'] = $results['banner_six'];
							
							$desktop_banner['dsv_banner_one_thumb'] = (strlen($results['banner_one']) >1 ? 'sized/listing/thumb_' . $results['banner_one'] : '');
							$desktop_banner['dsv_banner_two_thumb'] = (strlen($results['banner_two']) >1 ? 'sized/listing/thumb_' . $results['banner_two'] : '');
							$desktop_banner['dsv_banner_three_thumb'] = (strlen($results['banner_three']) >1 ? 'sized/listing/thumb_' . $results['banner_three'] : '');
							$desktop_banner['dsv_banner_four_thumb'] = (strlen($results['banner_four']) >1 ? 'sized/listing/thumb_' . $results['banner_four'] : '');
							$desktop_banner['dsv_banner_five_thumb'] = (strlen($results['banner_five']) >1 ? 'sized/listing/thumb_' . $results['banner_five'] : '');
							$desktop_banner['dsv_banner_six_thumb'] = (strlen($results['banner_six']) >1 ? 'sized/listing/thumb_' . $results['banner_six'] : '');
			
							$desktop_banner['dsv_banner_one_url'] = $results['banner_one_link'];
							$desktop_banner['dsv_banner_two_url'] = $results['banner_two_link'];
							$desktop_banner['dsv_banner_three_url'] = $results['banner_three_link'];
							$desktop_banner['dsv_banner_four_url'] = $results['banner_four_link'];
							$desktop_banner['dsv_banner_five_url'] = $results['banner_five_link'];
							$desktop_banner['dsv_banner_six_url'] = $results['banner_six_link'];
					
							$desktop_banner['dsv_banner_one_window'] = ((int)$results['banner_one_window'] == 1 ? 'true' : 'false');
							$desktop_banner['dsv_banner_two_window'] = ((int)$results['banner_two_window'] == 1 ? 'true' : 'false');
							$desktop_banner['dsv_banner_three_window'] = ((int)$results['banner_three_window'] == 1 ? 'true' : 'false');
							$desktop_banner['dsv_banner_four_window'] = ((int)$results['banner_four_window'] == 1 ? 'true' : 'false');
							$desktop_banner['dsv_banner_five_window'] = ((int)$results['banner_five_window'] == 1 ? 'true' : 'false');
							$desktop_banner['dsv_banner_six_window'] = ((int)$results['banner_six_window'] == 1 ? 'true' : 'false');
			
							$desktop_banner['dsv_banner_one_bimage'] = $results['banner_one_bak_image'];
							$desktop_banner['dsv_banner_two_bimage'] = $results['banner_two_bak_image'];
							$desktop_banner['dsv_banner_three_bimage'] = $results['banner_three_bak_image'];
							$desktop_banner['dsv_banner_four_bimage'] = $results['banner_four_bak_image'];
							$desktop_banner['dsv_banner_five_bimage'] = $results['banner_five_bak_image'];
							$desktop_banner['dsv_banner_six_bimage'] = $results['banner_six_bak_image'];
							
							$desktop_banner['banner_one_bak_image'] = (strlen($results['banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['banner_one_bak_image'] : '');
							$desktop_banner['banner_two_bak_image'] = (strlen($results['banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['banner_two_bak_image'] : '');
							$desktop_banner['banner_three_bak_image'] = (strlen($results['banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['banner_three_bak_image'] : '');
							$desktop_banner['banner_four_bak_image'] = (strlen($results['banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['banner_four_bak_image'] : '');
							$desktop_banner['banner_five_bak_image'] = (strlen($results['banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['banner_five_bak_image'] : '');
							$desktop_banner['banner_six_bak_image'] = (strlen($results['banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['banner_six_bak_image'] : '');
					
							$desktop_banner['banner_one_bak_colour'] = $results['banner_one_bak_colour'];
							$desktop_banner['banner_two_bak_colour'] = $results['banner_two_bak_colour'];
							$desktop_banner['banner_three_bak_colour'] = $results['banner_three_bak_colour'];
							$desktop_banner['banner_four_bak_colour'] = $results['banner_four_bak_colour'];
							$desktop_banner['banner_five_bak_colour'] = $results['banner_five_bak_colour'];
							$desktop_banner['banner_six_bak_colour'] = $results['banner_six_bak_colour'];
		
		
		
		
		$return_array['banner_desktop'] = $desktop_banner;
		
		
		
		$mobile_banner = array();
		
							$mobile_banner['dsv_banner_one_image'] = $results['mobile_banner_one'];
							$mobile_banner['dsv_banner_two_image'] = $results['mobile_banner_two'];
							$mobile_banner['dsv_banner_three_image'] = $results['mobile_banner_three'];
							$mobile_banner['dsv_banner_four_image'] = $results['mobile_banner_four'];
							$mobile_banner['dsv_banner_five_image'] = $results['mobile_banner_five'];
							$mobile_banner['dsv_banner_six_image'] = $results['mobile_banner_six'];
							
							$mobile_banner['dsv_banner_one_thumb'] = (strlen($results['mobile_banner_one']) >1 ? 'sized/listing/thumb_' . $results['mobile_banner_one'] : '');
							$mobile_banner['dsv_banner_two_thumb'] = (strlen($results['mobile_banner_two']) >1 ? 'sized/listing/thumb_' . $results['mobile_banner_two'] : '');
							$mobile_banner['dsv_banner_three_thumb'] = (strlen($results['mobile_banner_three']) >1 ? 'sized/listing/thumb_' . $results['mobile_banner_three'] : '');
							$mobile_banner['dsv_banner_four_thumb'] = (strlen($results['mobile_banner_four']) >1 ? 'sized/listing/thumb_' . $results['mobile_banner_four'] : '');
							$mobile_banner['dsv_banner_five_thumb'] = (strlen($results['mobile_banner_five']) >1 ? 'sized/listing/thumb_' . $results['mobile_banner_five'] : '');
							$mobile_banner['dsv_banner_six_thumb'] = (strlen($results['mobile_banner_six']) >1 ? 'sized/listing/thumb_' . $results['mobile_banner_six'] : '');
			
							$mobile_banner['dsv_banner_one_url'] = $results['mobile_banner_one_link'];
							$mobile_banner['dsv_banner_two_url'] = $results['mobile_banner_two_link'];
							$mobile_banner['dsv_banner_three_url'] = $results['mobile_banner_three_link'];
							$mobile_banner['dsv_banner_four_url'] = $results['mobile_banner_four_link'];
							$mobile_banner['dsv_banner_five_url'] = $results['mobile_banner_five_link'];
							$mobile_banner['dsv_banner_six_url'] = $results['mobile_banner_six_link'];
					
							$mobile_banner['dsv_banner_one_window'] = ((int)$results['mobile_banner_one_window'] == 1 ? 'true' : 'false');
							$mobile_banner['dsv_banner_two_window'] = ((int)$results['mobile_banner_two_window'] == 1 ? 'true' : 'false');
							$mobile_banner['dsv_banner_three_window'] = ((int)$results['mobile_banner_three_window'] == 1 ? 'true' : 'false');
							$mobile_banner['dsv_banner_four_window'] = ((int)$results['mobile_banner_four_window'] == 1 ? 'true' : 'false');
							$mobile_banner['dsv_banner_five_window'] = ((int)$results['mobile_banner_five_window'] == 1 ? 'true' : 'false');
							$mobile_banner['dsv_banner_six_window'] = ((int)$results['mobile_banner_six_window'] == 1 ? 'true' : 'false');
			
							$mobile_banner['dsv_banner_one_bimage'] = $results['mobile_banner_one_bak_image'];
							$mobile_banner['dsv_banner_two_bimage'] = $results['mobile_banner_two_bak_image'];
							$mobile_banner['dsv_banner_three_bimage'] = $results['mobile_banner_three_bak_image'];
							$mobile_banner['dsv_banner_four_bimage'] = $results['mobile_banner_four_bak_image'];
							$mobile_banner['dsv_banner_five_bimage'] = $results['mobile_banner_five_bak_image'];
							$mobile_banner['dsv_banner_six_bimage'] = $results['mobile_banner_six_bak_image'];
							
							$mobile_banner['banner_one_bak_image'] = (strlen($results['mobile_banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['mobile_banner_one_bak_image'] : '');
							$mobile_banner['banner_two_bak_image'] = (strlen($results['mobile_banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['mobile_banner_two_bak_image'] : '');
							$mobile_banner['banner_three_bak_image'] = (strlen($results['mobile_banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['mobile_banner_three_bak_image'] : '');
							$mobile_banner['banner_four_bak_image'] = (strlen($results['mobile_banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['mobile_banner_four_bak_image'] : '');
							$mobile_banner['banner_five_bak_image'] = (strlen($results['mobile_banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['mobile_banner_five_bak_image'] : '');
							$mobile_banner['banner_six_bak_image'] = (strlen($results['mobile_banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['mobile_banner_six_bak_image'] : '');
					
							$mobile_banner['banner_one_bak_colour'] = $results['mobile_banner_one_bak_colour'];
							$mobile_banner['banner_two_bak_colour'] = $results['mobile_banner_two_bak_colour'];
							$mobile_banner['banner_three_bak_colour'] = $results['mobile_banner_three_bak_colour'];
							$mobile_banner['banner_four_bak_colour'] = $results['mobile_banner_four_bak_colour'];
							$mobile_banner['banner_five_bak_colour'] = $results['mobile_banner_five_bak_colour'];
							$mobile_banner['banner_six_bak_colour'] = $results['mobile_banner_six_bak_colour'];
		
		
		$return_array['banner_mobile'] = $mobile_banner;
		
		
		
		$tablet_banner = array();
		
							$tablet_banner['dsv_banner_one_image'] = $results['tablet_banner_one'];
							$tablet_banner['dsv_banner_two_image'] = $results['tablet_banner_two'];
							$tablet_banner['dsv_banner_three_image'] = $results['tablet_banner_three'];
							$tablet_banner['dsv_banner_four_image'] = $results['tablet_banner_four'];
							$tablet_banner['dsv_banner_five_image'] = $results['tablet_banner_five'];
							$tablet_banner['dsv_banner_six_image'] = $results['tablet_banner_six'];
							
							$tablet_banner['dsv_banner_one_thumb'] = (strlen($results['tablet_banner_one']) >1 ? 'sized/listing/thumb_' . $results['tablet_banner_one'] : '');
							$tablet_banner['dsv_banner_two_thumb'] = (strlen($results['tablet_banner_two']) >1 ? 'sized/listing/thumb_' . $results['tablet_banner_two'] : '');
							$tablet_banner['dsv_banner_three_thumb'] = (strlen($results['tablet_banner_three']) >1 ? 'sized/listing/thumb_' . $results['tablet_banner_three'] : '');
							$tablet_banner['dsv_banner_four_thumb'] = (strlen($results['tablet_banner_four']) >1 ? 'sized/listing/thumb_' . $results['tablet_banner_four'] : '');
							$tablet_banner['dsv_banner_five_thumb'] = (strlen($results['tablet_banner_five']) >1 ? 'sized/listing/thumb_' . $results['tablet_banner_five'] : '');
							$tablet_banner['dsv_banner_six_thumb'] = (strlen($results['tablet_banner_six']) >1 ? 'sized/listing/thumb_' . $results['tablet_banner_six'] : '');
			
							$tablet_banner['dsv_banner_one_url'] = $results['tablet_banner_one_link'];
							$tablet_banner['dsv_banner_two_url'] = $results['tablet_banner_two_link'];
							$tablet_banner['dsv_banner_three_url'] = $results['tablet_banner_three_link'];
							$tablet_banner['dsv_banner_four_url'] = $results['tablet_banner_four_link'];
							$tablet_banner['dsv_banner_five_url'] = $results['tablet_banner_five_link'];
							$tablet_banner['dsv_banner_six_url'] = $results['tablet_banner_six_link'];
					
							$tablet_banner['dsv_banner_one_window'] = ((int)$results['tablet_banner_one_window'] == 1 ? 'true' : 'false');
							$tablet_banner['dsv_banner_two_window'] = ((int)$results['tablet_banner_two_window'] == 1 ? 'true' : 'false');
							$tablet_banner['dsv_banner_three_window'] = ((int)$results['tablet_banner_three_window'] == 1 ? 'true' : 'false');
							$tablet_banner['dsv_banner_four_window'] = ((int)$results['tablet_banner_four_window'] == 1 ? 'true' : 'false');
							$tablet_banner['dsv_banner_five_window'] = ((int)$results['tablet_banner_five_window'] == 1 ? 'true' : 'false');
							$tablet_banner['dsv_banner_six_window'] = ((int)$results['tablet_banner_six_window'] == 1 ? 'true' : 'false');
			
							$tablet_banner['dsv_banner_one_bimage'] = $results['tablet_banner_one_bak_image'];
							$tablet_banner['dsv_banner_two_bimage'] = $results['tablet_banner_two_bak_image'];
							$tablet_banner['dsv_banner_three_bimage'] = $results['tablet_banner_three_bak_image'];
							$tablet_banner['dsv_banner_four_bimage'] = $results['tablet_banner_four_bak_image'];
							$tablet_banner['dsv_banner_five_bimage'] = $results['tablet_banner_five_bak_image'];
							$tablet_banner['dsv_banner_six_bimage'] = $results['tablet_banner_six_bak_image'];
							
							$tablet_banner['banner_one_bak_image'] = (strlen($results['tablet_banner_one_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['tablet_banner_one_bak_image'] : '');
							$tablet_banner['banner_two_bak_image'] = (strlen($results['tablet_banner_two_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['tablet_banner_two_bak_image'] : '');
							$tablet_banner['banner_three_bak_image'] = (strlen($results['tablet_banner_three_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['tablet_banner_three_bak_image'] : '');
							$tablet_banner['banner_four_bak_image'] = (strlen($results['tablet_banner_four_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['tablet_banner_four_bak_image'] : '');
							$tablet_banner['banner_five_bak_image'] = (strlen($results['tablet_banner_five_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['tablet_banner_five_bak_image'] : '');
							$tablet_banner['banner_six_bak_image'] = (strlen($results['tablet_banner_six_bak_image']) >1 ? $bref . DS_IMAGES_FOLDER . 'page/' . $results['tablet_banner_six_bak_image'] : '');
					
							$tablet_banner['banner_one_bak_colour'] = $results['tablet_banner_one_bak_colour'];
							$tablet_banner['banner_two_bak_colour'] = $results['tablet_banner_two_bak_colour'];
							$tablet_banner['banner_three_bak_colour'] = $results['tablet_banner_three_bak_colour'];
							$tablet_banner['banner_four_bak_colour'] = $results['tablet_banner_four_bak_colour'];
							$tablet_banner['banner_five_bak_colour'] = $results['tablet_banner_five_bak_colour'];
							$tablet_banner['banner_six_bak_colour'] = $results['tablet_banner_six_bak_colour'];
		
		
		
		$return_array['banner_tablet'] = $tablet_banner;
		
		
		unset($desktop_banner);
		unset($mobile_banner);
		unset($tablet_banner);
}


return $return_array;
}







?>