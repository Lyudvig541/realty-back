<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnouncementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('broker_id')->nullable();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('type_id');
            $table->string('property_name')->nullable();
            $table->integer('price')->nullable();
            $table->string('address');
            $table->boolean('verify')->default(false);
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('state_id')->nullable();
            $table->string('city_id')->nullable();
            $table->string('land_geometric_appearance')->nullable();
            $table->string('purpose')->nullable();
            $table->string('front_position')->nullable();
            $table->string('front_position_length')->nullable();
            $table->string('infrastructure')->nullable();
            $table->string('balcony')->nullable();
            $table->string('fence_type')->nullable();
            $table->string('building')->nullable();
            $table->string('road_type')->nullable();
            $table->integer('floor')->nullable();
            $table->integer('storeys')->nullable();
            $table->string('area')->nullable();
            $table->string('land_area')->nullable();
            $table->integer('rooms')->nullable();
            $table->integer('bathroom')->nullable();
            $table->string('building_type')->nullable();
            $table->string('latitude');
            $table->string('longitude');
            $table->string('ceiling_height')->nullable();
            $table->string('certificate')->nullable();
            $table->string('degree')->nullable();
            $table->string('condition')->nullable();
            $table->text('description')->nullable();
            $table->json('facilities')->nullable();
            $table->json('additional_infos')->nullable();
            $table->string('main_image')->nullable();
            $table->string('agree_terms')->nullable();
            $table->string('building_number')->nullable();
            $table->string('year')->nullable();
            $table->string('cover')->nullable();
            $table->string('rent_price')->nullable();
            $table->string('rent_type')->nullable();
            $table->enum('accepted', [1, 0])->default(0);
            $table->enum('free', [1, 0, 2])->default(0);
            $table->string('sewer')->nullable();
            $table->string('distance_from_metro_station')->nullable();
            $table->string('distance_from_medical_center')->nullable();
            $table->string('distance_from_stations')->nullable();
            $table->string('furniture')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->string('land_type')->nullable();
            $table->string('property_place')->nullable();
            $table->string('zestimate')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('condominium')->nullable();
            $table->text('reason')->nullable();
            $table->string('average_value')->nullable();
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
        Schema::dropIfExists('announcements');
    }
}
