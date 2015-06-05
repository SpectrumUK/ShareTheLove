 	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
	<div id="dspagesHeaderTitle">Web Exclusive Items</div>

<?php
				if ($dsv_list_type == 'grid'){
					include($dsv_modules . 'product_listing_column.php');
				}else{
					include($dsv_modules . 'product_listing.php');
				}
?>