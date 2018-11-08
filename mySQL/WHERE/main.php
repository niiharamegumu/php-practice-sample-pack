<?php
$emp_data = array();
$emp = '';
if ( isset($_GET['emp']) ) {
  $emp = $_GET['emp'];
}
$host = '';
$username = '';
$passwd = '';
$dbname = '';
$link = mysqli_connect( $host, $username, $passwd, $dbname );

if ( $link ) {
  mysqli_set_charset( $link, 'utf8' );
  if ( $emp && $emp !== 'all' ) {
    $query = "SELECT * FROM emp_table WHERE job = " . "'" .$emp . "'";
  } else {
    $query = "SELECT * FROM emp_table";
  }
  echo $query;
  $result = mysqli_query( $link, $query );
  while ( $row = mysqli_fetch_array( $result ) ) {
    $emp_data[] = $row;
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
    <h1>職種一覧</h1>
    <form>
      <select name="emp">
      <option value="all">全員</option>
      <option value="manager">マネージャー</option>
      <option value="analyst">アナリスト</option>
      <option value="clerk">一般職</option>
      </select>
      <input type="submit" value="表示">
    </form>
    <table>
      <tr>
        <th>社員番号</th>
        <th>名前</th>
        <th>職種</th>
        <th>年齢</th>
      </tr>
      <?php foreach ( $emp_data as $value ) : ?>
        <tr>
          <td><?php echo htmlspecialchars( $value['emp_id'], ENT_QUOTES, 'UTF-8' ) ?></td>
          <td><?php echo htmlspecialchars( $value['emp_name'], ENT_QUOTES, 'UTF-8' ) ?></td>
          <td><?php echo htmlspecialchars( $value['job'], ENT_QUOTES, 'UTF-8' ) ?></td>
          <td><?php echo htmlspecialchars( $value['age'], ENT_QUOTES, 'UTF-8' ) ?></td>
        </tr>
      <?php endforeach; ?>
    </table>

  </body>
</html>
