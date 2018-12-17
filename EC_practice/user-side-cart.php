<?php
require_once('includes/conf/const.php');
require_once('includes/models/admin-db.php');
require_once('includes/models/err-checker.php');
require_once('includes/models/functions.php');
require_once('includes/models/admin-product-manage.php');

session_start();
var_dump($_SESSION);

$manage = new Product_Manage();

if ( isset($_SESSION['user_name']) ) {

  if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $input = $_POST;
    switch ( $input['submit-type'] ) {
      case 'delete-selected-item':
        $success_msg = $manage->action_delete_selected_item( $input );
        break;
    }
    if ( count($success_msg) > 0 ) {
      $manage->cart_page_render( $success_msg );
    }
  } else {
    $manage->cart_page_render();
  }

} else {
  header( 'Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER["SCRIPT_NAME"]) . '/login.php');
}
