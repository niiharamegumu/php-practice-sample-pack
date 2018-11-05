<?php

$filename = './file.txt';
$comment = '';
$log = date( 'Y-m-d H:i:s' ) . "\t";


if ( $_SERVER['REQUEST_METHOD'] === 'POST' ){
  if ( isset( $_POST['comment'] ) ) {
    $comment = $_POST['comment'];
  }
  if ( $fp = fopen( $filename, 'a' ) ) {
    if ( fwrite( $fp, $log . $comment . "\n" ) === FALSE ) {
      print 'ファイル書き込み失敗:  ' . $filename;
    }
    fclose( $fp );
  }
}

$data = array();

if ( $fp = fopen( $filename, 'r' ) ) {
  while ( $tmp = fgets( $fp ) ) {
    $data[] = htmlspecialchars( $tmp, ENT_QUOTES, 'UTF-8' );
  }
    fclose( $fp );
} else {
  $data[] = 'ファイルがありません';
}

?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ファイル操作</title>
</head>
<body>
    <h1>ファイル操作</h1>

    <form method="post">
        <input type="text" name="comment">
        <input type="submit" name="submit" value="送信">
    </form>

    <p>以下に<?php print $filename; ?>の中身を表示</p>
<?php foreach ( $data as $read ) { ?>
    <p><?php print $read; ?></p>
<?php } ?>
</body>
</html>
