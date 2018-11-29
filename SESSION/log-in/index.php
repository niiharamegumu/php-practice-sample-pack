<?php

require_once 'include/conf/const.php';
require_once 'include/model/function.php';

session_start();

if (isset($_SESSION['user_id']) === TRUE) {
   header('Location: http://localhost:8888/php-practice-sample-pack/SESSION/log-in/user.php');
   exit;
}

if (isset($_SESSION['login_err_flag']) === TRUE) {
   $login_err_flag = $_SESSION['login_err_flag'];
   $_SESSION['login_err_flag'] = FALSE;
} else {
   $login_err_flag = FALSE;
}

if (isset($_COOKIE['email']) === TRUE) {
   $email = $_COOKIE['email'];
} else {
   $email = '';
}

$email = entity_str($email);
include_once 'include/view/index-page.php';
?>
