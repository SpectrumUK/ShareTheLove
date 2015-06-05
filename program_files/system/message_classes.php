<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



  class messageStack {
    var $size = 0;

    function messageStack() {
      global $messageToStack;

		// create a multi array
		
      $this->errors = array('notify' => array(),
	  						'error' => array(),
							'success' => array());

      if (dsf_session_is_registered('messageToStack')) {
       
				foreach ($messageToStack as $id => $value){
						foreach($value as $item){
							$this->add($item, $id);
						}
				}
	   
	    dsf_session_unregister('messageToStack');
      }
    }


    function add($message, $type = 'notify') {
      if ($type == 'error') {
        $this->errors[$type][] = $message;
      } elseif ($type == 'success') {
        $this->errors[$type][] = $message;
      } else {
        $this->errors['notify'][] = $message;
      }
      $this->size++;
    }


    function add_session($message, $type = 'notify') {
      global $messageToStack;

      if (!dsf_session_is_registered('messageToStack')) {
		  $messageToStack = array('notify' => array(),
								'error' => array(),
								'success' => array());
      }

      if ($type == 'error') {
        $messageToStack[$type][] = $message;
      } elseif ($type == 'success') {
        $messageToStack[$type][] = $message;
      } else {
        $messageToStack['notify'][] = $message;
      }
	 
	    dsf_resave_session('messageToStack');
    }

    function output() {
     	$ds_error_string = '';
		
	 	foreach($this->errors as $id => $value){
			
			if ($id == 'error'){
					if (is_array($value) && sizeof($value) > 0){
							foreach($value as $item){
									$ds_error_string .= '<div class="dsMessError">' . $item . '</div>';
							}
						
					}
			}elseif ($id == 'success'){
					if (is_array($value) && sizeof($value) > 0){
							foreach($value as $item){
									$ds_error_string .= '<div class="dsMessSuccess">' . $item . '</div>';
							}
						
					}
			}else{
					if (is_array($value) && sizeof($value) > 0){
									foreach($value as $item){
											$ds_error_string .= '<div class="dsMessWarning">' . $item . '</div>';
									}
						
					}
			}
		}
		
	  
	  return $ds_error_string;
	 
	  $this->reset();
    }



    function reset() {
      global $messageToStack;
	  
	       if (dsf_session_is_registered('messageToStack')) {
				dsf_session_unregister('messageToStack');
		   }
	  
	  $messageToStack = array('notify' => array(),
	  						'error' => array(),
							'success' => array());
	  
      $this->errors = array('notify' => array(),
	  						'error' => array(),
							'success' => array());
      $this->size = 0;
    }

  
     function size() {
      return $this->size;
    }
  
  
 }

?>
