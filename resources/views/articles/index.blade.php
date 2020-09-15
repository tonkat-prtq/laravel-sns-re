{{-- app.blade.phpをベースとして使う(継承する)ことを宣言 --}}
@extends('app') 

{{-- @yield('title')に対応し、記事一覧と表示される --}}
@section('title', '記事一覧')

{{-- @yield('content')に対応し、@endsectionまでのコードが代入される --}}
@section('content')
  {{-- includeでnav.blade.phpを取り込んでいる --}}
  @include('nav')
  <div class="container">
    {{-- Railsでいう articles.each do |article| --}}
    @foreach($articles as $article)
      @include('articles.card')
      {{-- cardを読み込んで記事一覧の表示を実装 --}}
      {{-- foreachで$articles(すべての記事)を1件ずつ$articleに代入しているため --}}
      {{-- card.blade.php内で$articleが使え、その中には記事1件の情報が入っている --}}
    @endforeach
  </div>
@endsection