@extends('layouts.common.common')

@section('content')
<div class="container">
    <div class="site-color text-white rounded p-3 mb-3">
        <h3>{{ __('チーム編集') }}</h3>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <form method="POST" action="/team/{{$team->id}}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="id" value="{{$team->id}}">
                    <div class="card">

                        <div class="card-header">{{ __('チーム名') }}</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control w-100 @error('name') is-invalid @enderror" name="name" value="{{ old('name',$team->name) }}" required autocomplete="name" autofocus>
                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-header">{{ __('プロフィール文') }}</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <textarea id="body" class="form-control w-100 @error('body') is-invalid @enderror" name="body" >{{ old('body',$team->body) }}</textarea>
                                    @error('body')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-header">{{ __('メンバー募集ステータス') }}</div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <select name="recruit_status" class="form-select" aria-label="Default select example">
                                        <option value="{{\App\Models\Team::STATUS_RECRUIT}}" @if(old('recruit_status',$team->recruit_status == \App\Models\Team::RECRUIT))selected @endif>募集中</option>
                                        <option value="{{\App\Models\Team::STATUS_FINISH}}" @if(old('recruit_status',$team->recruit_status == \App\Models\Team::FINISH))selected @endif>募集しない</option>
                                    </select>
                                    @error('recruit_status')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-3">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('保存') }}
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
