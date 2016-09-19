$(document).ready(function () {
    var es = new EventSource('Broadcast.php');
    es.onmessage = function (event) {
        console.log(event);
        var jdata = $.parseJSON(event.data);
        console.log(jdata.ID + " " + jdata.Name + " " + jdata.Event + " send time " + jdata.time + "<br>");
    };

});
