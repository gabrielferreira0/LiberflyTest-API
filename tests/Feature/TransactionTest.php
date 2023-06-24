<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function testGetTransactions(): void
    {
        $email = env('API_USER_EMAIL');
        $password = env('API_USER_PASSWORD');


        $authUser = $this->json('POST', 'api/auth/login', [
            'email' => $email,
            'password' => $password
        ]);

        $data = $authUser->json();
        $token = 'bearer ' . $data['access_token'];


        $response = $this->withHeaders([
            'Authorization' => $token,
        ])->get('/api/transactions');


        $response->assertStatus(200);
    }

    public function testGetTransaction(): void
    {
        $email = env('API_USER_EMAIL');
        $password = env('API_USER_PASSWORD');

        $authUser = $this->json('POST', 'api/auth/login', [
            'email' => $email,
            'password' => $password
        ]);

        $data = $authUser->json();
        $token = 'bearer ' . $data['access_token'];

        $response = $this->withHeaders([
            'Authorization' => $token,
        ])->get('/api/transactions/1');


        $response->assertStatus(200);
    }

}
