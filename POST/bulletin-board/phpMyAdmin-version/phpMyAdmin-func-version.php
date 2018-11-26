<?php
$errors = array();
$one_board_data = array();
define('NAME_MAX', 20);
define('COMMENT_MAX', 100);

define('DB_HOST',   '');
define('DB_USER',   '');
define('DB_PASSWD', '');
define('DB_NAME',   '');
define('DB_CHARACTER_SET',   'UTF8');
define('HTML_CHARACTER_SET', 'UTF-8');



$link = get_db_connect();

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $name = Null;
  $comment = Null;

  $name = check_input_value( 'name', NAME_MAX );
  $comment = check_input_value( 'comment', COMMENT_MAX );

  set_one_board_list( $link );
}

$one_board_data = get_one_board_list( $link );
$one_board_data = entity_assoc_array($one_board_data);

mysqli_close( $link );

$one_board_data = array_reverse( $one_board_data );



function get_db_connect () {
  if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
    $error[] = 'DBの接続に失敗しました。';
  }
  mysqli_set_charset($link, DB_CHARACTER_SET);
  return $link;
}

function check_input_value ( $type, $max ) {
  if ( !isset( $_POST[$type] ) || mb_strlen( $_POST[$type] ) === 0 ) {
    $errors[] = strtoupper($type) . 'を入力してください。';
  } elseif ( mb_strlen( $_POST[$type] ) > $max ) {
    $errors[] = strtoupper($type) . 'は' . $max . '文字以内でお願いします。';
  } else {
    return $_POST[$type];
  }

}

function set_one_board_list ( $link ) {
  if ( count( $error ) === 0 ) {
    $data = array(
      'board_user_name'    => $name,
      'board_user_comment' => $comment
    );
    $sql = "INSERT INTO one_board (board_user_name, board_user_comment)
            VALUES ('" . implode("','", $data) . "')";
    if (!mysqli_query( $link, $sql ) ) {
      $errors[] = 'SQLエラー：' . $sql;
    }
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
    exit;
  }
}

function get_one_board_list ( $link ) {
  $data = array();
  $sql = "SELECT board_user_name,
                 board_user_comment,
                 board_user_date
          FROM one_board";
  if ( $result = mysqli_query( $link, $sql ) ) {
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
    }
    mysqli_free_result($result);
  } else {
    $errors[] = 'SQLエラー：' . $sql;
  }
  return $data;
}

function entity_assoc_array ( $assoc_array ) {
  foreach ($assoc_array as $key => $value) {
    foreach ($value as $keys => $values) {
      $assoc_array[$key][$keys] = htmlspecialchars($values, ENT_QUOTES, HTML_CHARACTER_SET);
    }
}
  return $assoc_array;
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
    <label for="name">NAME：</label>
    <input type="text" name="name" id="name"><br>
    <label for="comment">COMMENT：</label>
    <input type="text" name="comment" id="comment" class="comment"><br>
    <input type="submit" name="submit" value="書き込み">
  </form>

  <ul class="content">
    <?php
      foreach ( $one_board_data as $value ) {
       $html = "<li>";
       $html .= "● " . $value['board_user_name'];
       $html .= "：" . $value['board_user_comment'];
       $html .= "　-" . $value['board_user_date'];
       $html .= "</li>";
       echo $html;
      }
    ?>
  </ul>

</body>
</html>
