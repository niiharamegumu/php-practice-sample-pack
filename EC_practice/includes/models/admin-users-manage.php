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

  public function login_page_render ( $messages = [] ) {
    include_once('includes/view/login.php');
  }

  public function user_manage_page_render ( $messages = [] ) {
    $db = $this->db;
    $users = [];
    $users = $db->get_user_data();
    $users = entity_assoc_array( $users );
    include_once('includes/view/user-manage.php');
  }

  public function action_user_login ( $input ) {
    return $this->user_login( $input );
  }
  private function user_login ( $input ) {
    $db = $this->db;
    $count = 0;
    $count = $db->user_login( $input );
    if ( $count === 1 ) {
      return true;
    } else {
      return false;
    }
  }

  public function action_insert_user_data ( $input ) {
    return $this->insert_user_data( $input );
  }

  private function insert_user_data ( $input ) {
    $db = $this->db;
    $checker = $this->checker;
    $name_count = $db->count_duplicate_user_data( 'user_name', $input['user-name'] );
    $err_msg = $checker->check_user_register_data( $name_count );

    if ( count($err_msg) > 0 ) {
      return array( [], $err_msg );
    } else {
      list( $success_msg, $err_msg ) = $db->insert_user_data( $input );
      return array( $success_msg, $err_msg );
    }
  }

}
