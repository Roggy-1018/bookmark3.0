<?php
session_start();
require_once('functions.php');
check_session_id(); // ログインしていない場合は、ログインページへリダイレクト

// ログインしているユーザーのIDを取得
$user_id = $_SESSION['user_id'];

$pdo = db_connect();

// ログインユーザーのブックマークのみを新しい順に取得するSQL
$sql = 'SELECT * FROM bookmarks_table WHERE user_id = :user_id ORDER BY created_at DESC';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);

try {
    $stmt->execute();
    // 取得したデータを$bookmarks変数に格納
    $bookmarks = $stmt->fetchAll();
} catch (PDOException $e) {
    exit('sql error:' . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ブックマーク一覧</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <p>ようこそ、<?= h($_SESSION['username']) ?>さん</p>
        <a href="logout.php">ログアウト</a>
    </header>

    <h1>ブックマーク登録</h1>

    <form action="insert.php" method="POST" class="form-container" style="max-width: 900px; margin: 20px auto;">
        <div>
            <label for="name">書籍名:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="url">URL:</label>
            <input type="url" id="url" name="url" required>
        </div>
        <div>
            <label for="comment">コメント:</label>
            <textarea id="comment" name="comment"></textarea>
        </div>
        <button type="submit">登録</button>
    </form>


    <h2>ブックマーク一覧</h2>
    <div class="bookmark-list">
        <?php foreach ($bookmarks as $bookmark) : ?>
            <div class="bookmark-item">
                <h3><a href="<?= h($bookmark['url']) ?>" target="_blank"><?= h($bookmark['name']) ?></a></h3>
                <p><?= nl2br(h($bookmark['comment'])) ?></p>
                <div class="actions">
                    <a href="detail.php?id=<?= h($bookmark['id']) ?>">編集</a>
                    <a href="delete.php?id=<?= h($bookmark['id']) ?>" onclick="return confirm('本当に削除しますか？')">削除</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>