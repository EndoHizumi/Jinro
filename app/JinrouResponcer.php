<?php
 require("Common.php");
 require("Actorassign.php");
 $category=mb_strtolower(filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRING), "UTF-8");
 if ($category!==null) {
     try {
         $result= $category();
         echo is_null($result)?"true":$result;
     } catch (\Throwable $th) {
         echo $th;
         echo "false";
    }
} else {
    echo "invalid endpoint";
 }

 function runQuery(string $statement, array $bindParamMap=[])
 {
     // bindParamMapが入力されなかった場合、:nameをバインドに設定する。。
     if (empty($bindParamMap)) {
         $playerName = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
         $bindParamMap= [":name"=>$playerName];
     };
     global $pdo;
     // SQLのエラーをExceptionとしてスローする。
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $query = $pdo -> prepare($statement);
     foreach ($bindParamMap as $key => $value) {
         $query -> bindParam($key, $value);
     }
     $query -> execute();
     $result =$query -> fetch(PDO::FETCH_ASSOC);
     return $result;
 }

  function ready()
  {
      runQuery("UPDATE members SET Ready=1,Event='Ready' WHERE Name=:name");
  }

  function restart()
  {
      runQuery("UPDATE members SET Job=NULL,Ready= 0,vote= 0,expel= 0,Guard= 0,Event='Restart' WHERE ID != 0");
  }

  function standby()
  {
      runQuery("UPDATE members SET Ready=0,Event='Standby' WHERE Name=:name");
  }

  function vote()
  {
      runQuery("UPDATE members SET vote=vote+1,Event='Vote' WHERE Name=:name");
  }

  function expel()
  {
      runQuery("UPDATE members SET expel=(SELECT MAX(expel) FROM members)+1,Event='expel' WHERE Name=:name");
  }

  function attack()
  {
      $result = runQuery("UPDATE members SET expel=-1,Event='Attack' WHERE Name=:name AND guard != 1");
      var_export($result);
  }

  function overlook()
  {
      return runQuery("SELECT job FROM members WHERE Name=:name")["job"];
  }

  function mystic()
  {
      return runQuery("SELECT job FROM members WHERE expel=(SELECT MAX(expel) FROM members)")["job"];
  }

  function guard()
  {
      runQuery("UPDATE members SET Guard=1,Event='Guard' WHERE Name=:name");
  }

  function nextDay()
  {
      runQuery("UPDATE members SET Guard= 0,vote= 0,Event='NextDay' WHERE ID != 0");
  }

  function quit()
  {
      runQuery("UPDATE members SET Job=NULL,Ready= 0,vote= 0,expel= 0,Guard= 0,Event='quit' WHERE ID != 0");
  }

  function fin()
  {
      runQuery("UPDATE members SET expel=0,Event='End' WHERE ID = 0");
      runQuery("DELETE FROM members WHERE ID != 0");
      runQuery("TRUNCATE activity_logs");
  }

  function start()
  {
      $gameOK = runQuery("SELECT `Ready` FROM `members` WHERE Ready= 0 AND ID != 0");
      if (isset($gameOK["Ready"])===false) {//Readyが0のカラムがない＝全員の準備が完了していると、判断する
          runQuery("UPDATE members SET expel=-2,Event='Start'  WHERE Name='game'");
          $coloms =runQuery("select count(id) from members where ID != 0;")["count(id)"];//参加人数の取得
          actorAssigns($colom);
      } else {
          return("The Game Play is not enough players.");
      }
  }

  function message()
  {
      $colom=runQuery("select count(id) from activity_logs;")["count(id)"];
      $statement=("INSERT INTO activity_logs (ID,Name,Event,Message,time) VALUE (:id,:name,:event,\"message\",:time);");
      $params = [
        ':id' => $colom+1,
        ':name' => filter_input(POST, "name", FILTER_SANITIZE_STRING),
        ':message' => filter_input(POST, "message", FILTER_SANITIZE_STRING),
        ':time'=> date("Y/m/d H:i:s")
      ];
      runQuery($statement, $params);
  }

  function createroom()
  {
      $statement = "INSERT INTO room value(:name,:pass,0,:owner);";
      $params = [
        ':name' => filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING),
        ':pass' => filter_input(INPUT_POST, "pass", FILTER_SANITIZE_STRING),
        ':owner' => filter_input(INPUT_POST, "owner", FILTER_SANITIZE_STRING)
      ];
      runQuery($statement, $params);
  }
