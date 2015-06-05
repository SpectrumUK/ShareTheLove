<?php
// available content fields are:

//		$dsv_wtb_details['text_block_one'];
//		$dsv_wtb_details['text_block_two'];
//		$dsv_wtb_details['text_block_three'];
//		$dsv_wtb_details['page_image'];


		/*$banner_array = array('image_one' => $dsv_banner_one_image,
						 'thumb_one' => $dsv_banner_one_thumb,
						 'url_one' => $dsv_banner_one_url,
						 'url_one_window' => $dsv_banner_one_window,
						 'image_two' => $dsv_banner_two_image,
						 'thumb_two' => $dsv_banner_two_thumb,
						 'url_two' => $dsv_banner_two_url,
						 'url_two_window' => $dsv_banner_two_window,
						 'image_three' => $dsv_banner_three_image,
						 'thumb_three' => $dsv_banner_three_thumb,
						 'url_three' => $dsv_banner_three_url,
						 'url_three_window' => $dsv_banner_three_window,
						 'image_four' => $dsv_banner_four_image,
						 'thumb_four' => $dsv_banner_four_thumb,
						 'url_four' => $dsv_banner_four_url,
						 'url_four_window' => $dsv_banner_one_window,
						 'colour_one' => $banner_one_bak_colour,
						 'background_one' => $banner_one_bak_image,
						 'colour_two' => $banner_two_bak_colour,
						 'background_two' => $banner_two_bak_image,
						 'colour_three' => $banner_three_bak_colour,
						 'background_three' => $banner_three_bak_image,
						 'colour_four' => $banner_four_bak_colour,
						 'background_four' => $banner_four_bak_image
						 );
*/?>

<!-- body //-->
<div id="contentHeader"><?php /*echo dsf_background_scrollB($banner_array);*/ ?>&nbsp;</div>
<div id="dsContent">
    	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
        <div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
    	<div class="clear"></div>
        <div class="w2b">
    	<h1><?php echo ds_strtoupper(TRANSLATION_WHERETOBUY); ?></h1>
        <?php echo $dsv_wtb_details['text_block_one'];?>
        <?php echo $dsv_wtb_details['text_block_two'];?>
		<?php
  			if (is_array($dsv_wtb) && sizeof($dsv_wtb) >0){
  		?>
	<div class="dsWTBList">
      	<ul>
	  	<?php
	   		foreach($dsv_wtb as $item){
		?>
			<li><a href="<?php echo $item['wtb_link'];?>" target="_blank"><?php echo dsf_image($item['wtb_image'],$item['wtb_name']) . '<br /><span class="w2btxt">' . $item['wtb_name'] . '</span>';?></a></li>
		<?php
	   		}
      	?>
      	</ul>
        <div class="clear"></div>
        <div class="w2bshadow"><?php echo dsf_image('custom/w2b_shadow.png', '', '940', '19');?></div>
	</div>
<?php	  
  } // end if check

?>
	<?php echo $dsv_wtb_details['text_block_three'];?>
</div>
</div>