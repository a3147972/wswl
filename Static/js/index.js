$(function() {
    var j = 0;

    $('#suggestId').dblclick(function() {
        $('.searchBox').hide();
    });
    $('#ser').click(function() {
        $('.searchBox').toggle();
    });
    $('#more').click(function() {
        $('.moreBox').toggle();
    });
    $('#moreClose').click(function() {
        $('.moreBox').toggle();
    });

});