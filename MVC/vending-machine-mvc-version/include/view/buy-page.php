<!DOCTYPE HTML>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>自動販売機</title>
</head>
<body>

  <div class="purchase-wrapper">
    <h1>購入ページ</h1>
    <?php if ( count($err_msg) > 0 ) : ?>
      <ul>
        <?php foreach ( $err_msg as $err ) : ?>
          <li><?php echo $err; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>
    <section class="vending-machine">
      <h2>自動販売機</h2>

      <form method="post" action="buy-result.php">

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
