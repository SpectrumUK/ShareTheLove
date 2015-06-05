<?php
// DIFFERENT LAYOUT FOR LEVEL TOP

if ($dslvl == 'top'){
?>
	<div id="dsASTabs">
    	<ul>
			<?php
			
			foreach($dsv_article_tabs as $item){
			
				if ($item['selected'] == 'true'){
					$text = '<li class="dsASTactive">';
				}else{
					$text = '<li class="dsAST">';
				}
				
				$text .='<a href="javascript:void(0);" rel="nofollow" class="dsASTBut" onclick="showArts(' . $item['id'] . ',' . $item['parent_id'] . ",'" . $dslvl . "'" . ');">' . $item['name'] . '</a></li>' . "\n";
				echo $text;
			}
		
?>        </ul>
		</div>
		
		<?php
		
		// scroll
		if (is_array($dsv_related_items) && sizeof($dsv_related_items)>0){
		 // we have items to scroll therefore go through routine.
		 
			// find out how many items are in the related items to decide whether or not we show scroll items.
			/*$total_scroll_items = sizeof($dsv_related_items);
			if ((int)$total_scroll_items > 666){
				// show scroll arrows
				?>
					<div class="dsASLArrow"><a href="javascript:void(0);" onclick="tabScrollRVP('left');"><?php echo dsf_image('custom/artLeft_btn.png', 'Left', '44', '44');?></a></div>
					<div class="dsASRArrow"><a href="javascript:void(0);" onclick="tabScrollRVP('right');"><?php echo dsf_image('custom/artRight_btn.png', 'Right', '44', '44');?></a></div>
				<?php
			}
				*/?>
					<div id="dsASScrItem">
					
					<div id="dsASItems">
						 <ul>
						 
						 <?php
							foreach($dsv_related_items as $item){

									
									if (isset($item['url']) && strlen($item['url']) > 1 ){ // we have url, now check for a new window
									
											// look for external link
											if (isset($item['url_window']) && $item['url_window'] =='true' ){ // we have an override url there default new window
														$js_link = ' onclick="window.open(\'' . $item['url'] . '\')"  style="CURSOR:pointer"';
														$htp_link = '<a href="' . $item['url'] . '" target="_blank">';
													
											}else{
													$js_link = ' onclick="document.location.href=\'' . $item['url'] . '\'"  style="CURSOR:pointer"';
														$htp_link = '<a href="' . $item['url'] . '">';
											
											}
											
									}else{
											$js_link = '';
											$htp_link = '<a href="#">';
									}




									?>
									<li<?php echo $js_link;?>>
											<div class="dsAlISTImg"><?php echo $http_link . dsf_image($item['image'], $item['name']) . '</a>';?></div>
										<?php /*<div class="dsACon"> */?>
											<div class="dsAlISTTitle"><?php echo $item['name'];?></div>
											<?php /*<div class="dsATxt"><?php echo $item['text'];?></div>
                                        </div>*/?>
									</li>
									<?php
							}
						 
						?>
						</ul>
                         <div id="dsVIEWAll_btn"><a href="<?php echo dsf_article_two_url($article_id). '">' . 
TRANSLATION_ARTICLE_TWO_BUTTON_TEXT . '</a>';?></div>
					</div>
					</div>
		<?php
		} // end of we have related articles
		?>
    </div>
 
 <?php
}else{
	// ALL OTHER LEVELS
	
	
	if (isset($dsv_related_items)){
?>
                    <div id="dsASTOPItems">
						 <ul>
						 
						 <?php
							foreach($dsv_related_items as $item){

									
									if (isset($item['url']) && strlen($item['url']) > 1 ){ // we have url, now check for a new window
									
											// look for external link
											if (isset($item['url_window']) && $item['url_window'] =='true' ){ // we have an override url there default new window
														$js_link = ' onclick="window.open(\'' . $item['url'] . '\')"  style="CURSOR:pointer"';
														$htp_link = '<a href="' . $item['url'] . '" target="_blank">';
													
											}else{
													$js_link = ' onclick="document.location.href=\'' . $item['url'] . '\'"  style="CURSOR:pointer"';
														$htp_link = '<a href="' . $item['url'] . '">';
											
											}
											
									}else{
											$js_link = '';
											$htp_link = '<a href="#">';
									}




									?>
									<li<?php echo $js_link;?>>
											<div class="dsAlISTImg"><?php echo $http_link . dsf_image($item['image'], $item['name']) . '</a>';?></div>
										<?php /*<div class="dsACon"> */?>
											<div class="dsAlISTTitle"><?php echo $item['name'];?></div>
											<?php /*<div class="dsATxt"><?php echo $item['text'];?></div>
                                        </div>*/?>
									</li>
									<?php
							}
						 
						?>
						</ul>
					</div>
<?php
			} // something set
}
?>
    <div class="clear"></div>
    <div id="dsASItems_bottom"></div>
