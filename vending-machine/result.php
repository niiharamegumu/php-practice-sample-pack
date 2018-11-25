<?php
$err_msg = array();
$result_data = array();
$host = 'localhost';
$user = 'root';
$pw = 'root';
$dbName = 'vending_machine';


// DB connect.
$link = mysqli_connect($host, $user, $pw, $dbName);

if ( $link ) {
  mysqli_set_charset($link, 'UTF8');
  $input_amount = 0;
  $stock_num = 0;
  $drink_id = Null;

  if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    mysqli_autocommit($link, false);

    if ( !isset( $_POST['input-amount'] ) || mb_strlen( $_POST['input-amount'] ) === 0 ) {
      $err_msg[] = '投入金額が空です。';
    } elseif ( !preg_match( '/^[0-9]+$/', $_POST['input-amount'] ) ) {
      $err_msg[] = '投入金額は、0以上の整数でお願いします。';
    } else {
      $input_amount = $_POST['input-amount'];
    }

    if ( !isset( $_POST['drink-id'] ) ) {
      $err_msg[] = 'ドリンクが指定されていません。';
    } elseif ( !preg_match( '/^[0-9]+$/', $_POST['drink-id'] ) ) {
      $err_msg[] = '不正な操作です。';
    } else {
      $drink_id = (int)$_POST['drink-id'];
    }

    $sql = "SELECT stock_num
    FROM stock_info
    WHERE drink_id = " . $drink_id;
    if ($result = mysqli_query( $link, $sql ) ) {
      $row = mysqli_fetch_array( $result );
      $stock_num = (int)$row['stock_num'];
    } else {
      $err_msg[] = 'SQLエラー' . $sql;
    }

    if ( count( $err_msg ) === 0 ) {
      $after_stock_num = $stock_num - 1;
      $sql = "UPDATE stock_info
              SET stock_num = " . $after_stock_num .
              " WHERE drink_id = " . $drink_id;
      if ( !mysqli_query( $link, $sql ) ) {
      $err_msg[] = 'SQLエラー' . $sql;
      }
    }
    if (count($err_msg) === 0) {
      mysqli_commit($link);
      // header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
      // exit;
    } else {
      mysqli_rollback($link);
    }
  }

  $sql = "SELECT drink_name,
                 img_path
          FROM drink_info
          WHERE drink_id = " . $drink_id;

  if ( $result = mysqli_query( $link, $sql ) ) {
    while ( $row = mysqli_fetch_array( $result ) ) {
      // $row --> Sanitizing をすること
      $result_data[] = $row;
    }
  }

  mysqli_free_result( $result );
  mysqli_close( $link );

} else {
  $err_msg[] = 'DBに接続できていません。';
}

?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>自動販売機</title>
</head>
<body>

  <div class="result-wrapper">
    <h1>購入結果ページ</h1>

    <section class="purchase-result">
      <h2>販売結果</h2>
      <img src="./images/<?php echo $result_data[0]['img_path']; ?>" alt="ここは画像です">
      <p>購入ドリンク：<?php echo $result_data[0]['drink_name']; ?></p>
      <p>おつり：<?php echo $input_amount; ?>円</p>
      <footer><a href="index.php">戻る</a></footer>
    </section>

  </div>

</body>
</html>
