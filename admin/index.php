<?php

class AdminLists {

  private $page;
  public $results;

  public function __construct($page = 'index'){

    $this->page = $page;

    switch($page){
      case 'index':
        $this->get_lists();
        break;
      case 'create':
        $this->create_list();
        $this->get_lists();
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

    global $wpdb;
    $list_name = $_POST['new_list'];
    $wpdb->insert($wpdb->prefix . 'longbeach_lists', array( 'time' => current_time('mysql'), 'name' => $list_name, 'list_order' => 3 ) );

  }

  private function get_lists(){

    global $wpdb;
    $this->results = $wpdb->get_results("SELECT * FROM " . $wpdb->prefix . "longbeach_lists",ARRAY_A);
    $this->page = 'index'; //always redirect to main plugin page

  }

}

$page = (!isset($_GET['action'])) ? 'index' : $_GET['action'];

$a = new AdminLists($page);

?>
