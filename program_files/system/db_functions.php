<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.

define('DS_DB_SERVER', 'localhost');		// in most cases should always be localhost. Change only if localhost does not work.
define('DS_DB_MASTER', 'ds_master');
define('DS_DB_USERNAME', 'ds_master_user'); 	// the username to connect to the database.
define('DS_DB_PASSWORD', 'Pw002f!945');			// the password to connect to the database.
define('DS_DB_COLLATION', 'utf8');		


// open connection
function dsf_db_connect($server = DS_DB_SERVER, $username = DS_DB_USERNAME, $password = DS_DB_PASSWORD, $database = DS_DB_MASTER, $link = 'db_link') {
  global $$link;


    $$link = mysql_connect($server, $username, $password);

   	if ($$link) {
		mysql_select_db($database);
		
		if (defined('DS_DB_COLLATION')){
			if (DS_DB_COLLATION == 'utf8'){
		
					if (function_exists('mysql_set_charset')){
						 mysql_set_charset('utf8',$$link);
					}
			}else{
					if (function_exists('mysql_set_charset')){
						 mysql_set_charset('latin1',$$link);
					}
			}
		}
			
	}

    return $$link;
  }



// close connection
function dsf_db_close($link = 'db_link') {
  global $$link;

  return mysql_close($$link);
}



// db error definition
  function dsf_db_error($query, $errno, $error) { 
      
      die();
//		if (DS_ERROR_SHOW == 'true'){	
//    		die('<font color="#FF0000"><strong>' . $errno . ' - ' . $error . '</strong><br /></font>' . $query);
//  		}else{
//    		die(' ');
//		}
  }




// standard query routine

  function dsf_db_query($query, $link = 'db_link') {
    global $$link;

    $result = mysql_query($query, $$link) or dsf_db_error($query, mysql_errno(), mysql_error());

    return $result;
  }



// alias db query used on some older content files.

	function dsf_query($query) {
		return dsf_db_query($query);
	}
	
	


// standard save array into database routine

  function dsf_db_perform($table, $data, $action = 'insert', $parameters = '', $link = 'db_link') {
    reset($data);
    if ($action == 'insert') {
      $query = 'insert into ' . $table . ' (';
      while (list($columns, ) = each($data)) {
        $query .= $columns . ', ';
      }
      $query = substr($query, 0, -2) . ') values (';
      reset($data);
      while (list(, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= 'now(), ';
            break;
          case 'null':
            $query .= 'null, ';
            break;
          default:
            $query .= '\'' . dsf_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ')';
    } elseif ($action == 'update') {
      $query = 'update ' . $table . ' set ';
      while (list($columns, $value) = each($data)) {
        switch ((string)$value) {
          case 'now()':
            $query .= $columns . ' = now(), ';
            break;
          case 'null':
            $query .= $columns .= ' = null, ';
            break;
          default:
            $query .= $columns . ' = \'' . dsf_db_input($value) . '\', ';
            break;
        }
      }
      $query = substr($query, 0, -2) . ' where ' . $parameters;
    }

    return dsf_db_query($query, $link);
  }


// fetch array routine
  function dsf_db_fetch_array($db_query) {
    return mysql_fetch_array($db_query, MYSQL_ASSOC);
  }


// alias array routine used on some older content files
  function dsf_array($db_query) {
  		return dsf_db_fetch_array($db_query);
  }

// alias num rows routine used on some older content files
  function dsf_rows($db_query) {
  		return mysql_num_rows($db_query);
  }


// find number of rows routine
  function dsf_db_num_rows($db_query) {
    return mysql_num_rows($db_query);
  }

// get the added primary key for last item added
  function dsf_db_insert_id() {
    return mysql_insert_id();
  }

// output special characters.

  function dsf_db_output($string) {
    return htmlspecialchars($string);
  }

// add slashes to data to prevent sql errors with quotes
  function dsf_db_input($string) {
    return addslashes($string);
  }

// the oposite to adding slashes is to remove any before recalling the data
  function dsf_db_prepare_input($string) {
    if (is_string($string)) {
      return trim(stripslashes($string));
    } elseif (is_array($string)) {
      reset($string);
      while (list($key, $value) = each($string)) {
        $string[$key] = dsf_db_prepare_input($value);
      }
      return $string;
    } else {
      return $string;
    }
  }
  
  
  
  

function dsf_select_database($database){
	
	
	return mysql_select_db($database);	

}



////
// Return a random row from a database query
  function dsf_random_select($query, $rows=1) {
    $random_product = '';
    $random_query = dsf_db_query($query);
    $num_rows = dsf_db_num_rows($random_query);
    
	if ($num_rows > 0) {
		// check for more than one row requested
			if ($rows >1){
				$return_array = array();
				if ($num_rows < $rows){
					if ($num_rows > 1){
							$rows = $num_rows;
					}else{
						$rows = 1;
					}
				}
				  
				  // start a counter here to only return the number of rows (or less as requested)
				  $row_limiter = $rows;
				  $row_current = 0;
				  
						  $random_row = dsf_rand(0, ($num_rows - $rows));
						  dsf_db_data_seek($random_query, $random_row);
						  while ($random_product = dsf_db_fetch_array($random_query)){
							$row_current ++;
							if ($row_current <= $row_limiter){
								$return_array[] = $random_product;
						   	}
						   }
				   
				  $random_product = $return_array;
				  
			}else{
			// standard routine
			  $random_row = dsf_rand(0, ($num_rows - 1));
			  dsf_db_data_seek($random_query, $random_row);
			  $random_product = dsf_db_fetch_array($random_query);
			}
    }

    return $random_product;
  }


// ###

  function dsf_db_data_seek($db_query, $row_number) {
    return mysql_data_seek($db_query, $row_number);
  }


// ###

// take an array of fields and return sql text from both shop and language prefixing the fields from the shop as ov_
function dsf_sql_override_select($dsv_sql_fields_required='', $shop_prefix='s',$language_prefix='l'){
	
$return_text = '';

if(strlen($shop_prefix)> 0 && strpos($shop_prefix,'.',0) == 0){
	$shop_prefix .= '.';
}

if(strlen($language_prefix)> 0 && strpos($language_prefix,'.',0) == 0){
	$language_prefix .= '.';
}

		if (is_array($dsv_sql_fields_required)){
		
			foreach($dsv_sql_fields_required as $value){
			
				if (strlen($return_text) > 1){
					$return_text .= ',';
				
				}
				
				$return_text .= $shop_prefix . $value .' as ov_' . $value . ',' . $language_prefix . $value;
				
			}
		}

return $return_text;	
}



// ###
// take results from a sql query where we have queried both shop and language (using ov_ prefix for shop) and return an array of fields
// having taken info consideration if any values were found in the ov_ parameter.

function dsf_sql_override_values($fields, $results){	
$return_array = array();

	if (is_array($fields) && is_array($results)	){
		foreach($fields as $value){
				if (strlen($value) > 0){
					$override_field = 'ov_' . $value;
					
					if (isset($results[$override_field]) && isset($results[$value])){
						// we have fields so we need to check which ones to send back,  we do this by initially checking lengths of strings
						// but then override the values back to the language version if the value is a 0 (most integars will be 0 by default).
						
						$result_field = (strlen($results[$override_field]) > 0 ? $results[$override_field] : $results[$value]);
						
						// override if 0
						if ((int)$results[$override_field] == 0 && (int)$results[$value] <> 0){
							$result_field = $results[$value];
						}
						
						$return_array[$value] = $result_field;
					}
					
				}
		}
	}

return $return_array;
}


// ###
function dsf_show_table_fields_as_text($database_and_table=''){
	
$fields = '';

	$query = dsf_db_query("show columns from " . $database_and_table);

			while ($columns_found = dsf_db_fetch_array($query)){
				if (strlen($fields)> 1){
					$fields.=', ';
				}
				$fields.= "'" . trim($columns_found['Field']) . "'";
			}

	return $fields;

}

?>