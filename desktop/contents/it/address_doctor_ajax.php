<?php
// multi choice file to replace / show the address input sections.

if ($job_level == 'single_address'){
	
	// we have recieved a single address back, we just need to respond with the standard form
	// but the fields needs to be based on whether it is invoice or delivery section.
	



	
	// the values to return are from the array 
	
	if ($section == 'delivery'){ // check for delivery as default is invoice.
	
					?>	<div class="dscheckoutInput"><label for="i_delivery_street"><?php echo TRANSLATION_CHECKOUT_STREET;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_delivery_street',$dsv_address_single['street'],'size="24"  maxlength="24"','forminput'); ?> 
						</div>
		
						<div class="dscheckoutInput"><label for="i_delivery_house"><?php echo TRANSLATION_CHECKOUT_HOUSE;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_delivery_house',$dsv_address_single['house'],'size="15" maxlength="15"','forminput'); ?> 
						</div>

						<div class="dscheckoutInput"><label for="i_delivery_postcode"><?php echo TRANSLATION_CHECKOUT_POSTCODE;?>:  <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_delivery_postcode', $dsv_address_single['postcode'],'size="15"  maxlength="9"','forminput'); ?>
						</div>


						<div class="dscheckoutInput"><label for="i_delivery_district"><?php echo TRANSLATION_CHECKOUT_DISTRICT;?>:</label>
						<?php echo dsf_form_input('i_delivery_district',$dsv_address_single['district'],'size="30"  maxlength="30"','forminput'); ?>
						</div>

						<div class="dscheckoutInput"><label for="i_delivery_town"><?php echo TRANSLATION_CHECKOUT_TOWN;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_delivery_town',$dsv_address_single['town'],'size="30"  maxlength="30"','forminput') . dsf_form_hidden('i_delivery_sap_county',0); ?> 
						</div>
		
				  
						<div class="dscheckoutInput"><label for="i_delivery_country"><?php echo TRANSLATION_CHECKOUT_COUNTRY;?>:</label>
						<?php echo dsf_country_list('i_delivery_country','','','forminput',$dsv_master_country_id); ?>
						</div>

<?php

	}else{
		// default invoice
		?>
						<div class="dscheckoutSection">

						<div class="dscheckoutInput"><label for="i_invoice_street"><?php echo TRANSLATION_CHECKOUT_STREET;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_street',$dsv_address_single['street'],'size="24"  maxlength="24"','forminput'); ?> 
						</div>
		
						<div class="dscheckoutInput"><label for="i_invoice_house"><?php echo TRANSLATION_CHECKOUT_HOUSE;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_house',$dsv_address_single['house'],'size="15" maxlength="15"','forminput'); ?> 
						</div>

						<div class="dscheckoutInput"><label for="i_invoice_postcode"><?php echo TRANSLATION_CHECKOUT_POSTCODE;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_postcode', $dsv_address_single['postcode'],'size="15"  maxlength="9"','forminput') ; ?> 
						</div>


						<div class="dscheckoutInput"><label for="i_invoice_district"><?php echo TRANSLATION_CHECKOUT_DISTRICT;?>:</label>
						<?php echo dsf_form_input('i_invoice_district',$dsv_address_single['district'],'size="30"  maxlength="30"','forminput'); ?>
						</div>

						<div class="dscheckoutInput"><label for="i_invoice_town"><?php echo TRANSLATION_CHECKOUT_TOWN;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_town',$dsv_address_single['town'],'size="30"  maxlength="30"','forminput').dsf_form_hidden('i_invoice_sap_county',0); ?> 
						</div>
		
						<div class="dscheckoutInput"><label for="i_invoice_country"><?php echo TRANSLATION_CHECKOUT_COUNTRY;?>:</label>
						<?php echo dsf_country_list('i_invoice_country','','','forminput',$dsv_master_country_id); ?>
						</div>


					</div>
        
        
        
        
        
        
      <?php
	} // end inv or del choice
	
	
}elseif ($job_level == 'multiple_address'){
	
	// we create a dropdown of addresses and then two buttons to allow the use to choose.
	?>
    <div class="addDoctorInst"><?php echo TRANSLATION_ADDOCTOR_SELECT_ADDRESS;?></div>
    <div class="dscheckoutInput"><?php echo dsf_form_dropdown('addoc_select', $address_choices, '','','forminput');
						
	if ($section == 'delivery'){ // check for delivery as default is invoice.
		echo dsf_form_hidden('i_delivery_street',$street); 
		echo dsf_form_hidden('i_delivery_house',$house);
		echo dsf_form_hidden('i_delivery_postcode', $pcode) ;
	}else{
		echo dsf_form_hidden('i_invoice_street',$street); 
		echo dsf_form_hidden('i_invoice_house',$house);
		echo dsf_form_hidden('i_invoice_postcode', $pcode) ;
	}
	
	?></div>
    <div class="dscheckoutInput">
    	<div class="addDoctorUse"><a href="javascript:void(0)" onclick="dsfAduse('<?php echo $section;?>','<?php echo $addkey;?>');"><?php echo dsf_image_button('useaddress_btn_it.gif', TRANSLATION_ADDOCTOR_ALLOCATE);?></a></div>
    	<div class="addDoctorUse"><a href="javascript:void(0)" onclick="dsfAdman('<?php echo $section;?>','<?php echo $addkey;?>');"><?php echo dsf_image_button('inputaddress_btn_it.gif', TRANSLATION_ADDDOCTOR_MANUAL);?></a></div>
    </div>

	<?php
}elseif ($job_level == 'manual'){
	
	// put it all back the way it was.
	
	
	if ($section == 'delivery'){ // check for delivery as default is invoice.
	
					?>	<div class="dscheckoutInput"><label for="i_delivery_street"><?php echo TRANSLATION_CHECKOUT_STREET;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_delivery_street',$street,'size="24"  maxlength="24"','forminput'); ?> 
						</div>
		
						<div class="dscheckoutInput"><label for="i_delivery_house"><?php echo TRANSLATION_CHECKOUT_HOUSE;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_delivery_house',$house,'size="15" maxlength="15"','forminput'); ?> 
						</div>

						<div class="dscheckoutInput"><label for="i_delivery_postcode"><?php echo TRANSLATION_CHECKOUT_POSTCODE;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_delivery_postcode', $pcode,'size="15"  maxlength="9"','forminput'); ?> 
						</div>


						<div class="dscheckoutInput"><label for="i_delivery_district"><?php echo TRANSLATION_CHECKOUT_DISTRICT;?>:</label>
						<?php echo dsf_form_input('i_delivery_district','','size="30"  maxlength="30"','forminput'); ?>
						</div>

						<div class="dscheckoutInput"><label for="i_delivery_town"><?php echo TRANSLATION_CHECKOUT_TOWN;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_delivery_town','','size="30"  maxlength="30"','forminput') . dsf_form_hidden('i_delivery_sap_county',0); ?> 
						</div>
		
				  
						<div class="dscheckoutInput"><label for="i_delivery_country"><?php echo TRANSLATION_CHECKOUT_COUNTRY;?>:</label>
						<?php echo dsf_country_list('i_delivery_country','','','forminput',$dsv_master_country_id); ?>
						</div>

<?php

	}else{
		// default invoice
		?>
						<div class="dscheckoutSection">

						<div class="dscheckoutInput"><label for="i_invoice_street"><?php echo TRANSLATION_CHECKOUT_STREET;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_street',$street,'size="24"  maxlength="24"','forminput'); ?> 
						</div>
		
						<div class="dscheckoutInput"><label for="i_invoice_house"><?php echo TRANSLATION_CHECKOUT_HOUSE;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_house',$house,'size="15" maxlength="15"','forminput'); ?> 
						</div>

						<div class="dscheckoutInput"><label for="i_invoice_postcode"><?php echo TRANSLATION_CHECKOUT_POSTCODE;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_postcode', $pcode,'size="15"  maxlength="9"','forminput') ; ?> 
						</div>


						<div class="dscheckoutInput"><label for="i_invoice_district"><?php echo TRANSLATION_CHECKOUT_DISTRICT;?>:</label>
						<?php echo dsf_form_input('i_invoice_district','','size="30"  maxlength="30"','forminput'); ?>
						</div>

						<div class="dscheckoutInput"><label for="i_invoice_town"><?php echo TRANSLATION_CHECKOUT_TOWN;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_town','','size="30"  maxlength="30"','forminput').dsf_form_hidden('i_invoice_sap_county',0); ?> 
						</div>
		
						<div class="dscheckoutInput"><label for="i_invoice_country"><?php echo TRANSLATION_CHECKOUT_COUNTRY;?>:</label>
						<?php echo dsf_country_list('i_invoice_country','','','forminput',$dsv_master_country_id); ?>
						</div>


					</div>
        
        
        
        
        
        
      <?php
	} // end inv or del choice
	
		
	
	

}else{

	// we have received an error,  all we can do is ask the custom to enter their information manually
	// and send an email notification of the error.
?>
    <div class="addDoctorInst"><?php echo TRANSLATION_ADDDOCTOR_ERROR;?></div>

<?php	
	if ($section == 'delivery'){ // check for delivery as default is invoice.
	
					?>	<div class="dscheckoutInput"><label for="i_delivery_street"><?php echo TRANSLATION_CHECKOUT_STREET;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_delivery_street',$street,'size="24"  maxlength="24"','forminput'); ?> 
						</div>
		
						<div class="dscheckoutInput"><label for="i_delivery_house"><?php echo TRANSLATION_CHECKOUT_HOUSE;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_delivery_house',$house,'size="15" maxlength="15"','forminput'); ?> 
						</div>

						<div class="dscheckoutInput"><label for="i_delivery_postcode"><?php echo TRANSLATION_CHECKOUT_POSTCODE;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_delivery_postcode', $pcode,'size="15"  maxlength="9"','forminput'); ?> 
						</div>


						<div class="dscheckoutInput"><label for="i_delivery_district"><?php echo TRANSLATION_CHECKOUT_DISTRICT;?>:</label>
						<?php echo dsf_form_input('i_delivery_district','','size="30"  maxlength="30"','forminput'); ?>
						</div>

						<div class="dscheckoutInput"><label for="i_delivery_town"><?php echo TRANSLATION_CHECKOUT_TOWN;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_delivery_town','','size="30"  maxlength="30"','forminput') . dsf_form_hidden('i_delivery_sap_county',0); ?> 
						</div>
		
				  
						<div class="dscheckoutInput"><label for="i_delivery_country"><?php echo TRANSLATION_CHECKOUT_COUNTRY;?>:</label>
						<?php echo dsf_country_list('i_delivery_country','','','forminput',$dsv_master_country_id); ?>
						</div>

<?php

	}else{
		// default invoice
		?>
						<div class="dscheckoutSection">

						<div class="dscheckoutInput"><label for="i_invoice_street"><?php echo TRANSLATION_CHECKOUT_STREET;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_street',$street,'size="24"  maxlength="24"','forminput'); ?> 
						</div>
		
						<div class="dscheckoutInput"><label for="i_invoice_house"><?php echo TRANSLATION_CHECKOUT_HOUSE;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_house',$house,'size="15" maxlength="15"','forminput'); ?> 
						</div>

						<div class="dscheckoutInput"><label for="i_invoice_postcode"><?php echo TRANSLATION_CHECKOUT_POSTCODE;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_postcode', $pcode,'size="15"  maxlength="9"','forminput') ; ?> 
						</div>


						<div class="dscheckoutInput"><label for="i_invoice_district"><?php echo TRANSLATION_CHECKOUT_DISTRICT;?>:</label>
						<?php echo dsf_form_input('i_invoice_district','','size="30"  maxlength="30"','forminput'); ?>
						</div>

						<div class="dscheckoutInput"><label for="i_invoice_town"><?php echo TRANSLATION_CHECKOUT_TOWN;?>: <span class="dsRequired">*</span></label>
						<?php echo dsf_form_input('i_invoice_town','','size="30"  maxlength="30"','forminput').dsf_form_hidden('i_invoice_sap_county',0); ?> 
						</div>
		
						<div class="dscheckoutInput"><label for="i_invoice_country"><?php echo TRANSLATION_CHECKOUT_COUNTRY;?>:</label>
						<?php echo dsf_country_list('i_invoice_country','','','forminput',$dsv_master_country_id); ?>
						</div>


					</div>
        
        
        
        
        
        
      <?php
	} // end inv or del choice
	

}
?>