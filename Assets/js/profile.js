/* RegEx for Password */
var passreg = /^(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{6,}$/;

/* Function to toggle/validate errors in input before form submission */
var regErrArray = [false, false];
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
    /* 5 Star Rating Plugin */
    $(".rating").rating();

    /* Handle all form submissions manually */
    $("form").submit(false);

    /* Create a new post */
    var defVisibility = 2;
    $("form.post").submit(function () {
        if ($("form.post .txt").val().trim() == "") return;

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

    $("form.post input[type=reset]").click(function () { $(this).closest(".newpost").addClass("no-focus"); });

    $("form.post .txt").focus(function () { $(this).closest(".newpost").removeClass("no-focus"); })

    $("form.post .visi").click(function () {
        if ($(this).data("val") != defVisibility) {
            $("form.post .visi").removeClass("active");
            $(this).addClass("active");
            defVisibility = $(this).data("val");
        }
    });



    // ================================================================================
    // Edit User's Details
    //
    $("form.details").submit(function () {
        $.ajax({
            url: "/profile/xhrChangeDetails",
            method: "post",
            data: new FormData($("form.details")[0]),
            processData: false,
            contentType: false,
            success: function (e) {
                if (e == "done") {
                    $("form.details .status").html("Saved.");
                    setTimeout(function () {
                        $("form.details .status").html("");
                    }, 2000);
                } else {

                }
            }
        })
    })

    // ================================================================================
    // Edit User's password
    //
    $("form.password").submit(function () {
        var uname = upass = $(".txt.upass", this), cpass = $(".txt.cpass", this);

        upass.blur();
        cpass.blur();

        if (upass.val().trim() !== "" && cpass.val().trim() !== "") {
            if (!(regErrArray[0] || regErrArray[1])) {
                $.ajax({
                    url: "/profile/xhrChangePassword",
                    method: "post",
                    data: { password: upass.val() },
                    success: function (e) {
                        if (e == "done") {
                            $("form.password .status").html("Saved.");
                            upass.val("");
                            cpass.val("");
                            setTimeout(function () {
                                $("form.password .status").html("");
                            }, 2000);
                        } else {
                        }
                    }
                })
            }
        }
    });

    /* Validate passwords before submission in settings page */
    $("form.password .txt.upass").blur(function () {
        toggleError($(this).val().trim() !== "" && !passreg.test($(this).val()), ".error.upass", this, 0);
    });

    $("form.password .txt.cpass").blur(function () {
        toggleError($(this).val().trim() !== "" && $(this).val() !== $("form.password .txt.upass").val(), ".error.cpass", this, 1);
    });



    // ================================================================================
    // Edit User's favourite Genres
    //
    // Open edit dialog
    //
    var onceBind = false;
    $(".edit.taste").click(function () {
        $("#edit-taste").fadeIn(function () {
            if (!onceBind) {
                InitializeEditDialog($("form.usergenre"), "user");
                onceBind = true;
            }
        });
    });



    // ================================================================================
    // Create new concert
    //
    // Open new concert dialog
    //
    $(".edit.concert").click(function () {
        var form1 = $("form.concert.form1"),
            error = [false, false, false, false, false],
            cname = $(".cname", form1),
            bandid = $(".bandid", form1),
            venueid = $(".venueid", form1),
            ctime1 = $(".ctime1", form1),
            ctime2 = $(".ctime2", form1),
            ticket = $(".ticket", form1),
            url = $(".url", form1),
            _Concert = 0;


        function toggleError(ctx, cond, i) {
            if (cond) ctx.addClass("error");
            else ctx.removeClass("error");
            error[i] = cond;
        }

        cname.unbind();
        bandid.unbind();
        venueid.unbind();
        ctime1.unbind();
        ctime2.unbind();
        form1.unbind().submit(false);

        cname.blur(function () { toggleError(cname, cname.val().trim() == "", 0); });
        bandid.blur(function () { toggleError(bandid, bandid.val().trim() == "", 1); });
        venueid.blur(function () { toggleError(venueid, venueid.val().trim() == "", 2); });
        ctime1.blur(function () { toggleError(ctime1, ctime1.val().trim() == "", 3); });
        ctime2.blur(function () { toggleError(ctime2, ctime2.val().trim() == "", 4); });

        form1.submit(function () {
            cname.blur();
            bandid.blur();
            venueid.blur();
            ctime1.blur();
            ctime2.blur();

            if (!(error[0] || error[1] || error[2] || error[3] || error[4])) {
                $.ajax({
                    url: '/profile/xhrCreateConcert',
                    data: new FormData(form1[0]),
                    processData: false,
                    contentType: false,
                    method: "post",
                    success: function (e) {
                        _Concert = parseInt(e);
                        if (_Concert > 0) {
                            if (!onceBind) {
                                InitializeEditDialog($("form.concertgenre"), "concert", _Concert);
                                onceBind = true;
                            }

                            form1.animate({ "height": "0px", "padding": "0px" });
                        } else {
                            alert("Something Went Wrong");
                        }
                    }
                })
            }
        })

        $("#edit-concert").fadeIn();
    });

    /* Close edit concert dialog */
    $("form.concert.form1 .cancel").click(function () { $("#edit-concert").fadeOut(); })



    // ================================================================================
    // Create new concert list
    //
    // Open new concert list dialog
    //
    $(".edit.list").click(function () {
        $("#edit-list").fadeIn();

        var form = $("form.userlist"),
            listname = $(".listname", form);

        listname.unbind();
        form.unbind().submit(false);

        listname.blur(function () {
            if (listname.val().trim() == "") listname.addClass("error");
            else listname.removeClass("error");
        });

        form.submit(function () {
            listname.blur();

            if (!listname.hasClass("error")) {
                $.ajax({
                    url: "/profile/xhrCreateList/" + listname.val(),
                    success: function () {
                        $("#edit-list").fadeOut(function () {
                            location.reload();
                        })
                    }
                });
            }
        });
    });

    /* close concert list dialog */
    $("form.userlist .cancel").click(function () { $("#edit-list").fadeOut(); })



    // ================================================================================
    // Delete existing list
    //
    $(".edit.deletelist").click(function () {
        var id = $(this).data("id");
        $.ajax({
            url: "/profile/xhrDeleteList/" + id,
            success: function (e) {
                location.href = "/profile/lists";
            }
        })
    });


    // ================================================================================
    // Manage Follow
    //
    $(".options .follow").click(function () {
        var id = $(this).data("id");
        var $url = $(this).hasClass("yes") ? "/profile/xhrDeleteFollow/" : "/profile/xhrCreateFollow/";
        $.ajax({
            url: $url + id,
            success: function (e) {
                location.reload();
            }
        })
    })


    // ================================================================================
    // Delete Posts
    //
    $(".block.post .delete").click(function () {
        var id = $(this).data("id");
        $.ajax({
            url: "/profile/xhrDeletePost/" + id,
            success: function (e) {
                location.reload();
            }
        })
    })


    // ================================================================================
    // Delete Reviews
    //
    $(".block.review .delete").click(function () {
        var id = $(this).data("id");
        $.ajax({
            url: "/profile/xhrDeleteReview/" + id,
            success: function (e) {
                location.reload();
            }
        })
    });

    // ================================================================================
    // Delete concert from list
    //
    $(".block.concert .delete").click(function (e) {
        e = e || Event;
        e.preventDefault();
        e.stopPropagation();
        var id = $(this).data("id");

        $.ajax({
            url: "/profile/xhrDeleteFromList/" + id,
            success: function () {
                location.reload();
            }
        })
    })

    // ================================================================================
    // Create new concert list
    //
    // Open new concert list dialog
    //
    $(".edit.band").click(function () {
        $("#edit-band").fadeIn();

        var form = $("form.band"),
            listname = $(".listname", form);

        listname.unbind();
        form.unbind().submit(false);

        listname.blur(function () {
            if (listname.val().trim() == "") listname.addClass("error");
            else listname.removeClass("error");
        });

        form.submit(function () {
            listname.blur();

            if (!listname.hasClass("error")) {
                $.ajax({
                    url: "/profile/xhrCreateBand/" + listname.val(),
                    success: function () {
                        $("#edit-list").fadeOut(function () {
                            console.log(e);
                            //location.reload();
                        })
                    }
                });
            }
        });
    });

    $("form.band .cancel").click(function () { $("#edit-band").fadeOut(); })
});