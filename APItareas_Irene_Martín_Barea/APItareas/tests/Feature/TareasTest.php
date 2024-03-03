<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Tarea;

class TareasTest extends TestCase
{
    use RefreshDatabase; // Usar esta trait para resetear la base de datos después de cada test

    public function test_listadoTareas(): void
    {
        //Creación de usuario y token para iniciar sesión y poder acceder al endpoint
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Enviar una solicitud JSON con el token de acceso para acceder a las tareas
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->json('GET', '/api/tareas');

        //validar la respuesta con código 200 de éxito
        $response->assertStatus(200)
        //validar que todas las tareas sigan la siguiente estructura
        ->assertJsonStructure([
            'data' => [
                '*' => [ // * se espera un conjunto de elementos
                    'id',
                    'Titulo',
                    'descripcion',
                    'etiquetas'
                ],
            ],
        ]);
    }

    public function test_mostrarTarea(){
        //Creación de usuario y token para iniciar sesión y poder acceder al endpoint
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        //Crear una tarea de simulación en la base de datos
        $tarea = new Tarea();
        $tarea->titulo = "titulo";
        $tarea->descripcion = "Descripcion";
        $tarea->save();

        // Enviar una solicitud JSON con el token de acceso para acceder a la tarea simulada (con id)
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->json('GET', '/api/tareas/' . $tarea->id);

        //validar la respuesta con código 200 de éxito
        $response->assertStatus(200)
        //validar que la tarea siga la siguiente estructura
        ->assertJsonStructure([
            'data' => [
                'id',
                'Titulo',
                'descripcion',
                'etiquetas'
            ],
        ]);
    }

    public function test_borrarTarea(){
        //Creación de usuario y token para iniciar sesión y poder acceder al endpoint
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        //Crear una tarea de simulación en la base de datos
        $tarea = new Tarea();
        $tarea->titulo = "titulo";
        $tarea->descripcion = "Descripcion";
        $tarea->save();

        // Enviar una solicitud JSON con el token de acceso para borrar la tarea simulada (con id)
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->json('DELETE', '/api/tareas/' . $tarea->id);

        //validar la respuesta con código 200 de éxito y el mensaje success
        $response->assertStatus(200) 
        ->assertJsonStructure([
            'success'
        ]);
    }
}
