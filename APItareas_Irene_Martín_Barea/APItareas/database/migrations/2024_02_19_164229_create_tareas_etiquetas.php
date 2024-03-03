<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tareas_etiquetas', function (Blueprint $table) {
            $table->id();
            //Dejarlo preparado para hacer el enganche (la barra baja separa la tabla y la columna)
            //por ejemplo: la tabla tareas tiene una columna id que es una clave foránea
            $table->foreignId("tareas_id")->constrained()->onDelete('cascade'); //clave foranea
            $table->foreignId("etiquetas_id")->constrained()->onDelete('cascade'); //clave foranea
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tareas_etiquetas');
    }
};
