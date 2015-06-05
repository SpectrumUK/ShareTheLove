<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.




/*

1. house number
2. Street name
3. Locality
4. Region
5. postal code
6. country

FROM HERE IT IS ALL DEFAULT PARAMETERS
7. origin: address doctor pdf - page 13    COO_DEU
8. withhn: address doctor pdf - page 13	   false
9. countrytype: pdf page 14                NAME_DE
10. lineseperator pdf page 15			   LST_LF	
11. preferland pdf page 15/16			   PFL_DATABASE
12. capital pdf page 16					   NO_CHANGE
13. formatwithorg pdf page 17			   false
14. parseinput pdf page 18				   NEVER
15. removediacretic pdf page 19			   false

*/
function dsf_get_address_doctor_address($housenumber = '', $streetname = '', $locality = '', $region = '', $postal_code = '',   $withhn = 'false', $lineseperator = 'LST_LF', $preferlang = 'PFL_DATABASE', $capital = 'NO_CHANGE', $formatwithorg = 'false', $parseinput = 'NEVER', $removediacretic = 'false'){
	
$origin = ADDRESS_DOCTOR_ORIGIN;
$countrytype = ADDRESS_DOCTOR_COUNTRY_TYPE;
$country = ADDRESS_DOCTOR_COUNTRY;

	
	
	$message = '';
	$send_mail = 'false';
	/*
	
	1.  First we need the soap built with the information we have captured from the customer
	2.  From this we build the headers
	3.  Then send the curl
	4.  If we have a value in the results count we need to find out how many for the loop to get house numbers
	5.  Loop through the house numbers, exploding on the '-' as we get ranged (perhaps for odd and even, but the less information you give the more clouded it gets)
	6.  Put all unique possibilities into an array
	7.  pull all house numbers from array, and then build a return array based on house number with the address elements captured.
	
	*/
	
	
	##### 1.  Build the soap for sending to address doctor
	$thesoap = dsf_get_address_doctor_soap($housenumber, $streetname, $locality, $region, $postal_code, $country, ADDRESS_DOCTOR_USERNAME, ADDRESS_DOCTOR_PASSWORD, $origin, $withhn, $countrytype, $lineseperator, $preferlang, $capital, $formatwithorg, $parseinput, $removediacretic);
	
//	echo $thesoap;
	
	if (strlen($thesoap) > 0){
		
		##### 2.  If we have received a string from the call then we can get the headers to do the curl to address doctor.
		$soap_headers = dsf_get_address_doctor_soap_headers($thesoap);
		 
		 // before we contrinue, the headers must be an array.
		if (is_array($soap_headers)){
			
			
			#### 3.  Pass both to the function to get data back from Address Doctor
			$add_doc_curl = dsf_get_address_doctor_curl_response($thesoap, $soap_headers);
			
			
			### 4.  The response should contain a number for how many responses we have had and the curl response needs to be 0  
			if ($add_doc_curl['curlerrno'] == 0 && isset($add_doc_curl['thedata']->Body->ValidateResponse->ValidateResult->ResultCount)){
			$total_results = $add_doc_curl['thedata']->Body->ValidateResponse->ValidateResult->ResultCount;
				
				
				
				// if we do have a number of responses we need to pull the data from the response
				$all_data = $add_doc_curl['thedata'];
				
				
				### 5.  Now we need to get the housenumbers
				
				
				// if we only have 1 return then we shouldnt explode, as it will only contain 1 number   	
																											
				if ($total_results == 1){
					$house_numbers[] = 	$housenumber; 




				} else {
				
				
				
					// if there is more than 1 i have assumed there will be a - seperator.
							$house_numbers = array();
							
							// each - has a range of numbers, which are needed to return the addresses to choose from.  The following will pick out the start and end point from each return
							for ($i = 0; $i < $total_results; $i++){
								
								
								
								$xml_house_numbers = $all_data->Body->ValidateResponse->ValidateResult->Results->Result->$i->Address->HouseNumber;
								$range_array = explode('-', $xml_house_numbers);
								$from = $range_array[0];
								$to = $range_array[1];
								
								### 6.  we now need to see if the array already contains that number, so if its not already in the array we add it.  This is because we could have house number ranges e.g. 1-11 2-10
								
								for ($n = $from; $n < $to + 1;$n++){
									if (!in_array($n, $house_numbers)){
										
										$house_numbers[] = $n;
									} else {
										// do nothing becuase we already have it	in the array
									}
									
									
									
								} // end for
								
		
							} // end for
				}
			
				
				
				### 7. To make the return all of the address details are required 
				
				
				// THE STRET NAME
				
				if (isset($all_data->Body->ValidateResponse->ValidateResult->Results->Result->ResultPercentage)){
				$highest_percentage = $all_data->Body->ValidateResponse->ValidateResult->Results->Result->ResultPercentage;
				} else {
					$highest_percentage = 0;
					
				}
				
				if (isset($all_data->Body->ValidateResponse->ValidateResult->Results->Result->ValidationStatus)){
				$highest_percentage = $all_data->Body->ValidateResponse->ValidateResult->Results->Result->Result->ValidationStatus;
				} else {
					$validation_status = '';
					
				}
				if (isset($all_data->Body->ValidateResponse->ValidateResult->Results->Result->Address->Street)){
					
			   		 $street = $all_data->Body->ValidateResponse->ValidateResult->Results->Result->Address->Street;
				} else {
					
					$street = '';
				}
				
				// LOCALITY  E.G. ESSEN
				if (isset($all_data->Body->ValidateResponse->ValidateResult->Results->Result->Address->Locality)){
					
        			$locality = $all_data->Body->ValidateResponse->ValidateResult->Results->Result->Address->Locality;
					
				} else {
					
					$locality = '';	
				}
        		
				// POSTAL CODE
				if (isset($all_data->Body->ValidateResponse->ValidateResult->Results->Result->Address->PostalCode)){
					
				$post_code = $all_data->Body->ValidateResponse->ValidateResult->Results->Result->Address->PostalCode;
				
				} else {
					
					$post_code = '';
					
				}
				
				//COUNTRY
				if (isset($all_data->Body->ValidateResponse->ValidateResult->Results->Result->Address->Country)){
					
       			$country = $all_data->Body->ValidateResponse->ValidateResult->Results->Result->Address->Country;
				
				} else {
					
					$country = '';
					
				}
				
				// PROVINCE E.G. NORTH RHINE-WESTPHALIA
				if (isset($all_data->Body->ValidateResponse->ValidateResult->Results->Result->Address->Province)){
					
       			$province = $all_data->Body->ValidateResponse->ValidateResult->Results->Result->Address->Province;
				
				} else {
					
					$province = '';
					
				}
				$return_addresses = array();
				$return_addresses['highestpercentage'] = $highest_percentage . '%';
				$return_addresses['validationstatus'] = $validation_status;
				$return_addresses['totalhousenumbers'] = (int)sizeof($house_numbers);
				$return_addresses['full_array'] = $all_data;
					// build an array for each of the house numbers and street details.  Becuase the house numbers are all for a street name, we can use the first entry.
					foreach ($house_numbers as $number){
						
						// we should no longer need to decode anything (that puts it back to latin therefore function changed.
						
						$return_addresses['addresses'][] = array('streetname' => $street,
													'housenumber' => $number,
													'locality' => $locality,
													'province' => $province,
													'postcode' => $post_code,
													'country' => $country);
						
						
						
					}
				
				return $return_addresses;
			} 
			
			
		} else {
			
			// SOAP HEADERS ERROR MAIL IS TRUE
			$message .= 'malformed headers ' . dsf_print_array($headers) . '<br/>' . dsf_print_array($all_data) . '<br />';
			$send_message = 'true';
		}
		
	} else {
		
		// SOAP ERROR EMAIL IS TRUE
		
		$message .= 'soap string is incorrect' . $thesoap . '<br/>' . dsf_print_array($all_data) . '<br />';
		$send_message = 'true';
	}
	
	if ($send_message == 'true' && strlen($message) > 0) {
		dsf_send_email('ADDRESS DOCTOR', ERROR_REPORT_EMAIL_ADDRESS, 'Email from address doctor functions',    $message,    STORE_OWNER, EMAIL_FROM);
	}
	
}



function dsf_get_address_doctor_curl_response($soap_request, $headers){
	
	
	// set the curl parameters
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,"http://validator2.addressdoctor.com/addInteractive/Interactive.asmx?WSDL"); // the url
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);  //timeouts
	curl_setopt($ch, CURLOPT_TIMEOUT,        10); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($ch, CURLOPT_POST,           true ); // we are posting something
	curl_setopt($ch, CURLOPT_POSTFIELDS,$soap_request); //the soap request
	curl_setopt($ch, CURLOPT_HTTPHEADER,$headers); // the headers
	
	
    $response = curl_exec($ch);
	$curlError = curl_error($ch);
	$curlErno = curl_errno($ch);
	
	// save a copy of this response so we can review the raw xml if we need to.
	// only when testing.
	
	/*
				$id = 'add_doct_' . time();
				$fp = fopen(DS_UNIT_ROOT . DS_XML . $id . '.' . 'xml', "w");
				fputs($fp, $response);
				fclose($fp);
   */


	// in order to load the response as xml we need to strip off soap:, otherwise we will get an error
	
	$contents = str_replace("soap:Body", "Body", $response);
    $response = html_entity_decode($contents);	  
	$thexml = new SimpleXMLElement($contents);
	
	return array('curlerrno' => $curlErno,
			     'curlerror' => $curlError,
				 'thedata' => $thexml);
	
}


function dsf_get_address_doctor_soap_headers($soap_request){
	
		  $headers = array();
		  $headers[] = "Host: validator2.addressdoctor.com";
		  $headers[] = "Content-Type: text/xml; charset=utf-8";
		  $headers[] = "Content-Length:" . strlen($soap_request);
		  $headers[] = "SOAPAction: http://validator2.AddressDoctor.com/addInteractive/Interactive/Validate";
		  
		  return $headers;
	
}

function dsf_get_address_doctor_soap($house_number, $street_name, $locality, $region, $post_code, $country, $customer_id, $password, $origin, $withhn, $countrytype, $lineseperator, $preferlang, $capital, $formatwithorg, $parseinput, $removediacretic){
	
	
	// This soap request has been laid out as per the address doctor documentation 14th July 2008 page 7
	
	$soap_request = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
				$soap_request .= "<soap:Envelope xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\n";
				$soap_request .= "xmlns:xsd=\"http://www.w3.org/2001/XMLSchema\"\n";
				$soap_request .= "xmlns:soap=\"http://schemas.xmlsoap.org/soap/envelope/\">\n";
				$soap_request .= "<soap:Body>\n";
					$soap_request .= "<Validate xmlns=\"http://validator2.AddressDoctor.com/addInteractive/Interactive\">\n";
					$soap_request .= "<addInteractiveRequest>\n";
						$soap_request .= "<Authentication>\n";
								$soap_request .= "<CustomerID>" . $customer_id . "</CustomerID>\n";
								$soap_request .= "<DepartmentID>0</DepartmentID>\n";
								$soap_request .= "<Password>" . $password . "</Password>\n";
						$soap_request .= "</Authentication>\n";
						$soap_request .= "<CampaignID>myCampaignID</CampaignID>\n";
						$soap_request .= "<JobToken></JobToken>\n";
						$soap_request .= "<Parameters>\n";
								$soap_request .= "<CountryOfOrigin>" . $origin . "</CountryOfOrigin>\n";
								$soap_request .= "<StreetWithHNo>" . $withhn . "</StreetWithHNo>\n";
								$soap_request .= "<CountryType>" . $countrytype . "</CountryType>\n";
								$soap_request .= "<LineSeparator>" . $lineseperator . "</LineSeparator>\n";
								$soap_request .= "<PreferredLanguage>" . $preferlang . "</PreferredLanguage>\n";
								$soap_request .= "<Capitalization>" . $capital . "</Capitalization>\n";
								$soap_request .= "<FormattedAddressWithOrganization>" . $formatwithorg . "</FormattedAddressWithOrganization>\n";
								$soap_request .= "<ParsedInput>" . $parseinput . "</ParsedInput>\n";
								$soap_request .= "<RemoveDiacritics>" . $removediacretic . "</RemoveDiacritics>\n";
						$soap_request .= "</Parameters>\n";
						$soap_request .= "<Address>\n";
								$soap_request .= "<RecordID>998887</RecordID>\n";
								$soap_request .= "<Organization>AddressDoctor GmbH</Organization>\n";
								$soap_request .= "<Department>Spectrum</Department>\n";
								$soap_request .= "<Contact>Varta</Contact>\n";
								$soap_request .= "<Building></Building>\n";
								$soap_request .= "<Street>" . utf8_encode($street_name) . "</Street>\n";
								$soap_request .= "<HouseNumber>" . $house_number . "</HouseNumber>\n";
								$soap_request .= "<POBox></POBox>\n";
								$soap_request .= "<Locality>" . $locality . "</Locality>\n";
								$soap_request .= "<PostalCode>" . $post_code . "</PostalCode>\n";
								$soap_request .= "<Province>" . $region . "</Province>\n";
								$soap_request .= "<Country>" . $country . "</Country>\n";
								$soap_request .= "<Residue></Residue>\n";
								$soap_request .= "<CountrySpecificLocalityLine></CountrySpecificLocalityLine>\n";
								$soap_request .= "<DeliveryAddressLines></DeliveryAddressLines>\n";
								$soap_request .= "<FormattedAddress></FormattedAddress>\n";
						$soap_request .= "</Address>\n";
						$soap_request .= "</addInteractiveRequest>\n";
					$soap_request .= "</Validate>\n";
				$soap_request .= "</soap:Body>\n";
				$soap_request .= "</soap:Envelope>\n";
	
		return $soap_request;
	
}
?>