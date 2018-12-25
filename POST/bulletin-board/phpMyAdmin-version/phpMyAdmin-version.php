<?php
$errors = array();
$data = array();
$name_max = 20;
$comment_max = 100;

$host = '';
$username = '';
$passwd = '';
$dbname = '';
$link = mysqli_connect( $host, $username, $passwd, $dbname );

if ( $link ) {
  mysqli_set_charset( $link, 'utf8' );

  if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $name = null;
    $comment = null;
    if ( !isset($_POST['name']) || preg_match("/^(\s|　)+$/", $_POST['name']) ) {
      $errors['name_error'] = '名前を入力してください';
    } elseif ( mb_strlen($_POST['name']) > $name_max ) {
      $errors['name_error'] = '名前は20文字以内で入力してください';
    } else {
      $name = $_POST['name'];
    }

    if ( !isset($_POST['comment']) || preg_match("/^(\s|　)+$/", $_POST['comment']) ) {
      $errors['comment_error'] = 'コメントを入力してください';
    } elseif ( mb_strlen($_POST['comment']) > $comment_max ) {
      $errors['comment_error'] = 'コメントは100文字以内で入力してください';
    } else {
      $comment = $_POST['comment'];
    }

    if ( count($errors) === 0 ) {
      $name = "'" . $name . "'";
      $comment = "'" . $comment . "'";
      $date = "'" . date('Y-m-d H:i:s') . "'";
      $query_insert = "INSERT INTO one_board (board_user_name, board_user_comment, board_user_date)
                        VALUES (" . $name . "," . $comment . "," . $date . ")";

      mysqli_query( $link, $query_insert );
      header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
      exit;
    }
  }
  $query_select = "SELECT board_user_name, board_user_comment, board_user_date FROM one_board";
  $result = mysqli_query( $link, $query_select );
  while ( $row = mysqli_fetch_array($result)) {
    $data[] = $row;
  }
  mysqli_free_result( $result );
  mysqli_close( $link );
  $data = array_reverse( $data );

} else {
  echo '接続エラー';
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ひとこと掲示板</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <h1>ひとこと掲示板</h1>

  <?php if ( count($errors) > 0 ) : ?>
    <ul class="error">
      <?php foreach ( $errors as $error ) : ?>
        <li><?php echo $error; ?></li>
      <?php endforeach; ?>
    </ul>
  <?php endif; ?>

  <form method="post" action="phpMyAdmin-version.php">
    <label for="name">名前：</label>
    <input type="text" name="name" id="name"><br>
    <label for="comment">コメント：</label>
    <input type="text" name="comment" id="comment" class="comment"><br>
    <input type="submit" name="submit" value="書き込み">
  </form>

  <ul class="content">
    <?php
      foreach ( $data as $value ) {
       $html = "<li>";
       $html .= "● " . $value[0] . "：" . $value[1] . "　-" . $value[2];
       $html .= "</li>";
       echo $html;
      }
    ?>
  </ul>

</body>
</html>
