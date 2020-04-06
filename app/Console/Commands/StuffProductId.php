<?php

namespace App\Console\Commands;

use App\DouplusTask;
use App\DouplusTaskBook;
use App\DouyinAweme;
use App\Helpers\Douyin\DouyinApp570Api;
use Illuminate\Console\Command;

class StuffProductId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stuff:product_id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '填充商品id';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $api = new DouyinApp570Api();

        DouyinAweme::all()->each(function (DouyinAweme $aweme) use ($api) {
            $product_id = $api->getShopPromotion($aweme->aweme_id);
            if (!$product_id) {
                return;
            }
            $aweme->product_id = $product_id;
            $aweme->save();

            DouplusTask::query()->where('aweme_id', $aweme->aweme_id)->update(['product_id' => $aweme->product_id]);
            DouplusTaskBook::query()->where('aweme_id', $aweme->aweme_id)->update(['product_id' => $aweme->product_id]);
        });
    }
}
