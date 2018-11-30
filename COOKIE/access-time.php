<?php
$now = date('Y年m月d日 G時i分s秒');
$have_pre_time = FALSE;

if ( isset($_COOKIE['visited']) === TRUE ) {
  $count = $_COOKIE['visited'] + 1;
} else {
  $count = 1;
}
setcookie( 'visited', $count, time() + 60 * 60 * 24 * 365 );

if ( isset( $_COOKIE['time'] ) === TRUE ) {
  $have_pre_time = TRUE;
  $pre_time = $_COOKIE['time'];
  $time = $now;
} else {
  $time = $now;
}
setcookie( 'time', $time, time() + 60 * 60 * 24 * 365 );

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  if ( isset( $_POST['delete'] ) ) {
    setcookie( 'visited', '', time() - 4000 );
    setcookie( 'time', '', time() - 4000 );
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
