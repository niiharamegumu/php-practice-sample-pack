<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <div class="wrapper">
      <h1>購入完了ページ</h1>
      <p>User Name：<?php echo $_SESSION['user_name']; ?></p>

      <nav class="global-nav">
        <ul>
          <li><a href="./logout.php">ログアウト</a></li>
          <li><a href="user-side-product-list.php">商品一覧ページへ</a></li>
        </ul>
      </nav>

      <?php if ( count($messages) > 0 ) : ?>
        <div class="message-wrapper">
          <ul>
            <?php foreach ( $messages as $message ) : ?>
              <li><?php echo $message; ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <div class="purchase-comp">
        <?php if ( count($items) > 0 ) : ?>
          <h2>ご購入ありがとうございます！</h2>
          <ul>
            <?php foreach ( $items as $item ) : ?>
              <li>
                <img src="./images/<?php echo $item['item_img']; ?>"><br>
                商品名：<span><?php echo $item['item_name']; ?></span><br>
                値段：<span><?php echo $item['item_price']; ?>円</span><br>
                個数：<span><?php echo $item['amount_num']; ?>個</span>
              </li>
            <?php endforeach; ?>
          </ul>

          <section class="total-fee">
            合計：<span><?php echo $input['total-fee']; ?>円</span>
          </section>
        <?php endif; ?>
      </div>

    </div>
  </body>
</html>
