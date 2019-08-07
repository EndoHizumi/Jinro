# DBの文字コード確認コマンド


status

## MySQLの文字コードを確認する

show variables like "chara%";

## テーブルの文字コードを確認する

show create table {tableName}

## テーブルの文字コードを変更

ALTER TABLE {targettable} CONVERT TO CHARACTER SET utf8;

## 操作手順

テーブルの文字コードをUTF-8にする。（文字を保存するテーブルをUTF-8）
これだけだと、クライアントとやりとり中に、文字化けする。

mysqlセクションを追加し、`default-character-set=utf8`と記述する。
これで、日本語の文字化けを起こすことがなくなる。

```mysql
[mysql]
default-character-set=utf8
```
