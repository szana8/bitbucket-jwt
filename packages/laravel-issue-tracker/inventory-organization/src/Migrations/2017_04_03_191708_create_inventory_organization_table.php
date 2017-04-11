<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventoryOrganizationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_organizations', function (Blueprint $table) {
            //$table->engine = 'InnoDB';

            $table->increments('id');
            $table->string('organization_code', 10)->unique()->index();
            $table->string('organization_name', 80)->unique();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::table('inventory_organizations', function($table) {
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
        Schema::table('inventory_organizations', function($table) {
            $table->dropForeign('inventory_organizations_location_id_foreign');
        });

        Schema::dropIfExists('inventory_organizations');
    }
}
