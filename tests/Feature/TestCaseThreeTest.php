<?php

namespace Tests\Feature;

use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestCaseThreeTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->post('/user/login',['email'=>'mithatcan@gmail.com','password'=>'deneme123']);
        
        $response->assertStatus(200)->assertJsonFragment([
            'code'=>200,
            'message'=>'User logged in successfully.'
        ]);
        
        $data = $response->getData();
        $token = $data->data->user_token;
        $store = Store::query()->where('store_owner_id', '=', $data->data->id)->first();
        $response = $this->get('/store');
        $response->assertStatus(200);

        $response = $this->get('/store/'.$store->id);
        $response->assertStatus(200);

        $response = $this->get('/product/8547565663');
        $response->assertStatus(200);

        $stockrequest = $this->post('/product/buy', ['token' => $token, 'barcode' => '8547565663', 'quantity' => 13]);
        $stockrequest->assertStatus(200)->assertJsonFragment([
            'code' => 200,
            'message'=>'Product bought successfully.'
        ]);
    }
}
