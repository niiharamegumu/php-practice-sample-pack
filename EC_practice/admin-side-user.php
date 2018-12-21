<?php
require_once('includes/conf/const.php');
require_once('includes/models/admin-db.php');
require_once('includes/models/err-checker.php');
require_once('includes/models/functions.php');
require_once('includes/models/admin-users-manage.php');

session_start();

$manage = new Users_Manage() ;

if ( isset($_SESSION['admin_name']) && ($_SESSION['admin_name'] === 'admin') ) {
  
  $manage->user_manage_page_render();

} else {
  header( 'Location: http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER["SCRIPT_NAME"]) . '/index.php');
}
