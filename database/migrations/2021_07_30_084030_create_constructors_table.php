<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constructors', function (Blueprint $table) {
            $table->id();
            $table->string('price_start');
            $table->string('price_end')->nullable();
            $table->string('start_date');
            $table->string('end_date');
            $table->string('property_type');
            $table->integer('available_apartments')->nullable();
            $table->integer('apartment_counts')->nullable();
            $table->integer('sold_apartments')->nullable();
            $table->integer('reserved_apartments')->nullable();
            $table->integer('available_parking')->nullable();
            $table->integer('underground_parking')->nullable();
            $table->integer('available_underground_parking')->nullable();
            $table->integer('office_space')->nullable();
            $table->integer('available_office_space')->nullable();
            $table->integer('min_room')->nullable();
            $table->integer('max_room')->nullable();
            $table->string('lot')->nullable();
            $table->integer('storeys')->nullable();
            $table->string('area')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('type')->nullable();
            $table->string('floor_height')->nullable();
            $table->string('main_image')->nullable();
            $table->integer('parking')->nullable();
            $table->unsignedBigInteger('currency_id');
            $table->unsignedBigInteger('const_agency_id');
            $table->string('state_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('live_video_url')->nullable();
            $table->string('distance_from_school');
            $table->string('distance_from_kindergarten');
            $table->string('distance_from_supermarket');
            $table->string('distance_from_pharmacy');
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
        Schema::dropIfExists('constructors');
    }

}

