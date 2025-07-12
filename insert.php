<?php
session_start();
require_once('functions.php');
check_session_id();

// POSTデータが正しく送信されているかチェック
if (
    !isset($_POST['name']) || $_POST['name'] === '' ||
    !isset($_POST['url']) || $_POST['url'] === ''
) {
    exit('必須項目が入力されていません。');
}

// POSTデータを変数に格納
$name = $_POST['name'];
$url = $_POST['url'];
$comment = $_POST['comment'] ?? ''; // コメントは任意
$user_id = $_SESSION['user_id']; // セッションからユーザーIDを取得

$pdo = db_connect();

// SQL文を作成
$sql = 'INSERT INTO bookmarks_table(id, user_id, name, url, comment, created_at, updated_at) VALUES(NULL, :user_id, :name, :url, :comment, now(), now())';
$stmt = $pdo->prepare($sql);

// バインド変数に値をセット
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':url', $url, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR); // ★★★ ここが修正点です ★★★

try {
    $stmt->execute();
} catch (PDOException $e) {
    exit('sql error:' . $e->getMessage());
}

header('Location: index.php');
exit();