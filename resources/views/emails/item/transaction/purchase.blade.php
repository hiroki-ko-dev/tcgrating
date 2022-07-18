{{$transactionUser->last_name}} {{$transactionUser->first_name}} 様

リモートポケカ対戦サイトです。
この度は以下の商品についてご購入頂きありがとうござます。

■ 送付先情報
〒{{$transactionUser->post_code}}
{{config('assets.prefectures')[$transactionUser->prefecture_id]}}{{$transactionUser->address1}}{{$transactionUser->address2}}{{$transactionUser->address3}}


■ 商品情報
注文日時：{{$transaction->created_at}}
購入合計料金：{{number_format($transaction->price)}}円

==================================
@foreach($transaction->transactionItems as $i => $transactionItem)
購入商品 {{$i}} : {{$transactionItem->item->name}}
購入数：{{$transactionItem->quantity}}
小計：{{number_format($transactionItem->quantity * $transactionItem->price)}}

==================================
@endforeach

発送の準備をいたしますので少々お待ちください。
よろしくお願いいたします。
