<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



// allocate how long to keep a session for based on seconds

   //   $SESS_LIFE = 1800; // 30 minutes
        $SESS_LIFE = 3600; // 1 hour
	//  $SESS_LIFE = 86400; // 1 day
	//  $SESS_LIFE = 604800; // 1 week



    function _sess_open($save_path, $session_name) {
      return true;
    }

    function _sess_close() {
      return true;
    }

    function _sess_read($key) {
      $value_query = dsf_db_query("select value from " . DS_DB_SHOP . ".sessions where sesskey = '" . dsf_db_input($key) . "' and expiry > '" . time() . "'");
      $value = dsf_db_fetch_array($value_query);

      if (isset($value['value'])) {
        return $value['value'];
      }else{
      	return false;
	  }
    }

    function _sess_write($key, $val) {
      global $SESS_LIFE;

      $expiry = time() + $SESS_LIFE;
      $value = $val;

      $check_query = dsf_db_query("select value from " . DS_DB_SHOP . ".sessions where sesskey = '" . dsf_db_input($key) . "'");

      
	  if (dsf_db_num_rows($check_query) > 0) {
		 	$upd = dsf_db_query("update " . DS_DB_SHOP . ".sessions set expiry = '" . dsf_db_input($expiry) . "', value = '" . dsf_db_input($value) . "' where sesskey = '" . dsf_db_input($key) . "'");
      } else {
        	$upd = dsf_db_query("insert into " . DS_DB_SHOP . ".sessions values ('" . dsf_db_input($key) . "', '" . dsf_db_input($expiry) . "', '" . dsf_db_input($value) . "')");
      }
	  
	  return $upd;
    }



    function _sess_destroy($key) {
      return dsf_db_query("delete from " . DS_DB_SHOP . ".sessions where sesskey = '" . dsf_db_input($key) . "'");
    }



    function _sess_gc($maxlifetime) {
      $upd = dsf_db_query("delete from " . DS_DB_SHOP . ".sessions where expiry < '" . time() . "'");

      return true;
    }


    session_set_save_handler('_sess_open', '_sess_close', '_sess_read', '_sess_write', '_sess_destroy', '_sess_gc');



// END SETTING SESSIONS FUNCTIONS AS HANDLES TO USE THE DATABASE TO STORE SESSION INFORMATION
// ##########################################################################################


// Now create the standard functions that we use for sessions.



  function dsf_session_start() {
    return session_start();
  }

  function dsf_session_register($variable) {
    global $session_started;

    if ($session_started == true) { 
        $_SESSION[$variable] =& $GLOBALS[$variable]; 
        return true; // just for the sake of consistency 
    } 

    return false; 
  }

  function dsf_session_is_registered($variable) {
      if (isset($_SESSION)){
	  	return array_key_exists($variable, $_SESSION);
      } 

  }

  function dsf_session_unregister($variable) {
		if (isset($_SESSION[$variable])){
			unset($_SESSION[$variable]);
		}
		return true;
  }

  function dsf_session_id($sessid = '') {
    if (!empty($sessid)) {
      return session_id($sessid);
    } else {
      return session_id();
    }
  }

  function dsf_session_name($name = '') {
    if (!empty($name)) {
      return session_name($name);
    } else {
      return session_name();
    }
  }

  function dsf_session_close() {
      return session_write_close();
  }

  function dsf_session_destroy() {
    return session_destroy();
  }

  function dsf_session_save_path($path = '') {
    if (!empty($path)) {
      return session_save_path($path);
    } else {
      return session_save_path();
    }
  }

  function dsf_session_recreate() {
      $session_backup = $_SESSION;

      unset($_COOKIE[dsf_session_name()]);

      dsf_session_destroy();

        session_set_save_handler('_sess_open', '_sess_close', '_sess_read', '_sess_write', '_sess_destroy', '_sess_gc');

      dsf_session_start();

      $_SESSION = $session_backup;
      unset($session_backup);
  }
 
 // dsf_resave_session
 // if doing a dsf_redirect function then any session variables that have been amended on the page
 // will not be saved unless they are done so manually with this function.
  
 function dsf_resave_session($variable=''){
 
 	if (!$variable){
		return false;
	}
	if (dsf_session_is_registered($variable)){
		dsf_session_unregister($variable);
	}
	dsf_session_register($variable);
}

?>