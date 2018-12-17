<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">
  </head>
  <body>
    <h1>ショッピングカート</h1>
    <p>User Name: <?php echo $_SESSION['user_name']; ?></p>
    <nav>
      <ul>
        <li><a href="logout.php">ログアウト</a></li>
        <li>
          <a href="user-side-cart.php">
            <span style="font-size: 48px; color: #00e;">
              <i class="fas fa-shopping-cart"></i>
            </span>
          </a>
        </li>
      </ul>
    </nav>

    <?php if ( count($messages) > 0 ) : ?>
      <ul>
        <?php foreach ( $messages as $message ) : ?>
          <li><?php echo $message; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <div class="selected-items">
      <?php if ( count($items) > 0 ) : ?>
      <ul>
        <?php foreach ( $items as $item ) : ?>
          <li>
            <img src="./images/<?php echo $item['item_img']; ?>">
            <span><?php echo $item['item_name']; ?></span>
            <span><?php echo $item['item_price']; ?>円</span>
            <span><?php echo $item['amount_num']; ?>個</span>
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
    <section>
      合計<span><?php echo $total; ?>円</span>
    </section>

  </body>
</html>
