<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="./css/style.css">
  </head>
  <body>
    <div class="wrapper">
      <h1>ユーザー管理ページ</h1>

      <nav class="global-nav">
        <ul>
          <li><a href="logout.php">ログアウト</a></li>
          <li><a href="admin-side.php">商品管理ページ</a></li>
        </ul>
      </nav>

      <section class="user-list">
        <h2>ユーザー情報一覧</h2>
        <table>
          <thead>
            <tr>
              <th>ユーザー名</th>
              <th>登録日時</th>
            </tr>
          </thead>
          <tbody>
            <?php if ( count($users) > 0 ) : ?>
              <?php foreach ( $users as $user ) : ?>
                <tr>
                  <td><?php echo $user['user_name']; ?></td>
                  <td><?php echo $user['created_date']; ?></td>
                </tr>
              <?php endforeach; ?>
            <?php endif; ?>
          </tbody>
        </table>
      </section>

    </div>
  </body>
</html>
