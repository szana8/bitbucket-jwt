<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubInventoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subinventories', function (Blueprint $table) {
            //$table->engine = 'InnoDB';

            $table->increments('id');
            $table->integer('inventory_type')->index();
            $table->string('description', 150);

            // Custom fields
            $table->string('attribute1', 240)->nullable();
            $table->string('attribute2', 240)->nullable();
            $table->string('attribute3', 240)->nullable();
            $table->string('attribute4', 240)->nullable();
            $table->string('attribute5', 240)->nullable();
            $table->string('attribute6', 240)->nullable();
            $table->string('attribute7', 240)->nullable();
            $table->string('attribute8', 240)->nullable();
            $table->string('attribute9', 240)->nullable();
            $table->string('attribute10', 240)->nullable();
            $table->string('attribute11', 240)->nullable();
            $table->string('attribute12', 240)->nullable();
            $table->string('attribute13', 240)->nullable();
            $table->string('attribute14', 240)->nullable();
            $table->string('attribute15', 240)->nullable();
            // End Custom Fields

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('subinventories', function($table) {
            $table->integer('organization_id')->after('id')->unsigned();
            $table->foreign('organization_id')->references('id')->on('inventory_organization')->onDelete('cascade');

            $table->integer('location_id')->after('id')->unsigned();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subinventories', function($table) {
            $table->dropForeign('subinventories_location_id_foreign');
            $table->dropForeign('subinventories_organization_id_foreign');
        });

        Schema::dropIfExists('subinventories');
    }
}
