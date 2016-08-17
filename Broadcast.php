<?php
  header('Content-Type: text/event-stream');
  header('Cache-Control:no-cache');
  require("Common.php");
  $lastID=isset($_SERVER["HTTP_LAST_EVENT_ID"]) ? intval($_SERVER["HTTP_LAST_EVENT_ID"]) : 0;
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $pdo->prepare("SELECT * FROM activity_logs WHERE ID > :lastid");
  while (1) {
    $stmt -> bindvalue(":lastid",$lastID);
    $stmt -> execute();
    $eventData = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    write($eventData);
  sleep(1);
}

  function write($Array){
    if($Array!=true) return;
    global $lastID;
    foreach($Array as $data){
      $logid = $data['ID'];
      $time = date('Y-m-d H:i:s');
      $jsondata = json_encode(
        array(
          'ID' => $logid ,
          'Name'=> $data['Name'] ,
          'Event'=> $data['Event'],
          'time'=> $time
        )
      );
      echo("id: $logid\n");
      echo("data: $jsondata\n\n");
      $lastID = $logid;
      ob_flush(); flush();
    }
  }
 ?>
