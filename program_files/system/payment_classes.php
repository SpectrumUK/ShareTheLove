<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.




class payment {
    var $modules, $selected_module;

// class constructor
    function payment($module = '') {
      global $payment, $PHP_SELF;

      if (defined('MODULE_PAYMENT_INSTALLED') && dsf_not_null(MODULE_PAYMENT_INSTALLED)) {
       
	   		
			// AMENDMENT 2013-10-28 for free of charge orders using a voucher. #########################
			
			$dsv_system_module_payment_installed = MODULE_PAYMENT_INSTALLED;
			
	   			if (defined('ALLOW_VOUCHER_FREE_BASKETS') && ALLOW_VOUCHER_FREE_BASKETS == 'true'){
					// we have the allow free voucher module to add to the list.
					
					// by default we do not want this added as a normal module as we don't want any accidental free orders going through.
					if (strlen($dsv_system_module_payment_installed) > 2){
						$dsv_system_module_payment_installed .= ';focvoucher.php';
					}else{
						$dsv_system_module_payment_installed .= 'focvoucher.php';
					}
				
				}
	   
	   		    $this->modules = explode(';', $dsv_system_module_payment_installed);

	   	 // END AMENDMENT ################################################



        $include_modules = array();

        if ( (dsf_not_null($module)) && (in_array($module . '.' . substr($PHP_SELF, (strrpos($PHP_SELF, '.')+1)), $this->modules)) ) {
          $this->selected_module = $module;

          $include_modules[] = array('class' => $module, 'file' => $module . '.php');
        
		} else {
          reset($this->modules);
          while (list(, $value) = each($this->modules)) {
            $class = substr($value, 0, strrpos($value, '.'));
            $include_modules[] = array('class' => $class, 'file' => $value);
          }
        }

        for ($i=0, $n=sizeof($include_modules); $i<$n; $i++) {
          include(DS_PROGRAM_MODULES . 'payment/' . $include_modules[$i]['file']);

          $GLOBALS[$include_modules[$i]['class']] = new $include_modules[$i]['class'];
        }

        if (!isset($GLOBALS[$payment]) || (isset($GLOBALS[$payment]) && !is_object($GLOBALS[$payment])))  {
          $payment = $include_modules[0]['class'];
        }


        if ( (dsf_not_null($module)) && (in_array($module, $this->modules)) && (isset($GLOBALS[$module]->form_action_url)) ) {
          $this->form_action_url = $GLOBALS[$module]->form_action_url;
        }
      }
    }

    function update_status() {
      if (is_array($this->modules)) {
        if (is_object($GLOBALS[$this->selected_module])) {
          if (function_exists('method_exists')) {
            if (method_exists($GLOBALS[$this->selected_module], 'update_status')) {
              $GLOBALS[$this->selected_module]->update_status();
            }
          }
        }
      }
    }


    function selection() {
      $selection_array = array();

      if (is_array($this->modules)) {
        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if ($GLOBALS[$class]->enabled) {
            $selection = $GLOBALS[$class]->selection();
            if (is_array($selection)) $selection_array[] = $selection;
          }
        }
      }

      return $selection_array;
    }

  }
?>
