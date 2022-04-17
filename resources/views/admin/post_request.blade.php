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

  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="box">
        <form method="POST" action="https://exp.host/--/api/v2/push/send">
          @csrf
          <input type="hidden" name="to" value="ExponentPushToken[KhlJf8PvNsZ5b9wqDQoIPB]">
          <input type="hidden" name="sound" value="default">
          <input type="hidden" name="title" value="titleテスト">
          <input type="hidden" name="body" value="bodyテスト">

          <table class="search table">
            <tr>
              <td class="heading">イベントID</td>
              <td>
                <button type="submit" style="width: 120px;">検索</button>
              </td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
