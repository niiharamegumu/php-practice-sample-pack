<?php

class Err_Checker {
  private $err_msg = [];

  public function check_insert_options_item () {
    $err_msg = $this->err_msg;
    if ( !isset($_POST['item-name']) || mb_strlen( $_POST['item-name'] ) === 0 ) {
      $err_msg[] = '商品の名前を入力してください。';
    }

    if ( !isset($_POST['item-price']) || mb_strlen( $_POST['item-price'] ) === 0 ) {
      $err_msg[] = '商品の値段を入力してください。';
    } elseif ( !filter_input( INPUT_POST, 'item-price', FILTER_VALIDATE_INT ) ) {
      $err_msg[] = '商品の値段は、0以上の整数です。';
    }

    if (!isset($_POST['stock-num']) || mb_strlen( $_POST['stock-num'] ) === 0) {
      $err_msg[] = '商品の個数を入力してください。';
    } elseif ( !filter_input( INPUT_POST, 'stock-num', FILTER_VALIDATE_INT ) ) {
      $err_msg[] = '商品の個数は、0以上の整数です。';
    }

    if ( $_FILES['item-img']['error'] === 4 ) {
      $err_msg[] = '商品の画像を選択してください。';
    }

    if ( !isset($_POST['public-status']) ) {
      $err_msg[] = '商品のステータスを選択してください。';
    } elseif ( !preg_match( '/^[01]$/', $_POST['public-status']) ) {
      $err_msg[] = '不正な入力です。';
    }

    return $err_msg;

  }


}
