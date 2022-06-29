// 画面読み込みした際に実行
$(document).ready(function(){
  totalPrice();
});

// 合計金額を計算
function totalPrice(){
  var col = $(".subtotal").index();

  var total_price = 0;
  for(var i = 0; i < $("#cart_table tbody").children().length - 1 ; i++) {
    total_price += parseInt($("#cart_table tbody tr").eq(i).children('td').eq(col).text());
  }
  $('#total_price').text(total_price);
}

// 合計金額を計算
function subTotalPrice(){
  var priceCol = $(".priceCol").index();
  var quantityCol = $(".quantityCol").index();
  var subTotalCol = $(".subtotalCol").index();

  for(var i = 0; i < $("#cart_table tbody").children().length - 1 ; i++) {
    var price = parseInt($("#cart_table tbody tr").eq(i).children('td').eq(priceCol).text());
    var quantity = parseInt($("#cart_table tbody tr").eq(i).children('td').eq(quantityCol).children('select').val());
    $("#cart_table tbody tr").eq(i).children('td').eq(subTotalCol).text(quantity * price);
  }
  totalPrice();
}

// 購入数の変更
$('.quantity').on('change', function() {
  var cart_id = $(this).data('id');
  var quantity = $(this).val();
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: 'PUT',
    url: '/item/cart/' + cart_id ,
    dataType: "json",
    data: {
      'cart_id': cart_id,
      'quantity': quantity
    },
  })
    // Ajaxリクエストが成功した場合
    .done(() => {
      subTotalPrice();
    })
    // Ajaxリクエストが失敗した場合
    .fail((error) => {
      alert("カート削除に失敗しました。");
    });
});

// デリートボタンクリック処理
$('.delete').on('click', function() {
  var cart_id = $(this).data('id');
  $.ajax({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: 'POST',
    url: '/item/cart/' + cart_id ,
    dataType: "json",
    data: {
      'cart_id': cart_id,
      '_method': 'DELETE'
    },
  })
    // Ajaxリクエストが成功した場合
    .done(() => {
      $(this).parents('tr').remove();
      totalPrice();
    })
    // Ajaxリクエストが失敗した場合
    .fail((error) => {
      alert("カート削除に失敗しました。");
    });
});
