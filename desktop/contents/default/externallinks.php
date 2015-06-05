<table border="0" width="100%" cellspacing="0" cellpadding="0">
<tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0" class="topPageTable">
				  <tr>
					<td class="pageHeading" height="30"><?php echo 'External Links'; ?></td>
					<td class="pageHeading" align="right"><?php //echo tep_image(DIR_WS_IMAGES . 'table_background_reviews_new.gif', HEADING_TITLE, LARGE_IMAGE_WIDTH, LARGE_IMAGE_HEIGHT); ?></td>
				  </tr>
       		 </table></td>
      </tr>

      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>
	
	  <tr>
		 <td class="normallink">The following links are provided by selected external sites.</td>
	  </tr>
 
      <tr>
        <td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
      </tr>

<?php


  $links_query_raw = "select link_id, link_title, link_url, link_image, link_content from " . TABLE_LINKS . " where status='1' order by link_id";

//  $links_query_raw = "select link_id, link_title, link_url, link_image, link_content from " . TABLE_LINKS . " where status='99' order by link_id";

  $links_splitup = new splitPageResults($links_query_raw, MAX_DISPLAY_LINKS_LISTING_VALUE);

 $links_query = tep_db_query($links_splitup->sql_query);

	$myrow = 1;
	$mycol=1;
    $colnumber = (int)EXTERNAL_LINKS_COLUMNS;
	$mycolopen = false;
	
$product_counter = tep_db_num_rows($links_query);


    while ($links = tep_db_fetch_array($links_query)) {
	
	$links_desc = urlencode($links['link_content']);
						$links_desc = str_replace("%0A","&nbsp;&nbsp;",$links_desc);
						$links_desc = urldecode($links_desc);
						$links_desc = str_replace("<br>","&nbsp;&nbsp;",$links_desc);
						$links_desc = str_replace("<br />","&nbsp;&nbsp;",$links_desc);
				$links_desc = stripslashes($links_desc);
	
	
				if(EXTERNAL_LINKS_FORMAT =='Row'){
?>
						  <tr>
							<td><table border="0" width="100%" cellspacing="1" cellpadding="2">
								  <tr><?php
								
								if (EXTERNAL_LINKS_SHOW_IMAGES == 'true'){
									?>
									<td width="<?php echo LINK_IMAGE_WIDTH; ?>" valign="middle" align="center"><?php
										if ($links['link_image']){
													 echo tep_thumb_image(DIR_WS_IMAGES . $links['link_image'], $links['link_title'], LINK_IMAGE_WIDTH, LINK_IMAGE_HEIGHT);
										}else{
													 echo '&nbsp;';
										 }
								 ?></td>
									<td valign="middle" align="left" class="main"><?php echo '<a href="http://' . $links['link_url'] .'" class="underlineLink" target="_blank"><b>' . $links['link_title'] .'</b></a><br>' . $links_desc; ?></td>
								<?php
								}else{
								?>
										<td valign="top" align="left" class="main"><?php echo '<a href="http://' . $links['link_url'] .'" class="underlineLink" target="_blank"><b>' . $links['link_title'] .'</b></a><br>' . $links_desc; ?></td>
								<?php
								}
								?>			
									</tr>
								</table></td>
						  </tr>
				
						 <tr>
							<td><?php echo tep_draw_separator('pixel_trans.gif', '100%', '10'); ?></td>
						  </tr>
	
<?php
			}else{
			// otherwise by column.
								// create row if mycol = 1
					if ($mycol==1){
								if ($myrow >1){ // create seperator for rows greater than 1
										// create loop to put a dotted horizontal line in.
										for ($i=1, $n=$colnumber+1; $i<$n; $i++) {
												if ($i == $colnumber){
													echo '<td height="9" class="horizontalBar">' . tep_draw_separator('pixel_trans.gif', '10', '1') . '</td>' ."\n";
													echo '</tr>' . "\n";
												}else{
													echo '<td height="9" align="left" class="horizontalBar">' . tep_draw_separator('pixel_trans.gif', '10', '1') . '</td>' ."\n";
													echo '<td height="9" width="9" align="left">' . tep_draw_separator('pixel_trans.gif', '9', '9') . '</td>' ."\n";
												}
										}
					
								}
						echo "<tr>\n"; // open row.
						$mycolopen = true; // mark as column open (used later to close off unused cells.
					}

						$mytd = '<td width="' . round(100/$colnumber) . '%" align="center" valign="top" class="main">'; // create cell
						

						
						if (EXTERNAL_LINKS_SHOW_IMAGES == 'true'){
								if ($links['link_image']){
									$mytd .= '<a href="http://' . $links['link_url'] .'" class="underlineLink" target="_blank">' . tep_thumb_image(DIR_WS_IMAGES . $links['link_image'], $links['link_title'], LINK_IMAGE_WIDTH, LINK_IMAGE_HEIGHT) . '</a><br>';
								}
						}
						
						$mytd .= '<a href="http://' . $links['link_url'] .'" class="underlineLink" target="_blank"><b>' . $links['link_title'] .'</b></a><br>' . $links['link_content'];
	
	
						// close off cell
						if ($mycol == $colnumber){ // maximum column met therefore close column and row.
							$mytd .='</td>' ."\n" . '</tr>';
							$mycol =1;
							$myrow ++;
							$mycolopen = false;
						}
				
						if ($mycolopen == true){
							$mytd .= '</td>' ."\n"; // close of current cell and put a divider in.
							
							$mytd .='<td width="9" align="center" class="verticalBar">' . tep_draw_separator('pixel_trans.gif', '9', '9') . '</td>' ."\n";
							$mycol ++;
						}
			
			echo $mytd; // echo the current cell and return to the while.
			
			} // end of if

			

} // end of while

			if ($mycolopen==true){
			
				for ($i=$mycol, $n=$colnumber+1; $i<$n; $i++) {
			
						if ($i == $colnumber){
							echo '<td>' . tep_draw_separator('pixel_trans.gif', PRODUCTLISTING_IMAGE_WIDTH, PRODUCTLISTING_IMAGE_HEIGHT) . '</td>' ."\n";
							echo '</tr>' . "\n";
						}else{
							echo '<td>' . tep_draw_separator('pixel_trans.gif', PRODUCTLISTING_IMAGE_WIDTH, PRODUCTLISTING_IMAGE_HEIGHT) . '</td>' ."\n";
							echo '<td width="9" align="center" class="verticalBar">' . tep_draw_separator('pixel_trans.gif', '9', '9') . '</td>' ."\n";
						}
				}
						
		    }

				if(EXTERNAL_LINKS_FORMAT =='Row'){
 if($product_counter >0){
?>
		  <tr>
                <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo $links_splitup->display_count(TEXT_DISPLAY_NUMBER_OF_LINKS);?></td>
                    <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $links_splitup->display_links(MAX_DISPLAY_LINKS_LISTING_VALUE, tep_get_all_get_params(array('page', 'info'))); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
}
}else{
 if($product_counter >0){
?>
		  <tr>
                <td <?php echo 'colspan="' . (($colnumber*2)-1) . '"'; ?>><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo $links_splitup->display_count(TEXT_DISPLAY_NUMBER_OF_LINKS);?></td>
                    <td align="right" class="smallText"><?php echo TEXT_RESULT_PAGE . ' ' . $links_splitup->display_links(MAX_DISPLAY_LINKS_LISTING_VALUE, tep_get_all_get_params(array('page', 'info'))); ?></td>
                  </tr>
                </table></td>
              </tr>
<?php
}
}
?>
	</table>