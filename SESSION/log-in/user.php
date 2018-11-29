<?php
require_once 'include/conf/const.php';
require_once 'include/model/function.php';

session_start();

if (isset($_SESSION['user_id']) === TRUE) {
   $user_id = $_SESSION['user_id'];
} else {
   header('Location: http://localhost:8888/php-practice-sample-pack/SESSION/log-in/index.php');
   exit;
}

$link = get_db_connect();

$sql = 'SELECT user_name FROM user_table WHERE user_id = ' . $user_id;

$data = get_as_array($link, $sql);

close_db_connect($link);

if (isset($data[0]['user_name'])) {
   $user_name = $data[0]['user_name'];
} else {
   header('Location: http://localhost:8888/php-practice-sample-pack/SESSION/log-in/logout.php');
   exit;
}

include_once 'include/view/user-page.php';
?>
