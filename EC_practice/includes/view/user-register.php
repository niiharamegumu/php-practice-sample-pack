<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <h1>ユーザー登録ページ</h1>
    <?php if ( count($messages) > 0 ) : ?>
      <ul>
        <?php foreach ( $messages as $message ) : ?>
          <li><?php echo $message; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
      <div>
        <label for="user-name">ユーザー名</label>：
        <input type="text" name="user-name" value="" placeholder="ユーザー名"><br>
        <label for="user-pw">パスワード</label>：
        <input type="password" name="user-pw" value="" placeholder="パスワード">
      </div>
      <input type="submit" value="新規作成する">
    </form>
    <nav>
      <a href="./login.php">ログインページに移動する</a>
    </nav>
  </body>
</html>
