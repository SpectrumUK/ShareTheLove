<?php

    $rows = 0;
	
	if (isset($dsv_nested_children) && $dsv_nested_children > 0 && is_array($dsv_nested_category)){
		echo' <div id="dsnestCat">' . "\n";
		echo'   <ul>' . "\n";
	
				foreach ($dsv_nested_category as $item) {
				  echo '    <li>';
				  if (strlen($item['sub_title_image'])>1){
				 		 echo '<div class="dsnestImg"><a href="' . dsf_category_url($item['id']) . '" title="' . $item['name'] . '">' . dsf_image($item['sub_title_image'], $item['name']) . '</a></div>' .
						 '<div class="dsnestTitle"><a href="' . dsf_category_url($item['id']) . '" title="' . $item['name'] . '">' . ds_strtoupper($item['name']) . '</a></div>' . '<div class="dsnestTxt">' . $item['text'] . '</div>';
						 
					}else{
				 		 echo '<div class="dsnestImg">&nbsp;</div><div class="dsnestTitle"><a href="' . dsf_category_url($item['id']) . '" title="' . $item['name'] . '">' . ds_strtoupper($item['name']) . '</a></div>' . '<div class="dsnestTxt">' . $item['text'] . '</div>';
				  }
				  echo '    </li>' . "\n";
			
				} // end for each

	
		echo'   </ul>' . "\n";
		echo' </div>' . "\n";
   }

?>
