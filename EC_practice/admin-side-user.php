<?php
require_once('includes/conf/const.php');
require_once('includes/models/admin-db.php');
require_once('includes/models/err-checker.php');
require_once('includes/models/functions.php');
require_once('includes/models/admin-users-manage.php');


$manage = new Users_Manage() ;

$manage->user_manage_page_render();
