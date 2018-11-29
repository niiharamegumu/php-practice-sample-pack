<?php
require_once( 'include/conf/const.php' );
require_once( 'include/model/function.php' );


$public_drink_list = array();
$public_status = 1;


if ( !$link = get_db_connect() ) {
  $err_msg[] = 'DBに接続できませんでした。';
}

$public_drink_list = get_public_status_drink_data ( $link, $public_status );
$public_drink_list = entity_assoc_array( $public_drink_list );

mysqli_close( $link );


include_once( 'include/view/buy-page.php' );
