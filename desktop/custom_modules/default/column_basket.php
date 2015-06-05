<?php

//check that we are not on a basket or checkout page because if
// we are we do not show the basket in the right column.

if(isset($dsv_hide_basket) && $dsv_hide_basket == 'true'){

// we don't show anything as we are hiding the basket on this page.


}else{ 
	
	// we can show the basket information if it exists.

	if (isset($dsv_column_basket) && is_array($dsv_column_basket)){
		?>
		  <div class="basket">
                
                <?php


		if ($dsv_column_basket['total_items'] >0){
			// we have items in the basket
			
			// loop through the products to show and put them into a table.
			// Note:  There is nothing wrong with creating a table in this way.  Tables are acceptable when using.
			// them to create a list of items in a speadsheet format.    It is not acceptable to use tables for
			// layout formatting.
			
			
					/*
					if(is_array($dsv_column_basket['products']) && sizeof($dsv_column_basket['products'])>0){
					
						foreach($dsv_column_basket['products'] as $item){
						
							echo '<tr>';
							echo '<td align="left">' . $item['qty'] . '</td>';
							echo '<td align="left">' . $item['products_name'] . '</td>';
							echo '<td align="right">' . $item['price'] . '</td>';
							
						
						} // end foreach
		
					} // end check of results.
					
					// now show totals.
						if (isset($dsv_column_basket['delivery_type']) && strlen($dsv_column_basket['delivery_type'])>1){
							echo '<tr>';
							echo '<td colspan="2" align="left">' . $dsv_column_basket['delivery_type'] . '</td>';
							echo '<td align="right">' . $dsv_column_basket['delivery_cost'] . '</td>';
						}
						
						if (isset($dsv_column_basket['voucher_total']) && strlen($dsv_column_basket['voucher_total'])>1){
							echo '<tr>';
							echo '<td colspan="2" align="left">Discount</td>';
							echo '<td align="right">- ' . $dsv_column_basket['voucher_total'] . '</td>';
						}
						*/
						
			if (isset($dsv_column_basket['basket_total']) && strlen($dsv_column_basket['basket_total'])>1){
				echo '<a href="' . dsf_link('basket.html') . '"><strong>' . $dsv_column_basket['basket_total'] . '</strong> (' . $dsv_column_basket['total_items']  . ')</a>';

			}
						?>	   
				
			   
		<?php	
		}else{
			// no items in the basket.


					/*
					
					if(is_array($dsv_column_basket['products']) && sizeof($dsv_column_basket['products'])>0){
					
						foreach($dsv_column_basket['products'] as $item){
						
							echo '<tr>';
							echo '<td align="left">' . $item['qty'] . '</td>';
							echo '<td align="left">' . $item['products_name'] . '</td>';
							echo '<td align="right">' . $item['price'] . '</td>';
							
						
						} // end foreach
		
					} // end check of results.
					
					// now show totals.
						if (isset($dsv_column_basket['delivery_type']) && strlen($dsv_column_basket['delivery_type'])>1){
							echo '<tr>';
							echo '<td colspan="2" align="left">' . $dsv_column_basket['delivery_type'] . '</td>';
							echo '<td align="right">' . $dsv_column_basket['delivery_cost'] . '</td>';
						}
						
						if (isset($dsv_column_basket['voucher_total']) && strlen($dsv_column_basket['voucher_total'])>1){
							echo '<tr>';
							echo '<td colspan="2" align="left">Discount</td>';
							echo '<td align="right">- ' . $dsv_column_basket['voucher_total'] . '</td>';
						}
						*/
						
			if (isset($dsv_column_basket['basket_total']) && strlen($dsv_column_basket['basket_total'])>1){
			echo '<a href="' . dsf_link('basket.html') . '"><strong>' . $dsv_column_basket['basket_total'] . '</strong> (' . $dsv_column_basket['total_items']  . ')</a>';

						}
						?>
			<?php
		}

	?>
	</div>
          <?php /*<div class="delivery"><a href="<?php echo dsf_link('shipping.html');?>"><?php echo TRANSLATION_CUSTOM_TEXT_FOUR;?></a></div>*/?>
       
          
<div class="login">
          <?php
	// top nav bar.  decide if customer is already logged in,  if they are then these two links
	// should be logoff and my account.
	
	// Otherwise they should be login and register.
	if (isset($dsv_customer_id) && (int)$dsv_customer_id >0){
		// customer logged in.
		?>
		<a href="<?php echo dsf_link('logoff.html','','SSL');?>"><?php echo TRANSLATION_LOGOUT ;?></a><a href="<?php echo dsf_link('account.html','','SSL');?>"><?php echo TRANSLATION_ACCOUNTS_MY_ACCOUNT ;?></a>
		<?php
	}else{
		// customer not logged in.
		?>
          
          		<a href="<?php echo dsf_link('login.html','','SSL');?>"><?php echo TRANSLATION_ACCOUNTS_MY_ACCOUNT ;?></a>
                <?php
	}
		?>
          </div>
	<?php

	} // end of we have an array of items.

} // end we are not hiding the basket.
?>