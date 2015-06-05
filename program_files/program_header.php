<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



// define parse page start time for debugging
define('DS_PARSE_START_TIME', microtime());



// Get IP function - required in the program header and used throughout the whole website.

function dsf_get_ip_address() {
if (isset($_SERVER)) {
	  if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && strlen($_SERVER['HTTP_X_FORWARDED_FOR']) > 1) {
		
			// we are running through a proxy. check for client header - warning this can be spoofed as its just a http header
			if (isset($_SERVER['HTTP_CLIENT_IP']) && strlen($_SERVER['HTTP_CLIENT_IP']) > 1) {
				$ip = $_SERVER['REMOTE_ADDR'] . ' proxy: ' . $_SERVER['HTTP_CLIENT_IP'];
			}else{
				// we are still though a proxy but have no client header.
				$ip = $_SERVER['REMOTE_ADDR'] . ' proxy';
			}
			
	  } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && strlen($_SERVER['HTTP_CLIENT_IP']) > 1) {
				$ip = $_SERVER['REMOTE_ADDR'] . ' client: ' . $_SERVER['HTTP_CLIENT_IP'];
	  
	  } else {
		$ip = $_SERVER['REMOTE_ADDR'];
	  }
  
} else {
	$ip = 'unknown';
}

return $ip;
}


function dsf_get_ip_address_nonproxy() {
if (isset($_SERVER)) {
	  if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && strlen($_SERVER['HTTP_X_FORWARDED_FOR']) > 1) {
		
			// we are running through a proxy. check for client header - warning this can be spoofed as its just a http header
			if (isset($_SERVER['HTTP_CLIENT_IP']) && strlen($_SERVER['HTTP_CLIENT_IP']) > 1) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			}else{
				// we are still though a proxy but have no client header.
				$ip = $_SERVER['REMOTE_ADDR'];
			}
			
	  } elseif (isset($_SERVER['HTTP_CLIENT_IP']) && strlen($_SERVER['HTTP_CLIENT_IP']) > 1) {
				$ip = $_SERVER['HTTP_CLIENT_IP'];
	  
	  } else {
		$ip = $_SERVER['REMOTE_ADDR'];
	  }
  
} else {
	$ip = 'unknown';
}

return $ip;
}


// Define internal IP numbers used by Designshops.
define('DS_INTERNAL_IP_ONE' , '90.152.2.202');
define('DS_INTERNAL_IP_TWO' , '82.39.6.61');
define('DS_INTERNAL_IP_THREE' , 'NONE');


// Define whitelist  array.

$dsv_whitelist_array = array();
$dsv_whitelist_array[] = '90.152.2.202'; // mark office
$dsv_whitelist_array[] = '82.39.6.61'; // mark home
$dsv_whitelist_array[] = '212.159.73.165'; // plasma
$dsv_whitelist_array[] = '90.209.134.183'; // simon home was 94.14.67.168 and '94.14.11.173' and '94.14.90.221'
$dsv_whitelist_array[] = '84.19.48.66'; // manchester office
$dsv_whitelist_array[] = '203.48.118.18'; // Australia
$dsv_whitelist_array[] = '85.115.33.180 proxy: 84.19.48.66'; // Manchester office Simons proxy
$dsv_whitelist_array[] = '85.115.58.180'; // Manchester office Simons proxy on SSL
$dsv_whitelist_array[] = '85.115.54.180'; // Manchester office Simons proxy on SSL added 2014-08-12
$dsv_whitelist_array[] = '85.115.54.180 proxy: 84.19.48.66'; // Manchester office over proxy added 2014-08-13

$dsv_whitelist_array[] = '62.3.66.110'; // requested by Hala.
// $dsv_whitelist_array[] = '62.152.176.15 proxy'; // Germany - 20/08/2013 TEMP must remove as proxy checks can be spoofed. - Removed 10/09/2013.



$dsv_whitelist_check = 'false';

foreach($dsv_whitelist_array as $value){
	
 	if (dsf_get_ip_address() == $value){
		$dsv_whitelist_check = 'true';
		break;
	}
}

define('DS_WHITELIST_IP' , $dsv_whitelist_check);
unset($dsv_whitelist_array);

// ###



// setup error and debug IP numbers to follow internal designshops ip numbers.
// these are used solely for error checking and debugging.

if (dsf_get_ip_address() == DS_INTERNAL_IP_THREE){
		define('DS_ERROR_IP' , DS_INTERNAL_IP_THREE); 
		define('DS_DEBUG_IP' , DS_INTERNAL_IP_THREE); 

}elseif (dsf_get_ip_address() == DS_INTERNAL_IP_TWO){
		define('DS_ERROR_IP' , DS_INTERNAL_IP_TWO); 
		define('DS_DEBUG_IP' , DS_INTERNAL_IP_TWO); 

}else{
		define('DS_ERROR_IP' , DS_INTERNAL_IP_ONE); 
		define('DS_DEBUG_IP' , DS_INTERNAL_IP_ONE); 

}


// ########################
// load config file


//  require('common/configure.php');
  

// set default timezone

date_default_timezone_set('GMT');





// ########################
// Define error logging

$dsv_keep_errors = '';


//function dsmyErrorHandler($errno, $errstr, $errfile, $errline)
//{
// global $dsv_keep_errors;
//  switch ($errno) {
//  case E_USER_ERROR:
//    $dsv_keep_errors .= "<b>My ERROR</b> [$errno] $errstr<br />\n";
//    $dsv_keep_errors .= "  Fatal error in line $errline of file $errfile";
//    $dsv_keep_errors .= ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
//    $dsv_keep_errors .= "Aborting...<br />\n";
//   // exit(1);
//    break;
//  case E_USER_WARNING:
//    $dsv_keep_errors .= "<b>My WARNING</b> [$errno] $errstr<br />\n";
//    break;
//  case E_USER_NOTICE:
//    $dsv_keep_errors .= "<b>My NOTICE</b> [$errno] $errstr<br />\n";
//    break;
//  default:
//    $dsv_keep_errors .= "ERROR:: Unknown error type: [$errno] $errstr<br />\n";
//    break;
//  }
//}
//
//
//function dsexception_handler($exception) {
// global $dsv_keep_errors;
//  $dsv_keep_errors .= "Uncaught exception: " . print_r($exception, true) . "\n";
//}


// set the level of error reporting
// if (dsf_get_ip_address() == DS_ERROR_IP){
//	 define('DS_ERROR_SHOW' , 'true');
//	 
// 	 ini_set('display_errors','1'); // 1 = yes
// 	$old_error_handler = set_error_handler("dsmyErrorHandler");
//	set_exception_handler('dsexception_handler');
//	
//  }else{
// 	 ini_set('display_errors','0'); // 1 = yes
//	 define('DS_ERROR_SHOW' , 'false');
//  }
// 
 
 
// ## 


// set the debug value
 if (dsf_get_ip_address() == DS_DEBUG_IP){
	 define('DS_DEBUG_SHOW' , 'true');
	 
  }else{
	 define('DS_DEBUG_SHOW' , 'false');
  }

// ##

 
 
  
 // error_reporting(E_ALL & ~E_NOTICE);

// error logging complete


// #########################
// set the type of request (secure or not)
  if (getenv('HTTPS') == 'on' || (int)getenv('HTTPS') == 1 ){
	  $dsv_http_request_type = 'SSL';
  }else{
	  $dsv_http_request_type = 'NONSSL';
  }
  
 
 // set php_self in the local scope - fallback for checking URLS
  if (!isset($PHP_SELF) or strlen($PHP_SELF) < 2){
  	 $PHP_SELF = $_SERVER['PHP_SELF'];
   }


// ##########################
// include the database functions
  require('program_files/system/' . 'db_functions.php');

// make a connection to the database... now
 dsf_db_connect() or die('Sorry Database communication error!');




// include the shops cache file which gives us an array of shops.

include('cache/webshop_cache.php');


// 2013-11-11 remove from the cache array anything that is disabled.

if(isset($cache_webshops) && is_array($cache_webshops)){
	
	foreach ($cache_webshops as $id => $value){
		
		if (isset($value['webshop_status']) && (int)$value['webshop_status'] == 1){
				// we are ok this is a valid webshop.
				
		}else{
			// not valid,  unset this cache item so it does not appear in any lists and will not validate as a webshop.
			
			if (DS_WHITELIST_IP == 'true'){  // whitelist url so leave as it is.
			
				$cache_webshops[$id]['removed'] = 'true';
				
			}else{
				
				// remove it.
				unset($cache_webshops[$id]);
				
			}
			
		}

	} // end foreach webshop
	
	reset($cache_webshops);
	
	
} // end if cache_webshops exists 2013-11-11 amendment.

//endy changed the setting on the $dsv_master_domain inorder for it to work on the local host. 

// get details of the shop based on what we are told from server variable SERVER_NAME
$dsv_domain_valid = 'false';

$dsv_show_subs_homepage = 'false';
$dsv_subs_domain_active = 'false';
$dsv_subs_domain_name = '';



if (isset($_SERVER['SERVER_NAME']) && strlen($_SERVER['SERVER_NAME']) > 3){
	$dsv_master_domain = strtolower(trim($_SERVER['SERVER_NAME']));
        
//added by endy inorder to make the site work on the local host        
$dsv_master_domain = "uk.russellhobbs.com";
	
	if (isset($cache_webshops[$dsv_master_domain])){
		
            
		if (isset($cache_webshops[$dsv_master_domain]['subs'])){
			

			// get the subdomain to go to.
						
			
			if (isset($_GET['shoplanguage']) && strlen($_GET['shoplanguage']) > 1){
				$dsv_shoplanguage = strtolower($_GET['shoplanguage']);
			}else{
				$dsv_shoplanguage = '';
			}
			
			if (strlen($dsv_shoplanguage) > 0 ){
				// we can check to see if the value is correct within subs.
				
			
			// we now need to find the correct sub if possible.
			
				foreach($cache_webshops[$dsv_master_domain]['subs'] as $id => $item){
					
						if (strtolower($id) == $dsv_shoplanguage){
					
						
							$dsv_domain_valid = 'true';
							$dsv_subs_domain_active = 'true';
							$dsv_subs_domain_name = $id;

							
							// set shop and language databases
							define('DS_DB_LANGUAGE' , trim($item['lang_db']));
							define('DS_DB_SHOP' , trim($item['shop_db']));
							define('CONTENT_COUNTRY' , trim($item['country_code']));
							define('DATE_FORMAT' , trim($item['country_date_format']));
							define('CONTENT_COMPANY' , trim($item['invoice_prefix']));
							define('LANGUAGE_URL_SUFFIX' , trim($item['language_url_suffix']));
							
							if (isset($item['cache_prefix'])){
								define('CONTENT_CACHE_PREFIX' , trim($item['cache_prefix']));
							}else{
								define('CONTENT_CACHE_PREFIX' , '');
							}
							
							
							$dsv_db = trim($item['shop_db']);
							
							$dsv_stock_api = (int)$item['stock_api'];
							$dsv_order_api = (int)$item['order_api'];
							
					
							$dsv_master_select_unit = trim($item['unit_id']);
							$dsv_country_code = strtolower(trim($item['country_code']));
					
							$dsv_html_language = $item['language_page_html'];
							
							$dsv_html_charset =	$item['language_page_charset'];
							$dsv_content_language = $item['language_page_content'];
							
							$dsv_email_header_charset =	$item['language_email_header'];


							$dsv_default_currency = strtoupper(trim($item['currency_title']));
							$dsv_master_country_id = strtoupper(trim($item['country_id']));
					
							define('DEFAULT_CHARSET' , $dsv_html_charset);
							define ('SITE_SUBFOLDER' , '/' . $id . '/');	// this should be '/' unless we have subs
							define ('DEFAULT_CURRENCY' , $dsv_default_currency);
			
							define ('DEFAULT_EMAIL_HEADER_CHARSET' , $dsv_email_header_charset);
			
			
							break;
						} // end if subs match
						
				} // end for loop.
			


			} // end we have get variable shoplanguage
			
			// if we have set a domain by this point then we are ok,  otherwise we need to set a default.
			


							if ($dsv_domain_valid == 'false'){ // we have not found what we are looking for set default and also sub requirement.
							
									// we do not have a shoplanguage therefore we can set the default item but need to set the page
									// to go to the language selection pages.
			
									$dsv_show_subs_homepage = 'true';
									$dsv_domain_valid = 'true';
									
									// set shop and language databases
									define('DS_DB_LANGUAGE' , trim($cache_webshops[$dsv_master_domain]['lang_db']));
									define('DS_DB_SHOP' , trim($cache_webshops[$dsv_master_domain]['shop_db']));
									define('CONTENT_COUNTRY' , trim($cache_webshops[$dsv_master_domain]['country_code']));
									define('DATE_FORMAT' , trim($cache_webshops[$dsv_master_domain]['country_date_format']));
									define('CONTENT_COMPANY' , trim($cache_webshops[$dsv_master_domain]['invoice_prefix']));
									define('LANGUAGE_URL_SUFFIX' , trim($cache_webshops[$dsv_master_domain]['language_url_suffix']));

									if (isset($cache_webshops[$dsv_master_domain]['cache_prefix'])){
										define('CONTENT_CACHE_PREFIX' , trim($cache_webshops[$dsv_master_domain]['cache_prefix']));
									}else{
										define('CONTENT_CACHE_PREFIX' , '');
									}



									$dsv_db = trim($cache_webshops[$dsv_master_domain]['shop_db']);
							
									$dsv_stock_api = (int)$cache_webshops[$dsv_master_domain]['stock_api'];
									$dsv_order_api = (int)$cache_webshops[$dsv_master_domain]['order_api'];

									$dsv_master_select_unit = trim($cache_webshops[$dsv_master_domain]['unit_id']);
									$dsv_country_code = strtolower(trim($cache_webshops[$dsv_master_domain]['country_code']));
							
									$dsv_html_language = $cache_webshops[$dsv_master_domain]['language_page_html'];
									
									$dsv_html_charset =	$cache_webshops[$dsv_master_domain]['language_page_charset'];
									$dsv_content_language = $cache_webshops[$dsv_master_domain]['language_page_content'];
									
									$dsv_email_header_charset =	$item['language_email_header'];

									$dsv_default_currency = strtoupper(trim($cache_webshops[$dsv_master_domain]['currency_title']));
									$dsv_master_country_id = strtoupper(trim($cache_webshops[$dsv_master_domain]['country_id']));
							
									define('DEFAULT_CHARSET' , $dsv_html_charset);
									define ('SITE_SUBFOLDER' , '/');	// this should be '/' unless we have subs
									define ('DEFAULT_CURRENCY' , $dsv_default_currency);
				
							define ('DEFAULT_EMAIL_HEADER_CHARSET' , $dsv_email_header_charset);
						}
			
			
			
			// *************************************************************************
			
		}else{
			
			// we have no subs therefore we can make the sub-folder definition
			
					$dsv_domain_valid = 'true';
					
					// set shop and language databases
					define('DS_DB_LANGUAGE' , trim($cache_webshops[$dsv_master_domain]['lang_db']));
					define('DS_DB_SHOP' , trim($cache_webshops[$dsv_master_domain]['shop_db']));
					define('CONTENT_COUNTRY' , trim($cache_webshops[$dsv_master_domain]['country_code']));
					define('DATE_FORMAT' , trim($cache_webshops[$dsv_master_domain]['country_date_format']));
					define('CONTENT_COMPANY' , trim($cache_webshops[$dsv_master_domain]['invoice_prefix']));
					define('LANGUAGE_URL_SUFFIX' , trim($cache_webshops[$dsv_master_domain]['language_url_suffix']));


							if (isset($cache_webshops[$dsv_master_domain]['cache_prefix'])){
								define('CONTENT_CACHE_PREFIX' , trim($cache_webshops[$dsv_master_domain]['cache_prefix']));
							}else{
								define('CONTENT_CACHE_PREFIX' , '');
							}

					$dsv_db = trim($cache_webshops[$dsv_master_domain]['shop_db']);
                                   
			
					$dsv_stock_api = (int)$cache_webshops[$dsv_master_domain]['stock_api'];
					$dsv_order_api = (int)$cache_webshops[$dsv_master_domain]['order_api'];


					$dsv_master_select_unit = trim($cache_webshops[$dsv_master_domain]['unit_id']);
					$dsv_country_code = strtolower(trim($cache_webshops[$dsv_master_domain]['country_code']));
			
					$dsv_html_language = $cache_webshops[$dsv_master_domain]['language_page_html'];
					
					$dsv_html_charset =	$cache_webshops[$dsv_master_domain]['language_page_charset'];
					$dsv_content_language = $cache_webshops[$dsv_master_domain]['language_page_content'];
                                        
//endy commented this out as it was producing an error. The $item variable is none existent.					
				//	$dsv_email_header_charset =	$item['language_email_header'];

					
					$dsv_default_currency = strtoupper(trim($cache_webshops[$dsv_master_domain]['currency_title']));
					$dsv_master_country_id = strtoupper(trim($cache_webshops[$dsv_master_domain]['country_id']));
			
					define('DEFAULT_CHARSET' , $dsv_html_charset);
					define ('SITE_SUBFOLDER' , '/');	// this should be '/' unless we have subs
					define ('DEFAULT_CURRENCY' , $dsv_default_currency);
			
				//	define ('DEFAULT_EMAIL_HEADER_CHARSET' , $dsv_email_header_charset);
		}
		

		define ('HTTP_DOMAIN' , $dsv_master_domain);
		define ('SSL_DOMAIN' , $dsv_master_domain);
		define ('SITE_DOMAIN' , str_replace("www." , "" , $dsv_master_domain)); // no www on site domain (used for spoof check and cookie)






		// look up unit configurations and load then as definitions.
		
            
                
		  $configuration_query = dsf_db_query("select mu.configuration_key as cfgKey, mu.configuration_value as MastercfgValue,  su.configuration_value as ShopcfgValue from " . DS_DB_MASTER . ".unit_configuration mu left join " . DS_DB_SHOP . ".unit_configuration su on (mu.configuration_key = su.configuration_key) where mu.unit_id='" . $dsv_master_select_unit . "'");
	
                  
                  while ($configuration = dsf_db_fetch_array($configuration_query)) {
			if (strlen($configuration['cfgKey']) > 0){
			
				if (strlen($configuration['ShopcfgValue']) > 0){
					// local unit definition
					define($configuration['cfgKey'], $configuration['ShopcfgValue']);
					
				}else{
					// master unit definition
					define($configuration['cfgKey'], $configuration['MastercfgValue']);
				}
			
			}
		  }


		// now the shops own configurations
		
		
		  $configuration_query = dsf_db_query("select configuration_key as cfgKey, configuration_value as cfgValue from " . DS_DB_SHOP . ".webshop_configuration");
		  while ($configuration = dsf_db_fetch_array($configuration_query)) {
			if (strlen($configuration['cfgKey']) > 0){
				define($configuration['cfgKey'], $configuration['cfgValue']);
			}
		  }
		



		// now the shops own module configurations (payments and shipping)
		
		
		  $configuration_query = dsf_db_query("select configuration_key as cfgKey, configuration_value as cfgValue from " . DS_DB_SHOP . ".module_configuration");
		  while ($configuration = dsf_db_fetch_array($configuration_query)) {
			if (strlen($configuration['cfgKey']) > 0){
				define($configuration['cfgKey'], $configuration['cfgValue']);
			}
		  }




		// do translations
		

		   $trans_query = dsf_db_query("select translation_key as cfgKey, translation_value as cfgValue from " . DS_DB_LANGUAGE . ".translation_table where unit_id='" . $dsv_master_select_unit . "'");
				while ($get_trans = dsf_db_fetch_array($trans_query)) {
					 define('TRANSLATION_' . $get_trans['cfgKey'], $get_trans['cfgValue']);
				}




		
		
	} // end if we have a valid shop check
	
} // end if we have server_name variable



// if we do not have server information at this point we cannot continue as we don't know
// what website we are loading.

if ($dsv_domain_valid == 'false'){	

	if (isset($_SERVER['SERVER_NAME'])){
		$dsv_domain = 'http://' . $_SERVER['SERVER_NAME'];
	}else{
		$dsv_domain = '';
	}




  header('Location: ' . $dsv_domain . '/holding_page.html');
  exit();
}







// #############################  CONTINUE WITH EXECUTION #####################################

// if we are still here then one of two things have happended.

// we have got into an infinate loop because the redirect to holding_page.html has not worked.

// The following now assumes everything is in order and we can continue with execution
// the code within index.php should prevent infinate loops.



// SET THE HTTP REQUEST TYPE BASED ON IF WE ARE CURRENTLY HTTPS

// set the type of request (secure or not)
  if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
	  $dsv_request_type = 'SSL';
  }else{
	  $dsv_request_type = 'NONSSL';
  }
  



// DEFINITIONS


// SSL info

define('ENABLE_SSL', true); // secure webserver for checkout procedure? - we should never say no unless testing.

// subdirectory paths
define('DS_WS_SHOP', SITE_SUBFOLDER);// for root shops this should be '/'

// server variable names used in catalog and admin.
define('DS_HTTP_SERVER', 'http://' . HTTP_DOMAIN);
define('DS_HTTPS_SERVER', 'https://' . SSL_DOMAIN);

// cookie info
define('DS_HTTP_COOKIE_DOMAIN', SITE_DOMAIN);
define('DS_HTTPS_COOKIE_DOMAIN', SITE_DOMAIN);
define('DS_HTTP_COOKIE_PATH', '/');
define('DS_HTTPS_COOKIE_PATH', '/');


if (isset($_SERVER['DOCUMENT_ROOT'])){
	$DOCUMENT_ROOT = " http://localhost/iloveHomePhotoMechanic";
}else{
	$DOCUMENT_ROOT = '';
}

define('DS_FS_DOCUMENT_ROOT', $DOCUMENT_ROOT); 
define('DS_FS_WEBSHOP', DS_FS_DOCUMENT_ROOT . '/');

define('DS_IMAGES_FOLDER', 'images/');
define('DS_SIZED_IMAGES_FOLDER', 'images/sized/');
define('DS_DIR_WS_DOCUMENTATION', 'pdf/');


define('DS_INCLUDES', 'custom_modules/');
define('DS_PROGRAM_INCLUDES', 'program_files/');
define('DS_FUNCTIONS', DS_PROGRAM_INCLUDES . 'system/');
define('DS_CLASSES', DS_PROGRAM_INCLUDES . 'system/');
define('DS_PROGRAM_MODULES', DS_PROGRAM_INCLUDES . 'system/modules/');
define('DS_XML', 'xml_transfers/');

$dsv_image_folder = DS_IMAGES_FOLDER;

define('EMAIL_SEPARATOR', '------------------------------------------------------------');

// ##


// CHECK WHETHER USER MUST BE LOGGED IN

if (defined('COMPULSORY_LOGIN')){
	$dsv_compulsory_login = COMPULSORY_LOGIN;
}else{
	$dsv_compulsory_login = 'no';
}


// CHECK FOR ECOMMERCE FACILITIES


if (defined('WHITELIST_ECOMMERCE') && WHITELIST_ECOMMERCE == 'true' && DS_WHITELIST_IP == 'true'){

	// we are on a whitelist url and we are forcing e-commerce
	$dsv_disable_ecommerce = 'false';

}elseif (defined('DISABLE_ECOMMERCE')){	// if the real command exists we use it.
	$dsv_disable_ecommerce = DISABLE_ECOMMERCE;
}else{

	// definition not found so we set it automatically to disable ecommerce.
	define('DISABLE_ECOMMERCE' , 'true');
	$dsv_disable_ecommerce = 'true';

}

// ###



// CHECK FOR RRP

if (defined('ENABLE_RRP')){
	$dsv_enable_rrp = ENABLE_RRP;
}else{
	$dsv_enable_rrp = 'false';
}


// ###

// CHECK SOCIAL NETWORK OPTIONS
if (defined('DS_ALLOW_SOCIAL_CONTENT_LINKS')){
	$dsv_show_social_network = DS_ALLOW_SOCIAL_CONTENT_LINKS;

}else{
	$dsv_show_social_network = 'false';
}



// CHECK USER UPLOAD CONTENT
if (defined('DS_APPROVE_USER_CONTENT')){
	$dsv_user_uploads_approval = DS_APPROVE_USER_CONTENT;

}else{
	$dsv_user_uploads_approval = 'true';
}


// TO GET AROUND BASE HREF ISSUE
$bref = (($dsv_request_type == 'SSL') ? DS_HTTPS_SERVER : DS_HTTP_SERVER) . DS_WS_SHOP;

// force an SSL version (for use in javascripts - Added for PhotoMechanic written by Bray Leino)
$SSL_bref = DS_HTTPS_SERVER. DS_WS_SHOP;

// ######################################



// NEW COOKIE LAW STUFF  
// ########## DEFINE CURRENT PAGE URL

				if (isset($_SERVER['REDIRECT_URL']) && strlen($_SERVER['REDIRECT_URL']) > 1){
						// use redirect url as that should be nice url.
					
							if (substr($_SERVER['REDIRECT_URL'] , 0, 1) == '/'){
								// GET RID OF PREFIX SLASH
								$dsv_current_page_url = substr($_SERVER['REDIRECT_URL'] , 1);
								
							}else{
								$dsv_current_page_url = $_SERVER['REDIRECT_URL'];
								
							}

				}else{
					// redirect url is not available so use php self.
				
					if (substr($_SERVER['PHP_SELF'] , 0, 1) == '/'){
						// GET RID OF PREFIX SLASH
						$dsv_current_page_url = substr($_SERVER['PHP_SELF'] , 1);
						
					}else{
						$dsv_current_page_url = $_SERVER['PHP_SELF'];
						
					}
				}
				
				
				// swap php for html
					$dsv_current_page_url = str_replace('php','html', $dsv_current_page_url);

				// if we are a sub language,   remove that from the current page url
				
				if ($dsv_subs_domain_active == 'true'){
					
							$dsv_strip_length = strlen($dsv_subs_domain_name . '/');
							
							$temp_strip_page = '#' . $dsv_current_page_url;
							
							if (strpos($temp_strip_page, $dsv_subs_domain_name . '/' , 0) == 1){
								$dsv_current_page_url = substr($dsv_current_page_url, $dsv_strip_length);
								
							}
							unset($temp_stip_page);
				}

// ###



// define general functions used application-wide
  require(DS_FUNCTIONS . 'general_functions.php');
  require(DS_FUNCTIONS . 'form_functions.php');
  require(DS_FUNCTIONS . 'image_functions.php');
  require(DS_FUNCTIONS . 'cache_url_functions.php');

 // require(DS_FUNCTIONS . 'banner_functions.php');

 // require(DS_FUNCTIONS . 'xml_classes.php');


// include stock API routines

if (isset($dsv_stock_api) && $dsv_stock_api == 1){
	// convar stock
  	//include ('convar/convar_stock_functions.php');
}

if (isset($dsv_stock_api) && $dsv_stock_api == 3){
	// convar stock
  //	include ('convar/sap_stock_functions.php');
}





// include order API routines

if (isset($dsv_order_api) && $dsv_order_api == 1){
	// convar orders
  	//include ('convar/convar_order_functions.php');
}







// ###



// bring in category cache data

//include(DS_FUNCTIONS . 'create_category_cache.php');



// temporary re-direct to updating page.
if (defined('SHOW_HOLDING_PAGE') && SHOW_HOLDING_PAGE == 'true'){
	
		if (DS_WHITELIST_IP == 'true'){

			// we are fine, we are white listed so don't need to take any notice of the redirect.
		}else{
			dsf_redirect(dsf_refer_link('holding_page.html'));
		}
		
}



// ###


// fix any possible issues with the get variables and injections


if (isset($_GET)){
	
	
	$new_get = array();
	
		foreach ($_GET as  $key => $value){
				
				$key = dsf_parse_injection(urldecode($key));
				$value = dsf_parse_injection(urldecode($value));
				
				if (strlen($key) > 0){
				
				$bits = explode('=',$key);
					if (is_array($bits)){
						if (isset($bits[1])){
							$bids = $bits[0];
							$new_get[$bids] = $bits[1];
						}else{
							// There is no data so need to make it current.
							if (strlen($value) >0){
								$new_get[$key] = urlencode($value);
							}
						}
					}else{
							if (strlen($value) >0){
								$new_get[$key] = urlencode($value);
							}
					}
				} // no value must been stripped
	} // end for each

	if (isset($new_get) && is_array($new_get)){
		unset($_GET);
		$_GET = $new_get;
		unset($new_get);
	}



	// lastly we want to go through possible get variables and either strip values
	// or make them integars.
	
		$strip_int_array = array('alter' , 'ppid' , 'pppid' , 'ccid', 'products_id');
		
		$strip_remove_array = array('skip_delivery' , 'products_delivery_date');
		
		foreach ($strip_int_array as $item){
			if (isset($_GET[$item])){
				$_GET[$item] = (int)$_GET[$item];
			}
		}
		
		
	
			foreach ($strip_remove_array as $item){
			if (isset($_GET[$item])){
				unset($_GET[$item]);
			}
		}

	// thats the end of either int or removing get variables.


}

// ###






// set the cookie domain
  $cookie_domain = (($dsv_request_type == 'NONSSL') ? DS_HTTP_COOKIE_DOMAIN : DS_HTTPS_COOKIE_DOMAIN);
 // $cookie_domain = '.' . SITE_DOMAIN;
  $cookie_path = (($dsv_request_type == 'NONSSL') ? DS_HTTP_COOKIE_PATH : DS_HTTPS_COOKIE_PATH);


// include basket class
  require(DS_CLASSES . 'basket_classes.php');




// ###


// check for a spider
		$spider_flag = false;
		$spider_name = '';
		
		if (isset($_SERVER['HTTP_USER_AGENT'])){	// if we don't have a user agent then we can do nothing.
			
			$user_agent = strtolower($_SERVER['HTTP_USER_AGENT']);
	
			if (dsf_not_null($user_agent) && strlen($user_agent)> 1) {
			 
			 	// get spiders
				$spider_query = dsf_db_query("select spiders_name from " . DS_DB_MASTER . ".known_spiders");
				$spiders = array();
					while ($spider_results = dsf_db_fetch_array($spider_query)){
						$spiders[] = $spider_results['spiders_name'];
					}
			 // add some generic ones
					$spiders[] ='robot';
					$spiders[] ='crawl';
					$spiders[] ='crawler';
					$spiders[] ='spider';
					$spiders[] ='bot';

		
			  for ($i=0, $n=sizeof($spiders); $i<$n; $i++) {
				if (dsf_not_null($spiders[$i])) {
				  if (is_integer(strpos($user_agent, trim($spiders[$i])))) {
					$spider_flag = true;
					$spider_name = trim($spiders[$i]);
					break;
				  }
				}
			  }
			}
		
		}
		
		// end of checking for spider.



  require(DS_CLASSES . 'navigation_classes.php');


// define how the session functions will be used
  require(DS_FUNCTIONS . 'session_functions.php');


	define('DS_SESSION_WRITE_DIRECTORY', DS_FS_WEBSHOP .'tmp/');

  		dsf_session_name('shopsessid');
  		dsf_session_save_path(DS_SESSION_WRITE_DIRECTORY);





// DEFINE COOKIE and SESSIONS


if ($spider_flag == false){	// we are not a spider.



			// ###############
			// cookie form,  we do this regardless of whether cookies have been allowed or not
			// that way it is available to us on all pages.
			
				if (isset($_SERVER['REDIRECT_URL']) && strlen($_SERVER['REDIRECT_URL']) > 1){
						// use redirect url as that should be nice url.
					
							if (substr($_SERVER['REDIRECT_URL'] , 0, 1) == '/'){
								// GET RID OF PREFIX SLASH
								$dsv_cookie_redirect_page = substr($_SERVER['REDIRECT_URL'] , 1);
								
							}else{
								$dsv_cookie_redirect_page = $_SERVER['REDIRECT_URL'];
								
							}

				}else{
					// redirect url is not available so use php self.
				
					if (substr($_SERVER['PHP_SELF'] , 0, 1) == '/'){
						// GET RID OF PREFIX SLASH
						$dsv_cookie_redirect_page = substr($_SERVER['PHP_SELF'] , 1);
						
					}else{
						$dsv_cookie_redirect_page = $_SERVER['PHP_SELF'];
						
					}
				}
				
				
				// swap php for html
					$dsv_cookie_redirect_page = str_replace('php','html', $dsv_cookie_redirect_page);
				
				
					$dsv_cookie_redirect_params = dsf_get_all_get_params(array('cookie_implied','products_id','slug'));
					$dsv_cookie_redirect_link = dsf_refer_link($dsv_cookie_redirect_page, $dsv_cookie_redirect_params, $dsv_request_type);
					
				$dsv_cookie_form_start = dsf_form_create('cookie_form', $dsv_cookie_redirect_link);
				$dsv_cookie_form_end = dsf_form_hidden('url',urlencode($dsv_cookie_redirect_link));
				$dsv_cookie_form_end .= '</form>';

				$dsv_cookie_page_form_start = dsf_form_create('cookie_page_form', $dsv_cookie_redirect_link);
				$dsv_cookie_page_form_end = '</form>';
			// ########## END COOKIE FORM
				



	// check to see if we have the allow cookie variable set.
	
	if (isset($_COOKIE['dsc_system_cookie']) && $_COOKIE['dsc_system_cookie'] == 'yes'){
		// we are allowed cookies,  set everything up.
		
			// set the session cookie parameters
			   if (function_exists('session_set_cookie_params')) {
					session_set_cookie_params(60 * 60 * 24 * 30, $cookie_path, $cookie_domain); // lenght (first param) changed from 0 to 60x60x24  - SETS SESSION COOKIE on machine
			  }elseif (function_exists('ini_set')) {
					ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
					ini_set('session.cookie_path', $cookie_path);
					ini_set('session.cookie_domain', $cookie_domain);
			  }



		// set the cookie again to reset its time
    		dsf_setcookie('dsc_system_cookie', 'yes', time()+(60*60*24*30), $cookie_path, $cookie_domain);
		
			// if we have a session ID in either GET or POST items we remove them.
			   if (isset($_POST[dsf_session_name()])) {
					unset($_POST[dsf_session_name()]);
			   }
			   if (isset($_GET[dsf_session_name()]) ) {
					unset($_GET[dsf_session_name()]);
			   }

				// start the session
					dsf_session_start();
					$session_started = true;
		
				// PHP 5 amendment to set all session variables
				if (isset($_SESSION)){
					foreach($_SESSION as $id => $value){
						$$id = $value;
					}
				}

			 $dsv_allow_system_cookie = 'true';
			 
			 
			 if (isset($_COOKIE['dsc_all_cookies']) && $_COOKIE['dsc_all_cookies'] == 'yes'){
				// set the cookie again to reset its time
    			dsf_setcookie('dsc_all_cookies', 'yes', time()+(60*60*24*30), $cookie_path, $cookie_domain);
				 $dsv_allow_all_cookies = 'true';
			 }else{
				 $dsv_allow_all_cookies = 'false';
			 }


	
	}else{
		// we do not have the approval
		
			if (defined('DS_COOKIE_SET_ALWAYS') && DS_COOKIE_SET_ALWAYS == 'true'){
				// user says force the cookie use anyway without permission
					
					// set the session cookie parameters
					   if (function_exists('session_set_cookie_params')) {
							session_set_cookie_params(60 * 60 * 24 * 30, $cookie_path, $cookie_domain); // lenght (first param) changed from 0 to 60x60x24  - SETS SESSION COOKIE on machine
					  }elseif (function_exists('ini_set')) {
							ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
							ini_set('session.cookie_path', $cookie_path);
							ini_set('session.cookie_domain', $cookie_domain);
					  }
		
		
					// if we have a session ID in either GET or POST items we remove them.
					   if (isset($_POST[dsf_session_name()])) {
							unset($_POST[dsf_session_name()]);
					   }
					   if (isset($_GET[dsf_session_name()]) ) {
							unset($_GET[dsf_session_name()]);
					   }
		
						// start the session
							dsf_session_start();
							$session_started = true;
				
						// set all session values as variables
						if (isset($_SESSION)){
							foreach($_SESSION as $id => $value){
								$$id = $value;
							}
						}
		
					 $dsv_allow_system_cookie = 'false'; // we haven't had authorisation therefore keep this as false to see dropdown
					 
					 
						dsf_setcookie('dsc_all_cookies', 'yes', time()+(60*60*24*30), $cookie_path, $cookie_domain);
						 $dsv_allow_all_cookies = 'true';
				
				
					
					// show cookie bar decision
					if (isset($dsv_cookie_banner_counter) && $dsv_cookie_banner_counter == 1){
						// we have a session variable saved to say we have already shown banner once and it wasn't clicked therefore implied permission counts
						
						// set the system cookie
							dsf_setcookie('dsc_system_cookie', 'yes', time()+(60*60*24*30), $cookie_path, $cookie_domain);
						// hide bar
							$dsv_show_cookie_bar = 'false';
					}else{
						// we haven't shown anything yet therefore show the cookie bar and save a session variable to say we've shown it.
						if (defined('DS_SHOW_COOKIE_BAR') && DS_SHOW_COOKIE_BAR == 'true'){
							$dsv_show_cookie_bar = 'true';
						}else{
							$dsv_show_cookie_bar = 'false';
						}
						$dsv_cookie_banner_counter = 1;
						dsf_session_register('dsv_cookie_banner_counter');
					}
				
				
			
			
			}else{
					// not defined or user agrees not to save cookies before permission.
					
				$dsv_allow_all_cookies = 'false';
				$dsv_allow_system_cookies = 'false';
						
				if (defined('DS_SHOW_COOKIE_BAR') && DS_SHOW_COOKIE_BAR == 'true'){
					$dsv_show_cookie_bar = 'true';
				}else{
							$dsv_show_cookie_bar = 'false';
				}
				
				// at this point we need to check to see if we have an action (should not happen as we should have received an implied
				// allow cookie by someone clicking on another link to get to an action.
				
				// it could happen however if people have their cookies turned off.
				
					if (isset($_GET['action']) || isset($_POST['action'])) {
			
						// we have an action therefore re-direct to cookies required page.
							  dsf_redirect(dsf_refer_link('cookie_usage.html'));
							  
							  // this page requires the facility for the user to allow cookies.
		
						
					}
				
			} // end if defined ds coodie set always option
		
	} // end check if cookie exists.
	



		// additional stuff to start the session if we have either been allowed or implied
		
		if (isset($_GET['cookie_implied']) && $_GET['cookie_implied'] == 'yes'){
			
			// we have received an implied request,  this means the user has continued to view an additional page
			// after we have shown the cookie script.
		
					// set the session cookie parameters
					   if (function_exists('session_set_cookie_params')) {
							session_set_cookie_params(60 * 60 * 24 * 30, $cookie_path, $cookie_domain); // lenght (first param) changed from 0 to 60x60x24  - SETS SESSION COOKIE on machine
					  }elseif (function_exists('ini_set')) {
							ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
							ini_set('session.cookie_path', $cookie_path);
							ini_set('session.cookie_domain', $cookie_domain);
					  }
		
				// set the system cookie
					dsf_setcookie('dsc_system_cookie', 'yes', time()+(60*60*24*30), $cookie_path, $cookie_domain);
				
					// if we have a session ID in either GET or POST items we remove them.
					   if (isset($_POST[dsf_session_name()])) {
							unset($_POST[dsf_session_name()]);
					   }
					   if (isset($_GET[dsf_session_name()]) ) {
							unset($_GET[dsf_session_name()]);
					   }
		
						// start the session
							dsf_session_start();
							$session_started = true;
				
						// set all session values as variables
						if (isset($_SESSION)){
							foreach($_SESSION as $id => $value){
								$$id = $value;
							}
						}
		
					 $dsv_allow_system_cookie = 'true';
					 
					 
						// set the all cookies aswell as they have implied by continuing.
						dsf_setcookie('dsc_all_cookies', 'yes', time()+(60*60*24*30), $cookie_path, $cookie_domain);
						 $dsv_allow_all_cookies = 'true';
						 
						 
						 
						 
					// we no need to do a redirect for the saved cookie to refresh itself,  we can use the cookie
					// link for this but we must remove any reference to the implied setting.
							dsf_redirect($dsv_cookie_redirect_link);
					
					
					
					
		
		} // end if implied
		
		
		// lastly check to see if we have the ds_confirm_cookie  (from post in the cookie bar set)
		
		if ((isset($_POST['ds_confirm_cookie']) && $_POST['ds_confirm_cookie'] == 'yes') || (isset($_POST['ds_confirm_cookie_page']) && $_POST['ds_confirm_cookie_page'] == 'yes') ){
			
			
			// without choice,  we set the system cookie
			
					// set the session cookie parameters
					   if (function_exists('session_set_cookie_params')) {
							session_set_cookie_params(60 * 60 * 24 * 30, $cookie_path, $cookie_domain); // lenght (first param) changed from 0 to 60x60x24  - SETS SESSION COOKIE on machine
					  }elseif (function_exists('ini_set')) {
							ini_set('session.cookie_lifetime', 60 * 60 * 24 * 30);
							ini_set('session.cookie_path', $cookie_path);
							ini_set('session.cookie_domain', $cookie_domain);
					  }
		
				// set the system cookie
					dsf_setcookie('dsc_system_cookie', 'yes', time()+(60*60*24*30), $cookie_path, $cookie_domain);
				
					// if we have a session ID in either GET or POST items we remove them.
					   if (isset($_POST[dsf_session_name()])) {
							unset($_POST[dsf_session_name()]);
					   }
					   if (isset($_GET[dsf_session_name()]) ) {
							unset($_GET[dsf_session_name()]);
					   }
		
						// start the session
							dsf_session_start();
							$session_started = true;
				
						// set all session values as variables
						if (isset($_SESSION)){
							foreach($_SESSION as $id => $value){
								$$id = $value;
							}
						}
		
					 $dsv_allow_system_cookie = 'true';
				
			
			
			// check to see if the user has agreed to the use of the all cookies (for analytics)
			
				if ( (isset($_POST['ds_confirm_all']) &&  $_POST['ds_confirm_all'] == 'yes') || (isset($_POST['ds_confirm_all_page']) &&  $_POST['ds_confirm_all_page'] == 'yes') ){	
							dsf_setcookie('dsc_all_cookies', 'yes', time()+(60*60*24*30), $cookie_path, $cookie_domain);
						 $dsv_allow_all_cookies = 'true';
				}else{
						 $dsv_allow_all_cookies = 'false';
						 // remove cookie if it existed
						 if (isset($_COOKIE['dsc_all_cookies'])){
							dsf_setcookie('dsc_all_cookies', 'deleted', time()-(60*60*24*365), $cookie_path, $cookie_domain);
						 }
						 
						 // remove analytics cookies
						 
						 
							 if (isset($_COOKIE['__utma'])){
							dsf_setcookie('__utma', 'deleted', time()-(60*60*24*365), $cookie_path, $cookie_domain);
						 }
					 
							 if (isset($_COOKIE['__utmb'])){
							dsf_setcookie('__utmb', 'deleted', time()-(60*60*24*365), $cookie_path, $cookie_domain);
						 }

							 if (isset($_COOKIE['__utmc'])){
							dsf_setcookie('__utmc', 'deleted', time()-(60*60*24*365), $cookie_path, $cookie_domain);
						 }

							 if (isset($_COOKIE['__utmz'])){
							dsf_setcookie('__utmz', 'deleted', time()-(60*60*24*365), $cookie_path, $cookie_domain);
						 }
						 
						 
						 
				}
				
				
				// lastly re-direct them to the page they were on for all of this to take affect.
						
							dsf_redirect($dsv_cookie_redirect_link);
						
				
			
			
		} // end of cookie confirmed.
		
} else {
	// we are a spider,   allow all access appart from any action commands where we re-direct to
	// the cookies required page.
	
			if (isset($_GET['action']) || isset($_POST['action'])) {
	
				// we have an action therefore re-direct to cookies required page.
				      dsf_redirect(dsf_refer_link('cookie_usage.html'));
					  
					  // this page requires the facility for the user to allow cookies.

				
			}
		
	
}// end spider check,  cookies and sessions







// ###############################################
// ##### 2014-03-10  BROWSER TYPE AMENDMENT ADDED
 
// automatically we make the browser type = desktop before querying the data.
$dsv_system_alternative_devices = 0;
$dsv_system_browser_type = 'desktop';
$dsv_system_mobile_allowed = 'false';
$dsv_system_tablet_allowed = 'false';


// we only look for other browsers if this domain has variants.
	if (isset($cache_webshops[$dsv_master_domain]['alternative_devices']) && (int)$cache_webshops[$dsv_master_domain]['alternative_devices'] == 1){
		
		$dsv_system_alternative_devices = 1;
		

		// alternatives are allowed.
			if (isset($cache_webshops[$dsv_master_domain]['mobile_site']) && trim($cache_webshops[$dsv_master_domain]['mobile_site']) == 'true'){
				
					$dsv_system_mobile_allowed = 'true';
		
			}

			if (isset($cache_webshops[$dsv_master_domain]['tablet_site']) && trim($cache_webshops[$dsv_master_domain]['tablet_site']) == 'true'){
				
					$dsv_system_tablet_allowed = 'true';
		
			}elseif (isset($cache_webshops[$dsv_master_domain]['tablet_site']) && trim($cache_webshops[$dsv_master_domain]['tablet_site']) == 'mobile'){
				
					$dsv_system_tablet_allowed = 'mobile';
		
			}
			
			

// #####  DETECTION IS CURRENTY FOR WHITELISTED URLS ONLY
	if (DS_WHITELIST_IP == 'true'){
		
			
			if (isset($_GET['ds_browser'])){
				
				// if we have a browser variable then we are doing a redirect.
					if ($_GET['ds_browser'] == 'mobile' && $dsv_system_mobile_allowed == 'true'){
						// we are on a redirect therefore set as mobile.
						$dsv_system_browser_type = 'mobile';
					// set the cookie variable.
						dsf_setcookie('dsc_browser_type', $dsv_system_browser_type, time()+(60*60*24*30), $cookie_path, $cookie_domain);
						
					}elseif ($_GET['ds_browser'] == 'tablet' && $dsv_system_tablet_allowed == 'true'){
						// we are on a redirect therefore set as mobile.
						$dsv_system_browser_type = 'tablet';
					// set the cookie variable.
						dsf_setcookie('dsc_browser_type', $dsv_system_browser_type, time()+(60*60*24*30), $cookie_path, $cookie_domain);
						
					}elseif ($_GET['ds_browser'] == 'tablet' && $dsv_system_tablet_allowed == 'mobile'){
						// we are on a redirect therefore set as mobile.
						$dsv_system_browser_type = 'mobile';
					// set the cookie variable.
						dsf_setcookie('dsc_browser_type', $dsv_system_browser_type, time()+(60*60*24*30), $cookie_path, $cookie_domain);
						
					}elseif ($_GET['ds_browser'] == 'desktop' ){
						// we are on a redirect therefore set as desktop.
						$dsv_system_browser_type = 'desktop';
					// set the cookie variable.
						dsf_setcookie('dsc_browser_type', $dsv_system_browser_type, time()+(60*60*24*30), $cookie_path, $cookie_domain);
						
					}else{
						// not a valid value,  clear the cookie and let detection kick back in next time.
						
						dsf_setcookie('dsc_browser_type', '', time()-(60*60*24*32), $cookie_path, $cookie_domain);
						
						if (isset($_COOKIE['dsc_browser_type'])){
							unset($_COOKIE['dsc_browser_type']);
						}
						
						if (isset($dsc_browser_type)){
							unset($dsc_browser_type);
						}
						
						
					}

				

			}else{
				// we are not doing a redirect so we check to see if we have a cookie set.
					

				if (isset($_COOKIE['dsc_browser_type'])){
					
					$dsc_browser_type = $_COOKIE['dsc_browser_type'];
					
					if ($dsc_browser_type == 'mobile' && $dsv_system_mobile_allowed == 'true'){
						// we have a mobile cookie and mobile is allowed.
						$dsv_system_browser_type = 'mobile';
					}elseif ($dsc_browser_type == 'tablet' && $dsv_system_tablet_allowed == 'true'){
						// we have a tablet cookie and tablet is allowed.
						$dsv_system_browser_type = 'tablet';
					}elseif ($dsc_browser_type == 'tablet' && $dsv_system_tablet_allowed == 'mobile'){
						// we have a tablet cookie and tablet is showing mobile.
						$dsv_system_browser_type = 'mobile';
					}
					
					// desktop variable not required here as we defaulted it above before detections.

					// set the cookie variable.
						dsf_setcookie('dsc_browser_type', $dsv_system_browser_type, time()+(60*60*24*30), $cookie_path, $cookie_domain);
			

				
				}else{
					
					// we don't have a cookie so detection is required.
					
					$dsv_system_browser_detection = 'desktop'; // default in case of detection error.
					
					if (file_exists(DS_UNIT_ROOT . 'hd3.php')){
						require_once(DS_UNIT_ROOT . 'hd3.php'); // include detection script.  -  NOTE THIS IS AN EXTERNAL PROVIDER USED AS PER INSTRUCTIONS FROM SPECTRUM BRANDS

							$hd5 = new HD3(); 
							
							if ($hd5->siteDetect()) {
								$tmp = $hd5->getReply();
									if (isset($tmp['class'])){
										if ($tmp['class'] == 'Mobile'){
											$dsv_system_browser_detection = 'mobile';
										}elseif ($tmp['class'] == 'Tablet'){
											$dsv_system_browser_detection = 'tablet';
										}
									}
							}
					}
					
					
					
					if ($dsv_system_browser_detection == 'mobile' && $dsv_system_mobile_allowed == 'true'){
						// we have a mobile cookie and mobile is allowed.
						$dsv_system_browser_type = 'mobile';
					}elseif ($dsv_system_browser_detection == 'tablet' && $dsv_system_tablet_allowed == 'true'){
						// we have a tablet cookie and tablet is allowed.
						$dsv_system_browser_type = 'tablet';
					}elseif ($dsv_system_browser_detection == 'tablet' && $dsv_system_tablet_allowed == 'mobile'){
						// we have a tablet cookie and tablet is showing mobile.
						$dsv_system_browser_type = 'mobile';
					}
					
					// desktop variable not required here as we defaulted it above before detections.

			
					// set the cookie variable.
						dsf_setcookie('dsc_browser_type', $dsv_system_browser_type, time()+(60*60*24*30), $cookie_path, $cookie_domain);
			
					
				}
				
				
			} // end browser get variable or cookie check.
			

	} // END WHITELIST CHECK #################



	}else{
		
		// we don't have alternative browsers allowed therefore clear any cookie if it exists.
		// we need to do this to clear any desktop cookie that may have been put there during testing detection process.
		
		if (isset($dsc_browser_type)){
			
						dsf_setcookie('dsc_browser_type', '', time()-(60*60*24*32), $cookie_path, $cookie_domain);
			
			
		}
	
		
	}
	


if (file_exists($dsv_system_browser_type)){ // see if the folder exists,  if is does then we prefix it otherwise we make it blank.

	$dsv_system_folder_prefix = $dsv_system_browser_type . '/';
}else{
	$dsv_system_folder_prefix = '';
}


	
define('DS_MODULES', $dsv_system_folder_prefix . DS_INCLUDES);
$dsv_modules = DS_MODULES;
	
	
	
// END BROWSER TYPE CHANGE 2014-03-10
// ###############################################





  if (dsf_session_is_registered('navigation')) {
  } else {
    $navigation = new navigationItem;
     dsf_session_register('navigation');
 }



// Campaign information

if (isset($_GET['cpgn']) && (int)$_GET['cpgn'] > 0){
    	if (dsf_session_is_registered('cpgn')) {
				dsf_session_unregister('cpgn');
		}
		
		$cpgn = $_GET['cpgn'];
		dsf_session_register('cpgn');
		unset($_GET['cpgn']);
		
}

// deal with cpgn if it is not set
if (!isset($cpgn)) {
		$cpgn=0;
}



// ###



// initialise the basket class

  if (dsf_session_is_registered('basket') && is_object($basket)) {
    // we are fine, the basket is registerd
  } else {
    $basket = new shoppingBasket;
    dsf_session_register('basket');
	
  }


// ###


// include email functions
include (DS_FUNCTIONS . 'multipart_functions.php');

require(DS_FUNCTIONS  . 'dynamic_form_functions.php');

// include currencies class and create an instance
  require(DS_CLASSES . 'currency_classes.php');
  $currencies = new currencies();

  $currency = DEFAULT_CURRENCY;
  dsf_resave_session('currency');
  
// ###




// ####################################################################################################
// ALL SLUG CHECKS ARE REQUIRED HERE AS WE NEED TO ALLOCATE PRODUCT ID NUMBERS FOR THE BASKET FUNCTIONS

$dsv_master_page_required = '';


		// check to see if we have a slug,  if we do then we need to find out what that page is and allocat it accordingly.
		
		// otherwise we load up the index.php  file.
		
		if (isset($_GET['slug']) && strlen($_GET['slug']) > 1){
		// possible pages which we could be wanting to load are:
		
		
		// products
		// products parts
		// categories
		// categories parts
		// article three
		// article two
		// article one
		
		// seasonal articles.
		
		$seasonal_query_where = " and sp.article_status='1'";

		// check for articles three,  two and one first as they have a prefix on them.
		
		$slug = urldecode($_GET['slug']);
		
		// remove any trailing slashes.
		if (substr($slug, -1) == '/'){
		
			$slug = substr(strtolower($slug), 0, strlen($slug)-1);
		
		}
		
		
		// check for forward slash.
			$slug_parts = explode("/" , $slug);
		
		
			
			
			if (is_array($slug_parts) && isset($slug_parts[0]) ){
				
				$slug_size = sizeof($slug_parts);
				if ($slug_size > 0){
					$slug_bit = $slug_size -1;
				}else{
					$slug_bit = 0;
				}
				
				
				// we have at least one item to look for.
				

				if ($slug_parts[0] == ARTICLE_3_URL){

						if (substr(strtolower($slug), -3) == 'php'){
									$art_slug = str_replace(".php" , "" , $slug_parts[$slug_bit]);
						}else{
									$art_slug = $slug_parts[$slug_bit];
						}
						$dsv_master_page_required = 'article_three';

					


				}elseif ($slug_parts[0] == ARTICLE_2_URL){

						if (substr(strtolower($slug), -3) == 'php'){
									$art_slug = str_replace(".php" , "" , $slug_parts[$slug_bit]);
						}else{
									$art_slug = $slug_parts[$slug_bit];
						}
						$dsv_master_page_required = 'article_two';



				}elseif ($slug_parts[0] == ARTICLE_1_URL){

						if (substr(strtolower($slug), -3) == 'php'){
									$art_slug = str_replace(".php" , "" , $slug_parts[$slug_bit]);
						}else{
									$art_slug = $slug_parts[$slug_bit];
						}
						$dsv_master_page_required = 'article_one';

					
					
				}else{
					
					// we are either category,  category parts,  product , part or seasonal article - either folder or file.


						if (substr(strtolower($slug), -3) == 'php'){
								// prod routines
								
								//	echo 'prod or part or seasonal article file';
									$prod_slug = dsf_db_input(str_replace(".php" , "" , $slug_parts[$slug_bit]));
									$range_slug = $slug_parts[0];
										
								// we need to work out whether we are a product or a part.
								
								$dsv_products_id = 0;
								


								$get_prod_id = dsf_db_query("select sp.products_id from " . DS_DB_SHOP . ".products sp left join " . DS_DB_LANGUAGE . ".products lp on (sp.products_id = lp.products_id) where sp.products_slug='" . $prod_slug . "' or lp.products_slug='" . $prod_slug . "'");
								$get_prod_results = dsf_db_fetch_array($get_prod_id);
								
								if ((int)$get_prod_results['products_id'] > 0){
									$dsv_products_id = $get_prod_results['products_id'];
									$products_id = $get_prod_results['products_id'];
									$_GET['products_id'] = $get_prod_results['products_id'];
									$dsv_prod_or_part = 'prod';
									$dsv_master_page_required = 'products';
						
						
								}else{
								
									// try and see if it is a part.
									
									
										$get_prod_id = dsf_db_query("select sp.products_id from " . DS_DB_SHOP . ".products_parts sp left join " . DS_DB_LANGUAGE . ".products_parts lp on (sp.products_id = lp.products_id) where sp.products_slug='" . $prod_slug . "' or lp.products_slug='" . $prod_slug . "'");
										$get_prod_results = dsf_db_fetch_array($get_prod_id);
								
										if ((int)$get_prod_results['products_id'] > 0){
												$_GET['products_id'] = $get_prod_results['products_id'];
												$_GET['parts_id'] = $get_prod_results['products_id'];
												$dsv_products_id = $get_prod_results['products_id'];
												$products_id = $get_prod_results['products_id'];
												$dsv_prod_or_part = 'part';
												$dsv_master_page_required = 'parts';
										}else{
											
													// see if its a seasonal article
												$get_prod_id = dsf_db_query("select sp.article_id from " . DS_DB_SHOP . ".seasonal_articles sp left join " . DS_DB_LANGUAGE . ".seasonal_articles lp on (sp.article_id = lp.article_id) where sp.article_slug='" . $prod_slug . "' or lp.article_slug='" . $prod_slug . "'" . $seasonal_query_where);
												$get_prod_results = dsf_db_fetch_array($get_prod_id);
										
												if ((int)$get_prod_results['article_id'] > 0){
														$_GET['article_id'] = $get_prod_results['article_id'];
														$dsv_article_id = $get_prod_results['article_id'];
														$article_id = $get_prod_results['article_id'];
														$dsv_master_page_required = 'seasonal_articles';
												}
											
										}
								}
								
								
								unset($prod_slug);



						}else{
								// category routines
								
								
								
								// check for seasonal article first.
							$prod_slug = dsf_db_input($slug_parts[$slug_bit]);
				
							$get_prod_id = dsf_db_query("select sp.article_id from " . DS_DB_SHOP . ".seasonal_articles sp left join " . DS_DB_LANGUAGE . ".seasonal_articles lp on (sp.article_id = lp.article_id) where sp.article_slug='" . $prod_slug . "' or lp.article_slug='" . $prod_slug . "'" . $seasonal_query_where);
							$get_prod_results = dsf_db_fetch_array($get_prod_id);
					
								if ((int)$get_prod_results['article_id'] > 0){
										$_GET['article_id'] = $get_prod_results['article_id'];
										$dsv_article_id = $get_prod_results['article_id'];
										$article_id = $get_prod_results['article_id'];
										$dsv_master_page_required = 'seasonal_articles';
								}else{
									
									// treat as a category
									
										$cat_slug = dsf_db_input($slug_parts[$slug_bit]);
										$range_slug = dsf_db_input($slug_parts[0]);
											
										$dsv_master_page_required = 'categories';
										// the categories page can sort its own slug data out as we don't need any id's prior to loading.
									
								}
								
		
						}
				
					
									
				} // end slug part check.


			}else{
				
				$dsv_master_page_required = 'index';

			}



		}else{
			
			// cannot establish the page therefore load up the index page.
			$dsv_master_page_required = 'index';
			
		}
		








// END SLUG CHECKS #####################################################################################







// START OF ACTIONS -  THESE ARE ASSOCIATED WITH THE SHOPPING BASKET SO WE CAN ADD AND ADJUST ITEMS FROM ANY PAGE


// Basket actions
  if (isset($_GET['action'])) {
		// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled
		if ($session_started == false) {
		  	dsf_redirect(dsf_href_link('cookie_usage.html'));
		}


		// if this is a spider just send the link back to the homepage.
		if ($spider_flag == true){
			  dsf_redirect(dsf_href_link());
		}



	// include the basket_functions file which contains all of the necessary commands to deal with
	// adding and removing items from the basket including redirection.
	  require(DS_FUNCTIONS . 'basket_functions.php');

	
	
	
  }

// AT THIS POINT ALL ACTIONS ARE COMPLETE

// update who is online
  dsf_update_whos_online();

// include the password crypto functions
  require(DS_FUNCTIONS . 'password_functions.php');

// include validation functions (right now only email address)
  require(DS_FUNCTIONS . 'validation_functions.php');

// split-page-results
  require(DS_CLASSES . 'page_classes.php');


// expire any specials
  dsf_expire_specials();


// initialize the message stack for output messages
  require(DS_CLASSES . 'message_classes.php');
  $messageStack = new messageStack;


// ####



// Global Variables for Buttons ***************************
// Simon stopped using the systems buttons for his own images/custom/ buttons defined in content files.
// these items have been left just in case some are still being used in an old content file somewhere. 

				$dsv_buy_button = 'button_buy.gif';
				$dsv_add_to_basket_button = 'button_add_to_basket.gif';
				$dsv_moreinfo_button = 'button_more_info.gif';
				$dsv_question_button = 'button_arrow_down.gif';
				$dsv_compare_button = 'button_compare.gif';
				$dsv_submit_button = 'button_send.gif';
				$dsv_search_button = 'button_search.gif';
				$dsv_continue_button = 'button_continue.gif';
				$dsv_basket_button = 'button_goto_basket.gif';
				$dsv_logoff_button = 'button_logoff.gif';
				$dsv_history_button = 'button_order_history.gif';
				$dsv_cancel_button = 'button_cancel.gif';
				$dsv_update_button = 'button_update.gif';
				$dsv_header_basket_button = 'button_amend_contents.gif';
			    $dsv_continue_shopping_button = 'button_continue_shopping.gif';
				$dsv_checkout_button = 'button_our_checkout.gif';
				$dsv_confirm_order_button = 'button_confirm_order.gif';
				$dsv_feedback_button = 'button_write_feedback.gif';
				$dsv_register_button = 'button_register.gif';
				$dsv_view_button = 'button_view.gif';


// ###




// Products per page code - allow users to change themselves

if (isset($_GET['ppp'])){

	if (dsf_session_is_registered('dsv_products_per_page')){
			dsf_session_unregister('dsv_products_per_page');
	}
	
		$dsv_products_per_page = (int)$_GET['ppp'];
		dsf_session_register('dsv_products_per_page');
		unset($_GET['ppp']);
}


	if (dsf_session_is_registered('dsv_products_per_page')){
			if ((int)$dsv_products_per_page > (int)MAX_DISPLAY_PRODUCTS_LISTING){
				// do nothing
			}else{
				dsf_session_unregister('dsv_products_per_page');
				$dsv_products_per_page = MAX_DISPLAY_PRODUCTS_LISTING;
				dsf_session_register('dsv_products_per_page');
			}
	}else{
				$dsv_products_per_page = MAX_DISPLAY_PRODUCTS_LISTING;
				dsf_session_register('dsv_products_per_page');

	}


// ###





// header basket details
$dsv_mini_basket_total = $currencies->format($basket->show_total());
$dsv_mini_basket_items = $basket->count_contents();

$dsv_mini_basket_link = dsf_href_link('basket.html', '','NONSSL');

$dsv_error_bar = '';


// search box.
// initialise this regardless of whether it is turned on within the columns or not.
$dsv_column_search_form_start = dsf_form_create('quick_find', dsf_href_link('search_results.html'), '' , 'get');
$dsv_column_search_form_end = dsf_hide_session_id() . '</form>';





// ###






// create a basket class to store what is currently in the basket.


if (!isset($dsv_column_basket)){ 
	// do nothing already set by left column.
	}else{
			
	  if (!isset($shipping_modules)){
			require(DS_CLASSES . 'delivery_classes.php');
			$shipping_modules = new shipping;
	  }

			    if (!dsf_session_is_registered('shipping')) {
  						$quotes = $shipping_modules->quote();
      					$shipping = $shipping_modules->cheapest();
	   					dsf_session_unregister('shipping');
      					dsf_session_register('shipping');

				}

			$newshipcost = 0;
			$newshiptypename = '';
			$newshiptype = '';
			
			  if ($basket->count_contents() > 0) {

					$total_cart_items = (int)$basket->count_contents();
    				$standard_del = $shipping_modules->quote();
	
					// $cheapest_del = $shipping_modules->cheapest();
					
						for ($i=0, $n=sizeof($standard_del); $i<$n; $i++) {
						  for ($j=0, $n2=sizeof($standard_del[$i]['methods']); $j<$n2; $j++) {
							  if($shipping['id'] == ($standard_del[$i]['id'] . '_' . $standard_del[$i]['methods'][$j]['id']) || $shipping == ($standard_del[$i]['id'] . '_' . $standard_del[$i]['methods'][$j]['id'])){
								  $newshiptype = $standard_del[$i]['methods'][$j]['title'];
								  $newshiptypename = $standard_del[$i]['module'];
								  $newshipcost = dsf_add_tax($standard_del[$i]['methods'][$j]['cost'], (isset($standard_del[$i]['tax']) ? $standard_del[$i]['tax'] : 0));
							  }
						  }
						}
				}


			// basket amendments 2013-10-26 to prevent negative basket totals.
			
				$dsv_basket_total_value = 0;
			
						if (isset($voucher_total) && $dsv_voucher_valid =='true' && (int)$voucher_total >0 && (int)$voucher_gift == 0){
							$dsv_voucher_text = $voucher_title;
							$dsv_voucher_discount =  $currencies->format($voucher_total);
							
					
						if ((float)$newshipcost >0  && ($newshiptype)){
							$dsv_basket_total_value = ($basket->show_total() + $newshipcost) - $voucher_total;
						}else{
							$dsv_basket_total_value = $basket->show_total() - $voucher_total;
						}
						
					}else{
						if ((float)$newshipcost >0 && ($newshiptype)){
							$dsv_basket_total_value = $basket->show_total() + $newshipcost;
						}else{
							$dsv_basket_total_value = $basket->show_total();
						}

							$dsv_voucher_text = '';
							$dsv_voucher_discount =  0;
						
					}
		
			
					if ((int)$dsv_basket_total_value <= 0 ){
						$dsv_basket_total_value = 0;
					}
					
					
					$dsv_basket_total = $currencies->format($dsv_basket_total_value);
					

	
			
			
				// get the products
				 $dsv_column_basket_products = array();
				
			  if ($basket->count_contents() > 0) {
	
				 // get the products.
				 
				 
				 $inbasket_array = array();
				 
					$any_out_of_stock = 0;
					$products = $basket->get_products();
					
					
					
					
					for ($i=0, $n=sizeof($products); $i<$n; $i++) {
				// Push all attributes information in an array
					  if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
						while (list($option, $value) = each($products[$i]['attributes'])) {
						  echo dsf_form_hidden('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
						  $attributes = dsf_db_query("select popt.products_options_name, poval.products_options_values_name, pa.options_values_price, pa.price_prefix
													  from " . DS_DB_SHOP . ".products_options popt, " . DS_SB_SHOP . ". products_options_values poval, " . DS_DB_SHOP . ".products_attribues pa
													  where pa.products_id = '" . $products[$i]['id'] . "'
													   and pa.options_id = '" . $option . "'
													   and pa.options_id = popt.products_options_id
													   and pa.options_values_id = '" . $value . "'
													   and pa.options_values_id = poval.products_options_values_id");
						  $attributes_values = dsf_db_fetch_array($attributes);
				
						  $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
						  $products[$i][$option]['options_values_id'] = $value;
						  $products[$i][$option]['products_options_values_name'] = $attributes_values['products_options_values_name'];
						  $products[$i][$option]['options_values_price'] = $attributes_values['options_values_price'];
						  $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
						}
					  }
					}
				
				
					for ($i=0, $n=sizeof($products); $i<$n; $i++) {
						$item_no_stock = 0;
				
							$an_temp_array = array();
						
					  $cur_row = 0;
						
						$inbasket_value = $products[$i]['id'];
						$inbasket_unique = dsf_get_prid($products[$i]['id']);
						$inbasket_array[$inbasket_value] = 'true';
				
				
						$an_temp_array['id'] = $products[$i]['id'];
						$an_temp_array['products_name'] = $products[$i]['name'];
						
						
								  						
											$an_temp_array['warranty'] = '';
									
				
									// add the model to the products name
									
											$an_temp_array['model'] = $products[$i]['model'];
											
								
										// add stock information to the item.  (not on warranties or lamps)
										  if (STOCK_CHECK == 'true') { // check stock
												if (((STOCK_WARN_NO_STOCK == 'true') && (STOCK_ALLOW_CHECKOUT == 'true')) || (STOCK_ALLOW_CHECKOUT == 'false')){
												
													$stock_check = dsf_check_stock($products[$i]['id'], $products[$i]['quantity']);
										   
														if (dsf_not_null($stock_check)) {
														  $any_out_of_stock = 1;
												
														$an_temp_array['stock_check'] = $stock_check;
														}
												}
										}


									  if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
												$tmp_stock_check = dsf_check_stock($products[$i]['id'], $products[$i]['quantity']);
									  }else{
												$tmp_stock_check = dsf_check_stock(dsf_get_prid($products[$i]['id']), $products[$i]['quantity']);
									  }	

									  if (isset($tmp_stock_check) && strlen($tmp_stock_check)>1){
									  		$an_temp_array['stock'] = $tmp_stock_check;
									  }else{
									  		$an_temp_array['stock'] = 'In Stock';
									  }
								
									  if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
										reset($products[$i]['attributes']);
										while (list($option, $value) = each($products[$i]['attributes'])) {
										   $an_temp_array['options'] = $products[$i][$option]['products_options_name'] . ' ' . $products[$i][$option]['products_options_values_name'];
										}
									  }
								
								
									if ((int)$products[$i]['shipping_latency'] > 0){
											$latency_name_query = dsf_db_query("select latency_title from " . DS_DB_SHOP . ".shipping_latency where latency_id='" . (int)$products[$i]['shipping_latency'] . "'");
											$latency_name_result = dsf_db_fetch_array($latency_name_query);
											
										   $an_temp_array['latency'] = $latency_name_result['latency_title'];
									}

									if ((int)$products[$i]['products_deposit'] > 0){
										   $an_temp_array['products_deposit'] = $currencies->display_price($products[$i]['products_deposit'], dsf_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']);
									}
									
									
								
									//$product_image = dsf_get_products_image($products[$i]['id']);
									
											$an_temp_array['image'] = dsf_get_basket_image($products[$i]['id']);
										
										$an_temp_array['qty'] = $products[$i]['quantity'];
										
										
										
									$an_temp_array['price'] = $currencies->display_price($products[$i]['final_price'], dsf_get_tax_rate($products[$i]['tax_class_id']), $products[$i]['quantity']);



						$dsv_column_basket_products[] = $an_temp_array;
						unset($an_temp_array);


					} // end of for
		} // end of we have products
						
			
			$dsv_column_basket = array('total_items' =>(int)$basket->count_contents(),
							'total_weight' => $basket->show_weight(),
							'goods_value' => $basket->show_total(),
							'delivery_type' => $newshiptypename,
							'delivery_cost' => $currencies->display_price($newshipcost,0),
							'voucher_total' => $dsv_voucher_discount,
							'basket_total' => $dsv_basket_total,
							'products' => $dsv_column_basket_products
							);
							
		unset($dsv_column_basket_products);
					
} // end of checking not already done 
		





// ###



if (isset($_GET['viewmode'])){
		if (dsf_session_is_registered('grid_view')){
			dsf_session_unregister('grid_view');
		}
		$grid_view = '';

	if ($_GET['viewmode'] == 'grid'){
		$grid_view = 'yes';
	}else{
		$grid_view = 'no';
	}
	dsf_session_register('grid_view');
unset($_GET['viewmode']);
}




// set the additional jquery variable so we can add to it later.

$jquery_additional_code = '';




// some old payment definitions which are not used and don't have a home.

  define('MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION', 'Please make cheques and postal orders payable to:&nbsp;<strong>' . MODULE_PAYMENT_MONEYORDER_PAYTO . '</strong>&nbsp; and post to:<br><br>' . nl2br(STORE_NAME_ADDRESS) . '<br><br>' . 'Your order will not ship until funds are cleared.');
  define('MODULE_PAYMENT_MONEYORDER_TEXT_EMAIL_FOOTER', "Please make cheques and postal orders payable to: ". MODULE_PAYMENT_MONEYORDER_PAYTO . " and post to:\n\n" . STORE_NAME_ADDRESS . "\n\n" . 'Your order will not ship until funds are cleared.');

  define('MODULE_ORDER_TOTAL_SUBTOTAL_TITLE', 'Sub-Total');
  define('MODULE_ORDER_TOTAL_SUBTOTAL_DESCRIPTION', 'Order Sub-Total');
  define('MODULE_ORDER_TOTAL_SUBTOTAL_NETT_TITLE', 'Sub Total');
  define('MODULE_ORDER_TOTAL_SUBTOTAL_NETT_DESCRIPTION', 'Order Sub Total');
  define('MODULE_ORDER_TOTAL_TAX_TITLE', 'Tax');
  define('MODULE_ORDER_TOTAL_TAX_DESCRIPTION', 'Order Tax');

  define('MODULE_ORDER_TOTAL_SHIPPING_TITLE', 'Shipping');
  define('MODULE_ORDER_TOTAL_SHIPPING_DESCRIPTION', 'Order Shipping Cost');

  define('MODULE_ORDER_TOTAL_TOTAL_TITLE', 'Total');
  define('MODULE_ORDER_TOTAL_TOTAL_DESCRIPTION', 'Order Total');






// get cookie bar information if it is required.

if (isset($dsv_show_cookie_bar) && $dsv_show_cookie_bar == 'true'){
	
	$query = dsf_db_query("select sc.bar_title as ov_bar_title, sc.bar_text as ov_bar_text, sc.bar_button_text as ov_bar_button_text, sc.bar_link_text as ov_bar_link_text, lc.bar_title, lc.bar_text, lc.bar_button_text, lc.bar_link_text from " . DS_DB_SHOP . ".cookie_details sc left join " . DS_DB_LANGUAGE . ".cookie_details lc on (sc.id = lc.id) where sc.id='1' and lc.unit_id='" . $dsv_master_select_unit . "'");
	$result = dsf_db_fetch_array($query);
		
	$dsv_cookie_details = array('bar_title' => (strlen($result['ov_bar_title']) > 1 ? $result['ov_bar_title'] : $result['bar_title']),
								'bar_text' => (strlen($result['ov_bar_text']) > 1 ? $result['ov_bar_text'] : $result['bar_text']),
								'bar_button_text' => (strlen($result['ov_bar_button_text']) > 1 ? $result['ov_bar_button_text'] : $result['bar_button_text']),
								'bar_link_text' => (strlen($result['ov_bar_link_text']) > 1 ? $result['ov_bar_link_text'] : $result['bar_link_text'])
								);
	
	
	
}


// parts keywords variable is used on menus to hold previously entered value.
// to prevent undefined variable error, we set it if not already set.

if (!isset($dsv_part_keywords)){
	$dsv_part_keywords = '';
}



// include tablet / mobile menu cache files  (array)
// as per requirements,  rather than creating a html UL / LI formatted cache like we do for standard menu and include within header where required,
// the mobile and tablet menus are arrays for individual styling.   as such we load them up from the program_header to they are available for every user editable file.

		if($dsv_system_browser_type == 'tablet'){

  			include(DS_FUNCTIONS . 'create_upper_menu_tablet_array.php');
  			include(DS_FUNCTIONS . 'create_lower_menu_tablet_array.php');

		}elseif ($dsv_system_browser_type == 'mobile'){
  			include(DS_FUNCTIONS . 'create_upper_menu_mobile_array.php');
  			include(DS_FUNCTIONS . 'create_lower_menu_mobile_array.php');

		}

// ###







?>