<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.





// this file is loaded after program header to get page and layout information
// from the database to load up any content pages.

if (isset($dsv_page_name) && strlen($dsv_page_name) > 1){
	
	
// override page information needs to be defined before we include this file.  This allows us to load a different set of layouts and contents for the same page in the layouts table.

// an example of this could be for a particular microsite a different layout is included so we can have a different set of styles and page layout.

// alternatively, by changing the content file,  it would be possible to include a totally different design outline for a particular page whilst leaving all other items totally untouched.

//		$dsv_page_overrides_required  true/false as decider
//		$dsv_page_overrides_layout_folder;
//		$dsv_page_overrides_layout_file;
//		$dsv_page_overrides_content_folder;
//		$dsv_page_overrides_content_file;


			// LAYOUT INFORMATION
			$layout_info_query = dsf_db_query("select * from " . DS_DB_SHOP . ".layouts where page_name='" . $dsv_page_name . "'");
			$layout_info = dsf_db_fetch_array($layout_info_query);


if (isset($dsv_page_overrides_required) && $dsv_page_overrides_required == 'true'){
	// overrides are requested
	
			if(isset($dsv_page_overrides_content_file) && strlen($dsv_page_overrides_content_file) > 1){
				$page_file = $dsv_page_overrides_content_file;
			}else{
				$page_file = $layout_info['page_file'];
			}

	
			if(isset($dsv_page_overrides_layout_folder) && strlen($dsv_page_overrides_layout_folder) > 1){
				define ('LAYOUT_NAME' , $dsv_page_overrides_layout_folder . '/');
			}else{
				define ('LAYOUT_NAME' , $layout_info['layout_name'] . '/');
			}

			if(isset($dsv_page_overrides_content_folder) && strlen($dsv_page_overrides_content_folder) > 1){
				define ('CONTENT_NAME' , $dsv_page_overrides_content_folder . '/');
			}else{
				define ('CONTENT_NAME' , $layout_info['contents_folder_select'] . '/');
			}
	
			define('DIR_WS_LAYOUTS', $dsv_system_folder_prefix . 'layouts/' . LAYOUT_NAME);
			define('DIR_WS_CONTENT', $dsv_system_folder_prefix . 'contents/' . CONTENT_NAME);
	

			if(isset($dsv_page_overrides_layout_file) && strlen($dsv_page_overrides_layout_file) > 1){
				define ('DS_LAYOUT_TEMPLATE_NAME' , $dsv_page_overrides_layout_file);
			}else{
				define ('DS_LAYOUT_TEMPLATE_NAME' , $layout_info['template_name']);
			}
	
}else{
	// previous routine
			
			$page_file = $layout_info['page_file'];
			define ('LAYOUT_NAME' , $layout_info['layout_name'] . '/');
			define ('CONTENT_NAME' , $layout_info['contents_folder_select'] . '/');
			
			define('DIR_WS_LAYOUTS', $dsv_system_folder_prefix . 'layouts/' . LAYOUT_NAME);
			define('DIR_WS_CONTENT', $dsv_system_folder_prefix . 'contents/' . CONTENT_NAME);
			define ('DS_LAYOUT_TEMPLATE_NAME' , $layout_info['template_name']);

}


			define('DIR_WS_CONTENT_SCRIPTS', DIR_WS_CONTENT . 'javascript/');
			define('DIR_WS_LAYOUT_TEMPLATE', DIR_WS_LAYOUTS);
			define('DS_LAYOUT', DIR_WS_LAYOUTS);
			
			$header_include = DS_MODULES . 'header.php';
			$left_include = DS_MODULES . 'column_left.php';
			$right_include = DS_MODULES . 'column_right.php';
			$footer_include = DS_MODULES . 'footer.php';
			$content_include = DIR_WS_CONTENT . $page_file;
			
			if (strlen($layout_info['script_name'])>1){
			   $specific_javascript_code = DIR_WS_CONTENT_SCRIPTS . $layout_info['script_name'];
			}
			
			if (strlen($layout_info['style_name'])>1){
				$specific_stylesheet = $layout_info['style_folder_name'] . '/' . $layout_info['style_name'];
			}
			
			
			// MANUAL CODE AMMENDMENTS - as from the table Manual_items
			
			$top_manual_items = "\n";
			$bottom_manual_items = "\n";
			
			$manual_items_query = dsf_db_query("select user_code, page_location from " . DS_DB_SHOP . ".manual_items where page_name='all' or page_name='" . $dsv_page_name . "' order by page_name");
			while ($manual_items = dsf_db_fetch_array($manual_items_query)){
				if ($manual_items['page_location'] == 1){
					$top_manual_items .= $manual_items['user_code'] . "\n";
				}elseif ($manual_items['page_location'] == 2){
					$bottom_manual_items .= $manual_items['user_code'] . "\n";
				}	
			}
			
			


	
			// dynamic forms
			if (isset($layout_info['form_id']) && (int)$layout_info['form_id'] > 0){
				
				
			// dynamic form required.
				
				// this is where we include the dynamic forms function which is a mixture of functions and code to run for actions.
				
				$dsv_breadcrumb = '<ul>' . "\n";
				$dsv_breadcrumb .= '<li><a href="' . dsf_href_link() . '">' . TRANSLATION_HOME .'</a>' . '</li>' . "\n";
				$dsv_breadcrumb .= '</ul>' . "\n";

				if (function_exists('dsf_create_dynamic_form_array')){
					// already exists therefore we cannot bring it in again.
					
				}else{
					// include the form functions
					$dsv_dynamic_form_id = (int)$layout_info['form_id'];
						require(DS_FUNCTIONS . 'dynamic_form_functions.php');
						
				}
				
				
			} // end dynamic forms.
			
			
			
			$dsv_secondary_banners = '';
			
			
			if (isset($layout_info['secondary_banner']) && (int)$layout_info['secondary_banner'] > 0){
			
				// secondary banners are set therefore we need to get the details and allocate an array.
				$sec_query = dsf_db_query("select * from " . DS_DB_SHOP . ".secondary_banners where banner_id='" . (int)$layout_info['secondary_banner'] . "' and status='1'");
				$sec_results = dsf_db_fetch_array($sec_query);
				
					if (isset($sec_results['number_of_images']) && (int)$sec_results['number_of_images'] > 0){
						// we have at least one banner image therefore create secondary images folder.
						
						$dsv_secondary_banners = array('number_of_images' => $sec_results['number_of_images'],
														'banner_one_image' => $sec_results['banner_one_image'],
														'banner_one_link' => $sec_results['banner_one_link'],
														'banner_one_window' => ((int)$sec_results['banner_one_target'] == 1 ? 'true' : 'false'),
														'banner_one_text' => $sec_results['banner_one_text'],
														'banner_one_width' => ((int)$sec_results['banner_one_width'] > 0 ? $sec_results['banner_one_width'] : ''),
														'banner_one_height' => ((int)$sec_results['banner_one_height'] > 0 ? $sec_results['banner_one_height'] : ''),
														'banner_two_image' => $sec_results['banner_two_image'],
														'banner_two_link' => $sec_results['banner_two_link'],
														'banner_two_window' => ((int)$sec_results['banner_one_target'] == 1 ? 'true' : 'false'),
														'banner_two_text' => $sec_results['banner_two_text'],
														'banner_two_width' => ((int)$sec_results['banner_two_width'] > 0 ? $sec_results['banner_two_width'] : ''),
														'banner_two_height' => ((int)$sec_results['banner_two_height'] > 0 ? $sec_results['banner_two_height'] : ''),
														'banner_three_image' => $sec_results['banner_three_image'],
														'banner_three_link' => $sec_results['banner_three_link'],
														'banner_three_window' => ((int)$sec_results['banner_one_target'] == 1 ? 'true' : 'false'),
														'banner_three_text' => $sec_results['banner_three_text'],
														'banner_three_width' => ((int)$sec_results['banner_three_width'] > 0 ? $sec_results['banner_three_width'] : ''),
														'banner_three_height' => ((int)$sec_results['banner_three_height'] > 0 ? $sec_results['banner_three_height'] : '')
														);
						
					}
	
	
	
	
			
			} // end secondary banner
			


} // end page name isset



?>