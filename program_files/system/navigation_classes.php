<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.



class navigationItem {
    var $path, $snapshot;

    function navigationItem() {
      $this->reset();
    }

    function reset() {
      $this->path = array();
      $this->snapshot = array();
    }

    function add_current_page() {
      global $dsv_current_page_url, $PHP_SELF, $request_type;


		if (isset($dsv_current_page_url) && strlen($dsv_current_page_url) > 0){
			$dsv_r_page = $dsv_current_page_url;
		}else{
			$dsv_r_page = basename($PHP_SELF);
		}
		

      $set = 'true';
      for ($i=0, $n=sizeof($this->path); $i<$n; $i++) {
        if ( $this->path[$i]['page'] == $dsv_r_page ) {
            array_splice($this->path, ($i));
            $set = 'true';
            break;
        }
      }

      if ($set == 'true') {
        $this->path[] = array('page' => $dsv_r_page,
                              'mode' => $request_type,
                              'get' => $_GET,
                              'post' => $_POST);
      }
    }

    function remove_current_page() {
      global $PHP_SELF, $dsv_current_page_url ;


		if (isset($dsv_current_page_url) && strlen($dsv_current_page_url) > 0){
			$dsv_r_page = $dsv_current_page_url;
		}else{
			$dsv_r_page = basename($PHP_SELF);
		}


      $last_entry_position = sizeof($this->path) - 1;
      if ($this->path[$last_entry_position]['page'] == $dsv_r_page) {
        unset($this->path[$last_entry_position]);
      }
    }

    function set_snapshot($page = '') {
      global $PHP_SELF, $dsv_current_page_url, $request_type;


		if (isset($dsv_current_page_url) && strlen($dsv_current_page_url) > 0){
			$dsv_r_page = $dsv_current_page_url;
		}else{
			$dsv_r_page = basename($PHP_SELF);
		}



      if (is_array($page)) {
        $this->snapshot = array('page' => $page['page'],
                                'mode' => $page['mode'],
                                'get' => $page['get'],
                                'post' => $page['post']);
      } else {
        $this->snapshot = array('page' => $dsv_r_page,
                                'mode' => $request_type,
                                'get' => $_GET,
                                'post' => $_POST);
      }
	  
	  
    }

    function clear_snapshot() {
      $this->snapshot = array();
    }

    function set_path_as_snapshot($history = 0) {
      $pos = (sizeof($this->path)-1-$history);
      $this->snapshot = array('page' => $this->path[$pos]['page'],
                              'mode' => $this->path[$pos]['mode'],
                              'get' => $this->path[$pos]['get'],
                              'post' => $this->path[$pos]['post']);
    }



    function debug() {
      for ($i=0, $n=sizeof($this->path); $i<$n; $i++) {
        echo $this->path[$i]['page'] . '?';
        while (list($key, $value) = each($this->path[$i]['get'])) {
          echo $key . '=' . $value . '&';
        }
        if (sizeof($this->path[$i]['post']) > 0) {
          echo '<br />';
          while (list($key, $value) = each($this->path[$i]['post'])) {
            echo '&nbsp;&nbsp;<strong>' . $key . '=' . $value . '</strong><br />';
          }
        }
        echo '<br />';
      }

      if (sizeof($this->snapshot) > 0) {
        echo '<br /><br />';

        echo $this->snapshot['mode'] . ' ' . $this->snapshot['page'] . '?' . dsf_array_to_string($this->snapshot['get'], array(dsf_session_name())) . '<br />';
      }
    }

    function unserialize($broken) {
      for(reset($broken);$kv=each($broken);) {
        $key=$kv['key'];
        if (gettype($this->$key)!="user function")
        $this->$key=$kv['value'];
      }
    }
  }
?>
