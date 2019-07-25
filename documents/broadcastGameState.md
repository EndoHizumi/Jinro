# 通信方法について

## 概要

JINROは、クライアントとサーバー間の双方向で通信が行われる。
その実現方法と利用技術について、記述する。

## 利用技術

方向|利用技術
:--:|:--:
クライアント -> サーバー|Ajax
サーバー -> クライアント|Server Sent Events

## 配信方法

無限ループで、Activity_logsをチェックし、レコードが追加されている場合、変更されたレコードがクライアントに送信される。

membersテーブルに変更があると、変更のあったレコードのid・name・eventのカラムがActivity_logsテーブルに書き込まれる。

イメージ

```puml
actor Client
Client <- broadcast.php::変更があったら、送信
database Jinro
broadcast.php <-> Jinro:無限ループで確認
jinroResponser.php-> Jinro:ゲームの状態を登録
```