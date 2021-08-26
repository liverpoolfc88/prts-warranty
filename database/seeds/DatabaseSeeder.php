<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AclSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(ProblemTypesTableSeeder::class);
        $this->call(StageGroupsTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(RegionsTableSeeder::class);
    }
}
