
//カレンダー機能の実装
$(function () {
  $("#datepicker").datepicker({
    dateFormat: 'yy/mm/dd',
  });
});

$(document).ready( function(){

    var today = new Date();

    var isDateExist = document.getElementById( "datepicker" ).value;

    if(!isDateExist) {
      var year = today.getFullYear();
      var month = today.getMonth() + 1
      var day = today.getDate();

      //日・時・分を取得
      var start_hour = ('00' + today.getHours()).slice(-2);
      var start_minute = ('00' + today.getMinutes()).slice(-2);

      document.getElementById("datepicker").value = year + "/" + month + "/" + day;
      document.getElementById('start_time').value = start_hour + ":" + start_minute;
      document.getElementById('end_time').value = start_hour + ":" + start_minute;
    }
});

