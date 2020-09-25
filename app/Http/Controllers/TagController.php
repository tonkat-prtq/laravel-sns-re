<?php

namespace App\Http\Controllers;

use App\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show(string $name)
    {
        $tag = Tag::where('name', $name)->first();
        // この$nameには、ルーティング追加した /tags/{name} の {name}の部分に入る文字列が渡ってくる
        // $nameと一致するタグ名を持つタグモデルをコレクションで取得
        // firstで変数$tagに代入

        return view('tags.show', ['tag' => $tag]);
        // viewメソッドで、タグ別記事一覧画面のbladeを呼び出す
    }
}
