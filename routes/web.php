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