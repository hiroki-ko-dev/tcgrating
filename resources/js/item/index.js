// カートに追加ボタンクリック処理
$('.cart_btn').on('click', function() {
  if(confirm('カートに追加しますか？。')){
    var item_id = $(this).attr('id').split('_')[1];
    var quantity = $('#quantity_' + item_id).val();
    $.ajax({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      type: 'POST',
      url: '/item/cart' ,
      dataType: "json",
      data: {
        item_id: item_id,
        quantity: quantity,
      },
    })
      // Ajaxリクエストが成功した場合
      .done((cart) => {
        let type = cart['type'];
        let message = cart['message'];

        $('.visible_' + item_id).fadeOut();
        html = '<div class="user-list">' + message + '</div>';
        $(".after_visible_" + item_id).append(html); //できあがったテンプレートを user-tableクラスの中に追加
        if(type === 'success'){
          let number = cart['number'];
          $('#cart-number').html('<p>' + number + '<p>').hide().fadeIn(1500);
        }

      })
      // Ajaxリクエストが失敗した場合
      .fail((error) => {
        alert("カート追加に失敗しました。");
      });
  }else{
  }
});
