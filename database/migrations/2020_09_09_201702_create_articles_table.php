<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('body');
            $table->bigInteger('user_id');
            // user_idというカラムを作成
            // foreignオプションで外部キー制約をつける
            // onで参照するテーブルを指定(ここではusers)
            // referencesで参照するカラムを指定(ここではid)
            // つまり、articlesテーブルのuser_idカラムは、usersテーブルのidカラムを参照する、という制約を設けている
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('articles');
    }
}
