

$(function () {
    //カレンダー機能の実装
    $('#datepicker').datepicker();

    //submitのボタン連打防止
    $('form').on('submit', function () {
        $('button').prop('disabled', true);
    });
});


