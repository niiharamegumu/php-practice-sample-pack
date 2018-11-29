<?php
require_once( 'include/conf/const.php' );
require_once( 'include/model/function.php' );

$drink_data_list = array();
$reverse = 0;


if ( !$link = get_db_connect() ) {
  $err_msg[] = 'DBに接続できませんでした。';
}

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  mysqli_autocommit($link, false);


  switch ( $_POST['submit-type'] ) {

    case 'add-item':
      $drink_name = Null;
      $drink_price = Null;
      $stock_num = Null;
      $status = Null;

      $result = check_have_characters( 'drink-name' );
      if ( $result === 'TRUE' ) {
        $drink_name = get_post_value( 'drink-name' );
      } else {
        $err_msg[] = $result;
      }

      $result = check_have_characters_and_integer( 'drink-price' );
      if ( $result === 'TRUE' ) {
        $drink_price = get_post_value( 'drink-price' );
      } else {
        $err_msg[] = $result;
      }

      $result = check_have_characters_and_integer( 'stock-num' );
      if ( $result === 'TRUE' ) {
        $stock_num = get_post_value( 'stock-num' );
      } else {
        $err_msg[] = $result;
      }

      $result = check_0_or_1( 'status' );
      if ( $result === 'TRUE' ) {
        $status = get_post_value( 'status' );
      } else {
        $err_msg[] = $result;
      }


      $temp_file = $_FILES['drink-image']['tmp_name'];

      if (is_uploaded_file($temp_file)) {
        $file_name = "./images/" . $_FILES['drink-image']['name'];
        $ext = get_extension( $file_name );
        $img_name = get_uniq_num() . $ext;

        $result = check_extension( $ext );
        if ( $result === 'TRUE' ) {
          move_uploaded_file($temp_file, $file_name );
          rename($file_name, "./images/" . $img_name);
        } else {
          $err_msg[] = $result;
        }
      } else {
        $err_msg[] = "ファイルが選択されていません。";
      }


      if ( count( $err_msg ) === 0 ) {
        if ( !insert_drink_info ( $link, $drink_name, $img_name, $drink_price, $status ) ) {
          $err_msg[] = 'drink_info：商品の追加に失敗しました。';
        }

        $drink_insert_id = mysqli_insert_id( $link );

        if ( !insert_stock_info( $link, $drink_insert_id, $stock_num ) ) {
          $err_msg[] = 'stock_info：商品の追加に失敗しました。';
        }
      }

      break;


    case 'stock-update':
      $stock_update_num = Null;
      $drink_id = (int)get_post_value( 'drink-id' );

      $result = check_have_characters_and_integer( 'stock-update-num' );
      if ( $result === 'TRUE' ) {
        $stock_update_num = get_post_value( 'stock-update-num' );
      } else {
        $err_msg[] = $result;
      }

      if ( count( $err_msg )  === 0 ) {
        if ( !update_stock_num( $link, $stock_update_num, $drink_id ) ) {
          $err_msg[] = '在庫数の変更に失敗しました。';
        }
      }

      break;


    case 'change-status':
      $drink_id = (int)get_post_value( 'drink-id' );
      $reverse_status = (int)get_post_value('reverse-status');

      if ( count( $err_msg ) === 0 ) {
        if ( !update_public_status( $link, $reverse_status, $drink_id ) ) {
          $err_msg[] = 'ステータスの変更に失敗しました。';
        }
      }

      break;
  }

  if (count($err_msg) === 0) {
    mysqli_commit($link);
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
    exit;
  } else {
    mysqli_rollback($link);
  }

}

$drink_data_list = get_drink_data_list( $link );
mysqli_close( $link );

$drink_data_list = entity_assoc_array( $drink_data_list );


include_once( 'include/view/control-page.php' );
