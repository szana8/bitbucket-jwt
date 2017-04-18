<?php

use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{

    private $_projects = [
        [
            "name"        => "SCRUM",
            "key"         => "SCR",
            "type"        => "Scrum Software Development",
            "description" => "Agile development with a board, sprints and stories. Connects with source and build tools.",
            "enabled"     => 1
        ],
        [
            "name"        => "Kanban Project",
            "key"         => "KAN",
            "type"        => "Kanban Software Development",
            "description" => "Kanban project.",
            "enabled"     => 1
        ],
        [
            "name"        => "PROJECT",
            "key"         => "PRO",
            "type"        => "Project Management",
            "description" => "This is a project management project.",
            "enabled"     => 1
        ]
    ];


    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->_projects as $project) {
            $project["created_by"]  = 1;
            $project["creation_date"] = date("Y-m-d H:i:s");
            $project["type"]       = LaravelIssueTracker\ListOfValues\Models\ListOfValues::where('lov_key', $project['type'])->first()->id;

            DB::table('projects')->insert($project);
        }
    }
}