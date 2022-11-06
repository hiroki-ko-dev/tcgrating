$(document).ready( function() {
  //submitのボタン連打防止
  $('form').on('submit', function () {
    $('button').prop('disabled', true);
  });
});