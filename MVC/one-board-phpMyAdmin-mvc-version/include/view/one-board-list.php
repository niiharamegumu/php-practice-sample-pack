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

  <form method="post" action="one-board-controller.php">
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
