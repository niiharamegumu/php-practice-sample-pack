<?php

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

      <form method="post">
        <label for="">投入金額</label>：
        <input type="text" name="input-amount"><br>
        <div class="product-list-wrapper">
          <ul class="drink">
            <?php  ?>
            <li>
              <span>ここは画像です</span><br>
              <span>XXX</span><br>
              <span>XXX円</span><br>
              <input type="radio" name="drink-id" value="">
            </li>
            <?php  ?>
          </ul>
        </div>
        <input type="submit" name="submit-purchase" value="購入">
      </form>

    </section>

  </div>

</body>
</html>
