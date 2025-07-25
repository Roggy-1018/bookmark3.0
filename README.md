# ログイン機能付き ブックマークアプリ

これは、PHPとMySQLで作成したシンプルなブックマーク管理アプリケーションです。ユーザー登録・ログイン機能があり、各ユーザーは自分だけのブックマークを管理することができます。

---

## 主な機能

* **ユーザー認証**
    * 新規ユーザー登録
    * ログイン・ログアウト機能
    * パスワードのハッシュ化による安全なパスワード管理
* **ブックマーク管理 (CRUD)**
    * ブックマークの登録（Create）
    * 登録済みブックマークの一覧表示（Read）
    * ブックマーク情報の更新（Update）
    * ブックマークの削除（Delete）
* **データ管理**
    * 登録されたブックマークは、ログインしているユーザーに紐づけて管理されます。
    * 他のユーザーのブックマークを閲覧・編集することはできません。

---

## 動作環境

* PHP 7.4 以上
* MySQL 5.7 以上 (または MariaDB)
* ApacheなどのWebサーバー
* XAMPPやMAMPなどのローカル開発環境での利用を想定

---

## インストール・設定方法

1.  **データベースの作成**
    `phpMyAdmin` などの管理ツールを使い、任意の名前で新しいデータベースを作成します（例: `bookmark_db`）。文字コードは `utf8mb4` を推奨します。

2.  **テーブルの作成**
    作成したデータベースを選択し、「SQL」タブから以下のクエリを**2つ**実行して、`users_table` と `bookmarks_table` を作成します。

    **① ユーザーテーブル**
    ```sql
    CREATE TABLE `users_table` (
      `id` int(12) NOT NULL AUTO_INCREMENT,
      `username` varchar(64) NOT NULL,
      `password` varchar(255) NOT NULL,
      `created_at` datetime NOT NULL,
      PRIMARY KEY (`id`)
    );
    ```

    **② ブックマークテーブル**
    ```sql
    CREATE TABLE `bookmarks_table` (
      `id` int(12) NOT NULL AUTO_INCREMENT,
      `user_id` int(12) NOT NULL,
      `name` varchar(255) NOT NULL,
      `url` text NOT NULL,
      `comment` text,
      `created_at` datetime NOT NULL,
      PRIMARY KEY (`id`)
    );
    ```

3.  **データベース接続設定**
    `functions.php` ファイルを開き、`db_connect()` 関数内のデータベース接続情報を、ご自身の環境に合わせて編集します。
    ```php
    // functions.php
    function db_connect() {
        $db_host = 'localhost';      // ホスト名
        $db_name = 'bookmark_db';    // 手順1で作成したデータベース名
        $db_user = 'root';           // DBユーザー名
        $db_pass = '';               // DBパスワード
        // ...
    }
    ```

4.  **ファイルの配置**
    全てのプロジェクトファイルを、サーバーのドキュメントルート（XAMPPなら`htdocs`）配下に設置します。

---

## 使い方

1.  ブラウザで `signup.php` にアクセスし、新規ユーザー登録を行います。
2.  登録後、`login.php` にアクセスしてログインします。
3.  ログインに成功すると、ブックマーク管理ページ (`index.php`) に移動します。
4.  このページで、ブックマークの登録・編集・削除が行えます。
