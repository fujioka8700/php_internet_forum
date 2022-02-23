<?php
session_start();

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
    //   print_r($error);
      ?>
      <h1>会員登録画面</h1>
      <form action="./registration.php" method="get">
          <?php if(isset($error['email']) && $error['email'] == "blank"): ?>
            <p>emailを入力してください。</p>
          <?php endif; ?>
          <p>email<input type="email" name="email" id="" value="<?php echo htmlspecialchars($_SESSION['join']['email']); ?>"></p>
          <?php if(isset($error['password']) && $error['password'] == "blank"): ?>
            <p>パスワードを入力してください。</p>
          <?php endif; ?>
          <p>パスワード<input type="password" name="password" id=""></p>
          <input type="submit" value="登録">
      </form>
  </body>
</html>