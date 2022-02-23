<?php
session_start();
include_once('./dbconnect.php');

$email = htmlspecialchars($_SESSION['join']['email']);
$password = htmlspecialchars($_SESSION['join']['password']);

$statement = $pdo->prepare("INSERT INTO members (email, password) VALUES (:email, :password)");
$statement->execute(array('email' => $email, 'password' => $password));

unset($pdo);
unset($_SESSION['join']);

header('Location: ./completed.php');