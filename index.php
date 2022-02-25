<?php
session_start();
include_once('./dbconnect.php');

// ログアウトしてきた時の処理
if (isset($_SESSION['id'])) {
    session_destroy();
}

if (!empty($_POST)) {
    if (($_POST['email'] != '') && ($_POST['password'] != '')) {
        $email = $_POST['email'];
        $statement = $pdo->prepare('SELECT * FROM members WHERE email=:email');
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $member = $statement->fetch(PDO::FETCH_ASSOC);
    
        if ($_POST['password'] == $member['password']) {
            $_SESSION['id'] = $member['id'];
            $_SESSION['time'] = time();
            header('Location: ./forum.php');
        } else {
            $error['login'] = 'failed';
        }
    } else {
        $error['login'] = 'blank';
    }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico">
    <title>犬・猫 どちら派掲示板</title>
  </head>
  <body>
      <?php
      // デバッグ
      // print_r($member);
      // print_r($_COOKIE);
      // print_r($_SESSION);
      ?>
      <h1>犬・猫 どちら派掲示板</h1>
      <?php if ($error['login'] == 'blank'): ?>
        <p>メールとパスワードを入力してください。</p>
      <?php elseif ($error['login'] == 'failed'): ?>
        <p>メールとパスワードが間違っています。</p>
      <?php endif ?>
      <form action="./index.php" method="post">
          <p>email<input type="email" name="email" id=""></p>
          <p>パスワード<input type="password" name="password" id=""></p>
          <input type="submit" value="ログインする">
      </form>
      <p>会員登録は<a href="./registration.php">こちら</a></p>
  </body>
</html>