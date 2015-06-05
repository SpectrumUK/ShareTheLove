<?php

if ($action == 'success'){
?>
<script>
		function openFbPopUp() {
			FB.ui(
			  {
				  method: 'share',
				  href: '<?php echo $user_image_details['url'];?>',
			  },
			  function (response) {}
			);
		}
</script>
<header class="content-wrapper center-text">&nbsp;</header>
<div class="wrapper wrapper--step bordered">

                <section class="content-wrapper">

                    <h2><?php echo TRANSLATION_USER_CUSTOM_FOUR;?></h2>

                    <hr class="hr--grey top" />
					
                    <div id="photo-container" class="message">
                        <?php echo dsf_image($user_image_details ['image_one'], $user_image_details['text_one'],'316','316');?> 
                     <div class="text">   
                      <?php if ($user_image_details['image_status_show'] == 'false'){
						echo $image_upload_details['text_block_six'];
						
						if ($dsv_show_social_network == 'true'){

					echo '<ul class="button-inline-list">
                                <li>
                                    <a onclick="openFbPopUp()" href="javascript:void(0);" class="updated-icons facebook-button">
                                        <i class="share-icon-image">
                                            Facebook
                                       	</i>
                                        <span class="share-icon-text">'
                                            . TRANSLATION_USER_IMAGE_SHARE .
                                        '</span>
                                        <!--<i class="icon icon-share icon-share--fb">Facebook</i>-->
                                    </a>
                                </li>
                                <li>
                                    <a class="updated-icons twitter-button" href="https://twitter.com/share?text=' . $image_upload_details['text_six'] . '" target="_blank">
                                        <!--<i class="icon icon-share icon-share--tw">Twitter</i>-->
                                        <i class="share-icon-image">
                                            Twitter
                                        </i>
                                        <span class="share-icon-text">'
                                            . TRANSLATION_USER_IMAGE_TWEET . 
                                        '</span>
                                    </a>
                                </li>
                            </ul>
                            
                            <a href="' . $bref . 'images/' . $user_image_details['image_one'] . '" class="updated-icons save-button">
                                <i class="share-icon-image">
                                    Save Image
                                </i>
                                <span class="share-icon-text">'
                                    . TRANSLATION_USER_IMAGE_SAVE . 
                                '</span>
                            </a>';
				}else{
					echo '';
				}
					  }else{						
						echo $image_upload_details['text_block_five']; 
						
					if ($dsv_show_social_network == 'true'){

					echo '<ul class="button-inline-list">
                                <li>
                                    <a onclick="openFbPopUp()" href="javascript:void(0);" class="updated-icons facebook-button">
                                        <i class="share-icon-image">
                                            Facebook
                                       	</i>
                                        <span class="share-icon-text">'
                                            . TRANSLATION_USER_IMAGE_SHARE .
                                        '</span>
                                        <!--<i class="icon icon-share icon-share--fb">Facebook</i>-->
                                    </a>
                                </li>
                                <li>
                                    <a class="updated-icons twitter-button" href="https://twitter.com/share?text=' . $image_upload_details['text_six'] . '" target="_blank">
                                        <!--<i class="icon icon-share icon-share--tw">Twitter</i>-->
                                        <i class="share-icon-image">
                                            Twitter
                                        </i>
                                        <span class="share-icon-text">'
                                            . TRANSLATION_USER_IMAGE_TWEET . 
                                        '</span>
                                    </a>
                                </li>
                            </ul>
                            
                            <a href="' . $bref . 'images/' . $user_image_details['image_one'] . '" class="updated-icons save-button">
                                <i class="share-icon-image">
                                    Save Image
                                </i>
                                <span class="share-icon-text">'
                                    . TRANSLATION_USER_IMAGE_SAVE . 
                                '</span>
                            </a>';
				}else{
					echo '';
				}
};?>

                        </div>
                    </div>
                    
                    <div class="btn-row center">
                        <hr class="hr--faded bottom" />
                        <a href="<?php echo $bref;?>user_images.html?mechanicID=1" class="redBtn"><?php echo TRANSLATION_USER_VIEW_GALLERY;?></a>
                    </div>

                </section>

            </div>
            <script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/plugins.js"></script>
		<script>
		(function (d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) { return; }
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		</script>
            <?php

// The contents of the image upload items is within the array $image_upload_details

// to see the contents of the array run the following command
//echo '<div style="background-color:#ffffff;color:#000000;">' . dsf_print_array($user_image_details) . '</div>';
//echo '<div style="background-color:#ffffff;color:#000000;">' . dsf_print_array($image_upload_details) . '</div>';


?>
            
<?php
}else{
?>

<header class="content-wrapper center-text">
                <p class="title"><?php echo TRANSLATION_USER_YOUR_PROGRESS;?></p>
                <ul class="inline-list breadcrumb">
                    <li><i class="icon icon--smlheart">1</i></li>
                    <li><i class="icon icon--smlheart">2</i></li>
                    <li><i class="icon icon--smlheart">3</i></li>
                    <li><i class="icon icon--smlheart">4</i></li>
                    <li><i class="icon icon--smlheart">5</i></li>
                </ul>
            </header>
            			
            <div class="wrapper wrapper--step bordered">

				<!-- Competition Pick Photo -->
                <section class="content-wrapper center-text comp-slide slide-pick">
                    
					<h1><?php echo TRANSLATION_USER_PICK_PHOTO;?></h1>
                    
                    <hr class="hr--grey top" />
                    <div class="red-buttons">
						
						<div id="flashUploadImage" style="display: none;"></div>
						
                        <a href="JavaScript:void(0);" id="btn-choose-file" class="icon-button">
                            <i class="icon red-icon icon--choose"></i>
                            <span><?php echo TRANSLATION_USER_CHOOSE_FILE;?></span></a>
                        <a href="JavaScript:void(0);" id="btn-take-photo" class="icon-button">
                            <i class="icon red-icon icon--takephoto"></i>
                            <span><?php echo TRANSLATION_USER_TAKE_PHOTO;?></span></a>
                        <a href="JavaScript:void(0);" class="icon-button" id="btn-find-fb-photo">
                            <i class="icon red-icon icon--facebook"></i>
                            <span><?php echo TRANSLATION_USER_FACEBOOK_PHOTO;?></span></a>
                    </div>
					
					<input id="fileInput" type="file" accept="image/*">
					
					<input id="cameraInput" type="file"  accept="image/*" capture="camera" />
                </section>
				<!-- Competition Pick Photo -->
				
				<!-- Competition FB Photo -->
				<section class="content-wrapper wrapper--step comp-slide slide-fb-photo">
					<h1><?php echo TRANSLATION_USER_PICK_PHOTO;?></h1>
					<hr class="hr--grey top" />
					
                    <div class="gallery-breadcrumb">
                        <p><a href="JavaScript:void(0);" onclick="loadFBGallery()"><?php echo TRANSLATION_USER_CUSTOM_ONE;?></a> <span id="fb-album-title"></span></p>
                    </div>
					<div id="fb-photo-list" class="gallery-container content-scroll"><ul id="fb-photo-list-ul"></ul></div>
					
                    <div class="btn-row center">
                        <hr class="hr--faded bottom" />
                        <a  href="JavaScript:void(0);" id="btn-fb-back" class="button grey-button"><span><i class="icon white-chevron"></i>Back</span></a>
                    </div>

				</section>
				<!-- Competition FB Photo -->
				
                <!-- Webcam photo -->
				<section class="content-wrapper wrapper--step comp-slide slide-take-photo center-text">

                    <h1><?php echo TRANSLATION_USER_TAKE_PHOTO;?></h1>
					<hr class="hr--grey top" />
					
                    <!-- camera bit -->
                    <div id="flashContent"></div>
            	
                    <div class="btn-row">
                        <hr class="hr--faded bottom" />
                        <a href="javascript:void(0);" onclick="callFlex();" class="redBtn padded--inner"><i class="icon red-icon icon--takephoto"></i><span><?php echo TRANSLATION_USER_CUSTOM_TWO;?></span></a>
                        <a href="JavaScript:void(0);" id="btn-webcam-back" class="button grey-button"><span><i class="icon white-chevron"></i><?php echo TRANSLATION_USER_IMAGE_BACK;?></span></a>
                    </div>
			
				</section>
				<!-- Webcam photo -->

                <section class="content-wrapper comp-slide slide-terms-conditions">
                    <!-- Ts and Cs -->
                    <h1><?php echo $image_upload_details['text_seven'];?></h1>

                    <hr class="hr--grey" />

                    <div class="content-scroll">
                     	<?php echo $image_upload_details['text_block_seven'];?>  
                    </div>

                    <div class="btn-row center-text">
                        <hr class="hr--faded bottom" />
                        <a href="JavaScript:void(0);" id="btn-close-tsandcs" class="redBtn padded--med"><?php echo TRANSLATION_USER_CUSTOM_THREE;?></a>
                    </div>
                </section>

				<!-- Competition Canvas -->
				<section class="content-wrapper comp-slide slide-canvas">
					<h1><?php echo TRANSLATION_USER_PICK_PHOTO;?></h1>
                    
					<hr class="hr--grey" />
                    <form id="rhForm">
					
                        <div id="photo-container">
						    
							<canvas id="canvas" width="315" height="315"></canvas>
                       
					        <!-- Crop It -->
						    <div class="form-step form-crop-it">
							    <ul class="vertical-list image-tools">
									<li><div id="btn-rotate"><i class="icon icon-text icon--rotate">Rotate</i></div></li>
									<li class="divider"><div id="btn-zoom-in"><i class="icon icon-text icon--zoom-in"><?php echo TRANSLATION_USER_IMAGE_ZOOM;?></i></div></li>
									<li><div id="btn-zoom-out"><i class="icon icon-text icon--zoom-out"><?php echo TRANSLATION_USER_CUSTOM_FIVE;?></i></div></li>
									<li class="divider text-pos"><p><?php echo TRANSLATION_USER_CUSTOM_SIX;?></p><div id="btn-textpos"><i class="icon icon-text icon--text-pos">Top/Bottom selector</i></div></li>
								</ul>
								<p class="tools-text"><strong><?php echo TRANSLATION_USER_IMAGE_DRAG;?></strong></p>
						    </div>

                            <!-- Filter It -->
						    <div class="form-step form-filter-it" >
							    <ul class="inline-list image-filters">
								    <li><div id="btn-filter1"><img src="../../../images/custom/ihearthome/mechanic/filter-1.jpg" alt="<?php echo TRANSLATION_USER_IMAGE_SELECT_FILTER;?>" title="<?php echo TRANSLATION_USER_IMAGE_SELECT_FILTER;?>" /></div></li>
								    <li><div id="btn-filter2"><img src="../../../images/custom/ihearthome/mechanic/filter-2.jpg" alt="<?php echo TRANSLATION_USER_IMAGE_ADD_FILTER;?>" title="<?php echo TRANSLATION_USER_IMAGE_ADD_FILTER;?>" /></div></li>
								    <li><div id="btn-filter3"><img src="../../../images/custom/ihearthome/mechanic/filter-3.jpg" alt="<?php echo TRANSLATION_USER_IMAGE_ADD_FILTER;?>" title="<?php echo TRANSLATION_USER_IMAGE_ADD_FILTER;?>" /></div></li>
								    <li><div id="btn-filter4"><img src="../../../images/custom/ihearthome/mechanic/filter-4.jpg" alt="<?php echo TRANSLATION_USER_IMAGE_ADD_FILTER;?>" title="<?php echo TRANSLATION_USER_IMAGE_ADD_FILTER;?>" /></div></li>
							    </ul>
						    </div>

                             <!-- Entry form -->
                             
                            <div class="form-step form-entry-form">
                                 <div class="form-wrapper">
                                    <div class="formRow no-margin"><?php echo $dsv_dynamic_form_fields['txtYourName']['long_text'];?></div>
                                    <div class="formRow two-col">
                                        <label class="txtLabel js-hide" for="<?php echo $dsv_dynamic_form_fields['txtFirstName']['field_name'];?>"><?php echo $dsv_dynamic_form_fields['txtFirstName']['field_text'];?></label>
                                        <input type="text" class="txtbox" placeholder="<?php echo $dsv_dynamic_form_fields['txtFirstName']['field_text'];?>" id="<?php echo $dsv_dynamic_form_fields['txtFirstName']['field_name'];?>" name="<?php echo $dsv_dynamic_form_fields['txtFirstName']['field_name'];?>" required />
                                    </div>
                                    <div class="formRow two-col">
                                        <label class="txtLabel js-hide" for="<?php echo $dsv_dynamic_form_fields['txtLastName']['field_name'];?>"><?php echo $dsv_dynamic_form_fields['txtLastName']['field_text'];?></label>
                                        <input type="text" class="txtbox" placeholder="<?php echo $dsv_dynamic_form_fields['txtLastName']['field_text'];?>" id="<?php echo $dsv_dynamic_form_fields['txtLastName']['field_name'];?>" name="<?php echo $dsv_dynamic_form_fields['txtLastName']['field_name'];?>" required />
                                    </div>
                                    <div class="formRow no-margin"><span class="group-label"><?php echo $dsv_dynamic_form_fields['txtDOB']['long_text'];?></span></div>
                                    <div class="formRow three-col">
                                        <label class="txtLabel js-hide" for="<?php echo $dsv_dynamic_form_fields['txtDobDay']['field_name'];?>"><?php echo $dsv_dynamic_form_fields['txtDobDay']['field_text'];?></label>
                                        <input type="text" class="txtbox" placeholder="<?php echo $dsv_dynamic_form_fields['txtDobDay']['field_text'];?>" id="<?php echo $dsv_dynamic_form_fields['txtDobDay']['field_name'];?>" maxlength="2" name="<?php echo $dsv_dynamic_form_fields['txtDobDay']['field_name'];?>" required />
                                    </div>
                                    <div class="formRow three-col">
                                        <label class="txtLabel js-hide" for="<?php echo $dsv_dynamic_form_fields['txtDobMonth']['field_name'];?>"><?php echo $dsv_dynamic_form_fields['txtDobMonth']['field_text'];?></label>
                                        <input type="text" class="txtbox" placeholder="<?php echo $dsv_dynamic_form_fields['txtDobMonth']['field_text'];?>" id="<?php echo $dsv_dynamic_form_fields['txtDobMonth']['field_name'];?>" maxlength="2" name="<?php echo $dsv_dynamic_form_fields['txtDobMonth']['field_name'];?>" required />
                                    </div>
                                    <div class="formRow three-col">
                                        <label class="txtLabel js-hide" for="<?php echo $dsv_dynamic_form_fields['txtDobYear']['field_name'];?>"><?php echo $dsv_dynamic_form_fields['txtDobYear']['field_text'];?></label>
                                        <input type="text" class="txtbox" placeholder="<?php echo $dsv_dynamic_form_fields['txtDobYear']['field_text'];?>" id="<?php echo $dsv_dynamic_form_fields['txtDobYear']['field_name'];?>" maxlength="4" name="<?php echo $dsv_dynamic_form_fields['txtDobYear']['field_name'];?>" required />
                                    </div>
                                    <div class="formRow">
                                        <select class="select styled red" id="<?php echo $dsv_dynamic_form_fields['ddCountry']['field_name'];?>" name="<?php echo $dsv_dynamic_form_fields['ddCountry']['field_name'];?>" required>
                                        <?php echo $dsv_dynamic_form_fields['ddCountry']['field_values'];?>
                                        </select>
                                    </div>
                                    <div class="formRow no-margin"><?php echo $dsv_dynamic_form_fields['txtEmailAddress']['long_text'];?></div>
                                    <div class="formRow">
                                        <label class="txtLabel js-hide" for="<?php echo $dsv_dynamic_form_fields['txtEmail']['field_name'];?>"><?php echo $dsv_dynamic_form_fields['txtEmail']['field_text'];?></label>
                                        <input type="text" class="txtbox" placeholder="<?php echo $dsv_dynamic_form_fields['txtEmail']['field_text'];?>" id="<?php echo $dsv_dynamic_form_fields['txtEmail']['field_name'];?>" name="<?php echo $dsv_dynamic_form_fields['txtEmail']['field_name'];?>" required />
                                    </div>
                                    <div class="formRow chkbox">
                                        <input type="checkbox" class="cbox" id="<?php echo $dsv_dynamic_form_fields['cb1']['field_name'];?>" name="<?php echo $dsv_dynamic_form_fields['cb1']['field_name'];?>" />
                                        <label class="cbLabel" for="<?php echo $dsv_dynamic_form_fields['cb1']['field_name'];?>"><?php echo $dsv_dynamic_form_fields['cb1']['field_text'];?></label>
                                    </div>
                                    <div class="formRow chkbox">
                                        <input type="checkbox" class="cbox" id="<?php echo $dsv_dynamic_form_fields['cb2']['field_name'];?>" name="<?php echo $dsv_dynamic_form_fields['cb2']['field_name'];?>" required/>
                                        <label class="cbLabel" for="<?php echo $dsv_dynamic_form_fields['cb2']['field_name'];?>"><?php echo $dsv_dynamic_form_fields['txtTC']['long_text'];?></label>
                                    </div>
                                    <div class="formRow chkbox">
                                        <input type="checkbox" class="cbox" id="<?php echo $dsv_dynamic_form_fields['cb3']['field_name'];?>" name="<?php echo $dsv_dynamic_form_fields['cb3']['field_name'];?>" required/>
                                        <label class="cbLabel" for="<?php echo $dsv_dynamic_form_fields['cb3']['field_name'];?>"><?php echo $dsv_dynamic_form_fields['txtPHOTOTC']['long_text'];?></label>
                                    </div>
                                </div>
                            </div>

                        </div>
					
                        <div class="col form-wrapper dark">
							<!-- Tell Us About It -->
						    <div class="form-step form-tell-us-about">
							    <div class="formRow">
								    <label for="txtName" class="txtInLabel"><?php echo $image_upload_details['text_two'];?> <span class="grey">(<?php echo TRANSLATION_USER_CLICK_TO_EDIT;?>)</span></label>
								    <input type="text" class="txtbox" maxlength="15" id="txtName" name="txtName"  />
							    </div>
							    <i class="icon icon-text icon--heart"><?php echo $image_upload_details['text_six'];?></i>
							    <div class="formRow">
								    <label for="txtWhatYouLove" class="txtInLabel"><?php echo $image_upload_details['text_three'];?> <span class="grey">(<?php echo TRANSLATION_USER_CLICK_TO_EDIT;?>)</span></label>
								    <input type="text" class="txtbox" maxlength="35" id="txtWhatYouLove" name="txtWhatYouLove" required />
								    <p class="extra-text"><span id="remainingChars">20</span> <?php echo TRANSLATION_USER_CHARACTERS_REMAINING?></p>
							    </div>
								
							    <div class="formRow">
								    <select class="select styled" id="ddFileUnder" name="ddFileUnder" required>
									    <option value=""><?php echo TRANSLATION_USER_CHOOSE_CATEGORY;?></option>
                                        <?php 
											foreach ($image_upload_details['mechanic_form']['filters'] as $id => $item){
											echo '<option value="' . $id . '">' . $item . '</option>'; 
										};?>
								    </select>
							    </div> 
						    </div>
                        </div>
                        
                        <div class="btn-row center-text">
                            <hr class="hr--faded bottom" />
                            <a href="JavaScript:void(0);" id="btn-form-continue" class="redBtn padded--med"><?php echo TRANSLATION_USER_IMAGE_CONTINUE;?></a>
                            <a href="JavaScript:void(0);" id="btn-form-back" class="button grey-button"><span><i class="icon white-chevron"></i><?php echo TRANSLATION_USER_IMAGE_BACK;?></span></a>
                        </div>
               
                    </form>
					
				</section>
				<!-- Competition Canvas -->
				
            </div>
		
        
        <script src="<?php echo $bref;?>desktop/scripts/ihearthome/mechanic/plugins.js"></script>
        <script src="<?php echo $bref;?>desktop/scripts/ihearthome/mechanic/vendor/jquery.infieldlabel.min.js"></script>
		<script type="text/javascript">
			$(function () {
				$(".txtInLabel").inFieldLabels({ fadeOpacity: 0.2 });
			});

			(function ($) {
				$.fn.extend({
					limiter: function (limit, elem) {
						$(this).on("keyup focus", function () {
							setCount(this, elem);
						});
						function setCount(src, elem) {
							var chars = src.value.length;
							if (chars > limit) {
								src.value = src.value.substr(0, limit);
								chars = limit;
							}
							elem.html(limit - chars);
						}
						setCount($(this)[0], elem);
					}
				});
			})(jQuery);

			var elem = $("#remainingChars");
			$("#txtName").limiter(15, elem);
			$("#txtWhatYouLove").limiter(35, elem);
		</script>
        <script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/custom-form-elements.js"></script>
        <script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/vendor/jquery.validate.min.js"></script>
        <?php /*<script src="<?php echo $SSL_bref;?>desktop/scripts/ihearthome/mechanic/validation.js"></script>*/?>
        <script type="text/javascript">
                             $(document).ready(function () {

    var form = $("#rhForm");

    if (form.length) {
	
		$.validator.addMethod("check_date_of_birth", function(value, element) {
			var day = $("#txtDobDay").val();
			var month = $("#txtDobMonth").val();
			var year = $("#txtDobYear").val();
			var age =  18;

			var mydate = new Date();
			mydate.setFullYear(year, month-1, day);
			var currdate = new Date();
			currdate.setFullYear(currdate.getFullYear() - age);
			return (currdate - mydate < 0 ? false : true);
		});

        var d = new Date();
        var yearNum = d.getFullYear();
        if (isNaN(yearNum)) yearNum = 2014;


        $(form).validate({
            debug: true
        });

        $("#txtName").rules("add", {
           // minlength: 2,
            messages: {
                required: "Please enter a name"
            }
        });
        $("#txtWhatYouLove").rules("add", {
            //minlength: 2,
            messages: {
                required: "<?php echo $dsv_dynamic_form_fields['txtDobDay']['required_error'];?>"
            }
        });
        $("#ddFileUnder").rules("add", {
            messages: {
                required: "<?php echo $dsv_dynamic_form_fields['txtDobDay']['required_error'];?>"
            }
        });
        //comp form fields
        $("#txtFirstName").rules("add", {
            minlength: 2,
            messages: {
                required: "<?php echo $dsv_dynamic_form_fields['txtFirstName']['required_error'];?>"
            }
        });
        $("#txtLastName").rules("add", {
            minlength: 2,
            messages: {
                required: "<?php echo $dsv_dynamic_form_fields['txtLastName']['required_error'];?>"
            }
        });
        // $("#txtWhatYouLove").rules("add", {
            // minlength: 2,
            // messages: {
                // required: "Please tell us what you love"
            // }
        // });
        $("#txtDobDay").rules("add", {
            digits: true,
            range: [1, 31],
            messages: {
                digits: "<?php echo $dsv_dynamic_form_fields['txtDobMonth']['required_error'];?>",
                range: "<?php echo $dsv_dynamic_form_fields['txtDobYear']['required_error'];?>",
                required: "<?php echo $dsv_dynamic_form_fields['txtDobDay']['required_error'];?>"
            }
        });
        $("#txtDobMonth").rules("add", {
            digits: true,
            range: [1, 12],
            messages: {
                digits: "<?php echo $dsv_dynamic_form_fields['txtDobMonth']['required_error'];?>",
                range: "<?php echo $dsv_dynamic_form_fields['txtDobYear']['required_error'];?>",
                required: "<?php echo $dsv_dynamic_form_fields['txtDobDay']['required_error'];?>"
            }
        });
        $("#txtDobYear").rules("add", {
            digits: true,
            range: [1900, yearNum],
            minlength: 4,
			check_date_of_birth: true,
            messages: {
                digits: "<?php echo $dsv_dynamic_form_fields['txtDobMonth']['required_error'];?>",
                range: "<?php echo $dsv_dynamic_form_fields['txtDobYear']['required_error'];?>",
                required: "<?php echo $dsv_dynamic_form_fields['txtDobDay']['required_error'];?>",
				check_date_of_birth: "<?php echo $dsv_dynamic_form_fields['txtDOB']['required_error'];?>"
            }
        });
        $("#txtEmail").rules("add", {
            email: true,
            messages: {
                required: "<?php echo $dsv_dynamic_form_fields['txtEmail']['required_error'];?>",
                email: "<?php echo $dsv_dynamic_form_fields['txtEmail']['min_error'];?>"
            }
        });
        $("#ddCountry").rules("add", {
            messages: {
                required: "<?php echo $dsv_dynamic_form_fields['ddCountry']['required_error'];?>"
            }
        });
        $("#cb2").rules("add", {
            messages: {
                required: "<?php echo $dsv_dynamic_form_fields['cb2']['required_error'];?>"
            }
        });
        $("#cb3").rules("add", {
            messages: {
                required: "<?php echo $dsv_dynamic_form_fields['cb3']['required_error'];?>"
            }
        });
  }

});

                             </script>
        
<?php
}
?>       
<?php 
//echo dsf_print_array ($user_image_details);
 //echo dsf_print_array ($image_upload_details);
 
?>