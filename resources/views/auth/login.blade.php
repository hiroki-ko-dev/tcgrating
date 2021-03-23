@extends('layouts.common.common')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-6 mx-auto">
                <article class="card-body">
                    <h4 class="card-title text-center mb-4 mt-1">ログイン画面</h4>
                    <hr>
                    <form>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                </div>
                                <input name="" class="form-control" placeholder="Email or ユーザアカウント名" type="email">
                            </div> <!-- input-group.// -->
                        </div> <!-- form-group// -->
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                </div>
                                <input class="form-control" placeholder="******" type="password">
                            </div> <!-- input-group.// -->
                        </div> <!-- form-group// -->
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block"> Login  </button>
                        </div> <!-- form-group// -->
                        <p class="text-center"><a href="#" class="btn">Forgot password?</a></p>
                        <p class="text-center"><a href="#" class="btn">アカウント新規作成</a></p>
                    </form>
                </article>
            </div><!-- /card-container -->
        </div>
    </div><!-- /container -->
@endsection

@include('layouts.common.header')
@include('layouts.common.adsense')
@include('layouts.common.footer')

