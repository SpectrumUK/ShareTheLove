<div id="dsBasketMask" class="dsBasketS2"></div>
<div id="dsBasketHolder"></div>
<div id="contentHeader"></div>

<div id="dsContent">
		<div class="dsCHleft">
 		<div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	<div class="addthis"><?php include ('custom_modules/default/addthis.php');?></div>
    	<div class="clear"></div>
    	<h1><?php echo ds_strtoupper(TRANSLATION_PAGE_MANUALS); ?></h1>
        <div id="dsuserCat"><?php
						
						// the whole set of dropdowns is within the array $sections_array
						// this also contains the section names.
						
						if (isset($sections_array) && is_array($sections_array)){
						
							?>
							<ul>
						
							<?php foreach($sections_array as $id => $item){
							
								echo '<li><div class="userTitle">' . ds_strtoupper($item['title']) . '</div>' . "\n";
									echo '<ul>';
										echo '<li>' . dsf_form_dropdown('manual' . $id, $item['list'], '', 'onchange="dsfManual(\'manual' . $id .'\');"', 'userformitem') . '</li>';
									echo '</ul>';
								echo '</li>' . "\n";
							
							
							
							} // end foreach
						?>
						
							</ul>
							<?php
						} // end if array
						?>
                        </div>
                        <div class="clear">&nbsp;</div>
                        <a href="http://get.adobe.com/reader/" target="_blank" title="Get Adobe Acrobat Reader"><?php echo dsf_image('custom/get_adobe_reader.png', 'Adobe Acrobat Reader', '156', '44', 'class="dsAcroRead"');?></a>
						<p><?php echo TRANSLATION_PDF_MANUAL_INFORMATION;?></p>
</div>