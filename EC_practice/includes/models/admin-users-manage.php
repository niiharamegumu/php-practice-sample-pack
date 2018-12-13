<?php

class Users_Manage {
  private $db;
  private $checker;

  public function __construct () {
    $this->db = new Admin_Db();
    $this->checker = new Err_Checker();
  }

  public function register_page_render ( $messages = [] ) {
    include_once('includes/view/user-register.php');
  }

  public function action_insert_user_data ( $input ) {
    return $this->insert_user_data( $input );
  }
  private function insert_user_data ( $input ) {
    $db = $this->db;
    return $db->insert_user_data( $input );
  }

}
