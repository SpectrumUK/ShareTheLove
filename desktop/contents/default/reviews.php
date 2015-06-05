<?php

// bazaar voice function for creating userToken
function bvEncodeUser($userID, $sharedkey){

		$userString = 'date=' . date('Ymd') . '&userid=' . $userID;
		
		return md5($sharedkey . $userString) . bin2hex($userString);
}

//shared Key provided by BV
$sharedKey = BAZAAR_JS_TWO;

// the user token
$encUser = bvEncodeUser($dsv_customer_id, $sharedKey);


//The product id of item wanting to be reviewed
if (isset($_GET['pID']) && $_GET['pID']){
	
	$dsv_product_id = (int)$_GET['pID'];
	unset($_GET['pID']);
		
} else {
	$dsv_product_id = 0;	
}
?>
<!-- BAzaar voice script for each page that will display something from bazaar voice-->
<script type="text/javascript"
	src="<?php echo BAZAAR_JS_ONE;?>">
</script>

<script type="text/javascript">
	$BV.ui("submission_container", {
		userToken: "<?php echo $encUser;?>"
	});
</script>

<div id="dsCRESTstrip">&nbsp;</div>
<div id="dsContent">
    <div id="BVSubmissionContainer"><!-- SUBMISSION CONTAINER--></div>
</div>
