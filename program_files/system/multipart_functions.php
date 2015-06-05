<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



// function changed on 2013-08-29 to correct mime issue where on iphone a message with attachement was not showing any text
// on the preview although it was fine when clicking into the message.
function dsf_send_email($dsv_to_name, $dsv_to, $dsv_subject='', $dsv_message='', $dsv_from_name, $dsv_from,  $dsv_html = '', $file=''){


if (defined('DEFAULT_EMAIL_HEADER_CHARSET') && DEFAULT_EMAIL_HEADER_CHARSET == 'uft-8'){
	
	          $to = (($dsv_to_name != '') ? '"' . dsf_check_utf_string($dsv_to_name) . '" <' . $dsv_to . '>' : $dsv_to);
			  $from = (($dsv_from_name != '') ? '"' . dsf_check_utf_string($dsv_from_name) . '" <' . EMAIL_FROM . '>' : EMAIL_FROM);
			  $reply_to = (($dsv_from_name != '') ? '"' . dsf_check_utf_string($dsv_from_name) . '" <' . $dsv_from . '>' : $dsv_from);
			  $dsv_subject = dsf_check_utf_string($dsv_subject);

}else{
	
	// standard routine
	

	          $to = (($dsv_to_name != '') ? '"' . utf8_decode($dsv_to_name) . '" <' . $dsv_to . '>' : $dsv_to);
			  $from = (($dsv_from_name != '') ? '"' . utf8_decode($dsv_from_name) . '" <' . EMAIL_FROM . '>' : EMAIL_FROM);
			  $reply_to = (($dsv_from_name != '') ? '"' . utf8_decode($dsv_from_name) . '" <' . $dsv_from . '>' : $dsv_from);

}

			
				// check to see if we have plain text message.
				if (isset($dsv_message) && strlen($dsv_message) > 1){
					// we have valid text.
					$dsv_valid_plain_text = 'true';
				
					// strip any html from the plain message
					$dsv_message = dsf_strip_html_items($dsv_message);

				}else{
					$dsv_valid_plain_text = 'false';
				}
				
				
				// check to see if we have html text message.
				if (isset($dsv_html) && strlen($dsv_html) > 1){
					// we have valid text.
					$dsv_valid_html_text = 'true';
				}else{
					$dsv_valid_html_text = 'false';
				}



// check html text.

		if ($dsv_valid_plain_text == 'true' && $dsv_valid_html_text == 'false'){
			
			// we have no html text therefore create some from the plain text.
		
				$dsv_html = nl2br($dsv_message);
		}
		
		
		
// check plain text

		if ($dsv_valid_plain_text == 'false' && $dsv_valid_html_text == 'true'){
			
			// we have no plain text therefore attempt to create some from the html text.
			
				$dsv_message = dsf_strip_html_items($dsv_html);
			
		}
		

		
		
		// add html headers and footers  (actual html items)
		$htmlbody = dsf_get_html_header() . $dsv_html . dsf_get_html_footer();
		
		
	
	// set a variable to decide if we are adding an attachement - only PDF files are allowed in this release.
	
	$dsv_att_add = 'false';
	
		$required_file = DS_UNIT_ROOT . DS_XML . 'pdf/' . $file;
			
		
		if (isset($file) && strlen($file)> 1){
			$dsv_file_exists = file_exists($required_file);
		
				// does the file exist?
						if ($dsv_file_exists == 1){
							$dsv_att_add = 'true';
						}
		}
							
		// we know know if we have an attachment of not.  we use that to create the email.
		
		
				// with attachment
									

			if ($dsv_att_add == 'true'){


		
		$attachment = chunk_split(base64_encode(file_get_contents($required_file)),76,"\n");
		
		
		//Let's start our headers
		$headers = 'From: ' . $from . "\n";

// function changed 2014-01-10 to include Reply-To

		$headers .= 'Reply-To: ' . $reply_to . "\n";
// end amendment 2014-01-10.

		$headers .= "X-Mailer: SHOP\n";
		$headers .= "X-Priority: 3\n"; //1 = Urgent, 3 = Normal
		$headers .= "MIME-Version: 1.0\n";
		$headers .= "Content-Type: multipart/mixed;\n boundary=\"----=MIME_BOUNDARY_main_message\"\n"; 
		$headers .= "Content-Transfer-Encoding: 7bit\n\n";
		$headers .= "This is a multi-part message in MIME format.\r\n";
	
		$body = "------=MIME_BOUNDARY_main_message\n"; 
		$body .= "Content-Type: multipart/alternative;\n boundary=\"----=MIME_BOUNDARY_message_parts\"\n"; 
		$body .= "\n"; 
		$body .= "This is a multi-part message in mime format.\r\n";
		
		################## plain ######################
		$body .= "------=MIME_BOUNDARY_message_parts\n";
		$body .= 'Content-Type: text/plain; charset="' . DEFAULT_CHARSET .'"' . "\n"; 
		$body .= "Content-Transfer-Encoding: 7bit\n\n";
		$body .= "\n"; 
		/* Add our message, in this case it's plain text.  You could also add HTML by changing the Content-Type to text/html */
		$body .= strip_tags($dsv_message) ."\n";
		$body .= "\n"; 
	###################################################	
		
		
	################################# html ####################################	
		$body .= "------=MIME_BOUNDARY_message_parts\n";
		$body .= 'Content-Type: text/html; charset="' . DEFAULT_CHARSET .'"' . "\n"; 
		$body .= "Content-Transfer-Encoding: 7bit\n\n";
		$body .= "\n"; 
		/* Add our message, in this case it's plain text.  You could also add HTML by changing the Content-Type to text/html */
		$body .= $htmlbody."\n";
		$body .= "\n"; 
		$body .= "------=MIME_BOUNDARY_message_parts--\n"; 

		########################################################################
		
		
	################################# attachement ####################################	
		$body .= "\n"; 
		$body .= "------=MIME_BOUNDARY_main_message\n"; 
		$body .= "Content-Type: application/pdf;\n\tname=\"" . $file . "\"\n";
		$body .= "Content-Transfer-Encoding: base64\n";
		$body .= "Content-Disposition: attachment;\n\tfilename=\"" . $file . "\"\n\n";
		$body .= $attachment; //The base64 encoded message
		$body .= "\n"; 
		$body .= "------=MIME_BOUNDARY_main_message--\n"; 

		########################################################################


			
				} else { // attachment not found.
					
				
						$mime_boundary = 'Multipart_Boundary_x'.md5(time()).'x';
					
						$headers  = "MIME-Version: 1.0\r\n";
						$headers .= 'From: ' . $from . "\r\n";
						$headers .= 'Reply-To: ' . $reply_to . "\r\n";
						$headers .= "X-Sender-IP: " . $_SERVER['SERVER_ADDR'] . "\r\n";
						$headers .= 'Sent: '.date('n/d/Y g:i A')."\r\n";
						$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\r\n";
						$headers .= "Content-Transfer-Encoding: 7bit\r\n";
					
						$body	 = "This is a multi-part message in mime format.\n\n";
					
						
						# Add in plain text version
						$body	.= "--$mime_boundary\n";
						$body	.= "Content-Type: text/plain; charset=\"" . DEFAULT_CHARSET . "\"\n";
						$body	.= "Content-Transfer-Encoding: 7bit\n\n";
						$body	.= strip_tags($dsv_message);
						$body	.= "\n\n";
					
						# Add in HTML version
						$body	.= "--$mime_boundary\n";
						$body	.= "Content-Type: text/html; charset=\"" . DEFAULT_CHARSET . "\"\n";
						$body	.= "Content-Transfer-Encoding: 7bit\n\n";
						$body	.= $htmlbody;
						$body	.= "\n\n";
					
						# End email
						$body	.= "--$mime_boundary--\n"; # <-- Notice trailing --, required to close email body for mime's
					
					
					// WHY DO WE HAVE DIFFERENT HEADERS FOR THIS PART - go with what we know.
					

			} // attachement check
		
		//send the email
		
		// check for correct to values

		
// function changed 2014-01-10 to include Reply-To
			  $mail = mail($to, $dsv_subject, $body, $headers, '-f' . EMAIL_FROM);
// previoulsy
			//  $mail = mail($to, $dsv_subject, $body, $headers, '-f'.$dsv_from);
// end amendment 2014-01-10
	
	
	if ($mail){
		return 'true';
	} else {
		return 'false';
	}
		
}




// Function to get headers and footers out of the database for html creation

function dsf_get_html_header(){
	
	// for now we are just returning text, but could look at database in future.
	$string = '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">' . "\n";
	$string .= '<HTML><HEAD>' . "\n";
	$string .= '<META content="text/html; charset=' . DEFAULT_CHARSET . '" http-equiv=Content-Type>' . "\n";
	$string .= '<STYLE>@font-face {' . "\n";
	$string .= 	'font-family: Calibri;' . "\n";
	$string .= '}' . "\n";
	$string .= '@font-face {' . "\n";
	$string .= 	'font-family: Tahoma;' . "\n";
	$string .= '}' . "\n";
	$string .= '@font-face {' . "\n";
	$string .= 	'font-family: Century Gothic;' . "\n";
	$string .= '}' . "\n";
	$string .= 'DIV.main {' . "\n";
	$string .= '	MARGIN: 0cm 0cm 0pt; FONT-FAMILY: "Arial","Calibri","Times New Roman","serif"; FONT-SIZE: 10pt; FONT-WEIGHT: normal; TEXT-DECORATION: none; BACKGROUND-COLOR:#ffffff' . "\n";
	$string .= '}' . "\n";
	$string .= 'TABLE {' . "\n";
	$string .= '	MARGIN: 0cm 0cm 0pt; PADDING:0pt; BORDER: 1px solid #e4e4e4;' . "\n";
	$string .= '}' . "\n";
	$string .= 'TD {' . "\n";
	$string .= '	MARGIN: 0cm 0cm 0pt; PADDING:4px; BORDER: 1px solid #e4e4e4; FONT-FAMILY: "Arial","Calibri","Times New Roman","serif"; FONT-SIZE: 10pt; FONT-WEIGHT: normal; TEXT-DECORATION: none;' . "\n";
	$string .= '}' . "\n";
	$string .= '.shaded {' . "\n";
	$string .= '	MARGIN: 0cm 0cm 0pt; FONT-FAMILY: "Arial","Calibri","Times New Roman","serif"; FONT-SIZE: 10pt; FONT-WEIGHT: bold; TEXT-DECORATION: none; BACKGROUND-COLOR:#f4f4f4' . "\n";
	$string .= '}' . "\n";
	$string .= '</STYLE>' . "\n";
	$string .= '</HEAD>' . "\n";
	$string .='<BODY>' . "\n";	
	$string .='<DIV class=main>' . "\n";	


return $string;
}

function dsf_get_html_footer() {
	$string ='</DIV>' . "\n";	
	$string .='</BODY>' . "\n";	
	$string .='</HTML>' . "\n";	
	
return $string;
}




function dsf_strip_html_items($text){
	
	
	// special job to see if there are any styles in the html.  if there is then the
	// stripping of html will remove the <style> and </style> tags but leave all the content
	// inbetween which we don't want.
	
	$style_end_pos = strpos($text,'</style>',0);
	
	if ($style_end_pos > 0){
		$style_start_pos = strpos($text,'<style>',0);
	}else{
		
		// do again this time uppercase if we haven't already found it.
		$style_end_pos = strpos($text,'</STYLE>',0);
		if ($style_end_pos > 0){
			$style_start_pos = strpos($text,'<STYLE>',0);
		}
	}
	
	
	if ($style_end_pos > 0){
		
		// we have found items therefore we need to strip everything in between.
		
		if ($style_start_pos > 0){
			$before = substr($text,0,$style_start_pos);
		}else{
			$before = '';
		}
		
		$after = substr($text,($style_end_pos + 8));
		
		$text = $before . $after;
	}
	
	
	// now standard strip of html items putting manual linebreaks in where paragraphs or br exist.	
	
	
	$string = str_replace("</p>" , "</p>####" , $text);
	$string = str_replace("<br />" , "##" , $string);
	$string = strip_tags($string);
	$string = str_replace("##" , "\n" , $string);
			
	return $string;
}






function dsf_check_utf_string($string='') {
	
	if (strlen($string) > 0){
		
			// check if string has any non ASCII chars
			
			$string_check = mb_detect_encoding($string, 'ASCII', true);
			
			if ($string_check == true){
				// plain ASCII chars return it as it is.
				
				$new_string = $string;
				
			}else{
				
				// we have at least 1 non ASCII char therefore we encode it
				$new_string = '=?utf-8?B?'.base64_encode($string).'?=';
			}
	}else{
		$new_string = '';
	}
	
return $new_string;
	
}
// END FUNCTIONS
?>