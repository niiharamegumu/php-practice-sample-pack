<?php
require_once('includes/conf/const.php');
require_once('includes/models/admin-db.php');
require_once('includes/models/err-checker.php');
require_once('includes/models/functions.php');
require_once('includes/models/admin-users-manage.php');

session_start();
$manage = new Users_Manage();

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $login_flag = false;
  $admin_user = false;
  $input = $_POST;

  $admin_user = $manage->check_admin_user( $input );
  if ( $admin_user ) {
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER["SCRIPT_NAME"]) . '/admin-side.php');
  } else {

    $login_flag = $manage->action_user_login( $input );
    if ( $login_flag ) {
      header( 'Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER["SCRIPT_NAME"]) . '/user-side-product-list.php');
    } else {
      $err_msg[] = 'ユーザー名または、パスワードが違います。';
      $manage->login_page_render( $err_msg );
    }
    
  }

} else {
  $manage->login_page_render();
}
