<?php

namespace App;

// Eloquent = モデルのこと
// Eloquent ORM(Eloquent Object Relational Mapping)
// データベースとモデルを関連付ける機能の名前

use Illuminate\Database\Eloquent\Model;

// 多対1のときBelongsTo
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// 多対多のときBelongsToMany
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    // strong parameter的な感じ
    // 前持って許可するプロパティを指定しておくことで、不正なリクエストを弾く
    protected $fillable = [
        'title',
        'body',
    ];

    // ArticleとUserは多(Articles)対1(user)
    // :BelongsToで、userメソッドの戻り値の型宣言
    // BelongsToクラス以外の型が帰ってきた場合はTypeErrorという例外が発生し処理が終了する
    public function user(): BelongsTo 
    {
        // この$thisはArticleクラスのインスタンス自身
        // この下のコードでは外部キー名の省略をしている
        return $this->belongsTo('App\User'); 
    }

    public function likes(): BelongsToMany
    {
        // belongsToManyの第一引数には関連付けたいモデルのモデル名を渡す
        // 第二引数には中間テーブルのテーブル名を渡す
        // 第二引数を省略すると、2つのモデル名の単数形をアルファベット順に結合した名前であるという前提で処理され、article_userという中間テーブルを参照する
        // しかし今回は中間テーブルの名前をlikesとしたので、第二引数にlikesを渡す必要がある
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }
}
