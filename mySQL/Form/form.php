<?php
require_once('include/model/FormHelper.php');
require_once('include/model/functions.php');


$db = get_db_connect();


if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
  list($errors, $input) = validate_form();
  if ( $errors ) {
    show_form($errors);
  } else {
    process_form($db, $input);
  }
} else {
  show_form();
}
?>
