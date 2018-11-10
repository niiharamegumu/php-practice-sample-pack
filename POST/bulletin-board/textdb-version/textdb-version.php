<?php
$filename = './user_data.txt';
$errors = array();
$data = array();
$name_max = 20;
$comment_max = 100;

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $name = null;
  $comment = null;
  if ( !isset($_POST['name']) || mb_strlen($_POST['name']) === 0 ) {
    $errors['name_error'] = '名前を入力してください';
  } elseif ( mb_strlen($_POST['name']) > $name_max ) {
    $errors['name_error'] = '名前は20文字以内で入力してください';
  } else {
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
  }

  if ( !isset($_POST['comment']) || mb_strlen($_POST['comment']) === 0 ) {
    $errors['comment_error'] = 'コメントを入力してください';
  } elseif ( mb_strlen($_POST['comment']) > $comment_max ) {
    $errors['comment_error'] = 'コメントは100文字以内で入力してください';
  } else {
    $comment = htmlspecialchars($_POST['comment'], ENT_QUOTES, 'UTF-8');
  }

  if ( count($errors) === 0 ) {
    $write_content = $name . '：' . $comment . ' -' . date('Y-m-d H:i:s') ."\n";

    if ( !$fp = fopen($filename, 'a') ) {
      exit('ファイルが開けませんでした');
    }

    if ( !fwrite($fp, $write_content) ) {
      exit('ファイルに書き込めませんでした');
    }
    fclose($fp);
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
  }
}


  if ( $fp = fopen($filename, 'r') ) {
    while ( $tmp = fgets($fp) ) {
      $data[] = htmlspecialchars($tmp, ENT_QUOTES, 'UTF-8');
    }
    fclose($fp);
    $data = array_reverse($data);
  }
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ファイル操作</title>
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

  <form method="post" action="textdb-version.php">
    <label for="name">名前：</label>
    <input type="text" name="name" id="name"><br>
    <label for="comment">コメント：</label>
    <input type="text" name="comment" id="comment" class="comment"><br>
    <input type="submit" name="submit" value="書き込み">
  </form>

  <ul class="content">
    <?php foreach ( $data as $value ) : ?>
      <li>● <?php echo $value; ?></li>
    <?php endforeach; ?>
  </ul>

</body>
</html>
