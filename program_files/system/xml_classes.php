<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.


 
 // BUILDER
 
   class dsXmlBuilder {
    var $xml;
    var $indent;
    var $stack = array();

    function dsXmlBuilder($indent = '  ') {
      $this->indent = $indent;
      $this->xml = '<?xml version="1.0" encoding="utf-8"?>'."\n";


    }

    function dsXml_indent() {
      for ($i = 0, $j = count($this->stack); $i < $j; $i++) {
        $this->xml .= $this->indent;
      }
    }

 
 
     //Used when an element has sub-elements
    // This function adds an open tag to the output
    function dsXmlHeaderPush($element, $attributes) {
      $this->dsXml_indent();
      $this->xml .= '<'.$element . ' ' . $attributes . '>';
      $this->xml .= "\n";
      $this->stack[] = $element;
    }



     //Used when an element has sub-elements
    // This function does not add an open tag to the output
    function dsXmlHeaderPushSingle($element, $attributes) {
      $this->dsXml_indent();
      $this->xml .= '<'.$element . ' ' . $attributes . ' />';
      $this->xml .= "\n";
    }


   //Used when an element has sub-elements
    // This function adds an open tag to the output
    function dsXmlPush($element, $attributes = array()) {
      $this->dsXml_indent();
      $this->xml .= '<'.$element . '>';
         if (isset($attributes) && sizeof($attributes)>0){
				foreach ($attributes as $key => $value) {
				$this->xml .= '<'.$key.'>'.dsf_correct_ampersand($value).'</' . $key . '>';
			  }
	  }
	  
      $this->xml .= "\n";
      $this->stack[] = $element;
    }

   //Used when an element has no sub-elements and does not need to close
    // This function adds an open tag to the output
    function dsXmlPClose($element, $attributes = array()) {
      $this->dsXml_indent();
      $this->xml .= '<'.$element . '>';
      if (isset($attributes) && sizeof($attributes)>0){
		  foreach ($attributes as $key => $value) {
			$this->xml .= '<'.$key.'>'.dsf_correct_ampersand($value).'</' . $key . '>';
		  }
	  }
	  
      $this->xml .= "\n";
    }



    //Used when an element has no subelements.
    //Data within the open and close tags are provided with the 
    //contents variable
    function dsXmlElement($element, $content, $attributes = array()) {
      $this->dsXml_indent();
      $this->xml .= '<'.$element;
      if (isset($attributes) && is_array($attributes)){
		  foreach ($attributes as $key => $value) {
			$this->xml .= ' '.$key.'="'.dsf_correct_ampersand($value).'"';
		  }
	  }
	  
      $this->xml .= '>'.dsf_correct_ampersand($content).'</'.$element.'>'."\n";
	  
	  
    }



    function dsXmlRawElement($element, $content, $attributes = array()) {
      $this->dsXml_indent();
      $this->xml .= '<'.$element;
      if (isset($attributes) && sizeof($attributes)>0){
			  foreach ($attributes as $key => $value) {
				$this->xml .= ' '.$key.'="'.dsf_correct_ampersand($value).'"';
			  }
	  }
	  
      $this->xml .= '>'.dsf_correct_ampersand($content).'</'.$element.'>'."\n";
    }


    function dsXmlEmptyElement($element, $attributes = array()) {
      $this->dsXml_indent();
      $this->xml .= '<'.$element;
      if (isset($attributes) && sizeof($attributes)>0){
		  foreach ($attributes as $key => $value) {
			$this->xml .= ' '.$key.'="'.dsf_correct_ampersand($value).'"';
		  }
	  }
	  
      $this->xml .= " />\n";
    }

    //Used to close an open tag
    function dsXmlPop($pop_element) {
      $element = array_pop($this->stack);
      $this->dsXml_indent();
      if($element !== $pop_element) 
        die('XML Error: Tag Mismatch when trying to close "'. $pop_element. '"');
      else
        $this->xml .= "</$element>\n";
    }

    function dsXmlGetXML() {
      if(count($this->stack) != 0)
        die ('XML Error: No matching closing tag found for " '. array_pop($this->stack). '"');
      else
        return $this->xml;
    }
  }

// END OF BUILDER



// SUBMIT CODE
    function GetAuthenticationHeaders() {
      $headers = array();
      $headers[] = "Content-Type: application/xml; charset=UTF-8";
      $headers[] = "Accept: application/xml";
      return $headers; 
    }




    function dsSendReq($url, $header_arr, $postargs, $message_log='') {
      global $checker_order_number;
	  
	  // Get the curl session object
      $session = curl_init($url);

      // Set the POST options.
      curl_setopt($session, CURLOPT_POST, true);
      curl_setopt($session, CURLOPT_HTTPHEADER, $header_arr);
      curl_setopt($session, CURLOPT_POSTFIELDS, $postargs);
      curl_setopt($session, CURLOPT_HEADER, true);	// keep it true for UTF8 translastions to work correctly.
      curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

      // Do the POST and then close the session
      $response = curl_exec($session);
      if (curl_errno($session)) {
        die(curl_error($session));
      } else {
        curl_close($session);
      }

      // Get HTTP Status code from the response
      $status_code = array();
      preg_match('/\d\d\d/', $response, $status_code);
	  return $response;



    }




// END SUBMIT CODE


// RESPONSE CODE


  /* In case the XML API contains multiple open tags
     with the same value, then invoke this function and
     perform a foreach on the resultant array.
  */
  function get_arr_result($child_node) {
    $result = array();
    if(isset($child_node)) {
      if(is_associative_array($child_node)) {
        $result[] = $child_node;
      }
      else {
        foreach($child_node as $curr_node){
          $result[] = $curr_node;
        }
      }
    }
    return $result;
  }

  /* Returns true if a given variable represents an associative array */
  function is_associative_array( $var ) {
    return is_array( $var ) && !is_numeric( implode( '', array_keys( $var ) ) );
  }


if (!function_exists('getallheaders')) { 
   function getallheaders() {
   foreach($_SERVER as $name => $value)
       if(substr($name, 0, 5) == 'HTTP_') {
           $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
       }
   return $headers;
   }
 } 

?>