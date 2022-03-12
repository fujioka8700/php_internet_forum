<?php
session_start();
include_once('./dbconnect.php');

// すでに登録したEmailではないか
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

// 入力が空ではないか確認
function is_empty_member($s) {
    if ($_POST[$s] == "") {
        return 'blank';
    }
}

// 入力にエラーがなければ確認画面へ
function is_no_error($error) {
    $judge = array_filter($error);
    if (empty($judge)) {
        $_SESSION['join'] = $_POST;
        header('Location: ./confirm.php'); 
    }
}

// 入力やり直し時、NameとEmailはそのまま
function keep_your_input($s) {
  if (!empty($_POST[$s])) {
    $_SESSION[$s] = htmlspecialchars($_POST[$s]);
  } else {
    unset($_SESSION[$s]);
  }
}

if (!empty($_POST)) {
    $error['name'] = is_empty_member('name');

    keep_your_input('name');

    $error['email'] = is_empty_member('email');

    keep_your_input('email');

    if ($error['email'] != 'blank') {
        $error['email'] = email_exists($pdo, $_POST['email']);
    }

    $error['password'] = is_empty_member('password');

    $error['password2'] = is_empty_member('password2');

    // ２つのパスワードの確認
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
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="./dist/app.css">
    <title>[会員登録] 犬・猫 どちら派掲示板</title>
  </head>
  <body>  
      <div id="login">
        <h3 class="text-center text-white pt-5">犬・猫 どちら派掲示板</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="./registration.php" method="post">
                            <h3 class="text-center text-info">会員登録</h3>
                            <div class="form-group">
                              <p class="text-info">どちら派ですか？</p>
                              <input type="radio" name="animal" id="dog" value="dog" checked>
                              <label for="dog">犬</label>
                              <input type="radio" name="animal" id="cat" value="cat">
                              <label for="cat">猫</label>
                            </div>
                            <?php if($error['name'] == "blank"): ?>
                              <p class="text-danger">Nameを入力してください。</p>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="name" class="text-info">Name:</label><br>
                                <input type="text" name="name" id="name" class="form-control" value="<?= $_SESSION['name']; ?>">
                            </div>
                            <?php if($error['email'] == "blank"): ?>
                              <p class="text-danger">Emailを入力してください。</p>
                            <?php elseif($error['email'] == "duplicate"): ?>
                              <p class="text-danger">Emailが登録されています。</p>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="email" class="text-info">Email:</label><br>
                                <input type="email" name="email" id="email" class="form-control"  value="<?= $_SESSION['email']; ?>">
                            </div>
                            <?php if($error['password'] == "blank"): ?>
                              <p class="text-danger">パスワードを入力してください。</p>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="password" name="password" id="password" class="form-control">
                            </div>
                            <?php if($error['password2'] == "blank"): ?>
                              <p class="text-danger">確認のためのパスワードを入力してください。</p>
                            <?php elseif($error['password2'] == "difference"): ?>
                              <p class="text-danger">パスワードが上記と違います。</p>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="password2" class="text-info">Password 再入力:</label><br>
                                <input type="password" name="password2" id="password2" class="form-control">
                            </div>
                            <div class="form-group submit">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="確認画面へ">
                            </div>
                            <div id="register-link" class="text-right">
                                <span class="text-info"><a href="./login.php">ログイン画面へ戻る</a></span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
    <script src="./dist/app.js"></script>
  </body>
</html>