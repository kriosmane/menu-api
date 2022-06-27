<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Tests\TestCase;

class ItemTest extends TestCase
{
    /**
     * Authenticate user.
     *
     * @return void
     */
    protected function authenticate()
    {
        $user = User::create([
            'name' => 'test',
            'email' => rand(12345, 678910).'test@gmail.com',
            'password' => bcrypt('secret1234'),
        ]);

        if (! auth()->attempt(['email' => $user->email, 'password' => 'secret1234'])) {
            return response(['message' => 'Login credentials are invaild']);
        }

        return $accessToken = auth()->user()->createToken('authToken')->accessToken;
    }

    /**
     * test create item.
     *
     * @return void
     */
    public function test_create_item()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', 'api/item', [
            'name' => 'Test Pizza',
            'description' => 'Pizza Description',
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test update item.
     *
     * @return void
     */
    public function test_update_item()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('PUT', 'api/item/4', [
            'name' => 'Name updated',
            'description' => 'description updated',
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test find item.
     *
     * @return void
     */
    public function test_find_item()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', 'api/item/4');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test get all items.
     *
     * @return void
     */
    public function test_get_all_items()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('GET', 'api/item');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test delete products.
     *
     * @return void
     */
    public function test_delete_item()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('DELETE', 'api/item/4');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test update item.
     *
     * @return void
     */
    public function test_add_property()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('POST', 'api/item/5/property', [
            'name' => 'Vegan',
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }

    /**
     * test update item.
     *
     * @return void
     */
    public function test_delete_property()
    {
        $token = $this->authenticate();

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$token,
        ])->json('DELETE', 'api/item/5/property/1');

        //Write the response in laravel.log
        \Log::info(1, [$response->getContent()]);

        $response->assertStatus(200);
    }
}
