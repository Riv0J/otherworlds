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
        Schema::create('classifications', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::create('classifications_translations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('classification_id');
            $table->string('locale');

            //translatable attributes
            $table->string('name');
            $table->string('description');
            $table->string('keyword');

            $table->foreign('classification_id')->references('id')->on('classifications')->onDelete('cascade');
            $table->unique(['classification_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('classifications');
    }
};
