<?php
$err_msg = array();
$height = '';
$weight = '';
$bmi    = '';


$request_method = get_request_method();

if ($request_method === 'POST') {
  $height = get_post_data('height');
  $height = (int)$height / 100;
  $weight = get_post_data('weight');

  if (!check_float($height)) {
    $err_msg[] = '身長は数値を入力してください';
  }

  if (!check_float($weight)) {
    $err_msg[] = '体重は数値を入力してください';
  }

  if (count($err_msg) === 0) {
    $bmi = calc_bmi($height, $weight);
  }
}


/**
* BMIを計算
* @param mixed $height 身長
* @param mixed $weight 体重
* @return float BMI
*/
function calc_bmi( $height, $weight ) {
  return round( $weight / ($height * $height), 2 );
}

/**
* 値が正の整数又は小数か確認
* @param mixed $float 確認する値
* @return bool TRUEorFALSE
*/
function check_float($float) {
  return preg_match( '/^([1-9]\d*|0)(\.\d+)?$/', $float );
}

/**
* リクエストメソッドを取得
* @return str GET/POST/PUTなど
*/
function get_request_method() {
  return $_SERVER['REQUEST_METHOD'];
}

/**
* POSTデータを取得
* @param str $key 配列キー
* @return str POST値
*/
function get_post_data($key) {
  $str = '';
  if (isset($_POST[$key]) === TRUE) {
    $str = $_POST[$key];
  }
  return $str;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>BMI計算</title>
</head>
<body>
  <h1>BMI計算</h1>
  <form method="post">
    身長: <input type="text" name="height" value="<?php print $height ?>">
    体重: <input type="text" name="weight" value="<?php print $weight ?>">
    <input type="submit" value="BMI計算">
  </form>

  <?php if (count($err_msg) > 0) : ?>
    <?php     foreach ($err_msg as $value) : ?>
      <p><?php print $value; ?></p>
    <?php endforeach; ?>
  <?php endif; ?>

  <?php if ($request_method === 'POST' && count($err_msg) ===0) : ?>
    <p>あなたのBMIは<?php print $bmi; ?>です</p>
  <?php endif; ?>

</body>
</html>
