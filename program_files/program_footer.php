<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



 
 // search cache check
 
 $dsv_cache_check = date("Y-m-d" , time()) . ' 00:00:00';
 
 if (defined('USE_SEARCH_CACHE') && USE_SEARCH_CACHE == 'true'){
	 
	// check the date and if yesterday then set it to today so the cache is not
	// created more than once.
	
			if (defined('USE_SEARCH_CACHE_DATE') && USE_SEARCH_CACHE_DATE < $dsv_cache_check){
			
				$upd = dsf_db_query("update " . DS_DB_SHOP . ".webshop_configuration set configuration_value='" . date('Y-m-d H:i:s',time()) . "' where configuration_key='USE_SEARCH_CACHE_DATE'");
			
				include('program_files/system/create_search_cache.php');
			
		   }

	 
 }
 
 
 
 // errors - only ever shown if browsing on an internal IP number.
 

 if (isset($dsv_ajax_page) && $dsv_ajax_page == 'true'){
	  // we are on an ajax page therefore we cannot show any errors at all
 }else{
	 
		 if (defined('DS_ERROR_SHOW') && DS_ERROR_SHOW == 'true'){	
		  if (isset($dsv_keep_errors)){
			 echo '<span style="color:#ff0000">';
			  echo 'ERRORS ARE<br />';
			  echo $dsv_keep_errors;
			  echo '</span>';
		  }
		 }
		 
 }
 
 
// write all session data back.
 // dsf_session_close();

?>