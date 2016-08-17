<?php
  require("Common.php");
  require("Actorassign.php");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(isset($_POST["category"])){
  if($_POST["category"]=="ready"){
      $stmt = $pdo -> prepare("UPDATE members SET Ready=1,Event='Ready' WHERE Name=:name");
  }else if($_POST["category"]=="vote"){
      $stmt = $pdo -> prepare("UPDATE members SET vote=vote+1,Event='Vote' WHERE Name=:name");
  }else if($_POST["category"]=="expel"){
    empty(maxexpel())?$max=0:$max=maxexpel();
      $stmt = $pdo -> prepare("UPDATE members SET expel=$max+1,Event='expel' WHERE Name=:name");
  }else if($_POST["category"]=="attack"){
    $stmt = $pdo -> prepare("UPDATE members SET expel=-1,Event='Attack' WHERE Name=:name");
  }else if($_POST["category"]=="open"){
      $stmt = $pdo -> prepare("SELECT job FROM members WHERE Name=:name ");
  }else if($_POST["category"]=="mystic"){
      $stmt = $pdo -> prepare("SELECT job FROM members WHERE expel=:expel ");
  }else if($_POST["category"]=="guard"){
      $stmt = $pdo -> prepare("UPDATE members SET Guard=1,Event='Guard' WHERE Name=:name");
  }else if($_POST["category"]=="start"){//あとで見やすくする。
        start();
  }else if($_POST["category"]=="restart"){
        $stmt = $pdo -> prepare("UPDATE members SET Job=NULL,Ready= 0,vote= 0,expel= 0,Guard= 0,Event='Restart' WHERE ID BETWEEN 1 AND 20");
  }else if($_POST["category"]=="nextDay"){
        $stmt = $pdo -> prepare("UPDATE members SET Job=NULL,Ready= 0,vote= 0,expel= 0,Guard= 0,Event='quit' WHERE ID BETWEEN 1 AND 20");
  }else if($_POST["category"]=="quit"){
    $stmt = $pdo -> prepare("UPDATE members SET Guard= 0,vote= 0,Event='NextDay' WHERE ID BETWEEN 1 AND 20");
  }else if($_POST["category"]=="end"){
      $stmt = $pdo -> prepare("UPDATE members SET expel=0,Event='End'  WHERE ID = 0");
      $stmt -> execute();
      $stmt = $pdo -> prepare("DELETE FROM members WHERE ID BETWEEN 1 AND 20");
      $stmt -> execute();
      $stmt = $pdo -> prepare("TRUNCATE activity_logs");
}else{
    return 0;
  }

  if($_POST["category"]=="mystic"){
    $stmt -> bindParam(':expel',maxexpel());
  }else {
    $stmt -> bindParam(':name',$_POST["name"]);
  }
    $stmt -> execute();

    if($_POST["category"]=="open"||$_POST["category"]=="mystic"){
      $result = $stmt -> fetch(PDO::FETCH_ASSOC);
      echo $result["job"];
    }
}
  function maxExpel(){
    global $pdo;
    $stmt = $pdo -> prepare("select max(expel) from members WHERE ID BETWEEN 1 AND 20");
    $stmt -> execute();
    $result =$stmt -> fetch(PDO::FETCH_ASSOC);
    if(empty($result))$result["max(expel)"]=1;
    return $result["max(expel)"];
  }

  function start(){
    global $pdo;
    $stmt = $pdo -> prepare("SELECT `Ready` FROM `members` WHERE Ready= 0 AND ID BETWEEN 1 AND 20");
    $stmt -> execute();
    $gameOK = $stmt -> fetch(PDO::FETCH_ASSOC);
    if(isset($gameOK["Ready"])===false){//Readyが0のカラムがない＝全員の準備が完了していると、判断する
      $stmt = $pdo -> prepare("UPDATE members SET expel=-2,Event='Start'  WHERE Name='game'");
      $stmt -> execute();
      $stmt = $pdo -> prepare("select count(id) from members where ID BETWEEN 1 AND 10;");
      $stmt -> execute();
      $coloms =$stmt -> fetch(PDO::FETCH_ASSOC);
      $colom = $coloms["count(id)"];//参加人数の取得
      actorAssigns($colom);
      exit();
    }else{
      echo("The Game Play is not enough players.");
      return;
    }
  }
