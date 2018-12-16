<?php

class Users_Manage {
  private $db;
  private $checker;

  public function __construct () {
    $this->db = new Admin_Db();
    $this->checker = new Err_Checker();
  }

  public function check_admin_user ( $input ) {
    $admin_name = 'admin';
    $admin_pw = 'admin';
    if ( ($input['login-user-name'] === $admin_name) && ($input['login-user-pw'] === $admin_pw) ) {
      return true;
    } else {
      return false;
    }
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
    return $this->get_user_login_pw( $input );
  }
  private function get_user_login_pw ( $input ) {
    $db = $this->db;
    $row = [];
    $login_flag = false;

    $row = $db->get_user_login_pw( $input );
    $login_flag = password_verify( $input['login-user-pw'], $row['password'] );
    if ( $login_flag ) {
      $_SESSION['user_id'] = $row['id'];
      $_SESSION['user_name'] = $input['login-user-name'];
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
