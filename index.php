<?php
include_once('./dbconnect.php');

if (!empty($_GET)) {
    $email = $_GET['email'];
    $statement = $pdo->prepare('SELECT * FROM members WHERE email=:email');
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $member = $statement->fetch(PDO::FETCH_ASSOC);

    if ($_GET['password'] == $member['password']) {
        $_SESSION['id'] = $member['id'];
        $_SESSION['time'] = time();
        header('Location: ./forum.php');
    }
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>犬・猫 どちら派掲示板</title>
  </head>
  <body>
      <?php
      print_r($member);
      echo time();
      ?>
      <h1>犬・猫 どちら派掲示板</h1>
      <form action="./index.php" method="get">
          <p>email<input type="email" name="email" id="" value="a@a.com"></p>
          <p>パスワード<input type="password" name="password" id="" value="a"></p>
          <input type="submit" value="ログインする">
      </form>
  </body>
</html>