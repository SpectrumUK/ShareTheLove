<!DOCTYPE html>
<html lang="<?php echo $dsv_html_language;?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $dsv_html_charset;?>" />
<meta name="content-language" content="<?php echo $dsv_content_language;?>" />

<?php 

//require('program_files/meta.php');
?>
<?php $parent_details = dsf_get_individual_seasonal_article_details(16);?>
<meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="fb:app_id" content="549385165194725" />
		<meta property="og:type" content="website" /> 
		<meta property="og:title" content="<?php echo $user_image_details['text_one'] . ' ' . $user_image_details['mechanic']['mechanic_image_three_text'] . ' ' . $user_image_details['text_two'];?>" />
		<meta property="og:site_name" content="<?php echo $user_image_details['text_one'] . ' ' . $user_image_details['mechanic']['mechanic_image_three_text'] . ' ' . $user_image_details['text_two'];?>" />
		<meta property="og:description" content="<?php echo $parent_details['user_photo_mechanic_details']['text_five'];?>" />
		<meta property="og:url" content="<?php echo str_replace("http:", "https:" , $user_image_details['url']);?>" />
        		<!-- FB Image - replace with users uploaded image -->
			<meta property="og:image" content="<?php echo $SSL_bref . 'images/' . $user_image_details['image_one'];?>"/>
	<!-- FB Image -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!---  ADD STYLE SHEETS -->

<link href="<?php echo $bref;?>desktop/styles/default/layout_ilovehome.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $bref;?>desktop/styles/default/general.css" rel="stylesheet" type="text/css" />      
<link href="<?php echo $bref;?>desktop/styles/ihearthome/bootstrap.min.css" rel="stylesheet" type="text/css" media="all"/>
<link href="<?php echo $bref;?>desktop/styles/ihearthome/base.min.css" rel="stylesheet" type="text/css" media="all"/>
<link href="<?php echo $bref;?>desktop/styles/ihearthome/animate.min.css" rel="stylesheet" type="text/css" media="all"/>

<!--[if IE 6]>
<link href="<?php echo $bref;?>styles/default/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
        
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/jquery-1.11.0.min.js"></script>
<script src="<?php echo $bref;?>desktop/scripts/main.js"></script>
<!--- IHEARTHOME SCRIPTS -->
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/jquery.cycle2.min.js"></script>
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/bootstrap.min.js"></script>        
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/jquery.jcarousel.min.js"></script>
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/jcarousel.responsive.min.js"></script>
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/functions.min.js"></script>  
<script src="<?php echo $bref;?>desktop/scripts/ihearthome/functions.min.js"></script>  

<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e30341f35244d3a" async></script>
<script type="text/javascript">
var addthis_share = addthis_share || {}
addthis_share = {
	passthrough : {
		twitter: {
			text: "<?php echo $user_image_details['text_one'] . ' ❤ ' . $user_image_details['text_two'] . ' - ' . $parent_details['user_photo_mechanic_details']['text_five'] . ' - ' . $parent_details['url'];?>"
		}
	}
}
</script>

<?php
echo $top_manual_items;
?>
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
<script>
	$('.dropdown-toggle').dropdown()
</script>


        </div>
        <script src="//code.jquery.com/jquery.min.js"></script>
<?php
echo $bottom_manual_items;
?>
<!--
Start of DoubleClick Floodlight Tag: Please do not remove
Activity name of this tag: ilovehome landing page 2014
URL of the webpage where the tag is expected to be placed: http://uk.russellhobbs.com/ilovehome/
This tag must be placed between the <body> and </body> tags, as close as possible to the opening tag.
Creation Date: 11/21/2014
-->
<script type="text/javascript">
var axel = Math.random() + "";
var a = axel * 10000000000000;
document.write('<iframe src="http://3074717.fls.doubleclick.net/activityi;src=3074717;type=russe780;cat=ilove0;ord=' + a + '?" width="1" height="1" frameborder="0" style="display:none"></iframe>');
</script>
<noscript>
<iframe src="http://3074717.fls.doubleclick.net/activityi;src=3074717;type=russe780;cat=ilove0;ord=1?" width="1" height="1" frameborder="0" style="display:none"></iframe>
</noscript>
<!-- End of DoubleClick Floodlight Tag: Please do not remove -->
</body>
</html>