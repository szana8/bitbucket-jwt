<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('location_code', 50)->unique()->index();
            $table->string('description', 150);
            $table->string('address_line_1', 240);
            $table->string('address_line_2', 240)->nullable();
            $table->string('address_line_3', 240)->nullable();
            $table->string('town_or_city', 30);
            $table->string('country', 60);
            $table->string('postal_code', 30);
            $table->string('region', 120)->nullable();
            $table->string('region_2', 120)->nullable();
            $table->string('region_3', 120)->nullable();
            $table->string('phone_number', 60)->nullable();
            $table->string('phone_number_2', 60)->nullable();
            $table->string('phone_number_3', 60)->nullable();
            $table->boolean('ship_to_site_flag');
            $table->boolean('bill_to_site_flag');
            $table->boolean('office_site_flag');

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

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locations');
    }
}
