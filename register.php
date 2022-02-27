<?php
session_start();
include_once('./dbconnect.php');
include_once('./member_property.php');

$hash = password_hash($password, PASSWORD_BCRYPT);

$statement = $pdo->prepare("INSERT INTO members (animal, name, email, password) VALUES (:animal, :name, :email, :password)");
$statement->execute(array(':animal' => $animal, ':name' => $name,':email' => $email, ':password' => $hash));

unset($pdo);

header('Location: ./completed.php');