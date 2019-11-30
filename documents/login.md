# login

## 機能概要

パスワードがあっているのかその確認と入室の処理を行う。

## 処理

### 処理の流れ

リクエストを受ける→部屋の情報をDBから取得する→パスワードがあっているか確認する→ユーザー名をmemberテーブルに登録する。

### 詳細

1. ユーザーが名前と部屋のパスワードを入力する。
2. Login.phpはroomテーブルのnameとpass、isstartカラムを取得する。
3. サーバーから要求されたレコードが送られてくる。これを部屋の管理情報として扱う。(=roomInfo)
   1. もし、roomInfoが空の場合、メッセージ1をクライアントに返す。
   2. もし、roomInfoのisstartが1の場合、メッセージ2をクライアントに返す。
4. roomInfoのpassカラムの値とリクエストのpassの値を比較する
   1. もし、値が異なる場合、メッセージ3をクライアントに返す。
   2. 一致した時、参加プレイヤーの人数を取得する。
5. 参加プレイヤーの人数が帰ってくる。
6. 5をインクリメントした値とユーザー名、ルーム名をMemberテーブルに登録する。
7. クライアントにウェルカムメッセージを返して、ログイン成功とする。

## シーケンス図

```puml
actor Client
autonumber
Client -> Login.php:username,password
database Jinro
Login.php -> Jinro: select roomInfo from members Table.
Login.php <- Jinro: roomInfo(id:0 record)
autonumber "<font color=red><b> Message:"
alt roomIndfo is empty
    Client<[#red]-Login.php:[9999]Error Break Room. please contact administar
end
alt roominfo.expel is 2
    Client<-Login.php:Game already started. Retry later.
end
alt password is roomInfo.pass
    autonumber 4 
    Login.php -> Jinro:select PlayersCount from members Table.
    Login.php <- Jinro:playerCount
    Login.php -> Jinro:Insert name for members table.
    Login.php -> Client: welcome message
else
    autonumber 3 "<font color=red><b> Message:"
    Client <[#red]-Login.php:Login Failure
end
```
