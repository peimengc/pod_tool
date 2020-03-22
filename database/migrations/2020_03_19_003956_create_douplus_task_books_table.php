<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDouplusTaskBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('douplus_task_books', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('douyin_auth_id')->index()->nullable()->comment('投放账号id');
            $table->string('aweme_id')->index()->nullable()->comment('视频id,用于获取商品id');
            $table->string('aweme_author_id')->index()->nullable()->comment('视频作者id');
            $table->string('product_id')->index()->nullable()->comment('商品id');
            $table->string('task_id')->index()->comment('热门消耗唯一ID');
            $table->string('state')->index()->nullable()->comment('状态');
            $table->string('cost')->nullable()->comment('本条消耗');
            $table->string('cost_inc')->nullable()->comment('消耗增量');
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
        Schema::dropIfExists('douplus_task_books');
    }
}
