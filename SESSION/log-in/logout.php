<?php

require_once 'include/conf/const.php';
require_once 'include/model/function.php';

session_start();

$session_name = session_name();

$_SESSION = array();


if (isset($_COOKIE[$session_name])) {

  $params = session_get_cookie_params();

  // sessionに利用しているクッキーの有効期限を過去に設定することで無効化
  setcookie($session_name, '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
  );
}

session_destroy();

header('Location: http://localhost:8888/php-practice-sample-pack/SESSION/log-in/index.php');
exit;
?>
