<?php

class Admin_Db {
  private $db;
  private $success_msg = [];
  private $err_msg = [];


  public function __construct() {
    $this->db = $this->db_connect();
  }

  public function db_connect () {
    try {
      $db = new PDO(DSN, DB_USER, DB_PASSWD);
    } catch ( PDOException $e ) {
      echo $e->getMessage();
      exit;
    }
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
  }

  public function insert_options_item ( $input ) {
    $date = date('Y-m-d H:i:s');
    $db = $this->db;
    try {
      $db->beginTransaction();
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
      echo 'insert_options_item ' . $e->getMessage();
    }
  }

  public function insert_option_stock ( $input, $id ) {
    $date = date('Y-m-d H:i:s');
    $db = $this->db;
    try {
      $db->beginTransaction();
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
      echo 'insert_option_stock ' . $e->getMessage();
    }
  }

  public function insert_user_data ( $input ) {
    $date = date('Y-m-d H:i:s');
    $db = $this->db;
    try {
      $db->beginTransaction();
      $stmt = $db->prepare('INSERT INTO user_info ( user_name, password, created_date )
                            VALUES (?,?,?)');
      $args = [
        $input['user-name'],
        password_hash($input['user-pw'], PASSWORD_BCRYPT),
        $date
      ];
      $stmt->execute( $args );
      $db->commit();
      $this->success_msg[] = '登録完了!';
    } catch ( PDOException $e ) {
      $db->rollBack();
      $this->err_msg[] = '登録に失敗しました。';
    }
    return array($this->success_msg, $this->err_msg);

  }

  public function insert_cart ( $input ) {
    $date = date('Y-m-d H:i:s');
    $db = $this->db;
    $amount_num = 1;
    try {
      $db->beginTransaction();
      $sql = "INSERT INTO cart_info (
                user_id, item_id, amount_num, created_date
              )
              VALUES ( ?, ?, ?, ? )";
      $stmt = $db->prepare( $sql );
      $args = [
        $_SESSION['user_id'],
        $input['item-id'],
        $amount_num,
        $date
      ];
      $stmt->execute( $args );
      $db->commit();
      $this->success_msg[] = 'カートに追加しました。';
    } catch ( PDOException $e ) {
      $db->rollBack();
    }
    return $this->success_msg;
  }

  public function update_cart ( $input, $num ) {
    $db = $this->db;
    $amount_num = ++$num;
    try {
      $db->beginTransaction();
      $sql = "UPDATE cart_info SET amount_num = :num WHERE item_id = :id";
      $stmt = $db->prepare( $sql );
      $stmt->bindValue(':num', $amount_num, PDO::PARAM_INT);
      $stmt->bindValue(':id', $input['item-id'],PDO::PARAM_INT);
      $stmt->execute();
      $db->commit();
      $this->success_msg[] = 'カートに追加しました。';
    } catch ( PDOException $e ) {
      $db->rollBack();
    }
    return $this->success_msg;
  }

  public function get_items_list () {
    $items = [];
    $db = $this->db;
    try {
      $sql = "SELECT i.id,
              i.item_name,
              i.item_img,
              i.item_price,
              i.public_status,
              s.stock_num
              FROM item_info as i
              JOIN stock_info as s
              ON i.id = s.item_id";

      $stmt = $db->query( $sql );
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $items[] = $row;
      }
    } catch ( PDOException $e ) {
      echo $e->getMessage();
    }
    return $items;
  }

  public function get_public_product () {
    $public_products = [];
    $db = $this->db;
    try {
      $sql = "SELECT i.id,
              i.item_name,
              i.item_img,
              i.item_price,
              s.stock_num
              FROM item_info as i
              JOIN stock_info as s
              ON i.id = s.item_id
              WHERE public_status = 1";

      $stmt = $db->query( $sql );
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $public_products[] = $row;
      }

    } catch (PDOException $e) {
      echo $e->getMessage();
    }
    return $public_products;

  }

  public function get_stock_num_item_id ( int $id ) {
    $db = $this->db;
    $row = [];
    $stock_num = 0;
    try {
      $sql = "SELECT stock_num FROM stock_info WHERE item_id = :id";
      $stmt = $db->prepare( $sql );
      $stmt->bindValue( ':id', $id, PDO::PARAM_INT );
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      $stock_num = (int)$row['stock_num'];
    } catch ( PDOException $e ) {
      echo $e->getMessage();
    }
    return $stock_num;

  }

  public function get_user_data () {
    $db = $this->db;
    $uers = [];
    try {
      $sql = "SELECT user_name, password, created_date FROM user_info";
      $stmt = $db->query( $sql );
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $users[] = $row;
      }
    } catch ( PDOException $e ) {
      echo $e->getMessage();
    }
    return $users;
  }

  public function get_user_selected_cart_items () {
    $db = $this->db;
    $items = [];
    $id;
    try {
      $sql = "SELECT c.id,
                     c.amount_num,
                     c.item_id,
                     i.item_name,
                     i.item_price,
                     i.item_img
              FROM cart_info as c
              JOIN item_info as i
              ON c.item_id = i.id
              WHERE c.user_id = :id";
      $stmt = $db->prepare( $sql );
      $id = (int)$_SESSION['user_id'];
      $stmt->bindValue( ':id', $id, PDO::PARAM_INT );
      $stmt->execute();
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
        $items[] = $row;
      }
    } catch ( PDOException $e ) {
      echo $e->getMessage();
    }
    return $items;
  }

  public function count_duplicate_user_data ( $column, $data ) {
    $db = $this->db;
    $count = 0;
    $db_column = '';
    switch ( $column ) {
      case 'user_name':
        $db_column = 'user_name';
        break;
    }
    try {
      $sql = "SELECT COUNT( * ) FROM user_info WHERE " . $db_column . " = ?";
      $stmt = $db->prepare( $sql );
      $stmt->execute( array($data) );
      $count = (int)$stmt->fetchColumn();
    } catch ( PDOException $e ) {
      echo $e->getMessage();
    }
    return $count;

  }

  public function get_duplicate_cart_item ( $input ) {
    $db = $this->db;
    try {
      $sql = "SELECT amount_num FROM cart_info WHERE item_id = :id";
      $stmt = $db->prepare( $sql );
      $stmt->bindValue(':id', $input['item-id'], PDO::PARAM_INT);
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch ( PDOException $e ) {
      echo $e->getMessage();
    }
    return $row;

  }

  public function get_user_login_pw ( $input ) {
    $db = $this->db;
    $row = [];
    try {
      $sql = "SELECT id, password FROM user_info
              WHERE user_name = ?";
      $stmt = $db->prepare( $sql );
      $args = [
        $input['login-user-name']
      ];
      $stmt->execute( $args );
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch ( PDOException $e ) {
      echo $e->getMessage();
    }
    return $row;

  }

  public function update_item_stock ( $input ) {
    $db = $this->db;
    $stock_num = (int)$input['stock-update'];
    $item_id = (int)$input['item-id'];
    try {
      $db->beginTransaction();
      $stmt = $db->prepare('UPDATE stock_info SET stock_num = :stock WHERE item_id = :id');
      $stmt->bindValue(':stock', $stock_num, PDO::PARAM_INT);
      $stmt->bindValue(':id', $item_id, PDO::PARAM_INT);
      $stmt->execute();
      $db->commit();
      $this->success_msg[] = '在庫数を変更しました。';
    } catch ( PDOException $e ) {
      $db->rollBack();
      $this->err_msg[] = '在庫数の変更に失敗しました。';
    }
    return array($this->success_msg, $this->err_msg);
  }

  public function reduce_item_stock ( int $num, int $id ) {
    $db = $this->db;
    try {
      $db->beginTransaction();
      $stmt = $db->prepare('UPDATE stock_info SET stock_num = :stock WHERE item_id = :id');
      $stmt->bindValue(':stock', $num, PDO::PARAM_INT);
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $db->commit();
    } catch ( PDOException $e ) {
      $db->rollBack();
    }
  }

  public function update_item_status ( $input ) {
    $db = $this->db;
    $reverse_status = (int)$input['reverse-status'];
    $item_id = (int)$input['item-id'];
    try {
      $db->beginTransaction();
      $stmt = $db->prepare('UPDATE item_info SET public_status = :status WHERE id = :id');
      $stmt->bindValue(':status', $reverse_status, PDO::PARAM_INT);
      $stmt->bindValue(':id', $item_id, PDO::PARAM_INT);
      $stmt->execute();
      $db->commit();
      $this->success_msg[] = 'ステータスを変更しました。';
    } catch ( PDOException $e ) {
      $db->rollBack();
      $this->err_msg[] = 'ステータスの変更に失敗しました。';
    }
    return array($this->success_msg, $this->err_msg);
  }

  public function delete_product_data ( $input ) {
    $db = $this->db;
    $item_id = (int)$input['item-id'];
    try {
      $db->beginTransaction();
      $sql = "DELETE i, s
              FROM item_info as i
              JOIN stock_info as s
              ON i.id = s.item_id
              WHERE i.id = :id
              AND s.item_id = :id";

      $stmt = $db->prepare( $sql );
      $stmt->bindValue(':id', $item_id, PDO::PARAM_INT);
      // ON DELETE => CASCADE
      $stmt->execute();
      $db->commit();
    } catch ( PDOException $e ) {
      $db->rollBack();
      echo $e->getMessage();
    }
  }

  public function delete_selected_item ( int $id ) {
    $db = $this->db;
    try {
      $db->beginTransaction();
      $sql = "DELETE FROM cart_info WHERE id = :id";
      $stmt = $db->prepare( $sql );
      $stmt->bindValue(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      $db->commit();
      $this->success_msg[] = '削除しました。';
    } catch ( PDOException $e ) {
      $db->rollBack();
      echo $e->getMessage();
    }
    return $this->success_msg;
  }

  public function update_selected_item_num ( $input ) {
    $db = $this->db;
    $cart_item_id = (int)$input['selected-item-id'];
    $update_num = (int)$input['selected-item-num'];
    try {
      $db->beginTransaction();
      $stmt = $db->prepare('UPDATE cart_info SET amount_num = :num WHERE id = :id');
      $stmt->bindValue(':num', $update_num, PDO::PARAM_INT);
      $stmt->bindValue(':id', $cart_item_id, PDO::PARAM_INT);
      $stmt->execute();
      $db->commit();
      $this->success_msg[] = '選択したアイテム数を更新しました。';
    } catch ( PDOException $e ) {
      $db->rollBack();
      $this->err_msg[] = '選択したアイテム数の更新に失敗しました。';
    }
    return array($this->success_msg, $this->err_msg);
  }

}
