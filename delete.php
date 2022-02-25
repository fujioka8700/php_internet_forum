<?php
session_start();
include_once('./dbconnect.php');

// 自身の投稿内容1つ削除
if (isset($_SESSION['id'])) {
    $id = $_REQUEST['id'];
    $messages = $pdo->prepare('SELECT * FROM posts WHERE id=:id');
    $messages->bindValue(':id', $id, PDO::PARAM_INT);
    $messages->execute();
    $message = $messages->fetch(PDO::FETCH_ASSOC);
    if ($message['created_by'] == $_SESSION['id']) {
        $del = $pdo->prepare('DELETE FROM posts WHERE id=:id');
        $del->bindValue(':id', $id, PDO::PARAM_INT);
        $del->execute();
    }
}
header('Location: ./forum.php');