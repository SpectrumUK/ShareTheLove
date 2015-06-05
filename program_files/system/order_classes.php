<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



class order {
    var $info, $totals, $products, $customer, $delivery, $content_type;

    function order($order_id = '') {
      $this->info = array();
      $this->totals = array();
      $this->products = array();
      $this->customer = array();
      $this->delivery = array();

      if (dsf_not_null($order_id)) {
        $this->query($order_id);
      } else {
        $this->cart();
      }
    }

    function query($order_id) {
      global $dsv_master_select_unit;

      $order_id = dsf_db_prepare_input($order_id);

      $order_query = dsf_db_query("select o.orders_id, o.customers_id, o.customers_name, o.customers_company, o.customers_house, o.customers_street, o.customers_district, o.customers_town, o.customers_county, o.customers_postcode, o.customers_state, o.customers_country, o.customers_telephone, o.customers_email_address, o.customers_address_format_id, o.delivery_name, o.delivery_company, o.delivery_house, o.delivery_street, o.delivery_district, o.delivery_town, o.delivery_county, o.delivery_postcode, o.delivery_state, o.delivery_country, o.delivery_address_format_id, o.payment_method, o.cc_ctype, o.currency, o.currency_value, o.date_purchased, o.orders_status, o.last_modified, o.customers_comments, o.products_delivery_date, o.tracking_number, o.stock_deducted, o.invoice_date, o.deposit_value, c.customers_firstname, c.customers_lastname, o.customers_sap_county, o.delivery_sap_county, o.ip_number from " . DS_DB_SHOP . ".orders o left join " . DS_DB_SHOP . ".customers c on (o.customers_id = c.customers_id) where o.orders_id = '" . (int)$order_id . "'");
      $order = dsf_db_fetch_array($order_query);

      $totals_query = dsf_db_query("select title, text, value, class from " . DS_DB_SHOP . ".orders_total where orders_id = '" . (int)$order_id . "' order by sort_order");
      while ($totals = dsf_db_fetch_array($totals_query)) {
        $this->totals[] = array('title' => $totals['title'],
                                'text' => $totals['text'],
                                'value' => $totals['value'],
								'class' => $totals['class']
								);
      }

      $order_total_query = dsf_db_query("select text, value from " . DS_DB_SHOP . ".orders_total where orders_id = '" . (int)$order_id . "' and class = 'ot_total'");
      $order_total = dsf_db_fetch_array($order_total_query);

      $shipping_method_query = dsf_db_query("select title, value from " . DS_DB_SHOP . ".orders_total where orders_id = '" . (int)$order_id . "' and class = 'ot_shipping'");
      $shipping_method = dsf_db_fetch_array($shipping_method_query);

      $order_status_query = dsf_db_query("select orders_status_name, customer_status_name from " . DS_DB_LANGUAGE . ".orders_status where orders_status_id = '" . $order['orders_status'] . "' and unit_id='" . $dsv_master_select_unit . "'");
      $order_status = dsf_db_fetch_array($order_status_query);



		// make valid postcodes
	  if (defined('CONTENT_COUNTRY') && CONTENT_COUNTRY == 'GB'){
			
		  // we format for UK .
		  
		
				$cpost_start = str_replace(" ","",$order['customers_postcode']);
				if (strlen($cpost_start) >1){
						$last_three = substr($cpost_start, -3, 3);
						$first_chrs = substr($cpost_start, 0, strlen($cpost_start) -3);
						$new_customer_postcode = strtoupper($first_chrs . ' ' . $last_three);
				}else{
					$new_customer_postcode = strtoupper($cpost_start);
				}
				
				$cpost_start = str_replace(" ","",$order['delivery_postcode']);
				if (strlen($cpost_start) >1){
						$last_three = substr($cpost_start, -3, 3);
						$first_chrs = substr($cpost_start, 0, strlen($cpost_start) -3);
						$new_delivery_postcode = strtoupper($first_chrs . ' ' . $last_three);
				}else{
					$new_delivery_postcode = strtoupper($cpost_start);
				}
			
	  }elseif (defined('CONTENT_COUNTRY') && CONTENT_COUNTRY == 'DE'){


			// germany override
		  	// we remove any possible spaces from the postcodes.
			
					$new_customer_postcode = str_replace(" ", "", $order['customers_postcode']);
					$new_delivery_postcode = str_replace(" ", "", $order['delivery_postcode']);

	  }elseif (defined('CONTENT_COUNTRY') && CONTENT_COUNTRY == 'IT'){


			// Italy override
		  	// we remove any possible spaces from the postcodes.
			
					$new_customer_postcode = str_replace(" ", "", $order['customers_postcode']);
					$new_delivery_postcode = str_replace(" ", "", $order['delivery_postcode']);

	  }else{
		  
		// if it is not defined or not one of the above,  then we let it go through the way it is.
		
					$new_customer_postcode = $order['customers_postcode'];
					$new_delivery_postcode = $order['delivery_postcode'];

	  }






      $this->info = array('id' => $order['orders_id'],
	  					   'currency' => $order['currency'],
                          'currency_value' => $order['currency_value'],
                          'payment_method' => $order['payment_method'],
                           'cc_ctype' => $order['cc_ctype'],
                         'date_purchased' => $order['date_purchased'],
                          'orders_status' => $order_status['orders_status_name'],
                          'customer_orders_status' => $order_status['customer_status_name'],
                          'last_modified' => $order['last_modified'],
                          'products_delivery_date' => $order['products_delivery_date'],
                          'tracking_number' => $order['tracking_number'],
                          'total' => strip_tags($order_total['text']),
                          'total_value' => number_format(strip_tags($order_total['value']),2,'.',''),
						  'shipping_method' => ((substr($shipping_method['title'], -1) == ':') ? substr(strip_tags($shipping_method['title']), 0, -1) : strip_tags($shipping_method['title'])),
						  'customers_comments' => $order['customers_comments'],
						  'stock_deducted' => $order['stock_deducted'],
						  'invoice_date' => $order['invoice_date'],
						  'ip_number' => $order['ip_number'],
						  'deposit_value' => $order['deposit_value']
						  );

      $this->customer = array('id' => $order['customers_id'],
                              'name' => $order['customers_name'],
                              'firstname' => $order['customers_firstname'],
                              'lastname' => $order['customers_lastname'],
							  'company' => $order['customers_company'],
                              'house' => $order['customers_house'],
                              'street' => $order['customers_street'],
                              'district' => $order['customers_district'],
                              'town' => $order['customers_town'],
                              'county' => $order['customers_county'],
							  'county_code' => $order['customers_sap_county'],
                              'postcode' => $new_customer_postcode,
                              'state' => $order['customers_state'],
                              'country' => $order['customers_country'],
                              'format_id' => $order['customers_address_format_id'],
                              'telephone' => $order['customers_telephone'],
                              'email_address' => $order['customers_email_address']);

      $this->delivery = array('name' => $order['delivery_name'],
                              'company' => $order['delivery_company'],
                              'house' => $order['delivery_house'],
                              'street' => $order['delivery_street'],
                              'district' => $order['delivery_district'],
                              'town' => $order['delivery_town'],
                              'county' => $order['delivery_county'],
							  'county_code' => $order['delivery_sap_county'],
                              'postcode' => $new_delivery_postcode,
                              'state' => $order['delivery_state'],
                              'country' => $order['delivery_country'],
                              'format_id' => $order['delivery_address_format_id']);

      if (empty($this->delivery['name']) && empty($this->delivery['street_address'])) {
        $this->delivery = false;
      }


      $index = 0;
      $orders_products_query = dsf_db_query("select orders_products_id, products_id, warranty_id, parts_id, products_name, products_model, products_price, products_tax, products_quantity, final_price, products_deposit, additional_carriage, shipping_latency, products_sku from " . DS_DB_SHOP . ".orders_products where orders_id = '" . (int)$order_id . "'");
      while ($orders_products = dsf_db_fetch_array($orders_products_query)) {
        $this->products[$index] = array('qty' => $orders_products['products_quantity'],
	                                'id' => $orders_products['products_id'],
									'parts_id' => $orders_products['parts_id'],
										'products_id' => $orders_products['products_id'],
                                        'warranty' => $orders_products['warranty_id'],
                                        'alt_id' => $orders_products['bracket_id'],
                                        'name' => $orders_products['products_name'],
                                        'model' => $orders_products['products_model'],
                                        'tax' => $orders_products['products_tax'],
                                        'price' => $orders_products['products_price'],
                                        'final_price' => $orders_products['final_price'],
                                        'products_deposit' => $orders_products['products_deposit'],
                                        'additional_carriage' => $orders_products['additional_carriage'],
                                        'shipping_latency' => $orders_products['shipping_latency'],
                                        'products_sku' => $orders_products['products_sku']
										);

        $subindex = 0;
        $attributes_query = dsf_db_query("select products_options, products_options_values, option_id, value_id, options_values_price, price_prefix from " . DS_DB_SHOP . ".orders_products_attributes where orders_id = '" . (int)$order_id . "' and orders_products_id = '" . (int)$orders_products['orders_products_id'] . "'");
        if (dsf_db_num_rows($attributes_query)) {
          while ($attributes = dsf_db_fetch_array($attributes_query)) {
            $this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options'],
                                                                     'option_id' => $attributes['option_id'],
                                                                     'value_id' => $attributes['value_id'],
                                                                     'value' => $attributes['products_options_values'],
                                                                     'prefix' => $attributes['price_prefix'],
                                                                     'price' => $attributes['options_values_price']);

            $subindex++;
          }
        }

        $this->info['tax_groups']["{$this->products[$index]['tax']}"] = '1';

        $index++;
      }
    }


    function cart() {
      global $customer_id,  $basket, $currency, $currencies, $shipping, $payment, $payment_details;

      $this->content_type = $basket->get_content_type();

      $customer_address_query = dsf_db_query("select c.customers_firstname, c.customers_lastname, c.customers_telephone, c.customers_email_address, ca.invoice_company, ca.invoice_name, ca.invoice_house, ca.invoice_street, ca.invoice_district, ca.invoice_town, ca.invoice_county, ca.invoice_sap_county, ca.invoice_postcode, ca.invoice_country from " . DS_DB_SHOP . ".customers c left join " . DS_DB_SHOP . ".customers_addresses ca on (c.customers_id = ca.customers_id) where c.customers_id = '" . (int)$customer_id . "'");
  //    $customer_address_query = dsf_db_query("select c.customers_firstname, c.customers_lastname, c.customers_telephone, c.customers_email_address, ca.invoice_company, ca.invoice_name, ca.invoice_house, ca.invoice_street, ca.invoice_district, ca.invoice_town, ca.invoice_county, ca.invoice_postcode, ca.invoice_country from " . TABLE_CUSTOMERS . " c, " . TABLE_CUSTOMERS_ADDRESSES . " ca where c.customers_id = ca.customers_id and c.customers_id = '" . (int)$customer_id . "'");
      $customer_address = dsf_db_fetch_array($customer_address_query);
		$customer_address['invoice_country'] = dsf_get_country_name($customer_address['invoice_country']);
	
      $shipping_address_query = dsf_db_query("select c.customers_firstname, c.customers_lastname, c.customers_telephone, c.customers_email_address, ca.delivery_name, ca.delivery_company, ca.delivery_house, ca.delivery_street, ca.delivery_district, ca.delivery_town, ca.delivery_county, ca.delivery_sap_county, ca.delivery_postcode, ca.delivery_country from " . DS_DB_SHOP . ".customers c left join " . DS_DB_SHOP . ".customers_addresses ca on (c.customers_id = ca.customers_id)where c.customers_id = '" . (int)$customer_id . "'");
      $shipping_address = dsf_db_fetch_array($shipping_address_query);
		$shipping_address['delivery_country'] = dsf_get_country_name($shipping_address['delivery_country']);
      

      $this->info = array('order_status' => DEFAULT_ORDERS_STATUS_ID,
                          'currency' => $currency,
                          'currency_value' => $currencies->currencies[$currency]['value'],
                          'payment_method' => $payment,
                          'payment_type' => (isset($payment_details['cc_save']) ? $payment_details['cc_save'] : '0'),
						  'shipping_method' => $shipping['title'],
                          'shipping_cost' => $shipping['cost'],
                          'subtotal' => 0,
                          'subtotal_nett' => 0,
                          'comments' => (isset($GLOBALS['comments']) ? $GLOBALS['comments'] : ''),
                          'products_delivery_date' => (isset($GLOBALS['products_delivery_date']) ? $GLOBALS['products_delivery_date'] : ''),
                          'tracking_number' => (isset($GLOBALS['tracking_number']) ? $GLOBALS['tracking_number'] : ''),
                          'customers_comments' => (isset($GLOBALS['comments']) ? $GLOBALS['comments'] : ''),
						  'additional_delivery' => 0,
						  'total_deposit' => 0
						  );

      if (isset($GLOBALS[$payment]) && is_object($GLOBALS[$payment])) {
        $this->info['payment_method'] = $GLOBALS[$payment]->title;

        if ( isset($GLOBALS[$payment]->order_status) && is_numeric($GLOBALS[$payment]->order_status) && ($GLOBALS[$payment]->order_status > 0) ) {
          $this->info['order_status'] = $GLOBALS[$payment]->order_status;
        }
      }

      $this->customer = array('firstname' => $customer_address['customers_firstname'],
                              'lastname' => $customer_address['customers_lastname'],
                              'name' => $customer_address['invoice_name'],
                              'company' => $customer_address['invoice_company'],
                              'house' => $customer_address['invoice_house'],
                              'street' => $customer_address['invoice_street'],
                              'district' => $customer_address['invoice_district'],
                              'town' => $customer_address['invoice_town'],
                              'county' => $customer_address['invoice_county'],
                              'county_code' => $customer_address['invoice_sap_county'],
                              'country' => $customer_address['invoice_country'],
                              'postcode' => $customer_address['invoice_postcode'],
                              'format_id' => '1',
                              'telephone' => $customer_address['customers_telephone'],
                              'email_address' => $customer_address['customers_email_address']);

      $this->delivery = array('firstname' => $customer_address['customers_firstname'],
                              'lastname' => $customer_address['customers_lastname'],
							  'name' => $shipping_address['delivery_name'],
                              'company' => $shipping_address['delivery_company'],
                              'house' => $shipping_address['delivery_house'],
                              'street' => $shipping_address['delivery_street'],
                              'district' => $shipping_address['delivery_district'],
                              'town' => $shipping_address['delivery_town'],
                              'county' => $shipping_address['delivery_county'],
                              'county_code' => $shipping_address['delivery_sap_county'],
                              'postcode' => $shipping_address['delivery_postcode'],
                              'country' => $shipping_address['delivery_country'],
                              'format_id' => '1');


      $index = 0;
      $products = $basket->get_products();
      for ($i=0, $n=sizeof($products); $i<$n; $i++) {
        $this->products[$index] = array('qty' => $products[$i]['quantity'],
                                        'warranty' => $products[$i]['warranty'],
										'parts_id' => $products[$i]['parts_id'],
                                         'alt_id' => $products[$i]['alt_id'],
                                       'name' => $products[$i]['name'],
                                        'model' => $products[$i]['model'],
                                        'tax' => dsf_get_tax_rate($products[$i]['tax_class_id']),
                                        'tax_description' => dsf_get_tax_description($products[$i]['tax_class_id']),
                                        'price' => $products[$i]['price'],
                                        'final_price' => $products[$i]['price'] + $basket->attributes_price($products[$i]['id']),
                                        'weight' => $products[$i]['weight'],
                                        'products_deposit' => $products[$i]['products_deposit'],
                                        'additional_carriage' => $products[$i]['additional_carriage'],
                                        'shipping_latency' => $products[$i]['shipping_latency'],
                                        'fixed_carriage' => $products[$i]['fixed_carriage'],
                                        'apply_fixed_carriage' => $products[$i]['apply_fixed_carriage'],
                                        'id' => $products[$i]['id']);

        if ($products[$i]['attributes']) {
          $subindex = 0;
          reset($products[$i]['attributes']);
          while (list($option, $value) = each($products[$i]['attributes'])) {
            $attributes_query = dsf_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix from " . DS_DB_SHOP . ".products_options popt, " . DS_DB_SHOP . ".products_options_values poval, " . DS_DB_SHOP . ".products_attributes pa where pa.products_id = '" . (int)$products[$i]['id'] . "' and pa.options_id = '" . (int)$option . "' and pa.options_id = popt.products_options_id and pa.options_values_id = '" . (int)$value . "' and pa.options_values_id = poval.products_options_values_id");
            $attributes = dsf_db_fetch_array($attributes_query);

            $this->products[$index]['attributes'][$subindex] = array('option' => $attributes['products_options_name'],
                                                                     'value' => $attributes['products_options_values_name'],
                                                                     'option_id' => $option,
                                                                     'value_id' => $value,
                                                                     'prefix' => $attributes['price_prefix'],
                                                                     'price' => $attributes['options_values_price']);

            $subindex++;
          }
        }
        
		$this->info['subtotal_nett'] += ($this->products[$index]['final_price'] * $this->products[$index]['qty']);

		$this->info['total_deposit'] += dsf_add_tax($this->products[$index]['products_deposit'], $this->products[$index]['tax']) * $this->products[$index]['qty'];
		$this->info['additional_delivery'] += ($this->products[$index]['additional_carriage'] * $this->products[$index]['qty']);

		
        $shown_price = dsf_add_tax($this->products[$index]['final_price'], $this->products[$index]['tax']) * $this->products[$index]['qty'];
        $this->info['subtotal'] += $shown_price;

        $products_tax = $this->products[$index]['tax'];
        $products_tax_description = $this->products[$index]['tax_description'];
        if (DISPLAY_PRICE_WITH_TAX == 'true') {
          $this->info['tax'] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
          if (isset($this->info['tax_groups']["$products_tax_description"])) {
            $this->info['tax_groups']["$products_tax_description"] += $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
          } else {
            $this->info['tax_groups']["$products_tax_description"] = $shown_price - ($shown_price / (($products_tax < 10) ? "1.0" . str_replace('.', '', $products_tax) : "1." . str_replace('.', '', $products_tax)));
          }
        } else {
          $this->info['tax'] += ($products_tax / 100) * $shown_price;
          if (isset($this->info['tax_groups']["$products_tax_description"])) {
            $this->info['tax_groups']["$products_tax_description"] += ($products_tax / 100) * $shown_price;
          } else {
            $this->info['tax_groups']["$products_tax_description"] = ($products_tax / 100) * $shown_price;
          }
        }

        $index++;
      }

      if (DISPLAY_PRICE_WITH_TAX == 'true') {
        $this->info['total'] = $this->info['subtotal'] + $this->info['shipping_cost'];
      } else {
        $this->info['total'] = $this->info['subtotal'] + $this->info['tax'] + $this->info['shipping_cost'];
      }
   
   
    }
  }
  
  
  
  
// ###################################################################################################

class order_total {
    var $modules;

    function order_total() {

      if (defined('MODULE_ORDER_TOTAL_INSTALLED') && dsf_not_null(MODULE_ORDER_TOTAL_INSTALLED)) {
        $this->modules = explode(';', MODULE_ORDER_TOTAL_INSTALLED);

        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          include(DS_PROGRAM_MODULES . 'order_total/' . $value);

          $class = substr($value, 0, strrpos($value, '.'));
          $GLOBALS[$class] = new $class;
        }
      }
    }

    function process() {
      $order_total_array = array();
      if (is_array($this->modules)) {
        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if ($GLOBALS[$class]->enabled) {
            $GLOBALS[$class]->process();

            for ($i=0, $n=sizeof($GLOBALS[$class]->output); $i<$n; $i++) {
              if (dsf_not_null($GLOBALS[$class]->output[$i]['title']) && dsf_not_null($GLOBALS[$class]->output[$i]['text'])) {
                $order_total_array[] = array('code' => $GLOBALS[$class]->code,
                                             'title' => $GLOBALS[$class]->output[$i]['title'],
                                             'text' => $GLOBALS[$class]->output[$i]['text'],
                                             'value' => number_format(dsf_round($GLOBALS[$class]->output[$i]['value'],2),2,'.',''),
                                             'sort_order' => $GLOBALS[$class]->sort_order);
              }
            }
          }
        }
      }

      return $order_total_array;
    }

    function output() {
      $output_string = '';
      if (is_array($this->modules)) {
        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if ($GLOBALS[$class]->enabled) {
            $size = sizeof($GLOBALS[$class]->output);
            for ($i=0; $i<$size; $i++) {
              $output_string .= '              <tr>' . "\n" .
                                '                <td align="right" class="main">' . $GLOBALS[$class]->output[$i]['title'] . '</td>' . "\n" .
                                '                <td align="right" class="main">' . $GLOBALS[$class]->output[$i]['text'] . '</td>' . "\n" .
                                '              </tr>';
            }
          }
        }
      }

      return $output_string;
    }

    function conoutput() {
      $output_string = '';
	  $output_string = array();
	  
      if (is_array($this->modules)) {
        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if ($GLOBALS[$class]->enabled) {
            $size = sizeof($GLOBALS[$class]->output);
            for ($i=0; $i<$size; $i++) {
	
				if($GLOBALS[$class]->output[$i]['title'] == 'Sub Total:'){
					// do nothing not shown on customer side.
				}
				
				 elseif(($GLOBALS[$class]->output[$i]['title'] == 'VAT:') && (DISPLAY_PRICE_WITH_TAX =='true')) {
					if(CHECKOUT_SHOW_VAT_INCLUSIVE_LINE =='true'){
					$output_string[1] ='<tr><td colspan="2" class="main" height="25" align="center"><b>These values include VAT charged at ' . dsf_tax_text(dsf_get_default_vat_rate()) . '% to a total value of ' . $GLOBALS[$class]->output[$i]['text'] .'</b></td></tr>';
					}else{
					$output_string[1] ='<tr><td colspan="2" class="main" height="25" align="left">&nbsp;</td></tr>';
					}
				
				}elseif($GLOBALS[$class]->output[$i]['title'] == 'Discount:') {
				  $output_string[0] .= '              <tr>' . "\n" .
									'                <td align="right" class="discount">' . $GLOBALS[$class]->output[$i]['title'] . '</td>' . "\n" .
									'                <td align="right" class="discount">' . $GLOBALS[$class]->output[$i]['text'] . '</td>' . "\n" .
									'              </tr>';
				}else{
				  $output_string[0] .= '              <tr>' . "\n" .
									'                <td align="right" class="main">' . $GLOBALS[$class]->output[$i]['title'] . '</td>' . "\n" .
									'                <td align="right" class="main">' . $GLOBALS[$class]->output[$i]['text'] . '</td>' . "\n" .
									'              </tr>';

				}
            }
          }
        }
      }

      return $output_string;
    }




    function marcoconoutput() {
      $output_string = '';
	  $output_string = array();
	  
      if (is_array($this->modules)) {
        reset($this->modules);
        while (list(, $value) = each($this->modules)) {
          $class = substr($value, 0, strrpos($value, '.'));
          if ($GLOBALS[$class]->enabled) {
            $size = sizeof($GLOBALS[$class]->output);
            for ($i=0; $i<$size; $i++) {
	
				if($GLOBALS[$class]->output[$i]['title'] == 'Sub Total:'){
					// do nothing not shown on customer side.
				}
				
				 elseif(($GLOBALS[$class]->output[$i]['title'] == 'VAT:') && (DISPLAY_PRICE_WITH_TAX =='true')) {
					if(CHECKOUT_SHOW_VAT_INCLUSIVE_LINE =='true'){
					$output_string[1] ='<tr><td colspan="4" class="main" height="25" align="center"><b>These values include VAT charged at ' . dsf_tax_text(dsf_get_default_vat_rate()) . '% to a total value of ' . $GLOBALS[$class]->output[$i]['text'] .'</b></td></tr>';
					}else{
					$output_string[1] ='';
					}
				
				}elseif($GLOBALS[$class]->output[$i]['title'] == 'Discount:') {
				  $output_string[0] .= '              <tr>' . "\n" .
									'                <td colspan="3" class="basketQuantityDiscount">' . $GLOBALS[$class]->output[$i]['title'] . '</td>' . "\n" .
									'                <td align="right" class="discount">' . $GLOBALS[$class]->output[$i]['text'] . '</td>' . "\n" .
									'              </tr>';
				}else{
				  $output_string[0] .= '              <tr>' . "\n" .
									'                <td colspan="3" class="basketQuantitySide">' . $GLOBALS[$class]->output[$i]['title'] . '</td>' . "\n" .
									'                <td align="right" class="main">' . $GLOBALS[$class]->output[$i]['text'] . '</td>' . "\n" .
									'              </tr>';

				}
            }
          }
        }
      }

      return $output_string;
    }




  }


?>
