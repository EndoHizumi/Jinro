<?php
class ExceptionMapping{
 private $ExceptionMsg = null;
 private $code2String = [
   "23000"=>"その名前は既に使われています。"
 ];

  function __construct($message){
    $this -> ExceptionMsg = $message;
  }

  function SQLExceptionMessenger(){
    // 渡されたＳＱＬエラーメッセージから、エラーコードを取り出して、
    // 対応するメッセージを表示する
    $exceptionCode= substr($this -> ExceptionMsg,9,5);
    echo($this -> code2String[$exceptionCode]);
  }

}
