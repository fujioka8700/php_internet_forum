<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>会員登録完了</title>
  </head>
  <body>
      <?php
      // デバッグ
      print_r($_SESSION);
      ?>
      <h1>会員登録完了</h1>
      <a href="./registration.php">戻る</a>
  </body>
</html>