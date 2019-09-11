# JinroWebAPI要件

- [JinroWebAPI要件](#jinrowebapi%e8%a6%81%e4%bb%b6)
  - [URLフォーマット](#url%e3%83%95%e3%82%a9%e3%83%bc%e3%83%9e%e3%83%83%e3%83%88)
  - [レスポンスフォーマット](#%e3%83%ac%e3%82%b9%e3%83%9d%e3%83%b3%e3%82%b9%e3%83%95%e3%82%a9%e3%83%bc%e3%83%9e%e3%83%83%e3%83%88)
    - [Endpoint](#endpoint)
      - [jobs](#jobs)
      - [players](#players)
<<<<<<< HEAD
      - [games](#games)
=======
      - [rooms](#rooms)
      - [times](#times)
>>>>>>> 7b7e2803811a5552c4f0c0d6cd9505ae20697fb1
      - [messages](#messages)
  - [メソッド要件](#%e3%83%a1%e3%82%bd%e3%83%83%e3%83%89%e8%a6%81%e4%bb%b6)
    - [ゲーム全体制御系](#%e3%82%b2%e3%83%bc%e3%83%a0%e5%85%a8%e4%bd%93%e5%88%b6%e5%be%a1%e7%b3%bb)
      - [ready](#ready)
      - [stanby](#stanby)
      - [begin](#begin)
      - [quit](#quit)
      - [enter](#enter)
      - [exit](#exit)
      - [createRoom](#createroom)
      - [breakRoom](#breakroom)
    - [時間帯操作系](#%e6%99%82%e9%96%93%e5%b8%af%e6%93%8d%e4%bd%9c%e7%b3%bb)
      - [nextTime](#nexttime)
      - [nextDay](#nextday)
    - [ユーザーアクション系](#%e3%83%a6%e3%83%bc%e3%82%b6%e3%83%bc%e3%82%a2%e3%82%af%e3%82%b7%e3%83%a7%e3%83%b3%e7%b3%bb)
      - [vote](#vote)
      - [expel](#expel)
      - [attack](#attack)
      - [overlook](#overlook)
      - [mystic](#mystic)
      - [guard](#guard)
      - [message](#message)
      - [jinroMessage](#jinromessage)
    - [備考](#%e5%82%99%e8%80%83)

## URLフォーマット

`/jinro/api/v1/(user|game|room|message|jinromessage)/{domain}`

## レスポンスフォーマット

- JSON

  ``` json
  {
    "result": boolean, // 処理の成否
<<<<<<< HEAD
    "reason": String // 処理結果（またはエラーメッセージ)
=======
    "value": String // 処理結果（またはエラーメッセージ)
>>>>>>> 7b7e2803811a5552c4f0c0d6cd9505ae20697fb1
  }
  ```

### Endpoint

#### jobs

<<<<<<< HEAD
- path:/{userName}
  - method:GET
  - body:overlook/mystic
    - type:string

- path:/{userName}
  - method:PUT
  - body:jobName
    - type:string

#### players

- path:/state/{userName}
  - method:PUT
  - body:ready/standby
    - type:string
  
- path:/{userName}
  - method:POST

- path:/{userName}
  - method:DELETE

- path:/vote/{userName}
  - method:PUT
=======
- path: /
  - GET
    - param
      - playerName
      - overlook/mystic
  - PUT
    - param
      - usenName
      - job

#### players

- path: /state/{userName}
  - PUT
    - param
      - name
        - userName
      - name
        - ready
      - name
        - standby

- path: /{userName}
  - POST
    - param
      - name
        - userName

- path:/{userName}
  - DELETE
    - param
      - name
        - userName

- path:/vote/{userName}
  - PUT
    - param
      - name
        - userName
>>>>>>> 7b7e2803811a5552c4f0c0d6cd9505ae20697fb1

- path:/expel/{userName}
  - method:PUT

- path:/attack/{userName}
  - method:PUT

- path:/guard/{userName}
  - method:PUT

<<<<<<< HEAD
#### games
=======
#### rooms
>>>>>>> 7b7e2803811a5552c4f0c0d6cd9505ae20697fb1

- path:/
  - method:GET
  - body:roomName/pass
    - type:string

<<<<<<< HEAD
- path:/state
  - method:PUT
  - body:start/end
    - type:string
=======
#### times
>>>>>>> 7b7e2803811a5552c4f0c0d6cd9505ae20697fb1

- path:/
  - method:POST
  - description:createRoom

<<<<<<< HEAD
- path:/
  - method:DELETE
  - description:breakRoom
=======
#### messages
>>>>>>> 7b7e2803811a5552c4f0c0d6cd9505ae20697fb1

- path:/nextDay
  - method:PUT
  - description:nextDay

<<<<<<< HEAD
- path:/nextTime
  - method:PUT
  - description:nextTime

#### messages

- path:/
  - method:PUT
  - description:addMessage

=======
>>>>>>> 7b7e2803811a5552c4f0c0d6cd9505ae20697fb1
## メソッド要件

### ゲーム全体制御系

#### ready

- やりたいこと  
  - プレイヤーが、まだ準備中と意思表示がしたい時

- 入力
  - 無し

- 処理
  - 指定ユーザーのreadyカラムを0に更新する
  - 指定ユーザーのeventカラムを'ready'に更新する

- 出力
  - 状態の変更の成否:boolean

- 補足
  - 無し

#### stanby

- やりたいこと  
  - プレイヤーが、準備完了と意思表示がしたい時

- 入力
  - 無し

- 処理
  - 指定ユーザーのreadyカラムを1に更新する
  - 指定ユーザーのeventカラムを'standby'に更新する

- 出力
  - 状態の変更の成否:boolean

- 補足
  - 無し

#### begin

- やりたいこと  
  - 誰かがゲームを開始した

- 入力
  - 無し

- 処理
  - リクエストしたユーザーのroomidの値に対応するroomテーroomテーブルのブルのisStartのカラムを1に更新する
  - 指定ユーザーのeventカラムを'begin'に更新する

- 出力
  - 状態の変更の成否:boolean

- 補足
- 一人でも、Standbyがいる場合はFalseを返す

#### quit

- やりたいこと  
  - ゲームを終了させる

- 入力
  - 無し

- 処理
  - breakroomを内部的にコールする
  - 指定ユーザーのeventカラムを'quit'に更新する

- 出力
  - 状態の変更の成否:boolean

- 補足
  - 無し

#### enter

- やりたいこと  
  - ユーザーの名前とパスワードを確認して、問題がなければ、指定のゲームルームに入室させる

- 入力
  - ユーザー名
  - パスワード
  - 入室したい部屋

- 処理
  - 入力されたパスワードが指定roomテーブルのpassカラムの値と一致するか確認する
    - 一致する場合
      - 重複するユーザー名があるか確認する。ある場合は、Falseと理由を返す
    - 異なる場合
      - Falseと理由を返す
- 出力
  - 状態の変更の成否:boolean

- 補足
  - 一人でも、Standbyがいる場合はFalseを返す

#### exit

- やりたいこと  

- 入力

- 処理

- 出力

- 補足

#### createRoom

- やりたいこと  

- 入力

- 処理

- 出力

- 補足

#### breakRoom

- やりたいこと  

- 入力

- 処理

- 出力

- 補足

### 時間帯操作系

#### nextTime

- やりたいこと  
  - 昼を夕方に、夕方を夜に、時眼帯の変更する。

- 入力
  - 無し

- 処理
  - roomテーブルのtimezoneカラムを反転させる。
  - 指定ユーザーのeventカラムを'nexttime'に更新する
  - activytLogsテーブルのmessageカラムに、roomテーブルのdayカラムを転記する

- 出力
  - 状態の変更の成否:boolean

- 補足
  - dayカラムがnullの時は、1を登録する。

#### nextDay

- やりたいこと  
  - 日付を次の日に進める。

- 入力
  - 無し

- 処理
  - roomテーブルのdayカラムをインクリメントする
  - roomテーブルの指定ユーザーのeventカラムを'nextday'に更新する
  - activytLogsテーブルのmessageカラムに、roomテーブルのdayカラムを転記する

- 出力
  - 状態の変更の成否:boolean

- 補足
  - dayカラムがnullの時は、1を登録する。

### ユーザーアクション系

#### vote

- やりたいこと  

- 入力

- 処理

- 出力

- 補足

#### expel

- やりたいこと  

- 入力

- 処理

- 出力

- 補足

#### attack

- やりたいこと  

- 入力

- 処理

- 出力

- 補足

#### overlook

- やりたいこと  

- 入力

- 処理

- 出力

- 補足

#### mystic

- やりたいこと  

- 入力

- 処理

- 出力

- 補足

#### guard

- やりたいこと  

- 入力

- 処理

- 出力

- 補足

#### message

- やりたいこと  

- 入力

- 処理

- 出力

- 補足

#### jinroMessage

- やりたいこと  

- 入力

- 処理

- 出力

- 補足

### 備考

enter以外は、セッションにnameの値がない場合は、401 unauthtizationを返す
自分の名称はセッションから取得する
