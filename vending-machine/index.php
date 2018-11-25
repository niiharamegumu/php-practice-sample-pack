<?php

$err_msg = array();
$public_drink_list = array();
$public_status = 1;
$host = '';
$user = '';
$pw = '';
$dbName = '';


$link = mysqli_connect($host, $user, $pw, $dbName);

if ( $link ) {
  mysqli_set_charset($link, 'UTF8');
  $sql = "SELECT drink_info.drink_id,
                 drink_info.drink_name,
                 drink_info.img_path,
                 drink_info.drink_price,
                 stock_info.stock_num,
                 drink_info.public_status
          FROM drink_info
          JOIN stock_info
          ON drink_info.drink_id = stock_info.drink_id
          WHERE public_status = " . $public_status;
  if ( $result = mysqli_query( $link, $sql ) ) {
    while ( $row = mysqli_fetch_array( $result ) ) {
      $public_drink_list[] = $row;
    }
  }
  mysqli_free_result( $result );
  mysqli_close( $link );

} else {
  $err_msg[] = 'DBに接続できていません。';
}

?>
<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>自動販売機</title>
</head>
<body>

  <div class="purchase-wrapper">
    <h1>購入ページ</h1>

    <section class="vending-machine">
      <h2>自動販売機</h2>

      <form method="post" action="result.php">

        <label for="">投入金額</label>：
        <input type="text" name="input-amount">円 *半角数字<br>
        <div class="product-list-wrapper">
          <ul class="drink">
            <?php foreach ( $public_drink_list as $public_drink ) : ?>
              <li>
                <span><img src="./images/<?php echo $public_drink['img_path']; ?>"></span><br>
                <span><?php echo $public_drink['drink_name']; ?></span><br>
                <span><?php echo $public_drink['drink_price']; ?>円</span><br>
                <?php if ( (int)$public_drink['stock_num'] === 0 ) : ?>
                  <span>売り切れ</span>
                <?php else : ?>
                  <input type="radio" name="drink-id" value="<?php echo $public_drink['drink_id']; ?>">
                <?php endif; ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
        <input type="submit" name="submit-purchase" value="購入">

      </form>

    </section>

  </div>

</body>
</html>
