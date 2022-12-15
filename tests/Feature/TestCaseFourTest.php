<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class TestCaseFourTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_four_case()
    {
        $register = $this->post('/user/register',[
            'name' => 'mithat',
            'email'=>'mithatcan@gmail.com',
            'password'=>'deneme123',
            'user_type' => 1
        ]);
        $register->assertStatus(200)->assertJsonFragment(['code' => 200]);

        $response = $this->post('/user/login',['email'=>'mithatcan@gmail.com','password'=>'deneme123']);
        
        $response->assertStatus(200)->assertJsonFragment(['code'=>200]);
        
        $data = $response->getData();
        $token = $data->data->user_token;

        $response = $this->post('/store/register',[
            'store_name' => 'Ali Tekel',
            'store_category' => 'Tekel',
            'store_image_url' => 'https://image.com/123',
            'token' => $token,
        ]);

        $response->assertStatus(200)->assertJsonFragment(['code'=>200]);

        
        $response = $this->post('/product/add',[
            
            'product_name' => 'Beypazarı Maden Suyu',
            'product_barcode' => '8547565663',
            'category_id' => 2,
            'price' => '2.50',
            'image' => 'https://image.com/123',
            'token' => $token,
        ]);

        $response->assertStatus(200)->assertJsonFragment(['code'=>200]);
    }
}
