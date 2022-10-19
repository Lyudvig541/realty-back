<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstructorTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('constructor_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale')->index();
            $table->string('property_name');
            $table->text('property_description')->nullable();
            $table->string('sub_title')->nullable();
            $table->string('address');
            $table->text('features')->nullable();
            $table->text('renovation')->nullable();
            $table->json('plans')->nullable();
            $table->json('floors')->nullable();
            $table->integer('floors_id')->nullable();
            $table->integer('plans_id')->nullable();
            $table->unsignedBigInteger('constructor_id');
            $table->unique(['constructor_id','locale']);
            $table->foreign('constructor_id')->references('id')->on('constructors')->onDelete('cascade');
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
        Schema::dropIfExists('constructor_translations');
    }
}
