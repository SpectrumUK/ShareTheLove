<!DOCTYPE html>
<html lang="<?php echo $dsv_html_language;?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $dsv_html_charset;?>" />
<meta name="content-language" content="<?php echo $dsv_content_language;?>" />

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
var addthis_config = {
    data_track_clickback: true
}
</script>


</head>
<body>

<?php include('custom_modules/default/cookie_bar.php'); ?>

<div id="headerHolder"><?php include ('custom_modules/default/header.php');?></div>
<div class="clear"></div>
<div id="contentHolder"><?php include($content_include);?></div>
<div class="clear"></div>
<div id="footerHolder"><?php include('custom_modules/default/footer.php');?></div>

<?php
echo $bottom_manual_items;
?>

</body>
</html>