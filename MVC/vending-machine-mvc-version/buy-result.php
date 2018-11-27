<?php
require_once( 'include/conf/const.php' );
require_once( 'include/model/function.php' );

$remaining_amount = 0;
$result_data = array();


$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME);

if ( $link ) {
  mysqli_set_charset($link, 'UTF8');
  $input_amount = 0;
  $stock_num = 0;
  $drink_price = 0;
  $drink_id = Null;
  $public_status = Null;

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


    if ( count( $err_msg ) === 0 ) {
      $sql = "SELECT d.drink_price,
                     d.public_status,
                     s.stock_num
              FROM drink_info AS d
              JOIN stock_info AS s
              ON d.drink_id = s.drink_id
              WHERE
                d.drink_id = " . $drink_id .
              " AND" .
                " s.drink_id = " . $drink_id;

      if ($result = mysqli_query( $link, $sql ) ) {
        $row = mysqli_fetch_array( $result );
        $drink_price = (int)$row['drink_price'];

        if ( (int)$row['stock_num'] === 0 ) {
          $err_msg[] = '在庫数に変更がありました。在庫がありませんでした。';
        } else {
          $stock_num = (int)$row['stock_num'];
        }

        if ( (int)$row['public_status'] === 0 ) {
          $err_msg[] = '公開ステータスが変更されていました。非公開の飲み物でした。';
        }

      } else {
        $err_msg[] = 'SQLエラー' . $sql;
      }

      if ( $input_amount >= $drink_price ) {
        $remaining_amount = $input_amount - $drink_price;
      } else {
        $err_msg[] = '投入金額が足りません。';
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

      if ( count( $err_msg ) === 0 ) {
        $sql = "INSERT INTO purchase_history (drink_id)
                VALUES (" . $drink_id . ")";
        if ( !mysqli_query( $link, $sql ) ) {
          $err_msg[] = 'SQLエラー' . $sql;
        }
      }

    }

    if (count($err_msg) === 0) {
      mysqli_commit($link);
    } else {
      mysqli_rollback($link);
    }
  }

  if ( count( $err_msg ) === 0 ) {
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
  }

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
      <?php if ( count( $err_msg ) === 0 ) : ?>
        <img src="./images/<?php echo $result_data[0]['img_path']; ?>" alt="ドリンクイメージ">
        <p>購入ドリンク：<?php echo $result_data[0]['drink_name']; ?></p>
        <p>おつり：<?php echo $remaining_amount; ?>円</p>
      <?php else : ?>
        <ul>
          <?php foreach ( $err_msg as $err ): ?>
              <li><?php echo $err; ?></li>
          <?php endforeach; ?>
        </ul>
      <?php endif; ?>
      <footer><a href="index.php">戻る</a></footer>
    </section>

  </div>

</body>
</html>
