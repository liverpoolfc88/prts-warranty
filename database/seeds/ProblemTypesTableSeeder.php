<?php

use Illuminate\Database\Seeder;

class ProblemTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name'=>'Warranty – Тех отчетлар'],
            ['name'=>'Warranty - Телеграм'],
        ];

        \App\ProblemType::insert($data);
    }
}
