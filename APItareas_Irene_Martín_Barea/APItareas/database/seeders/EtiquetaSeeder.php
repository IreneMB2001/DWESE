<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class EtiquetaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('etiquetas')->insert([
            'nombre'=>'Estudio'
        ]);
        DB::table('etiquetas')->insert([
            'nombre'=>'Ocio'
        ]);
        DB::table('etiquetas')->insert([
            'nombre'=>'Hogar'
        ]);
        DB::table('etiquetas')->insert([
            'nombre'=>'Otros'
        ]);
    }
}
