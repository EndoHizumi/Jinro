<?php
    session_name("jinroPlayerID");
    session_start();
    require("Common.php");
    require("Actorassign.php");
    $category = mb_strtolower(filter_input(INPUT_POST, "category", FILTER_SANITIZE_STRING), "UTF-8");
    if (empty($category)) {
        header("HTTP/1.1 404 Not Found");
        return;
    }
    try {
        $requestToken = filter_input(INPUT_COOKIE, "token", FILTER_SANITIZE_STRING);
        if ($category != "enter" and ($_SESSION["token"] != $requestToken or empty($_SESSION['token']))) {
            header("HTTP/1.1 401 Unauthorized\n");
            return;
        }
        $result = $category();
        echo is_null($result)?"true\n":$result;
    } catch (\Throwable $th) {
        echo $th;
        echo "false\n";
    }finally{
        var_dump($_COOKIE);
        echo("------------\n");
        var_dump($_SESSION);
    }
 
    function runQuery(string $statement, array $bindParamMap=[])
    {
        // bindParamMapが入力されなかった場合、:nameをバインドに設定する。
        if (empty($bindParamMap)) {
            $playerName = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
            $bindParamMap = [":name"=>$playerName];
        };
        global $pdo;
        // SQLのエラーをExceptionとしてスローする。
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = $pdo -> prepare($statement);
        foreach ($bindParamMap as $key => $value) {
            $query -> bindParam($key, $value);
        }
        try{
            $execResult = $query -> execute();
        } catch (PDOException $e) {
            require_once("ExceptionMapping.php");
            $message = $e->getMessage();
            $exceptionmsg = new ExceptionMapping($message);
            return $exceptionmsg -> SQLExceptionMessenger();
        }
        $result = $query -> fetch(PDO::FETCH_ASSOC);
        // INSERTやUPDATEのときは、executeの結果を変えす。
        if (!$result) {
            $result = $execResult;
        }
        return $result;
    }

    function ready()
    {
        return runQuery("UPDATE members SET Ready=1,Event='Ready' WHERE Name=:name");
    }

    function restart()
    {
        return runQuery("UPDATE members SET Job=NULL,Ready= 0,vote= 0,expel= 0,Guard= 0,Event='Restart' WHERE ID != 0");
    }

    function standby()
    {
        return runQuery("UPDATE members SET Ready=0,Event='Standby' WHERE Name=:name");
    }

    function vote()
    {
        return runQuery("UPDATE members SET vote=vote+1,Event='Vote' WHERE Name=:name");
    }

    function expel()
    {
        return runQuery("UPDATE members SET expel=(SELECT MAX(expel) FROM members)+1,Event='expel' WHERE Name=:name");
    }

    function attack()
    {
        return runQuery("UPDATE members SET expel=-1,Event='Attack' WHERE Name=:name AND guard != 1");
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
        return runQuery("UPDATE members SET Guard=1,Event='Guard' WHERE Name=:name");
    }

    function nextDay()
    {
        return runQuery("UPDATE members SET Guard= 0,vote= 0,Event='NextDay' WHERE ID != 0");
    }

    function quit()
    {
        return runQuery("UPDATE members SET Job=NULL,Ready= 0,vote= 0,expel= 0,Guard= 0,Event='quit' WHERE ID != 0");
    }

    function fin()
    {
        runQuery("UPDATE members SET expel=0,Event='End' WHERE ID = 0");
        runQuery("DELETE FROM members WHERE ID != 0");
        runQuery("TRUNCATE activity_logs");
    }

    function start()
    {
        $gameOK = runQuery("SELECT `Ready` FROM `members` WHERE Ready=0 AND ID != 0");
        if (isset($gameOK["Ready"]) === false) {//Readyが0のカラムがない＝全員の準備が完了していると、判断する
            runQuery("UPDATE members SET expel=-2,Event='Start'  WHERE Name='game'");
            $colom = runQuery("select count(id) from members where ID != 0;")["count(id)"];//参加人数の取得
            actorAssigns($colom);
        } else {
            return("The Game Play is not enough players.");
        }
    }

    function message()
    {
        $colom=runQuery("select count(id) from activity_logs;")["count(id)"];
        $statement = ("INSERT INTO activity_logs (ID,Name,Event,Message,time) VALUE (:id,:name,:event,\"message\",:time);");
        $params = [
        ':id' => $colom+1,
        ':name' => filter_input(POST, "name", FILTER_SANITIZE_STRING),
        ':message' => filter_input(POST, "message", FILTER_SANITIZE_STRING),
        ':time' => date("Y/m/d H:i:s")
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
        return runQuery($statement, $params);
    }

    function enter()
    {
        // 部屋の情報を取得する。
        $roomInfo = runQuery("SELECT ID,job,expel FROM `members` WHERE id=0;");
        $requestPass = filter_input(INPUT_POST, "pass", FILTER_SANITIZE_STRING);
        $requestName = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
        if ($roomInfo['job'] == $requestPass&&!empty($requestName)) {
            // パスワードが一致した時
            $colom = runQuery("select count(id) from members")["count(id)"];
            $statement = "INSERT INTO members (ID,Name,Event) VALUE (:id,:name,\"Enter\");";
            $params = [
                ':id' => $colom+1,
                ':name'=> $requestName
            ];
            $result = runQuery($statement, $params);
            $token = openssl_random_pseudo_bytes(256);
            $_SESSION['token'] = $token;
            setcookie("token", $token);
            return $result ? "[000] Welcome to ${requestName}\n":"[999] Login Failure\n";
        } else {
            // パスワードが一致しない。
            return "[101] Login Failure\n";
        }
    }
