<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{   
    // strong parameter的なもの
    // ここに記述されていないプロパティは、firstOrCreateやcreateメソッドでモデルが保存できない
    protected $fillable = [
        'name',
    ];
}
