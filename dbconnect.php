<?php
try {
    $pdo = new PDO('mysql:host=localhost:3306;dbname=internet_forum;charset=utf8mb4', 'dog2', 'dogdog');
} catch (PDOException $e) {
    $result = "#ERR: " . $e->getMessage();
}