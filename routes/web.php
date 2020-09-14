<?php

Auth::routes();

// Railsのconfig/routes.rbのようなもの

Route::get('/', 'ArticleController@index');

// ('/') <- 第一引数にはURLを文字列で渡す
// ('ArticleController@index') <- 第二引数には、どのコントローラで何のメソッドを実行するのかを文字列で渡す
// ArticleControllerがコントローラの名前
// indexがアクションメソッド名(xRailsで言うアクション名)

// Railsでいう resources :articles
Route::resource('/articles', 'ArticleController');