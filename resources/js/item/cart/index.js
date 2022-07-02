// 画面読み込みした際に実行
$(document).ready(function(){
  totalPrice();
});

// 合計金額を計算
function totalPrice(){
  var col = $(".subtotal").index();

  var total_price = 0;
  for(var i = 0; i < $("#cart_table").children('.row').length ; i++) {
    total_price += parseInt($(".subtotal").eq(i).text());
  }
  $('#total_price').text(total_price);
}

// 合計金額を計算
function subTotalPrice(){

  for(var i = 0; i < $("#cart_table").children('.row').length ; i++) {
    var price = parseInt($(".price").eq(i).text());
    var quantity = parseInt($(".quantity").eq(i).val());
    $(".subtotal").eq(i).text(quantity * price);

    console.log('price:' + price);
    console.log('quantity:' + quantity);
    console.log('subtotal:' + quantity * price);
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
      $(this).parents('.row').remove();
      totalPrice();
    })
    // Ajaxリクエストが失敗した場合
    .fail((error) => {
      alert("カート削除に失敗しました。");
    });
});
