$(document).ready(function () {
    var es = new EventSource('Broadcast.php');
    es.onmessage = function (event) {
        var jdata = $.parseJSON(event.data);
        if (jdata.Event == "Enter") {
            AddMember(jdata);
        }
    };

    function AddMember(jdata) {
        console.log("Enter " + jdata.Name);
        $(".PlayersView").append('<div class="Player shadow" id="' + jdata.Name + '"><img src="icon.png"><span class="name">' + jdata.Name + '</span></div>');
    }
});
