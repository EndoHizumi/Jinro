<?php

  require("Common.php");
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $pdo -> prepare("SELECT ID,job,expel FROM `members` WHERE id=:value;");
  $stmt -> bindValue(':value',0);
  $stmt -> execute();
  $pass =$stmt -> fetch(PDO::FETCH_ASSOC);
  if(empty($pass))return;

  $postpass=$_POST["pass"];
  if($pass["expel"]==-2){
    echo "Game already started. Retry later.";
    return;
  }

  $stmt = $pdo -> prepare("select count(id) from members");
  $stmt -> execute();
  $coloms =$stmt -> fetch(PDO::FETCH_ASSOC);
  $colom = $coloms["count(id)"]-1;
  $postName = filter_input(INPUT_POST,"name");
 if($postpass==$pass["job"]&&!empty($postName)){
   try {

    $stmt = $pdo -> prepare("INSERT INTO members (ID,Name,Event) VALUE (:id,:name,:event);");
    $stmt -> bindValue(':id',$colom+1);
    $stmt -> bindValue(':name',$_POST["name"]);
   $stmt->bindValue(':event',"Enter");
    $stmt -> execute();
    echo "welcome to ".$_POST["name"];
   } catch (PDOException $e) {
     require_once("ExceptionMapping.php");

     $message = $e->getMessage();
     $exceptionmsg = new ExceptionMapping($message);
     $exceptionmsg -> SQLExceptionMessenger();
   }
  }else{
    echo("Login Failure");
  }

 ?>
