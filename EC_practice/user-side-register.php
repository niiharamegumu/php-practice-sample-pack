<?php
require_once('includes/conf/const.php');
require_once('includes/models/admin-db.php');
require_once('includes/models/err-checker.php');
require_once('includes/models/functions.php');
require_once('includes/models/admin-users-manage.php');


$manage = new Users_Manage();

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $input = $_POST;
  list( $success_msg, $err_msg ) = $manage->action_insert_user_data( $input );

  if ( count($success_msg) > 0 ) {
    $manage->register_page_render( $success_msg );
  } elseif ( count($err_msg) > 0 ) {
    $manage->register_page_render( $err_msg );
  } else {
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
    // $manage->register_page_render();
  }

} else {
  $manage->register_page_render();
}
