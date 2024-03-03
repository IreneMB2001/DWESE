<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthTest extends TestCase
{
    use RefreshDatabase; // Usar esta trait para resetear la base de datos después de cada test

    public function testRegister()
    {
        // Crear un usuario de ejemplo en la base de datos para registrarse
        $usuarioTest = [
            'name' => 'Test',
            'email' => 'Test@test.com',
            'password' => Hash::make('secret'),
        ];

        // Enviar una solicitud POST JSON a la ruta '/api/register' con los datos de registro
        $response = $this->postJson('/api/register', $usuarioTest);

        // Asegurarse de que la respuesta tenga un código de estado 200 (éxito)
        $response->assertStatus(200)
        //Asegurarse de que la estructura del Json es la siguiente
            ->assertJsonStructure([
                'data',
                'access_token',
                'token_type',
            ]);
    }

    public function testLogin()
    {
        // Crear un usuario de ejemplo en la base de datos para iniciar sesión
        $user = User::factory()->create([
            'email' => 'Test@test.com',
            'password' => Hash::make('secret'),
        ]);

        // Datos de inicio de sesión para el usuario para ser enviados
        $usuarioTest = [
            'email' => $user->email,
            'password' => 'secret',
        ];

        // Enviar una solicitud POST JSON a la ruta '/api/login' con los datos de inicio de sesión
        $response = $this->postJson('/api/login', $usuarioTest);

        // Asegurarse de que la respuesta tenga un código de estado 200 (éxito)
        $response->assertStatus(200)
        // Asegurarse de que la respuesta contenga ciertos elementos en formato JSON
            ->assertJson([
                'message' => 'Hola ' . $user->name,
                'token_type' => 'Bearer',
            ]);
    }

    public function testLogout()
    {
        // Crear un usuario de ejemplo en la base de datos
        $user = User::factory()->create();
        // Crear un token de acceso para el usuario
        $token = $user->createToken('auth_token')->plainTextToken;

        // Enviar una solicitud JSON con el token de acceso para cerrar la sesión
        $response = $this->withHeaders(['Authorization' => 'Bearer ' . $token])
            ->json('GET', '/api/logout');

        // Asegurarse de que la respuesta tenga un código de estado 200 (éxito)
        $response->assertStatus(200)
            ->assertJson(['message' => 'Sesión cerrada correctamente']);
    }
}
