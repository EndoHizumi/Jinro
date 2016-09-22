<?php
try {
$pdo = new PDO('mysql:host=127.0.0.1;dbname=winvis;charset=utf8','root','php1850',
array(PDO::ATTR_EMULATE_PREPARES => false));
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
 echo('データベース接続失敗。'.$e->getMessage());
 return;
}
?>
