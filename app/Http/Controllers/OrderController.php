<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Store;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class OrderController extends Controller
{
    public function Add(Request $request){
        $product = Product::query()->where('product_barcode', '=', $request->barcode)->first();
        if($product != null){
            $response = Http::post(URL::to('/').'user/token', ['token' => $request->token]);
            $store = Store::query()->where('store_owner_id', '=', json_decode($response->body())->data->id)->first();
            $order = new Order();
            $order->store_id = $store->id;
            $order->product_id = $product->id;
            $order->quantity = $request->quantity;
            $order->save();

            return response()->json([
                'code' => 200,
                'data' => $order,
                'message' => "Order added successfully."
            ]);
        }
        return response()->json([
            'code' => 404,
            'data' => null,
            'message' => "Order could not be added successfully, wrong barcode."
        ]);
    }
}
