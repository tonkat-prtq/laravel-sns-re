<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() // バリデーションのルールを設定
    {
        return [
            'title' => 'required|max:55', // ['required', 'max:50']でも可
            'body' => 'required|Max:500',
            'tags' => 'json|regex:/^(?!.*\s).+$/u|regex:/^(?!.*\/).*$/u',
        ];
    }

    public function attributes() // バリデーションエラーメッセージに表示させる項目名のカスタマイズ
    {
        return [
            'title' => 'タイトル',
            'body' => '本文',
            'tags' => 'タグ',
        ];
    }

    public function passedValidation() // フォームリクエストのバリデーションが成功したあとに自動的に呼ばれるメソッド
    {
        $this->tags = collect(json_decode($this->tags)) // json_decodeで、json形式の文字列であるタグ情報を連想配列に変換して、それを更にcollectでコレクションに変換している
            ->slice(0.5) // コレクションに変換することでsliceや下のmapメソッドが使える。slice(0,5)とすることでタグの数を5個に制限している
            ->map(function ($requestTag) {
                return $requestTag->text; // $requestTagの中の、'text'だけ抽出して返している
            });
    }
}
