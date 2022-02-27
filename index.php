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
    <link rel="shortcut icon" href="favicon.ico">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <title>犬・猫 どちら派掲示板</title>
    <style>
      body {
        margin: 0;
        padding: 0;
        background-color: #17a2b8;
        height: 100vh;
      }
      #login .container #login-row #login-column #login-box {
        margin-top: 120px;
        max-width: 600px;
        min-height: 320px;
        border: 1px solid #9C9C9C;
        background-color: #EAEAEA;
      }
      #login .container #login-row #login-column #login-box #login-form {
        padding: 20px;
      }
      #login .container #login-row #login-column #login-box #login-form #register-link {
        margin-top: -55px;
        margin-bottom: 23px;
      }
      .submit {
        margin-top: 30px;
      }
    </style>
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
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  </body>
</html>