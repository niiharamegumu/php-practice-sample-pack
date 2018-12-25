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
  } else {
    return FALSE;
  }
}

function check_have_characters ( $name ) {
  $err = '';
  if ( !isset( $_POST[$name] ) || preg_match("/^(\s|　)+$/", $_POST[$name]) ) {
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

function entity_str($str) {
  return htmlspecialchars($str, ENT_QUOTES, HTML_CHARACTER_SET);
}

function entity_assoc_array($assoc_array) {
  foreach ($assoc_array as $key => $value) {
    foreach ($value as $keys => $values) {
      $assoc_array[$key][$keys] = entity_str($values);
    }
}
  return $assoc_array;
}

function get_as_array($link, $sql) {
  $data = array();
  if ($result = mysqli_query($link, $sql)) {
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
    }
  mysqli_free_result($result);
  }
  return $data;
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

function insert_purchase_history ( $link, $id ) {
  $sql = "INSERT INTO purchase_history (drink_id)
          VALUES (" . $id . ")";
  return insert_db( $link, $sql );
}

function update_stock_num ( $link, $num, $id ) {
  $sql = "UPDATE stock_info
          SET stock_num = " . $num .  " WHERE drink_id = " . $id;
  return insert_db( $link, $sql );
}

function update_public_status ( $link, $status, $id ) {
  $sql = "UPDATE drink_info
          SET public_status = " . $status .  " WHERE drink_id = " . $id;
  return insert_db( $link, $sql );
}

function get_drink_data_list ( $link ) {
  $sql = "SELECT drink_info.drink_id,
                 drink_info.drink_name,
                 drink_info.img_path,
                 drink_info.drink_price,
                 stock_info.stock_num,
                 drink_info.public_status
          FROM drink_info
          JOIN stock_info
          ON drink_info.drink_id = stock_info.drink_id";
  return get_as_array($link, $sql);
}

function get_public_status_drink_data ( $link, $status ) {
  $sql = "SELECT drink_info.drink_id,
                 drink_info.drink_name,
                 drink_info.img_path,
                 drink_info.drink_price,
                 stock_info.stock_num,
                 drink_info.public_status
          FROM drink_info
          JOIN stock_info
          ON drink_info.drink_id = stock_info.drink_id
          WHERE public_status = " . $status;
  return get_as_array($link, $sql);
}

function get_buy_drink_check_data ( $link, $id ) {
  $sql = "SELECT d.drink_price,
                 d.public_status,
                 s.stock_num
          FROM drink_info AS d
          JOIN stock_info AS s
          ON d.drink_id = s.drink_id
          WHERE
            d.drink_id = " . $id .
          " AND" .
            " s.drink_id = " . $id;
  if ( $result = mysqli_query( $link, $sql ) ) {
    return $result;
  } else {
    return FALSE;
  }
}

function get_drink_result_data ( $link, $id ) {
  $sql = "SELECT drink_name,
                 img_path
          FROM drink_info
          WHERE drink_id = " . $id;
  return get_as_array( $link, $sql );
}

function insert_db($link, $sql) {
  if (mysqli_query($link, $sql) === TRUE) {
    return TRUE;
  } else {
    return FALSE;
  }
}
