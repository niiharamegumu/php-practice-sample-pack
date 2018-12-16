<?php
require_once('includes/conf/const.php');
require_once('includes/models/admin-db.php');
require_once('includes/models/err-checker.php');
require_once('includes/models/functions.php');
require_once('includes/models/admin-product-manage.php');

session_start();
$manage = new Product_Manage();




if ( isset($_SESSION['user_name']) ) {

  if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $input = $_POST;
    switch ( $input['submit-type'] ) {
      case 'insert-cart':
        $success_msg = $manage->action_insert_cart( $input );
        break;
    }
    if ( count($success_msg) > 0 ) {
      $manage->product_list_page_render( $success_msg );
    }
  } else {
    $manage->product_list_page_render();
  }

} else {
  header( 'Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER["SCRIPT_NAME"]) . '/login.php');
}
