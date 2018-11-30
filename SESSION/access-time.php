<?php
$now = date('Y年m月d日 G時i分s秒');
$have_pre_time = FALSE;

session_start();

if ( isset($_SESSION['visited']) === TRUE ) {
  $count = ++$_SESSION['visited'];
} else {
  $_SESSION['visited'] = 1;
  $count = $_SESSION['visited'];
}


if ( isset( $_SESSION['time'] ) === TRUE ) {
  $have_pre_time = TRUE;
  $pre_time = $_SESSION['time'];
  $_SESSION['time'] = $now;
} else {
  $_SESSION['time'] = $now;
}

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  if ( isset( $_POST['delete'] ) ) {
    session_start();

    $session_name = session_name();
    $_SESSION = array();

    if ( isset( $_COOKIE[$session_name] ) ) {
      $params = session_get_cookie_params();
      setcookie($session_name, '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
               );
    }
    session_destroy();
  }

  header('Location:' . $_SERVER['PHP_SELF']);
}


?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>アクセス・タイム</title>
  </head>
  <body>
    <?php if ( $count === 1 ) : ?>
      <p>はじめてのアクセスです。</p>
    <?php else : ?>
      <p><?php echo $count; ?>回目のアクセスです。</p>
    <?php endif; ?>

    <p><?php echo $now; ?>（現在日時）</p>
    <?php if ( $have_pre_time === TRUE ) : ?>
      <p><?php echo $pre_time; ?>（前回のアクセス日時）</p>
    <?php endif; ?>

    <form method="post">
      <input type="submit" name="delete" value="履歴削除">
    </form>
  </body>
</html>
