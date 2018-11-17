<?php
$host = 'xxx';
$user = 'xxx';
$passwd = 'xxx';
$dbname = 'xxx';
$customer_id = 1;
$message = '';
$point = 0;
$err_msg = array();
$point_gift_list = array();


if ($link = mysqli_connect($host, $user, $passwd, $dbname)) {
  mysqli_set_charset($link, 'UTF8');
  $sql = 'SELECT point FROM point_customer_table WHERE customer_id = ' . $customer_id;

  if ($result = mysqli_query($link, $sql)) {
    $row = mysqli_fetch_assoc($result);
    if (isset($row['point'])) {
      $point = $row['point'];
    }
  } else {
    $err_msg[] = 'SQL失敗:' . $sql;
  }
  mysqli_free_result($result);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = date('Y-m-d H:i:s');
    $point_gift_id = (int)$_POST['point_gift_id'];
    $gift_point = 0;
    mysqli_autocommit($link, false);

    $sql = "SELECT point FROM point_gift_table WHERE point_gift_id = " . $point_gift_id;
    if ($result = mysqli_query($link, $sql)) {
      $row = mysqli_fetch_assoc($result);

      if (isset($row['point'])) {
        $gift_point = $row['point'];
      }

      $data = array(
        'customer_id'   => $customer_id,
        'point_gift_id' => $point_gift_id,
        'created_at'    => $date
      );
      $sql = "INSERT INTO point_history_table (customer_id, point_gift_id, created_at) VALUES('" . implode("','", $data) . "')";

      if (mysqli_query($link, $sql)) {
        $remainder = $point - $gift_point;
        $sql = "UPDATE point_customer_table SET point =" . $remainder . " WHERE customer_id =" . $customer_id;

        if (!mysqli_query($link, $sql)) {
          $err_msg[] = 'point_customer_table: updateエラー:' . $sql;
        }
      } else {
        $err_msg[] = 'point_history_table: insertエラー:' . $sql;
      }

    } else {
      $err_msg[] = 'point_gift_id: selectエラー:' . $sql;
    }
    if (count($err_msg) === 0) {
      mysqli_commit($link);
    } else {
      mysqli_rollback($link);
    }
  header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
  }

  $sql = 'SELECT point_gift_id, name, point FROM point_gift_table';
  if ($result = mysqli_query($link, $sql)) {
    $i = 0;
    while ($row = mysqli_fetch_assoc($result)) {
      $point_gift_list[$i]['point_gift_id'] = htmlspecialchars($row['point_gift_id'], ENT_QUOTES, 'UTF-8');
      $point_gift_list[$i]['name']       = htmlspecialchars($row['name'],       ENT_QUOTES, 'UTF-8');
      $point_gift_list[$i]['point']      = htmlspecialchars($row['point'],      ENT_QUOTES, 'UTF-8');
      $i++;
    }
  } else {
    $err_msg[] = 'SQL失敗:' . $sql;
  }
  mysqli_free_result($result);
  mysqli_close($link);

} else {
   $err_msg[] = 'error: ' . mysqli_connect_error();
}
