<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <div class="wrapper">
      <h1>ユーザー登録ページ</h1>

      <nav class="global-nav">
        <ul>
          <li><a href="./index.php">ログインページに移動する</a></li>
        </ul>
      </nav>

      <?php if ( count($messages) > 0 ) : ?>
        <div class="message-wrapper">
          <ul>
            <?php foreach ( $messages as $message ) : ?>
              <li><?php echo $message; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form method="post" action="<?php echo $_SERVER['PHP_SELF']?>">
        <div>
          <label for="register-name">ユーザー名</label>：
          <input type="text" name="user-name" id="register-name" placeholder="ユーザー名" autofocus><br>
          <label for="register-pw">パスワード</label>：
          <input type="password" name="user-pw" id="register-pw" placeholder="パスワード">
        </div>
        <input type="submit" value="新規作成する">
      </form>

    </div>
  </body>
</html>
