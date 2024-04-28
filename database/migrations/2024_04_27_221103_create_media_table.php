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
        Schema::create('medias', function (Blueprint $table) {
            $table->id();

            $table->string('url');

            //foreign place_id
            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');

            //foreign place_id
            $table->unsignedBigInteger('prefix_id');
            $table->foreign('prefix_id')->references('id')->on('prefixes')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('medias_translations', function (Blueprint $table) {
            $table->id();
            $table->string('locale');
            $table->string('description');

            //foreign media_id
            $table->unsignedBigInteger('media_id');
            $table->foreign('media_id')->references('id')->on('medias')->onDelete('cascade');

            //foreign prefix_id
            $table->unsignedBigInteger('prefix_id')->nullable();
            $table->foreign('prefix_id')->references('id')->on('prefixes')->onDelete('cascade');

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
        Schema::dropIfExists('medias');
    }
};
