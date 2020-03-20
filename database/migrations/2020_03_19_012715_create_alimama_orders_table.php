<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlimamaOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alimama_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('douyin_user_id')->index()->nullable()->comment('账号id');
            $table->string('tk_auth_id')->index()->comment('联盟id');

            $table->string('adzone_id')->index()->comment('广告位ID');
            $table->string('adzone_name')->nullable()->comment('推广位名称');
            $table->string('alimama_rate')->nullable()->comment('服务费%');
            $table->string('alimama_share_fee')->nullable()->comment('技术服务费');
            $table->string('alipay_total_price')->nullable()->comment('付款金额');
            $table->string('click_time')->index()->nullable()->comment('点击时间');
            $table->string('deposit_price')->nullable()->comment('预售时期，用户对预售商品支付的定金金额');
            $table->string('flow_source')->nullable()->comment('产品类型');
            $table->string('income_rate')->nullable()->comment('订单结算的佣金比率+平台的补贴比率');
            $table->string('item_category_name')->nullable()->comment('商品类目');
            $table->string('item_id')->index()->comment('商品id');
            $table->string('item_img')->nullable()->comment('商品图片');
            $table->string('item_link')->nullable()->comment('商品链接');
            $table->string('item_num')->nullable()->comment('商品数量');
            $table->string('item_price')->nullable()->comment('商品单价');
            $table->string('item_title')->nullable()->comment('商品标题');
            $table->string('order_type')->nullable()->comment('订单所属平台类型');
            $table->string('pub_id')->nullable()->comment('推广者的会员id');
            $table->string('pub_share_fee')->nullable()->comment('结算预估收入');
            $table->string('pub_share_pre_fee')->nullable()->comment('付款预估收入');
            $table->string('pub_share_rate')->nullable()->comment('总佣金占%');
            $table->string('refund_tag')->nullable()->comment('是否维权订单');
            $table->string('seller_nick')->nullable()->comment('掌柜旺旺');
            $table->string('seller_shop_title')->nullable()->comment('店铺名称');
            $table->string('site_id')->nullable()->comment('媒体管理下的ID');
            $table->string('site_name')->nullable()->comment('媒体管理下的对应ID的自定义名称');
            $table->string('subsidy_fee')->nullable()->comment('补贴金额');
            $table->string('subsidy_rate')->nullable()->comment('平台补贴%');
            $table->string('subsidy_type')->nullable()->comment('平台出资方');
            $table->string('tb_deposit_time')->nullable()->comment('预售时期，用户对预售商品支付定金的付款时间');
            $table->string('tb_paid_time')->index()->nullable()->comment('付款时间');
            $table->string('terminal_type')->nullable()->comment('成交平台');
            $table->string('tk_commission_fee_for_media_platform')->nullable()->comment('结算专项服务费');
            $table->string('tk_commission_pre_fee_for_media_platform')->nullable()->comment('预估专项服务费');
            $table->string('tk_commission_rate_for_media_platform')->nullable()->comment('专项服务费率');
            $table->string('tk_create_time')->index()->nullable()->comment('订单创建的时间');
            $table->string('tk_deposit_time')->nullable()->comment('预售时期，用户对预售商品支付定金的付款时间，可能略晚于在淘宝付定金时间');
            $table->string('tk_order_role')->nullable()->comment('佣金归属者');
            $table->string('tk_paid_time')->index()->nullable()->comment('付款时间');
            $table->string('tk_status')->index()->nullable()->comment('订单状态');
            $table->string('tk_total_rate')->nullable()->comment('实际收益%');
            $table->string('total_commission_fee')->nullable()->comment('佣金金额');
            $table->string('total_commission_rate')->nullable()->comment('佣金%');
            $table->string('trade_id')->unique()->comment('订单编号');
            $table->string('trade_parent_id')->nullable()->comment('淘宝后台订单编号');

            $table->string('tk_earning_time')->index()->nullable()->comment('佣金支付时间');
            $table->string('pay_price')->nullable()->comment('确认收货金额');
            $table->string('special_id')->nullable()->comment('会员运营id');
            $table->string('relation_id')->nullable()->comment('渠道关系id');
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
        Schema::dropIfExists('alimama_orders');
    }
}
