<?php

class Longbeach_Output{

  private $wpdb;

  public function __construct(){
    global $wpdb;
    $this->wpdb = &$wpdb;
  }

  public function display_data($type=null){

    $lists = $this->get_lists($type);

    if(!$lists) return false; //if no associated list, stop

    $tagsArray = $this->get_tags($type);

		$controls = '<div class="controls"><ul>';
		$controls .= '<li class="filter active" data-filter="all">Show All</li> | ';
		
    foreach($tagsArray as $t){
        $tDisplay = preg_replace('/-/',' ',ucfirst($t));
        $t = preg_replace('/[-!$%^&*()_+|~=`{}\[\]:";\'<>?,.\/]/','-',$t);
				$controls .= '<li class="filter" data-filter="' . $t . '">' . $tDisplay . '</li> | ';
    }
    
    $controls = trim($controls, '| ');
    $controls .= '</ul></div>';

    echo $controls;
    
   foreach($lists as $l){
      $items = $this->get_list_items($l['id']);
      echo '<div class="lblist_container">';
      echo '<ul id="Grid">';
      foreach($items as $i){
        $tag_strings = explode(',',stripslashes($i['tags']));
        $tags = implode(" ",$tag_strings);
        $vtags = preg_replace('/[ -!$%^&*()_+|~=`{}\[\]:";\'<>?,.\/]/','-',trim($tags));
        echo '<li class="span_5 col mix lblist_unit ' . $vtags . '">';
        echo '<h5>' . stripslashes($i['name']) . '</h5>';
        echo '<p>' . stripslashes($i['address']) . '</p>';
        echo '<p>' . stripslashes($i['phone']) . '</p>';
        echo '<p><a href="' . stripslashes($i['url']) . '" target="_blank">';
        echo stripslashes($i['url']) . '</a></p>';
        echo '</li>';
      }
      echo '<div class="clear"></div>';
      echo '</ul>';
      echo '</div>';
    }

  }

  private function get_lists($type){
    $type = preg_replace('/-/',' ',$type);
    if($type != null){
			$id = $this->wpdb->get_results(
				"SELECT id FROM " . $this->wpdb->prefix . "longbeach_lists WHERE name='" . $type . "'",
				ARRAY_A
			);
			$id = $id[0]['id'];
      $query_type =  " WHERE id=" . $id;
    } else $query_type = '';

    $results = $this->wpdb->get_results(
      "SELECT * FROM " . $this->wpdb->prefix . "longbeach_lists" . $query_type,
      ARRAY_A
    );

    return (!empty($results)) ? $results : false;

  }

  private function get_list_items($id){

    $results = $this->wpdb->get_results(
      "SELECT * FROM " . $this->wpdb->prefix . "longbeach_list_items WHERE list_id = " . $id . " ORDER BY name",
      ARRAY_A
    );

    return $results;

  }

  private function get_tags($type){

	  $id = $this->wpdb->get_results(
		  "SELECT id FROM " . $this->wpdb->prefix . "longbeach_lists WHERE name='" . $type . "'",
			ARRAY_A
		);
		
    $id = $id[0]['id'];

    $results = $this->wpdb->get_results(
      "SELECT tags FROM " . $this->wpdb->prefix . "longbeach_list_items WHERE list_id = " . $id,
      ARRAY_A
    );

    $resultsAll = array();
    foreach($results as $r){
      foreach($r as $i){
        $i = preg_replace('/ /','-',trim($i));
        $e = explode(',',$i);
        $resultsAll = array_merge($resultsAll,$e);
      }
    }
    
    $resultsAll = array_unique($resultsAll);
    sort($resultsAll);
    
    return $resultsAll;

  }

}
