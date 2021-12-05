$(function() {
    $("body").on("click", "button[data-btn-type=ajax]", function() {
        console.log("click btn");

        $.ajax({
            url: "../api/createCsv.php",
            type: "post",
            dataType: "json"
        })

        .done(function(response) {
            console.log("ajax通信：成功");
            console.log(response);
            // 成功時、ダウンロードボタンを有効に
            $(".download").prop("disabled", false);
            $(".file_name").html(response);
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