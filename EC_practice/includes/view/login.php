<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <div class="wrapper">
      <h1>ログインページ</h1>

      <nav class="global-nav">
        <ul>
          <li><a href="./user-side-register.php">ユーザーの新規登録</a></li>
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

      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="user-name">ユーザー名</label>：
        <input type="text" name="login-user-name" id="user-name" placeholder="ユーザー名" autofocus><br>
        <label for="user-pw">パスワード</label>：
        <input type="password" name="login-user-pw" id="user-pw" placeholder="パスワード"><br>
        <input type="submit" name="login" value="ログイン">
      </form>

    </div>
  </body>
</html>
