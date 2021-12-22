$(function() {
    $("body").on("click", "button[data-btn-type=ajax]", function() {
        var COUNT = 2;
        var TOTAL = 1;

        console.log("click btn");

        $.ajax({
            url: "../api/createCsv.php",
            type: "post",
            dataType: "json"
        })

        .done(function(response) {
            console.log("ajax通信：成功");
            console.log(response);

            $(".download").html("出力中...");

            var timerId = setInterval(() => {
                $.ajax({
                    url: "../api/checkProgress.php",
                    type: "post",
                    dataType: "json"
                })

                .done(function(progress) {
                    console.log(progress[COUNT] + " / " + progress[TOTAL]);
                    $(".progress").css("width", Math.ceil(progress[COUNT] / progress[TOTAL] * 100) + "px");

                    // 出力が完了した時の処理
                    if (progress[COUNT] === progress[TOTAL]){
                        clearInterval(timerId);
                        $(".download").html("ダウンロード");
                        $(".download").prop("disabled", false);
                        $(".file_name").html(response);                        
                    }
                })
            }, 500);
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