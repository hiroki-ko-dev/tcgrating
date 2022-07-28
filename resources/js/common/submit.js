

$(function () {
    //submitのボタン連打防止
    $('form').on('submit', function () {
        $(this).css('pointer-events','none');
    });
});


