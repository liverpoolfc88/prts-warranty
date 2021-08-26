<?php

use Illuminate\Database\Seeder;

class DepartmentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name'=>'Press 1'],
            ['name'=>'Press 2'],
            ['name'=>'Body 1'],
            ['name'=>'Body 2'],
            ['name'=>'Paint'],
            ['name'=>'GA'],
            ['name'=>'PE'],
            ['name'=>'ME'],
            ['name'=>'QE'],
            ['name'=>'Supply Chain'],
            ['name'=>'Maintenance'],
            ['name'=>'SQE'],
            ['name'=>'Aftersales']
        ];

        \App\Department::insert($data);
    }
}
