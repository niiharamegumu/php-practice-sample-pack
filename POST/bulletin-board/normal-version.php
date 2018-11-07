<?php
$name = '';
$comment = '';
$writeContent = '';
$data = array();
$name_strlen = 0;
$comment_strlen = 0;
$name_max = 20;
$comment_max = 100;
$fileName = './user_data.txt';
$log = '[' . date( 'Y-m-d H:i:s' ) . ']' .  "\n";


if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $name = htmlspecialchars( $_POST['name'], ENT_QUOTES, 'UTF-8' );
  $comment = htmlspecialchars( $_POST['comment'], ENT_QUOTES, 'UTF-8' );
  $name_strlen = mb_strlen($name);
  $comment_strlen = mb_strlen($comment);
  if( mb_strlen($name) <= $name_max && mb_strlen($name) !== 0 &&
      mb_strlen($comment) <= $comment_max && mb_strlen($comment) !== 0){

    if ( $fp = fopen( $fileName, 'a' ) ) {
      $writeContent = $name . '：' . $comment . $log;
      if ( !fwrite( $fp, $writeContent ) ) {
        echo '書き込みに失敗';
      }
      fclose( $fp );
    }

  }
  $url_add_get_key = "?name_strlen=" . $name_strlen . "&comment_strlen=" . $comment_strlen;
  header("Location:http://localhost:8888/code-camp/main.php" . $url_add_get_key);
  exit();
}


if ( $fp = fopen( $fileName, 'r' ) ) {
  while ( $tmp = fgets( $fp ) ) {
    $data[] = htmlspecialchars( $tmp, ENT_QUOTES, 'UTF-8' );
  }
  fclose( $fp );
} else {
  echo ' 読み込みに失敗 ';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ファイル操作</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>ひとこと掲示板</h1>
    <ul>
      <?php
        if( $_GET['name_strlen'] > $name_max ){
          echo '<li>名前は20文字以内です。</li>';
        }
        if ( $_GET['name_strlen'] === '0' ) {
          echo '<li>名前を入力してください。</li>';
        }
        if ( $_GET['comment_strlen'] > $comment_max  ) {
          echo '<li>コメントは100文字以内です。</li>';
        }
        if ( $_GET['comment_strlen'] === '0' ) {
          echo '<li>コメントを入力してください。</li>';
        }
        $flag = FALSE;
      ?>
    </ul>
  <form method="post">
    <table>
      <tr>
        <th><label for="name">名前：</label></th>
        <td><input type="text" name="name" id="name" value=""></td>
      </tr>
      <tr>
        <th><label for="comment">コメント：</label></th>
        <td><input type="text" name="comment" id="comment" value=""></td>
      </tr>
    </table>
    <input type="submit" name="submit" value="送信">
  </form>

    <div>
      <ul>
        <?php
          $html = '';
          foreach ( $data as $value ) {
            $html .= '<li>';
            $html .= $value;
            $html .= '</li>';
            echo $html;
            $html = '';
          }
        ?>
      </ul>
    </div>
</body>
</html>
