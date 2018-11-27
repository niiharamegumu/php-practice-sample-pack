<?php
require_once('include/conf/one-board-const.php');
require_once('include/model/one-board-function.php');

$errors = array();
$one_board_data = array();


if ( !$link = get_db_connect() ) {
  $errors[] = 'DBに接続できませんでした。';
}

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  $name = Null;
  $comment = Null;

  $result = check_input_value( 'name', NAME_MAX );
  if ( $result === 'TRUE' ) {
    $name = get_post_value( 'name' );
  } else {
    $errors[] = $result;
  }

  $result = check_input_value( 'comment', COMMENT_MAX );
  if ( $result === 'TRUE' ) {
    $comment = get_post_value( 'comment' );
  } else {
    $errors[] = $result;
  }

  if ( count( $errors ) === 0 ) {
    if ( !set_one_board_list( $link, $name, $comment ) ) {
      $errors[] = 'INSERTエラー';
    }
  }

}

if ( !$one_board_data = get_one_board_list( $link ) ) {
  $errors[] = 'SELECTエラー';
}

$one_board_data = entity_assoc_array($one_board_data);

mysqli_close( $link );

$one_board_data = array_reverse( $one_board_data );


include_once('include/view/one-board-list.php');
