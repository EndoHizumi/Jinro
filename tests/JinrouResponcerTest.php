<DOCTYPE HTML>
  <head>
    <title>JinrouResponcerTest</title>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  </head>
  <body>
    <h1>JinrouResponcerTest</h1>
    <form id="submitForm" method="post" action="JinrouResponcer.php">
      名前：<input type="text" name="name">
      <BR>category:<BR>
      <input type="radio" name="category" value="ready">Ready
      <input type="radio" name="category" value="start">start
      <input type="radio" name="category" value="restart">restart
      <input type="radio" name="category" value="nextDay">nextDay
      <input type="radio" name="category" value="vote">vote
      <input type="radio" name="category" value="expel">expel
      <input type="radio" name="category" value="open">open
      <input type="radio" name="category" value="mystic">mystic
      <input type="radio" name="category" value="guard">guard<br>
      <input id="submitButton" type="button" value="送信"><br>
      <span id =status></span>
      <pre><span id =database></span></pre>
    </form>
    <table></table>

      <script>
      window.open = function(){
        $('#submitForm').submit(function(event) {
          event.preventDefault();
          $.ajax({
            type:'POST',
            url:'JinrouResponcer.php',
            data:$("#submitForm").serialize(),
             success: function(data){
               $("#status").html(data);
             }
          });
        });
      }
      </script>
  </body>
  </html>
