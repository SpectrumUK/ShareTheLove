<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



// this file is named as a function however, it is a mixture of functions and include file which is ran from
// the layout_header.php include file and this file will produce all of the necessary code to submit a form, check a form
// and place the fields into variables for creation.


// #####

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





// #######

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

// #####

// END FUNCTIONS



// as we only ever include this file function file if we have a form to display,  we can safely start to create the sections we need.


// job 1 is to create the form field array from the form id and put it into a variable.

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





?>