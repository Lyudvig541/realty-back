<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Category::query()->insert([
            'image'=>'',
        ]);
        \App\CategoryTranslation::query()->insert([
            'locale'=>'am',
            'name'=>'Վաճառք',
            'category_id'=>1
        ]);
        \App\CategoryTranslation::query()->insert([
            'locale'=>'en',
            'name'=>'Sale',
            'category_id'=>1
        ]);
        \App\CategoryTranslation::query()->insert([
            'locale'=>'ru',
            'name'=>'Продажа',
            'category_id'=>1
        ]);
        \App\Category::query()->insert([
            'image'=>'',
        ]);
        \App\CategoryTranslation::query()->insert([
            'locale'=>'am',
            'name'=>'Վարձակալություն',
            'category_id'=>2
        ]);
        \App\CategoryTranslation::query()->insert([
            'locale'=>'en',
            'name'=>'Rent',
            'category_id'=>2
        ]);
        \App\CategoryTranslation::query()->insert([
            'locale'=>'ru',
            'name'=>'Аренда',
            'category_id'=>2
        ]);
    }
}
