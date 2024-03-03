<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class TareaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tareas')->insert([
            'titulo'=>'DWES',
            'descripcion' => 'Estudiar php y laravel.'
        ]);
        DB::table('tareas')->insert([
            'titulo'=>'Peliculas',
            'descripcion' => 'Hacer maraton de peliculas con los amigos.'
        ]);
        DB::table('tareas')->insert([
            'titulo'=>'Cena',
            'descripcion' => 'Preparar pizza para cenar.'
        ]);

    }
}
