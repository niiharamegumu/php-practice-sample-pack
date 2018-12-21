<?php
require_once('includes/conf/const.php');
require_once('includes/models/admin-db.php');
require_once('includes/models/err-checker.php');
require_once('includes/models/functions.php');
require_once('includes/models/admin-product-manage.php');

session_start();

$manage = new Product_Manage();
if ( isset($_SESSION['admin_name']) && ($_SESSION['admin_name'] === 'admin') ) {
  if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $input = $_POST;
    switch ( $input['submit-type'] ) {
      case 'add-item':
        $err_msg = $manage->action_insert_product_data( $input );
        break;
      case 'stock-update':
        list( $success_msg, $err_msg ) = $manage->action_update_item_stock( $input );
        break;
      case 'change-status':
        list( $success_msg, $err_msg ) = $manage->action_update_item_status( $input );
        break;
      case 'delete-item':
        $manage->action_delete_product_data( $input );
        break;
    }

    if ( count($success_msg) > 0 ) {
      $manage->admin_page_render( $success_msg );
    } elseif ( count($err_msg) > 0 ) {
      $manage->admin_page_render( $err_msg );
    } else {
      header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
      // $manage->admin_page_render();
    }


  } else {
    $manage->admin_page_render();
  }
} else {
  header( 'Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER["SCRIPT_NAME"]) . '/index.php');
}
