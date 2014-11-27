$(function () {
    $("form").submit(false);

    var defVisibility = 2;
    $("form.post").submit(function () {
        $.ajax({
            url: "/profile/xhrCreatePost",
            data: {
                text: $("form.post .txt").val(),
                visi: defVisibility
            },
            method: "post",
            success: function (e) {
                console.log(e);
            }
        });
    });

    $("form.post .txt").focus(function () { $(this).closest(".newpost").removeClass("no-focus"); })
    $("form.post .visi").click(function () {
        if ($(this).data("val") != defVisibility) {
            $("form.post .visi").removeClass("active");
            $(this).addClass("active");
            defVisibility = $(this).data("val");
        }
    })
})