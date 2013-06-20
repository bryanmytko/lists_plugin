<?php

class Longbeach_Output{

  private $wpdb;

  public function __construct(){

    global $wpdb;
    $this->wpdb = &$wpdb;

  }

  public function display_data($type=null){

    $lists = $this->get_lists($type);

    /*echo "<script>jQuery('#Grid').mixitup({
    targetSelector: '.mix',
    filterSelector: '.filter',
    sortSelector: '.sort',
    buttonEvent: 'click',
    effects: ['fade','scale'],
    listEffects: null,
    easing: 'smooth',
    layoutMode: 'grid',
    targetDisplayGrid: 'inline-block',
    targetDisplayList: 'block',
    gridClass: '',
    listClass: '',
    transitionSpeed: 600,
    showOnLoad: 'all',
    sortOnLoad: false,
    multiFilter: false,
    filterLogic: 'or',
    resizeContainer: true,
    minHeight: 0,
    failClass: 'fail',
    perspectiveDistance: '3000',
    perspectiveOrigin: '50% 50%',
    animateGridList: true,
    onMixLoad: null,
    onMixStart: null,
    onMixEnd: null
    });</script>";*/
    echo "<script>jQuery(document).ready(function(){ jQuery('#Grid').mixitup(); });</script>";

echo '<div class="controls"><ul>
    <li class="filter active" data-filter="all">Show All<li> | 
    <li class="filter" data-filter="pizza">Pizza</li> | 
    <li class="filter" data-filter="italian">Italian</li> | 
    <li class="filter" data-filter="chinese">Chinese</li> | 
    <li class="filter" data-filter="thai">Thai</li>
</ul></div>';
    
  foreach($lists as $l){
      $items = $this->get_list_items($l['id']);
      echo '<div class="lblist_container">';
      echo '<h2>' . $l['name'] . '</h2>';
      $i = 0;
      echo '<ul id="Grid">';
      foreach($items as $i){
        $tag_strings = explode(',',stripslashes($i['tags']));
        $tags = implode(" ",$tag_strings);
        echo '<li class="mix lblist_unit ' . $tags . '">';
        echo '<h4>' . stripslashes($i['name']) . '</h4>';
        echo '<p>' . stripslashes($i['address']) . '</p>';
        echo '<p>' . stripslashes($i['phone']) . '</p>';
        echo '<p><a href="' . stripslashes($i['url']) . '" target="_blank">' . stripslashes($i['url']) . '</a></p>';
        echo '<em><strong>tags:</strong> ' . $i['tags'] . '</em>';
        echo '</li>';
        $i++;
        if($i%3 == 0) echo '<div class="clear"></div>';
      }
      echo '<ul>';
      echo '</div>';
    }

  }

  private function get_lists($type){

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

    return $results;

  }

  private function get_list_items($id){

    $results = $this->wpdb->get_results(
      "SELECT * FROM " . $this->wpdb->prefix . "longbeach_list_items WHERE list_id = " . $id,
      ARRAY_A
    );

    return $results;

  }

  //@TODO sorting...? Ajax?
  private function sorting(){} 


}
