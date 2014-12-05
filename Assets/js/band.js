$(function () {
    $(".options .fan").click(function () {
        var id = $(this).data("id");
        var $url = $(this).hasClass("yes") ? "/band/xhrDeleteFan/" : "/band/xhrCreateFan/";
        $.ajax({
            url: $url + id,
            success: function (e) {
                location.reload();
            }
        })
    });

    $("form.filter select").change(function () {
        $("form.filter").submit();
    });
})