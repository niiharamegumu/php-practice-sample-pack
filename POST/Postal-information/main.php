<?php
$fileName = './miyazaki.csv';

$data = array();

if ( $fp = fopen( $fileName, 'r' ) ) {
  while ( $tmp = fgetcsv( $fp ) ) {
    $data[] = $tmp;
  }
} else {
  echo 'ファイルが読み込めません。';
}
fclose( $fp );



?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ファイル操作</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>宮崎県の郵便情報</h1>
  <table>
    <thead>
      <tr><th>郵便番号</th><th>都道府県</th><th>市区町村</th><th>町域</th></tr>
    </thead>
    <?php foreach ($data as $value): ?>
      <?php
        preg_match('/[0-9]{3}/', $value[2],$pre);
        preg_match('/[0-9]{4}$/', $value[2],$after);
        $html = '';
        $html .= '<tr>';
        $html .= '<td>' . $pre[0] . '-' . $after[0] . '</td>';
        $html .= '<td>' . $value[6] . '</td>';
        $html .= '<td>' . $value[7] . '</td>';
        $html .= '<td>' . $value[8] . '</td>';
        $html .= '</tr>';
        echo $html;
      ?>
    <?php endforeach; ?>
  </table>
</body>
</html>
