<?php

use Illuminate\Database\Seeder;
use LaravelIssueTracker\Authorization\Models\Permission;
use LaravelIssueTracker\Authorization\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $createPermission               = new Permission();
        $createPermission->name         = "create-issue";
        $createPermission->display_name = "Create Issue";
        $createPermission->description  = "Create new issue";
        $createPermission->save();

        $editPermission               = new Permission();
        $editPermission->name         = "edit-issue";
        $editPermission->display_name = "Edit Issue";
        $editPermission->description  = "Edit an issue";
        $editPermission->save();

        $deletePermission               = new Permission();
        $deletePermission->name         = "delete-issue";
        $deletePermission->display_name = "DdeletePlete Issue";
        $deletePermission->description  = "Delete an issue";
        $deletePermission->save();

        $admin = Role::findOrFail(1);

        $admin->attachPermissions([
            $createPermission,
            $editPermission,
            $deletePermission
        ]);
    }
}
