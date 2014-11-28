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
            complete: function (e) {
                location.reload();
            }
        });
    });

    $("form.post input[type=reset]").click(function () {  $(this).closest(".newpost").addClass("no-focus"); });

    $("form.post .txt").focus(function () { $(this).closest(".newpost").removeClass("no-focus"); })
    $("form.post .visi").click(function () {
        if ($(this).data("val") != defVisibility) {
            $("form.post .visi").removeClass("active");
            $(this).addClass("active");
            defVisibility = $(this).data("val");
        }
    });

    $(".rating").rating();
})