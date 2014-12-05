function InitializeEditDialog(Form, Mode, Concert) {
    var selectedGenre = null, selectedGenreId = null, selectedForm = Form, selectedMode = Mode;

    selectedForm.submit(false);

    resetSubGenreForm();

    /* Close edit dialog */
    $(".controls .btn.done", selectedForm).click(function () {
        resetSubGenreForm();
        $(selectedForm).closest(".edit-diag").fadeOut(function () {
            if (Mode == "concert") location.reload();
        });
    })

    /* Input events of dialog */
    $(".txt.genre", selectedForm).keyup(function () {
        refreshDatalist($(this).val(), $(".datalist", selectedForm));
    }).blur(function () {
        addSubGenre();
    }).focus(function () {
        refreshDatalist($(this).val(), $(".datalist", selectedForm));
    });

    $(".genres .genre", selectedForm).click(removeSubGenre);

    selectedForm.submit(function () {
        var list = $(".datalist", selectedForm);
        var key = $(".txt.genre", selectedForm).val();
        var hot = $("li:first-child", list);

        selectedGenre = hot.html();
        selectedGenreId = hot.data("id");

        addSubGenre();
        refreshDatalist(key, list);
    });

    /* Functions for handling input evennts in the edit genre dialog */
    function resetSubGenreForm() {
        selectedGenre = null;
        selectedGenreId = null;

        $(".txt.genre", selectedForm).val("");
    }

    function refreshDatalist(key, list) {
        $("li", list).unbind("hover");
        list.html("");        

        if (key.trim() != "") {
            $.ajax({
                url: "/profile/xhrSubGenres/" + Mode + (Concert != undefined ? "/" + Concert : "") + "?key=" + key,
                success: function (e) {
                    try {
                        e = eval(e);
                        for (i in e) {
                            list.append($("<li />").attr("data-id", e[i].subcatid).html(e[i].subcatname));
                            $("li", list).hover(function () {
                                selectedGenreId = $(this).data("id");
                                selectedGenre = $(this).html();
                            }, function () {
                                selectedGenre = null;
                                selectedGenreId = null;
                            })
                        }
                    } catch (e) {

                    }
                }
            });
        }
    }

    function addSubGenre() {
        if (selectedGenre != null) {
            var s1 = selectedGenre, s2 = selectedGenreId;
            $.ajax({
                url: '/profile/xhrAddGenre/' + Mode + "/" + s2 + (Concert != undefined ? "/" + Concert : ""),
                success: function () {                    
                    $(".genres", selectedForm).append(
                        $("<div class='genre' title='Click to remove' />")
                        .data("id", s2)
                        .html(s1)
                        .click(removeSubGenre)
                    );
                    resetSubGenreForm();
                }
            });
        }
    }

    function removeSubGenre() {
        var target = $(this);
        $.ajax({
            url: '/profile/xhrRemoveGenre/' + Mode + "/" + target.data("id") + (Concert != undefined ? "/" + Concert : ""),
            success: function (e) {
                target.remove();
                console.log(e);
                resetSubGenreForm();
            }
        })
    }
    /* End Functions for edit user genre dialog */
}