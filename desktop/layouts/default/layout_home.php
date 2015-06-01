<!DOCTYPE html>
<html lang="<?php echo $dsv_html_language;?>">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="content-language" content="en-GB">

<title>Kettles, Toasters, Irons &amp; Kitchen Appliances - Russell Hobbs International</title>

<link href="http://uk.russellhobbs.com/favicon.ico" rel="shortcut icon">
<meta name="description" content="Free delivery on online orders direct from Russell Hobbs, the UK's leading small electrical appliance brand. Everything from kettles, toasters, irons, food preparation, table top, deep fryers, vacuum cleaners and cooking/baking appliances.">
<meta name="keywords" content="russell hobbs, kettles, toasters, irons, coffee makers, food preparation, tabletop cooking, cookware, vacuum cleaners">

<meta name="robots" content="all">
<meta name="rating" content="general">
<meta name="revisit-after" content="7 days">
<meta name="language" content="en">
<meta name="designer" content="DesignShops Ecommerce">
<link rel="canonical" href="http://uk.russellhobbs.com">

<base href="http://uk.russellhobbs.com/">
<link href="http://uk.russellhobbs.com/styles/default/home.css" rel="stylesheet" type="text/css">
<link href="http://uk.russellhobbs.com/styles/default/jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" media="screen">
<link href="http://uk.russellhobbs.com/styles/default/jcountdown.css" rel="stylesheet" type="text/css">
<script type="text/javascript" async="" src="http://www.google-analytics.com/ga.js"></script><script type="text/javascript" src="http://uk.russellhobbs.com/scripts/jquery.js"></script>
<script src="http://uk.russellhobbs.com/scripts/jquery-1.8.2.min.js"></script>

<script src="http://uk.russellhobbs.com/scripts/jquery.jcountdown.min.js"></script>
<script type="text/javascript" src="http://uk.russellhobbs.com/scripts/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="http://uk.russellhobbs.com/scripts/main.js"></script>



<!-- Start J Query Command -->

<script type="text/javascript">
$(document).ready(function() {
	
	// jump to tag
	$(".aScroll").click(function(event){
		$(this).blur();
	
	event.preventDefault();
	//get the full url 
	var full_url = this.href;
	//split the url by # and get the anchor target name
	var parts = full_url.split("#");
	var trgt = parts[1];
	//get the top offset of the target anchor
	var target_offset = $("#"+trgt).offset();
	var target_top = target_offset.top;
	//goto that anchor by setting the body scroll top to anchor top
	$('html, body').animate({scrollTop:target_top}, 500);
	});

	
	// disable menu click
	
	$("#dsuMenu ul li a").click(function(event){
	
	//get the full url 
	var full_url = this.href;
	if (full_url == 'http://uk.russellhobbs.com/#'){
		event.preventDefault();
		$(this).blur();
	}
	});

	// disable banner thumbnail click
	$(".dsScrollT a").click(function(event){
	
	//get the full url 
	var full_url = this.href;
	if (full_url == 'http://uk.russellhobbs.com/#'){
		event.preventDefault();
		$(this).blur();
	}
	});


	// disable banner icon click
	$(".dsScrollIcon a").click(function(event){
	
	//get the full url 
	var full_url = this.href;
	if (full_url == 'http://uk.russellhobbs.com/#'){
		event.preventDefault();
		$(this).blur();
	}
	});
	

	// disable lightbox thumbnail click
	$(".dsGalleryT a").click(function(event){
	
	//get the full url 
	var full_url = this.href;
	if (full_url == 'http://uk.russellhobbs.com/#'){
		event.preventDefault();
		$(this).blur();
	}
	});



	$("a.articleajax").fancybox({
		'hideOnContentClick': false,
		'overlayColor':'#000000', 
		'padding':'0',
		'scrolling': 'no',
		'centerOnScroll' : true 
	});





	// hover menus
	$("#dsuMenu ul li").hover(
        function () {
		$(this).children("ul").show();
		},function(){
		 $(this).children("ul").hide();
	});//hover

	$("#dsuMenu ul li ul li").hover(
        function () {
		$(this).children("ul").show();
		$(this).children("ul").show();
		},function(){
		$(this).children("ul").show();
		$(this).children("ul").show();
	});//hover

	// preload any important images
	dspreload();

});// document ready
</script>






<script type="text/javascript" src="http://uk.russellhobbs.com/scripts/flash.js"></script>

<!---  ADD STYLE SHEETS -->

<link href="http://uk.russellhobbs.com/styles/default/layout.css" rel="stylesheet" type="text/css">
<link href="http://uk.russellhobbs.com/styles/default/general.css" rel="stylesheet" type="text/css">


<!--[if IE 6]>
<link href="http://uk.russellhobbs.com/styles/default/ie.css" rel="stylesheet" type="text/css" />
<![endif]-->



<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-2697998-8']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>


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


<script type="text/javascript" id="waxCS">var WAX = function () { var _arrInputs; return { getElement: function (i) { return _arrInputs[i]; }, setElement: function(i){ _arrInputs=i; } } }(); function waxGetElement(i) { return WAX.getElement(i); } function coSetPageData(t, d){ if('wax'==t) { WAX.setElement(d);} }</script></head>
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