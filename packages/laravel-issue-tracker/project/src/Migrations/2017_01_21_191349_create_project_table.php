<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('name', 100)->unique();
            $table->string('url', 150);
            $table->integer('lead_id')->unsigned();
            $table->foreign('lead_id')->references('id')->on('users')->onDelete('cascade');
            $table->text('description')->nullable();
            $table->string('key', 5)->unique();
            $table->integer('type')->nullable()->index();
            $table->integer('avatar_id')->unsigned();
            $table->foreign('avatar_id')->references('id')->on('avatars')->onDelete('cascade');
            $table->enum('enabled', array('Y', 'N'))->default('Y');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function($table) {
            $table->dropForeign('projects_lead_id_foreign');
            $table->dropForeign('projects_avatar_id_foreign');
        });

        Schema::dropIfExists('projects');
    }
}
