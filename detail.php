<?php
session_start();
require_once('functions.php');
check_session_id();

// URLからIDを取得
if (!isset($_GET['id'])) {
    exit('IDが指定されていません。');
}
$id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$pdo = db_connect();

// SQL文を作成（自分のブックマークデータのみ取得）
$sql = 'SELECT * FROM bookmarks_table WHERE id = :id AND user_id = :user_id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

try {
    $stmt->execute();
    $bookmark = $stmt->fetch(); // データを1件取得
} catch (PDOException $e) {
    exit('sql error:' . $e->getMessage());
}

// データが見つからない場合はエラー
if (!$bookmark) {
    exit('指定されたデータは存在しないか、編集権限がありません。');
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ブックマーク編集</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h1>ブックマーク編集</h1>
        <form action="update.php" method="POST">
            <input type="hidden" name="id" value="<?= h($bookmark['id']) ?>">
            
            <label>書籍名: <input type="text" name="name" value="<?= h($bookmark['name']) ?>" required></label>
            <label>URL: <input type="url" name="url" value="<?= h($bookmark['url']) ?>" required></label>
            <label>コメント: <textarea name="comment"><?= h($bookmark['comment']) ?></textarea></label>
            
            <button type="submit">更新</button>
        </form>
        <a href="index.php">一覧に戻る</a>
    </div>
</body>
</html>