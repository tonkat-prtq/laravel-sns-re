<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->bigIncrements('id'); // いいねを識別するID
            $table->bigInteger('user_id'); // いいねしたユーザーのID

            // 外部キー制約
            // Likesテーブルのuser_idカラムには、usersテーブルのidと紐付けられ、そこに存在するidと同じ値のみ許可
            // onDelete('cascase')で、いいねをしたユーザーがusersテーブルから削除されたら、likesテーブルからそのユーザーに紐づくレコードが削除される
            // Railsでいうdependent: :destroy (ただしRailsであればusersテーブルに記述するはず)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade'); 
            $table->bigInteger('article_id'); // いいねされた記事のID
            $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
