<?php

    $rows = 0;
	
	if (isset($dsv_nested_children) && $dsv_nested_children > 0 && is_array($dsv_nested_category)){
		echo' <div id="dsnestCat">' . "\n";
		echo'   <ul>' . "\n";
	
				foreach ($dsv_nested_category as $item) {
				  echo '    <li>';
				  if (strlen($item['sub_title_image'])>1){
					  
				 		 echo '<div class="dsnestImg"><a href="' . dsf_category_parts_url($item['id']) . '" title="' . $item['name'] . '">' . dsf_image($item['sub_title_image'], $item['name']) . '</a></div>' .
						 '<div class="dsnestTitle"><a href="' . dsf_category_parts_url($item['id']) . '" title="' . $item['name'] . '">' . ds_strtoupper($item['name']) . '</a></div>' . '<div class="dsnestTxt">' . $item['text'] . '</div>';
						 
					}else{
				 		 echo '<div class="dsnestImg">&nbsp;</div><div class="dsnestTitle"><a href="' . dsf_category_parts_url($item['id']) . '" title="' . $item['name'] . '">' . ds_strtoupper($item['name']) . '</a></div>' . '<div class="dsnestTxt">' . $item['text'] . '</div>';
				  }
				  echo '    </li>' . "\n";
			
				} // end for each

	
		echo'   </ul>' . "\n";
		echo' </div>' . "\n";
   }
?>




<?php /*<div id="clear"></div>
<div class="lineBreak"></div>
<div id="nestHolder">

<?php

    $rows = 0;
	
	if ($dsv_nested_children > 0 && is_array($dsv_nested_category)){
		echo' <div id="nestCat">' . "\n";
		echo'   <ul>' . "\n";
	
				foreach ($dsv_nested_category as $item) {
				//  $cPath_new = dsf_get_path($categories['categories_id']);
				  $cPath_new = 'cPath=' . $categories['categories_id'];
				  echo '    <li>';
				  if (strlen($item['image'])>1){
				 		 echo '<div class="catDetails"><a href="' . dsf_category_parts_url($item['id']) . '" class="dsnestCatLink" title="' . $item['name'] . '">' . dsf_image($item['image'], $item['name'], $item['width'], $item['height']) . '</a>' .
						 '<h2><a href="' . dsf_category_parts_url($item['id']) . '" class="dsnestCatLink" title="' . $item['name'] . '">' . $item['name'] . '</a></h2>' . '<a href="' . dsf_category_parts_url($item['id']) . '"class="dsnestCatLink" title="' . $item['name'] . '">' . $item['text'] . '</a></div>';
						 
					}else{
				 		 echo '<div class="catDetails"><a href="' . dsf_category_parts_url($item['id']) . '" class="dsnestCatLink" title="' . $item['name'] . '">' . dsf_image($item['image'], $item['name'], $item['width'], $item['height']) . '</a></div>' .
						 '<h2><a href="' . dsf_category_parts_url($item['id']) . '" class="dsnestCatLink" title="' . $item['name'] . '">' . $item['name'] . '</a></h2>';
				  }
				  echo '    </li>' . "\n";
			
				} // end for each

	
		echo'   </ul>' . "\n";
		echo' </div>' . "\n";
   }

?>
</div>*/?>
