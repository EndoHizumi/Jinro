<?php
//配役振り分け（親方）プログラム//
require("Common.php");
function actorAssigns($player){
  global $pdo;
  $actors = array("人狼","占い師","村人","狩人","狂人","霊媒師");//配役配列
  //参加人数に応じた配役の割合を示したデータをデータベースから取得
  $stmt = $pdo -> prepare("SELECT * FROM `actors` WHERE peoples=:value;");
  $stmt -> bindParam(':value',$player);
  $stmt -> execute();
  $assginList =$stmt -> fetch(PDO::FETCH_ASSOC);
  for($i=0;$i<=$assginList['Villager']-1;$i++){
       actorAssign($player,$actors[2]);
  }

  for($i=0;$i<=$assginList['wolf']-1;$i++){
       actorAssign($player,$actors[0]);
  }

  for($i=0;$i<=$assginList['fortune']-1;$i++){
       actorAssign($player,$actors[1]);
  }

  for($i=0;$i<=$assginList['hunter']-1;$i++){
       actorAssign($player,$actors[3]);
  }

  for($i=0;$i<=$assginList['cracker']-1;$i++){
       actorAssign($player,$actors[4]);
  }

  for($i=0;$i<=$assginList['mystic']-1;$i++){
       actorAssign($player,$actors[5]);
  }
}
function actorAssign($player,$actor){ //既に配役を持っている人に配役が回らないようにする
  global $pdo;
  global $postrand;
  $userID  = funcRand($player);

  if(JobalreadybyID($userID)===false){
  $stmt = $pdo -> prepare("UPDATE `members` SET job =:jobs,Event='start' WHERE ID=:ID;");
  $stmt -> bindParam(':ID',$userID);
  $stmt -> bindParam('jobs',$actor);
  echo("userID:$userID<br>Actor:$actor<br>");
  try {
    $stmt -> execute();
  } catch (Exception $e) {
    echo($e->getMessage);
    return(0);
  }
}else {
   actorAssign($player,$actor);
}
}

function funcRand($max){
  return  mt_rand(1,$max);
}

function JobalreadybyID($id){ //IDを渡すと既に配役を持っているか判断する
    global $pdo;
    $stmt = $pdo -> prepare("SELECT job FROM `members` WHERE id=:id;");
    $stmt -> bindParam(':id',$id);
    $stmt -> execute();
    $result =$stmt -> fetch(PDO::FETCH_ASSOC);
    var_dump(isset($result['job'])?True:false);
    return isset($result['job'])?True:false;
}
 ?>
