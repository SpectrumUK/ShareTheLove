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
    <label><?php echo TRANSLATION_PARTS_DROPDOWN_PRODUCTS;?>:</label><?php echo dsf_form_dropdown('menu_part_name', $dsv_parts_select, $dsv_part_name, 'onchange="DSMENUPartjump();"', 'forminput');
	
	
}else{
	// we load everything including jquery javascript code and format accordingly
	?>
<div id="CPMENU_cats">
<div id="CPMENUtitle"><?php echo strtoupper(TRANSLATION_PARTS_DROPDOWN_TITLE);?></div>

<div id="CPMENUleft"><?php
	// echo the category names with radio buttons.
	foreach($dsv_parts_radio as $id => $value){
	
		echo '<div class="CPMENUradio">' . dsf_form_radio('dsv_menu_part_category', $id, (isset($dsv_parts_selected) && $dsv_parts_selected == $id ? true : false),'onclick="DSMENUPartSel(' . $id . ');"') . '&nbsp;' . $value . '</div>';
		
	}
	?></div></div>
    
    <div id="CPMENUright">
    <div id="CPMENUprodHold"><div id="CPMENUprods"><label><?php echo TRANSLATION_PARTS_DROPDOWN_PRODUCTS;?>:</label><?php echo dsf_form_dropdown('menu_part_name', $dsv_parts_select, $dsv_part_name, 'onchange="DSMENUPartjump();"', 'forminput');?></div></div>
    <div class="CPMENUsearch"><?php echo dsf_form_search('menu_part_keywords',$dsv_part_keywords,'size="20"','forminput', TRANSLATION_PARTS_DROPDOWN_SEARCH); ?></div>	
    <div class="CPMENUsearchBut"><?php echo dsf_submit_image('button_search.gif', TRANSLATION_SEARCH_BUTTON) . dsf_form_hidden('menu_partSearch' , dsf_href_link('parts-search.html')) . dsf_form_hidden('dsv_menu_radio_part' , $dsv_parts_select); ?></div>	
	</div>
	
<?php	
} // end coming from ajax or first load.
echo $dsv_cat_parts_nav_form_end;
?>
<script>
$("#menu_part_name").mouseleave(function(event){     event.stopPropagation();   });
</script>
