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
    $manage->purchase_comp_page_render( $input );
  } else {
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER["SCRIPT_NAME"]) . '/user-side-product-list.php');
  }

} else {
  header( 'Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER["SCRIPT_NAME"]) . '/index.php');
}
