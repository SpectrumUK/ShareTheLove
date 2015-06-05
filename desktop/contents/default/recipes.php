<!-- body //-->
<?php

 // #######  SECTION 1 #############
 
 // TOP LEVEL RECIPE    /RECIPES/  NOTHING ELSE SELECTED.
 
 if ($dsv_recipe_level == 'top'){
 
 	// as we are at top the array $main_recipe will not be set therefore the only dynamic info
	// is the nested items underneath.
	
	// This can however be mixed with hardcoded info
	
	// we will format this as standard similar to george to show off the capabilities.
?>
	<div class="details" id="contentDiv">
		<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div><?php
	// decide whether to put text title or image title This would be hardcoded for top level
		?></div>
	</div>
	<div id="contentContainer">
    	<div id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
<div id="rightContent">
	<div class="pagTitles">	
	<h1><?php echo 'Recipes'; ?></h1>
    <div class="addthis"><!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=saltonuk"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=saltonuk"></script>
<!-- AddThis Button END -->
</div>
</div>
<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Phasellus pharetra, nisl ut adipiscing egestas, enim purus molestie lorem, ac semper leo leo non nunc. Nunc pulvinar justo nec leo. Ut auctor condimentum pede. 	
    Integer est nisi, pulvinar eget, congue a, vulputate at.</p>
	<p>Nullam sollicitudin imperdiet nunc. Aenean nibh neque, laoreet ut, eleifend id, interdum non, dolor. Suspendisse potenti.</p>
    <div class="dropForm">
            <select name="recipes" class="active" onChange="dojump(this)">
            	<option value="" class="active">Select a recipe</option>
			<?php
		// start right hand nav
		if (isset($recipe_children) && is_array($recipe_children)){
			foreach($recipe_children as $item){
		if ((int)$recipe_children['current_id'] == (int)$item['id']){
					// current select item
					echo '<option value="' . $item['url'] . '" class="active">'. $item['name'] . '</option>' . "\n";
				}else{
					echo '<option value="' . $item['url'] . '">' . $item['name'] . '</option>' . "\n";
				}
			}
		}
		?>
        </select>
        </div>
        <div class="lineBreak"></div>
	
<?php

// get a list of the last 3 recipes added to the system.

 ?> 
 	<h1><?php echo 'Latest Recipes'; ?></h1>
<div class="recipes">
 		<?php
		if (isset($latest_recipes) && is_array($latest_recipes)){
			// we have an array of items therefore create unordered list.
			echo '<ul>';
			foreach ($latest_recipes as $item){
				echo '<li>';
						echo '<div class="imgColumn"><a href="' . $item['url'] . '">' . dsf_image($item['listing_image'], $item['name'],$item['width'],$item['height']) . '</a></div>' . "\n";
						echo '<div class="txtColumn"><h3><a href="' . $item['url'] . '">' . $item['name'] . '</a></h3><a href="' . $item['url'] . '">' . $item['short_text'] . '</a></div>' . "\n";
				echo '</li>';
			} // end for each loop
			echo '</ul>'; // clode the unordered list
		} // end check for recipe children
	
	?>
  </div>
<?php

// end of top level




 // #######  SECTION 2 #############
	

}elseif ($dsv_recipe_level == 'nested') {
 	// as we are nested the array $main_recipe should be set therefore we can show some additional text about
	// the group as well as the nested items underneath.
	
	
	// we will format this as standard similar to george to show off the capabilities.
?>
	<div class="details" id="contentDiv">
		<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div></div>
	</div>
	<div id="contentContainer">
    	<div id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
<div id="rightContent">
	<div class="pagTitles">
    <h1><?php echo $main_recipe['name'];?></h1>
    <div class="addthis"><!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=saltonuk"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=saltonuk"></script>
<!-- AddThis Button END -->
</div>
</div>
	<div><?php echo $main_recipe['main_text'];?></div>
    <p><a href="recipes">« return to recipe listings</a></p>
<div class="lineBreak"></div>

  		
<?php

// get the children under this recipe (this will need refomatting as just used previous styles for example) 
 ?> <div class="recipes">
 		<?php
		if (isset($recipe_children) && is_array($recipe_children)){
			// we have an array of items therefore create unordered list.
			echo '<ul>';
			foreach ($recipe_children as $item){
				echo '<li><div id="recipeListing" class="recipe">';
					// for example have used the main_image however any of the available images could be used.
						echo '<div class="imgColumn"><a href="' . $item['url'] . '">' . dsf_image($item['listing_image'], $item['name'],$item['width'],$item['height']) . '</a></div>' . "\n";
						echo '<div class="txtColumn"><h3><a href="' . $item['url'] . '">' . $item['name'] . '</a></h3><a href="' . $item['url'] . '">' . $item['short_text'] . '</a></div>' . "\n";
					// close off this list item
				echo '</div></li>' . "\n";
			} // end for each loop
			echo '</ul>'; // clode the unordered list
		} // end check for recipe children
	?>
  </div>
<?php

// end of nested level



 // #######  SECTION 3 #############

// must be showing a recipe

  }elseif ($dsv_recipe_level == 'recipe') {
	
	// The full recipe details as with the previous nested will be stored in the variable $main_recipe
	// which can be used on this page and formatted accordingly.
	
?>
	<div class="details" id="contentDiv">
		<div id="contentHeader"><div class="breadCrumb"><?php echo $dsv_breadcrumb; ?></div>
    	</div>
	</div>
	<div id="contentContainer">
    	<div id="content">
        	<div id="leftMenu"><?php include ('custom_modules/left_menu.php');?></div>
<div id="rightContent">
<div class="pagTitles">		
    <div class="addthis"><!-- AddThis Button BEGIN -->
<a class="addthis_button" href="http://www.addthis.com/bookmark.php?v=250&amp;pub=saltonuk"><img src="http://s7.addthis.com/static/btn/v2/lg-share-en.gif" width="125" height="16" alt="Bookmark and Share" style="border:0"/></a><script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js?pub=saltonuk"></script>
<!-- AddThis Button END -->
</div>
</div>
<?php
// Choose from all of the available variables, for the example we are only using the main text field.
 ?> 
 <div class="imgColumn">
 	<div class="recipe"><?php
	if (isset($main_recipe['listing_image'])){
			echo dsf_image($main_recipe['listing_image']);
	}
	?>
    </div>
    <?php
	if (isset($main_recipe['main_image'])){
			echo dsf_image($main_recipe['main_image']);
	}
	?>
 </div>
 <div class="recipeDetails">
 	<h1><?php echo $main_recipe['name'];?></h1>
 	<?php echo $main_recipe['main_text'];?>
 	<p><a href = "javascript:history.back()">« return to perivous page</a></p>
 </div>
<?php
	// new added upto three products section which will need formatting.
	
	if (is_array($recipe_products) && sizeof($recipe_products)>0){
			?>
		<div>Suggested Products</div>
		<div>
		 <ul>
		<?php
			foreach($recipe_products as $item){
				
				echo '<li><div>' . "\n";
					if (isset($item['image']) && strlen($item['image'])>1){
						echo '<a href="' . $item['url'] . '">' . dsf_image($item['image'], $item['name'],$item['width'],$item['height']) . '</a>';
					}else{
						echo '<a href="' . $item['url'] . '">' . dsf_notavailable_image($item['width'], $item['height']) . '</a>';
					}
				echo '<br><br><a href="' . $item['url'] . '">' . dsf_image_button($dsv_moreinfo_button , 'More Info') . '</a>';
				echo '</div></li>' . "\n";
			 }	
		?>
		</ul>
		</div><?php
		}

	
	
	
	
	
	
// end of recipe level


} // end of the 3 section if
?>

</div>
</div>
</div>
<!-- body_eof //-->