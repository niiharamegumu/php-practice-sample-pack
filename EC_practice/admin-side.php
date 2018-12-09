<?php

require_once('includes/conf/const.php');
require_once('includes/models/admin-db.php');
require_once('includes/models/functions.php');



if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $input = $_POST;

  require_once('includes/models/admin/admin-product-manage.php');
  switch ( $input['submit-type'] ) {
    case 'add-item':
      $add_item = new Product_Manage();
      $add_item->action_insert_product_data( $input );
      $add_item->page_render();
      break;
    case 'stock-update':
      $stock_update = new Product_Manage();
      $stock_update->action_update_item_stock( $input );
      $stock_update->page_render();
      break;

  }

} else {
  include_once('includes/view/product-manage.php');
}







?>
