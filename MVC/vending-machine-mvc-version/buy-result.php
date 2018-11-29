<?php
require_once( 'include/conf/const.php' );
require_once( 'include/model/function.php' );

$remaining_amount = 0;
$result_data = array();


if ( !$link = get_db_connect() ) {
  $err_msg[] = 'DBに接続できませんでした。';
}

$input_amount = 0;
$stock_num = 0;
$drink_price = 0;
$drink_id = Null;
$public_status = Null;

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  mysqli_autocommit($link, false);

  $result = check_have_characters_and_integer( 'input-amount' );
  if ( $result === 'TRUE' ) {
    $input_amount = get_post_value( 'input-amount' );
  } else {
    $err_msg[] = $result;
  }

  if ( !isset( $_POST['drink-id'] ) ) {
    $err_msg[] = 'ドリンクが指定されていません。';
  } elseif ( !preg_match( '/^[0-9]+$/', $_POST['drink-id'] ) ) {
    $err_msg[] = '不正な操作です。';
  } else {
    $drink_id = (int)get_post_value( 'drink-id' );
  }


  if ( count( $err_msg ) === 0 ) {

    if ($result = get_buy_drink_check_data( $link, $drink_id ) ) {
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
      $err_msg[] = 'SQLエラー：get_buy_drink_check_data()';
    }

    if ( $input_amount >= $drink_price ) {
      $remaining_amount = $input_amount - $drink_price;
    } else {
      $err_msg[] = '投入金額が足りません。';
    }

    if ( count( $err_msg ) === 0 ) {
      $after_stock_num = $stock_num - 1;
      if ( !update_stock_num( $link, $after_stock_num, $drink_id ) ) {
        $err_msg[] = '在庫数の更新に失敗しました。';
      }
    }

    if ( count( $err_msg ) === 0 ) {
      if ( !insert_purchase_history( $link, $drink_id ) ) {
        $err_msg[] = '購入履歴の追加に失敗しました。';
      }
    }

  }

  if (count($err_msg) === 0) {
    mysqli_commit($link);
  } else {
    mysqli_rollback($link);
  }
}

$result_data = get_drink_result_data( $link, $drink_id );
mysqli_close( $link );

$result_data = entity_assoc_array( $result_data );


include_once( 'include/view/result-page.php' );
