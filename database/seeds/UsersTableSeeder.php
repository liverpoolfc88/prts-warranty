<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new \App\User();
        $user->name = 'admin';
        $user->email = 'sheralim@gmail.com';
        $user->phone_number = '+998 90 3811777';
        $user->role = \App\User::ROLE_EMPLOYEE;
        $user->password = bcrypt('123456');
        $user->save();

        $roleAdmin = \App\Role::where('name','admin')->first();
        //$user->attachRole($roleAdmin);
        $user->roles()->attach($roleAdmin->id);

    }
}
