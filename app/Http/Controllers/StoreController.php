<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class StoreController extends Controller
{
    //
    public function RegisterStore(Request $request)
    {
        $tokenresponse = Http::post(URL::to('/').'user/token', ['token' => $request->token]);
        if(json_decode($tokenresponse->body())->code == 200){
            $store = new Store();
            $store->store_name = $request->store_name;
            $store->store_category = $request->store_category;
            $store->store_image_url = $request->store_image_url;
            $store->store_owner_id = json_decode($tokenresponse->body())->data->id;
            $store->save();
            return response()->json([
                'code' => 200,
                'data' => $store,
                'message' => "Store registered successfully"
            ]);
        }
        return response()->json([
            'code' => 401,
            'data' => null,
            'message' => json_decode($tokenresponse->body())->message
        ]);
    }
}
