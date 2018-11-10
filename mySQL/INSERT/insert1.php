<?php
$goods_data = array();
$goods_name = '';
$price = 0;

if ( isset($_POST['goods_name']) && isset($_POST['price']) ) {
  $goods_name = "'" . $_POST['goods_name'] . "'";
  $price = (int)$_POST['price'];
}
$host = '';
$username = '';
$passwd = '';
$dbname = '';
$link = mysqli_connect( $host, $username, $passwd, $dbname );

if ( $link ) {
  mysqli_set_charset( $link, 'utf8' );
  $query_select = "SELECT goods_name, price FROM goods_table";

  if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    if ( $goods_name && $price ) {
      $query_insert = "INSERT INTO goods_table (goods_name, price) VALUES (" . $goods_name . "," . $price . ")";
      mysqli_query( $link, $query_insert );
    }
    header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
    exit;
  }

  $result = mysqli_query( $link, $query_select );
  while ( $row = mysqli_fetch_array( $result ) ) {
    $goods_data[] = $row;
  }

  mysqli_free_result( $result );
  mysqli_close( $link );

} else {
  echo '接続できていません';
}

?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>商品一覧</h1>
    <form method="post" action="main.php">
      商品名:<input type="text" name="goods_name"><br>
      価格:<input type="text" name="price"><br>
      <input type="submit" value="追加">
    </form>
    <table>
      <thead>
        <tr>
          <th>商品名</th>
          <th>価格</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ( $goods_data as $value ) : ?>
          <tr>
            <td><?php echo htmlspecialchars( $value['goods_name'], ENT_QUOTES, 'UTF-8' ) ?></td>
            <td><?php echo htmlspecialchars( $value['price'], ENT_QUOTES, 'UTF-8' ) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

  </body>
</html>
