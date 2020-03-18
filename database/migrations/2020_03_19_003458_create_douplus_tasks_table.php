<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDouplusTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('douplus_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('douyin_auth_id')->index()->nullable()->comment('投放账号id');
            $table->string('aweme_id')->index()->nullable()->comment('视频id,用于获取商品id');
            $table->string('aweme_author_id')->index()->nullable()->comment('视频作者id');
            $table->string('product_id')->index()->nullable()->comment('商品id');
            $table->string('task_id')->unique()->comment('热门消耗唯一ID');
            $table->string('state')->index()->nullable()->comment('状态');
            $table->string('cost')->nullable()->comment('本条消耗');
            $table->string('budget')->nullable()->comment('投放金额');
            $table->string('total_balance')->nullable()->comment('余额');
            $table->string('duration')->index()->nullable()->comment('投放时长，小时');
            $table->string('delivery_start_time')->index()->nullable()->comment('开始投放时间');
            $table->timestamp('create_time')->index()->nullable()->comment('创建时间');
            $table->string('reject_reason')->nullable()->comment('状态描述');
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
        Schema::dropIfExists('douplus_tasks');
    }
}
