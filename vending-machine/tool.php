<?php
$err_msg = array();
$success_msg = array();
$msgs = array();
$drink_data_list = array();
$reverse = 0;
$host = '';
$user = '';
$pw = '';
$dbName = '';


$link = mysqli_connect($host, $user, $pw, $dbName);

if ( $link ) {
  mysqli_set_charset($link, 'UTF8');
  if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
    mysqli_autocommit($link, false);


    switch ( $_POST['submit-type'] ) {


      case 'add-item':
        $drink_name = Null;
        $drink_price = Null;
        $stock_num = Null;
        $status = Null;

        if ( !isset( $_POST['drink-name'] ) || preg_match("/^(\s|　)+$/", $_POST['drink-name']) ) {
          $err_msg[] = '名前が空です。';
        } else {
          $drink_name = $_POST['drink-name'];
        }

        if ( !isset( $_POST['drink-price'] ) || preg_match("/^(\s|　)+$/", $_POST['drink-price']) ) {
          $err_msg[] = '値段が空です。';
        } elseif ( !preg_match('/^[0-9]+$/', $_POST['drink-price'] ) ) {
          $err_msg[] = '値段は、0以上の整数でお願いします。';
        } else {
          $drink_price = $_POST['drink-price'];
        }

        if ( !isset( $_POST['stock-num'] ) || preg_match("/^(\s|　)+$/", $_POST['stock-num']) ) {
          $err_msg[] = '個数が空です。';
        } elseif ( !preg_match('/^[0-9]+$/', $_POST['stock-num'] ) ) {
          $err_msg[] = '個数は、0以上の整数でお願いします。';
        } else {
          $stock_num = $_POST['stock-num'];
        }

        if ( !preg_match( '/^[01]$/', $_POST['status'] ) ) {
          $err_msg[] = 'ステータスは 0 or 1　の整数でお願いします。';
        } else {
          $status = $_POST['status'];
        }

        $temp_file = $_FILES['drink-image']['tmp_name'];

        if (is_uploaded_file($temp_file)) {
          $file_name = "./images/" . $_FILES['drink-image']['name'];
          $ext = "." . pathinfo($file_name, PATHINFO_EXTENSION);
          $img_path = md5(uniqid()) . $ext;
          if ( !preg_match( '/\.png$|\.jpg$|\.jpeg$/i', $ext ) ) {
            $err_msg[] = '画像の拡張子は、.jpg or .png でお願いします。';
          } elseif ( move_uploaded_file($temp_file, $file_name ) ) {
            rename($file_name, "./images/" . $img_path);
          } else {
            $err_msg[] = "画像アップロード・保存ができませんでした。";
          }
        } else {
          $err_msg[] = "ファイルが選択されていません。";
        }

        if ( count( $err_msg ) === 0 ) {
          $data = array(
            'drink_name'  => $drink_name,
            'img_path'    => $img_path,
            'drink_price' => $drink_price,
            'status'      => $status
          );

          $sql = "INSERT INTO drink_info (drink_name, img_path, drink_price, public_status)
                  VALUES('" . implode("','", $data) . "')";
          if ( !mysqli_query($link, $sql) ) {
            $err_msg[] = 'drink_info error!';
          }
          $drink_insert_id = mysqli_insert_id($link);

          $sql = "INSERT INTO stock_info (drink_id, stock_num)
                  VALUES (" . $drink_insert_id . "," . $stock_num . ")";
          if ( !mysqli_query( $link, $sql ) ) {
            $err_msg[] = 'stock_info error!';
          }
        }

        if ( count($err_msg) === 0 ) {
          $success_msg[] = 'ドリンクを追加しました';
        }
        break;


      case 'stock-update':
        $drink_id = (int)$_POST['drink-id'];

        if ( !isset( $_POST['stock-update-num'] ) || mb_strlen( $_POST['stock-update-num'] ) === 0 ) {
          $err_msg[] = '在庫数が空です。';
        } elseif ( !preg_match('/^[0-9]+$/', $_POST['stock-update-num'] ) ) {
          $err_msg[] = '在庫数は、0以上の整数でお願いします。';
        } else {
          $stock_update_num = $_POST['stock-update-num'];
        }

        if ( count( $err_msg )  === 0 ) {
          $sql = "UPDATE stock_info
                  SET stock_num = " . $stock_update_num .  " WHERE drink_id = " . $drink_id;
          if ( !mysqli_query( $link, $sql ) ) {
            $err_msg[] = "在庫数のアップデートに失敗しました。";
          }
        }

        if ( count($err_msg) === 0 ) {
          $success_msg[] = '在庫数を変更しました';
        }
        break;


      case 'change-status':
        $drink_id = (int)$_POST['drink-id'];
        $reverse_status = (int)$_POST['reverse-status'];

        $sql = "UPDATE drink_info
                SET public_status = " . $reverse_status .  " WHERE drink_id = " . $drink_id;
        if ( !mysqli_query( $link, $sql ) ) {
          $err_msg[] = "ステータスの変更ができませんでした。";
        }

        if ( count($err_msg) === 0 ) {
          $success_msg[] = 'ステータスを変更しました';
        }
        break;
    }

    if ( count($err_msg) > 0 ) {
      mysqli_rollback($link);
      $msgs = $err_msg;
    } elseif ( count($success_msg) > 0 ) {
      mysqli_commit( $link );
      $msgs = $success_msg;
    } else {
      header( 'Location: http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] );
    }


  }


  $sql = "SELECT drink_info.drink_id,
                 drink_info.drink_name,
                 drink_info.img_path,
                 drink_info.drink_price,
                 stock_info.stock_num,
                 drink_info.public_status
          FROM drink_info
          JOIN stock_info
          ON drink_info.drink_id = stock_info.drink_id";
  if ( $result = mysqli_query( $link, $sql ) ) {
    while ( $row = mysqli_fetch_array( $result ) ) {
      // $row --> Sanitizing をすること
      $drink_data_list[] = $row;
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
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <div class="administration-wrapper">
    <h1>管理ページ</h1>
    <?php if ( count($msgs) > 0 ) : ?>
      <ul>
        <?php foreach ( $msgs as $msg ) : ?>
          <li><?php echo $msg; ?></li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <section class="addition" action="tool.php">
      <h2>新規商品の追加</h2>
      <form method="post" enctype="multipart/form-data" action="tool.php">
        <label for="drink-name">名前</label>：
        <input type="text" name="drink-name" value="" id="drink-name"><br>

        <label for="drink-price">値段</label>：
        <input type="text" name="drink-price" value="" id="drink-price"><br>

        <label for="stock-num">個数</label>：
        <input type="text" name="stock-num" value="" id="stock-num"><br>

        <input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
        <input type="file" name="drink-image"><br>

        <select name="status">
          <option value="0">非公開</option>
          <option value="1">公開</option>
        </select><br>

        <input type="hidden" name="submit-type" value="add-item">
        <input type="submit" value="商品の追加">
      </form>
    </section>

    <section class="information-change">
      <h2>商品情報の変更</h2>
      <table>
        <caption>商品一覧</caption>

        <thead>
          <tr>
            <th colspan="col">商品画像</th>
            <th colspan="col">商品名</th>
            <th colspan="col">価格</th>
            <th colspan="col">在庫数</th>
            <th colspan="col">ステータス</th>
          </tr>
        </thead>

        <tbody>
          <?php foreach ( $drink_data_list as $drink_data ) : ?>
            <tr>
              <td><img src="./images/<?php echo $drink_data['img_path'] ?>"></td>
              <td><?php echo $drink_data['drink_name'] ?></td>
              <td><?php echo $drink_data['drink_price'] ?></td>

              <form method="post" action="tool.php">
                <td>
                  <input type="text" name="stock-update-num" value="<?php echo $drink_data['stock_num'] ?>">個<br>
                  <input type="submit" value="変更">
                </td>
                <input type="hidden" name="drink-id" value="<?php echo $drink_data['drink_id'] ?>">
                <input type="hidden" name="submit-type" value="stock-update">
              </form>

              <form method="post" action="tool.php">
                <td>
                  <?php if (  (int)$drink_data['public_status'] === 1 ) : ?>
                    <input type="submit" value="公開→非公開">
                    <?php $reverse = 0; ?>
                  <?php else : ?>
                    <input type="submit" value="非公開→公開">
                    <?php $reverse = 1; ?>
                  <?php endif; ?>
                </td>
                <input type="hidden" name="reverse-status" value="<?php echo $reverse ?>">
                <input type="hidden" name="drink-id" value="<?php echo $drink_data['drink_id'] ?>">
                <input type="hidden" name="submit-type" value="change-status">
              </form>

            </tr>
          <?php endforeach; ?>
        </tbody>

      </table>
    </section>

  </div>

</body>
</html>
