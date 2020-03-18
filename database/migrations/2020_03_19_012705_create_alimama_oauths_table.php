<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlimamaOauthsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alimama_oauths', function (Blueprint $table) {
            $table->increments('id');
            $table->string('taobao_user_id')->unique()->comment('淘宝用户id');
            $table->string('taobao_user_nick')->index()->comment('授权账号名称');
            $table->string('access_token')->nullable();
            $table->unsignedTinyInteger('status')->default(1)->comment('1可用 2失效');
            $table->timestamp('expire_time')->nullable()->comment('失效时间');
            $table->json('oauth_json')->nullable()->comment('token');
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
        Schema::dropIfExists('alimama_oauths');
    }
}
