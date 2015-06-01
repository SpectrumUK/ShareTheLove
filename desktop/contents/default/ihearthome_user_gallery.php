

<?php $parent_details = dsf_get_individual_seasonal_article_details(16);?>

<?php

//$seasonal_details_menu = dsf_create_seasonal_articles_upper_menu(16);
// EXPLANATION OF A REPLACE SOLUTION

// you would put the function at the top of each content page (including any being loaded by ajax)

if (!function_exists('sr_heart_replace')){
	function sr_heart_replace($string_to_check = ''){
	
	// it is possible to do a single replace mode by using arrays as the first and seccond parameters however,
	// by doing that in this case it is going to be rather difficult to ready and adjust.
	
	// we will therefore just do a sequence of single replace commands one after the other until testing is complete and you are
	// happy with the outcome, this could then be changed to a single command with arrays later.
	
	//$string_to_check = str_replace("[REDHEART1]" , '<span class="heart_red_header"></span>' , $string_to_check);
	$string_to_check = str_replace("[REDHEART1]" , '<span class="heart_red_breadcrumb"></span>' , $string_to_check);
	$string_to_check = str_replace("[REDHEART2]" , '<span class="heart_red_big"></span>' , $string_to_check);
	$string_to_check = str_replace("[REDHEART3]" , '<span class="topright_redheart"></span>' , $string_to_check);
	
	$string_to_check = str_replace("[WHITEHEART1]" , '<span class="heart_white"></span>' , $string_to_check);
	$string_to_check = str_replace("[WHITEHEART2]" , '<span class="heart_white_poll" style="margin: 3px 0 0 0;"></span>' , $string_to_check);
	$string_to_check = str_replace("[WHITEHEART4]" , '<span class="heart_whiteheart_button verticaltextbottom"></span>' , $string_to_check);
	
	// alternatively,  if you didn't want to use the internal dsf_image function because you wanted to do some additional styles etc....  you could replace
	// using standard html
	
	
	// $string_to_check = str_replace("[WHITEHEART2]" , '<img src="custom/visa_icon.jpg" width="100" height="100" class="someclass" />' , $string_to_check);
	
	
	
	
// return back to the calling script the answer
	return $string_to_check;
	
	} // end function
} // end checking for function already loaded.

?>


<?php

// The contents of the user image details is within the array $user_image_details


// to see the contents of the array run the following command


// echo dsf_print_array($user_image_details);


/*

The value of dsv_image_level is the most important aspect as that will supply different options
for an if statement to show different things from within the same content file based on the level of the article.


Possible values are:	image	- a physical user image to display the details.
						filtered_listing	- a selection of images to show based on a filtered value.
						ajax_filtered_listing	- similar a selection of images to show based on a filtered value.
						listing	- a selection of images to show based on a select mechanic value.
						ajax_listing	- a selection of images to show based on a select mechanic value.
						none	- an error has occurred finding the item

NOTE: There are no differences between ajax no non ajax arrays other than the level supplied.    However,  when creating content they need to be treated differently
as ajax items are usually loaded into a div using javascript and therefore the content is usually different to the non-ajax items.


*/


// see what level we are referencing


// ##### IMAGE TYPE

	if ($dsv_image_level == 'image'){
		?>
		<script>
		function openFbPopUp() {
			FB.ui(
			  {
				  method: 'share',
				  href: '#',
			  },
			  function (response) {}
			);
		}
</script>
<title></title>

<div class="breadCrumbilh">
    <ul>
        <li><a href="<?php echo $bref;?>"><?php echo TRANSLATION_HOME;?></a></li>
        <li><a href="<?php echo $parent_details['url'];?>"><?php echo sr_heart_replace($parent_details['article_name']);?></a></li>
        <li><?php echo TRANSLATION_GALLERY_HEADER;?></li>
    </ul>
</div>
<div class="nav_topright">
<p><a href="<?php echo $SSL_bref;?>image_upload.html?mechanicID=1"><?php echo sr_heart_replace(TRANSLATION_USER_CUSTOM_TEN);?></a> &nbsp;|&nbsp;<a href="<?php echo $bref;?>user_images.html?mechanicID=1"><?php echo TRANSLATION_GALLERY_HEADER;?></a>
<?php /*&nbsp;&nbsp;<span class="topright_instagram"></span> <span class="topright_facebook"></span>*/?></p>
</div>

<div class="height15"></div>
<div class="col-sm-4 firstfix">
    <?php echo '<a href="' . $user_image_menu['url'] . '">' . dsf_image($user_image_menu ['image'], $user_image_menu['name'],'','', 'class="img-responsive"') . '</a>';?>
	</div>

<div class="height5"></div>
<img class="fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>
<?php echo dsf_image ($user_image_details['image_one'], '', '363', '363','class="img-responsive margin20auto"');?>

<?php if ($user_image_details['image_status_show'] == 'false'){
						echo '<div class="height30"></div>'; 
					  }else{						
					if ($dsv_show_social_network == 'true'){

					echo sr_heart_replace($user_image_details['mechanic']['text_block_three']);
					
                    echo $image_upload_details['text_block_six'];
						echo '<div class="centeritems">
						<div class="addthis_sharing_toolbox"></div>
						</div>
						
						<div class="height30"></div>'; 
				}else{
					echo '<div class="height30"></div>';
				}
					  }
				?>

<div class="text-center">
  <a href="<?php echo $SSL_bref;?>image_upload.html?mechanicID=1"><button type="button" class="btn btn-red gothamlight gallerybutton">
    <?php echo sr_heart_replace($user_image_details['mechanic']['mechanic_image_one_text']);?>
  </button></a>
</div>

<div class="height5"></div>
<img class="fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />
<div class="height5"></div>



<?php echo sr_heart_replace($user_image_details['mechanic']['text_block_four']);?>


<div class="everythingyou_gallery">
<?php   
  $ug_counter = 0;
	foreach ($user_image_details['user_images']['images'] as $id => $item){
		
	$ug_counter ++;
		
	if ($ug_counter < 5) {
		echo '<div class="col-sm-3"><a href="' . $item['url'] . '">' . dsf_image ($item['image_one'], '', '190', '190','class="img-responsive"') . '</a></div>'; 
		}
	}
?>

<?php 
	/*foreach ($user_image_details['user_images']['images'] as $id => $item){
		echo '<div class="col-sm-3"><a href="' . $item['url'] . '">' . dsf_image ($item['image_one_thumb'], '', '', '','class="img-responsive"') . '</a></div>'; 
	};*/
?>

	<div class="height30"></div>

	<div class="text-center">
	  <a href="<?php echo $bref;?>user_images.html?mechanicID=1"><button type="button" class="btn btn-red gothamlight gallerybutton">
	    <?php echo sr_heart_replace($user_image_details['mechanic']['mechanic_image_two_text']);?>
	  </button></a>
	</div>

</div>

<div class="height30"></div>

<?php 			

	}

// ###### END IMAGE TYPE


// ##### filtered_listing TYPE

	if ($dsv_image_level == 'filtered_listing' || $dsv_image_level == 'listing'){

		?>
<script type="text/javascript">

function showAjaxPageTwo(pageURL, pageDIV){
	
var urltoCall = pageURL;
var targDIV = MM_findObj(pageDIV);

var rndvalfix = Math.random() + "";
var rndval = rndvalfix * 10000000000000;
$(targDIV).hide(50);
$.ajax({
	

							method: "get",url: urltoCall, data: "rnd=" + rndval,
							success: function(html){ //so, if data is retrieved, store it in html
							$(targDIV).html(html);
							$(targDIV).show(100);
							
					 }
				 }); //close $.ajax(
}

</script>
<div class="breadCrumbilh">
    <ul>
        <li><a href="<?php echo $bref;?>"><?php echo TRANSLATION_HOME;?></a></li>
        <li><a href="<?php echo $parent_details['url'];?>"><?php echo sr_heart_replace($parent_details['article_name']);?></a></li>
        <li><?php echo TRANSLATION_GALLERY_HEADER;?></li>
    </ul>
</div>

<div class="nav_topright">
<p><a href="<?php echo $SSL_bref;?>image_upload.html?mechanicID=1"><?php echo sr_heart_replace(TRANSLATION_USER_CUSTOM_TEN);?></a> &nbsp;|&nbsp;<a href="<?php echo $bref;?>user_images.html?mechanicID=1"><?php echo TRANSLATION_GALLERY_HEADER;?></a><?php /*&nbsp;&nbsp;<span class="topright_instagram"></span> <span class="topright_facebook"></span>*/?></p>
</div>

	<div class="height15"></div>
    <h1 class="mainheader__everything"><?php echo sr_heart_replace($user_image_details['mechanic']['text_eight']);?></h1>
		<?php echo sr_heart_replace($user_image_details['mechanic']['text_block_eight']);?>

<img class="fancylineholder" src="../../../images/custom/ihearthome/layout/fancyline.png" />

<div class="col-md-12 textcenter">
	<div class="pull-right">
		<div class="pull-left font16 gothamlight" style="margin-right: 17px; padding: 10px 0 0;"><?php echo TRANSLATION_MOBILE_CUSTOM_TEN;?></div>
		
		<div class="btn-group">
			<button type="button" class="btn btn-red dropdown dropdown-toggle" data-toggle="dropdown"><?php echo $user_image_menu['title'];?></button>
			<ul class="dropdown-menu" role="menu">
            <?php 

    echo '<li><a href="' . $user_image_menu['url'] . '">' . $user_image_menu['title'] .'</a></li>';
			
				// loop through children
    foreach ($user_image_menu['children'] as $item){
 
 		echo '<li><a href="' . $item['url'] . '">' . $item['name'] .'</a></li>';
    
    		}
		?>  
			</ul>
		</div>
	</div>
</div>

<div class="height30"></div>

<div class="everythingyou_gallery">
<?php
// loop though images and print them.
		if(isset($user_image_details['user_images']['images']) && is_array($user_image_details['user_images']['images']) ){
   
   foreach ($user_image_details['user_images']['images'] as $item){
    
     if (isset($item['image_one']) && strlen($item['image_one']) > 1){
      // we have an image
      echo '<div class="col-sm-3" style="height:230px;"><a href="' . $item['url'] . '">' . dsf_image($item['image_one'], '', '190', '190') . '</a></div>';
   
   
  }
   }
}

?>
</div>

<?php 

  
 if ($user_image_details['user_images']['current_page'] < $user_image_details['user_images']['total_pages']){
	  
  $ug_next_page = (int)$user_image_details['user_images']['current_page'] + 1;
  $ug_next_url = $user_image_details['user_images']['page_ajax_urls'][$ug_next_page];
  $ug_next_div = "UGdiv" . $user_image_details['user_images']['current_page'];
 
	echo 
	'<div id="UGdiv' . $user_image_details['user_images']['current_page'] .'"><div class="text-center">
	<button onClick="showAjaxPageTwo(\'' . $ug_next_url . '\' , \'' . $ug_next_div .'\')" type="button" class="btn btn-loadmore gothamlight">' . TRANSLATION_USER_CUSTOM_NINE .  '<span class="heart_whiteheart_button" style="vertical-align: text-bottom;"></span>
	</button>
</div></div>';
}else{
	echo 
	'';

}?>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 402px; -webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius: 0px;">
	  <div class="modal-content nocurvedcorners">
	    <div class="modal-body">
	      <div class="curvedcorners closebackgroundmodal">
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div>
	      <img class="img-responsive margin20auto" src="public/images/layout/everythingyou/everythingyou_modalexample.jpg" alt=""/>
	    </div>
	    <div class="modal-footer">
	    <p>Share what you <span class="heart_red_nav"></span></p>
	    <img class="img-responsive centeritems " src="public/images/icons/modalfull_example.jpg" alt=""/>
	    </div>
	    <div class="height10"></div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
	$('.dropdown-toggle').dropdown()
</script>


        </div>
		
	<?php	
		// simple display of filter image.
		
		/*if (isset($user_image_details['filter_image_one']) && strlen($user_image_details['filter_image_one']) > 4){
			// we have an image
			echo '<div>' . dsf_image($user_image_details['filter_image_one']) . '</div>';
		}

		if (isset($user_image_details['filter_name']) && strlen($user_image_details['filter_name']) > 2){
			// we have a title
			echo '<div><h2>' . $user_image_details['filter_name'] . '</h2></div>';
		}*/

	}

// ###### END filtered_listing TYPE


// ##### ajax_filtered_listing TYPE

	if ($dsv_image_level == 'ajax_filtered_listing' || $dsv_image_level == 'ajax_listing'){

// loop though images and print them.
		if(isset($user_image_details['user_images']['images']) && is_array($user_image_details['user_images']['images']) ){
   
   foreach ($user_image_details['user_images']['images'] as $item){
    
     if (isset($item['image_one']) && strlen($item['image_one']) > 1){
      // we have an image
      echo '<div class="col-sm-3" style="height:230px;"><a href="' . $item['url'] . '">' . dsf_image($item['image_one'], '', '190', '190') . '</a></div>';
   
   
  }
   }
}

?>
</div>

<?php 

  
 if ($user_image_details['user_images']['current_page'] < $user_image_details['user_images']['total_pages']){
	  
  $ug_next_page = (int)$user_image_details['user_images']['current_page'] + 1;
  $ug_next_url = $user_image_details['user_images']['page_ajax_urls'][$ug_next_page];
  $ug_next_div = "UGdiv" . $user_image_details['user_images']['current_page'];
 
	echo 
	'<div id="UGdiv' . $user_image_details['user_images']['current_page'] .'"><div class="text-center">
	<button onClick="showAjaxPageTwo(\'' . $ug_next_url . '\' , \'' . $ug_next_div .'\')" type="button" class="btn btn-loadmore gothamlight">' . TRANSLATION_USER_CUSTOM_NINE .  '<span class="heart_whiteheart_button" style="vertical-align: text-bottom;"></span>
	</button>
</div></div>';
}else{
	echo 
	'';

}

	}

// ###### END ajax_filtered_listing TYPE


// ##### listing TYPE

	/*if ($dsv_image_level == 'listing'){
		
		?>
        
        		
<div class="col-md-12 textcenter">
	<div class="pull-right">
		<div class="pull-left font16 gothamlight" style="margin-right: 17px; padding: 10px 0 0;"><?php echo TRANSLATION_MOBILE_CUSTOM_TEN;?></div>
		
		<div class="btn-group">
			<button type="button" class="btn btn-red dropdown dropdown-toggle" data-toggle="dropdown"><?php echo $user_image_menu['title'];?></button>
			<ul class="dropdown-menu" role="menu">
            <?php 

    echo '<li><a href="' . $user_image_menu['url'] . '">' . $user_image_menu['title'] .'</a></li>';
			
				// loop through children
    foreach ($user_image_menu['children'] as $item){
 
 		echo '<li><a href="' . $item['url'] . '">' . $item['name'] .'</a></li>';
    
    		}
		?>  
			</ul>
		</div>
	</div>
</div>

<div class="height30"></div>

<div class="everythingyou_gallery">

<?php
// loop though images and print them.
		if(isset($user_image_details['user_images']['images']) && is_array($user_image_details['user_images']['images']) ){
   
   foreach ($user_image_details['user_images']['images'] as $item){
    
     if (isset($item['image_one']) && strlen($item['image_one']) > 1){
      // we have an image
      echo '<div class="col-sm-3" style="height:230px;"><a data-toggle="modal" href="#myModal">' . dsf_image($item['image_one'], '', '190', '190') . '</a></div>';
   
   
  }
   }
}

?>
</div>

<div class="height30"></div>
<div class="height30"></div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" style="width: 402px; -webkit-border-radius: 0px; -moz-border-radius: 0px; border-radius: 0px;">
	  <div class="modal-content nocurvedcorners">
	    <div class="modal-body">
	      <div class="curvedcorners closebackgroundmodal">
	      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button></div>
	      
	    </div>
	    <div class="modal-footer">
	    <p>Share what you <span class="heart_red_nav"></span></p>
	    <img class="img-responsive centeritems " src="public/images/icons/modalfull_example.jpg" alt=""/>
	    </div>
	    <div class="height10"></div>
	  </div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


		<?php /*echo '<div><br /><br /><br /><br /><br /><br /><br />LEVEL = listing</div>';

		// loop though images and print them.
		if(isset($user_image_details['user_images']['images']) && is_array($user_image_details['user_images']['images']) ){
			
			foreach ($user_image_details['user_images']['images'] as $item){
				
					if (isset($item['image_one']) && strlen($item['image_one']) > 4){
						// we have an image
						echo '<div>' . dsf_image($item['image_one']) . '<br />' . $item['image_name'] . '</div>';
					}
				
			}
		
		
			
		}

	}*/

// ###### END listing TYPE


// ##### ajax_listing TYPE

	/*if ($dsv_image_level == 'ajax_listing'){

		echo '<div id="AJdiv">LEVEL = ajax_listing';

		// loop though images and print them.
		if(isset($user_image_details['user_images']['images']) && is_array($user_image_details['user_images']['images']) ){
			
			foreach ($user_image_details['user_images']['images'] as $item){
				
					if (isset($item['image_one']) && strlen($item['image_one']) > 4){
						// we have an image
						echo '<div>' . dsf_image($item['image_one']) . '<br />' . $item['image_name'] . '</div>';
					}
				
			}
		
		echo '</div>';	
		}

	}*/

// ###### END ajax_listing TYPE
//echo '<h2>Full Array =</h2>' . dsf_print_array($user_image_details['user_images']['images'][0]['url']);
//echo '<h2>' . dsf_print_array($parent_details) . '</h2>';
//echo '<h2>Menu Array =</h2>' . dsf_print_array($user_image_menu);
//echo $ug_next_page . "<br />";
//echo $ug_next_url . "<br />";
//echo $ug_next_div;

?>
