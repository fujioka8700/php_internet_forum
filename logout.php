<?php
@session_start();

// ログアウト処理
if (isset($_SESSION['id'])) {
    session_destroy();
}

header('Location: ./index.php');