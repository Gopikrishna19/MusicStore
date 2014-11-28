(function ($) {
    $.fn.rating = function () {
        $(this).each(function (i) {
            var rate = $(this).data("rate");
            $(this).html("");
            for (var i = 1; i <= 5; $(this).append("<input type='radio' disabled name='rate" + i + "' " + (i == rate ? "checked='true'" : "") + "><i></i>"), ++i);
        })
    }
} (jQuery));