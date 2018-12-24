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
      <h1>商品一覧</h1>
      <p>User Name：<?php echo $_SESSION['user_name']; ?></p>

      <nav class="global-nav">
        <ul>
          <li><a href="logout.php">ログアウト</a></li>
          <li>
            <a href="user-side-cart.php">
              <span style="font-size: 38px; color: #3330b5;">
                <i class="fas fa-shopping-cart"></i>
              </span>
            </a>
          </li>
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

      <div class="product-list">
        <?php if ( count($public_products) > 0 ) : ?>
          <ul>
            <?php foreach ( $public_products as $product ) : ?>
              <li>
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                  <span><img src="./images/<?php echo $product['item_img']; ?>"></span><br>
                  <span>商品名：<?php echo $product['item_name']; ?></span><br>
                  <span>値段：¥<?php echo $product['item_price']; ?></span><br>
                  <?php if ( (int)$product['stock_num'] > 0 ) : ?>
                    <input type="submit" value="カートに入れる">
                    <input type="hidden" name="submit-type" value="insert-cart">
                    <input type="hidden" name="item-id" value="<?php echo $product['id']; ?>">
                  <?php else : ?>
                    <span>売り切れ</span>
                  <?php endif; ?>
                </form>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php endif; ?>
      </div>

    </div>
  </body>
</html>
