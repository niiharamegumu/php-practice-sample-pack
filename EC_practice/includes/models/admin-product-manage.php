<?php

class Product_Manage {
  private $db;
  private $checker;

  public function __construct () {
    $this->db = new Admin_Db();
    $this->checker = new Err_Checker();
  }

  public function admin_page_render ( $messages = [] ) {
    $db = $this->db;
    $items = $db->get_items_list();
    $items = entity_assoc_array( $items );
    include_once('includes/view/product-manage.php');
  }

  public function product_list_page_render ( $messages = [] ) {
    $db = $this->db;
    $public_products = $db->get_public_product();
    if ( count($public_products) === 0 ) {
      $messages[] = '公開中の商品がありません。';
    }
    $public_products = entity_assoc_array( $public_products );
    include_once('includes/view/product-list.php');
  }

  public function cart_page_render ( $messages = [] ) {
    $db = $this->db;
    $items = $db->get_user_selected_cart_items();
    if ( count($items) === 0 ) {
      $messages[] = 'カートの中身は空です。';
    }
    $items = entity_assoc_array( $items );
    $total = $this->get_cart_total_price( $items );
    include_once('includes/view/cart.php');
  }

  private function get_cart_total_price ( $items ) {
    $total = 0;
    $items_count = count($items);
    for ( $i = 0; $i < $items_count; $i++ ) {
      $price = $items[$i]['item_price'];
      $num = $items[$i]['amount_num'];
      $total += $price * $num;
    }
    return $total;
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

  public function action_insert_cart ( $input ) {
    return $this->insert_cart( $input );
  }
  private function insert_cart ( $input ) {
    $db = $this->db;
    $row = [];
    $row = $db->get_duplicate_cart_item( $input );
    if ( $row ) {
      return $success_msg = $db->update_cart( $input, (int)$row['amount_num'] );
    } else {
      return $success_msg = $db->insert_cart( $input );
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

  public function action_delete_selected_item ( $input ) {
    return $this->delete_selected_item( $input );
  }
  private function delete_selected_item ( $input ) {
    $db = $this->db;
    return $db->delete_selected_item( $input );
  }

}
