/// <reference path='jquery.js' />
var passreg = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,}$/;
var regErrArray = [false, false, false];

function toggleError(cond, cls, ctx, rea) {
    if (cond) {
        $(cls).addClass("open");
        $(ctx).addClass("error");
    } else {
        $(cls).removeClass("open");
        $(ctx).removeClass("error");
    }

    if (rea != undefined) regErrArray[rea] = cond;
}

$(function () {
    $.ajaxSetup({
        beforeSend: function () {
            $(".loader").addClass("open");
        },
        complete: function () {
            $(".loader").removeClass("open");
        }
    });

    $("form").submit(false);
    $(".login").submit(function () {
        var uname = $(".uname", this), upass = $(".upass", this), ctx = this;
        if (uname.val().trim() !== "" && upass.val().trim() !== "") {
            toggleError(false, ".error.invalid", ctx)
            $.ajax({
                url: "/home/xhrCheckUser/" + uname.val() + "/" + upass.val(),
                success: function (e) {
                    try {
                        if (!eval(e)) {
                            toggleError(true, ".error.invalid", ctx);
                        } else {
                            location.href = "/profile";
                        }
                    } catch (e) {

                    }
                }
            });
        } else {
            toggleError(true, ".error.invalid", ctx)
        }
    });

    $(".register").submit(function () {
        var uname = $(".uname", this), upass = $(".upass", this), cpass = $(".cpass", this);

        upass.blur();
        cpass.blur();

        if (uname.val().trim() !== "" && upass.val().trim() !== "" && cpass.val().trim() !== "") {
            if (!(regErrArray[0] || regErrArray[1] || regErrArray[2])) {
                $.ajax({
                    url: "/home/xhrCreateUser/" + uname.val() + "/" + upass.val(),
                    success: function (e) {
                        location.href = "/home";
                    }
                })
            }
        }
    });

    var unameSTid = null;
    $(".register .uname").keyup(function () {
        clearTimeout(unameSTid);
        var uname = $(this), ctx = this;

        unameSTid = setTimeout(function () {
            if (uname.val().trim() !== "" && uname.val().trim().length >= 6) {
                toggleError(false, ".error.ulent", ctx, 0);
                $.ajax({
                    url: "/home/xhrCheckUser/" + uname.val(),
                    success: function (e) {
                        try {
                            toggleError(eval(e), ".error.uname", ctx, 0);
                        } catch (e) {

                        }
                    }
                });
            } else if (uname.val().trim() !== "" && uname.val().trim().length < 6) {
                toggleError(true, ".error.ulent", ctx, 0);
            }
            else {
                toggleError(false, ".error.ulent", ctx, 0);
                toggleError(false, ".error.uname", ctx, 0);
            }
        }, 500)
    });

    $(".register .upass").blur(function () {
        toggleError($(this).val().trim() !== "" && !passreg.test($(this).val()), ".error.upass", this, 1);
    });

    $(".register .cpass").blur(function () {
        toggleError($(this).val().trim() !== "" && $(this).val() !== $(".register .upass").val(), ".error.cpass", this, 2);
    });
});