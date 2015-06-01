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

<!-- Competition Panel //-->
<div class="col-sm-7 compholder_product">
	<div class="col-sm-8 competitionholder_info">
		<h4 class="comptitle_product gothambold"><?php echo sr_heart_replace($article_details['text_one']);?></h4>
		<p class="compsubtitle_product"><?php echo sr_heart_replace($article_details['text_two']);?></p>
		<?php echo sr_heart_replace($article_details['text_block_one']);?>
	</div>
	<div class="competitionIMG">	
    	<?php echo dsf_image($article_details ['article_image_one'], $article_details['text_one'],'','', 'class="img-responsive"');?>
    </div>
	<div class="col-sm-12 padding020">
    <p class="font13 redtxt"><?php echo sr_heart_replace($article_details['text_three']);?></p>
		<div class="enterboxes curvedcorners">
			<p class="small11 blacktxt"><?php echo sr_heart_replace($article_details['text_four']);?></p>
			<div class="steps_numbered"></div>
		</div>
		<div class="enterboxes curvedcorners">
			<p class="small11 blacktxt"><?php echo sr_heart_replace($article_details['text_five']);?></p>
			<div class="steps_numbered_2"></div>
		</div>
		<div class="enterboxes_red curvedcorners">
			<p class="whitetxt nopaddingoutter nomargin"><a href="<?php echo $SSL_bref;?>image_upload.html?mechanicID=1"><?php echo sr_heart_replace($article_details['text_six']);?></a></p>
		</div> 
	</div>
</div>

<!-- Recipe Panel //-->
<div class="col-sm-5 howto_competition">
	<h3 class="generalh3_product"><?php echo sr_heart_replace($article_details['text_seven']);?></h3>
	<div class="jcarousel-wrapper">
		<div class="jcarousel">
			<ul>
             <?php
				// loop through children
				foreach ($article_details['allocated_items'] as $item){
					echo '<li class="howto">'
					. dsf_image($item['article_two_details']['title_image'], $item['article_two_details']['article_title'], '', '', 'class="img-responsive"') . 
					'<div class="productslider_bg text-center paddingtop15 nopaddingoutter height140">
						<p class="font18 gothambold">' . $item['article_two_details']['article_name'] .'</p>
						<div class="height15"></div>
						<a href="' . $item['article_two_details']['url']. '" class="btn btn-red btn-xs font14">' . TRANSLATION_CUSTOM_TEXT_NINE . '</a>
					</div>
				</li>';


// previously with wrong field in.    this particular allocated_items is an article 2 therefore the fields  image_one and text_one and name do not exist
// simply printing the array of article_details['allocated_items'] shows this.
// additionally,  when looping as below,  the value in $item would only be:  article_include_type,  article_two_details, 

// again,  by printing the value of $item  using  dsf_print_array($item) gives the fields



/*
				foreach ($article_details['allocated_items'] as $item){
					echo '<li class="howto">'
					. dsf_image($item['image_one'], $item['text_one'], '', '', 'class="img-responsive"') . 
					'<div class="productslider_bg text-center paddingtop15 nopaddingoutter height140">
						<p class="font18 gothambold">' . $item['name'] .'</p>
						<div class="height15"></div>
						<button type="button" class="btn btn-red btn-xs font14"><a href="' . $item['url']. '">' . TRANSLATION_CUSTOM_TEXT_NINE . '</a></button>
					</div>
				</li>';

*/


				}
			?>
				
			</ul>
		</div>
	
		<a href="#" class="jcarousel-control-prev howtoprev"><img class="img-responsive" src="../../../images/custom/ihearthome/icons/productslideleft.png" alt=""/></a>
		<a href="#" class="jcarousel-control-next howtonext"><img class="img-responsive" src="../../../images/custom/ihearthome/icons/productslideright.png" alt=""/></a>
	</div>
</div>

<!-- divider -->
<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>
<?php //echo dsf_print_array($seasonal_details);?>