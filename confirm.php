<?php
session_start();
include_once('./member_property.php');

if (!isset($_SESSION['join'])) {
  header('Location: ./registration.php');
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>会員情報確認画面</title>
  </head>
  <body>
      <?php
      // デバッグ
      ?>
      <h1>会員情報確認画面</h1>
      <p>name: <?php echo $name; ?></p>
      <p>email: <?php echo $email; ?></p>
      <p>パスワード: [セキュリティのため非表示]</p>
      <input type="button" onclick="location.href='./registration.php'" value="修正する">
      <input type="button" onclick="location.href='./register.php'" value="登録する">
  </body>
</html>