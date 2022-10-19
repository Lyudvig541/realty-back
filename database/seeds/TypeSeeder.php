<?php

use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Type::query()->insert([
            'slug' => 'house',
            'image'=>'',
        ]);
        \App\TypeTranslation::query()->insert([
            'locale'=>'am',
            'name'=>'Առանձնատուն',
            'type_id'=>1
        ]);
        \App\TypeTranslation::query()->insert([
            'locale'=>'en',
            'name'=>'House',
            'type_id'=>1
        ]);
        \App\TypeTranslation::query()->insert([
            'locale'=>'ru',
            'name'=>'Дом',
            'type_id'=>1
        ]);
        \App\Type::query()->insert([
            'slug' => 'apartment',
            'image'=>'',
        ]);
        \App\TypeTranslation::query()->insert([
            'locale'=>'am',
            'name'=>'Բնակարան',
            'type_id'=>2
        ]);
        \App\TypeTranslation::query()->insert([
            'locale'=>'en',
            'name'=>'Apartment',
            'type_id'=>2
        ]);
        \App\TypeTranslation::query()->insert([
            'locale'=>'ru',
            'name'=>'Квартира',
            'type_id'=>2
        ]);
        \App\Type::query()->insert([
            'slug' => 'commercial',
            'image'=>'',
        ]);
        \App\TypeTranslation::query()->insert([
            'locale'=>'am',
            'name'=>'Կոմերցիոն',
            'type_id'=>3
        ]);
        \App\TypeTranslation::query()->insert([
            'locale'=>'en',
            'name'=>'Commercial',
            'type_id'=>3
        ]);
        \App\TypeTranslation::query()->insert([
            'locale'=>'ru',
            'name'=>'Коммерческая недвижимость',
            'type_id'=>3
        ]);
        \App\Type::query()->insert([
            'slug' => 'land',
            'image'=>'',
        ]);
        \App\TypeTranslation::query()->insert([
            'locale'=>'am',
            'name'=>'Հողամաս',
            'type_id'=>4
        ]);
        \App\TypeTranslation::query()->insert([
            'locale'=>'en',
            'name'=>'Land',
            'type_id'=>4
        ]);
        \App\TypeTranslation::query()->insert([
            'locale'=>'ru',
            'name'=>'Земля',
            'type_id'=>4
        ]);
    }
}
