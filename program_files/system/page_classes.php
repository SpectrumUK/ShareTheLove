<?php
// Version: 		Spectrum Brands Duplicate Source code.
// Version number: 	1.0
// Version Date: 	28 November 2014
// Last Amendment: 	never.




class splitPageResults {
    var $sql_query, $number_of_rows, $current_page_number, $number_of_pages, $number_of_rows_per_page, $page_name;

    function splitPageResults($query, $max_rows, $count_key = '*', $page_holder = 'page', $max_override=0) {

      $this->sql_query = $query;
      $this->page_name = $page_holder;

      if (isset($_GET[$page_holder])) {
        $page = $_GET[$page_holder];
      } elseif (isset($_POST[$page_holder])) {
        $page = $_POST[$page_holder];
      } else {
        $page = '';
      }

      if (empty($page) || !is_numeric($page)) $page = 1;
      $this->current_page_number = $page;

      $this->number_of_rows_per_page = $max_rows;

      $pos_to = strlen($this->sql_query);
	  $pos_match = strpos($this->sql_query, ' match(', 0);
	  $pos_where = strpos($this->sql_query, ' where', 0);
	  
	  if ($pos_match > 0){
		  // we are doing matching which could therefore contain a from text item.  Matching will always contain a where command therefore we need to go backwards from the where command to find the from.
      		$rev_offset = $pos_where - $pos_to;  // will produce a negative value that we need.
			
			$pos_from = strrpos($this->sql_query, ' from', $rev_offset);
		  
	  }else{
		  
      		$pos_from = strpos($this->sql_query, ' from', 0);
	  }
	  
	  
      $pos_group_by = strrpos($this->sql_query, ' group by', $pos_from);
      if (($pos_group_by < $pos_to) && ($pos_group_by != false)) $pos_to = $pos_group_by;

      $pos_having = strrpos($this->sql_query, ' having', $pos_from);
      if (($pos_having < $pos_to) && ($pos_having != false)) $pos_to = $pos_having;

      $pos_order_by = strrpos($this->sql_query, ' order by', $pos_from);
      if (($pos_order_by < $pos_to) && ($pos_order_by != false)) $pos_to = $pos_order_by;

      if (strpos($this->sql_query, 'distinct') || strrpos($this->sql_query, 'group by')) {
        $count_string = 'distinct ' . dsf_db_input($count_key);
      } else {
        $count_string = dsf_db_input($count_key);
      }


	 if ((int)$pos_from <=0){
	 	$pos_from = 0;
	 }

      $count_query = dsf_db_query("select count(" . $count_string . ") as total " . substr($this->sql_query, $pos_from, ($pos_to - $pos_from)));
      $count = dsf_db_fetch_array($count_query);

     // OVERRIDE ITEMS LISTED
	  if (isset($max_override) && (int)$max_override > 0){
	  		if ((int)$max_override < (int)$count['total']){
	  			$this->number_of_rows = (int)$max_override;
			}else{
	  			$this->number_of_rows = $count['total'];
			}
	  }else{
	  		$this->number_of_rows = $count['total'];
	  }
	  
      $this->number_of_pages = ceil($this->number_of_rows / $this->number_of_rows_per_page);

      if ($this->current_page_number > $this->number_of_pages) {
        $this->current_page_number = $this->number_of_pages;
      }

      $offset = ($this->number_of_rows_per_page * ($this->current_page_number - 1));


	if ((int)$offset <=0){
		$offset = 0;
	}
	
      $this->sql_query .= " limit " . $offset . ", " . $this->number_of_rows_per_page;
	  
	  
    }



// display split-page-number-links
    function display_links($max_page_links, $parameters = '', $page_link ='', $category=0 , $range=0) {
      global $PHP_SELF, $request_type;


		if ((int)$category > 0) {

					  $display_links_string = '<div class="dsPageLIBox"><ul class="dsPageLI">';
				
					  $class = 'class="dsPageResults"';
				
					  if (dsf_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';
				
				// previous button - not displayed on first page
					
					// CODE TO DECIDE TEXT OR IMAGES FOR NEXT
					if (PAGE_BUTTONS_TYPE == 'image'){
							 if ($this->current_page_number > 1) {
								$display_links_string .= '<li><a href="' . dsf_category_url($category, $parameters . $this->page_name . '=' . ($this->current_page_number - 1),'',false, (isset($range) ? $range : '0')) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' ">' . dsf_button_image('button_prev_page.gif',PREVNEXT_TITLE_PREVIOUS_PAGE) . '</a></li>';
							  }else{
								$display_links_string .= '<li>' . dsf_button_image('button_prev_page_none.gif','No Previous Page') . '</li>';
							  }
					 }else{
							 if ($this->current_page_number > 1) $display_links_string .= '<li><a href="' . dsf_category_url($category, $parameters . $this->page_name . '=' . ($this->current_page_number - 1), false, (isset($range) ? $range : '0')) . '" class="dsPageResults" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' ">' . PREVNEXT_BUTTON_PREV . '</a></li>';
					}
				
				
				// check if number_of_pages > $max_page_links
					  $cur_window_num = intval($this->current_page_number / $max_page_links);
					  if ($this->current_page_number % $max_page_links) $cur_window_num++;
				
					  $max_window_num = intval($this->number_of_pages / $max_page_links);
					  if ($this->number_of_pages % $max_page_links) $max_window_num++;
				
				// previous window of pages
					  if ($cur_window_num > 1) $display_links_string .= '<li><a href="' . dsf_category_url($category, $parameters . $this->page_name . '=' . (($cur_window_num - 1) * $max_page_links),false, (isset($range) ? $range : '0')) . '" class="dsPageResults" title=" ' . sprintf(PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a></li>';
				
				// page nn button
					  for ($jump_to_page = 1 + (($cur_window_num - 1) * $max_page_links); ($jump_to_page <= ($cur_window_num * $max_page_links)) && ($jump_to_page <= $this->number_of_pages); $jump_to_page++) {
						if ($jump_to_page == $this->current_page_number) {
						  $display_links_string .= '<li><span class="dsPageCurrent">' . $jump_to_page . '</span></li>';
						} else {
						  $display_links_string .= '<li><a href="' . dsf_category_url($category, $parameters . $this->page_name . '=' . $jump_to_page,false, (isset($range) ? $range : '0')) . '" class="dsPageResults" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $jump_to_page . '</a></li>';
						}
					  }
				
				// next window of pages
					  if ($cur_window_num < $max_window_num) $display_links_string .= '<li><a href="' . dsf_category_url($category, $parameters . $this->page_name . '=' . (($cur_window_num) * $max_page_links + 1),false, (isset($range) ? $range : '0')) . '" class="dsPageResults" title=" ' . sprintf(PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a></li>';
				
				// next button
					// CODE TO DECIDE TEXT OR IMAGES FOR NEXT
					if (PAGE_BUTTONS_TYPE == 'image'){
					  if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)) {
						$display_links_string .= '<li><a href="' . dsf_category_url($category, $parameters . 'page=' . ($this->current_page_number + 1),false, (isset($range) ? $range : '0')) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . dsf_button_image('button_next_page.gif',PREVNEXT_TITLE_NEXT_PAGE) . '</a></li>';
					  }else{
						$display_links_string .= '<li>' . dsf_button_image('button_next_page_none.gif','No Further Pages'). '</li>';
					  }
					
					}else{
					  if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)) $display_links_string .= '<li><a href="' . dsf_category_url($category, $parameters . 'page=' . ($this->current_page_number + 1),false, (isset($range) ? $range : '0')) . '" class="dsPageResults" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . '</a></li>';
					}
				
				
					  $display_links_string .= '</ul></div>';
				
						$display_links_string = str_replace('?page=1&','?' , $display_links_string);
						$display_links_string = str_replace('&page=1&','&' , $display_links_string);
						$display_links_string = str_replace('?page=1"','"' , $display_links_string);
					
					
					
					
						
					
				
					  return $display_links_string;
	  
	  }else{
	  	// standard link
					if(!$page_link){
						$page_link = basename($PHP_SELF);
					}
					
					  $display_links_string = '<div class="dsPageLIBox"><ul class="dsPageLI">';
				
					  $class = 'class="dsPageResults"';
				
					  if (dsf_not_null($parameters) && (substr($parameters, -1) != '&')) $parameters .= '&';
				
				// previous button - not displayed on first page
					
					// CODE TO DECIDE TEXT OR IMAGES FOR NEXT
					if (PAGE_BUTTONS_TYPE == 'image'){
							 if ($this->current_page_number > 1) {
								$display_links_string .= '<li><a href="' . dsf_href_link($page_link, $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' ">' . dsf_button_image('button_prev_page.gif',PREVNEXT_TITLE_PREVIOUS_PAGE) . '</a></li>';
							  }else{
								$display_links_string .= '<li>' . dsf_button_image('button_prev_page_none.gif','No Previous Page') . '</li>';
							  }
					 }else{
							 if ($this->current_page_number > 1) $display_links_string .= '<li><a href="' . dsf_href_link($page_link, $parameters . $this->page_name . '=' . ($this->current_page_number - 1), $request_type) . '" class="dsPageResults" title=" ' . PREVNEXT_TITLE_PREVIOUS_PAGE . ' ">' . PREVNEXT_BUTTON_PREV . '</a></li>';
					}
				
				
				// check if number_of_pages > $max_page_links
					  $cur_window_num = intval($this->current_page_number / $max_page_links);
					  if ($this->current_page_number % $max_page_links) $cur_window_num++;
				
					  $max_window_num = intval($this->number_of_pages / $max_page_links);
					  if ($this->number_of_pages % $max_page_links) $max_window_num++;
				
				// previous window of pages
					  if ($cur_window_num > 1) $display_links_string .= '<li><a href="' . dsf_href_link($page_link, $parameters . $this->page_name . '=' . (($cur_window_num - 1) * $max_page_links), $request_type) . '" class="dsPageResults" title=" ' . sprintf(PREVNEXT_TITLE_PREV_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a></li>';
				
				// page nn button
					  for ($jump_to_page = 1 + (($cur_window_num - 1) * $max_page_links); ($jump_to_page <= ($cur_window_num * $max_page_links)) && ($jump_to_page <= $this->number_of_pages); $jump_to_page++) {
						if ($jump_to_page == $this->current_page_number) {
						  $display_links_string .= '<li><span class="dsPageCurrent">' . $jump_to_page . '</span></li>';
						} else {
						  $display_links_string .= '<li><a href="' . dsf_href_link($page_link, $parameters . $this->page_name . '=' . $jump_to_page, $request_type) . '" class="dsPageResults" title=" ' . sprintf(PREVNEXT_TITLE_PAGE_NO, $jump_to_page) . ' ">' . $jump_to_page . '</a></li>';
						}
					  }
				
				// next window of pages
					  if ($cur_window_num < $max_window_num) $display_links_string .= '<li><a href="' . dsf_href_link($page_link, $parameters . $this->page_name . '=' . (($cur_window_num) * $max_page_links + 1), $request_type) . '" class="dsPageResults" title=" ' . sprintf(PREVNEXT_TITLE_NEXT_SET_OF_NO_PAGE, $max_page_links) . ' ">...</a></li>';
				
				// next button
					// CODE TO DECIDE TEXT OR IMAGES FOR NEXT
					if (PAGE_BUTTONS_TYPE == 'image'){
					  if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)) {
						$display_links_string .= '<li><a href="' . dsf_href_link($page_link, $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . dsf_button_image('button_next_page.gif',PREVNEXT_TITLE_NEXT_PAGE) . '</a></li>';
					  }else{
						$display_links_string .= '<li>' . dsf_button_image('button_next_page_none.gif','No Further Pages'). '</li>';
					  }
					
					}else{
					  if (($this->current_page_number < $this->number_of_pages) && ($this->number_of_pages != 1)) $display_links_string .= '<li><a href="' . dsf_href_link($page_link, $parameters . 'page=' . ($this->current_page_number + 1), $request_type) . '" class="dsPageResults" title=" ' . PREVNEXT_TITLE_NEXT_PAGE . ' ">' . PREVNEXT_BUTTON_NEXT . '</a></li>';
					}
				
				
					  $display_links_string .= '</ul></div>';
				
					  return $display_links_string;
		
	  }
	  
	  
    }

// display number of total products found
    function display_count($text_output) {
      $to_num = ($this->number_of_rows_per_page * $this->current_page_number);
      if ($to_num > $this->number_of_rows) $to_num = $this->number_of_rows;

      $from_num = ($this->number_of_rows_per_page * ($this->current_page_number - 1));

      if ($to_num == 0) {
        $from_num = 0;
      } else {
        $from_num++;
      }

      return sprintf($text_output, $from_num, $to_num, $this->number_of_rows);
    }
  }
?>
