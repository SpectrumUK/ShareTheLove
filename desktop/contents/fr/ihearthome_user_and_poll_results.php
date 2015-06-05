<?php $parent_poll = dsf_get_individual_consumer_poll_details(6);?>
<?php
// this file can be either accessed directly as a seasonal_article  (when viewed as a standalone item)
// or as a child of the mancave item (where we include the file so everything is on one page).

// as such there are two possible arrays where our information could be in.

// STANDALONE - the details would be in seasonal_details

// CHILD - the details would be in $child  (as defined by the content page looping through the children) originally it will be within the $seasonal_details['children'] array.

// because of this we need to define where our data is and use it accordingly.   The easiest way is to check for the $child variable

// we will store the values we want to use into a new variable called $article_details
if (isset($child)){
	// we are being included as a child.
	$article_details = $child;
}else{
	// we are standalone.
	$article_details = $seasonal_details;
}

?>

<div class="col-sm-6">
<img class="img-responsive" src="../../../images/custom/ihearthome/layout/poll_replacement_fr.jpg" />
</div>




<div class="col-sm-6 nopaddingright">
    <div class="jcarousel-wrapper">
        <div class="jcarousel">
            <ul>
            <?php
				// loop through children
				foreach ($consumer_poll_details['related_complete_poll_items'] as $item){
					echo '<li class="statslilder">';
					?>
                    <div class="nopaddingoutter pull-left statsslider_img">
                        <?php echo dsf_image($item['poll_image_four'], $item['poll_title'], '', '', 'class="img-responsive"');?>
                    </div>
                    <div class="statsbgbox">
                        <div class="statsbgbox_content">
                            <p class="font20 gothamlight"><?php echo sr_heart_replace($item['text_success']);?></p>
                            
                            <?php echo sr_heart_replace($item['text_block_success']);?>
                            <div class="height5"></div>
                            <a href="<?php echo $SSL_bref;?>image_upload.html?mechanicID=1" class="btn btn-red btn-xs font14"><?php echo sr_heart_replace($parent_poll['text_two']);?></a>
                        </div>
                    </div>
				<?php echo
				'</li>';
				}?>                                                  
            </ul>
        </div>

        <a href="#" class="jcarousel-control-prev resultssliderleft"><img class="img-responsive" src="../../../images/custom/ihearthome/icons/productslideleft.png" alt=""/></a>
        <a href="#" class="jcarousel-control-next resultssliderright"><img class="img-responsive" src="../../../images/custom/ihearthome/icons/productslideright.png" alt=""/></a>
    </div>	
</div>

<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>

<!-- this is jQuery for the poll section -->
<script>
    $('#polloption1').click(function() {
        $('#titlehides').show();
    });
    $('#polloption2').click(function() {
        $('#titlehides').show();
    });
    $('#polloption1').click(function() {
        $('#happyhide, #happyhide1').hide();
    });
    $('#polloption2').click(function() {
        $('#happyhide, #happyhide1').hide();
    });
</script>
<?php 
//echo 'Main array = ';
//unset($consumer_poll_details['related_poll_items']);
//echo dsf_print_array($consumer_poll_details);
?>
