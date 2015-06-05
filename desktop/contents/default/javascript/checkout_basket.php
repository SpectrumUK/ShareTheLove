<script language="javascript" type="text/javascript"><!--

function MM_validateForm() { //v4.0
  var cObj = MM_findObj('i_agreedterms');
  
  var retval = 'false';
  
  if(!cObj) {
	  retval = 'true';
  }
  
	if(cObj.checked == false)  {
	  retval = 'true';
	}

if (retval == 'true'){
   	    alert("<?php echo TRANSLATION_WORD_ERROR . '\n\n' . TRANSLATION_CHECKOUT_ERROR_TERMS;?>");
	return (false);
}else{
 	return (true);
}

}
--></script>