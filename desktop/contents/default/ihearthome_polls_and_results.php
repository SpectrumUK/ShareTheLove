<?php $parent_poll = dsf_get_individual_consumer_poll_details(6);?>

<div class="col-sm-6">
	<h3 class="questionh3_product" style=""><?php echo sr_heart_replace($parent_poll['text_one']);?></h3>
	<div class="question_1stbox curvedcorners">
		<?php echo sr_heart_replace($consumer_poll_details['poll_question']);?>
	</div>
    <div class="height10"></div>
    
    
    <?php
	// at this point we are doing two things,  showing possible answers and then later showing the results.
	
	// the possible answers array and the results answers array contain exactly the same names therefore it is easier to just use the answers one as that has more data.
	
	reset($consumer_poll_details['results']['answers']);
	
	$answer_counter = 0;
	
	foreach ($consumer_poll_details['results']['answers'] as $key => $answer){
		$answer_counter ++;
		
	?>
    
    
    <a id="polloption<?php echo $answer_counter;?>">
    	<div id="happyhide" class="question_answersbox curvedcorners">
    		<p class="font19"><?php echo sr_heart_replace($key);?></p>
    	</div>
    </a>
<?php
	}
	?>

    <div id="titlehides" class="animated fadeIn">
	
	<?php 
		reset($consumer_poll_details['results']['answers']);

	   foreach ($consumer_poll_details['results']['answers'] as $key => $answer){

?>
        <div class="progress <?php echo ($answer['winner'] == 'true' ? 'leading' : 'losing');?>prog positionrelative">
            <div class="progress-bar <?php echo ($answer['winner'] == 'true' ? 'leading' : 'losing');?>" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo $answer['percent'];?>;"></div>
            <div class="poll_results"><strong><?php echo sr_heart_replace($answer['percent']);?></strong></div>
        </div>

     <?php   
	 }
?> 
    </div>
    
    
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
echo dsf_print_array($parent_poll);
?>

