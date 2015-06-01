<!DOCTYPE html>
<html lang="<?php echo $dsv_html_language;?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $dsv_html_charset;?>" />
<meta name="content-language" content="<?php echo $dsv_content_language;?>" />

<script src="<?php echo $bref;?>scripts/cufon-yui.js" type="text/javascript"></script>
<script src="<?php echo $bref;?>scripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="<?php echo $bref;?>scripts/Avenir_35_300.font.js" type="text/javascript"></script>
<script src="<?php echo $bref;?>scripts/Avenir_45_400.font.js" type="text/javascript"></script>
<script type="text/javascript">
		Cufon.replace('h1');
		Cufon.replace('h2');
		Cufon.replace('h6');
		Cufon.replace('h4', { fontFamily: 'Avenir 45' });
</script>

<?php 
require('program_files/meta.php');

?>
<!---  ADD STYLE SHEETS -->

<link href="<?php echo $bref;?>styles/default/layout.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $bref;?>styles/default/general.css" rel="stylesheet" type="text/css" />


<!--[if IE 6]>
<link href="<?php echo $bref;?>styles/default/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->


<?php

echo $top_manual_items;
?>

<script language="javascript" type="text/javascript"> 
<!-- ; 
function dojump(objSelect) { 
url = objSelect.options[objSelect.selectedIndex].value; 
if (url!="") location.href = url;
} 
// --> 
</script> 

<script type="text/javascript">
<!--
	function trackBasketAdd(){
	Image1= new Image(1,1);
	Image1.src = "https://tsw0.com/7171/?aid=1&value=non";
}

//-->
</script>

<script type="text/javascript">
var addthis_config = {
    data_track_clickback: true
}
</script>


</head>
<body>
<?php include('custom_modules/default/cookie_bar.php'); ?>

<!-- Header Holder -->
<div id="headerHolder">
	<div id="headerContainer"><?php include ('custom_modules/default/header.php');?></div>
</div>
<!-- Content Holder -->
<div id="contentHolder"><?php include($content_include);?></div>
<div class="clear"></div>
<!-- Footer Holder -->
<div id="footerHolder">
	<div id="footerContainer"><?php include('custom_modules/default/footer.php');?></div>
</div>

<?php
echo $bottom_manual_items;
?>

<script type="text/javascript"> Cufon.now(); </script>
<script src="http://t.trackedlink.net/_dmpt.js" type="text/javascript"></script>
<script type="text/javascript">
_dmSetDomain("www.russellhobbs.co.uk");
</script>
</body>
</html>