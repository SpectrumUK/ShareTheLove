<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



class shoppingBasket {
    var $contents, $total, $weight, $cartID, $content_type, $total_deposit, $total_additional_carriage, $c_count_fixed , $c_count_fixed_total;

    function shoppingBasket() {
      $this->reset();
    }

    function restore_contents() {
      global $customer_id;

      if (!dsf_session_is_registered('customer_id')) return false;

// insert current basket contents in database
      if (is_array($this->contents)) {
        reset($this->contents);
      
	    while (list($products_id, ) = each($this->contents)) {
          $qty = $this->contents[$products_id]['qty'];
          $warranty = $this->contents[$products_id]['warranty'];
          $parts_id = $this->contents[$products_id]['parts_id'];
          $alt_id = $this->contents[$products_id]['alt_id'];
          $bracketi = $this->contents[$products_id]['bracketi'];

          $product_query = dsf_db_query("select products_id from " . DS_DB_SHOP . ".customers_basket where customers_id = '" . (int)$customer_id . "' and products_id = '" . dsf_db_input($products_id) . "'");
 
          if (!dsf_db_num_rows($product_query)) {
            dsf_db_query("insert into " . DS_DB_SHOP . ".customers_basket (customers_id, products_id, warranty_id, parts_id, customers_basket_quantity, customers_basket_date_added) values ('" . (int)$customer_id . "', '" . dsf_db_input($products_id) . "', '" . $warranty . "', '" . dsf_db_input($parts_id) . "', '" . $qty . "', '" . date('Ymd') . "')");

            if (isset($this->contents[$products_id]['attributes'])) {
              reset($this->contents[$products_id]['attributes']);
              while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
                dsf_db_query("insert into " . DS_DB_SHOP . ".customers_basket_attributes (customers_id, products_id, products_options_id, products_options_value_id) values ('" . (int)$customer_id . "', '" . dsf_db_input($products_id) . "', '" . (int)$option . "', '" . (int)$value . "')");
              }
            }
          } else {
          
		  	// PARTS CHANGE
			if (isset($parts_id) && (int)$parts_id > 0){
					  dsf_db_query("update " . DS_DB_SHOP . ".customers_basket set customers_basket_quantity = '" . $qty . "' where customers_id = '" . (int)$customer_id . "' and products_id = '" . dsf_db_input($products_id) . "'");
			}else{
				// standard routine
					  dsf_db_query("update " . DS_DB_SHOP . ".customers_basket set customers_basket_quantity = '" . $qty . "' where customers_id = '" . (int)$customer_id . "' and products_id = '" . dsf_db_input($products_id) . "' and parts_id='" . dsf_db_input($parts_id) . "'");
			}
		  
		  }
        }
      }

// reset per-session basket contents, but not the database contents
      $this->reset(false);

      $products_query = dsf_db_query("select products_id, warranty_id, parts_id, customers_basket_quantity from " . DS_DB_SHOP . ".customers_basket where customers_id = '" . (int)$customer_id . "'");
      while ($products = dsf_db_fetch_array($products_query)) {
        $this->contents[$products['products_id']] = array('qty' => $products['customers_basket_quantity'],
		                                                  'warranty' => $products['warranty_id'],
		                                                  'parts_id' => $products['parts_id'],
		                                                  'alt_id' => $products['alt_id']);
// attributes
        $attributes_query = dsf_db_query("select products_options_id, products_options_value_id from " . DS_DB_SHOP . ".customers_basket_attributes where customers_id = '" . (int)$customer_id . "' and products_id = '" . dsf_db_input($products['products_id']) . "'");
        while ($attributes = dsf_db_fetch_array($attributes_query)) {
          $this->contents[$products['products_id']]['attributes'][$attributes['products_options_id']] = $attributes['products_options_value_id'];
        }
      }

      $this->cleanup();
    }

    function reset($reset_database = false) {
      global $customer_id;

      $this->contents = array();
      $this->total = 0;
      $this->weight = 0;
      $this->content_type = false;
	  $this->total_deposit = 0;
	  $this->total_additional_carriage = 0;
      $this->c_count_fixed = 0;
      $this->c_count_fixed_total = 0;
	  

      if (dsf_session_is_registered('customer_id') && ($reset_database == true)) {
        dsf_db_query("delete from " . DS_DB_SHOP . ".customers_basket where customers_id = '" . (int)$customer_id . "'");
        dsf_db_query("delete from " . DS_DB_SHOP . ".customers_basket_attributes where customers_id = '" . (int)$customer_id . "'");
      }

      unset($this->cartID);
      if (dsf_session_is_registered('cartID')) dsf_session_unregister('cartID');
    }

    function add_cart($products_id, $qty = '1', $attributes = '', $warranty ='', $parts_id =0, $alt_id ='', $notify = true) {
      global $new_products_id_in_cart, $customer_id;

      $products_id = dsf_get_uprid($products_id, $attributes, $warranty, $parts_id, $alt_id);
      if ($notify == true) {
        $new_products_id_in_cart = $products_id;
        dsf_session_register('new_products_id_in_cart');
      }

      if ($this->in_cart($products_id)) {
        $this->update_quantity($products_id, $qty, $attributes, $warranty, $parts_id, $alt_id);
      } else {
        $this->contents[] = array($products_id);
        $this->contents[$products_id] = array('qty' => $qty);
        $this->contents[$products_id]['warranty'] = $warranty;
		$this->contents[$products_id]['parts_id'] = $parts_id;
		$this->contents[$products_id]['alt_id'] = $alt_id;
		
// insert into database
        if (dsf_session_is_registered('customer_id')) dsf_db_query("insert into " . DS_DB_SHOP . ".customers_basket (customers_id, products_id, warranty_id, parts_id, customers_basket_quantity, customers_basket_date_added) values ('" . (int)$customer_id . "', '" . dsf_db_input($products_id) . "', '" . $warranty . "', '" . dsf_db_input($parts_id) . "', '" . $qty . "', '" . date('Ymd') . "')");

        if (is_array($attributes)) {
          reset($attributes);
          while (list($option, $value) = each($attributes)) {
            $this->contents[$products_id]['attributes'][$option] = $value;
// insert into database
            if (dsf_session_is_registered('customer_id')) dsf_db_query("insert into " . DS_DB_SHOP . ".customers_basket_attributes (customers_id, products_id, products_options_id, products_options_value_id) values ('" . (int)$customer_id . "', '" . dsf_db_input($products_id) . "', '" . (int)$option . "', '" . (int)$value . "')");
          }
        }
      }
      $this->cleanup();

// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
      $this->cartID = $this->generate_cart_id();
    }



    function update_quantity($products_id, $quantity = '', $attributes = '', $warranty ='', $parts_id =0, $alt_id='') {
      global $customer_id;

      if (empty($quantity)) return true; // nothing needs to be updated if theres no quantity, so we return true..

      $this->contents[$products_id] = array('qty' => $quantity);
         $this->contents[$products_id]['warranty'] = $warranty;
         $this->contents[$products_id]['parts_id'] = $parts_id;
         $this->contents[$products_id]['alt_id'] = $alt_id;
		 
		 // update database
	  if (dsf_session_is_registered('customer_id')) {

      // PARTS CHANGE
		  if (isset($parts_id) && (int)$parts_id > 0){
			  dsf_db_query("update " . DS_DB_SHOP . ".customers_basket set customers_basket_quantity = '" . $quantity . "' where customers_id = '" . (int)$customer_id . "' and products_id = '" . dsf_db_input($products_id) . "' and parts_id = '" . dsf_db_input($parts_id) . "'");

	  			}else {
		 		// standard routine  
		 		 dsf_db_query("update " . DS_DB_SHOP . ".customers_basket set customers_basket_quantity = '" . $quantity . "' where customers_id = '" . (int)$customer_id . "' and products_id = '" . dsf_db_input($products_id) . "'");
			}
	  }


      if (is_array($attributes)) {
        reset($attributes);
        while (list($option, $value) = each($attributes)) {
          $this->contents[$products_id]['attributes'][$option] = $value;
// update database
          if (dsf_session_is_registered('customer_id')) dsf_db_query("update " . DS_DB_SHOP . ".customers_basket_attributes set products_options_value_id = '" . (int)$value . "' where customers_id = '" . (int)$customer_id . "' and products_id = '" . dsf_db_input($products_id) . "' and products_options_id = '" . (int)$option . "'");
        }
      }
    }

    function cleanup() {
      global $customer_id;

      reset($this->contents);
      while (list($key,) = each($this->contents)) {
        if ($this->contents[$key]['qty'] < 1) {
          unset($this->contents[$key]);
// remove from database
          if (dsf_session_is_registered('customer_id')) {
            dsf_db_query("delete from " . DS_DB_SHOP . ".customers_basket where customers_id = '" . (int)$customer_id . "' and products_id = '" . dsf_db_input($key) . "'");
            dsf_db_query("delete from " . DS_DB_SHOP . ".customers_basket_attributes where customers_id = '" . (int)$customer_id . "' and products_id = '" . dsf_db_input($key) . "'");
          }
        }
      }
    }

    function count_contents() {  // get total number of items in cart 
      $total_items = 0;
      if (is_array($this->contents)) {
        reset($this->contents);
        while (list($products_id, ) = each($this->contents)) {
          $total_items += $this->get_quantity($products_id);
        }
      }

      return $total_items;
    }

    function get_quantity($products_id) {
      if (isset($this->contents[$products_id])) {
        return $this->contents[$products_id]['qty'];
      } else {
        return 0;
      }
    }

    function in_cart($products_id) {
      if (isset($this->contents[$products_id])) {
        return true;
      } else {
        return false;
      }
    }

    function remove($products_id) {
      global $customer_id;

      unset($this->contents[$products_id]);
// remove from database
      if (dsf_session_is_registered('customer_id')) {
        dsf_db_query("delete from " . DS_DB_SHOP . ".customers_basket where customers_id = '" . (int)$customer_id . "' and products_id = '" . dsf_db_input($products_id) . "'");
        dsf_db_query("delete from " . DS_DB_SHOP . ".customers_basket_attributes where customers_id = '" . (int)$customer_id . "' and products_id = '" . dsf_db_input($products_id) . "'");
      }

// assign a temporary unique ID to the order contents to prevent hack attempts during the checkout procedure
      $this->cartID = $this->generate_cart_id();
    }

    function remove_all() {
      $this->reset();
    }

    function get_product_id_list() {
      $product_id_list = '';
      if (is_array($this->contents)) {
        reset($this->contents);
        while (list($products_id, ) = each($this->contents)) {
          $product_id_list .= ', ' . $products_id;
        }
      }

      return substr($product_id_list, 2);
    }


    function calculate() {
      $this->total = 0;
      $this->weight = 0;
      $this->total_deposit = 0;
      $this->total_additional_carriage = 0;
      $this->c_count_fixed = 0;
      $this->c_count_fixed_total = 0;
	  
      if (!is_array($this->contents)) return 0;

      reset($this->contents);
      while (list($products_id, ) = each($this->contents)) {
        $qty = $this->contents[$products_id]['qty'];


	// PARTS CHAANGE
	
	if (isset($this->contents[$products_id]['parts_id']) && (int)$this->contents[$products_id]['parts_id'] > 0){
		
		

// products price
        $product_query = dsf_db_query("select products_id, products_price, products_tax_class_id, products_weight, products_deposit, additional_carriage, fixed_carriage, apply_fixed_carriage from " . DS_DB_SHOP . ".products_parts where products_id = '" . (int)$this->contents[$products_id]['parts_id'] . "'");

        if ($product = dsf_db_fetch_array($product_query)) {
          $prid = $product['products_id'];
          $products_tax = dsf_get_tax_rate($product['products_tax_class_id']);
          $products_price = $product['products_price'];
          $products_weight = $product['products_weight'];

          $specials_query = dsf_db_query("select specials_new_products_price from " . DS_DB_SHOP . ".specials_parts where products_id = '" . (int)$prid . "' and status = '1'");
          if (dsf_db_num_rows ($specials_query)) {
            $specials = dsf_db_fetch_array($specials_query);
            $products_price = $specials['specials_new_products_price'];
          }

			  $this->weight += ($qty * $products_weight);


	$temp_stock_check = dsf_stock_parts($products_id, $qty);


	// no stock
		if ((int)($temp_stock_check) > 0){  // we have a result saying there is stock so we don't
											// do a deposit,  its full price.
				$products_deposit = $products_price;						
		}else{
				// decide full price depending on whether there is a discount value
				
				if ((int)$product['products_deposit'] > 0){
					$products_deposit = ($products_price / 100) * $product['products_deposit'];
				}else{
					$products_deposit = $products_price;
				}
		}
		
		
		if ((int)$product['additional_carriage'] > 0){
			$additional_carriage = $product['additional_carriage'];
		}else{
			$additional_carriage = 0;
		}
			
			

		if ((int)$product['apply_fixed_carriage'] == 1){
			$this->c_count_fixed += $qty;
			$this->c_count_fixed_total += ($product['fixed_carriage'] * $qty);
		}

          $this->total += dsf_add_tax($products_price, $products_tax) * $qty;
          $this->total_deposit += dsf_add_tax($products_deposit, $products_tax) * $qty;
          $this->total_additional_carriage += $additional_carriage * $qty;

      }



		
		
	}else{
		
		// standard routine
		

// products price
        $product_query = dsf_db_query("select products_id, products_price, products_tax_class_id, products_weight, products_deposit, additional_carriage, fixed_carriage, apply_fixed_carriage from " . DS_DB_SHOP . ".products where products_id = '" . (int)$products_id . "'");

        if ($product = dsf_db_fetch_array($product_query)) {
          $prid = $product['products_id'];
          $products_tax = dsf_get_tax_rate($product['products_tax_class_id']);
          $products_price = $product['products_price'];
          $products_weight = $product['products_weight'];

          $specials_query = dsf_db_query("select specials_new_products_price from " . DS_DB_SHOP . ".specials where products_id = '" . (int)$prid . "' and status = '1'");
          if (dsf_db_num_rows ($specials_query)) {
            $specials = dsf_db_fetch_array($specials_query);
            $products_price = $specials['specials_new_products_price'];
          }


			if (!$this->contents[$products_id]['warranty']) {
			  $this->weight += ($qty * $products_weight);
			}


	$temp_stock_check = dsf_stock($products_id, $qty);


	// no stock
		if ((int)($temp_stock_check) > 0){  // we have a result saying there is stock so we don't
											// do a deposit,  its full price.
				$products_deposit = $products_price;						
		}else{
				// decide full price depending on whether there is a discount value
				
				if ((int)$product['products_deposit'] > 0){
					$products_deposit = ($products_price / 100) * $product['products_deposit'];
				}else{
					$products_deposit = $products_price;
				}
		}
		
		
		if ((int)$product['additional_carriage'] > 0){
			$additional_carriage = $product['additional_carriage'];
		}else{
			$additional_carriage = 0;
		}
			
			

		if ((int)$product['apply_fixed_carriage'] == 1){
			$this->c_count_fixed += $qty;
			$this->c_count_fixed_total += ($product['fixed_carriage'] * $qty);
		}

          $this->total += dsf_add_tax($products_price, $products_tax) * $qty;
          $this->total_deposit += dsf_add_tax($products_deposit, $products_tax) * $qty;
          $this->total_additional_carriage += $additional_carriage * $qty;

      }

	  } // end part or product
	  

// attributes price
        if (isset($this->contents[$products_id]['attributes'])) {
          reset($this->contents[$products_id]['attributes']);
          while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
            $attribute_price_query = dsf_db_query("select options_values_price, price_prefix from " . DS_DB_SHOP . ".products_attributes where products_id = '" . (int)$prid . "' and options_id = '" . (int)$option . "' and options_values_id = '" . (int)$value . "'");
            $attribute_price = dsf_db_fetch_array($attribute_price_query);
            if ($attribute_price['price_prefix'] == '+') {
              $this->total += $qty * dsf_add_tax($attribute_price['options_values_price'], $products_tax);
            } else {
              $this->total -= $qty * dsf_add_tax($attribute_price['options_values_price'], $products_tax);
            }
          }
        }
		
		
      }
    }



    function attributes_price($products_id) {
      $attributes_price = 0;

      if (isset($this->contents[$products_id]['attributes'])) {
        reset($this->contents[$products_id]['attributes']);
        while (list($option, $value) = each($this->contents[$products_id]['attributes'])) {
          $attribute_price_query = dsf_db_query("select options_values_price, price_prefix from " . DS_DB_SHOP . ".products_attributes where products_id = '" . (int)$products_id . "' and options_id = '" . (int)$option . "' and options_values_id = '" . (int)$value . "'");
          $attribute_price = dsf_db_fetch_array($attribute_price_query);
          if ($attribute_price['price_prefix'] == '+') {
            $attributes_price += $attribute_price['options_values_price'];
          } else {
            $attributes_price -= $attribute_price['options_values_price'];
          }
        }
      }

      return $attributes_price;
    }

    function get_products() {

      if (!is_array($this->contents)) return false;

      $products_array = array();
      reset($this->contents);
      while (list($products_id, ) = each($this->contents)) {




	// PARTS CHAANGE
	
	if (isset($this->contents[$products_id]['parts_id']) && (int)$this->contents[$products_id]['parts_id'] > 0){

        $products_query = dsf_db_query("select p.products_id, pm.products_sku, p.products_sku as ov_products_sku, pm.products_name, p.products_name as ov_products_name, pm.products_model, p.products_model as ov_products_model, pm.products_accessories, p.products_accessories as ov_products_accessories,  pm.category_image, p.category_image as ov_category_image, p.products_price, p.products_weight, p.additional_carriage, p.products_deposit, p.products_tax_class_id, p.shipping_latency, p.apply_fixed_carriage, p.fixed_carriage from " . DS_DB_SHOP . ".products_parts p left join " . DS_DB_LANGUAGE . ".products_parts pm on (p.products_id = pm.products_id) where p.products_id = '" . (int)$this->contents[$products_id]['parts_id'] . "'");
        if ($products = dsf_db_fetch_array($products_query)) {
          $prid = $products['products_id'];
          $products_price = $products['products_price'];
		  $products_full_price = $products['products_price'];
		  

          $specials_query = dsf_db_query("select specials_new_products_price from " . DS_DB_SHOP . ".specials_parts where products_id = '" . (int)$prid . "' and status = '1'");
         
		  if (dsf_db_num_rows($specials_query) > 0) {
            $specials = dsf_db_fetch_array($specials_query);
            $products_price = $specials['specials_new_products_price'];
		  	$products_full_price = 0;
          }



	$qty = $this->contents[$products_id]['qty'];

	$temp_stock_check = dsf_stock_parts($this->contents[$products_id]['parts_id'], $qty);

	// no stock

		if ((int)($temp_stock_check) > 0){  // we have a result saying there is stock so we don't
											// do a deposit,  its full price.
				$products_deposit = $products_price;						
		}else{
				// decide full price depending on whether there is a discount value
				
				if ((float)$products['products_deposit'] > 0){
					$products_deposit = ($products_price / 100) * $products['products_deposit'];
				}else{
					$products_deposit = $products_price;
				}
		}



		// define override values.
		if (isset($products['ov_products_sku']) && strlen($products['ov_products_sku']) > 1){
			$products_sku = $products['ov_products_sku'];
		}else{
			$products_sku = $products['products_sku'];
		}
		

		if (isset($products['ov_products_accessories']) && strlen($products['ov_products_accessories']) > 1){
			$products_accessories = $products['ov_products_accessories'];
		}else{
			$products_accessories = $products['products_accessories'];
		}


		
		if (isset($products['ov_products_name']) && strlen($products['ov_products_name']) > 1){
			$products_name = $products['ov_products_name'];
		}else{
			$products_name = $products['products_name'];
		}

		if (isset($products['ov_products_model']) && strlen($products['ov_products_model']) > 1){
			$products_model = $products['ov_products_model'];
		}else{
			$products_model = $products['products_model'];
		}

		if (isset($products['ov_category_image']) && strlen($products['ov_category_image']) > 1){
			$category_image = $products['ov_category_image'];
		}else{
			$category_image = $products['category_image'];
		}


         $products_array[] = array('id' => $products_id,
		 							'sku' => $products_sku,
                                    'warranty' => $this->contents[$products_id]['warranty'],
                                    'parts_id' => $this->contents[$products_id]['parts_id'],
                                    'alt_id' => $this->contents[$products_id]['alt_id'],
                                    'name' => $products_name,
                                    'model' => $products_model,
                                    'image' => $category_image,
                                    'price' => $products_price,
									'products_full_price' => $products_full_price, 
                                    'quantity' => $this->contents[$products_id]['qty'],
                                    'weight' => $products['products_weight'],
                                    'final_price' => ($products_price + $this->attributes_price($products_id)),
                                    'tax_class_id' => $products['products_tax_class_id'],
									'products_deposit' => $products_deposit,
									'additional_carriage' => $products['additional_carriage'],
									'apply_fixed_carriage' => $products['apply_fixed_carriage'],
									'fixed_carriage' => $products['fixed_carriage'],
									'shipping_latency' => $products['shipping_latency'],
									'products_accessories' => $products_accessories,
                                    'attributes' => (isset($this->contents[$products_id]['attributes']) ? $this->contents[$products_id]['attributes'] : ''));
        }


	}else{
		// standard routine
		
        $products_query = dsf_db_query("select p.products_id, pm.products_sku, p.products_sku as ov_products_sku, pm.products_name, p.products_name as ov_products_name, pm.products_model, p.products_model as ov_products_model, pm.products_accessories, p.products_accessories as ov_products_accessories, pm.category_image, p.category_image as ov_category_image, p.products_price, p.products_weight, p.additional_carriage, p.products_deposit, p.products_tax_class_id, p.shipping_latency, p.apply_fixed_carriage, p.fixed_carriage from " . DS_DB_SHOP . ".products p left join " . DS_DB_LANGUAGE . ".products pm on (p.products_id = pm.products_id) where p.products_id = '" . (int)$products_id . "'");

        if ($products = dsf_db_fetch_array($products_query)) {
          $prid = $products['products_id'];
          $products_price = $products['products_price'];
		  $products_full_price = $products['products_price'];
		  

          $specials_query = dsf_db_query("select specials_new_products_price from " . DS_DB_SHOP . ".specials where products_id = '" . (int)$prid . "' and status = '1'");
         
		  if (dsf_db_num_rows($specials_query) > 0) {
            $specials = dsf_db_fetch_array($specials_query);
            $products_price = $specials['specials_new_products_price'];
		  	$products_full_price = 0;
          }



	$qty = $this->contents[$products_id]['qty'];

	$temp_stock_check = dsf_stock($products_id, $qty);

	// no stock

		if ((int)($temp_stock_check) > 0){  // we have a result saying there is stock so we don't
											// do a deposit,  its full price.
				$products_deposit = $products_price;						
		}else{
				// decide full price depending on whether there is a discount value
				
				if ((float)$products['products_deposit'] > 0){
					$products_deposit = ($products_price / 100) * $products['products_deposit'];
				}else{
					$products_deposit = $products_price;
				}
		}




		// define override values.
		if (isset($products['ov_products_sku']) && strlen($products['ov_products_sku']) > 1){
			$products_sku = $products['ov_products_sku'];
		}else{
			$products_sku = $products['products_sku'];
		}
		
		
		if (isset($products['ov_products_accessories']) && strlen($products['ov_products_accessories']) > 1){
			$products_accessories = $products['ov_products_accessories'];
		}else{
			$products_accessories = $products['products_accessories'];
		}


		
		if (isset($products['ov_products_name']) && strlen($products['ov_products_name']) > 1){
			$products_name = $products['ov_products_name'];
		}else{
			$products_name = $products['products_name'];
		}

		if (isset($products['ov_products_model']) && strlen($products['ov_products_model']) > 1){
			$products_model = $products['ov_products_model'];
		}else{
			$products_model = $products['products_model'];
		}

		if (isset($products['ov_category_image']) && strlen($products['ov_category_image']) > 1){
			$category_image = $products['ov_category_image'];
		}else{
			$category_image = $products['category_image'];
		}




         $products_array[] = array('id' => $products_id,
		 							'sku' => $products_sku,
                                    'warranty' => $this->contents[$products_id]['warranty'],
                                    'parts_id' => $this->contents[$products_id]['parts_id'],
                                    'alt_id' => $this->contents[$products_id]['alt_id'],
                                    'name' => $products_name,
                                    'model' => $products_model,
                                    'image' => $category_image,
                                    'price' => $products_price,
									'products_full_price' => $products_full_price, 
                                    'quantity' => $this->contents[$products_id]['qty'],
                                    'weight' => $products['products_weight'],
                                    'final_price' => ($products_price + $this->attributes_price($products_id)),
                                    'tax_class_id' => $products['products_tax_class_id'],
									'products_deposit' => $products_deposit,
									'additional_carriage' => $products['additional_carriage'],
									'apply_fixed_carriage' => $products['apply_fixed_carriage'],
									'fixed_carriage' => $products['fixed_carriage'],
									'shipping_latency' => $products['shipping_latency'],
									'products_accessories' => $products_accessories,
                                    'attributes' => (isset($this->contents[$products_id]['attributes']) ? $this->contents[$products_id]['attributes'] : ''));
        }
      
	} // end part or product
	
	
	  } // end while


      return $products_array;
    }

    function show_total() {
      $this->calculate();

      return $this->total;
    }

    function show_weight() {
      $this->calculate();

      return $this->weight;
    }


    function show_deposit() {
      $this->calculate();

      return $this->total_deposit;
    }


    function show_additional_carriage() {
      $this->calculate();

      return $this->total_additional_carriage;
    }

    
	function show_fixed_carriage() {
      $this->calculate();

      return array('total_ccount_fixed' => $this->c_count_fixed,
	  				'total_ccount_fixed_value' => $this->c_count_fixed_total);
    }


    function generate_cart_id($length = 5) {
      return dsf_create_random_value($length, 'digits');
    }

    function get_content_type() {

        $this->content_type = 'physical';

      return $this->content_type;
    }

    function unserialize($broken) {
      for(reset($broken);$kv=each($broken);) {
        $key=$kv['key'];
        if (gettype($this->$key)!="user function")
        $this->$key=$kv['value'];
      }
    }

  }
?>