<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



function dsf_link($page = '', $parameters ='', $connection = 'NONSSL'){
// alias of dsf_href_link previously with fewer options, may have been used by Simon on old content files therefore
// brought over to this system.
return dsf_href_link($page, $parameters, $connection);
}



  function dsf_href_link($page = '', $parameters = '', $connection = 'NONSSL') {
    global $dsv_request_type, $session_started, $cpgn, $chosen_menu_type, $dsv_allow_system_cookie, $spider_flag;

    if (!dsf_not_null($page)) {
    	// we will just return the homepage as exact url.
		$nopage = 'true';
		
    }
	
		$connection = strtoupper(trim($connection));
	

	if ($connection <> 'SSL'){
		$connection = 'NONSSL';
	}


	if (defined('NO_SSL_AVAILABLE') && NO_SSL_AVAILABLE == 'true'){
		$connection = 'NONSSL';
	}
	



    if ($connection == 'NONSSL') {
      $link = DS_HTTP_SERVER . DS_WS_SHOP;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL == true) {
        $link = DS_HTTPS_SERVER . DS_WS_SHOP;
      } else {
        $link = DS_HTTP_SERVER . DS_WS_SHOP;
      }
    } else {
		if (DS_ERROR_SHOW == 'true'){	
	  		echo('<div><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br></b>Connection = ' . $connection . 'page= ' . $page . ' <br><br>Full Details:<br>Page = ' . $page . '<br>Params = ' . $parameters . '<br>Connetion = ' . $connection . '<br>Add Session = ' . $add_session . '<br>Search Engine Safe = ' . $search_engine_safe . '<br>Lamp Search Safe = ' . $lamp_engine_safe . '</div>');
		}else{
			return;
		}
    }
	

    if (dsf_not_null($parameters)) {
      $link .= $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

	


		// differences made due to cookie law 2012-05-28 ########################
			
			if (isset($dsv_allow_system_cookie) && $dsv_allow_system_cookie == 'true'){
				// we are fine do not need to do anything with URLS
			}else{
				// we add an implied consent to the end of each url providing it is not the
				// form request (that needs to use dsf_href_refer_link   - additionally we don't
				// add it for known spiders
				
							if (defined('DS_COOKIE_SET_ALWAYS') && DS_COOKIE_SET_ALWAYS == 'true'){
								// forcing therefore do not need implied
							}else{
								
									if ($spider_flag == false){
										$link .= $separator .  'cookie_implied=yes';
									}
							}
			}
		//  end cookie law difference ###########################################



     $link = str_replace('&', '&amp;', $link);

	if (isset($nopage) && $nopage == 'true'){
		// we didn't pass a url page, so look for trailing slash and remove it.
			if (strlen(SITE_SUBFOLDER) > 1){
				// dont do anything as we have a sub folder.
			}else{
				if (substr($link, -1) == '/'){
				 $link = substr($link, 0, -1);
				}
			}
	}

    return dsf_parse_injection($link);
  }







// a copy of the dsf_href_link used for redirection, does not use the &amp; option.

  function dsf_refer_link($page = '', $parameters = '', $connection = 'NONSSL') {
    global $dsv_request_type, $session_started, $cpgn, $chosen_menu_type, $dsv_allow_system_cookie, $spider_flag;

    if (!dsf_not_null($page)) {
    	// we will just return the homepage as exact url.
		$nopage = 'true';
		
    }

if ($connection <> 'SSL'){
	$connection = 'NONSSL';
}


	if (defined('NO_SSL_AVAILABLE') && NO_SSL_AVAILABLE == 'true'){
		$connection = 'NONSSL';
	}
	



    if ($connection == 'NONSSL') {
      $link = DS_HTTP_SERVER . DS_WS_SHOP;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL == true) {
        $link = DS_HTTPS_SERVER . DS_WS_SHOP;
      } else {
        $link = DS_HTTP_SERVER . DS_WS_SHOP;
      }
    } else {
		if (DS_ERROR_SHOW == 'true'){	
	  		echo('<div><font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine connection method on a link!<br><br></b>Connection = ' . $connection . 'page= ' . $page . ' <br><br>Full Details:<br>Page = ' . $page . '<br>Params = ' . $parameters . '<br>Connetion = ' . $connection . '<br>Add Session = ' . $add_session . '<br>Search Engine Safe = ' . $search_engine_safe . '<br>Lamp Search Safe = ' . $lamp_engine_safe . '</div>');
		}else{
			return;
		}
    }

    if (dsf_not_null($parameters)) {
      $link .= $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);


	if (isset($nopage) && $nopage == 'true'){
		// we didn't pass a url page, so look for trailing slash and remove it.
			if (strlen(SITE_SUBFOLDER) > 1){
				// dont do anything as we have a sub folder.
			}else{
				if (substr($link, -1) == '/'){
				 $link = substr($link, 0, -1);
				}
			}
	}

    return dsf_parse_injection($link);
  }














  function dsf_category_url($category_id = '', $parameters = '', $connection = 'NONSSL', $range_id=0) {
    global $dsv_request_type, $session_started, $cpgn, $category_slug_cache, $dsv_allow_system_cookie, $spider_flag;

    if ((int)$category_id == 0 && (int)$range_id == 0) {
		if (DS_ERROR_SHOW == 'true'){	
			echo('<div style="color:#ff0000;"><strong>Error!</strong>Unable to determine the category!<br /><br />Details are: category ID ' . $category_id . ' range_id ' . $range_id . ' Params ' . $parameters . ' connection ' . $connection) . '</div>';
    	}else{
			return;
		}
	
	}


	
	if (isset($range_id) && (int)$range_id > 0){
			// if we have a range id, then we are adding the range to the beginining of the url
			$get_range_query = dsf_db_query("select mr.range_slug, r.range_slug as ov_range_slug from " . DS_DB_SHOP . ".ranges r left join " . DS_DB_LANGUAGE . ".ranges mr on (r.range_id = mr.range_id) where r.range_id='" . (int)$range_id . "'");
			$get_range_result = dsf_db_fetch_array($get_range_query);
			
			if (isset($get_range_result['ov_range_slug']) && strlen($get_range_result['ov_range_slug']) > 1){
					$page = dsf_href_link($get_range_result['ov_range_slug'] . '/' . dsf_get_cat_slug_tree($category_id),'', $connection);

			}elseif (isset($get_range_result['range_slug']) && strlen($get_range_result['range_slug']) > 1){
					$page = dsf_href_link($get_range_result['range_slug'] . '/' . dsf_get_cat_slug_tree($category_id),'', $connection);

			}else{
				// ignore the range
					$page = dsf_href_link(dsf_get_cat_slug_tree($category_id),'', $connection);
			}


			
	}else{
		// standard category routine.
	
			if (isset($category_slug_cache[$category_id]) && strlen($category_slug_cache[$category_id]) > 5){
					// we have a url provided
							$page = $category_slug_cache[$category_id];
			}else{
					$page = dsf_href_link(dsf_get_cat_slug_tree($category_id),'', $connection);
			}
	}
	
		
	$link = '';
	
	
    if (dsf_not_null($parameters)) {
      $link = $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);





     $link = str_replace('&amp;', '&', $link);
     $link = str_replace('?&', '?', $link);
     $link = str_replace('&', '&amp;', $link);
     $link = str_replace('///', '/', $link);
     $link = str_replace('//', '/', $link);
     $link = str_replace('http:/', 'http://', $link);
     $link = str_replace('https:/', 'https://', $link);
	
    return $link;
  }


// seo product url creator to take over from dsf_product_link


  function dsf_product_url($product_id = 0, $category_id = 0, $products_slug ='', $parameters = '', $connection = 'NONSSL') {
    global $dsv_request_type, $session_started, $cpgn, $category_slug_cache, $dsv_allow_system_cookie, $spider_flag;

    if ((int)$product_id < 1) {
		if (DS_ERROR_SHOW == 'true'){	
			echo('<div style="color:#ff0000;"><strong>Error!</strong>Unable to determine the product!<br /><br />Details are: product ID ' . $product_id . ' | product slug ' . $products_slug . ' | Params ' . $parameters . ' | connection ' . $connection ) . '</div>';
    	}else{
			return;
		}
	
	}

    if ((int)$category_id == 0 || strlen($products_slug) < 1) {
			$get_cat_query = dsf_db_query("select lp.products_main_cat, lp.products_slug, sp.products_main_cat as ov_products_main_cat, sp.products_slug as ov_products_slug from " . DS_DB_SHOP . ".products sp left join " . DS_DB_LANGUAGE . ".products lp on (sp.products_id =lp.products_id)  where sp.products_id='" . (int)$product_id . "'");
			$get_cat_result = dsf_db_fetch_array($get_cat_query);
			
			
			if ((int)$get_cat_result['ov_products_main_cat'] > 0){
				$category_id = (int)$get_cat_result['ov_products_main_cat'];
			}else{
				$category_id = (int)$get_cat_result['products_main_cat'];
			}
			
			if (strlen($get_cat_result['ov_products_slug']) > 0){
				$products_slug = $get_cat_result['ov_products_slug'];
			}else{
				$products_slug = $get_cat_result['products_slug'];
			}
			
	}
		

	
	if (isset($category_slug_cache[$category_id]) && strlen($category_slug_cache[$category_id]) > 5){
			// we have a url provided
			$page = $category_slug_cache[$category_id] . $products_slug . '.html';
	}else{
			$page = dsf_href_link(dsf_get_cat_slug_tree($category_id) . $products_slug . '.html', '', $connection);
	}
		
	$link = '';
	
    if (dsf_not_null($parameters)) {
      $link .= $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);




     $link = str_replace('&amp;', '&', $link);
     $link = str_replace('?&', '?', $link);
     $link = str_replace('&', '&amp;', $link);
     $link = str_replace('///', '/', $link);
     $link = str_replace('//', '/', $link);
     $link = str_replace('http:/', 'http://', $link);
     $link = str_replace('https:/', 'https://', $link);
	
    return $link;
  }


// ###

  function dsf_range_url($range_id = 0, $parameters = '', $connection = 'NONSSL', $category_id=0) {
    global $dsv_request_type, $session_started,  $cpgn, $category_slug_cache;

    if (!dsf_not_null($range_id)) {
		if (DS_ERROR_SHOW == 'true'){	
			echo('<div style="color:#ff0000;"><strong>Error!</strong>Unable to determine the range!<br /><br />Details are: range ID ' . $range_id . ' Params ' . $parameters . ' connection ' . $connection ) . '</div>';
    	}else{
			return;
		}
	
	}

	
	if (isset($category_id) && (int)$category_id > 0){
		$cparam = dsf_get_cat_slug_tree($category_id);
	}else{
		$cparam = '';
	}
	
	
	if (isset($range_id) && (int)$range_id > 0){
			// if we have a range id, then we are adding the range to the beginining of the url
			$get_range_query = dsf_db_query("select sr.range_slug as ov_range_slug, lr.range_slug from " . DS_DB_SHOP . ".ranges sr left join " . DS_DB_LANGUAGE . ".ranges lr on (sr.range_id = lr.range_id) where sr.range_id='" . (int)$range_id . "'");
			$get_range_result = dsf_db_fetch_array($get_range_query);
			
			if (isset($get_range_result['ov_range_slug']) && strlen($get_range_result['ov_range_slug']) > 1){
					$page = dsf_href_link($get_range_result['ov_range_slug'] . '/' . $cparam , '', $connection);

			}elseif (isset($get_range_result['range_slug']) && strlen($get_range_result['range_slug']) > 1){
					$page = dsf_href_link($get_range_result['range_slug'] . '/' . $cparam , '', $connection);


			}else{
				// ignore the range
					$page = dsf_href_link($cparam, '', $connection);
			}
			
	}else{
					$page = dsf_href_link($cparam, '', $connection);
	}
	
		
	$link = '';
	
	
    if (dsf_not_null($parameters)) {
      $link .= $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);







     $link = str_replace('&amp;', '&', $link);
     $link = str_replace('?&', '?', $link);
     $link = str_replace('&', '&amp;', $link);
     $link = str_replace('///', '/', $link);
     $link = str_replace('//', '/', $link);
     $link = str_replace('http:/', 'http://', $link);
     $link = str_replace('https:/', 'https://', $link);
	
    return $link;
  }









  function dsf_category_parts_url($category_id = '', $parameters = '', $connection = 'NONSSL', $range_id=0) {
    global $dsv_request_type, $session_started,  $cpgn, $category_parts_slug_cache, $dsv_allow_system_cookie, $spider_flag;

    if ((int)$category_id == 0 && (int)$range_id == 0) {
		if (DS_ERROR_SHOW == 'true'){	
			echo('<div style="color:#ff0000;"><strong>Error!</strong>Unable to determine the category parts!<br /><br />Details are: category ID ' . $category_id . ' range_id ' . $range_id . ' Params ' . $parameters . ' connection ' . $connection ) . '</div>';
    	}else{
			return;
		}
	
	}


	
	if (isset($range_id) && (int)$range_id > 0){
			// if we have a range id, then we are adding the range to the beginining of the url
			$get_range_query = dsf_db_query("select mr.range_slug, r.range_slug as ov_range_slug from " . DS_DB_SHOP . ".ranges r left join " . DS_DB_LANGUAGE . ".ranges mr on (r.range_id = mr.range_id) where r.range_id='" . (int)$range_id . "'");
			$get_range_result = dsf_db_fetch_array($get_range_query);
			
			if (isset($get_range_result['ov_range_slug']) && strlen($get_range_result['ov_range_slug']) > 1){
					$page = dsf_href_link($get_range_result['ov_range_slug'] . '/' . dsf_get_cat_parts_slug_tree($category_id), '', $connection);

			}elseif (isset($get_range_result['range_slug']) && strlen($get_range_result['range_slug']) > 1){
					$page = dsf_href_link($get_range_result['range_slug'] . '/' . dsf_get_cat_parts_slug_tree($category_id), '', $connection);

			}else{
				// ignore the range
					$page = dsf_href_link(dsf_get_cat_parts_slug_tree($category_id), '', $connection);
			}


			
	}else{
		// standard category routine.
	
			if (isset($category_parts_slug_cache[$category_id]) && strlen($category_parts_slug_cache[$category_id]) > 5){
					// we have a url provided
							$page = $category_parts_slug_cache[$category_id];
			}else{
					$page = dsf_href_link(dsf_get_cat_parts_slug_tree($category_id), '', $connection);
			}
	}
	
		
	$link = '';
	
	
    if (dsf_not_null($parameters)) {
      $link .= $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);






     $link = str_replace('&amp;', '&', $link);
     $link = str_replace('?&', '?', $link);
     $link = str_replace('&', '&amp;', $link);
     $link = str_replace('///', '/', $link);
     $link = str_replace('//', '/', $link);
     $link = str_replace('http:/', 'http://', $link);
     $link = str_replace('https:/', 'https://', $link);
	
    return $link;
  }


// seo product url creator to take over from dsf_product_link


  function dsf_product_parts_url($product_id = '', $category_id = 0, $products_slug ='', $parameters = '', $connection = 'NONSSL') {
    global $dsv_request_type, $session_started, $cpgn, $category_parts_slug_cache, $dsv_allow_system_cookie, $spider_flag;

    if (!dsf_not_null($product_id)) {
		if (DS_ERROR_SHOW == 'true'){	
			echo('<div style="color:#ff0000;"><strong>Error!</strong>Unable to determine the product!<br /><br />Details are: part ID ' . $product_id . ' product slug ' . $products_slug . ' Params ' . $parameters . ' connection ' . $connection ) . '</div>';
    	}else{
			return;
		}
	
	}

    if ((int)$category_id == 0 || strlen($products_slug) <1) {
			$get_cat_query = dsf_db_query("select lp.products_main_cat, lp.products_slug, sp.products_main_cat as ov_products_main_cat, sp.products_slug as ov_products_slug from " . DS_DB_SHOP . ".products_parts sp left join " . DS_DB_LANGUAGE . ".products_parts lp on (sp.products_id =lp.products_id)  where sp.products_id='" . (int)$product_id . "'");
			$get_cat_result = dsf_db_fetch_array($get_cat_query);
			
			
			if ((int)$get_cat_result['ov_products_main_cat'] > 0){
				$category_id = (int)$get_cat_result['ov_products_main_cat'];
			}else{
				$category_id = (int)$get_cat_result['products_main_cat'];
			}
			
			if (strlen($get_cat_result['ov_products_slug']) > 0){
				$products_slug = $get_cat_result['ov_products_slug'];
			}else{
				$products_slug = $get_cat_result['products_slug'];
			}
			
	}
		

	if (isset($category_parts_slug_cache[$category_id]) && strlen($category_parts_slug_cache[$category_id]) > 5){
			// we have a url provided
			$page = $category_parts_slug_cache[$category_id] . $products_slug . '.html';
	}else{
			$page = dsf_href_link(dsf_get_cat_parts_slug_tree($category_id) . $products_slug . '.html', '', $connection);
	}
		




		
	$link = '';
	
    if (dsf_not_null($parameters)) {
      $link .= $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);





     $link = str_replace('&amp;', '&', $link);
     $link = str_replace('?&', '?', $link);
     $link = str_replace('&', '&amp;', $link);
     $link = str_replace('///', '/', $link);
     $link = str_replace('//', '/', $link);
     $link = str_replace('http:/', 'http://', $link);
     $link = str_replace('https:/', 'https://', $link);
	
    return $link;
  }










// ########################################
// SEO ITEMS






function dsf_get_cat_slug_tree($categories_id, $loopstopper = 1, $required_name =''){
					
if (defined('IGNORE_SEO_UPPER_LEVEL')){
	$ignore_upper = IGNORE_SEO_UPPER_LEVEL;
}else{
	$ignore_upper = 0;
}

			$categories_query = dsf_db_query("SELECT sc.categories_id, sc.parent_id as ov_parent_id, sc.categories_slug as ov_categories_slug, lc.parent_id, lc.categories_slug FROM " . DS_DB_SHOP .".categories sc left join " . DS_DB_LANGUAGE . ".categories lc on (sc.categories_id = lc.categories_id)  WHERE sc.categories_id = '". $categories_id . "'");
			$categories = dsf_db_fetch_array($categories_query);
		
			
			if ((int)$categories['ov_parent_id'] > 0){
					$parent_id = $categories['ov_parent_id'];
			}else{
					$parent_id = $categories['parent_id'];
			}
			
			
			if (strlen($categories['ov_categories_slug']) > 0){
					$slug = $categories['ov_categories_slug'];
			}else{
					$slug = $categories['categories_slug'];
			}
				
			
			
			
			if ($parent_id == 0){
			   
			   if ($ignore_upper == 1){
			   	// dont show last level on seo urls
				}else{
				
					   if ($required_name){
							$required_name = $slug . '/' . $required_name;
					   }else{
							$required_name = $slug . '/';
					   }
		   		}
				
			 }else{
			    $loopstopper ++;
					if ($loopstopper < 6) { // max 6 links down, stops loops on rouge unlinked categories.
	
							if($required_name){
												$required_name = dsf_get_cat_slug_tree($parent_id, $loopstopper, $slug . '/' . $required_name);
							}else{
												$required_name = dsf_get_cat_slug_tree($parent_id, $loopstopper, $slug . '/');
							}
					}
			}
			

return $required_name;
}



function dsf_get_cat_parts_slug_tree($categories_id, $loopstopper = 1, $required_name =''){
					
if (defined('IGNORE_SEO_UPPER_LEVEL')){
	$ignore_upper = IGNORE_SEO_UPPER_LEVEL;
}else{
	$ignore_upper = 0;
}

			$categories_query = dsf_db_query("SELECT sc.categories_id, sc.parent_id as ov_parent_id, sc.categories_slug as ov_categories_slug, lc.parent_id, lc.categories_slug FROM " . DS_DB_SHOP .".categories_parts sc left join " . DS_DB_LANGUAGE . ".categories_parts lc on (sc.categories_id = lc.categories_id)  WHERE sc.categories_id = '". $categories_id . "'");
			$categories = dsf_db_fetch_array($categories_query);
		
			
			if ((int)$categories['ov_parent_id'] > 0){
					$parent_id = $categories['ov_parent_id'];
			}else{
					$parent_id = $categories['parent_id'];
			}
			
			
			if (strlen($categories['ov_categories_slug']) > 0){
					$slug = $categories['ov_categories_slug'];
			}else{
					$slug = $categories['categories_slug'];
			}
				
			
			
			
			if ($parent_id == 0){
			   
			   if ($ignore_upper == 1){
			   	// dont show last level on seo urls
				}else{
				
					   if ($required_name){
							$required_name = $slug . '/' . $required_name;
					   }else{
							$required_name = $slug . '/';
					   }
		   		}
				
			 }else{
			    $loopstopper ++;
					if ($loopstopper < 6) { // max 6 links down, stops loops on rouge unlinked categories.
	
							if($required_name){
												$required_name = dsf_get_cat_parts_slug_tree($parent_id, $loopstopper, $slug . '/' . $required_name);
							}else{
												$required_name = dsf_get_cat_parts_slug_tree($parent_id, $loopstopper, $slug . '/');
							}
					}
			}
			

return $required_name;
}


// LIST OF CATEGORIES WITH THEIR PARENTS FOR CACHE FILE -   THESE ARE USED SO WE CAN SHOW CHILDREN
// PRODUCTS FROM ALL OF THE CHILDREN UNDERNEATH THIS CATEGORY.

// objective is to find a total list of children categories under the selected category
// looping though until all categories have been crawled.

function dsf_get_single_child_list($categories_id, $text='') {
    $categories_count = 0;

    $categories_query = dsf_db_query("select categories_id from " . DS_DB_SHOP . ".categories where parent_id = '" . (int)$categories_id . "'");
   
    while ($categories = dsf_db_fetch_array($categories_query)) {
	
			// check to see there is some products in that category,  if there are not, we are not interested
			$pr_query = dsf_db_query("select products_id from " . DS_DB_SHOP . ".products_to_categories where categories_id='" . (int)$categories['categories_id'] . "'");
			
			if (dsf_db_num_rows($pr_query) > 0){
				// only add if there are products found
				
					  if (isset($text) && strlen($text)>0){
						 $text .= ':' . $categories['categories_id'];
					  }else{
						 $text = ':' . $categories['categories_id'];
					  }
	  		}
	  	// loop again
	  
	  	$text .= dsf_get_single_child_list($categories['categories_id']);
	  
    }
    return $text;
 }


// same for parts

// objective is to find a total list of children categories under the selected category
// looping though until all categories have been crawled.

function dsf_get_single_child_parts_list($categories_id, $text='') {
    $categories_count = 0;

    $categories_query = dsf_db_query("select categories_id from " . DS_DB_SHOP . ".categories_parts where parent_id = '" . (int)$categories_id . "'");
   
    while ($categories = dsf_db_fetch_array($categories_query)) {
	
			// check to see there is some products in that category,  if there are not, we are not interested
			$pr_query = dsf_db_query("select products_id from " . DS_DB_SHOP . ".products_parts_to_categories_parts where categories_id='" . (int)$categories['categories_id'] . "'");
			
			if (dsf_db_num_rows($pr_query) > 0){
				// only add if there are products found
				
					  if (isset($text) && strlen($text)>0){
						 $text .= ':' . $categories['categories_id'];
					  }else{
						 $text = ':' . $categories['categories_id'];
					  }
	  		}
	  	// loop again
	  
	  	$text .= dsf_get_single_child_parts_list($categories['categories_id']);
	  
    }
    return $text;
 }

// ###


  function dsf_article_one_url($article_id = '', $parameters = '', $connection = 'NONSSL') {
    global $dsv_request_type, $session_started, $cpgn;


// good slug name field from article configuration name
	$good_name = strtolower(ARTICLE_1_NAME);
	$good_name = str_replace(array("'", '"') , "" , $good_name);
	$good_name = str_replace(array("+", ")", "(" , " " , "/" , "'" , '"' , "." , "\\" , "*" , "$" , "<" , ">" , "&lt;" , "&gt;"), "-" , $good_name);
	$good_name = str_replace(array("&amp;", "&"), "-and-" , $good_name);
	$good_name = str_replace("--", "-" , $good_name);
	$good_name = str_replace("--", "-" , $good_name);


    if ((int)$article_id < 1) {
		if (DS_ERROR_SHOW == 'true'){	
			echo('<div style="color:#ff0000;"><strong>Error!</strong>Unable to determine the article!<br /><br />Details are: article ID ' . $article_id . ' Params ' . $parameters . ' connection ' . $connection) . '</div>';
    	}else{
			return;
		}
	
	}

	
	$page = dsf_href_link($good_name . '/' . dsf_get_article_one_slug_tree($article_id), '', $connection);
		
	$link = '';
	
    if (dsf_not_null($parameters)) {
      $link .= $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

     $link = str_replace('&amp;', '&', $link);
     $link = str_replace('?&', '?', $link);
     $link = str_replace('&', '&amp;', $link);
     $link = str_replace('///', '/', $link);
     $link = str_replace('//', '/', $link);
     $link = str_replace('http:/', 'http://', $link);
     $link = str_replace('https:/', 'https://', $link);
	
    return dsf_parse_injection($link);
  }


// ###


  function dsf_article_two_url($article_id = '', $parameters = '', $connection = 'NONSSL') {
    global $dsv_request_type, $session_started, $cpgn;


// good slug name field from article configuration name
	$good_name = strtolower(ARTICLE_2_NAME);
	$good_name = str_replace(array("'", '"') , "" , $good_name);
	$good_name = str_replace(array("+", ")", "(" , " " , "/" , "'" , '"' , "." , "\\" , "*" , "$" , "<" , ">" , "&lt;" , "&gt;"), "-" , $good_name);
	$good_name = str_replace(array("&amp;", "&"), "-and-" , $good_name);
	$good_name = str_replace("--", "-" , $good_name);
	$good_name = str_replace("--", "-" , $good_name);


    if ((int)$article_id < 1) {
		if (DS_ERROR_SHOW == 'true'){	
			echo('<div style="color:#ff0000;"><strong>Error!</strong>Unable to determine the article!<br /><br />Details are: article ID ' . $article_id . ' Params ' . $parameters . ' connection ' . $connection) . '</div>';
    	}else{
			return;
		}
	
	}

	
	$page = dsf_href_link($good_name . '/' . dsf_get_article_two_slug_tree($article_id), '', $connection);
		$link = '';
		
	
    if (dsf_not_null($parameters)) {
      $link .= $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

     $link = str_replace('&amp;', '&', $link);
     $link = str_replace('?&', '?', $link);
     $link = str_replace('&', '&amp;', $link);
     $link = str_replace('///', '/', $link);
     $link = str_replace('//', '/', $link);
     $link = str_replace('http:/', 'http://', $link);
     $link = str_replace('https:/', 'https://', $link);
	
    return dsf_parse_injection($link);
  }

// ###


  function dsf_article_three_url($article_id = '', $parameters = '', $connection = 'NONSSL') {
    global $dsv_request_type, $session_started, $cpgn;


// good slug name field from article configuration name
	$good_name = strtolower(ARTICLE_3_NAME);
	$good_name = str_replace(array("'", '"') , "" , $good_name);
	$good_name = str_replace(array("+", ")", "(" , " " , "/" , "'" , '"' , "." , "\\" , "*" , "$" , "<" , ">" , "&lt;" , "&gt;"), "-" , $good_name);
	$good_name = str_replace(array("&amp;", "&"), "-and-" , $good_name);
	$good_name = str_replace("--", "-" , $good_name);
	$good_name = str_replace("--", "-" , $good_name);


    if ((int)$article_id < 1) {
		if (DS_ERROR_SHOW == 'true'){	
			echo('<div style="color:#ff0000;"><strong>Error!</strong>Unable to determine the article!<br /><br />Details are: article ID ' . $article_id . ' Params ' . $parameters . ' connection ' . $connection ) . '</div>';
    	}else{
			return;
		}
	
	}

	
	$page = dsf_href_link($good_name . '/' . dsf_get_article_three_slug_tree($article_id), '', $connection);
		
	$link = '';
	
    if (dsf_not_null($parameters)) {
      $link .= $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

     $link = str_replace('&amp;', '&', $link);
     $link = str_replace('?&', '?', $link);
     $link = str_replace('&', '&amp;', $link);
     $link = str_replace('///', '/', $link);
     $link = str_replace('//', '/', $link);
     $link = str_replace('http:/', 'http://', $link);
     $link = str_replace('https:/', 'https://', $link);
	
    return dsf_parse_injection($link);
  }



// ###


  function dsf_seasonal_article_url($article_id = '', $parameters = '', $connection = 'NONSSL') {
    global $dsv_request_type, $session_started, $cpgn;

    if ((int)$article_id < 1) {
		if (DS_ERROR_SHOW == 'true'){	
			echo('<div style="color:#ff0000;"><strong>Error!</strong>Unable to determine the article!<br /><br />Details are: article ID ' . $article_id . ' Params ' . $parameters . ' connection ' . $connection ) . '</div>';
    	}else{
			return;
		}
	
	}

	
	$page = dsf_href_link(dsf_get_seasonal_article_slug_tree($article_id), '', $connection);
		
	$link = '';
	
    if (dsf_not_null($parameters)) {
      $link .= $page . '?' . dsf_output_string($parameters);
      $separator = '&';
    } else {
      $link .= $page;
      $separator = '?';
    }

    while ( (substr($link, -1) == '&') || (substr($link, -1) == '?') ) $link = substr($link, 0, -1);

     $link = str_replace('&amp;', '&', $link);
     $link = str_replace('?&', '?', $link);
     $link = str_replace('&', '&amp;', $link);
     $link = str_replace('///', '/', $link);
     $link = str_replace('//', '/', $link);
     $link = str_replace('http:/', 'http://', $link);
     $link = str_replace('https:/', 'https://', $link);
	
    return dsf_parse_injection($link);
  }

// ###


?>