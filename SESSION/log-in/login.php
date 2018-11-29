<?php
require_once 'include/conf/const.php';
require_once 'include/model/function.php';

if (get_request_method() !== 'POST') {
   header('Location: http://localhost:8888/php-practice-sample-pack/SESSION/log-in/index.php');
   exit;
}

session_start();

$email  = get_post_data('email');
$passwd = get_post_data('passwd');

setcookie('email', $email, time() + 60 * 60 * 24 * 365);

$link = get_db_connect();

$sql = 'SELECT user_id FROM user_table
       WHERE email =\'' . $email . '\' AND passwd =\'' . $passwd . '\'';

$data = get_as_array($link, $sql);

close_db_connect($link);

if (isset($data[0]['user_id'])) {
   $_SESSION['user_id'] = $data[0]['user_id'];
   header('Location: http://localhost:8888/php-practice-sample-pack/SESSION/log-in/user.php');
   exit;
} else {
   $_SESSION['login_err_flag'] = TRUE;
   header('Location: http://localhost:8888/php-practice-sample-pack/SESSION/log-in/index.php');
   exit;
}
?>
