<?php


function get_db_connect () {
  if (!$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWD, DB_NAME)) {
    return FALSE;
  }
  mysqli_set_charset($link, DB_CHARACTER_SET);
  return $link;
}

function get_post_value ( $name ) {
  if( isset( $_POST[$name] ) ) {
    return trim( $_POST[$name] );
  }
}

function check_input_value ( $type, $max ) {
  $error = '';
  if ( !isset( $_POST[$type] ) || preg_match("/^(\s|　)+$/", $_POST[$type]) ) {
    $error = strtoupper($type) . 'を入力してください。';
    return $error;
  } elseif ( mb_strlen( $_POST[$type] ) > $max ) {
    $error = strtoupper($type) . 'は' . $max . '文字以内でお願いします。';
    return $error;
  } else {
    return 'TRUE';
  }
}

function set_one_board_list ( $link, $name, $comment ) {
  $data = array(
    'board_user_name'    => $name,
    'board_user_comment' => $comment
  );
  $sql = "INSERT INTO one_board_revised_edition (board_user_name, board_user_comment)
          VALUES ('" . implode("','", $data) . "')";
  if (!mysqli_query( $link, $sql ) ) {
    return FALSE;
  }
  header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
  exit;
}

function get_one_board_list ( $link ) {
  $data = array();
  $sql = "SELECT board_user_name,
                 board_user_comment,
                 board_user_date
          FROM one_board_revised_edition";
  if ( $result = mysqli_query( $link, $sql ) ) {
    if (mysqli_num_rows($result) > 0) {
      while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
      }
    }
    mysqli_free_result($result);
  } else {
    return FALSE;
  }
  return $data;
}

function entity_assoc_array ( $assoc_array ) {
  foreach ($assoc_array as $key => $value) {
    foreach ($value as $keys => $values) {
      $assoc_array[$key][$keys] = htmlspecialchars($values, ENT_QUOTES, HTML_CHARACTER_SET);
    }
}
  return $assoc_array;
}
