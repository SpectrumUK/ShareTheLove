<?php
// EXPLANATION OF A REPLACE SOLUTION

// you would put the function at the top of each content page (including any being loaded by ajax)

if (!function_exists('sr_heart_replace')){
	function sr_heart_replace($string_to_check = ''){
	
	// it is possible to do a single replace mode by using arrays as the first and seccond parameters however,
	// by doing that in this case it is going to be rather difficult to ready and adjust.
	
	// we will therefore just do a sequence of single replace commands one after the other until testing is complete and you are
	// happy with the outcome, this could then be changed to a single command with arrays later.
	
	$string_to_check = str_replace("[REDHEART2]" , '<span class="heart_red"></span>' , $string_to_check);
	$string_to_check = str_replace("[WA]" , '<span class="wateraid_logo" style="margin: 3px 0 0 0;"></span>' , $string_to_check);
	
	// alternatively,  if you didn't want to use the internal dsf_image function because you wanted to do some additional styles etc....  you could replace
	// using standard html
	
	
	// $string_to_check = str_replace("[WHITEHEART2]" , '<img src="custom/visa_icon.jpg" width="100" height="100" class="someclass" />' , $string_to_check);
	
// return back to the calling script the answer
	return $string_to_check;
	
	} // end function
} // end checking for function already loaded.

?>

<!-- WaterAid Header Panel -->
<div class="header__wateraid">
	<!-- Main Content -->
	<div class="col-sm-8 margintop20">
		<!-- Main Image -->
		<div class="dsCIMG">
			<div class="dsIMGLeftCorner">
				<img src="../../../images/custom/ihearthome/layout/wateraid/wateraid_left_corner.png" alt="WaterAid" />
			</div>
			<div class="dsIMGRightCorner">
				<img src="../../../images/custom/ihearthome/layout/wateraid/wateraid_right_corner.png" alt="WaterAid" />
			</div>
			<?php echo dsf_image($seasonal_details['article_image_one'], $seasonal_details['article_image_one_text'],'','');?>
		</div>
		
		<div class="col-sm-12 wateraid_compholder_info">
			<h1 class="headertitle"><?php echo sr_heart_replace($seasonal_details['text_one']);?></h1>
			<p class="compsubtitle_product wateraid_subtitle">
				<?php echo sr_heart_replace($seasonal_details['text_two']);?>
			</p>
		</div>
		
		<!-- Main Text -->
		<div class="col-sm-12 wateraid_compholder_info">
			<p><?php echo sr_heart_replace ($seasonal_details['text_block_one']);?></p>
		</div>
		
		<!-- Photo Upload Panel -->
		<div class="col-sm-12 wateraid_upload_panel">
			<p class="gothambold wateraid_upload_link">
				<a href="<?php echo $SSL_bref;?>image_upload.html?mechanicID=1">
					<?php echo sr_heart_replace($seasonal_details['text_three']);?>
				</a>
			</p>
		</div>
		
		<!-- Link -->
		<div class="col-sm-12 wateraid_compholder_info">
			<p class="gothambold">
				<a href="<?php echo $SSL_bref;?>image_upload.html?mechanicID=1">
					<?php echo sr_heart_replace($seasonal_details['text_four']);?>
				</a>
			</p>
			<p class="small11 margintop20">
				<?php echo sr_heart_replace($seasonal_details['text_five']);?>
			</p>
		</div>
	</div>
	
	<!-- Target Count and Featured Products -->
	<div class="col-sm-4 nopaddingoutter overflowhidden wateraid_target_featured">
		<h3 class="generalh3_product margintop20">
			<?php echo sr_heart_replace($seasonal_details['text_six']);?>
		</h3>
		
		<div class="wateraid_target">
			<p class="gothambold textcenter target_percentage">
				<?php echo sr_heart_replace($seasonal_details['text_eight']);?>
			</p>
			
			<p class="gothamlight font22 target_text">
				<?php echo sr_heart_replace($seasonal_details['text_seven']);?>
			</p>
		</div>
		
		<div class="wateraid_featured_prods margintop40">
			<?php
			// RELATED PRODUCTS ALWAYS SHOWN AS ITS A PLACEHOLDER.
			if (isset($seasonal_details['article_products']) && is_array($seasonal_details['article_products'])){
			?>
			<h3 class="generalh3_product"><?php echo TRANSLATION_FEATURED_PRODUCTS;?></h3>
			
			<div id="#dsARTProSML">
				<?php
				$total_related = sizeof($seasonal_details['article_products']);
				if ($total_related > 4){
					$total_related = 4;
				}
				$total_counter = 0;
				foreach($seasonal_details['article_products'] as $item){
					$total_counter ++;
					
					if ($total_counter <= $total_related){
						?>
						<div class="dsPROList">
							<?php echo '<a href="' . $item['url'] . '">' . dsf_image($item['image'], $item['name'] . ' ' . $item['model'], $item['width'], $item['height']) . '</a>';?>
								<div class="dsProTitle"><?php echo '<a href="' . $item['url'] . '">' . $item['name'] . '</a>';?></div>
								<div class="dsProModel"><?php echo '<a href="' . $item['url'] . '">' . $item['model'] . '</a>';?></div>
						</div>
					<?php
					}
				}
				?>
			</div>
			<?php
			}
			?>
		</div>
	</div>
</div>

<?php //echo dsf_print_array($seasonal_details);?>