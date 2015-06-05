<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.


// currently only ran from ds_api.php



class credit {
    var $info, $totals, $products, $customer, $delivery, $content_type;

    function credit($credit_id = '') {
      $this->info = array();
      $this->totals = array();
      $this->products = array();
      $this->customer = array();
      $this->delivery = array();

      if (dsf_not_null($credit_id)) {
        $this->query($credit_id);
      }
    }

    function query($credit_id) {

      $credit_id = dsf_db_prepare_input($credit_id);

      $order_query = dsf_db_query("select * from " . DS_DB_SHOP . ".credits where credits_id = '" . (int)$credit_id . "'");
      $order = dsf_db_fetch_array($order_query);

      $totals_query = dsf_db_query("select title, text, value, class from " . DS_DB_SHOP . ".credits_total where credits_id = '" . (int)$credit_id . "' order by sort_order");
      while ($totals = dsf_db_fetch_array($totals_query)) {
        $this->totals[] = array('title' => $totals['title'],
                                'text' => $totals['text'],
                                'value' => $totals['value'],
								'class' => $totals['class']
								);
      }

      $order_total_query = dsf_db_query("select text, value from " . DS_DB_SHOP . ".credits_total where credits_id = '" . (int)$credit_id . "' and class = 'ot_total'");
      $order_total = dsf_db_fetch_array($order_total_query);


      $this->info = array('id' => $order['credits_id'],
	  					   'orders_id' => $order['orders_id'],
	  					   'currency' => $order['currency'],
                          'currency_value' => $order['currency_value'],
                          'payment_method' => $order['payment_method'],
                          'cc_ctype' => $order['cc_ctype'],
                          'date_purchased' => $order['date_purchased'],
                          'last_modified' => $order['last_modified'],
                          'total' => strip_tags($order_total['text']),
                          'total_value' => number_format(strip_tags($order_total['value']),2,'.','')
						  );

      $this->customer = array('id' => $order['customers_id'],
                              'name' => $order['customers_name'],
							  'company' => $order['customers_company'],
                              'house' => $order['customers_house'],
                              'street' => $order['customers_street'],
                              'district' => $order['customers_district'],
                              'town' => $order['customers_town'],
                              'county' => $order['customers_county'],
							  'county_code' => $order['customers_sap_county'],
                              'postcode' => $order['customers_postcode'],
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
                              'postcode' => $order['delivery_postcode'],
                              'state' => $order['delivery_state'],
                              'country' => $order['delivery_country'],
                              'format_id' => $order['delivery_address_format_id']);

      if (empty($this->delivery['name']) && empty($this->delivery['street_address'])) {
        $this->delivery = false;
      }


      $index = 0;
      $orders_products_query = dsf_db_query("select * from " . DS_DB_SHOP . ".credits_products where credits_id = '" . (int)$credit_id . "'");
      while ($orders_products = dsf_db_fetch_array($orders_products_query)) {
        $this->products[$index] = array('qty' => $orders_products['products_quantity'],
	                                'id' => $orders_products['products_id'],
                                        'warranty' => $orders_products['warranty_id'],
                                        'alt_id' => $orders_products['bracket_id'],
                                        'name' => $orders_products['products_name'],
                                        'model' => $orders_products['products_model'],
                                        'tax' => $orders_products['products_tax'],
                                        'price' => $orders_products['products_price'],
                                        'final_price' => $orders_products['final_price'],
                                        'products_deposit' => $orders_products['products_deposit'],
                                        'additional_carriage' => $orders_products['additional_carriage'],
                                        'shipping_latency' => $orders_products['shipping_latency']
										);


        $this->info['tax_groups']["{$this->products[$index]['tax']}"] = '1';

        $index++;
      }
    }


  }
  
  
  
?>