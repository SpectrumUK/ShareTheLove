<!-- body //-->
	<div class="details" id="contentDiv">
		<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div><?php /*echo dsf_image($dsv_guide_details['guide_image'], $dsv_guide_details['guide_name']);*/?></div>
	</div>
	<div id="contentContainer">
    	<div id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
            
	<div id="rightContent" class="pagDetails">
    	<div class="pagTitles">
    		<h1><?php echo 'Russell Hobbs Buyers Guide'; ?></h1>
            <div class="addthis"><!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=saltonuk"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=saltonuk"></script>
<!-- AddThis Button END -->
</div>
        </div>    
            <div class="dropForm">
            <select name="guides" class="active" onChange="dojump(this)">
			<?php
		// start right hand nav
		if (isset($dsv_guide_menu) && is_array($dsv_guide_menu)){
			foreach($dsv_guide_menu as $item){
		if ((int)$dsv_guide_details['current_id'] == (int)$item['id']){
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
       <h2><?php echo $dsv_guide_details['title_text'];?></h2>
       <?php echo $dsv_guide_details['guide_text'];?>
		</div> 
                
            </div>
	</div>
    </div>

