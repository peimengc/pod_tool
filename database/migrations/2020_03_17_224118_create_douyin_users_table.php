<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDouyinUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('douyin_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('type')->index()->default(2)->comment('1投产号2橱窗号');
            $table->string('uid',20)->unique()->comment('抖音唯一标识');
            $table->string('unique_id')->index()->comment('unique_id');
            $table->string('short_id')->index()->comment('short_id');
            $table->string('nickname')->nullable()->comment('昵称');
            $table->string('avatar')->nullable()->comment('头像');
            $table->string('cookie')->nullable()->comment('cookie');
            $table->unsignedBigInteger('following')->default(0)->comment('关注');
            $table->unsignedBigInteger('favorited')->default(0)->comment('点赞');
            $table->unsignedBigInteger('follower')->default(0)->comment('粉丝');
            $table->unsignedBigInteger('aweme_count')->default(0)->comment('公开作品数');
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
        Schema::dropIfExists('douyin_users');
    }
}
