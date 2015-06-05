<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



function dsf_create_category_cache() {
global $cat_parent_array;

// create the slug file
$query = dsf_db_query("select categories_id from " . DS_DB_SHOP . ".categories where category_type='0' order by categories_id");
$query_total = dsf_db_num_rows($query);

$text_file = "<?php" . "\n";
$text_file .= '\$category_slug_cache = array();' . "\n";
while ($results = dsf_db_fetch_array($query)){
	$text_file .= "\$category_slug_cache[" . $results['categories_id'] . "] = '" . dsf_refer_link(dsf_get_cat_slug_tree($results['categories_id'])) . "';" . "\n";
}

$text_file .= "\$category_slug_checker = 'valid';" . "\n";
$text_file .= "\$category_slug_counter = " . $query_total . ";" . "\n\n\n";




// Not part of SEO however, we are also going to write to the file a further
// array of all category parents and children so that we can call this information when
// wanting to show products underneath nested categories.
	$complete_trees = dsf_create_up_cat_tree();
	
	if (isset($cat_parent_array) && is_array($cat_parent_array)){
			$text_file .= '\$category_children_cache = array();' . "\n";
				foreach ($cat_parent_array as $id => $value){
					$text_file .= "\$category_children_cache[" . $id . "] = '" . $value . "';" . "\n";
				}
	}
	// end additional parent - children code


$text_file .= "\n\n";
// now we are going to do a similar query for the categories parts.


$query = dsf_db_query("select categories_id from " . DS_DB_SHOP . ".categories_parts where category_type='0' order by categories_id");
$query_total = dsf_db_num_rows($query);

$text_file .= '\$category_parts_slug_cache = array();' . "\n";
while ($results = dsf_db_fetch_array($query)){
	$text_file .= "\$category_parts_slug_cache[" . $results['categories_id'] . "] = '" . dsf_refer_link(dsf_get_cat_parts_slug_tree($results['categories_id'])) . "';" . "\n";
}

$text_file .= "\$category_parts_slug_checker = 'valid';" . "\n";
$text_file .= "\$category_parts_slug_counter = " . $query_total . ";" . "\n\n\n";




// do the same for parts parents and children

$cat_parent_array = array();

	$complete_trees = dsf_create_up_cat_parts_tree();
	
	if (isset($cat_parent_array) && is_array($cat_parent_array)){
			$text_file .= '\$category_parts_children_cache = array();' . "\n";
				foreach ($cat_parent_array as $id => $value){
					$text_file .= "\$category_parts_children_cache[" . $id . "] = '" . $value . "';" . "\n";
				}
	}
	// end additional parent - children code


// remove any of those slashes
$text_file = str_replace("\\$cat_", "$cat_" , $text_file);
$text_file .= '?>';


return $text_file;
}









$tmp_cache_file = strtolower(DS_FS_WEBSHOP . 'cache/' . CONTENT_CACHE_PREFIX . CONTENT_COUNTRY . '_' . LANGUAGE_URL_SUFFIX . '_category_slug_info.php');
if (file_exists($tmp_cache_file)) {
		include($tmp_cache_file);
}else{

	
	if (isset($dsv_domain_valid) && $dsv_domain_valid == 'true'){
	
		// we have a valid domain,  now we need to check to ensure that we are not on the general page
		// otherwise we will create a default language cache files which will have wrong urls in it.
			if (isset($dsv_show_subs_homepage) && $dsv_show_subs_homepage == 'false'){
			
				// create the category cache.
				 $new_menu = dsf_create_category_cache();
				
					$fp = fopen($tmp_cache_file, "w");
					fputs($fp, str_replace("$\\" , "$", $new_menu));
					fclose($fp);
				
						include($tmp_cache_file);
			}
	}
	
}
?>