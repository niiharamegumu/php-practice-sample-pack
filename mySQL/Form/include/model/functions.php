<?php
function get_db_connect () {
  try {
    $dsn = 'mysql:host=;dbname=;charset=utf8';
    $user = '';
    $pw = '';
    $db = new PDO( $dsn, $user, $pw );
  } catch (PDOException $e) {
    print $e->getMessage();
    exit;
  }
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  return $db;
}


function show_form ( $errors = [] ) {
  $defaults = ['price' => '5.00'];
  $form = new FormHelper($defaults);
  include_once('include/view/form-view.php');
}


function validate_form () {
  $input = [];
  $errors = [];

  $input['dish_name'] = trim($_POST['dish_name'] ?? '');
  if ( !strlen($input['dish_name']) ) {
    $errors[] = 'Please enter the name of the dish.';
  }

  $input['price'] = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT) ?? '';
  if ( $input['price'] <= 0 ) {
    $errors[] = 'Please enter a valid price.';
  }

  $input['is_spicy'] = $_POST['is_spicy'] ?? 'no';

  return array($errors, $input);
}


function process_form( $db, $input ) {
  if ( $input['is_spicy'] === 'yes' ) {
    $is_spicy = 1;
  } else {
    $is_spicy = 0;
  }

  try {
    $stmt = $db->prepare('INSERT INTO dishes (dish_name, price, is_spicy)
                          VALUES (?,?,?)');
    $stmt->execute([$input['dish_name'], $input['price'], $is_spicy]);
    print 'Added ' . htmlentities($input['dish_name']) . " to the database.";
  } catch ( PDOException $e ) {
    print "Couldn't add your dish to the database.<br>";
    print 'Error:' . $e->getMessage();
  }

}
