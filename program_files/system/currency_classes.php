<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.




  class currencies {
    var $currencies;

    function currencies() {
		global $dsv_master_country_id;
		
      $this->currencies = array();
	  
	  if (isset($dsv_master_country_id) && (int)$dsv_master_country_id > 0){
		  
				  $currencies_query = dsf_db_query("select currency_title, currency_symbol_left, currency_symbol_right, currency_decimal_point, currency_thousand_point, currency_decimal_places from " . DS_DB_MASTER . ".countries where country_id='" . $dsv_master_country_id . "'");
				  $currencies = dsf_db_fetch_array($currencies_query);
					$this->currencies['default'] = array('title' => $currencies['currency_title'],
													   'symbol_left' => $currencies['currency_symbol_left'],
													   'symbol_right' => $currencies['currency_symbol_right'],
													   'decimal_point' => $currencies['currency_decimal_point'],
													   'thousands_point' => $currencies['currency_thousand_point'],
													   'decimal_places' => $currencies['currency_decimal_places'],
													   'value' => 1);
				 
	  }else{
		  // something wrong finding the country,  show default values so that the class still works.
		  
					$this->currencies['default'] = array('title' => '',
													   'symbol_left' => '',
													   'symbol_right' => '',
													   'decimal_point' => '.',
													   'thousands_point' => ',',
													   'decimal_places' => 2,
													   'value' => 1);
		  
		  
		  
		  
	  }
	  
	  
	  
    }


    function format($number) {
      
	  $currency_type = 'default'; // global for all webshops

        $format_string = $this->currencies[$currency_type]['symbol_left'] . number_format(dsf_round($number, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']) . $this->currencies[$currency_type]['symbol_right'];

      return $format_string;
    }



    function is_set($code) {
      if (isset($this->currencies[$code]) && dsf_not_null($this->currencies[$code])) {
        return true;
      } else {
        return false;
      }
    }

    function get_value($code) {
      return $this->currencies[$code]['value'];
    }

    function get_decimal_places($code) {
      return $this->currencies[$code]['decimal_places'];
    }


    function display_price($products_price, $products_tax, $quantity = 1) {
	if ($products_price > 0){
      return $this->format(dsf_add_tax($products_price, $products_tax) * $quantity);
    }else{
	  return '';
	}
	}
	

    function display_novatprice($products_price, $products_tax, $quantity = 1) {
		
		if (DISPLAY_NOVAT_PRICE == 'true'){
		
				if ($products_tax >0){
				  return '(' . $this->format(dsf_add_notax($products_price, $products_tax) * $quantity) . ' ex VAT)';
				}else{
				 return '';
				 }
	 	}else{
			return '';
		}
	 
	 }


    function display_numeric_price($products_price, $products_tax, $quantity = 1) {
      return $this->format_numeric(dsf_add_tax($products_price, $products_tax) * $quantity);
    }


    function format_numeric($number) {

		$currency_type = 'default';
		
        $format_string = number_format($number, $this->currencies[$currency_type]['decimal_places'], '.',''); // force a . as decimal separator so we can do maths on the results.

      return $format_string;
    }




    function format_no_symbols($number) {
      
	  $currency_type = 'default'; // global for all webshops

        $format_string = number_format(dsf_round($number, $this->currencies[$currency_type]['decimal_places']), $this->currencies[$currency_type]['decimal_places'], $this->currencies[$currency_type]['decimal_point'], $this->currencies[$currency_type]['thousands_point']);

      return $format_string;
    }



}?>
