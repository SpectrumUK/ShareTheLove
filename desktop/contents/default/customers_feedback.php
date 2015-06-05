<!-- body //-->
	<div class="details" id="contentDiv">
		<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div></div>
	</div>
	<div id="contentContainer">
    	<div class="contentHome" id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
           	<div id="rightContent">
            <div class="pagTitles">
            <h1>Customers Feedback</h1>
             <div class="addthis"><!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=saltonuk"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=saltonuk"></script>
<!-- AddThis Button END -->
</div></div>
            <p>We are continually updating and improving our website to give our customers the best possible service. We recognise the importance of our customer's opinions and ideas and value any feedback received whether 
            possitive or negative.</p>
			<p>These pages show some of the comments that previous customers have written about us, we would appreciate if you could take the time to advise us of your experience with our service.</p>
            <?php echo '<p><a href="' . dsf_link('customers_feedback_write.html') . '">' . dsf_image_button($dsv_feedback_button, 'Let us know your feedback') . '</a></p>'; ?>
<div class="lineBreak"></div>
		<h1 class="mtop">Recent Feedback</h1>
        <?php
  if (is_array($dsv_feedback) && sizeof($dsv_feedback) >0){
  
	   foreach($dsv_feedback as $item){
			?>
			<div class="dsFbRow">
			<div class="dsFbRight">Rating:<br><?php echo dsf_image('stars_' . $item['rating'] . '.gif', $item['rating'] . ' out of 5');?></div>
			<div class="dsFbLeft"><?php echo nl2br($item['text']);?></div>
			<div class="dsFbBottom"><?php echo 'Written by: ' . $item['author'] . ' on ' . $item['date'];?></div>
			</div>
			<?php
	  
	   }
  
  }
  
  if ((int)$dsv_feedback_total_pages > 1){
	  ?>
	  <div class="dsPrHolder">Pages: <?php echo $dsv_feedback_page_links;?></div>
	  <?php
  }
  ?>
	</div>
</div>
</div>
