<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AclSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            ['name'=>'admin', 'display_name'=>'Administrator', 'description'=>'Tha administrator of PRR system'],
            ['name'=>'manager', 'display_name'=>'Manager', 'description'=>'Section manager'],
            ['name'=>'employee', 'display_name'=>'GM Employee', 'description'=>'SQE team member'],
            ['name'=>'department', 'display_name'=>'Department', 'description'=>'Local department'],
        ];

        \App\Role::insert($roles);

        $permissions = [
            ['name'=>'manage-user', 'display_name'=>'Manage users permission', 'description'=>'Permission to list, create, edit or delete users'],
            ['name'=>'create-problem', 'display_name'=>'Create a problem permission', 'description'=>'Permission to create problem'],
            ['name'=>'update-problem', 'display_name'=>'Update the problem permission', 'description'=>'Permission to update problem'],
            ['name'=>'delete-problem', 'display_name'=>'Delete the problems permission', 'description'=>'Permission to delete problem'],
            ['name'=>'manage-stage-group', 'display_name'=>'Manage stage group permission', 'description'=>'Permission to create, edit or delete stage groups'],
            ['name'=>'manage-stage', 'display_name'=>'Manage stage permission', 'description'=>'Permission to create, edit or delete stages'],
            ['name'=>'manage-department', 'display_name'=>'Manage Supplier permission', 'description'=>'Permission to create, edit or delete suppliers'],
            ['name'=>'accept-stage', 'display_name'=>'Accept Stage permission', 'description'=>'Permission to accept or reject the stage'],
            ['name'=>'file-upload', 'display_name'=>'Upload files permission', 'description'=>'Permission to upload a file'],
            ['name'=>'stage-comment', 'display_name'=>'Comment stage permission', 'description'=>'Permission to comment stage']
        ];
        \App\Permission::insert($permissions);

        $role_permission=[
            ['permission_id'=>1, 'role_id'=>1],
            ['permission_id'=>2, 'role_id'=>3],
            ['permission_id'=>3, 'role_id'=>2],
            ['permission_id'=>3, 'role_id'=>3],
            ['permission_id'=>4, 'role_id'=>1],
            ['permission_id'=>4, 'role_id'=>2],
            ['permission_id'=>5, 'role_id'=>1],
            ['permission_id'=>6, 'role_id'=>1],
            ['permission_id'=>7, 'role_id'=>1],
            ['permission_id'=>8, 'role_id'=>3],
            ['permission_id'=>9, 'role_id'=>3],
            ['permission_id'=>9, 'role_id'=>4],
            ['permission_id'=>10, 'role_id'=>2],
            ['permission_id'=>10, 'role_id'=>3],
            ['permission_id'=>10, 'role_id'=>4]
        ];

        DB::table('permission_role')->insert($role_permission);
    }
}
