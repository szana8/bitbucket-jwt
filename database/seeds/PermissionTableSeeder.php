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

        $globalPermissionList = [

            [
                'name' => 'create-user',
                'display_name' => 'Create User',
                'description' => 'Create new User'
            ],
            [
                'name' => 'edit-user',
                'display_name' => 'Edit User',
                'description' => 'Edit a User'
            ],
            [
                'name' => 'remove-user',
                'display_name' => 'Remove User',
                'description' => 'Remove a User'
            ],

            [
                'name' => 'create-role',
                'display_name' => 'Create Role',
                'description' => 'Create new Role'
            ],
            [
                'name' => 'edit-role',
                'display_name' => 'Edit Role',
                'description' => 'Edit a Role'
            ],
            [
                'name' => 'remove-role',
                'display_name' => 'Remove Role',
                'description' => 'Remove a Role'
            ],

            [
                'name' => 'create-permission',
                'display_name' => 'Create Permission',
                'description' => 'Create new Permission'
            ],
            [
                'name' => 'edit-permission',
                'display_name' => 'Edit Permission',
                'description' => 'Edit a Permission'
            ],
            [
                'name' => 'remove-permission',
                'display_name' => 'Remove Permission',
                'description' => 'Remove a Permission'
            ],

            [
                'name' => 'create-metadata',
                'display_name' => 'Create Metadata',
                'description' => 'Create new Metadata'
            ],
            [
                'name' => 'edit-metadata',
                'display_name' => 'Edit Metadata',
                'description' => 'Edit a Metadata'
            ],
            [
                'name' => 'remove-metadata',
                'display_name' => 'Remove Metadata',
                'description' => 'Remove a Metadata'
            ],

            [
                'name' => 'create-list-of-value',
                'display_name' => 'Create List Of Value',
                'description' => 'Create new List Of Value'
            ],
            [
                'name' => 'edit-list-of-value',
                'display_name' => 'Edit List Of Value',
                'description' => 'Edit a List Of Value'
            ],
            [
                'name' => 'remove-list-of-value',
                'display_name' => 'Remove List Of Value',
                'description' => 'Remove a List Of Value'
            ],
        ];

        foreach($globalPermissionList as $permissions)
        {
            Permission::create($permissions);
        }

    }
}
