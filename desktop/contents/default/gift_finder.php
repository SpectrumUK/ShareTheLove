<!-- body //-->
	<div class="details" id="contentDiv">
		<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div></div>
        <?php /*echo dsf_image($dsv_gift_details['gift_image'], $dsv_gift_details['gift_name']);*/?>
	</div>
	<div id="contentContainer">
    	<div id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
	<div id="rightContent">
    	<div class="pagTitles">
    		<h1><?php echo 'Inspired Gift Ideas'; ?></h1>
            <div class="addthis"><!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=saltonuk"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=saltonuk"></script>
<!-- AddThis Button END -->
</div></div>
            <div class="dropForm">
            <select name="country" class="active" onChange="dojump(this)">
			<?php
		// start right hand nav
		if (isset($dsv_gift_menu) && is_array($dsv_gift_menu)){
			foreach($dsv_gift_menu as $item){
		if ((int)$dsv_gift_details['current_id'] == (int)$item['id']){
					// current select item
					echo '<option value="' . $item['url'] . '" class="active">' . $item['title'] . '</option>' . "\n";
				}else{
					echo '<option value="' . $item['url'] . '">' . $item['title'] . '</option>' . "\n";
				}
			}
		}
		?>
        </select>
        </div>
            <div class="lineBreak"></div>
       <div class="giftProducts">
       
       <h2><?php echo $dsv_gift_details['title_text'];?></h2>
       <p><?php echo $dsv_gift_details['gift_text'];?></p>
		
        
            <?php
		if (is_array($dsv_gift_details['products']) && sizeof($dsv_gift_details['products'])>0){
			?>
           
            <ul>
		<?php
			foreach($dsv_gift_details['products'] as $item){
				
				echo '<li><div><a href="' . $item['url'] . '">' . dsf_image($item['image'], $item['title'],$item['width'],$item['height']) . '<br><br>' . $item['title'] . '&nbsp;' . $item['model'] .  '<br><br>' . dsf_image_button($dsv_moreinfo_button , 'More Info') . '</a></div></li>' . "\n";
			 }	
		?>
		</ul>
        </div>
		<?php
		}
		?>   
                
            </div>
	</div>
    </div>

