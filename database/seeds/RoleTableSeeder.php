<?php

use Illuminate\Database\Seeder;
use LaravelIssueTracker\Authorization\Models\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $owner               = new Role();
        $owner->name         = "owner";
        $owner->display_name = "Project Owner";
        $owner->description  = "Use this owner of the given project.";
        $owner->save();

        $admin               = new Role();
        $admin->name         = "admin";
        $admin->display_name = "Admin User";
        $admin->description  = "Admin role.";
        $admin->save();

        $user = App\User::find(1);
        $user->attachRole($admin); // parameter can be an Role object, array, or id
    }
}
