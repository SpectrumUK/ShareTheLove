<div class="dsMETAmenu">
	<?php /*<div class="dsMAETATitle">NAVIGATE TO:</div>*/?>
		<ul>
        	<li><a href="<?php echo dsf_link('contact_us.html');?>" title="<?php echo TRANSLATION_PAGE_CONTACT;?>"><?php echo TRANSLATION_PAGE_CONTACT;?></a></li>
            <li><a href="<?php echo dsf_link('about_us.html');?>" title="<?php echo TRANSLATION_PAGE_ABOUT;?>"><?php echo TRANSLATION_PAGE_ABOUT;?></a></li>
            <li><a href="<?php echo dsf_link('where_to_buy.html');?>" title="<?php echo TRANSLATION_PAGE_WTB;?>"><?php echo TRANSLATION_PAGE_WTB;?></a></li>
    		<li><a href="<?php echo dsf_link('conditions.html');?>" title="<?php echo TRANSLATION_PAGE_TERMS;?>"><?php echo TRANSLATION_PAGE_TERMS;?></a></li>
          <?php if(strtolower(CONTENT_COUNTRY)=='gb'){
			echo '<li><a href="' . dsf_link('shipping.html') . '" title="' .  TRANSLATION_PAGE_DELIVERY . '">' . TRANSLATION_PAGE_DELIVERY . '</a></li>' ; 
		}else{ //do nothing	
		 }?>
		 <?php /* changed to the code above
		 	if ($dsv_disable_ecommerce == 'false'){
				?>
				 <li><a href="<?php echo dsf_link('shipping.html');?>" title="<?php echo TRANSLATION_PAGE_DELIVERY;?>"><?php echo TRANSLATION_PAGE_DELIVERY;?></a></li>
        	<?php
			}
			*/?>
			<li><a href="<?php echo dsf_link('privacy.html');?>" title="<?php echo TRANSLATION_PAGE_PRIVACY;?>"><?php echo TRANSLATION_PAGE_PRIVACY;?></a></li>
            <li><a href="<?php echo dsf_link('recycling.html');?>" title="<?php echo TRANSLATION_PAGE_RECYCLE;?>"><?php echo TRANSLATION_PAGE_RECYCLE;?></a></li>
            <li><a href="<?php echo dsf_link('user-manuals.html');?>" title="<?php echo TRANSLATION_PAGE_MANUALS;?>"><?php echo TRANSLATION_PAGE_MANUALS;?></a></li>
            <li><a href="<?php echo dsf_link('imprint.html');?>" title="<?php echo TRANSLATION_PAGE_IMPRINT;?>"><?php echo TRANSLATION_PAGE_IMPRINT;?></a></li>
            <li><a href="<?php echo dsf_link('sitemap.html');?>" title="<?php echo TRANSLATION_PAGE_SITEMAP;?>"><?php echo TRANSLATION_PAGE_SITEMAP;?></a></li>
    	</ul>
</div>