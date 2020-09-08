{{-- app.blade.phpをベースとして使う(継承する)ことを宣言 --}}
@extends('app') 

{{-- @yield('title')に対応し、記事一覧と表示される --}}
@section('title', '記事一覧')

{{-- @yield('content')に対応し、@endsectionまでのコードが代入される --}}
@section('content')
  <div class="container">
    <div class="card mt-3">
      {{-- Railsでいう articles.each do |article| --}}
      @foreach($articles as $article)
        <div class="card-body d-flex flex-row">
          <i class="fas fa-user-circle fa-3x mr-1"></i>
          <div>
            <div class="font-weight-bold">
              {{-- コントローラからbladeに渡された変数は{{ }} ←マスタッシュ で値を表示できる --}}
              {{-- Railsでいう、article.user.name --}}
              {{ $article->user->name }}
            </div>
            <div class="font-weight-lighter">
              {{-- Railsでいう、article.created_at.strftime('%Y/%m/%d %H:%i') --}}
              {{-- Laravelでは ->format で日付時刻のフォーマットを変更できる --}}
              {{ $article->created_at->format('Y/m/d H:i') }}
            </div>
          </div>
        </div>
        <div class="card-body pt-0 pb-2">
          <h3 class="h4 card-title">
            {{ $article->title }}
          </h3>
          <div class="card-text">
            {{ e($article->body) }}
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection