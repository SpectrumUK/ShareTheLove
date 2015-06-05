<div id="dsContent">
    <div class="dsMETAleft">
    	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo ds_strtoupper(TRANSLATION_ACCOUNTS_MY_ACCOUNT); ?></h1>
		<p><?php echo TRANSLATION_ACCOUNTS_WELCOME_BACK;?> <strong><?php echo $dsv_customer_first_name . ' ' . $dsv_customer_last_name;?></strong></p><p><?php echo TRANSLATION_ACCOUNTS_WELCOME_MESSAGE;?></p>
        <?php
				 // echo any error.
				 
				 if (isset($dsv_account_error) && strlen($dsv_account_error)>1){
				 	echo $dsv_account_error;
				 }
				
				?>
        <div class="dsACSection">
        <h2><?php echo strtoupper(TRANSLATION_ACCOUNTS_RECENT_ORDERS); ?></h2>

		<?php
		
			
			if (is_array($dsv_recent_orders) && sizeof($dsv_recent_orders)>0){
			// we have orders to show.
			
				foreach($dsv_recent_orders as $item){
?>
                  <div class="dsACOrder">
				  <div class="dsACCol"><strong><?php echo TRANSLATION_WORD_DATE;?>:</strong> <?php echo $item['order_date'] . '<br><strong>' . TRANSLATION_CHECKOUT_ORDER_REFERENCE . ':</strong> ' .  $item['order_id']; ?></div>
				  <div class="dsACCol"><?php echo '<strong>' . TRANSLATION_BASKET_TOTAL . ':</strong> ' . $item['order_total'] . '<br><strong>' . TRANSLATION_WORD_STATUS . ':</strong> ' . $item['order_status']; ?></div>
				  <div class="dsACBtn"><?php echo '<a href="' . dsf_link('order_details.html', 'order_id=' . $item['order_id'], 'SSL') . '">' . dsf_image_button($dsv_view_button, TRANSLATION_WORD_VIEW, 'align="middle"') . '</a>'; ?></div>
				  </div>
				  
                  
			<?php
				} // end foreach order

					  if ($dsv_total_orders > 3) {
			?>
			
							  <div class="dsACVallBtn">
									<?php echo '<a href="' . dsf_link('account_history.html', '', 'SSL') . '" >' . dsf_image_button('view_all_orders_btn.gif', TRANSLATION_ACCOUNTS_VIEW_ALL) . '</a>'; ?>
							  </div> 	
								
					 <?php
					 }
					 ?>


			<?php
		}else{
			?>
		<p><?php echo TRANSLATION_ACCOUNTS_NO_PURCHASES;?></p>
			<?php
		}
			?>
		</div>
    </div>
    <div class="dsMETAright">
        <?php include ('custom_modules/default/ac_menu.php');?>
    </div>
</div>