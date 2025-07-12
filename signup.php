<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ブックマーク - 新規登録</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h1>新規ユーザー登録</h1>
        <form action="signup_act.php" method="POST">
            <label>ユーザー名: <input type="text" name="username" required></label>
            <label>パスワード: <input type="password" name="password" required></label>
            <button type="submit">登録</button>
        </form>
        <p>すでにアカウントをお持ちですか？</p>
        <a href="login.php">ログインはこちら</a>
    </div>
</body>
</html>