<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegister()
    {
        $time = time();

        $response = $this->json('POST', '/api/register', [
            'name'  =>  $name = 'Test',
            'email'  =>  $email = $time.'test@example.com',
            'password'  =>  $password = '123456789',
        ]);

        //Write the response in laravel.log
        \Log::info($response->getContent());

        $response->assertStatus(200);

        // Receive our token
        $this->assertArrayHasKey('access_token', $response->json());

        // Delete users
        \App\Models\User::where('email', $time.'test@example.com')->delete();
    }

    public function testLogin()
    {
        $time = time();

        // Creating User
        \App\Models\User::create([
            'name' => 'Test',
            'email' => $email = $time.'@example.com',
            'password' => $password = bcrypt('123456789'),
        ]);

        // Simulated landing
        $response = $this->json('POST', '/api/login', [
            'email' => $email,
            'password' => '123456789',
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        // Determine whether the login is successful and receive token
        $response->assertStatus(200);

        //$this->assertArrayHasKey('token',$response->json());

        // Delete users
        \App\Models\User::where('email', $time.'@gmail.com')->delete();
    }
}
