<?php

use Illuminate\Database\Seeder;
use App\Language;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::query()->insert([
            'code'=>'en',
        ]);
        Language::query()->insert([
            'code'=>'am',
        ]);
        Language::query()->insert([
            'code'=>'ru',
        ]);
    }
}
