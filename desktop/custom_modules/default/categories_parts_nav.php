<?php
// this file is used to display the categories parts navigation currently set to the top
// left of the screen over the banner image.

// we have as constants on all pages this is to be included into the following variables:

// $dsv_parts_radio  as an array of  category_id => category name.    This is used for radio buttons.

// $dsv_parts_select as a multi array of  product_id, products_model used for product dropdown which is dynamic

// IMPORTANT - this include is used as a stand alone as well as an ajax call which needs to change the contents of the
// products dropdown box dynamically, therefore this file must use a DIV called 'CPprods' in order to re-populate

echo $dsv_cat_parts_nav_form_start;

if (isset($dsv_from_ajax) && $dsv_from_ajax == 'true'){
	// we are re-loading this page therefore all we want is the products dropdown box
	?>
    <label><?php echo TRANSLATION_TEXT_PRODUCTS;?>:</label><?php echo dsf_form_dropdown('part_name', $dsv_parts_select, $dsv_part_name, 'onchange="DSPartjump();"', 'forminput');
	
	
}else{
	// we load everything including jquery javascript code and format accordingly
?>
<div id="CP_cats"><?php
	// echo the category names with radio buttons.
	foreach($dsv_parts_radio as $id => $value){
	
		echo '<div class="CPradio">' . dsf_form_radio('dsv_part_category', $id, (isset($dsv_parts_selected) && $dsv_parts_selected == $id ? true : false),'onclick="DSPartSel(' . $id . ');"') . '&nbsp;' . $value . '</div>';
		
	}
	?></div>
    <div class="CPdivider"></div>
    <div id="CPprodHold"><div id="CPprods" class="CPdrop"><label><?php echo TRANSLATION_TEXT_PRODUCTS;?>:</label><?php echo dsf_form_dropdown('part_name', $dsv_parts_select, $dsv_part_name, 'onchange="DSPartjump();"', 'forminput');?></div></div>
    <div class="CPsearch"><?php echo dsf_form_input('part_keywords',$dsv_part_keywords,'size="20"','forminput'); ?></div>	
    <div class="CPsearchBut"><?php echo dsf_submit_image('search_parts_btn.gif', TRANSLATION_SEARCH_BUTTON) . dsf_form_hidden('partSearch' , dsf_href_link('parts-search.html')) . dsf_form_hidden('dsv_radio_part' , $dsv_parts_select); ?></div>	
	
	
<?php	
} // end coming from ajax or first load.
echo $dsv_cat_parts_nav_form_end;
?>