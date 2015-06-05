<!-- body //-->
	<div class="inner" id="contentDiv">
		<div id="contentHeader"><?php echo dsf_image($dsv_article_details['title_image'], $dsv_article_details['article_name']);?></div>
	</div>
	<div id="contentContainer">
    	<div id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
	<div id="rightContent">
    		<div class="pagTitles">
            <div class="addthis"><!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=saltonuk"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=saltonuk"></script>
<!-- AddThis Button END -->
</div></div>            
            
        <?php
		/*if (is_array($dsv_article_details['products']) && sizeof($dsv_article_details['products'])>0){
			?>
					
		<ul>
		<?php
			foreach($dsv_article_details['products'] as $item){
				
				echo '<li><a href="' . $item['url'] . '">' . dsf_image($item['image'], $item['title'],$item['width'],$item['height']) . '</a></li>' . "\n";
			 }	
		?>
		</ul>
		<?php
		}
		?>
		
		<?php
		// start right hand nav
		if (isset($dsv_article_menu) && is_array($dsv_article_menu)){
			foreach($dsv_article_menu as $item){
			if ($item['id'] == 1) {
                                    // do nothing
                            }else{
				if ((int)$dsv_article_details['current_id'] == (int)$item['id']){
					// current select item
					echo '<li><a href="' . $item['url'] . '" class="active">' . $item['title'] . '</a></li>' . "\n";
				}else{
					echo '<li><a href="' . $item['url'] . '">' . $item['title'] . '</a></li>' . "\n";
				}
			}	
			}
		}
		*/?>
        <div class="imgColumn">
 	<div class="articles"><?php echo dsf_image($dsv_article_details['article_image'], $dsv_article_details['article_name']);?></div>
    <?php
	if (isset($main_recipe['main_image'])){
			echo dsf_image($main_recipe['main_image']);
	}
	?>
 </div>
 <div class="articleDetails">
 	<h1><?php echo $dsv_article_details['article_name'];?></h1>
 	<?php echo $dsv_article_details['article_text'];?>
 	<p><a href = "javascript:history.back()">« return to perivous page</a></p>
 </div>
                
            </div>
	</div>
    </div>

