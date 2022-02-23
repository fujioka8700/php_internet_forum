<?php
session_start();
include_once('./dbconnect.php');

function email_exists($pdo, $email) {
    $statement = $pdo->prepare('SELECT COUNT(id) FROM members WHERE email=:email');
    $statement->bindValue(':email', $email, PDO::PARAM_STR);
    $statement->execute();
    $count = $statement->fetch(PDO::FETCH_ASSOC);
    unset($pdo);
    if ($count['COUNT(id)'] > 0) {
        return 'duplicate';
    }
}

function is_empty($s) {
    if ($_GET[$s] == "") {
        return 'blank';
    }
}

function is_no_error($error) {
    $judge = array_filter($error);
    if (empty($judge)) {
        $_SESSION['join'] = $_GET;
        header('Location: ./confirm.php'); 
    }
}

if (!empty($_GET)) {
    $error['email'] = is_empty('email');

    if ($error['email'] != 'blank') {
        $error['email'] = email_exists($pdo, $_GET['email']);
    }

    $error['password'] = is_empty('password');

    is_no_error($error);
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>会員登録画面</title>
  </head>
  <body>
      <?php
      // デバッグ
    //   echo $error['email'];
      ?>
      <h1>会員登録画面</h1>
      <form action="./registration.php" method="get">
          <?php if($error['email'] == "blank"): ?>
            <p>emailを入力してください。</p>
          <?php elseif($error['email'] == "duplicate"): ?>
            <p>emailが登録されています。</p>
          <?php endif; ?>
          <p>email<input type="email" name="email" id=""></p>
          <?php if($error['password'] == "blank"): ?>
            <p>パスワードを入力してください。</p>
          <?php endif; ?>
          <p>パスワード<input type="password" name="password" id=""></p>
          <input type="submit" value="登録">
      </form>
  </body>
</html>