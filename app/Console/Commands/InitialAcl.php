<?php

namespace App\Console\Commands;

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class InitialAcl extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acl:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Initialize ACL (Roles and permissions)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        //DB::table('permissions')->delete();
        //DB::table('roles')->delete();
        //Permission::truncate();
        //Role::truncate();
        //DB::statement('TRUNCATE permissions CASCADE');
        //DB::statement('TRUNCATE roles CASCADE');
        //DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // create permissions

        // user management
        $manageUser = new Permission();
        $manageUser->name         = 'manage-user';
        $manageUser->display_name = 'Manage users permission'; // optional
        $manageUser->description  = 'Permission to list, create, edit or delete users'; // optional
        $manageUser->save();

        //problem management
        $createProblem = new Permission();
        $createProblem->name         = 'create-problem';
        $createProblem->display_name = 'Create a problem permission';
        $createProblem->description  = 'Permission to create problem';
        $createProblem->save();

        $updateProblem = new Permission();
        $updateProblem->name         = 'update-problem';
        $updateProblem->display_name = 'Update the problem permission';
        $updateProblem->description  = 'Permission to update problem';
        $updateProblem->save();

        $deleteProblem = new Permission();
        $deleteProblem->name         = 'delete-problem';
        $deleteProblem->display_name = 'Delete the problems permission';
        $deleteProblem->description  = 'Permission to delete problem';
        $deleteProblem->save();

        //stage group management
        $manageGroup = new Permission();
        $manageGroup->name         = 'manage-stage-group';
        $manageGroup->display_name = 'Manage stage group permission';
        $manageGroup->description  = 'Permission to create, edit or delete stage groups';
        $manageGroup->save();

        //stage management
        $manageStage = new Permission();
        $manageStage->name         = 'manage-stage';
        $manageStage->display_name = 'Manage stage permission';
        $manageStage->description  = 'Permission to create, edit or delete stages';
        $manageStage->save();

        // supplier management
        $manageSupplier = new Permission();
        $manageSupplier->name         = 'manage-supplier';
        $manageSupplier->display_name = 'Manage Supplier permission';
        $manageSupplier->description  = 'Permission to create, edit or delete suppliers';
        $manageSupplier->save();

        //accept stage
        $acceptStage = new Permission();
        $acceptStage->name         = 'accept-stage';
        $acceptStage->display_name = 'Accept Stage permission';
        $acceptStage->description  = 'Permission to accept or reject the stage';
        $acceptStage->save();

        //file upload
        $fileUpload = new Permission();
        $fileUpload->name         = 'file-upload';
        $fileUpload->display_name = 'Upload files permission';
        $fileUpload->description  = 'Permission to upload a file';
        $fileUpload->save();

        //comment problem
        $commentStage = new Permission();
        $commentStage->name         = 'stage-comment';
        $commentStage->display_name = 'Comment stage permission';
        $commentStage->description  = 'Permission to comment stage';
        $commentStage->save();

        //Role::truncate();

        $admin = new Role();
        $admin->name         = 'admin';
        $admin->display_name = 'Administrator';
        $admin->description  = 'Tha administrator of PRR system';
        $admin->save();

        $manager = new Role();
        $manager->name         = 'manager';
        $manager->display_name = 'Manager';
        $manager->description  = 'Section manager';
        $manager->save();

        $employee = new Role();
        $employee->name         = 'employee';
        $employee->display_name = 'GM Employee';
        $employee->description  = 'SQE team member';
        $employee->save();

        $supplier = new Role();
        $supplier->name         = 'supplier';
        $supplier->display_name = 'Supplier';
        $supplier->description  = 'Local supplier';
        $supplier->save();

        $admin->attachPermissions([
            $manageUser->id,
            $manageGroup->id,
            $manageStage->id,
            $manageSupplier->id,
            $deleteProblem->id,
        ]);

        $manager->attachPermissions([
            $deleteProblem->id,
            $updateProblem->id,
            $commentStage->id
        ]);

        $employee->attachPermissions([
            $createProblem->id,
            $updateProblem->id,
            $acceptStage->id,
            $commentStage->id,
            $fileUpload->id
        ]);

        $supplier->attachPermissions([
            $commentStage->id,
            $fileUpload->id
        ]);

    }
}
