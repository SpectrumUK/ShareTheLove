<!DOCTYPE html>
<html lang="<?php echo $dsv_html_language;?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $dsv_html_charset;?>" />
<meta name="content-language" content="<?php echo $dsv_content_language;?>" />

<?php 

require('program_files/meta.php');
?>

<!---  ADD STYLE SHEETS -->

<?php /*<link href="<?php echo $bref;?>styles/default/layout.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $bref;?>styles/default/general.css" rel="stylesheet" type="text/css" />


<!--[if IE 6]>
<link href="<?php echo $bref;?>styles/default/ie.css" rel="stylesheet" type="text/css" />
<![endif]--> */?>


<?php
echo $top_manual_items;
?>


</head>
<body>

<div id="contentHolder">
	<?php include ($content_include);?>
</div>

<?php
echo $bottom_manual_items;
?>

</body>
</html>