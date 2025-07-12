<?php
session_start();

// セッション変数を空にする
$_SESSION = [];

// クッキーにセッションIDが残っている場合は削除
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 42000, '/');
}

// セッションを破棄
session_destroy();

// ログインページへリダイレクト
header('Location: login.php');
exit();