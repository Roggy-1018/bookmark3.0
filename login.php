<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ブックマーク - ログイン</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h1>ログイン</h1>
        <form action="login_act.php" method="POST">
            <label>ユーザー名: <input type="text" name="username"></label>
            <label>パスワード: <input type="password" name="password"></label>
            <button type="submit">ログイン</button>
        </form>
        <p>アカウントをお持ちでないですか？</p>
        <a href="signup.php">新規登録はこちら</a>
    </div>
</body>
</html>