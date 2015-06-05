<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



function dsf_flash_session(){
    $link= '?' . dsf_session_name() . '=' . dsf_session_id();
	return $link;

}



// protection of script injection via get variables.
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





  function dsf_form_create($name, $action, $method = 'post', $params = '') {
    $form = '<form name="' . dsf_output_string($name) . '" action="' . $action;
	
    $form .= '" method="' . dsf_output_string($method) . '"';
    if (dsf_not_null($params)) {
      $form .= ' ' . $params;
    }
    $form .= '>';

    return $form;
  }



	function dsf_form_end(){
		return '</form>';
	}
	




////
// Output a form input field


function dsf_form_search($name, $value = '', $parameters = '',  $itemclass='formitem', $placeholder=''){
// alias of dsf_form_input as search type
return dsf_form_input($name, $value, $parameters , $itemclass, $placeholder, 'search', true);
}




function dsf_form_email($name, $value = '', $parameters = '', $itemclass='formitem', $placeholder=''){
// alias of dsf_form_input as email type

return dsf_form_input($name, $value, $parameters , $itemclass, $placeholder, 'email', true);
}


////
// Output a form input field
  function dsf_form_input($name, $value = '', $parameters = '', $itemclass='formitem', $placeholder='', $type = 'text', $reinsert_value = true) {

   if (!$type || strlen($type)<2){
   		$type = 'text';
	}

	if (isset($itemclass) && strlen($itemclass) < 1){
		$itemclass = 'formitem';
	}




    $field = '<input type="' . dsf_output_string($type) . '" name="' . dsf_output_string($name) . '" id="' . dsf_output_string($name) . '"';

    if ($reinsert_value == true && dsf_not_null($value)) {
      $field .= ' value="' . dsf_output_string($value) . '"';
    }


	if (isset($placeholder) && strlen($placeholder)>0){
		$field .= ' placeholder="' . $placeholder . '"';
	}

    if (dsf_not_null($parameters)) $field .= ' ' . $parameters;


    $field .= ' class="' . $itemclass . '" />';


    return $field;
  }

////
// Output a form password field
function dsf_form_password($name, $value = '', $parameters = '',  $itemclass='formitem', $placeholder=''){
// alias of dsf_form_input as search type
	return dsf_form_input($name, $value, $parameters , $itemclass, $placeholder, 'password', false);
	
}




////
// Output a form filefield
  function dsf_form_file($name, $itemclass='formitem', $placeholder='') {
	return dsf_form_input($name, '', '' , $itemclass, $placeholder, 'file', false);

  }



////
// Output a form checkbox field
  function dsf_form_checkbox($name, $value = '', $checked = false, $params = '', $compare = '', $enabled='') {
    return dsf_form_selection($name, 'checkbox', $value, $checked, $compare, $enabled, $params, $name);
  }

////
// Output a form radio field
  function dsf_form_radio($name, $value = '', $checked = false,  $params = '', $compare = '',$id='') {
    return dsf_form_selection($name, 'radio', $value, $checked, $compare, '', $params, $id);
  }


////
// Output a selection field - alias function for dsf_form_checkbox() and dsf_form_radio()
  function dsf_form_selection($name, $type, $value = '', $checked = false, $compare ='', $enabled='', $params = '', $id='') {
    $selection = '<input type="' . dsf_output_string($type) . '" name="' . dsf_output_string($name) . '"';
	
	if (dsf_not_null($id)) {
		$selection .= ' id="' . dsf_output_string($id) . '"';
	}else{
		$selection .= ' id="' . dsf_output_string($name) . '"';
	}
	

    if (dsf_not_null($value)) $selection .= ' value="' . dsf_output_string($value) . '"';

			if ($checked == true) {
			  $selection .= ' CHECKED';
			}elseif (strlen($compare)> 0 && $value == $compare){
			  $selection .= ' CHECKED';
			}
		
	if ($enabled =='DISABLED') $selection .= ' DISABLED';
	
 	if ($params){
		$selection .= ' ' . $params;
	}
   $selection .= ' />';

    return $selection;
  }



////
// Output a form textarea field
  function dsf_form_text($name, $text='', $width, $height, $parameters = '', $itemclass='formitem') {
    $field = '<textarea name="' . dsf_output_string($name) . '" id="' . dsf_output_string($name) . '" cols="' . dsf_output_string($width) . '" rows="' . dsf_output_string($height) . '"';

    if (dsf_not_null($parameters)) $field .= ' ' . $parameters;


    $field .= ' class="' . $itemclass .'">';

        if (dsf_not_null($text)) {
      		$field .= $text;
    	}

    $field .= '</textarea>';

    return $field;
  }



////
// Output a form hidden field
  function dsf_form_hidden($name, $value = '', $parameters = '') {
    $field = '<input type="hidden" name="' . dsf_output_string($name) . '" id="' . dsf_output_string($name) . '"';
	
    if (dsf_not_null($value)) {
      $field .= ' value="' . dsf_output_string($value) . '"';
    }

    if (dsf_not_null($parameters)) $field .= ' ' . $parameters;

    $field .= ' />';

    return $field;
  }



////
// Output a form pull down menu
  function dsf_form_dropdown($name, $values, $default = '', $parameters = '', $itemclass='formitem', $required = false) {
    $field = '<select name="' . dsf_output_string($name) . '" id="' . dsf_output_string($name) . '"';

    if (dsf_not_null($parameters)) $field .= ' ' . $parameters;

     $field .= ' class="' . $itemclass .'">';
	 
    if (empty($default) && isset($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);

    for ($i=0, $n=sizeof($values); $i<$n; $i++) {
      if ($default == $values[$i]['id']) {
     		 $field .= '<option value="' . dsf_output_string($values[$i]['id']) . '"';
     		 $field .= ' selected="selected"';
      }else{
     		 $field .= '<option value="' . dsf_output_string($values[$i]['id']) . '"';
	  }

      $field .= '>' . dsf_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>';
    }
    $field .= '</select>';


    return $field;
  }



////
// Output a list style selection box.
  function dsf_form_listbox($name, $values, $default = '', $parameters = '', $itemclass='formitem', $rows=30) {
    $field = '<select name="' . dsf_output_string($name) . '" id="' . dsf_output_string($name) . '"';

	if ((int)$rows < 1){
		$rows = 30;
	}
	
	$field .= ' size="' . $rows . '"';
	

    if (dsf_not_null($parameters)) $field .= ' ' . $parameters;

     $field .= ' class="' . $itemclass .'">';
	 
    if (empty($default) && isset($GLOBALS[$name])) $default = stripslashes($GLOBALS[$name]);

    for ($i=0, $n=sizeof($values); $i<$n; $i++) {
      if ($default == $values[$i]['id']) {
     		 $field .= '<option value="' . dsf_output_string($values[$i]['id']) . '"';
     		 $field .= ' selected="selected"';
      }else{
     		 $field .= '<option value="' . dsf_output_string($values[$i]['id']) . '"';
	  }

      $field .= '>' . dsf_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>';
    }
    $field .= '</select>';


    return $field;
  }



////
// Hide form elements
  function dsf_hide_session_id() {
  
  $getsess_id = dsf_session_name();
  
    global $session_started, $_GET;

    if (($session_started == true) && isset($_GET[$getsess_id])){
      return dsf_form_hidden(dsf_session_name(), dsf_session_id());
    }
  }





  


function dsf_multi_unique($array) {
   foreach ($array as $k=>$na)
       $new[$k] = serialize($na);
   $uniq = array_unique($new);
   foreach($uniq as $k=>$ser)
       $new1[$k] = unserialize($ser);
   return ($new1);
}

function dsf_natsort2d($aryInput) {
  $aryTemp = $aryOut = array();
  foreach ($aryInput as $key=>$value) {
   reset($value);
   $aryTemp[$key]=current($value);
  }
  natsort($aryTemp);
  foreach ($aryTemp as $key=>$value) {
   $aryOut[] = $aryInput[$key];
  }
  return ($aryOut);
}

function dsf_stripquotes($text){

     $text = str_replace('"', ' ', $text);
     $text = str_replace("'", " ", $text);
return $text;
}


// ######################################
?>