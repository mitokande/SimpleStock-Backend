<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    //
    public function AddProduct(Request $request){
        $response = Http::post('http://127.0.0.1:8001/user/token', ['token' => $request->token]);
        if(json_decode($response->body())->code == 200){
            $product = new Product();
            $product->product_name = $request->product_name;
            $product->product_barcode = $request->product_barcode;
            $product->product_category_id = $request->category_id;
            $product->product_price = $request->price;
            $product->product_image_url = $request->image;
            $product->save();
            return response()->json([
                'code' => 200,
                'data' => $product,
                'message' => "Product added successfully"
            ]);
        }
        return response()->json([
            'code' => 401,
            'data' => null,
            'message' => json_decode($response->body())->message
        ]);
    }
}