<?php
session_start();
require_once('functions.php');
check_session_id();

// POSTデータが正しく送信されているかチェック
if (
    !isset($_POST['id']) || $_POST['id'] === '' ||
    !isset($_POST['name']) || $_POST['name'] === '' ||
    !isset($_POST['url']) || $_POST['url'] === ''
) {
    exit('必須項目が入力されていません。');
}

// POSTデータを変数に格納
$id = $_POST['id'];
$name = $_POST['name'];
$url = $_POST['url'];
$comment = $_POST['comment'] ?? '';
$user_id = $_SESSION['user_id'];

$pdo = db_connect();

// SQL文を作成（自分のブックマークのみ更新可能）
$sql = 'UPDATE bookmarks_table SET name=:name, url=:url, comment=:comment, updated_at=now() WHERE id=:id AND user_id=:user_id';
$stmt = $pdo->prepare($sql);

// バインド変数に値をセット
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':url', $url, PDO::PARAM_STR);
$stmt->bindValue(':comment', $comment, PDO::PARAM_STR);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

try {
    $stmt->execute();
} catch (PDOException $e) {
    exit('sql error:' . $e->getMessage());
}

header('Location: index.php');
exit();