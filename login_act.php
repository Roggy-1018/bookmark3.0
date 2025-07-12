<?php
session_start();
require_once('functions.php');

$username = $_POST['username'];
$password = $_POST['password'];

$pdo = db_connect();

$sql = 'SELECT * FROM users_table WHERE username = :username AND is_deleted = 0';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);

try {
    $stmt->execute();
    $user = $stmt->fetch();
} catch (PDOException $e) {
    echo json_encode(["sql error" => "{$e->getMessage()}"]);
    exit();
}

// ユーザーが存在し、パスワードが一致する場合
if ($user && password_verify($password, $user['password'])) {
    // セッションに変数を格納
    $_SESSION['session_id'] = session_id();
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    header("Location: index.php"); // メインページへリダイレクト
    exit();
} else {
    // ログイン失敗
    header("Location: login.php"); // ログインページへリダイレクト
    exit();
}