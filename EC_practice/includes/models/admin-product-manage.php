<?php

class Product_Manage {
  private $db;
  private $checker;

  public function __construct () {
    $this->db = new Admin_Db();
    $this->checker = new Err_Checker();
  }

  public function page_render ( $messages = [] ) {
    $db = $this->db;
    $items = $db->get_items_list();
    $items = entity_assoc_array( $items );
    include_once('includes/view/product-manage.php');
  }

  public function action_insert_product_data ( $input ) {
    return $this->insert_product_data( $input );
  }

  private function insert_product_data ( $input ) {
    $db = $this->db;
    $checker = $this->checker;

    $err_msg = $checker->check_insert_options_item();

    if ( count( $err_msg ) > 0 ) {
      return $err_msg;
    } else {
      $input['item-img'] = img_file_upload();
      $insert_id = $db->insert_options_item( $input );
      $db->insert_option_stock( $input, $insert_id );
      return array();
    }

  }

  public function action_delete_product_data ( $input ) {
    $this->delete_product_data( $input );
  }
  private function delete_product_data ( $input ) {
    $db = $this->db;
    $db->delete_product_data( $input );
  }

  public function action_update_item_stock ( $input ) {
    return $this->update_item_stock( $input );
  }

  private function update_item_stock ( $input ) {
    $db = $this->db;
    $checker = $this->checker;
    $err_msg = $checker->check_update_item_stock();
    if ( count($err_msg) > 0 ) {
      return array( [], $err_msg );
    } else {
      list( $success_msg, $err_msg ) = $db->update_item_stock( $input );
      return array($success_msg, $err_msg);
    }
  }

  public function action_update_item_status ( $input ) {
    return $this->update_item_status( $input );
  }

  private function update_item_status ( $input ) {
    $db = $this->db;
    list( $success_msg, $err_msg ) = $db->update_item_status( $input );
    return array($success_msg, $err_msg);
  }

}
