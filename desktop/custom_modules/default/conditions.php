<!-- body //-->
	<div class="details" id="contentDiv">
		<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div></div>
	</div>
	<div id="contentContainer">
    	<div class="contentHome" id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
			<div id="rightContent" class="pagDetails">
            <div class="pagTitles">
            <h1>Terms &amp; Conditions</h1>
            <div class="addthis"><?php include ('custom_modules/addthis.php');?></div></div>
            <?php
	echo nl2br($dsv_page_text);
	 ?></div>
            </div>
	</div>

