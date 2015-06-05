<!-- body //-->
<div id="dsPROstrip" style="background-image: url('<?php echo dsf_image($seasonal_details['sub_title_image'],'','','','','YES');?>');">&nbsp;</div>
<div id="dsContent" class="dsARTContent">
    <div class="dsARTleft">
    
    <div class="breadCrumb">&nbsp;</div>
    <div class="clear"></div>
    	<h1 class="dsATitle"><?php echo ds_strtoupper($seasonal_details['text_one']);?></h1>
        <div class="dsMAtxt"><?php echo $seasonal_details['text_block_one'];?></div>
		<div class="clear"></div>
        <div><?php echo dsf_image($seasonal_details['title_image'], $seasonal_details['text_one']);?></div>
        <div class="clear"></div>
        <div class="dsMAtxt"><?php echo $seasonal_details['text_block_two'];?></div>
</div>                 
<div class="dsMETAright">&nbsp;</div>
<div class="clear"></div> 	
</div>s
<?php //echo dsf_print_array($seasonal_details);?>

<!-- body_eof //-->