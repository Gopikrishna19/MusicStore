$(function () {
    $(".right .rating").rating();

    $("form.filter select").change(function () {
        $("form.filter").submit();
    });

    $("form:not(.filter)").submit(false);

    var formreview = $("form.review");

    formreview.submit(function () {
        var review = $(".txt", formreview),
            rating = $("input[type=radio]:checked", formreview),
            cid = $(".id", formreview).val();
        if (review.val().trim() == "" || rating.val() == undefined) return;

        $.ajax({
            url: '/concert/xhrAddReview',
            method: "post",
            data: {
                review: review.val(),
                rating: rating.val(),
                cid: cid
            },
            success: function (e) {
                location.reload();
            }
        })
    });

    $("input[type=reset]", formreview).click(function () { $(this).closest(".newpost").addClass("no-focus"); });
    $(".txt", formreview).focus(function () { $(this).closest(".newpost").removeClass("no-focus"); });

    $(".options .appr").click(function () {
        var cid = $("this").closest(".options").data("cid");
        $.ajax({
            url: '/concert/xhrApprove/' + cid,
            success: function (e) {
                location.reload();
            }
        })
    });

    $(".options .recommend").click(function () {
        var cid = $(this).closest(".options").data("cid");
        console.log(cid);
        $.ajax({
            url: '/concert/xhrRecommend/' + cid,
            success: function (e) {
                alert("You have recommended this concert to your followers" + e);
            }
        })
    });

    $(".options .delete").click(function () {
        var cid = $(this).closest(".options").data("cid");
        if (confirm("This concert will be deleted forever!")) {
            $.ajax({
                url: '/concert/xhrDeleteConcert/' + cid,
                success: function (e) {
                    location.href = "/concert";
                }
            })
        }
    });

    $(".options .attend").click(function () {
        var cid = $(this).closest(".options").data("cid");
        var mode = $(this).data("mode");

        $.ajax({
            url: '/concert/xhrAttendConcert/' + cid + "/" + mode,
            success: function (e) {
                location.reload();
            }
        })
    });


    // ================================================================================
    // Edit concert
    //
    // Open edit concert dialog
    //
    var onceBind = false;
    $(".options .edit").click(function () {
        var form1 = $("form.concert.form1"),
            error = [false, false, false, false, false],
            cname = $(".cname", form1),
            bandid = $(".bandid", form1),
            venueid = $(".venueid", form1),
            ctime1 = $(".ctime1", form1),
            ctime2 = $(".ctime2", form1),
            ticket = $(".ticket", form1),
            cid = $(".cid", form1).val(),
            url = $(".url", form1);

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
                    url: '/concert/xhrSaveConcert',
                    data: new FormData(form1[0]),
                    processData: false,
                    contentType: false,
                    method: "post",
                    success: function (e) {
                        if (!onceBind) {
                            InitializeEditDialog($("form.concertgenre"), "concert", cid);
                            onceBind = true;
                        }

                        form1.animate({ "height": "0px", "padding": "0px" });
                    }
                })
            }
        })

        $("#edit-concert").fadeIn();
    });

    /* Close edit concert dialog */
    $("form.concert.form1 .cancel").click(function () { $("#edit-concert").fadeOut(); })


    // ================================================================================
    // Add concert to list
    //
    // Open add concert dialog
    //    
    $(".options .addlist").click(function () {
        $("#add-list").fadeIn();

        var form1 = $("form.userlist"),
            error = false,
            listid = $(".listid", form1),
            cid = $(".cid", form1).val(),
            status = $(".status", form1),
            cancel = $(".cancel", form1);

        cancel.val("Cancel");
        status.html("");

        listid.unbind().blur(function () {
            if ($(this).val() == "") $(this).addClass("error");
            else $(this).removeClass("error");
            error = $(this).hasClass("error");
        });

        form1.unbind().submit(false).submit(function () {
            listid.blur();

            if (!error) {
                $.ajax({
                    url: '/concert/xhrAddToList/' + cid + '/' + listid.val(),
                    success: function (e) {
                        if (e == "1") {
                            cancel.val("Close");
                            status.html("Successfully added to the list");
                        } else if (e == "2") {
                            cancel.val("Close");
                            status.html("Already in the list");
                        } else {
                            console.log(e);
                            status.html("Something went wrong");
                        }
                    }
                })
            }
        });
    });

    /* Close edit concert dialog */
    $("form.userlist .cancel").click(function () { $("#add-list").fadeOut(); })
});