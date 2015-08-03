(function ($) {
$(document).ready(function () {
    $("iframe.pepfeed-dropdown").hide();
    $("div.pepfeed-dropdown").hover(

    function () {
        $(this).children("iframe").css('width', '300px').css('height', '250px');
        $(this).children("iframe").stop(true, true).fadeIn('fast');
    },

    function () {
        $(this).children("iframe").stop(true, true).delay(500).fadeOut('medium');
    });

    function doSomething() {
        var el = $(this);
        var str = el.attr("data-pepfeed");
        $.ajax({
            url: str,
            dataType: 'jsonp',
            success: function (data) {
               el.html( 'Save $' + (data.content.store_offers)[0].price + ' with PepFeed');
//                $.each(data.content.store_offers, function (i, item) {
//                    el.html('Save $' + item.price + ' with PepFeed');
//                });
            }
        });
    }

    $(".pepfeed-button-class").each(doSomething);
});
}(jQuery));