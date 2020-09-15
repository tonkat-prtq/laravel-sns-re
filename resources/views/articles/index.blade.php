{{-- app.blade.phpをベースとして使う(継承する)ことを宣言 --}}
@extends('app') 

{{-- @yield('title')に対応し、記事一覧と表示される --}}
@section('title', '記事一覧')

{{-- @yield('content')に対応し、@endsectionまでのコードが代入される --}}
@section('content')
  {{-- includeでnav.blade.phpを取り込んでいる --}}
  @include('nav')
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
          @if( Auth::id() === $article->user_id )
          {{-- 記事ごとの更新/削除メニューは、その記事を投稿したユーザーにのみ表示する必要がある --}}
            <!-- dropdown -->
            <div class="ml-auto card-text">
              <div class="dropdown">
                <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <button type="button" class="btn btn-link text-muted m-0 p-2">
                    <i class="fas fa-ellipsis-v"></i>
                  </button>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                  <a class="dropdown-item" href="{{ route("articles.edit", ['article' => $article]) }}">
                    <i class="fas fa-pen mr-1"></i>記事を更新する
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item text-danger" data-toggle="modal" data-target="#modal-delete-{{ $article->id }}">
                    <i class="fas fa-trash-alt mr-1"></i>記事を削除する
                  </a>
                </div>
              </div>
            </div>
            <!-- dropdown -->
    
            <!-- modal -->
            <div id="modal-delete-{{ $article->id }}" class="modal fade" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="閉じる">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form method="POST" action="{{ route('articles.destroy', ['article' => $article]) }}">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body">
                      {{ $article->title }}を削除します。よろしいですか？
                    </div>
                    <div class="modal-footer justify-content-between">
                      <a class="btn btn-outline-grey" data-dismiss="modal">キャンセル</a>
                      <button type="submit" class="btn btn-danger">削除する</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <!-- modal -->
          @endif

        </div>
        <div class="card-body pt-0 pb-2">
          <h3 class="h4 card-title">
            {{ $article->title }}
          </h3>
          <div class="card-text">
            {{-- e($article->body)で、body内の改行タグをエスケープする --}}
            {{-- nl2br()で改行を<br>に置き換える --}}
            {{-- {!! !!}で、<br>だけエスケープをせずに出力する --}}
            {!! nl2br(e( $article->body )) !!}
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection