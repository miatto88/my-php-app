$(function() {
    $("body").on("click", "button[data-btn-type=ajax]", function() {
        console.log("click btn");

        var send_data = {
            id: $(this).attr("value")
        };
        console.log("item_id : " + send_data["id"]);

        $.ajax({
            url: "../api/delete.php",
            type: "post",
            dataType: "json",
            data: send_data,
        })

        .done(function(response) {
            console.log("ajax通信：成功");
            console.log(response);
            // 成功時、対象のDOM要素を削除
            if (response.result === "OK") {
                $("#item_id_" + send_data["id"]).remove();
            }
        })

        .fail(function(jqXHR, textStatus, errorThrown) {
            console.log("ajax通信：失敗");
            $(".messages").html("通信に失敗しました");
            
            console.log("jqXHR       : " + jqXHR.status); // HTTPステータス取得
            console.log("textStatus  : " + textStatus); // タイムアウト、パースエラー
            console.log("errorThrown : " + errorThrown.message); // 例外情報
        })
    })
});