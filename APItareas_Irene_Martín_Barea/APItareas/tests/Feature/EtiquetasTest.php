<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Etiqueta;

class EtiquetasTest extends TestCase
{
    use RefreshDatabase; // Usar esta trait para resetear la base de datos después de cada test

    public function test_listadoEtiquetas(): void
    {
        //Creación de usuario y token para iniciar sesión y poder acceder al endpoint
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Enviar una solicitud JSON con el token de acceso para acceder a las etiquetas
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->json('GET', '/api/etiquetas');

        //validar la respuesta con código 200 de éxito
        $response->assertStatus(200)
        //validar que todas las etiquetas sigan la siguiente estructura
        ->assertJsonStructure([
            'data' => [
                '*' => [ // * se espera un conjunto de elementos
                    'id',
                    'nombre'
                ],
            ],
        ]);
    }

    public function test_mostrarEtiqueta(){
        //Creación de usuario y token para iniciar sesión y poder acceder al endpoint
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        //Crear una etiqueta de simulación en la base de datos
        $etiqueta = new Etiqueta();
        $etiqueta->nombre = "etiqueta";
        $etiqueta->save();

        // Enviar una solicitud JSON con el token de acceso para acceder a la etiqueta simulada (con id)
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->json('GET', '/api/etiquetas/' . $etiqueta->id);

        //validar la respuesta con código 200 de éxito
        $response->assertStatus(200)
        //validar que la etiqueta siga la siguiente estructura
        ->assertJsonStructure([
            'data' => [
                'id',
                'nombre',
            ],
        ]);
    }

    public function test_borrarEtiqueta(){
        //Creación de usuario y token para iniciar sesión y poder acceder al endpoint
        $user = User::factory()->create();
        $token = $user->createToken('auth_token')->plainTextToken;

        //Crear una etiqueta de simulación en la base de datos
        $etiqueta = new Etiqueta();
        $etiqueta->nombre = "etiqueta";
        $etiqueta->save();

        // Enviar una solicitud JSON con el token de acceso para borrar la etiqueta simulada (con id)
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->json('DELETE', '/api/etiquetas/' . $etiqueta->id);

        //validar la respuesta con código 200 de éxito y el mensaje success
        $response->assertStatus(200) 
        ->assertJsonStructure([
            'success'
        ]);
    }
}
