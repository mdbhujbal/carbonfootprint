<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCarbonFootprintsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carbon_footprints', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
			$table->string('activity');
			$table->enum('activity_type', array('miles','fuel'));
			$table->string('fuel_type')->default('');
			$table->string('mode')->default('');
			$table->string('country');
			$table->string('carbon_footprint');
			$table->enum('is_active', array('0','1'))->default('1');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carbon_footprints');
    }
}
