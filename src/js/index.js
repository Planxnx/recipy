// $(window).load(function () {
//     if (search === 0) {
//         $('#myModal').css('display', 'block')
//         alert(search)
//     }
//
//     $("#closeBtn").click(function () {
//         $('#myModal').css('display', 'none')
//     });
//
// });

$(function () {
    $("#btnSearch").click(function () {
        $.ajax({
            url: "./src/service/search/search.php",
            type: "post",
            data: {searchText: $("#searchText").val()},
            beforeSend: function () {
                $(".loading").show();
                $("#list-data").hide();
            },
            complete: function () {
                $(".loading").hide();
                $("#list-data").show();
            },
            success: function (data) {
                $("#list-data").html(data);
            }
        });
    });
    $("#searchform").on("keyup keypress", function (e) {
        var code = e.keycode || e.which;
        if (code == 13) {
            $("#btnSearch").click();
            return false;
        }
    });
});