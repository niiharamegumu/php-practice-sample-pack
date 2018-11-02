<?php
$name = '';
$gender = '';
$mail = '';

if( isset($_POST['my_name']) === TRUE && isset($_POST['gender']) === TRUE && isset($_POST['mail']) === TRUE ){
  $name = htmlspecialchars($_POST['my_name'], ENT_QUOTES, 'UTF-8');
  $gender = htmlspecialchars($_POST['gender'], ENT_QUOTES, 'UTF-8');
  $mail = htmlspecialchars($_POST['mail'], ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <form method="post">
      <p>
        <label for="my_name">お名前</label> :
        <input id="my_name" type="text" name="my_name" value="">
      </p>
      <p>
        <input type="radio" name="gender" value="man" id="man" <?php if($gender === '男'){ echo 'checked'; } ?>>
        <label for="man">男</label>
      </p>
      <p>
        <input type="radio" name="gender" value="woman" id="woman" <?php if($gender === '女'){ echo 'checked'; } ?>>
        <label for="woman">女</label>
      </p>
      <p>
        <input type="checkbox" name="mail" value="OK" id="mail" <?php if($mail === 'OK'){ echo 'checked'; } ?>>
        <label for="mail">お知らせメールを受け取る</label>
      </p>
      <input type="submit" value="送信">
    </form>

<?php if( $name !== '' && $gender !== '' && $mail !== '' ) : ?>
    <div>
      <p>お名前 : <?php echo $name; ?></p>
      <p>性別 : <?php echo $gender; ?></p>
      <p>メールの受取 : <?php echo $mail; ?></p>
    </div>
<?php endif; ?>

  </body>
</html>
