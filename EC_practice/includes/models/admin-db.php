<?php

class Admin_Db {
  private $db;

  public function __construct() {
    $this->db = $this->db_connect();;
    return $this->db;
  }

  public function db_connect () {
    try {
      $db = new PDO(DSN, DB_USER, DB_PASSWD);
    } catch ( PDOException $e ) {
      $e->getMessage();
      exit;
    }
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }

  public function insert_options_item ( $input ) {
    $date = date('Y-m-d H:i:s');
    $db = $this->db;
    $db->beginTransaction();
    try {
      $stmt = $db->prepare('INSERT INTO item_info ( item_name, item_price, item_img, public_status, created_date )
                            VALUES (?,?,?,?,?)');
      $args = [
        $input['item-name'],
        $input['item-price'],
        $input['item-img'],
        $input['public-status'],
        $date
      ];
      $stmt->execute( $args );
      $id = $db->lastInsertId();
      $db->commit();
      return $id;
    } catch ( PDOException $e ) {
      $db->rollBack();
      $e->getMessage();
    }
  }

  public function insert_option_stock ( $input, $id ) {
    $date = date('Y-m-d H:i:s');
    $db = $this->db;
    $db->beginTransaction();
    try {
      $stmt = $db->prepare('INSERT INTO stock_info ( item_id, stock_num, created_date )
                            VALUES (?,?,?)');
      $args = [
        $id,
        $input['stock-num'],
        $date
      ];
      $stmt->execute( $args );
      $db->commit();
    } catch ( PDOException $e ) {
      $db->rollBack();
      $e->getMessage();
    }
  }

  public function get_items_list () {
    $items = [];
    $date = date('Y-m-d H:i:s');
    $db = $this->db;
    $sql = "SELECT i.id,
                   i.item_name,
                   i.item_img,
                   i.item_price,
                   i.public_status,
                   s.stock_num
            FROM item_info as i
            JOIN stock_info as s
            ON i.id = s.item_id";
    try {
      $stmt = $db->query( $sql );
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $items[] = $row;
      }
      return $items;
    } catch ( PDOException $e ) {
      $e->getMessage();
    }
  }

  public function update_item_stock ( $input ) {
    $db = $this->db;
    $stock_num = (int)$input['stock-update'];
    $item_id = (int)$input['item-id'];
    $db->beginTransaction();
    try {
      $stmt = $db->prepare('UPDATE stock_info SET stock_num = :stock WHERE item_id = :id');
      $stmt->bindValue(':stock', $stock_num, PDO::PARAM_INT);
      $stmt->bindValue(':id', $item_id, PDO::PARAM_INT);
      $stmt->execute();
      $db->commit();
    } catch ( PDOException $e ) {
      $db->rollBack();
      $e->getMessage();
    }
  }

}
