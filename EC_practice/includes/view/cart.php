<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  </head>
  <body>
    <div class="wrapper">
      <h1>ショッピングカート</h1>

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

      <div class="selected-items">
        <?php if ( count($items) > 0 ) : ?>
          <ul>
            <?php foreach ( $items as $item ) : ?>
              <li>
                <img src="./images/<?php echo $item['item_img']; ?>"><br>
                <span><?php echo $item['item_name']; ?></span><br>
                <span><?php echo $item['item_price']; ?>円</span>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="text" name="selected-item-num" value="<?php echo $item['amount_num']; ?>">
                  <input type="submit" value="変更">
                  <input type="hidden" name="submit-type" value="update-selected-item">
                  <input type="hidden" name="selected-item-id" value="<?php echo $item['id']; ?>">
                </form>

                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <input type="submit" value="削除">
                  <input type="hidden" name="submit-type" value="delete-selected-item">
                  <input type="hidden" name="selected-item-id" value="<?php echo $item['id']; ?>">
                </form>

              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>

      <section class="total-fee">
        合計：<span><?php echo $total; ?>円</span>
      </section>

      <section>
        <?php if ( count($items) > 0 ) : ?>
          <form method="post" action="./user-side-purchase-comp.php">
            <input type="submit" value="購入する">
            <input type="hidden" name="total-fee" value="<?php echo $total; ?>">
          </form>
        <?php endif; ?>
      </section>
    </div>

  </body>
</html>
