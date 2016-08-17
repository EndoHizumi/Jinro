<DOCTYPE HTML>
  <head>
    <title>テストページ</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  </head>
  <body>
    <h1>Test Page</h1>
    <form id="submitForm" action="#" method="POST">
      Name：<input type="text" name="name">
      Password：<input type="password" name="pass">
      <input id="submitButton" type="button" value="送信">
      <span id =status></span>
    </form>
      <script>
        $("#submitButton").click(function(){
          $.ajax({
            type:'POST',
            url:'CreateRoom.php',
            data:$("#submitForm").serialize(),
             success: function(data){
               $("#status").html(data);
             }
          });
        });
      </script>
  </body>
  </html>
