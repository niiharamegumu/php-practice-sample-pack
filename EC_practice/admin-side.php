<?php
require_once('includes/conf/const.php');
require_once('includes/models/admin-db.php');
require_once('includes/models/err-checker.php');
require_once('includes/models/functions.php');
require_once('includes/models/admin-product-manage.php');

$manage = new Product_Manage();

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $input = $_POST;
  switch ( $input['submit-type'] ) {
    case 'add-item':
      $err = $manage->action_insert_product_data( $input );
      break;
    case 'stock-update':
      list( $success, $err ) = $manage->action_update_item_stock( $input );
      break;
    case 'change-status':
      list( $success, $err ) = $manage->action_update_item_status( $input );
      break;
    case 'delete-item':
      $manage->action_delete_product_data( $input );
      break;
  }


  $success_msg = $success;
  $err_msg = $err;

  if ( count($success_msg) > 0 ) {
    $manage->page_render( $success_msg );
  } elseif ( count($err_msg) > 0 ) {
    $manage->page_render( $err_msg );
  } else {
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
  }


} else {
  $manage->page_render();
}







?>
