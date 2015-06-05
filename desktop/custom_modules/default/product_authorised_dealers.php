<div class="dsADSTitle"><?php echo TRANSLATION_AUTHORISED_DEALERS; ?>AUTHORISED SERVICE DEALERS</div>
<?php
		// get the data from the distributors table for the list of items.
		
		$pline = '';
		
		$dis_query = dsf_query("select * from " . DS_DB_SHOP . ".distributors order by sort_order");
		while ($dis_results = dsf_array($dis_query)){
		
				$pline .= '<div class="dsADSItem"';
				// pur link on div if it exists
				if (isset($dis_results['distributor_url']) && strlen($dis_results['distributor_url']) > 1){
					$pline .= ' onclick="window.open(\'' . $dis_results['distributor_url'] . '\');"  style="CURSOR:pointer"';
				}
				
				$pline .= '>';
				
				$pline .='<div class="dsADSName">' . $dis_results['distributor_name'] . '</div>';
				
				$pline .='<div class="dsADSPhone">' . $dis_results['distributor_phone'] . '</div>';
		
				$pline .='</div>' . "\n";
		} // end while

	// show the list
	echo $pline;
	?>