<!-- body //-->
	<div class="details" id="contentDiv">
		<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div></div>
	</div>
	<div id="contentContainer">
    	<div class="contentHome" id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
			<div id="rightContent" class="pagDetails">
            <div class="pagTitles">
            <h1>Site Map</h1>
            <div class="addthis"><?php include ('custom_modules/addthis.php');?></div></div>
    <div id="mapContent">
		<div id="leftMap">
        	<h2>Product Categories</h2>
			<?php echo $dsv_products_map;?>
        </div>

		<div id="rightMap">
        	<h2>Other Sections</h2>
            <ul>
            	<li><a href="<?php echo dsf_link('account.html');?>">My Account</a></li>
                <li><a href="<?php echo dsf_link('about/');?>">About Us</a></li>
                <li><a href="<?php echo dsf_link('contact_us.html'); ?>" >Contact Us</a></li>
                <li><a href="<?php echo dsf_link('login.html');?>">Login/Register</a></li>
                <li><a href="<?php echo dsf_link('news/');?>">News</a></li>
				<li><a href="<?php echo dsf_link('customers_feedback.html'); ?>" >Customer Feedback</a></li>
                <li><a href="<?php echo dsf_link('gift-ideas/');?>">Gift Ideas</a></li>
                <li><a href="<?php echo dsf_link('buying-guides/');?>">Buying Guides</a></li>
                <li><a href="<?php echo dsf_link('conditions.html'); ?>" >Terms &amp; Conditions</a></li>
				<li><a href="<?php echo dsf_link('shipping.html'); ?>" >Delivery &amp; Returns</a></li>
				<li><a href="<?php echo dsf_link('privacy.html'); ?>" >Privacy Policy</a></li>

			</ul>
        </div>
	</div>
</div>
            </div>
	</div>

