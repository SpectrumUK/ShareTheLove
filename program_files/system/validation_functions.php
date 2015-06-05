<?php

// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.


// previous validation on the old system was far too dificult and with the release of so many different domain extensions
// is impossible to keep up to date.   This method is much simpler.


function dsf_validate_email($email) {

$valid_address = true;

if (strlen($email) > 4){

	// check for @ inside address and that there is at least 3 characters  and 1 . after the symbol
		$email_pos = strpos($email, '@', 0);
		
		if ($email_pos > 0){
		
			$email_strip = explode('@', $email);
			if (sizeof($email_strip) == 2){
			
				$email_pos = strpos($email_strip[1], '.' ,0);
				
				if ($email_pos > 0){
				
					if (($email_pos + 3) <= strlen($email_strip[1])){
						// we are fine
					}else{
						$valid_address = false;
					}
				
				}else{
					$valid_address = false;
			
				}
			}else{
				$valid_address = false;
			}
		
		
		}else{
			$valid_address = false;
		}



	// check for other invalid items in email address
	
		$email_pos = strpos($email, ' ', 0);
		
		if ($email_pos > 0){
			$valid_address = false;
		}

	// check for comma in email address
	
		$email_pos = strpos($email, ',', 0);
		
		if ($email_pos > 0){
			$valid_address = false;
		}

	// check for greater than in email address
	
		$email_pos = strpos($email, '>', 0);
		
		if ($email_pos > 0){
			$valid_address = false;
		}


	// any additional checks can be added here.
	


}else{
	$valid_address = false;
}


return $valid_address;
}


?>