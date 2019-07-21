# jinroResponcer

## 機能概要

ユーザーの状態管理テーブル
ユーザーの状態をテーブルに書きこむ。

## 挙動

POSTメソッドで送られてきたcategoryの値に応じて、
memberテーブルにいる指定ユーザーのカラムを変更するクエリを作成する。
（詳細は、以下の通り）
categoryが、mysticの場合、:expelにmaxexpelメソッドを割り当てる。
それ以外の場合、:nameにPOSTメソッドのnameの値を割り当てる。
クエリを実行する。
categoryの値がopenまたはmysticの場合、結果を取得して、echoで表示する。

maxExpel関数
memberテーブルの一番大きいexpelの値をもつレコードを選択する。

start関数
categoryがstartの時に呼び出される
memberテーブルのreadyの値が０をレコードのreadyを選択する。
選択されたreadyのカラムがないなら、ユーザー：gameのexpelを２にEventをStartに変更する。
参加人数を取得して、actorAssigns関数をよび出す。
カラムがある場合、The Game Play is not enough players.と返す。

## 作成するクエリ

### ready

状態：ユーザーがゲーム開始待ちになった

- readyのフラグを立てる。
- eventの値をreadyに変更する。
  
### vote

状態：ユーザーに票が入った

- voteの値をインクリメントする。
- eventをvoteに変更する
  
### expel

状態：ユーザーが追放された又は人狼に喰われた

- expelの値を$maxの値＋１に更新する。
- Eventの値をexpelに変更する。

### attack

状態:調査中(多分、人狼に喰われた)

- expelの値を-1に更新する
- Eventの値をAttackに変更する。

### open

状態:指定ユーザーの職業を開示するターンになった。

- 指定ユーザーのjobカラムを選択する。

### mystic

状態:霊媒師が前日吊るしあげた村人が人狼だったか判定した。

- expelの値が一番大きいユーザーの職業を選択する。

### guard

状況:ガードマンが、守る村人を指定した

- guardの値を１に更新する。
  
### restart 

状況:ゲームをリセットする。

- jobの値をNullに更新する。
- ready/vote/expel/guardの値を０に更新する。
- Eventをrestartに更新する。

### nextDay

状況:夜のターンが終わった

- guard/voteの値を０に更新する。
- EventをNextDayに更新する。

### Quit

状況:ゲームをログアウトする。

- jobの値をNullに更新する。
- ready/vote/expel/guardの値を０に更新する。
- Eventをquitに更新する。

### end

状況:ゲームを終了させる。

- ID:0のexpelを０に更新する。
- ID:1から20のレコードを削除する。
- activitylogテーブルのレコードを全削除する。

###　start

start関数を呼び出す
