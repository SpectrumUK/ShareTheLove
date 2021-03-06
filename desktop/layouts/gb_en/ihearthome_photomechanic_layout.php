<!DOCTYPE html>
<html lang="<?php echo $dsv_html_language;?>"><head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $dsv_html_charset;?>" />
<meta name="content-language" content="<?php echo $dsv_content_language;?>" />

<meta charset="utf-8">
<?php

if ($action == 'success'){
?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta property="fb:app_id" content="549385165194725" />
		<meta property="og:type" content="website" /> 
		<meta property="og:title" content="Russell Hobbs - I Love Home" />
		<meta property="og:site_name" content="Russell Hobbs - I Love Home" />
		<meta property="og:description" content="<?php echo $image_upload_details['text_five'];?>" />
		<meta property="og:url" content="<?php echo str_replace("http:", "https:" , $user_image_details['url']);?>" />
<script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/vendor/modernizr-2.6.2.min.js"></script>
<script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/jquery-1.9.1.min.js" type="text/javascript"></script>
		<script>
		window.fbAsyncInit = function () {
			$(document).ready(function () {
				initFBApp();
			});
		};
		
		function initFBApp(){
			FB.init({
				appId: 549385165194725,
				channelUrl: '<?php echo $SSL_bref;?>channel.php',
				status: true,
				xfbml: true
			});
		}
		</script>
        
        <!---  ADD STYLE SHEETS -->

<link href="<?php echo $SSL_bref;?>styles/default/layout.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $SSL_bref;?>styles/default/general.css" rel="stylesheet" type="text/css" />

<!--- IHEARTHOME PHOTO MECHANIC STYLE SHEETS -->
<link rel="stylesheet" href="<?php echo $SSL_bref;?>desktop/styles/ihearthome/mechanic/ilovehomestyles.css">

<!--[if IE 6]>
<link href="<?php echo $bref;?>styles/default/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->

<!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
<?php 
}else{
?>
  

<?php 

//require('program_files/meta.php');
?>

<!---  ADD STYLE SHEETS -->

<link href="<?php echo $SSL_bref;?>styles/default/layout.css" rel="stylesheet" type="text/css" />
<link href="<?php echo $SSL_bref;?>styles/default/general.css" rel="stylesheet" type="text/css" />

<!--- IHEARTHOME PHOTO MECHANIC STYLE SHEETS -->
<link rel="stylesheet" href="<?php echo $bref;?>desktop/styles/ihearthome/mechanic/ilovehomestyles.css">

<!--[if IE 6]>
<link href="<?php echo $bref;?>styles/default/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->
		
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

<script type="text/javascript">

// Config Vars

var _appURL = "<?php echo $SSL_bref;?>";
var _webserviceURL = "<?php echo $SSL_bref;?>image_upload.html?mechanicID=1&action=ajax_submit";
var _unsupportedURL = "<?php echo $SSL_bref;?>/unsupported.html";
var _submitFormThankyouURL = "<?php echo $SSL_bref;?>image_upload.html?mechanicID=1&action=success";
var _facebookImageHandlerFile = "<?php echo $SSL_bref;?>imageproxy.php";
var _fbRedirectPath = "<?php echo $SSL_bref;?>image_upload.html?mechanicID=1";

var _termsConditionsTitle = '<?php echo $image_upload_details['text_seven'];?>';
var _compFormTitle = '<?php echo TRANSLATION_USER_CUSTOM_EIGHT;?>';
var _tellUsAboutItTitle = '<?php echo $image_upload_details['text_one'];?>';
var _pickPhotoTitle = '<?php echo TRANSLATION_USER_PICK_PHOTO;?>';
var _cropItTitle = '<?php echo TRANSLATION_USER_IMAGE_CROP;?>';
var _chooseFilterTitle = '<?php echo TRANSLATION_USER_IMAGE_SELECT_FILTER;?>';
var _compFormBtnText = '<?php echo TRANSLATION_USER_CUSTOM_SEVEN;?>';
var _chooseFilterBtnText = '<?php echo TRANSLATION_USER_IMAGE_CONTINUE;?>';
var _compMechanicURL = "/image_upload.html?mechanicID=1";
var _fbProfilePicAlt = '<?php echo $image_upload_details['text_five'];?>';

var _errorSendEntry = "Sorry there was an issue\nwith your entry.\n\nPlease try again later.";
var _errorPostAjax = "Sorry there was an issue\nconnecting to the server.\n\nPlease try again later.";
var _errorUploadFormat = "\n\nIncompatible image file.\nPlease select again.";
var _errorImageTooLarge = "Sorry!\nThat image is too large.\nPlease select a\nsmaller image.";
var _errorReadingFile = "Sorry there was an issue\nreading this file.\n\nPlease try another.";
var _errorConnectingFacebook = "Sorry there was an issue\nconnecting to Facebook.\n\nPlease try again later.";
var _errorfbNoPhotos = "We are unable to find any Facebook images at this time. Please go back and choose from another option.";

</script>

<!--- IHEARTHOME PHOTO MECHANIC SCRIPTS -->
<script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/vendor/modernizr-2.6.2.min.js"></script>
<script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/jquery-1.9.1.min.js" type="text/javascript"></script>
<script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/easeljs-0.7.0.min.js" type="text/javascript"></script>
<script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/preloadjs-0.4.0.min.js" type="text/javascript"></script>
<script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/base64.js" type="text/javascript"></script>
<script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/jpeg_encoder.min.js" type="text/javascript"></script>
<script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/russell-hobbs-comp-mechanic.js"></script>
<script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/vendor/swfobject.js" type="text/javascript"></script>

<?php
echo $top_manual_items;
?>

<script type="text/javascript">
            var swfVersionStr = "0";
            var xiSwfUrlStr = "";
            var flashvars = {};
            var params = {};
            params.quality = "high";
            params.bgcolor = "#ffffff";
            params.allowscriptaccess = "sameDomain";
            var attributes = {};
            attributes.id = "webcam";
            attributes.name = "webcam";
            attributes.align = "middle";
            swfobject.embedSWF(
                "<?php echo $SSL_bref;?>/flash/webcam.swf", "flashContent", "315", "315", swfVersionStr, xiSwfUrlStr, flashvars, params, attributes);
        </script>
		<style>
		#fallbackInput{
			margin-bottom: 14px;
		}
		</style>

<?php }
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

<div id="fb-root"></div>

<?php //include('custom_modules/default/cookie_bar.php'); ?>

<div id="headerHolder"><?php include ('/desktop/custom_modules/default/header.php');?></div>
<div class="clear"></div>

<div id="IHeartHome_Container">
		<?php include("/desktop/contents/uk/ilovehome_photomechanic.php");?>
</div>
<div class="clear"></div>
<div id="footerHolder"><?php include('/desktop/custom_modules/default/footer.php');?></div>

<?php
echo $bottom_manual_items;
?>
<!-- Facebook Conversion Code for I Heart Home Entry -->
<script>(function() {
  var _fbq = window._fbq || (window._fbq = []);
  if (!_fbq.loaded) {
    var fbds = document.createElement('script');
    fbds.async = true;
    fbds.src = '//connect.facebook.net/en_US/fbds.js';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(fbds, s);
    _fbq.loaded = true;
  }
})();
window._fbq = window._fbq || [];
window._fbq.push(['track', '6022822208353', {'value':'0.00','currency':'GBP'}]);
</script>
<noscript><img height="1" width="1" alt="" style="display:none" src="https://www.facebook.com/tr?ev=6022822208353&amp;cd[value]=0.00&amp;cd[currency]=GBP&amp;noscript=1" /></noscript>

</body>
</html>