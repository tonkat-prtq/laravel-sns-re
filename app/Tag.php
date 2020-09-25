<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{   
    // strong parameter的なもの
    // ここに記述されていないプロパティは、firstOrCreateやcreateメソッドでモデルが保存できない
    protected $fillable = [
        'name',
    ];

    public function getHashtagAttribute(): string // アクセサ
    {
        return '#' . $this->name;
    }

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany('App\Article')->withTimestamps();
    }
}
