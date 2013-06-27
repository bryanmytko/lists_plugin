<?php
/*
Plugin Name: Long Beach Lists
Description: Creates custom, sortable lists
Version: 0.1
Author: Bryan Mytko
Author URI: http://www.bryanmytko.com
License: GPL2

Copyright 2013 Bryan Mytko (email : bryanmytko@gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

define(APP_PATH,'index.php?page=longbeach_lists/admin/index.php');

class WP_Longbeach_Lists{

  public function __construct(){

    add_action(
    'admin_menu',
    array(&$this,'create_menu_page')
    ); 
    
  }

  public function create_menu_page(){

    add_menu_page(
    "Longbeach Lists",
    "Longbeach Lists",
    "manage_options",
    "longbeach_lists/admin/index.php",
    "",
    "",
    25
    );

  }

  public function activate(){

    global $wpdb;

    $table_name_lists = $wpdb->prefix . "longbeach_lists";
    $table_name_items = $wpdb->prefix . "longbeach_list_items";

		$sql = "CREATE TABLE $table_name_lists (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			name tinytext NOT NULL,
      list_order mediumint(9),
			UNIQUE KEY id (id)); CREATE TABLE $table_name_items (
      id mediumint(9) NOT NULL AUTO_INCREMENT,
      time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
      list_id mediumint(9),
      name tinytext NOT NULL,
      url VARCHAR(255) DEFAULT '' NOT NULL,
      img VARCHAR(255),
      tags text,
      address text,
      phone VARCHAR(255),
      UNIQUE KEY id (id));";

    require(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);

  }

  public function deactivate(){}

}

$wp_longbeach_lists = new WP_Longbeach_Lists();

/* Front-end Display */
function longbeach_lists($type=null){
  require('lib/output.php'); 
  $o = new Longbeach_Output();
  $o->display_data($type);
}

/* Register hooks for activation (creates DB) and deactivation */
register_activation_hook(__FILE__, array('WP_Longbeach_Lists', 'activate'));
register_deactivation_hook(__FILE__, array('WP_Longbeach_Lists', 'deactivate'));

/* Enqueue CSS */
add_action('wp_enqueue_scripts','lb_add_my_files');
function lb_add_my_files() {
  wp_enqueue_script("jquery");
  wp_register_script('lb-mixitup', plugins_url('/public/js/mixitup-1.5.4/src/jquery.mixitup.js',__FILE__));
  wp_enqueue_script('lb-mixitup');
  wp_register_script('lb-script', plugins_url('/public/js/longbeach_lists.js',__FILE__));
  wp_enqueue_script('lb-script');
  wp_register_style('lb-style',plugins_url('/public/css/longbeach_lists.css',__FILE__));
  wp_enqueue_style('lb-style');
}