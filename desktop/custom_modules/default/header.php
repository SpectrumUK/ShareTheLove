<div id="headerContainer">
<div id="dsheadLogo"><a href="<?php echo dsf_link('index.html');?>"><?php echo dsf_image('custom/rh_logo.gif', TRANSLATION_LOGO_ALT, '313', '69');?></a></div>
 <?php /*<div id="headerBasket"> include ('custom_modules/column_basket.php');</div>*/?>
 <div id="dsFTcountry">
 		<div class="dsLANGFlag"><?php echo dsf_image('country/' . $dsv_country_code .'.gif', '', '20', '20');?></div>
    	<div class="dsLANGTitle"><a href="http://www.russellhobbs.com"><?php echo TRANSLATION_TEXT_CHANGE_COUNTRY;?></a></div>
        <!-- Start Form -->
		<?php /*<div><?php
			
					$link_query = dsf_query("select link_title, link_url from links where status='1' order by sort_order, link_title");
					
					$return_text = '<div id="dsLinkBox">' . "\n";
					
					$link_array = array(array('id' => '', 'text' => TRANSLATION_PLEASE_SELECT));
					
					while ($links = dsf_array($link_query)){
						$link_array[] = array('id' => $links['link_url'], 'text' => $links['link_title']);
					}

				?>
		<form>
		<?php
		 echo dsf_form_dropdown('dsCountrySelect', $link_array, '', 'onchange="dsfChangeC();"', 'ftrformitem');
		?>
		</form>
		</div> 
		<!-- End Form -->
    </div>*/?>
    </div>
    <?php         
			// ONLY SHOW IF ECOMMERCE IS ACTIVE
			if ($dsv_disable_ecommerce == 'false'){
				?>
                
				<div id="dsheadECOM"><?php include ('/desktop/custom_modules/default/column_basket.php');?></div>
                
				<?php
				};?>
<div class="clear"></div>
	<div id="dsuMenu"><?php	include('program_files/system/create_upper_menu_cache.php');?></div>
	<?php /*include ('custom_modules/search.php');*/?>
</div>