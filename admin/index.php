<?php

class AdminLists {

  private $page;
  private $wpdb;
  public $results;
  public $list_items;
  public $title;
  public $id;

  public function __construct($page = 'index'){

    global $wpdb;
    $this->wpdb = &$wpdb;
    $this->page = $page;

    /* general application actions routed here */
    switch($page){
      case 'index':
        $this->get_lists();
        break;
      case 'create':
        $this->create_list();
        $this->get_lists();
        break;
      case 'delete':
        $this->delete_list();
        $this->get_lists();
        break;
      case 'edit':
        $this->edit_list();
        break;
      case 'delete_list_item':
        $this->delete_list_item();
        $this->edit_list();
        break;
      case 'add_list_item':
        $this->add_list_item();
        $this->edit_list();
        break;
    }

    $this->render_template();

  }

  public function render_template(){

    ob_start();

    include "views/" . $this->page . ".php";

    ob_flush();

  }

  private function create_list(){

    $list_name = $_POST['new_list'];
    $this->wpdb->insert(
      $this->wpdb->prefix . 'longbeach_lists',
      array( 
        'time' => current_time('mysql'),
        'name' => $list_name,
        'list_order' => 3 
      )
    );

  }

  private function get_lists(){

    $this->results = $this->wpdb->get_results(
      "SELECT * FROM " . $this->wpdb->prefix . "longbeach_lists",
      ARRAY_A
    );
    
    $this->page = 'index'; //always redirect to main plugin page

  }
  
  private function delete_list(){

    $id = $_GET['id'];
    $this->wpdb->query( 
    	$this->wpdb->prepare( 
    		"DELETE FROM " . $this->wpdb->prefix . "longbeach_lists 
    		 WHERE id = " . $id
    	)
    );
    
  }
  
  private function edit_list(){
    
    if(!isset($this->id)) $this->id = $_GET['id'];

    $this->results = $this->list_items = $this->wpdb->get_results(
      "SELECT * FROM " . $this->wpdb->prefix . "longbeach_lists WHERE id = " . $this->id,
      ARRAY_A
    );
    $this->list_items = $this->wpdb->get_results(
      "SELECT * FROM " . $this->wpdb->prefix . "longbeach_list_items WHERE list_id = " . $this->id,
      ARRAY_A
    );
 
  }
  
  private function add_list_item(){
    
    $name = $_POST['name'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $url = $_POST['url'];
    $tags = $_POST['tags'];
    $this->id = $_POST['list_id'];
    
    $this->wpdb->insert(
      $this->wpdb->prefix . 'longbeach_list_items',
      array( 
        'time' => current_time('mysql'),
        'name' => $name, 
        'url' => $url,
        'address' => $address,
        'phone' => $phone,
        'tags' => $tags,
        'list_id' => $this->id
      )
    );
    
    $this->page = 'edit';
    
  }
  
  private function delete_list_item(){
    
    $id = $_GET['id'];
    $this->id = $this->wpdb->get_results(
        "SELECT list_id FROM " . $this->wpdb->prefix . "longbeach_list_items WHERE id = " . $id,
        ARRAY_A
      );
    $this->id = $this->id[0]['list_id'];

    $this->wpdb->query( 
    	$this->wpdb->prepare( 
    		"DELETE FROM " . $this->wpdb->prefix . "longbeach_list_items
    		 WHERE id = " . $id
    	)
    );

    $this->page = 'edit';
    
  }

}

$page = (!isset($_GET['action'])) ? 'index' : $_GET['action'];

$a = new AdminLists($page);

?>
