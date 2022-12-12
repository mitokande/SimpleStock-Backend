<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StockController extends Controller
{
    //
    public function Add(Request $request){
        $product = Product::query()->where('product_barcode', '=', $request->barcode)->first();
        if($product != null){
            $response = Http::post('http://127.0.0.1:8001/user/token', ['token' => $request->token]);
            $store = Store::query()->where('store_owner_id', '=', json_decode($response->body())->data->id)->first();
            $stock = new Stock();
            $stock->store_id = $store->id;
            $stock->product_id = $product->id;
            $stock->quantity = $request->quantity;
            $stock->save();

            return response()->json([
                'code' => 200,
                'data' => $stock,
                'message' => "Stock added successfully"
            ]);
        }
        return response()->json([
            'code' => 404,
            'data' => null,
            'message' => "Stock could not be added successfully, wrong barcode"
        ]);
    }
}