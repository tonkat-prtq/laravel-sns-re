@extends('app')

@section('title', '記事更新')

@include('nav')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <div class="card mt-3">
          <div class="card-body pt-0">
            @include('error_card_list')
            <div class="card-text">
              <form method="POST" action="{{ route('articles.update', ['article' => $article]) }}">
              {{-- formのアクションタグに route('articles.update')と書き記事更新処理のURLを指定し、第二引数['article' => $article]で、ルーティングのパラメーターを渡している --}}
              {{-- URIのarticleの部分に$articleのパラメータを渡す感じ。$articleにはid以外の情報も入っているがそこはLaravelが自動で識別して補完してくれる --}}
                @method('PATCH')
                {{-- HTMLのformタグは、PUTメソッドやPATCHメソッドをサポートしていない(DELETEメソッドもサポートしていない) --}}
                {{-- LaravelのBladeでPATCHメソッド等を使う場合は、formタグでは属性をPOSTのままとしつつ、@methodでPATCHメソッド等を指定する --}}
                @include('articles.form')
                <button type="submit" class="btn blue-gradient btn-block">更新する</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection