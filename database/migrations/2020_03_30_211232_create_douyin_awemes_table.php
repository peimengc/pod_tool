<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDouyinAwemesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('douyin_awemes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('aweme_id')->unique()->comment('视频id');
            $table->string('author_user_id')->index()->comment('作者');
            $table->string('product_id')->index()->nullable()->comment('商品id');
            $table->string('desc')->nullable()->comment('标题');
            $table->unsignedBigInteger('create_time')->comment('发布时间');
            $table->string('cover')->nullable()->comment('封面图');
            $table->text('share_url')->nullable()->comment('分享地址');
            $table->boolean('is_private')->default(false)->comment('私密');
            $table->boolean('with_goods')->default(false)->comment('小黄车');
            $table->unsignedBigInteger('forward_count')->default(0)->comment('转发');
            $table->unsignedBigInteger('comment_count')->default(0)->comment('评论');
            $table->unsignedBigInteger('digg_count')->default(0)->comment('点赞');
            $table->unsignedBigInteger('play_count')->default(0)->comment('播放');
            $table->unsignedBigInteger('share_count')->default(0)->comment('分享');
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
        Schema::dropIfExists('douyin_awemes');
    }
}
