<?php

function db_connect()
{
    // XAMPP / さくらサーバー 共通設定
    $db_host = 'localhost';      // XAMPP: localhost, さくら: 指定のホスト名
    $db_name = 'bookmark3.0';   // あなたのDB名
    $db_user = 'root';           // XAMPP: root, さくら: 指定のユーザー名
    $db_pass = '';               // XAMPP: (空), さくら: 指定のパスワード

    $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";

    try {
        $pdo = new PDO($dsn, $db_user, $db_pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch (PDOException $e) {
        exit('DBConnectError:' . $e->getMessage());
    }
}

// ログイン状態のチェック関数
function check_session_id()
{
    if (!isset($_SESSION['session_id']) || $_SESSION['session_id'] !== session_id()) {
        // ログインしていない、またはセッションIDが一致しない場合
        header('Location: login.php'); // ログインページへリダイレクト
        exit();
    }
}

// XSS対策関数
function h($str)
{
    return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}