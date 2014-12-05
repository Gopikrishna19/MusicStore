(function ($) {
    var raterId = 0;
    $.fn.rating = function () {
        $(this).each(function (i) {
            var rate = $(this).data("rate");
            rate = rate == undefined ? 0 : rate;
            var dis = $(this).data("disabled") != undefined && $(this).data("disabled") == false ? "" : "disabled";
            $(this).html("");
            for (var i = 1; i <= 5; $(this).append("<input type='radio' " + "value='" + i + "' " +
                                        dis + " name='rate" + raterId + "' " +
                                        (i == rate ? "checked='true'" : "") + "><i></i>"), ++i);
            raterId += 1;
        });
    }

    $.fn.ratingAttr = function (rate) {
        $(this).each(function (i) {
            $(this).data("rate", rate);
            $(this).rating();
        });
    }
} (jQuery));