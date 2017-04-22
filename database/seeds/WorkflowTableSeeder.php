<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use LaravelIssueTracker\Workflow\Models\Workflow;

class WorkflowTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Workflow::create([
            "name" => "Laravel Default Workflow",
            "description" => "default workflow",
            "descriptor" => Storage::disk('local')->get('./tmp/sample.json')
        ]);
    }
}
