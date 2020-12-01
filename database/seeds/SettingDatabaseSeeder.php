<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        setting::setMany([
            'default_locale' => 'ar',
            'default_timezone' => 'Africa/Cairo',
            'reviews_enabled' => true,
            'auto_approve_reviews' => true,
            'supported_currencies' => ['USD','LE','SAR'],
            'default_currency' => 'USD',
            'store_email' => 'ma990130@gmail.com',
            'search_engine' => 'mysql',
            'local_shipping_cost' => '0',
            'outer_shipping_cost' => '0',
            'free_shipping_cost' => '0',
            'translatable' => [
                'store_name' => 'متجر الاحلام',
                'free_shipping_labl' => 'توصيل مجاني',
                'local_shipping_labl' => 'توصيل داخلي',
                'outer_shipping_labl' => 'توصيل خارجي',
            ],
        ]);


    }
}
