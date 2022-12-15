<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TestCaseOneTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $register = $this->post('/user/register',[
            'name' => 'mithat',
            'email'=>'mithatcan1@gmail.com',
            'password'=>'deneme123',
            'user_type' => 1
        ]);
        $register->assertStatus(200)->assertJsonFragment(['code' => 200]);

        $response = $this->post('/user/login',['email'=>'mithatcan1@gmail.com','password'=>'deneme123']);
        
        $response->assertStatus(200)->assertJsonFragment(['code'=>200]);
        
        $data = $response->getData();
        $token = $data->data->user_token;

        $barcodeCheck = $this->post('/product/check',['barcode'=>'8547565663']);

        $barcodeCheck->assertStatus(200)->assertJsonFragment(['code' => 200]);

        $stockrequest = $this->post('/stock/add', ['token' => $token, 'barcode' => '8547565663', 'quantity' => 13]);
        $stockrequest->assertStatus(200)->assertJsonFragment(['code' => 200]);

        

    }
}
