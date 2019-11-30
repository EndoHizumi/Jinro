# JinroWebAPI要件

## URLフォーマット

`/jinro/api/(user|game|room|message|jinromessage)/{domain}`

## レスポンスフォーマット

- JSON

  ``` json
  {
    "result": boolean, // 処理の成否
    "value": String // 処理結果（またはエラーメッセージ)
  }
  ```

### Endpoint

#### jobs

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
  
- path:/vote/{userName}
  - method:PUT

- path:/expel/{userName}
  - method:PUT

- path:/attack/{userName}
  - method:PUT

- path:/guard/{userName}
  - method:PUT

- path:/message/
  - method:PUT
  - description:addMessage

#### rooms

- path:/{roomName}
  - method:GET

- path:/state/{roomName}
  - method:PUT
  - body:start/end
    - type:string

- path:/{roomName}
  - method:POST
  - description:createRoom

- path:/{roomName}
  - method:DELETE
  - description:breakRoom

- path:/{userName}/enter
  - method:POST

- path:/{userName}/exit
  - method:DELETE

- path:{roomName}/time/nextDay
  - method:PUT
  - description:nextDay

- path:{roomName}/time/nextTime
  - method:PUT
  - description:nextTime

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
