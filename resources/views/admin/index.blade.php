@extends('layouts.common.common')

@section('content')
<div class="container">
  <div class="row justify-content-center m-1 mb-3">
    <div class="col-12 page-header">
      {{ __('管理者用ページ') }}
    </div>
  </div>

  <div class="row justify-content-center">
    <!-- フラッシュメッセージ -->
    @if (session('flash_message'))
      <div class="col-md-12">
        <div class="text-center alert-danger rounded p-3 mb-3">
          {{ session('flash_message') }}
        </div>
      </div>
    @endif
  </div>

  <div class="row justify-content-center pt-3 pb-3">
    <button type="submit" class="btn bg-primary text-white w-50" onclick="location.href='admin/item/transaction'">商品取引一覧</button>
  </div>

  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="box">
        <form action="">
          <table class="search table">
            <tr>
              <td class="heading">イベントID</td>
              <td colspan="3"><input type="number" name="event_id" value="{{ request('event_id') }}"/></td>
              <td>
                <button type="submit" style="width: 120px;">検索</button>
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="box">
        <div class="card-text border-bottom p-2">
          <table class="table">
              <thead>
              <tr>
                <th scope="col">順位</th>
                <th scope="col">対戦ID</th>
                <th scope="col">○回線</th>
                <th scope="col">ユーザーID</th>
                <th scope="col">名前</th>
                <th scope="col" class="text-left">勝敗</th>
                <th scope="col">rate</th>
              </tr>
              </thead>
              <tbody>
              @foreach($duels as $i => $duel)
                @foreach($duel->duelUsers as $duelUser)
                  @foreach($duelUser->duelUserResults as $duelUserResult)
                    <tr>
                      <td scope="col" class="align-middle">{{$duelUserResult->id}}</td>
                      <td scope="col" class="align-middle">{{$duel->id}}</td>
                      <td scope="col" class="align-middle">{{$duel->match_number}}</td>
                      <td scope="col" class="align-middle">{{$duelUser->user->id}}</td>
                        <td scope="col" class="align-middle">{{$duelUser->user->name}}</td>
                      <td scope="col" class="text-left align-middle">
                        @if($duelUserResult->result == 1)
                          勝ち{{$duelUserResult->result}}
                        @elseif($duelUserResult->result == 2)
                          負け{{$duelUserResult->result}}
                        @else
                          ドロー{{$duelUserResult->result}}
                        @endif
                      </td>
                        <td scope="col" class="align-middle"></td>
                    </tr>
                  @endforeach
                @endforeach
              @endforeach
              </tbody>
          </table>
        </div>
    </div>
  </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
