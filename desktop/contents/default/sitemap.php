<div id="dsContent">
    <div class="dsSMAPleft">
    	<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="clear"></div>
    	<h1><?php echo strtoupper(TRANSLATION_TITLE_SITEMAP); ?></h1>
		<?php echo ($dsv_page_text); ?>
        <div class="dsSMAP">
        <?php echo $dsv_products_map;?>
        <?php /*<ul>
            	<li><a href="http://en.russellhobbs.com/sitemap.html">Other Sections</a><ul>
                <li><a href="<?php echo dsf_link('where_to_buy.html'); ?>" ><?php echo TRANSLATION_PAGE_WTB;?> </a></li>
                <li><a href="<?php echo dsf_link('contact_us.html'); ?>" ><?php echo TRANSLATION_PAGE_CONTACT;?></a></li>
                <li><a href="<?php echo dsf_link('conditions.html'); ?>" ><?php echo TRANSLATION_PAGE_TERMS;?></a></li>
				<li><a href="<?php echo dsf_link('privacy.html'); ?>" ><?php echo TRANSLATION_PAGE_PRIVACY;?></a></li>
                <li><a href="<?php echo dsf_link('user-manuals.html'); ?>" ><?php echo TRANSLATION_PAGE_MANUALS;?></a></li>
                <li><a href="<?php echo dsf_link('recycling.html'); ?>" ><?php echo TRANSLATION_PAGE_RECYCLE;?></a></li>
                </ul></li>
			</ul> */?>
    </div>
    </div>
    <div class="dsMETAright">
        <div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
        <?php include ('custom_modules/default/signup.php');?>
        <div class="clear"></div>
        <?php include ('custom_modules/default/meta_menu.php');?>
    </div>
</div>
<?php
if (isset($ex_script_text)){
	echo $ex_script_text;
}
?>