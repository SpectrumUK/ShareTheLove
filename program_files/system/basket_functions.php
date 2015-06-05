<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.




// this file is named as a function however, it is simply a required include to bring all of the
// basket actions out of the program_header file to keep it easier to read.




// check to see if there is a quanity being set
if (isset($_POST['it_quantity'])){
	$required_quanity = $_POST['it_quantity'];
}elseif (isset($_GET['it_quanity'])){
	$required_quanity = $_GET['it_quantity'];
}else{
    $required_quanity =1;
}

// make sure the required_quantity is numeric
if (is_numeric($required_quanity) == false){
    $required_quanity =1;
}






		// if we have a variable of add,  then it means we want to go back to the page that added it and not
		// to the basket page.
		
		if (isset($_GET['add']) && $_GET['add'] == 'yes'){
			$basket_override = 'true';
		}else{
			$basket_override = 'false';
		}









	// we are about to define what happens when we add something to the basket.
	// unless otherwise informed,  we go to the basket.html page.
	
	// the variable dsv_cookie_redirect_page should give us the current page we are on.
	
	



    if ($basket_override == 'false') {
      $goto =  'basket.html';
      $parameters = array('action', 'products_id', 'parts_id' , 'pid' ,'params', 'slug');
    } else {
      $goto = $dsv_cookie_redirect_page;
      if ($_GET['action'] == 'buy_now') {
        $parameters = array('action', 'pid', 'ccid' ,'params','add', 'parts_id', 'slug');
      } else {
        $parameters = array('action', 'pid' ,'params','add', 'slug');
      }
    } 



 
    switch ($_GET['action']) {
      // customer wants to update the product quantity in their shopping basket
      case 'update_product' :
	  
	  							  // ####### VOUCHER SPECIFIC CODE 
							  if (isset($_POST['dsv_voucher_validator_x']) || isset($_POST['dsv_voucher_validator_y']) || isset($_POST['dsv_voucher_validator']) ) {
							  		// we need to validate this voucher number within the basket page.
									// to get the number across however, we need to create a session variable.
											$voucher_request = strtoupper(str_replace(" ","",$_POST['input_voucher_code']));
							  		dsf_session_register('voucher_request');
							  }else{
									  if (isset($_POST['input_voucher_code']) && strlen($_POST['input_voucher_code']) >0){
											$voucher_request = strtoupper(str_replace(" ","",$_POST['input_voucher_code']));
											dsf_session_register('voucher_request');
									  }
							  }
							  // ####### VOUCHER SPECIFIC CODE

	  
	  
	  
	  
	   for ($i=0, $n=sizeof($_POST['products_id']); $i<$n; $i++) {
                                if (in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array()))) {
                                  $basket->remove($_POST['products_id'][$i]);
                                } else {
                                    $attributes = ($_POST['id'][$_POST['products_id'][$i]]) ? $_POST['id'][$_POST['products_id'][$i]] : '';
                                 
								  if (is_numeric($_POST['cart_quantity'][$i])){ // only change if numeric
								    if ($_POST['cart_quantity'][$i] == 0){
									     $basket->remove($_POST['products_id'][$i]);
									}else{
										
										if (defined('MAXIMUM_SINGLE_SKU') && ($_POST['cart_quantity'][$i] > (int)MAXIMUM_SINGLE_SKU)){
											$over_quantity_error = 'true';
									 		$basket->add_cart($_POST['products_id'][$i], (int)MAXIMUM_SINGLE_SKU, $attributes, $_POST['warranty'][$i], $_POST['parts_id'][$i], $_POST['alt_id'][$i], false);
										}else{
											
									 		$basket->add_cart($_POST['products_id'][$i], $_POST['cart_quantity'][$i], $attributes, $_POST['warranty'][$i], $_POST['parts_id'][$i], $_POST['alt_id'][$i], false);
										}
								   
								    }
                                  }
								  
								  
								// button stuff to go here.
								$but_add = 'butadd' . $_POST['products_id'][$i] . '_x';
								$but_minus = 'butminus' . $_POST['products_id'][$i] . '_x';
								$but_trash = 'buttrash' . $_POST['products_id'][$i] . '_x';
								$but_remove = 'remove' . $_POST['products_id'][$i] . '_x';
								
								if ($_POST[$but_add]){ // add another product.
								
                                  if (is_numeric($_POST['cart_quantity'][$i])){ // only change if numeric
								     $new_q = $_POST['cart_quantity'][$i] +1;
										
										if (defined('MAXIMUM_SINGLE_SKU') && ((int)$new_q > (int)MAXIMUM_SINGLE_SKU)){
											$over_quantity_error = 'true';
									 		$basket->add_cart($_POST['products_id'][$i], (int)MAXIMUM_SINGLE_SKU, $attributes, $_POST['warranty'][$i], $_POST['parts_id'][$i], $_POST['alt_id'][$i], false);
										}else{
											$basket->add_cart($_POST['products_id'][$i], $new_q, $attributes, $_POST['warranty'][$i], $_POST['parts_id'][$i], $_POST['alt_id'][$i], false);
										}
										
								  }
								 }



								if ($_POST[$but_minus]){ // add another product.
                                  if (is_numeric($_POST['cart_quantity'][$i])){ // only change if numeric
								     $new_q = $_POST['cart_quantity'][$i] -1;
									 if ((int)$new_q <=0){
                                  		$basket->remove($_POST['products_id'][$i]);
									 }else{
									 	$basket->add_cart($_POST['products_id'][$i], $new_q, $attributes, $_POST['warranty'][$i], $_POST['parts_id'][$i], $_POST['alt_id'][$i], false);
                                  	}
								  }
								 }
								
								
								if ($_POST[$but_trash]){ // add another product.
                                  $basket->remove($_POST['products_id'][$i]);
								 }
								

								if ($_POST[$but_remove]){ // add another product.
                                  $basket->remove($_POST['products_id'][$i]);
								 }


								}
                              }
							  
							  
							  if (dsf_session_is_registered('over_quantity_error')){
							  		dsf_session_unregister('over_quantity_error');
							  }
							  	if (isset($over_quantity_error) && $over_quantity_error == 'true'){
										dsf_session_register('over_quantity_error');
								}
							  
							  		dsf_resave_session('basket');
							  
							  break;
      // customer adds a product from the products page
      case 'add_product' :    if (isset($_POST['products_id']) && is_numeric($_POST['products_id'])) {
                                $basket->add_cart($_POST['products_id'], $basket->get_quantity(dsf_get_uprid($_POST['products_id'], $_POST['id']))+ $required_quanity, $_POST['id']);
                              }
							 
								 if((int)$_POST['warranty_count'] > 0){
							     // there were accessories so loop throught them.
								 for ($i = 0, $n = (int)$_POST['warranty_count'] +1; $i < $n; $i++) {
								   if ((int)$_POST['warranty_quantity'][$i] > 0){
									 // an accessory has been purchased, add that to basket as well.
                                        $basket->add_cart($_POST['products_id'], $basket->get_quantity(dsf_get_uprid($_POST['products_id'], $_POST['id'],$_POST['warranty_id'][$i]))+ (int)$_POST['warranty_quantity'][$i], $_POST['id'],$_POST['warranty_id'][$i]);
									}
								 }
							 }
						 
							 
							 if((int)$_POST['accessory_count'] > 0){
							     // there were accessories so loop throught them.
								 for ($i = 0, $n = (int)$_POST['accessory_count'] +1; $i < $n; $i++) {
								   if ((int)$_POST['accessory_quantity'][$i] > 0){
									 // an accessory has been purchased, add that to basket as well.
                                		$basket->add_cart($_POST['accessory_id'][$i], $basket->get_quantity(dsf_get_uprid($_POST['accessory_id'][$i], $_POST['id'])) + (int)$_POST['accessory_quantity'][$i], $_POST['id']);
									
									
									}
								 }
							 }
                             
							  		dsf_resave_session('cart');

                              dsf_redirect(dsf_refer_link($goto, dsf_get_all_get_params($parameters)));
                              break;
							  
							  
      // performed by the 'buy now' button in product listings and review page
      case 'buy_now' :    
	  

	  
	  			    if (isset($_GET['products_id'])) {
						
						
								if (isset($_GET['parts_id']) && (int)$_GET['parts_id'] > 0){
									$_GET['pppid'] = $_GET['products_id'] . 'P' . $_GET['parts_id'];
									$_GET['ppid'] = $_GET['products_id'];
								}else{
									// standard routine
									
									if (isset($_GET['ppid']) && ((int)$_GET['ppid']  == (int)$_GET['products_id'])){
											// dont need to do anything, the ppid is already set for returning to product on continue shopping.
									}else{
										$_GET['ppid'] = $_GET['products_id'];
									}
								}
								
								
                                if (dsf_has_product_attributes($_GET['products_id'])) {
                                  dsf_redirect(dsf_refer_link('products.html', 'products_id=' . $_GET['products_id']));
                                } else {
									
                                  
								  
								  
								  
								// ### PARTS PROGRAMMING
								if (isset($_GET['parts_id']) && (int)$_GET['parts_id'] > 0){
									// add part
								  $basket->add_cart($_GET['parts_id'], $required_quanity,'','',$_GET['parts_id']);
								}else{
									// standard product add
									  $basket->add_cart($_GET['products_id'], $required_quanity);
								}
								  
                                }
                              }

								 if((isset($_GET['warranty_id'])) && (isset($_GET['ppid']))){
									 // an accessory has been purchased, add that to basket as well.
                                        $basket->add_cart($_GET['ppid'], $basket->get_quantity(dsf_get_uprid($_GET['ppid'], $_GET['id'],$_GET['warranty_id']))+ 1, $_GET['id'],$_GET['warranty_id']);
							     }
							  unset($_GET['warranty_id']);
							  

								// alt id
								 if((isset($_GET['alt_id'])) && (isset($_GET['ppid']))){
									 // an accessory has been purchased, add that to basket as well.
                                        $basket->add_cart($_GET['ppid'], $basket->get_quantity(dsf_get_uprid($_GET['ppid'], $_GET['id'],$_GET['warranty_id'], $_GET['lamp_id'], $_GET['alt_id']))+ 1, $_GET['id'],$_GET['warranty_id'], $_GET['lamp_id'],$_GET['alt_id']);
							     }


								 if((isset($_GET['accessory_id'])) && (isset($_GET['ppid']))){
                                  $basket->add_cart($_GET['accessory_id'], $basket->get_quantity($_GET['accessory_id'])+ $required_quanity);
							     }
							  unset($_GET['accessory_id']);
  
							  
							  		dsf_resave_session('cart');
							  
                              dsf_redirect(dsf_refer_link($goto, dsf_get_all_get_params($parameters)));
                              break;


      case 'cust_order' :     if (dsf_session_is_registered('customer_id') && isset($_GET['pid'])) {
                                if (dsf_has_product_attributes($_GET['pid'])) {
                                  dsf_redirect(dsf_refer_link('products.html', 'products_id=' . $_GET['pid']));
                                } else {
                                  $basket->add_cart($_GET['pid'], $basket->get_quantity($_GET['pid'])+1);
                                }
                              }
							  
							  		dsf_resave_session('cart');
							  
							  
                              dsf_redirect(dsf_refer_link($goto, dsf_get_all_get_params($parameters)));
                              break;
    }
?>