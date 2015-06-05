<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



// This funstion validates a plain text password with an
// encrpyted password
  function dsf_validate_password($plain, $encrypted) {
  
    if (dsf_not_null($plain) && dsf_not_null($encrypted)) {
      $stack = explode(':', $encrypted);

     	 if (sizeof($stack) != 2) return false;

			  if (md5($stack[1] . $plain) == $stack[0]) {
				return true;
			  }
    	}
  
  
    return false;
  }

////
// This function makes a new password from a plaintext password. 
  function dsf_encrypt_password($plain) {
    $password = '';

    for ($i=0; $i<10; $i++) {
      $password .= dsf_rand();
    }

    $salt = substr(md5($password), 0, 2);

    $password = md5($salt . $plain) . ':' . $salt;

    return $password;
  }
  
  
  function dsf_rnd_iv($iv_len)
{
   $iv = '';
   while ($iv_len-- > 0) {
       $iv .= chr(mt_rand() & 0xff);
   }
   return $iv;
}



function dsf_md5_encrypt($plain_text, $password, $iv_len = 16)
{
   $plain_text .= "\x13";
   $n = strlen($plain_text);
   if ($n % 16) $plain_text .= str_repeat("\0", 16 - ($n % 16));
   $i = 0;
   $enc_text = dsf_rnd_iv($iv_len);
   $iv = substr($password ^ $enc_text, 0, 512);
   while ($i < $n) {
       $block = substr($plain_text, $i, 16) ^ pack('H*', md5($iv));
       $enc_text .= $block;
       $iv = substr($block . $iv, 0, 512) ^ $password;
       $i += 16;
   }
   
   // there is a problem with a + value when using apache as it is automatically translated as a space which is incorrect.
   
   $enc_text = base64_encode($enc_text);
   
   $enc_text = str_replace("+" , '-5QH0-n-' , $enc_text);
   
   
   return $enc_text;
}



function dsf_md5_decrypt($enc_text, $password, $iv_len = 16)
{

   // there is a problem with a + value when using apache as it is automatically translated as a space which is incorrect.
	   $enc_text = str_replace('-5QH0-n-' , "+" , $enc_text);


   $enc_text = base64_decode($enc_text);


   $n = strlen($enc_text);
   $i = $iv_len;
   $plain_text = '';
   $iv = substr($password ^ substr($enc_text, 0, $iv_len), 0, 512);
   while ($i < $n) {
       $block = substr($enc_text, $i, 16);
       $plain_text .= $block ^ pack('H*', md5($iv));
       $iv = substr($block . $iv, 0, 512) ^ $password;
       $i += 16;
   }
   return preg_replace('/\\x13\\x00*$/', '', $plain_text);
}

?>
