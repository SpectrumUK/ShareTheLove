<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



// although in the functions folder,  this is not a function but an include file in order to create
// the search cache when run.

// if the file is included,  it will delete the previous search cache and create a new one.



  if (!function_exists('sc_dsf_strip_commas')) {
		function sc_dsf_strip_commas($string){

			$string = str_replace(","," ",$string);
		
		
		$string = str_replace(" "," ",$string);
		
		$string_split = explode(" ",$string);
		$string_value = '';
		
		
		if (sizeof($string_split)>0){
			foreach ($string_split as $item_split){
				if (strlen($item_split) >3){
					$string_value .= (strlen($string_value)>1 ? ' ' : '') . $item_split;
				}else{
					$string_value .= (strlen($string_value)>1 ? ' ' : '') . $item_split . 'zz';
				}
		
			}
		}else{
				if (strlen($string) >3){
					$string_value .= (strlen($string_value)>1 ? ' ' : '') . $string;
				}else{
					$string_value .= (strlen($string_value)>1 ? ' ' : '') . $string . 'zz';
				}
		}
		
		$string = $string_value;
		
		
			$string = str_replace("/","",$string);
			$string = str_replace("<p>","<p> ",$string);
			$string = str_replace("<br />"," ",$string);
			$string = str_replace("<br>"," ",$string);
			$string = str_replace("&nbsp;"," ",$string);
			$string = str_replace("'"," ",$string);
			$string = str_replace('"',' ',$string);
			$string = str_replace("\n"," ",$string);
			$string = str_replace("&quot;"," ",$string);
			$string = str_replace("\t"," ",$string);
		
		
		
		
		return $string;
		}
}

function dsf_get_categories_additional_text($cfeature=0, $cvalue='', $type, $catname=''){
		if (!$cvalue || (int)$cfeature <1){
			return '';
			break;
		}else{
		
		$catname = trim($catname);
		
			if (strlen($catname)>1){
					if ((substr(strtoupper($catname),-1,1) == 'S') && (substr(strtoupper($catname),-2,1) <> 'S')){
							// found an S so strip it.
							$catname = substr($catname,0,(strlen($catname)-1));
							$catname = ' ' . $catname;

					}else{
							$catname = ' ' . $catname;
					}
					
			}
			
			
		
			if ($type == 'feature'){
			
				// get category name
				$cat_name_query = dsf_db_query("select sc.categories_id, sc.categories_name as ov_categories_name, lc.categories_name from " . DS_DB_SHOP . ".categories sc left join " . DS_DB_LANGUAGE . ".categories lc on (sc.categories_id = lc.categories_id) where sc.virtual_category='" . $cfeature . "'");
				 $cat_name = dsf_db_fetch_array($cat_name_query);
				 
				 
				 if (strlen($cat_name['categories_id'])>1){
				 
				 		$catname = trim((strlen($cat_name['ov_categories_name'])> 0 ? $cat_name['ov_categories_name'] : $cat_name['categories_name']));
						
							if ((substr(strtoupper($catname),-1,1) == 'S') && (substr(strtoupper($catname),-2,1) <> 'S')){
									// found an S so strip it.
									$catname = substr($catname,0,(strlen($catname)-1));
									$catname = ' ' . $catname;
							}else{
									$catname = ' ' . $catname;
							}

				 	return ' ' . $cvalue . $catname;
				 }else{
				 	return '';
					break;
				}
			
			
			
				 
			}elseif ($type == 'group'){
				// get category name
				$cat_name_query = dsf_db_query("select g.group_name, gv.group_value_name from " . DS_DB_SHOP . ".groups g left join " . DS_DB_SHOP . ".groups_values gv on (g.group_id = gv.group_id) where g.group_id='" . $cfeature . "' and gv.group_value_id='" . (int)$cvalue . "'");
				 $cat_name = dsf_db_fetch_array($cat_name_query);
				 
				 if (strlen($cat_name['group_name'])>1 && strlen($cat_name['group_value_name'])>1){
				 	return ' ' . $cat_name['group_name'] . ' ' . $cat_name['group_value_name'] . $catname;
				 }else{
				 	return '';
					break;
				}
				 
				 
			}else{
			return '';
			}
		
		}

}


// END FUNCTIONS





// REMOVE ALL CURRENT ITEMS

$delete_all = dsf_db_query("delete from " . DS_DB_SHOP . ".search_cache where products_id >1");



								
								 $product_info_query = dsf_db_query("select p.products_id, p.products_name as ov_products_name, lp.products_name, p.products_description as ov_products_description, lp.products_description, p.products_short as ov_products_short, lp.products_short, p.products_model as ov_products_model, lp.products_model, p.manufacturers_id, p.products_features, p.products_groups from " . DS_DB_SHOP . ".products p left join " . DS_DB_LANGUAGE . ".products lp on (p.products_id = lp.products_id) where p.products_status = '1' order by p.products_id");
									while($product_info_values = dsf_db_fetch_array($product_info_query)){
								
												  
												  $products_category = '';
												  $category_id = 0;
												  $category_id_two = 0;
												  $category_id_three = 0;
												  
												  
												  
												  
												  $man_info_query = dsf_db_query("select m.manufacturers_name as ov_manufacturers_name, lm.manufacturers_name from " . DS_DB_SHOP . ".manufacturers m left join " . DS_DB_LANGUAGE . ".manufacturers lm on (m.manufacturers_id = lm.manufacturers_id) where m.manufacturers_id = '" . (int)$product_info_values['manufacturers_id'] . "'");
												  $man_info = dsf_db_fetch_array($man_info_query);
												
												$manname = (strlen($man_info['ov_manufacturers_name']) > 0 ? $man_info['ov_manufacturers_name'] : $man_info['manufacturers_name']);
											
												$man_id = (int)$product_info_values['manufacturers_id'];
												
												
												
											
												// get category structure.
												$cat_query_raw = dsf_db_query("select categories_id from " . DS_DB_SHOP . ".products_to_categories where products_id='" . (int)$product_info_values['products_id'] . " limit 3'");
												
												$cc_count = 0;
												
												$cname_one = '';
												$cname_two = '';
												$cname_three = '';
												
												while ($cat_query = dsf_db_fetch_array($cat_query_raw)){
													$cc_count ++;
													
															
															$cnew_name = dsf_get_category_name((int)$cat_query['categories_id'],'1');
															
															if ((substr(strtoupper($cnew_name),-1,1) == 'S') && (substr(strtoupper($cnew_name),-2,1) <> 'S')){
																		// found an S so strip it.
																	$cnew_name = substr($cnew_name,0,(strlen($cnew_name)-1));
															}
													
													
															$products_category .= $cnew_name . ' ';
												
														if ($cc_count == 1){
															$cname_one = $cnew_name . ' ';
															$category_id = $cat_query['categories_id'];
														}elseif ($cc_count == 2){
															$cname_two = $cnew_name . ' ';
															$category_id_two = $cat_query['categories_id'];
														}else{
															$cname_three = $cnew_name . ' ';
															$category_id_three = $cat_query['categories_id'];
														}
												}
												
												
												
												$products_model = (strlen($product_info_values['ov_products_model']) > 0 ? $product_info_values['ov_products_model'] : $product_info_values['products_model']);
												$products_name = (strlen($product_info_values['ov_products_name']) > 0 ? $product_info_values['ov_products_name'] : $product_info_values['products_name']);
												 
												if(strlen($products_model) > 0){
													$prod_name = $products_model . ' - ' . $products_name;
												
												}else{
													$prod_name = $products_name;
												}
			
			
			
												// check to see if manufacturers name is within the name field above, if it is not. add it.
												
												if (strlen($manname) > 0 && strlen($prod_name)>0){
														$manufacturers_replacement = strtoupper(trim($manname));
														$product_replacement = strtoupper($prod_name);
														$replacement_found = strpos($product_replacement, $manufacturers_replacement);
												}else{
													// either manufacturers name or product name not found therefore
													// no replacements are necessary
													$replacement_found = '1';
												}
								
												if ((int)$replacement_found >0){
												 // it has found the name.
												 // do nothing.
												}else{
												$prod_name = $manname . ' ' . $prod_name;
												}
								
								
												// do the same check on the model
								
								
												$brand_model = $products_model;
												
												if (strlen($manname) > 0 && strlen($brand_model)>0){
														$manufacturers_replacement = strtoupper(trim($manname));
														$product_replacement = strtoupper($brand_model);
														$replacement_found = strpos($product_replacement, $manufacturers_replacement);
												}else{
													// either manufacturers name or product name not found therefore
													// no replacements are necessary
													$replacement_found = '1';
												}
								
												if ((int)$replacement_found >0){
												 // it has found the name.
												 // do nothing.
												}else{
												$brand_model = $manname . ' ' . $brand_model;
												}
												
								
												// model number
												$model_split = explode(" ",$products_model);
												$add_model_value = '';
												
												if (sizeof($model_split)>0){
													foreach ($model_split as $item){
														if (strpos($item,'-')>0){
															$add_model_value .= ' ' . str_replace('-',' ',$item);
															$add_model_value .= ' ' . str_replace('-','',$item);
														}
														if (strpos($item,'_')>0){
															$add_model_value .= ' ' . str_replace('_',' ',$item);
															$add_model_value .= ' ' . str_replace('_','',$item);
														}
													}
												
												}else{
														if (strpos($products_model,'-')>0){
															$add_model_value .= ' ' . str_replace('-',' ',$item);
															$add_model_value .= ' ' . str_replace('-','',$item);
														}
														if (strpos($products_model,'_')>0){
															$add_model_value .= ' ' . str_replace('_',' ',$item);
															$add_model_value .= ' ' . str_replace('_','',$item);
														}
												}
												
												$brand_model .= $add_model_value;
												$brand_model = str_replace("  "," ", $brand_model);
												
												
												// next replace all words less than 3 characters with zz markers
												$model_split_two = explode(" ",$brand_model);
												$add_model_value = '';
												
												
												if (sizeof($model_split_two)>0){
													foreach ($model_split_two as $item_split){
														if (strlen($item_split) >3){
															$add_model_value .= ' ' . $item_split;
														}else{
															$add_model_value .= ' ' . $item_split . 'zz';
														}
												
													}
												}else{
														if (strlen($brand_model) >3){
															$add_model_value .= ' ' . $brand_model;
														}else{
															$add_model_value .= ' ' . $brand_model . 'zz';
														}
												}
												
												$brand_model = $add_model_value;
												
												
												
												
												
								
												$brand_title = sc_dsf_strip_commas($prod_name);
												
												$brand_model = sc_dsf_strip_commas($brand_model);
												
												
													// add feature table info to the products description
													
												  		$current_product_feature_array = array();

														$c_features = explode("\n", $product_info_values['products_features']);
													
													foreach($c_features as $f) {
														$f_explode = explode("~" , $f);
														$cfeature = (int)trim($f_explode[0]);
														
														// extra code for yes and no values.
														if (strtoupper(trim($f_explode[1])) == 'YES'){
															$current_product_feature_array[1][$cfeature] = '';
														}else if (strtoupper(trim($f_explode[1])) == 'NO'){
															$current_product_feature_array[1][$cfeature] = '';
														}else{
															$current_product_feature_array[1][$cfeature] = trim($f_explode[1]);
														}
													}
	
	
													$feature_text = '';
													
													$feature_query = dsf_db_query("select distinct f.feature_id, f.feature_name as ov_feature_name, lf.feature_name from " . DS_DB_SHOP . ".features f left join " . DS_DB_LANGUAGE . ".features lf on (f.feature_id = lf.feature_id) left join  " . DS_DB_SHOP . ".features_to_categories fc on (f.feature_id = fc.feature_id) where fc.categories_id ='" . (int)$cat_query['categories_id'] . "' order by f.sort_order");
														while ($features = dsf_db_fetch_array($feature_query)){
														  $current_feature = (int)$features['feature_id'];
														  // Products features
															$feature_text .= ' ' . (strlen($features['ov_feature_name']) > 0 ? $features['ov_feature_name'] : $features['feature_name']) . ' ' . $current_product_feature_array[1][$current_feature];
														}
												
												
												
												$feature_text = sc_dsf_strip_commas($feature_text);
												$description = sc_dsf_strip_commas((strlen($product_info_values['ov_products_description']) > 0 ? $product_info_values['ov_products_description'] : $product_info_values['products_description']));
												$description = strip_tags($description . " " . $feature_text);



												// check for featuers and groups which may also be virtual categories.
												// add these to the categories text.
												$additional_category_text = '';
												$f = '';
												$f_explode = '';
												
													foreach($c_features as $f) {
														$f_explode = explode("~" , $f);
														$cfeature = (int)trim($f_explode[0]);
														$cvalue = trim($f_explode[1]);
													
														$additional_category_text .= dsf_get_categories_additional_text($cfeature, $cvalue, 'feature');
														
													}
													// repeat the process for groups
													

														$c_groups = explode(":", $product_info_values['products_groups']);
													
													foreach($c_groups as $g) {
														$g_explode = explode("~" , $g);
														$cgroup = (int)trim($g_explode[0]);
														$gvalue = (int)trim($g_explode[1]);
														$additional_category_text .= dsf_get_categories_additional_text($cgroup, $gvalue, 'group', $products_category);
													
														$additional_category_text .= dsf_get_categories_additional_text($cgroup, $gvalue, 'group', $products_category);
														
														// additional programming for alias categories
														if ((int)$category_id_two >1){
															$additional_category_text .= dsf_get_categories_additional_text($cgroup, $gvalue, 'group', $cname_two);
														}
													
														if ((int)$category_id_three >1){
															$additional_category_text .= dsf_get_categories_additional_text($cgroup, $gvalue, 'group', $cname_three);
														}
														// END of additional programming.
														
													}



												if (strlen($cname_two) >1){
													$category_text = sc_dsf_strip_commas($cname_one . $additional_category_text);
													$category_text .= ' ' . sc_dsf_strip_commas($cname_two . $additional_category_text);
												}else{
													$category_text = sc_dsf_strip_commas($products_category . $additional_category_text);
												}
																
					
								
									if ((int)$category_id_two == 0){
										$category_id_two = $category_id;
									}
									
									if ((int)$category_id_three == 0){
										$category_id_three = $category_id_two;
									}
									
								
								
										$sql_data_array = array('products_id' => $product_info_values['products_id'],
																'brand_model' => (strlen($brand_model)>3 ? $brand_model : $brand_model. 'zz'),
																'brand_title' => $brand_title,
																'description' => $description,
																'category_text' => $category_text,
																'category_id' => $category_id,
																'category_id_two' => $category_id_two,
																'category_id_three' => $category_id_three,
																'manufacturers_id' => $man_id);
										
				  						dsf_db_perform(DS_DB_SHOP . '.search_cache', $sql_data_array);
										
								} // end while
								
?>