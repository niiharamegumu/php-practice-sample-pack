<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <div class="login-wrapper">
      <?php if ( count($messages) > 0 ) : ?>
        <ul>
          <?php foreach ( $messages as $message ) : ?>
            <li><?php echo $message; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <input type="text" name="login-user-name" placeholder="ユーザー名"><br>
        <input type="password" name="login-user-pw" placeholder="パスワード"><br>
        <input type="submit" name="login" value="ログイン">
      </form>
      <a href="./user-side-register.php">ユーザーの新規登録</a>
    </div>
  </body>
</html>
