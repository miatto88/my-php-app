$(function() {
    $("body").on("click", "button[data-btn-type=ajax]", function() {
        console.log("click btn");

        var send_data;
        send_data = {
            id: $(this).attr("value")
        };
        console.log("ユーザーID : " + send_data["id"]);

        $.ajax({
            url: "../api/delete.php",
            type: "post",
            dataType: "json",
            data: send_data,
        })

        .done(function (response) {
            alert("成功");
            console.log("成功");
        })

        .fail(function () {
            alert("失敗");
            console.log("失敗");
        })
    })
});