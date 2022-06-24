@extends('layouts.common.common')

@section('title','対戦')

@section('description')
  <meta name="description" content="ポケモンカードのブログ記事一覧です。最新情報から歴代パックや値段相場までまとめています。"/>
@endsection

@section('addCss')
  <link rel="stylesheet" href="{{ mix('/css/blog/show.css') }}">
@endsection

@section('addJs')
  <script src="//cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>
@endsection

@section('content')
  <div class="container">

    <div class="row justify-content-center">
      <!-- フラッシュメッセージ -->
      @if (session('flash_message'))
        <div class="col-12">
          <div class="text-center alert-danger rounded p-3 mb-3">
            {{ session('flash_message') }}
          </div>
        </div>
      @endif
    </div>

    <div class="row justify-content-center m-1 mb-3">
      <div class="col-12 page-header">
        {{ __('記事編集') }}
      </div>
    </div>
    <form method="POST" action="/blog/{{$blog->id}}">
      @csrf
      @method('PUT')

      @include('layouts.blog._form')

    </form>
  </div>

@endsection

@section('addScript')
  <script>
    // ClassicEditor
    //   .create( document.querySelector( '#editor' ) )
    //   .catch( error => {
    //     console.error( error );
    //   } );

    CKEDITOR.replace('editor', {
      contentsCss: [
        '/css/blog/show.css'
      ]
    });

    // CKEDITOR.stylesSet.add( 'default', [
    //   // Block Styles
    //   { name: 'List',       element: 'h3',      styles: { 'color': 'Blue' }, attributes: { class: 'some-class' }},
    //   { name: 'Red Title',        element: 'h3',      styles: { 'color': 'Red' }, attributes: { class: 'some-class' }},
    //
    //   // Inline Styles
    //   { name: 'Marker: Yellow',   element: 'span',    styles: { 'background-color': 'Yellow' } },
    //   { name: 'Marker: Green',    element: 'span',    styles: { 'background-color': 'Lime' } },
    //
    //   // Object Styles
    //   {
    //     name: 'Image on Left',
    //     element: 'img',
    //     attributes: {
    //       style: 'padding: 5px; margin-right: 5px',
    //       border: '2',
    //       align: 'left'
    //     }
    //   }
    // ] );
  </script>
@endsection

@include('layouts.common.header')
@include('layouts.common.google')
@include('layouts.common.footer')
