$(document).ready(function () {
    var es = new EventSource('Broadcast.php');
    es.onmessage = function (event) {
        console.log(event);
        var jdata = $.parseJSON(event.data);
        console.log(jdata.ID + " " + jdata.Name + " " + jdata.Event + " send time " + jdata.time + "<br>");
        if (jdata.Event == "Enter") {
            AddMember(jdata);
        }
    };

    function AddMember(jdata) {
        console.log("Enter " + jdata.Name);
        $(".PlayersView").append('<div class="Player shadow" id="' + jdata.Name + '"><img src="icon.png"><span class="name">' + jdata.Name + '</span></div>');
    }
});
//
// <div class="Player shadow" id="hoge">
//            <!--DisplayTest User -->
//            <img src="icon.png">
//            <span class="name">Hoge</span>
//        </div>
