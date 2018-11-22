<?php
// DB connect.
$err_msg = array();
$drink_data_list = array();
$host = 'localhost';
$user = 'root';
$pw = 'root';
$dbName = 'vending_machine';


$link = mysqli_connect($host, $user, $pw, $dbName);
if ( $link ) {
  mysqli_set_charset($link, 'UTF8');
  if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    $drink_name = $_POST['drink-name'];
    $drink_price = $_POST['drink-price'];
    $stock_num = $_POST['stock-num'];
    $status = $_POST['status'];
    // Image File Upload.
    $temp_file = $_FILES['drink-image']['tmp_name'];
    $file_name = "./images/" . $_FILES['drink-image']['name'];
    $ext = "." . pathinfo($file_name, PATHINFO_EXTENSION);
    $img_path = md5(uniqid()) . $ext;
    if (is_uploaded_file($temp_file)) {
      if ( move_uploaded_file($temp_file, $file_name ) ) {
        rename($file_name, "./images/" . $img_path);
      } else {
        $err_msg[] = "画像アップロード・保存ができませんでした。";
      }
    } else {
      $err_msg[] = "ファイルが選択されていません。";
    }

    $data = array(
      'drink_name'  => $drink_name,
      'img_path'    => $img_path,
      'drink_price' => $drink_price,
      'status'      => $status
    );

    mysqli_autocommit($link, false);


    //　Add drink-name,drink-price,status.
    $sql = "INSERT INTO drink_info (drink_name, img_path, drink_price, public_status) VALUES('" . implode("','", $data) . "')";
    if ( !mysqli_query($link, $sql) ) {
      $err_msg[] = 'drink_info error!';
    }
    $drink_insert_id = mysqli_insert_id($link);


    // Add drink_id(stock_info),stock-num.
    $sql = "INSERT INTO stock_info (drink_id, stock_num) VALUES (" . $drink_insert_id . "," . $stock_num . ")";
    if ( !mysqli_query( $link, $sql ) ) {
      $err_msg[] = 'stock_info error!';
    }
    // Transaction.
    if (count($err_msg) === 0) {
      mysqli_commit($link);
    } else {
      mysqli_rollback($link);
    }

    header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
  }


  $sql = "SELECT drink_info.drink_id,
                 drink_info.drink_name,
                 drink_info.img_path,
                 drink_info.drink_price,
                 stock_info.stock_num,
                 drink_info.public_status
          FROM drink_info
          JOIN stock_info
          ON drink_info.drink_id = stock_info.drink_id";
  if ( $result = mysqli_query( $link, $sql ) ) {
    while ( $row = mysqli_fetch_array( $result ) ) {
      $drink_data_list[] = $row;
    }
  }
  mysqli_free_result( $result );
  mysqli_close( $link );

} else {
  $err_msg[] = 'DBに接続できていません。';
}
var_dump($err_msg);
?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>自動販売機</title>
</head>
<body>

  <div class="administration-wrapper">
    <h1>管理ページ</h1>

    <section class="addition" action="tool.php">
      <h2>新規商品の追加</h2>
      <form method="post" enctype="multipart/form-data" action="tool.php">
        <label for="drink-name">名前</label>：
        <input type="text" name="drink-name" value="" id="drink-name"><br>

        <label for="drink-price">値段</label>：
        <input type="text" name="drink-price" value="" id="drink-price"><br>

        <label for="stock-num">個数</label>：
        <input type="text" name="stock-num" value="" id="stock-num"><br>

        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
        <input type="file" name="drink-image"><br>

        <select name="status">
          <option value="0">非公開</option>
          <option value="1">公開</option>
        </select><br>

        <input type="hidden" name="submit-type" value="add-item">
        <input type="submit" name="submit-addition" value="商品の追加">
      </form>
    </section>

    <section class="information-change">
      <h2>商品情報の変更</h2>
      <table>
        <caption>商品一覧</caption>
        <thead>
          <tr>
            <th colspan="col">商品画像</th>
            <th colspan="col">商品名</th>
            <th colspan="col">価格</th>
            <th colspan="col">在庫数</th>
            <th colspan="col">ステータス</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ( $drink_data_list as $drink_data ) : ?>
            <tr>
              <td><img src="./images/<?php echo $drink_data['img_path'] ?>"></td>
              <td><?php echo $drink_data['drink_name'] ?></td>
              <td><?php echo $drink_data['drink_price'] ?></td>
              <td><?php echo $drink_data['stock_num'] ?></td>
              <td><?php echo $drink_data['public_status'] ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </section>

  </div>

</body>
</html>
