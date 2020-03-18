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
            $table->string('dy_uid',20)->unique()->comment('抖音唯一标识');
            $table->string('dy_unique_id')->index()->comment('unique_id');
            $table->string('dy_short_id')->index()->comment('short_id');
            $table->string('dy_nickname')->nullable()->comment('昵称');
            $table->string('dy_avatar_url')->nullable()->comment('头像');
            $table->text('dy_cookie')->nullable()->comment('cookie');
            $table->string('tb_sub_pid')->nullable()->comment('淘宝pid');
            $table->string('tb_adzone_id')->index()->nullable()->comment('推广位');
            $table->unsignedBigInteger('favorited')->default(0)->comment('点赞');
            $table->unsignedBigInteger('follower')->default(0)->comment('粉丝');
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
