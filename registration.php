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

function is_empty_member($s) {
    if ($_POST[$s] == "") {
        return 'blank';
    }
}

function is_no_error($error) {
    $judge = array_filter($error);
    if (empty($judge)) {
        $_SESSION['join'] = $_POST;
        header('Location: ./confirm.php'); 
    }
}

if (!empty($_POST)) {
    $error['name'] = is_empty_member('name');

    $error['email'] = is_empty_member('email');

    if ($error['email'] != 'blank') {
        $error['email'] = email_exists($pdo, $_POST['email']);
    }

    $error['password'] = is_empty_member('password');

    $error['password2'] = is_empty_member('password2');

    // パスワードの確認
    if (($_POST['password'] != $_POST['password2']) && ($_POST['password2'] != "")) {
      $error['password2'] = 'difference';
    }

    is_no_error($error);
}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <link rel="shortcut icon" href="favicon.ico">
    <title>会員登録画面</title>
  </head>
  <body>
      <?php
      // デバッグ
      // echo $error['password2'];
      ?>
      <h1>会員登録画面</h1>
      <p><a href="./index.php">TOPへ戻る</a></p>
      <form action="./registration.php" method="post">
          <input type="radio" name="animal" id="dog" value="dog" checked>
          <label for="dog">犬</label>
          <input type="radio" name="animal" id="cat" value="cat">
          <label for="cat">猫</label>
          <?php if($error['name'] == "blank"): ?>
            <p>名前を入力してください。</p>
          <?php endif; ?>
          <p>名前<input type="text" name="name" id=""></p>
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
          <?php if($error['password2'] == "blank"): ?>
            <p>確認のためのパスワードを入力してください。</p>
          <?php elseif($error['password2'] == "difference"): ?>
            <p>パスワードが上記と違います。</p>
          <?php endif; ?>
          <p>パスワード再入力<input type="password" name="password2" id=""></p>
          <input type="submit" value="登録">
      </form>
  </body>
</html>