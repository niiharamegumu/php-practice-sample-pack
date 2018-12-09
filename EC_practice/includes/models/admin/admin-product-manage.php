<?php

class Product_Manage {
  private $db;

  public function __construct () {
    $this->db = new Admin_Db();
  }

  public function page_render () {
    $db = $this->db;
    $items = $db->get_items_list();
    $items = entity_assoc_array( $items );
    include_once('includes/view/product-manage.php');
  }

  public function action_insert_product_data ( $input ) {
    $this->insert_product_data( $input );
  }

  private function insert_product_data ( $input ) {
    $db = $this->db;
    $input['item-img'] = img_file_upload();
    $insert_id = $db->insert_options_item( $input );
    $db->insert_option_stock( $input, $insert_id );
  }

  public function action_update_item_stock ( $input ) {
    $this->update_item_stock( $input );
  }

  private function update_item_stock ( $input ) {
    $db = $this->db;
    $db->update_item_stock( $input );
  }

  public function action_update_item_status ( $input ) {
    $this->update_item_status( $input );
  }

  private function update_item_status ( $input ) {
    $db = $this->db;
    $db->update_item_status( $input );
  }

}
