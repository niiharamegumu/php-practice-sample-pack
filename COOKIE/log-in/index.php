<?php

if (isset($_COOKIE['cookie_check']) === TRUE) {
  $cookie_check = 'checked';
} else {
  $cookie_check = '';
}
if (isset($_COOKIE['user_name']) === TRUE) {
  $user_name = $_COOKIE['user_name'];
} else {
  $user_name = '';
}

$cookie_check = htmlspecialchars($cookie_check, ENT_QUOTES, 'UTF-8');
$user_name = htmlspecialchars($user_name  , ENT_QUOTES, 'UTF-8');


include_once 'include/view/login-page.php';
?>
