<?php
$choiceStr = '';
$compChoiceStr = '';
$resultStr = '';
$args = array('グー', 'チョキ', 'パー');
$choiceNum = 0;
$compChoiceNum = 0;
$resultNum = 0;

if ( isset( $_POST['choice'] ) === TRUE ) {
  $choiceNum = (int)$_POST['choice'];
  $choiceStr = $args[$choiceNum];
  $compChoiceNum = rand( 0, 1 );
  $compChoiceStr = $args[$compChoiceNum];

  $resultNum = ($choiceNum - $compChoiceNum + 3) % 3;
  if ( $resultNum === 0 ) {
    $resultStr = '引き分け';
  } elseif ( $resultNum === 2 ) {
    $resultStr = '勝ち';
  } else {
    $resultStr = '負け';
  }

}

?>


<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title>じゃんけん</title>
  </head>
  <body>
    <h1>ジャンケン勝負</h1>
    <form method="post">
      <p>
        <input type="radio" name="choice" value="0" id="rock">
        <label for="rock">グー</label>
      </p>
      <p>
        <input type="radio" name="choice" value="1" id="scissors">
        <label for="scissors">チョキ</label>
      </p>
      <p>
        <input type="radio" name="choice" value="2" id="paper">
        <label for="paper">パー</label>
      </p>
      <input type="submit" value="勝負する">
    </form>

<?php if ( $choiceStr !== '' ) : ?>
    <div class="result">
      <p>あなた：<?php echo $choiceStr; ?></p>
      <p>コンピュータ：<?php echo $compChoiceStr; ?></p>
      <p>結果：<?php echo $resultStr; ?></p>
    </div>
<?php endif; ?>
  </body>
</html>
