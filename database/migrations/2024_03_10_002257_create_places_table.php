<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->integer('views_count')->default(0);
            $table->integer('favorites_count')->default(0);
            $table->boolean('natural')->default(true);
            $table->string('source')->nullable();

            //foreign country_id
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            //foreign classification_id
            $table->unsignedBigInteger('classification_id');
            $table->foreign('classification_id')->references('id')->on('classifications')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('places_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('place_id');
            $table->string('locale');

            //translatable attributes
            $table->string('name');
            $table->text('synopsis');
            $table->string('description');

            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            $table->unique(['place_id', 'locale']);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
        Schema::dropIfExists('places_translations');
    }
};
