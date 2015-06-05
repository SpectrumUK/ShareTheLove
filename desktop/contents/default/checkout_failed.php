<div id="dsBasketMask" class="dsBasketS4"></div>
<div id="dsBasketHolder"></div>
<div id="contentHeader"></div>

<div id="dsContent">
		<div class="dsCHleft">
 		<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php 
if (isset($dsv_page_title) && strlen($dsv_page_title)>1){
	echo $dsv_page_title;
}else{
	echo strtoupper('Checkout Process Failed');
}
 ?></h1>
 <?php 
if (isset($dsv_page_text) && strlen($dsv_page_text)>1){
	echo '<p>' . $dsv_page_text . '</p>';
}else{
	echo 'Sorry<p>An error has occured somewhere in the checkout process, we shall contact you for further details.</p>';
}
?>
<p>Thank you for shopping with us.</p>
</div>
</div>
