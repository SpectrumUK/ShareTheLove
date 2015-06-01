<!DOCTYPE html>
<html lang="<?php echo $dsv_html_language;?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $dsv_html_charset;?>" />
<meta name="content-language" content="<?php echo $dsv_content_language;?>" />

<?php 

//require('program_files/meta.php');
?>

<!---  ADD STYLE SHEETS -->

<link href="<?php echo $bref;?>desktop/styles/default/layout_ilovehome.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $bref;?>desktop/styles/default/general.css" rel="stylesheet" type="text/css" />

<!--- IHEARTHOME STYLE SHEETS -->
<link href="<?php echo $bref;?>desktop/styles/ihearthome/bootstrap.min.css" rel="stylesheet" type="text/css" media="all"/>
<link href="<?php echo $bref;?>desktop/styles/ihearthome/animate.min.css" rel="stylesheet" type="text/css" media="all"/>
<link href="<?php echo $bref;?>desktop/styles/ihearthome/ihearthome.min.css" rel="stylesheet" type="text/css" media="all"/>

<!--[if IE 6]>
<link href="<?php echo $bref;?>styles/default/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--- IHEARTHOME SCRIPTS -->
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/jquery-1.11.0.min.js"></script>
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/jquery-ui.min.js"></script>
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/jquery.ui.touch-punch.min.js"></script>

<!-- carousel -->
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/jquery.cycle2.min.js"></script>
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/bootstrap.min.js"></script>        
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/jquery.jcarousel.min.js"></script>
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/jcarousel.responsive.min.js"></script>
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/functions.min.js"></script>

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
var addthis_config = {
    data_track_clickback: true
}
</script>


</head>
<body>
<!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-NH6ZBJ"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-NH6ZBJ');</script>
<!-- End Google Tag Manager -->
<?php include('custom_modules/default/cookie_bar.php'); ?>

<div id="headerHolder"><?php include ('custom_modules/default/header.php');?></div>
<div class="clear"></div>
<div id="contentHolder">
	<div class="container mainwidth">
		<?php include($content_include);?>
	</div>
</div>
<div class="clear"></div>
<div id="footerHolder"><?php include('custom_modules/default/footer.php');?></div>

<?php
echo $bottom_manual_items;
?>

</body>
</html>