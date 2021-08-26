<?php

use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name'=>'Внут. Рынок'],
            ['name'=>'Россия'],
            ['name'=>'Казахстан'],
            ['name'=>'Украина'],
            ['name'=>'Азербайжан'],
            ['name'=>'Белоруссия'],
            ['name'=>'Прочие'],
        ];

        \App\Region::insert($data);
    }
}
