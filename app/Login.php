<?php
  require("Common.php");
try {
  $stmt = $pdo -> prepare("SELECT ID,job,expel FROM `members` WHERE id=:value;");
  $stmt -> bindValue(':value',0);
  $stmt -> execute();
  if(empty($stmt)) throw new Exception("BreakRoomException", 1);
  $pass =$stmt -> fetch(PDO::FETCH_ASSOC);
} catch (Exception $e) {
  echo("[9999]Error Break Room. please contact administar");
}

  if(empty($pass))return;
  $postpass=$_POST["pass"];
  if($pass["expel"]==-2){
    echo "Game already started. Retry later.";
    return;
  }
 $postName = filter_input(INPUT_POST,"name");
 if($postpass==$pass["job"]&&!empty($postName)){
  $stmt = $pdo -> prepare("select count(id) from members");
  $stmt -> execute();
  $coloms =$stmt -> fetch(PDO::FETCH_ASSOC);
  $colom = $coloms["count(id)"]-1;
   try {
    $stmt = $pdo -> prepare("INSERT INTO members (ID,Name,Event) VALUE (:id,:name,:event);");
    $stmt -> bindValue(':id',$colom+1);
    $stmt -> bindValue(':name',$_POST["name"]);
    $stmt->bindValue(':event',"Enter");
    $stmt -> execute();
    echo "[0000] welcome to ".$_POST["name"];
   } catch (PDOException $e) {
     require_once("ExceptionMapping.php");
     $message = $e->getMessage();
     $exceptionmsg = new ExceptionMapping($message);
     $exceptionmsg -> SQLExceptionMessenger();
   }
  }else{
    echo("Login Failure");
  }
