<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



// currently only ran from ds_api.php


// ### CREATE CREDIT  ### //   Returns a credit Number
function dsf_create_fixed_credit_note($dsv_order=0, $savedorder='', $dsv_refund_reason='', $dsv_refund_value=0) {
global $currencies;

	// dsv_order = an order number to allocate the credit to.
	// order = an order class object - this is required.
	// dsv_refund_reason - the static reason to put inside the product line to say why we are creating the credit.
	// dsv_refund_value - the actual amount (including vat) to raise the credit for.
	
	

						  $sql_data_array = array('orders_id' => $dsv_order,
						  						  'customers_id' => $savedorder->customer['id'],
												  'customers_name' => $savedorder->customer['name'],
												  'customers_company' => $savedorder->customer['company'],
												  'customers_house' => $savedorder->customer['house'],
												  'customers_street' => $savedorder->customer['street'],
												  'customers_district' => $savedorder->customer['district'],
												  'customers_town' => $savedorder->customer['town'],
												  'customers_county' => $savedorder->customer['county'],
												  'customers_sap_county' => $savedorder->customer['county_code'],
												  'customers_postcode' => $savedorder->customer['postcode'], 
												  'customers_state' => $savedorder->customer['state'], 
												  'customers_country' => $savedorder->customer['country']['title'], 
												  'customers_telephone' => $savedorder->customer['telephone'], 
												  'customers_email_address' => $savedorder->customer['email_address'],
												  'customers_address_format_id' => $savedorder->customer['format_id'], 
												  'delivery_name' => $savedorder->delivery['name'], 
												  'delivery_company' => $savedorder->delivery['company'],
												  'delivery_house' => $savedorder->delivery['house'], 
												  'delivery_street' => $savedorder->delivery['street'], 
												  'delivery_district' => $savedorder->delivery['district'], 
												  'delivery_town' => $savedorder->delivery['town'], 
												  'delivery_county' => $savedorder->delivery['county'], 
												  'delivery_sap_county' => $savedorder->delivery['county_code'], 
												  'delivery_postcode' => $savedorder->delivery['postcode'], 
												  'delivery_state' => $savedorder->delivery['state'], 
												  'delivery_country' => $savedorder->delivery['country'], 
												  'delivery_address_format_id' => $savedorder->delivery['format_id'], 
												  'payment_method' => $savedorder->info['payment_method'], 
                          						  'cc_ctype' => $savedorder->info['cc_ctype'],
												  'date_purchased' => 'now()', 
												  'currency' => $savedorder->info['currency'], 
												  'currency_value' => $savedorder->info['currency_value']
												   );
						  dsf_db_perform(DS_DB_SHOP .'.credits', $sql_data_array);
						  $insert_id = dsf_db_insert_id();
						 
						 
						 // calculate totals.
						 $gross_total = $dsv_refund_value;
						 $net_total = round(($dsv_refund_value / (100 + dsf_get_default_vat_rate())) * 100 , 4);
						 $vat_total = round((float)$gross_total - (float)$net_total , 2);
						 
						 // save the credit totals.
						 
							// subtotal we are including vat with these therefore it would be the same as gross total.
							$sql_data_array = array('credits_id' => $insert_id,
													'title' => 'Sub Total',
													'text' => $currencies->format($gross_total),
													'value' => $gross_total, 
													'class' => 'ot_subtotal', 
													'sort_order' => 1);
							dsf_db_perform(DS_DB_SHOP .'.credits_total', $sql_data_array);
						 
						 
						// vat 
							$sql_data_array = array('credits_id' => $insert_id,
													'title' => 'VAT',
													'text' => $currencies->format($vat_total),
													'value' => $vat_total, 
													'class' => 'ot_tax', 
													'sort_order' => 2);
							dsf_db_perform(DS_DB_SHOP .'.credits_total', $sql_data_array);


						// total
							$sql_data_array = array('credits_id' => $insert_id,
													'title' => 'Total',
													'text' => $currencies->format($gross_total),
													'value' => $gross_total, 
													'class' => 'ot_total', 
													'sort_order' => 3);
							dsf_db_perform(DS_DB_SHOP .'.credits_total', $sql_data_array);
						 
						 

						// the credit reason.
						
							$sql_data_array = array('credits_id' => $insert_id, 
													'products_id' => 0, 
													'warranty_id' => 0, 
													'products_model' => '', 
													'products_name' => $dsv_refund_reason, 
													'products_price' => $net_total, 
													'final_price' => $net_total, 
													'products_tax' => dsf_get_default_vat_rate(), 
													'products_quantity' => 1,
													'products_deposit' => 0,
													'additional_carriage' => 0,
													'shipping_latency' => 0
													);
							dsf_db_perform(DS_DB_SHOP .'.credits_products', $sql_data_array);
							$credit_products_id = dsf_db_insert_id();
						

return $insert_id;

} // end function creating fixed priced credit

?>