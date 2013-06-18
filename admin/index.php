<?php

class AdminLists {

  private $page;

  public function __construct($page = 'index'){

    $this->page = $page;

    switch($page){
      case 'create':
        $this->create_list();
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
    $this->page = 'index'; //redirect to main plugin page

  }

}

$page = (!isset($_GET['action'])) ? 'index' : $_GET['action'];

$a = new AdminLists($page);

?>
