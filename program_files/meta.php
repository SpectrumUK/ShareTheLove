<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.

// the meta file is included into a layout template file to echo dynamic page titles, descriptions etc..  as well as default javascript code
// ran by contents.
?>
<title><?php if(isset($page_title)&& strlen($page_title)>0) {
				echo $page_title;
				}else{
				echo SHOP_TITLE;
				} ?></title>

<?php if (isset($additional_meta) && strlen($additional_meta)>0){
 ?>
<link href="<?php echo $bref;?>favicon.ico" rel="shortcut icon" />
<meta name="description" content="<?php echo $additional_meta;?>" />
<?php
}else{
?>
<link href="<?php echo $bref;?>favicon.ico" rel="shortcut icon" />
<meta name="description" content="<?php echo METATAG_DESCRIPTION;?>" />
<?php
}
?>
<?php if (isset($additional_keywords) && strlen($additional_keywords)>0){
 ?>
<meta name="keywords" content="<?php echo $additional_keywords;?>" />
<?php
}else{
?>
<meta name="keywords" content="<?php echo METATAG_KEYWORDS;?>" />
<?php
}
?>

<?php
	if (isset($dsv_page_no_index) && $dsv_page_no_index == 'true'){
		// show a no index no follow  meta
		?>
<meta name="robots" content="NOINDEX, NOFOLLOW" />
<?php		
}else{
	// show standard meta
	?>
<meta name="robots" content="all" />
<meta name="rating" content="general" />
<meta name="revisit-after" content="7 days" />
<?php
	}
?>
<meta name="language" content="<?php echo $dsv_html_language;?>" />
<meta name="designer" content="DesignShops Ecommerce" />
<?php
if (isset($canonical_link) && strlen($canonical_link)>10){
?>
<link rel="canonical" href="<?php echo $canonical_link; ?>" />
<?php
}


?>

<base href="<?php echo $bref;?>" />
<?php
// layouts stylesheet specific items.

// specific page stylesheet
  if (isset($specific_stylesheet) && strlen($specific_stylesheet)>1){
  		 echo '<link href="' . $bref . $dsv_system_folder_prefix . 'styles/' . $specific_stylesheet . '" rel="stylesheet" type="text/css" />' . "\n";
	}

// fancybox (lightbox)

echo '<link href="' . $bref . $dsv_system_folder_prefix . 'styles/default/' . 'jquery.fancybox-1.3.4.css" rel="stylesheet" type="text/css" media="screen"/>' . "\n";


	// Change of JQUERY version for Mancave amends done via external company.  need migrate script as well to keep menu operational as
	// new version of query removes the .hover aspect used for the dropdown menu.
	// Simon will need to come up with a fix for this so the migrate script can be removed.
	?>
<script type="text/javascript" src="<?php echo $bref . $dsv_system_folder_prefix;?>scripts/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo $bref . $dsv_system_folder_prefix;?>scripts/jquery-migrate-1.2.1.js"></script>
<?php
/*
// PREVIOUS JQUERY USED
<script type="text/javascript" src="<?php echo $bref . $dsv_system_folder_prefix;?>scripts/jquery.js"></script>

*/


?>
<script type="text/javascript" src="<?php echo $bref . $dsv_system_folder_prefix;?>scripts/jquery.fancybox-1.3.4.pack.js"></script>
<script type="text/javascript" src="<?php echo $bref . $dsv_system_folder_prefix;?>scripts/main.js"></script>


<?php
if (isset($dsv_dynamic_form_id) && (int)$dsv_dynamic_form_id > 0){
	?>
<script type="text/javascript" src="<?php echo $bref . $dsv_system_folder_prefix ;?>scripts/dynamic_forms.js"></script>
<?php
}
?>

<!-- Start J Query Command -->

<script type="text/javascript">
$(document).ready(function() {
	<?php if (isset($jquery_additional_code)){
			echo $jquery_additional_code;
			}
	?>

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
	if (full_url == '<?php echo $bref;?>#'){
		event.preventDefault();
		$(this).blur();
	}
	});

	// disable banner thumbnail click
	$(".dsScrollT a").click(function(event){
	
	//get the full url 
	var full_url = this.href;
	if (full_url == '<?php echo $bref;?>#'){
		event.preventDefault();
		$(this).blur();
	}
	});


	// disable banner icon click
	$(".dsScrollIcon a").click(function(event){
	
	//get the full url 
	var full_url = this.href;
	if (full_url == '<?php echo $bref;?>#'){
		event.preventDefault();
		$(this).blur();
	}
	});
	

	// disable lightbox thumbnail click
	$(".dsGalleryT a").click(function(event){
	
	//get the full url 
	var full_url = this.href;
	if (full_url == '<?php echo $bref;?>#'){
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






<?php


  if ($dsv_request_type == 'NONSSL') {
?>
<script type="text/javascript" src="<?php echo $bref . $dsv_system_folder_prefix;?>scripts/flash.js"></script>
<?php
}else{
?>
<script type="text/javascript" src="<?php echo $bref . $dsv_system_folder_prefix;?>scripts/sslflash.js"></script>
<?php
}

// END OF INSERTING MENU SCRIPTS
// #############################



// specific javascript code.
  if (isset($specific_javascript_code)&& strlen($specific_javascript_code)>1){
  		include($specific_javascript_code . '.php');
	}





// make breadcrumb text uppercase (if thats what has been requested in config)
// its not just a matter of simple str_replace on the whole string because that would change text inside of the URLs as well.

if (isset($dsv_breadcrumb)){
	
	if (UPPERCASE_BREADCRUMBS == 'true'){
		$new_crumb = '';
				$crumb_split = explode('</a>', $dsv_breadcrumb);
				
				
					foreach ($crumb_split as $value){
							$crumb_start = explode('">' , $value);
								
								$size = sizeof($crumb_start);
								
								// now put it all back together
								foreach($crumb_start as $id => $item){
										if (($id == ($size - 1)) && $size > 1){
											$new_crumb .= ds_strtoupper($item) . '</a>';
										}else{
											if ($size > 1){
												$new_crumb .= $item . '">';
											}else{
												$new_crumb .= $item;
											}
										}
								
								}
					}
		$dsv_breadcrumb = $new_crumb;
		unset($new_crumb);
	}
}else{
	$dsv_breadcrumb = '';
}

?>