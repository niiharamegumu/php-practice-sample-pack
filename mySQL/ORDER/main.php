<?php
$goods_data = array();
$order = 'ASC';
if ( isset($_GET['order']) ) {
  $order = $_GET['order'];
}

$host = '';
$username = '';
$passwd = '';
$dbname = '';
$link = mysqli_connect( $host, $username, $passwd, $dbname );

if ( $link ) {
  mysqli_set_charset( $link, 'utf8' );
  $query = "SELECT `goods_name`, `price` FROM `goods_table` ORDER BY price " . $order;
  $result = mysqli_query( $link, $query );

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
    <link rel="stylesheet" href="style.css">
    <title></title>
  </head>
  <body>
    <h1>商品一覧</h1>
    <form>
      <input type="radio" name="order" value="ASC" <?php if ( $order === 'ASC' ) { echo 'checked'; } ?>>昇順
      <input type="radio" name="order" value="DESC" <?php if ( $order === 'DESC' ) { echo 'checked'; } ?>>降順
      <input type="submit" value="表示">
    </form>
    <table>
      <tr>
        <th>商品名</th>
        <th>値段</th>
      </tr>
      <?php foreach ( $goods_data as $value ) : ?>
        <tr>
          <td><?php echo htmlspecialchars( $value['goods_name'], ENT_QUOTES, 'UTF-8' ) ?></td>
          <td><?php echo htmlspecialchars( $value['price'], ENT_QUOTES, 'UTF-8' ) ?></td>
        </tr>
      <?php endforeach; ?>
    </table>

  </body>
</html>
