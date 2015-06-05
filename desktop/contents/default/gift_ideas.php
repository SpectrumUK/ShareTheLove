<?php
// get details of current guide if any.
if (isset($_GET['gift'])){
	$gift_id = (int)$_GET['gift'];
}else{
	$gift_id = 1;
}

// get the guides information from the database.
	$gift_info_query = tep_db_query("select * from gift_ideas where gift_id='" . $gift_id . "'");
	$gift_info = tep_db_fetch_array($gift_info_query);



?>
<script src="includes/more-show-hide.js" type="text/javascript"></script>
<!--content start --><div id="content">
 <img src="img/giftideas_h1.gif" alt="Russell Hobbs Gift Ideas" width="102" height="31" />
 
 <div class="submenu"><ul>
			<?php
		  			 echo '<li>' . '<a href="' . tep_href_link(FILENAME_HOME) . '">Home</a></li><li>|</li>' . "\n";
		  			 echo '<li>' . '<a href="' . tep_href_link(FILENAME_GIFTS) . '">Gift Ideas</a></li>' . "\n";
				
				if ($gift_id > 1){
					 echo '<li>|</li>' . '<li><a href="' . tep_href_link(FILENAME_GIFTS, 'gift=' . $gift_id) . '">' . $gift_info['gift_title'] . '</a></li>';
		 		}
				 ?>
</ul></div>
 
<div id="about_rh"><div class="main_img"><?php echo tep_image(DIR_WS_IMAGES . $gift_info['gift_image'], $gift_info['gift_title']);?></div>
  <div class="about_left"><?php echo tep_image(DIR_WS_IMAGES . $gift_info['gift_header_image'], $gift_info['gift_header_title']);?>
    <?php
	echo '<div>' . $gift_info['gift_text'] . '</div>';


// gift products routine
$c_accessory = array();

$r_accessories = 0;


if ((int)$gift_info['gift_prod1'] > 0){
	$c_accessory[] = $gift_info['gift_prod1'];
	$r_accessories ++;
}
if ((int)$gift_info['gift_prod2'] > 0){
	$c_accessory[] = $gift_info['gift_prod2'];
	$r_accessories ++;
}
if ((int)$gift_info['gift_prod3'] > 0){
	$c_accessory[] = $gift_info['gift_prod3'];
	$r_accessories ++;
}

if ((int)$gift_info['gift_prod4'] > 0){
	$c_accessory[] = $gift_info['gift_prod4'];
	$r_accessories ++;
}

 // we have a gift product therefore show items.
 if ($r_accessories >0){
 ?>
	  <div class="rel_prods">
		<ul>
				<?php
			//	$c_accessory = explode("~", $product_info_values['products_accessories']);
				$accessory_count = 0;
				foreach($c_accessory as $acc_item) {
					// at this point each accessory is in the format product_id::category_id
					

					 $accessory_info_query = tep_db_query("select p.products_id, pd.products_name, pd.products_description, pd.products_othernames, p.products_model, p.products_largeimage, p.products_price, p.products_tax_class_id, p.rrp_price, p.allow_purchase, p.web_exclusive from " . TABLE_PRODUCTS . " p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on (p.products_id = pd.products_id) where p.products_status = '1' and p.products_id = '" . (int)$acc_item . "'");
						$accessory_info_values = tep_db_fetch_array($accessory_info_query);
					
						if ($acc_price = tep_get_products_special_price($accessory_info_values['products_id'])) {
						  $accessory_price = $currencies->display_price($acc_price, tep_get_tax_rate($accessory_info_values['products_tax_class_id']));
						} else {
						  $accessory_price = $currencies->display_price($accessory_info_values['products_price'], tep_get_tax_rate($accessory_info_values['products_tax_class_id']));
						}

						if($accessory_info_values['products_id']){
							// we have an item therefore show it.
								$accessory_count ++;
								if ($accessory_count >1){
									$accessory_count =0;
								}
							
							if ($accessory_count == 1){
							?>
							<li class="listingProductSeperator"><?php
							}else{
							?>
							<li><?php
							}
							?>
							<?php echo '<a href="' . tep_product_link($accessory_info_values['products_id'],$accessory_info_values['products_name']) . '">' .tep_image(DIR_WS_IMAGES_SIZED . 'details/gift_' . $accessory_info_values['products_largeimage'], $accessory_info_values['products_name'], '150', '169') . '</a>';?>
							<?php echo '<br>' . $accessory_info_values['products_name'];?><br />
							<?php
							if ((int)$accessory_info_values['allow_purchase'] == 1){ // allow purchase
									echo '<span class="listingPrice">';
									if ($accessory_info_values['rrp_price'] > 0){
										echo 'RRP:' . $currencies->display_price($accessory_info_values['rrp_price'],0) . ' : ';
									}
									
									echo 'Offer: ' . $accessory_price . '<br />';
									echo '<br />';
									echo '</span';
									echo '<a href="' . tep_product_link($accessory_info_values['products_id'],$accessory_info_values['products_name']) . '">' . tep_image_button('button_more_info.gif', 'More Information') . '</a>';
									echo '<a href="' . tep_href_link(FILENAME_SHOPPING_CART, 'action=buy_now&products_id=' . $accessory_info_values['products_id'] . '&ppid=' . $accessory_info_values['products_id'] . '&ccid=' . $current_category_id, 'NONSSL') . '">' . tep_image_button('button_buy.gif', 'Add to Basket') . '</a>';
							}else{
									echo '<br><br>' . '<a href="' . tep_product_link($accessory_info_values['products_id'],$accessory_info_values['products_name']) . '">' . tep_image_button('button_more_info.gif', 'More Information') . '</a>';
							}
							?>
							</li>
								<?php
						} // end of displaying the item (after double checking that it exists)
				} // end of for each accessory
		
			?>
		
		</ul>
	  </div>
	<?php
	
 } // end of if r_accessories >0;
 
// end of gift products routine.
	?>
  </div>

    
  <div class= "about_menu"><img src="img/guides_h1.gif" alt="Gift Guides" width="106" height="27" />
    <ul class="about_buttons">
	<?php
	$gift_info_query = tep_db_query("select gift_id, gift_title from gift_ideas where gift_id >'1' order by sort_order, gift_title");
	// $gift_info_query = tep_db_query("select gift_id, gift_title from gift_ideas where gift_id <>'" . (int)$gift_id . "' order by sort_order, gift_title");
	while ($gift_info = tep_db_fetch_array($gift_info_query)){
		echo '<li><a href="' . tep_href_link(FILENAME_GIFTS, 'gift=' . $gift_info['gift_id']) . '" class="about_but">' . $gift_info['gift_title'] . '</a></li>';
	}
?>
    </ul>
</div>
</div>
  </div>
<!--end of contents -->