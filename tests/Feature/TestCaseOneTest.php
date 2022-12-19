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

        $response = $this->post('/user/login',['email'=>'mithatcan@gmail.com','password'=>'deneme123']);
        
        $response->assertStatus(200)->assertJsonFragment([
            'code'=>200,
            'message'=>'User logged in successfully.'
        ]);
        
        $data = $response->getData();
        $token = $data->data->user_token;

        $barcodeCheck = $this->post('/product/check',['barcode'=>'8547565663']);

        $barcodeCheck->assertStatus(200)->assertJsonFragment([
            'code' => 200,
            'message'=>'Product with the given barcode was found successfully.'
        ]);

        $stockrequest = $this->post('/stock/add', ['token' => $token, 'barcode' => '8547565663', 'quantity' => 13]);
        $stockrequest->assertStatus(200)->assertJsonFragment([
            'code' => 200,
            'message'=>'Stock added successfully.'
        ]);

        

    }
}
