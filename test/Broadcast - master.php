<?php
  header('Content-Type: text/event-stream');
  header('Cache-Control:no-cache');
  require("Common.php");
  $lastID=isset($_SERVER["HTTP_LAST_EVENT_ID"]) ? intval($_SERVER["HTTP_LAST_EVENT_ID"]) : 0;
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $stmt = $pdo->prepare("SELECT * FROM test_trriger WHERE ID > :lastid");
  $stmt -> bindvalue(":lastid",$lastID,PDO::PARAM_INT);
  //while (1) {
    $stmt -> execute();
    $stmt -> debugDumpParams();
    $eventData = $stmt -> fetchAll(PDO::FETCH_ASSOC);
    print_r($eventData);
    write($eventData);
  /*  sleep(1);
}*/

  function write($Array){
    global $lastID;
    if($Array!=true){
    $jsn = json_encode(
      array(
        'ID'=>'Null ',
        'Name'=> 'no data.'
      )
    );
    echo("data: $jsn\n\n");
      return;
    }
      foreach($Array as $data){
        $logid = $data["ID"];
        $jsondata = json_encode(
          array(
            'ID' => $logid ,
            'Name'=> $data['Name'] ,
            'Event'=> $data['Event']
          )
        );
        echo("data: $jsondata\n\n");
        $lastID = $logid;
        ob_flush(); flush();
      }
  }
 ?>
