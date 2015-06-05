<table align="center" border="0" cellspacing="0" cellpadding="10" class="thumbnailBox" >
<tr>
<td class="productHeading" align="center" colspan="2" height="30" valign="middle"><b><?php echo $product_info_values['products_name']; ?></b></td>
</tr>


		<tr>
		  <td align="left" valign="top">
				<table width="<?php echo (int)EXTRALARGE_IMAGE_WIDTH + 15; ?>" border="0" cellpadding="0" cellspacing="0" align="left">



					<?php
						if ($product_info_values['products_largeimage']) { // We have a large image.
					?>
						  <tr>
							<td width="1"><?php echo tep_draw_separator('pixel_trans.gif', '1', EXTRALARGE_IMAGE_HEIGHT); ?></td>
							<td align="left"><?php echo tep_image(DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_largeimage'], addslashes($product_info_values['products_name']), EXTRALARGE_IMAGE_WIDTH , EXTRALARGE_IMAGE_HEIGHT, 'name="pic' . $product_info_values['products_id'] . '"'); ?></td>
						  </tr>
				  <?php
				  	}else{
					?>
						  <tr>
							<td width="1"><?php echo tep_draw_separator('pixel_trans.gif', '1', LARGE_IMAGE_HEIGHT); ?></td>
							<td align="center"><?php echo tep_thumb_image(DIR_WS_IMAGES . 'error_noimageavailable.gif', addslashes($product_info_values['products_name']), EXTRALARGE_IMAGE_WIDTH , EXTRALARGE_IMAGE_HEIGHT, 'hspace="5" vspace="5"'); ?></td>
						  </tr>
					<?php
					}
					?>
			
				</table>
		
		  </td>
		  <td align="right">
		    
			<?php if($product_info_values['products_image']) {
		// only do small product thumbs if they exist.
		?>  
		<table width="160" cellpadding="0" cellspacing="0" border="0" class="thumbnailBox">
			<tr>
			 <td class="main" align="center">Select an Alternative Image to View</td>
			 </tr>
		
			  <tr>
			    <td align="center">&nbsp;<?php if($product_info_values['products_largeimage']) {
						 echo '<a href="javascript:LargeImage(\'pic' . $product_info_values['products_id'] . '\',\'\',\'' . DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_largeimage'] .'\',0);" onMouseDown="LargeImage(\'pic' . $product_info_values['products_id'] . '\',\'\',\'' . DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_largeimage'] .'\',0);" onMouseOver="SwapImage(\'pic' . $product_info_values['products_id'] . '\',\'\',\'' . DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_largeimage'] .'\',0)";>' . tep_image(DIR_WS_IMAGES_SIZED . 'details/thumb_' . $product_info_values['products_largeimage'], addslashes($product_info_values['products_name'] . ' CLICK FOR LARGER IMAGE'), PRODUCT_INFO_THUMBNAIL_WIDTH, PRODUCT_INFO_THUMBNAIL_HEIGHT, 'name="sml' . $product_info_values['products_id']. '" hspace="2" vspace="2"') . '</a>'; 
						 }?></td>
				</tr>
				<tr>
		        <td align="center">&nbsp;<?php if($product_info_values['products_image']) {
						echo '<a href="javascript:LargeImage(\'pic' . $product_info_values['products_id'] . '\',\'\',\'' . DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_image'] .'\',0);" onMouseDown="LargeImage(\'pic' . $product_info_values['products_id'] . '\',\'\',\'' . DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_image'] .'\',0)" onMouseOver="SwapImage(\'pic' . $product_info_values['products_id'] . '\',\'\',\'' . DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_image'] .'\',0)">' . tep_image(DIR_WS_IMAGES_SIZED . 'details/thumb_' . $product_info_values['products_image'], addslashes($product_info_values['products_name'] . ' CLICK FOR LARGER IMAGE'), PRODUCT_INFO_THUMBNAIL_WIDTH, PRODUCT_INFO_THUMBNAIL_HEIGHT, 'name="sml' . $product_info_values['products_id']. '" hspace="2" vspace="2"') . '</a>';
						}?></td>
			  </tr>
			   <tr>
			    <td align="center">&nbsp;<?php if($product_info_values['products_popimage']) {
						echo '<a href="javascript:LargeImage(\'pic' . $product_info_values['products_id'] . '\',\'\',\'' . DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_popimage'] .'\',0);" onMouseDown="LargeImage(\'pic' . $product_info_values['products_id'] . '\',\'\',\'' . DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_popimage'] .'\',0)" onMouseOver="SwapImage(\'pic' . $product_info_values['products_id'] . '\',\'\',\'' . DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_popimage'] .'\',0)">' . tep_image(DIR_WS_IMAGES_SIZED . 'details/thumb_' . $product_info_values['products_popimage'], addslashes($product_info_values['products_name'] . ' CLICK FOR LARGER IMAGE'), PRODUCT_INFO_THUMBNAIL_WIDTH, PRODUCT_INFO_THUMBNAIL_HEIGHT, 'name="sml' . $product_info_values['products_id']. '" hspace="2" vspace="2"') . '</a>';
						} ?></td>
				</tr>
				<tr>
		        <td align="center">&nbsp;<?php if($product_info_values['products_popflash']) {
						echo '<a href="javascript:LargeImage(\'pic' . $product_info_values['products_id'] . '\',\'\',\'' . DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_popflash'] .'\',0);" onMouseDown="LargeImage(\'pic' . $product_info_values['products_id'] . '\',\'\',\'' . DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_popflash'] .'\',0)" onMouseOver="SwapImage(\'pic' . $product_info_values['products_id'] . '\',\'\',\'' . DIR_WS_IMAGES_SIZED . 'details/super_' . $product_info_values['products_popflash'] .'\',0)">' . tep_image(DIR_WS_IMAGES_SIZED . 'details/thumb_' . $product_info_values['products_popflash'], addslashes($product_info_values['products_name'] . ' CLICK FOR LARGER IMAGE'), PRODUCT_INFO_THUMBNAIL_WIDTH, PRODUCT_INFO_THUMBNAIL_HEIGHT, 'name="sml' . $product_info_values['products_id']. '" hspace="2" vspace="2"') . '</a>';
						} ?></td>
			  </tr>
			</table>
		    
			<?php
			}else{
			echo '&nbsp;';
			}
			?>
			
		  </td>
		  </tr>







<tr>
<td class="productHeading" colspan="2" align="center"><a href="javascript:window.close()" class="main"><?php echo '[Close]'; ?></a></td>
</tr></table>