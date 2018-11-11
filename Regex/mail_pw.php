<?php
$mail_message = '';
$pw_message = '';
$mail_ok = false;
$pw_ok = false;

if (isset($_POST['mail']) && isset($_POST['password']) ) {
   $mail = $_POST['mail'];
   $pw = $_POST['password'];

   if (mb_strlen($mail) === 0) {
       $mail_message =  'アドレスを入力してください。';
   } else if (preg_match('/^[a-zA-Z0-9_.+-]+[@][a-zA-Z0-9.-]+$/', $mail) !== 1) {
       $mail_message = '形式が違います。xxxx@xxx.xxxでお願いします。';
   } else {
     $mail_ok = true;
   }
   if (mb_strlen($pw) === 0) {
       $pw_message =  'パスワードを入力してください。';
   } else if (preg_match('/[a-zA-Z0-9]{6,18}/', $pw) !== 1) {
       $pw_message = '6文字以上18文字以下の半角英数字(大文字可)でお願いします。';
   } else {
     $pw_ok = true;
   }

}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
   <meta charset="UTF-8">
   <title>正規表現課題</title>
</head>
<body>
  <?php if ( !$mail_ok || !$pw_ok ) :  ?>
    <form method="post">
      <p>
        <label>メールアドレス</label>
        <input type="text" name="mail">
      </p>
      <p>
        <label>パスワード</label>
        <input type="password" name="password">
      </p>
      <?php
        if ( $mail_message !== '' ) {
          echo "<p>" . $mail_message . "</p>";
        }
        if ( $pw_message !== '' ) {
          echo "<p>" . $pw_message . "</p>";
        }
      ?>
      <input type="submit" name="submit" value="登録">
    </form>
  <?php else : ?>
    <p>登録完了</p>
  <?php endif; ?>
</body>
</html>
