$(document).ready(function () {
    $(".loginForm").submit(function () {
        var name = $(".loginForm [name = 'name']").val();
        var pass = $(".loginForm [name = 'pass']").val();
        loginFunction(name, pass);
        return false;
    });

    function loginFunction(name, pass) {
        if (name == "" || pass == "") {
            alert("名前もしくは合言葉が入力されていません");
            return;
        }
        $.ajax({
            type: "POST",
            url: "JinrouResponcer.php",
            data: "category=enter&name=" + name + "&pass=" + pass,

        }).done(function (data) {
            console.log(data);
            if (data.indexOf("000") != -1) {
                window.location.href = "/index.html";
            } else {
                $(".ErrArea").html(data);
            }
        });
    }
});
