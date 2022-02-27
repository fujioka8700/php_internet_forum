<?php
@session_start();
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
    
        if (password_verify($_POST['password'], $member['password'])) {
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
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
    <link rel="stylesheet" href="./dist/app.css">
    <title>[TOP] 犬・猫 どちら派掲示板</title>
  </head>
  <body>
    <div id="login">
        <h3 class="text-center text-white pt-5">犬・猫 どちら派掲示板</h3>
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="./index.php" method="post">
                            <h3 class="text-center text-info">Login</h3>
                            <?php if ($error['login'] == 'blank'): ?>
                              <p class="text-danger">メールとパスワードを入力してください。</p>
                            <?php elseif ($error['login'] == 'failed'): ?>
                              <p class="text-danger">メールとパスワードが間違っています。</p>
                            <?php endif ?>
                            <div class="form-group">
                                <label for="username" class="text-info">Email:</label><br>
                                <input type="email" name="email" id="username" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info">Password:</label><br>
                                <input type="text" name="password" id="password" class="form-control">
                            </div>
                            <div class="form-group submit">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="ログイン">
                            </div>
                            <div id="register-link" class="text-right">
                                <span class="text-info">会員登録は<a href="./registration.php">こちら</a></span>
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