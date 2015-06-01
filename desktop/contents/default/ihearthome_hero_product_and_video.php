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

<div class="col-xs-7 nopaddingoutter">
	<h3 class="generalh3_product"><?php echo sr_heart_replace($article_details['text_one']);?></h3>
	<div class="col-sm-6 nopaddingoutter productdetails">	
		<p class="font16"><strong><?php echo sr_heart_replace($article_details['text_two']);?></strong></p>
		<?php echo sr_heart_replace($article_details['text_block_one']);?>
		<p class="redtxt"><?php echo sr_heart_replace($article_details['text_three']);?></p>
			<?php echo sr_heart_replace($article_details['text_block_two']);?>
		<p><a href="<?php echo $article_details['article_products'][0]['url'];?>"><?php echo sr_heart_replace($article_details['text_four']);?></a></p>
	</div>

	<div class="heroimage col-xs-6 nopaddingoutter">	
                <?php echo dsf_image($article_details['article_products'][0]['standard_image'], $article_details['article_products'][0]['name'], '', '', 'class="img-responsive heroproduct_position"');?>
                
    
   		<div class="heroinsets_holder">
                    <ul class="heroinsets">
						<li><?php echo dsf_image($article_details['article_products'][0]['image_1_thumb'], '', '61', '61', 'style="border: 1px solid #fff;"');?></li>
                        <li><?php echo dsf_image($article_details['article_products'][0]['image_2_thumb'], '', '61', '61', 'style="border: 1px solid #fff;"');?></li>
                        <li><?php echo dsf_image($article_details['article_products'][0]['image_3_thumb'], '', '61', '61', 'style="border: 1px solid #fff;"');?></li> 
                    </ul>
                </div>
	</div>
</div>

<div class="col-sm-5 nopaddingright">
	<h3 class="generalh3_product"><?php echo sr_heart_replace($article_details['text_five']);?></h3>
    <div class="videoWrapper">
        <?php echo $article_details['article_youtube_link'];
        /*<iframe width="429" height="241" src="//www.youtube.com/embed/KoZF_xVholI?rel=0" frameborder="0" allowfullscreen></iframe>*/?>
    </div>
    <div class="productslider_bg text-center video_notcompetition">
        <p class="paddingtop15 gothambold font18"><?php echo sr_heart_replace($article_details['article_video_title']);?></p>
        <p><?php echo sr_heart_replace($article_details['article_video_text']);?></p>
        <div class="height5"></div>
        <a class="btn btn-red btn-xs font14" href="<?php echo $article_details['text_eight'];?>">
		<?php         
			  if ($dsv_disable_ecommerce == 'false'){
				  echo TRANSLATION_MOBILE_SHOP_NOW;
			  }else{
				  echo TRANSLATION_FIND_OUT_MORE;
			  }
		?>
			</a>
    </div>
</div>

<div class="height5"></div>
<img class="img-responsive fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>

<?php 
//echo 'Hero Product array = ';
//echo dsf_print_array($article_details['article_products']);
?>