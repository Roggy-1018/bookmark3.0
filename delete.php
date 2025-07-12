<?php
session_start();
require_once('functions.php');
check_session_id(); // ログインチェック

// URLからIDを取得
if (!isset($_GET['id'])) {
    exit('IDが指定されていません。');
}
$id = $_GET['id'];
$user_id = $_SESSION['user_id']; // 現在のユーザーID

$pdo = db_connect();

// SQL文を作成（自分のブックマークのみ削除可能）
$sql = 'DELETE FROM bookmarks_table WHERE id = :id AND user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

try {
    $stmt->execute();
} catch (PDOException $e) {
    exit('sql error:' . $e->getMessage());
}

header('Location: index.php');
exit();