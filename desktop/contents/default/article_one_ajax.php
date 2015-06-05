	<div id="dsASTabs">
    	<ul>
			<?php
			
			foreach($dsv_article_tabs as $item){
			
				if ($item['selected'] == 'true'){
					$text = '<li class="dsASTactive">';
				}else{
					$text = '<li class="dsAST">';
				}
				
				$text .='<a href="javascript:void(0);" rel="nofollow" class="dsASTBut" onclick="showArts(' . $item['id'] . ',' . $item['parent_id'] . ');">' . $item['title'] . '</a></li>' . "\n";
			
				echo $text;
			}
		
?>        </ul>
        <div class="clear"></div>
		
		<?php
		
		// scroll
		if (is_array($dsv_related_items) && sizeof($dsv_related_items)>0){
		 // we have items to scroll therefore go through routine.
		 
			// find out how many items are in the related items to decide whether or not we show scroll items.
			$total_scroll_items = sizeof($dsv_related_items);
			if ((int)$total_scroll_items > 666){
				// show scroll arrows
				?>
					<div class="dsASLArrow"><a href="javascript:void(0);" onclick="tabScrollRVP('left');"><?php echo dsf_image('custom/artLeft_btn.png', 'Left', '44', '44');?></a></div>
					<div class="dsASRArrow"><a href="javascript:void(0);" onclick="tabScrollRVP('right');"><?php echo dsf_image('custom/artRight_btn.png', 'Right', '44', '44');?></a></div>
				<?php
			}
				?>
					
					<div id="dsASItems">
						 <ul>
						 
						 <?php
							foreach($dsv_related_items as $item){

									if (isset($item['override_url']) && strlen($item['override_url']) > 1 ){ // we have an override url there default new window
												$js_link = ' onclick="window.open(\'' . $item['override_url'] . '\')"  style="CURSOR:pointer"';
												$htp_link = '<a href="' . $item['override_url'] . '" target="_blank">';
											
									}elseif (isset($item['url']) && strlen($item['url']) > 1){
											$js_link = ' onclick="document.location.href=\'' . $item['url'] . '\'"  style="CURSOR:pointer"';
												$htp_link = '<a href="' . $item['url'] . '">';
											
									}else{
											$js_link = '';
											$htp_link = '<a href="#">';
									}




									?>
									<li<?php echo $js_link;?>>
										<div class="dsAImg"><?php echo $http_link . dsf_image($item['image'], $item['name']) . '</a>';?></div>
                                        <div class="dsACon">
											<div class="dsATitle"><?php echo $item['name'];?></div>
											<div class="dsATxt"><?php echo $item['text'];?></div>
                                        </div>
									</li>
									<?php
							}
						 
						?>
						</ul>
                        
					</div>
                    
                    
		<?php
		} // end of we have related articles
		?>
    </div>
    <div class="clear"></div>
    <div id="dsASItems_bottom"></div>