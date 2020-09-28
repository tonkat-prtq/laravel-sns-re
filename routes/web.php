<?php

Auth::routes();

// Railsのconfig/routes.rbのようなもの

Route::get('/', 'ArticleController@index')->name('articles.index');

// ('/') <- 第一引数にはURLを文字列で渡す
// ('ArticleController@index') <- 第二引数には、どのコントローラで何のメソッドを実行するのかを文字列で渡す
// ArticleControllerがコントローラの名前
// indexがアクションメソッド名(xRailsで言うアクション名)
// ->name で名前をつけている

Route::resource('/articles', 'ArticleController')->except(['index', 'show'])->middleware('auth');
// Railsでいう resources :articles
// ->except でカッコ内のアクションに対応するルーティングが作られないようにしている
// middlewareでログイン時のみ投稿リンク表示を実現
// authミドルウェアは、コントローラでリクエストを処理する前に、ユーザー名がログイン済みであるかどうかをチェックし、なければログイン画面へリダイレクト

Route::resource('/articles', 'ArticleController')->only(['show']);
// onlyを繋げるとそのアクションのみ指定することができる、Railsのonlyと同じ感じ

// Route::prefix('articles')で、URIの先頭にarticlesをつける
// ->name('articles.')で、ルーティングに名前をつける
Route::prefix('articles')->name('articles.')->group(function() {
  // groupメソッドを使うことで、それまでに定義した内容がgroupメソッドに無名関数として渡した各ルーティングにまとめて適用される
  // ここではprefix('articles')とname('articles.')のこと
  Route::put('/{article}/like', 'ArticleController@like')->name('like')->middleware('auth');
  Route::delete('/{article}/like', 'ArticleController@unlike')->name('unlike')->middleware('auth');
});

Route::get('/tags/{name}', 'TagController@show')->name('tags.show');
// 引数$nameを受け取り、それが{name}に入る

Route::prefix('users')->name('users.')->group(function() {
  Route::get('/{name}', 'UserController@show')->name('show');
  Route::get('/{name}/likes', 'UserController@likes')->name('likes');
  Route::middleware('auth')->group(function () {
    Route::put('/{name}/follow', 'UserController@follow')->name('follow');
    Route::delete('/{name}/follow', 'UserController@unfollow')->name('unfollow');
  });
});