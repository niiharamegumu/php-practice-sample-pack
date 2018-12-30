<?php

class Err_Checker {
  private $err_msg = [];

  public function check_insert_options_item () {
    $err_msg = $this->err_msg;
    if ( !isset($_POST['item-name']) || preg_match("/^(\s|　)+$/", $_POST['item-name']) || mb_strlen($_POST['item-name']) === 0 ) {
      $err_msg[] = '商品の名前を入力してください。';
    }

    if ( !isset($_POST['item-price']) || preg_match("/^(\s|　)+$/", $_POST['item-price']) || mb_strlen($_POST['item-price']) === 0 ) {
      $err_msg[] = '商品の値段を入力してください。';
    } elseif ( !$this->check_int_zero_over( $_POST['item-price'] ) ) {
      $err_msg[] = '商品の値段は、0以上の半角数字です。';
    }

    if (!isset($_POST['stock-num']) || preg_match("/^(\s|　)+$/", $_POST['stock-num']) || mb_strlen($_POST['stock-num']) === 0 ) {
      $err_msg[] = '商品の個数を入力してください。';
    } elseif ( !$this->check_int_zero_over( $_POST['stock-num'] ) ) {
      $err_msg[] = '商品の個数は、0以上の半角数字です。';
    }

    $img_err = $_FILES['item-img']['error'];
    if ( $img_err === 1 || $img_err === 2 ) {
      $err_msg[] = 'ファイルサイズが大きすぎます。';
    } elseif ( $img_err === 4 ) {
      $err_msg[] = '商品の画像を選択してください。';
    }
    $img_extension_check = $_FILES['item-img']['name'];
    if ( !preg_match( '/\.png$|\.jpg$|\.jpeg$/i', $img_extension_check ) ) {
      $err_msg[] = '画像の拡張子は、.jpg.jpeg or .png でお願いします。';
    }

    if ( !isset($_POST['public-status']) ) {
      $err_msg[] = '商品のステータスを選択してください。';
    } elseif ( !preg_match( '/^[01]$/', $_POST['public-status']) ) {
      $err_msg[] = '不正な入力です。';
    }

    return $err_msg;

  }

  public function check_update_item_stock () {
    $err_msg = $this->err_msg;
    if ( !$this->check_int_zero_over( $_POST['stock-update']) ) {
      $err_msg[] = '商品の個数は、0以上の半角数字です。';
    }
    return $err_msg;
  }

  public function check_user_register_data ( $name_count ) {
    $err_msg = $this->err_msg;
    if ( !preg_match( '/^[0-9a-z]{6,}$/i', $_POST['user-name']) ) {
      $err_msg[] = '名前・パスワードは６文字以上の半角英数字でお願いします。';
    }
    if ( $name_count !== 0 ) {
      $err_msg[] = 'この名前は既に使用されています。';
    }

    return $err_msg;
  }

  public function check_int_zero_over ( $subject ) {
    if ( preg_match('/^[0-9]+$/', $subject ) ) {
      return true;
    } else {
      return false;
    }
  }

  public function check_positive_integer ( $subject ) {
    if ( preg_match('/^[1-9][0-9]*$/', $subject ) ) {
      return true;
    } else {
      return false;
    }
  }


}
