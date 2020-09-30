<?php

// docker-compose exec workspace php artisan make:controller ArticleController で作成
// Rails generate controller Articles みたいなもの
// 今回はdockerで環境を構築しているため、docker-compose exec workspace というコマンドが前についている
// Laravelでコントローラの雛形を作成するためのコマンド自体は php artisan make:controller ArticleController


namespace App\Http\Controllers;
use App\Article;
use App\Tag;
use App\Http\Requests\ArticleRequest;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // 新しくオブジェクトが生成されるたびにこのメソッドを呼び出す
    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    public function index() // 以下、indexアクションメソッドの中身
    {   
        // Railsで言う、@logs = logs.all.order(created_at: :desc)
        // YWT Questでは並び替え用のメソッドはモデルのscopeに記述してた
        // allメソッドはモデルが持つクラスメソッドで、モデルの全データをコレクションで返す
        // Laravelの場合、sortByDescはコレクションのメソッド
        $articles = Article::all()->sortByDesc('created_at')
            ->load(['user', 'likes', 'tags']);

        return view('articles.index', ['articles' => $articles]);
        // view('第一引数', ['第二引数'])
        // 第一引数にはビューファイルの場所を渡す
        // 'articles.index'とすることで、resources/views/articlesのindex.blade.phpを表示する
        // 第二引数には、ビューファイルに渡す変数の名称と、その変数の値を記述する
        // Railsでいう @logs = logs.all みたいな感じ
        // この場合、viewファイルに渡す変数の名称は'articles'
        // その中身は $articles(このファイルで定義しているもの)
    
    }

    public function create()
    {
        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        return view('articles.create', [
            'allTagNames' => $allTagNames,
        ]);
    }

    public function store(ArticleRequest $request, Article $article)
    // (ArticleRequest $request, Article $article)
    // 第一引数 $request, 第二引数 $article
    // その手前のArticleRequestやArticleは、そのクラスのインスタンスであるということを宣言している
    // もしもstoreメソッドの該当する引数に、それ以外のインスタンスが渡されると、TypeErrorが発生して処理が中断する

    // また、DI(Dependency Injection)の意味もある
    // 訳：依存性の注入
    // Laravelのコントローラはメソッドの引数で型宣言を行うと、そのクラスのインスタンスが自動で生成されてメソッド内で使えるようになる
    // 依存している度合いを下げている
    {
        // $article->title = $request->title;
        // $article->body = $request->body;
        // Articleモデルのインスタンスである$articleのtitleとbodyに対し、
        // 記事登録画面から送信されたPOSTリクエストのbody部のタイトルと本文の値をそれぞれ代入している

        $article->fill($request->all());
        // articleモデルのfillableプロパティ内に指定しておいたプロパティ(title, body)が$articleの各プロパティに代入され
        // 上の2行のような記述が不要になる
        // また、不正なリクエストへの対策となる
        // strong parameter的な感じ

        $article->user_id = $request->user()->id;
        // user()メソッドを使うことでUserクラスのインスタンスにアクセスできるので、そこからuser.idを取得してArticleのuser_idに代入している
        $article->save();
        // モデルのsaveメソッドを使ってレコードを新規登録

        $request->tags->each(function ($tagName) use ($article) {

            // firstOrCreateで、渡ってきた$tagNameがTagテーブルのnameカラムの中に存在するかどうかを探し、存在すればそのモデルを、存在しなければそのレコードをテーブルに保存した上でモデルを返す
            $tag = Tag::firstOrCreate(['name' => $tagName]);

            // $tagにはタグモデルが代入されている
            // attachで$articleに$tagのレコードを新規追加
            $article->tags()->attach($tag);
        });
        return redirect()->route('articles.index');
    }

    public function edit(Article $article)
    // storeアクションメソッドと同じようにDI(Dependency Injection)をしているが、
    // editアクションメソッドの場合、$articleには、呼び出された時のURIが例えば
    // articles/3/edit であれば、idが3であるArticleモデルのインスタンスが代入される

    {
        $tagNames = $article->tags->map(function ($tag) {
            return ['text' => $tag->name];
        });

        $allTagNames = Tag::all()->map(function ($tag) {
            return ['text' => $tag->name];
        });

        return view('articles.edit', [
            'article' => $article,
            'tagNames' => $tagNames,
            'allTagNames' => $allTagNames,
        ]);
    }

    public function update(ArticleRequest $request, Article $article)
    {
        $article->fill($request->all())->save();
        // いったん記事のとタグの既存の紐付け情報を削除
        $article->tags()->detach();
        $request->tags->each(function ($tagName) use ($article) {
            $tag = Tag::firstOrCreate(['name' => $tagName]);
            // そのあとに、リクエスト通りのタグ情報を登録しなおす
            // そうすることで、記事更新処理でのタグ情報の付け外しを実現
            $article->tags()->attach($tag);
        });
        return redirect()->route('articles.index');
    }

    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('articles.index');
    }

    public function show(Article $article)
    {
        return view('articles.show', ['article' => $article])
        ->load(['articles.user', 'articles.likes', 'articles.tags']);
    }

    // いいねをするメソッド
    public function like(Request $request, Article $article)
    {
        // detachメソッドで最初に削除することで、いいねの多重登録を避ける
        $article->likes()->detach($request->user()->id);
        // attachメソッドで新規登録する
        $article->likes()->attach($request->user()->id);

        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }

    // いいねを外すメソッド
    public function unlike(Request $request, Article $article)
    {
        $article->likes()->detach($request->user()->id);
        
        return [
            'id' => $article->id,
            'countLikes' => $article->count_likes,
        ];
    }
}
