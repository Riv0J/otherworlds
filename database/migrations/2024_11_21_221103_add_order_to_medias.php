<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration 
{
    public function up() {
        Schema::table('medias', function (Blueprint $table) {
            $table->unsignedInteger('order')->nullable();
        });

        $registros = DB::table('medias')->orderBy('id', 'asc')->get();

        // Enumerar y actualizar cada registro
        $contador = 1;
        foreach ($registros as $registro) {
            DB::table('medias')
                ->where('id', $registro->id)
                ->update(['order' => $contador]);
            $contador++;
        }
    }

    public function down() {
        Schema::table('medias', function (Blueprint $table) {
            $table->dropColumn('order');
        });
    }
};