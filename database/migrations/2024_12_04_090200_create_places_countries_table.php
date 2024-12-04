<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('places_countries', function (Blueprint $table) {
            $table->id();
            $table->integer('order');

            //foreign country_id
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            //foreign place_id
            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
            
            //unique combination of ids
            $table->unique(['place_id', 'country_id']);
        });

        foreach(\App\Models\Place::all() as $place){
            $country = $place->country;
            $place->countries()->attach($country->id, ['order' => 1]); // Si deseas asignar un orden
        }

    }

    public function down()
    {
        Schema::dropIfExists('places_countries');
    }
};
