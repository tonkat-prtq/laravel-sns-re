<?php

// docker-compose exec workspace php artisan make:controller ArticleController で作成
// Rails generate controller Articles みたいなもの
// 今回はdockerで環境を構築しているため、docker-compose exec workspace というコマンドが前についている
// Laravelでコントローラの雛形を作成するためのコマンド自体は php artisan make:controller ArticleController


namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index() // 以下、indexアクションメソッドの中身
    {
        $articles = [
            (object)[
                'id' => 1,
                'title' => 'タイトル1',
                'body' => '本文1',
                'created_at' => now(),
                'user' => (object)[
                    'id' => 1,
                    'name' => 'ユーザー名1'
                ],
            ],
            // (object)は型キャスト
            // 配列をオブジェクト型に変換している
            (object)[
                'id' => 2,
                'title' => 'タイトル2',
                'body' => '本文2',
                'created_at' => now(),
                'user' => (object)[
                    'id' => 2,
                    'name' => 'ユーザー名2',
                ],
            ],
        ];

        return view('articles.index', ['articles' => $articles]);
        // view('第一引数', ['第二引数'])
        // 第一引数にはビューファイルの場所を渡す
        // 'articles.index'とすることで、resources/views/articlesのindex.blade.phpを表示する
        // 第二引数には、ビューファイルに渡す変数の名称と、その変数の値を記述する
        // Railsでいう @logs = logs.all みたいな感じ
        // この場合、viewファイルに渡す変数の名称は'articles'
        // その中身は $articles(このファイルで定義しているもの)
    
    }
}
