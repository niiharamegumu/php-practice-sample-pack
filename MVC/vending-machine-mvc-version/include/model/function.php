<?php


function get_db_connect () {
  if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
    return FALSE;
  }
  mysqli_set_charset($link, DB_CHARACTER_SET);
  return $link;
}

function get_post_value ( $name ) {
  if ( isset( $_POST[$name] ) ) {
    return trim( $_POST[$name] );
  }
}

function check_have_characters ( $name ) {
  $err = '';
  if ( !isset( $_POST[$name] ) || mb_strlen( $_POST[$name] ) === 0 ) {
    $err = strtoupper( $name ) . 'が空です。';
    return $err;
  } else {
    return 'TRUE';
  }
}

function check_have_characters_and_integer ( $name ) {
  $err = '';
  $result = check_have_characters( $name );
  if ( $result !== 'TRUE' ) {
    return $result;
  } elseif ( !preg_match('/^[0-9]+$/', $_POST[$name] ) ) {
    $err = strtoupper( $name ) . 'は0以上の整数でお願いします。';
    return $err;
  } else {
    return 'TRUE';
  }
}

function check_0_or_1 ( $name ) {
  $err = '';
  if ( !preg_match( '/^[01]$/', $_POST[$name] ) ) {
    $err = strtoupper( $name ) . 'は 0 or 1 でお願いします';
    return $err;
  } else {
    return 'TRUE';
  }
}

function get_extension ( $file_name ) {
  $ext = "." . pathinfo($file_name, PATHINFO_EXTENSION);
  return $ext;
}

function get_uniq_num () {
  $result = md5( uniqid() );
  return $result;
}

function check_extension ( $ext ) {
  $err = '';
  if ( !preg_match( '/\.png$|\.jpg$|\.jpeg$/i', $ext ) ) {
    $err = '画像の拡張子は、.jpg or .png でお願いします。';
    return $err;
  } else {
    return 'TRUE';
  }
}

function insert_drink_info ( $link, $drink_name, $img_name, $drink_price, $status ) {
  $data = array(
    'drink_name'    => $drink_name,
    'img_path'      => $img_name,
    'drink_price'   => $drink_price,
    'public_status' => $status
  );
  $sql = "INSERT INTO drink_info (drink_name, img_path, drink_price, public_status)
          VALUES ('" . implode("','", $data) . "')";
  return insert_db( $link, $sql );
}

function insert_stock_info ( $link, $drink_id, $stock_num ) {
  $sql = "INSERT INTO stock_info (drink_id, stock_num)
          VALUES (" . $drink_id . "," . $stock_num . ")";
  return insert_db( $link, $sql );
}

function insert_db($link, $sql) {
  if (mysqli_query($link, $sql) === TRUE) {
    return TRUE;
  } else {
    return FALSE;
  }
}
