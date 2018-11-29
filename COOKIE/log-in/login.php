<?php

$now = time();
if (isset($_POST['cookie_check']) === TRUE) {
  $cookie_check = $_POST['cookie_check'];
} else {
  $cookie_check = '';
}
if (isset($_POST['user_name']) === TRUE) {
  $cookie_value = $_POST['user_name'];
} else {
  $cookie_value = '';
}

// Cookieを利用するか確認
if ($cookie_check === 'checked') {
// Cookieへ保存
  setcookie('cookie_check', $cookie_check, $now + 60 * 60 * 24 * 365);
  setcookie('user_name'   , $cookie_value, $now + 60 * 60 * 24 * 365);
} else {
// Cookieを削除
  setcookie('cookie_check', '', $now - 3600);
  setcookie('user_name'   , '', $now - 3600);
}

print '<p>ようこそ</p>';
?>
