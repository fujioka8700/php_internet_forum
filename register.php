<?php
session_start();
include_once('./dbconnect.php');
include_once('./member_property.php');

$statement = $pdo->prepare("INSERT INTO members (name, email, password) VALUES (:name, :email, :password)");
$statement->execute(array('name' => $name,'email' => $email, 'password' => $password));

unset($pdo);

header('Location: ./completed.php');