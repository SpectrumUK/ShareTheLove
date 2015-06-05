<!-- body //-->
<?php // echo '<pre>' . print_r($dsv_news_details , true) . '</pre>';?>
	<div class="details" id="contentDiv">
		<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div></div>
	</div>
	<div id="contentContainer">
    	<div id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
	<div id="rightContent">
	<div class="imgColumn">
 		<?php echo dsf_image($dsv_news_details['header_image'], $dsv_news_details['header_title']);?>
 	</div>
 	<div class="recipeDetails">
   		<h1><?php echo $dsv_news_details['news_name'];?></h1>
 		<p><?php echo $dsv_news_details['news_text'];?></p>
		<!-- AddThis Button BEGIN -->
<div class="addBut"><a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=saltonuk"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=saltonuk"></script></div>
<!-- AddThis Button END -->
	 </div>
			
            
            <div class="lineBreak"></div>
            
        <?php
		
		if (is_array($dsv_news_details['products']) && sizeof($dsv_news_details['products'])>0){
			?>
		<div id="recProducts">
        <h2>Featured Products</h2>		
		<ul>
		<?php
			foreach($dsv_news_details['products'] as $item){
				
				echo '<li><div><a href="' . $item['url'] . '">' . dsf_image($item['image'], $item['title'],$item['width'],$item['height']) . '<br><a href="' . $item['url'] . '">' . $item['title'] . '&nbsp;' . $item['model'] .  '<br><br>' . dsf_image_button($dsv_moreinfo_button , 'More Info') . '</a></div></li>' . "\n";
			 }	
		?>
		</ul>
        </div>
		<?php
		}
		?>
        
            
           <div id="newMenu"><ul>
		
		<?php
		// start right hand nav
		if ((int)$dsv_news_details['current_id']  < 2){
		
		if (isset($dsv_news_menu) && is_array($dsv_news_menu)){
			foreach($dsv_news_menu as $item){
			if ($item['id'] == 1) {
                                    // do nothing
                            }else{
				if ((int)$dsv_news_details['current_id'] == (int)$item['id']){
					// current select item
					echo '<li><a href="' . $item['url'] . ' class="active">' . $item['title'] . '</a></li>' . "\n";
				}else{
					echo '<li><a href="' . $item['url'] . '">' . dsf_image($item['news_image'], $item['title'],$item['width'],$item['height']) . $item['title'] . '</a></li>' . "\n";
				}
			}	
			}
		}
		}
		?>
        
        </ul></div>
                
            </div>
	</div>
    </div>
