<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->string('public_slug')->unique();
            $table->integer('views_count')->default(0);
            $table->integer('favorites_count')->default(0);
            $table->boolean('natural')->default(true);
            $table->double('latitude', 10, 6)->default(0);
            $table->double('longitude', 10, 6)->default(0);

            //wikimedia link with images to this place
            $table->string('gallery_url')->nullable();

            //foreign country_id
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');

            //foreign category_id
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');

            $table->string('thumbnail')->default('t.png');
            $table->timestamps();
        });

        Schema::create('places_translations', function (Blueprint $table) {
            $table->id();

            $table->string('locale');

            //translatable attributes
            $table->string('name');
            $table->text('synopsis');
            $table->string('slug');

            //foreign place_id
            $table->unsignedBigInteger('place_id');
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');

            //unique constraints
            $table->unique(['place_id', 'locale']);
            $table->unique(['locale', 'slug']);
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
