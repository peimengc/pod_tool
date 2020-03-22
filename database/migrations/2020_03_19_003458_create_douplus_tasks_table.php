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
            $table->string('douyin_auth_id')->index()->comment('投放账号id');
            $table->string('aweme_id')->index()->comment('视频id,用于获取商品id');
            $table->string('aweme_author_id')->index()->comment('视频作者id');
            $table->string('task_id')->unique()->comment('热门消耗唯一ID');
            $table->string('state')->index()->comment('状态');
            $table->string('budget')->nullable()->comment('投放金额');
            $table->timestamp('create_time')->index()->comment('创建时间');
            $table->string('reject_reason')->nullable()->comment('未通过原因');
            $table->string('state_desc')->nullable()->comment('状态描述');

            $table->string('product_id')->nullable()->index()->comment('商品id');

            $table->string('duration')->nullable()->comment('投放时长，小时');
            $table->string('cost')->nullable()->comment('本条消耗');
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
