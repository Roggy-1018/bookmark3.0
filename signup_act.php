<?php
require_once('functions.php');

if (
    !isset($_POST['username']) || $_POST['username'] === '' ||
    !isset($_POST['password']) || $_POST['password'] === ''
) {
    exit('paramError');
}

$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // パスワードをハッシュ化

$pdo = db_connect();

$sql = 'INSERT INTO users_table(id, username, password, is_deleted, created_at, updated_at) VALUES(NULL, :username, :password, 0, now(), now())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);
$stmt->bindValue(':password', $password, PDO::PARAM_STR);

try {
    $stmt->execute();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

header("Location: login.php"); // 登録後はログインページへ
exit();